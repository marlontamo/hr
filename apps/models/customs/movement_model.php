
		
	function _get_list($start, $limit, $search, $filter, $trash = false)
	{
		$data = array();				
		
		
		$qry = "SELECT * 
				FROM partner_movement 
				WHERE 1=1 ";
		
		if( $trash )
		{
			$qry .= " AND deleted = 1";
		}
		else{
			$qry .= " AND deleted = 0";	
		}
		
		// $qry .= " GROUP BY record_id
		// 			ORDER BY created_by ";

		$qry .= ' '. $filter;
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	function getTransferFields(){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_fields "; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_employee_details($user_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT *, 
		'' AS project_id, 
		'' AS project, 
		'' AS rank_id, 
		'' AS rank
		 FROM partner_movement_current WHERE user_id = {$user_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_movement_details($movement_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT 
		pmove.movement_id,
		pmove.status_id,
		pmove.due_to_id,
		pmove.remarks AS movement_remarks,
		pmoveact.action_id,
		pmoveact.user_id,
		pmoveact.effectivity_date,
		pmoveact.type_id,
		pmoveact.type,
		pmoveact.remarks AS action_remarks,
		pmoveact.action_id,
		pmoveact.display_name
				FROM {$this->db->dbprefix}partners_movement pmove
				INNER JOIN {$this->db->dbprefix}partners_movement_action pmoveact 
				ON pmove.movement_id = pmoveact.movement_id 
				WHERE pmove.movement_id = {$movement_id}
				AND pmoveact.deleted = 0
				ORDER BY pmoveact.effectivity_date DESC"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_action_movement($action_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action
				WHERE action_id = {$action_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_extension_movement($action_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_extension
				WHERE action_id = {$action_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_moving_movement($action_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_moving
				WHERE action_id = {$action_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_compensation_movement($action_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_compensation
				WHERE action_id = {$action_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_transfer_movement($action_id=0, $field_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_transfer
				WHERE action_id = {$action_id} 
				AND field_id = {$field_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

