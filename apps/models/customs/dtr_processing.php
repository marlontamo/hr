<?php //delete me
	function _get_list($start, $limit, $search, $trash = false)
	{
		$data = array();				
		

		$qry = $this->_get_list_cached_query();
		$qry .= " LIMIT $limit OFFSET $start";

		$trash = $trash ? 'true' : 'false';

		$this->db->query("select set_search('". $search ."')");
		$this->db->query("select set_trash( ".$trash." )");

		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	function _get_list_cached_query()
	{
		parent::_get_list_cached_query();
		return 'SELECT * FROM `time_period_list`';
	}
	