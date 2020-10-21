<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Applicant_monitoring extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('applicant_monitoring_model', 'mod');
		$this->load->model('mrf_model', 'mrf');
		$this->load->model('mrf_admin_model', 'mrf_am');
		parent::__construct();
	}

	public function index()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}
		
		//get all MRF
		$vars['request_id'] = "";
		$vars['mrf'] = $this->mod->get_active_mrf_by_year();
		if( sizeof( $vars['mrf'] ) > 0 )
		{
			$breakout = false;
			foreach( $vars['mrf'] as $year => $mrfs )
			{
				foreach( $mrfs as $mrf )
				{
					if($mrf->status_id == 4)
					{
						$vars['request_id'] = $mrf->request_id;
						$breakout = true;
						break;
					}
				}
				
				if($breakout)
					break;
			}
		}
		$this->load->vars( $vars );

		echo $this->load->blade('pages.dashboard')->with( $this->load->get_cached_vars() );
	}

	public function single_upload()
	{
		$this->_ajax_only();
		define('UPLOAD_DIR', 'uploads/applicant_monitoring/');
		$this->load->library("UploadHandler");
		$files = $this->uploadhandler->post();
		$file = $files[0];
	    $file->clas = date('hhmmss');		
		if( isset($file->error) && $file->error != "" )
		{
			$this->response->message[] = array(
				'message' => $file->error,
				'type' => 'error'
			);	
		}

	    $html = '<tr class="template-download">
	    	<input type="hidden" name="applicant_monitoring_interview[photo][]" value="'.$file->url.'"/>
	    	<input type="hidden" name="applicant_monitoring_interview[type][]" value="'.(isset($file->thumbnailUrl) ? 'img' : 'file').'"/>
	    	<input type="hidden" name="applicant_monitoring_interview[filename][]" value="'.$file->name.'" class="filename"/>
	    	<input type="hidden" name="applicant_monitoring_interview[size][]" value="'.$file->size.'"/>
	        <td>
	            <span class="preview">';
	                if (isset($file->thumbnailUrl)) {
	                    $html .= '<a href="'.$file->url.'" title="'.$file->name.'" download="'.$file->name.'" data-gallery><img src="'.base_url().$file->thumbnailUrl.'"></a>';
	                }
	            $html .= '</span>
	        </td>
	        <td>
	            <p class="name">';
	                if (isset($file->url)) {
	                    $html .= '<a href="javascript:void(0)" title="'.$file->name.'">'.$file->name.'</a>';
	                } else {
	                    $html .= '<span>"'.$file->name.'"</span>';
	                }
	            $html .= '</p>';
	            if (isset($file->error)) {
	                $html .= '<div><span class="label label-danger">Error</span>'.$file->error.'</div>';
	            }
	        $html .= '</td>
	        <td>
	            <span class="size">'.$file->size.'</span>
	        </td>
	        <td>
	        	<a data-dismiss="fileupload" class="btn red delete_attachment">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
	        	</a>
	        </td>
	    </tr>';

		$this->response->file = $file;
		$this->response->filenames = $file->name;
		$this->response->html = $html;
		$this->_ajax_return();
	}

	function get_steps()
	{
		$this->_ajax_only();
		if( !$this->permission['list'] )
		{
			$this->response->message[] = array(
				'message' => 'insufficient permission.',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
        $user_id = $this->config->config['user']['user_id'];
        $permission = $this->config->item('permission');
        $is_assigned = isset($permission[$this->mod->mod_code]['process']) ? $permission[$this->mod->mod_code]['process'] : 0;
        $is_interviewer = $this->mod->is_interviewer();

		$request_id = $this->input->post('request_id');
		$year = $this->input->post('year');

		$this->db->order_by('sort_order');
		$_steps = $this->db->get_where('recruitment_process_status', array('deleted' => 0, 'active' => 1));
		$step = array();
		
		if( !empty( $request_id ) )
		{
			$qry = "SELECT a.*, b.position
			FROM {$this->db->dbprefix}recruitment_request a
			LEFT JOIN {$this->db->dbprefix}users_position b on b.position_id = a.position_id
			WHERE a.request_id = {$request_id}
			LIMIT 1 OFFSET 0";

			$mrf = $this->db->query( $qry )->row();
			foreach($_steps->result() as $_step)
			{
				$step[$_step->status_id]['step'] = $_step;
				$step[$_step->status_id]['is_assigned'] = $is_assigned;
				$step[$_step->status_id]['is_interviewer'] = $is_interviewer;
				$step[$_step->status_id]['recruit'] = array();

				$qry = "select a.*, concat(b.firstname, ' ', b.lastname) as fullname, b.blacklisted, c.key_value as gender
						FROM {$this->db->dbprefix}recruitment_process a
						LEFT JOIN {$this->db->dbprefix}recruitment b on b.recruit_id = a.recruit_id
						LEFT JOIN {$this->db->dbprefix}recruitment_request rr ON a.request_id = rr.request_id
						LEFT JOIN {$this->db->dbprefix}recruitment_personal c on c.recruit_id = a.recruit_id and c.key = 'gender'";
				if($is_interviewer){
					$qry .= " LEFT JOIN {$this->db->dbprefix}recruitment_request_approver rra on rra.request_id = a.request_id ";
				}
				$qry .= " WHERE a.status_id = {$_step->status_id} AND a.request_id = {$request_id} and a.deleted = 0";
				
				if($is_interviewer){ $qry .= " AND (rra.approver_id = ".$this->user->user_id. " OR rr.created_by = ".$this->user->user_id.") GROUP BY a.request_id";}

				$recruits = $this->db->query( $qry );

				foreach( $recruits->result() as $recruit )
				{
					$step[$_step->status_id]['recruit'][] = $recruit;	
				}	
			}
		}
		else{
			$mrf =  new stdClass();
			$mrf->position = lang('common.all') . " " . $year;

			foreach($_steps->result() as $_step)
			{
				$step[$_step->status_id]['step'] = $_step;
				$step[$_step->status_id]['is_interviewer'] = $is_interviewer;
				$step[$_step->status_id]['is_assigned'] = $is_assigned;
				$step[$_step->status_id]['recruit'] = array();

				$qry = "select a.*, concat(c.firstname, ' ', c.lastname) as fullname, c.blacklisted, d.key_value as gender 
						FROM {$this->db->dbprefix}recruitment_process a
						LEFT JOIN {$this->db->dbprefix}recruitment_request b ON b.request_id = a.request_id
						LEFT JOIN {$this->db->dbprefix}recruitment c on c.recruit_id = a.recruit_id
						LEFT JOIN {$this->db->dbprefix}recruitment_personal d on d.recruit_id = a.recruit_id and d.key = 'gender'";
				if($is_interviewer){ 
					$qry .= " LEFT JOIN {$this->db->dbprefix}recruitment_request_approver rra on rra.request_id = a.request_id";
				}
				
				$qry .= " WHERE a.status_id = {$_step->status_id} AND YEAR(b.created_on) = {$year} AND b.deleted = 0 AND a.deleted = 0 AND b.status_id <> 7";
                
                if($is_assigned){
                     $qry .= " AND b.hr_assigned={$user_id}";
                }
                
                if($is_interviewer){ $qry .= " AND (rra.approver_id = ".$this->user->user_id. " OR b.created_by = ".$this->user->user_id.") GROUP BY a.request_id"; }

                $qry .= " ORDER BY b.created_on ASC";
     
				$recruits = $this->db->query($qry);
						
				foreach( $recruits->result() as $recruit )
				{
					$step[$_step->status_id]['recruit'][] = $recruit;	
				}	
			}
		}

		$steps = "";
		foreach( $step as $status_id => $_step )
		{
			switch( $_step['step']->status_code ){
				case 'STEP-1':
					$steps .= $this->load->view('steps/step1', $_step, true);
					break;
				case 'STEP-2':
					$steps .= $this->load->view('steps/step2', $_step, true);
					break;
				case 'STEP-3':
					$steps .= $this->load->view('steps/step3', $_step, true);
					break;
				case 'STEP-4':
					$steps .= $this->load->view('steps/step4', $_step, true);
					break;
				case 'STEP-5':
					$steps .= $this->load->view('steps/step5', $_step, true);
					break;
				case 'STEP-6':
					$steps .= $this->load->view('steps/step6', $_step, true);
					break;
				case 'STEP-7':
					$steps .= $this->load->view('steps/step7', $_step, true);
					break;
				case 'STEP-8':
					$steps .= $this->load->view('steps/step8', $_step, true);
					break;					
			}
		}

		$this->response->header = $this->load->view('steps/header', array('mrf' => $mrf), true);
		$this->response->steps = $this->load->view('steps/steps', array('steps' => $steps), true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function get_schedule_form()
	{
		$this->_ajax_only();
		$vars['process_id'] = $process_id = $this->input->post('process_id');
		$this->db->limit(1);
		$vars['process'] = $process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		$this->db->limit(1);
		$vars['recruit'] = $recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
		
		$vars['position'] = "";
		$vars['phone'] = "";
		$vars['mobile'] = "";
		
		$this->load->model('applicants_model', 'recruit');
		$position = $this->recruit->get_recruitment_personal_value($process->recruit_id, 'position_sought');
		if(sizeof($position)>0)
		{
			$vars['position'] = $position[0]['key_value'];	
		}
		$phone = $this->recruit->get_recruitment_personal_value($process->recruit_id, 'phone');
		if(sizeof($phone)>0)
		{
			$vars['phone'] = $phone[0]['key_value'];	
		}
		$mobile = $this->recruit->get_recruitment_personal_value($process->recruit_id, 'mobile');
		if(sizeof($mobile)>0)
		{
			$vars['mobile'] = $mobile[0]['key_value'];	
		}

		$var['saved_scheds'] = $this->mod->get_scheds($process_id);

		$this->load->helper('form');
		$this->load->helper('file');
		$this->response->schedule_form = $this->load->view('forms/schedule', $vars, true);
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function save_bi(){
		$this->_ajax_only();

		$process_id = $this->input->post('process_id');
		$this->response->saved = false;

		$process_brackground_info = array(
				'process_id' => $process_id
			);
		
		$this->db->insert('recruitment_process_background', $process_brackground_info); 
		$rpb_id = $this->db->insert_id();

		$company = $this->input->post('company');
		$department = $this->input->post('department');
		$reference_person = $this->input->post('reference_person');
		$position = $this->input->post('position');
		$employment_status = $this->input->post('employment_status');
		$date_hired = $this->input->post('date_hired');
		$date_resigned = $this->input->post('date_resigned');
		$reason_for_leaving = $this->input->post('reason_for_leaving');
		$q1 = $this->input->post('q1');
		$q1_ans = $this->input->post('q1_ans');
		$q2 = $this->input->post('q2');
		$q3 = $this->input->post('q3');
		$q4_ans = $this->input->post('q4_ans');
		$q5 = $this->input->post('q5');
		$q5_ans = $this->input->post('q5_ans');
		$q6_ans = $this->input->post('q6_ans');
		$q7_ans = $this->input->post('q7_ans');
		$q8 = $this->input->post('q8');
		$q9_ans = $this->input->post('q9_ans');
		$q10 = $this->input->post('q10');
		$q11 = $this->input->post('q11');
		$q12 = $this->input->post('q12');

		$this->db->where('rpb_id',$rpb_id);
		$this->db->delete('recruitment_process_background_item'); 

		foreach( $position as $key => $val )
		{	
			$date_hired_val = '0000-00-00';
			if(strtotime($date_hired[$key])){
				$date_hired_val = date( 'Y-m-d', strtotime($date_hired[$key]) );				
			}
			$date_resigned_val = '0000-00-00';
			if(strtotime($date_resigned[$key])){
				$date_resigned_val = date( 'Y-m-d', strtotime($date_resigned[$key]) );				
			}	

			$process_brackground_info_item = array(
				'rpb_id' => $rpb_id,
				'company' => $company[$key],
				'department' => $department[$key],
				'reference_person' => $reference_person[$key],
				'position' => $val,
				'employment_status' => $employment_status[$key],
				'date_hired' => $date_hired_val,
				'date_resigned' => $date_resigned_val,
				'reason_for_leaving' => $reason_for_leaving[$key],
				'q1' => $q1[$key],
				'q1_ans' => $q1_ans[$key],
				'q2' => $q2[$key],
				'q3' => $q3[$key],
				'q4_ans' => $q4_ans[$key],
				'q5' => (isset($q5[$key]) ? $q5[$key] : ''),
				'q5_ans' => $q5_ans[$key],
				'q6_ans' => $q6_ans[$key],
				'q7_ans' => $q7_ans[$key],
				'q8' => $q8[$key],
				'q9_ans' => $q9_ans[$key],
				'q10' => $q10[$key],
				'q11' => $q11[$key],
				'q12' => $q12[$key],
			);

			$this->db->insert('recruitment_process_background_items', $process_brackground_info_item); 			
		}

		if( $this->db->_error_message() != "" )
		{
			$this->response->message[] = array(
				'message' => 'Unexpected error occured. Contact your system admin.',
				'type' => 'success'
			);

			$this->_ajax_return();	
		}

		$this->response->saved = true;
		$this->response->message[] = array(
			'message' => 'Success saving background investigation.',
			'type' => 'success'
		);

		$this->_ajax_return();	
	}

	function save_exam(){
		$this->_ajax_only();

		// echo "<pre>\n";
		// print_r($this->input->post());

		$process_id = $this->input->post('process_id');
		$exam_name = $this->input->post('exam_name');
		$date_taken = $this->input->post('date_taken');
		$score = $this->input->post('score');
		$status = $this->input->post('status');

		$this->response->saved = false;

		$details_where = array('process_id' => $process_id);
		$this->db->delete('recruitment_process_exam', $details_where);	

		$status_all = 1;
		foreach( $exam_name as $index => $exam )
		{
			$date = date( 'Y-m-d', strtotime($date_taken[$index]) );
			$insert = array(
				'process_id' => $process_id,
				'exam_name' => $exam,
				'date_taken' => $date,
				'score' => $score[$index],
				'status_id' => $status[$index]
			);
			$this->db->insert('recruitment_process_exam', $insert); 

			if ($status[$index] == 0){
				$status_all = false;
			}
		}

		if( $this->db->_error_message() != "" )
		{
			$this->response->message[] = array(
				'message' => 'Unexpected error occured. Contact your system admin.',
				'type' => 'success'
			);

			$this->_ajax_return();	
		}

		$this->response->saved = true;
		$this->response->message[] = array(
			'message' => 'Success saving exam results.',
			'type' => 'success'
		);

		if ($status_all){
			$update_data = array('status_id' => 3,
								'modified_by' => $this->user->user_id,
								'modified_on' => date('Y-m-d H:i:s')
								);

			$this->db->update('recruitment_process', $update_data, array('process_id' => $process_id));	

			$process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();

			$update_data = array('status_id' => 4, 
									'modified_by' => $this->user->user_id,
									'modified_on' => date('Y-m-d H:i:s')
								);
		//get previous data for audit logs
			$previous_main_data = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row_array();
			$this->db->update('recruitment', $update_data, array('recruit_id' => $process->recruit_id));
			//create system logs
			$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment_process_schedule', $previous_main_data, $update_data);			
		}

		$this->_ajax_return();	
	}

	function save_schedule()
	{
		$this->_ajax_only();

		$type = $this->input->post('type');
		$process_id = $this->input->post('process_id');
		$dates = $this->input->post('sched_date');
		$user_id = $this->input->post('sched_user_id');
		$location_id = $this->input->post('location_id');

		$this->response->saved = false;

		if($dates)
		{
			$validation = false;
			foreach( $dates as $index => $date )
			{
				if( empty($date) )
				{
					$this->response->message[] = array(
						'message' => 'Please fillup date.',
						'type' => 'warning'
					);	
					$validation = true;
				}

				if( empty($user_id[$index]) )
				{
					$this->response->message[] = array(
						'message' => 'Please choose an interviewer.',
						'type' => 'warning'
					);	
					$validation = true;
				}
				if($validation){
					$this->_ajax_return();	
				}
			}

			$this->db->limit(1);
			$process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
			$this->db->limit(1);
			$recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
			$this->load->model('system_feed');

			if ($process->status_id == 5){
				$this->db->where('type',2);
			}
			else{
				$this->db->where('type',1);
			}	
			$this->db->where('process_id',$process_id);			
			$this->db->update('recruitment_process_schedule', array('deleted'=>1));
			foreach( $dates as $index => $date )
			{
				$date = str_replace(' - ', " ", $date);
				$insert = array(
					'type' => $type,
					'process_id' => $process_id,
					'date' => date('Y-m-d H:i:s', strtotime( $date )),
					'user_id' => $user_id[$index],
					'location_id' => (isset($location_id[$index]) ? $location_id[$index] : '')
				);

				$this->db->limit(1);
				if ($process->status_id == 5){
					$this->db->where('type',2);
				}
				else{
					$this->db->where('type',1);
				}				
				$this->db->where('process_id',$process_id);
				$this->db->where('user_id',$user_id[$index]);
				$check = $this->db->get('recruitment_process_schedule');

				if ($process->status_id == 5){
					$this->db->where('type',2);
				}
				else{
					$this->db->where('type',1);
				}

				$this->db->where('process_id',$process_id);
				$this->db->where('user_id',$user_id[$index]);				
				$this->db->update('recruitment_process_schedule', array('deleted'=>0));
				if( $check->num_rows() == 1 )
				{
					$sched = $check->row();
				//get previous data for audit logs
					$previous_main_data = $this->db->get_where('recruitment_process_schedule', array('schedule_id' => $sched->schedule_id))->row_array();
					$this->db->update('recruitment_process_schedule', $insert, array('schedule_id' => $sched->schedule_id));
					//create system logs
					$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment_process_schedule', $previous_main_data, $insert);
					
					if( $sched->status_id == 0 )
					{
						$feed = array(
	                        'status' => 'info',
	                        'message_type' => 'Personnel',
	                        'user_id' => $this->user->user_id,
	                        'feed_content' => 'Your scheduled interview for applicant '. $recruit->firstname .' '. $recruit->lastname.' on '.date('F d, Y - h:i a', strtotime( $date )) .' has been updated.',
	                        'uri' => $this->mod->route,
	                        'recipient_id' => $user_id[$index]
	                    );
	                    $recipients = array($user_id[$index]);
	                    $this->system_feed->add( $feed, $recipients );

	                    $this->response->notify[] = $user_id[$index];
					}
				}
				else{
					$this->db->insert('recruitment_process_schedule', $insert); 
					$schedule_id = $this->db->insert_id();
					//create system logs
					$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'recruitment_process_schedule', array(), $insert);
					
					$this->db->insert('recruitment_process_interview', array('schedule_id' => $schedule_id)); 
					//create system logs
					$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'recruitment_process_interview', array(), array('schedule_id' => $schedule_id));
					
					$feed = array(
                        'status' => 'info',
                        'message_type' => 'Personnel',
                        'user_id' => $this->user->user_id,
                        'feed_content' => 'You have a scheduled interview for applicant '.$recruit->firstname.' '.$recruit->lastname.' on '.date('F d, Y - h:i a', strtotime( $date )),
                        'uri' => $this->mod->route,
                        'recipient_id' => $user_id[$index]
                    );
                    $recipients = array($user_id[$index]);
                    $this->system_feed->add( $feed, $recipients );

                    $this->response->notify[] = $user_id[$index];
				}

				$this->send_email($user_id[$index],$process_id,1);
			}

			$this->response->saved = true;
			if( $process->status_id == 1 || $process->status_id == 5)
			{
				$update_data = array('status_id' => 2, 
										'modified_by' => $this->user->user_id,
										'modified_on' => date('Y-m-d H:i:s')
									);

				if ($process->status_id == 5){
					$update_data['from_seting_final_interview'] = 2;
				}

			//get previous data for audit logs
				$previous_main_data = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row_array();
				$this->db->update('recruitment_process', $update_data, array('process_id' => $process_id));				
				//create system logs
				$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment_process_schedule', $previous_main_data, $update_data);

			//get previous data for audit logs
				$previous_main_data = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row_array();
				$this->db->update('recruitment', $update_data, array('recruit_id' => $process->recruit_id));
				//create system logs
				$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment', $previous_main_data, $update_data);

				if ($process->status_id == 1){
					$this->db->limit(1);
					$requests = $this->db->get_where('recruitment_request', array('request_id' => $process->request_id))->row();
					$this->db->limit(1);
					$positions = $this->db->get_where('users_position', array('position_id' => $requests->position_id))->row();
					$feed = array(
	                    'status' => 'info',
	                    'message_type' => 'Personnel',
	                    'user_id' => $this->user->user_id,
	                    'feed_content' => $recruit->firstname.' '.$recruit->lastname.' for '.$positions->position.' was moved to HR evaluation.',
	                    'uri' => $this->mod->route,
	                    'recipient_id' => $requests->user_id
	                );
	                $recipients = array($requests->user_id);
	                $this->system_feed->add( $feed, $recipients );

	                $this->response->notify[] = $requests->user_id;
	            }
			}
		}
		else{
			$this->response->message[] = array(
				'message' => 'No inteview schedules set.',
				'type' => 'warning'
			);	
			$this->_ajax_return();		
		}

		$this->response->message[] = array(
			'message' => 'Success saving interview schedules!',
			'type' => 'success'
		);
		$this->_ajax_return();	
	}

	function get_interview_list()
	{
		$this->_ajax_only();
		
		$user_id = $this->config->config['user']['user_id'];
        $permission = $this->config->item('permission');
        $vars['is_assigned'] = isset($permission[$this->mod->mod_code]['process']) ? $permission[$this->mod->mod_code]['process'] : 0;
        $vars['is_interviewer'] = $this->mod->is_interviewer();
        $vars['login_user'] = $user_id;

		$vars['process_id'] = $process_id = $this->input->post('process_id');
		$this->db->limit(1);
		$vars['process'] = $process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		$this->db->limit(1);
		$vars['recruit'] = $recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
		
		$vars['position'] = "";
		$vars['phone'] = "";
		$vars['mobile'] = "";
		
		$this->load->model('applicants_model', 'recruit');
		$position = $this->recruit->get_recruitment_personal_value($process->recruit_id, 'position_sought');
		if(sizeof($position)>0)
		{
			$vars['position'] = $position[0]['key_value'];	
		}
		$phone = $this->recruit->get_recruitment_personal_value($process->recruit_id, 'phone');
		if(sizeof($phone)>0)
		{
			$vars['phone'] = $phone[0]['key_value'];	
		}
		$mobile = $this->recruit->get_recruitment_personal_value($process->recruit_id, 'mobile');
		if(sizeof($mobile)>0)
		{
			$vars['mobile'] = $mobile[0]['key_value'];	
		}

		$vars['saved_scheds'] = $this->mod->get_scheds($process_id);

		$vars['exams'] = $this->mod->get_exams($process_id);

		$vars['bis'] = $this->mod->get_backgrounds($process_id);

		$vars['request'] = $this->mod->get_request($process->request_id);

		$vars['bi'] = $this->mod->get_bi($process_id);

		$userinfo_qry = $this->db->get_where('users',array('user_id' => $this->user->user_id));

		$vars['userinfo'] = $userinfo_qry->row();

			// echo "<pre>\n";
			// print_r($vars);
		$this->load->helper('form');
		$this->load->helper('file');
		
		$this->response->interview_list = $this->load->view('forms/interview_list', $vars, true);
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function get_interview_list_only()
	{
		$this->_ajax_only();
		
		$user_id = $this->config->config['user']['user_id'];
        $permission = $this->config->item('permission');
        $vars['is_assigned'] = isset($permission[$this->mod->mod_code]['process']) ? $permission[$this->mod->mod_code]['process'] : 0;
        $vars['is_interviewer'] = $this->mod->is_interviewer();
        $vars['login_user'] = $user_id;

		$vars['process_id'] = $process_id = $this->input->post('process_id');
		$this->db->limit(1);
		$vars['process'] = $process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		$this->db->limit(1);
		$vars['recruit'] = $recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
		
		$vars['saved_scheds'] = $this->mod->get_scheds($process_id);

		$vars['exams'] = $this->mod->get_exams($process_id);

		$vars['bis'] = $this->mod->get_backgrounds($process_id);

		$vars['request'] = $this->mod->get_request($process->request_id);

		$vars['bi'] = $this->mod->get_bi($process_id);

		$userinfo_qry = $this->db->get_where('users',array('user_id' => $this->user->user_id));

		$vars['userinfo'] = $userinfo_qry->row();		
			// echo "<pre>\n";
			// print_r($vars);
		$this->load->helper('form');
		$this->load->helper('file');
		
		$this->response->interview_list = $this->load->view('forms/interview_list_only', $vars, true);
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function add_prev_work_row()
	{
		$this->_ajax_only();

		$vars['process_id'] = '';

		$this->load->helper('form');
		$this->response->bi_form = $this->load->view('forms/bi_forms_template', $vars, true);
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function get_interview_form()
	{
		$this->_ajax_only();
		$vars['schedule_id'] = $schedule_id = $this->input->post('schedule_id');
		$vars['sched'] = $sched = $this->mod->get_sched( $schedule_id );
		$this->db->limit(1);
		$vars['interview'] = $this->db->get_where('recruitment_process_interview', array('schedule_id' => $schedule_id))->row();
		
		$qry = "select a.*, concat(b.firstname, ' ', b.lastname) as fullname, up.position, ud.department
		FROM {$this->db->dbprefix}recruitment_process a
		LEFT JOIN {$this->db->dbprefix}recruitment b on b.recruit_id = a.recruit_id
        LEFT JOIN {$this->db->dbprefix}recruitment_request rr on rr.request_id = a.request_id
        LEFT JOIN {$this->db->dbprefix}users_position up on up.position_id = rr.position_id
        LEFT JOIN {$this->db->dbprefix}users_department ud on ud.department_id = rr.department_id
		WHERE a.process_id = {$sched->process_id} LIMIT 1";
		$vars['recruit'] = $this->db->query( $qry )->row();

		$interviewKeyClass_sql = "SELECT * FROM {$this->db->dbprefix}recruitment_interview_key_class 
								WHERE deleted = 0 
								ORDER BY sort_order
								";
		$interviewKeyClass = $this->db->query( $interviewKeyClass_sql )->result_array();
		foreach($interviewKeyClass as $data){
			$keys[$data['key_class_id']]['key_class'] = $data['key_class'];
			$keys[$data['key_class_id']]['header_text'] = $data['header_text'];
			$keys[$data['key_class_id']]['layout'] = $data['layout'];
			$keys[$data['key_class_id']]['layout_custom_file'] = $data['layout_custom_file'];
			$keys[$data['key_class_id']]['other_remarks'] = $data['other_remarks'];

			$interviewKeys_sql = "SELECT * FROM {$this->db->dbprefix}recruitment_interview_key 
									WHERE deleted = 0 AND key_class_id = {$data['key_class_id']} 
									ORDER BY sort_order";
			$interviewKeys = $this->db->query( $interviewKeys_sql )->result_array();
				$keys[$data['key_class_id']]['keys'] = $interviewKeys;
		}

		$vars['details'] = $keys;

		$prf_jd = '';
		$prf_job_description_result = $this->db->get_where('recruitment_request_details',array('request_id' => $vars['recruit']->request_id, 'key_id' => 12));
		if ($prf_job_description_result && $prf_job_description_result->result() > 0){
			$prf_jd = $prf_job_description_result->row()->key_value;
		}
		$vars['prf_jd_details'] = $prf_jd;

		$this->db->where('schedule_id',$schedule_id);
		$this->db->join('users','recruitment_process_schedule.user_id = users.user_id');
		$vars['schedule'] = $this->db->get('recruitment_process_schedule')->row();

		$this->db->where('schedule_id',$schedule_id);
		$vars['attachement'] = $this->db->get('recruitment_interview_attachment');

		// for hrd manager
		$userinfo_qry = $this->db->get_where('users',array('user_id' => $this->user->user_id));

		$userinfo = $userinfo_qry->row();

	    $hrd_manager = $this->mod->get_role_permission(4); //hrd manager
	    $vars['edit_remarks'] = false;
	    if (in_array($userinfo->role_id,$hrd_manager) || $userinfo->user_id == 38){
	        $vars['edit_remarks'] = true;
	    }

		$this->load->helper('form');
		$this->response->interview_form = $this->load->view('forms/interview', $vars, true);
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function view_interview_result()
	{
		$this->_ajax_only();
		$vars['schedule_id'] = $schedule_id = $this->input->post('schedule_id');
		$vars['sched'] = $sched = $this->mod->get_sched( $schedule_id );
		$this->db->limit(1);
		$vars['interview'] = $this->db->get_where('recruitment_process_interview', array('schedule_id' => $schedule_id))->row();
		
		$qry = "select a.*, concat(b.firstname, ' ', b.lastname) as fullname, up.position, ud.department
		FROM {$this->db->dbprefix}recruitment_process a
		LEFT JOIN {$this->db->dbprefix}recruitment b on b.recruit_id = a.recruit_id
        LEFT JOIN {$this->db->dbprefix}recruitment_request rr on rr.request_id = a.request_id
        LEFT JOIN {$this->db->dbprefix}users_position up on up.position_id = rr.position_id
        LEFT JOIN {$this->db->dbprefix}users_department ud on ud.department_id = rr.department_id
		WHERE a.process_id = {$sched->process_id} LIMIT 1";
		$vars['recruit'] = $this->db->query( $qry )->row();

		$interviewKeyClass_sql = "SELECT * FROM {$this->db->dbprefix}recruitment_interview_key_class 
								WHERE deleted = 0 
								ORDER BY sort_order
								";
		$interviewKeyClass = $this->db->query( $interviewKeyClass_sql )->result_array();
		foreach($interviewKeyClass as $data){
			$keys[$data['key_class_id']]['key_class'] = $data['key_class'];
			$keys[$data['key_class_id']]['header_text'] = $data['header_text'];
			$keys[$data['key_class_id']]['layout'] = $data['layout'];
			$keys[$data['key_class_id']]['layout_custom_file'] = $data['layout_custom_file'];
			$keys[$data['key_class_id']]['other_remarks'] = $data['other_remarks'];

			$interviewKeys_sql = "SELECT * FROM {$this->db->dbprefix}recruitment_interview_key 
									WHERE deleted = 0 AND key_class_id = {$data['key_class_id']} 
									ORDER BY sort_order";
			$interviewKeys = $this->db->query( $interviewKeys_sql )->result_array();
				$keys[$data['key_class_id']]['keys'] = $interviewKeys;
		}

		$vars['details'] = $keys;

		$prf_jd = '';
		$prf_job_description_result = $this->db->get_where('recruitment_request_details',array('request_id' => $vars['recruit']->request_id, 'key_id' => 12));
		if ($prf_job_description_result && $prf_job_description_result->result() > 0){
			$prf_jd = $prf_job_description_result->row()->key_value;
		}
		$vars['prf_jd_details'] = $prf_jd;

		$this->db->where('schedule_id',$schedule_id);
		$this->db->join('users','recruitment_process_schedule.user_id = users.user_id');
		$vars['schedule'] = $this->db->get('recruitment_process_schedule')->row();

		$this->db->where('schedule_id',$schedule_id);
		$vars['attachement'] = $this->db->get('recruitment_interview_attachment');

		// for hrd manager
		$userinfo_qry = $this->db->get_where('users',array('user_id' => $this->user->user_id));

		$userinfo = $userinfo_qry->row();

	    $hrd_manager = $this->mod->get_role_permission(4); //hrd manager
	    $vars['edit_remarks'] = false;
	    if (in_array($userinfo->role_id,$hrd_manager) || $userinfo->user_id == 38){
	        $vars['edit_remarks'] = true;
	    }

		$this->load->helper('form');
		$this->response->interview_form = $this->load->view('forms/detail/interview', $vars, true);
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

    function download_file($upload_id){   
        $this->db->select("photo")
        ->from("recruitment_interview_attachment")
        ->where("recruitment_interview_attachment_id = {$upload_id}");

        $image_details = $this->db->get()->row_array();   
        $path = base_url() . $image_details['photo'];
        
        header('Content-disposition: attachment; filename='.substr( $image_details['photo'], strrpos( $image_details['photo'], '/' )+1 ).'');
        header('Content-type: txt/pdf');
        readfile($path);
    }   

	function save_interview()
	{
		$this->_ajax_only();

		$interview = $this->input->post('interview');
		$interview_details = $this->input->post('recruitment_interview_details');
		$interview_result = $interview_details['technical_recommendation']['key_value'];
		$this->response->process_id = $process_id = $this->input->post('process_id');
		$this->response->interview_reult = $interview_result;
		$this->response->status_id = $this->input->post('status_id');
		$status_id = $this->input->post('status_id');
		$interview_id = $this->input->post('interview_id');
		$applicant_monitoring_interview = $this->input->post('applicant_monitoring_interview');

		$attachement = (isset($applicant_monitoring_interview['photo']) ? $applicant_monitoring_interview['photo'] : array());
		$filename = (isset($applicant_monitoring_interview['filename']) ? $applicant_monitoring_interview['filename'] : array());
		$type = (isset($applicant_monitoring_interview['type']) ? $applicant_monitoring_interview['type'] : array());
		$size = (isset($applicant_monitoring_interview['size']) ? $applicant_monitoring_interview['size'] : array());

		$this->db->limit(1);
		$process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();

		$this->response->from_seting_final_interview = $process->from_seting_final_interview;

		// save movement attachement multiple
		if (!empty($attachement)){
			$this->db->where('schedule_id',$interview['schedule_id']);
			$this->db->delete('recruitment_interview_attachment');

			foreach ($attachement as $key => $value) {
				$info = array(
							'schedule_id' => $interview['schedule_id'],
							'process_id' => $process_id,
							'photo' => $value,
							'type' => $type[$key],
							'filename' => $filename[$key],
							'size' => $size[$key]
						);

				$this->db->insert('recruitment_interview_attachment',$info);
			}
		}

		$interview_update = array(
							'process_id' =>	$process_id,
							'modified_by' => $this->user->user_id,
							'modified_on' => date('Y-m-d H:i:s')
							);

		$userinfo_qry = $this->db->get_where('users',array('user_id' => $this->user->user_id));

		$userinfo = $userinfo_qry->row();

		if( $interview_result == 'Consider' || $interview_result == 'With Reservation' )
		{
			if( $interview_result == 'Consider' )
			{
				$interview_update['result_id'] = '8';
				$interview_update['result'] = 'Consider';
			}elseif( $interview_result == 'With Reservation' ){
				$interview_update['result_id'] = '3';
				$interview_update['result'] = 'With Reservation';
			}
			if( $status_id == 2 && ($interview_result == 'Consider'|| $interview_result == 'With Reservation'  ) )
			{
				$update_data = array('status_id' => 3,
									'modified_by' => $this->user->user_id,
									'modified_on' => date('Y-m-d H:i:s')
									);

				if ($process->from_seting_final_interview == 2){
					$update_data['status_id'] = 2;
				}
			//get previous data for audit logs
				$previous_main_data = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row_array();
				$this->db->update('recruitment_process', $update_data, array('process_id' => $process_id));		
				//create system logs
				$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment_process', $previous_main_data, $update_data);
			
			//get previous data for audit logs
				$previous_main_data = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row_array();
				$this->db->update('recruitment', $update_data, array('recruit_id' => $process->recruit_id));
				//create system logs
				$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment', $previous_main_data, $update_data);
				
				$this->load->model('system_feed');
				$recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
				$this->db->limit(1);
				$requests = $this->db->get_where('recruitment_request', array('request_id' => $process->request_id))->row();
				$this->db->limit(1);
				$positions = $this->db->get_where('users_position', array('position_id' => $requests->position_id))->row();
				$feed = array(
                    'status' => 'info',
                    'message_type' => 'Personnel',
                    'user_id' => $this->user->user_id,
                    'feed_content' => $recruit->firstname.' '.$recruit->lastname.' for '.$positions->position. ' was moved for interview.',
                    'uri' => $this->mod->route,
                    'recipient_id' => $requests->user_id
                );
                $recipients = array($requests->user_id);
                $this->system_feed->add( $feed, $recipients );

                $this->response->notify[] = $requests->user_id;

                if ($process->from_seting_final_interview == 2){
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
	                            'message_type' => 'Personnel',
	                            'user_id' => $this->user->user_id,
	                            'feed_content' => $userinfo->full_name .' has completed an interview for ' . $recruit->firstname.' '.$recruit->lastname,
	                            'uri' => $this->mod->route,
	                            'recipient_id' => $validator['user_id']
	                        );

	                        $recipients = array( $validator['user_id']);
	                        $this->system_feed->add( $feed, $recipients );
	                    
	                        $this->response->notify[] =  $validator['user_id'];
	                    }
	                }                	
                }
			}
		}
		else if( $interview_result == 'Reject' ){
			$this->db->limit(1);
			$recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
			$this->load->model('system_feed');
			$feed = array(
                'status' => 'info',
                'message_type' => 'Personnel',
                'user_id' => $this->user->user_id,
                'feed_content' => $recruit->firstname.' '.$recruit->lastname.' has rejected an interview.',
                'uri' => $this->mod->route,
                'recipient_id' => 1
            );
            $recipients = array(1);
            $this->system_feed->add( $feed, $recipients );

            $this->response->notify[] = 1;

            $interview_update['result_id'] = '10';
			$interview_update['result'] = 'Rejected';

            if ($process->from_seting_final_interview == 2){
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
                            'message_type' => 'Personnel',
                            'user_id' => $this->user->user_id,
                            'feed_content' => $userinfo->full_name .' has completed an interview for ' . $recruit->firstname.' '.$recruit->lastname,
                            'uri' => $this->mod->route,
                            'recipient_id' => $validator['user_id']
                        );

                        $recipients = array( $validator['user_id']);
                        $this->system_feed->add( $feed, $recipients );
                    
                        $this->response->notify[] =  $validator['user_id'];
                    }
                }                	
            }			
		}
		else if( $interview_result == 'Hold' ){
			$this->db->limit(1);
			$recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
			$this->load->model('system_feed');
			$feed = array(
                'status' => 'info',
                'message_type' => 'Personnel',
                'user_id' => $this->user->user_id,
                'feed_content' => $recruit->firstname.' '.$recruit->lastname.' has hold an interview.',
                'uri' => $this->mod->route,
                'recipient_id' => 1
            );
            $recipients = array(1);
            $this->system_feed->add( $feed, $recipients );

            $this->response->notify[] = 1;

            $interview_update['result_id'] = '9';
			$interview_update['result'] = 'Hold';

            if ($process->from_seting_final_interview == 2){
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
                            'message_type' => 'Personnel',
                            'user_id' => $this->user->user_id,
                            'feed_content' => $userinfo->full_name .' has completed an interview for ' . $recruit->firstname.' '.$recruit->lastname,
                            'uri' => $this->mod->route,
                            'recipient_id' => $validator['user_id']
                        );

                        $recipients = array( $validator['user_id']);
                        $this->system_feed->add( $feed, $recipients );
                    
                        $this->response->notify[] =  $validator['user_id'];
                    }
                }                	
            }			
		}		
	//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment_process_interview', array('schedule_id' => $interview['schedule_id']))->row_array();
		$this->db->update('recruitment_process_interview', $interview_update, array('schedule_id' => $interview['schedule_id']));

		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment_process_interview', $previous_main_data, $interview_update);

		foreach($interview_details as $index => $keys){
			$key_details = $this->db->get_where('recruitment_interview_key', array('key_code' => $index))->row_array();			
			
			$details_where = array('key' => $index, 'interview_id' => $interview_id);
			$key_exist = $this->db->get_where('recruitment_interview_details', $details_where);	

			$records['interview_id'] = $interview_id;
			$records['key_id'] = $key_details['key_id'];
			$records['key'] = $key_details['key_code'];
			$records['sequence'] = 1;

			if(is_array($keys['key_value'])){
				$this->db->delete('recruitment_interview_details', $details_where);				
				//create system logs
				$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'delete', 'recruitment_interview_details - interview_id', array(), array('interview_id' => $interview_id));

				foreach($keys['key_value'] as $keyVal_index => $keyVal){
					$records['key_name'] = $keys['key_name'][$keyVal_index];
					$records['created_by'] = $this->user->user_id;
					$records['key_value'] = $keyVal;
					$records['sequence'] = $keyVal_index + 1;
					$this->db->insert('recruitment_interview_details', $records);
					//create system logs
					$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'recruitment_interview_details', array(), $records);
				}
			}else{
				$records['key_name'] = $key_details['key_label'];
				$records['key_value'] = $keys['key_value'];	
				$previous_main_data = array();			
				switch ($key_exist->num_rows()){
					case 0:
						$records['created_by'] = $this->user->user_id;
						$this->db->insert('recruitment_interview_details', $records);
						$action = "insert";
					break;
					case 1:
					//get previous data for audit logs
						$previous_main_data = $this->db->get_where('recruitment_interview_details', $details_where)->row_array();
						$records['modified_by'] = $this->user->user_id;
						$records['modified_on'] = date('Y-m-d H:i:s');
						$this->db->update('recruitment_interview_details', $records, $details_where);
						$action = "update";
					break;
				}
				//create system logs
				$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, $action, 'recruitment_interview_details', $previous_main_data, $records);
			}

			if(isset($keys['other_remarks'])){
				$previous_main_data = $this->db->get_where('recruitment_interview_details', $details_where)->row_array();
				$other_remarks['other_remarks'] = $keys['other_remarks'];
				$this->db->update('recruitment_interview_details', $other_remarks, $details_where);
				//create system logs
				$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment_interview_details', $previous_main_data, $other_remarks);
			}
		}

		$this->response->message[] = array(
			'message' => 'Results successfully saved.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function move_to_jo()
	{
		$this->_ajax_only();

		$result_id = $this->input->post('result_id');
		if($result_id == 0)
		{
			$this->response->pending = true;
			$this->response->message[] = array(
				'message' => 'Interview is not yet passed',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}	

		$process_id = $this->input->post('process_id');
		$this->db->limit(1);
		$process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		$update_data = array('status_id' => 6,
							'modified_by' => $this->user->user_id,
							'modified_on' => date('Y-m-d H:i:s')
							);
	//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row_array();
		$this->db->update('recruitment_process', $update_data, array('process_id' => $process_id));
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment_process', $previous_main_data, $update_data);

	//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row_array();
		$this->db->update('recruitment', $update_data, array('recruit_id' => $process->recruit_id));
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment', $previous_main_data, $update_data);
		
		$this->load->model('system_feed');
		$recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
		$this->db->limit(1);
		$requests = $this->db->get_where('recruitment_request', array('request_id' => $process->request_id))->row();
		$this->db->limit(1);
		$positions = $this->db->get_where('users_position', array('position_id' => $requests->position_id))->row();
		$feed = array(
            'status' => 'info',
            'message_type' => 'Personnel',
            'user_id' => $this->user->user_id,
            'feed_content' => $recruit->firstname.' '.$recruit->lastname.' for '.$positions->position.' was moved for job offer.',
            'uri' => $this->mod->route,
            'recipient_id' => $requests->user_id
        );
        $recipients = array($requests->user_id);
        $this->system_feed->add( $feed, $recipients );
        $this->response->notify[] = $requests->user_id;

		$this->response->message[] = array(
			'message' => 'Applicant successfully moved to Job Offer.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function move_to_exam()
	{
		$this->_ajax_only();

		$result_id = $this->input->post('result_id');

/*		if($result_id == 0)
		{
			$this->response->pending = true;
			$this->response->message[] = array(
				'message' => 'Interview is not yet passed',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}	*/

		$process_id = $this->input->post('process_id');
		$this->db->limit(1);
		$process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		$update_data = array('status_id' => 3,
							'modified_by' => $this->user->user_id,
							'modified_on' => date('Y-m-d H:i:s')
							);
	//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row_array();
		$this->db->update('recruitment_process', $update_data, array('process_id' => $process_id));
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment_process', $previous_main_data, $update_data);

	//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row_array();
		$this->db->update('recruitment', $update_data, array('recruit_id' => $process->recruit_id));
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment', $previous_main_data, $update_data);
		
		$this->load->model('system_feed');
		$recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
		$this->db->limit(1);
		$requests = $this->db->get_where('recruitment_request', array('request_id' => $process->request_id))->row();
		$this->db->limit(1);
		$positions = $this->db->get_where('users_position', array('position_id' => $requests->position_id))->row();
		$feed = array(
            'status' => 'info',
            'message_type' => 'Personnel',
            'user_id' => $this->user->user_id,
            'feed_content' => $recruit->firstname.' '.$recruit->lastname.' for '.$positions->position.' was moved for examinations.',
            'uri' => $this->mod->route,
            'recipient_id' => $requests->user_id
        );
        $recipients = array($requests->user_id);
        $this->system_feed->add( $feed, $recipients );
        $this->response->notify[] = $requests->user_id;

		$this->response->message[] = array(
			'message' => 'Applicant successfully moved to Examinations.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function move_to_bi()
	{
		$this->_ajax_only();

		$result_id = $this->input->post('result_id');
		if($result_id == 0)
		{
			$this->response->pending = true;
			$this->response->message[] = array(
				'message' => 'Examination is not yet passed',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}	

		$process_id = $this->input->post('process_id');
		$this->db->limit(1);
		$process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		$update_data = array('status_id' => 4,
							'modified_by' => $this->user->user_id,
							'modified_on' => date('Y-m-d H:i:s')
							);
	//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row_array();
		$this->db->update('recruitment_process', $update_data, array('process_id' => $process_id));
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment_process', $previous_main_data, $update_data);

	//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row_array();
		$this->db->update('recruitment', $update_data, array('recruit_id' => $process->recruit_id));
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment', $previous_main_data, $update_data);
		
		$this->load->model('system_feed');
		$recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
		$this->db->limit(1);
		$requests = $this->db->get_where('recruitment_request', array('request_id' => $process->request_id))->row();
		$this->db->limit(1);
		$positions = $this->db->get_where('users_position', array('position_id' => $requests->position_id))->row();
		$feed = array(
            'status' => 'info',
            'message_type' => 'Personnel',
            'user_id' => $this->user->user_id,
            'feed_content' => $recruit->firstname.' '.$recruit->lastname.' for '.$positions->position.' was moved for background investigation.',
            'uri' => $this->mod->route,
            'recipient_id' => $requests->user_id
        );
        $recipients = array($requests->user_id);
        $this->system_feed->add( $feed, $recipients );
        $this->response->notify[] = $requests->user_id;

		$this->response->message[] = array(
			'message' => 'Applicant successfully moved to Background Investigation.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function move_to_final_interview()
	{
		$this->_ajax_only();

		$process_id = $this->input->post('process_id');
		$this->db->limit(1);
		$process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		$update_data = array('status_id' => 5,
							'modified_by' => $this->user->user_id,
							'modified_on' => date('Y-m-d H:i:s')
							);
	//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row_array();
		$this->db->update('recruitment_process', $update_data, array('process_id' => $process_id));
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment_process', $previous_main_data, $update_data);

	//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row_array();
		$this->db->update('recruitment', $update_data, array('recruit_id' => $process->recruit_id));
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment', $previous_main_data, $update_data);
		
		$this->load->model('system_feed');
		$recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
		$this->db->limit(1);
		$requests = $this->db->get_where('recruitment_request', array('request_id' => $process->request_id))->row();
		$this->db->limit(1);
		$positions = $this->db->get_where('users_position', array('position_id' => $requests->position_id))->row();
		$feed = array(
            'status' => 'info',
            'message_type' => 'Personnel',
            'user_id' => $this->user->user_id,
            'feed_content' => $recruit->firstname.' '.$recruit->lastname.' for '.$positions->position.' was moved for final interview.',
            'uri' => $this->mod->route,
            'recipient_id' => $requests->user_id
        );
        $recipients = array($requests->user_id);
        $this->system_feed->add( $feed, $recipients );
        $this->response->notify[] = $requests->user_id;

		$this->response->message[] = array(
			'message' => 'Applicant successfully moved to Background Investigation.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function move_to_cs()
	{
		$this->_ajax_only();
		$this->response->moved = 0;

		$process_id = $this->input->post('process_id');

		$jo = $this->db->get_where('recruitment_process_offer', array('process_id' => $process_id));
		if($jo->num_rows() == 0){
			$this->response->message[] = array(
				'message' => 'Kindly save/update Job Offer details before moving to contract signing.',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}else{
			$jo_details = $jo->row_array();
			if($jo_details['accept_offer'] != 1){
				$this->response->message[] = array(
					'message' => 'Declined or unaccepted offer cannot be moved to contract signing.',
					'type' => 'warning'
				);
				$this->_ajax_return();
			}
		}

		$this->db->limit(1);
		$process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		$update_data = array('status_id' => 6,
							'modified_by' => $this->user->user_id,
							'modified_on' => date('Y-m-d H:i:s')
							);
	//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row_array();
		$this->db->update('recruitment_process', $update_data, array('process_id' => $process_id));
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment_process', $previous_main_data, $update_data);

	//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row_array();
		$this->db->update('recruitment', $update_data, array('recruit_id' => $process->recruit_id));
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment', $previous_main_data, $update_data);

		$this->db->limit(1);
		$check = $this->db->get_where('recruitment_process_signing', array('process_id' => $process_id));
		if( $check->num_rows() == 0 )
		{
			$rps_insert = array('process_id' => $process_id, 'accepted' => 1);
			$this->db->insert('recruitment_process_signing', $rps_insert);
			//create system logs
			$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'recruitment_process_signing', array(), $rps_insert);
		}

		$this->load->model('system_feed');
		$recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
		$this->db->limit(1);
		$requests = $this->db->get_where('recruitment_request', array('request_id' => $process->request_id))->row();
		$this->db->limit(1);
		$positions = $this->db->get_where('users_position', array('position_id' => $requests->position_id))->row();
		$feed = array(
            'status' => 'info',
            'message_type' => 'Personnel',
            'user_id' => $this->user->user_id,
            'feed_content' => $recruit->firstname.' '.$recruit->lastname.' for '.$positions->position.' was moved for contract signing.',
            'uri' => $this->mod->route,
            'recipient_id' => $requests->user_id
        );
        $recipients = array($requests->user_id);
        $this->system_feed->add( $feed, $recipients );
        $this->response->notify[] = $requests->user_id;

		$this->response->message[] = array(
			'message' => 'Applicant successfully moved to contract signing.',
			'type' => 'success'
		);
		$this->response->moved = 1;

		$this->_ajax_return();
	}

	function move_to_preemp()
	{
		$this->_ajax_only();

		$process_id = $this->input->post('process_id');
		$this->db->limit(1);
		$process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		$update_data = array('status_id' => 7,
							'modified_by' => $this->user->user_id,
							'modified_on' => date('Y-m-d H:i:s')
							);
	//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row_array();
		$this->db->update('recruitment_process', $update_data, array('process_id' => $process_id));
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment_process', $previous_main_data, $update_data);

	//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row_array();
		$this->db->update('recruitment', $update_data, array('recruit_id' => $process->recruit_id));
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment', $previous_main_data, $update_data);

		$this->load->model('system_feed');
		$recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
		$this->db->limit(1);
		$requests = $this->db->get_where('recruitment_request', array('request_id' => $process->request_id))->row();
		$this->db->limit(1);
		$positions = $this->db->get_where('users_position', array('position_id' => $requests->position_id))->row();
		$feed = array(
            'status' => 'info',
            'message_type' => 'Personnel',
            'user_id' => $this->user->user_id,
            'feed_content' => $recruit->firstname.' '.$recruit->lastname.' for '.$positions->position.' was moved to pre-employment.',
            'uri' => $this->mod->route,
            'recipient_id' => $requests->user_id
        );
        $recipients = array($requests->user_id);
        $this->system_feed->add( $feed, $recipients );
        $this->response->notify[] = $requests->user_id;

		$this->response->message[] = array(
			'message' => 'Applicant successfully moved to pre-employment',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function get_jo_template(){
		$this->load->library('parser');
		$this->parser->set_delimiters('{{', '}}');

		$jo_template_val = '';
		$jo_template_id = $this->input->post('jo_template_id');
		$process_id = $this->input->post('process_id');
		$recruit_id = $this->input->post('recruit_id');

		$this->db->select("CONCAT(title,' ',firstname,' ',lastname) as full_name,CONCAT(title,' ',lastname) as last_name",false);
		$applicant_result = $this->db->get_where('recruitment',array('recruit_id' => $recruit_id));

		if ($applicant_result && $applicant_result->num_rows() > 0){
			$applicant = $applicant_result->row();
		}

		$this->db->select("CONCAT(title,' ',firstname,' ',lastname) as full_name",false);
		$hrd_manager_result = $this->db->get_where('users_profile',array('position_id' => 380));

		if ($hrd_manager_result && $hrd_manager_result->num_rows() > 0){
			$hrd_manager = $hrd_manager_result->row();
		}

		$vars['cur_date'] = date('d F Y');
		$vars['applicant_full_name'] = $applicant->full_name;
		$vars['last_name'] = $applicant->last_name;
		$vars['hrd_manager'] = $hrd_manager->full_name;

		$result = $this->db->get_where('recruitment_process_offer_template',array('template_id' => $jo_template_id));
		if ($result && $result->num_rows() > 0){
			$jo_template_val_init = $result->row()->template;

			$jo_template_val = $this->parser->parse_string($jo_template_val_init, $vars, TRUE);
		}

		$this->response->jo_template = $jo_template_val;
		$this->_ajax_return();		
	}

	function get_jo_form()
	{
		$this->_ajax_only();
		$user_id = $this->config->config['user']['user_id'];
		$vars['process_id'] = $process_id = $this->input->post('process_id');
		$this->db->limit(1);
		$vars['process'] = $process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		$this->db->limit(1);
		$vars['recruit'] = $recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
		$vars['is_interviewer'] = $this->mod->is_interviewer();
		$vars['login_user'] = $user_id;
		$vars['position'] = "";
		$vars['phone'] = "";
		$vars['mobile'] = "";
		
		$this->load->model('applicants_model', 'recruit');
		$position = $this->recruit->get_recruitment_personal_value($process->recruit_id, 'position_sought');
		if(sizeof($position)>0)
		{
			$vars['position'] = $position[0]['key_value'];	
		}
		$phone = $this->recruit->get_recruitment_personal_value($process->recruit_id, 'phone');
		if(sizeof($phone)>0)
		{
			$vars['phone'] = $phone[0]['key_value'];	
		}
		$mobile = $this->recruit->get_recruitment_personal_value($process->recruit_id, 'mobile');
		if(sizeof($mobile)>0)
		{
			$vars['mobile'] = $mobile[0]['key_value'];	
		}

		$vars['saved_scheds'] = $this->mod->get_scheds($process_id);

		$vars['employment_status_id'] = '';
		$vars['no_months'] = '';
		$vars['template_id'] = '';
		$vars['reports_to'] = '';
		$vars['start_date'] = '';
		$vars['end_date'] = '';
		$vars['work_schedule'] = '';
		$vars['shift_id'] = '';
		$vars['lunch_break'] = '';
		$vars['accept_offer'] = 1;
		$vars['blacklisted'] = '';
		$this->db->limit(1);

		$jo = $this->db->get_where('recruitment_process_offer', array('process_id' => $process_id));
		if( $jo->num_rows() == 1 )
		{
			$jo = $jo->row_array();
			$vars = array_merge($vars, $jo);
		}

		$vars['blacklisted'] = $recruit->blacklisted;
		if(strtotime($vars['start_date'])){
			$vars['start_date'] = date('F d, Y', strtotime($vars['start_date']));
		}else{
			$vars['start_date'] = "";
		}
		if(strtotime($vars['end_date'])){
			$vars['end_date'] = date('F d, Y', strtotime($vars['end_date']));
		}else{
			$vars['end_date'] = "";
		}

		$vars['exams'] = $this->mod->get_exams($process_id);

		$vars['bis'] = $this->mod->get_backgrounds($process_id);

		$vars['request'] = $this->mod->get_request($process->request_id);

		$vars['bi'] = $this->mod->get_bi($process_id);		
// echo "<pre>\n";
// print_r($vars);
		$this->load->helper('form');
		$this->load->helper('file');
		$this->response->jo_form = $this->load->view('forms/jo_form', $vars, true);
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function save_jo()
	{
		$this->_ajax_only();

		$recruit_id = $this->input->post('recruit_id');
		$process_id = $this->input->post('process_id');
		$jo = $this->input->post('jo');
		
		$recruit = $this->input->post('recruitment');
		$validation = false;

		// if(in_array($jo['employment_status_id'], array(2,5,6))){
		// 	if(!$jo['no_months'] > 0){
		// 		$this->response->message[] = array(
		// 	    	'message' => 'No. of months is required.',
		// 	    	'type' => 'warning'
		// 		);
		// 		$validation = true;
		// 	}
		// }

		$required_fields = array("Reports To" => 'reports_to', 
			"Employee Status" => 'employment_status_id'/*, 
			"Work Schedule" => 'work_schedule'*/);

		foreach($required_fields as $index => $field){
			if(trim($jo[$field]) == ""){
				$this->response->message[] = array(
			    	'message' => "{$index} is required",
			    	'type' => 'warning'
				);
				$validation = true;
			}
		}
		if($validation){
			$this->_ajax_return();
		}

		$job_offer = $this->db->get_where('recruitment_process_offer', array('process_id' => $process_id));		
		$jo['process_id'] = $process_id;
		if(strtotime($jo['start_date'])){
			$jo['start_date'] = date('Y-m-d', strtotime($jo['start_date']));
		}else{
			$jo['start_date'] = '0000-00-00';
		}
		if(strtotime($jo['end_date'])){
			$jo['end_date'] = date('Y-m-d', strtotime($jo['end_date']));
		}else{
			$jo['end_date'] = '0000-00-00';
		}
		
		if($jo['accept_offer'] == 1){
			$recruit['blacklisted'] = '';
			$this->response->accepted = 1;
			$recruit['status_id'] = 6;
/*			$update_data = array('status_id' => 5,
								'modified_by' => $this->user->user_id,
								'modified_on' => date('Y-m-d H:i:s')
								);

			$previous_main_data = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row_array();
			$this->db->update('recruitment_process', $update_data, array('process_id' => $process_id));	*/			
		}else{//declined job offer
			$recruit['status_id'] = 8;
			$this->response->accepted = 0;

			$applicant	= $this->db->get_where('recruitment', array('recruit_id' => $recruit_id));

			if ($applicant && $applicant->num_rows() > 0){
				$applicant_info = $applicant->row();

				$recruitment = $this->db->get_where('recruitment_process', array('process_id' => $process_id));

				$recipient = '';
				if ($recruitment && $recruitment->num_rows() > 0){
					$recruitment_process = $recruitment->row();

					$recruitment = $this->db->get_where('recruitment_request', array('request_id' => $recruitment_process->request_id));					

					if ($recruitment){
						$recruitment_request = $recruitment->row();

						$recipient = $recruitment_request->created_by;
					}
				}

				$this->load->model('system_feed');

				if ($recipient != ''){
					$feed = array(
		                'status' => 'info',
		                'message_type' => 'Personnel',
		                'user_id' => $this->user->user_id,
		                'feed_content' => 'Candidate '.$applicant_info->firstname.','.$applicant_info->lastname.' retract the job offer',
		                'uri' => $this->mod->route,
		                'recipient_id' => $recipient
		            );
		            $recipients = array($recipient);
		            $this->system_feed->add( $feed, $recipients );	
				}
			}		
		}

		$previous_main_data = array();
		if($job_offer->num_rows() == 0){
			$this->db->insert('recruitment_process_offer', $jo);
			$action = 'insert';
		}else{
		//get previous data for audit logs
			$previous_main_data = $this->db->get_where('recruitment_process_offer', array('process_id' => $process_id))->row_array();
			$this->db->update('recruitment_process_offer', $jo, array('process_id' => $process_id));
			$action = 'update';
		}
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, $action, 'recruitment_process_offer', $previous_main_data, $jo);

	//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment', array('recruit_id' => $recruit_id))->row_array();
		$this->db->update('recruitment', $recruit, array('recruit_id' => $recruit_id));
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment', $previous_main_data, $recruit);

		$this->db->delete('recruitment_process_offer_compben', array('process_id' => $process_id));
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'delete', 'recruitment_process_offer_compben - process_id', array(), array('process_id' => $process_id));

		$compben = $this->input->post('compben');
		$benefit = isset( $compben['benefit_id'] ) ? $compben['benefit_id'] : false;
		$permanent = isset( $compben['permanent'] ) ? $compben['permanent'] : false;
		$amount = isset( $compben['amount'] ) ? str_replace(',','',$compben['amount']) : false;
		$rate = isset( $compben['rate_id'] ) ? $compben['rate_id'] : false;

		if( $benefit )
		{
			foreach($benefit as $index => $benefit_id)
			{
				$insert = array(
					'process_id' => $process_id,
					'benefit_id' => $benefit_id,
					'permanent' => $permanent[$index],
					'amount' => $amount[$index],
					'rate_id' => $rate[$index]
				);
				$this->db->insert('recruitment_process_offer_compben', $insert);
				//create system logs
				$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'recruitment_process_offer_compben', array(), $insert);
			}
		}

		$this->response->message[] = array(
			'message' => 'Job Offer details successfully saved/updated.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function save_cs()
	{
		$this->_ajax_only();
        
		$process_id = $this->input->post('process_id');
		$signing = $this->input->post('signing');
		$recruit = $this->input->post('recruitment');
		$recruit_id = $this->input->post('recruit_id');

        $validation_rules[] = 
            array(
                'field' => 'signing[template_id]',
                'label' => 'Template',
                'rules' => 'required'
                );

        if( sizeof( $validation_rules ) > 0 )
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

                $this->_ajax_return();
            }
        }

		if($signing['accepted'] == 1){
			$recruit['blacklisted'] = '';
			$this->response->signing_accepted = true;
		}		
	//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment_process_signing', array('process_id' => $process_id))->row_array();
		$this->db->update('recruitment_process_signing', $signing, array('process_id' => $process_id));
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment_process_signing', $previous_main_data, $signing);

	//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment', array('recruit_id' => $recruit_id))->row_array();
		$this->db->update('recruitment', $recruit, array('recruit_id' => $recruit_id));
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment', $previous_main_data, $recruit);

		$this->response->message[] = array(
			'message' => 'Contract signing details successfully saved/updated.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

    // ajax_export
    function ajax_export(){
        $process_id = $this->input->post('process_id');
        $template = $this->input->post('template');

        switch($template){
        	case 'jo':	//job offer
        		$filename = $this->mod->export_pdf_job_offer($process_id);
        	break;
        	case 'iaf':	//interview_assessment_form
        		$filename = $this->mod->export_pdf_interview_assessment_form($process_id);
        	break;
        	case 'ea':	//employment_agreement
        		$filename = $this->mod->export_pdf_employment_agreement($process_id);
        	break;
        	case 'bin':	//background_investigation_report
        		$filename = $this->mod->export_pdf_background_investigation_report($process_id);
        	break;
        	case 'jd':	//job_description
        		$filename = $this->mod->export_pdf_job_description($process_id);
        	break;
        	case 'nca':	//non-compete_agreement
        		$filename = $this->mod->export_pdf_non_compete_agreement($process_id);
        	break;
        	case 'nda':	//non-disclosure_agreement
        		$filename = $this->mod->export_pdf_non_disclosure_agreement($process_id);
        	break;
        	case 'pec':	//pre-employment_checklist
        		$filename = $this->mod->export_pdf_pre_employment_checklist($process_id);
        	break;

        }

        $this->response->message[] = array(
            'message' => 'Download file ready.',
            'type' => 'success'
        );

        $this->response->filename = $filename;
        $this->_ajax_return();
    }

    function add_candid(){
        $this->_ajax_only();

        $record = array();

		$this->load->model('recruitform_model', 'rec');
		$record['mrf'] = $this->mod->get_active_mrf_by_year();
		$record['mrf2'] = $this->mod->get_active_mrf_by_year();
		
         $key_sql = "SELECT * FROM {$this->db->dbprefix}recruitment_key pk 
                    LEFT JOIN {$this->db->dbprefix}recruitment_key_class pkc 
                    ON pk.key_class_id = pkc.key_class_id 
                    WHERE pk.deleted = 0";
        $key_qry = $this->db->query($key_sql);

        $recruitment_keys = $key_qry->result_array();
        $record['recruitment_keys'] = array();
        $record['recruitment_labels'] = array();
        foreach($recruitment_keys as $keys){
            $record['recruitment_keys'][] = $keys['key_code'];
            $record['recruitment_labels'][$keys['key_code']] = $keys['key_label'];
        }
        
        $this->load->vars($record);
		$this->load->helper('form');
		$this->load->helper('file');

        $data['title'] = 'Add Candidate';
        $data['content'] = $this->load->blade('forms.applicant')->with( $this->load->get_cached_vars() );



        $this->response->sign = $this->load->view('templates/modal', $data, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }


    function get_applicants(){
        $this->_ajax_only();
        $position = '';
        $position_result = $this->db->get_where('users_position',array('position' => $this->input->post('position')));
        if ($position_result && $position_result->num_rows() > 0){
        	$position = $position_result->row()->position;
        }

        $applicants =  $this->mod->get_applicants($this->input->post('position'));
        $this->response->applicants = '<option value="">Select..</option>';
        if(!empty($applicants)){
        	$this->response->applicants .= '<optgroup label="'.$position.'">';
        	foreach ($applicants as $key => $applicant) {
	        	$this->response->applicants .= '<option value="'.$applicant['recruit_id'].'" >'.$applicant['firstname'] .' '. $applicant['lastname'] .'</option>';
	        }	
	        $this->response->applicants .= '</optgroup>';
        }
        
        $applicants_other_position = $this->mod->get_applicants_oth_position();
        if(!empty($applicants_other_position)){
        	$this->response->applicants .= '<optgroup label="Other Position">';
        	foreach ($applicants_other_position as $key1 => $applicant_oth) {
	        	$this->response->applicants .= '<option value="'.$applicant_oth['recruit_id'].'" >'.$applicant_oth['firstname'] .' '. $applicant_oth['lastname'] .'</option>';
	        }	
	        $this->response->applicants .= '</optgroup>';        	
        }

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }

    function get_applicant_details()
    {
    	$this->_ajax_only();
    	
    	$personal = $this->db->get_where('recruitment_personal', array('recruit_id' => $this->input->post('recruit_id'), 'deleted' => 0));
    	$this->response->personal = $personal->result_array();

    	$this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();

    }

	function save_applicant(){
        $this->_ajax_only();
        if($_POST['recruitment_request']['applicant_type'] == 1){
        	$this->save_external();
        }else{
        	$this->save_internal();
        }
        // $this->_ajax_return();
	}

	function save_internal(){
		$this->response->invalid=false;
		$error = false;

		$data['user_id'] 		= $_POST['recruitment_request']['user_id'];
		$data['request_id'] 	= $_POST['recruitment']['request_id'];
		// $data['cover_letter'] 	= $this->input->post('cover_letter');
		$data['position'] 		= $_POST['recruitment_personal']['position_sought'];
		unset($_POST['recruitment_request']);
		unset($_POST['recruitment']);
		unset($_POST['recruitment_personal']);

		$users_details_qry = "SELECT upro.title, upro.suffix, upro.lastname, upro.firstname, 
							upro.middlename, upro.maidenname, upro.nickname, users.email, 
							upro.birth_date, upro.partner_id
							FROM {$this->db->dbprefix}users_profile upro
							LEFT JOIN {$this->db->dbprefix}users users 
							ON users.user_id = upro.user_id
							WHERE upro.user_id = {$data['user_id']} ";

		$users_details = $this->db->query($users_details_qry)->row_array();

		//recruitment table details
		$recruitment_data['recruitment']['recruitment_date'] = date('Y-m-d');
		$recruitment_data['recruitment']['title'] = $users_details['title']; 
		$recruitment_data['recruitment']['suffix'] = $users_details['suffix'];
		$recruitment_data['recruitment']['lastname'] = $users_details['lastname']; 
		$recruitment_data['recruitment']['firstname'] = $users_details['firstname'];
		$recruitment_data['recruitment']['middlename'] = $users_details['middlename']; 
		$recruitment_data['recruitment']['maidenname'] = $users_details['maidenname'];
		$recruitment_data['recruitment']['nickname'] = $users_details['nickname']; 
		$recruitment_data['recruitment']['email'] = $users_details['email'];
		$recruitment_data['recruitment']['birth_date'] = $users_details['birth_date']; 
		$recruitment_data['recruitment']['request_id'] = $data['request_id']; 
		$recruitment_data['recruitment']['partner_id'] = $users_details['partner_id']; 
		// $recruitment_data['recruitment']['cover_letter'] = $data['cover_letter']; 
	
        //SAVING START   
		$transactions = true;
		$this->partner_id = 0;
		if( $transactions )
		{
			$this->db->trans_begin();
		}

		$main_table = 'recruitment';
		$main_record = $recruitment_data['recruitment'];

		//add mandatory fields
		$main_record['created_by'] = $this->user->user_id;
		$this->db->insert($main_table, $main_record);
		if( $this->db->_error_message() == "" )
		{
			$this->recruit_id = $this->response->record_id = $this->record_id = $this->db->insert_id();
		}
		$this->response->action = 'insert';
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, $this->response->action, $main_table, array(), $main_record);
		
		if( $this->db->_error_message() != "" ){
			$this->response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
			$error = true;
			goto stop;
		}else{
			//additional keys
			$recruit_keys = array();
			$recruitKeys = array(
						'position_sought' 		=> $data['position'], 
						'currently_employed' 	=> 1
						//, 'cover_letter'			=> $data['cover_letter']
						);
			foreach($recruitKeys as $keys => $value){
				$key_details = $this->db->get_where('recruitment_key', array('deleted' => 0, 'key_code' => $keys))->row_array();
				if(count($key_details) > 0){
					$recruit_keys['recruit_id'] = $this->recruit_id;
					$recruit_keys['key_id'] = $key_details['key_id'];
					$recruit_keys['key'] = $key_details['key_code'];
					$recruit_keys['sequence'] = 1;
					$recruit_keys['key_name'] = $key_details['key_label'];
					$recruit_keys['key_value'] = $value;
					$recruit_keys['created_by'] = $this->user->user_id;

					$this->db->insert('recruitment_personal', $recruit_keys);							
					if( $this->db->_error_message() != "" ){
						$this->response->message[] = array(
							'message' => $this->db->_error_message(),
							'type' => 'error'
						);
						$error = true;
						goto stop;
					}
					//create system logs
					$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'recruitment_personal', array(), $recruit_keys);
				}
			}

			$recruit_personal_qry = "SELECT * 
									FROM {$this->db->dbprefix}partners_personal 
									WHERE partner_id = {$users_details['partner_id']}";
			$recruit_personal_details = $this->db->query($recruit_personal_qry)->result_array();
			
			foreach($recruit_personal_details as $data){
				$key_details = $this->db->get_where('recruitment_key', array('deleted' => 0, 'key_code' => $data['key']))->row_array();
				if(count($key_details) > 0){
					$recruit_keys['recruit_id'] = $this->recruit_id;
					$recruit_keys['key_id'] = $key_details['key_id'];
					$recruit_keys['key'] = $key_details['key_code'];
					$recruit_keys['sequence'] = $data['sequence'];
					$recruit_keys['key_name'] = $key_details['key_label'];
					$recruit_keys['key_value'] = $data['key_value'];
					$recruit_keys['created_by'] = $this->user->user_id;

					$this->db->insert('recruitment_personal', $recruit_keys);							
					if( $this->db->_error_message() != "" ){
						$this->response->message[] = array(
							'message' => $this->db->_error_message(),
							'type' => 'error'
						);
						$error = true;
						goto stop;
					}
					//create system logs
					$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'recruitment_personal', array(), $recruit_keys);
				}
			}

			$recruit_personal_history_qry = "SELECT * 
									FROM {$this->db->dbprefix}partners_personal_history 
									WHERE partner_id = {$users_details['partner_id']}";
			$recruit_personal_history_details = $this->db->query($recruit_personal_history_qry)->result_array();
			
			$recruit_keys = array();
			foreach($recruit_personal_history_details as $data){
				$key_details = $this->db->get_where('recruitment_key', array('deleted' => 0, 'key_code' => $data['key']))->row_array();
				if(count($key_details) > 0){
					$recruit_keys['recruit_id'] = $this->recruit_id;
					$recruit_keys['key_id'] = $key_details['key_id'];
					$recruit_keys['key'] = $key_details['key_code'];
					$recruit_keys['sequence'] = $data['sequence'];
					$recruit_keys['key_name'] = $key_details['key_label'];
					$recruit_keys['key_value'] = $data['key_value'];
					$recruit_keys['created_by'] = $this->user->user_id;

					$this->db->insert('recruitment_personal_history', $recruit_keys);							
					if( $this->db->_error_message() != "" ){
						$this->response->message[] = array(
							'message' => $this->db->_error_message(),
							'type' => 'error'
						);
						$error = true;
						goto stop;
					}
					//create system logs
					$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'recruitment_personal_history', array(), $recruit_keys);
				}
			}
		}

		if( $recruitment_data['recruitment']['request_id'] )
		{
			//check if exists in process
			$this->db->limit(1);
			$check = $this->db->get_where('recruitment_process', array('request_id' => $recruitment_data['recruitment']['request_id'], 'recruit_id' => $this->recruit_id ));
			if( $check->num_rows() == 0 )
			{
				$insert = array(
					'request_id' => $recruitment_data['recruitment']['request_id'], 
					'recruit_id' => $this->recruit_id, 
					'status_id' => 1,
					'created_by' => $this->user->user_id
				);
				$this->db->insert('recruitment_process', $insert);
				if( $this->db->_error_message() != "" ){
					$this->response->message[] = array(
						'message' => $this->db->_error_message(),
						'type' => 'error'
					);
					$error = true;
				}
				//create system logs
				$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'recruitment_process', array(), $insert);
			}
		}

		stop:
		if( true )
		{
			if( !$error ){
				$this->db->trans_commit();
			}
			else{
				 $this->db->trans_rollback();
			}
		}

		if( !$error  )
		{
			$this->response->message[] = array(
				'message' => 'Application successfully submitted.',
				'type' => 'success'
			);
		}

		$this->response->saved = !$error;
        $this->_ajax_return();

	}

	function save_external(){
		$this->load->model('applicants_model', 'app');

		$error = false;
		$post = $_POST;
		$this->response->record_id = $this->record_id = $this->recruit_id = $post['record_id'];
		unset( $post['record_id'] );
		$this->response->fgs_number = $post['fgs_number'];
        /***** START Form Validation (hard coded) *****/
		//table assignment (manual saving)
		$other_tables = array();
		$partners_personal = array();
		$validation_rules = array();
		$partners_personal_key = array();
		/*switch($post['fgs_number']){
			case 1:
			//General Tab
			//Application Tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment[lastname]',
				'label' => 'Last Name',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment[firstname]',
				'label' => 'First Name',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal[position_sought]',
				'label' => 'Position Sought',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal[how_hiring_heard]',
				'label' => 'How did you learn about HDI?',
				'rules' => 'required'
				);
			// $validation_rules[] = 
			// array(
			// 	'field' => 'recruitment_personal[desired_salary]',
			// 	'label' => 'Desired Salary',
			// 	'rules' => 'required'
			// 	);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal[resume]',
				'label' => 'Resume',
				'rules' => 'required'
				);

			// $partners_personal_table = "recruitment_personal";
			// $partners_personal_key = array('position_sought', 'desired_salary', 'salary_pay_mode', 'how_hiring_heard', 'resume');
			// $partners_personal = $post['recruitment_personal'];
			// break;
			// case 3:
			//Contacts Tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment[email]',
				'label' => 'Email Address',
				'rules' => 'required|valid_email'
				);
			// $validation_rules[] = 
			// array(
			// 	'field' => 'recruitment_personal[phone]',
			// 	'label' => 'Phone',
			// 	'rules' => 'required'
			// 	);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal[mobile]',
				'label' => 'Mobile Phone',
				'rules' => 'required'
				);
			$partners_personal_table = "recruitment_personal";
			$partners_personal_key = array('phone', 'mobile', 'position_sought', 'how_hiring_heard', 'sourcing_free_sites', 'resume');
			$partners_personal = $post['recruitment_personal'];

			$partner_phone = $_POST['recruitment_personal']['phone'];
			$partner_mobile = $_POST['recruitment_personal']['mobile'];

			unset($partners_personal['mobile']);
			foreach ($partner_mobile as $phone){
				$mobile = $this->check_mobile($phone);
				if(!empty($phone)){
					if(!$mobile){
						$this->response->invalid=true;
						$this->response->invalid_message='Invalid mobile number';
						$this->response->message[] = array(
					    	'message' => 'Invalid mobile number',
					    	'type' => 'warning'
						);
		        		$this->_ajax_return();
		        	}else{
		        		$partners_personal['mobile'][] = $mobile;
		        	}
		        }
			}
        	if(!isset($partners_personal['mobile'])){
        		$partners_personal['mobile'] = array();
        	}
			unset($partners_personal['phone']);
			foreach ($partner_phone as $phone){
				$mobile = $this->check_phone($phone);
				if(!empty($phone)){
					if(!$mobile){
						$this->response->invalid=true;
						$this->response->invalid_message='Invalid phone number';
						$this->response->message[] = array(
					    	'message' => 'Invalid phone number',
					    	'type' => 'warning'
						);
		        		$this->_ajax_return();
		        	}else{
		        		$partners_personal['phone'][] = $mobile;
		        	}
		        }
			}
        	if(!isset($partners_personal['phone'])){
        		$partners_personal['phone'] = array();
        	}
			break;

		}*/
        $partners_personal_table = "recruitment_personal";
        $partners_personal_key = array('phone', 'mobile', 'position_sought', 'how_hiring_heard', 'sourcing_free_sites', 'resume');
        $partners_personal = $post['recruitment_personal'];
		
		$validation_rules[] = 
			array(
				'field' => 'recruitment_personal[position_sought]',
				'label' => 'Position Sought',
				'rules' => 'required'
				);

		$validation_rules[] = 
			array(
				'field' => 'recruitment[recruit_id]',
				'label' => 'Applicant',
				'rules' => 'required'
				);

		if( sizeof( $validation_rules ) > 0 )
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

				$this->_ajax_return();
			}
		}
        /***** END Form Validation (hard coded) *****/

        //SAVING START   
		$transactions = true;
		// $this->recruit_id = 0;
		if( $transactions )
		{
			$this->db->trans_begin();
		}

		//start saving with main table
		if(array_key_exists($this->app->table, $post)){			
			$main_record = $post[$this->app->table];
			$this->record_id = $this->recruit_id = $main_record['recruit_id'];
			$record = $this->db->get_where( $this->app->table, array( $this->app->primary_key => $this->record_id ) );
			$previous_main_data = array();
			switch( true )
			{
				/*case $record->num_rows() == 0:
					//add mandatory fields
					if( !$this->session->userdata('user') ) {
						$main_record['created_by'] =  '';
					}else{
						$this->user = $this->session->userdata('user');
						$main_record['created_by'] =  $this->user->user_id;
					} 
					$main_record['recruitment_date'] = date('Y-m-d');

					$this->db->insert($this->app->table, $main_record);
					if( $this->db->_error_message() == "" )
					{
						$this->recruit_id = $this->response->record_id = $this->record_id = $this->db->insert_id();
						// $partners_add['user_id'] = $this->record_id;
						// $this->db->insert('partners', $partners_add);
						// $this->recruit_id = $this->db->insert_id();
					}
					$this->response->action = 'insert';
				break;*/
				case $record->num_rows() == 1:
					if( !$this->session->userdata('user') ) {
						$main_record['modified_by'] =  '';
					}else{
						$this->user = $this->session->userdata('user');
						$main_record['modified_by'] =  $this->user->user_id;
					} 
					$main_record['modified_on'] = date('Y-m-d H:i:s');
					$main_record['status_id'] = 1;
					//get previous data for audit logs
					$previous_main_data = $this->db->get_where($this->app->table, array($this->app->primary_key => $this->record_id))->row_array();
					$this->db->update( $this->app->table, $main_record, array( $this->app->primary_key => $this->record_id ) );
					$this->response->action = 'update';
				break;
				default:
					$this->response->message[] = array(
						'message' => lang('common.inconsistent_data'),
						'type' => 'error'
					);
					$error = true;
					goto stop;
			}

			if( $this->db->_error_message() != "" ){
				$this->response->message[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
				$error = true;
				goto stop;
			}
			//create system logs
			$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, $this->response->action, $this->app->table, $previous_main_data, $main_record);
		}

		//personal profile
		if(count($partners_personal_key) > 0){
			// $this->load->model('my201_model', 'profile_mod');
			$sequence = 1;
			$post['fgs_number'];
			$accountabilities_attachments = array(12,13);
			$current_sequence = array_key_exists('sequence', $post) ? $post['sequence'] : 0;
			foreach( $partners_personal_key as $table => $key )
			{
                if(array_key_exists($key, $partners_personal)) {
    				if(!is_array($partners_personal[$key])){
    					$record = $this->app->get_recruitment_personal($this->record_id , $partners_personal_table, $key, $current_sequence);
    					if(in_array($post['fgs_number'], $accountabilities_attachments) && $current_sequence == 0) //insert to personal history
    					{
    						$sequence = count($record) + 1;
    						$record = array();
    					}
    					$data_personal = array('key_value' => $partners_personal[$key]);
    					$previous_main_data = array();
    					switch( true )
    					{
    						case count($record) == 0:
    							$data_personal = $this->app->insert_recruitment_personal($this->record_id, $key, $partners_personal[$key], $sequence, $this->recruit_id);
    							$this->db->insert($partners_personal_table, $data_personal);
    							// $this->record_id = $this->db->insert_id();
    							$action = 'insert';
    							break;
    						case count($record) == 1:
    							$recruit_id = $this->recruit_id;
    							$where_array = in_array($post['fgs_number'], $accountabilities_attachments) ? array( 'recruit_id' => $recruit_id, 'key' => $key, 'sequence' => $current_sequence ) : array( 'recruit_id' => $recruit_id, 'key' => $key );
    						//get previous data for audit logs
    							$previous_main_data = $this->db->get_where($partners_personal_table, $where_array)->row_array();
    							$this->db->update( $partners_personal_table, $data_personal, $where_array );
    							$action = 'update';
    							break;
    						default:
    							$this->response->message[] = array(
    								'message' => lang('common.inconsistent_data'),
    								'type' => 'error'
    							);
    							$error = true;
    							goto stop;
    					}

    					if( $this->db->_error_message() != "" ){
    						$this->response->message[] = array(
    							'message' => $this->db->_error_message(),
    							'type' => 'error'
    						);
    						$error = true;
    					}
    					//create system logs
    					$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, $action, $partners_personal_table, $previous_main_data, $data_personal);
    				}else{
    					$sequence = 1;
    					$recruit_id = $this->recruit_id;
    					$this->db->delete($partners_personal_table, array( 'recruit_id' => $recruit_id, 'key' => $key ));					
    					//create system logs
    					$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'delete', "$partners_personal_table - recruit_id", array(), array('recruit_id' => $recruit_id));
    					
    					foreach( $partners_personal[$key] as $table => $data_personal )
    					{	
    						$data_personal = $this->app->insert_recruitment_personal($this->record_id, $key, $data_personal, $sequence, $this->recruit_id);
    						$this->db->insert($partners_personal_table, $data_personal);

    						if( $this->db->_error_message() != "" ){
    							$this->response->message[] = array(
    								'message' => $this->db->_error_message(),
    								'type' => 'error'
    							);
    							$error = true;
    						}	
    						$sequence++;
    						//create system logs
    						$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', $partners_personal_table, array(), $data_personal);
    					}

    				}
                }
			}
		}

		if( $main_record['request_id'] )
		{
			//check if exists in process
			$this->db->limit(1);
			$check = $this->db->get_where('recruitment_process', array('request_id' => $main_record['request_id'], 'recruit_id' => $this->recruit_id ));
			if( $check->num_rows() == 0 )
			{
				$insert = array(
					'request_id' => $main_record['request_id'], 
					'recruit_id' => $this->recruit_id, 
					'status_id' => 1,
					'created_by' => $this->user->user_id
				);
				$this->db->insert('recruitment_process', $insert);

				if( $this->db->_error_message() != "" ){
					$this->response->message[] = array(
						'message' => $this->db->_error_message(),
						'type' => 'error'
					);
					$error = true;
				}
				//create system logs
				$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'recruitment_process', array(), $insert);
			}
		}

		stop:
		if( $transactions )
		{
			if( !$error ){
				$this->db->trans_commit();
			}
			else{
				 $this->db->trans_rollback();
			}
		}

		if( !$error  )
		{
			$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
		}

		$this->response->saved = !$error;

        $this->_ajax_return();
	}
        
    function get_cs_form()
	{
		$this->_ajax_only();
		$vars['process_id'] = $process_id = $this->input->post('process_id');
		$this->db->limit(1);
		$vars['process'] = $process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		$this->db->limit(1);
		$vars['recruit'] = $recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
		$vars['is_interviewer'] = $this->mod->is_interviewer();

		$vars['position'] = "";
		$vars['phone'] = "";
		$vars['mobile'] = "";
		
		$this->load->model('applicants_model', 'recruit');
		$position = $this->recruit->get_recruitment_personal_value($process->recruit_id, 'position_sought');
		if(sizeof($position)>0)
		{
			$vars['position'] = $position[0]['key_value'];	
		}
		$phone = $this->recruit->get_recruitment_personal_value($process->recruit_id, 'phone');
		if(sizeof($phone)>0)
		{
			$vars['phone'] = $phone[0]['key_value'];	
		}
		$mobile = $this->recruit->get_recruitment_personal_value($process->recruit_id, 'mobile');
		if(sizeof($mobile)>0)
		{
			$vars['mobile'] = $mobile[0]['key_value'];	
		}

		$vars['saved_scheds'] = $this->mod->get_scheds($process_id);
		$vars['blacklisted'] = '';
		
		$this->db->limit(1);
		$jo = $this->db->get_where('recruitment_process_offer', array('process_id' => $process_id));
		if( $jo->num_rows() == 1 )
		{
			$jo = $jo->row_array();
			$vars = array_merge($vars, $jo);
		}

		$this->db->limit(1);
		$cs = $this->db->get_where('recruitment_process_signing', array('process_id' => $process_id));
		$vars['template_id'] = '';
		$vars['signing_accepted'] = '1';

		if( $cs->num_rows() == 1 )
		{
			$cs = $cs->row();
			$vars['template_id'] = $cs->template_id;
			$vars['signing_accepted'] = $cs->accepted;
			$vars['signing_already'] = true;
		}
		$vars['blacklisted'] = $recruit->blacklisted;

		$vars['exams'] = $this->mod->get_exams($process_id);

		$vars['bis'] = $this->mod->get_backgrounds($process_id);
		// echo "<pre>\n";
		// print_r($vars);
		$this->load->helper('form');
		$this->load->helper('file');
		$this->response->cs_form = $this->load->view('forms/cs_form', $vars, true);
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

    function check_mobile($phoneNum=0){ 	
		$mobileNumber = trim(str_replace(' ', '', $phoneNum));
		$mobileNumber =  str_replace('-', '', $mobileNumber);

		if(!empty($mobileNumber)){
			if ((substr($mobileNumber,0,1) != 0) && strlen($mobileNumber) < 11){
				$mobileNumber = '0'.$mobileNumber;
			}	
			$output = preg_replace( '/(0|\+?\d{2})(\d{9,10})/', '0$2', $mobileNumber);

			preg_match( '/(0|\+?\d{2})(\d{9,10})/', $mobileNumber, $matches);

			if(isset($matches[1]) && isset($matches[2])){
				$mobile_prefix = substr($matches[2], 0, 2);
				if($matches[2] != $output || $mobile_prefix == 00){
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}

		return '+63'.$matches[2];
    }

    function check_phone($phoneNum=0){
		$mobileNumber = trim(str_replace(' ', '', $phoneNum));
		$mobileNumber =  str_replace('-', '', $mobileNumber);

		if(!empty($mobileNumber)){
			if ((substr($mobileNumber,0,1) != 0) && strlen($mobileNumber) < 9){
				$mobileNumber = '0'.$mobileNumber;
			}	

			$output = preg_replace( '/(0|\+?\d{2})(\d{8})/', '0$2', $mobileNumber);
			preg_match( '/(0|\+?\d{2})(\d{8})/', $mobileNumber, $matches);

			if(isset($matches[1]) && isset($matches[2])){
				$mobile_prefix = substr($matches[2], 0, 2);
				if('0'.$matches[2] != $output || $mobile_prefix == 00){
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}

		return '+63'.$matches[2];
    }

	function add_item() {
		$this->_ajax_only();
		$data = array();

		$data['header_text'] = $this->input->post('header_text');
		$data['key_code'] = $this->input->post('key_code');
		$this->load->helper('form');
		$this->load->helper('file');
		$this->response->add_item = $this->load->view('forms/sub/add_item', $data, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();
	}

	function add_item_remarks() {
		$this->_ajax_only();
		$data = array();

		$data['header_text'] = $this->input->post('header_text');
		$data['key_code'] = $this->input->post('key_code');
		$this->load->helper('form');
		$this->load->helper('file');
		$this->response->add_item = $this->load->view('forms/sub/add_item_remarks', $data, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();
	}

	function get_201_form()
	{
		$this->_ajax_only();
		$user_id = $this->config->config['user']['user_id'];
		$vars['process_id'] = $process_id = $this->input->post('process_id');
		$vars['recuser_user_id'] = $recuser_user_id = $this->input->post('user_id');
		$this->db->limit(1);
		$vars['process'] = $process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		$this->db->limit(1);
		$request = $this->db->get_where('recruitment_request', array('request_id' => $process->request_id))->row();
		$this->db->limit(1);
		$vars['recruit'] = $recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
		$vars['is_interviewer'] = $this->mod->is_interviewer();
		$vars['login_user'] = $user_id;

		$vars['position'] = "";
		$vars['phone'] = "";
		$vars['mobile'] = "";
		
		$this->load->model('applicants_model', 'recruit');
		$position = $this->recruit->get_recruitment_personal_value($process->recruit_id, 'position_sought');
		if(sizeof($position)>0)
		{
			$vars['position'] = $position[0]['key_value'];	
		}
		$phone = $this->recruit->get_recruitment_personal_value($process->recruit_id, 'phone');
		if(sizeof($phone)>0)
		{
			$vars['phone'] = $phone[0]['key_value'];	
		}
		$mobile = $this->recruit->get_recruitment_personal_value($process->recruit_id, 'mobile');
		if(sizeof($mobile)>0)
		{
			$vars['mobile'] = $mobile[0]['key_value'];	
		}

		$vars['saved_scheds'] = $this->mod->get_scheds($process_id);

		$vars['recuser_company_id'] = $request->company_id;
		$vars['recuser_department_id'] = $request->department_id;
		$vars['recuser_reports_to_id'] = $request->user_id;
		$vars['recuser_location_id'] = "";
		$vars['recuser_calendar_id'] = "";

		//$company = $this->db->get_where('users_company', array('company_id' => $request->company_id));
		
		$series = '';
/*		if ($company && $company->num_rows() > 0){
			$company_code = $company->row()->company_code;

			$series = get_system_series('ID_NUMBER', $company_code);			
		}*/

		$series = get_system_series('AHI_ID_NUMBER', '', true);

		$vars['recuser_login'] = $series;
		if( !empty($recuser_user_id) )
		{
			$qry = "SELECT a.company_id as recuser_company_id, a.department_id as recuser_department_id, a.reports_to_id as recuser_reports_to_id, 
			a.location_id as recuser_location_id, b.calendar_id as recuser_calendar_id, c.login as recuser_login
			FROM {$this->db->dbprefix}users_profile a
			LEFT JOIN {$this->db->dbprefix}partners b on a.user_id = b.user_id
			LEFT JOIN {$this->db->dbprefix}users c on c.user_id = a.user_id
			WHERE a.user_id = {$recuser_user_id} LIMIT 1 OFFSET 0";
			$recuser = $this->db->query($qry)->row_array();
			$vars = array_merge($vars, $recuser);
		}

		$this->db->limit(1);

		$jo = $this->db->get_where('recruitment_process_offer', array('process_id' => $process_id));
		if( $jo->num_rows() == 1 )
		{
			$jo = $jo->row_array();
			$vars = array_merge($vars, $jo);
		}
		$vars['blacklisted'] = $recruit->blacklisted;
		if(strtotime($vars['start_date'])){
			$vars['start_date'] = date('F d, Y', strtotime($vars['start_date']));
		}else{
			$vars['start_date'] = "";
		}
		if(strtotime($vars['end_date'])){
			$vars['end_date'] = date('F d, Y', strtotime($vars['end_date']));
		}else{
			$vars['end_date'] = "";
		}

		$vars['exams'] = $this->mod->get_exams($process_id);

		$vars['bis'] = $this->mod->get_backgrounds($process_id);

		$vars['request'] = $this->mod->get_request($process->request_id);

		$vars['bi'] = $this->mod->get_bi($process_id);		

/*		$this->db->limit(1);
		$cs = $this->db->get_where('recruitment_process_signing', array('process_id' => $process_id));
		$vars['template_id'] = '';
		$vars['signing_accepted'] = '1';

		if( $cs->num_rows() == 1 )
		{
			$cs = $cs->row();
			$vars['template_id'] = $cs->template_id;
			$vars['signing_accepted'] = $cs->accepted;
		}*/

		// echo "<pre>\n";
		// print_r($vars);
		$this->load->helper('form');
		$this->load->helper('file');
		$this->response->form201 = $this->load->view('forms/201form', $vars, true);
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function get_employee_id_no()
	{
		$this->_ajax_only();

        $series = get_system_series('AHI_ID_NUMBER', '', true);

        $this->response->id_number = $series;
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

	    $this->_ajax_return();
	}

	function save_201()
	{
		$this->_ajax_only();

		$post = $_POST;
		$process_id = $post['process_id'];

		$process_id = 	$this->input->post('process_id');

		$this->db->limit(1);
		$process 	= 	$this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
				   		
		$this->db->limit(1);
		$request 	= 	$this->db->get_where('recruitment_request', array('request_id' => $process->request_id))->row();
		
		$this->db->limit(1);
		$recruit 	= 	$this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();

		$this->db->limit(1);
		$offer 		= 	$this->db->get_where('recruitment_process_offer', array('process_id' => $process_id))->row();

		$user_id = $post['user_id'];
		$users = $post['users'];
		$partners = $post['partners'];
		$users_profile = $post['users_profile'];

		$validation_rules[] = array(
			'field'   => 'partners[calendar_id]',
			'label'   => 'Work Schedule',
			'rules'   => 'required'
		);

		$validation_rules[] = array(
			'field'   => 'users_profile[company_id]',
			'label'   => 'Company',
			'rules'   => 'required'
		);

		$validation_rules[] = array(
			'field'   => 'users_profile[department_id]',
			'label'   => 'Department',
			'rules'   => 'required'
		);

		$validation_rules[] = array(
			'field'   => 'users_profile[reports_to_id]',
			'label'   => 'Reports To',
			'rules'   => 'required'
		);

		$validation_rules[] = array(
			'field'   => 'users_profile[location_id]',
			'label'   => 'Location',
			'rules'   => 'required'
		);

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
			
			$this->_ajax_return();
		}

        // start valdiate id number
        $idnumber = trim($users['login']);
        
        if(strlen($idnumber) > 0) {
            // validate in partners table
            $id_number_qry = "SELECT  partner_id, id_number
                                        FROM {$this->db->dbprefix}partners 
                                        WHERE id_number = '{$idnumber}' 
                                        AND deleted = 0;
                                        ";
            $idnum_sql = $this->db->query( $id_number_qry );
            $idnum_count = $idnum_sql->num_rows();

            // validate in users table
            $login_qry = "SELECT  user_id, login
                                        FROM {$this->db->dbprefix}users 
                                        WHERE login = '{$idnumber}' 
                                        AND deleted = 0;
                                        ";
            $login_sql = $this->db->query( $login_qry );
            $login_count = $login_sql->num_rows();

            if($idnum_count > 0 || $login_count > 0) {
                $this->response->message[] = array(
                    'message' => "ID number already exist.",
                    'type' => 'warning'
                );
                
                $this->_ajax_return();
            }
        }
        // end valdiate id number

		//SAVING START   
		$transactions = true;
		$error = false;
		if( $transactions )
		{
			$this->db->trans_begin();
		}

		if( empty($user_id) )
		{
			$this->load->library('aes', array('key' => $this->config->item('encryption_key')));	

			if ($users['salary'] && $users['salary'] != ''){
				$partners['salary'] = ($this->aes->encrypt( $users['salary'] ));
				unset($users['salary']);
			}
						
			$users['email'] = $recruit->email;
			$users['created_by'] = $this->user->user_id;
			$users['role_id'] = 12;
			$users['full_name'] = $recruit->lastname.', '.$recruit->firstname;
			$users['display_name'] = $recruit->lastname.', '.$recruit->firstname;

			$this->db->insert('users', $users);
			$user_id = $new_user_id = $this->db->insert_id();

			if( $this->db->_error_message() != "" ){
				$this->response->message[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
				$error = true;
			}

			$system_series = $this->db->get_where('system_series', array('series_code' => 'AHI_ID_NUMBER'))->row();

			if(!(empty($system_series))){
			    // records have been returned
			    $sequence = $system_series->sequence + 1; 
				$this->db->update('system_series',  array('last_sequence' => $idnumber, 'sequence' => $sequence), array('id' => $system_series->id));
			}

			//create system logs
			$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'users', array(), $users);
			$partners['user_id'] = $new_user_id;
			$partners['created_by'] = $this->user->user_id;
			$partners['id_number'] = $users['login'];
			$partners['effectivity_date'] = $offer->start_date;
			$partners['calendar_id'] = $partners['calendar_id'];
			$partners['alias'] = $recruit->lastname.', '.$recruit->firstname;
			
			$this->db->insert('partners', $partners);
			$new_partner_id = $this->db->insert_id();

			if( $this->db->_error_message() != "" ){
				$this->response->message[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
				$error = true;
			}

			//create system logs
			$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'partners', array(), $partners);

			$users_profile['user_id'] = $new_user_id;
			$users_profile['partner_id'] = $new_partner_id;
			$users_profile['recruit_id'] = $process->recruit_id;
			$users_profile['lastname'] = $recruit->lastname;
			$users_profile['firstname'] = $recruit->firstname;
			$users_profile['middlename'] = $recruit->middlename;
			$users_profile['maidenname'] = $recruit->maidenname;
			$users_profile['nickname'] = $recruit->nickname;
			$users_profile['position_id'] = $request->position_id;
			$users_profile['title'] = $recruit->title;
			$users_profile['birth_date'] = $recruit->birth_date;
			$this->db->insert('users_profile', $users_profile);

			if( $this->db->_error_message() != "" ){
				$this->response->message[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
				$error = true;
			}

			//create system logs
			$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'users_profile', array(), $users_profile);

			$this->load->model('system_feed');

			$feed = array(
                'status' => 'info',
                'message_type' => 'Personnel',
                'user_id' => $this->user->user_id,
                'feed_content' => $recruit->firstname.' '.$recruit->lastname.' now has a 201 record.',
                'uri' => $this->mod->route,
                'recipient_id' => $users_profile['reports_to_id']
            );
            $recipients = array($users_profile['reports_to_id']);
            $this->system_feed->add( $feed, $recipients );

            if( $this->db->_error_message() != "" ){
				$this->response->message[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
				$error = true;
			}

            $this->response->notify[] = $users_profile['reports_to_id'];
		}
		else{
		//get previous data for audit logs
			$previous_main_data = $this->db->get_where('users', array('user_id' => $user_id))->row_array();
			$this->db->update('users', $users, array('user_id' => $user_id));
			
			if( $this->db->_error_message() != "" ){
				$this->response->message[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
				$error = true;
			}

			//create system logs
			$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'users', $previous_main_data, $users);

		//get previous data for audit logs
			$previous_main_data = $this->db->get_where('partners', array('user_id' => $user_id))->row_array();
			$this->db->update('partners', $partners, array('user_id' => $user_id));
			if( $this->db->_error_message() != "" ){
				$this->response->message[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
				$error = true;
			}

			//create system logs
			$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'partners', $previous_main_data, $partners);

		//get previous data for audit logs
			$previous_main_data = $this->db->get_where('users_profile', array('user_id' => $user_id))->row_array();
			$this->db->update('users_profile', $users_profile, array('user_id' => $user_id));
			if( $this->db->_error_message() != "" ){
				$this->response->message[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
				$error = true;
			}

			//create system logs
			$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'users_profile', $previous_main_data, $users_profile);
		}

		$this->db->limit(1);
		$partner = $this->db->get_where('partners', array('user_id' => $user_id))->row();
		$rec_array = array('status_id' => 7, 'hired' => 1, 'partner_id' => $partner->partner_id);		
		//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row_array();
		$this->db->update('recruitment', $rec_array, array('recruit_id' => $process->recruit_id));
		
		if( $this->db->_error_message() != "" ){
			$this->response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
			$error = true;
		}

		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment', $previous_main_data, $rec_array);

		$quantity_served = $request->quantity + 1;
		if( $request->quantity == $quantity_served){
			//update mrf close?
			$update_mrf = array(
								'status_id' => 5,
								'closing_remarks' => 'system-closed',
								'closed_by' => $this->user->user_id,
								'closed_on' => date('Y-m-d H:i:s'),
								'quantity' => $quantity_served
							);
			$this->db->update('recruitment_request', $update_mrf, array('request_id' => $request->request_id));	
			if( $this->db->_error_message() != "" ){
				$this->response->message[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
				$error = true;
			}
		}
		
		stop:
		if( $transactions )
		{
			if( !$error ){
				$this->db->trans_commit();
			}
			else{
				 $this->db->trans_rollback();
			}
		}

		if( !$error  )
		{

			$this->response->saved = true;
			$this->response->message[] = array(
				'message' => '',
				'type' => 'success'
			);
		}

		$this->response->saved = !$error;
		$this->_ajax_return();
	}

	function add_benefit_row() {
		$this->_ajax_only();
		$data = array();

		$this->load->helper('form');
		$this->load->helper('file');
		$this->response->benefit = $this->load->view('forms/sub/benefit', $data, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();
	}

	function get_preemp_form()
	{
		$this->_ajax_only();
		$user_id = $this->config->config['user']['user_id'];
		$vars['process_id'] = $process_id = $this->input->post('process_id');
		$this->db->limit(1);
		$vars['process'] = $process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		$this->db->limit(1);
		$vars['recruit'] = $recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
		$vars['is_interviewer'] = $this->mod->is_interviewer();
		$vars['login_user'] = $user_id;

		$vars['position'] = "";
		$vars['phone'] = "";
		$vars['mobile'] = "";
		
		$this->load->model('applicants_model', 'recruit');
		$position = $this->recruit->get_recruitment_personal_value($process->recruit_id, 'position_sought');
		if(sizeof($position)>0)
		{
			$vars['position'] = $position[0]['key_value'];	
		}
		$phone = $this->recruit->get_recruitment_personal_value($process->recruit_id, 'phone');
		if(sizeof($phone)>0)
		{
			$vars['phone'] = $phone[0]['key_value'];	
		}
		$mobile = $this->recruit->get_recruitment_personal_value($process->recruit_id, 'mobile');
		if(sizeof($mobile)>0)
		{
			$vars['mobile'] = $mobile[0]['key_value'];	
		}

		$vars['saved_scheds'] = $this->mod->get_scheds($process_id);

		$vars['employment_status_id'] = '';
		$vars['no_months'] = '';
		$vars['template_id'] = '';
		$vars['reports_to'] = '';
		$vars['start_date'] = '';
		$vars['end_date'] = '';
		$vars['work_schedule'] = '';
		$vars['shift_id'] = '';
		$vars['lunch_break'] = '';
		$vars['accept_offer'] = 1;
		$vars['blacklisted'] = '';
		$this->db->limit(1);

		$jo = $this->db->get_where('recruitment_process_offer', array('process_id' => $process_id));
		if( $jo->num_rows() == 1 )
		{
			$jo = $jo->row_array();
			$vars = array_merge($vars, $jo);
		}
		$vars['blacklisted'] = $recruit->blacklisted;
		if(strtotime($vars['start_date'])){
			$vars['start_date'] = date('F d, Y', strtotime($vars['start_date']));
		}else{
			$vars['start_date'] = "";
		}
		if(strtotime($vars['end_date'])){
			$vars['end_date'] = date('F d, Y', strtotime($vars['end_date']));
		}else{
			$vars['end_date'] = "";
		}

		$vars['exams'] = $this->mod->get_exams($process_id);

		$vars['bis'] = $this->mod->get_backgrounds($process_id);

		$vars['request'] = $this->mod->get_request($process->request_id);

		$vars['bi'] = $this->mod->get_bi($process_id);				
// echo "<pre>\n";
// print_r($vars);
		$this->load->helper('form');
		$this->load->helper('file');
		$this->response->jo_form = $this->load->view('forms/preemp', $vars, true);
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function save_preemp()
	{
		$this->_ajax_only();

		$process_id = $this->input->post('process_id');
		$checklist_id = $this->input->post('checklist_id');
		$preemp['submitted'] = $this->input->post('submitted');
		$preemp['modified_by'] = $this->user->user_id;
		$preemp['modified_on'] = date('Y-m-d H:i:s');

		$where_array = array('process_id' => $process_id,
								'checklist_id' => $checklist_id);
	//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment_process_employment_checklist', $where_array)->row_array();
		$this->db->update('recruitment_process_employment_checklist', $preemp, $where_array);
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment_process_employment_checklist', $previous_main_data, $preemp);

		$this->response->message[] = array(
			'message' => 'Item successfully saved/updated.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function move_to_c201()
	{
		$this->_ajax_only();

		$process_id = $this->input->post('process_id');
		$this->db->limit(1);
		$process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		$update_data = array('status_id' => 8,
							'modified_by' => $this->user->user_id,
							'modified_on' => date('Y-m-d H:i:s')
							);
	//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row_array();
		$this->db->update('recruitment_process', $update_data, array('process_id' => $process_id));
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment_process', $previous_main_data, $update_data);

	//get previous data for audit logs
		$previous_main_data = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row_array();
		$this->db->update('recruitment', $update_data, array('recruit_id' => $process->recruit_id));
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'recruitment', $previous_main_data, $update_data);

		//$checklists = $this->db->get_where('recruitment_employment_checklist', array('deleted' => 0))->result_array();
		$completed = $_POST['completed'];
		$date_submitted = $_POST['date_submitted'];

		$this->db->where('process_id',$process_id);
		$this->db->delete('recruitment_process_employment_checklist');

		foreach($completed as $key => $val){
			$insert_list = array(
							'process_id' => $process_id, 
							'checklist_id' => $key,
							'submitted' => $val,
							'date_submitted' => ($date_submitted[$key] != '' ? date( 'Y-m-d', strtotime($date_submitted[$key])) : ''),
							'created_by' => $this->user->user_id
							);

			$this->db->insert('recruitment_process_employment_checklist', $insert_list);
			//create system logs
			$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'recruitment_process_employment_checklist', array(), $insert_list);
		}

		$this->load->model('system_feed');
		$recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
		$this->db->limit(1);
		$requests = $this->db->get_where('recruitment_request', array('request_id' => $process->request_id))->row();
		$this->db->limit(1);
		$positions = $this->db->get_where('users_position', array('position_id' => $requests->position_id))->row();
		$feed = array(
            'status' => 'info',
            'message_type' => 'Personnel',
            'user_id' => $this->user->user_id,
            'feed_content' => $recruit->firstname.' '.$recruit->lastname.' for '.$positions->position.' was moved to create 201.',
            'uri' => $this->mod->route,
            'recipient_id' => $requests->user_id
        );
        $recipients = array($requests->user_id);
        $this->system_feed->add( $feed, $recipients );

        $this->response->notify[] = $requests->user_id;
		$this->response->message[] = array(
			'message' => 'Applicant successfully moved to create 201.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function send_email($user_id = '',$process_id = '',$ajax = false)
	{
		$this->_ajax_only();

		$process_id = ($process_id != '') ? $process_id : $this->input->post('process_id');
		$user_id = ($user_id != '')  ? $user_id : $this->input->post('user_id');

	 	$users_qry = "SELECT * FROM {$this->db->dbprefix}users_profile usp 
	 					LEFT JOIN {$this->db->dbprefix}users us ON usp.user_id = us.user_id
	 					WHERE usp.user_id = {$user_id}";
		$users_profile = $this->db->query($users_qry)->row_array();
	 	$scheduleData['interviewers_name'] = $users_profile['firstname'].' '.$users_profile['lastname'];

	 	$interview_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_process recp 
	 					LEFT JOIN {$this->db->dbprefix}recruitment rec ON recp.recruit_id = rec.recruit_id
	 					WHERE recp.process_id = {$process_id}";
	 	$interview_details = $this->db->query($interview_qry)->row_array();
	 	$scheduleData['applicant_name'] = $interview_details['firstname'].' '.$interview_details['lastname'];
		
		$position_where = array( 'recruit_id' => $interview_details['recruit_id'], 'key' => 'position_sought');
		$position_sought = $this->db->get_where( 'recruitment_personal', $position_where )->row_array();
		$scheduleData['position_applied'] = $position_sought['key_value'];

		$schedule_where = array( 'process_id' => $process_id, 'user_id' => $user_id);

		$this->db->join('recruitment_interview_location', 'recruitment_interview_location.interview_location_id=recruitment_process_schedule.location_id');
		$this->db->join('users_company', 'users_company.company_id=recruitment_interview_location.company_id');
		$schedule_details_result = $this->db->get_where( 'recruitment_process_schedule', $schedule_where );

		if ($schedule_details_result && $schedule_details_result->num_rows() > 0){
			$schedule_details = $schedule_details_result->row_array();

			$scheduleData['interview_date'] = date('F d, Y', strtotime($schedule_details['date']));
			$scheduleData['interview_time'] = date('h:i a', strtotime($schedule_details['date']));

			$scheduleData['system_url'] = $this->mrf->get_recruitment_config('URL'); 
	    	$scheduleData['system_title'] = $this->mrf->get_recruitment_config('application_title'); 
	    	$scheduleData['system_author'] = $this->mrf->get_recruitment_config('author'); 
			

		 	$request_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_request rr 
		 					LEFT JOIN {$this->db->dbprefix}users_company uc ON rr.company_id = uc.company_id
		 					WHERE rr.request_id = {$interview_details['request_id']}";
		 	$request_details = $this->db->query($request_qry)->row_array();
			$scheduleData['company_name'] = $schedule_details['company'];
			$scheduleData['interview_venue'] = $schedule_details['address'];
			$scheduleData['company_code'] = $schedule_details['company_code'];

		 	$comcontact_qry = "SELECT * FROM {$this->db->dbprefix}users_company_contact ucc 
		 					WHERE ucc.company_id = {$schedule_details['company_id']}";
		 	$contact_details = $this->db->query($comcontact_qry)->row_array();
			$scheduleData['company_number'] = $contact_details['contact_no'];
			$scheduleData['system_url'] = $scheduleData['system_url'];

			$this->load->library('parser');
			$this->parser->set_delimiters('{{', '}}');

			$interviewer_template = $this->db->get_where( 'system_template', array( 'code' => 'INTERVIEWER_SCHED') )->row_array();	
			$msg = $this->parser->parse_string($interviewer_template['body'], $scheduleData, TRUE);		
			$this->db->query("INSERT INTO {$this->db->dbprefix}system_email_queue (`to`, `subject`, body)
			         VALUES('{$users_profile['email']}', '{$interviewer_template['subject']}', '".$this->db->escape_str($msg)."') ");		         
			//create system logs
			$insert_array = array(
				'to' => $users_profile['email'], 
				'subject' => $interviewer_template['subject'], 
				'body' => $msg
				);
			$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'system_email_queue', array(), $insert_array);	

			$interviewee_template = $this->db->get_where( 'system_template', array( 'code' => 'INTERVIEWEE_SCHED') )->row_array();
			$msg = $this->parser->parse_string($interviewee_template['body'], $scheduleData, TRUE);
			
			$this->db->query("INSERT INTO {$this->db->dbprefix}system_email_queue (`to`, `subject`, body)
			         VALUES('{$interview_details['email']}', '{$interviewee_template['subject']}', '".$this->db->escape_str($msg)."') ");
			//create system logs
			$insert_array = array(
				'to' => $interview_details['email'], 
				'subject' => $interviewee_template['subject'], 
				'body' => $msg
				);
			$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'system_email_queue', array(), $insert_array);				
		}
		
		if( $this->db->_error_message() != "" ){
			return $this->db->_error_message();
		}

		if (!$ajax){
			$this->response->message[] = array(
				'message' => 'Interview Schedule email successfully sent.',
				'type' => 'success'
			);
			$this->_ajax_return();			
		}

	}

	function email_jo()
	{
		$this->_ajax_only();

		$process_id = $this->input->post('process_id');
		$jo = $this->db->get_where('recruitment_process_offer', array('process_id' => $process_id));

		if($jo->num_rows() == 0){
			$this->response->message[] = array(
				'message' => 'Please fillout first Job Offer details before sending email.',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		$offer = $jo->row_array();
		$template_data['start_date'] = date('F d, Y', strtotime($offer['start_date']));
		if(strtotime($offer['end_date'])){
			$template_data['end_probi_date'] = date('F d, Y', strtotime($offer['end_date']));
		}else{
			$template_data['end_probi_date'] = '';
		}
		switch($offer['work_schedule']){
			case 1:
			$template_data['daysofwork'] = "Mondays to Fridays";
			break;
			case 2:
			$template_data['daysofwork'] = "Mondays to Saturdays";
			break;
		}		
		switch($offer['lunch_break']){
			case 1:
			$template_data['breaktime'] = "12:00 noon to 1:00 pm";
			break;
			case 2:
			$template_data['breaktime'] = "1:00 pm to 2:00 pm";
			break;
		}

		$shift = $this->db->get_where( 'time_shift', array( 'shift_id' => $offer['shift_id']) )->row_array();	
		$template_data['timeshift'] = $shift['shift'];

	 	$immediate_qry = "SELECT pos.* FROM {$this->db->dbprefix}users_profile up
					LEFT JOIN {$this->db->dbprefix}users_position pos ON up.position_id = pos.position_id
					WHERE up.user_id = {$offer['reports_to']}";
	 	$immediate = $this->db->query($immediate_qry);	
		$template_data['immediateposition'] = '';
		if($immediate && $immediate->num_rows() > 0){
			$immediate = $immediate->row_array();
			$template_data['immediateposition'] = $immediate['position'];
		}

		$interview_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_process recp 
	 					LEFT JOIN {$this->db->dbprefix}recruitment rec ON recp.recruit_id = rec.recruit_id
	 					WHERE recp.process_id = {$process_id}";
	 	$recruit_details = $this->db->query($interview_qry);
	 	$template_data['dear'] = '';
	 	if($recruit_details && $recruit_details->num_rows() > 0){
	 		$recruit_details = $recruit_details->row_array();
	 		$template_data['dear'] = $recruit_details['firstname'].' '.$recruit_details['lastname'];
		}
		
	 	$request_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_request rr 
	 					LEFT JOIN {$this->db->dbprefix}users_company uc ON rr.company_id = uc.company_id
	 					WHERE rr.request_id = {$recruit_details['request_id']}";
	 	$request_details = $this->db->query($request_qry)->row_array();
		$template_data['company_name'] = $request_details['company'];
		$template_data['interview_venue'] = $request_details['address'];
		$template_data['company_code'] = $request_details['company_code'];

		$template_data['basicsalary'] = '';

	 	$comben_qry = "SELECT offben.* FROM {$this->db->dbprefix}recruitment_process_offer_compben offben
						LEFT JOIN {$this->db->dbprefix}recruitment_benefit comben ON offben.benefit_id = comben.benefit_id
						WHERE offben.process_id = {$process_id} AND comben.is_basic = 1";
	 	$compben = $this->db->query($comben_qry);
	 	if($compben && $compben->num_rows() > 0){
	 		$compben = $compben->row_array();
	 		$template_data['basicsalary'] = $compben['amount'];
	 	}	
		
	 	$combens_qry = "SELECT offben.*, comben.benefit FROM {$this->db->dbprefix}recruitment_process_offer_compben offben
						LEFT JOIN {$this->db->dbprefix}recruitment_benefit comben ON offben.benefit_id = comben.benefit_id
						WHERE offben.process_id = {$process_id} AND comben.is_basic != 1";
	 	$compbens = $this->db->query($combens_qry);
	 	$template_data['benefits'] = '';

	 	if($compbens && $compbens->num_rows() > 0){
		 	foreach($compbens->result_array() as $benefit){
		 		$template_data['benefits'] .= '<li>* '.$benefit['benefit'].' : Php '.$benefit['amount'].'</li>';
		 	}
		}

		$position_where = array( 'recruit_id' => $recruit_details['recruit_id'], 'key' => 'position_sought');
		$position_sought = $this->db->get_where( 'recruitment_personal', $position_where )->row_array();
		$template_data['position'] = $position_sought['key_value'];

	 	$hr_qry = "SELECT up.* FROM {$this->db->dbprefix}users_profile up
						LEFT JOIN {$this->db->dbprefix}users_position pos ON up.position_id = pos.position_id
						WHERE pos.position_code = 'HRM-RES'";
	 	$hr = $this->db->query($hr_qry)->row_array();
		$template_data['HRmanager'] = $hr['firstname'].' '.$hr['lastname'];

		$template_data['system_url'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'URL' LIMIT  1")->row_array();
    	$template_data['system_title'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'application_title' LIMIT  1")->row_array();
    	$template_data['system_author'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'author' LIMIT  1")->row_array();
		
		$this->load->library('parser');
		$this->parser->set_delimiters('{{', '}}');

		$interviewer_template = $this->db->get_where( 'system_template', array( 'code' => 'JO_EMAIL') )->row_array();	
		$msg = $this->parser->parse_string($interviewer_template['body'], $template_data, TRUE);
		$subject = $this->parser->parse_string($interviewer_template['subject'], $template_data, TRUE);		
		
		$this->db->query("INSERT INTO {$this->db->dbprefix}system_email_queue (`to`, `subject`, body)
		         VALUES('{$recruit_details['email']}', '{$subject}', '".$this->db->escape_str($msg)."') ");
		//create system logs
		$insert_array = array(
			'to' => $recruit_details['email'], 
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

		$this->response->message[] = array(
			'message' => 'Job Offer email successfully sent.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function print_jo()
	{
		$this->_ajax_only();

		$process_id = $this->input->post('process_id');
		$jo = $this->db->get_where('recruitment_process_offer', array('process_id' => $process_id));

		if($jo->num_rows() == 0){
			$this->response->message[] = array(
				'message' => 'Please fillout first Job Offer details before sending email.',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

    	$user = $this->config->item('user');
        $this->load->library('PDFm');
        $mpdf=new PDFm();

        $mpdf->SetTitle( 'Job Offer' );
        $mpdf->SetMargins(0, 0, 40);
        $mpdf->SetAutoPageBreak(true, 1);
        $mpdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $mpdf->SetDisplayMode('real', 'default');
        $mpdf->AddPage();

/*		$offer = $jo->row_array();
		$template_data['date'] = date('F d, Y');
		$template_data['start_date'] = date('F d, Y', strtotime($offer['start_date']));
		if(strtotime($offer['end_date'])){
			$template_data['end_probi_date'] = date('F d, Y', strtotime($offer['end_date']));
		}else{
			$template_data['end_probi_date'] = '';
		}

		switch($offer['work_schedule']){
			case 1:
			$template_data['daysofwork'] = "Mondays to Fridays";
			break;
			case 2:
			$template_data['daysofwork'] = "Mondays to Saturdays";
			break;
		}		
		switch($offer['lunch_break']){
			case 1:
			$template_data['breaktime'] = "12:00 noon to 1:00 pm";
			break;
			case 2:
			$template_data['breaktime'] = "1:00 pm to 2:00 pm";
			break;
		}

		$shift = $this->db->get_where( 'time_shift', array( 'shift_id' => $offer['shift_id']) )->row_array();	
		$template_data['timeshift'] = $shift['shift'];

	 	$immediate_qry = "SELECT pos.* FROM {$this->db->dbprefix}users_profile up
					LEFT JOIN {$this->db->dbprefix}users_position pos ON up.position_id = pos.position_id
					WHERE up.user_id = {$offer['reports_to']}";
	 	$immediate = $this->db->query($immediate_qry)->row_array();	
		$template_data['immediateposition'] = $immediate['position'];
	 	
	 	$interview_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_process recp 
	 					LEFT JOIN {$this->db->dbprefix}recruitment rec ON recp.recruit_id = rec.recruit_id
	 					WHERE recp.process_id = {$process_id}";
	 	$recruit_details = $this->db->query($interview_qry)->row_array();
	 	$template_data['dear'] = $recruit_details['firstname'].' '.$recruit_details['lastname'];
		$template_data['recipients'] = $recruit_details['firstname'].' '.$recruit_details['lastname'];
		
	 	$request_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_request rr 
	 					LEFT JOIN {$this->db->dbprefix}users_company uc ON rr.company_id = uc.company_id
	 					WHERE rr.request_id = {$recruit_details['request_id']}";
	 	$request_details = $this->db->query($request_qry)->row_array();
		$template_data['company_name'] = $request_details['company'];
		$template_data['interview_venue'] = $request_details['address'];
		$template_data['company_code'] = $request_details['company_code'];

	 	$comben_qry = "SELECT offben.* FROM {$this->db->dbprefix}recruitment_process_offer_compben offben
						LEFT JOIN {$this->db->dbprefix}recruitment_benefit comben ON offben.benefit_id = comben.benefit_id
						WHERE offben.process_id = {$process_id} AND comben.is_basic = 1";
	 	$compben = $this->db->query($comben_qry)->row_array();
		$template_data['basicsalary'] = $compben['amount'];

	 	$combens_qry = "SELECT offben.*, comben.benefit FROM {$this->db->dbprefix}recruitment_process_offer_compben offben
						LEFT JOIN {$this->db->dbprefix}recruitment_benefit comben ON offben.benefit_id = comben.benefit_id
						WHERE offben.process_id = {$process_id} AND comben.is_basic != 1";
	 	$compbens = $this->db->query($combens_qry)->result_array();
	 	$template_data['benefits'] = '';
	 	foreach($compbens as $benefit){
	 		$template_data['benefits'] .= '<li>* '.$benefit['benefit'].' : Php '.$benefit['amount'].'</li>';
	 	}

		$position_where = array( 'recruit_id' => $recruit_details['recruit_id'], 'key' => 'position_sought');
		$position_sought = $this->db->get_where( 'recruitment_personal', $position_where )->row_array();
		$template_data['position'] = $position_sought['key_value'];

	 	$hr_qry = "SELECT up.* FROM {$this->db->dbprefix}users_profile up
						LEFT JOIN {$this->db->dbprefix}users_position pos ON up.position_id = pos.position_id
						WHERE pos.position_code = 'HRM-RES'";
	 	$hr = $this->db->query($hr_qry)->row_array();
		$template_data['HRmanager'] = $hr['firstname'].' '.$hr['lastname'];

		$template_data['system_url'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'URL' LIMIT  1")->row_array();
    	$template_data['system_title'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'application_title' LIMIT  1")->row_array();
    	$template_data['system_author'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'author' LIMIT  1")->row_array();

		$this->load->model('applicants_model', 'recruit');
		$city_town = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'city_town');
		$vars['city_town'] = count($city_town) == 0 ? " " : $city_town[0]['key_value'] == "" ? "" : $city_town[0]['key_value'];
		$countries = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'country');
		$vars['country'] = count($countries) == 0 ? " " : $countries[0]['key_value'] == "" ? "" : $countries[0]['key_value'];
		$address_1 = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'address_1');
		$vars['address_1'] = count($address_1) == 0 ? " " : $address_1[0]['key_value'] == "" ? "" : $address_1[0]['key_value'];
		$address_2 = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'address_2');
		$vars['address_2'] = count($address_2) == 0 ? " " : $address_2[0]['key_value'] == "" ? "" : $address_2[0]['key_value'];
		$zip_code = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'zip_code');
		$vars['zip_code'] = count($zip_code) == 0 ? " " : $zip_code[0]['key_value'] == "" ? "" : $zip_code[0]['key_value'];
		$province = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'province');
		$vars['province'] = count($province) == 0 ? " " : $province[0]['key_value'] == "" ? "" : $province[0]['key_value'];
		$presentadd_no = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'presentadd_no');
		$vars['presentadd_no'] = count($presentadd_no) == 0 ? " " : $presentadd_no[0]['key_value'] == "" ? "" : $presentadd_no[0]['key_value'];
		$presentadd_village = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'presentadd_village');
		$vars['presentadd_village'] = count($presentadd_village) == 0 ? " " : $presentadd_village[0]['key_value'] == "" ? "" : $presentadd_village[0]['key_value'];
		$town = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'town');
		$vars['town'] = count($town) == 0 ? " " : $town[0]['key_value'] == "" ? "" : $town[0]['key_value'];
		
		$template_data['address1'] = $vars['presentadd_no'].' '.$vars['address_1'].' '.$vars['presentadd_village'].' '.$vars['address_2'];
		$template_data['address2'] = $vars['town'].' '.$vars['city_town'].' '.$vars['province'].' '.$vars['zip_code'];*/
        
        // this is line is for AHI
        $template_jo = '';
        $offer_saved = $this->db->get_where('recruitment_process_offer',array('process_id' => $process_id));
        if ($offer_saved && $offer_saved->num_rows() > 0){
        	$template_jo = $offer_saved->row()->template_value;
        }

        $template_data['jo_template'] = (isset($_POST['jo']['template_value']) && $_POST['jo']['template_value'] != '' ? $_POST['jo']['template_value'] : $template_jo);

        $benefit = $_POST['compben']['benefit_id'];
        $amount = $_POST['compben']['amount'];
        $permanent = $_POST['compben']['permanent'];

        $benefit_html = '<table align="center" cellpadding="2px" cellspacing="0" style="width: 95%; height: auto; background: #fff; border: 1px solid #000;margin-bottom: 10px;">
        					<tr>
            					<td style="border-right: 1px solid #000;border-bottom: 1px solid #000" align="center">Compensation</td>
            					<td style="border-bottom: 1px solid #000" align="center">Amount</td>
        					</tr>';

        if (count($benefit) > 0){
        	$total = 0;
        	foreach ($benefit as $key => $value) {
        		$benefit_item = '';
        		$amount_val = str_replace(',','',$amount[$key]);
        		$benefit_item_result = $this->db->get_where('payroll_transaction',array('transaction_id' => $value));
        		if ($benefit_item_result && $benefit_item_result->num_rows() > 0){
        			$benefit_item = $benefit_item_result->row()->transaction_label;
        		}
        		if (!$permanent[$key]){
	        		$benefit_html .= '<tr>
	                					<td style="border-right: 1px solid #000" align="lect">'.$benefit_item.'</td>
	                					<td align="left">'.number_format($amount_val, 2, '.', ',').'</td>
	            					</tr>';
        			$total += str_replace(',','',$amount[$key]);	            					
            	}
        	}
    		$benefit_html .= '<tr>
            					<td style="border-right: 1px solid #000" align="lect"><b>Gross Pay</b></td>
            					<td align="left">'.number_format($total, 2, '.', ',').'</td>
        					</tr>';          	
        }
        else{
        	$this->db->join('payroll_transaction','recruitment_process_offer_compben.benefit_id = payroll_transaction.transaction_id');
        	$benefit_saved = $this->db->get_where('recruitment_process_offer_compben',array('process_id' => $process_id, 'permanent' => 0));
        	if ($benefit_saved && $benefit_saved->num_rows() > 0){
        		$total = 0;
        		foreach ($benefit_saved->result() as $row) {
        			$total += $row->amount;
	        		$benefit_html .= '<tr>
	                					<td style="border-right: 1px solid #000" align="lect">'.$row->transaction_label.'</td>
	                					<td align="left">'.number_format($row->amount, 2, '.', ',').'</td>
	            					</tr>';
        		}
        		$benefit_html .= '<tr>
                					<td style="border-right: 1px solid #000" align="lect"><b>Gross Pay</b></td>
                					<td align="left">'.number_format($total, 2, '.', ',').'</td>
            					</tr>';        		
        	}
        }

        $benefit_html .= '</table>';


        $permanent_html = '<table align="center" cellpadding="2px" cellspacing="0" style="width: 95%; height: auto; background: #fff; border: 1px solid #000;margin-bottom: 10px;">
        					<tr>
            					<td style="border-right: 1px solid #000;border-bottom: 1px solid #000" align="center">Compensation</td>
            					<td style="border-bottom: 1px solid #000" align="center">Amount</td>
        					</tr>';

        if (count($benefit) > 0){
        	$total = 0;
        	foreach ($benefit as $key => $value) {
        		$total += str_replace(',','',$amount[$key]);
        		$benefit_item = '';
        		$amount_val = str_replace(',','',$amount[$key]);
        		$benefit_item_result = $this->db->get_where('payroll_transaction',array('transaction_id' => $value));
        		if ($benefit_item_result && $benefit_item_result->num_rows() > 0){
        			$benefit_item = $benefit_item_result->row()->transaction_label;
        		}
        		$permanent_html .= '<tr>
                					<td style="border-right: 1px solid #000" align="lect">'.$benefit_item.'</td>
                					<td align="left">'.number_format($amount_val, 2, '.', ',').'</td>
            					</tr>';
        	}
    		$permanent_html .= '<tr>
            					<td style="border-right: 1px solid #000" align="lect"><b>Gross Pay</b></td>
            					<td align="left">'.number_format($total, 2, '.', ',').'</td>
        					</tr>';          	
        }
        else{
        	$this->db->join('payroll_transaction','recruitment_process_offer_compben.benefit_id = payroll_transaction.transaction_id');
        	$benefit_saved = $this->db->get_where('recruitment_process_offer_compben',array('process_id' => $process_id));
        	if ($benefit_saved && $benefit_saved->num_rows() > 0){
        		$total = 0;
        		foreach ($benefit_saved->result() as $row) {
        			$total += $row->amount;
	        		$permanent_html .= '<tr>
	                					<td style="border-right: 1px solid #000" align="lect">'.$row->transaction_label.'</td>
	                					<td align="left">'.number_format($row->amount, 2, '.', ',').'</td>
	            					</tr>';
        		}
	    		$permanent_html .= '<tr>
	            					<td style="border-right: 1px solid #000" align="lect"><b>Gross Pay</b></td>
	            					<td align="left">'.number_format($total, 2, '.', ',').'</td>
	        					</tr>';          		
        	}
        }

        $permanent_html .= '</table>';

        $vars['compensation'] = $benefit_html;
        $vars['probationary_appoinment'] = $benefit_html;
        $vars['permanent_appoinment'] = $permanent_html;

        $this->load->helper('file');
		$this->load->library('parser');
		$this->parser->set_delimiters('{{', '}}');

		$template_data['jo_template'] = $this->parser->parse_string($template_data['jo_template'], $vars, TRUE);

       	$mrf_template = $this->db->get_where( 'system_template', array( 'code' => 'JOB-OFFER-FORM') )->row_array();
		$html = $this->parser->parse_string($mrf_template['body'], $template_data, TRUE);
		// this is line is for AHI

        $this->load->helper('file');
        $path = 'uploads/templates/job_offer/pdf/';
        $this->check_path( $path );
        $filename = $path .$template_data['dear']."-".$template_data['position']. "-".'Job Offer' .".pdf";

        $mpdf->WriteHTML($html, 0, true, false);
        $mpdf->Output($filename, 'F');

        $this->response->filename = $filename;
		$this->response->message[] = array(
			'message' => 'File successfully loaded.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function print_emp_agree()
	{
		$this->_ajax_only();

		$process_id = $this->input->post('process_id');
		$jo = $this->db->get_where('recruitment_process_offer', array('process_id' => $process_id));

		if($jo->num_rows() == 0){
			$this->response->message[] = array(
				'message' => 'Please fillout first Job Offer details before sending email.',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

    	$user = $this->config->item('user');

        $this->load->library('PDFm');
        $mpdf = new PDFm();

        $mpdf->SetTitle( 'Employee Agreement' );
        $mpdf->SetAutoPageBreak(true, 1);
        $mpdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $mpdf->SetDisplayMode('real', 'default');
        $mpdf->AddPage();

		$offer = $jo->row_array();
		$template_data['date'] = date('F d, Y');
		$template_data['start_date'] = date('F d, Y', strtotime($offer['start_date']));
		if(strtotime($offer['end_date'])){
			$template_data['end_probi_date'] = date('F d, Y', strtotime($offer['end_date']));
		}else{
			$template_data['end_probi_date'] = '';
		}

		switch($offer['work_schedule']){
			case 1:
			$template_data['daysofwork'] = "Mondays to Fridays";
			break;
			case 2:
			$template_data['daysofwork'] = "Mondays to Saturdays";
			break;
		}		
		switch($offer['lunch_break']){
			case 1:
			$template_data['breaktime'] = "12:00 noon to 1:00 pm";
			break;
			case 2:
			$template_data['breaktime'] = "1:00 pm to 2:00 pm";
			break;
		}

		$shift = $this->db->get_where( 'time_shift', array( 'shift_id' => $offer['shift_id']) )->row_array();	
		$template_data['timeshift'] = $shift['shift'];

	 	$immediate_qry = "SELECT pos.* FROM {$this->db->dbprefix}users_profile up
					LEFT JOIN {$this->db->dbprefix}users_position pos ON up.position_id = pos.position_id
					WHERE up.user_id = {$offer['reports_to']}";
	 	$immediate = $this->db->query($immediate_qry)->row_array();
		$template_data['immediateposition'] = $immediate['position'];
	 	
	 	$interview_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_process recp 
	 					LEFT JOIN {$this->db->dbprefix}recruitment rec ON recp.recruit_id = rec.recruit_id
	 					WHERE recp.process_id = {$process_id}";
	 	$recruit_details = $this->db->query($interview_qry)->row_array();
	 	$template_data['dear'] = $recruit_details['firstname'].' '.$recruit_details['lastname'];
		$template_data['recipients'] = $recruit_details['firstname'].' '.$recruit_details['lastname'];
		
	 	$request_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_request rr 
	 					LEFT JOIN {$this->db->dbprefix}users_company uc ON rr.company_id = uc.company_id
	 					WHERE rr.request_id = {$recruit_details['request_id']}";
	 	$request_details = $this->db->query($request_qry)->row_array();
		$template_data['company_name'] = $request_details['company'];
		$template_data['interview_venue'] = $request_details['address'];
		$template_data['company_code'] = $request_details['company_code'];

	 	$comben_qry = "SELECT offben.* FROM {$this->db->dbprefix}recruitment_process_offer_compben offben
						LEFT JOIN {$this->db->dbprefix}recruitment_benefit comben ON offben.benefit_id = comben.benefit_id
						WHERE offben.process_id = {$process_id} AND comben.is_basic = 1";
	 	$compben = $this->db->query($comben_qry)->row_array();
		$template_data['basicsalary'] = $compben['amount'];

	 	$combens_qry = "SELECT offben.*, comben.benefit FROM {$this->db->dbprefix}recruitment_process_offer_compben offben
						LEFT JOIN {$this->db->dbprefix}recruitment_benefit comben ON offben.benefit_id = comben.benefit_id
						WHERE offben.process_id = {$process_id} AND comben.is_basic != 1";
	 	$compbens = $this->db->query($combens_qry)->result_array();
	 	$template_data['benefits'] = '';
	 	foreach($compbens as $benefit){
	 		$template_data['benefits'] .= '<li>* '.$benefit['benefit'].' : Php '.$benefit['amount'].'</li>';
	 	}

		$position_where = array( 'recruit_id' => $recruit_details['recruit_id'], 'key' => 'position_sought');
		$position_sought = $this->db->get_where( 'recruitment_personal', $position_where )->row_array();
		$template_data['position'] = $position_sought['key_value'];

	 	$hr_qry = "SELECT up.* FROM {$this->db->dbprefix}users_profile up
						LEFT JOIN {$this->db->dbprefix}users_position pos ON up.position_id = pos.position_id
						WHERE pos.position_code = 'HRM-RES'";
	 	$hr = $this->db->query($hr_qry)->row_array();
		$template_data['HRmanager'] = $hr['firstname'].' '.$hr['lastname'];

		$template_data['system_url'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'URL' LIMIT  1")->row_array();
    	$template_data['system_title'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'application_title' LIMIT  1")->row_array();
    	$template_data['system_author'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'author' LIMIT  1")->row_array();

		$this->load->model('applicants_model', 'recruit');
		$city_town = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'city_town');
		$vars['city_town'] = count($city_town) == 0 ? " " : $city_town[0]['key_value'] == "" ? "" : $city_town[0]['key_value'];
		$countries = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'country');
		$vars['country'] = count($countries) == 0 ? " " : $countries[0]['key_value'] == "" ? "" : $countries[0]['key_value'];
		$address_1 = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'address_1');
		$vars['address_1'] = count($address_1) == 0 ? " " : $address_1[0]['key_value'] == "" ? "" : $address_1[0]['key_value'];
		$address_2 = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'address_2');
		$vars['address_2'] = count($address_2) == 0 ? " " : $address_2[0]['key_value'] == "" ? "" : $address_2[0]['key_value'];
		$zip_code = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'zip_code');
		$vars['zip_code'] = count($zip_code) == 0 ? " " : $zip_code[0]['key_value'] == "" ? "" : $zip_code[0]['key_value'];
		$province = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'province');
		$vars['province'] = count($province) == 0 ? " " : $province[0]['key_value'] == "" ? "" : $province[0]['key_value'];
		$presentadd_no = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'presentadd_no');
		$vars['presentadd_no'] = count($presentadd_no) == 0 ? " " : $presentadd_no[0]['key_value'] == "" ? "" : $presentadd_no[0]['key_value'];
		$presentadd_village = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'presentadd_village');
		$vars['presentadd_village'] = count($presentadd_village) == 0 ? " " : $presentadd_village[0]['key_value'] == "" ? "" : $presentadd_village[0]['key_value'];
		$town = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'town');
		$vars['town'] = count($town) == 0 ? " " : $town[0]['key_value'] == "" ? "" : $town[0]['key_value'];
		
		$template_data['address1'] = $vars['presentadd_no'].' '.$vars['address_1'].' '.$vars['presentadd_village'].' '.$vars['address_2'];
		$template_data['address2'] = $vars['town'].' '.$vars['city_town'].' '.$vars['province'].' '.$vars['zip_code'];
        
        $this->load->helper('file');
		$this->load->library('parser');

       	$mrf_template = $this->db->get_where( 'system_template', array( 'code' => 'EMPLOYMENT-AGREEMENT') )->row_array();
		$this->parser->set_delimiters('{{', '}}');
		$html = $this->parser->parse_string($mrf_template['body'], $template_data, TRUE);

        $this->load->helper('file');
        $path = 'uploads/templates/employment_agreement/pdf/';
        $this->check_path( $path );
        $filename = $path .$template_data['dear']."-".$template_data['position']. "-".' Employment Agreement' .".pdf";

        $mpdf->WriteHTML($html, 0, true, false);
        $mpdf->Output($filename, 'F');

        $this->response->filename = $filename;
		$this->response->message[] = array(
			'message' => 'File successfully loaded.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function print_interview()
	{
		$this->_ajax_only();

		$process_id = $this->input->post('process_id');
    	$user = $this->config->item('user');

        $this->load->library('PDFm');
        $mpdf = new PDFm();

        $mpdf->SetTitle( 'Interview Assessment' );
        $mpdf->SetAutoPageBreak(true, 1);
        $mpdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $mpdf->SetDisplayMode('real', 'default');
        $mpdf->AddPage();


	 	$interview_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_process recp 
	 					LEFT JOIN {$this->db->dbprefix}recruitment rec ON recp.recruit_id = rec.recruit_id
	 					WHERE recp.process_id = {$process_id}";
	 	$recruit_details = $this->db->query($interview_qry)->row_array();
	 	$template_data['dear'] = $recruit_details['firstname'].' '.$recruit_details['lastname'];
		$template_data['recipients'] = $recruit_details['firstname'].' '.$recruit_details['lastname'];
		$template_data['date'] = date('M d Y',strtotime($recruit_details['recruitment_date']));

	 	$request_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_request rr 
	 					LEFT JOIN {$this->db->dbprefix}users_company uc ON rr.company_id = uc.company_id
	 					LEFT JOIN {$this->db->dbprefix}users_department ud ON rr.department_id = ud.department_id
	 					WHERE rr.request_id = {$recruit_details['request_id']}";
	 	$request_details = $this->db->query($request_qry)->row_array();
		$template_data['company_name'] = $request_details['company'];
		$template_data['company_code'] = $request_details['company_code'];
		$template_data['department'] = $request_details['department'];
		$template_data['logo'] = base_url().$request_details['print_logo'];
		$template_data['section'] = 'RECRUITMENT';

        $optional_requirements = $this->mrf_am->get_recruitment_request_key_value($recruit_details['request_id'], 'optional_requirements');
        $optional_requirements = count($optional_requirements) == 0 ? " " : $optional_requirements[0]['key_value'] == "" ? "" : $optional_requirements[0]['key_value'];
        $optional_requirements = unserialize($optional_requirements);
        $template_data['optional_requirements1'] = $optional_requirements[0];
        $template_data['optional_requirements2'] = $optional_requirements[1];
        $template_data['optional_requirements3'] = $optional_requirements[2];
		$position_where = array( 'recruit_id' => $recruit_details['recruit_id'], 'key' => 'position_sought');
		$position_sought = $this->db->get_where( 'recruitment_personal', $position_where )->row_array();
		$template_data['position'] = $position_sought['key_value'];
        // get recruitment interview details
        $recruitment_process_interview_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_process_interview rpi 
                        LEFT JOIN {$this->db->dbprefix}recruitment_process rp ON rpi.process_id = rp.process_id
                        WHERE rpi.process_id = {$process_id}";
        $recruit_inteview_details = $this->db->query($recruitment_process_interview_qry);
        if ($recruit_inteview_details && $recruit_inteview_details->num_rows() > 0){
        	$html = '';
        	foreach ($recruit_inteview_details->result() as $row) {
		        $recommendation = $this->mod->get_recruitment_interview_details($row->id, 'technical_recommendation');
		        if (count($recommendation) > 0){
		        	$recommendation_val = ($recommendation['key_value'] == "") ? "" : $recommendation['key_value'];
		        	$remarks = $this->mod->get_recruitment_interview_details($row->id, 'remarks');
		        	$remarks_val = ($remarks['key_value'] == "") ? "" : $remarks['key_value'];
		        	$interviewer = $this->mod->get_recruitment_interview_details($row->id, 'interviewer');
		        	$interviewer_val = ($interviewer['key_value'] == "") ? "" : $interviewer['key_value'];
		        	$interviewer_date = $this->mod->get_recruitment_interview_details($row->id, 'interviewer_date');
		        	$interviewer_date_val = ($interviewer_date['key_value'] == "") ? "" : $interviewer_date['key_value'];				        			        	
		        	$html .= '<tr>
		                <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;width:70%">'.$remarks_val.'</td>
		                <td style="width:30%;border-bottom: 1px solid #000;">
		                    <u>&nbsp;&nbsp;&nbsp;'.($recommendation_val == 'Consider' ? "X" : "&nbsp;&nbsp;").'&nbsp;&nbsp;&nbsp;</u> consider <br>
		                    <u>&nbsp;&nbsp;&nbsp;'.($recommendation_val == 'Hold' ? "X" : "&nbsp;&nbsp;").'&nbsp;&nbsp;&nbsp;</u> hold <br>
		                    <u>&nbsp;&nbsp;&nbsp;'.($recommendation_val == 'Reject' ? "X" : "&nbsp;&nbsp;").'&nbsp;&nbsp;&nbsp;</u> reject <br><br><br><br>
		                    By: <u>&nbsp;&nbsp;&nbsp;'.$interviewer_val.'&nbsp;&nbsp;&nbsp;</u> <br>
		                    Date: <u>&nbsp;&nbsp;&nbsp;'.$interviewer_date_val.'&nbsp;&nbsp;&nbsp;</u>
		                </td>
		            </tr> ';
		        }	        
        	}
        }

        $template_data['comments'] = $html;
/*
        $employment_status = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'employment_status');
        $template_data['employment_status'] = count($employment_status) == 0 ? " " : $employment_status['key_value'] == "" ? "" : $employment_status['key_value'];
        $salary = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'salary');
        $template_data['salary'] = count($salary) == 0 ? " " : $salary['key_value'] == "" ? "" : $salary['key_value'];
        $benefits = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'benefits');
        $template_data['benefits'] = count($benefits) == 0 ? " " : $benefits['key_value'] == "" ? "" : $benefits['key_value'];
        $working_schedule = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'working_schedule');
        $template_data['working_schedule'] = count($working_schedule) == 0 ? " " : $working_schedule['key_value'] == "" ? "" : $working_schedule['key_value'];
        $immediate_superior = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'immediate_superior');
        $template_data['immediate_superior'] = count($immediate_superior) == 0 ? " " : $immediate_superior['key_value'] == "" ? "" : $immediate_superior['key_value'];
        $expected_salary = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'expected_salary');
        $template_data['expected_salary'] = count($expected_salary) == 0 ? " " : $expected_salary['key_value'] == "" ? "" : $expected_salary['key_value'];
        $employment_type = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'employment_type');
        $template_data['employment_type'] = count($employment_type) == 0 ? " " : $employment_type['key_value'] == "" ? "" : $employment_type['key_value'];
        $pref_work_locations = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'pref_work_locations');
        $template_data['pref_work_locations'] = count($pref_work_locations) == 0 ? " " : $pref_work_locations['key_value'] == "" ? "" : $pref_work_locations['key_value'];
        $pref_work_schedule = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'pref_work_schedule');
        $template_data['pref_work_schedule'] = count($pref_work_schedule) == 0 ? " " : $pref_work_schedule['key_value'] == "" ? "" : $pref_work_schedule['key_value'];
        $avail_client_int = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'avail_client_int');
        $template_data['avail_client_int'] = count($avail_client_int) == 0 ? " " : $avail_client_int['key_value'] == "" ? "" : $avail_client_int['key_value'];
        $avail_employment = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'avail_employment');
        $template_data['avail_employment'] = count($avail_employment) == 0 ? " " : $avail_employment['key_value'] == "" ? "" : $avail_employment['key_value'];
        $pending_applications = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'pending_applications');
        $template_data['pending_applications'] = count($pending_applications) == 0 ? " " : $pending_applications['key_value'] == "" ? "" : $pending_applications['key_value'];
        $reason_for_leaving = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'reason_for_leaving');
        $template_data['reason_for_leaving'] = count($reason_for_leaving) == 0 ? " " : $reason_for_leaving['key_value'] == "" ? "" : $reason_for_leaving['key_value'];
        $competencies = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'competencies');
        $template_data['competencies'] = count($competencies) == 0 ? " " : $competencies['key_value'] == "" ? "" : $competencies['key_value'];
        $personality = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'personality');
        $template_data['personality'] = count($personality) == 0 ? " " : $personality['key_value'] == "" ? "" : $personality['key_value'];
        $hr_remarks = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'hr_remarks');
        $template_data['hr_remarks'] = count($hr_remarks) == 0 ? " " : $hr_remarks['key_value'] == "" ? "" : $hr_remarks['key_value'];
        $interviewers_notes = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'interviewers_notes');
        $template_data['interviewers_notes'] = count($interviewers_notes) == 0 ? " " : $interviewers_notes['key_value'] == "" ? "" : $interviewers_notes['key_value'];
        $remarks = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'remarks');
        $template_data['remarks'] = count($remarks) == 0 ? " " : $remarks['key_value'] == "" ? "" : $remarks['key_value'];
        $technical_recommendation = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'technical_recommendation');
        $template_data['technical_recommendation'] = count($technical_recommendation) == 0 ? " " : $technical_recommendation['key_value'] == "" ? "" : $technical_recommendation['key_value'];
        $interviewer_date = $this->mod->get_recruitment_interview_details($recruit_inteview_details['id'], 'interviewer_date');
        $template_data['interviewer_date'] = count($interviewer_date) == 0 ? " " : $interviewer_date['key_value'] == "" ? "" : $interviewer_date['key_value'];
        
		$template_data['desired_salary'] = '';*/
		
		$template_data['system_url'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'URL' LIMIT  1")->row_array();
    	$template_data['system_title'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'application_title' LIMIT  1")->row_array();
    	$template_data['system_author'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'author' LIMIT  1")->row_array();

        $this->load->helper('file');
		$this->load->library('parser');

       	$mrf_template = $this->db->get_where( 'system_template', array( 'code' => 'INTERVIEW-ASSESSMENT', 'deleted' => 0) )->row_array();
		$this->parser->set_delimiters('{{', '}}');
		$html = $this->parser->parse_string($mrf_template['body'], $template_data, TRUE);

        $this->load->helper('file');
        $path = 'uploads/templates/interview/pdf/';
        $this->check_path( $path );
        $filename = $path .$template_data['dear']."-".$template_data['position']. "-".'Interview Assessment' .".pdf";

        $mpdf->WriteHTML($html, 0, true, false);
        $mpdf->Output($filename, 'F');

        $this->response->filename = $filename;
		$this->response->message[] = array(
			'message' => 'File successfully loaded.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function print_bi()
	{
		$this->_ajax_only();

		$process_id = $this->input->post('process_id');
/*		$jo = $this->db->get_where('recruitment_process_offer', array('process_id' => $process_id));*/

    	$user = $this->config->item('user');

        $this->load->library('PDFm');
        $mpdf = new PDFm();

        $mpdf->SetTitle( 'Background Investigation' );
        $mpdf->SetAutoPageBreak(true, 1);
        $mpdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $mpdf->SetDisplayMode('real', 'default');
        $mpdf->AddPage();

/*		$offer = $jo->row_array();
		$template_data['date'] = date('F d, Y');
		$template_data['start_date'] = date('F d, Y', strtotime($offer['start_date']));
		if(strtotime($offer['end_date'])){
			$template_data['end_probi_date'] = date('F d, Y', strtotime($offer['end_date']));
		}else{
			$template_data['end_probi_date'] = '';
		}*/

/*	 	$immediate_qry = "SELECT pos.* FROM {$this->db->dbprefix}users_profile up
					LEFT JOIN {$this->db->dbprefix}users_position pos ON up.position_id = pos.position_id
					WHERE up.user_id = {$offer['reports_to']}";
	 	$immediate = $this->db->query($immediate_qry)->row_array();
		$template_data['immediateposition'] = $immediate['position'];*/

		$this->db->where('recruitment_process_background.process_id',$process_id);
		$bi_header = $this->db->get('recruitment_process_background');
		if ($bi_header && $bi_header->num_rows() > 0){
			$bi_header_row = $bi_header->row();
		}

	 	$template_data['date'] = 'MARCH 01, 2013';
	 	$template_data['date_created'] = date('F d, Y',strtotime($bi_header_row->created_on));
	 	$interview_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_process recp 
	 					LEFT JOIN {$this->db->dbprefix}recruitment rec ON recp.recruit_id = rec.recruit_id
	 					WHERE recp.process_id = {$process_id}";
	 	$recruit_details = $this->db->query($interview_qry)->row_array();
	 	$template_data['dear'] = $recruit_details['firstname'].' '.$recruit_details['lastname'];
		$template_data['recipients'] = $recruit_details['firstname'].' '.$recruit_details['lastname'];
		$template_data['lastname'] = $recruit_details['lastname'];
		$template_data['firstname'] = $recruit_details['firstname'];
		$template_data['middlename'] = $recruit_details['middlename'];
		$template_data['section'] = 'RECRUITMENT';

	 	$request_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_request rr 
	 					LEFT JOIN {$this->db->dbprefix}users_company uc ON rr.company_id = uc.company_id
	 					LEFT JOIN {$this->db->dbprefix}users_department ud ON rr.department_id = ud.department_id
	 					WHERE rr.request_id = {$recruit_details['request_id']}";
	 	$request_details = $this->db->query($request_qry)->row_array();
		$template_data['company_name'] = $request_details['company'];
		$template_data['interview_venue'] = $request_details['address'];
		$template_data['company_code'] = $request_details['company_code'];
		$template_data['department'] = $request_details['department'];
		$template_data['logo'] = base_url().$request_details['print_logo'];

		$position_where = array( 'recruit_id' => $recruit_details['recruit_id'], 'key' => 'position_sought');
		$position_sought = $this->db->get_where( 'recruitment_personal', $position_where )->row_array();
		$template_data['position'] = $position_sought['key_value'];

	 	$hr_qry = "SELECT up.* FROM {$this->db->dbprefix}users_profile up
						LEFT JOIN {$this->db->dbprefix}users_position pos ON up.position_id = pos.position_id
						WHERE pos.position_code = 'HRM-RES'";
	 	$hr = $this->db->query($hr_qry)->row_array();
		$template_data['HRmanager'] = $hr['firstname'].' '.$hr['lastname'];

		$template_data['system_url'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'URL' LIMIT  1")->row_array();
    	$template_data['system_title'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'application_title' LIMIT  1")->row_array();
    	$template_data['system_author'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'author' LIMIT  1")->row_array();

		$this->db->where('recruitment_process_background.process_id',$process_id);
		$this->db->join('recruitment_process_background_items','recruitment_process_background.rpb_id = recruitment_process_background_items.rpb_id');
		$work_related['result'] = $this->db->get('recruitment_process_background');

		$prev_work_related = $this->load->view('forms/bi_forms_print', $work_related, true);

		$template_data['prev_work_related'] = $prev_work_related;
		$template_data['address1'] = $vars['presentadd_no'].' '.$vars['address_1'].' '.$vars['presentadd_village'].' '.$vars['address_2'];
		$template_data['address2'] = $vars['town'].' '.$vars['city_town'].' '.$vars['province'].' '.$vars['zip_code'];
        
        $this->load->helper('file');
		$this->load->library('parser');

       	$mrf_template = $this->db->get_where( 'system_template', array( 'code' => 'BACKGROUND-CHECK-FORM') )->row_array();
		$this->parser->set_delimiters('{{', '}}');
		$html = $this->parser->parse_string($mrf_template['body'], $template_data, TRUE);

        $this->load->helper('file');
        $path = 'uploads/templates/background_check/pdf/';
        $this->check_path( $path );
        $filename = $path .$template_data['dear']."-".$template_data['position']. "-".' Background Check Form' .".pdf";

        $mpdf->WriteHTML($html, 0, true, false);
        $mpdf->Output($filename, 'F');

        $this->response->filename = $filename;
		$this->response->message[] = array(
			'message' => 'File successfully loaded.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}


	function print_preemp_checklist()
	{
		$this->_ajax_only();

		$process_id = $this->input->post('process_id');
		$jo = $this->db->get_where('recruitment_process_offer', array('process_id' => $process_id));

    	$user = $this->config->item('user');

        $this->load->library('PDFm');
        $mpdf = new PDFm();

        $mpdf->SetTitle( 'Pre-employment Checklist' );
        $mpdf->SetAutoPageBreak(true, 1);
        $mpdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $mpdf->SetDisplayMode('real', 'default');
        $mpdf->AddPage();

		$offer = $jo->row_array();
		$template_data['date'] = date('F d, Y');
		$template_data['start_date'] = date('F d, Y', strtotime($offer['start_date']));
		if(strtotime($offer['end_date'])){
			$template_data['end_probi_date'] = date('F d, Y', strtotime($offer['end_date']));
		}else{
			$template_data['end_probi_date'] = '';
		}

	 	$interview_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_process recp 
	 					LEFT JOIN {$this->db->dbprefix}recruitment rec ON recp.recruit_id = rec.recruit_id
	 					WHERE recp.process_id = {$process_id}";
	 	$recruit_details = $this->db->query($interview_qry)->row_array();
	 	$template_data['dear'] = $recruit_details['firstname'].' '.$recruit_details['lastname'];
		$template_data['recipients'] = $recruit_details['firstname'].' '.$recruit_details['lastname'];

	 	$request_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_request rr 
	 					LEFT JOIN {$this->db->dbprefix}users_company uc ON rr.company_id = uc.company_id
	 					LEFT JOIN {$this->db->dbprefix}users_department ud ON rr.department_id = ud.department_id
	 					WHERE rr.request_id = {$recruit_details['request_id']}";
	 	$request_details = $this->db->query($request_qry)->row_array();
		$template_data['company_name'] = $request_details['company'];
		$template_data['interview_venue'] = $request_details['address'];
		$template_data['company_code'] = $request_details['company_code'];
		$template_data['department'] = $request_details['department'];

		$position_where = array( 'recruit_id' => $recruit_details['recruit_id'], 'key' => 'position_sought');
		$position_sought = $this->db->get_where( 'recruitment_personal', $position_where )->row_array();
		$template_data['position'] = $position_sought['key_value'];

		$template_data['system_url'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'URL' LIMIT  1")->row_array();
    	$template_data['system_title'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'application_title' LIMIT  1")->row_array();
    	$template_data['system_author'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'author' LIMIT  1")->row_array();

        $this->load->helper('file');
		$this->load->library('parser');

       	$mrf_template = $this->db->get_where( 'system_template', array( 'code' => 'PRE-EMPLOYMENT-CHECKLIST') )->row_array();
		$this->parser->set_delimiters('{{', '}}');
		$html = $this->parser->parse_string($mrf_template['body'], $template_data, TRUE);

        $this->load->helper('file');
        $path = 'uploads/templates/preemployment_checklist/pdf/';
        $this->check_path( $path );
        $filename = $path .$template_data['dear']."-".$template_data['position']. "-".' Pre-employment Checklist' .".pdf";

        $mpdf->WriteHTML($html, 0, true, false);
        $mpdf->Output($filename, 'F');

        $this->response->filename = $filename;
		$this->response->message[] = array(
			'message' => 'File successfully loaded.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}


	function print_jd()
	{
		$this->_ajax_only();

		$process_id = $this->input->post('process_id');
		$jo = $this->db->get_where('recruitment_process_offer', array('process_id' => $process_id));

    	$user = $this->config->item('user');

        $this->load->library('PDFm');
        $mpdf = new PDFm();

        $mpdf->SetTitle( 'Job Description' );
        $mpdf->SetAutoPageBreak(true, 1);
        $mpdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $mpdf->SetDisplayMode('real', 'default');
        $mpdf->AddPage();

		$offer = $jo->row_array();
		$template_data['date'] = date('F d, Y');
		$template_data['start_date'] = date('F d, Y', strtotime($offer['start_date']));
		if(strtotime($offer['end_date'])){
			$template_data['end_probi_date'] = date('F d, Y', strtotime($offer['end_date']));
		}else{
			$template_data['end_probi_date'] = '';
		}
	 	
	 	$interview_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_process recp 
	 					LEFT JOIN {$this->db->dbprefix}recruitment rec ON recp.recruit_id = rec.recruit_id
	 					WHERE recp.process_id = {$process_id}";
	 	$recruit_details = $this->db->query($interview_qry)->row_array();
	 	$template_data['dear'] = $recruit_details['firstname'].' '.$recruit_details['lastname'];
		$template_data['recipients'] = $recruit_details['firstname'].' '.$recruit_details['lastname'];
		
	 	$immediate_qry = "SELECT up.* FROM {$this->db->dbprefix}users_profile up
					LEFT JOIN {$this->db->dbprefix}users_position pos ON up.position_id = pos.position_id
					WHERE up.user_id = {$offer['reports_to']}";
	 	$immediate = $this->db->query($immediate_qry)->row_array();	
		$template_data['reportsto'] = $immediate['firstname'].' '.$immediate['lastname'];
		$template_data['nextlevelsuperior'] = '';
		$template_data['supervises'] = '';
		$template_data['coordinates'] = '';
		$template_data['jobmissions_purpose'] = '';
		$template_data['knowledge'] = '';
		$template_data['skills'] = '';
		$template_data['abilities_behavior'] = '';
		$template_data['academic_professional'] = '';
		$template_data['requirements'] = '';
		$template_data['licensure'] = '';
		$template_data['certificates'] = '';
		if($immediate['reports_to_id'] > 0){
		 	$superior_qry = "SELECT up.* FROM {$this->db->dbprefix}users_profile up
						LEFT JOIN {$this->db->dbprefix}users_position pos ON up.position_id = pos.position_id
						WHERE up.user_id = {$immediate['reports_to_id']}";
		 	$superior = $this->db->query($superior_qry)->row_array();	
			$template_data['nextlevelsuperior'] = $superior['firstname'].' '.$superior['lastname'];
		}

	 	$request_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_request rr 
	 					LEFT JOIN {$this->db->dbprefix}users_company uc ON rr.company_id = uc.company_id
	 					LEFT JOIN {$this->db->dbprefix}users_department ud ON rr.department_id = ud.department_id
	 					WHERE rr.request_id = {$recruit_details['request_id']}";
	 	$request_details = $this->db->query($request_qry)->row_array();
		$template_data['company_name'] = $request_details['company'];
		$template_data['interview_venue'] = $request_details['address'];
		$template_data['company_code'] = $request_details['company_code'];
		$template_data['department'] = $request_details['department'];

		$position_where = array( 'recruit_id' => $recruit_details['recruit_id'], 'key' => 'position_sought');
		$position_sought = $this->db->get_where( 'recruitment_personal', $position_where )->row_array();
		$template_data['position'] = $position_sought['key_value'];

	 	$hr_qry = "SELECT up.* FROM {$this->db->dbprefix}users_profile up
						LEFT JOIN {$this->db->dbprefix}users_position pos ON up.position_id = pos.position_id
						WHERE pos.position_code = 'HRM-RES'";
	 	$hr = $this->db->query($hr_qry)->row_array();
		$template_data['HRmanager'] = $hr['firstname'].' '.$hr['lastname'];

		$template_data['system_url'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'URL' LIMIT  1")->row_array();
    	$template_data['system_title'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'application_title' LIMIT  1")->row_array();
    	$template_data['system_author'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'author' LIMIT  1")->row_array();

		$this->load->model('applicants_model', 'recruit');
		$city_town = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'city_town');
		$vars['city_town'] = count($city_town) == 0 ? " " : $city_town[0]['key_value'] == "" ? "" : $city_town[0]['key_value'];
		$countries = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'country');
		$vars['country'] = count($countries) == 0 ? " " : $countries[0]['key_value'] == "" ? "" : $countries[0]['key_value'];
		$address_1 = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'address_1');
		$vars['address_1'] = count($address_1) == 0 ? " " : $address_1[0]['key_value'] == "" ? "" : $address_1[0]['key_value'];
		$address_2 = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'address_2');
		$vars['address_2'] = count($address_2) == 0 ? " " : $address_2[0]['key_value'] == "" ? "" : $address_2[0]['key_value'];
		$zip_code = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'zip_code');
		$vars['zip_code'] = count($zip_code) == 0 ? " " : $zip_code[0]['key_value'] == "" ? "" : $zip_code[0]['key_value'];
		$province = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'province');
		$vars['province'] = count($province) == 0 ? " " : $province[0]['key_value'] == "" ? "" : $province[0]['key_value'];
		$presentadd_no = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'presentadd_no');
		$vars['presentadd_no'] = count($presentadd_no) == 0 ? " " : $presentadd_no[0]['key_value'] == "" ? "" : $presentadd_no[0]['key_value'];
		$presentadd_village = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'presentadd_village');
		$vars['presentadd_village'] = count($presentadd_village) == 0 ? " " : $presentadd_village[0]['key_value'] == "" ? "" : $presentadd_village[0]['key_value'];
		$town = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'town');
		$vars['town'] = count($town) == 0 ? " " : $town[0]['key_value'] == "" ? "" : $town[0]['key_value'];
		
		$template_data['address1'] = $vars['presentadd_no'].' '.$vars['address_1'].' '.$vars['presentadd_village'].' '.$vars['address_2'];
		$template_data['address2'] = $vars['town'].' '.$vars['city_town'].' '.$vars['province'].' '.$vars['zip_code'];
        
        $this->load->helper('file');
		$this->load->library('parser');

       	$mrf_template = $this->db->get_where( 'system_template', array( 'code' => 'JOB-DESCRIPTION') )->row_array();
		$this->parser->set_delimiters('{{', '}}');
		$html = $this->parser->parse_string($mrf_template['body'], $template_data, TRUE);

        $this->load->helper('file');
        $path = 'uploads/templates/job_description/pdf/';
        $this->check_path( $path );
        $filename = $path .$template_data['dear']."-".$template_data['position']. "-".' Job Description' .".pdf";

        $mpdf->WriteHTML($html, 0, true, false);
        $mpdf->Output($filename, 'F');

        $this->response->filename = $filename;
		$this->response->message[] = array(
			'message' => 'File successfully loaded.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function print_nondisclosure()
	{
		$this->_ajax_only();

		$process_id = $this->input->post('process_id');
		$jo = $this->db->get_where('recruitment_process_offer', array('process_id' => $process_id));

		if($jo->num_rows() == 0){
			$this->response->message[] = array(
				'message' => 'Please fillout first Job Offer details before sending email.',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

    	$user = $this->config->item('user');
        $this->load->library('PDFm');
        $mpdf=new PDFm();

        $mpdf->SetTitle( 'Non-disclosure Agreement' );
        $mpdf->SetAutoPageBreak(true, 1);
        $mpdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $mpdf->SetDisplayMode('real', 'default');
        $mpdf->AddPage();

		$offer = $jo->row_array();
		$template_data['date'] = date('F d, Y');
		$template_data['start_date'] = date('F d, Y', strtotime($offer['start_date']));
		if(strtotime($offer['end_date'])){
			$template_data['end_probi_date'] = date('F d, Y', strtotime($offer['end_date']));
		}else{
			$template_data['end_probi_date'] = '';
		}
	 	
	 	$interview_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_process recp 
	 					LEFT JOIN {$this->db->dbprefix}recruitment rec ON recp.recruit_id = rec.recruit_id
	 					WHERE recp.process_id = {$process_id}";
	 	$recruit_details = $this->db->query($interview_qry)->row_array();
	 	$template_data['dear'] = $recruit_details['firstname'].' '.$recruit_details['lastname'];
		$template_data['recipients'] = $recruit_details['firstname'].' '.$recruit_details['lastname'];
		
	 	$request_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_request rr 
	 					LEFT JOIN {$this->db->dbprefix}users_company uc ON rr.company_id = uc.company_id
	 					WHERE rr.request_id = {$recruit_details['request_id']}";
	 	$request_details = $this->db->query($request_qry)->row_array();
		$template_data['company_name'] = $request_details['company'];
		$template_data['company_address'] = $request_details['address'];
		$template_data['company_code'] = $request_details['company_code'];

	 	$hr_qry = "SELECT up.* FROM {$this->db->dbprefix}users_profile up
						LEFT JOIN {$this->db->dbprefix}users_position pos ON up.position_id = pos.position_id
						WHERE pos.position_code = 'HRM-RES'";
	 	$hr = $this->db->query($hr_qry)->row_array();
		$template_data['HRmanager'] = $hr['firstname'].' '.$hr['lastname'];

		$template_data['system_url'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'URL' LIMIT  1")->row_array();
    	$template_data['system_title'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'application_title' LIMIT  1")->row_array();
    	$template_data['system_author'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'author' LIMIT  1")->row_array();

		$this->load->model('applicants_model', 'recruit');
		$city_town = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'city_town');
		$vars['city_town'] = count($city_town) == 0 ? " " : $city_town[0]['key_value'] == "" ? "" : $city_town[0]['key_value'];
		$countries = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'country');
		$vars['country'] = count($countries) == 0 ? " " : $countries[0]['key_value'] == "" ? "" : $countries[0]['key_value'];
		$address_1 = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'address_1');
		$vars['address_1'] = count($address_1) == 0 ? " " : $address_1[0]['key_value'] == "" ? "" : $address_1[0]['key_value'];
		$address_2 = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'address_2');
		$vars['address_2'] = count($address_2) == 0 ? " " : $address_2[0]['key_value'] == "" ? "" : $address_2[0]['key_value'];
		$zip_code = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'zip_code');
		$vars['zip_code'] = count($zip_code) == 0 ? " " : $zip_code[0]['key_value'] == "" ? "" : $zip_code[0]['key_value'];
		$province = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'province');
		$vars['province'] = count($province) == 0 ? " " : $province[0]['key_value'] == "" ? "" : $province[0]['key_value'];
		$presentadd_no = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'presentadd_no');
		$vars['presentadd_no'] = count($presentadd_no) == 0 ? " " : $presentadd_no[0]['key_value'] == "" ? "" : $presentadd_no[0]['key_value'];
		$presentadd_village = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'presentadd_village');
		$vars['presentadd_village'] = count($presentadd_village) == 0 ? " " : $presentadd_village[0]['key_value'] == "" ? "" : $presentadd_village[0]['key_value'];
		$town = $this->recruit->get_recruitment_personal_value($recruit_details['recruit_id'], 'town');
		$vars['town'] = count($town) == 0 ? " " : $town[0]['key_value'] == "" ? "" : $town[0]['key_value'];
		
		$template_data['address1'] = $vars['presentadd_no'].' '.$vars['address_1'].' '.$vars['presentadd_village'].' '.$vars['address_2'];
		$template_data['address2'] = $vars['town'].' '.$vars['city_town'].' '.$vars['province'].' '.$vars['zip_code'];
        
        $this->load->helper('file');
		$this->load->library('parser');

       	$mrf_template = $this->db->get_where( 'system_template', array( 'code' => 'NON-DISCLOSURE') )->row_array();
		$this->parser->set_delimiters('{{', '}}');
		$html = $this->parser->parse_string($mrf_template['body'], $template_data, TRUE);

        $this->load->helper('file');
        $path = 'uploads/templates/nondisclosure_agreement/pdf/';
        $this->check_path( $path );
        $filename = $path .$template_data['dear']."-".$template_data['position']. "-".'Non-disclosure Agreement' .".pdf";

        $mpdf->WriteHTML($html, 0, true, false);
        $mpdf->Output($filename, 'F');

        $this->response->filename = $filename;
		$this->response->message[] = array(
			'message' => 'File successfully loaded.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	private function check_path( $path, $create = true )
	{
		if( !is_dir( FCPATH . $path ) ){
			if( $create )
			{
				$folders = explode('/', $path);
				$cur_path = FCPATH;
				foreach( $folders as $folder )
				{
					$cur_path .= $folder;

					if( !is_dir( $cur_path ) )
					{
						mkdir( $cur_path, 0777, TRUE);
						$indexhtml = read_file( APPPATH .'index.html');
		                write_file( $cur_path .'/index.html', $indexhtml);
					}

					$cur_path .= '/';
				}
			}
			return false;
		}
		return true;
	}

	function add_exam_form() {
		$this->_ajax_only();
		$data=array();
		// $data['form_value'] = $this->input->post('form_value');

		$this->load->helper('file');
		$this->response->add_form = $this->load->view('forms/sub/exam_form', $data, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();
	}

	function add_sched_row() {
		$this->_ajax_only();
		$data=array();
		// $data['form_value'] = $this->input->post('form_value');

		$this->load->helper('form');
		$this->load->helper('file');
		$this->response->add_form = $this->load->view('forms/sub/sched_form', $data, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();
	}
	
}

