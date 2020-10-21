<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Amp_admin extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('amp_admin_model', 'mod');
		$this->load->model('annual_manpower_planning_model', 'amp');
		$vars['amp'] = $this->amp;
		$this->load->vars( $vars );
		$this->lang->load('annual_manpower_planning');
		$this->lang->load('calendar');
		parent::__construct();
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

        $data['amp_admin'] = isset($this->permission['list']) ? $this->permission['list'] : 0;

        $this->load->model('annual_manpower_planning_model', 'amp_ad');
        $data['amp'] = isset($permission[$this->amp_ad->mod_code]['list']) ? $permission[$this->amp_ad->mod_code]['list'] : 0;
     
        $this->load->vars($data);  
		echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
	}

	
	function save()
	{
		// echo "<pre>";
		// print_r($_POST);
		// exit();
		// $new_positions = $this->input->post('new_position');
		unset($_POST['view_type']);
		parent::save( true );
		
		if( $this->response->saved )
		{
			$where = array(
				'plan_id' => $this->record_id,
			);
			$this->db->delete('recruitment_manpower_plan_position_new', $where);

			//create system logs
			$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'delete', 'recruitment_manpower_plan_position_new - plan_id', array(), explode(',', $this->record_id));
			// if( $new_positions )
			// {

			if( $this->input->post('new_position') )
			{
			// 	$_POST['new_position'] = $new_positions;
				$new_positions = $_POST['new_position']['position'];
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
					$this->db->insert('recruitment_manpower_plan_position_new', $insert);
					//create system logs
					$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'recruitment_manpower_plan_position_new', array(), $insert);

				}
			}
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
		
		if($_POST['view_type'] == 'detail'){
			$view_file = 'detail/incumbent';
		}else{
			$view_file = 'edit/incumbent';
		}
		$saved_incumbents = $this->mod->get_saved_incumbents( $_POST['plan_id'] );
		$incumbents = $this->mod->get_incumbents( $_POST['company_id'], $_POST['department_id'] );
		$users = array();
		if( $saved_incumbents )
		{
			foreach ($saved_incumbents as $incumbent)
			{
				$users[] = $incumbent->user_id; 	
				$this->response->incumbent[] = $this->load->view($view_file, array('post' => $_POST, 'incumbent' => $incumbent), true);
			}
		}

		if( $incumbents )
		{
			foreach ($incumbents as $incumbent)
			{
				if( !in_array( $incumbent->user_id, $users ) )
					$this->response->incumbent[] = $this->load->view($view_file, array('post' => $_POST, 'incumbent' => $incumbent), true);
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
		$positions = $this->mod->get_positions( $_POST['department_id'] );
		$position_ids = array();

		if($_POST['view_type'] == 'detail'){
			$view_file = 'detail/position';
		}else{
			$view_file = 'edit/position';
		}

		if( $save_positions )
		{
			foreach ($save_positions as $position)
			{
				$position_ids[] = $position->position_id; 	
				$this->response->position[] = $this->load->view($view_file, array('post' => $_POST, 'position' => $position), true);
			}
		}

		if( $positions )
		{
			foreach ($positions as $position)
			{
				if( !in_array( $position->position_id, $position_ids ) )
					$this->response->position[] = $this->load->view($view_file, array('post' => $_POST, 'position' => $position), true);
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

		if($_POST['view_type'] == 'detail'){
			$view_file = 'detail/incumbent_form';
		}else{
			$view_file = 'edit/incumbent_form';
		}

		$this->load->helper('form');
		$data['title'] = 'With Incumbent Settings';
		$data['description'] = 'This section used to plan and modify positions with incumbent.';
		$data['content'] = $this->load->view($view_file, $vars, true);

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

		if($_POST['view_type'] == 'detail'){
			$view_file = 'detail/position_form';
		}else{
			$view_file = 'edit/position_form';
		}

		$this->load->helper('form');
		$this->db->limit(1);
		$position = $this->db->get_where("users_position", array('position_id' => $_POST['position_id']))->row();
		$data['title'] = $position->position;
		$data['description'] = 'This section used to plan positions, budget and modify headcount.';
		$data['content'] = $this->load->view($view_file, $vars, true);

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
					'action_id' => $action_id,
					'month' => $month[$index],
					'budget' => $budget[$index],
					'company_id' => $company_id[$index],
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
					'needed' => $needed[$index],
					'month' => $month,
					'budget' => $budget[$index],
					'company_id' => $company_id[$index],
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
			
			$dept = $this->db->get_where("users_department", array('department_id' => $users['department_id']))->row_array();
			$data['record']['recruitment_manpower_plan.departmenthead'] = (isset($dept['immediate']) ? $dept['immediate'] : '');
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
	        '1' => 'January',
	        '2' => 'February',
	        '3' => 'March',
	        '4' => 'April',
	        '5' => 'May',
	        '6' => 'June',
	        '7' => 'July',
	        '8' => 'August',
	        '9' => 'September',
	        '10' => 'October',
	        '11' => 'November',
	        '12' => 'December',
	    );

		$data['job_ranks'] = $job_ranks;
		$data['employment_statuss'] = $employment_statuss;
		$data['job_classes'] = $job_classes;
		$data['companies'] = $companys;
		$data['months'] = $months;
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

	function _list_options_active( $record, &$rec )
	{
		//temp remove until view functionality added
		if( $this->permission['detail'] )
		{
			$rec['detail_url'] = $this->mod->url . '/detail/' . $record['record_id'];
			$rec['options'] .= '<li><a href="'.$rec['detail_url'].'"><i class="fa fa-info"></i> '. lang('common.view') .'</a></li>';
		}

		if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}	
		
		if( isset($this->permission['delete']) && $this->permission['delete'] )
		{
			$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
			$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
		}
	}

	public function detail( $record_id, $child_call = false )
	{
		if( !$this->permission['detail'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_detail( $child_call );
	}

	private function _detail( $child_call )
	{
		if( !$this->_set_record_id() )
		{
			echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->record_id = $data['record_id'] = $_POST['record_id'];
		
		$record_check = $this->mod->_exists( $this->record_id );
		if( $record_check === true )
		{
			$result = $this->mod->_get( 'detail', $this->record_id );
			$data['record'] = $result->row_array();
			$this->load->vars( $data );

			if( !$child_call ){
				if( !IS_AJAX )
				{
					$this->load->helper('form');
					$this->load->helper('file');
					echo $this->load->blade('pages.detail')->with( $this->load->get_cached_vars() );
				}
				else{
					$data['title'] = $this->mod->short_name .' - Detail';
					$data['content'] = $this->load->blade('pages.quick_detail')->with( $this->load->get_cached_vars() );

					$this->response->html = $this->load->view('templates/modal', $data, true);

					$this->response->message[] = array(
						'message' => '',
						'type' => 'success'
					);
					$this->_ajax_return();
				}
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
}