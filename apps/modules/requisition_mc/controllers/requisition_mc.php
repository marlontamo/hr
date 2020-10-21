<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Requisition_mc extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('requisition_mc_model', 'mod');
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

		switch( $this->record['approver.status_id'] )
		{
			case 0:
				echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
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
			switch( $record['requisition_status_id'] )
			{
				case 7:
					if( $record['mc_status_id'] == 0 || $record['mc_status_id'] == 7 )
						$rec['edit_url'] = $this->mod->url . '/approve/' . $record['record_id'];
					break;		
			}
			
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
		
		if( isset( $_POST['requisition_remarks'] ) )
    	{
    		$remarks = $_POST['requisition_remarks'];
    		foreach( $remarks as $user_id => $remark )
    		{
    			if( $remark != "" )
    			{
        			$insert = array(
        				'requisition_id' => $this->record_id,
        				'user_id' => $user_id,
        				'remarks' => $remark,
        				'date' => date('Y-m-d')
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

    	$request = $_POST['requisition'];
    	switch( $request['status'] )
    	{
    		case 3: //approve
    			break;
    		case 6: // disapprove
    			break;
    		default: //save as draft
    			break;
    	}
    	$this->db->update('requisition_mc_signatories', array('status_id' => $request['status']), array('requisition_id' => $this->record_id, 'user_id' => $user_id));
    	if( $this->db->_error_message() != "" )
		{
			$this->response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
			$error = true;
			goto stop;
		}

        //count signatories
		$mc_signatories = $this->requisition->get_mc_signatories( $this->record_id );
		$approve_ctr = 0;
		$disapprove_ctr = 0;
		if($mc_signatories)
		{
			foreach($mc_signatories as $mc)
			{
				switch($mc->status_id)
				{
					case 3:
						$approve_ctr++;
						break;
					case 6:
						$disapprove_ctr++;
						break;
				}
			}
		}

		if( $this->requisition_cfg['min_mc_signatory'] <= $approve_ctr )
		{
			$this->db->update('requisition', array('status_id' => 10), array('requisition_id' => $this->record_id));
			$this->load->model('system_feed');
			
			$requisition = $this->mod->_get( 'edit', $this->record_id )->row_array();
			//approved notify requester
			$feed = array(
                'status' => 'info',
                'message_type' => 'Comment',
                'user_id' => $this->user->user_id,
                'feed_content' => 'Your purchase requisition form has been approved.',
                'uri' => get_mod_route('requisition', '', false).'/view/'.$this->record_id,
                'recipient_id' => $requisition['requisition.created_by']
            );

            $recipients = array($requisition['requisition.created_by']);
            $this->system_feed->add( $feed, $recipients );

            $this->response->notify[] = $requisition['requisition.created_by'];

			//notify purchasing
		}

		if( $this->requisition_cfg['min_mc_signatory'] <= $disapprove_ctr )
		{
			$this->db->update('requisition', array('status_id' => 6), array('requisition_id' => $this->record_id));
			$this->load->model('system_feed');
			
			$requisition = $this->mod->_get( 'edit', $this->record_id )->row_array();
			//disapproved notify requester
			$feed = array(
                'status' => 'info',
                'message_type' => 'Comment',
                'user_id' => $this->user->user_id,
                'feed_content' => 'Your purchase requisition form has been disapproved.',
                'uri' => get_mod_route('requisition', '', false).'/view/'.$this->record_id,
                'recipient_id' => $requisition['requisition.created_by']
            );

            $recipients = array($requisition['requisition.created_by']);
            $this->system_feed->add( $feed, $recipients );

            $this->response->notify[] = $requisition['requisition.created_by'];
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