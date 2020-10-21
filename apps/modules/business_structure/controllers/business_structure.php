<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Business_structure extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('business_structure_model', 'mod');
		parent::__construct();
	}

	public function index()
	{
		if( !$this->permission['edit'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}
		
		$vars['regions'] = array();
		$regions = $this->db->get_where('business_region', array('deleted' => 0));
		if( $regions->num_rows() ) $vars['regions'] = $regions->result();
		$this->load->vars( $vars );

		echo $this->load->blade('pages.setup')->with( $this->load->get_cached_vars() );
	}

	function get_regions()
	{
		$this->_ajax_only();
		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => 'Insuficient permission!',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		
		$vars['regions'] = array();
		$regions = $this->db->get_where('business_region', array('deleted' => 0));
		if( $regions->num_rows() ) $vars['regions'] = $regions->result();

		$this->response->regions = $this->load->view('filter/region-list', $vars, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		
		$this->_ajax_return();
	}

	function edit_region()
	{
		$this->_ajax_only();
		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => 'Insuficient permission!',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		
		$this->load->helper('form');
		$this->load->helper('file');

		$vars['region_id'] = $region_id = $this->input->post('region_id');
		if( empty( $region_id ) )
		{
			$data['title'] = 'Add Region';
			$vars['region'] = '';
			$vars['region_code'] = '';
			$vars['description'] = '';
		}
		else{
			$vars = $this->db->get_where('business_region', array('deleted' => 0, 'region_id' => $region_id), 1)->row_array();
			$data['title'] = 'Edit Region';
		}
		$data['content'] = $this->load->view('form/region', $vars, true);

		$this->response->region_form = $this->load->view('templates/modal', $data, true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		
		$this->_ajax_return();
	}

	function save_region()
	{
		$this->_ajax_only();
		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => 'Insuficient permission!',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		
		$this->response->error = false;

		$region = $this->input->post('region');

		if( empty( $region['region'] ) )
		{
			$this->response->message[] = array(
				'message' => 'Please enter Region Name.',
				'type' => 'warning'
			);
			$this->response->error = true;
		}

		if( empty( $region['region_code'] ) )
		{
			$this->response->message[] = array(
				'message' => 'Please enter Region Code.',
				'type' => 'warning'
			);
			$this->response->error = true;
		}

		if( !$this->response->error )
		{
			$previous_main_data = array();
			if( empty( $region['region_id'] ) ){
				$this->db->insert('business_region', $region);
				$action = 'insert';
			}
			else{
			//get previous data for audit logs
				$previous_main_data = $this->db->get_where('business_region', array('region_id' => $region['region_id']))->row_array();
				$this->db->update('business_region', $region, array('region_id' => $region['region_id']));	
				$action = 'update';
			}

			if( $this->db->_error_message() != "" )
			{
				$this->response->message[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
				
				$this->_ajax_return();	
			}
			//create system logs
			$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, $action, 'business_region', $previous_main_data, $region);
		}
		else{
			$this->_ajax_return();
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		
		$this->_ajax_return();
	}

	function get_groups()
	{
		$this->_ajax_only();
		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => 'Insuficient permission!',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		
		$vars['groups'] = array();
		$region_id = $this->input->post('region_id');
		$groups = $this->db->get_where('business_group', array('deleted' => 0, 'region_id' =>$region_id));
		if( $groups->num_rows() ) $vars['groups'] = $groups->result();

		$this->response->groups = $this->load->view('filter/group-list', $vars, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		
		$this->_ajax_return();
	}

	function edit_group()
	{
		$this->_ajax_only();
		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => 'Insuficient permission!',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		
		$this->load->helper('form');
		$this->load->helper('file');

		$vars['group_id'] = $group_id = $this->input->post('group_id');
		$vars['region_id'] = $region_id = $this->input->post('region_id');
		if( empty( $group_id ) )
		{
			$data['title'] = 'Add Group';
			$vars['group'] = '';
			$vars['group_code'] = '';
			$vars['description'] = '';
		}
		else{
			$vars = $this->db->get_where('business_group', array('deleted' => 0, 'group_id' => $group_id), 1)->row_array();
			$data['title'] = 'Edit Group';
		}
		$data['content'] = $this->load->view('form/group', $vars, true);

		$this->response->group_form = $this->load->view('templates/modal', $data, true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		
		$this->_ajax_return();
	}

	function save_group()
	{
		$this->_ajax_only();
		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => 'Insuficient permission!',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		
		$this->response->error = false;

		$group = $this->input->post('group');

		if( empty( $group['group'] ) )
		{
			$this->response->message[] = array(
				'message' => 'Please enter Group Name.',
				'type' => 'warning'
			);
			$this->response->error = true;
		}

		if( empty( $group['group_code'] ) )
		{
			$this->response->message[] = array(
				'message' => 'Please enter Group Code.',
				'type' => 'warning'
			);
			$this->response->error = true;
		}

		if( !$this->response->error )
		{
			$previous_main_data = array();
			if( empty( $group['group_id'] ) ){
				$this->db->insert('business_group', $group);
				$action = 'insert';
			}
			else{
			//get previous data for audit logs
				$previous_main_data = $this->db->get_where('business_group', array('group_id' => $group['group_id']))->row_array();
				$this->db->update('business_group', $group, array('group_id' => $group['group_id']));
				$action = 'update';	
			}

			if( $this->db->_error_message() != "" )
			{
				$this->response->error = true;
				$this->response->message[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
				
				$this->_ajax_return();	
			}
			//create system logs
			$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, $action, 'business_group', $previous_main_data, $group);
		}
		else{
			$this->_ajax_return();
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		
		$this->_ajax_return();
	}

	function delete_region()
	{
		$this->_ajax_only();
		if( !$this->permission['delete'] )
		{
			$this->response->message[] = array(
				'message' => 'Insuficient permission!',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		
		$region_id = $this->input->post('region_id');
		$this->db->update('business_region', array('deleted' => 1), array('region_id' => $region_id));
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'delete', 'business_region - region_id', array(), array('region_id' => $region_id));
		
		$this->_ajax_return();
	}

	function delete_group()
	{
		$this->_ajax_only();
		if( !$this->permission['delete'] )
		{
			$this->response->message[] = array(
				'message' => 'Insuficient permission!',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		
		$group_id = $this->input->post('group_id');
		$this->db->update('business_group', array('deleted' => 1), array('group_id' => $group_id));
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'delete', 'business_group - group_id', array(), array('group_id' => $group_id));
		
		$this->_ajax_return();
	}

	function get_companies()
	{
		$this->_ajax_only();
		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => 'Insuficient permission!',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		
		$vars['companies'] = array();
		$group_id = $this->input->post('group_id');
		$companies = $this->db->get_where('users_company', array('deleted' => 0, 'business_group_id' => $group_id));
		if( $companies->num_rows() ) $vars['companies'] = $companies->result();

		$this->response->companies = $this->load->view('filter/company-list', $vars, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		
		$this->_ajax_return();
	}

	function edit_company()
	{
		$this->_ajax_only();
		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => 'Insuficient permission!',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		
		$this->load->helper('form');
		$this->load->helper('file');

		$vars['company_id'] = $company_id = $this->input->post('company_id');
		$vars['group_id'] = $group_id = $this->input->post('group_id');
		if( empty( $company_id ) )
		{
			$data['title'] = 'Add Company';
			$vars['company'] = '';
			$vars['company_code'] = '';
		}
		else{
			$vars = $this->db->get_where('users_company', array('deleted' => 0, 'company_id' => $company_id), 1)->row_array();
			$data['title'] = 'Edit Company';
		}
		$vars['group_id'] = $group_id = $this->input->post('group_id');
		$groups = $this->db->get_where('business_group', array('deleted' => 0));
		foreach($groups->result() as $group)
			$vars['group_options'][$group->group_id] = $group->group;

		$data['content'] = $this->load->view('form/company', $vars, true);

		$this->response->company_form = $this->load->view('templates/modal', $data, true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		
		$this->_ajax_return();
	}

	function save_company()
	{
		$this->_ajax_only();
		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => 'Insuficient permission!',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		
		$this->response->error = false;

		$company = $this->input->post('company');

		if( empty( $company['company'] ) )
		{
			$this->response->message[] = array(
				'message' => 'Please enter Company Name.',
				'type' => 'warning'
			);
			$this->response->error = true;
		}

		if( empty( $company['company_code'] ) )
		{
			$this->response->message[] = array(
				'message' => 'Please enter Company Code.',
				'type' => 'warning'
			);
			$this->response->error = true;
		}

		if( !$this->response->error )
		{
			$previous_main_data = array();
			if( empty( $company['company_id'] ) ){
				$this->db->insert('users_company', $company);
				$action = 'insert';
			}
			else{
			//get previous data for audit logs
				$previous_main_data = $this->db->get_where('users_company', array('company_id' => $company['company_id']))->row_array();
				$this->db->update('users_company', $company, array('company_id' => $company['company_id']));
				$action = 'update';
			}

			if( $this->db->_error_message() != "" )
			{
				$this->response->error = true;
				$this->response->message[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
				
				$this->_ajax_return();	
			}
			//create system logs
			$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, $action, 'users_company', $previous_main_data, $company);
		}
		else{
			$this->_ajax_return();
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		
		$this->_ajax_return();
	}
}