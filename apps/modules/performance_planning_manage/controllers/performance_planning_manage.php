<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Performance_planning_manage extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('performance_planning_manage_model', 'mod');
		$this->load->model('appraisal_individual_planning_model', 'mod_personal');
		parent::__construct();
		$this->lang->load('performance_planning');
		$this->lang->load('appraisal_individual_planning');
	}


	public function index()
	{
        $permission = $this->config->item('permission');
        $vars['appraisal_individual_planning'] = isset($permission['appraisal_individual_planning']) ? $permission['appraisal_individual_planning'] : 0;
        $vars['performance_planning'] = isset($permission['performance_planning']) ? $permission['performance_planning'] : 0;

		// $this->db->order_by('performance_status', 'asc');
		$this->db->group_by('year,performance_type_id');
		$performance_planning_year = $this->db->get_where('performance_planning', array('deleted' => 0));
		$vars['performance_planning_year'] = $performance_planning_year->result();

        $this->load->vars($vars);
        parent::index();
	}

	public function edit( $record_id, $child_call = false )
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
		$data['reminder_ids'] = array();

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

			//get rating scores
			$reference_ids = $this->db->get_where('performance_planning_applicable', array('planning_id' => $this->record_id))->result_array();
			$references= array();
			foreach ($reference_ids as $index => $value){
				$references[] = $value['user_id'];
			}
			$data['record']['performance_planning_applicable.user_id'] = implode(',', $references);

			$data['reminder_ids'] = $this->db->get_where('performance_planning_reminder', array('planning_id' => $this->record_id, 'deleted' => 0))->result_array();

	        $this->load->model('appraisal_template_model', 'template');
	        $vars['template'] = $this->template;

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

		$this->_ajax_return();
	}

	private function _process_lists( $records, $trash )
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

			if(!$trash)
				$this->_list_options_active( $record, $rec );
			else
				$this->_list_options_trash( $record, $rec );

			$record['login_user_id'] = $this->user->user_id;

			$record = array_merge($record, $rec);
			$this->response->list .= $this->load->blade('list_template', $record, true)->with( $this->load->get_cached_vars() );
		}
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
				if ($filter_by_key == 'status_id'){
					$filter_by_key = 'ww_performance_planning.status_id';
				}
								
				if( $filter_value != "" ) $filter = 'AND '. $filter_by_key .' = "'.$filter_value.'"';	
			}
		}
		else{
			if( $filter_by && $filter_by != "" )
			{
				if ($filter_by == 'status_id'){
					$filter_by = 'ww_performance_planning.status_id';
				}

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
		$this->load->model('performance_planning_admin_model', 'plan_admin');
		$rec['view_users'] = $this->plan_admin->url . '/index/' . $record['record_id'];
		$rec['options'] .= '<li><a href="'.$rec['view_users'].'"><i class="fa fa-user"></i> ' . lang('performance_planning.view_emp') . '</a></li>';

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

	function filter_status() {
		$this->_ajax_only();

		$department_id = $this->input->post('dept_id');
		$planning_id = $this->input->post('planning_id');
		$status_id = $this->input->post('status_id');

		$users = $this->mod->filter_status($department_id, $planning_id, $this->user->user_id, $status_id);
		
		$this->response->filter_status = '';
		foreach($users as $user_id => $user){
			switch($user['status_id']){
				case 1: //Draft
					$color_class = 'orange';
				break;
				case 2: //For Approval
					$color_class = 'yellow';
				break;
				case 3: //Pending
					$color_class = 'red';
				break;
				case 4: //Approved
					$color_class = 'green';
				break;
				default:
					$color_class = 'default';
				break;
			}
			$href = get_mod_route('appraisal_individual_planning') . '/review/'.$planning_id.'/'.$user_id.'/'.$this->user->user_id;
			$this->response->filter_status  .= '<span class="margin-right-5"><a type="button" href="'.$href.'" class="btn '.$color_class.' btn-xs margin-bottom-6" data-id="'.$user_id.'"> '.$user['name'].' </a></span>';
		}
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();
	}

	function get_appplicable_references() {
		$this->_ajax_only();

		$record_id = $this->input->post('record_id');
		$where = array('planning_id'=>$record_id);
		$applicable_for = $this->db->get_where('performance_planning_applicable', $where)->result_array();
		
		foreach($applicable_for as $index => $value){
			$this->response->applicable_for[] = array(
				'label' => $value['fullname'],
				'value' => $value['user_id']
				);
		}

		$this->_ajax_return();
	}

	public function get_filters(){
		$this->_ajax_only();
		if($this->input->post('record_id') > 0){
			$data = array();

			// $where = array('deleted'=>0);
			switch($this->input->post('record_id')){
				case 1: //company
					$this->db->select('company_id as value,company as label');
					$this->db->order_by('company', '0');
					$this->db->where('deleted', '0');
					$filter_by = $this->db->get('users_company');
				break;
				case 2: //Location
					$this->db->select('location_id as value,location as label');
					$this->db->order_by('location', '0');
					$this->db->where('deleted', '0');
					$filter_by = $this->db->get('users_location');
				break;
				case 3: //Department
					$this->db->select('department_id as value,department as label');
					$this->db->order_by('department', '0');
					$this->db->where('deleted', '0');
					$filter_by = $this->db->get('users_department');
				break;
				case 4: //Division
					$this->db->select('division_id as value,division as label');
					$this->db->order_by('division', '0');
					$this->db->where('deleted', '0');
					$filter_by = $this->db->get('users_division');
				break;
				case 5: //Position
					$this->db->select('position_id as value,position as label');
					$this->db->order_by('position', '0');
					$this->db->where('deleted', '0');
					$filter_by = $this->db->get('users_position');
				break;				
				case 6: //Division
					$this->db->select('job_class_id as value,job_class as label');
					$this->db->order_by('job_class', '0');
					$this->db->where('deleted', '0');
					$filter_by = $this->db->get('users_job_class');
				break;
			}
		}else{
			$this->response->message[] = array(
				'message' => 'Please Select Filter By',
				'type' => 'warning'
				);

		}

		$this->response->filter_id = array();
		if($this->input->post('planning_id') > 0){
			$where = array('deleted'=>0, 'planning_id'=>$this->input->post('planning_id'));
			$planning_data = $this->db->get_where('performance_planning', $where)->row_array();
        	$filter_ids = $planning_data['filter_id'];
        	$this->response->filter_id = explode(',', $filter_ids);
		}

		if(isset($filter_by)){
	        $this->response->count = $filter_by->num_rows();
	        $this->response->selected_filter = 0;
	        $this->response->filter_by = "";
	        foreach( $filter_by->result() as $filterBy )
	        {
	        	$selected = '';
	        	if((!empty($this->response->filter_id) && in_array($filterBy->value, $this->response->filter_id))){
	        		$selected = 'selected="selected"';
	            	$this->response->selected_filter = 1;
	        	}
	            $this->response->filter_by .= '<option value="'.$filterBy->value.'" '.$selected.'>'.$filterBy->label.'</option>';
	        }
	    }
		$this->_ajax_return();
	}

    function get_selection_filters()
    {
    	if ($this->input->post('template_id') == ''){
	        $this->response->message[] = array(
	            'message' => '',
	            'type' => 'success'
	        );

	        $this->_ajax_return(); 
    	}

        $this->_ajax_only();
        $filter_by = $this->input->post('filter_by');
        $filter_id = $this->input->post('filter_id');
        $template_id = implode(",",$this->input->post('template_id'));
        $employment_status_id = $this->input->post('employment_status_id');

		$template_qry = "SELECT * FROM 
						{$this->db->dbprefix}performance_template
						WHERE template_id IN ({$template_id})";
		$applicables = $this->db->query( $template_qry )->result_array();

		$qry = "SELECT partners.alias, partners.partner_id, partners.user_id
                FROM partners
                INNER JOIN users_profile ON partners.user_id = users_profile.user_id
                INNER JOIN {$this->db->dbprefix}users users ON partners.user_id = users.user_id
                LEFT JOIN {$this->db->dbprefix}partners_personal pp ON partners.partner_id = pp.partner_id AND pp.key = 'job_class'
                LEFT JOIN {$this->db->dbprefix}users_job_class ujc ON pp.key_value = ujc.job_class
                WHERE partners.deleted = 0 AND users.active = 1 AND users_profile.reports_to_id = {$this->user->user_id} 
                ";

		if(!empty($filter_id)){
        	$filter_id = implode(',',$this->input->post('filter_id'));
			switch($filter_by){
				case 1: //company
		            $qry .= " AND users_profile.company_id IN ({$filter_id}) ";
				break;
				case 2: //Location
		            $qry .= " AND users_profile.location_id IN ({$filter_id}) ";
				break;
				case 3: //Department
	            	$qry .= " AND users_profile.department_id IN ({$filter_id})  ";
				break;
				case 4: //Division
	            	$qry .= " AND users_profile.division_id IN ({$filter_id})  ";
	            break;
	            case 5: //position
	            	$qry .= " AND users_profile.position_id IN ({$filter_id})  ";
				break;
			}
		}

		if(!empty($employment_status_id)){
        	$employment_status_id = implode(",",$this->input->post('employment_status_id'));
			$qry .= " AND partners.status_id IN ({$employment_status_id})  ";
		}

		$employment_type = array();
		$job_class = array();
		foreach($applicables as $applicable){
			switch($applicable['applicable_to_id']){
				case 1: //employment type
					$applicable_to[] = $applicable['applicable_to'];
				break;
				case 6: //job class
					$job_class[] = $applicable['applicable_to'];
				break;
			}
		}

		if( sizeof($employment_type) > 0 )
		{
	        $applicable_tos = implode(",",$employment_type);
			$qry .= " AND employment_type_id IN ({$applicable_tos})  ";
        }

        if( sizeof($job_class) > 0 )
		{
	        $applicable_tos = implode(",",$job_class);
			$qry .= " AND ujc.job_class_id IN ({$applicable_tos})  ";
        }

        $qry .= " ORDER BY partners.alias ASC";

        $employees = $this->db->query( $qry );

		$this->response->filter_id = array();
		if($this->input->post('planning_id') > 0){
			$where = array('planning_id'=>$this->input->post('planning_id'));
			$planning_data = $this->db->get_where('performance_planning_applicable', $where)->result_array();
        	
        	$filter_ids = array();
        	foreach($planning_data as $index => $value){
        		$filter_ids[] = $value['user_id'];
        	}
        	$this->response->filter_id = $filter_ids;
		}

        $this->response->count = $employees->num_rows();
        $this->response->selected_filter = 0;
        $this->response->employees = "";
        foreach( $employees->result() as $employee )
        {   
        	$selected = '';
        	if(in_array($employee->user_id, $this->response->filter_id) || !($this->input->post('planning_id') > 0) ){
        		$selected = 'selected="selected"';
            	$this->response->selected_filter = 1;
        	}
            $data['partner_id_options'][$employee->user_id] = $employee->alias;
            $this->response->employees .= '<option value="'.$employee->user_id.'" '.$selected.'>'.$employee->alias.'</option>';
        }


        // $this->response->filtered_employees = $view['content'];

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

	public function save( $child_call = false )
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
		
		if ($this->input->post('error') == 'true' ){
			$this->response->message[] = array(
				'message' => 'Total weight should be 100 percent',
				'type' => 'error'
			);
			$this->_ajax_return();
		}

		$child_table = 'performance_planning_reminder';
		$child_primary_id = 'reminder_id';
		$child_table_data = array();
		if(isset($_POST['performance_planning_reminder'])){
			$child_table_data = $_POST['performance_planning_reminder'];
		}
		if(isset($_POST['performance_planning_applicable'])){
			$applicable_for_data['performance_planning_applicable'] = $_POST['performance_planning_applicable'];
		}

		unset( $_POST['notification_id'] );
		unset( $_POST['performance_planning_reminder'] );
		unset( $_POST['performance_planning_applicable'] );

        $template_ids = implode(",", $_POST['performance_planning']['template_id']);

        $select_templates = " SELECT applicable_to 
        					FROM {$this->db->dbprefix}performance_template 
        					WHERE template_id IN ({$template_ids}) ";

        $applicable_data = $this->db->query($select_templates)->result_array();

        $applicables = array();
        foreach($applicable_data as $data){
        	$data = explode(",", $data['applicable_to']);
        	foreach ($data as $datum){
        		if(in_array($datum, $applicables)){
	                $this->response->message[] = array(
	                    'message' => 'Selected templates have the same applicable to',
	                    'type' => 'warning'
	                );
					$this->_ajax_return();
        		}else{
        			$applicables[] = $datum;
        		}
        	}
        }

		$transactions = true;
		$this->db->trans_begin();
		$this->response = $this->mod->_save( $child_call );
		$error = false;

		if( $this->response->saved )
		{
			if(!empty($child_table_data)){
				$child_record = array();
				foreach($child_table_data[$child_primary_id] as $index => $value){				
					//start saving with performance_planning_reminder table
			        $record = $this->db->get_where( $child_table , array( $child_primary_id => $value ) );
			        $child_record['planning_id'] = $this->response->record_id;
			        $child_record['notification_id'] = $child_table_data['notification_id'][$index];
			        $child_record['date'] = date('Y-m-d', strtotime($child_table_data['date'][$index]));
			        $child_record['status_id'] = $child_table_data['status_id'][$index];
			        $child_record['file'] = $child_table_data['file'][$index];
			        switch( true )
			        {
			            case $record->num_rows() == 0:
			                //add mandatory fields
			                $child_record['created_on'] = date('Y-m-d H:i:s');
			                $child_record['created_by'] = $this->user->user_id;

			                $this->db->insert($child_table, $child_record);
			                if( $this->db->_error_message() == "" )
			                {
			                    $child_record_id = $this->child_record_id = $this->db->insert_id();
			                }
			                break;
			            case $record->num_rows() == 1:
			                $child_record['modified_by'] = $this->user->user_id;
			                $child_record['modified_on'] = date('Y-m-d H:i:s');

			                $this->db->update( $child_table, $child_record, array( $child_primary_id => $value) );
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
			}

	        // DELETE/INSERT to applicable
	        $applicable_for_insert = array();
	        // $this->db->delete('performance_planning_applicable', array( $this->mod->primary_key => $this->response->record_id ) ); 
	        foreach($applicable_for_data as $field => $value){
	            $applicable_for_insert[$this->mod->primary_key] = $this->response->record_id;
	            $template_id = $_POST['performance_planning']['template_id'];
	            $appraisal_status_id = $_POST['performance_planning']['status_id'];
	            $performance_type_id = $_POST['performance_planning']['performance_type_id'];
	            $planning_year = $_POST['performance_planning']['year'];
				$performance_type = $this->db->get_where( 'performance_setup_performance' , array( 'performance_id' => $performance_type_id ) )->row_array();

	            // $user_id = explode(",", $value['user_id']);
	            $user_id = $value['user_id'];
	            //delete from applicable if REMOVED
	            $this->db->where_not_in('user_id', $user_id);
	        	$this->db->delete('performance_planning_applicable', array( $this->mod->primary_key => $this->response->record_id ) ); 
	            //delete from approver if REMOVED
/*	            $this->db->where_not_in('user_id', $user_id);
	        	$this->db->delete('performance_planning_approver', array( $this->mod->primary_key => $this->response->record_id ) ); */
	            foreach ($user_id as $index => $id){
	            	$applicable_for_insert['user_id'] = $id;
	            	$applicable_for_insert['status_id'] = (isset($_POST['applicable_status']) ? $_POST['applicable_status'] : 0);
	            	$applicable_for_insert['to_user_id'] = $id;
					// switch($applicable_for_insert['applicable_for']){
					// 	case 1: //Employment Type
					// 		$full_name = $this->db->get_where( 'partners_employment_type' , array( 'employment_type_id' => $id ) )->row_array();
					// 		$applicable_for_insert['fullname'] = $full_name['employment_type'];
					// 	break;
					// 	case 2: //Employment Status
					// 		$full_name = $this->db->get_where( 'partners_employment_status' , array( 'employment_status_id' => $id ) )->row_array();
					// 		$applicable_for_insert['fullname'] = $full_name['employment_status'];
					// 	break;
					// 	case 3: //Position
					// 		$full_name = $this->db->get_where( 'users_position' , array( 'users_position_id' => $id ) )->row_array();
					// 		$applicable_for_insert['fullname'] = $full_name['users_position'];
					// 	break;
					// 	case 4: //Employee
							$full_name = $this->db->get_where( 'users' , array( 'user_id' => $id ) )->row_array();
							$applicable_for_insert['fullname'] = $full_name['full_name'];
					// 	break;
					// 	case 5: //Company
					// 		$full_name = $this->db->get_where( 'users_company' , array( 'company_id' => $id ) )->row_array();
					// 		$applicable_for_insert['fullname'] = $full_name['company'];
					// 	break;

					// }

					$this->db->where_in('template_id', $template_id);
					$applicables = $this->db->get( 'performance_template' )->result_array();
					foreach($applicables as $applicable){
						// $template_applicable = $this->db->get_where( 'performance_template_applicable' , array( 'applicable_to_id' => $applicable['applicable_to_id'] ) )->row_array();
						switch($applicable['applicable_to_id']){
							case 1: //employment type
								$this->db->where_in('employment_type_id', explode(',', $applicable['applicable_to']));
								$this->db->where('user_id', $id);
								$applicable_id = $this->db->get( 'partners' )->num_rows();
								if($applicable_id > 0){
									$applicable_for_insert['template_id'] = $applicable['template_id'];

									$this->db->where('user_id', $applicable_for_insert['user_id']);
									$this->db->where('template_id', $applicable_for_insert['template_id']);
									$this->db->where('planning_id', $applicable_for_insert['planning_id']);
									$applicable_exist = $this->db->get( 'performance_planning_applicable' );
									$send_feeds = 0;		
										
									if($applicable_exist->num_rows() == 0){
			            				$this->db->insert('performance_planning_applicable', $applicable_for_insert);
										$send_feeds = 1;
									}/*else{
										$this->db->where('user_id', $applicable_for_insert['user_id']);
										$this->db->where('template_id', $applicable_for_insert['template_id']);
										$this->db->where('planning_id', $applicable_for_insert['planning_id']);										
										$this->db->update('performance_planning_applicable', $applicable_for_insert);
										$applicables = $applicable_exist->row_array();
										$send_feeds = 1;
									}
*/
									//add feeds if within scope
				                    if( $send_feeds == 1 )
				                    {
										//$appraisal_status = ($appraisal_status_id == 1) ? 'is now open' : 'was closed';
										$feed_content = "The {$planning_year} performance planning period for {$performance_type['performance']} is for your review and acceptance";
				                        $this->load->model('system_feed');
				                        $feed = array(
				                            'status' => 'info',
				                            'message_type' => 'Performance Appraisal',
				                            'user_id' => $this->user->user_id,
				                            'feed_content' => $feed_content,
				                            'uri' => $this->mod_personal->route . '/edit/'.$_POST['record_id'].'/'.$id,
				                            'recipient_id' => $id
				                        );

				                        $recipients = array($id);
				                        $this->system_feed->add( $feed, $recipients );
				                    
				                        $this->response->notify[] = $id;
				                    }

							        $this->db->where('planning_id',$this->response->record_id);
							        $appraisal_planning_info_result = $this->db->get( 'performance_planning');
							        $appraisal_planning_info = $appraisal_planning_info_result->row();

									$performance_populate_approvers = $this->db->query("CALL sp_performance_planning_populate_approvers({$this->response->record_id}, ".$appraisal_planning_info->created_by.", ".$id.")");
									mysqli_next_result($this->db->conn_id);	 				                    

								}
							break;
							case  6: // job class
								$qry = "select c.*
								FROM {$this->db->dbprefix}partners_personal a
								LEFT JOIN {$this->db->dbprefix}partners b on b.partner_id = a.partner_id
								LEFT JOIN {$this->db->dbprefix}users c on c.user_id = b.user_id
								LEFT JOIN {$this->db->dbprefix}users_job_class d on d.job_class = a.key_value
								where a.key = 'job_class' and c.user_id = {$id} and d.job_class_id in ({$applicable['applicable_to']})";
								$applicable_id = $this->db->query( $qry )->num_rows();
								if($applicable_id > 0){
									$applicable_for_insert['template_id'] = $applicable['template_id'];

									$this->db->where('user_id', $applicable_for_insert['user_id']);
									$this->db->where('template_id', $applicable_for_insert['template_id']);
									$this->db->where('planning_id', $applicable_for_insert['planning_id']);
									$applicable_exist = $this->db->get( 'performance_planning_applicable' );
									$send_feeds = 0;		

		            				$performance_populate_approvers = $this->db->query("CALL sp_performance_planning_populate_approvers({$this->response->record_id}, ".$id.")");
									mysqli_next_result($this->db->conn_id);
										
									if($applicable_exist->num_rows() == 0){
			            				$this->db->insert('performance_planning_applicable', $applicable_for_insert);
										$send_feeds = 1;
									}else{
										$applicables = $applicable_exist->row_array();
										if($applicables['status_id'] != 4 || $appraisal_status_id != 1){//not approved
											$send_feeds = 1;
										}
									}

									//add feeds if within scope
				                    if( $send_feeds == 1 )
				                    {
										$appraisal_status = ($appraisal_status_id == 1) ? 'is now open' : 'was closed';
				                    	if(isset($performance_type['for_probi'])){
				                    		$feed_content = "The performance planning period for your {$performance_type['performance']} $appraisal_status";
				                    	}else{
				                    		$feed_content = "The {$planning_year} performance planning period for {$performance_type['performance']} $appraisal_status";
				                    	}
				                        $this->load->model('system_feed');
				                        $feed = array(
				                            'status' => 'info',
				                            'message_type' => 'Comment',
				                            'user_id' => $this->user->user_id,
				                            'feed_content' => $feed_content,
				                            // 'uri' => $this->mod->route . '/review/'.$_POST['planning_id'].'/'.$_POST['user_id'].'/'.$approver->approver_id,
				                            'recipient_id' => $id
				                        );

				                        $recipients = array($id);
				                        $this->system_feed->add( $feed, $recipients );
				                    
				                        $this->response->notify[] = $id;
				                    }

								}
							break;
						}	
        				//$performance_planning_period_email = $this->db->query("CALL sp_performance_planning_period_email( {$planning_year}, {$id}, '{$performance_type['performance']}', {$appraisal_status_id}, '{$performance_type['for_probi']}' )");
						mysqli_next_result($this->db->conn_id);					
					}

		            if( $this->db->_error_message() != "" ){
		                $this->response->message[] = array(
		                    'message' => $this->db->_error_message(),
		                    'type' => 'error'
		                );
		                $error = true;
		                goto stop;
		            }


		            if (isset($_POST['item'])){
				        $this->db->where('planning_id',$this->input->post('record_id'));
				        $this->db->delete('performance_planning_applicable_items');

				        $this->db->where('planning_id',$this->input->post('record_id'));
				        $this->db->delete('performance_planning_applicable_items_header');

				        $this->db->where('planning_id',$this->input->post('record_id'));
				        $this->db->delete('performance_planning_applicable_fields');

				        $this->db->where('planning_id',$this->input->post('record_id'));
				        $this->db->delete('performance_planning_applicable_fields_header');	

			            foreach($applicable_for_data['performance_planning_applicable']['user_id'] as $field => $id){		            	
					        $item = $_POST['item'];
					        $field = $_POST['field'];
					        			        			        			        
					        $ctr = 1;
					        foreach ($item as $key_item => $value_item) {
					        	foreach ($value_item as $key1 => $value1) {
					        		$item_info = array(
					        				'planning_id' => $this->input->post('record_id'),
					        				'user_id' => $id,
					        				'section_column_id' => $key_item,
					        				'item' => $key1 + 1,
					        				'parent_id' => ($value1 == 1 ? 1 : ''),
					        				'sequence' => $ctr
					        			);

		/*		                    $where = array(
				                        'planning_id' => $this->input->post('record_id'),
				                        'user_id' => $id,
				                    );*/
									
			                    	$this->db->insert('performance_planning_applicable_items',$item_info);
			                    	$item_id = $this->db->insert_id();

			                    	$this->db->insert('performance_planning_applicable_items_header',$item_info);
			                    	$item_id_header = $this->db->insert_id();

					        		$field_info = array(
					        				'planning_id' => $this->input->post('record_id'),
					        				'user_id' => $id,
					        				'item_id' => $item_id,
					        				'section_column_id' => $key_item,
					        				'value' => (isset($field[$key_item][$key1]) ? $field[$key_item][$key1] : '')
					        			);   

									$this->db->insert('performance_planning_applicable_fields',$field_info);

									$this->db->insert('performance_planning_applicable_fields_header',$field_info);
		/*		                    $check = $this->db->get_where('performance_planning_applicable_items', $where);
				                    if ($check && $check->num_rows() > 0){

				                    }
				                    else{
				                    	$this->db->insert('performance_planning_applicable_items',$item_info);
				                    	$item_id = $this->db->insert_id();

						        		$field_info = array(
						        				'planning_id' => $this->input->post('record_id'),
						        				'user_id' => $id,
						        				'item_id' => $item_id,
						        				'section_column_id' => $key_item,
						        				'value' => $field[$key_item][$key1]
						        			);   

										$this->db->insert('performance_planning_applicable_fields',$field_info);		        			                 	
				                    }*/
				                    $ctr++;
				                }
					        }	
					    }
				    }
	            }            
	        }       
            //send to approvers
/*			$planning_get_approvers = $this->db->query("SELECT * 
										FROM {$this->db->dbprefix}performance_planning_approver 
										WHERE planning_id = {$this->response->record_id} 
										GROUP BY approver_id")->result_array();
			// mysqli_next_result($this->db->conn_id);
	        if(count($planning_get_approvers) > 0){
				$appraisal_status = ($appraisal_status_id == 1) ? 'is now open' : 'was closed';
            	if(isset($performance_type['for_probi'])){
            		$feed_content = "The performance planning period for {$performance_type['performance']} $appraisal_status";
            	}else{
            		$feed_content = "The {$planning_year} performance planning period for {$performance_type['performance']} $appraisal_status";
            	}
				foreach ($planning_get_approvers as $approver){
	                $this->load->model('system_feed');
	                $feed = array(
	                    'status' => 'info',
	                    'message_type' => 'Comment',
	                    'user_id' => $this->user->user_id,
	                    'feed_content' => $feed_content,
	                    // 'uri' => $this->mod->route . '/review/'.$_POST['planning_id'].'/'.$_POST['user_id'].'/'.$approver->approver_id,
	                    'recipient_id' => $approver['approver_id']
	                );

	                $recipients = array($approver['approver_id']);
	                $this->system_feed->add( $feed, $recipients );
	            
	                $this->response->notify[] = $approver['approver_id'];
	        	}
	        }*/
            
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

		$this->_ajax_return();
	}

	//for planning section module
	function update_applicable()
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
		
		$options = $this->mod->_get_applicable_options( $this->input->post('applicable_to_id') ); 

		$this->response->options = "";
		foreach( $options as $value => $label )
		{
			$this->response->options .= '<option value="'.$value.'">'.$label.'</option>';
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function get_section_form()
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
		
		$section_id = $this->input->post('section_id');
		$template_id = $this->input->post('template_id');
		$vars['template_section_id'] = $section_id;
		$vars['template_id'] = $template_id;
		$vars['template_section'] = '';
		$vars['parent_id'] = '';
		$vars['weight'] = '';
		$vars['section_type_id'] = '';
		$vars['min_crowdsource'] = '';
		$vars['sequence'] = '';
		$vars['header'] = '';
		$vars['footer'] = '';

		if( !empty( $section_id ) )
		{
			$vars = $this->db->get_where('performance_template_section', array('template_section_id' => $section_id))->row_array();
		}
		
		$this->load->vars( $vars );

		$this->load->helper('form');
		$data['title'] = 'Add/Edit Section';
		$data['content'] = $this->load->blade('edit.section_form')->with( $this->load->get_cached_vars() );

		$this->response->section_form = $this->load->view('templates/modal', $data, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();	
	}

	function save_section()
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
		
		$this->load->library('form_validation');

		$config = array(
			array(
				'field'   => 'template_id',
				'label'   => 'Template',
				'rules'   => 'required'
			),
			array(
				'field'   => 'template_section',
				'label'   => 'Template Title',
				'rules'   => 'required'
			),
			array(
				'field'   => 'section_type_id',
				'label'   => 'Section Type',
				'rules'   => 'required'
			),
			array(
				'field'   => 'weight',
				'label'   => 'Weight',
				'rules'   => 'numeric'
			),
			array(
				'field'   => 'sequence',
				'label'   => 'Sequence',
				'rules'   => 'required|numeric'
			)
		);

		$this->form_validation->set_rules($config); 

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

		$template_section_id = $this->input->post('template_section_id');
		unset( $_POST['template_section_id'] );
		$previous_main_data = array();
		if( empty( $template_section_id )  )
		{
			$this->db->insert('performance_template_section', $_POST);
			$action = 'insert';
		}
		else{
		//get previous data for audit logs
			$where_array = array('template_section_id' => $template_section_id);
			$previous_main_data = $this->db->get_where('performance_template_section', $where_array)->row_array();
			$this->db->update('performance_template_section', $_POST, $where_array);
			$action = 'update';
		}
        //create system logs
        $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, $action, 'performance_template_section', $previous_main_data, $_POST);

		$this->response->close_modal = true;

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function get_section_header(){
		$this->load->model('appraisal_template_model', 'template');
		$sections = $this->template->build_sections($this->input->post('template_id'));
		
		$this->response->section_header = $this->load->view('edit/section_header', array('sections' => $sections, 'planning_id' => $this->input->post('planning_id') ), true);		

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

/*	function get_sections()
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

		$sections = $this->mod->build_sections( $this->input->post('template_id') );

		$this->response->sections = $this->load->view('edit/sections', array('sections' => $sections ), true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}*/

	function get_column_form()
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

		$column_id = $this->input->post('column_id');
		$section_id = $this->input->post('section_id');

		$vars['section_column_id'] = $column_id;
		$vars['template_section_id'] = $section_id;
		$vars['title'] = '';
		$vars['uitype_id'] = '';
		$vars['sequence'] = '';
		$vars['width'] = '';
		$vars['rating_group_id'] = '';
		$vars['min_items'] = '';
		$vars['max_items'] = '';
		$vars['min_weight'] = '';

		if( !empty( $column_id ) )
		{
			$vars = $this->db->get_where('performance_template_section_column', array('section_column_id' => $column_id))->row_array();
		}
		
		$this->load->vars( $vars );

		$this->load->helper('form');
		$data['title'] = 'Add/Edit Column';
		$data['content'] = $this->load->blade('edit.sections.column_form')->with( $this->load->get_cached_vars() );

		$this->response->column_form = $this->load->view('templates/modal', $data, true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();	
	}

	function save_column()
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

		$this->load->library('form_validation');

		$config = array(
			array(
				'field'   => 'title',
				'label'   => 'Title',
				'rules'   => 'required'
			),
			array(
				'field'   => 'sequence',
				'label'   => 'Sequence',
				'rules'   => 'required|numeric'
			),
			array(
				'field'   => 'width',
				'label'   => 'Width',
				'rules'   => 'required|numeric'
			),
			array(
				'field'   => 'uitype_id',
				'label'   => 'UIType',
				'rules'   => 'required'
			)
		);

		if( $this->input->post('uitype_id') == 5 )
		{
			$config[] = array(
			'field'   => 'rating_group_id',
			'label'   => 'Rating',
			'rules'   => 'required'
			);	
		}

		$this->form_validation->set_rules($config); 

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

		$section_column_id = $this->input->post('section_column_id');
		unset( $_POST['section_column_id'] );
		$previous_main_data = array();
		if( empty( $section_column_id )  )
		{
			$this->db->insert('performance_template_section_column', $_POST);
			$action = 'insert';
		}
		else{
		//get previous data for audit logs
			$where_array = array('section_column_id' => $section_column_id);
			$previous_main_data = $this->db->get_where('performance_template_section_column', $where_array)->row_array();
			$this->db->update('performance_template_section_column', $_POST, $where_array);
			$action = 'update';
		}
        //create system logs
        $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, $action, 'performance_template_section_column', $previous_main_data, $_POST);

		$this->response->close_modal = true;		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function delete_column()
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

		$column_id = $this->input->post('column_id');
		$this->db->update('performance_template_section_column', array('deleted' => 1), array('section_column_id' => $column_id));
		//create system logs
        $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'delete', 'performance_template_section_column - section_column_id', array(), array('section_column_id' => $column_id));
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function delete_section()
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

		$template_section_id = $this->input->post('section_id');
		$this->db->update('performance_template_section', array('deleted' => 1), array('template_section_id' => $template_section_id));
		//create system logs
        $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'delete', 'performance_template_section - template_section_id', array(), array('template_section_id' => $template_section_id));

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function get_item_form()
    {
        $this->_ajax_only();

        $vars = $_POST;
        $vars['sequence'] = '';
        $vars['item'] = '';
        $vars['tripart'] = '';

        if( !empty( $vars['item_id'] ) )
        {
            $this->db->limit(1);
            $vars = $this->db->get_where('performance_template_section_column_item', array('item_id' => $vars['item_id']))->row_array();
        }

        $this->load->vars( $vars );

        $this->load->helper('form');
        $data['title'] = 'Add/Edit Column Item';
        $data['content'] = $this->load->blade('edit.item_form')->with( $this->load->get_cached_vars() );

        $this->response->item_form = $this->load->view('templates/modal', $data, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }

    function save_item()
    {
        $this->_ajax_only();

        $this->load->library('form_validation');

        $config = array(
            array(
                'field'   => 'item',
                'label'   => 'Item',
                'rules'   => 'required'
            )
        );

        $this->form_validation->set_rules($config); 

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

        $item_id = $this->input->post('item_id');
        unset( $_POST['item_id'] );
		$previous_main_data = array();
		if( empty( $item_id )  )
		{
			$this->db->insert('performance_template_section_column_item', $_POST);
			$action = 'insert';
		}
		else{
		//get previous data for audit logs
			$where_array = array('item_id' => $item_id);
			$previous_main_data = $this->db->get_where('performance_template_section_column_item', $where_array)->row_array();
			$this->db->update('performance_template_section_column_item', $_POST, $where_array);
			$action = 'update';
		}
        //create system logs
        $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, $action, 'performance_template_section_column_item', $previous_main_data, $_POST);

        $this->response->close_modal = true;

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();   
    }

    function get_items()
    {
        $this->_ajax_only();

        $column_id = $this->input->post('column_id');
        $column = $this->db->get_where('performance_template_section_column', array('section_column_id' => $column_id))->row();
        $_POST['section_id'] = $column->template_section_id;
        $this->get_section_items();
    }

    function get_section_items()
    {
        $this->_ajax_only();
        
        $this->response->items = $this->load->view('edit/section_items', $_POST, true);

        $this->response->section_id = $_POST['section_id'];
        $this->response->close_modal = true;

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();      
    }

    function delete_item()
    {
        $this->_ajax_only();
        
        $this->db->delete('performance_template_section_column_item', array('item_id' => $this->input->post('item_id')));
		//create system logs
        $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'delete', 'performance_template_section_column_item - item_id', array(), array('item_id' => $this->input->post('item_id')));
        
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }			
}