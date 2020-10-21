<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class clearance_manage_model extends Record
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
		$this->mod_id = 164;
		$this->mod_code = 'clearance_manage';
		$this->route = 'partner/clearance_manage';
		$this->url = site_url('partner/clearance_manage');
		$this->primary_key = 'clearance_id';
		$this->table = 'partners_clearance';
		$this->icon = '';
		$this->short_name = 'Clearance';
		$this->long_name  = 'Clearance Manage';
		$this->description = '';
		$this->path = APPPATH . 'modules/clearance_manage/';

		parent::__construct();
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
		$qry .= " ORDER BY {$this->db->dbprefix}{$this->table}.effectivity_date DESC";
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search, 'user_id' => $this->user->user_id), TRUE);

		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	function get_pending_status($clearance_id)
	{
		$clearance = $this->db->get_where('partners_clearance_signatories', array('clearance_id' => $clearance_id, 'status_id <>' => 4 ));
		$pending = 0;
		if($clearance && $clearance->num_rows() > 0){
			$pending = $clearance->num_rows();
		}
		return $pending;
	}

}