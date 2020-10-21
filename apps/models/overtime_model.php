<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class overtime_model extends Record
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
		$this->mod_id = 92;
		$this->mod_code = 'overtime';
		$this->route = 'time/overtime';
		$this->url = site_url('time/overtime');
		$this->primary_key = 'id';
		$this->table = 'report_time_overtime';
		$this->icon = '';
		$this->short_name = 'Overtime';
		$this->long_name  = 'Overtime';
		$this->description = '';
		$this->path = APPPATH . 'modules/overtime/';

		parent::__construct();
	}

	function _get_list($start, $limit, $search, $filter, $trash = false)
	{
		$data = array();				
		
		$qry = " SELECT * FROM report_time_overtime WHERE user_id = {$this->user->user_id} ";
		//additional conditions
		$qry .= "AND (
					payroll_date like '%{$search}%' OR 
					date like '%{$search}%' OR 
					time_from like '%{$search}%' OR 
					time_to like '%{$search}%' 
				)";
		$qry .= ' '. $filter;
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

	public function get_period_details($period_id=0){

		$data = array();

		$qry = "SELECT `record_id`,`period_id`,`period_year`,`payroll_date`,`from`,`to` 
				FROM time_period_list  tpl 
				JOIN users_profile up ON up.company_id =  tpl.`company_id`  
				AND up.`user_id` = '".$this->user->user_id."' 
				AND period_id = {$period_id}
				LIMIT 5";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			$data = $result->row_array();
		}

		return $data;
	}
}