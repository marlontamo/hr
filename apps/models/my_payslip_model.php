<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class my_payslip_model extends Record
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
		$this->mod_id = 170;
		$this->mod_code = 'my_payslip';
		$this->route = 'account/payslip';
		$this->url = site_url('account/payslip');
		$this->primary_key = 'id';
		$this->table = 'payroll_closed_transaction';
		$this->icon = '';
		$this->short_name = 'My Payslip';
		$this->long_name  = 'My Payslip';
		$this->description = '';
		$this->path = APPPATH . 'modules/my_payslip/';

		parent::__construct();
	}

	function _get_list($start, $limit, $search, $filter, $trash = false)
	{
		$data = array();				
		
		$qry = $this->_get_list_cached_query();
		
		// if( $trash )
		// {
		// 	$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 1";
		// }
		// else{
		// 	$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 0";	
		// }
		
		$qry .= " AND user_id = {$this->user->user_id}";	
		$qry .= ' '. $filter;
		$qry .= " ORDER BY payroll_date DESC";
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