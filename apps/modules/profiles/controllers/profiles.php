<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profiles extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('profiles_model', 'mod');
		parent::__construct();
		$this->lang->load('permissions');
	}

	function edit()
	{
		parent::edit( '', true );
		
		$this->db->order_by('parent_group, sub_group, long_name');
		$modules = $this->db->get_where('modules', array('deleted' => 0));
		
		foreach ($modules->result() as $module) {
			$data['modules'][$module->mod_id] = $module;	
		}

		$actions = $this->db->get_where('modules_actions', array('deleted' => 0));
		foreach ($actions->result() as $action) {
			$data['actions'][$action->action_id] = $action;	
		}

		if( !empty( $this->record_id) )
		{
			foreach( $data['modules'] as $mod_id => $mod )
			{
				$s_set = $this->db->get_where('profiles_sensitivity', array('mod_id' => $mod_id, 'profile_id' => $this->record_id));
				foreach( $s_set->result() as $_sensitivity )
				{
					$data['sensitivity'][$mod_id][$_sensitivity->sensitivity_id] = 1;
				}

				$p_set = $this->db->get_where('profiles_permission', array('mod_id' => $mod_id, 'profile_id' => $this->record_id));
				foreach( $p_set->result() as $_permission )
				{
					$data['permission'][$mod_id][$_permission->action_id] = $_permission->grant;
				}	
			}
		}

		$this->load->vars( $data );

		$this->load->helper('form');
		$this->load->helper('file');
		echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
	}

	function detail()
	{
		parent::detail( '', true );
		
		$this->db->order_by('parent_group, sub_group, long_name');
		$modules = $this->db->get_where('modules', array('deleted' => 0));
		
		foreach ($modules->result() as $module) {
			$data['modules'][$module->mod_id] = $module;	
		}

		$actions = $this->db->get_where('modules_actions', array('deleted' => 0));
		foreach ($actions->result() as $action) {
			$data['actions'][$action->action_id] = $action;	
		}

		if( !empty( $this->record_id) )
		{
			foreach( $data['modules'] as $mod_id => $mod )
			{
				$s_set = $this->db->get_where('profiles_sensitivity', array('mod_id' => $mod_id, 'profile_id' => $this->record_id));
				foreach( $s_set->result() as $_sensitivity )
				{
					$data['sensitivity'][$mod_id][$_sensitivity->sensitivity_id] = 1;
				}

				$p_set = $this->db->get_where('profiles_permission', array('mod_id' => $mod_id, 'profile_id' => $this->record_id));
				foreach( $p_set->result() as $_permission )
				{
					$data['permissions'][$mod_id][$_permission->action_id] = $_permission->grant;
				}	
			}
		}

		$this->load->vars( $data );

		$this->load->helper('form');
		$this->load->helper('file');
		echo $this->load->blade('pages.detail')->with( $this->load->get_cached_vars() );
	}

	function add()
	{
		parent::add( '', true );

		$this->db->order_by('parent_group, sub_group, long_name');
		$modules = $this->db->get_where('modules', array('deleted' => 0));
		
		foreach ($modules->result() as $module) {
			$data['modules'][$module->mod_id] = $module;	
		}

		$actions = $this->db->get_where('modules_actions', array('deleted' => 0));
		foreach ($actions->result() as $action) {
			$data['actions'][$action->action_id] = $action;	
		}

		if( !empty( $this->record_id) )
		{
			foreach( $data['modules'] as $mod_id => $mod )
			{
				$s_set = $this->db->get_where('profiles_sensitivity', array('mod_id' => $mod_id, 'profile_id' => $this->record_id));
				foreach( $s_set->result() as $_sensitivity )
				{
					$data['sensitivity'][$mod_id][$_sensitivity->sensitivity_id] = 1;
				}

				$p_set = $this->db->get_where('profiles_permission', array('mod_id' => $mod_id, 'profile_id' => $this->record_id));
				foreach( $p_set->result() as $_permission )
				{
					$data['permissions'][$mod_id][$_permission->action_id] = $_permission->grant;
				}	
			}
		}

		$this->load->vars( $data );

		$this->load->helper('form');
		$this->load->helper('file');
		echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
	}

	function save()
	{
		parent::save( true );
		if( $this->response->saved )
        {
        	//save data sensitivity and permission

        	$this->db->delete('profiles_sensitivity', array( $this->mod->primary_key => $this->record_id ));
        	if( $this->input->post('sensitivity') )
        	{
        		$sensitivity = $this->input->post('sensitivity');
        		// debug($sensitivity);
        		foreach( $sensitivity as $mod_id => $_sensitivity )
        		{
        			foreach( $_sensitivity as $sensitivity_id => $value ){
        				$this->db->insert('profiles_sensitivity', array( $this->mod->primary_key => $this->record_id, 'mod_id' => $mod_id, 'sensitivity_id' => $sensitivity_id ));
        				
        				//create system logs
						$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'edit', 'profiles_sensitivity', array(), array( $this->mod->primary_key => $this->record_id, 'mod_id' => $mod_id, 'sensitivity_id' => $sensitivity_id, 'value' => $value ) );
        			}
        		}


        	}

        	$this->db->delete('profiles_permission', array( $this->mod->primary_key => $this->record_id ));
        	if( $this->input->post('permissions') )
        	{
        		$permission = $this->input->post('permissions');
        		foreach( $permission as $mod_id => $_permission )
        		{
        			foreach( $_permission as $action_id => $grant ){
        				$this->db->insert('profiles_permission', array( $this->mod->primary_key => $this->record_id, 'mod_id' => $mod_id, 'action_id' => $action_id, 'grant' => 1 ));

        				//create system logs
						$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'edit', 'profiles_permission', array(), array( $this->mod->primary_key => $this->record_id, 'mod_id' => $mod_id, 'action_id' => $action_id, 'grant' => $grant ));
        			}
        		}

        		
        	}

        	$this->mod->_create_permission_file( $this->record_id );

        	$this->response->message[] = array(
                'message' => lang('common.save_success'),
                'type' => 'success'
            );
        }

        $this->_ajax_return();
	}
}