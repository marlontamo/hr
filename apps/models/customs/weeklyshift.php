public function call_sp_time_shift_insert($calendar_id='', $week_no='', $shift_id=0){		
		$sp_time_shift_insert = $this->db->query("CALL sp_time_shift_insert('".$calendar_id."', '".$week_no."', ".$shift_id.")");
		mysqli_next_result($this->db->conn_id);
		return $sp_time_shift_insert;
	}

public function get_time_shift_weekly_calendar($record_id){		

		$this->db->where('calendar_id',$record_id);
		$get_time_shift_weekly = $this->db->get('time_shift_weekly_calendar');
		return $get_time_shift_weekly->result_array();
	}