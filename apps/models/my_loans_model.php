<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class my_loans_model extends Record
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
		$this->mod_id = 173;
		$this->mod_code = 'my_loans';
		$this->route = 'account/loans';
		$this->url = site_url('account/loans');
		$this->primary_key = 'partner_loan_id';
		$this->table = 'payroll_partners_loan';
		$this->icon = '';
		$this->short_name = 'My Loans';
		$this->long_name  = 'My Loans';
		$this->description = '';
		$this->path = APPPATH . 'modules/my_loans/';

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
		$qry .= " ORDER BY {$this->db->dbprefix}{$this->table}.entry_date DESC, {$this->db->dbprefix}{$this->table}.loan_status_id ASC ";
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