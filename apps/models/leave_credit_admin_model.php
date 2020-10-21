<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class leave_credit_admin_model extends Record
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
		$this->mod_id = 185;
		$this->mod_code = 'leave_credit_admin';
		$this->route = 'time/leave_credit_admin';
		$this->url = site_url('time/leave_credit_admin');
		$this->primary_key = 'id';
		$this->table = 'time_form_balance';
		$this->icon = '';
		$this->short_name = 'Annual Leave Admin';
		$this->long_name  = 'Leave Balance Admin';
		$this->description = '';
		$this->path = APPPATH . 'modules/leave_credit_admin/';

		parent::__construct();
	}

	function _get_list($start, $limit, $search, $filter, $trash = false, $list_view="annual")
	{
		$data = array();				
		
		$qry = $this->_get_list_cached_query();
		
		//filter by specific employee
		// $qry .= " AND {$this->db->dbprefix}{$this->table}.user_id = {$this->user->user_id}";
		
		if( $trash )
		{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 1";
		}
		else{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 0";	
		}
		
		$qry .= ' '. $filter;
		switch($list_view){
			case 'annual':
				$qry .= " AND T3.form_code IN ('VL') ";
			break;
			case 'addl':
				$qry .= " AND T3.form_code IN ('ADDL') AND ( used > 0 OR current > 0 ) ";
			break;
			case 'special':
				$qry .= " AND T3.form_code NOT IN ('VL', 'ADDL', 'SL') AND used > 0 ";
			break;
			case 'sick':
				$qry .= " AND T3.form_code IN ('SL') AND used > 0 ";
			break;
		}

		// $qry .= ' UNION ';

		// $qry .= $this->union_qry();
		// $qry .= ' AND ww_time_form_balance.form_code NOT IN ("VL", "ADDL", "SL") 
		// 		 GROUP BY ww_time_form_balance.user_id, ww_time_form_balance.year';

		$qry .= " ORDER BY 
					time_form_balance_user_id ASC,
					time_form_balance_period_from DESC ";

		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);
// echo $qry;exit;
		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	function union_qry(){
		$union_qry = 'SELECT GROUP_CONCAT(`ww_time_form_balance`.`id` SEPARATOR ", ") AS record_id, 
				0 AS "time_form_balance_current", 
				0 AS "time_form_balance_previous", 
				T2.display_name AS "time_form_balance_user_id", 
				"Cuti Khusus" AS "time_form_balance_form", 
				ww_time_form_balance.year AS "time_form_balance_year", 
				SUM(ww_time_form_balance.used) AS "time_form_balance_used", 
				0 AS "time_form_balance_balance",
				DATE_FORMAT(ww_time_form_balance.period_from, \'%d %b %Y\') AS "time_form_balance_period_from",
				DATE_FORMAT(ww_time_form_balance.period_to, \'%d %b %Y\') AS "time_form_balance_period_to",
				DATE_FORMAT(ww_time_form_balance.period_extension, \'%d %b %Y\') as "time_form_balance_period_extension_view",
				DATE_FORMAT(ww_time_form_balance.period_extension, "%M %d, %Y") AS "time_form_balance_period_extension"
				,
				`ww_time_form_balance`.`created_on` AS "time_form_balance_created_on", 
				`ww_time_form_balance`.`created_by` AS "time_form_balance_created_by", 
				`ww_time_form_balance`.`modified_on` AS "time_form_balance_modified_on", 
				`ww_time_form_balance`.`modified_by` AS "time_form_balance_modified_by", 
				GROUP_CONCAT(`ww_time_form_balance`.`form_id` SEPARATOR ", ") AS time_form_balance_form_id, 
				T4.effectivity_date, 
				T3.form_code, (SELECT COUNT(tfb.id) + 1  FROM ww_time_form_balance tfb 
					WHERE tfb.`year` = ww_time_form_balance.year
					AND tfb.`user_id` = ww_time_form_balance.user_id 
					AND tfb.form_code IN ("VL", "ADDL", "SL")
					GROUP BY `year`, user_id) AS rowspan
				, ww_time_form_balance.user_id
				FROM (`ww_time_form_balance`)
				LEFT JOIN `ww_users` T2 ON `T2`.`user_id` = `ww_time_form_balance`.`user_id`
				LEFT JOIN `ww_partners` T4 ON `T4`.`user_id` = `ww_time_form_balance`.`user_id`
				LEFT JOIN `ww_time_form` T3 ON `T3`.`form_id` = `ww_time_form_balance`.`form_id`
				WHERE (
				ww_time_form_balance.current like "%{$search}%" OR 
				ww_time_form_balance.previous like "%{$search}%" OR 
				T2.display_name like "%{$search}%" OR 
				ww_time_form_balance.year like "%{$search}%" OR 
				T3.form like "%{$search}%"
				)
				';

		return $union_qry;

	}
}