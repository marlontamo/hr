<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class Menu extends Record
{
	public function create_role_menu( $role_id = 0 )
	{
		$role_menu_path = APPPATH . 'views/menu/' . $this->session->userdata('current_db');
		if (!is_dir($role_menu_path)) {
            mkdir($role_menu_path, 0755, true);
            copy(APPPATH .'index.html', $role_menu_path.'/index.html');
        }
        $role_menu = $role_menu_path .'/'. $role_id .'.blade.php';
        $menu_array = array();
		$route = array();

		//get the top menu
		$qry = "SELECT *
		FROM {$this->db->dbprefix}menu a
		LEFT JOIN {$this->db->dbprefix}roles_menu b on b.menu_item_id = a.menu_item_id
		WHERE a.deleted = 0 AND (a.parent_menu_item_id IS NULL OR a.parent_menu_item_id = 0 ) AND b.role_id = {$role_id}
		ORDER BY a.sequence ASC";
		$menu = $this->db->query( $qry );

		foreach( $menu->result() as $top )
		{
			if( $top->menu_item_type_id == 1 )
				$this->_get_route( $route, $top );
			else
				$top->mod_code = 'menu-'.$top->menu_item_id;

			$top->uri = $this->_get_menu_url( $top );

			$top->submenu = $this->_get_submenu( $top->menu_item_id, $role_id, $route );
			$menu_array[] = $top;
		}
		$view = $this->load->blade('templates/menu', array( 'menu' => $menu_array), true);
		$this->load->helper('file');
		write_file($role_menu , $view);
	}

	private function _get_submenu( $parent_id, $role_id, &$route )
	{
		$menu_array = array();

		$qry = "SELECT *
		FROM {$this->db->dbprefix}menu a
		LEFT JOIN {$this->db->dbprefix}roles_menu b on b.menu_item_id = a.menu_item_id
		WHERE a.deleted = 0 AND a.parent_menu_item_id = {$parent_id} AND b.role_id = {$role_id}
		ORDER BY a.sequence ASC";
		$submenus = $this->db->query( $qry );
		
		foreach( $submenus->result() as $submenu )
		{
			if( $submenu->menu_item_type_id == 1 )
				$this->_get_route( $route, $submenu );
			else
				$submenu->mod_code = 'menu-'.$submenu->menu_item_id;

			$submenu->uri = $this->_get_menu_url( $submenu );
			
			$submenu->submenu = $this->_get_submenu( $submenu->menu_item_id, $role_id, $route );
			$menu_array[] = $submenu;
		}

		return sizeof( $menu_array ) > 0 ? $menu_array : false;
	}

	private function _get_route( &$route, &$menu )
	{
		$module = $this->db->get_where('modules', array('mod_id' => $menu->mod_id))->row();
		
		if( !empty( $menu->uri ) )
			$route_to = $menu->uri;
		else
			$route_to = $module->route;

		$route[$route_to] = $module->route;
		
		if( !empty($menu->method) )
			$route[$route_to] .= '/' . $menu->method;
	
		$menu->mod_code = $module->mod_code;
	} 

	private function _get_menu_url( $menu )
	{
		if( !empty( $menu->uri ) )
			return $menu->uri = '<?php echo site_url(\''.$menu->uri.'\');?>';
		
		switch( $menu->menu_item_type_id )
		{
			case 1:	//module
				$module = $this->db->get_where('modules', array('mod_id' => $menu->mod_id))->row();
				$url = '<?php echo site_url(\''.$module->route.'\');?>';
				if( !empty($menu->method) )
					$url .= '/' . $menu->method;
				break;
			case 2: //external
				$url = $menu->uri;
				break;
			case 3: //label
			default:
				$url = "javascript:;";
				break;
		}

		return $url;
	}

	function _delete_all_menu_files()
	{
		$path = APPPATH . 'views/menu/';
		$files = glob($path."*.php");
		foreach($files as $file)
		{
			unlink($file); 
		}
	}
}