<?php //delete me	
	public function index()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}
		
		$this->load->helper('form');
		echo $this->load->blade('menu_manager')->with( $this->load->get_cached_vars() );
	}

	function get_menu()
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

		if( !$this->input->post('role_id') )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$menu = $this->mod->_get_role_menu( $this->input->post('role_id') );
		$this->response->menu = '';
		if( sizeof( $menu ) > 0 )
		{
			$this->response->menu = $this->load->view('menu_tree', array('menu' => $menu), true);
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function update_menu()
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

		$sequence = $this->input->post('sequence');
		$sequence = json_decode( $sequence );
		$ctr = 1;
		foreach( $sequence as $menu )
		{
			$this->mod->_update_menu( $menu, 0, $ctr );
			$this->response->q[] = $this->db->last_query();
			$ctr++;
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function save_role_menu()
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

		if( !$this->input->post('role_id') )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$role_id = $this->input->post('role_id');
		$menu_items = $this->input->post('menu_item_id');
	
		$this->db->delete('roles_menu', array('role_id' => $role_id));
		foreach( $menu_items as $menu_item_id )
		{
			$this->db->insert('roles_menu', array('menu_item_id' => $menu_item_id, 'role_id' => $role_id));
		}

		$role_menu = APPPATH . 'views/menu/'. $role_id .'.blade.php';
		if( file_exists( $role_menu ) )
			unlink( $role_menu );

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}
