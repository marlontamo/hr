<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class timerecord_manage_model extends Record
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
		$this->mod_id = 77;
		$this->mod_code = 'timerecord_manage';
		$this->route = 'time/timerecords/manage';
		$this->url = site_url('time/timerecords/manage');
		$this->primary_key = 'record_id';
		$this->table = 'time_record';
		$this->icon = '';
		$this->short_name = 'Timerecord Manage';
		$this->long_name  = 'Timerecord Manage';
		$this->description = '';
		$this->path = APPPATH . 'modules/timerecord_manage/';

		parent::__construct();
	}

	public function getManagerPartners(){

		$data = array();

		$qry = "SELECT 
					up.user_id partner_id, up.display_name partner_name 
				FROM users_profile up
				LEFT JOIN users ON users.user_id = up.user_id 
				WHERE up.reports_to_id = '".$this->user->user_id."' 
				AND users.active != 0
				ORDER BY partner_name ASC";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}

	public function get_period_list_manager($id){

		$data = array();

		$qry = "SELECT `record_id`,`period_id`,`period_year`,`payroll_date`,`from`,`to` 
				FROM time_period_list  tpl 
				JOIN users_profile up ON up.company_id =  tpl.`company_id`  
				AND up.`user_id` = '".$id."'
				LIMIT 5";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}

	public function _get_list_by_period_manager($from, $to, $id){

		$from = date("Y-m-d", strtotime($from));
		$to = date("Y-m-d", strtotime($to));

		$data = array();
		
		$qry = "SELECT * FROM time_record_list 
				WHERE user_id = '".$id."' ";
		$qry .= " AND date BETWEEN '" . $from . "' AND '" . $to . "'";
		$qry .= " ORDER BY DATE ASC"; 

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}

	public function _get_list_manager($range, $date, $id){

		$from = date("Y-m-1", strtotime($date));
		$to = date("Y-m-t", strtotime($date));

		$data = array();
		
		$qry = "SELECT * FROM time_record_list 
				WHERE user_id = '".$id."' ";
		$qry .= " AND date BETWEEN '" . $from . "' AND '" . $to . "'";
		$qry .= " ORDER BY DATE ASC"; 

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;		
	}

	public function _get_list_manager_by_date($range, $date, $id){

		$date = date("Y-m-d", strtotime($date));

		$data = array();
		$userids = array();
		$subordinates = $this->getAllSubordinates();

		foreach($subordinates as $subordinate){
			$userids[] = $subordinate['partner_id'];
		}

		
		$qry = "SELECT * FROM time_record_list 
				LEFT JOIN users ON time_record_list.user_id = users.user_id
				WHERE time_record_list.user_id IN ( ".implode(",", $userids)." ) ";
		$qry .= " AND time_record_list.`date` BETWEEN '" . $date . "' AND '" . $date . "'";
		$qry .= " ORDER BY time_record_list.`date` ASC"; 

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;		
	}

	public function time_record_list_forms($date, $user_id){

		$data = array();

		$qry = "SELECT * FROM time_record_list_forms
				WHERE date = '{$date}' 
				AND user_id = '{$user_id}' 
				AND form_code <> 'DTRU'
				GROUP BY forms_id 
				";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}


	public function getAllSubordinates(){

		$data = array();
		$manager_ids = array();

		$qry = "SELECT 
					up.user_id partner_id, 
					CONCAT(lastname, ', ', firstname, ' ', maidenname) partner_name 
				FROM users_profile up
				LEFT JOIN users ON users.user_id = up.user_id 
				WHERE up.reports_to_id = '".$this->user->user_id."'  
				AND users.active != 0 
				ORDER BY partner_name ASC";
		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
				$manager_ids[] = $row['partner_id'];
			}
		}

		$qry = "SELECT 
					up.user_id partner_id, 
					CONCAT(lastname, ', ', firstname, ' ', maidenname) partner_name 
				FROM users_profile up
				LEFT JOIN users ON users.user_id = up.user_id 
				WHERE up.reports_to_id IN (".implode(',', $manager_ids).")  
				AND users.active != 0 
				ORDER BY partner_name ASC";
		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}

	public function is_dtru_applicable()
	{
		$updating = $this->db->get_where('time_form', array('form_code' => 'DTRU', 'deleted' => 0));
		if($updating && $updating->num_rows() > 0){
			$dtru = $updating->row();
			if($dtru->can_view == 1){
				return true;
			}
		}
		return false;
	}
}
