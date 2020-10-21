<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Requisition extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('requisition_model', 'mod');
		$requisition_cfg = $this->load->config('requisition', true, true);
		$vars['requisition_cfg'] = $requisition_cfg['requisition'];
		$this->load->vars( $vars );
		parent::__construct();
	}

	function add()
	{
		$this->load->vars(array('items' => array()));
		parent::add();
	}

	function edit( $record_id )
	{
		parent::edit('', true);
		$this->load->helper('form');
		$this->load->helper('file');
		$this->_after_parent_edit();
	    echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
	}

	function view( $record_id )
	{
		parent::edit('', true);
		$this->_after_parent_edit();

		switch( $this->record['requisition.status_id'] )
		{
			case 13:
				echo $this->load->blade('pages.confirm')->with( $this->load->get_cached_vars() );
				break;
			case 9:
				echo $this->load->blade('pages.closed')->with( $this->load->get_cached_vars() );
				break;
			case 4:
				echo $this->load->blade('pages.priced')->with( $this->load->get_cached_vars() );
				break;
			default:
				echo $this->load->blade('pages.view')->with( $this->load->get_cached_vars() );
		}
    }

    private function _after_parent_edit()
    {
    	//items
    	$items = $this->db->get_where('requisition_items', array('requisition_id' => $this->record_id));
    	if($items->num_rows() > 0)
    		$vars['items'] = $items->result();
    	else
    		$vars['items'] = array();

    	//approver remark
    	$where = array(
    		'requisition_id' => $this->record_id,
    		'user_id' => $this->record['requisition.approver_id'],
    	);
    	$this->db->limit(1);
    	$approver_remarks = $this->db->get_where('requisition_remarks', $where);
    	
    	if( $approver_remarks->num_rows() == 1 )
    		$vars['approver_remark'] = $approver_remarks->row();
    	else
    		$vars['approver_remark'] = false;

    	$vars['mc_signatories'] = $this->mod->get_mc_signatories( $this->record_id );

    	$this->load->vars( $vars );
    }

	public function save()
	{
		$this->_ajax_only();
		if( !$this->_set_record_id() )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'error'
			);
			$this->_ajax_return();	
		}
		
		if( (empty( $this->record_id ) && !$this->permission['add']) || ($this->record_id && !$this->permission['edit']) )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$this->db->trans_begin();
		$error = false;
		$this->response = $this->mod->_save( true, false );
		$this->record_id = $this->response->record_id;
		
		if( $this->response->saved )
        {
        	if( isset($_POST['requisition_items']) )
        	{
        		$validation_rules = array(
        			array(
        				'field'   => 'requisition_items[item][]',
						'label'   => 'Item',
						'rules'   => 'required'
        			),
        			array(
        				'field'   => 'requisition_items[reason][]',
						'label'   => 'Reason',
						'rules'   => 'required'
        			),
        			array(
        				'field'   => 'requisition_items[date][]',
						'label'   => 'Date',
						'rules'   => 'required'
        			),
        			array(
        				'field'   => 'requisition_items[quantity][]',
						'label'   => 'Quantity',
						'rules'   => 'required'
        			),
        			array(
        				'field'   => 'requisition_items[unit_price][]',
						'label'   => 'Unit Price',
						'rules'   => 'required'
        			)
        		);

        		$this->form_validation->set_rules( $validation_rules );
				if ($this->form_validation->run() == false)
				{
					foreach( $this->form_validation->get_error_array() as $f => $f_error )
					{
						$this->response->message[] = array(
							'message' => $f_error,
							'type' => 'warning'
						);	
					}
					
					$error = true;
					goto stop;
				}

				$this->db->delete('requisition_items', array('requisition_id' => $this->record_id));
				$items = $_POST['requisition_items'];
				$insert = array();
				foreach( $items as $group => $values )
				{
					foreach($values as $index => $value)
					{
						$insert[$index]['requisition_id'] = $this->record_id;
						if($group == 'quantity' || $group == 'unit_price')
							$value = str_replace(',', '', $value);

						if($group == 'date')
							$value = date('Y-m-d', strtotime($value));

						if($group == 'amount')
							continue;

						$insert[$index][$group] = $value;
					}
				}
				
				$this->db->insert_batch('requisition_items', $insert);
				if( $this->db->_error_message() != "" )
				{
					$this->response->message[] = array(
						'message' => $this->db->_error_message(),
						'type' => 'error'
					);
					$error = true;
					goto stop;
				}
        	}
        	else{
        		$this->response->message[] = array(
					'message' => 'There are no items, please add.',
					'type' => 'warning'
				);
				$error = true;
        	}

        	$request = $_POST['requisition'];
        	if( $request['status'] == 2 )
        	{
        		$this->db->update('requisition', array('status_id' => 2), array('requisition_id' => $this->record_id));
        		if( $this->db->_error_message() != "" )
				{
					$this->response->message[] = array(
						'message' => $this->db->_error_message(),
						'type' => 'error'
					);
					$error = true;
					goto stop;
				}
        		
        		//send to approver
        		$this->load->model('system_feed');
        		$feed = array(
                    'status' => 'info',
                    'message_type' => 'Comment',
                    'user_id' => $this->user->user_id,
                    'feed_content' => 'A purchase requisition form needs your approval.',
                    'uri' => get_mod_route('requisition_manage', '', false).'/view/'.$this->record_id,
                    'recipient_id' => $request['approver']
                );

                $recipients = array($request['approver']);
                $this->system_feed->add( $feed, $recipients );

                $this->response->notify[] = $request['approver'];
        	}
        }
        else{
        	$error = true;
        }

		stop:
		if( !$error ){
			$this->db->trans_commit();
			$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
		}
		else{
			$this->db->trans_rollback();
		}
		
		$this->response->saved = !$error;
		
		$this->_ajax_return();
	}

	public function confirm()
	{
		$this->_ajax_only();
		if( !$this->_set_record_id() )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'error'
			);
			$this->_ajax_return();	
		}
		
		if( (empty( $this->record_id ) && !$this->permission['add']) || ($this->record_id && !$this->permission['edit']) )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$this->db->trans_begin();
		$error = false;
		parent::edit('', true);
		
		$this->db->update('requisition', array('status_id' => 9), array('requisition_id' => $this->record_id));
		if( $this->db->_error_message() != "" )
		{
			$this->response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
			$error = true;
			goto stop;
		}

		stop:
		if( !$error ){
			$this->db->trans_commit();
			$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
		}
		else{
			$this->db->trans_rollback();
		}
		
		$this->response->saved = !$error;
		
		$this->_ajax_return();
	}

	function _list_options_active( $record, &$rec )
	{
		if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
		{
			if($record['requisition_status_id'] == 1)
				$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			else
				$rec['edit_url'] = $this->mod->url . '/view/' . $record['record_id'];

			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}	
		
		if( isset($this->permission['delete']) && $this->permission['delete'] )
		{
			$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
			$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
		}
	}
}