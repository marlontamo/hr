<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class form_application_model extends Record
{
	var $mod_id;
	var $mod_code;
	var $route;
	var $url;
	var $primary_key;
	var $table;
	var $icon;
	var $short_name;
	var $long_name;
	var $description;
	var $path;

	public function __construct()
	{
		$this->mod_id = 42;
		$this->mod_code = 'form_application';
		$this->route = 'time/application';
		$this->url = site_url('time/application');
		$this->primary_key = 'forms_id';
		$this->table = 'time_forms';
		$this->icon = '';
		$this->short_name = 'Application';
		$this->long_name  = 'Application';
		$this->description = '';
		$this->path = APPPATH . 'modules/form_application/';

		parent::__construct();		
	}

function _cancel_record( $records, $form_type )
{

	$this->response = new stdClass();

	$data['modified_on'] = date('Y-m-d H:i:s');
	$data['modified_by'] = $this->user->user_id;
	$data['form_status_id'] = '8';

	$this->db->where_in($this->primary_key, $records);
	$this->db->update($this->table, $data);

	
	if( $this->db->_error_message() != "" ){
		$this->response->message[] = array(
			'message' => $this->db->_error_message(),
			'type' => 'error'
		);
	}
	else{
		$this->response->message[] = array(
			'message' => $form_type . ' has been cancelled.',
			'type' => 'success'
		);
	}

	return $this->response;
}

function _get_list($start, $limit, $search, $trash = false, $filters)
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

        if($filters != "" & $filters != "form_id=0")
			$qry .= $filters;
			     

        $qry .= " AND {$this->db->dbprefix}{$this->table}.user_id = ".$this->user->user_id;
        //$qry .= " AND {$this->db->dbprefix}{$this->table}.form_code <> 'DTRU'"; // exclude DTRU
        $qry .= " GROUP BY record_id";
        $qry .= " ORDER BY {$this->db->dbprefix}{$this->table}.created_on DESC ";
        $qry .= " LIMIT $limit OFFSET $start";

        $this->load->library('parser');
        $this->parser->set_delimiters('{$', '}');
        $qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

        $result = $this->db->query( $qry );
        // echo $qry;
        if($result->num_rows() > 0)
        {           
            foreach($result->result_array() as $row){
                $data[] = $row;
            }
        }
        return $data;
    }

public function get_forms_info(){

	$this->db->where('deleted',0);
	$form = $this->db->get('time_form');
	return $form->row_array();

}

public function get_form_info( $form_code = '' ){		

		if( $form_code != '' ){
			$this->db->where('deleted',0);
			$this->db->where('form_code',strtoupper($form_code));
			$this->db->or_where('form_id',$form_code);
			$this->db->group_by('is_leave');
			$form = $this->db->get('time_form');
			return $form->row_array();
		}
		else{
			$this->db->where('deleted',0);
			$form = $this->db->get('time_form');
			return $form->result_array();
		}

		
	}	


