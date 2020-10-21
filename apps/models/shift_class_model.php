<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class shift_class_model extends Record
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
		$this->mod_id = 83;
		$this->mod_code = 'shift_class';
		$this->route = 'admin/time/shift_class';
		$this->url = site_url('admin/time/shift_class');
		$this->primary_key = 'id';
		$this->table = 'time_shift_class_company';
		$this->icon = 'fa-clock-o';
		$this->short_name = 'Shift Class';
		$this->long_name  = 'Time Shift Class';
		$this->description = 'Manage and list shifts and class policy';
		$this->path = APPPATH . 'modules/shift_class/';

		parent::__construct();
	}

	function _get_list($start, $limit, $search, $trash = false,$shiftClasses, $shifts)
	{
		$data = array();

		$qry = $this->_get_list_cached_query();
		if(count($shiftClasses) > 0 && count($shifts) > 0){
			$qry .= " WHERE tscc.class_id IN ( ".implode(',', $shiftClasses)." ) AND tscc.shift_id 
						IN ( ".implode(',', $shifts)." )";
		    if( $search ){
		    	$qry .= " AND ( company LIKE '%".$search."%' OR shift LIKE '%".$search."%' OR class_code LIKE '%".$search."%' OR class_value LIKE '%".$search."%' )";
		    }

		    $qry .= " ORDER BY tsc.class_code ASC ";
			// $qry .= " LIMIT $limit OFFSET $start";
		}else{
			$qry .= " WHERE 1 = 0";
		}

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	function _get_list_cached_query()
	{
		// parent::_get_list_cached_query();
		return "SELECT tscc.id AS record_id, uc.company, ts.shift, tsc.class_code, tscc.class_value
				FROM {$this->db->dbprefix}time_shift_class_company tscc
				JOIN {$this->db->dbprefix}time_shift_class tsc ON tscc.class_id = tsc.class_id
				JOIN {$this->db->dbprefix}time_shift ts ON tscc.shift_id = ts.shift_id
				JOIN {$this->db->dbprefix}users_company uc ON tscc.company_id = uc.company_id";
	}

	function get_shift_class_details($record_id)
	{
		$qry_shift_class = "SELECT tscc.id AS record_id, uc.company, ts.shift, tsc.class_code, tscc.class_value,
				tscc.employment_status_id, tscc.employment_type_id, tscc.partners_id
				FROM {$this->db->dbprefix}time_shift_class_company tscc
				JOIN {$this->db->dbprefix}time_shift_class tsc ON tscc.class_id = tsc.class_id
				JOIN {$this->db->dbprefix}time_shift ts ON tscc.shift_id = ts.shift_id
				JOIN {$this->db->dbprefix}users_company uc ON tscc.company_id = uc.company_id
				WHERE tscc.id = {$record_id}";
		$result = $this->db->query( $qry_shift_class );

		$data = array();
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data = $row;
			}
		}
		return $data;
	}
	
}