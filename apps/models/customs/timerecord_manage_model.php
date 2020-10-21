<?php //delete me
	public function getManagerPartners(){

		$data = array();

		$qry = "SELECT 
					user_id partner_id, 
					CONCAT(lastname, ', ', firstname, ' ', maidenname) partner_name 
				FROM ww_users_profile
				WHERE reports_to_id = '".$this->user->user_id."' 
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
				AND up.`user_id` = '".$id."'";

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


	public function getAllSubordinates(){

		$data = array();
		$manager_ids = array();

		$qry = "SELECT 
					user_id partner_id, 
					CONCAT(lastname, ', ', firstname, ' ', maidenname) partner_name 
				FROM ww_users_profile
				WHERE reports_to_id = '".$this->user->user_id."' 
				ORDER BY partner_name ASC";
		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
				$manager_ids[] = $row['partner_id'];
			}
		}

		$qry = "SELECT 
					user_id partner_id, 
					CONCAT(lastname, ', ', firstname, ' ', maidenname) partner_name 
				FROM ww_users_profile
				WHERE reports_to_id IN (".implode(',', $manager_ids).") 
				ORDER BY partner_name ASC";
		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}