public function get_form_status( $user_id ){

	$sql = "SELECT tf.form_id, tf.form, tf.form_code, tf.is_leave,
	SUM(IF( tfp.form_status_id=3, 1, 0)) pending,
	SUM(IF( tfp.form_status_id=6, 1, 0)) approved
	FROM {$this->db->dbprefix}time_form tf
	LEFT JOIN {$this->db->dbprefix}time_forms tfp ON tfp.form_id = tf.form_id AND tfp.user_id = ".$user_id." AND tfp.deleted = 0
	GROUP BY tf.form_id";

	$result = $this->db->query($sql);
	return $result->result_array();

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

	public function get_specialLeaves_policy_grant($user_id=0){
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
							AND tf.special_leave = 1
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
							#AND IF(pps.key_value = 1, 1=1, tf.form_id != 16)
							ORDER BY tf.order_by, tf.form_id";
							// echo "<pre>$application_forms";exit();
		$application_forms = $this->db->query($application_forms);
		return ($form_id != 0) ? $application_forms->row_array() : $application_forms->result_array();		 
	}

	public function get_regularLeaves_policy_grant($user_id=0){
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
							AND ( tf.special_leave = 0 AND is_leave = 1)
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
							#AND IF(pps.key_value = 1, 1=1, tf.form_id != 16)
							AND tfcp.deleted = 0
							GROUP BY tf.form_code
							ORDER BY tf.order_by, tf.form_id";
							// echo "<pre>$application_forms";exit();
		$application_forms = $this->db->query($application_forms);
		return ($form_id != 0) ? $application_forms->row_array() : $application_forms->result_array();		 
	}

	public function get_otherForms_policy_grant($user_id=0){
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
							AND ( tf.special_leave = 0 AND is_leave = 0)
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
							#AND IF(pps.key_value = 1, 1=1, tf.form_id != 16)
							ORDER BY tf.order_by, tf.form_id";
							// echo "<pre>$application_forms";exit();
		$application_forms = $this->db->query($application_forms);
		return ($form_id != 0) ? $application_forms->row_array() : $application_forms->result_array();		 
	}

	public function get_policy_disable_no_credit($user_id=0){
		$form_id = 0;
		$forms_disable_no_credits = $this->get_form_type();

		$forms_with_disable_no_credit = array();
		foreach($forms_disable_no_credits as $forms_disable_no_credit){
			$forms_with_disable_no_credit[] = $forms_disable_no_credit['form_code']."-DISABLE-ADD-NO-CREDIT";
		}
		$forms_with_disable_no_credit = "('" . implode("','", $forms_with_disable_no_credit) . "')";
		$application_forms = "SELECT tf.* FROM {$this->db->dbprefix}time_form tf
							LEFT JOIN {$this->db->dbprefix}time_form_class tfc ON tf.form_id = tfc.form_id
							LEFT JOIN {$this->db->dbprefix}time_form_class_policy tfcp ON tfc.class_id = tfcp.class_id
							LEFT JOIN {$this->db->dbprefix}users_profile up ON FIND_IN_SET(up.company_id, tfcp.company_id)
							LEFT JOIN {$this->db->dbprefix}partners prs ON up.user_id = prs.user_id
							LEFT JOIN {$this->db->dbprefix}users usr ON up.user_id = usr.user_id
							LEFT JOIN {$this->db->dbprefix}partners_personal pp ON prs.partner_id = pp.partner_id AND pp.key = 'gender'
							LEFT JOIN {$this->db->dbprefix}partners_personal pps ON prs.partner_id = pps.partner_id AND pps.key = 'solo_parent'
							WHERE tfc.class_code IN
							{$forms_with_disable_no_credit}
							AND ( tf.special_leave = 0 AND is_leave = 1)
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
							#AND IF(pps.key_value = 1, 1=1, tf.form_id != 16)
							ORDER BY tf.order_by, tf.form_id";

		$application_forms = $this->db->query($application_forms);
		return ($form_id != 0) ? $application_forms->row_array() : $application_forms->result_array();		 
	}

	public function get_policy_attachment($user_id=0,$type=""){
		$form_id = 0;
		// $forms_disable_no_credits = $this->get_form_type();

		$forms_with_disable_no_credit = array();
		// foreach($forms_disable_no_credits as $forms_disable_no_credit){
			$forms_with_disable_no_credit[] = strtoupper($type)."-REQUIRE-ATTACHMENT-DAYS";
		// }
		$forms_with_disable_no_credit = "('" . implode("','", $forms_with_disable_no_credit) . "')";
		$application_forms = "SELECT tfcp.* FROM {$this->db->dbprefix}time_form tf
							LEFT JOIN {$this->db->dbprefix}time_form_class tfc ON tf.form_id = tfc.form_id
							LEFT JOIN {$this->db->dbprefix}time_form_class_policy tfcp ON tfc.class_id = tfcp.class_id
							LEFT JOIN {$this->db->dbprefix}users_profile up ON FIND_IN_SET(up.company_id, tfcp.company_id)
							LEFT JOIN {$this->db->dbprefix}partners prs ON up.user_id = prs.user_id
							LEFT JOIN {$this->db->dbprefix}users usr ON up.user_id = usr.user_id
							LEFT JOIN {$this->db->dbprefix}partners_personal pp ON prs.partner_id = pp.partner_id AND pp.key = 'gender'
							LEFT JOIN {$this->db->dbprefix}partners_personal pps ON prs.partner_id = pps.partner_id AND pps.key = 'solo_parent'
							WHERE tfc.class_code IN
							{$forms_with_disable_no_credit}
							AND (is_leave = 1)
							AND up.user_id = {$user_id}
							AND tfcp.class_value = 0
							AND IF((tfcp.employment_status_id  != 'ALL') AND (prs.status_id IS NOT NULL AND LENGTH(prs.status_id) > 0), FIND_IN_SET(prs.status_id, tfcp.employment_status_id), 1)
							AND IF((tfcp.employment_type_id  != 'ALL') AND (prs.employment_type_id IS NOT NULL AND LENGTH(prs.employment_type_id) > 0), FIND_IN_SET(prs.employment_type_id, tfcp.employment_type_id), 1)
							AND IF((tfcp.role_id  != 'ALL') AND (usr.role_id IS NOT NULL AND LENGTH(usr.role_id) > 0), FIND_IN_SET(usr.role_id, tfcp.role_id), 1)
							AND IF((tfcp.division_id  != 'ALL') AND (up.division_id IS NOT NULL AND LENGTH(up.division_id) > 0), FIND_IN_SET(up.division_id, tfcp.division_id), 1)
							AND IF((tfcp.department_id  != 'ALL') AND (up.department_id IS NOT NULL AND LENGTH(up.department_id) > 0), FIND_IN_SET(up.department_id, tfcp.department_id), 1)
							AND IF((tfcp.group_id  != 'ALL') AND (up.group_id IS NOT NULL AND LENGTH(up.group_id) > 0), FIND_IN_SET(up.group_id, tfcp.group_id), 1)
							#AND IF((tfcp.project_id IS NOT NULL AND LENGTH(tfcp.project_id) > 0) AND (up.project_id IS NOT NULL AND LENGTH(up.project_id) > 0), FIND_IN_SET(up.project_id, tfcp.project_id), 1)
							AND IF(pp.key_value = 'Male', tf.only_female != 1, tf.only_male != 1)
							#AND IF(pps.key_value = 1, 1=1, tf.form_id != 16)
							ORDER BY tf.order_by, tf.form_id";
		$application_forms = $this->db->query($application_forms);
		return $application_forms->row_array();		 
	}

	public function get_policy_check_tenure($user_id=0){
		$form_id = 0;
		$forms_disable_no_credits = $this->get_form_type();

		$forms_with_disable_no_credit = array();
		foreach($forms_disable_no_credits as $forms_disable_no_credit){
			$forms_with_disable_no_credit[] = $forms_disable_no_credit['form_code']."-FILING-TENURE";
		}
		$forms_with_disable_no_credit = "('" . implode("','", $forms_with_disable_no_credit) . "')";
		$application_forms = "SELECT tf.*, tfc.*, tfcp.*, prs.* 
 							FROM {$this->db->dbprefix}time_form tf
							LEFT JOIN {$this->db->dbprefix}time_form_class tfc ON tf.form_id = tfc.form_id
							LEFT JOIN {$this->db->dbprefix}time_form_class_policy tfcp ON tfc.class_id = tfcp.class_id
							LEFT JOIN {$this->db->dbprefix}users_profile up ON FIND_IN_SET(up.company_id, tfcp.company_id)
							LEFT JOIN {$this->db->dbprefix}partners prs ON up.user_id = prs.user_id
							LEFT JOIN {$this->db->dbprefix}users usr ON up.user_id = usr.user_id
							LEFT JOIN {$this->db->dbprefix}partners_personal pp ON prs.partner_id = pp.partner_id AND pp.key = 'gender'
							LEFT JOIN {$this->db->dbprefix}partners_personal pps ON prs.partner_id = pps.partner_id AND pps.key = 'solo_parent'
							WHERE tfc.class_code IN
							{$forms_with_disable_no_credit}
							AND ( tf.special_leave = 0 AND is_leave = 1)
							AND up.user_id = {$user_id}
							AND tfcp.class_value > 0
							AND IF((tfcp.employment_status_id  != 'ALL') AND (prs.status_id IS NOT NULL AND LENGTH(prs.status_id) > 0), FIND_IN_SET(prs.status_id, tfcp.employment_status_id), 1)
							AND IF((tfcp.employment_type_id  != 'ALL') AND (prs.employment_type_id IS NOT NULL AND LENGTH(prs.employment_type_id) > 0), FIND_IN_SET(prs.employment_type_id, tfcp.employment_type_id), 1)
							AND IF((tfcp.role_id  != 'ALL') AND (usr.role_id IS NOT NULL AND LENGTH(usr.role_id) > 0), FIND_IN_SET(usr.role_id, tfcp.role_id), 1)
							AND IF((tfcp.division_id  != 'ALL') AND (up.division_id IS NOT NULL AND LENGTH(up.division_id) > 0), FIND_IN_SET(up.division_id, tfcp.division_id), 1)
							AND IF((tfcp.department_id  != 'ALL') AND (up.department_id IS NOT NULL AND LENGTH(up.department_id) > 0), FIND_IN_SET(up.department_id, tfcp.department_id), 1)
							AND IF((tfcp.group_id  != 'ALL') AND (up.group_id IS NOT NULL AND LENGTH(up.group_id) > 0), FIND_IN_SET(up.group_id, tfcp.group_id), 1)
							#AND IF((tfcp.project_id IS NOT NULL AND LENGTH(tfcp.project_id) > 0) AND (up.project_id IS NOT NULL AND LENGTH(up.project_id) > 0), FIND_IN_SET(up.project_id, tfcp.project_id), 1)
							AND IF(pp.key_value = 'Male', tf.only_female != 1, tf.only_male != 1)
							#AND IF(pps.key_value = 1, 1=1, tf.form_id != 16)
							ORDER BY tf.order_by, tf.form_id";
// echo "<pre>\n$application_forms";exit;
		$application_forms = $this->db->query($application_forms);
		return ($form_id != 0) ? $application_forms->row_array() : $application_forms->result_array();		 
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

	public function get_leave_balance($user_id=0, $date='', $form_id=0){	
		if($date == ''){
			$date = date('Y-m-d');
		}
        $leave_balance = $this->db->query("CALL sp_get_leave_balance('{$user_id}', '{$date}', {$form_id})");
        mysqli_next_result($this->db->conn_id);
		return $leave_balance->result_array();
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

	public function get_leave_duration($leave_duration_id = 0){		
		$where = array('deleted' => 0);
		if($leave_duration_id != 0) {$where = array('deleted' => 0, 'leave_duration_id' => $leave_duration_id);}
		$leave_duration_type = $this->db->get_where('time_leave_duration', $where);

		return $leave_duration_type->result_array();
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
		$shift_details_qry = "SELECT 
									p.user_id AS user_id, tr.date AS DATE, 
									tr.shift_id AS shift_id,
									IF(tr.aux_shift_id=0, tr.shift_id, tr.aux_shift_id) AS cur_shift_id,
									IF(IFNULL(ts_aux.time_start,'')='', ts.time_start, ts_aux.time_start) AS shift_time_start, 
									IF(IFNULL(ts_aux.time_end,'')='', ts.time_end, ts_aux.time_end) AS shift_time_end,
									IF(IFNULL(tr.aux_time_in,0)=0, IFNULL(tr.time_in, '-'), IF(tr.aux_time_in > tr.time_in, tr.time_in, tr.aux_time_in)) AS logs_time_in,  
									IF(IFNULL(tr.aux_time_out,0)=0, IFNULL(tr.time_out, '-') , IF(tr.aux_time_out < tr.time_out, tr.time_out, tr.aux_time_out)) AS logs_time_out
								FROM partners p
								LEFT JOIN time_shift ts ON p.shift_id = ts.shift_id
								LEFT JOIN time_record tr ON tr.user_id = p.user_id AND tr.`date`='{$date}'
								LEFT JOIN time_shift ts_aux ON IF(tr.aux_shift_id=0,tr.shift_id,tr.aux_shift_id) = ts_aux.shift_id
								WHERE p.user_id = {$user_id};
							";	     
		$shift_details = $this->db->query($shift_details_qry);

		if($shift_details->num_rows() == 0){
			$shift_details_qry = "SELECT partners.user_id AS user_id,'$date' AS DATE, ww_time_shift_weekly_calendar.shift_id AS shift_id,
									ww_time_shift.time_start AS shift_time_start, ww_time_shift.time_end AS shift_time_end,
									 '-' AS logs_time_in,  '-' AS logs_time_out
								 FROM partners 
								 LEFT JOIN ww_time_shift_weekly_calendar ON partners.calendar_id = ww_time_shift_weekly_calendar.calendar_id AND week_name = DAYNAME({$date})
								 LEFT JOIN ww_time_shift ON ww_time_shift_weekly_calendar.shift_id = ww_time_shift.shift_id
								 WHERE partners.user_id = $user_id";
			$shift_details = $this->db->query($shift_details_qry);
		}

		return $shift_details->row_array();
	}

	public function get_shift_policy($shift_id = false,$company_id = false,$class_code = false){
		if ($class_code){
			$this->db->where('class_code',$class_code);
		}
		$this->db->where('company_id',$company_id);
		$this->db->where('time_shift.shift_id',$shift_id);
		$this->db->join('time_shift_class_company','time_shift.shift_id = time_shift_class_company.shift_id');
		$this->db->join('time_shift_class','time_shift_class_company.class_id = time_shift_class.class_id');
		$result = $this->db->get('time_shift');
		if ($result && $result->num_rows() > 0){
			return $result->row_array();
		}

		return array();
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

		if($dtr_type){
			return $dtr_type['dtrp_type'];
		}
		return false;
	}

	public function check_ut_type($forms_id=0){			
		$query_ut = "SELECT IF(time_from = '0000-00-00 00:00:00' , 0, 1) AS ut_type
	    from {$this->db->dbprefix}time_forms_date
	    where forms_id = $forms_id";
		$ut_type = $this->db->query($query_ut)->row_array();

		if($ut_type){
			return $ut_type['ut_type'];
		}
		return false;
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

	public function check_rest_day($user_id=0, $date){	
		// $check_if_rest_day = "SELECT * FROM time_shift_rest_days WHERE user_id = $user_id";
		$check_if_rest_day_qry = "SELECT `date`, 
								IF( UPPER(aux_shift) IN ('OFF','RESTDAY'), 1, IF( aux_shift_id >  0, 0, IF(UPPER(shift) IN ('OFF','RESTDAY'), 1, 0)) ) restday
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
							      	AND emp_calendar.shift IN ('OFF','RESTDAY'))
							     LEFT JOIN ww_time_shift_weekly_calendar cws_calendar
							      ON ((cws_time_shift.default_calendar = cws_calendar.calendar_id)
							      	AND cws_calendar.shift IN ('OFF','RESTDAY'))
								LEFT JOIN time_record ON (partners.user_id = time_record.user_id
								AND time_record.date = '{$date}')
							     LEFT JOIN ww_time_shift tr_time_shift
							      ON ((time_record.aux_shift_id = tr_time_shift.shift_id))
							     LEFT JOIN ww_time_shift_weekly_calendar tr_calendar
							      ON ((tr_time_shift.default_calendar = tr_calendar.calendar_id)
								AND tr_calendar.shift IN ('OFF','RESTDAY'))
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

	public function get_pending_forms($date='', $user_id=0, $forms_id=0){
		$pending_forms = "SELECT * FROM time_forms_validate_if_exist WHERE date = '$date' AND user_id = $user_id ";
		$pending_forms = $this->db->query($pending_forms);
		if($pending_forms){
			return $pending_forms->result_array();
		}
	}

	function notify_approvers( $forms_id=0, $form=array())
	{
		$notified = array();

		$this->db->order_by('sequence', 'asc');
		$approvers = $this->db->get_where('time_forms_approver', array('forms_id' => $form['forms_id'], 'deleted' => 0));
	
		$first = true;
		foreach( $approvers->result() as $approver )
		{
			switch( $approver->condition )
			{
				case 'All':
				case 'Either Of';
					break;
				case 'By Level':
					if( !$first )
						continue;
					break;
			}

			$form_status = $form['form_status_id'] == 2 ? "Filed" : "Cancelled";
			
			$this->db->where('form_code',$form['form_code']);
			$this->db->where('deleted',0);
			$form_type = $this->db->get('time_form');
			$form_type = $form_type->row_array();

			$this->load->model('form_application_manage_model', 'formManage');

			//insert notification
			
			$insert = array(
				'status' => 'info',
				'message_type' => 'Time Record',
				'user_id' => $form['user_id'],
				'display_name' => $this->get_display_name($form['user_id']),
				'feed_content' => $form_status.': '.$form_type['form'].' for '.date('F d, Y', strtotime($form['date_from'])).'.<br><br>Reason: '.$form['reason'],
				'recipient_id' => $approver->user_id,
				'uri' => str_replace(base_url(), '', $this->formManage->url).'/detail/'.$form['forms_id']
			);
			$this->db->insert('system_feeds', $insert);
			$id = $this->db->insert_id();
			$this->db->insert('system_feeds_recipient', array('id' => $id, 'user_id' => $approver->user_id));
			
			$notified[] = $approver->user_id;

			$first = false;

		}

		return $notified;
	}

	function notify_filer( $forms_id=0, $form=array())
	{
		$notified = array();

        $this->lang->load( 'form_application' );
		$form_status = $form['form_status_id'] == 2 ? $this->lang->line('form_application.applied_for') : "Cancelled";

		//insert notification
		$insert = array(
			'status' => 'info',
			'message_type' => 'Time Record',
			'user_id' => $form['user_id'],
			'feed_content' => $form_status.' '.$form['form_code'],
			'recipient_id' => $form['user_id'],
			'uri' => str_replace(base_url(), '', $this->url).'/detail/'.$form['forms_id']
		);

		$this->db->insert('system_feeds', $insert);
		$id = $this->db->insert_id();
		$this->db->insert('system_feeds_recipient', array('id' => $id, 'user_id' => $form['user_id']));
		$notified[] = $form['user_id'];

		return $notified;
	}

	public function validate_ot_forms($date_from='', $date_to='', $user_id=0, $form_id=0, $forms_id=0){	                 
        $qry = "SELECT *
        FROM time_forms_date tfd
        JOIN time_forms tf ON tfd.forms_id = tf.forms_id
        WHERE tfd.deleted = 0 AND tf.deleted = 0 AND tf.form_status_id IN (2,3,4,5,6) AND tf.user_id = '{$user_id }' 
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

	public function check_time_record_workschedule($date='', $user_id=0){
		$time_record_workschedule_qry = "SELECT * FROM time_record WHERE date = '$date' AND user_id = $user_id";
		$time_record_workschedule = $this->db->query($time_record_workschedule_qry);
		if($time_record_workschedule){
			return $time_record_workschedule->result_array();	
		}	
		return false;
	}

	public function get_disapproved_cancelled_remarks($forms_id=0, $user_id=0){
		$disapproved_cancelled_remarks_qry = "SELECT CONCAT(firstname, ' ', lastname) as approver_name, tf.display_name AS employee_name, tfa.comment, tfs.form_status, tfa.comment_date as `date`
									FROM {$this->db->dbprefix}time_forms tf
									LEFT JOIN {$this->db->dbprefix}time_forms_approver tfa ON tf.`forms_id` = tfa.`forms_id`
									LEFT JOIN {$this->db->dbprefix}users_profile up ON tfa.`user_id` = up.`user_id`
									LEFT JOIN {$this->db->dbprefix}time_form_status tfs ON tf.`form_status_id` = tfs.`form_status_id`									
									WHERE tf.form_status_id IN (7,8) AND tf.deleted = 0
									AND tf.`forms_id` = $forms_id AND tfa.`form_status_id` IN (7,8)";

		$disapproved_cancelled_remarks = $this->db->query($disapproved_cancelled_remarks_qry);
		if($disapproved_cancelled_remarks->num_rows() > 0){
			return $disapproved_cancelled_remarks->result_array();
		}else{
			$disapproved_cancelled_remarks_qry = "SELECT CONCAT(firstname, ' ', lastname) as approver_name, tf.display_name AS employee_name,
											  IF(tf.form_status_id = 7, tfd.declined_comment, tfd.cancelled_comment) AS `comment` ,  
											  tfs.form_status, tfd.date as `date`
											  FROM   {$this->db->dbprefix}time_forms tf 
											  LEFT JOIN `{$this->db->dbprefix}time_forms_date` tfd 
											    ON tf.`forms_id` = tfd.`forms_id` 
											  LEFT JOIN {$this->db->dbprefix}time_form_status tfs 
											    ON tf.`form_status_id` = tfs.`form_status_id` 
											  LEFT JOIN {$this->db->dbprefix}users_profile up 
											  	ON tf.`user_id` = up.`user_id`
											  WHERE tf.form_status_id IN (7, 8) 
											  AND tf.deleted = 0 
											  AND tf.`forms_id` = $forms_id ";

			$disapproved_cancelled_remarks = $this->db->query($disapproved_cancelled_remarks_qry);
			if($disapproved_cancelled_remarks){
				return $disapproved_cancelled_remarks->result_array();
			}
		}
		return false;
	}


	public function get_period_list(){

		$data = array();

		$qry = "SELECT `record_id`,`period_id`,`period_year`,`payroll_date`,`from`,`to` 
				FROM time_period_list  tpl 
				JOIN users_profile up ON up.company_id =  tpl.`company_id`  
				AND up.`user_id` = '".$this->user->user_id."'
				LIMIT 5";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}

    function get_ot_leave_credits($user_id=0,$form_id=0, $used_by_form=0){
        $data = array();
        $current_day = date('Y-m-d');

        $qry = "SELECT tfol.*, tf.date_from, IFNULL( IF(tfolu.used_by_form = 0 OR tfolu.used_by_form IS NULL, credit, (credit - tfolu.used) ),0) AS balance
        FROM {$this->db->dbprefix}time_forms_ot_leave tfol 
        INNER JOIN {$this->db->dbprefix}time_forms tf on tfol.forms_id = tf.forms_id
        LEFT JOIN {$this->db->dbprefix}time_forms_ot_leave_used tfolu ON tfol.forms_id = tfolu.forms_id ";
        if($used_by_form > 0){
        	$qry .= "
        	AND ( tfolu.used_by_form = {$used_by_form} ) ";
        }
        $qry .= "
        WHERE tf.user_id={$user_id} AND tf.form_id = {$form_id} AND tf.form_status_id = 6
        AND ( ( ((credit - tfol.used ) > 0 OR tfol.used_by_form = 0) 
        		AND expiration_date >= '{$current_day}' ) ";
        if($used_by_form > 0){
        	$qry .= " OR ( tfolu.used_by_form = {$used_by_form} ) ";
        }
        $qry .= " )";

// echo "<pre>\n$qry";
        $result = $this->db->query($qry);        
        if($result->num_rows() > 0){
                
            foreach($result->result_array() as $row){
                $data[] = $row;
            }           
        }
            
        $result->free_result();
        return $data;   
    }

    function get_selected_leave_credits($user_id=0,$form_id=0, $forms_id='', $used_by_form=0){
        $data = array();

        $qry = "SELECT tfol.*, tf.date_from, IF( tfolu.used_by_form = 0 OR tfolu.used_by_form = {$used_by_form}, credit, (credit - tfolu.used )) as balance
        FROM {$this->db->dbprefix}time_forms_ot_leave tfol 
        INNER JOIN {$this->db->dbprefix}time_forms tf on tfol.forms_id = tf.forms_id
        LEFT JOIN {$this->db->dbprefix}time_forms_ot_leave_used tfolu ON tfol.forms_id = tfolu.forms_id
        WHERE tf.user_id={$user_id} AND tf.form_id = {$form_id} AND tf.form_status_id = 6
         "; // WHERE user_id = '$userID';
        
        if(strlen($forms_id) > 0){
        	$qry .= " AND tfol.forms_id IN ( {$forms_id} ) ";
        }
        if($used_by_form > 0){
        	$qry .= " AND ( tfolu.used_by_form = {$used_by_form} ) ";
        }

// echo "<pre>\n$qry";
        $result = $this->db->query($qry);        
        if($result->num_rows() > 0){
                
            foreach($result->result_array() as $row){
                $data[] = $row;
            }           
        }
            
        $result->free_result();
        return $data;   
    }

    public function time_forms_get_application($user_id=0, $date=''){	
		if($date == ''){
			$date = date('Y-m-d');
		}

        $get_application = $this->db->query("CALL sp_time_forms_get_application('{$user_id}', '{$date}')");
        mysqli_next_result($this->db->conn_id);

        if($get_application && $get_application->num_rows() > 0) {
        	return true;
        } else {
        	return false;
        }
	}

	public function get_form_statuses(){
		$this->db->order_by('form_status');
		$result = $this->db->get('time_form_status');
		if ($result && $result->num_rows() > 0){
			return $result;
		}
		else{
			return false;
		}
	}
}