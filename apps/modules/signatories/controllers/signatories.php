<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Signatories extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('signatories_model', 'mod');
		parent::__construct();
	}

	function index()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->db->select('TRIM(category)category,class,class_id,class_code');
		$this->db->order_by('category, class');
		$classes = $this->db->get_where('approver_class', array('deleted' => 0));

		$data['class_options'] = array('' => 'Select Class...');
		foreach( $classes->result() as $class )
		{
			if($class->category == 'Time Records') {
				$class_code = $class->class_code.'-GRANT';
				$this->db->join('time_form_class_policy','time_form_class.class_id = time_form_class_policy.class_id');
				$result = $this->db->get_where('time_form_class',array('class_code' => $class_code));
				if ($result && $result->num_rows() > 0){
					$row = $result->row();
					if ($row->class_value == 'YES'){
						$data['class_options'][$class->category][$class->class_id] = $class->class . ' ('.$class->class_code.')';
					}
				}
			}
			else {
				$data['class_options'][$class->category][$class->class_id] = $class->class . ' ('.$class->class_code.')';
			}
		}

		$data['companies'] = array();
		$companies = $this->db->get_where('users_company', array('deleted' => 0));
		foreach( $companies->result() as $company )
		{
			$data['companies'][] = $company;
		}

		$this->load->vars( $data );

		$this->load->helper('form');
		echo $this->load->blade('manager')->with( $this->load->get_cached_vars() );
	}

	function get_company_signatories()
	{
		$this->_ajax_only();

		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$class_id = $this->input->post('class_id');
		$company_id = $this->input->post('company_id');

		$signatories = $this->mod->get_company_signatories( $class_id, $company_id );

		if( $signatories )
		{
			$this->response->signatories = $this->load->view('signatory_list', array('signatories' => $signatories), true);
		}
		else{
			$this->response->signatories = $this->load->view('no_signatory', '', true);
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function get_department_signatories()
	{
		$this->_ajax_only();

		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$class_id = $this->input->post('class_id');
		$department_id = $this->input->post('department_id');
		$company_id = $this->input->post('company_id');

		$signatories = $this->mod->get_department_signatories( $class_id, $department_id, $company_id );

		if( $signatories )
		{
			$this->response->signatories = $this->load->view('signatory_list', array('signatories' => $signatories), true);
		}
		else{
			$this->response->signatories = $this->load->view('no_signatory', '', true);
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function get_position_signatories()
	{
		$this->_ajax_only();

		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$class_id = $this->input->post('class_id');
		$position_id = $this->input->post('position_id');
		$company_id = $this->input->post('company_id');
		$department_id = $this->input->post('department_id');

		$signatories = $this->mod->get_position_signatories( $class_id, $position_id, $department_id, $company_id );

		if( $signatories )
		{
			$this->response->signatories = $this->load->view('signatory_list', array('signatories' => $signatories), true);
		}
		else{
			$this->response->signatories = $this->load->view('no_signatory', '', true);
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function get_user_signatories()
	{
		$this->_ajax_only();

		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$class_id = $this->input->post('class_id');
		$user_id = $this->input->post('user_id');
		$position_id = $this->input->post('position_id');
		$company_id = $this->input->post('company_id');
		$department_id = $this->input->post('department_id');

		$signatories = $this->mod->get_user_signatories( $class_id, $user_id, $position_id, $department_id, $company_id );

		if( $signatories )
		{
			$this->response->signatories = $this->load->view('signatory_list', array('signatories' => $signatories), true);
		}
		else{
			$this->response->signatories = $this->load->view('no_signatory', '', true);
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function get_users_signatories()
	{
		$this->_ajax_only();

		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$class_id = $this->input->post('class_id');
		$user_id = $this->input->post('user_id');
		$position_id = $this->input->post('position_id');
		$company_id = $this->input->post('company_id');
		$department_id = $this->input->post('department_id');

		$signatories = $this->mod->get_users_signatories( $class_id, $user_id, $position_id, $department_id, $company_id );

		if( $signatories )
		{
			$this->response->signatories = $this->load->view('signatory_list', array('signatories' => $signatories), true);
		}
		else{
			$this->response->signatories = $this->load->view('no_signatory', '', true);
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function edit_signatory()
	{
		$this->_ajax_only();
		
		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$data['company_id'] = $this->input->post('company_id');
		$data['department_id'] = $this->input->post('department_id');
		$data['position_id'] = $this->input->post('position_id');
		$data['user_id'] = $this->input->post('user_id');
		$data['set_for'] = $this->input->post('set_for');
		$data['class_id'] = $this->input->post('class_id');

		$company = $this->db->get_where('users_company', array('company_id' => $data['company_id']))->row();
		$data['company'] = $company->company_code;
		
		if( !empty( $data['department_id'] ) )
		{
			$department = $this->db->get_where('users_department', array('department_id' => $data['department_id']))->row();
			$data['department'] = $department->department;
		}
		
		if( !empty( $data['position_id'] ) )
		{
			$position = $this->db->get_where('users_position', array('position_id' => $data['position_id']))->row();
			$data['position'] = $position->position;
		}

		if( !empty( $data['user_id'] ) )
		{
			$employee = $this->db->get_where('users', array('user_id' => $data['user_id']))->row();
			$data['employee'] = $employee->full_name;
		}

		switch( $data['set_for'] )
		{
			case "company":
				$data['signatory'] = $this->mod->get_company_signatory( $this->input->post('sig_id') );
				break;
			case "department":
				$data['signatory'] = $this->mod->get_department_signatory( $this->input->post('sig_id') );
				break;
			case "position":
				$data['signatory'] = $this->mod->get_position_signatory( $this->input->post('sig_id') );
				break;
			case "user":
				$data['signatory'] = $this->mod->get_user_signatory( $this->input->post('sig_id') );
				break;
		}

		if($data['class_id'] == 16){ //Change Request
			$data['conditions']  = array(
				"Either Of" => "Either Of"
			);
		}else{
			$data['conditions']  = array(
				"All" => "All",
				"By Level" => "By Level",
				"Either Of" => "Either Of",
			);
		}
		$this->db->select('user_id,full_name');
		$this->db->order_by('full_name');
		$users = $this->db->get_where('users', array('deleted' => 0, 'active' => 1));
		$data['users'][''] = 'Select an option';
		foreach( $users->result() as $user )
		{
			$data['users'][$user->user_id] = $user->full_name;
		}

		$this->load->helper('form');
		$data['content'] = $this->load->view('edit_signatory', $data, true);
		$data['title'] = 'Signatory Add/Edit';
		$this->response->edit_form = $this->load->view('templates/modal', $data, true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function delete_signatory()
	{

		$this->_ajax_only();
		
		if( !$this->permission['delete'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$set_for = $this->input->post('set_for');
		switch( $set_for )
		{
			case "company":
				$approver_class_details = $this->mod->get_company_signatory( $this->input->post('sig_id') );
				$this->response = $this->mod->delete_company_signatory( $this->input->post('sig_id') );
				$company_details = $this->mod->get_company_details($approver_class_details->company_id);
				$approver_of = $company_details['company'];
				break;
			case "department":
				$approver_class_details = $this->mod->get_department_signatory( $this->input->post('sig_id') );
				$this->response = $this->mod->delete_department_signatory( $this->input->post('sig_id') );
				$department_details = $this->mod->get_department_details($approver_class_details->department_id);
				$approver_of = $department_details['department'];
				break;
			case "position":
				$approver_class_details = $this->mod->get_position_signatory( $this->input->post('sig_id') );
				$this->response = $this->mod->delete_position_signatory( $this->input->post('sig_id') );
				$position_details = $this->mod->get_position_details($approver_class_details->position_id);
				$approver_of = $position_details['position'];
				break;
			case "user":
				$approver_class_details = $this->mod->get_user_signatory( $this->input->post('sig_id') );
				$this->db->limit(1);
				$approver_of = $this->db->get_where('users', array('user_id' => $approver_class_details->user_id))->row()->full_name;
				$this->response = $this->mod->delete_user_signatory( $this->input->post('sig_id') );
				break;
		}

		if($this->response->message[0]['type'] == 'success'){
			$data['class_id'] = (array_key_exists('company_id', $approver_class_details)) ? $approver_class_details->class_id : 0 ;
			$data['company_id'] = (array_key_exists('company_id', $approver_class_details)) ? $approver_class_details->company_id : 0 ;
			$data['department_id'] = (array_key_exists('department_id', $approver_class_details)) ? $approver_class_details->department_id : 0 ;
			$data['position_id'] = (array_key_exists('position_id', $approver_class_details)) ? $approver_class_details->position_id : 0 ;
			$data['user_id'] = (array_key_exists('user_id', $approver_class_details)) ? $approver_class_details->user_id : 0 ;
			
			// debug($data['class_id']);exit();
			// if( $set_for != "user" )
			// {
				//update existing class approver
				switch($data['class_id']){
					case 1:
					case 2:
					case 3:
					case 4:
					case 5:
					case 6:
					case 7:
					case 8:
					case 9:
					case 10:
					case 11:
					case 12:
					case 13:
					case 14:
					case 15:
					case 17:
					case 18:
		            case 23: //Employee’s Marriage
		            case 24: //Marriage of Child
		            case 25: //Childs Circumcision
		            case 26: //Childs Baptism
		            case 27: //Relatives Bereavement Leave
		            case 28: //Pilgrimage Leave
		            case 29: //Menstruation Leave
		            case 30: //Family Bereavement Leave
		            case 31: //Additional Leave
		            case 35: //Additional Leave Real
		            case 32: //Replacement Schedule
		            case 37: //Leave Incentive Leave
		            case 38: //Home Leave
		            case 39: //Force Leave		            
					//update existing forms approver
					$update_pending_approver = $this->mod->update_existing_form_approvers($data['class_id'], $data['user_id'], $data['position_id'], $data['department_id'], $data['company_id'], $data['user_id']);
					break;
					case 19:
					//update existing performance planning/appraisal approver
					$update_pending_approver = $this->mod->update_existing_performance_approvers($data['class_id'], $data['user_id'], $data['position_id'], $data['department_id'], $data['company_id'], $data['user_id']);
					break;
					case 16://change requests
					//select existing performance change requests approver
					$update_pending_approver = $this->mod->update_existing_personal_request_approvers($data['class_id'], $data['position_id'], $data['department_id'], $data['company_id'], $data['user_id']);
					break;
					case 20://recruitment
					//select existing performance planning/appraisal approver
					$update_pending_approver = $this->mod->update_existing_mrf_approvers($data['class_id'], $data['position_id'], $data['department_id'], $data['company_id'], $data['user_id']);
					break;
					case 21://Online Request
					//select existing performance Online Request approver
					$update_pending_approver = $this->mod->update_existing_online_request_approvers($data['class_id'], $data['position_id'], $data['department_id'], $data['company_id'], $data['user_id']);
					break;
					case 34://IR
					//select existing IR approver
					$update_pending_approver = $this->mod->update_existing_ir_approvers($data['class_id'], $data['position_id'], $data['department_id'], $data['company_id'], $data['user_id']);
					break;
					case 40://Movement
					//select existing online request	
					$update_pending_approver = $this->mod->update_existing_mv_approvers($data['class_id'], $data['position_id'], $data['department_id'], $data['company_id'],  $data['user_id']);
					break;						
					default:
					$update_pending_approver['type'] = 'success';
				}
				if ($update_pending_approver['type'] == "error"){
					$this->response->message[] = array(
						'message' => $update_pending_approver['message'],
						'type' => 'error'
					);
				}
			// }
		}
		
		$insert = array(
			'status' => 'info',
			'message_type' => 'Signatories',
			'user_id' => $this->user->user_id,
			'display_name' => $this->mod->get_display_name($this->user->user_id),
			'feed_content' => "You have been deleted as approver of {$approver_of}",
			'recipient_id' => $approver_class_details->approver_id
		);
		$notified[] = $approver_class_details->approver_id;
		$this->db->insert('system_feeds', $insert);
		$id = $this->db->insert_id();

	$this->response->notified = $notified;

		$this->_ajax_return();	
	}

	function save_signatory()
	{
		$this->_ajax_only();
		$id = $this->input->post('id');

		if( (empty( $id ) && !$this->permission['add']) || ($id && !$this->permission['edit']) )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		if($this->input->post('approver_id') == '')
		{
			$this->response->message[] = array(
				'message' => 'User is required',
				'type' => 'error'
			);
			$this->_ajax_return();
		}

		$data['approver'] = 0;
		if( $this->input->post('approver') )
		{
			$data['approver'] = 1;	
		}

		$data['email'] = 0;
		if( $this->input->post('email') )
		{
			$data['email'] = 1;	
		}

		$data['approver_id'] = $this->input->post('approver_id');
		$data['condition'] = $this->input->post('condition');
		$data['class_id'] = $this->input->post('class_id');
		$data['sequence'] = $this->input->post('sequence');
		$data['company_id'] = $this->input->post('company_id');

		$set_for = $this->input->post('set_for');
		switch( $set_for )
		{
			case "company":
				$table = 'approver_class_company';
				$company_details = $this->mod->get_company_details($data['company_id']);
				$approver_of = $company_details['company'];
				$where_condition = array('company_id' => $data['company_id']);
				break;
			case "department":
				$data['department_id'] = $this->input->post('department_id');
				$table = 'approver_class_department';
				$department_details = $this->mod->get_department_details($data['department_id']);
				$approver_of = $department_details['department'];
				$where_condition = array('company_id' => $data['company_id'],
										'department_id' => $data['department_id']);
				break;
			case "position":
				$data['department_id'] = $this->input->post('department_id');
				$data['position_id'] = $this->input->post('position_id');
				$table = 'approver_class_position';
				$position_details = $this->mod->get_position_details($data['position_id']);
				$approver_of = $position_details['position'];
				$where_condition = array('company_id' => $data['company_id'],
										'department_id' => $data['department_id'],
										'position_id' => $data['position_id']);
				break;
			case "user":
				$data['department_id'] = $this->input->post('department_id');
				$data['position_id'] = $this->input->post('position_id');
				$data['user_id'] = $this->input->post('user_id');
				$approver_name = $this->db->get_where('users', array('user_id' => $data['approver_id']));
				if ($approver_name && $approver_name->num_rows() > 0){
					$data['alias'] = $approver_name->row()->full_name;
				}
				else{
					$data['alias'] = '';
				}
				$table = 'approver_class_user';
				$user_details = $this->db->get_where('users', array('user_id' => $data['user_id']))->row();
				$approver_of = $user_details->full_name;
				$where_condition = array(
					'company_id' => $data['company_id'],
					'department_id' => $data['department_id'],
					'position_id' => $data['position_id'],
					'user_id' => $data['user_id']
				);
				break;
		}

		// $no_sequence = array('all', 'either of');
		// if( in_array(strtolower($data['condition']), $no_sequence) ){
		// 	$data['sequence'] = 1;
		// }

		if(empty($id))
		{
			$data['created_by'] = $this->user->user_id;
			$this->db->insert($table, $data);
		}
		else{
			$data['modified_by'] = $this->user->user_id;
			$data['modified_on'] = date('Y-m-d H:i:s');
			$this->db->update($table, $data, array('id' => $id));
		}
		
		//update condition for all approvers
		// $this->db->update($table, array('condition' => $data['condition']), $where_condition);

		if($this->db->_error_message() != "")
		{
			$this->response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}
		else{
			$data['company_id'] = ($this->input->post('company_id') > 0) ? $this->input->post('company_id') : 0 ;
			$data['department_id'] = ($this->input->post('department_id') > 0) ? $this->input->post('department_id') : 0 ;
			$data['position_id'] = ($this->input->post('position_id') > 0) ? $this->input->post('position_id') : 0 ;
			$data['user_id'] = ($this->input->post('user_id') > 0) ? $this->input->post('user_id') : 0 ;
			
			$update_pending_approver = array();
			//update existing class approver
			// if( $set_for != "user" )
			// {
	// 		debug($data['class_id']);
	// 			debug($data['user_id']);
	// 			debug($data['position_id']);
	// 			debug($data['department_id']);
	// 			debug($data['company_id']);
	// 			debug($data['user_id']);
 // die;	
			// debug($data['class_id']); die;
				switch($data['class_id']){
					case 1: //TK forms
					case 2:
					case 3:
					case 4:
					case 5:
					case 6:
					case 7:
					case 8:
					case 9:
					case 10:
					case 11:
					case 12:
					case 13:
					case 14:
					case 15:
					case 17:
					case 18:
		            case 23: //Employee’s Marriage
		            case 24: //Marriage of Child
		            case 25: //Childs Circumcision
		            case 26: //Childs Baptism
		            case 27: //Relatives Bereavement Leave
		            case 28: //Pilgrimage Leave
		            case 29: //Menstruation Leave
		            case 30: //Family Bereavement Leave
		            case 31: //Additional Leave
		            case 32: //Replacement Schedule
		            case 37: //Leave Incentive Leave
		            case 38: //Home Leave
		            case 39: //Force Leave
					//select existing forms approver
					case 35:
					$update_pending_approver = $this->mod->update_existing_form_approvers($data['class_id'], $data['user_id'], $data['position_id'], $data['department_id'], $data['company_id'], $data['user_id']);
					break;
					case 19://performance
					//select existing performance planning/appraisal approver
					$update_pending_approver = $this->mod->update_existing_performance_approvers($data['class_id'], $data['user_id'], $data['position_id'], $data['department_id'], $data['company_id'], $data['user_id']);
					break;
					case 16://change requests
					//select existing performance planning/appraisal approver
					$update_pending_approver = $this->mod->update_existing_personal_request_approvers($data['class_id'], $data['position_id'], $data['department_id'], $data['company_id'], $data['user_id']);
					break;
					case 20://change requests
					//select existing performance planning/appraisal approver
					$update_pending_approver = $this->mod->update_existing_mrf_approvers($data['class_id'], $data['position_id'], $data['department_id'], $data['company_id'], $data['user_id']);
					break;
					case 21://Online Request
					//select existing performance Online Request approver
					$update_pending_approver = $this->mod->update_existing_online_request_approvers($data['class_id'], $data['position_id'], $data['department_id'], $data['company_id'], $data['user_id']);
					break;
					case 34://IR
					//select existing IR approver
					$update_pending_approver = $this->mod->update_existing_ir_approvers($data['class_id'], $data['position_id'], $data['department_id'], $data['company_id'], $data['user_id']);
					break;
					case 36://Annuall Manpower Planning
					//select existing Annuall Manpower Planning approver
					$update_pending_approver = $this->mod->update_existing_amp_approvers($data['class_id'], $data['position_id'], $data['department_id'], $data['company_id'], $data['user_id']);
					break;					
					case 40://Movement
					//select existing online request	
					$update_pending_approver = $this->mod->update_existing_mv_approvers($data['class_id'], $data['position_id'], $data['department_id'], $data['company_id'],  $data['user_id']);
					break;								
					default:
					$update_pending_approver['type'] = 'success';
				}

				if(isset($update_pending_approver['type'])){
					if ($update_pending_approver['type'] == "error"){
						$this->response->message[] = array(
							'message' => $update_pending_approver['message'],
							'type' => 'error'
						);
					}else{
						$this->response->message[] = array(
							'message' => 'Record succesfully saved.',
							'type' => 'success'
						);
					}
				}	
			// }
		}

		$insert = array(
			'status' => 'info',
			'message_type' => 'Signatories',
			'user_id' => $this->user->user_id,
			'display_name' => $this->mod->get_display_name($this->user->user_id),
			'feed_content' => "You have been added as approver of {$approver_of}",
			'recipient_id' => $data['approver_id']
		);
		$notified[] = $data['approver_id'];
		$this->db->insert('system_feeds', $insert);
		$id = $this->db->insert_id();

		$this->response->notified = $notified;
		$this->response->message[] = array(
			'message' => lang('common.save_success'),
			'type' => 'success'
		);
		$this->_ajax_return();

	}

	function get_company_department()
	{
		$this->_ajax_only();

		$this->response->department = '';

		$company_id = $this->input->post('company_id');
		$qry = "select * from `approver_class_department` where company_id={$company_id}";
		$depts = $this->db->query( $qry );
		
		if($depts->num_rows() > 0){
			foreach($depts->result() as $dept)
			{
				$this->response->department .= $this->load->view('department', array('dept' => $dept), true);
			}
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function get_department_position()
	{
		$this->_ajax_only();

		$this->response->position = '';

		$department_id = $this->input->post('department_id');
		$company_id = $this->input->post('company_id');
		$qry = "select * from `approver_class_position` where department_id={$department_id} AND company_id = {$company_id}";
		$position = $this->db->query( $qry );
		if($position->num_rows() > 0){
			foreach($position->result() as $pos)
			{
				$this->response->position .= $this->load->view('position', array('pos' => $pos), true);
			}
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function get_position_employees()
	{
		$this->_ajax_only();

		$this->response->user = '';

		$department_id = $this->input->post('department_id');
		$company_id = $this->input->post('company_id');
		$position_id = $this->input->post('position_id');
		$qry = "select * from `approver_position_users` where department_id={$department_id} AND company_id = {$company_id} AND position_id={$position_id}";
		$users = $this->db->query( $qry );
		if($users->num_rows() > 0){
			foreach($users->result() as $user)
			{
				$this->response->user .= $this->load->view('user', array('user' => $user), true);
			}
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function count_affected_forms(){
		$this->_ajax_only();

		$approver_class_details = array();
		$set_for = $this->input->post('set_for');
		if ($this->input->post('sig_id') > 0){
			switch( $set_for )
			{
				case "company":
					$approver_class_details = $this->mod->get_company_signatory( $this->input->post('sig_id') );
					break;
				case "department":
					$approver_class_details = $this->mod->get_department_signatory( $this->input->post('sig_id') );
					break;
				case "position":
					$approver_class_details = $this->mod->get_position_signatory( $this->input->post('sig_id') );
					break;
				case "user":
					$approver_class_details = $this->mod->get_user_signatory( $this->input->post('sig_id') );
					break;
			}
		}
		
		$company_id = ($this->input->post('company_id') > 0) ? $this->input->post('company_id') : 0 ;
		$department_id = ($this->input->post('department_id') > 0) ? $this->input->post('department_id') : 0 ;
		$position_id = ($this->input->post('position_id') > 0) ? $this->input->post('position_id') : 0 ;
		$user_id = ($this->input->post('user_id') > 0) ? $this->input->post('user_id') : 0 ;
		$class_id = ($this->input->post('class_id') > 0) ? $this->input->post('class_id') : 0 ;

		$data['class_id'] = (array_key_exists('class_id', $approver_class_details)) ? $approver_class_details->class_id : $class_id ;
		$data['company_id'] = (array_key_exists('company_id', $approver_class_details)) ? $approver_class_details->company_id : $company_id ;
		$data['department_id'] = (array_key_exists('department_id', $approver_class_details)) ? $approver_class_details->department_id : $department_id ;
		$data['position_id'] = (array_key_exists('position_id', $approver_class_details)) ? $approver_class_details->position_id : $position_id ;
		$data['user_id'] = (array_key_exists('user_id', $approver_class_details)) ? $approver_class_details->user_id : $user_id ;

		$this->response->timeforms = 0;
		$this->response->pending_forms_count = 0;
		$this->response->performance = 0;
		$this->response->pending_performance_count = 0;
		$this->response->change_request = 0;
		$this->response->pending_change_request_count = 0;
		$this->response->erequest = 0;
		$this->response->pending_erequest_count = 0;
		$this->response->ir = 0;
		$this->response->pending_ir_count = 0;

		switch($data['class_id']){
			case 1://forms
			case 2:
			case 3:
			case 4:
			case 5:
			case 6:
			case 7:
			case 8:
			case 9:
			case 10:
			case 11:
			case 12:
			case 13:
			case 14:
			case 15:
			case 17:
			case 18:
            case 23: //Employee’s Marriage
            case 24: //Marriage of Child
            case 25: //Childs Circumcision
            case 26: //Childs Baptism
            case 27: //Relatives Bereavement Leave
            case 28: //Pilgrimage Leave
            case 29: //Menstruation Leave
		    case 30: //Family Bereavement Leave
		    case 31: //Additional Leave
		    case 32: //Replacement Schedule
		    case 37: //Leave Incentive Leave
		    case 38: //Home Leave
		    case 39: //Force Leave
			//select existing forms approver
			$this->response->timeforms = 1;
			$this->response->pending_forms_count = $this->mod->select_existing_pending_forms($data['class_id'], $data['user_id'], $data['position_id'], $data['department_id'], $data['company_id'], $data['user_id']);
			break;
			case 19: //performance
			//select existing performance planning/appraisal approver
			$this->response->performance = 1;
			$this->response->pending_performance_count = $this->mod->select_existing_pending_performance($data['class_id'], $data['user_id'], $data['position_id'], $data['department_id'], $data['company_id'], $data['user_id']);
			break;
			case 16: //Change Request
			//select existing Change Request
			$this->response->change_request = 1;
			$this->response->pending_change_request_count = $this->mod->select_existing_pending_change_requests($data['class_id'], $data['position_id'], $data['department_id'], $data['company_id'], $data['user_id']);
			break;
			case 20: //Recruitment
			//select existing Recruitment
			$this->response->mrf = 1;
			$this->response->pending_mrf_count = $this->mod->select_existing_pending_mrf($data['class_id'], $data['position_id'], $data['department_id'], $data['company_id'], $data['user_id']);
			break;
			case 21://Online Request
			//select existing online request	
			$this->response->erequest = 1;
			$this->response->pending_erequest_count = $this->mod->select_existing_pending_erequest($data['class_id'], $data['position_id'], $data['department_id'], $data['company_id'], $data['user_id']);
			case 34://Online Request
			//select existing online request	
			$this->response->ir = 1;
			$this->response->pending_ir_count = $this->mod->select_existing_pending_ir($data['class_id'], $data['position_id'], $data['department_id'], $data['company_id'],  $data['user_id']);
			break;
			case 36://Annuall Manpower Planning
			//select existing Annuall Manpower Planning approver
			$this->response->amp = 1;
			$this->response->pending_amp_count = $this->mod->select_existing_pending_amp($data['class_id'], $data['position_id'], $data['department_id'], $data['company_id'], $data['user_id']);
			break;				
			case 40://Movement
			//select existing online request	
			$this->response->mv = 1;
			$this->response->pending_mv_count = $this->mod->select_existing_pending_mv($data['class_id'], $data['position_id'], $data['department_id'], $data['company_id'],  $data['user_id']);
			break;			
		}
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function save_assign_all()
	{
		$this->_ajax_only();
		$id = $this->input->post('id');

		if( (empty( $id ) && !$this->permission['add']) || ($id && !$this->permission['edit']) )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$data['approver'] = 0;
		if( $this->input->post('approver') )
		{
			$data['approver'] = 1;	
		}

		$data['email'] = 0;
		if( $this->input->post('email') )
		{
			$data['email'] = 1;	
		}

		$data['approver_id'] = $this->input->post('approver_id');
		$data['condition'] = $this->input->post('condition');
		$data['sequence'] = $this->input->post('sequence');
		$data['company_id'] = $this->input->post('company_id');

		$set_for = $this->input->post('set_for');
		switch( $set_for )
		{
			case "user":
				$data['department_id'] = $this->input->post('department_id');
				$data['position_id'] = $this->input->post('position_id');
				$data['user_id'] = $this->input->post('user_id');
				$approver_name= $this->db->get_where('users', array('user_id' => $data['approver_id']))->row();
				$data['alias'] = $approver_name->full_name;
				$table = 'approver_class_users';
				$user_details = $this->db->get_where('users', array('user_id' => $data['user_id']))->row();
				$approver_of = $user_details->full_name;
				$where_condition = array(
					'company_id' => $data['company_id'],
					'department_id' => $data['department_id'],
					'position_id' => $data['position_id'],
					'user_id' => $data['user_id']
				);
				break;
		}

		if(empty($id))
		{
			$data['created_by'] = $this->user->user_id;
			$this->db->insert($table, $data);
		}
		else{
			$data['modified_by'] = $this->user->user_id;
			$data['modified_on'] = date('Y-m-d H:i:s');
			$this->db->update($table, $data, array('id' => $id));
		}

		if($this->db->_error_message() != "")
		{
			$this->response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}
		else{
			$data['company_id'] = ($this->input->post('company_id') > 0) ? $this->input->post('company_id') : 0 ;
			$data['department_id'] = ($this->input->post('department_id') > 0) ? $this->input->post('department_id') : 0 ;
			$data['position_id'] = ($this->input->post('position_id') > 0) ? $this->input->post('position_id') : 0 ;
			$data['user_id'] = ($this->input->post('user_id') > 0) ? $this->input->post('user_id') : 0 ;
			
			$update_pending_approver = array();

			if(isset($update_pending_approver['type'])){
				if ($update_pending_approver['type'] == "error"){
					$this->response->message[] = array(
						'message' => $update_pending_approver['message'],
						'type' => 'error'
					);
				}else{
					$this->response->message[] = array(
						'message' => 'Record succesfully saved.',
						'type' => 'success'
					);
				}
			}	
		}

		$insert = array(
			'status' => 'info',
			'message_type' => 'Signatories',
			'user_id' => $this->user->user_id,
			'display_name' => $this->mod->get_display_name($this->user->user_id),
			'feed_content' => "You have been added as approver of {$approver_of}",
			'recipient_id' => $data['approver_id']
		);
		$notified[] = $data['approver_id'];
		$this->db->insert('system_feeds', $insert);
		$id = $this->db->insert_id();

		$this->response->notified = $notified;
		$this->response->message[] = array(
			'message' => lang('common.save_success'),
			'type' => 'success'
		);
		$this->_ajax_return();

	}

	function delete_assign_all()
	{

		$this->_ajax_only();
		
		if( !$this->permission['delete'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$set_for = $this->input->post('set_for');
		switch( $set_for )
		{
			case "user":
				$approver_class_details = $this->mod->get_users_signatory( $this->input->post('sig_id') );
				$this->db->limit(1);
				$approver_of = $this->db->get_where('users', array('user_id' => $approver_class_details->user_id))->row()->full_name;
				$this->response = $this->mod->delete_users_signatory( $this->input->post('sig_id') );
				break;
		}
		
		$insert = array(
			'status' => 'info',
			'message_type' => 'Signatories',
			'user_id' => $this->user->user_id,
			'display_name' => $this->mod->get_display_name($this->user->user_id),
			'feed_content' => "You have been deleted as approver of {$approver_of}",
			'recipient_id' => $approver_class_details->approver_id
		);
		$notified[] = $approver_class_details->approver_id;
		$this->db->insert('system_feeds', $insert);
		$id = $this->db->insert_id();

	$this->response->notified = $notified;

		$this->_ajax_return();	
	}

}