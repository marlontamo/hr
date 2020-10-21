<?php //delete me
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
	