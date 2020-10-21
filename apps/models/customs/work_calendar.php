<?php //delete me
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

		mysqli_next_result($this->db->conn_id);
		return $data;		
	}

	public function get_shift(){
		
		$data = array();
		$qry = "SELECT shift_id, shift FROM time_shift;";
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

	public function get_partners( $manager_id ){
		
		$data = array();
		$qry = "CALL sp_partners_subordinates('$manager_id');"; 
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

	public function get_searched_partner($manager_id, $keyword){

		$data = array();

		$qry = "SELECT 
					`up`.`user_id`, 
					`p`.`id_number`, 
					CONCAT(`up`.`lastname`, ', ', `up`.`firstname`, ' ', `up`.`maidenname`) `display_name`, 
					`p`.`shift_id`, 
					`p`.`shift`
					
				FROM ww_users_profile up
				LEFT JOIN ww_partners p ON p.`user_id` = up.`user_id` 

				    
				WHERE up.`reports_to_id` = $manager_id ";

		if($keyword !== 'ALL'){
			
			$qry .= "   AND `up`.`lastname` LIKE '%" . $keyword . "%'
				        OR `up`.`firstname` LIKE '%" . $keyword . "%' ";
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

	public function get_assigned_partners($manager_id, $date, $shift_id){
		
		$data = array();
		$qry = "CALL sp_time_calendar_manager_list('$manager_id','$date', '$shift_id')";
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