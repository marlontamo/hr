<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class overtime_rates_model extends Record
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
		$this->mod_id = 94;
		$this->mod_code = 'overtime_rates';
		$this->route = 'admin/payroll/overtime_rates';
		$this->url = site_url('admin/payroll/overtime_rates');
		$this->primary_key = 'overtime_rate_id';
		$this->table = 'payroll_overtime_rates';
		$this->icon = '';
		$this->short_name = 'Overtime Rates';
		$this->long_name  = 'Overtime Rates';
		$this->description = 'Setup of Overtime Rates';
		$this->path = APPPATH . 'modules/overtime_rates/';

		parent::__construct();
	}

	function _get_list($start, $limit, $search, $filter, $trash = false)
	{
		$data = array();				
		
		$qry = " SELECT * FROM {$this->db->dbprefix}payroll_overtime_rates a
			LEFT JOIN {$this->db->dbprefix}users_company b on a.company_id = b.company_id
		";
		//additional conditions
		$qry .= "WHERE (
					overtime_rate like '%{$search}%' OR 
					overtime like '%{$search}%' OR 
					overtime_code like '%{$search}%' OR
					company like '%{$search}%'
				)";
		$qry .= ' '. $filter;
		$qry .= ' ORDER BY overtime_id';
		$qry .= " LIMIT $limit OFFSET $start";
		
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