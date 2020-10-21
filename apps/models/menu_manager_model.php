<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class menu_manager_model extends Record
{
	var $mod_id;
	var $mod_code;
	var $route;
	var $url;
	var $primary_key;
	var $table;
	var $icon;
	var $short_name;
	var $long_name;
	var $description;
	var $path;

	public function __construct()
	{
		$this->mod_id = 7;
		$this->mod_code = 'menu_manager';
		$this->route = 'admin/menu_manager';
		$this->url = site_url('admin/menu_manager');
		$this->primary_key = 'menu_item_id';
		$this->table = 'menu';
		$this->icon = '';
		$this->short_name = 'Menu Manager';
		$this->long_name  = 'Menu Manager';
		$this->description = '';
		$this->path = APPPATH . 'modules/menu_manager/';

		parent::__construct();
	}

	public function _get_role_menu( $role_id )
	{
		return $this->_get_menu( 0, $role_id );
	}

	public function _get_menu( $parent_id, $role_id = 0 )
	{
		$menu = array();

		$this->db->order_by('sequence asc');
		$_menus = $this->db->get_where( $this->table, array('deleted' => 0, 'parent_menu_item_id' => $parent_id) );

		foreach( $_menus->result() as $_menu )
		{
			if(!empty( $role_id ))
			{
				$_menu->checked = false;
				$check = $this->db->get_where('roles_menu', array('role_id' => $role_id, 'menu_item_id' => $_menu->menu_item_id));
				if($check->num_rows() == 1)
				{
					$_menu->checked = true;
				}
			}

			$menu[] = array(
				'menu' => $_menu,
				'children' => $this->_get_menu( $_menu->menu_item_id, $role_id )
			);		
		}

		return $menu;
	}

	function _update_menu( $menu, $parant_id, $sequence )
	{
		$this->db->update($this->table, array('parent_menu_item_id'=> $parant_id, 'sequence' => $sequence), array( $this->primary_key => $menu->id) );
		if( isset( $menu->children ) )
		{
			$ctr = 1;
			foreach( $menu->children as $child )
			{
				$this->_update_menu( $child, $menu->id, $ctr );
				$ctr++;
			}
		}
	}
}