<?php //delete me
	public function save()
	{
		parent::save( true );
		
		if( $this->response->saved )
		{
			//update profile distribution
			$this->db->delete('roles_profile', array('role_id' => $this->record_id));
			$profile_ids = $_POST['roles']['profile_id'];
			foreach( $profile_ids as $profile_id )
			{
				$this->db->insert('roles_profile', array('role_id' => $this->record_id, 'profile_id' => $profile_id));
			}

			$this->mod->_create_permission_file( $this->record_id );

			$this->load->model('menu');
			$role_menu = APPPATH . 'views/menu/'. $this->record_id .'.blade.php';
			$this->menu->create_role_menu( $this->record_id, $role_menu );	
		
			$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
		}

		$this->_ajax_return();
	}
	