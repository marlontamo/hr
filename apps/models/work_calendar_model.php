<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class work_calendar_model extends Record
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
		$this->mod_id = 27;
		$this->mod_code = 'work_calendar';
		$this->route = 'time/calendar';
		$this->url = site_url('time/calendar');
		$this->primary_key = 'work_calendar_id';
		$this->table = 'time_work_calendar';
		$this->icon = 'fa-clock-o';
		$this->short_name = 'Work Calendar';
		$this->long_name  = 'Work Calendar Manager';
		$this->description = 'calendar of work schedules.';
		$this->path = APPPATH . 'modules/work_calendar/';

		parent::__construct();
	}


	public function get_work_calendar_details($start_date, $end_date, $userid){

		$data = array();
		$qry = "CALL sp_time_calendar_manager('".$start_date."', '".$end_date."', $userid)";
		$result = $this->db->query( $qry );

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// die();

		mysqli_next_result($this->db->conn_id);
		return $data;		
	}

	public function get_shift(){
		
		$data = array();
		$qry = "SELECT shift_id, shift FROM time_shift WHERE deleted = 0 ORDER BY time_start;";
		$result = $this->db->query($qry);

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		mysqli_next_result($this->db->conn_id);
		return $data;		
	}

	public function get_shift_weekly(){
		
		$data = array();
		$qry = "SELECT calendar_id, calendar FROM {$this->db->dbprefix}time_shift_weekly WHERE deleted = 0;";
		$result = $this->db->query($qry);

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		mysqli_next_result($this->db->conn_id);
		return $data;		
	}

	public function get_partners( $manager_id, $role_id ){
		
		$data = array();
		$qry = "CALL sp_partners_subordinates('$manager_id', '$role_id');";  //die($qry);
		$result = $this->db->query($qry);

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		mysqli_next_result($this->db->conn_id);
		return $data;		
	}

	public function get_searched_partner($manager_id, $keyword, $role_id){ 

		$data = array();
		$admin_list = array("2", "6");

		$qry = "SELECT p.user_id, p.id_number, p.alias display_name, p.shift_id, shift, p.calendar_id, calendar 
				FROM partners p 
				LEFT JOIN users_profile up ON up.`user_id` = p.`user_id` ";


		/*WHERE IFNULL(p.resigned_date,0) = 0 AND alias LIKE '%james%' ";



		$qry = "SELECT 
					`up`.`user_id`, 
					`p`.`id_number`, 
					CONCAT(`up`.`lastname`, ', ', `up`.`firstname`, ' ', `up`.`maidenname`) `display_name`, 
					`p`.`shift_id`, 
					`p`.`shift`
					
				FROM ww_users_profile up
				LEFT JOIN ww_partners p ON p.`user_id` = up.`user_id` ";*/

		
		if(!in_array($role_id, $admin_list)){
			
			// $qry .= "WHERE up.`reports_to_id` = $manager_id 
			// 		 AND `up`.`lastname` LIKE '%" . $keyword . "%'
			// 	     OR `up`.`firstname` LIKE '%" . $keyword . "%' ";

			$qry .= " WHERE IFNULL(p.resigned_date,0) = 0 
					  AND (up.`reports_to_id` = $manager_id 
					  OR up.`project_hr_id` = $manager_id
					  OR $manager_id IN (up.`coordinator_id`))
					  AND alias LIKE '%" . $keyword . "%' ";
		}
		else{
			
			// $qry .= "WHERE `up`.`lastname` LIKE '%" . $keyword . "%'
			// 	     OR `up`.`firstname` LIKE '%" . $keyword . "%' ";

			$qry .= " WHERE IFNULL(p.resigned_date,0) = 0 
					  AND alias LIKE '%" . $keyword . "%' ";
		}


		$qry .= "	ORDER BY display_name ASC";  




		$result = $this->db->query($qry);

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;			
	}

	public function get_assigned_partners($manager_id, $date, $shift_id, $role_id){
		
		$data = array();
		$qry = "CALL sp_time_calendar_manager_list('$manager_id','$date', '$shift_id', '$role_id')"; //die($qry);
		$result = $this->db->query($qry); 

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		mysqli_next_result($this->db->conn_id);
		return $data;
	}

	public function update_partner_work_schedule( $date, $partner_id, $shift_id){

		$qry = "CALL sp_time_calendar_manager_insert('$partner_id','$date', '$shift_id')";
		$result = $this->db->query($qry);
	}

	public function update_partner_work_schedule_weekly( $date, $partner_id, $calendar_id){

		$qry = "CALL sp_time_calendar_manager_insert_weekly('$partner_id','$date', '$calendar_id')";
		$result = $this->db->query($qry);
	}	
}