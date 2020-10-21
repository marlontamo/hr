<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Requisition_manage extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('requisition_manage_model', 'mod');
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
			case 2:
				echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
				break;
			case 4:
				echo $this->load->blade('pages.reapprove')->with( $this->load->get_cached_vars() );
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
		$this->response = $this->mod->_save( true, false );
		$this->record_id = $this->response->record_id;
		
		if( $this->response->saved )
        {
        	if( isset($_POST['requisition_items']) )
        	{
        		$this->db->delete('requisition_items', array('requisition_id' => $this->record_id));
				$items = $_POST['requisition_items'];
				$insert = array();
				foreach( $items as $group => $values )
				{
					foreach($values as $index => $value)
					{
						$insert[$index]['requisition_id'] = $this->record_id;
						if($group == 'quantity' || $group == 'unit_price' || $group == 'actual_price')
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

        	$this->load->model('system_feed');
        	$request = $_POST['requisition'];
        	if( $request['status'] > 2 )
        	{
        		$remarks = $_POST['requisition_remarks'];
        		$this->db->delete('requisition_remarks', array('requisition_id' => $this->record_id));
        		foreach( $remarks as $user_id => $remark )
        		{
        			if( $remark != "" )
        			{
	        			$insert = array(
	        				'requisition_id' => $this->record_id,
	        				'user_id' => $user_id,
	        				'remarks' => $remark
	        			);

	        			$where = array(
	        				'requisition_id' => $this->record_id,
	        				'user_id' => $user_id
	        			);

	        			$this->db->limit(1);
	        			$check = $this->db->get_where('requisition_remarks', $where);
	        			if($check->num_rows() == 1)
	        				$this->db->update('requisition_remarks', $insert, $where);
	        			else
	        				$this->db->insert('requisition_remarks', $insert);
        			}
        			else{
        				$this->response->message[] = array(
							'message' => 'Please add your remark.',
							'type' => 'error'
						);
						$error = true;
						goto stop;	
        			}
        		}	
        	}

        	switch( $request['status'] )
        	{
        		case 3: //approve, send to purchasing department
        			//notify purchasing
        			break;
        		case 11: //reapprove, send to purchasing department
        			//notify purchasing
        			break;
        		case 6: // disapprove, notify requester
        			$feed = array(
	                    'status' => 'info',
	                    'message_type' => 'Comment',
	                    'user_id' => $this->user->user_id,
	                    'feed_content' => 'Your purchase requisition form has been disapproved.',
	                    'uri' => get_mod_route('requisition', '', false).'/view/'.$this->record_id,
	                    'recipient_id' => $request['approver']
	                );

	                $recipients = array($request['approver']);
	                $this->system_feed->add( $feed, $recipients );

	                $this->response->notify[] = $request['approver'];
        			break;
        		case 7: //ms approval
        			break;
        	}
        	$this->db->update('requisition', array('status_id' => $request['status']), array('requisition_id' => $this->record_id));
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
}