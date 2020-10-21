<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class sbr_model extends Record
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
		$this->mod_id = 238;
		$this->mod_code = 'sbr';
		$this->route = 'payroll/sbr';
		$this->url = site_url('payroll/sbr');
		$this->primary_key = 'payroll_period_id';
		$this->table = 'payroll_period';
		$this->icon = '';
		$this->short_name = 'Assign SBR';
		$this->long_name  = 'Assign SBR';
		$this->description = '';
		$this->path = APPPATH . 'modules/sbr/';

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
			$qry .= " WHERE {$this->db->dbprefix}{$this->table}.deleted = 0";	
		}
		
		$qry .= ' '. $filter;
		$qry .= " GROUP BY YEAR({$this->db->dbprefix}{$this->table}.payroll_date), MONTH({$this->db->dbprefix}{$this->table}.payroll_date)";
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