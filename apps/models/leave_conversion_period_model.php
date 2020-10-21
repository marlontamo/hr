<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class leave_conversion_period_model extends Record
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
		$this->mod_id = 228;
		$this->mod_code = 'leave_conversion_period';
		$this->route = 'payroll/leave_conversion_period';
		$this->url = site_url('payroll/leave_conversion_period');
		$this->primary_key = 'leave_conversion_period_id';
		$this->table = 'payroll_leave_conversion_period';
		$this->icon = 'fa-folder';
		$this->short_name = 'Leave Conversion Period';
		$this->long_name  = 'Leave Conversion Period';
		$this->description = '';
		$this->path = APPPATH . 'modules/leave_conversion_period/';

		parent::__construct();
	}

	function _get_applied_to_options( $record_id, $mark_selected = false, $apply_to = "" )
	{
		if( $mark_selected )
		{
			$selected = array();
			$applied_to = $this->db->get_where('payroll_leave_conversion_period_apply_to', array('leave_conversion_id' => $record_id));
			foreach( $applied_to->result() as $row )
			{
				$selected[] = $row->apply_to;
			}
		}
		
		if( !empty($record_id) )
		{
			$result = $this->_get( 'edit', $record_id );
			$record = $result->row_array();
			$apply_to = $record['payroll_leave_conversion_period.apply_to_id'];
		}

		// GET SENSITIVITY
		// BEGIN //
		$sense = '';
		$sensID = $this->config->config['user']['sensitivity'];
		if($sensID && !empty($sensID) ){
			$sense = " AND p.sensitivity IN ( ".$sensID." )";
		}
		// END //

		$options = array();
		switch( $apply_to )
		{
			case 1: //employee
				$qry_category = $this->get_role_category('up');	

				$qry = "SELECT u.full_name as label, u.user_id as value
				FROM {$this->db->dbprefix}users u
				INNER JOIN {$this->db->dbprefix}payroll_partners p on p.user_id = u.user_id
				INNER JOIN {$this->db->dbprefix}users_profile up ON p.user_id = up.user_id
				WHERE u.deleted = 0 $sense";

		        if ($qry_category != ''){
		            $qry .= ' AND ' . $qry_category;
		        }

		        $qry .= " ORDER BY u.full_name ASC";
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
			case 5: //division
				$qry = "SELECT branch as label, branch_id as value
				FROM {$this->db->dbprefix}users_branch
				WHERE deleted = 0
				ORDER BY branch asc";
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

	function _get_list($start, $limit, $search, $filter, $trash = false)
	{
		$data = array();				
		
		$qry = $this->_get_list_cached_query();
		
		if( $trash )
		{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 1";
		}
		else{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 0";	
		}

		$qry .= ' '. $filter;
        $qry .= " ORDER BY {$this->db->dbprefix}{$this->table}.payroll_date DESC ";
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}
}