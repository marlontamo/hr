<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class shift_model extends Record
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
		$this->mod_id = 37;
		$this->mod_code = 'shift';
		$this->route = 'admin/time/shift';
		$this->url = site_url('admin/time/shift');
		$this->primary_key = 'shift_id';
		$this->table = 'time_shift';
		$this->icon = '';
		$this->short_name = 'Shift';
		$this->long_name  = 'Shift';
		$this->description = 'shift manage.';
		$this->path = APPPATH . 'modules/shift/';

		parent::__construct();
	}

	function _get_shift_options( $record_id, $mark_selected = false, $select_option = true, $apply_to )
	{
		if( $mark_selected )
		{
			$selected = array();

			$shift = $this->db->get_where('time_shift_apply_to_id', array('shift_id' => $record_id, 'apply_to' => $apply_to));
			foreach( $shift->result() as $row )
			{
				$selected[] = $row->apply_to_id;
			}
		}
		
		$options = array();
		$codes = array();

		switch( $apply_to )
		{
			case 1: //employee
				$qry = "SELECT full_name as label, user_id as value, display_name as code
				FROM {$this->db->dbprefix}users
				WHERE deleted = 0
				ORDER BY full_name asc";
				break;
			case 2: //company
				$qry = "SELECT company as label, company_id as value, company_code as code
				FROM {$this->db->dbprefix}users_company
				WHERE deleted = 0
				ORDER BY company asc";
				break;
			case 3: //division
				$qry = "SELECT division as label, division_id as value, division_code as code
				FROM {$this->db->dbprefix}users_division
				WHERE deleted = 0
				ORDER BY division asc";
				break;
			case 4: //department
				$qry = "SELECT department as label, department_id as value, department as code
				FROM {$this->db->dbprefix}users_department
				WHERE deleted = 0
				ORDER BY department asc";
				break;
		}

		$lists = $this->db->query( $qry );
		$cnt = 0;
		foreach( $lists->result() as $row )
		{
			if( $mark_selected && in_array($row->value, $selected) )
			{
				$options[] = '<option value="'. $row->value .'" selected>'.$row->label.'</option>';
				$codes[$row->value] = $row->code;
				$cnt++;
			}
			else{
				$options[] = '<option value="'. $row->value .'">'.$row->label.'</option>';
			}	
		}

		if($mark_selected && $cnt == 0 && $apply_to == 4){
			$options[] = '<option value="All" selected>All</option>';
		}

		if(!$select_option){
			return $codes;
		}

		return implode('', $options);
	}


	function _get_shift_apply_to_value($record_id, $apply_to)
	{
		$values = array();
		$shift = $this->db->get_where('time_shift_apply_to_id', array('shift_id' => $record_id, 'apply_to' => $apply_to));
		foreach( $shift->result() as $row )
		{
			$values[] = $row->apply_to_id;
		}

		return $values;
	}


	function get_shift_class_company($company_id, $shift_id, $class_id)
	{
		$where = array('company_id' => $company_id, 'shift_id' => $shift_id, 'class_id' => $class_id); 
		$class = $this->db->get_where('time_shift_class_company', $where);

		return $class;

	}

	function get_shift_value($shift_id)
	{
		$this->db->where('shift_id', $shift_id);
		$shift_values = $this->db->get('time_shift_apply_to_value');

		if($shift_values && $shift_values->num_rows() > 0){
			$shift_value = json_decode($shift_values->row()->shift, true);
			$values = array();
			if(isset($shift_value['class_id'])){
				foreach ($shift_value['class_id'] as $key => $class_id) {
					$values[$class_id] = $shift_value['value'][$key];
				}
				$shift_value = $values;
			}
		}else{
			$shift_value = false;
		}
				
		return $shift_value;
	}

	function _save_shift_class_company($class_id, $shift_id, $class_value, $company_details = false)
	{
		$companies = $this->_get_shift_options( $shift_id, true, false, 2 );
		if($company_details !== false && is_array($company_details))
		{
			$companies = $company_details['company'];
		}
			foreach ($companies as $company_id => $company) {
				$shift_class_company_record = $this->get_shift_class_company($company_id, $shift_id, $class_id);
				if($shift_class_company_record && $shift_class_company_record->num_rows() > 0){
					$shift_class_company_record = $shift_class_company_record->row_array();
					$main_record = array('class_value' => $class_value);
					if($company_details !== false){
						$main_record = $company_details['main_record'];
					}
					
					$this->db->update('time_shift_class_company', $main_record, array( 'id' => $shift_class_company_record['id'] ) );
					$record_id = $shift_class_company_record['id'];
				}else{
					$main_record = array('shift_id' => $shift_id, 'class_id' => $class_id, 'company_id' => $company_id, 'class_value' => $class_value);
					if($company_details !== false){
						$main_record = $company_details['main_record'];
					}
					$this->db->insert('time_shift_class_company', $main_record);
					$record_id = $this->db->insert_id();
				}
			}
		
		return $record_id;
	}
}

