<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class partner_loan_model extends Record
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
		$this->mod_id = 84;
		$this->mod_code = 'partner_loan';
		$this->route = 'payroll/partner_loans';
		$this->url = site_url('payroll/partner_loans');
		$this->primary_key = 'partner_loan_id';
		$this->table = 'payroll_partners_loan';
		$this->icon = 'fa-folder';
		$this->short_name = 'Employee Loans';
		$this->long_name  = 'Employee Loans';
		$this->description = '';
		$this->path = APPPATH . 'modules/partner_loan/';

		parent::__construct();
	}

	function _get_list($start, $limit, $search, $filter, $trash = false)
	{
		$data = array();				
		
		$qry = $this->_get_list_cached_query();

		// GET SENSITIVITY
		// BEGIN //
		$sensID = $this->config->config['user']['sensitivity'];
		if($sensID && !empty($sensID) ){
			$qry .= " AND T20.sensitivity IN ( ".$sensID." )";
		}
		// END //
		if( $trash )
		{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 1";
		}
		else{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 0";	
		}

		$qry .= ' '. $filter;
		$qry .= " ORDER BY full_name ";
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