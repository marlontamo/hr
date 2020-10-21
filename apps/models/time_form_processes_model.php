<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class time_form_processes_model extends Record
{

	function __construct()
	{
		parent::__construct();
	}

    function leave_conversion_processes($forms_data=array(), $form_details){
        $convert_qry = "SELECT tfc.*, tfcp.* FROM {$this->db->dbprefix}time_form tf
                LEFT JOIN {$this->db->dbprefix}time_form_class tfc ON tf.form_id = tfc.form_id
                LEFT JOIN {$this->db->dbprefix}time_form_class_policy tfcp ON tfc.class_id = tfcp.class_id
                LEFT JOIN {$this->db->dbprefix}users_profile up ON FIND_IN_SET(up.company_id, tfcp.company_id)
                LEFT JOIN {$this->db->dbprefix}partners prs ON up.user_id = prs.user_id
                LEFT JOIN {$this->db->dbprefix}users usr ON up.user_id = usr.user_id
                LEFT JOIN {$this->db->dbprefix}partners_personal pp ON prs.partner_id = pp.partner_id AND pp.key = 'gender'
                LEFT JOIN {$this->db->dbprefix}partners_personal pps ON prs.partner_id = pps.partner_id AND pps.key = 'solo_parent'
                WHERE tf.form_code IN
                ('{$forms_data['form_code']}')
                AND up.user_id = {$forms_data['user_id']}
                AND tfcp.class_value = 'YES'
                AND tfc.class_code = '{$forms_data['form_code']}-ALLOW-LEAVE-CONVERSION'
                AND IF((tfcp.employment_status_id  != 'ALL') AND (prs.status_id IS NOT NULL AND LENGTH(prs.status_id) > 0), FIND_IN_SET(prs.status_id, tfcp.employment_status_id), 1)
                AND IF((tfcp.employment_type_id  != 'ALL') AND (prs.employment_type_id IS NOT NULL AND LENGTH(prs.employment_type_id) > 0), FIND_IN_SET(prs.employment_type_id, tfcp.employment_type_id), 1)
                AND IF((tfcp.role_id  != 'ALL') AND (usr.role_id IS NOT NULL AND LENGTH(usr.role_id) > 0), FIND_IN_SET(usr.role_id, tfcp.role_id), 1)
                AND IF((tfcp.division_id  != 'ALL') AND (up.division_id IS NOT NULL AND LENGTH(up.division_id) > 0), FIND_IN_SET(up.division_id, tfcp.division_id), 1)
                AND IF((tfcp.department_id  != 'ALL') AND (up.department_id IS NOT NULL AND LENGTH(up.department_id) > 0), FIND_IN_SET(up.department_id, tfcp.department_id), 1)
                AND IF((tfcp.group_id  != 'ALL') AND (up.group_id IS NOT NULL AND LENGTH(up.group_id) > 0), FIND_IN_SET(up.group_id, tfcp.group_id), 1)
                #AND IF((tfcp.project_id IS NOT NULL AND LENGTH(tfcp.project_id) > 0) AND (up.project_id IS NOT NULL AND LENGTH(up.project_id) > 0), FIND_IN_SET(up.project_id, tfcp.project_id), 1)
                AND IF(pp.key_value = 'Male', tf.only_female != 1, tf.only_male != 1)
                AND IF(pps.key_value = 1, 1=1, tf.form_id != 16)
                ORDER BY tf.order_by, tf.form_id";
        $convert_result = $this->db->query($convert_qry);
        if($convert_result->num_rows() > 0){
            $class_qry = "SELECT tfc.*, tfcp.* FROM {$this->db->dbprefix}time_form tf
                    LEFT JOIN {$this->db->dbprefix}time_form_class tfc ON tf.form_id = tfc.form_id
                    LEFT JOIN {$this->db->dbprefix}time_form_class_policy tfcp ON tfc.class_id = tfcp.class_id
                    LEFT JOIN {$this->db->dbprefix}users_profile up ON FIND_IN_SET(up.company_id, tfcp.company_id)
                    LEFT JOIN {$this->db->dbprefix}partners prs ON up.user_id = prs.user_id
                    LEFT JOIN {$this->db->dbprefix}users usr ON up.user_id = usr.user_id
                    LEFT JOIN {$this->db->dbprefix}partners_personal pp ON prs.partner_id = pp.partner_id AND pp.key = 'gender'
                    LEFT JOIN {$this->db->dbprefix}partners_personal pps ON prs.partner_id = pps.partner_id AND pps.key = 'solo_parent'
                    WHERE tf.form_code IN
                    ('{$forms_data['form_code']}')
                    AND up.user_id = {$forms_data['user_id']}
                    AND tfc.class_code IN (
                        '{$forms_data['form_code']}-CONVERSION-LEAVE-TYPE',
                        '{$forms_data['form_code']}-HOURS-FOR-ONE-DAY-LEAVE',
                        '{$forms_data['form_code']}-HOURS-FOR-HALF-DAY-LEAVE'
                        )
                    AND IF((tfcp.employment_status_id  != 'ALL') AND (prs.status_id IS NOT NULL AND LENGTH(prs.status_id) > 0), FIND_IN_SET(prs.status_id, tfcp.employment_status_id), 1)
                    AND IF((tfcp.employment_type_id  != 'ALL') AND (prs.employment_type_id IS NOT NULL AND LENGTH(prs.employment_type_id) > 0), FIND_IN_SET(prs.employment_type_id, tfcp.employment_type_id), 1)
                    AND IF((tfcp.role_id  != 'ALL') AND (usr.role_id IS NOT NULL AND LENGTH(usr.role_id) > 0), FIND_IN_SET(usr.role_id, tfcp.role_id), 1)
                    AND IF((tfcp.division_id  != 'ALL') AND (up.division_id IS NOT NULL AND LENGTH(up.division_id) > 0), FIND_IN_SET(up.division_id, tfcp.division_id), 1)
                    AND IF((tfcp.department_id  != 'ALL') AND (up.department_id IS NOT NULL AND LENGTH(up.department_id) > 0), FIND_IN_SET(up.department_id, tfcp.department_id), 1)
                    AND IF((tfcp.group_id  != 'ALL') AND (up.group_id IS NOT NULL AND LENGTH(up.group_id) > 0), FIND_IN_SET(up.group_id, tfcp.group_id), 1)
                    #AND IF((tfcp.project_id IS NOT NULL AND LENGTH(tfcp.project_id) > 0) AND (up.project_id IS NOT NULL AND LENGTH(up.project_id) > 0), FIND_IN_SET(up.project_id, tfcp.project_id), 1)
                    AND IF(pp.key_value = 'Male', tf.only_female != 1, tf.only_male != 1)
                    AND IF(pps.key_value = 1, 1=1, tf.form_id != 16)
                    ORDER BY tf.order_by, tf.form_id";
            $class_result = $this->db->query($class_qry);
            if($class_result->num_rows() > 0){
                foreach($class_result->result_array() as $class){
                	$class_array[$class['class_code']] = $class['class_value'];
                }

                if( $form_details['status_id'] == 6){//approved
                    if(array_key_exists ( $forms_data['form_code'].'-HOURS-FOR-ONE-DAY-LEAVE' , $class_array )){
                        if ($forms_data['hrs'] >= $class_array[$forms_data['form_code'].'-HOURS-FOR-ONE-DAY-LEAVE' ] ){
                            $this->add_entry_one_day_leave($forms_data, $class_array[$forms_data['form_code'].'-HOURS-FOR-ONE-DAY-LEAVE' ], $class_array, $form_details);
                        }else{
                            if(array_key_exists ( $forms_data['form_code'].'-HOURS-FOR-HALF-DAY-LEAVE' , $class_array )){
                                if ($forms_data['hrs'] >= $class_array[$forms_data['form_code'].'-HOURS-FOR-HALF-DAY-LEAVE' ] )
                                $this->add_entry_half_day_leave($forms_data, $class_array[$forms_data['form_code'].'-HOURS-FOR-HALF-DAY-LEAVE' ], $class_array, $form_details);
                            }
                        }
                    }else{
                        if(array_key_exists ( $forms_data['form_code'].'-HOURS-FOR-HALF-DAY-LEAVE' , $class_array )){
                            if ($forms_data['hrs'] >= $class_array[$forms_data['form_code'].'-HOURS-FOR-HALF-DAY-LEAVE' ] )
                            $this->add_entry_half_day_leave($forms_data, $class_array[$forms_data['form_code'].'-HOURS-FOR-HALF-DAY-LEAVE' ], $class_array, $form_details);
                        }
                    }
                }
                // else{
                //     $this->set_ot_leave($forms_data, $form_details);
                // }
            }
        }
    }

    function add_entry_one_day_leave($forms_data=array(), $value, $class_array=array(), $form_details=array()){
    	if($forms_data['hrs'] >= $value){
			$this->db->where('deleted', '0');
			$this->db->where('form_code', $class_array[$forms_data['form_code'].'-CONVERSION-LEAVE-TYPE']);
		    $form_record = $this->db->get('time_form')->row_array();

            $balqry = " SELECT * FROM {$this->db->dbprefix}time_form_balance 
                    WHERE year = '".date('Y')."' AND user_id= {$forms_data['user_id']}
                    AND form_id= {$form_record['form_id']}";
            $balresults = $this->db->query($balqry);
            if($balresults->num_rows() > 0){
                $bal_array = $balresults->row_array();
                $record = array(
                    'current' => $bal_array['current'] + 1,
                    'modified_on' => date('Y-m-d H:i:s')
                );
                $where_bal = array( 
                    'year' => date('Y'),
                    'form_id' => $form_record['form_id'],
                    'user_id' => $forms_data['user_id']
                    );
                $this->db->update( 'time_form_balance', $record, $where_bal );
            }else{
                $record = array(
                    'year'      => date('Y'),
                    'user_id'   => $forms_data['user_id'],
                    'form_id'   => $form_record['form_id'],
                    'form_code' => $form_record['form_code'],
                    'current'   => '1'
                );
                $this->db->insert('time_form_balance', $record);
            }
            $this->set_ot_leave($forms_data, $form_details, 1);
    	}else{
    		$this->add_entry_half_day_leave($forms_data, $value, $class_array=array(), $form_details);
    	}
    }

    function add_entry_half_day_leave($forms_data=array(), $value, $class_array, $form_details=array()){
    	if($forms_data['hrs'] >= $value){
	    	$this->db->where('deleted', '0');
	    	$this->db->where('form_code', $class_array[$forms_data['form_code'].'-CONVERSION-LEAVE-TYPE']);
	        $form_record = $this->db->get('time_form')->row_array();

            $balqry = " SELECT * FROM {$this->db->dbprefix}time_form_balance 
                    WHERE year = '".date('Y')."' AND user_id= {$forms_data['user_id']}
                    AND form_id= {$form_record['form_id']}";
            $balresults = $this->db->query($balqry);
            if($balresults->num_rows() > 0){
                $bal_array = $balresults->row_array();
                $record = array(
                    'current' => $bal_array['current'] + 0.5,
                    'modified_on' => date('Y-m-d H:i:s')
                );
                $where_bal = array( 
                    'year' => date('Y'),
                    'form_id' => $form_record['form_id'],
                    'user_id' => $forms_data['user_id']
                    );
                $this->db->update( 'time_form_balance', $record, $where_bal );
            }else{
        		$record = array(
        			'year' 		=> date('Y'),
        			'user_id' 	=> $forms_data['user_id'],
        			'form_id' 	=> $form_record['form_id'],
        			'form_code'	=> $form_record['form_code'],
        			'current'	=> '0.5'
       			);
                $this->db->insert('time_form_balance', $record);
            }
            $this->set_ot_leave($forms_data, $form_details, 0.5);
    	}
    }

    function set_ot_leave($forms_data=array(), $form_details=array(), $leave_credit=0){

        $record = $this->db->get_where( 'time_forms_ot_leave', array( 'forms_id' => $forms_data['forms_id'] ) );
        
        $class_qry = "SELECT tfc.*, tfcp.* FROM {$this->db->dbprefix}time_form tf
                    LEFT JOIN {$this->db->dbprefix}time_form_class tfc ON tf.form_id = tfc.form_id
                    LEFT JOIN {$this->db->dbprefix}time_form_class_policy tfcp ON tfc.class_id = tfcp.class_id
                    LEFT JOIN {$this->db->dbprefix}users_profile up ON FIND_IN_SET(up.company_id, tfcp.company_id)
                    LEFT JOIN {$this->db->dbprefix}partners prs ON up.user_id = prs.user_id
                    LEFT JOIN {$this->db->dbprefix}users usr ON up.user_id = usr.user_id
                    LEFT JOIN {$this->db->dbprefix}partners_personal pp ON prs.partner_id = pp.partner_id AND pp.key = 'gender'
                    LEFT JOIN {$this->db->dbprefix}partners_personal pps ON prs.partner_id = pps.partner_id AND pps.key = 'solo_parent'
                    WHERE tf.form_code IN
                    ('{$forms_data['form_code']}')
                    AND up.user_id = {$forms_data['user_id']}
                    AND tfc.class_code IN (
                        '{$forms_data['form_code']}-LEAVE-EXPIRATION-DAYS',
                        '{$forms_data['form_code']}-LEAVE-EXPIRATION-FIELD',
                        '{$forms_data['form_code']}-MINIMUM-FILING-DAYS-FOR-EXPIRY',
                        '{$forms_data['form_code']}-EXPIRY-EXT-FOR-MIN-DAYS-FILED'
                        )
                    AND IF((tfcp.employment_status_id  != 'ALL') AND (prs.status_id IS NOT NULL AND LENGTH(prs.status_id) > 0), FIND_IN_SET(prs.status_id, tfcp.employment_status_id), 1)
                    AND IF((tfcp.employment_type_id  != 'ALL') AND (prs.employment_type_id IS NOT NULL AND LENGTH(prs.employment_type_id) > 0), FIND_IN_SET(prs.employment_type_id, tfcp.employment_type_id), 1)
                    AND IF((tfcp.role_id  != 'ALL') AND (usr.role_id IS NOT NULL AND LENGTH(usr.role_id) > 0), FIND_IN_SET(usr.role_id, tfcp.role_id), 1)
                    AND IF((tfcp.division_id  != 'ALL') AND (up.division_id IS NOT NULL AND LENGTH(up.division_id) > 0), FIND_IN_SET(up.division_id, tfcp.division_id), 1)
                    AND IF((tfcp.department_id  != 'ALL') AND (up.department_id IS NOT NULL AND LENGTH(up.department_id) > 0), FIND_IN_SET(up.department_id, tfcp.department_id), 1)
                    AND IF((tfcp.group_id  != 'ALL') AND (up.group_id IS NOT NULL AND LENGTH(up.group_id) > 0), FIND_IN_SET(up.group_id, tfcp.group_id), 1)
                    #AND IF((tfcp.project_id IS NOT NULL AND LENGTH(tfcp.project_id) > 0) AND (up.project_id IS NOT NULL AND LENGTH(up.project_id) > 0), FIND_IN_SET(up.project_id, tfcp.project_id), 1)
                    AND IF(pp.key_value = 'Male', tf.only_female != 1, tf.only_male != 1)
                    AND IF(pps.key_value = 1, 1=1, tf.form_id != 16)
                    ORDER BY tf.order_by, tf.form_id";
            $class_result = $this->db->query($class_qry);
            if($class_result->num_rows() > 0){
                foreach($class_result->result_array() as $class){
                    $class_array[$class['class_code']] = $class['class_value'];
                }
                //get field expiry
                $this->db->select($class_array[$forms_data['form_code'].'-LEAVE-EXPIRATION-FIELD'])
                ->from('partners')
                ->where( array('user_id' => $forms_data['user_id']) );
                $expiry         = $this->db->get('')->row_array(); 
                $expiry_date    = $expiry[$class_array[$forms_data['form_code'].'-LEAVE-EXPIRATION-FIELD']]; 
                $min_filing_days = (isset($class_array[$forms_data['form_code'].'-MINIMUM-FILING-DAYS-FOR-EXPIRY']) ? $class_array[$forms_data['form_code'].'-MINIMUM-FILING-DAYS-FOR-EXPIRY'] : 0);

                $expiry_date = date('Y',strtotime($forms_data['date_to'])).'-'.date('m-d', strtotime($expiry_date));

                if( strtotime($expiry_date) < strtotime($forms_data['date_to']) ){
                    // $expiry_date=date('Y-m-d', strtotime('+1 year', strtotime($expiry_date)));
                    $expiry_date = date('Y-m-d', strtotime('+1 year', strtotime($expiry_date)));
                }

                $expire_date = strtotime($expiry_date); // or your date as well
                $your_date = strtotime($forms_data['date_to']);
                $datediff = $expire_date - $your_date;
                $filing_days = floor($datediff/(60*60*24));

                $expiration_date = '0000-00-00';
                if($filing_days < $min_filing_days){
                    $a_date = date("Y-m-d", strtotime("+1 month", $your_date));
                    // $expiration_date = date("Y-m-t", strtotime($a_date));
                    $d = new DateTime( $a_date ); 
                    $expiration_date = $d->format( 'Y-m-t' );
                }else{
                    $expiration_date = $expiry_date;
                }

                // $expiry_days = date('Y-m-d', strtotime($forms_data['date_to']."+".$class_array[$forms_data['form_code'].'-LEAVE-EXPIRATION-DAYS']." days"));

                // if(strtotime($expiry_date) > strtotime($expiry_days)){
                //     $expiration_date = $expiry_date;
                // }else{
                //     $expiration_date = $expiry_days;
                // }
            }

        switch( true )
        {
            case $record->num_rows() == 0:
                $ot_record = array(
                    'forms_id'          => $forms_data['forms_id'],
                    'credit'            => $leave_credit,
                    'remarks'           => $form_details['remarks'],
                    'validated_by'      => $this->user->user_id,
                    'status_id'         => $form_details['status_id'],
                    'expiration_date'   => $expiration_date
                );
                $this->db->insert('time_forms_ot_leave', $ot_record);
                break;
            case $record->num_rows() == 1:
                $ot_record = array(
                    'forms_id'          => $forms_data['forms_id'],
                    'credit'            => $leave_credit,
                    'remarks'           => $form_details['remarks'],
                    'validated_by'      => $this->user->user_id,
                    'status_id'         => $form_details['status_id'],
                    'expiration_date'   => $expiration_date
                );
                $this->db->update( 'time_forms_ot_leave', $ot_record, array( 'forms_id' => $forms_data['forms_id'] ) );
                break;
        }
        $this->db->update( 'time_form_balance', array( 'deleted' => 0 ) );
    }

}