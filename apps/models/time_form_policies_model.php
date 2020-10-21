<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class time_form_policies_model extends Record
{

	function __construct()
	{
		parent::__construct();
	}

	public function get_working_days($date_from='', $date_to='', $user_id){
        //START get days count
        $start = new DateTime($date_from);
        $end = new DateTime($date_to);      
        // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);
        $period = iterator_to_array($period);

        // best stored as array, so you can add more than one
        $count = 0;

        if( $date_from != "" || $date_to != "" ){
            
            $rest_days= array();
            foreach($period as $dt) {
                $form_holiday = array();
                $form_holiday = $this->check_if_holiday($dt->format('Y-m-d'));
                $forms_rest_day_count = $this->check_rest_day($user_id, $dt->format('Y-m-d'));

                if(count($form_holiday) > 0 || $forms_rest_day_count > 0){           
                    
                }
                else{
                	$count++;
            	}
            }
        
        }	
        return $count;	
	}

	public function get_form_policies($form_id=0, $user_id=0, $type=''){
		$application_form_policies = "SELECT tf.*, tfc.*, tfcp.* FROM {$this->db->dbprefix}time_form tf
							LEFT JOIN {$this->db->dbprefix}time_form_class tfc ON tf.form_id = tfc.form_id
							LEFT JOIN {$this->db->dbprefix}time_form_class_policy tfcp ON tfc.class_id = tfcp.class_id
							LEFT JOIN {$this->db->dbprefix}users_profile up ON FIND_IN_SET(up.company_id, tfcp.company_id)
							LEFT JOIN {$this->db->dbprefix}partners prs ON up.user_id = prs.user_id
							LEFT JOIN {$this->db->dbprefix}users usr ON up.user_id = usr.user_id
							WHERE tf.form_id = $form_id
							AND up.user_id = {$user_id} 
							AND tf.`deleted` = '0'  
							AND tfcp.`deleted` = '0'
							AND tfc.`deleted` = '0'
							AND IF('{$type}' != '',tfc.class_code LIKE '%{$type}%',1)
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

	public function check_rest_day($user_id=0, $date){	
		// $check_if_rest_day = "SELECT * FROM time_shift_rest_days WHERE user_id = $user_id";
		$check_if_rest_day_qry = "SELECT `date`, 
								IF( UPPER(aux_shift)='RESTDAY' OR UPPER(aux_shift)='OFF', 1, IF( aux_shift_id >  0, 0, IF(UPPER(shift)='RESTDAY' OR UPPER(shift)='OFF', 1, 0)) ) restday
								FROM time_record WHERE `date` = '{$date}'
								AND user_id = {$user_id}
								HAVING restday = 1";
								
		$check_if_rest_day = $this->db->query($check_if_rest_day_qry);
		return $check_if_rest_day->num_rows();	
	}

	public function check_if_rest_day($user_id=0, $date){	
		// $check_if_rest_day = "SELECT * FROM time_shift_rest_days WHERE user_id = $user_id";
		$check_if_rest_day_qry = "SELECT DISTINCT partners.user_id AS user_id,
								  IF( (time_record.aux_shift_id > 0), tr_time_shift.shift_id, IF((time_forms_date.shift_to > 0),cws_time_shift.shift_id,emp_time_shift.shift_id) ) AS shift_id,
								  IF( (tr_calendar.calendar_id > 0), tr_calendar.week_name, IF((emp_calendar.calendar_id > 0),emp_calendar.week_name,cws_calendar.week_name) ) AS rest_day 
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
							      	AND emp_calendar.shift = 'RESTDAY')
							     LEFT JOIN ww_time_shift_weekly_calendar cws_calendar
							      ON ((cws_time_shift.default_calendar = cws_calendar.calendar_id)
							      	AND cws_calendar.shift = 'RESTDAY')
								LEFT JOIN time_record ON (partners.user_id = time_record.user_id
								AND time_record.date = '{$date}')
							     LEFT JOIN ww_time_shift tr_time_shift
							      ON ((time_record.aux_shift_id = tr_time_shift.shift_id))
							     LEFT JOIN ww_time_shift_weekly_calendar tr_calendar
							      ON ((tr_time_shift.default_calendar = tr_calendar.calendar_id)
								AND tr_calendar.shift = 'RESTDAY')
							      )
									WHERE partners.user_id =$user_id";
									
		$check_if_rest_day = $this->db->query($check_if_rest_day_qry);

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
        $this->db->where('(\'' . date('Y-m-d',strtotime($current_day)) . '\' BETWEEN date_from AND cutoff)', '', false);
        $result_timekeeping_period = $this->db->get('time_period');  

        if ($result_timekeeping_period && $result_timekeeping_period->num_rows() > 0){
		    $row_period = $result_timekeeping_period->row();
		    //$limit = $value - 1;
			$result_timekeeping_period_prev_result = $this->db->query("SELECT * FROM {$this->db->dbprefix}time_period WHERE deleted = 0 AND company_id IN ({$company_id}) AND date_from < '{$current_day}' AND DAYOFMONTH(date_from) = 1 GROUP BY cutoff_monthly ORDER BY date_from DESC LIMIT 1 OFFSET {$value}");		        		

			if ($result_timekeeping_period_prev_result && $result_timekeeping_period_prev_result->num_rows() > 0){
				$result_timekeeping_period_prev_row = $result_timekeeping_period_prev_result->row();
		        return $result_timekeeping_period_prev_row->date_from;
			}else{
				$result_timekeeping_period_prev_result = $this->db->query("SELECT * FROM {$this->db->dbprefix}time_period WHERE deleted = 0 AND company_id IN ({$company_id}) AND date_from < '{$current_day}' AND DAYOFMONTH(date_from) = 1  ORDER BY date_from DESC ");		        		

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
        $this->db->where('(\'' . date('Y-m-d',strtotime($current_day)) . '\' BETWEEN date_from AND cutoff)', '', false);
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
        $this->db->where('(\'' . date('Y-m-d',strtotime($current_day)) . '\' BETWEEN date_from AND cutoff)', '', false);
        $result_timekeeping_period = $this->db->get('time_period');  

        if ($result_timekeeping_period && $result_timekeeping_period->num_rows() > 0){
		    $row_period = $result_timekeeping_period->row();
		    $limit = $value - 1;
			$result_timekeeping_period_prev_result = $this->db->query("SELECT * FROM {$this->db->dbprefix}time_period WHERE deleted = 0 AND company_id IN ({$company_id}) AND date_from > '{$current_day}' ORDER BY date_from ASC LIMIT {$value} OFFSET {$limit} ");		        		

			if ($result_timekeeping_period_prev_result && $result_timekeeping_period_prev_result->num_rows() > 0){
				$result_timekeeping_period_prev_row = $result_timekeeping_period_prev_result->row();
		        return $result_timekeeping_period_prev_row->cutoff;
			}else{
				$result_timekeeping_period_prev_result = $this->db->query("SELECT * FROM {$this->db->dbprefix}time_period WHERE deleted = 0 AND company_id IN ({$company_id}) AND date_from > '{$current_day}' ORDER BY date_from ASC ");		        		

				if ($result_timekeeping_period_prev_result && $result_timekeeping_period_prev_result->num_rows() > 0){
					$result_timekeeping_period_prev_row = $result_timekeeping_period_prev_result->row();
			        return $result_timekeeping_period_prev_row->cutoff;
				}else{
					return $row_period->cutoff;
				}
			}
		}
		return false;
	}

	public function get_advance_allowed_date_within_cutoff($value=0, $date_from='', $company_id=''){
		$current_day = date('Y-m-d');
    	$this->db->where('deleted',0);
    	$this->db->where("company_id IN ($company_id)", '', false);
        $this->db->where('(\'' . date('Y-m-d',strtotime($current_day)) . '\' BETWEEN date_from AND cutoff)', '', false);
        $result_timekeeping_period = $this->db->get('time_period');  

        if ($result_timekeeping_period && $result_timekeeping_period->num_rows() > 0){
		    $row_period = $result_timekeeping_period->row();
		    return $row_period->cutoff;
		}
		return false;
	}

	public function count_approved_forms($form_id, $user_id, $fstart_date='', $fend_date='', $forms_id){
        $qry = "SELECT * FROM time_forms tf
        LEFT JOIN ww_time_forms_date tfd ON tf.forms_id = tfd.forms_id
        WHERE tf.deleted = 0 AND tf.form_status_id IN (2,3,4,5,6) AND tf.user_id = '{$user_id}' 
        AND tf.form_id = '{$form_id}' AND
        ( 
            date_from >= '{$fstart_date}' AND date_to <= '{$fend_date}'          
        )";
        if($forms_id > 0){
        	$qry .= " AND tf.forms_id != {$forms_id}";
        }

		$existing_form = $this->db->query($qry);
		return $existing_form->num_rows();
	}

	public function count_filed_approved_forms($form_id, $user_id, $fstart_date='', $fend_date='', $forms_id){
        $qry = "SELECT * FROM time_forms tf
        LEFT JOIN ww_time_forms_date tfd ON tf.forms_id = tfd.forms_id
        WHERE tf.deleted = 0 AND tf.form_status_id IN (2,3,4,5,6) AND tf.user_id = '{$user_id}' 
        AND tf.form_id = '{$form_id}' ";
        if($forms_id > 0){
        	$qry .= " AND tf.forms_id != {$forms_id}";
        }

		$existing_form = $this->db->query($qry);
		return $existing_form->num_rows();
	}

	public function get_shift_details($date='', $user_id=0){
		$shift_details_qry = "SELECT 
							p.user_id AS user_id, tr.date AS DATE, 
							p.shift_id AS shift_id,
							IF(IFNULL(ts_aux.time_start,'')='', ts.time_start, ts_aux.time_start) AS shift_time_start, 
							IF(IFNULL(ts_aux.time_end,'')='', ts.time_end, ts_aux.time_end) AS shift_time_end,
							IF(IFNULL(tr.aux_time_in,0)=0, IFNULL(tr.time_in, '-'), tr.aux_time_in) AS logs_time_in,  
							IF(IFNULL(tr.aux_time_out,0)=0, IFNULL(tr.time_out, '-') , tr.aux_time_out) AS logs_time_out
						FROM partners p
						LEFT JOIN time_shift ts ON p.shift_id = ts.shift_id
						LEFT JOIN time_record tr ON tr.user_id = p.user_id AND tr.`date`='{$date}'
						LEFT JOIN time_shift ts_aux ON IF(tr.aux_shift_id=0,tr.shift_id,tr.aux_shift_id) = ts_aux.shift_id
						WHERE p.user_id = {$user_id};
					";	
							     
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
        $this->db->where('(\'' . date('Y-m-d',strtotime($date_from)) . '\' BETWEEN date_from AND cutoff)', '', false);
        $result_timekeeping_period = $this->db->get('time_period');  

        if ($result_timekeeping_period && $result_timekeeping_period->num_rows() > 0){
		    $row_period = $result_timekeeping_period->row();
		    $limit = $value - 1;
			$result_timekeeping_period_prev_result = $this->db->query("SELECT * FROM {$this->db->dbprefix}time_period WHERE deleted = 0 AND company_id IN ({$company_id}) AND date_from < '{$row_period->date_from}'  GROUP BY cutoff_monthly ORDER BY date_from DESC LIMIT {$value} OFFSET {$limit}");		        		

			if ($result_timekeeping_period_prev_result && $result_timekeeping_period_prev_result->num_rows() > 0){
				$result_timekeeping_period_prev_row = $result_timekeeping_period_prev_result->row();
		        return $result_timekeeping_period_prev_row->date_from;
			}else{
				$result_timekeeping_period_prev_result = $this->db->query("SELECT * FROM {$this->db->dbprefix}time_period WHERE deleted = 0 AND company_id IN ({$company_id}) AND date_from < '{$row_period->date_from}'  GROUP BY cutoff_monthly  ORDER BY date_from DESC ");		        		

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
        $this->db->where('(\'' . date('Y-m-d',strtotime($date_from)) . '\' BETWEEN date_from AND cutoff)', '', false);
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
        $this->db->where('(\'' . date('Y-m-d',strtotime($date_from)) . '\' BETWEEN date_from AND cutoff)', '', false);
        $this->db->order_by('date_from','desc');
        $result_timekeeping_period = $this->db->get('time_period');  

        if ($result_timekeeping_period && $result_timekeeping_period->num_rows() > 0){
		    $row_period = $result_timekeeping_period->row();
		    $limit = $value - 1;
			$result_timekeeping_period_prev_result = $this->db->query("SELECT * FROM {$this->db->dbprefix}time_period WHERE deleted = 0 AND company_id IN ({$company_id}) AND date_from > '{$row_period->date_from}' GROUP BY cutoff_monthly ORDER BY date_from ASC LIMIT {$value} OFFSET {$limit}");		        		

			if ($result_timekeeping_period_prev_result && $result_timekeeping_period_prev_result->num_rows() > 0){
				$result_timekeeping_period_prev_row = $result_timekeeping_period_prev_result->row();
		        return $result_timekeeping_period_prev_row->cutoff;
			}else{
				$result_timekeeping_period_prev_result = $this->db->query("SELECT * FROM {$this->db->dbprefix}time_period WHERE deleted = 0 AND company_id IN ({$company_id}) AND date_from > '{$row_period->date_from}'  GROUP BY cutoff_monthly ORDER BY date_from ASC ");		        		

				if ($result_timekeeping_period_prev_result && $result_timekeeping_period_prev_result->num_rows() > 0){
					$result_timekeeping_period_prev_row = $result_timekeeping_period_prev_result->row();
			        return $result_timekeeping_period_prev_row->cutoff;
				}else{
					return date('Y-m-d', strtotime('+1 day'));
				}
			}
		}
		return false;
	}

	public function get_advance_allowed_date_within_cutoff_change_stat($value=0, $current_day='', $company_id=''){
		// $current_day = date('Y-m-d');
    	// $this->db->where('deleted',0);
    	// $this->db->where("company_id IN ($company_id)", '', false);
     //    $this->db->where('(\'' . date('Y-m-d',strtotime($date_from)) . '\' BETWEEN date_from AND cutoff)', '', false);
     //    $result_timekeeping_period = $this->db->get('time_period');  

		$d_from = date('Y-m-d',strtotime($current_day));
        $qry = "CALL sp_get_last_cutoff_date('".$value."', '".$d_from."', '".$company_id."')";
        $result_timekeeping_period = $this->db->query( $qry );

  //       if ($result_timekeeping_period && $result_timekeeping_period->num_rows() > 0){
		//     $row_period = $result_timekeeping_period->row();
		    // return $row_period->cutoff;
		// }
		// return false;
        $row_period = array('date_from' => '', 'date_to' => '');
		if($result_timekeeping_period && $result_timekeeping_period->num_rows() > 0)
		{			
			$row_period = $result_timekeeping_period->row_array();
		    
		}
		else{
			$row_period = NULL;
		}
		mysqli_next_result($this->db->conn_id);
		return $row_period;
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

	public function get_filed_forms($user_id=0, $form_id=0, $forms_id=0){
		$check_filed_forms = "SELECT SUM(tfd.day) AS total FROM {$this->db->dbprefix}time_forms tf
		LEFT JOIN {$this->db->dbprefix}time_forms_date tfd ON tf.forms_id = tfd.forms_id
			WHERE tf.user_id = {$user_id} AND tf.form_id = {$form_id} 
			AND tf.form_status_id IN (6) 
			AND (YEAR(tf.date_from) = YEAR(CURDATE()) AND YEAR(tf.date_to) = YEAR(CURDATE())) ";

		if($forms_id > 0){
			$check_filed_forms .= " AND tf.forms_id != {$forms_id} ";
		}

		$check_filed_form = $this->db->query($check_filed_forms)->row_array();
		return $check_filed_form['total'];		
	}


}