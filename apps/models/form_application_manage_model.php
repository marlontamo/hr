<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class form_application_manage_model extends Record
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
		$this->mod_id = 44;
		$this->mod_code = 'form_application_manage';
		$this->route = 'time/applicationmanage';
		$this->url = site_url('time/applicationmanage');
		$this->primary_key = 'forms_id';
		$this->table = 'time_forms';
		$this->icon = '';
		$this->short_name = 'Application';
		$this->long_name  = 'Application';
		$this->description = '';
		$this->path = APPPATH . 'modules/form_application_manage/';

		parent::__construct();
	}

function _get_list($start, $limit, $search, $trash = false,$filters)
{
	$data = array();				
	
	$qry = $this->_get_list_cached_query();
	$qry .= " WHERE approver_id = {$this->user->user_id}";

	if($filters != "" & $filters != "form_id=0")
	{	
		if ($filters == "approver_status_id=8")
			$qry .= " AND form_status_id=8";
		else
			$qry .= $filters;
			// $qry .= " AND " . $filters;	
	}

    if( $search ){
    	$qry .= " AND ( display_name LIKE '%".$search."%' OR form LIKE '%".$search."%' OR form_status LIKE '%".$search."%' OR date_range LIKE '%".$search."%' )";
    }
    //$qry .= " AND form_code <> 'DTRU'"; // exclude DTRU
    $qry .= " ORDER BY created_on DESC ";
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
	return 'SELECT * FROM `time_forms_manage`';
}

function setDecission($decission){

		$data = array();
		
		$qry = "CALL sp_time_forms_approval('".$decission['formid']."', '".$decission['userid']."', '".$decission['decission']."', '".(isset($decission['comment']) ? $decission['comment'] : '')."')";
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
	$this->load->model('form_application_model', 'formApp');
		$qry = "INSERT INTO ww_system_feeds 
				(
					status
					, message_type
					, user_id
					, display_name
					, feed_content
					, recipient_id
					, uri
				) 
				VALUES
				(
					'" . $data['status'] . "',
					'" . $data['message_type'] . "',
					'" . $data['user_id'] . "',
					'" . $data['display_name'] . "',
					'" . $data['feed_content'] . "',
					'" . $data['recipient_id'] . "',
					'" . str_replace(base_url(), '', $this->formApp->url).'/detail/'.$data['forms_id'] . "'					
				)";
		
		$this->db->query($qry);                                  
		
		return $this->db->insert_id();
	}

