<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Applicant_interviewer_monitoring extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('applicant_interviewer_monitoring_model', 'mod');
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
		$this->load->model('mrf_model', 'mrf');
		
		$vars['request_id'] = "";
		$vars['mrf'] = $this->mrf->get_active_mrf_by_year_interviewer();

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

		$request_id = $this->input->post('request_id');
		$year = $this->input->post('year');
		$user_id = $this->user->user_id;
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
				$step[$_step->status_id]['recruit'] = array();
				$qry = "select a.*,c.user_id as `requestor_id`, concat(b.firstname, ' ', b.lastname) as fullname, b.blacklisted, d.user_id as interviewer
				FROM {$this->db->dbprefix}recruitment_process a
				LEFT JOIN {$this->db->dbprefix}recruitment b on b.recruit_id = a.recruit_id
				LEFT JOIN {$this->db->dbprefix}recruitment_request c ON c.request_id = b.request_id
				LEFT JOIN {$this->db->dbprefix}recruitment_process_schedule d on d.process_id = a.process_id
				WHERE a.status_id = {$_step->status_id} AND a.request_id = {$request_id} and a.deleted = 0
				 GROUP BY d.process_id";

				$recruits = $this->db->query( $qry );
				
				foreach( $recruits->result() as $recruit )
				{
					$step[$_step->status_id]['recruit'][] = $recruit;	
				}	
			}
		}
		else{
			$mrf =  new stdClass();
			$mrf->position = "All " . $year;

			foreach($_steps->result() as $_step)
			{
				$step[$_step->status_id]['step'] = $_step;
				$step[$_step->status_id]['recruit'] = array();
				$qry = "select b.user_id as `requestor_id`, a.*, concat(c.firstname, ' ', c.lastname) as fullname, c.blacklisted , d.user_id as interviewer
				FROM {$this->db->dbprefix}recruitment_process a
				LEFT JOIN {$this->db->dbprefix}recruitment_request b ON b.request_id = a.request_id
				LEFT JOIN {$this->db->dbprefix}recruitment c on c.recruit_id = a.recruit_id
				LEFT JOIN {$this->db->dbprefix}recruitment_process_schedule d on d.process_id = a.process_id
				WHERE a.status_id = {$_step->status_id} AND YEAR(b.created_on) = {$year} AND b.deleted = 0 AND a.deleted = 0
				 GROUP BY d.process_id";
				
				$qry .= " ORDER BY a.created_on ASC";
				
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
			foreach ($_step['recruit'] as $key => $value) {
				if($value->interviewer != $user_id)
					if($value->requestor_id != $user_id) 
						unset($_step['recruit'][$key]);
			}
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
		$vars['process'] = $process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
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

		$this->response->schedule_form = $this->load->view('forms/schedule', $vars, true);
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function save_schedule()
	{
		$this->_ajax_only();

		$process_id = $this->input->post('process_id');
		$dates = $this->input->post('sched_date');
		$user_id = $this->input->post('sched_user_id');
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


			$process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
			$recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
			$this->load->model('system_feed');

			foreach( $dates as $index => $date )
			{
				$insert = array(
					'process_id' => $process_id,
					'date' => date('Y-m-d', strtotime( $date )),
					'user_id' => $user_id[$index]
				);

				$this->db->limit(1);
				$check = $this->db->get_where('recruitment_process_schedule', array('process_id' => $process_id, 'user_id' => $user_id[$index]));
				if( $check->num_rows() == 1 )
				{
					$sched = $check->row();
					$this->db->update('recruitment_process_schedule', $insert, array('schedule_id' => $sched->schedule_id));
				
					if( $sched->status_id == 0 )
					{
						$feed = array(
	                        'status' => 'info',
	                        'message_type' => 'Personnel',
	                        'user_id' => $this->user->user_id,
	                        'feed_content' => lang('applicant_monitoring.scheduled_interview_update', $recruit->firstname.' '.$recruit->lastname),
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
					$this->db->insert('recruitment_process_interview', array('schedule_id' => $schedule_id)); 

					$feed = array(
                        'status' => 'info',
                        'message_type' => 'Personnel',
                        'user_id' => $this->user->user_id,
                        'feed_content' => lang('applicant_monitoring.scheduled_interview', $recruit->firstname.' '.$recruit->lastname),
                        'uri' => $this->mod->route,
                        'recipient_id' => $user_id[$index]
                    );
                    $recipients = array($user_id[$index]);
                    $this->system_feed->add( $feed, $recipients );

                    $this->response->notify[] = $user_id[$index];
				}
			}

			$this->response->saved = true;
			if( $process->status_id == 1 )
			{
				$update_data = array('status_id' => 2, 
										'modified_by' => $this->user->user_id,
										'modified_on' => date('Y-m-d H:i:s')
									);
				$this->db->update('recruitment_process', $update_data, array('process_id' => $process_id));
				$this->db->update('recruitment', $update_data, array('recruit_id' => $process->recruit_id));
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

		$vars['process_id'] = $process_id = $this->input->post('process_id');
		$vars['process'] = $process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		$vars['recruit'] = $recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
		
		$vars['position'] = "";
		$vars['phone'] = "";
		$vars['mobile'] = "";
		$vars['user_id'] = $this->user->user_id;

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
		
		$this->response->interview_list = $this->load->view('forms/interview_list', $vars, true);
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
		$vars['is_disabled'] = $this->input->post('is_disabled');
		
		$vars['sched'] = $sched = $this->mod->get_sched( $schedule_id );
		$this->db->limit(1);
		$vars['interview'] = $this->db->get_where('recruitment_process_interview', array('schedule_id' => $schedule_id))->row();
		
		$qry = "select a.*, concat(b.firstname, ' ', b.lastname) as fullname
		FROM {$this->db->dbprefix}recruitment_process a
		LEFT JOIN {$this->db->dbprefix}recruitment b on b.recruit_id = a.recruit_id
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
			$keys[$data['key_class_id']]['other_remarks'] = $data['other_remarks'];

			$interviewKeys_sql = "SELECT * FROM {$this->db->dbprefix}recruitment_interview_key 
									WHERE deleted = 0 AND key_class_id = {$data['key_class_id']} 
									";
			$interviewKeys = $this->db->query( $interviewKeys_sql )->result_array();
				$keys[$data['key_class_id']]['keys'] = $interviewKeys;
		}
		$vars['details'] = $keys;

		$this->load->helper('form');
		$this->response->interview_form = $this->load->view('forms/interview', $vars, true);
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function save_interview()
	{
		$this->_ajax_only();
		
		$interview = $this->input->post('interview');
		$interview_details = $this->input->post('recruitment_interview_details');
		$interview_result = $interview_details['result']['key_value'];
		$this->response->process_id = $process_id = $this->input->post('process_id');
		$status_id = $this->input->post('status_id');
		$interview_id = $this->input->post('interview_id');

		$process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		
		$interview_update = array(
							'process_id' =>	$process_id,
							'modified_by' => $this->user->user_id,
							'modified_on' => date('Y-m-d H:i:s')
							);

		if( $interview_result == 'Passed' )
		{
			$interview_update['result_id'] = '1';
			$interview_update['result'] = 'Passed';
			if( $status_id == 2 && $interview_result == 'Passed' )
			{
				$update_data = array('status_id' => 3,
									'modified_by' => $this->user->user_id,
									'modified_on' => date('Y-m-d H:i:s')
									);

				
				$this->db->update('recruitment_process', $update_data, array('process_id' => $process_id));		
				$this->db->update('recruitment', $update_data, array('recruit_id' => $process->recruit_id));
			}
		}
		else if( $interview_result == 'Failed' ){
			$recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
			$this->load->model('system_feed');
			$feed = array(
                'status' => 'info',
                'message_type' => 'Personnel',
                'user_id' => $this->user->user_id,
                'feed_content' => lang('applicant_monitoring.failed_interview', $recruit->firstname.' '.$recruit->lastname),
                'uri' => $this->mod->route,
                'recipient_id' => 1
            );
            $recipients = array(1);
            $this->system_feed->add( $feed, $recipients );

            $this->response->notify[] = 1;

            $interview_update['result_id'] = '2';
			$interview_update['result'] = 'Failed';
		}

		foreach($interview_details as $index => $keys){
			/*if($index == "salary_expectation")
			{
				if(!is_numeric($keys['key_value']))
				{
					$this->response->validate = true;
					$this->response->message[] = array(
						'message' => 'Salary Expection should be numeric',
						'type' => 'warning'
					);
					$this->_ajax_return();
				}
			}
*/
			$key_details = $this->db->get_where('recruitment_interview_key', array('key_code' => $index))->row_array();			
			
			$details_where = array('key' => $index, 'interview_id' => $interview_id);
			$key_exist = $this->db->get_where('recruitment_interview_details', $details_where);	

			$records['interview_id'] = $interview_id;
			$records['key_id'] = $key_details['key_id'];
			$records['key'] = $key_details['key_code'];
			$records['sequence'] = 1;

			if(is_array($keys['key_value'])){
				$this->db->delete('recruitment_interview_details', $details_where);
				foreach($keys['key_value'] as $keyVal_index => $keyVal){
					$records['key_name'] = $keys['key_name'][$keyVal_index];
					$records['created_by'] = $this->user->user_id;
					$records['key_value'] = $keyVal;
					$records['sequence'] = $keyVal_index + 1;
					$this->db->insert('recruitment_interview_details', $records);
				}
			}else{
				$records['key_name'] = $key_details['key_label'];
				$records['key_value'] = $keys['key_value'];
				switch ($key_exist->num_rows()){
					case 0:
						$records['created_by'] = $this->user->user_id;
						$this->db->insert('recruitment_interview_details', $records);
					break;
					case 1:
						$records['modified_by'] = $this->user->user_id;
						$records['modified_on'] = date('Y-m-d H:i:s');
						$this->db->update('recruitment_interview_details', $records, $details_where);
					break;
				}
			}

			if(isset($keys['other_remarks'])){
				$other_remarks['other_remarks'] = $keys['other_remarks'];
				$this->db->update('recruitment_interview_details', $other_remarks, $details_where);
			}
		}

		$this->db->update('recruitment_process_interview', $interview_update, array('schedule_id' => $interview['schedule_id']));

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
		$process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		$update_data = array('status_id' => 4,
							'modified_by' => $this->user->user_id,
							'modified_on' => date('Y-m-d H:i:s')
							);
		$this->db->update('recruitment_process', $update_data, array('process_id' => $process_id));
		$this->db->update('recruitment', $update_data, array('recruit_id' => $process->recruit_id));

		$this->response->message[] = array(
			'message' => '',
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

		$process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		$update_data = array('status_id' => 5,
							'modified_by' => $this->user->user_id,
							'modified_on' => date('Y-m-d H:i:s')
							);
		$this->db->update('recruitment_process', $update_data, array('process_id' => $process_id));
		$this->db->update('recruitment', $update_data, array('recruit_id' => $process->recruit_id));

		$this->db->limit(1);
		$check = $this->db->get_where('recruitment_process_signing', array('process_id' => $process_id));
		if( $check->num_rows() == 0 )
		{
			$this->db->insert('recruitment_process_signing', array('process_id' => $process_id, 'accepted' => 1));
		}

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
		$process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		$update_data = array('status_id' => 6,
							'modified_by' => $this->user->user_id,
							'modified_on' => date('Y-m-d H:i:s')
							);
		$this->db->update('recruitment_process', $update_data, array('process_id' => $process_id));
		$this->db->update('recruitment', $update_data, array('recruit_id' => $process->recruit_id));

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function get_jo_form()
	{
		$this->_ajax_only();
		$vars['process_id'] = $process_id = $this->input->post('process_id');
		$vars['process'] = $process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
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

		$this->load->helper('form');
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

		if(in_array($jo['employment_status_id'], array(2,5,6))){
			if(!$jo['no_months'] > 0){
				$this->response->message[] = array(
			    	'message' => 'No. of months is required.',
			    	'type' => 'warning'
				);
				$validation = true;
			}
		}

		$required_fields = array("Reports To" => 'reports_to', 
			"Employee Status" => 'employment_status_id', "Start Date" => 'start_date', 
			"Work Schedule" => 'work_schedule', "Time Schedule" => 'shift_id', 
			"Lunch Break" => 'lunch_break');

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
		$jo['start_date'] = date('Y-m-d', strtotime($jo['start_date']));
		if(strtotime($jo['end_date'])){
			$jo['end_date'] = date('Y-m-d', strtotime($jo['end_date']));
		}else{
			$jo['end_date'] = '0000-00-00';
		}
		if($jo['accept_offer'] == 1){
			$recruit['blacklisted'] = '';
		}
		// echo $job_offer->num_rows()."<pre>";print_r($_POST);
		// exit();
		if($job_offer->num_rows() == 0){
			$this->db->insert('recruitment_process_offer', $jo);
		}else{
			$this->db->update('recruitment_process_offer', $jo, array('process_id' => $process_id));
		}

		$this->db->update('recruitment', $recruit, array('recruit_id' => $recruit_id));

		$this->db->delete('recruitment_process_offer_compben', array('process_id' => $process_id));
		$compben = $this->input->post('compben');
		$benefit = isset( $compben['benefit_id'] ) ? $compben['benefit_id'] : false;
		$amount = isset( $compben['amount'] ) ? $compben['amount'] : false;
		$rate = isset( $compben['rate_id'] ) ? $compben['rate_id'] : false;
		if( $benefit )
		{
			foreach($benefit as $index => $benefit_id)
			{
				$insert = array(
					'process_id' => $process_id,
					'benefit_id' => $benefit_id,
					'amount' => $amount[$index],
					'rate_id' => $rate[$index]
				);
				$this->db->insert('recruitment_process_offer_compben', $insert);
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

		if($signing['accepted'] == 1){
			$recruit['blacklisted'] = '';
		}
		
		$this->db->update('recruitment_process_signing', $signing, array('process_id' => $process_id));

		$this->db->update('recruitment', $recruit, array('recruit_id' => $recruit_id));

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
		$record['mrf'] = $this->rec->get_active_mrf_by_year();
		$record['mrf2'] = $this->rec->get_active_mrf_by_year();
		
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
				}
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
		switch($post['fgs_number']){
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
			$partners_personal_key = array('phone', 'mobile', 'position_sought', 'how_hiring_heard', 'resume');
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
		}

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
			$record = $this->db->get_where( $this->app->table, array( $this->app->primary_key => $this->record_id ) );

			switch( true )
			{
				case $record->num_rows() == 0:
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
					break;
				case $record->num_rows() == 1:
					if( !$this->session->userdata('user') ) {
						$main_record['modified_by'] =  '';
					}else{
						$this->user = $this->session->userdata('user');
						$main_record['modified_by'] =  $this->user->user_id;
					} 
					$main_record['modified_on'] = date('Y-m-d H:i:s');
					// if(array_key_exists('birth_date', $main_record)){
					// 	$main_record['birth_date'] = date('Y-m-d', strtotime($main_record['birth_date']));
					// }

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
				if(!is_array($partners_personal[$key])){
					$record = $this->app->get_recruitment_personal($this->record_id , $partners_personal_table, $key, $current_sequence);
					if(in_array($post['fgs_number'], $accountabilities_attachments) && $current_sequence == 0) //insert to personal history
					{
						$sequence = count($record) + 1;
						$record = array();
					}
					$data_personal = array('key_value' => $partners_personal[$key]);
					switch( true )
					{
						case count($record) == 0:
							$data_personal = $this->app->insert_recruitment_personal($this->record_id, $key, $partners_personal[$key], $sequence, $this->recruit_id);
							$this->db->insert($partners_personal_table, $data_personal);
							// $this->record_id = $this->db->insert_id();
							break;
						case count($record) == 1:
							$recruit_id = $this->recruit_id;
							$where_array = in_array($post['fgs_number'], $accountabilities_attachments) ? array( 'recruit_id' => $recruit_id, 'key' => $key, 'sequence' => $current_sequence ) : array( 'recruit_id' => $recruit_id, 'key' => $key );
							$this->db->update( $partners_personal_table, $data_personal, $where_array );
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
				}else{
					$sequence = 1;
					$recruit_id = $this->recruit_id;
					$this->db->delete($partners_personal_table, array( 'recruit_id' => $recruit_id, 'key' => $key ));
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
					}

				}
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
		$vars['process'] = $process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
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
		}
		$vars['blacklisted'] = $recruit->blacklisted;
		
		$this->load->helper('form');
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
		$vars['process_id'] = $process_id = $this->input->post('process_id');
		$vars['process'] = $process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
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

		$this->load->helper('form');
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
		$this->db->update('recruitment_process_employment_checklist', $preemp, $where_array);

		$this->response->message[] = array(
			'message' => 'Item successfully saved/updated.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}
}