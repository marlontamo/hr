<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class leave_balance_model extends Record
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
		$this->mod_id = 86;
		$this->mod_code = 'leave_balance';
		$this->route = 'time/leave_balance';
		$this->url = site_url('time/leave_balance');
		$this->primary_key = 'id';
		$this->table = 'time_form_balance';
		$this->icon = 'fa-calendar';
		$this->short_name = 'Leave Balance';
		$this->long_name  = 'Leave Balance';
		$this->description = '';
		$this->path = APPPATH . 'modules/leave_balance/';

		parent::__construct();
	}


	function _get_list($start, $limit, $search, $filter, $trash = false)
	{
		$data = array();				
		
		$qry = $this->_get_list_cached_query();
		
		//filter by specific employee
		$qry .= " AND {$this->db->dbprefix}{$this->table}.user_id = {$this->user->user_id}";
		
		if( $trash )
		{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 1";
		}
		else{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 0";	
		}
		
		$qry .= " AND {$this->db->dbprefix}{$this->table}.form_code <> 'ADDL' "; // exclude ADDL

		$qry .= ' '. $filter;
		$qry .= " ORDER BY {$this->db->dbprefix}{$this->table}.year DESC ";
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