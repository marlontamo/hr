<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class time_form_policies {
	function __construct()
	{
    	$this->CI =& get_instance();
		$this->CI->load->model('time_form_policies_model', '', TRUE);
        $this->CI->load->model('form_application_model', 'formapp', TRUE);
	}

	function validate_form_filing($form_id=0, $form_code='', $user_id=0, $date_from='', $date_to='', $uploads=array(), $forms_id=0, $date_time_from='', $date_time_to='', $date_time='', $shift_to='', $scheduled='YES', $total_duration=0, $addl_type=''){
		$form_policy_error = array();
        $form_policy_error['error'] = array();
        $form_policy_error['warning'] = array();
		$form_policy_error['hr_validate'] =  false; 
        $current_day = date('Y-m-d');
		$form_policies = $this->CI->time_form_policies_model->get_form_policies($form_id, $user_id);
         
		foreach ($form_policies as $form_policy){
			switch(strtoupper($form_policy['class_code'])) {
				case $form_code.'-FILING-TENURE':
				$filing_tenure = $this->_check_filing_tenure($form_policy['class_value'], $user_id);
				if($filing_tenure == 'error'){
                    if($form_policy['severity'] == 'Warning'){
                        $form_policy_error['warning'][] = "You are not yet allowed to file this form.";
                    }else{
                        $form_policy_error['error'][] = "You are not yet allowed to file this form.";
                    }
				}
				break;
				case $form_code.'-FILING-MAXIMUM-DAYS':
				$filing_maximum_days = $this->_check_filing_maximum_days($form_policy['class_value'], $date_from, $date_to, $user_id);
				if($filing_maximum_days == 'error'){
                    if($form_policy['severity'] == 'Warning'){
                        $form_policy_error['warning'][] = "You exceeded the maximum no of days to apply.";
                    }else{
                        $form_policy_error['error'][] = "You exceeded the maximum no of days to apply.";
                    }
				}
				break;
				case $form_code.'-LATE-FILING-CUTOFF':
                if(strtotime($date_from) < strtotime($current_day)){
    				$late_filing_cutoff = $this->_check_late_filing_cutoff($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
    				if($late_filing_cutoff == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "You exceeded the maximum allowable days to file as late filing.";
                        }else{
                            $form_policy_error['error'][] = "You exceeded the maximum allowable days to file as late filing.";
                        }
    				}elseif($late_filing_cutoff == 'invalid'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }else{
                            $form_policy_error['error'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }
    				}
                }
				break;
				case $form_code.'-LATE-FILING-DAYS':
                if(strtotime($date_from) < strtotime($current_day)){
    				$late_filing_days= $this->_check_late_filing_days($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id'],$user_id);
    				if($late_filing_days == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "You exceeded the maximum allowable days to file as late filing.";
                        }else{
                            $form_policy_error['error'][] = "You exceeded the maximum allowable days to file as late filing.";
                        }
    				}
                }
				break;
				case $form_code.'-LATE-FILING-NOT-ALLOWED':
                if(strtotime($date_from) < strtotime($current_day)){
    				$late_filing_not_allowed = $this->_check_late_filing_not_allowed($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
    				if($late_filing_not_allowed == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Late filing is not allowed.";
                        }else{
                            $form_policy_error['error'][] = "Late filing is not allowed.";
                        }
    				}elseif($late_filing_not_allowed == 'invalid'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }else{
                            $form_policy_error['error'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }
    				}
                }
				break;
				case $form_code.'-LATE-FILING-WITHIN-CUTOFF':
                if(strtotime($date_from) < strtotime($current_day)){
    				$late_filing_within_cutoff = $this->_check_late_filing_within_cutoff($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
    				if($late_filing_within_cutoff == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Late filing within cutoff is not allowed.";
                        }else{
                            $form_policy_error['error'][] = "Late filing within cutoff is not allowed.";
                        }
    				}elseif($late_filing_within_cutoff == 'invalid'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }else{
                            $form_policy_error['error'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }
    				}
                }
				break;
				case $form_code.'-ADVANCE-FILING-CUTOFF':
                if(strtotime($date_to) > strtotime($current_day)){
    				$advance_filing_cutoff = $this->_check_advance_filing_cutoff($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
    				if($advance_filing_cutoff == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "You exceeded the maximum allowable days to file as advance filing.";
                        }else{
                            $form_policy_error['error'][] = "You exceeded the maximum allowable days to file as advance filing.";
                        }
    				}elseif($advance_filing_cutoff == 'invalid'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }else{
                            $form_policy_error['error'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }
    				}
                }
				break;
				case $form_code.'-ADVANCE-FILING-DAYS':
                if(strtotime($date_to) > strtotime($current_day)){
    				$advance_filing_days= $this->_check_advance_filing_days($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id'],$user_id);
    				if($advance_filing_days == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "You exceeded the maximum allowable days to file as advance filing.";
                        }else{
                            $form_policy_error['error'][] = "You exceeded the maximum allowable days to file as advance filing.";
                        }
    				}
                }
				break;
				case $form_code.'-ADVANCE-FILING-NOT-ALLOWED':
                if(strtotime($date_to) > strtotime($current_day)){
    				$advance_filing_not_allowed = $this->_check_advance_filing_not_allowed($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
    				if($advance_filing_not_allowed == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Advance filing is not allowed.";
                        }else{
                            $form_policy_error['error'][] = "Advance filing is not allowed.";
                        }
    				}elseif($advance_filing_not_allowed == 'invalid'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }else{
                            $form_policy_error['error'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }
    				}
                }
				break;
				case $form_code.'-ADVANCE-FILING-WITHIN-CUTOFF':
                if(strtotime($date_to) > strtotime($current_day)){
    				$advance_filing_cutoff = $this->_check_advance_filing_within_cutoff($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
    				if($advance_filing_cutoff == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Advance filing within cutoff is not allowed.";
                        }else{
                            $form_policy_error['error'][] = "Advance filing within cutoff is not allowed.";
                        }
    				}elseif($advance_filing_cutoff == 'invalid'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }else{
                            $form_policy_error['error'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }
    				}
                }
				break;
				case $form_code.'-REQUIRE-ATTACHMENT-DAYS':
				$advance_filing_days= $this->_check_if_require_attachment($form_policy['class_value'], $date_from, $date_to, $uploads, $user_id);
				if($advance_filing_days == 'error'){
                    if($form_policy['severity'] == 'Warning'){
                        $form_policy_error['warning'][] = "Supporting file is required."; 
                    }else{
                        $form_policy_error['error'][] = "Supporting file is required."; 
                    }
				}
				break;
				case $form_code.'-HR-VALIDATION-DAYS':
				$advance_filing_days= $this->_check_if_for_hr_validation($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id'], $user_id);
				if($advance_filing_days == 'error'){
					$form_policy_error['hr_validate'] =  true; 
				}
				break;
				case $form_code.'-MAXIMUM-FILING-MONTH':
				$max_file_month = $this->_check_max_file_month($form_policy['class_value'], $date_from, $date_to, $form_id, $forms_id, $user_id);
				if($max_file_month == 'error'){
                    if($form_policy['severity'] == 'Warning'){
                        $form_policy_error['warning'][] = "Your application exceeded the maximum number to apply"; 
                    }else{
                        $form_policy_error['error'][] = "Your application exceeded the maximum number to apply"; 
                    }
				}
				break;
				case $form_code.'-MINIMUM-FILING-MINUTES':
                // echo "<pre>";
                // var_dump( in_array($form_code, array('ADDL')) );
                // echo "<br>";
                // var_dump( !in_array($addl_type, array('Use')) );
                if( ( !in_array($form_code, array('ADDL')) ) ||
                    (( in_array($form_code, array('ADDL')) ) && ( !in_array($addl_type, array('Use')) )) ){
    				// echo "here po";
                    $min_file_month = $this->_check_min_minutes_file($form_policy['class_value'], $date_time_from, $date_time_to, $date_time, $form_id, $forms_id, $user_id);
    				if($min_file_month == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Minimum minutes to apply should be ".$form_policy['class_value']." minutes"; 
                        }else{
                            $form_policy_error['error'][] = "Minimum minutes to apply should be ".$form_policy['class_value']." minutes"; 
                        }
    				}
                }
				break;
				case $form_code.'-MAXIMUM-FILING-MINUTES':
				$max_file_month = $this->_check_max_minutes_file($form_policy['class_value'], $date_time_from, $date_time_to, $date_time, $form_id, $forms_id, $user_id);
				if($max_file_month == 'error'){
                    if($form_policy['severity'] == 'Warning'){
                        $form_policy_error['warning'][] = "Maximum minutes to apply should be ".$form_policy['class_value']." minutes"; 
                    }else{
                        $form_policy_error['error'][] = "Maximum minutes to apply should be ".$form_policy['class_value']." minutes"; 
                    }
				}
				break;
				case $form_code.'-WORKING-DAYS':
				$working_days_only = $this->_check_working_days($form_policy['class_value'], $date_from, $date_to, $user_id);
				if($working_days_only == 'error'){
                    if($form_policy['severity'] == 'Warning'){
                        $form_policy_error['warning'][] = "You are not allowed to file this form on this date."; 
                    }else{
                        $form_policy_error['error'][] = "You are not allowed to file this form on this date."; 
                    }
				}
				break;
				case $form_code.'-FILING-WITHIN-SHIFT':
                $form_holiday = $this->CI->time_form_policies_model->check_if_holiday(date('Y-m-d', strtotime($date_time_from)));
                if(empty($form_holiday)){
                    $within_shift_only = $this->_check_within_shift($form_policy['class_value'], $date_time_from, $date_time_to, $date_time, $form_id, $forms_id, $user_id);
                }
                else{
                    $within_shift_only = '';
                }
				if($within_shift_only == 'error'){
					if(strtolower($form_policy['class_value']) == 'yes'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Selected time should be within your shift."; 
                        }else{
                            $form_policy_error['error'][] = "Selected time should be within your shift."; 
                        }
					}else{
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Selected time should not be within your shift."; 
                        }else{
                            $form_policy_error['error'][] = "Selected time should not be within your shift."; 
                        }
					}
				}
				break;
                case $form_code.'-MAX-START-SHIFT':
                $max_shift_start = $this->_check_max_shift_start($form_policy['class_value'], $shift_to);
                if($max_shift_start == 'error'){
                    if($form_policy['severity'] == 'Warning'){
                        $form_policy_error['warning'][] = " CWS filing is only up to ".date('h a', strtotime($form_policy['class_value']))."."; 
                    }else{
                        $form_policy_error['error'][] = " CWS filing is only up to ".date('h a', strtotime($form_policy['class_value']))."."; 
                    }
                }
                break;
                case $form_code.'-1-DAY-FILING-PRIOR':
                if($scheduled == 'YES'){
                    // if(strtotime($date_from) >= strtotime($current_day)){
                        $one_day_prior = $this->_check_one_day_prior($form_policy['class_value'], $date_from, $date_to, $user_id);
                        if($one_day_prior == 'error'){
                            if($form_policy['severity'] == 'Warning'){
                                $form_policy_error['warning'][] = "Form must be filed ".$form_policy['class_value']." day/s prior."; 
                            }else{
                                $form_policy_error['error'][] = "Form must be filed ".$form_policy['class_value']." day/s prior."; 
                            }
                        }
                    // }
                }
                break;
                case $form_code.'-MORE-THAN-A-DAY-FILING-PRIOR':
                if($scheduled == 'YES'){
                    // if(strtotime($date_from) >= strtotime($current_day)){
                        $more_than_a_day_prior = $this->_check_more_than_a_day_prior($form_policy['class_value'], $date_from, $date_to, $user_id);
                        if($more_than_a_day_prior == 'error'){
                            if($form_policy['severity'] == 'Warning'){
                                $form_policy_error['warning'][] = "Form must be filed ".$form_policy['class_value']." day/s prior."; 
                            }else{
                                $form_policy_error['error'][] = "Form must be filed ".$form_policy['class_value']." day/s prior."; 
                            }
                        }
                    // }
                }
                break;
                case $form_code.'-UNSCHEDULED-LATE-FILING-HOURS':
                if($scheduled == 'NO'){
                    if(strtotime($date_from) < strtotime($current_day)){
                        $unscheduled_late_filing = $this->_check_unscheduled_late_filing($form_policy['class_value'], $date_from, $date_to, $user_id);
                        if($unscheduled_late_filing == 'error'){
                            if($form_policy['severity'] == 'Warning'){
                                $form_policy_error['warning'][] = "Form must be filed ".$form_policy['class_value']." hours upon return to work."; 
                            }else{
                                $form_policy_error['error'][] = "Form must be filed ".$form_policy['class_value']." hours upon return to work."; 
                            }
                        }
                    }
                }
                break;
                case $form_code.'-ALLOW-FILING-NO-CREDIT':
                $credits = $this->_check_credits($form_policy['class_value'], $date_from, $date_to, $user_id, $form_id);
                if($credits === 'error'){
                    if($form_policy['severity'] == 'Warning'){
                        $form_policy_error['warning'][] = "You do not have sufficient credit/s to file this form."; 
                    }else{
                        $form_policy_error['error'][] = "You do not have sufficient credit/s to file this form."; 
                    }
                }
                break;
                case $form_code.'-FILING-PRIOR':
                        $filing_prior = $this->_check_filing_prior($form_policy['class_value'], $date_from, $date_to, $user_id);
                        if($filing_prior == 'error'){
                            if($form_policy['severity'] == 'Warning'){
                                $form_policy_error['warning'][] = "Form must be filed ".$form_policy['class_value']." day/s prior."; 
                            }else{
                                $form_policy_error['error'][] = "Form must be filed ".$form_policy['class_value']." day/s prior."; 
                            }
                        }
                break;
                case $form_code.'-ALLOWABLE-DAYS-YEARLY':
                        $max_days_yearly = $this->_check_filed_this_year($form_policy['class_value'], $date_from, $date_to, $user_id, $form_id, $forms_id, $total_duration);
                        if($max_days_yearly == 'error'){
                            if($form_policy['severity'] == 'Warning'){
                                $form_policy_error['warning'][] = "You exceed maximum allowable days to file this year."; 
                            }else{
                                $form_policy_error['error'][] = "You exceed maximum allowable days to file this year."; 
                            }
                        }
                break;
                case $form_code.'-FILING-PRIOR-MONTHS':
                        $filing_prior = $this->_check_filing_prior_months($form_policy['class_value'], $date_from, $date_to, $user_id);
                        if($filing_prior == 'error'){
                            if($form_policy['severity'] == 'Warning'){
                                $form_policy_error['warning'][] = "Form must be filed ".$form_policy['class_value']." month/s prior."; 
                            }else{
                                $form_policy_error['error'][] = "Form must be filed ".$form_policy['class_value']." month/s prior."; 
                            }
                        }
                break;
                case $form_code.'-MAXIMUM-FILING-ALL-IN':
                $max_file_month = $this->_check_max_file_allin($form_policy['class_value'], $date_from, $date_to, $form_id, $forms_id, $user_id);
                if($max_file_month == 'error'){
                    if($form_policy['severity'] == 'Warning'){
                        $form_policy_error['warning'][] = "Your application exceeded the maximum number to apply"; 
                    }else{
                        $form_policy_error['error'][] = "Your application exceeded the maximum number to apply"; 
                    }
                }
                break;
			}
		}

		return $form_policy_error;
	}


    function _check_filing_tenure($value='', $user_id=0){
        $present_date = date('Y-m-d');
        $partner_details = $this->CI->time_form_policies_model->get_partner_details($user_id);
        $date1 = $partner_details['effectivity_date'];
        $date2 = $present_date;

        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $months_stayed = (($year2 - $year1) * 12) + ($month2 - $month1);

        if($months_stayed < $value){
            return 'error';
        }
        return false;
    }

    function _check_filing_maximum_days($value='', $date_from='', $date_to='', $user_id=0){
        //START get days count
        $start = new DateTime($date_from);
        $end = new DateTime($date_to);      
            // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        $interval = $end->diff($start);
        $days = $interval->days;

            // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);
        $period = iterator_to_array($period);
        
        $rest_days= array();
        // foreach($period as $dt) {
        //     $forms_rest_day = $this->CI->time_form_policies_model->check_if_rest_day($user_id, $dt->format('Y-m-d'));
        //     foreach($forms_rest_day as $forms_rest){
        //         $rest_days[] = $forms_rest['rest_day'];
        //     }
        // }

        foreach($period as $dt) {
            $form_holiday = array();
            $form_holiday = $this->CI->time_form_policies_model->check_if_holiday($dt->format('Y-m-d'));
            $forms_rest_day_count = $this->CI->time_form_policies_model->check_rest_day($user_id, $dt->format('Y-m-d'));

            if(count($form_holiday) > 0 || $forms_rest_day_count > 0){           
                $days--;
            }
        }

        if($days > $value){
            return 'error';
        }
        return false;
    }

    function _check_late_filing_cutoff($value='', $date_from='', $date_to='', $company_id=''){
        $allowed_date = $this->CI->time_form_policies_model->get_allowed_date_number_cutoff($value, $date_from, $company_id);

        if(!$allowed_date){
            return "invalid";
        }else{
            if(strtotime($date_from) < strtotime($allowed_date)){
                return 'error';
            }
        }
        return false;
    }

    function _check_late_filing_days($value='', $date_from='', $date_to='', $company_id='', $user_id= ''){   
        $current_day = date('Y-m-d');
        $no_working_days = $this->CI->time_form_policies_model->get_working_days($date_from, $current_day, $user_id);

        if($no_working_days > $value){
            return 'error';
        }

        return false;        
    }

    function _check_late_filing_not_allowed($value='', $date_from='', $date_to='', $company_id=''){     
        $current_day = date('Y-m-d');
        if(strtotime($date_from) < strtotime($current_day) && strtolower($value) == 'yes'){
            return 'error';
        }
        return false;
    }

    function _check_late_filing_within_cutoff($value='', $date_from='', $date_to='', $company_id=''){
        $allowed_date = $this->CI->time_form_policies_model->get_allowed_date_within_cutoff($value, $date_from, $company_id);

        if(!$allowed_date){
            return "invalid";
        }else{
            if(strtotime($date_from) < strtotime($allowed_date) && strtolower($value) == 'yes'){
                return 'error';
            }
        }
        return false;
    }

    function _check_advance_filing_cutoff($value='', $date_from='', $date_to='', $company_id=''){
        $allowed_date = $this->CI->time_form_policies_model->get_advance_allowed_date_number_cutoff($value, $date_from, $company_id);

        if(!$allowed_date){
            return "invalid";
        }else{
            if(strtotime($date_to) > strtotime($allowed_date)){
                return 'error';
            }
        }
        return false;
    }

    function _check_advance_filing_days($value='', $date_from='', $date_to='', $company_id='', $user_id=''){   
        $current_day = date('Y-m-d');
        $no_working_days = $this->CI->time_form_policies_model->get_working_days($date_from, $current_day, $user_id);

        if($no_working_days > $value){
            return 'error';
        }

        return false;            
    }

    function _check_advance_filing_not_allowed($value='', $date_from='', $date_to='', $company_id=''){     
        $current_day = date('Y-m-d');
        if(strtotime($date_from) > strtotime($current_day) && strtolower($value) == 'yes'){
            return 'error';
        }
        return false;
    }

    function _check_advance_filing_within_cutoff($value='', $date_from='', $date_to='', $company_id=''){
        $allowed_date = $this->CI->time_form_policies_model->get_advance_allowed_date_within_cutoff($value, $date_from, $company_id);

        if(!$allowed_date){
            return "invalid";
        }else{
            if(strtotime($date_to) > strtotime($allowed_date) && strtolower($value) == 'yes'){
                return 'error';
            }
        }
        return false;
    }

    function _check_if_require_attachment($value='', $date_from='', $date_to='', $uploads=array(), $user_id=0){
        //START get days count
        $start = new DateTime($date_from);
        $end = new DateTime($date_to);      
            // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        $interval = $end->diff($start);
        $days = $interval->days;

            // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);
        $period = iterator_to_array($period);
           
        $rest_days= array();
        // foreach($period as $dt) {
        //     $forms_rest_day = $this->CI->time_form_policies_model->check_if_rest_day($user_id, $dt->format('Y-m-d'));
        //     foreach($forms_rest_day as $forms_rest){
        //         $rest_days[] = $forms_rest['rest_day'];
        //     }
        // }

        foreach($period as $dt) {
            $form_holiday = array();
            $form_holiday = $this->CI->time_form_policies_model->check_if_holiday($dt->format('Y-m-d'));
            $forms_rest_day_count = $this->CI->time_form_policies_model->check_rest_day($user_id, $dt->format('Y-m-d'));

            if(count($form_holiday) > 0 || $forms_rest_day_count > 0){           
                $days--;
            }
        }

        $count_uploads = count($uploads);
        if($count_uploads ==  1){

            if (is_array($uploads)){
                $count_uploads = $uploads[0] == "" ? 0 : 1;
            }else{
                $count_uploads = $uploads == "" ? 0 : 1;
            }
        }

        if($days > $value && $count_uploads == 0){
            return 'error';
        }
        return false;
    }

    function _check_if_for_hr_validation($value='', $date_from='', $date_to='', $company_id='', $user_id=0){
        //START get days count
        $start = new DateTime($date_from);
        $end = new DateTime($date_to);      
            // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        $interval = $end->diff($start);
        $days = $interval->days;

            // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);
        $period = iterator_to_array($period);
           
        $rest_days= array();
        // foreach($period as $dt) {
        //     $forms_rest_day = $this->CI->time_form_policies_model->check_if_rest_day($user_id, $dt->format('Y-m-d'));
        //     foreach($forms_rest_day as $forms_rest){
        //         $rest_days[] = $forms_rest['rest_day'];
        //     }
        // }

        foreach($period as $dt) {
            $form_holiday = array();
            $form_holiday = $this->CI->time_form_policies_model->check_if_holiday($dt->format('Y-m-d'));
            $forms_rest_day_count = $this->CI->time_form_policies_model->check_rest_day($user_id, $dt->format('Y-m-d'));

            if(count($form_holiday) > 0 || $forms_rest_day_count > 0){           
                $days--;
            }
        }

        if($days > $value){
            return 'error';
        }
        return false;
    }

    function _check_max_file_month($value='', $date_from='', $date_to='', $form_id, $forms_id='', $user_id=0){
        $filed_forms_count = 0;

        $fmonth = date('m',strtotime($date_from));
        $fyear = date('Y',strtotime($date_from));
        $flast_day = date('t',strtotime($date_from));

        $fstart_date = date('Y-m-d',strtotime($fyear.'-'.$fmonth.'-1'));
        $fend_date = date('Y-m-d',strtotime($fyear.'-'.$fmonth.'-'.$flast_day));

        $filed_forms_count = $this->CI->time_form_policies_model->count_approved_forms($form_id, $user_id, $fstart_date, $fend_date, $forms_id);

        // if( $date_from <= $date_to ){

        //     while( $date_from <= $date_to ){

        //         $date_from = date('Y-m-d',strtotime('+1 day',strtotime($date_from)));
        //         $filed_forms_count++;

        //     }

        // }
        //START get days count
        $start = new DateTime($date_from);
        $end = new DateTime($date_to);      
            // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        $interval = $end->diff($start);

        $filed_forms_count = $filed_forms_count + $interval->d; 

            // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);
        $period = iterator_to_array($period);
           
        $rest_days= array();
        // foreach($period as $dt) {
        //     $forms_rest_day = $this->CI->time_form_policies_model->check_if_rest_day($user_id, $dt->format('Y-m-d'));
        //     foreach($forms_rest_day as $forms_rest){
        //         $rest_days[] = $forms_rest['rest_day'];
        //     }
        // }

        foreach($period as $dt) {
            $form_holiday = array();
            $form_holiday = $this->CI->time_form_policies_model->check_if_holiday($dt->format('Y-m-d'));
            $forms_rest_day_count = $this->CI->time_form_policies_model->check_rest_day($user_id, $dt->format('Y-m-d'));

            if(count($form_holiday) > 0 || $forms_rest_day_count > 0){           
                $filed_forms_count--;
            }
        }
        
        if($filed_forms_count > $value){
            return 'error';
        }
        
        return false;
    }

    function _check_max_file_allin($value='', $date_from='', $date_to='', $form_id, $forms_id='', $user_id=0){
        $filed_forms_count = 0;

        $fmonth = date('m',strtotime($date_from));
        $fyear = date('Y',strtotime($date_from));
        $flast_day = date('t',strtotime($date_from));

        $fstart_date = date('Y-m-d',strtotime($fyear.'-'.$fmonth.'-1'));
        $fend_date = date('Y-m-d',strtotime($fyear.'-'.$fmonth.'-'.$flast_day));

        $filed_forms_count = $this->CI->time_form_policies_model->count_filed_approved_forms($form_id, $user_id, $fstart_date, $fend_date, $forms_id);

        // if( $date_from <= $date_to ){

        //     while( $date_from <= $date_to ){

        //         $date_from = date('Y-m-d',strtotime('+1 day',strtotime($date_from)));
        //         $filed_forms_count++;

        //     }

        // }
        //START get days count
        $start = new DateTime($date_from);
        $end = new DateTime($date_to);      
            // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        $interval = $end->diff($start);
        $filed_forms_count = $filed_forms_count + $interval->days;

            // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);
        $period = iterator_to_array($period);
           
        $rest_days= array();
        // foreach($period as $dt) {
        //     $forms_rest_day = $this->CI->time_form_policies_model->check_if_rest_day($user_id, $dt->format('Y-m-d'));
        //     foreach($forms_rest_day as $forms_rest){
        //         $rest_days[] = $forms_rest['rest_day'];
        //     }
        // }

        foreach($period as $dt) {
            $form_holiday = array();
            $form_holiday = $this->CI->time_form_policies_model->check_if_holiday($dt->format('Y-m-d'));
            $forms_rest_day_count = $this->CI->time_form_policies_model->check_rest_day($user_id, $dt->format('Y-m-d'));

            if(count($form_holiday) > 0 || $forms_rest_day_count > 0){           
                $filed_forms_count--;
            }
        }
        if($filed_forms_count > $value){
            return 'error';
        }
        
        return false;
    }

    function _check_min_minutes_file($value='', $date_time_from='', $date_time_to='', $date_time='', $form_id=0, $forms_id=0, $user_id=0){
        if($date_time != ''){//UT, ET
            $shift_schedule = $this->CI->time_form_policies_model->get_shift_details(date('Y-m-d', strtotime($date_time)), $user_id);
            $shift_schedule_start = strtotime($shift_schedule['shift_time_start']);
            $shift_schedule_end = strtotime($shift_schedule['shift_time_end']);
            if($form_id == 10){ //UT
                $datetime2 = $shift_schedule_end < $shift_schedule_start ? strtotime(date('Y-m-d', strtotime($date_time. "+1 days"))." ".$shift_schedule['shift_time_end']) : strtotime(date('Y-m-d', strtotime($date_time))." ".$shift_schedule['shift_time_end']);
            }else{ //ET
                $datetime2 = strtotime(date('Y-m-d', strtotime($date_time))." ".$shift_schedule['shift_time_start']);
            }
            $datetime1 = strtotime($date_time);    
            $minutes = ($datetime2 - $datetime1)/60;
        }else{//OT,OBT, DTRP
            $datetime2 = strtotime($date_time_to);
            $datetime1 = strtotime($date_time_from);        
            $minutes = ($datetime2 - $datetime1)/60;
        }

        if($minutes < $value){
            return 'error';
        }
        return false;
    }

    function _check_max_minutes_file($value='', $date_time_from='', $date_time_to='', $date_time='', $form_id=0, $forms_id=0, $user_id=0){
        if($date_time != ''){//UT, ET
            $shift_schedule = $this->CI->time_form_policies_model->get_shift_details(date('Y-m-d', strtotime($date_time)), $user_id);
            $shift_schedule_start = strtotime($shift_schedule['shift_time_start']);
            $shift_schedule_end = strtotime($shift_schedule['shift_time_end']);
            if($form_id == 10){ //UT
                $datetime2 = $shift_schedule_end < $shift_schedule_start ? strtotime(date('Y-m-d', strtotime($date_time. "+1 days"))." ".$shift_schedule['shift_time_end']) : strtotime(date('Y-m-d', strtotime($date_time))." ".$shift_schedule['shift_time_end']);
            }else{ //ET
                $datetime2 = strtotime(date('Y-m-d', strtotime($date_time))." ".$shift_schedule['shift_time_start']);
            }
            $datetime1 = strtotime($date_time);   
            $minutes = ($datetime2 - $datetime1)/60;
        }else{//OT,OBT, DTRP
            $datetime2 = strtotime($date_time_to);
            $datetime1 = strtotime($date_time_from);        
            $minutes = ($datetime2 - $datetime1)/60;
        }

        if($minutes > $value){
            return 'error';
        }
        return false;
    }

    function _check_working_days($value='', $date_from='', $date_to='', $user_id=0){
        //START get days count
        $start = new DateTime($date_from);
        $end = new DateTime($date_to);      
            // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        $interval = $end->diff($start);
        $days = $interval->days;
        $not_allowed = 0;

            // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);
        $period = iterator_to_array($period);
           
        $rest_days= array();
        // foreach($period as $dt) {
        //     $forms_rest_day = $this->CI->time_form_policies_model->check_if_rest_day($user_id, $dt->format('Y-m-d'));
        //     foreach($forms_rest_day as $forms_rest){
        //         $rest_days[] = $forms_rest['rest_day'];
        //     }
        // }

        foreach($period as $dt) {
            $form_holiday = array();
            $form_holiday = $this->CI->time_form_policies_model->check_if_holiday($dt->format('Y-m-d'));
            $forms_rest_day_count = $this->CI->time_form_policies_model->check_rest_day($user_id, $dt->format('Y-m-d'));

            if(count($form_holiday) > 0 || $forms_rest_day_count > 0){           
                $not_allowed++;
            }
        }

        if(strtolower($value) == 'yes' && $not_allowed > 0){
            return 'error';
        }
        return false;
    }

    function _check_within_shift($value='', $date_time_from='', $date_time_to='', $date_time='', $form_id=0, $forms_id=0, $user_id=0){
        $within_shift_yes = 0;
        $within_shift_no = 0;

        if($date_time != ''){ //UT, ET
            $shift_schedule = $this->CI->time_form_policies_model->get_shift_details(date('Y-m-d', strtotime($date_time)), $user_id);
            $shift_schedule_start = strtotime($shift_schedule['shift_time_start']);
            $shift_schedule_end = strtotime($shift_schedule['shift_time_end']);
            
            $datetime_end = $shift_schedule_end < $shift_schedule_start ? strtotime(date('Y-m-d', strtotime($date_time. "+1 days"))." ".$shift_schedule['shift_time_end']) : strtotime(date('Y-m-d', strtotime($date_time))." ".$shift_schedule['shift_time_end']);        
            $datetime_start = strtotime(date('Y-m-d', strtotime($date_time))." ".$shift_schedule['shift_time_start']);
            $date_time = strtotime($date_time);
            if ( $date_time >= $datetime_start && $date_time <= $datetime_end ){
                $within_shift_yes = 1;
            }else{
                $within_shift_no = 1;
            }
        }else{ //OT,OBT, DTRP
            $shift_schedule = $this->CI->time_form_policies_model->get_shift_details(date('Y-m-d', strtotime($date_time_from)), $user_id);
            $shift_schedule_start = strtotime($shift_schedule['shift_time_start']);
            $shift_schedule_end = strtotime($shift_schedule['shift_time_end']);
            
            $datetime_end = $shift_schedule_end < $shift_schedule_start ? strtotime(date('Y-m-d', strtotime($date_time_from. "+1 days"))." ".$shift_schedule['shift_time_end']) : strtotime(date('Y-m-d', strtotime($date_time_from))." ".$shift_schedule['shift_time_end']);        
            $datetime_start = strtotime(date('Y-m-d', strtotime($date_time_from))." ".$shift_schedule['shift_time_start']);
            $date_time_to = strtotime($date_time_to);
            $date_time_from = strtotime($date_time_from);   
            if( ($date_time_from >= $datetime_start AND $date_time_from < $datetime_end) OR
                ($date_time_to > $datetime_start AND $date_time_to <= $datetime_end) ){
                    $within_shift_yes = 1;
            }else{
                $within_shift_no = 1;
            }
        }

        if(strtolower($value) == 'yes' && $within_shift_yes == 0){
            return 'error';
        }elseif(strtolower($value) == 'no' && $within_shift_no == 0){
            return 'error';
        }
        return false;
    }

    function _check_max_shift_start($value='', $shift_to=''){
        $shift_schedule = $this->CI->time_form_policies_model->get_selected_shift_details($shift_to);

        if(strtotime($shift_schedule['time_start']) > strtotime($value)){
            return 'error';
        }
        return false;
    }

    function _check_one_day_prior($value='', $date_from='', $date_to='', $user_id=0){
        //START get days count
        $start = new DateTime($date_from);
        $end = new DateTime($date_to);      
            // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        $interval = $end->diff($start);
        $days = $interval->days;

        //START get days prior count
        $current_day = date('Y-m-d');
        $start_prior = new DateTime($current_day);
        $end_prior = new DateTime($date_from);      
            // otherwise the  end date is excluded (bug?)
        // $end_prior->modify('+1 day');

        $interval_prior = $end_prior->diff($start_prior);
        $days_prior = $interval_prior->days;
        
        // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);
        $period = iterator_to_array($period);

        $rest_days= array();
        // foreach($period as $dt) {
        //     $forms_rest_day = $this->CI->time_form_policies_model->check_if_rest_day($user_id, $dt->format('Y-m-d'));
        //     foreach($forms_rest_day as $forms_rest){
        //         $rest_days[] = $forms_rest['rest_day'];
        //     }
        // }

        $is_start_holirestDay=0;
        foreach($period as $dt) {
            $form_holiday = array();
            $form_holiday = $this->CI->time_form_policies_model->check_if_holiday($dt->format('Y-m-d'));
            $forms_rest_day_count = $this->CI->time_form_policies_model->check_rest_day($user_id, $dt->format('Y-m-d'));

            if((count($form_holiday) > 0 || $forms_rest_day_count > 0) && $is_start_holirestDay == 0){           
                $days_prior--;
            }else{
                $is_start_holirestDay++;
            }
        }

        if(($days <= 1) && ($days_prior <= $value || strtotime($date_from) < strtotime($current_day))){
            return 'error';
        }
        return false;
    }

    function _check_more_than_a_day_prior($value='', $date_from='', $date_to='', $user_id=0){
        //START get days count
        $start = new DateTime($date_from);
        $end = new DateTime($date_to);      
            // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        $interval = $end->diff($start);
        $days = $interval->days;

        //START get days prior count
        $current_day = date('Y-m-d');
        $start_prior = new DateTime($current_day);
        $end_prior = new DateTime($date_from);      
        // $end_prior->modify('+1 day');

        $interval_prior = $end_prior->diff($start_prior);
        $days_prior = $interval_prior->days;
        
        // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);
        $period = iterator_to_array($period);

        $rest_days= array();
        // foreach($period as $dt) {
        //     $forms_rest_day = $this->CI->time_form_policies_model->check_if_rest_day($user_id, $dt->format('Y-m-d'));
        //     foreach($forms_rest_day as $forms_rest){
        //         $rest_days[] = $forms_rest['rest_day'];
        //     }
        // }

        $is_start_holirestDay=0;
        foreach($period as $dt) {
            $form_holiday = array();
            $form_holiday = $this->CI->time_form_policies_model->check_if_holiday($dt->format('Y-m-d'));
            $forms_rest_day_count = $this->CI->time_form_policies_model->check_rest_day($user_id, $dt->format('Y-m-d'));

            if((count($form_holiday) > 0 || $forms_rest_day_count > 0) && $is_start_holirestDay == 0){           
                $days_prior--;
            }else{
                $is_start_holirestDay++;
            }
        }

        if(($days > 1) && ($days_prior <= $value || strtotime($date_from) < strtotime($current_day))){
            return 'error';
        }
        return false;
    }

    function _check_unscheduled_late_filing($value='', $date_from='', $date_to='', $user_id=0){
        $current_day = date('Y-m-d');
        $shift_schedule = $this->CI->time_form_policies_model->get_shift_details(date('Y-m-d', strtotime($date_from)), $user_id);
        $shift_schedule_start = strtotime($shift_schedule['shift_time_start']);
        
        $shift_schedule_end = strtotime($shift_schedule['shift_time_end']);
        //START get days count
        $start = new DateTime($date_to);
        $end = new DateTime($current_day);      

        // $end->modify('+1 day');
        $interval = $end->diff($start);
        $days_interval = $interval->days;

        $datetime2 = strtotime(date('Y-m-d', strtotime($date_from))." ".$shift_schedule['shift_time_start']);
        $datetime1 = strtotime(date('Y-m-d H:i:s'));    

            // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);
        $period = iterator_to_array($period);

        $rest_days= array();
        // foreach($period as $dt) {
        //     $forms_rest_day = $this->CI->time_form_policies_model->check_if_rest_day($user_id, $dt->format('Y-m-d'));
        //     foreach($forms_rest_day as $forms_rest){
        //         $rest_days[] = $forms_rest['rest_day'];
        //     }
        // }
        $count_days = 0;
        foreach($period as $dt) {
            $form_holiday = array();
            $form_holiday = $this->CI->time_form_policies_model->check_if_holiday($dt->format('Y-m-d'));
            $forms_rest_day_count = $this->CI->time_form_policies_model->check_rest_day($user_id, $dt->format('Y-m-d'));

            if(count($form_holiday) > 0 || $forms_rest_day_count > 0){           
                $days_interval--;
                $count_days++;
            }
        }   

        $datetime1 = strtotime ( "-$count_days day" , $datetime1 ) ; 
        $hours =  (($datetime1 - $datetime2) / (60 * 60)) - 24;
        if($hours > $value || $days_interval > 1){
            return 'error';
        }
        return false;
    }

    function _check_credits($value='', $date_from='', $date_to='', $user_id=0, $form_id=0){
        $year = date('Y');
        $credits = array();
        $date = date('Y-m-d');
        $credits = $this->CI->formapp->get_leave_balance($user_id, date('Y-m-d'), $form_id); 

        if(strtolower($value) == 'no' ){
            if(count($credits) > 0){
                $has_balance = false;

                foreach($credits as $crit)
                {
                    if( $crit['balance'] > 0) $has_balance = true;
                }

                if(!$has_balance){
                    return 'error';
                }    
                return $has_balance;    
            }
            else{
                return 'error';
            }
        }
        return false;
    }

    function _check_filing_prior($value='', $date_from='', $date_to='', $user_id=0){
         //START get days count
        $start = new DateTime($date_from);
        $end = new DateTime($date_to);      
            // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        $interval = $end->diff($start);
        $days = $interval->days;

        //START get days prior count
        $current_day = date('Y-m-d');
        $start_prior = new DateTime($current_day);
        $end_prior = new DateTime($date_from);      
        // $end_prior->modify('+1 day');

        $interval_prior = $end_prior->diff($start_prior);
        $days_prior = $interval_prior->days;
        
        // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);
        $period = iterator_to_array($period);

        $rest_days= array();
        // foreach($period as $dt) {
        //     $forms_rest_day = $this->CI->time_form_policies_model->check_if_rest_day($user_id, $dt->format('Y-m-d'));
        //     foreach($forms_rest_day as $forms_rest){
        //         $rest_days[] = $forms_rest['rest_day'];
        //     }
        // }

        $is_start_holirestDay = 0;
        foreach($period as $dt) {
            $form_holiday = array();
            $form_holiday = $this->CI->time_form_policies_model->check_if_holiday($dt->format('Y-m-d'));
            $forms_rest_day_count = $this->CI->time_form_policies_model->check_rest_day($user_id, $dt->format('Y-m-d'));

            if((count($form_holiday) > 0 || $forms_rest_day_count > 0) && $is_start_holirestDay == 0){           
                $days_prior--;
            }else{
                $is_start_holirestDay++;
            }
        }

        if($days_prior <= $value || (strtotime($date_from) < strtotime($current_day))){
            return 'error';
        }
        return false;
    }

    function _check_filing_prior_months($value='', $date_from='', $date_to='', $user_id=0){
         //START get days count
        // $start = new DateTime($date_from);
        // $end = new DateTime($date_to);      
            // otherwise the  end date is excluded (bug?)
        // $end->modify('+1 day');

        // $interval = $end->diff($start);
        // $days = $interval->days;

        //START get days prior count
        $current_day = date('Y-m-d');   
        $d1 = new DateTime($current_day);
        $d2 = new DateTime($date_from);

        $interval = $d2->diff($d1);

        $months_prior = $interval->format('%m');

        if($months_prior < $value || (strtotime($date_from) < strtotime($current_day))){
            return 'error';
        }
        return false;
    }

    function _check_filed_this_year($value='', $date_from='', $date_to='', $user_id=0, $form_id=0, $forms_id=0, $total_duration=0){
        $existing_filed_forms = $this->CI->time_form_policies_model->get_filed_forms($user_id, $form_id, $forms_id);        

        $total_duration += $existing_filed_forms;
        if($total_duration > $value){
            return 'error';
        }
        return false;
    }

    function validate_form_change_status($forms_id,$decission){
        $form_policy_error = array();
        $form_policy_error['error'] = array();
        $form_policy_error['warning'] = array();
        $form_policy_error['hr_validate'] =  false; 
        $current_day = date('Y-m-d');

        $form_details = $this->CI->time_form_policies_model->get_forms_details($forms_id);
        
        if (empty($form_details)){
            return $form_policy_error;
        }

        switch ($decission) {
            case 0:
            case 8:
                $type = 'CANCELLATION';
                break;
            case 1:
            case 2:
                $type = 'APPROVAL';
                break;                
            default:
                $type = '';
                break;
        }

        $form_id = $form_details['form_id'];
        $user_id = $form_details['user_id'];
        $form_code = $form_details['form_code'];
        $date_from = $form_details['date_from'];
        $date_to = $form_details['date_to'];
        $form_policies = $this->CI->time_form_policies_model->get_form_policies($form_id, $user_id, $type);
        foreach ($form_policies as $form_policy){
            switch($form_policy['class_code']){
                case $form_code.'-LATE-APPROVAL-CUTOFF':
                // case $form_code.'-LATE-CANCELLATION-CUTOFF':
                if(strtotime($date_from) < strtotime($current_day)){
                    $advance_filing_cutoff = $this->_check_advance_change_status_cutoff($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
                    if($advance_filing_cutoff == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Allowable time for approval has already passed.";
                        }else{
                            $form_policy_error['error'][] = "Allowable time for approval has already passed.";
                        }
                    }elseif($advance_filing_cutoff == 'invalid'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }else{
                            $form_policy_error['error'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }
                    }
                }
                break;
                case $form_code.'-LATE-APPROVAL-DAYS':
                // case $form_code.'-LATE-CANCELLATION-DAYS':
                if(strtotime($date_from) < strtotime($current_day)){
                    $advance_filing_days= $this->_check_advance_change_status_days($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id'],$user_id);
                    if($advance_filing_days == 'error'){
                        $form_policy_error['error'][] = "Allowable time for approval has already passed.";
                    }
                }
                break;
                case $form_code.'-LATE-APPROVAL-NOT-ALLOWED':
                // case $form_code.'-LATE-CANCELLATION-NOT-ALLOWED':
                if(strtotime($date_from) < strtotime($current_day)){
                    $advance_filing_not_allowed = $this->_check_advance_change_status_not_allowed($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
                    if($advance_filing_not_allowed == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Allowable time for approval has already passed.";
                        }else{
                            $form_policy_error['error'][] = "Allowable time for approval has already passed.";
                        }
                    }elseif($advance_filing_not_allowed == 'invalid'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }else{
                            $form_policy_error['error'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }
                    }
                }
                break;
                case $form_code.'-LATE-APPROVAL-WITHIN-CUTOFF':
                // case $form_code.'-LATE-CANCELLATION-WITHIN-CUTOFF':
                if(strtotime($date_from) < strtotime($current_day)){
                    $advance_filing_cutoff = $this->_check_advance_change_status_within_cutoff($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
                    if($advance_filing_cutoff == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Allowable time for approval has already passed.";
                        }else{
                            $form_policy_error['error'][] = "Allowable time for approval has already passed.";
                        }
                    }elseif($advance_filing_cutoff == 'invalid'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }else{
                            $form_policy_error['error'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }
                    }
                }
                break;
                case $form_code.'-ADVANCE-APPROVAL-CUTOFF':
                // case $form_code.'-ADVANCE-CANCELLATION-CUTOFF':
                if(strtotime($date_to) > strtotime($current_day)){
                    $late_filing_cutoff = $this->_check_late_change_status_cutoff($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
                    if($late_filing_cutoff == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Allowable time for approval has already passed.";
                        }else{
                            $form_policy_error['error'][] = "Allowable time for approval has already passed.";
                        }
                    }elseif($late_filing_cutoff == 'invalid'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }else{
                            $form_policy_error['error'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }
                    }
                }
                break;
                case $form_code.'-ADVANCE-APPROVAL-DAYS':
                // case $form_code.'-ADVANCE-CANCELLATION-DAYS':
                if(strtotime($date_to) > strtotime($current_day)){
                    $late_filing_days= $this->_check_late_change_status_days($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id'],$user_id);
                    if($late_filing_days == 'error'){
                        $form_policy_error['error'][] = "Allowable time for approval has already passed.";
                    }
                }
                break;
                case $form_code.'-ADVANCE-APPROVAL-NOT-ALLOWED':
                // case $form_code.'-ADVANCE-CANCELLATION-NOT-ALLOWED':
                if(strtotime($date_to) > strtotime($current_day)){
                    $late_filing_not_allowed = $this->_check_late_change_status_not_allowed($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
                    if($late_filing_not_allowed == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Allowable time for approval has already passed.";
                        }else{
                            $form_policy_error['error'][] = "Allowable time for approval has already passed.";
                        }
                    }elseif($late_filing_not_allowed == 'invalid'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }else{
                            $form_policy_error['error'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }
                    }
                }
                break;
                case $form_code.'-ADVANCE-APPROVAL-WITHIN-CUTOFF':
                // case $form_code.'-ADVANCE-CANCELLATION-WITHIN-CUTOFF':
                if(strtotime($date_to) > strtotime($current_day)){
                    $late_filing_within_cutoff = $this->_check_late_change_status_within_cutoff($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
                    if($late_filing_within_cutoff == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Allowable time for approval has already passed.";
                        }else{
                            $form_policy_error['error'][] = "Allowable time for approval has already passed.";
                        }
                    }elseif($late_filing_within_cutoff == 'invalid'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }else{
                            $form_policy_error['error'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }
                    }
                }
                break;
            }
        }        
        return $form_policy_error;
    }

    function _check_late_change_status_cutoff($value='', $date_from='', $date_to='', $company_id=''){
        $current_day = date('Y-m-d');
        $allowed_date = $this->CI->time_form_policies_model->get_allowed_date_number_cutoff_change_stat($value, $date_from, $company_id);

        if(!$allowed_date){
            return "invalid";
        }else{
            if(strtotime($current_day) < strtotime($allowed_date)){
                return 'error';
            }
        }
        return false;
    }

    function _check_late_change_status_days($value='', $date_from='', $date_to='', $company_id='', $user_id = ''){   
        $current_day = date('Y-m-d');
        $no_working_days = $this->CI->time_form_policies_model->get_working_days($date_to, $current_day, $user_id);

        if($no_working_days > $value){
            return 'error';
        }

        return false;
    }

    function _check_late_change_status_not_allowed($value='', $date_from='', $date_to='', $company_id=''){     
        $current_day = date('Y-m-d');
        if(strtotime($date_from) < strtotime($current_day) && strtolower($value) == 'yes'){
            return 'error';
        }
        return false;
    }

    function _check_late_change_status_within_cutoff($value='', $date_from='', $date_to='', $company_id=''){  
        $current_day = date('Y-m-d');
        if(strtotime($date_from) > strtotime($current_day)){
            //to bypass checking on super advance filing
            return false;
        }else{
            $allowed_date = $this->CI->time_form_policies_model->get_allowed_date_within_cutoff_change_stat($value, $date_from, $company_id);

            if(!$allowed_date){
                return "invalid";
            }else{
                if(strtotime($current_day) < strtotime($allowed_date) && strtolower($value) == 'yes'){
                    return 'error';
                }
            }
        }
        return false;
    }

    function _check_advance_change_status_cutoff($value='', $date_from='', $date_to='', $company_id=''){
        $current_day = date('Y-m-d');
        $allowed_date = $this->CI->time_form_policies_model->get_advance_allowed_date_number_cutoff_change_stat($value, $date_from, $company_id);

        if(!$allowed_date){
            return "invalid";
        }else{
            if(strtotime($current_day) > strtotime($allowed_date)){
                return 'error';
            }
        }
        return false; 
    }

    function _check_advance_change_status_days($value='', $date_from='', $date_to='', $company_id='', $user_id = ''){   
        $current_day = date('Y-m-d');
        $no_working_days = $this->CI->time_form_policies_model->get_working_days($date_from, $current_day, $user_id);

        if($no_working_days > $value){
            return 'error';
        }

        return false;
    }

    function _check_advance_change_status_not_allowed($value='', $date_from='', $date_to='', $company_id=''){     
        $current_day = date('Y-m-d');
        if(strtotime($date_from) > strtotime($current_day) && strtolower($value) == 'yes'){
            return 'error';
        }
        return false;
    }

    function _check_advance_change_status_within_cutoff($value='', $date_from='', $date_to='', $company_id=''){
        $current_day = date('Y-m-d');
        $allowed_date = $this->CI->time_form_policies_model->get_advance_allowed_date_within_cutoff_change_stat($value, $date_from, $company_id);
        
        $d_from = date('Y-m-d', strtotime($allowed_date['date_from']));
        $d_to = date('Y-m-d', strtotime($allowed_date['date_to']));
        $date_from = date('Y-m-d', strtotime($date_from));
        $date_to = date('Y-m-d', strtotime($date_to));

        if(!$allowed_date){
            return "invalid";
        }else{
            if((($date_from > $d_from) && ($date_to < $d_to)) && $value == 2){
                return false;
            } else {
                return 'error';
            }
        }
        // if(!$allowed_date){
        //     return "invalid";
        // }else{
        //     if(strtotime($current_day) > strtotime($allowed_date) && strtolower($value) == 'yes'){
        //         return 'error';
        //     }
        // }
    }


    function validate_form_cancel_status($forms_id){
        $form_policy_error = array();
        $form_policy_error['error'] = array();
        $form_policy_error['hr_validate'] =  false; 
        $current_day = date('Y-m-d');

        $form_details = $this->CI->time_form_policies_model->get_forms_details($forms_id);
        $form_id = $form_details['form_id'];
        $user_id = $form_details['user_id'];
        $form_code = $form_details['form_code'];
        $date_from = $form_details['date_from'];
        $date_to = $form_details['date_to'];
        $form_policies = $this->CI->time_form_policies_model->get_form_policies($form_id, $user_id);
        foreach ($form_policies as $form_policy){ 
            switch($form_policy['class_code']){
                case $form_code.'-LATE-CANCELLATION-CUTOFF':
                if(strtotime($date_from) < strtotime($current_day)){
                    $advance_filing_cutoff = $this->_check_advance_change_status_cutoff($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
                    if($advance_filing_cutoff == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Allowable time for cancellation has already passed.";
                        }else{
                            $form_policy_error['error'][] = "Allowable time for cancellation has already passed.";
                        }
                    }elseif($advance_filing_cutoff == 'invalid'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }else{
                            $form_policy_error['error'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }
                    }
                }
                break;
                case $form_code.'-LATE-CANCELLATION-DAYS':
                if(strtotime($date_from) < strtotime($current_day)){
                    $advance_filing_days= $this->_check_advance_change_status_days($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
                    if($advance_filing_days == 'error' && $form_policy['severity'] != 'Warning'){
                        $form_policy_error['error'][] = "Allowable time for cancellation has already passed.";
                    }
                }
                break;
                case $form_code.'-LATE-CANCELLATION-NOT-ALLOWED':
                if(strtotime($date_from) < strtotime($current_day)){
                    $advance_filing_not_allowed = $this->_check_advance_change_status_not_allowed($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
                    if($advance_filing_not_allowed == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Allowable time for cancellation has already passed.";
                        }else{
                            $form_policy_error['error'][] = "Allowable time for cancellation has already passed.";
                        }
                    }elseif($advance_filing_not_allowed == 'invalid'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }else{
                            $form_policy_error['error'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }
                    }
                }
                break;
                case $form_code.'-LATE-CANCELLATION-WITHIN-CUTOFF':
                if(strtotime($date_from) < strtotime($current_day)){
                    $advance_filing_cutoff = $this->_check_advance_change_status_within_cutoff($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
                    if($advance_filing_cutoff == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Allowable time for cancellation has already passed.";
                        }else{
                            $form_policy_error['error'][] = "Allowable time for cancellation has already passed.";
                        }
                    }elseif($advance_filing_cutoff == 'invalid'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }else{
                            $form_policy_error['error'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }
                    }
                }
                break;
                case $form_code.'-ADVANCE-CANCELLATION-CUTOFF':
                if(strtotime($date_to) > strtotime($current_day)){
                    $late_filing_cutoff = $this->_check_late_change_status_cutoff($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
                    if($late_filing_cutoff == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Allowable time for cancellation has already passed.";
                        }else{
                            $form_policy_error['error'][] = "Allowable time for cancellation has already passed.";
                        }
                    }elseif($late_filing_cutoff == 'invalid'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }else{
                            $form_policy_error['error'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }
                    }
                }
                break;
                case $form_code.'-ADVANCE-CANCELLATION-DAYS':
                if(strtotime($date_to) > strtotime($current_day)){
                    $late_filing_days= $this->_check_late_change_status_days($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
                    if($late_filing_days == 'error' && $form_policy['severity'] != 'Warning'){
                        $form_policy_error['error'][] = "Allowable time for cancellation has already passed.";
                    }
                }
                break;
                case $form_code.'-ADVANCE-CANCELLATION-NOT-ALLOWED':
                if(strtotime($date_to) > strtotime($current_day)){
                    $late_filing_not_allowed = $this->_check_late_change_status_not_allowed($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
                    if($late_filing_not_allowed == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Allowable time for cancellation has already passed.";
                        }else{
                            $form_policy_error['error'][] = "Allowable time for cancellation has already passed.";
                        }
                    }elseif($late_filing_not_allowed == 'invalid'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }else{
                            $form_policy_error['error'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }
                    }
                }
                break;
                case $form_code.'-ADVANCE-CANCELLATION-WITHIN-CUTOFF':
                if(strtotime($date_to) > strtotime($current_day)){
                    $late_filing_within_cutoff = $this->_check_late_change_status_within_cutoff($form_policy['class_value'], $date_from, $date_to, $form_policy['company_id']);
                    if($late_filing_within_cutoff == 'error'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Allowable time for cancellation has already passed.";
                        }else{
                            $form_policy_error['error'][] = "Allowable time for cancellation has already passed.";
                        }
                    }elseif($late_filing_within_cutoff == 'invalid'){
                        if($form_policy['severity'] == 'Warning'){
                            $form_policy_error['warning'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }else{
                            $form_policy_error['error'][] = "Next cutoff not yet created in processing, please contact admin.";
                        }
                    }
                }
                break;
            }
        }
        return $form_policy_error;
    }


}