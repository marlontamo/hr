<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class mrf_manage_model extends Record
{
	var $mod_id;
	var $mod_code;
	var $route;
	var $url;
	var $primary_key;
	var $table;
	var $icon;
	var $short_name;
	var $long_name;
	var $description;
	var $path;

	public function __construct()
	{
		$this->mod_id = 128;
		$this->mod_code = 'mrf_manage';
		$this->route = 'recruitment/mrf_manage';
		$this->url = site_url('recruitment/mrf_manage');
		$this->primary_key = 'request_id';
		$this->table = 'recruitment_request';
		$this->icon = 'fa-folder';
		$this->short_name = 'Personnel Requisition Form - Manage';
		$this->long_name  = 'Personnel Requisition Form - Manage';
		$this->description = '';
		$this->path = APPPATH . 'modules/mrf_manage/';

		parent::__construct();
	}

	function _get_list($start, $limit, $search, $filter, $dt_filter, $trash = false)
	{
		$data = array();				
		
		$qry = $this->_get_list_cached_query();
		
		if( $trash )
		{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 1";
		}
		else{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 0";	
		}

		if( $this->user->user_id != 1 )
		{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.status_id <> 1";
		}


		$qry .= ' AND T5.approver_id = '. $this->user->user_id . ' AND T5.status_id > 1';

		if(is_array($filter)) {
			foreach ($filter as $filter_key => $filter_value) {
				$qry .= ' AND '.$this->db->dbprefix.'recruitment_request.'. $filter_value;
			}
		}
		
		if($dt_filter != "")
			$qry .= ' AND '.$this->db->dbprefix.'recruitment_request.created_on LIKE "%'. $dt_filter . '%"';
		
		$qry .= " ORDER BY " .$this->db->dbprefix. "recruitment_request.created_on DESC";
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);
		// echo "<pre>";print_r($qry);exit;
		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	public function _get_list_cached_query()
	{
		$this->load->config('list_cached_query_custom');
		return $this->config->item('list_cached_query_custom');	
	}

	function get_key_classes()
	{
		$this->db->order_by('sequence');
		$classes = $this->db->get_where('recruitment_request_key_class', array('deleted' => 0));
		if( $classes->num_rows() > 0 )
			return $classes->result();
		else
			return false;
	}

	function get_keys( $key_class_id, $record_id )
	{
		if( !empty( $record_id ) ){
			$qry = "select a.*, b.key_value
			FROM {$this->db->dbprefix}recruitment_request_key a
			LEFT JOIN {$this->db->dbprefix}recruitment_request_details b ON b.key_id = a.key_id AND b.request_id = {$record_id}
			WHERE a.deleted = 0 AND a.key_class_id = {$key_class_id}
			ORDER BY a.sequence";
			$classes = $this->db->query( $qry );
		}
		else{
			$this->db->order_by('sequence');
			$classes = $this->db->get_where('recruitment_request_key', array('deleted' => 0, 'key_class_id' => $key_class_id));	
		}

		if( $classes->num_rows() > 0 )
			return $classes->result();
		else
			return false;
	}

	function change_status( $record_id=0, $status_id=0, $comment="" )
	{
		$response = new stdClass();
		$req = $this->db->get_where('recruitment_request', array('request_id' => $record_id))->row();
		$req_by = $this->db->get_where('users', array('user_id' => $req->user_id))->row();

		//get approvers
		$where = array(
			'request_id' => $record_id
		);
		$this->db->order_by('sequence');
		$approvers = $this->db->get_where('recruitment_request_approver', $where)->result();
		$fstapprover = $approvers[0];
        $no_approvers = sizeof($approvers);
        $condition = $approvers[0]->condition;

        $this->load->library('parser');
        $this->parser->set_delimiters('{{', '}}');
                
        $response->redirect = false;
		$this->load->model('system_feed');
		$modified_on = date('Y-m-d H:i:s');
		switch( $status_id )
        {
            case 3: //approved
                //bring it up
                foreach(  $approvers as $index => $approver )
                {
                    if( $approver->approver_id == $this->user->user_id ){
                        $this->db->update('recruitment_request_approver', array('status_id' => 3,'comment'=>$comment,'modified_on'=>$modified_on,'status'=>"Approved"), array('id' => $approver->id));

                        if( isset( $approvers[$index+1] ) && $condition == "By Level" )
                        {
                        	$up = $approvers[$index+1];
                        	$this->db->update('recruitment_request_approver', array('status_id' => 2), array('id' => $up->id));
                        	$feed = array(
                                'status' => 'info',
                                'message_type' => 'Recruitment',
                                'user_id' => $req->user_id,
                                'feed_content' => 'Filed recruitment request and is now for your next approval.',
                                'uri' => $this->mod->route . '/view/'.$record_id,
	                            'recipient_id' => $up->approver_id
                            );
                            $recipients = array($up->approver_id);
                            $this->system_feed->add( $feed, $recipients );

                            $response->notify[] = $up->approver_id;

	                         // start email to approver
			                $approvers_user_info = $this->db->get_where('users', array('user_id' => $up->approver_id));
			                if ($approvers_user_info && $approvers_user_info->num_rows() > 0){
			                	$approvers_details = $approvers_user_info->row();
			                	$approver_fullname = $approvers_details->full_name;
			                }          
			                                  
			                $sendmrfdata['requestor'] = $req_by->full_name;
			                $sendmrfdata['approver'] = $approver_fullname;

	                        $mrf_send_template = $this->db->get_where( 'system_template', array( 'code' => 'MRF-SEND-APPROVER') )->row_array();
	                        $msg = $this->parser->parse_string($mrf_send_template['body'], $sendmrfdata, TRUE); 
	                        $subject = $this->parser->parse_string($mrf_send_template['subject'], $sendmrfdata, TRUE); 

	                        $this->db->query("INSERT INTO {$this->db->dbprefix}system_email_queue (`to`, `subject`, body)
	                                 VALUES('{$approvers_details->email}', '{$subject}', '".@mysql_real_escape_string($msg)."') ");
	                        //create system logs
	                        $insert_array = array(
	                            'to' => $approvers_details->email, 
	                            'subject' => $subject, 
	                            'body' => $msg
	                            );
	                        $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'system_email_queue', array(), $insert_array);                             
                        }
                    }
                }

                $response->redirect = true;
                break;
            case 6: //cancel
            	$where = array(
            		'request_id' => $record_id,
					'user_id' => $req->user_id,
					'approver_id' => $this->user->user_id
            	);
            	$this->db->update('recruitment_request_approver', array('status_id' => 6,'modified_on'=>$modified_on,'status'=>"Cancel"), $where);
            	if( $this->db->affected_rows() == 1 )
            	{
					$feed = array(
	                    'status' => 'info',
	                    'message_type' => 'Recruitment',
	                    'user_id' => $req->user_id,
	                    'feed_content' => 'The Personnel Requisition Form you requested has been cancelled.',
	                    'uri' => get_mod_route( 'mrf', '', false) . '/edit/'.$record_id,
	                    'recipient_id' => $req->user_id
	                );

	                $recipients = array($req->user_id);
	                $this->system_feed->add( $feed, $recipients );
	                $response->notify[] = $req->user_id;
	                $response->redirect = true;

                     // start email to requestor
	                $approvers_user_info = $this->db->get_where('users', array('user_id' => $this->user->user_id));
	                if ($approvers_user_info && $approvers_user_info->num_rows() > 0){
	                	$approvers_details = $approvers_user_info->row();
	                	$approver_fullname = $approvers_details->full_name;
	                }          
	                                  
	                $sendmrfdata['requestor'] = $req_by->full_name;
	                $sendmrfdata['approver'] = $approver_fullname;

                    $mrf_send_template = $this->db->get_where( 'system_template', array( 'code' => 'MRF-SEND-APPROVER') )->row_array();
                    $msg = $this->parser->parse_string($mrf_send_template['body'], $sendmrfdata, TRUE); 
                    $subject = $this->parser->parse_string($mrf_send_template['subject'], $sendmrfdata, TRUE); 

                    $this->db->query("INSERT INTO {$this->db->dbprefix}system_email_queue (`to`, `subject`, body)
                             VALUES('{$approvers_details->email}', '{$subject}', '".@mysql_real_escape_string($msg)."') ");
                    //create system logs
                    $insert_array = array(
                        'to' => $approvers_details->email, 
                        'subject' => $subject, 
                        'body' => $msg
                        );
                    $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'system_email_queue', array(), $insert_array);
                }
                break;
           case 7: // validated
            	$where = array(
            		'request_id' => $record_id,
					'user_id' => $req->user_id,
					'approver_id' => $this->user->user_id
            	);
            	$this->db->update('recruitment_request_approver', array('status_id' => 7,'comment'=>$comment,'modified_on'=>$modified_on,'status'=>"Validated"), $where);
            	if( $this->db->affected_rows() == 1 )
            	{
					$feed = array(
	                    'status' => 'info',
	                    'message_type' => 'Recruitment',
	                    'user_id' => $req->user_id,
	                    'feed_content' => 'The Personnel Requisition Form you requested has been validated.',
	                    'uri' => get_mod_route( 'mrf', '', false) . '/edit/'.$record_id,
	                    'recipient_id' => $req->user_id
	                );

	                $recipients = array($req->user_id);
	                $this->system_feed->add( $feed, $recipients );
	                $response->notify[] = $req->user_id;
	                $response->redirect = true;

 					// start email to requestor
	                $approvers_user_info = $this->db->get_where('users', array('user_id' => $this->user->user_id));
	                if ($approvers_user_info && $approvers_user_info->num_rows() > 0){
	                	$approvers_details = $approvers_user_info->row();
	                	$approver_fullname = $approvers_details->full_name;
	                }          
	                                  
	                $sendmrfdata['requestor'] = $req_by->full_name;
	                $sendmrfdata['approver'] = $approver_fullname;

                    $mrf_send_template = $this->db->get_where( 'system_template', array( 'code' => 'MRF-SEND-APPROVER') )->row_array();
                    $msg = $this->parser->parse_string($mrf_send_template['body'], $sendmrfdata, TRUE); 
                    $subject = $this->parser->parse_string($mrf_send_template['subject'], $sendmrfdata, TRUE); 

                    $this->db->query("INSERT INTO {$this->db->dbprefix}system_email_queue (`to`, `subject`, body)
                             VALUES('{$approvers_details->email}', '{$subject}', '".@mysql_real_escape_string($msg)."') ");
                    //create system logs
                    $insert_array = array(
                        'to' => $approvers_details->email, 
                        'subject' => $subject, 
                        'body' => $msg
                        );
                    $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'system_email_queue', array(), $insert_array);	                
                }                
            case 8: // disapproved
            	$where = array(
            		'request_id' => $record_id,
					'user_id' => $req->user_id,
					'approver_id' => $this->user->user_id
            	);
            	$this->db->update('recruitment_request_approver', array('status_id' => 8,'comment'=>$comment,'modified_on'=>$modified_on,'status'=>"Disapproved"), $where);
            	if( $this->db->affected_rows() == 1 )
            	{
					$this->db->update('recruitment_request', array('status_id' => $status_id, 'date_disapproved' => date('Y-m-d H:i:s')), array('request_id' => $record_id));            		

					$feed = array(
	                    'status' => 'info',
	                    'message_type' => 'Recruitment',
	                    'user_id' => $req->user_id,
	                    'feed_content' => 'The Personnel Requisition Form you requested has been disapproved.',
	                    'uri' => get_mod_route( 'mrf', '', false) . '/edit/'.$record_id,
	                    'recipient_id' => $req->user_id
	                );

	                $recipients = array($req->user_id);
	                $this->system_feed->add( $feed, $recipients );
	                $response->notify[] = $req->user_id;
	                $response->redirect = true;

 					// start email to requestor
	                $approvers_user_info = $this->db->get_where('users', array('user_id' => $this->user->user_id));
	                if ($approvers_user_info && $approvers_user_info->num_rows() > 0){
	                	$approvers_details = $approvers_user_info->row();
	                	$approver_fullname = $approvers_details->full_name;
	                }          
	                                  
	                $sendmrfdata['requestor'] = $req_by->full_name;
	                $sendmrfdata['approver'] = $approver_fullname;

                    $mrf_send_template = $this->db->get_where( 'system_template', array( 'code' => 'MRF-SEND-APPROVER') )->row_array();
                    $msg = $this->parser->parse_string($mrf_send_template['body'], $sendmrfdata, TRUE); 
                    $subject = $this->parser->parse_string($mrf_send_template['subject'], $sendmrfdata, TRUE); 

                    $this->db->query("INSERT INTO {$this->db->dbprefix}system_email_queue (`to`, `subject`, body)
                             VALUES('{$approvers_details->email}', '{$subject}', '".@mysql_real_escape_string($msg)."') ");
                    //create system logs
                    $insert_array = array(
                        'to' => $req_by->email, 
                        'subject' => $subject, 
                        'body' => $msg
                        );
                    $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'system_email_queue', array(), $insert_array);	                
                }
        }
	
		if( $status_id == 3 )
        {
            $where = array(
				'request_id' => $record_id
			);
			$this->db->order_by('sequence');
			$approvers = $this->db->get_where('recruitment_request_approver', $where)->result();

            switch ($condition) {
                case 'ALL':
                case 'By Level':
                    $all_approved = true;
                    foreach( $approvers as $approver )
                    {
                        if($approver->status_id != 3)
                        {
                            $all_approved = false;
                            break;
                        }
                    }
                    if($all_approved)
                    {
                        $status_id = 3;
                    }
                    else{
                        $status_id = 2;
                    }
                    break;
                case 'Either Of':
                    $one_approved = false;
                    foreach( $approvers as $approver )
                    {
                        if($approver->status_id == 3)
                        {
                            $one_approved = true;
                            break;
                        }
                    }
                    if($one_approved)
                    {
                        $status_id = 3;
                    }
                    else{
                        $status_id = 2;
                    }
                    break;
            }

            if( $status_id == 3 ) // status id of the main table recruitment request
            {
            	$feed = array(
                    'status' => 'info',
                    'message_type' => 'Recruitment',
                    'user_id' => $req->user_id,
                    'feed_content' => 'The Personnel Requisition Form you requested has been approved.',
                    'uri' => get_mod_route( 'mrf', '', false) . '/edit/'.$record_id,
                    'recipient_id' => $req->user_id
                );

                $recipients = array($req->user_id);
                $this->system_feed->add( $feed, $recipients );
                $response->notify[] = $req->user_id;
            	
/*            	if( !empty($req->role_id) ){
	                $qry = "select * 
	                FROM {$this->db->dbprefix}users
	                WHERE role_id in ({$req->role_id})
	                AND deleted = 0 AND active = 1";
	                $pointpersons = $this->db->query( $qry );
	                if( $pointpersons->num_rows() > 0 )
	                {
	                	$feed = array(
		                    'status' => 'info',
		                    'message_type' => 'Comment',
		                    'user_id' => $this->user->user_id,
		                    'feed_content' => 'A Personnel Requisition Form has been approved and needs your attention.',
		                    'uri' => get_mod_route( 'mrf_admin', '', false) . '/view/'.$record_id,
		                    'recipient_id' => 0
		                );
		                $recipients = array();
	                	foreach($pointpersons->result() as $pointperson)
	                	{
	                		$recipients[] = $pointperson->user_id;
	                		$response->notify[] = $pointperson->user_id;
	                	}
	                	$this->system_feed->add( $feed, $recipients );
	                }
            	}*/
            }

            $this->db->update('recruitment_request', array('status_id' => $status_id, 'date_approved' => date('Y-m-d H:i:s')), array('request_id' => $record_id));

            if( $this->db->_error_message() != "" )
	        {
	        	$response->message[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
	        }
    	}

    	return $response;
	}
	
    function get_recruitment_config($key)
    {
    	$this->db->where('key', $key);
    	$this->db->limit('1');
    	$config = $this->db->get('config');

    	if($config && $config->num_rows() > 0){
    		$config = $config->row();
    		return $config->value;
    	}
    	
    	return false;
    }
	
}