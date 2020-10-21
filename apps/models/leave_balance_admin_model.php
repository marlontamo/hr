<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class leave_balance_admin_model extends Record
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
		$this->mod_id = 85;
		$this->mod_code = 'leave_balance_admin';
		$this->route = 'time/admin/leave_balance';
		$this->url = site_url('time/admin/leave_balance');
		$this->primary_key = 'id';
		$this->table = 'time_form_balance';
		$this->icon = 'fa-calendar';
		$this->short_name = 'Leave Balance Admin';
		$this->long_name  = 'Manage Leave Balance';
		$this->description = '';
		$this->path = APPPATH . 'modules/leave_balance_admin/';

		parent::__construct();
	}

	function getYear(){ 
		
		$data = array();

		$qry = "SELECT DISTINCT(`year`)
				FROM {$this->db->dbprefix}{$this->table} "; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row['year'];
			}			
		}
			
		$result->free_result();
		return $data;	
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
		
		$qry .= " AND {$this->db->dbprefix}{$this->table}.form_code <> 'ADDL' "; // exclude ADDL

        // for role caegory filtering
        $qry_category = $this->mod->get_role_category();

        if ($qry_category != ''){
            $qry .= ' AND ' . $qry_category;
        }

		$qry .= ' '. $filter;
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