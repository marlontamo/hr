<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class current_transaction_model extends Record
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
		$this->mod_id = 68;
		$this->mod_code = 'current_transaction';
		$this->route = 'payroll/current_transactions';
		$this->url = site_url('payroll/current_transactions');
		$this->primary_key = 'id';
		$this->table = 'payroll_current_transaction';
		$this->icon = 'fa-folder';
		$this->short_name = 'Current Transactions';
		$this->long_name  = 'Current Transactions';
		$this->description = '';
		$this->path = APPPATH . 'modules/current_transaction/';

		parent::__construct();
	}

	function get_red_flags()
	{
		// GET SENSITIVITY
		// BEGIN //
		$add_qry = '';
		$sensID = $this->config->config['user']['sensitivity'];
		if($sensID && !empty($sensID) ){
			$add_qry = " AND p.sensitivity IN ( ".$sensID." )";
		}
		// END //
		$qry = "
    	select * from
    	(select b.user_id, b.full_name from 
    	{$this->db->dbprefix}payroll_current_transaction a
    	LEFT JOIN {$this->db->dbprefix}users b on b.user_id = a.employee_id
    	LEFT JOIN {$this->db->dbprefix}payroll_partners p on p.user_id = a.employee_id
    	where (aes_decrypt(a.amount, encryption_key()) * 1) < 0 AND
    	a.deleted = 0 AND a.transaction_code = 'NETPAY' $add_qry

    	UNION

    	select b.user_id, b.full_name from 
    	{$this->db->dbprefix}payroll_current_transaction a
    	LEFT JOIN {$this->db->dbprefix}users b on b.user_id = a.employee_id
    	LEFT JOIN {$this->db->dbprefix}payroll_partners c on c.user_id = a.employee_id
    	LEFT JOIN {$this->db->dbprefix}payroll_partners p on p.user_id = a.employee_id
    	where (aes_decrypt(a.amount, encryption_key()) * 1) < (aes_decrypt(c.minimum_takehome, encryption_key()) * 1) AND
    	a.deleted = 0 AND a.transaction_code = 'NETPAY' $add_qry
    	) as emps
		group by user_id
		order by full_name asc
		";
    	return $this->db->query( $qry );
	}

	function _get_list($start, $limit, $search, $filter, $trash = false)
	{
		$filter = str_replace('__','.',$filter);

		$data = array();				
		
		$qry = $this->_get_list_cached_query();

		// GET SENSITIVITY
		// BEGIN //
		$sensID = $this->config->config['user']['sensitivity'];
		if($sensID && !empty($sensID) ){
			$qry .= " AND T5.sensitivity IN ( ".$sensID." )";
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
/*		$user = $this->config->item('user');
		$qry .= " AND `{$this->db->dbprefix}{$this->table}`.company_id in ({$user['region_companies']})";*/
		
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