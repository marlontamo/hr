<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class mobile_timerecord_model extends Record{

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

	public function __construct(){
		
		$this->mod_id = 31;
		$this->mod_code = 'timerecord';
		$this->route = 'time/timerecords';
		$this->url = site_url('time/timerecords');
		$this->primary_key = 'record_id';
		$this->table = 'time_record';
		$this->icon = '';
		$this->short_name = 'Time Records';
		$this->long_name  = 'Time Records';
		$this->description = 'timesheets.';
		$this->path = APPPATH . 'modules/mobile/mobile_timerecord/';

		parent::__construct();
	}

	public function _get_list($range, $date){

		$from = date("Y-m-1", strtotime($date));
		$to = date("Y-m-t", strtotime($date));

		$data = array();
		
		$qry = "SELECT * FROM time_record_list 
				WHERE user_id = '".$this->user->user_id."' ";
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

	public function get_list_mobile($user_id, $date){

		// $from = date("Y-m-1", strtotime($date));
		// $to = date("Y-m-t", strtotime($date));

		$from = date("Y-m-1", strtotime($date));
		$to = date("Y-m-t", strtotime($date));

		

		$data = array();
		
		$qry = "SELECT * FROM time_record_list 
				WHERE user_id = '".$user_id."' ";
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

	public function _get_list_by_period($from, $to){

		$from = date("Y-m-d", strtotime($from));
		$to = date("Y-m-d", strtotime($to));

		$data = array();
		
		$qry = "SELECT * FROM time_record_list 
				WHERE user_id = '".$this->user->user_id."' ";
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

	public function get_period_list(){

		$data = array();

		$qry = "SELECT `record_id`,`period_id`,`period_year`,`payroll_date`,`from`,`to` 
				FROM time_period_list  tpl 
				JOIN users_profile up ON up.company_id =  tpl.`company_id`  
				AND up.`user_id` = '".$this->user->user_id."'
				LIMIT 5";

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

	public function is_dtr_editable($date, $user_id){

		$data = 'fa ';
		$current_date = date('Y-m-d');
		// $current_date = '2015-03-19';

		$qry = "SELECT * FROM {$this->db->dbprefix}time_period 
				LEFT JOIN users_profile ON 
				{$this->db->dbprefix}time_period.company_id = users_profile.company_id
				WHERE user_id = {$user_id} AND
				'{$date}' BETWEEN `date_from` AND `date_to`
				AND '{$current_date}' < cutoff
				";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){						
			$data = 'fa-edit';
		}

		return $data;
	}

	public function time_record_list_forms_details($forms_id=0, $user_id=0){

		$data = array();

		$qry = "SELECT * FROM time_record_list_forms
				WHERE forms_id = '{$forms_id}' 
				GROUP BY forms_id 
				";

		$result = $this->db->query( $qry );
		return $result->row_array();
		
	}
}