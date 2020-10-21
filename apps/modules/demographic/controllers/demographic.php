<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Demographic extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('demographic_model', 'mod');
		parent::__construct();
	}

	public function index()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}
		
		echo $this->load->blade('pages.dashboard')->with( $this->load->get_cached_vars() );
	}

	public function company()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}
		
		$profile = $this->db->get_where('users_profile', array('user_id' => $this->user->user_id))->row();
		$vars['company_id'] = $profile->company_id;
		$vars['company'] = $profile->company;
		$this->load->vars($vars);
		echo $this->load->blade('pages.dashboard')->with( $this->load->get_cached_vars() );
	}

	function get_gender_per_status_data()
	{
		$this->_ajax_only();
		$company_id = $this->input->post('company_id');
		$department_id = $this->input->post('department_id');
		$date = $this->input->post('date');
		$this->response->data = $this->mod->get_gender_per_status_data($company_id,$department_id,$date);
		$this->_ajax_return();
	}

	function get_age_profile_data()
	{
		$this->_ajax_only();
		$company_id = $this->input->post('company_id');
		$department_id = $this->input->post('department_id');
		$date = $this->input->post('date');
		$this->response->data = $this->mod->get_age_profile_data( $company_id,$department_id,$date );
		$this->_ajax_return();
	}

	function get_type_per_status_data()
	{
		$this->_ajax_only();
		$company_id = $this->input->post('company_id');
		$department_id = $this->input->post('department_id');
		$date = $this->input->post('date');
		$stats = $this->mod->get_type_per_status( $company_id,$department_id,$date );
		if( $stats )
		{
			$this->response->data = $stats;
		}
		else{
			$this->response->data = false;
		}
		$this->_ajax_return();
	}

	function get_tenure_data()
	{
		$this->_ajax_only();
		$company_id = $this->input->post('company_id');
		$department_id = $this->input->post('department_id');
		$date = $this->input->post('date');
		$this->response->data = $this->mod->get_tenure_stats( $company_id,$department_id,$date );
		$this->_ajax_return();
	}

	function update_department()
	{
		$this->_ajax_only();
		if($this->input->post('company_id') > 0){
			$where = 'company_id='.$this->input->post('company_id');
		}else{
			$where = "1=1";
		}

		$departments = $this->db->query('SELECT * FROM approver_class_department WHERE '.$where);
		$this->response->departments = '<option value="" selected="selected">Select Department</option>';
		foreach( $departments->result() as $department )
		{
			$this->response->departments .= '<option value="'.$department->department_id.'">'.$department->department.'</option>';
		}
		$this->_ajax_return();	
	}

	function get_population_division()
	{
		$this->_ajax_only();
		$company_id = $this->input->post('company_id');
		$department_id = $this->input->post('department_id');
		$date = $this->input->post('date');
		$this->response->data = $this->mod->get_population_division_stats( $company_id,$department_id,$date );
		$this->_ajax_return();
	}

	function get_long_lat_data()
	{
		$this->_ajax_only();
		$company_id = $this->input->post('company_id');
		$department_id = $this->input->post('department_id');
		$date = $this->input->post('date');
		$this->response->data = $this->mod->get_long_lat( $company_id,$department_id,$date );
		$this->_ajax_return();
	}

	function update_map(){
		$this->_ajax_only();

		$this->load->model('partners_model', 'partners_mod');
		$partner_id = $this->partners_mod->get_partner_id($this->user->user_id);
		if(!empty($partner_id)){
			$request_done = array();
			$partners_key = $this->db->get_where('partners_key', array('deleted' => 0, 'key_code' => 'map_location'))->row_array();
			$key_personal_qry = " SELECT * FROM {$this->db->dbprefix}partners_personal 
								WHERE partner_id = {$partner_id} AND deleted = 0 
								AND key_id = {$partners_key['key_id']} AND key_value !='' ";
			$key_personal_sql = $this->db->query($key_personal_qry);
			$request_done = $this->db->get_where('partners_personal_request', array('status' => 2, 'deleted' => 0, 'partner_id' => $partner_id, 'key_id' => $partners_key['key_id']))->row_array();
			
			if( !(count($request_done) > 0) && !($key_personal_sql->num_rows() > 0) ){
				$this->response->message[] = array(
			    	'message' => '',
			    	'type' => 'success'
				);
				$data = array();
				$this->response->update_map = $this->load->view('customs/prompt_enter_coor', $data, true);
			}
		}
        $this->_ajax_return();
	}

	function update_mapcoor(){
		$this->_ajax_only();
		$this->response->invalid=false;
		$error = false;

		$lat_lng =  $_POST['partners_personal']['map_location'];

		if(empty($lat_lng)){
			$this->response->invalid=true;
				$this->response->invalid_message='Invalid number';
					$this->response->message[] = array(
				    	'message' => 'Invalid Coordinates',
				    	'type' => 'warning'
					);
        		$this->_ajax_return();
		}

		$this->load->model('partners_model', 'partners_mod');
		$partner_id = $this->partners_mod->get_partner_id($this->user->user_id);
		$partners_personal = $this->partners_mod->get_partners_personal($this->user->user_id, 'partners_personal', 'map_location', 1);

        //SAVING START   
		$transactions = true;
		$this->partner_id = 0;
		if( $transactions )
		{
			$this->db->trans_begin();
		}
		
		$main_record = array();
		switch( true )
		{
			case count($partners_personal) == 0:
				$data_personal = $this->partners_mod->insert_partners_personal($this->user->user_id, 'map_location', $lat_lng, 1, $partner_id);
				$this->db->insert('partners_personal', $data_personal);
				$this->response->action = 'insert';
				break;
			case count($partners_personal) > 0:
				$partners_personal = $partners_personal[0];
				$main_record['modified_by'] = $this->user->user_id;
				$main_record['modified_on'] = date('Y-m-d H:i:s');
				$main_record['key_value'] = $lat_lng;
				$this->db->update( 'partners_personal', $main_record, array( 'personal_id' => $partners_personal['personal_id'] ) );
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
		}else{			
			$partners_key = $this->db->get_where('partners_key', array('deleted' => 0, 'key_code' => 'map_location'))->row_array();
			$data_personal_request = array();
			$data_personal_request['partner_id'] = $partner_id;
			$data_personal_request['key_id'] = $partners_key['key_id'];
			$data_personal_request['key'] = 'map_location';
			$data_personal_request['sequence'] = 1;
			$data_personal_request['key_value'] = $lat_lng;
			$data_personal_request['status'] = 3;
			$data_personal_request['created_by'] = $this->user->user_id;
			$this->db->insert('partners_personal_request', $data_personal_request);
			
			if( $this->db->_error_message() != "" ){
				$this->response->message[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
				$error = true;
				goto stop;
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
				'message' => 'Plotted coordinates was successfully saved and/or updated.',
				'type' => 'success'
			);
		}

        $this->_ajax_return();
		
	}
}