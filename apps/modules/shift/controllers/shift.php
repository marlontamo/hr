<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Shift extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('shift_model', 'mod');
		parent::__construct();
	}


	function save()
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

		$validation_rules = array();
	
		$validation_rules[] = 
		array(
			'field' => 'time_shift[company_id]',
			'label' => 'Company',
			'rules' => 'required'
			);
		$validation_rules[] = 
		array(
			'field' => 'time_shift[shift]',
			'label' => 'Shift',
			'rules' => 'required'
			);
		$validation_rules[] = 
		array(
			'field' => 'time_shift[time_start]',
			'label' => 'Time From',
			'rules' => 'required'
			);
		$validation_rules[] = 
		array(
			'field' => 'time_shift[time_end]',
			'label' => 'Time To',
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

		$this->db->trans_begin();
		$this->response = $this->mod->_save( true, false );

		if( $this->response->saved ){
			
			if( isset($_POST['time_shift']['company_id']) )
			{
				$applied_to = $_POST['time_shift']['company_id'];
				$this->db->delete('time_shift_apply_to_id', array('shift_id' => $this->response->record_id, 'apply_to' => 2));

				foreach( $applied_to as $company_id )
				{
					$insert = array(
						'shift_id' => $this->response->record_id,
						'apply_to' => 2,
						'apply_to_id' => $company_id
					);
					$this->db->insert('time_shift_apply_to_id', $insert);
				}				
			}

			if( isset($_POST['time_shift']['department_id']) )
			{
				$applied_to = $_POST['time_shift']['department_id'];
				$this->db->delete('time_shift_apply_to_id', array('shift_id' => $this->response->record_id, 'apply_to' => 4));

				foreach( $applied_to as $department_id )
				{
					if($department_id !== 'All'){
						$insert = array(
							'shift_id' => $this->response->record_id,
							'apply_to' => 4,
							'apply_to_id' => $department_id
						);
						$this->db->insert('time_shift_apply_to_id', $insert);
					}
					
				}
			}

			$this->db->trans_commit();

		}
		else{
			$this->db->trans_rollback();
		}
		
		$this->response->message[] = array(
			'message' => lang('common.save_success'),
			'type' => 'success'
		);

		$this->_ajax_return();
	}


	function shift_policy($shift_id = 0)
    {
        if( !$this->permission['list'])
        {
            echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
            die();
        }

        if( $shift_id == 0)
		{
			echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
			die();
		}

        $user_setting = APPPATH . 'config/users/'. $this->user->user_id .'.php';
        $user_id = $this->user->user_id;
        $this->load->config( "users/{$user_id}.php", false, true );
        $user = $this->config->item('user');

        $this->load->config( 'roles/'. $user['role_id'] .'/permission.php', false, true );
        $permission = $this->config->item('permission');
        
        $data['shift_id'] = $shift_id;
        
        $result = $this->mod->_get( 'edit', $shift_id );
		$record = $result->row_array(); 

		$companies = $this->mod->_get_shift_options( $shift_id, true , false, 2);
		$record['companies'] = $companies;

		$department = $this->mod->_get_shift_options( $shift_id, true , false, 4);
		$record['department'] = empty($department) ? 'All' : $department;

		$shift_value = $this->mod->get_shift_value($shift_id);
				
		$data['shift_value'] = $shift_value;

        $shift_classes = $this->db->get_where( 'time_shift_class', array( 'deleted' => 0 ) )->result_array();
		$data['shift_classes'] = $shift_classes;
		$data['record'] = $record;
		
        $this->load->vars($data);        
        echo $this->load->blade('pages.shift_policy')->with( $this->load->get_cached_vars() );
    }


    function save_class_value()
    {
    	$error = false;
		$post = $_POST;
		$table = 'time_shift_apply_to_value';
		$shift_id = $post['shift_id'];

		$this->db->where('shift_id', $shift_id);
		$shift_record = $this->db->get($table);

		$this->response->record_id = $this->record_id =  $post['pk'];
		unset( $post['pk'] );
        /***** END Form Validation (hard coded) *****/
        //SAVING START   
		$transactions = true;
		if( $transactions )
		{
			$this->db->trans_begin();
		}
		
		$main_record['class_id'][] = $this->record_id;
		$main_record['value'][] = $post['value'];
		
		switch( true )
		{				
			case $shift_record->num_rows() == 0:
				$values = json_encode($main_record);
				$this->db->insert($table, array('shift_id' => $shift_id, 'shift' => $values));
				if( $this->db->_error_message() == "" )
				{
					$this->response->record_id = $this->record_id = $shift_id;
				}
				$this->response->action = 'insert';
				break;
			case $shift_record->num_rows() == 1:
		
				$shift_value = json_decode($shift_record->row()->shift, true);
				
				if(isset($shift_value['class_id'])){
					foreach ($shift_value['class_id'] as $key => $class_id) {
						if(!in_array($class_id, $main_record['class_id'])){
							$main_record['class_id'][] = $class_id;	
							$main_record['value'][] = $shift_value['value'][$key];
						}						
					}
				}
				$values = json_encode($main_record);

				$this->db->update( $table, array('shift' => $values), array( 'shift_id' => $shift_id ) );
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

		$this->mod->_save_shift_class_company($this->record_id, $shift_id, $post['value']);

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
				'message' => 'Class value successfully updated.',
				'type' => 'success'
			);
		}

		$this->response->saved = !$error;

        $this->_ajax_return();
    }


    function get_shift_class_company_form()
	{
		$this->_ajax_only();
		$data = array();
		$data['title'] = 'Company Shift Policy';	
		$data['description'] = $this->input->post('class');	
		$data['shift_id'] = $this->input->post('shift_id');	
		$data['class_id'] = $this->input->post('class_id');	
		$data['data_type'] = $this->input->post('data_type');	
		$data['class_value'] = $this->input->post('class_value');	

		$companies = $this->mod->_get_shift_options( $this->input->post('shift_id'), true , false, 2);
		$data['companies'] = $companies;
		
		$class_company = array();
		foreach ($companies as $id => $company) {
			$shift_class_company = $this->mod->get_shift_class_company($id, $this->input->post('shift_id'), $this->input->post('class_id'));

			if($shift_class_company && $shift_class_company->num_rows() > 0){
				$value = $shift_class_company->row();
				$class_company[$id]['class_value'] = $value->class_value;
				$class_company[$id]['employment_status_id'] = $value->employment_status_id;
				$class_company[$id]['employment_type_id'] = $value->employment_type_id;
				$class_company[$id]['partners_id'] = $value->partners_id;
			}

		}
		
		$employment_type = $this->db->get_where('partners_employment_type', array('deleted' => 0))->result_array();
		$employment_status = $this->db->get_where('partners_employment_status', array('deleted' => 0, 'active' => 1))->result_array();

		$types[0] = 'ALL';
		foreach ($employment_type as $key => $type) {
			$types[$type['employment_type_id']] = $type['employment_type'];
		}
		asort($types);

		$status[0] = 'ALL';
		foreach ($employment_status as $key => $stat) {
			$status[$stat['employment_status_id']] = $stat['employment_status'];
		}
		asort($status);
		
		$qry = "SELECT partners.alias, partners.partner_id, partners.user_id 
                FROM partners
                INNER JOIN users_profile ON partners.user_id = users_profile.user_id
                WHERE partners.deleted = 0 AND active = 1";
        $qry .= " ORDER BY partners.alias ASC";

        $employees_qry = $this->db->query( $qry );
        $employees = array();
        foreach( $employees_qry->result_array() as $employee )
        {   
            $employees[$employee['partner_id']] = $employee['alias'];
        }

		$data['employment_type'] = json_encode($types);
		$data['employment_status'] = json_encode($status);
		$data['employees'] = json_encode($employees);
		$data['class_company'] = $class_company;

		$shift_value = $this->mod->get_shift_value($this->input->post('shift_id'));
		$data['shift_value'] = isset($shift_value[$this->input->post('class_id')]) ? $shift_value[$this->input->post('class_id')] : $data['class_value'];

		$this->load->vars( $data );
		
		$data['content'] = $this->load->blade('pages.shift_policy_form')->with( $this->load->get_cached_vars() );
		$this->response->shift_class_company_form = $this->load->view('templates/modal', $data, true);

        $this->response->message[] = array(
		    'message' => '',
		    'type' => 'success'
		);

    	$this->_ajax_return();
	}

	function save_company_policy()
	{
		$error = false;
		$post = $_POST;
		$table = 'time_shift_class_company';
		
		$this->db->where('company_id', $post['company_id']);
		$this->db->where('class_id', $post['class_id']);
		$this->db->where('shift_id', $post['shift_id']);
		$this->db->where('deleted', 0);
		$record = $this->db->get($table);

		$this->response->record_id = $this->record_id =  $post['shift_id'];
		$transactions = true;
		// $shift_value = $this->mod->get_shift_value($post['shift_id']);

		$value = isset($post['value']) ? $post['value'] : '';
		if(is_array($value)){
			$shift_value = $this->mod->get_shift_value($post['shift_id']);

			$class_value = (!empty($shift_value[$post['class_id']])) ? $shift_value[$post['class_id']] :  $post['class_value'];
			$value = implode(',', $post['value']);
			$main_record[$post['value_type']] = $value;
			$main_record['class_value'] = $class_value;
			
			
		}else{
			$class_value = $value;
			$main_record['class_value'] = $class_value;
			if(isset($post['value_type'])){
				$main_record[$post['value_type']] = $value;
			}
		}
		
		if( $transactions )
		{
			$this->db->trans_begin();
		}
		
		$main_record['shift_id'] = $post['shift_id']; 
		$main_record['class_id'] = $post['class_id'];
		$main_record['company_id'] = $post['company_id'];

		$company_details['main_record'] = $main_record;
		$company_details['company'] = array($post['company_id'] => 'company');
		$this->mod->_save_shift_class_company($post['class_id'], $post['shift_id'], $class_value, $company_details);

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
				'message' => 'Company Shift Policy successfully updated.',
				'type' => 'success'
			);
		}

		$this->response->saved = !$error;

        $this->_ajax_return();

	}

}