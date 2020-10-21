<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mrf extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('mrf_model', 'mod');
		parent::__construct();
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

        $data['mrf'] = isset($this->permission['list']) ? $this->permission['list'] : 0;

        $this->load->model('mrf_admin_model', 'mrf_admin');
        $data['mrf_admin'] = isset($permission[$this->mrf_admin->mod_code]['list']) ? $permission[$this->mrf_admin->mod_code]['list'] : 0;
     
        $this->load->model('mrf_manage_model', 'mrf_manage');
        $data['mrf_manage'] = isset($permission[$this->mrf_manage->mod_code]['list']) ? $permission[$this->mrf_manage->mod_code]['list'] : 0;
     	
     	$this->db->order_by('recruit_status', 'asc');
		$recruitment_rec_status= $this->db->get_where('recruitment_request_status', array('deleted' => 0));
		$data['rec_status'] = $recruitment_rec_status->result_array();

        $this->load->vars($data);  
		echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
	}

	public function get_list()
	{
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

	private function _process_lists( $records, $trash, $data)
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
			//echo "<pre>";print_r($record);exit;
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

	public function add( $record_id = '', $child_call = false )
	{
		if( !$this->permission['add'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_edit( $child_call, true );
	}

	public function edit( $record_id = "", $child_call = false )
	{
		if( !$this->permission['edit'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->db->limit(1);
		$check = $this->db->get_where('recruitment_request', array('request_id' => $record_id, 'user_id' => $this->user->user_id))->num_rows();

		if( $check == 0 )
		{
			echo $this->load->blade('pages.not_under_attention')->with( $this->load->get_cached_vars() );
			die();	
		}

		$this->_edit( $child_call );
			
		// $this->load->helper('form');
		// $this->load->helper('file');
		// echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );

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

			//$this->db->limit(1);
			$this->db->order_by('sequence');
			$this->db->select('recruitment_request_approver.*,users.display_name');
			$this->db->join('users','users.user_id=recruitment_request_approver.approver_id','left');
			$check = $this->db->get_where('recruitment_request_approver', array('request_id' => $this->record_id));

			/*if( $check->num_rows() == 0 )
			{
				echo $this->load->blade('pages.not_under_attention')->with( $this->load->get_cached_vars() );
				die();	
			}*/
			$user_id = $this->user->user_id;
			$data['user_id'] = $user_id;
			$data['approver'] = $check->result_array();
			
			$partner_record = "SELECT up.*, ud.department as dept, uc.company as comp, ud.immediate 
							FROM {$this->db->dbprefix}users_profile up
							INNER JOIN {$this->db->dbprefix}users_company uc ON up.company_id = uc.company_id
							INNER JOIN {$this->db->dbprefix}users_department ud ON up.department_id = ud.department_id
							WHERE user_id = {$this->user->user_id} ";
			$partner = $this->db->query($partner_record);

			$arPartner_record = array('department_id' => '','immediate' => '','company_id' => '','comp' => '');
			if ($partner && $partner->num_rows() > 0){
				$arPartner_record = $partner->row_array();
			}
			
			if($new){
				$data['record']['recruitment_request.department_id'] = $arPartner_record['department_id'];	
				$data['record']['recruitment_request.immediate'] = $arPartner_record['immediate'];
				$data['record']['recruitment_request.company_id'] = $arPartner_record['company_id'];
			}else{
				$department = $this->db->get_where('users_department', array('department_id' => $data['record']['recruitment_request.department_id']));
				$data['record']['recruitment_request.immediate'] = $department->row()->immediate;
			}
			
			
			$data['record']['company'] = $arPartner_record['comp'];

			$data['record']['disabled'] = "";
			$data['record']['readonly'] = "";
			if($data['record']['recruitment_request.status_id'] > 1 && $data['record']['recruitment_request.status_id'] < 8){
				$data['record']['disabled'] = "disabled";
				$data['record']['readonly'] = "readonly";
			}
			// echo "<pre>\n";
			// print_r($data['record']);
			// exit;
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

	function save( $child_call = false )
	{

		$key_fields = $this->input->post('key');
		$recruit_fields = $this->input->post('recruitment_request');

        //validate key_requirements id=21  
        $record_id = trim($this->input->post('record_id'));
        $key_field_id = $this->mod->get_request_key_id('assignment');

        $_hr_assigned = '';

        if ((isset($key_fields) && $key_fields != '') && array_key_exists($key_field_id, $key_fields)){
        	$_hr_assigned = trim($key_fields[$key_field_id]);

	        if(empty($record_id))
	        {
	        	$control_number = '';
	            $control_number = $this->get_prf_control_no($key_fields[$key_field_id]);
	    		
	        }        	
    	}

/*        if( empty($_hr_assigned) ){
            $this->response->message[] = array(
                'message' => 'Assignment is required.',
                'type' => 'warning'
            );  
            $this->_ajax_return(); 
        } */

        //validate key_requirements id=17		
		if((isset($key_fields) && $key_fields != '') && array_key_exists(17, $key_fields)){
			$key_req = $key_fields[17];
			if( !array_filter($key_req) ){
				$this->response->message[] = array(
					'message' => 'Input at least one key requirement.',
					'type' => 'warning'
				);
			$this->_ajax_return();			
			}
		}

    	$req = $_POST['recruitment_request'];

    	if (isset($req['replacement_transfer_leave_date_from']) && $req['replacement_transfer_leave_date_from'] == '1970-01-01'){
    		$_POST['recruitment_request']['replacement_transfer_leave_date_from'] = '';
    	}

    	if (isset($req['replacement_transfer_leave_date_to']) && $req['replacement_transfer_leave_date_to'] == '1970-01-01'){
    		$_POST['recruitment_request']['replacement_transfer_leave_date_to'] = '';
    	}

		if(isset($this->record_id))
		{
			parent::save( true );
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
						'key_value' => (is_array($value)) ? serialize($value) : $value
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
				$this->db->update('recruitment_request', array('status_id' => $_POST['recruitment']['status_id']), array('request_id' => $this->record_id));

			if( $_POST['recruitment']['status_id'] == 2 )
			{
				$this->db->where('request_id',$this->record_id);
				$this->db->update('recruitment_request_approver', array('status_id' => 1,'status' => ''));

				$this->load->model('system_feed');

				$req = $this->db->get_where('recruitment_request', array('request_id' => $this->record_id))->row();
				$req_by = $this->db->get_where('users', array('user_id' => $req->user_id))->row();
				//get approvers
		        $where = array(
		            'request_id' => $this->record_id,
		            'user_id' => $req->user_id,
		        );
		        $this->db->order_by('sequence');
		        $approvers = $this->db->get_where('recruitment_request_approver', $where)->result();

		        $no_approvers = sizeof($approvers);

		        $approver_fullname = '';
		        if (!empty($approvers)){
	                $approvers_user_info = $this->db->get_where('users', array('user_id' => $approvers[0]->approver_id));
	                if ($approvers_user_info && $approvers_user_info->num_rows() > 0){
	                	$approvers_details = $approvers_user_info->row();
	                	$approver_fullname = $approvers_details->full_name;
	                }
		        }

                $sendmrfdata['requestor'] = $req_by->full_name;
                $sendmrfdata['approver'] = $approver_fullname;

                $this->load->library('parser');
                $this->parser->set_delimiters('{{', '}}');

		        if($no_approvers > 0){
			        $condition = $approvers[0]->condition;

			        switch ($condition) {
		                case 'ALL':
		                case 'Either Of':
		                	foreach($approvers as $approver)
		                	{
		                		$this->db->update('recruitment_request_approver', array('status_id' => 2), array('id' => $approver->id));
			                	$feed = array(
		                            'status' => 'info',
		                            'message_type' => 'Recruitment',
		                            'user_id' => $this->user->user_id,
		                            'feed_content' => $req_by->full_name. ' Filed recruitment request and now for your approval',
		                            'uri' => get_mod_route('mrf_manage', 'view/'.$this->record_id, false),
		                            'recipient_id' => $approver->approver_id
		                        );

		                        $recipients = array($approver->approver_id);
		                        $this->system_feed->add( $feed, $recipients );
		                    
		                        $this->response->notify[] = $approver->approver_id;

                                // email to approver
                                $mrf_send_template = $this->db->get_where( 'system_template', array( 'code' => 'MRF-SEND-APPROVER') )->row_array();
                                $msg = $this->parser->parse_string($mrf_send_template['body'], $sendmrfdata, TRUE); 
                                $subject = $this->parser->parse_string($mrf_send_template['subject'], $sendmrfdata, TRUE); 

                                $this->db->query("INSERT INTO {$this->db->dbprefix}system_email_queue (`to`, `subject`, body)
                                         VALUES('{$approvers_details->email}', '{$subject}', '".$this->db->escape_str($msg)."') ");

                                //create system logs
                                $insert_array = array(
                                    'to' => $approvers_details->email, 
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
		                	}
		                	break;
		                case 'By Level':
		                	$approver =  $approvers[0];
		                	$this->db->update('recruitment_request_approver', array('status_id' => 2), array('id' => $approver->id));
		                	$feed = array(
	                            'status' => 'info',
	                            'message_type' => 'Recruitment',
	                            'user_id' => $this->user->user_id,
	                            'feed_content' => 'Please review Personnel Requisition Form requested by '.$req_by->full_name.'.',
	                            'uri' => get_mod_route('mrf_manage', 'view/'.$this->record_id, false),
	                            'recipient_id' => $approver->approver_id
	                        );

	                        $recipients = array($approver->approver_id);
	                        $this->system_feed->add( $feed, $recipients );
	                    
	                        $this->response->notify[] = $approver->approver_id;

                            // email to approver
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

                            if( $this->db->_error_message() != "" ){
                                $this->response->message[] = array(
                                    'message' => 'Error occured in sending email. Kindly contact System Admin',
                                    'type' => 'error'
                                );
                                $this->_ajax_return();
                            }
		                    break;
		            }
		        }
			}
			elseif( $_POST['recruitment']['status_id'] == 6 ){
				$req = $this->db->get_where('recruitment_request', array('request_id' => $this->record_id))->row();
            	$where = array(
            		'request_id' => $this->record_id,
            	);
            	$this->db->update('recruitment_request_approver', array('status_id' => 6,'modified_on'=>date('Y-m-d H:i:s'),'status'=>"Cancelled"), $where);				
            	$this->db->update('recruitment_request', array('date_cancelled' => date('Y-m-d H:i:s')), array('request_id' => $this->record_id));     
			}

			//set pointperson
			if(isset($_POST['recruitment_request']['position_id'])){
				$position_id = $_POST['recruitment_request']['position_id'];
				$this->db->limit(1);
				$position = $this->db->get_where('users_position', array('position_id' => $position_id))->row();
				$type_id = $position->employee_type_id;
				$qry = "SELECT * FROM `{$this->db->dbprefix}recruitment_mrf_pointperson` 
				WHERE FIND_IN_SET({$type_id}, type_id) > 0";
				$roles = $this->db->query( $qry );
				if( $roles->num_rows() > 0 )
				{
					$update_role = array();
					foreach( $roles->result() as $role )
					{
						$update_role[$role->role_id] = $role->role_id;
					}	
					$this->db->update('recruitment_request', array('role_id' => implode(',', $update_role)), array('request_id' => $this->record_id));
				}
			}


			$request_control_no = $this->db->get_where('recruitment_request', array('request_id' => $this->record_id));

        	if($request_control_no && $request_control_no->num_rows() > 0){
        		$request_control_no = $request_control_no->row();
        	}

        	if($request_control_no->document_no == ''){
        		
        		$control_number = $this->get_prf_control_no();

        		$system_series = $this->db->get_where('system_series', array('series_code' => 'PRF_CONTROL_NO'))->row();
                $sequence = $system_series->sequence + 1; 
                $this->db->update('system_series',  array('last_sequence' => $control_number, 'sequence' => $sequence), array('id' => $system_series->id));
            
                $this->db->update('recruitment_request', array('document_no' => $control_number), array('request_id' => $this->record_id));
                
        	}
			
			$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
		}

		$this->_ajax_return();
	}

	function _list_options_active( $record, &$rec )
	{
		//temp remove until view functionality added
		/*if( $this->permission['detail'] )
		{
			$rec['detail_url'] = $this->mod->url . '/detail/' . $record['record_id'];
			$rec['options'] .= '<li><a href="'.$rec['detail_url'].'"><i class="fa fa-info"></i> View</a></li>';
		}*/
		// echo "<pre>";
		// print_r($record);
		// exit();
		if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}	
		if(!($record['recruitment_request_status_id']>1)){
			if( isset($this->permission['delete']) && $this->permission['delete'] )
			{
				$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
				$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
			}
		}
		// if( isset($this->permission['delete']) && $this->permission['delete'] )
		// {
/*			$rec['duplicate_url'] = $this->mod->url . '/duplicate/' . $record['record_id'];
			$rec['options'] .= '<li><a href="javascript: duplicate_record('.$record['record_id'].')"><i class="fa fa-copy"></i> '.lang('common.duplicate').'</a></li>';*/
		// }
	}
	
	function duplicate()
	{
		$this->_ajax_only();
		
		if( !$this->input->post('records') )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();	
		}

		$records = $this->input->post('records');
		$records = explode(',', $records);

		$this->db->where_in($this->mod->primary_key, $records);
		$main_records = $this->db->get($this->mod->table)->row_array();

		$main_records['request_id'] = '';
		$main_records['document_no'] = '';
		$main_records['status_id'] = 1;
		$main_records['created_on'] = '';
		$main_records['created_by'] = $this->user->user_id;
		$main_records['modified_on'] = '';
		$main_records['modified_by'] = '';

		$this->db->insert($this->mod->table, $main_records);
		if( $this->db->_error_message() == "" )
		{
			$this->response->record_id = $this->record_id = $this->db->insert_id();
		}
		
		if( $this->db->_error_message() != "" ){
			$this->response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}
		else{
			$this->response->message[] = array(
				'message' => lang('common.duplicate_record', $this->db->affected_rows()),
				'type' => 'success'
			);
		}

		$this->_ajax_return();
	}

	function get_dept_immediate(){
		$this->_ajax_only();

		$dept_id = $this->input->post('dept_id');

		$this->db->select('*')
	    ->from('users_department')
    	->where("department_id = {$dept_id}");

    	$department_info = $this->db->get('');

		if( $department_info->num_rows() > 0 ){
    		$dep_info = $department_info->row_array();

    		$this->db->select('full_name')
		    ->from('users')
	    	->where("user_id = {$dep_info['immediate_id']}");
	    	$department_head = $this->db->get('')->row_array();

	    	$dep_head_fullname = '';
	    	if (isset($department_head['full_name'])){
	    		$dep_head_fullname = $department_head['full_name'];
	    	}

			$this->response->immediate = $dep_head_fullname;
			$this->response->retrieved_immediate = true;
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

        $this->_ajax_return();
	}

    function update_nature_req()
    {
        $this->_ajax_only();
        $record_check = $this->mod->_exists( $this->input->post('record_id') );

        if($record_check === true){
        	$result = $this->mod->_get( 'edit', $this->input->post('record_id'));
			$record = $result->row_array();
        }

		// $natures = $db->get_where('recruitment_request_nature', array('deleted' => 0));
		$natures_qry = "SELECT *
						 FROM {$this->db->dbprefix}recruitment_request_nature 
						 WHERE deleted=0 ";
		if($this->input->post('budgeted') == 0)
			$natures_qry .= " AND nature_id NOT IN (5) ";
		
		$natures = $this->db->query($natures_qry);
		
        $this->response->natures = '<option value="">Select...</option>';
        foreach( $natures->result() as $nature )
        {
        	$selected = (($record_check === true) && ($record['recruitment_request.nature_id'] == $nature->nature_id)) ? "selected='selected'" : "";
            $this->response->natures .= '<option value="'.$nature->nature_id.'"  '. $selected .'>'.$nature->nature.'</option>';
        }
        $this->_ajax_return();  
    }

    function get_prf_control_no()
    {
        $series = get_system_series('PRF_CONTROL_NO', 'PRF');
        return $series;
    }
}