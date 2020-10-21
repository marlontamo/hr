

	function _get_list($start, $limit, $search, $filter, $trash = false)
	{
		$data = array();				
		
		$qry = " SELECT * FROM report_time_overtime WHERE user_id = {$this->user->user_id} ";
		//additional conditions
		$qry .= "AND (
					payroll_date like '%{$search}%' OR 
					date like '%{$search}%' OR 
					time_from like '%{$search}%' OR 
					time_to like '%{$search}%' 
				)";
		$qry .= ' '. $filter;
		$qry .= " LIMIT $limit OFFSET $start";

		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	public function get_period_details($period_id=0){

		$data = array();

		$qry = "SELECT `record_id`,`period_id`,`period_year`,`payroll_date`,`from`,`to` 
				FROM time_period_list  tpl 
				JOIN users_profile up ON up.company_id =  tpl.`company_id`  
				AND up.`user_id` = '".$this->user->user_id."' 
				AND period_id = {$period_id}
				LIMIT 5";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			$data = $result->row_array();
		}

		return $data;
	}
