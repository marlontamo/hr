<?php //delete me
	function _get_group_lists( $group )
	{
		$lists = array();
		$items = array();
		switch( $group )
		{
			case 'company':
				$lists = $this->_get_companies();
				break;
			case 'division':
				$lists = $this->_get_divisions();
				break;
			case 'department':
				$lists = $this->_get_departments();
				break;
			case 'position':
				$lists = $this->_get_positions();
				break;
			case 'employee_type':
				$lists = $this->_get_employee_types();
				break;
			case 'location':
				$lists = $this->_get_locations();
				break;
		}

		foreach( $lists as $item )
		{
			$items[] = '<a href="javascript:toggle_item( '.$item['id'].' )" class="list-group-item small ">
			<span class="pull-left margin-right-10"><input type="checkbox" class="checkboxes" name="group_id[]" value="'.$item['id'].'" /></span>
			<span class="text-info">'.$item['label'].'</span></a>';
		}

		return implode('', $items);
	}

	private function _get_companies()
	{
		$lists = array();
		$this->db->order_by('company', 'asc');
		$companies = $this->db->get_where('users_company', array('deleted' => '0'));
		foreach( $companies->result() as $row )
		{
			$lists[] = array(
				'id' => $row->company_id,
				'label' => $row->company
			);
		}
		return $lists;
	}

	private function _get_divisions()
	{
		$lists = array();
		$this->db->order_by('division', 'asc');
		$companies = $this->db->get_where('users_division', array('deleted' => '0'));
		foreach( $companies->result() as $row )
		{
			$lists[] = array(
				'id' => $row->division_id,
				'label' => $row->division
			);
		}
		return $lists;
	}

	private function _get_departments()
	{
		$lists = array();
		$this->db->order_by('department', 'asc');
		$companies = $this->db->get_where('users_department', array('deleted' => '0'));
		foreach( $companies->result() as $row )
		{
			$lists[] = array(
				'id' => $row->department_id,
				'label' => $row->department
			);
		}
		return $lists;
	}

	private function _get_positions()
	{
		$lists = array();
		$this->db->order_by('position', 'asc');
		$companies = $this->db->get_where('users_position', array('deleted' => '0'));
		foreach( $companies->result() as $row )
		{
			$lists[] = array(
				'id' => $row->position_id,
				'label' => $row->position
			);
		}
		return $lists;
	}

	private function _get_locations()
	{
		$lists = array();
		$this->db->order_by('location', 'asc');
		$companies = $this->db->get_where('users_location', array('deleted' => '0'));
		foreach( $companies->result() as $row )
		{
			$lists[] = array(
				'id' => $row->location_id,
				'label' => $row->location
			);
		}
		return $lists;
	}
}