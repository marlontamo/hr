<?php //delete me

	public function _get_list($start, $limit, $search, $filter, $trash = false){

		$data = array();				
		
		//$qry = $this->_get_list_cached_query();
		$qry = "SELECT 
					`tfcp`.`id` as `record_id`,
					`tfc`.`class_id`,
					`tfc`.`class_code`,
					`tfcp`.`severity`,
					`tfcp`.`class_value`,
					`tfcp`.`description`,
					`uc`.`company_id`,
					`uc`.`company`,
					`tfcp`.`employment_status_id`, 
					`tfcp`.`employment_type_id`,
					`tfcp`.`role_id` 
				FROM  
					{$this->db->dbprefix}time_form_class_policy tfcp 
				LEFT JOIN {$this->db->dbprefix}time_form_class tfc ON tfc.`class_id` = tfcp.`class_id` 
				LEFT JOIN {$this->db->dbprefix}users_company uc ON FIND_IN_SET(tfcp.`id`, tfcp.`company_id`) 
				WHERE tfc.`class_code` LIKE '%$search%' ";
		
		
		if( $trash )
		{
			$qry .= " AND uc.`deleted` = '1'";
		}
		else{
			$qry .= " AND uc.`deleted` = '0'";	
		}
		
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