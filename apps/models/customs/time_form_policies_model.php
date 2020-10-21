

	public function get_form_policies($form_id=0, $user_id=0){
		$application_form_policies = "SELECT tf.*, tfc.*, tfcp.* FROM {$this->db->dbprefix}time_form tf
							LEFT JOIN {$this->db->dbprefix}time_form_class tfc ON tf.form_id = tfc.form_id
							LEFT JOIN {$this->db->dbprefix}time_form_class_policy tfcp ON tfc.class_id = tfcp.class_id
							LEFT JOIN {$this->db->dbprefix}users_profile up ON FIND_IN_SET(up.company_id, tfcp.company_id)
							LEFT JOIN {$this->db->dbprefix}partners prs ON up.user_id = prs.user_id
							LEFT JOIN {$this->db->dbprefix}users usr ON up.user_id = usr.user_id
							WHERE tf.form_id = $form_id
							AND up.user_id = {$user_id} 
							AND IF((tfcp.employment_status_id  != 'ALL') AND (prs.status_id IS NOT NULL AND LENGTH(prs.status_id) > 0), FIND_IN_SET(prs.status_id, tfcp.employment_status_id), 1)
							AND IF((tfcp.employment_type_id  != 'ALL') AND (prs.employment_type_id IS NOT NULL AND LENGTH(prs.employment_type_id) > 0), FIND_IN_SET(prs.employment_type_id, tfcp.employment_type_id), 1)
							AND IF((tfcp.role_id  != 'ALL') AND (usr.role_id IS NOT NULL AND LENGTH(usr.role_id) > 0), FIND_IN_SET(usr.role_id, tfcp.role_id), 1)
							AND IF((tfcp.division_id  != 'ALL') AND (up.division_id IS NOT NULL AND LENGTH(up.division_id) > 0), FIND_IN_SET(up.division_id, tfcp.division_id), 1)
							AND IF((tfcp.department_id  != 'ALL') AND (up.department_id IS NOT NULL AND LENGTH(up.department_id) > 0), FIND_IN_SET(up.department_id, tfcp.department_id), 1)
							AND IF((tfcp.group_id  != 'ALL') AND (up.group_id IS NOT NULL AND LENGTH(up.group_id) > 0), FIND_IN_SET(up.group_id, tfcp.group_id), 1)
							#AND IF((tfcp.project_id IS NOT NULL AND LENGTH(tfcp.project_id) > 0) AND (up.project_id IS NOT NULL AND LENGTH(up.project_id) > 0), FIND_IN_SET(up.project_id, tfcp.project_id), 1)
							";
		$application_form_policies = $this->db->query($application_form_policies);			
		return $application_form_policies->result_array();		 
	}

	public function get_partner_details($user_id=0){		
		$partner_details = $this->db->get_where('partners', array('user_id' => $user_id));
		return $partner_details->row_array();
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

	public function get_allowed_date_number_cutoff($value=0, $date_from='', $company_id=''){	
		$current_day = date('Y-m-d');
    	$this->db->where('deleted',0);
    	$this->db->where("company_id IN ($company_id)", '', false);
        $this->db->where('(\'' . date('Y-m-d',strtotime($current_day)) . '\' BETWEEN date_from AND date_to)', '', false);
        $result_timekeeping_period = $this->db->get('time_period');  

        if ($result_timekeeping_period && $result_timekeeping_period->num_rows() > 0){
		    $row_period = $result_timekeeping_period->row();
		    $limit = $value - 1;
			$result_timekeeping_period_prev_result = $this->db->query("SELECT * FROM {$this->db->dbprefix}time_period WHERE deleted = 0 AND company_id IN ({$company_id}) AND date_from < '{$current_day}' ORDER BY date_from DESC LIMIT {$value} OFFSET {$limit}");		        		

			if ($result_timekeeping_period_prev_result && $result_timekeeping_period_prev_result->num_rows() > 0){
				$result_timekeeping_period_prev_row = $result_timekeeping_period_prev_result->row();
		        return $result_timekeeping_period_prev_row->date_from;
			}else{
				$result_timekeeping_period_prev_result = $this->db->query("SELECT * FROM {$this->db->dbprefix}time_period WHERE deleted = 0 AND company_id IN ({$company_id}) AND date_from < '{$current_day}' ORDER BY date_from DESC ");		        		

				if ($result_timekeeping_period_prev_result && $result_timekeeping_period_prev_result->num_rows() > 0){
					$result_timekeeping_period_prev_row = $result_timekeeping_period_prev_result->row();
			        return $result_timekeeping_period_prev_row->date_from;
				}else{
					return $row_period->date_from;
				}
			}
		}
		return false;
	}

	public function get_allowed_date_within_cutoff($value=0, $date_from='', $company_id=''){
		$current_day = date('Y-m-d');
    	$this->db->where('deleted',0);
    	$this->db->where("company_id IN ($company_id)", '', false);
        $this->db->where('(\'' . date('Y-m-d',strtotime($current_day)) . '\' BETWEEN date_from AND date_to)', '', false);
        $result_timekeeping_period = $this->db->get('time_period');  

        if ($result_timekeeping_period && $result_timekeeping_period->num_rows() > 0){
		    $row_period = $result_timekeeping_period->row();
		    return $row_period->date_from;
		}
		return false;
	}

	public function get_advance_allowed_date_number_cutoff($value=0, $date_from='', $company_id=''){	
		$current_day = date('Y-m-d');
    	$this->db->where('deleted',0);
    	$this->db->where("company_id IN ($company_id)", '', false);
        $this->db->where('(\'' . date('Y-m-d',strtotime($current_day)) . '\' BETWEEN date_from AND date_to)', '', false);
        $result_timekeeping_period = $this->db->get('time_period');  

        if ($result_timekeeping_period && $result_timekeeping_period->num_rows() > 0){
		    $row_period = $result_timekeeping_period->row();
		    $limit = $value - 1;
			$result_timekeeping_period_prev_result = $this->db->query("SELECT * FROM {$this->db->dbprefix}time_period WHERE deleted = 0 AND company_id IN ({$company_id}) AND date_from > '{$current_day}' ORDER BY date_from ASC LIMIT {$value} OFFSET {$limit} ");		        		

			if ($result_timekeeping_period_prev_result && $result_timekeeping_period_prev_result->num_rows() > 0){
				$result_timekeeping_period_prev_row = $result_timekeeping_period_prev_result->row();
		        return $result_timekeeping_period_prev_row->date_to;
			}else{
				$result_timekeeping_period_prev_result = $this->db->query("SELECT * FROM {$this->db->dbprefix}time_period WHERE deleted = 0 AND company_id IN ({$company_id}) AND date_from > '{$current_day}' ORDER BY date_from ASC ");		        		

				if ($result_timekeeping_period_prev_result && $result_timekeeping_period_prev_result->num_rows() > 0){
					$result_timekeeping_period_prev_row = $result_timekeeping_period_prev_result->row();
			        return $result_timekeeping_period_prev_row->date_to;
				}else{
					return $row_period->date_to;
				}
			}
		}
		return false;
	}

	public function get_advance_allowed_date_within_cutoff($value=0, $date_from='', $company_id=''){
		$current_day = date('Y-m-d');
    	$this->db->where('deleted',0);
    	$this->db->where("company_id IN ($company_id)", '', false);
        $this->db->where('(\'' . date('Y-m-d',strtotime($current_day)) . '\' BETWEEN date_from AND date_to)', '', false);
        $result_timekeeping_period = $this->db->get('time_period');  

        if ($result_timekeeping_period && $result_timekeeping_period->num_rows() > 0){
		    $row_period = $result_timekeeping_period->row();
		    return $row_period->date_to;
		}
		return false;
	}

	public function count_approved_forms($form_id, $user_id, $fstart_date='', $fend_date='', $forms_id){
        $qry = "SELECT * FROM time_forms tf
        WHERE tf.deleted = 0 AND tf.form_status_id IN (2,3,4,5,6) AND tf.user_id = '{$user_id}' 
        AND tf.form_id = '{$form_id}' AND
        ( 
            date_from >= '{$fstart_date}' AND date_to <= '{$fend_date}'          
        )";

		$existing_form = $this->db->query($qry);
		return $existing_form->num_rows();
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

	public function get_selected_shift_details($shift_id=''){
		$shift = $this->db->get_where('time_shift', array('deleted' => 0, 'shift_id' => $shift_id));
		return $shift->row_array();
	}	

	public function get_allowed_date_number_cutoff_change_stat($value=0, $date_from='', $company_id=''){	
		$current_day = date('Y-m-d');
    	$this->db->where('deleted',0);
    	$this->db->where("company_id IN ($company_id)", '', false);
        $this->db->where('(\'' . date('Y-m-d',strtotime($date_from)) . '\' BETWEEN date_from AND date_to)', '', false);
        $result_timekeeping_period = $this->db->get('time_period');  

        if ($result_timekeeping_period && $result_timekeeping_period->num_rows() > 0){
		    $row_period = $result_timekeeping_period->row();
		    $limit = $value - 1;
			$result_timekeeping_period_prev_result = $this->db->query("SELECT * FROM {$this->db->dbprefix}time_period WHERE deleted = 0 AND company_id IN ({$company_id}) AND date_from < '{$row_period->date_from}' ORDER BY date_from DESC LIMIT {$value} OFFSET {$limit}");		        		

			if ($result_timekeeping_period_prev_result && $result_timekeeping_period_prev_result->num_rows() > 0){
				$result_timekeeping_period_prev_row = $result_timekeeping_period_prev_result->row();
		        return $result_timekeeping_period_prev_row->date_from;
			}else{
				$result_timekeeping_period_prev_result = $this->db->query("SELECT * FROM {$this->db->dbprefix}time_period WHERE deleted = 0 AND company_id IN ({$company_id}) AND date_from < '{$row_period->date_from}' ORDER BY date_from DESC ");		        		

				if ($result_timekeeping_period_prev_result && $result_timekeeping_period_prev_result->num_rows() > 0){
					$result_timekeeping_period_prev_row = $result_timekeeping_period_prev_result->row();
			        return $result_timekeeping_period_prev_row->date_from;
				}else{
					return $row_period->date_from;
				}
			}
		}
		return false;
	}

	public function get_allowed_date_within_cutoff_change_stat($value=0, $date_from='', $company_id=''){
		$current_day = date('Y-m-d');
    	$this->db->where('deleted',0);
    	$this->db->where("company_id IN ($company_id)", '', false);
        $this->db->where('(\'' . date('Y-m-d',strtotime($date_from)) . '\' BETWEEN date_from AND date_to)', '', false);
        $result_timekeeping_period = $this->db->get('time_period');  

        if ($result_timekeeping_period && $result_timekeeping_period->num_rows() > 0){
		    $row_period = $result_timekeeping_period->row();
		    return $row_period->date_from;
		}
		return false;
	}

	public function get_advance_allowed_date_number_cutoff_change_stat($value=0, $date_from='', $company_id=''){	
		$current_day = date('Y-m-d');
    	$this->db->where('deleted',0);
    	$this->db->where("company_id IN ($company_id)", '', false);
        $this->db->where('(\'' . date('Y-m-d',strtotime($date_from)) . '\' BETWEEN date_from AND date_to)', '', false);
        $result_timekeeping_period = $this->db->get('time_period');  

        if ($result_timekeeping_period && $result_timekeeping_period->num_rows() > 0){
		    $row_period = $result_timekeeping_period->row();
		    $limit = $value - 1;
			$result_timekeeping_period_prev_result = $this->db->query("SELECT * FROM {$this->db->dbprefix}time_period WHERE deleted = 0 AND company_id IN ({$company_id}) AND date_from > '{$row_period->date_from}' ORDER BY date_from ASC LIMIT {$value} OFFSET {$limit}");		        		

			if ($result_timekeeping_period_prev_result && $result_timekeeping_period_prev_result->num_rows() > 0){
				$result_timekeeping_period_prev_row = $result_timekeeping_period_prev_result->row();
		        return $result_timekeeping_period_prev_row->date_to;
			}else{
				$result_timekeeping_period_prev_result = $this->db->query("SELECT * FROM {$this->db->dbprefix}time_period WHERE deleted = 0 AND company_id IN ({$company_id}) AND date_from > '{$row_period->date_from}' ORDER BY date_from ASC ");		        		

				if ($result_timekeeping_period_prev_result && $result_timekeeping_period_prev_result->num_rows() > 0){
					$result_timekeeping_period_prev_row = $result_timekeeping_period_prev_result->row();
			        return $result_timekeeping_period_prev_row->date_to;
				}else{
					return $row_period->date_to;
				}
			}
		}
		return false;
	}

	public function get_advance_allowed_date_within_cutoff_change_stat($value=0, $date_from='', $company_id=''){
		$current_day = date('Y-m-d');
    	$this->db->where('deleted',0);
    	$this->db->where("company_id IN ($company_id)", '', false);
        $this->db->where('(\'' . date('Y-m-d',strtotime($date_from)) . '\' BETWEEN date_from AND date_to)', '', false);
        $result_timekeeping_period = $this->db->get('time_period');  

        if ($result_timekeeping_period && $result_timekeeping_period->num_rows() > 0){
		    $row_period = $result_timekeeping_period->row();
		    return $row_period->date_to;
		}
		return false;
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
	    ->where(array('user_id' => $user_id, 'year' => $year, 'time_form_balance.form_id' => $form_id, 'time_form_balance.deleted' => 0));
		$leave_balances=$this->db->get('');	
		return $leave_balances->row_array();
	}


