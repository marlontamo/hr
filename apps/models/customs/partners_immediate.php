

		
	function _get_list($start='', $limit=0, $search='', $trash = false)
	{
		$data = array();				
		
		$qry = $this->_get_list_cached_query();
		
		if( $trash )
		{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 1";
		}
		else{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 0";	
		}
		//filter employees reporting to
		$qry .= " AND {$this->db->dbprefix}users_profile.reports_to_id = {$this->user->user_id}" ;

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

	public function _get_list_cached_query()
	{
		$this->load->config('list_cached_query_custom');
		return $this->config->item('list_cached_query');	
	}

	public function _get_edit_cached_query_custom( $record_id=0 )
	{
		$this->load->config('edit_cached_query_custom');
		$cached_query = $this->config->item('edit_cached_query_custom');

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($cached_query, array('record_id' => $record_id), TRUE);

		return $this->db->query( $qry )->row_array();
	}

	public function _get_edit_cached_query_personal_custom( $record_id=0 )
	{
		$this->load->config('edit_cached_query_custom');
		$cached_query = $this->config->item('edit_cached_query_personal_custom');

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($cached_query, array('record_id' => $record_id), TRUE);

		return $this->db->query( $qry )->result_array();
	}

	public function insert_partners_personal($user_id=0, $key_code='', $key_value='', $sequence=0, $partner_id=0)
	{
		$sql_partner = $this->db->get_where('partners', array('user_id' => $user_id));
		$partner_details = $sql_partner->row_array();

		$sql_partner_key = $this->db->get_where('partners_key', array('key_code' => $key_code));
		$key_details = $sql_partner_key->row_array();

		$data = array();
		
		$data = array(
			'partner_id' => ($partner_id == 0) ? $partner_details['partner_id'] : $partner_id,
			'key_id' => $key_details['key_id'],		
			'key' => $key_details['key_code'],
			'sequence' => $sequence,
			'key_name' => $key_details['key_label'],
			'key_value' => $key_value,
			'created_on' => date('Y-m-d H:i:s'),
			'created_by' => $this->user->user_id
			);

		return $data;
	}

	public function get_partner_id($user_id=0){
		$sql_partner = $this->db->get_where('partners', array('user_id' => $user_id));
		$partner_details = $sql_partner->row_array();
		return $partner_details['partner_id'];
	}

