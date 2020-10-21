<?php //delete me

	function _get_list($start, $limit, $search, $filter, $trash = false){

		$data = array();				
		
		$qry = 'SELECT 
					`ww_time_holiday`.`holiday_id` as record_id, 
					ww_time_holiday.holiday as "time_holiday_holiday", 
					DATE_FORMAT(ww_time_holiday.holiday_date, \'%M %d, %Y\') as "time_holiday_holiday_date", 
					IF(ww_time_holiday.legal = 1, "Yes", "No") as "time_holiday_legal", 
					`ww_time_holiday`.`created_on` as "time_holiday_created_on", 
					`ww_time_holiday`.`created_by` as "time_holiday_created_by", 
					`ww_time_holiday`.`modified_on` as "time_holiday_modified_on", 
					`ww_time_holiday`.`modified_by` as "time_holiday_modified_by" 
				FROM (`ww_time_holiday`)
				WHERE (
					ww_time_holiday.holiday like "%{$search}%" OR 
					DATE_FORMAT(ww_time_holiday.holiday_date, \'%M %d, %Y\') like "%{$search}%" OR 
					IF(ww_time_holiday.legal = 1, "Yes", "No") like "%{$search}%" 
				)';
		
		
		if( $trash ){
			$qry .= " AND `ww_time_holiday`.`deleted` = '1'";
		}
		else{
			$qry .= " AND `ww_time_holiday`.`deleted` = '0'";	
		}
		
		$qry .= 'ORDER BY ww_time_holiday.holiday_date DESC';

		$qry .= ' '. $filter;
		$qry .= " LIMIT $limit OFFSET $start"; 

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}

	function _save($action, $values){

		if($action !== ''){

			$qry = "UPDATE 
						ww_time_holiday 
					SET 
						holiday = '" . $values['holiday'] . "', 
						legal = '" . $values['legal'] . "', 
						holiday_date = '" . date("Y-m-d", strtotime($values['holiday_date'])) . "', 
						locations = '" . $values['locations'] . "', 
						location_count = '" . $values['loc_count'] . "', 
						modified_by = '" . $values['legal'] . "', 
						modified_on = NOW() 
					WHERE holiday_id = '" . $action . "'";
		}
		else{

			$qry = "INSERT INTO 
						ww_time_holiday (holiday, holiday_date, status_id, legal, locations, location_count, user_count)
					VALUES ('" . $values['holiday'] . "'
							,'" . date("Y-m-d", strtotime($values['holiday_date'])) . "'
							,'0'
							,'" . $values['legal'] . "'
							,'" . $values['locations'] . "'
							,'" . $values['loc_count'] . "'
							,'0')";
		}

		$result = $this->db->query( $qry );

		return $result;
	}

	function remove_holiday_locations($location_id){

		$qry = "DELETE FROM ww_time_holiday_location WHERE holiday_id = '".$location_id."'";
		$this->db->query( $qry );
	}

	function get_posted_holiday($holiday_date){

		$data = array();	

		$qry = "SELECT holiday_id, holiday 
				FROM ww_time_holiday 
				WHERE holiday_date = '". date("Y-m-d", strtotime($holiday_date)) ."'";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}

	function get_location_data($location_id){

		$data = array();	

		$qry = "SELECT location_id, location 
				FROM ww_users_location 
				WHERE location_id = '".$location_id."'";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}

	function get_users_from_location($location_id){

		$data = array();	
		
		$qry = "SELECT user_id, CONCAT(lastname, ', ', firstname, ' ', middlename) AS name 
				FROM ww_users_profile 
				WHERE location_id = '".$location_id."'";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}

	function add_to_holiday_location($holiday_data){

		$data = array();

		$qry = "INSERT INTO ww_time_holiday_location (holiday_id, location_id, location, user_id, user) 
				VALUES ('" . $holiday_data['holiday_id'] . "'
					 	, '" . $holiday_data['location_id'] . "'
					 	, '" . $holiday_data['location'] . "'
					 	, '" . $holiday_data['user_id'] . "'
					 	, '" . $holiday_data['user'] . "')";

		$result = $this->db->query( $qry );
	}

	function update_holiday_user_count($holiday_id, $count){

		$data = array();

		$qry = "UPDATE ww_time_holiday SET user_count = '".$count."' WHERE holiday_id = '".$holiday_id."'";
		$result = $this->db->query( $qry );

		return $result;
	}