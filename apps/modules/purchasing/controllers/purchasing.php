<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Purchasing extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('purchasing_model', 'mod');
		$this->load->model('requisition_model', 'requisition');
		$requisition_cfg = $this->load->config('requisition', true, true);
		$this->requisition_cfg = $vars['requisition_cfg'] = $requisition_cfg['requisition'];
		$this->load->vars( $vars );
		parent::__construct();
	}

	function view( $record_id )
	{
		parent::edit('', true);
		$this->_after_parent_edit();

		switch( $this->record['requisition.status_id'] )
		{
			case 3:
			case 11:
				echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
				break;
			case 10:
				echo $this->load->blade('pages.for_po')->with( $this->load->get_cached_vars() );
				break;
			default:
				echo $this->load->blade('pages.view')->with( $this->load->get_cached_vars() );
		}
    }

	private function _after_parent_edit()
    {
    	//items
    	$vars['items'] = $this->db->get_where('requisition_items', array('requisition_id' => $this->record_id))->result();

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

    	$vars['mc_signatories'] = $this->requisition->get_mc_signatories( $this->record_id );

    	$this->load->vars( $vars );
    }

	function _list_options_active( $record, &$rec )
	{
		if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/view/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}	
		
		if( isset($this->permission['delete']) && $this->permission['delete'] )
		{
			$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
			$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
		}
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
		$this->_set_record_id();
		$this->response->record_id = $this->record_id;
		
		$request = $_POST['requisition'];
		$validation_rules = false;
    	switch( $request['status'] )
    	{
    		case 3: //saving draft
    			break;
    		case 4: //re-approval
    			//notify approver
    			$this->load->model('system_feed');
    			$record = $this->mod->_get( 'edit', $this->record_id )->row_array();
    			$feed = array(
                    'status' => 'info',
                    'message_type' => 'Comment',
                    'user_id' => $this->user->user_id,
                    'feed_content' => 'A purchase requisition form needs your re-approval.',
                    'uri' => get_mod_route('requisition_manage', '', false).'/view/'.$this->record_id,
                    'recipient_id' => $record['requisition.approver']
                );

                $recipients = array($record['requisition.approver']);
                $this->system_feed->add( $feed, $recipients );

                $this->response->notify[] = $record['requisition.approver'];	
    			break;
    		case 5: //items recieved
    			//notify accouting
    			$this->load->model('system_feed');

    			//add validatin for items
    			$validation_rules = array(
	    			array(
	    				'field'   => 'requisition_items[actual_price][]',
						'label'   => 'Actual Price',
						'rules'   => 'required'
	    			)
	    		);
    			break;
    		case 10: //for PO
    			//check for total price
				$total_price = str_replace(',', '', $request['total_price']);

				if( $total_price >= $this->requisition_cfg['mc_approval'] )
				{
					$this->load->model('system_feed');
					$request['status'] = 7;
					//send to MC for approval
					$approvers = "CALL sp_requisition_mc_populate_approvers({$this->record_id}, {$request['approver']})";
					$result_insert_update = $this->db->query( $approvers );
					mysqli_next_result($this->db->conn_id);

					//notify approvers
					$approvers = $this->db->get_where('requisition_mc_signatories', array('requisition_id' => $this->record_id));
					foreach($approvers->result() as $approver)
					{
						$feed = array(
				            'status' => 'info',
				            'message_type' => 'Comment',
				            'user_id' => $this->user->user_id,
				            'feed_content' => 'A purchase requisition form needs your attention.',
				            'uri' => get_mod_route('requisition_mc', '', false).'/view/'.$this->record_id,
				            'recipient_id' => $approver->user_id
				        );

				        $recipients = array($approver->user_id);
				        $this->system_feed->add( $feed, $recipients );

				        $this->response->notify[] = $approver->user_id;	
					}
				}
				break;
			case 12: //for validation
				//notify accounting

				//add validatin for items
    			$validation_rules = array(
	    			array(
	    				'field'   => 'requisition_items[po_price][]',
						'label'   => 'PO Price',
						'rules'   => 'required'
	    			),
	    			array(
	    				'field'   => 'requisition_items[po_number][]',
						'label'   => 'PO Number',
						'rules'   => 'required'
	    			),
	    			array(
	    				'field'   => 'requisition_items[po_quantity][]',
						'label'   => 'PO Quantity',
						'rules'   => 'required'
	    			)
	    		);
				break;
    		case 0: //save draft
    			$request['status'] = 10;
    			break;
    	}
    	
    	if(isset($request['total_price']))
    	{
    		$request['total_price'] = str_replace(',', '', $request['total_price']);
    		$this->db->update('requisition', array('total_price' => $request['total_price']), array('requisition_id' => $this->record_id));
    	}
    		
    	$this->db->update('requisition', array('status_id' => $request['status']), array('requisition_id' => $this->record_id));

		if( isset($_POST['requisition_items']) )
    	{
    		if( $validation_rules )
    		{
	    		$this->load->library('form_validation');
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
			}

			$this->db->delete('requisition_items', array('requisition_id' => $this->record_id));
			$items = $_POST['requisition_items'];
			$insert = array();
			foreach( $items as $group => $values )
			{
				foreach($values as $index => $value)
				{
					$insert[$index]['requisition_id'] = $this->record_id;
					if($group == 'quantity' || $group == 'unit_price' || $group == 'actual_price' || $group == 'po_price' || $group == 'po_quantity')
						$value = str_replace(',', '', $value);

					if($group == 'date')
						$value = date('Y-m-d', strtotime($value));

					if($group == 'amount' || $group == 'actual_amount' || $group == 'po_amount')
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
}