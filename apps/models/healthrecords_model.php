<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class healthrecords_model extends Record
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
		$this->mod_id = 131;
		$this->mod_code = 'healthrecords';
		$this->route = 'partners/health_records';
		$this->url = site_url('partners/health_records');
		$this->primary_key = 'health_id';
		$this->table = 'partners_health_records';
		$this->icon = 'fa-folder';
		$this->short_name = 'Health Records';
		$this->long_name  = 'Health Records';
		$this->description = '';
		$this->path = APPPATH . 'modules/healthrecords/';

		parent::__construct();
	}

	function _get_list($start, $limit, $search, $filter, $trash = false, $permissions = array())
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

		if( !(isset( $permissions['edit'] ) && $permissions['edit']) )
		{
			$partner_info = $this->db->get_where( 'partners', array( 'user_id' => $this->user->user_id) )->row();
			$qry .= " AND {$this->db->dbprefix}{$this->table}.partner_id = {$partner_info->partner_id}";
		}
		
		$qry .= ' '. $filter;
		// $qry .= " GROUP BY {$this->db->dbprefix}{$this->table}.{$this->primary_key} ";
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