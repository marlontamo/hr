<?php //delete me
	function _get_config( $module ){
		
		$data = array();
		$qry = "SELECT c.key, c.value FROM ww_config c
				LEFT JOIN ww_config_group cg ON cg.config_group_id = c.config_group_id
				WHERE cg.group_key = '$module'
				UNION ALL
				SELECT 'config_group_id' as `key`, cg.config_group_id as value FROM ww_config_group cg
				WHERE cg.group_key = '$module'"; 
				
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				//$data[$row['key']][] = _create_proper_name( $row['key'] );
				$data[$row['key']][] = ucwords( str_replace( '_', ' ', $row['key'] ) );
				$data[$row['key']][] = $row['value'];
			}
			
		}
			
		$result->free_result();
		return $data;
		
	}
	
	
	function _update_config( $qry ){

		$success = false;
		
		for($i=0; $i < count($qry); $i++){
			$success = $this->db->query($qry[$i]);
		}
		
		return $success;
		
	}