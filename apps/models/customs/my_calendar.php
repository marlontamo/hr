


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

	public function get_user_details($user_id=0){		
		$user_details = $this->db->get_where('users', array('user_id' => $user_id));
		return $user_details->row_array();
	}

	public function get_form_type($form_id=0){		
		$where = array('deleted' => 0);
		if($form_id != 0) {$where= array('deleted' => 0, 'form_id' => $form_id);}
		$form_type_details = $this->db->get_where('time_form', $where);

		return ($form_id != 0) ? $form_type_details->row_array() : $form_type_details->result_array();		 
	}

	public function get_form_policy_grant($user_id=0){
		$form_id = 0;
		$forms_grants = $this->get_form_type();

		$forms_with_grant = array();
		foreach($forms_grants as $forms_grant){
			$forms_with_grant[] = $forms_grant['form_code']."-GRANT";
		}
		$forms_with_grant = "('" . implode("','", $forms_with_grant) . "')";
		$application_forms = "SELECT tf.* FROM {$this->db->dbprefix}time_form tf
							LEFT JOIN {$this->db->dbprefix}time_form_class tfc ON tf.form_id = tfc.form_id
							LEFT JOIN {$this->db->dbprefix}time_form_class_policy tfcp ON tfc.class_id = tfcp.class_id
							LEFT JOIN {$this->db->dbprefix}users_profile up ON FIND_IN_SET(up.company_id, tfcp.company_id)
							LEFT JOIN {$this->db->dbprefix}partners prs ON up.user_id = prs.user_id
							LEFT JOIN {$this->db->dbprefix}users usr ON up.user_id = usr.user_id
							LEFT JOIN {$this->db->dbprefix}partners_personal pp ON prs.partner_id = pp.partner_id AND pp.key = 'gender'
							LEFT JOIN {$this->db->dbprefix}partners_personal pps ON prs.partner_id = pps.partner_id AND pps.key = 'solo_parent'
							WHERE tfc.class_code IN
							{$forms_with_grant}
							AND up.user_id = {$user_id} 
							AND tfcp.class_value = 'YES'
							AND IF((tfcp.employment_status_id  != 'ALL') AND (prs.status_id IS NOT NULL AND LENGTH(prs.status_id) > 0), FIND_IN_SET(prs.status_id, tfcp.employment_status_id), 1)
							AND IF((tfcp.employment_type_id  != 'ALL') AND (prs.employment_type_id IS NOT NULL AND LENGTH(prs.employment_type_id) > 0), FIND_IN_SET(prs.employment_type_id, tfcp.employment_type_id), 1)
							AND IF((tfcp.role_id  != 'ALL') AND (usr.role_id IS NOT NULL AND LENGTH(usr.role_id) > 0), FIND_IN_SET(usr.role_id, tfcp.role_id), 1)
							AND IF((tfcp.division_id  != 'ALL') AND (up.division_id IS NOT NULL AND LENGTH(up.division_id) > 0), FIND_IN_SET(up.division_id, tfcp.division_id), 1)
							AND IF((tfcp.department_id  != 'ALL') AND (up.department_id IS NOT NULL AND LENGTH(up.department_id) > 0), FIND_IN_SET(up.department_id, tfcp.department_id), 1)
							AND IF((tfcp.group_id  != 'ALL') AND (up.group_id IS NOT NULL AND LENGTH(up.group_id) > 0), FIND_IN_SET(up.group_id, tfcp.group_id), 1)
							#AND IF((tfcp.project_id IS NOT NULL AND LENGTH(tfcp.project_id) > 0) AND (up.project_id IS NOT NULL AND LENGTH(up.project_id) > 0), FIND_IN_SET(up.project_id, tfcp.project_id), 1)
							AND IF(pp.key_value = 'Male', tf.only_female != 1, tf.only_male != 1)
							AND IF(pps.key_value = 1, 1=1, tf.form_id != 16)
							ORDER BY tf.form_id";
							// echo "<pre>$application_forms";exit();
		$application_forms = $this->db->query($application_forms);
		return ($form_id != 0) ? $application_forms->row_array() : $application_forms->result_array();		 
	}

	public function get_leave_form_type(){
		$where= array('deleted' => 0, 'is_leave' => 1);
		$leave_form_type = $this->db->get_where('time_form', $where);

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

	public function get_pending_forms($date='', $user_id=0){
		$pending_forms = "SELECT * FROM time_forms_validate_if_exist WHERE date = '$date' AND user_id = $user_id";
		$pending_forms = $this->db->query($pending_forms);
		if($pending_forms){
			return $pending_forms->result_array();
		}
		return false;
	}

	public function validate_ot_forms($date_from='', $date_to='', $user_id=0, $form_id=0, $forms_id=0){	                 
        $qry = "SELECT *
        FROM time_forms_date tfd
        JOIN time_forms tf ON tfd.forms_id = tf.forms_id
        WHERE tfd.deleted = 0 AND tf.form_status_id IN (2,3,4,5,6) AND tf.user_id = '{$user_id }' 
        AND tf.form_id = '{$form_id }' AND tf.forms_id != '{$forms_id }' AND
        ( 
            ('{$date_from}' >= tfd.time_from AND '{$date_from}' < tfd.time_to) OR
            ('{$date_to}' > tfd.time_from AND '{$date_to}' <= tfd.time_to)  
            -- OR
            --     ('2014-06-16 17:30:00' < datetime_from AND '2014-06-16 18:00:00' > datetime_to)                    
        )";
		$existing_form = $this->db->query($qry);
		return $existing_form->num_rows();
	}

	public function get_shift_details($date='', $user_id=0){
		$shift_details_qry = "SELECT
							  partners.user_id AS user_id,
							  time_record.date AS date,
							  IF((time_record.aux_shift_id > 0),time_record.aux_shift_id,IF((time_record.shift_id > 0),time_record.shift_id,IF((time_forms_date.shift_to > 0),cws_shift.shift_id,prt_shift.shift_id))) AS shift_id,
							  IF((time_record.aux_shift_id > 0),time_aux_shift.time_start,IF((time_record.shift_id > 0),time_rec_shift.time_start,IF((time_forms_date.shift_to > 0),cws_shift.time_start,prt_shift.time_start))) AS shift_time_start,
							  IF((time_record.aux_shift_id > 0),time_aux_shift.time_end,IF((time_record.shift_id > 0),time_rec_shift.time_end,IF((time_forms_date.shift_to > 0),cws_shift.time_end,prt_shift.time_end))) AS shift_time_end,
							  IF(((time_record.record_id > 0) AND (time_record.time_in <> '0000-00-00 00:00:00')),time_record.time_in,'-') AS logs_time_in,
							  IF(((time_record.record_id > 0) AND (time_record.time_out <> '0000-00-00 00:00:00')),time_record.time_out,'-') AS logs_time_out
							FROM (((((partners
							       LEFT JOIN time_forms
							         ON (((partners.user_id = time_forms.user_id)
							              AND (time_forms.form_id = 12)
							              AND (time_forms.form_status_id = 6))
							              AND ('{$date}' BETWEEN time_forms.date_from AND time_forms.date_to)))
							      LEFT JOIN time_record
							        ON ((partners.user_id = time_record.user_id)
							        AND (time_record.date='{$date}')))
							     LEFT JOIN time_forms_date
							       ON (((time_forms.forms_id = time_forms_date.forms_id)
							            AND (time_forms_date.deleted = 0))))
							    LEFT JOIN time_shift prt_shift
							      ON ((partners.shift_id = prt_shift.shift_id)))
							   LEFT JOIN time_shift cws_shift
							     ON ((time_forms_date.shift_to = cws_shift.shift_id))
							   LEFT JOIN time_shift time_rec_shift
							     ON ((time_record.shift_id = time_rec_shift.shift_id))
							   LEFT JOIN time_shift time_aux_shift
							     ON ((time_record.aux_shift_id = time_aux_shift.shift_id)))
							     
							     WHERE partners.user_id = {$user_id}";
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

	public function check_if_rest_day($user_id=0, $date){	
		// $check_if_rest_day = "SELECT * FROM time_shift_rest_days WHERE user_id = $user_id";
		$check_if_rest_day_qry = "SELECT DISTINCT partners.user_id AS user_id,
							  IF((time_forms_date.shift_to > 0),cws_time_shift.shift_id,emp_time_shift.shift_id) AS shift_id,
							  IF((emp_calendar.calendar_id > 0),emp_calendar.week_name,cws_calendar.week_name) AS rest_day
								FROM (partners
							       LEFT JOIN users_profile
							         ON ((partners.user_id = users_profile.user_id))
							       LEFT JOIN time_forms
								 ON ((partners.user_id = time_forms.user_id)
								      AND (time_forms.form_id = 12)
								      AND (time_forms.form_status_id = 6)
								      AND ('{$date}' BETWEEN time_forms.date_from AND time_forms.date_to))
							       LEFT JOIN time_forms_date
								 ON (((time_forms.forms_id = time_forms_date.forms_id)
							            AND (time_forms_date.deleted = 0)
    								AND time_forms_date.date = '{$date}'))
							     LEFT JOIN ww_time_shift emp_time_shift
							      ON ((partners.shift_id = emp_time_shift.shift_id))
							     LEFT JOIN ww_time_shift cws_time_shift
							      ON ((time_forms_date.shift_id = cws_time_shift.shift_id))
							     LEFT JOIN ww_time_shift_weekly_calendar emp_calendar
							      ON ((emp_time_shift.default_calendar = emp_calendar.calendar_id)
							      	AND emp_calendar.shift_id = 1)
							     LEFT JOIN ww_time_shift_weekly_calendar cws_calendar
							      ON ((cws_time_shift.default_calendar = cws_calendar.calendar_id)
							      	AND cws_calendar.shift_id = 1)
							      )
									WHERE partners.user_id =$user_id";
		$check_if_rest_day = $this->db->query($check_if_rest_day_qry);

		if($check_if_rest_day){
			return $check_if_rest_day->result_array();		
		}
		return false;	
	}


	public function check_if_holiday($date='', $user_id=0){

		$check_if_holiday_qry = "SELECT * FROM time_holiday th 
							LEFT JOIN {$this->db->dbprefix}time_holiday_location thl 
							ON th.holiday_id = thl.holiday_id
							WHERE th.holiday_date = '{$date}'
							AND thl.user_id = {$user_id}";
		$check_if_holiday = $this->db->query($check_if_holiday_qry);
		if($check_if_holiday){
			return $check_if_holiday->result_array();
		}
		return false;		
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

	public function check_time_record_workschedule($date='', $user_id=0){
		$time_record_workschedule_qry = "SELECT * FROM time_record WHERE date = '$date' AND user_id = $user_id";
		$time_record_workschedule = $this->db->query($time_record_workschedule_qry);
		if($time_record_workschedule){
			return $time_record_workschedule->result_array();	
		}	
		return false;
	}

	public function call_sp_approvers($class_code, $user_id){		
		$sp_time_calendar = $this->db->query("CALL sp_time_forms_get_approvers('$class_code', ".$user_id.")");

		mysqli_next_result($this->db->conn_id);
		return $sp_time_calendar->result_array();
	}

	public function get_time_forms_approvers($forms_id=0){		
		$time_forms_approvers = $this->db->query("SELECT tfa.user_id, `condition`,  sequence, up.lastname, up.firstname, 
							`position`, tfa.form_status, tfa.form_status_id 
							FROM ww_time_forms_approver tfa
							JOIN ww_users_profile up ON tfa.user_id = up.user_id 
							JOIN ww_users_position upos ON up.position_id = upos.position_id 
							WHERE tfa.forms_id = {$forms_id}");

		return $time_forms_approvers->result_array();
	}

