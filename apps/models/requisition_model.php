<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class requisition_model extends Record
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
		$this->mod_id = 191;
		$this->mod_code = 'requisition';
		$this->route = 'account/requisition';
		$this->url = site_url('account/requisition');
		$this->primary_key = 'requisition_id';
		$this->table = 'requisition';
		$this->icon = 'fa-folder';
		$this->short_name = 'Requisition';
		$this->long_name  = 'Requisition';
		$this->description = '';
		$this->path = APPPATH . 'modules/requisition/';

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
		$qry .= " AND {$this->db->dbprefix}{$this->table}.created_by = {$this->user->user_id}";
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

	function get_mc_signatories( $record_id )
	{
		$qry = "select b.*, a.*
    	FROM {$this->db->dbprefix}requisition_mc_signatories a
    	LEFT JOIN {$this->db->dbprefix}requisition_remarks b on (b.requisition_id = a.requisition_id AND b.user_id = a.user_id)
    	WHERE a.requisition_id = {$record_id}";
    	$mc_signatories = $this->db->query( $qry );
    	if( $mc_signatories->num_rows() > 0 )
    		return $mc_signatories->result();
    	else
    		return false;
	}
}