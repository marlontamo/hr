<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mrf_manage extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('mrf_manage_model', 'mod');
		parent::__construct();
        $this->lang->load( 'mrf' );
	}

	public function index()
	{
		$data['year'] = date('Y');
        $data['prev_year']['key'] 	= date('Y') - 1;
        $data['prev_year']['value'] = date('Y') - 1;
        $data['next_year']['key'] 	= date('Y') + 1;
        $data['next_year']['value']	= date('Y') + 1;

        // filters
        $data['current_date'] 	= date("Y-m-d");
        $data['prev_month'] 	= date("Y-m-d", strtotime($data['current_date'] . ' - 1 months'));
        $data['next_month'] 	= date("Y-m-d", strtotime($data['current_date'] . ' + 1 months'));

		for ($m=1; $m<=12; $m++) {

			$month_key = date('Y-m-d', mktime(0,0,0,$m, 1, date('Y')));
    		$month_value = date('F', mktime(0,0,0,$m, 1, date('Y')));
     		$data['month_list'][$month_key] = $month_value;
     	}

		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

        $user_setting = APPPATH . 'config/users/'. $this->user->user_id .'.php';
        $user_id = $this->user->user_id;
        $this->load->config( "users/{$user_id}.php", false, true );
        $user = $this->config->item('user');

        $this->load->config( 'roles/'. $user['role_id'] .'/permission.php', false, true );
        $permission = $this->config->item('permission');

        $data['mrf_manage'] = isset($this->permission['list']) ? $this->permission['list'] : 0;

        $this->load->model('mrf_admin_model', 'mrf_admin');
        $data['mrf_admin'] = isset($permission[$this->mrf_admin->mod_code]['list']) ? $permission[$this->mrf_admin->mod_code]['list'] : 0;
     
        $this->load->model('mrf_model', 'mrf_manage');
        $data['mrf'] = isset($permission[$this->mrf_manage->mod_code]['list']) ? $permission[$this->mrf_manage->mod_code]['list'] : 0;
     
        $this->db->order_by('recruit_status', 'asc');
		$recruitment_rec_status= $this->db->get_where('recruitment_request_status', array('deleted' => 0));
		$data['rec_status'] = $recruitment_rec_status->result_array();

        $this->load->vars($data);  
		echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
	}

	public function get_list()
	{
		$this->_ajax_only();
		if( !$this->permission['list'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$data = array();
		$data['pn'] = '';
		$data['sf'] = '';

		// determine list request
		$type 	= $this->input->post('type');
		$value 	= $this->input->post('value');

		// get currently selected year
		$csy_value 	= $this->input->post('selected_year');
		$currently_selected_year = $csy_value == '' ? $csy_value : date("Y");
		$date = date("Y-m-d");

		if($type === 'month' || $type === 'current'){

			$value = $type === 'current' ? date("Y-m-d") : $value;

			// if month, move to selected month
			// and setup pagination and month list
			$date = $value;

			// pn - previous/next 
			$data['pn']['prev'] = date("Y-m-d", strtotime($value . ' - 1 months'));
			$data['pn']['current'] = date("Y-m-d", strtotime($value)); // remove this line
			$data['pn']['nxt'] 	= date("Y-m-d", strtotime($value . ' + 1 months'));

			// side filter
			$selected_year = date('Y', strtotime($value));
			$prev_year = date('Y', strtotime($value)) - 1;
			$next_year = date('Y', strtotime($value)) + 1;


			$sf = '<span id="yr-fltr-prev" data-year-value="' . $prev_year . '" class="event-block label label-info year-filter">' . $prev_year . '</span>';

			for($m=1; $m<=12; $m++) {

				$month_key = date('Y-m-d', mktime(0,0,0,$m, 1, date('Y', strtotime($value))));
    			$month_value = date('F', mktime(0,0,0,$m, 1, date('Y', strtotime($value))));

    			$label_class = date("F", strtotime($value)) === $month_value ? 'label-success' : 'label-default';

				$sf .= '<span id="ml-'.$month_key.'" data-month-value="'.$month_key.'" class="event-block label ' . $label_class .' external-event month-list">'.$month_value.'</span>';
	     	}

	     	$sf .= '<span id="yr-fltr-next" data-year-value="' . $next_year . '" class="event-block label label-info external-event year-filter">
	                	' . $next_year . '
	                </span>';

			$data['sf'] = $sf;
			$range = "month";

			$this->response->current_title = date("F-Y", strtotime($value));
		}
		else if($type === 'year'){ 

			$range = "year";

			// if year, on previous year load the last month
			// otherwise move to first month of future year
			if($value < date('Y')){

				// now we're talking about previous year
				$data['pn']['prev'] = date("Y-m-d", strtotime($value . '-11-01'));
				$data['pn']['current'] = date("Y-m-d", strtotime($value . '-12-01'));
				$data['pn']['nxt'] 	= date("Y-m-d", strtotime($value + 1 . '-01-01'));

				// side filter
				$selected_year = date('Y', strtotime($value . '-01-01'));
				$prev_year = date('Y', strtotime($value . '-01-01')) - 1;
				$next_year = date('Y', strtotime($value . '-01-01')) + 1;
			}
			else{

				// future year
				$data['pn']['prev'] = date("Y-m-d", strtotime($value - 1 . '-12-01'));
				$data['pn']['current'] = date("Y-m-d", strtotime($value . '-01-01'));
				$data['pn']['nxt'] 	= date("Y-m-d", strtotime($value . '-02-01'));

				// side filter
				$selected_year = date('Y', strtotime($value . '-01-01'));
				$prev_year = date('Y', strtotime($value . '-01-01')) - 1;
				$next_year = date('Y', strtotime($value . '-01-01')) + 1;
			}

			$date = $data['pn']['current'];

			$sf = '';
			$sf = '<span 
						id="yr-fltr-prev" 
						data-year-value="' . $prev_year . '" 
						data-year-selected="' . $currently_selected_year . '" 
						class="event-block label label-info year-filter">' . $prev_year . '</span>';

			for($m = 1; $m <= 12; $m++) {

				$month_key = date('Y-m-d', mktime(0,0,0,$m, 1, $value));
    			$month_value = date('F', mktime(0,0,0,$m, 1, $value));

    			$label_class = date("F", strtotime($date)) === $month_value ? 'label-success' : 'label-default';

				$sf .= '<span id="ml-'.$month_key.'" data-month-value="'.$month_key.'" class="event-block label ' . $label_class .' external-event month-list">'.$month_value.'</span>';
	     	}

	     	$sf .= '<span 
	     				id="yr-fltr-next" 
	     				data-year-value="' . $next_year . '" 
	     				data-year-selected="' . $currently_selected_year . '" 
	     				class="event-block label label-info external-event year-filter">
	                	' . $next_year . '
	                </span>';

			$data['sf'] = $sf;

			$this->response->current_title = date("F-Y", strtotime($date));
		}

		$this->response->show_import_button = false;
		if( $this->input->post('page') == 1 )
		{
			$this->load->model('upload_utility_model', 'import');
			if( $this->import->get_templates( $this->mod->mod_id ) )
				$this->response->show_import_button = true;
		}

		$trash = $this->input->post('trash') == 'true' ? true : false;

		$records = $this->_get_list( $trash, $date );
		$this->_process_lists( $records, $trash, $data );

		$this->_ajax_return();
	}

	private function _process_lists( $records, $trash, $data )
	{
		$this->response->records_retrieve = sizeof($records);
		$this->response->list = '';
		$this->response->pn = $data['pn'];
		$this->response->sf = $data['sf'];
		foreach( $records as $record )
		{
			$rec = array(
				'detail_url' => '#',
				'edit_url' => '#',
				'delete_url' => '#',
				'options' => ''
			);

			if(!$trash)
				$this->_list_options_active( $record, $rec );
			else
				$this->_list_options_trash( $record, $rec );

			$record = array_merge($record, $rec);
			$this->response->list .= $this->load->blade('list_template', $record, true)->with( $this->load->get_cached_vars() );
		}
	}

	private function _get_list( $trash, $date )
	{
		$date_filter = date("Y-m", strtotime($date));
		$page = $this->input->post('page');
		$search = $this->input->post('search');
		$filter = "";
		
		$filter_by = $this->input->post('filter_by');
		$filter_value = $this->input->post('filter_value');
		
		if( is_array( $filter_by ) )
		{
			foreach( $filter_by as $filter_by_key => $filter_value )
			{
				if( $filter_value != "" ) 
					$filter[] = $filter_by_key .' = "'.$filter_value.'"';	
			}
		}
		else{
			if( $filter_by && $filter_by != "" )
			{
				$filter = 'AND '. $filter_by .' = "'.$filter_value.'"';
			}
		}
		
		if( $page == 1 )
		{
			$searches = $this->session->userdata('search');
			if( $searches ){
				foreach( $searches as $mod_code => $old_search )
				{
					if( $mod_code != $this->mod->mod_code )
					{
						$searches[$this->mod->mod_code] = "";
					}
				}
			}
			$searches[$this->mod->mod_code] = $search;
			$this->session->set_userdata('search', $searches);
		}
		
		$page = ($page-1) * 10;
		$records = $this->mod->_get_list($page, 10, $search, $filter, $date_filter, $trash);
		return $records;
	}

	public function edit( $record_id = "", $child_call = false )
	{
		if( !$this->permission['edit'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_edit( $child_call );
	}


	private function _edit( $child_call, $new = false )
	{
		$record_check = false;
		$this->record_id = $data['record_id'] = '';

		if( !$new ){
			if( !$this->_set_record_id() )
			{
				echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
				die();
			}

			$this->record_id = $data['record_id'] = $_POST['record_id'];
		}
		
		$record_check = $this->mod->_exists( $this->record_id );
		if( $new || $record_check === true )
		{
			$result = $this->mod->_get( 'edit', $this->record_id );
			if( $new )
			{
				$field_lists = $result->list_fields();
				foreach( $field_lists as $field )
				{
					$data['record'][$field] = '';
				}
			}
			else{
				$record = $result->row_array();
				foreach( $record as $index => $value )
				{
					$record[$index] = trim( $value );	
				}
				$data['record'] = $record;
			}

			if( !isset($this->permission['approve']) || !$this->permission['approve'] )
			{
				echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
				die();
			}

			
			//$this->db->limit(1);
			$this->db->order_by('sequence');
			$this->db->select('recruitment_request_approver.*,users.display_name');
			$this->db->join('users','users.user_id=recruitment_request_approver.approver_id','left');
			$check = $this->db->get_where('recruitment_request_approver', array('request_id' => $this->record_id));
			
			if( $check->num_rows() == 0 )
			{
				echo $this->load->blade('pages.not_under_attention')->with( $this->load->get_cached_vars() );
				die();	
			}
			$user_id = $this->user->user_id;
			$data['user_id'] = $user_id;
			$data['approver'] = $check->result_array();
			
			$this->load->model('mrf_model', 'mrf');
			$data['mrf'] = $this->mrf;

			$partner_record = "SELECT up.*, ud.department as dept, uc.company as comp, ud.immediate 
							FROM {$this->db->dbprefix}users_profile up
							INNER JOIN {$this->db->dbprefix}users_company uc ON up.company_id = uc.company_id
							INNER JOIN {$this->db->dbprefix}users_department ud ON up.department_id = ud.department_id
							WHERE user_id = {$data['record']['recruitment_request.user_id']} ";
			$partner_record = $this->db->query($partner_record)->row_array();

			$data['record']['recruitment_request.company_id'] = $partner_record['company_id'];
			$data['record']['recruitment_request.department_id'] = $partner_record['department_id'];
			$data['record']['recruitment_request.immediate'] = $partner_record['immediate'];
			$data['record']['company'] = $partner_record['comp'];

			$data['record']['disabled'] = "";
			$data['record']['readonly'] = "";
			if($data['record']['recruitment_request.status_id'] > 1){
				$data['record']['disabled'] = "disabled";
				$data['record']['readonly'] = "readonly";
			}
			$data['current_user'] = $this->user->user_id;
			$this->load->vars( $data );

			if( !$child_call ){
				$this->load->helper('form');
				$this->load->helper('file');
				echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
			}
		}
		else
		{
			$this->load->vars( $data );
			if( !$child_call ){
				echo $this->load->blade('pages.error', array('error' => $record_check))->with( $this->load->get_cached_vars() );
			}
		}
	}

	function view()
	{
		$this->edit();
	}

	function save()
	{
		parent::save( true );
		
		if( isset($_POST['recruitment']['status_id']) )
		{
			if($_POST['recruitment']['status_id'] == 8 && $_POST['recruitment']['comment'] == "")
			{
				$this->response->saved = false;
				$this->response->message[] = array(
					'message' => "Remarks field is required",
					'type' => 'warning'
				);
				$this->_ajax_return();
			}
		}

		if( $this->response->saved )
		{
			if( $this->input->post('key') )
			{
				$keys = $this->input->post('key');
				foreach( $keys as $key_id => $value )
				{
					$insert = array(
						'request_id' => $this->record_id,
						'key_id' => $key_id,
						'key_value' => $value
					);

					$where = array(
						'request_id' => $this->record_id,
						'key_id' => $key_id
					);

					$this->db->limit(1);
					$check = $this->db->get_where('recruitment_request_details', $where);
					if( $check->num_rows() == 1 )
					{
						$rec = $check->row();
						$insert['modified_by'] = $this->user->user_id;
						$insert['modified_on'] = date('Y-m-d H:i:s');
						$this->db->update('recruitment_request_details', $insert, array('id' => $rec->id));
					}
					else{
						$insert['created_by'] = $this->user->user_id;
						$this->db->insert('recruitment_request_details', $insert);
					}
				}
			}
			
			if( isset($_POST['recruitment']['status_id']) )
			{
				if(($_POST['recruitment']['status_id']) == 6 || $_POST['recruitment']['status_id'] == 7){
					$this->db->update('recruitment_request', array('status_id' => $_POST['recruitment']['status_id']), array('request_id' => $this->record_id));
				}

				$status_id = $_POST['recruitment']['status_id'];
				$comment = (isset($_POST['recruitment']['comment']) ? $_POST['recruitment']['comment'] : '');

				$response = $this->mod->change_status($this->record_id, $status_id, $comment);

				$this->response = (object) array_merge((array)$this->response, (array)$response);

                $req = $this->db->get_where('recruitment_request', array('request_id' => $this->record_id))->row();
                $req_by = $this->db->get_where('users', array('user_id' => $req->user_id))->row();
                //get approvers
                $where = array(
                    'request_id' => $this->record_id,
                    'user_id' => $req->user_id,
                );
                $this->db->order_by('sequence');
                $approvers = $this->db->get_where('recruitment_request_approver', $where)->result();
                
                $approvers_details = $this->db->get_where('users', array('user_id' => $approvers[0]->approver_id))->row();

/*                $role_ids = $this->mod->get_recruitment_config('hr_recruitment');
                
                $this->db->where_in('role_id', array($role_ids));
                $validators_details = $this->db->get('users')->result_array();*/
                
                $sendmrfdata['requestor'] = $req_by->full_name;
                $sendmrfdata['approver'] = $approvers_details->full_name;

                $this->load->library('parser');
                $this->parser->set_delimiters('{{', '}}');

                // send notif and email for approved PRF     
                if($req->status_id == 3) 
                {
					$hrd_manager = $this->mod->get_role_permission(4); //hrd manager
					if (count($hrd_manager) > 0){
						$this->db->where_in('role_id',$hrd_manager);
						$this->db->where('active',1);
						$this->db->where('deleted',0);  			
						$validators_details = $this->db->get('users')->result_array();

	                    foreach ($validators_details as $validator) {
	                        // start notif to approver
	                        $feed = array(
	                            'status' => 'info',
	                            'message_type' => 'Recruitment',
	                            'user_id' => $req->user_id,
	                            'feed_content' => 'Please review approved Personnel Requisition Form requested by '.$req_by->full_name.'.',
	                            'uri' => get_mod_route('mrf_admin', 'view/'.$this->record_id, false),
	                            'recipient_id' => $validator['user_id']
	                        );

	                        $recipients = array( $validator['user_id']);
	                        $this->system_feed->add( $feed, $recipients );
	                    
	                        $this->response->notify[] =  $validator['user_id'];
	                        // end notif to approver              

	                         // start email to approver
	                        $sendmrfdata['validator'] = $validator['full_name'];

	                        $mrf_send_template = $this->db->get_where( 'system_template', array( 'code' => 'MRF-SEND-VALIDATOR') )->row_array();
	                        $msg = $this->parser->parse_string($mrf_send_template['body'], $sendmrfdata, TRUE); 
	                        $subject = $this->parser->parse_string($mrf_send_template['subject'], $sendmrfdata, TRUE); 

	                        $this->db->query("INSERT INTO {$this->db->dbprefix}system_email_queue (`to`, `subject`, body)
	                                 VALUES('{$validator['email']}', '{$subject}', '".$this->db->escape_str($msg)."') ");
	                        //create system logs
	                        $insert_array = array(
	                            'to' => $validator['email'], 
	                            'subject' => $subject, 
	                            'body' => $msg
	                            );
	                        $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'system_email_queue', array(), $insert_array); 
	                    }
	                    if( $this->db->_error_message() != "" ){
	                        $this->response->message[] = array(
	                            'message' => 'Error occured in sending email. Kindly contact System Admin',
	                            'type' => 'error'
	                        );
	                        $this->_ajax_return();
	                    }
                    	// end email to approver
                    }
                // send notif and email for cancalled PRF        
                } 
                else 
                	if($_POST['recruitment']['status_id'] == 6) {        
                    // start email to approver
                    $mrf_send_template = $this->db->get_where( 'system_template', array( 'code' => 'MRF-SEND-CANCEL') )->row_array();
                    $msg = $this->parser->parse_string($mrf_send_template['body'], $sendmrfdata, TRUE); 
                    $subject = $this->parser->parse_string($mrf_send_template['subject'], $sendmrfdata, TRUE); 

                    $this->db->query("INSERT INTO {$this->db->dbprefix}system_email_queue (`to`, `subject`, body)
                             VALUES('{$req_by->email}', '{$subject}', '".$this->db->escape_str($msg)."') ");
                    //create system logs
                    $insert_array = array(
                        'to' => $req_by->email, 
                        'subject' => $subject, 
                        'body' => $msg
                        );
                    $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'system_email_queue', array(), $insert_array); 

                    if( $this->db->_error_message() != "" ){
                        $this->response->message[] = array(
                            'message' => 'Error occured in sending email. Kindly contact System Admin',
                            'type' => 'error'
                        );
                        $this->_ajax_return();
                    }
                    // end email to approver
                }
                
			}
		}

		$this->response->message[] = array(
			'message' => lang('common.save_success'),
			'type' => 'success'
		);

		$this->_ajax_return();
	}


	function change_status()
	{
		$this->_ajax_only();
		$record_id = $this->input->post('record_id');
		$status_id = $this->input->post('status_id');
		$response = $this->mod->change_status($record_id, $status_id);
		$this->response = (object) array_merge((array)$this->response, (array)$response);
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function _list_options_active( $record, &$rec )
	{
		if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/view/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
			switch( $record['recruitment_request_status_approver_id'] )
			{
				case 2:
					$rec['options'] .= '<li><a href="javascript: change_status('.$record['record_id'].', 3 )"><i class="fa fa-check"></i> '. lang('mrf_manage.approved') .'</a></li>';
					/*$rec['options'] .= '<li><a href="javascript: change_status('.$record['record_id'].', 8 )"><i class="fa fa-minus-circle"></i> '. lang('mrf_manage.disapproved') .'</a></li>';*/
					break;
			}

/*			switch( $record['recruitment_request_status_id'] )
			{
				case 3:
				case 4:
					$rec['options'] .= '<li><a href="javascript: change_status('.$record['record_id'].', 6 )"><i class="fa fa-check"></i> '. lang('common.cancel') .'</a></li>';
					break;
			}*/
		}	
		
		if(!($record['recruitment_request_status_id']>1)){
			if( isset($this->permission['delete']) && $this->permission['delete'] )
			{
				$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
				$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
			}
		}
	}
}