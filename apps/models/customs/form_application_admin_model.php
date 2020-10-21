


function _get_list($start, $limit, $search, $trash = false,$form_id)
{
	$data = array();				
	

	$qry = $this->_get_list_cached_query();
	// $qry .= " WHERE approver_id = {$this->user->user_id}";

	if( $form_id > 0 ){
        $qry .= " AND form_id = ".$form_id;
    }

    if( $search ){
    	$qry .= " AND ( display_name LIKE '%".$search."%' OR form LIKE '%".$search."%' OR form_status LIKE '%".$search."%' OR date_range LIKE '%".$search."%' )";
    }

    $qry .= " ORDER BY date_from DESC ";
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



function _get_list_cached_query()
{
	parent::_get_list_cached_query();
	return 'SELECT * FROM `time_forms_admin`';
}

function setDecission($decission){

		$data = array();

		$qry = "CALL sp_time_forms_approval_admin('".$decission['formid']."', '".$decission['userid']."', '".$decission['decission']."', '".$decission['comment']."')";
		$result = $this->db->query( $qry );

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		mysqli_next_result($this->db->conn_id);
		return $data;	
	}

function newPostData($data){

		$qry = "INSERT INTO ww_system_feeds 
				(
					status
					, user_id
					, display_name
					, feed_content
					, recipient_id
					, message_type
				) 
				VALUES
				(
					'" . $data['status'] . "',
					'" . $data['user_id'] . "',
					'" . $data['display_name'] . "',
					'" . $data['feed_content'] . "',
					'" . $data['recipient_id'] . "',
					'Time Record'
				)";
		
		$this->db->query($qry);
		return $this->db->insert_id();
	}

public function get_form_approver_info( $forms_id = 0, $user_id = 0 ){


	$form = $this->db->query("SELECT *, form_status_id as approver_status_id FROM time_forms WHERE forms_id=".$forms_id);
	return $form->row_array();


}
	
public function get_form_info( $form_code ){		

		$this->db->where('deleted',0);
		$this->db->where('form_code',strtoupper($form_code));
		$this->db->or_where('form_id',$form_code);
		$form = $this->db->get('time_form');
		return $form->row_array();
	}	

public function call_sp_time_calendar($date_from='', $date_to='', $user_id=0){		
		$sp_time_calendar = $this->db->query("CALL sp_time_calendar('$date_from', '$date_to', ".$user_id.")");
		mysqli_next_result($this->db->conn_id);
		return $sp_time_calendar->result_array();
	}

	public function get_display_name($user_id=0){		
		$sql_display_name = $this->db->get_where('users', array('user_id' => $user_id));
		$display_name = $sql_display_name->row_array();
		return $display_name['display_name'];
	}

	public function get_form_type($form_id=0){		
		$where = array('deleted' => 0);
		if($form_id != 0) {$where= array('deleted' => 0, 'form_id' => $form_id);}
		$form_type_details = $this->db->get_where('time_form', $where);

		return ($form_id != 0) ? $form_type_details->row_array() : $form_type_details->result_array();		 
	}

	public function get_leave_form_type(){

		$this->db->where_not_in('form_id',array(13));
		$this->db->where('is_leave',1);
		$this->db->where('deleted',0);
		$leave_form_type = $this->db->get('time_form');

		return $leave_form_type->result_array();		 
	}

	public function get_forms_details($forms_id=0){		
		$where = array('deleted' => 0);
		if($forms_id != 0) {$where= array('deleted' => 0, 'forms_id' => $forms_id);}
		$forms_details = $this->db->get_where('time_forms', $where);
		
		return $forms_details->row_array();
	}

	public function get_leave_balance($user_id=0, $year='', $form_id=0){	
		$this->db->select('*')
	    ->from('time_form_balance')
	    ->join('time_form', 'time_form_balance.form_id=time_form.form_id', 'left')
	    ->where(array('user_id' => $user_id, 'year' => $year, 'time_form_balance.deleted' => 0));
		$leave_balances=$this->db->get('');	
		return $leave_balances->result_array();
	}

	public function get_delivery(){		
		$this->db->order_by('delivery');
		$delivery_type = $this->db->get_where('time_delivery', array('deleted' => 0));
		return $delivery_type->result_array();
	}	

	public function get_forms_upload($forms_id){		
		$where = array('deleted' => 0);
		if($forms_id != 0) {$where= array('deleted' => 0, 'forms_id' => $forms_id);}
		$time_forms_upload = $this->db->get_where('time_forms_upload', $where);
		return $time_forms_upload->result_array();
	}	

	public function get_duration($duration_id = 0){		
		$where = array('deleted' => 0);
		if($duration_id != 0) {$where= array('deleted' => 0, 'duration_id' => $duration_id);}
		$duration_type = $this->db->get_where('time_duration', $where);

		return $duration_type->result_array();
	}	

	public function get_shifts(){		
		$this->db->order_by('shift');
		$shifts = $this->db->get_where('time_shift', array('deleted' => 0));
		return $shifts->result_array();
	}	

	public function get_approved_forms($date='', $user_id=0){
		$approved_forms = "SELECT * FROM time_forms_validation WHERE date = '$date' AND user_id = $user_id";
		$approved_forms = $this->db->query($approved_forms);

		return $approved_forms->result_array();
	}

	public function get_shift_details($date='', $user_id=0){
		$shift_details_qry = "SELECT * FROM time_shift_logs WHERE date='$date' AND user_id = $user_id";
		$shift_details = $this->db->query($shift_details_qry);

		if($shift_details->num_rows() == 0){
			$shift_details_qry = "SELECT partners.user_id AS user_id,'$date' AS DATE, partners.shift_id AS shift_id,
									time_shift.time_start AS shift_time_start, time_shift.time_end AS shift_time_end,
									 '-' AS logs_time_in,  '-' AS logs_time_out
								 FROM partners LEFT JOIN time_shift ON partners.shift_id = time_shift.shift_id
								 WHERE partners.user_id = $user_id";
			$shift_details = $this->db->query($shift_details_qry);
		}
		return $shift_details->row_array();
	}

	public function get_selected_dates($forms_id=0){	
		$where = array('deleted' => 0);
		if($forms_id != 0) {$where= array('deleted' => 0, 'forms_id' => $forms_id);}
		$selected_dates = $this->db->get_where('time_forms_date', $where);

		return $selected_dates->result_array();
	}

	public function check_dtrp_type($forms_id=0){			
		$query_dtrp = "SELECT IF(time_from = '0000-00-00 00:00:00' , 2, IF(time_to = '0000-00-00 00:00:00', 1, 3)) AS dtrp_type
	    from {$this->db->dbprefix}time_forms_date
	    where forms_id = $forms_id";
		$dtr_type = $this->db->query($query_dtrp)->row_array();
		return $dtr_type['dtrp_type'];
	}

	public function check_ut_type($forms_id=0){			
		$query_ut = "SELECT IF(time_from = '0000-00-00 00:00:00' , 0, 1) AS ut_type
	    from {$this->db->dbprefix}time_forms_date
	    where forms_id = $forms_id";
		$ut_type = $this->db->query($query_ut)->row_array();
		return $ut_type['ut_type'];
	}

	public function get_time_from_to_dates($forms_id=0, $date='', $time='', $form_type='', $bt_type=''){	
		$date = $date == '' ? '' : $date;	
		$this->db->select($time)
	    ->from('time_forms_date')
	    ->where("forms_id = $forms_id");
	    if($form_type == 8 && $bt_type == 2){//OBT form and type is Date Range
	    	$this->db->where("DATE_FORMAT($time, '%Y-%m-%d') = '$date'");
		}
		$time_forms_date=$this->db->get('')->row_array();	

		return array_key_exists($time, $time_forms_date) ? $time_forms_date[$time] : "" ;
	}

	public function check_if_rest_day($user_id=0){	
		$check_if_rest_day = "SELECT * FROM time_shift_rest_days WHERE user_id = $user_id";
		$check_if_rest_day = $this->db->query($check_if_rest_day);

		return $check_if_rest_day->result_array();		
	}


	public function check_if_holiday($date='', $user_id=0){
		$check_if_holiday = "SELECT * FROM time_holiday WHERE holiday_date = '$date'";
		$check_if_holiday = $this->db->query($check_if_holiday);

		return $check_if_holiday->result_array();		
	}
	
	public function edit_cached_query( $record_id )
	{
		//check for cached query
		if( !$this->load->config('edit_cached_query', false, true) )
		{
			//mandatory fields
			$this->db->select( $this->table . '.' . $this->primary_key . ' as record_id' );

			//create query for all tables
			$this->load->config('fields');
			$tables = array();
			foreach( $this->config->item('fields') as $fg_id => $fields )
			{
				foreach( $fields as $f_name => $field )
				{
					if( $field['display_id'] == 2 || $field['display_id'] == 3)
					{
						switch( $field['uitype_id'] )
						{ 
							case 6:
								$columns[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . ', \\\'%M %d, %Y\\\') as "'. $field['table'] .'.'. $field['column'] .'"';
								break;
							case 12:
								$columns[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . '_from, \\\'%M %d, %Y\\\') as "'. $field['table'] .'.'. $field['column'] .'_from"';
								$columns[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . '_to,\\\'%M %d, %Y\\\') as "'. $field['table'] .'.'. $field['column'] .'_to"';
								break;	
							default:
								$columns[] = $f_name . ' as "'. $field['table'] .'.'. $field['column'] .'"';
						}
					}
					
					
					if( !in_array( $field['table'], $tables ) && $field['table'] != $this->table ){
						$this->db->join( $field['table'], $field['table'].'.'.$this->primary_key . ' = ' . $this->table.'.'.$this->primary_key, 'left');
						$tables[] = $field['table'];
					}
				}
			}

			$db_debug = $this->db->db_debug;
			$this->db->db_debug = FALSE;

			if( isset( $columns ) ) $this->db->select( $columns, false );
			$this->db->from( $this->table );
			$this->db->where( $this->table.'.'.$this->primary_key. ' = "{$record_id}"' );
			$record = $this->db->get();
			$cached_query = $this->db->last_query();

			$this->db->db_debug = $db_debug;

			$cached_query = '$config["edit_cached_query"] = \''. $cached_query .'\';';
			$cached_query = $this->load->blade('templates/save2file', array( 'string' => $cached_query), true);
			
			$this->load->helper('file');
			$save_to = $this->path . 'config/edit_cached_query.php';
			$this->load->helper('file');
			write_file($save_to, $cached_query);
		}

		$this->load->config('edit_cached_query');
		$cached_query = $this->config->item('edit_cached_query');

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($cached_query, array('record_id' => $record_id), TRUE);

		return $this->db->query( $qry )->row_array();
	}
