<?php //delete me

	function getTimeReferrenceList(){ 

		$data = array();

		/*!*
		* 36 - holiday
		* 37 - shift
		*/

		$qry = "SELECT  
					mod_id, route, short_name, icon, description
				FROM ww_modules
				WHERE mod_id IN ('36', '37', '39', '72')
				AND deleted = '0'"; 
		
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
			
			$data['count'] = $result->num_rows();

			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}