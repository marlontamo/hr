<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class report_result_model extends Record
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
		$this->mod_id = 91;
		$this->mod_code = 'report_result';
		$this->route = 'report/results';
		$this->url = site_url('report/results');
		$this->primary_key = 'result_id';
		$this->table = 'report_results';
		$this->icon = 'fa-folder';
		$this->short_name = 'Report Results';
		$this->long_name  = 'Report Results';
		$this->description = '';
		$this->path = APPPATH . 'modules/report_result/';

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


		//checking of roles
		$role = $this->config->item('user');
		$roleid = $role['role_id'];		
		$roles = array(1,2,6);

		if( !in_array($roleid, $roles) )
			$qry .= ' AND `ww_report_results`.`created_by` = '.$this->user->user_id;	


		$qry .= ' ORDER BY `ww_report_results`.`created_on` DESC';
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