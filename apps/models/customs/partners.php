

		
	function _get_list($start='', $limit=0, $search='', $filter, $trash = false)
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
		$partner_details = array();

		$sql_partner = $this->db->get_where('partners', array('user_id' => $user_id));
		$partner_details = $sql_partner->row_array();
		if(!empty($partner_details)){
			return $partner_details['partner_id'];
		}
		return null;
	}


	function get_partners_personal_list_details($user_id=0, $key_class_code='', $sequence=0){

		$partner_id = $this->get_partner_id($user_id);
		$this->db->select('key, sequence, key_value, personal_id')
	    ->from('partners_personal_history')
	    ->join('partners', 'partners_personal_history.partner_id = partners.partner_id', 'left')
	    ->join('partners_key', 'partners_personal_history.key_id = partners_key.key_id', 'left')
	    ->join('partners_key_class', 'partners_key.key_class_id = partners_key_class.key_class_id', 'left')
	    ->where("partners.partner_id = $partner_id")
	    ->where("partners_key_class.key_class_code = '$key_class_code'")
	    ->where("partners_personal_history.sequence = '$sequence'")
	    // ->order_by("sequence", "desc")
	    ;

	    $partners_personal_list_details = $this->db->get('');	
		return $partners_personal_list_details->result_array();
	}

	function get_partners_personal($user_id=0, $partners_personal_table='', $key='', $sequence=0){

		$this->db->select('personal_id, key_value')
	    ->from($partners_personal_table)
	    ->join('partners', $partners_personal_table.'.partner_id = partners.partner_id', 'left')
	    ->where("partners.user_id = $user_id")
	    ->where($partners_personal_table.".key = '$key'");
	    if($sequence != 0)
	    	$this->db->where($partners_personal_table.".sequence = '$sequence'");

	    $partners_personal = $this->db->get('');	
		if( $partners_personal->num_rows() > 0 )
	    	return $partners_personal->result_array();
	    else
	    	return array();
	}