public function get_form_approver_info( $forms_id = 0, $user_id = 0 ){


	$form = $this->db->query("SELECT * FROM time_forms_manage WHERE forms_id=".$forms_id." AND approver_id=".$user_id);
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

	public function get_leave_balance($user_id=0, $date='', $form_id=0){	
		$date = date('Y-m-d');
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
									p.shift_id AS shift_id,
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
							      	AND emp_calendar.shift IN ('OFF','RESTDAY') )
							     LEFT JOIN ww_time_shift_weekly_calendar cws_calendar
							      ON ((cws_time_shift.default_calendar = cws_calendar.calendar_id)
							      	AND cws_calendar.shift IN ('OFF','RESTDAY') )
								LEFT JOIN time_record ON (partners.user_id = time_record.user_id
								AND time_record.date = '{$date}')
							     LEFT JOIN ww_time_shift tr_time_shift
							      ON ((time_record.aux_shift_id = tr_time_shift.shift_id))
							     LEFT JOIN ww_time_shift_weekly_calendar tr_calendar
							      ON ((tr_time_shift.default_calendar = tr_calendar.calendar_id)
								AND tr_calendar.shift IN ('OFF','RESTDAY') )
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

	function get_approver_remarks($forms_id=0){			
		$comments_query = "SELECT CONCAT( firstname , ' ', lastname ) AS display_name, comment, 
							form_status_id, time_forms_approver.user_id AS approver_id,
							time_forms_approver.comment_date,form_status
	    					FROM {$this->db->dbprefix}time_forms_approver time_forms_approver 
							LEFT JOIN {$this->db->dbprefix}users_profile users_profile 
							ON time_forms_approver.user_id = users_profile.user_id
					        WHERE forms_id= $forms_id
        					AND (form_status_id = 6 OR form_status_id = 7)
        					AND deleted = 0
        					ORDER BY time_forms_approver.id ";
		$comments = $this->db->query($comments_query);
        $comments = $comments->result_array();
		return $comments;
	}

	public function get_disapproved_cancelled_remarks($forms_id=0, $user_id=0){
		$disapproved_cancelled_remarks_qry = "SELECT CONCAT(firstname, ' ', lastname) as approver_name, tf.display_name AS employee_name, tfa.comment, tfs.form_status, tfa.comment_date as `date`
									FROM {$this->db->dbprefix}time_forms tf
									LEFT JOIN {$this->db->dbprefix}time_forms_approver tfa ON tf.`forms_id` = tfa.`forms_id`
									LEFT JOIN {$this->db->dbprefix}users_profile up ON tfa.`user_id` = up.`user_id`
									LEFT JOIN {$this->db->dbprefix}time_form_status tfs ON tf.`form_status_id` = tfs.`form_status_id`									
									WHERE tf.form_status_id IN (8) AND tf.deleted = 0
									AND tf.`forms_id` = $forms_id AND tfa.`form_status_id` IN (8)";

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
											  WHERE tf.form_status_id IN (8) 
											  AND tf.deleted = 0 
											  AND tf.`forms_id` = $forms_id ";

			$disapproved_cancelled_remarks = $this->db->query($disapproved_cancelled_remarks_qry);
			if($disapproved_cancelled_remarks){
				return $disapproved_cancelled_remarks->result_array();
			}
		}
		return false;
	}

	function get_approver_details($forms_id=0, $user_id=0){			
		$approver_query = "SELECT *
	    					FROM {$this->db->dbprefix}time_forms_approver  
					        WHERE forms_id= $forms_id
        					AND user_id = $user_id
        					AND deleted = 0";
		$current_approver_display = $this->db->query($approver_query);
        $approver_details = $current_approver_display->row_array();
		return $approver_details;
	}

	function get_leave_details($forms_id=0, $user_id=0){			
		$form_details_qry = "SELECT time_forms.*, approver.user_id as approver_id
								,time_form.form
	    					FROM time_forms  
	    					LEFT JOIN {$this->db->dbprefix}time_forms_approver approver
	    					ON time_forms.forms_id = approver.forms_id
	    					LEFT JOIN {$this->db->dbprefix}time_form time_form
	    					ON time_forms.form_id = time_form.form_id
					        WHERE time_forms.forms_id= $forms_id
					        AND approver.user_id = $user_id
        					AND time_forms.deleted = 0";
        					
		$form_details_sql = $this->db->query($form_details_qry);
        $form_details = $form_details_sql->row_array();
		return $form_details;
	}

	function get_obt_details($forms_id=0, $user_id=0){			
		$form_details_qry = "SELECT time_forms.*, forms_date.time_from, forms_date.time_to, 
								forms_obt.location, approver.user_id as approver_id
								,time_form.form, forms_obt.company_to_visit
	    					FROM time_forms  
	    					LEFT JOIN {$this->db->dbprefix}time_forms_date forms_date
	    					ON time_forms.forms_id = forms_date.forms_id
	    					LEFT JOIN {$this->db->dbprefix}time_forms_obt forms_obt
	    					ON time_forms.forms_id = forms_obt.forms_id
	    					LEFT JOIN {$this->db->dbprefix}time_forms_approver approver
	    					ON time_forms.forms_id = approver.forms_id
	    					LEFT JOIN {$this->db->dbprefix}time_form time_form
	    					ON time_forms.form_id = time_form.form_id
					        WHERE time_forms.forms_id= $forms_id
					        AND approver.user_id = $user_id
        					AND time_forms.deleted = 0";
        					
		$form_details_sql = $this->db->query($form_details_qry);
        $form_details = $form_details_sql->row_array();
		return $form_details;
	}

	function get_ot_ut_dtrp_details($forms_id=0, $user_id=0){			
		$form_details_qry = "SELECT time_forms.*, forms_date.time_from, forms_date.time_to, 
								 approver.user_id as approver_id
								,time_form.form
	    					FROM time_forms  
	    					LEFT JOIN {$this->db->dbprefix}time_forms_date forms_date
	    					ON time_forms.forms_id = forms_date.forms_id
	    					LEFT JOIN {$this->db->dbprefix}time_forms_approver approver
	    					ON time_forms.forms_id = approver.forms_id
	    					LEFT JOIN {$this->db->dbprefix}time_form time_form
	    					ON time_forms.form_id = time_form.form_id
					        WHERE time_forms.forms_id= $forms_id
					        AND approver.user_id = $user_id
        					AND time_forms.deleted = 0";
		$form_details_sql = $this->db->query($form_details_qry);
        $form_details = $form_details_sql->row_array();
		return $form_details;
	}

	function get_cws_details($forms_id=0, $user_id=0){			
		$form_details_qry = "SELECT time_forms.*, forms_date.time_from, forms_date.time_to, 
								 approver.user_id as approver_id, forms_date.date,
								 shift.shift as curr_shift, shiftto.shift as to_shift
								,time_form.form
	    					FROM time_forms  
	    					LEFT JOIN {$this->db->dbprefix}time_forms_date forms_date
	    					ON time_forms.forms_id = forms_date.forms_id
	    					LEFT JOIN {$this->db->dbprefix}time_forms_approver approver
	    					ON time_forms.forms_id = approver.forms_id
	    					LEFT JOIN {$this->db->dbprefix}time_shift shift
	    					ON forms_date.shift_id = shift.shift_id 
	    					LEFT JOIN {$this->db->dbprefix}time_shift shiftto
	    					ON forms_date.shift_to = shiftto.shift_id 
	    					LEFT JOIN {$this->db->dbprefix}time_form time_form
	    					ON time_forms.form_id = time_form.form_id
					        WHERE time_forms.forms_id= $forms_id
					        AND approver.user_id = $user_id
        					AND time_forms.deleted = 0";
        					
		$form_details_sql = $this->db->query($form_details_qry);
        $form_details = $form_details_sql->row_array();
		return $form_details;
	}

	public function get_form_information($forms_id=0){	
		$this->db->select('*')
	    ->from('time_forms')
	    ->join('time_form', 'time_forms.form_id=time_form.form_id', 'left')
	    ->where('forms_id', $forms_id);
		$form_info=$this->db->get('');	
		return $form_info->row_array();
	}

	public function get_users_info($user_id=0){
		$this->db->where('user_id',$user_id);
		$user_info = $this->db->get('users_profile');

		return $user_info->row_array();
	}

	function get_form_approvers($forms_id){			
		$form_approver_qry = "SELECT tfa.`user_id` AS approver_id, tfa.`condition`, tfa.sequence, up.lastname, up.firstname, usp.position
								FROM ww_time_forms_approver tfa
								INNER JOIN users_profile up ON tfa.`user_id` = up.user_id
								LEFT JOIN ww_users_position usp ON up.position_id = usp.position_id
								WHERE forms_id = {$forms_id} 
								ORDER BY tfa.sequence";
        					
		$form_approver_sql = $this->db->query($form_approver_qry);
        $approver_details = $form_approver_sql->result_array();
		return $approver_details;
	}

	function checkIfapprover($userID){

		$data = array();

		$qry = "SELECT * FROM dashboard_todos WHERE approver_id = '$userID' ";
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
		
		$result->free_result();
		return $data;	
	}

	function transfer_to_validation($form_details=array()){
		if($form_details['hr_validation'] == 1){
			$data = array( 'form_status_id' => 4 ); // set status to 'For Validation'
			$this->db->update( 'time_forms', $data, array('forms_id' => $form_details['forms_id']) );

            $data['user_id']        	= $form_details['user_id'];                                // THE CURRENT LOGGED IN USER 
            $data['display_name']   	= $form_details['display_name'];  // THE CURRENT LOGGED IN USER'S DISPLAY NAME
            $data['feed_content']  		= 'Your '.$form_details['form'].
            							' has now been approved and is now for HR validation';                                                           // THE MAIN FEED BODY
            $data['recipient_id']   	= $form_details['user_id'];                                                               // TO WHOM THIS POST IS INTENDED TO
            $data['status']         	= 'info';                                                                   // DANGER, INFO, SUCCESS & WARNING
            $data['message_type']       = 'Time Record';
            $data['forms_id'] 			= $form_details['forms_id'];
	            
            // ADD NEW DATA FEED ENTRY
            $latest = $this->newPostData($data);

            $this->notify_hr_validation($form_details);
		}else{
			if($form_details['form_code'] == 'ADDL'){
				$this->leave_convert($form_details);
			}
		}
	}

	function remove_additiona_leave($form_details=array()){
		if($form_details['form_code'] == 'ADDL'){
			$this->db->update( 'time_forms_ot_leave', array('used_by_form' => 0), array( 'used_by_form' => $form_details['forms_id']) );    
		}	
	}

	function notify_hr_validation($form_details=array()){
		$hr_validation_emails = $this->get_policy_hr_validation_emails($form_details);
		if( array_key_exists('class_value', $hr_validation_emails) ){
			$acct_emails = $hr_validation_emails['class_value'];
			$acct_ArrayedEmails = explode(',', $hr_validation_emails['class_value']);

			foreach( $acct_ArrayedEmails as $index => $email )
			{
				$users = $this->db->get_where( 'users', array('email' => trim($email)) )->row();

	            $data['user_id']        	= $users->user_id;                                // THE CURRENT LOGGED IN USER 
	            $data['display_name']   	= $users->full_name;  // THE CURRENT LOGGED IN USER'S DISPLAY NAME
	            $data['feed_content']  		= $form_details['form'].' filed by '.$form_details['display_name'].
	            							'has now been approved and is now for HR validation';                                                           // THE MAIN FEED BODY
	            $data['recipient_id']   	= $users->user_id;                                                               // TO WHOM THIS POST IS INTENDED TO
	            $data['status']         	= 'info';                                                                   // DANGER, INFO, SUCCESS & WARNING
	            $data['message_type']       = 'Time Record';
	            $data['forms_id'] 			= $form_details['forms_id'];
	            
	            // ADD NEW DATA FEED ENTRY
	            $latest = $this->newPostData($data);
				$sp_time_forms_email_hr_validation = $this->db->query("CALL sp_time_forms_email_hr_validation({$form_details['forms_id']}, {$users->user_id})");
				mysqli_next_result($this->db->conn_id);
			}
		}
	}

	public function get_policy_hr_validation_emails($form_details=array()){
		$form_id = 0;
		// $forms_disable_no_credits = $this->get_form_type();

		$forms_with_disable_no_credit = array();
		// foreach($forms_disable_no_credits as $forms_disable_no_credit){
			$forms_with_disable_no_credit[] = $form_details['form_code']."-HR-VALIDATION-EMAILS";
		// }
		$forms_with_disable_no_credit = "('" . implode("','", $forms_with_disable_no_credit) . "')";
		$application_forms = "SELECT tfcp.* 
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
							AND up.user_id = {$form_details['user_id']}
							AND tfcp.class_value != ''
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

		$application_forms = $this->db->query($application_forms);
		return $application_forms->row_array();	 
	}

	function notify_accounting($form_details=array()){
		$accounting_emails = $this->get_policy_accounting_emails($form_details);
		if( array_key_exists('class_value', $accounting_emails) ){
			$acct_emails = $accounting_emails['class_value'];
			$acct_ArrayedEmails = explode(',', $accounting_emails['class_value']);

			foreach( $acct_ArrayedEmails as $index => $email )
			{
				$users = $this->db->get_where( 'users', array('email' => trim($email)) )->row();

	            if(isset($users->user_id)){
		            $data['user_id']        	= $users->user_id;                                // THE CURRENT LOGGED IN USER 
		            $data['display_name']   	= $users->full_name;  // THE CURRENT LOGGED IN USER'S DISPLAY NAME
		            $data['feed_content']  		= 'Business Trip form filed by '.$form_details['display_name'].
		            							'has now been approved and is now for processing';                                                           // THE MAIN FEED BODY
		            $data['recipient_id']   	= $users->user_id;                                                               // TO WHOM THIS POST IS INTENDED TO
		            $data['status']         	= 'info';                                                                   // DANGER, INFO, SUCCESS & WARNING
		            $data['message_type']       = 'Time Record';
		            $data['forms_id'] 			= $form_details['forms_id'];
		            
		            // ADD NEW DATA FEED ENTRY
		            $latest = $this->newPostData($data);
					$sp_time_forms_email_accounting = $this->db->query("CALL sp_time_forms_email_accounting({$form_details['forms_id']}, {$users->user_id})");	
					mysqli_next_result($this->db->conn_id);
				}
			}
		}
	}

	public function get_policy_accounting_emails($form_details=array()){
		$form_id = 0;
		// $forms_disable_no_credits = $this->get_form_type();

		$forms_with_disable_no_credit = array();
		// foreach($forms_disable_no_credits as $forms_disable_no_credit){
			$forms_with_disable_no_credit[] = $form_details['form_code']."-ACCOUNTING-EMAILS";
		// }
		$forms_with_disable_no_credit = "('" . implode("','", $forms_with_disable_no_credit) . "')";
		$application_forms = "SELECT tfcp.* 
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
							AND up.user_id = {$form_details['user_id']}
							AND tfcp.class_value != ''
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

		$application_forms = $this->db->query($application_forms);
		return $application_forms->row_array();	 
	}

	function leave_convert($form_details=array())
    {       
        $transpo_record['remarks'] = $form_details['form']. ' Approved' ;
        $transpo_record['status_id'] = $form_details['form_status_id'];

        $this->load->model('time_form_processes_model', 'time_process');
        $this->time_process->leave_conversion_processes($form_details, $transpo_record); 

        if($form_details['type'] == 'File'){           
            $ot_record = array(
                'expiration_date'   => date("Y-m-d", strtotime("+3 month", strtotime($form_details['date_to'])))
            );
            $this->db->update( 'time_forms_ot_leave', $ot_record, array( 'forms_id' => $form_details['forms_id'] ) );
        }
    }
}