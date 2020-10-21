

	
	public function get_list($user_id=0){
		$data = array();	
		
		$qry = "SELECT 
				pp.appraisal_id, 
				pp.year, 
				pp.date_from,
				pp.date_to,
				psp.performance,
				pp.status_id,
				IF(pp.status_id=1, 'Open', 'Close') AS appraise_status,
				pp.notes
				 FROM 
				{$this->db->dbprefix}performance_appraisal pp
				JOIN {$this->db->dbprefix}performance_appraisal_applicable ppa 
				ON pp.appraisal_id = ppa.appraisal_id
				JOIN {$this->db->dbprefix}performance_appraisal_approver ppap 
				ON ppa.appraisal_id = ppap.appraisal_id AND ppa.user_id = ppap.user_id
				JOIN {$this->db->dbprefix}performance_setup_performance psp 
				ON pp.performance_type_id = psp.performance_id "
				;

		$qry .= " WHERE approver_id = {$user_id}";
		$qry .= " GROUP BY pp.appraisal_id ";
		$qry .= " ORDER BY pp.appraisal_id DESC ";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	public function get_department($user_id=0, $appraisal_id=0){
		$data = array();	
		
		$qry = " SELECT 
				up.department_id, 
				ud.department 
				FROM {$this->db->dbprefix}performance_appraisal_approver ppap
				JOIN users_profile up ON ppap.user_id = up.user_id
				JOIN {$this->db->dbprefix}users_department ud ON up.department_id = ud.department_id "
				;

		$qry .= " WHERE approver_id = {$user_id}
					AND ppap.appraisal_id = {$appraisal_id} ";
		$qry .= " GROUP BY up.department_id ";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data['department'][$row['department_id']]['name'] = $row['department'];
				$data['department'][$row['department_id']]['users'] = '';
				$data['department'][$row['department_id']]['status_count'] = '';
				$data['users'][$row['department_id']] = $this->get_appraise_users($row['department_id'], $appraisal_id, $user_id);
				$data['status'][$row['department_id']] = $this->get_statuses($row['department_id'], $appraisal_id, $user_id);
				// $data['department'][$row['department_id']]['users'] = $this->get_appraise_users($row['department_id'], $appraisal_id, $user_id);
			}
		}
		return $data;
	}

	public function get_appraise_users($department_id=0, $appraisal_id=0, $user_id=0){
		$data = array();	
		
		$qry = " SELECT 
				up.user_id, 
				CONCAT(up.firstname, ' ', up.lastname) as fullname,
				ppa.status_id
				FROM {$this->db->dbprefix}performance_appraisal_approver ppap
				JOIN {$this->db->dbprefix}performance_appraisal_applicable ppa
				ON ppap.user_id = ppa.user_id AND ppa.appraisal_id = {$appraisal_id}
				JOIN users_profile up ON ppap.user_id = up.user_id
				JOIN {$this->db->dbprefix}users_department ud 
				ON up.department_id = ud.department_id "
				;

		$qry .= " WHERE approver_id = {$user_id}
					AND ppap.appraisal_id = {$appraisal_id}
					AND up.department_id = {$department_id} ";
		// $qry .= " GROUP BY up.department_id ";

		// echo "<pre>";print_r($qry);exit();
		$result = $this->db->query( $qry );

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[$row['user_id']]['name'] = $row['fullname'];
				$data[$row['user_id']]['status_id'] = $row['status_id'];
			}
		}
		return $data;
	}

	public function get_statuses($department_id=0, $appraisal_id=0, $user_id=0){
		$data = array();	
		
		$qry = " SELECT 
				ppa.status_id
				FROM {$this->db->dbprefix}performance_appraisal_approver ppap
				JOIN {$this->db->dbprefix}performance_appraisal_applicable ppa
				ON ppap.user_id = ppa.user_id AND ppa.appraisal_id = {$appraisal_id}
				JOIN users_profile up ON ppap.user_id = up.user_id
				JOIN {$this->db->dbprefix}users_department ud 
				ON up.department_id = ud.department_id "
				;

		$qry .= " WHERE approver_id = {$user_id}
					AND ppap.appraisal_id = {$appraisal_id}
					AND up.department_id = {$department_id} ";
		$qry .= " GROUP BY ppa.status_id ";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data['status'][] = $row['status_id'];
				$data['status_count'][] = $this->get_status_count($department_id, $appraisal_id, $user_id, $row['status_id']);
			}
		}
		return $data;
	}

	public function get_status_count($department_id=0, $appraisal_id=0, $user_id=0, $status_id=0){
		$data = array();	
		
		$qry = " SELECT 
				COUNT(*) as status_count
				FROM {$this->db->dbprefix}performance_appraisal_approver ppap
				JOIN {$this->db->dbprefix}performance_appraisal_applicable ppa
				ON ppap.user_id = ppa.user_id AND ppa.appraisal_id = {$appraisal_id}
				JOIN users_profile up ON ppap.user_id = up.user_id
				JOIN {$this->db->dbprefix}users_department ud 
				ON up.department_id = ud.department_id "
				;

		$qry .= " WHERE approver_id = {$user_id}
					AND ppap.appraisal_id = {$appraisal_id}
					AND up.department_id = {$department_id}
					AND ppa.status_id = {$status_id} ";
		// $qry .= " GROUP BY ppa.status_id ";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data = $row['status_count'];
			}
		}
		return $data;
	}

	public function filter_status($department_id=0, $appraisal_id=0, $user_id=0, $status_id=0){
		$data = array();
		
		$qry = " SELECT 
				up.user_id, 
				CONCAT(up.firstname, ' ', up.lastname) as fullname,
				ppa.status_id
				FROM {$this->db->dbprefix}performance_appraisal_approver ppap
				JOIN {$this->db->dbprefix}performance_appraisal_applicable ppa
				ON ppap.user_id = ppa.user_id AND ppa.appraisal_id = {$appraisal_id}
				JOIN users_profile up ON ppap.user_id = up.user_id
				JOIN {$this->db->dbprefix}users_department ud 
				ON up.department_id = ud.department_id "
				;

		$qry .= " WHERE approver_id = {$user_id}
					AND ppap.appraisal_id = {$appraisal_id}
					AND up.department_id = {$department_id}  ";
		if(is_numeric($status_id)){
			$qry .= " AND ppa.status_id = {$status_id} ";
		}
		// $qry .= " GROUP BY up.department_id ";

		// echo "<pre>";print_r($qry);exit();
		$result = $this->db->query( $qry );

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[$row['user_id']]['name'] = $row['fullname'];
				$data[$row['user_id']]['status_id'] = $row['status_id'];
			}
		}
		return $data;
	}
