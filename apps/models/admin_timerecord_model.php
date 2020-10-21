<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class Admin_timerecord_model extends Record
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
		$this->mod_id = 58;
		$this->mod_code = 'admin_timerecord';
		$this->route = 'admin/timerecords';
		$this->url = site_url('admin/timerecords');
		$this->primary_key = 'record_id';
		$this->table = 'timerecord';
		$this->icon = 'fa-user';
		$this->short_name = 'Time Records';
		$this->long_name  = 'Time Records';
		$this->description = 'timesheets.';
		$this->path = APPPATH . 'modules/admin_timerecord/';

		parent::__construct();
	}

	public function _get_list($user_id,$range, $date){ 

		$from = date("Y-m-1", strtotime($date));
		$to = date("Y-m-t", strtotime($date));

		$data = array();
		
		$qry = "SELECT * FROM time_record_list 
				WHERE user_id = '{$user_id}' ";
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

	public function _get_list_by_date($user_id,$range, $date, $dept_id=0){ 

		// $from = date("Y-m-1", strtotime($date));
		// $to = date("Y-m-t", strtotime($date));
		$date = date("Y-m-d", strtotime($date));

		$data = array();
		
		$qry = "SELECT *, CONCAT(lastname,', ',firstname) as employee_name 
				FROM time_record_list 
				LEFT JOIN users_profile 
				ON time_record_list.user_id = users_profile.user_id
				WHERE 1=1 AND partner_id > 0";
		$qry .= " AND date BETWEEN '" . $date . "' AND '" . $date . "'";
		if($dept_id > 0){
			$qry .= " AND department_id = $dept_id ";
		}

        // for role caegory filtering
        $qry_category = $this->mod->get_role_category('users_profile');

        if ($qry_category != ''){
            $qry .= ' AND ' . $qry_category;
        }

		
		$qry .= " ORDER BY display_name ASC";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;		
	}

	public function _get_list_by_period($user_id, $from, $to){

		$from = date("Y-m-d", strtotime($from));
		$to = date("Y-m-d", strtotime($to));

		$data = array();
		
		$qry = "SELECT * FROM time_record_list 
				WHERE user_id = '{$user_id}' ";
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

	public function get_period_list( $user_id ){

		$data = array();

		$qry = "SELECT `record_id`,`period_id`,`period_year`,`payroll_date`,`from`,`to` 
				FROM time_period_list  tpl 
				JOIN users_profile up ON up.company_id =  tpl.`company_id`  
				AND up.`user_id` = '".$user_id."' 
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

	public function get_ot_info($user_id, $date)
	{
		$this->db->select('payroll_transaction.transaction_label, time_record_process.quantity');
		$this->db->where('time_record_process.date', $date);
		$this->db->where('time_record_process.user_id', $user_id);
		$this->db->where('payroll_transaction.transaction_class_id', 10);
		$this->db->join('payroll_transaction', 'payroll_transaction.transaction_id = time_record_process.transaction_id');
		$this->db->join('payroll_transaction_class', 'payroll_transaction_class.transaction_class_id = payroll_transaction.transaction_class_id');
		$this->db->from('time_record_process');
		$result = $this->db->get();
		
		$data = array();
		if($result && $result->num_rows() > 0){			
			$data = $result->result_array();
		}
		
		return $data;
	}

	function _get_user_to_options( $record_id, $mark_selected = false, $user_id = "" )
	{
        $qry = "SELECT `record_id`,`period_id`,`period_year`,`payroll_date`,`from`,`to` 
                FROM time_period_list  tpl 
                JOIN users_profile up ON up.company_id =  tpl.`company_id`  
                AND up.`user_id` = '".$user_id."'
                LIMIT 5";
		
		$lists = $this->db->query( $qry );
		$options[] = '<option value=""></option>';
		foreach( $lists->result() as $row )
		{
			$options[] = '<option value="'. $row->period_id .'">'.$row->payroll_date.'</option>';
		}
		return implode('', $options);
	}
}