<?php //delete me
	function _get_applied_to_options( $record_id, $mark_selected = false, $apply_to = "" )
	{
		if( $mark_selected )
		{
			$selected = array();
			$applied_to = $this->db->get_where('payroll_period_apply_to', array('payroll_period_id' => $record_id));
			foreach( $applied_to->result() as $row )
			{
				$selected[] = $row->apply_to;
			}
		}
		
		if( !empty($record_id) )
		{
			$result = $this->_get( 'edit', $record_id );
			$record = $result->row_array();
			$apply_to = $record['payroll_period.apply_to_id'];
		}

		$options = array();
		switch( $apply_to )
		{
			case 1: //employee
				$qry = "SELECT full_name as label, user_id as value
				FROM {$this->db->dbprefix}users
				WHERE deleted = 0
				ORDER BY full_name asc";
				break;
			case 2: //company
				$qry = "SELECT company as label, company_id as value
				FROM {$this->db->dbprefix}users_company
				WHERE deleted = 0
				ORDER BY company asc";
				break;
			case 3: //division
				$qry = "SELECT division as label, division_id as value
				FROM {$this->db->dbprefix}users_division
				WHERE deleted = 0
				ORDER BY division asc";
				break;
			case 4: //department
				$qry = "SELECT department as label, department_id as value
				FROM {$this->db->dbprefix}users_department
				WHERE deleted = 0
				ORDER BY department asc";
				break;
		}

		$lists = $this->db->query( $qry );
		foreach( $lists->result() as $row )
		{
			if( $mark_selected && in_array($row->value, $selected) )
			{
				$options[] = '<option value="'. $row->value .'" selected>'.$row->label.'</option>';
			}
			else{
				$options[] = '<option value="'. $row->value .'">'.$row->label.'</option>';
			}	
		}
		return implode('', $options);
	}