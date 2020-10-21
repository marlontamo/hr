<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class closed_transaction_model extends Record
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
		$this->mod_id = 69;
		$this->mod_code = 'closed_transaction';
		$this->route = 'payroll/closed_transactions';
		$this->url = site_url('payroll/closed_transactions');
		$this->primary_key = 'id';
		$this->table = 'payroll_closed_transaction';
		$this->icon = 'fa-folder';
		$this->short_name = 'Closed Transactions';
		$this->long_name  = 'Closed Transactions';
		$this->description = '';
		$this->path = APPPATH . 'modules/closed_transaction/';

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
			$qry .= " AND T4.sensitivity IN ( ".$sensID." )";
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

		// FOR COMPANY ASSIGN ONLY
		$user = $this->config->item('user');
		$qry .= " AND `{$this->db->dbprefix}{$this->table}`.company_id in ({$user['region_companies']})";
		
		
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