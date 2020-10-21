<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Annual_manpower_planning extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('annual_manpower_planning_model', 'mod');
		parent::__construct();
		$this->lang->load('annual_manpower_planning');
		$this->lang->load('calendar');
	}

	public function index()
	{
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

        $data['amp'] = isset($this->permission['list']) ? $this->permission['list'] : 0;

        $this->load->model('amp_admin_model', 'amp_ad');
        $data['amp_admin'] = isset($permission[$this->amp_ad->mod_code]['list']) ? $permission[$this->amp_ad->mod_code]['list'] : 0;

        $this->load->vars($data);  
		echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
	}
	
	function save()
	{
/*		echo "<pre>";
		print_r($_POST);
		exit();*/
		parent::save( true );
		
		if( $this->response->saved )
		{
			//create system logs
			$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'delete', 'recruitment_manpower_plan_position_new - plan_id', array(), explode(',', $this->record_id));

			if (isset($_POST['recruitment_manpower_plan']['manpower_plan_status_id']) && $_POST['recruitment_manpower_plan']['manpower_plan_status_id'] != ''){
				$this->db->where('plan_id',$this->record_id);
				$this->db->update('recruitment_manpower_plan',array('manpower_plan_status_id' => $_POST['recruitment_manpower_plan']['manpower_plan_status_id'],'user_id' => $this->user->user_id,'display_name' => $_POST['recruitment_manpower_plan']['created_by']));
			}

			if( $this->input->post('new_position') )
			{
				if (isset($_POST['new_position']['position'])){
					$new_positions = $_POST['new_position']['position'];
					$arIDS = $_POST['new_position']['id'];
					$month = $_POST['new_position']['month'];
					$employment_status_id = $_POST['new_position']['employment_status_id'];
					$job_class_id = $_POST['new_position']['job_class_id'];
					// $jobrank = $_POST['new_position']['job_rank_id'];
					$budget = $_POST['new_position']['budget'];
					$company_id = $_POST['new_position']['company_id'];

					foreach( $new_positions as $index => $new_position )
					{
						$insert = array(
							'plan_id' => $this->record_id,
							'position' => $new_position,
							'employment_status_id' => $employment_status_id[$index],
							'job_class_id' => $job_class_id[$index],
							'company_id' => $company_id[$index],
							'month' => $month[$index],
							'budget' => $budget[$index],
							'created_by' => $this->user->user_id
						);

						if (isset($arIDS[$index]) && $arIDS[$index] != 0){
							$this->db->where('id',$arIDS[$index]);
							$this->db->update('recruitment_manpower_plan_position_new', $insert);
						}
						else{
							$this->db->where('position',$new_position);
							$result = $this->db->get('recruitment_manpower_plan_position_new');
							if (!$result || $result->num_rows() == 0){
								$this->db->insert('recruitment_manpower_plan_position_new', $insert);
							}
						}

						//create system logs
						$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'recruitment_manpower_plan_position_new', array(), $insert);
					}
				}
			}
		}

		if ($_POST['recruitment_manpower_plan']['manpower_plan_status_id'] == 2){
			$qry = "CALL sp_manpower_plan_email('".$this->record_id."','for_approval');";
			$result = $this->db->query( $qry );
		}

		$this->response->message[] = array(
			'message' => lang('common.save_success'),
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function get_depthead()
	{
		$this->_ajax_only();
		$this->load->model('department_model');
		$this->response->depthead = $this->department_model->get_depthead( $this->input->post('department_id') );
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function validate_department()
	{
		$this->_ajax_only();
		$this->response->check = $check = $this->mod->validate_department( $_POST['company_id'], $_POST['department_id'], $_POST['year'] );

		if( !$check ){
			$this->response->message[] = array(
				'message' => 'Another annual planning is already created for the selected department.',
				'type' => 'warning'
			);
		}
		else{
			$this->response->message[] = array(
				'message' => '',
				'type' => 'success'
			);
		}
		$this->_ajax_return();	
	}

	function get_incumbent()
	{
		$this->_ajax_only();
		
		$saved_incumbents = $this->mod->get_saved_incumbents( $_POST['plan_id'] );
		$incumbents = $this->mod->get_incumbents( $_POST['company_id'], $_POST['department_id'] );
		$users = array();
		if( $saved_incumbents )
		{
			foreach ($saved_incumbents as $incumbent)
			{
				$users[] = $incumbent->user_id; 	
				$this->response->incumbent[] = $this->load->view('edit/incumbent', array('post' => $_POST, 'incumbent' => $incumbent), true);
			}
		}

		if( $incumbents )
		{
			foreach ($incumbents as $incumbent)
			{
				if( !in_array( $incumbent->user_id, $users ) )
					$this->response->incumbent[] = $this->load->view('edit/incumbent', array('post' => $_POST, 'incumbent' => $incumbent), true);
			}
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();	
	}

	function get_to_hire()
	{
		$this->_ajax_only();
		
		$save_positions = $this->mod->get_incumbents( $_POST['company_id'], $_POST['department_id'] );
		// $save_positions = $this->mod->get_saved_positions( $_POST['plan_id'] );
		
// echo "<pre>";print_r($this->db->last_query()) ;
		$positions = $this->mod->get_positions( $_POST['department_id'] );
		$position_ids = array();


		if( $save_positions )
		{
			foreach ($save_positions as $position)
			{
				$position_ids[] = $position->position_id; 	
				$this->response->position[] = $this->load->view('edit/position', array('post' => $_POST, 'position' => $position), true);
			}
		}

		if( $positions )
		{
			foreach ($positions as $position)
			{
				if( !in_array( $position->position_id, $position_ids ) )
					$this->response->position[] = $this->load->view('edit/position', array('post' => $_POST, 'position' => $position), true);
			}
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();	
	}

	function get_incumbent_form()
	{
		$this->_ajax_only();

		$vars = $_POST;

		$this->load->helper('form');
		$data['title'] = 'With Incumbent Settings';
		$data['description'] = 'This section used to plan and modify positions with incumbent.';
		$data['content'] = $this->load->view('edit/incumbent_form', $vars, true);

		$this->response->incumbent_form = $this->load->view('templates/modal', $data, true);		

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function get_tohire_form()
	{
		$this->_ajax_only();

		$vars = $_POST;

		$this->load->helper('form');
		$this->db->limit(1);
		$position = $this->db->get_where("users_position", array('position_id' => $_POST['position_id']))->row();
		$data['title'] = $position->position;
		$data['description'] = 'This section used to plan positions, budget and modify headcount.';
		$data['content'] = $this->load->view('edit/position_form', $vars, true);

		$this->response->tohire_form = $this->load->view('templates/modal', $data, true);		

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function save_incumbent_plans()
	{
		$this->_ajax_only();

		if( !isset($this->permission['edit']) || !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => 'You dont have sufficient permission to execute this action.',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$where = array(
			'plan_id' => $this->input->post('plan_id'),
			'user_id' => $this->input->post('user_id'),
			'position_id' => $this->input->post('position_id'),
		);
		$this->db->delete('recruitment_manpower_plan_incumbent', $where);
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'delete', 'recruitment_manpower_plan_incumbent - plan_id', array(), explode(',', $this->input->post('plan_id')));

		$actions = $this->input->post('action');
		$month = $this->input->post('month');
		$budget = $this->input->post('budget');
		$company_id = $this->input->post('company_id');

		if( $actions )
		{
			foreach( $actions as $index => $action_id )
			{
				$insert = array(
					'plan_id' => $this->input->post('plan_id'),
					'user_id' => $this->input->post('user_id'),
					'position_id' => $this->input->post('position_id'),
					'company_id' => $company_id[$index],
					'action_id' => $action_id,
					'month' => $month[$index],
					'budget' => $budget[$index],
					'created_by' => $this->user->user_id
				);
				$this->db->insert('recruitment_manpower_plan_incumbent', $insert);
				//create system logs
				$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'recruitment_manpower_plan_incumbent', array(), $insert);
			}
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function save_position_plans()
	{
		$this->_ajax_only();

		if( !isset($this->permission['edit']) || !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => 'You dont have sufficient permission to execute this action.',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$where = array(
			'plan_id' => $this->input->post('plan_id'),
			'position_id' => $this->input->post('position_id'),
		);
		$this->db->delete('recruitment_manpower_plan_position', $where);
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'delete', 'recruitment_manpower_plan_position - plan_id', array(), explode(',', $this->input->post('plan_id')));

		$months = $this->input->post('month');
		$job_class_id = $this->input->post('job_class_id');
		$employment_status_id = $this->input->post('employment_status_id');
		$needed = $this->input->post('needed');
		$budget = $this->input->post('budget');
		$company_id = $this->input->post('company_id');

		if( $months )
		{
			foreach( $months as $index => $month )
			{
				$insert = array(
					'plan_id' => $this->input->post('plan_id'),
					'position_id' => $this->input->post('position_id'),
					'job_class_id' => $job_class_id[$index],
					'employment_status_id' => $employment_status_id[$index],
					'company_id' => $company_id[$index],
					'needed' => $needed[$index],
					'month' => $month,
					'budget' => $budget[$index],
					'created_by' => $this->user->user_id
				);
				$this->db->insert('recruitment_manpower_plan_position', $insert);
				//create system logs
				$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'recruitment_manpower_plan_position', array(), $insert);
			}
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
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

	public function detail( $record_id, $child_call = false )
	{
		if( !$this->permission['edit'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_detail( $child_call );
	}

	private function _detail( $child_call, $new = false )
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
		
		$data['is_approve'] = $this->is_approve($this->record_id);
		$data['is_disapprove'] = $this->is_disapprove($this->record_id);

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

			$data['record']['disabled'] = "disabled";
			$data['record']['readonly'] = "readonly";
			$data['record']['view_type'] = 'detail';

			$this->record = $data['record'];
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

			$users = $this->db->get_where("users_profile", array('user_id' => $this->user->user_id))->row_array();
			$data['record']['recruitment_manpower_plan.company_id'] = $users['company_id'];
			$data['record']['recruitment_manpower_plan.company'] = $users['company'];
			$data['record']['recruitment_manpower_plan.department_id'] = $users['department_id'];
			
			$dept = $this->db->get_where("users_department", array('department_id' => $users['department_id']));
			$immediate = '';
			if ($dept && $dept->num_rows() > 0){
				$dept_info = $dept->row();
				$immediate = $dept_info->immediate;
			}

			$data['record']['recruitment_manpower_plan.departmenthead'] = $immediate;

			$data['record']['disabled'] = "";
			$data['record']['readonly'] = "";
			$data['record']['view_type'] = 'edit';

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

	function add_form() {
		$this->_ajax_only();

        $actions = $this->db->get_where('recruitment_manpower_plan_action', array('deleted' => 0));
        foreach( $actions->result() as $action )
        {
            $options[$action->action_id] = $action->action;
        }

        $companies = $this->db->get_where('users_company', array('deleted' => 0));
        foreach( $companies->result() as $company )
        {
            $companys[$company->company_id] = $company->company_code;
        }

	    $months = array(
	        '1' => lang('cal_january'),
	        '2' => lang('cal_february'),
	        '3' => lang('cal_march'),
	        '4' => lang('cal_april'),
	        '5' => lang('cal_may'),
	        '6' => lang('cal_june'),
	        '7' => lang('cal_july'),
	        '8' => lang('cal_august'),
	        '9' => lang('cal_september'),
	        '10' => lang('cal_october'),
	        '11' => lang('cal_november'),
	        '12' => lang('cal_december')
	    );

		$data['options'] = $options;
		$data['months'] = $months;
		$data['companies'] = $companys;
		$data['form_value'] = $this->input->post('form_value');

		$this->load->helper('form');
		$this->load->helper('file');
		$this->response->add_form = $this->load->view('edit/'.$this->input->post('add_form'), $data, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();
	}

	function add_tohire() {
		$this->_ajax_only();

        //
        $jobrank = $this->db->get_where('users_job_rank', array('deleted' => 0));
        $job_ranks = array('' => 'Select...');
        foreach($jobrank->result() as $jr)
        {
            $job_ranks[$jr->job_rank_id] = $jr->job_rank;
        }
        
        $job_class = $this->db->get_where('users_job_class', array('deleted' => 0));
        $job_classes = array('' => 'Select...');
        foreach($job_class->result() as $jclass)
        {
            $job_classes[$jclass->job_class_id] = $jclass->job_class;
        }
        
        $employment_status = $this->db->get_where('partners_employment_status', array('deleted' => 0));
        $employment_statuss = array('' => 'Select...');
        foreach($employment_status->result() as $etype)
        {
            $employment_statuss[$etype->employment_status_id] = $etype->employment_status;
        }

        $companies = $this->db->get_where('users_company', array('deleted' => 0));
        foreach( $companies->result() as $company )
        {
            $companys[$company->company_id] = $company->company_code;
        }

	    $months = array(
	        '1' => lang('cal_january'),
	        '2' => lang('cal_february'),
	        '3' => lang('cal_march'),
	        '4' => lang('cal_april'),
	        '5' => lang('cal_may'),
	        '6' => lang('cal_june'),
	        '7' => lang('cal_july'),
	        '8' => lang('cal_august'),
	        '9' => lang('cal_september'),
	        '10' => lang('cal_october'),
	        '11' => lang('cal_november'),
	        '12' => lang('cal_december')
	    );

		$data['job_ranks'] = $job_ranks;
		$data['employment_statuss'] = $employment_statuss;
		$data['job_classes'] = $job_classes;
		$data['companies'] = $companys;
		$data['months'] = $months;
		$data['form_value'] = $this->input->post('form_value');

		// echo $this->input->post('add_form');
		$this->load->helper('form');
		$this->load->helper('file');
		$this->response->add_form = $this->load->view('edit/'.$this->input->post('add_form'), $data, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();
	}

		
	public function _process_lists( $records, $trash )
	{
		$this->response->records_retrieve = sizeof($records);
		$this->response->list = '';
		foreach( $records as $record )
		{
			$rec = array(
				'detail_url' => '#',
				'edit_url' => '#',
				'delete_url' => '#',
				'options' => ''
			);

			if(!$trash){
				$this->_list_options_active( $record, $rec );
			}else{
				$this->_list_options_trash( $record, $rec );
			}

			$record = array_merge($record, $rec);

			if (!isset($record['login_user_id'])){
				$record['login_user_id'] = $this->user->user_id;
			}

			$this->response->list .= $this->load->blade('list_template', $record, true)->with( $this->load->get_cached_vars() );
		}
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

		$this->response->show_import_button = false;
		if( $this->input->post('page') == 1 )
		{
			$this->load->model('upload_utility_model', 'import');
			if( $this->import->get_templates( $this->mod->mod_id ) )
				$this->response->show_import_button = true;
		}

		$trash = $this->input->post('trash') == 'true' ? true : false;
		$records = $this->_get_list( $trash );
		$this->_process_lists( $records, $trash );
		
		$this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

		$this->_ajax_return();
	}

	private function _get_list( $trash )
	{
		$page = $this->input->post('page');
		$search = $this->input->post('search');
		$filter = "";
		
		$filter_by = $this->input->post('filter_by');
		$filter_value = $this->input->post('filter_value');
		
		if( is_array( $filter_by ) )
		{
			foreach( $filter_by as $filter_by_key => $filter_value )
			{
				if( $filter_value != "" ) $filter = 'AND '. $filter_by_key .' = "'.$filter_value.'"';	
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
		$records = $this->mod->_get_list($page, 10, $search, $filter, $trash);
		return $records;
	}

	function _list_options_active( $record, &$rec )
	{
		//temp remove until view functionality added
		if( $this->permission['detail'] )
		{
			$rec['detail_url'] = $this->mod->url . '/detail/' . $record['record_id'];
			$rec['options'] .= '<li><a href="'.$rec['detail_url'].'"><i class="fa fa-info"></i> View</a></li>';
		}

		if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}	
		
		if( isset($this->permission['delete']) && $this->permission['delete'] )
		{	
			if(isset($record['can_delete']) && $record['can_delete'] == 1){
				$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
				$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
			}elseif(isset($record['can_delete']) && $record['can_delete'] == 0){
				$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
				$rec['options'] .= '<li><a disabled="disabled" style="color:#B6B6B4" onclick="return false" href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
			}else{
				$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
				$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
			}
		}
	}

	function _list_options_trash( $record, &$rec )
	{
		if( $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}

		if( $this->permission['restore'] )
		{
			$rec['options'] .= '<li><a href="javascript:restore_record( '. $record['record_id'] .' )"><i class="fa fa-refresh"></i> '.lang('common.restore').'</a></li>';
		}
	}

	function is_approve($record_id){
		$this->db->where('recruitment_manpower_plan.deleted',0);
		$this->db->where('recruitment_manpower_plan.plan_id',$record_id);
		$this->db->where('recruitment_manpower_plan_approver.approver_id',$this->user->user_id);
		$this->db->join('recruitment_manpower_plan_approver','recruitment_manpower_plan.plan_id = recruitment_manpower_plan_approver.plan_id');
		$record = $this->db->get('recruitment_manpower_plan');

		if ($record && $record->num_rows() > 0){
			$row = $record->row();

			if (isset($this->permission) && $this->permission['approve'] == 1){
                if( $row->plan_status_id == 2 ){
                    return true;
                }
			}
			else{
				return false;
			}
		}

		return false;
	}

	function is_disapprove($record_id){
		$this->db->where('recruitment_manpower_plan.deleted',0);
		$this->db->where('recruitment_manpower_plan.plan_id',$record_id);
		$this->db->where('recruitment_manpower_plan_approver.approver_id',$this->user->user_id);
		$this->db->join('recruitment_manpower_plan_approver','recruitment_manpower_plan.plan_id = recruitment_manpower_plan_approver.plan_id');
		$record = $this->db->get('recruitment_manpower_plan');

		if ($record && $record->num_rows() > 0){
			$row = $record->row();

			if (isset($this->permission) && $this->permission['decline'] == 1){
                if( $row->plan_status_id == 2 ){
                    return true;
                }
			}
			else{
				return false;
			}
		}

		return false;
	}

    function forms_decission(){

        $this->current_user = $this->session->userdata['user']->user_id;

        $this->_ajax_only();
        $data = array();

		$qry = "CALL sp_recruitment_manpower_plan_approval('".$this->input->post('plan_id')."', '".$this->input->post('decission')."', '".$this->current_user."')";
		$result = $this->db->query( $qry );

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

        $this->response->message[]  = array(
            'message'   => lang('common.save_successful'),
            'type'      => 'success'
        );
        
        $this->_ajax_return();
    }

    function check_position(){
    	$this->db->where('deleted',0);
    	$this->db->where('position',$this->input->post('new_position'));
    	$result = $this->db->get('users_position');
    	if ($result && $result->num_rows() > 0){
	        $this->response->message_type  = 'error';
	        $this->response->message  = $this->input->post('new_position') . ' already exists in user position';
    	}
    	else{
			$this->response->message_type  = 'success';   		
    	}
        
        $this->_ajax_return();    	
    }
}