

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

function _get_list($start, $limit, $search, $trash = false,$form_id)
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

        if( $form_id > 0 ){

            $qry .= " AND {$this->db->dbprefix}{$this->table}.form_id = ".$form_id;

        }

        $qry .= " AND {$this->db->dbprefix}{$this->table}.user_id = ".$this->user->user_id;
        $qry .= " ORDER BY {$this->db->dbprefix}{$this->table}.date_from DESC ";
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

    public function check_if_rest_day($user_id=0){  
        $check_if_rest_day_qry = "SELECT * FROM time_shift_rest_days WHERE user_id = $user_id";
        $check_if_rest_day = $this->db->query($check_if_rest_day_qry);

        if($check_if_rest_day){
            return $check_if_rest_day->result_array();
        }
        return false;   
    }


    public function check_if_holiday($date='', $user_id=0){
        $check_if_holiday_qry = "SELECT * FROM time_holiday WHERE holiday_date = '$date'";
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
        $pending_forms = "SELECT * FROM time_forms_validate_if_exist WHERE date = '$date' AND user_id = $user_id AND forms_id != $forms_id";
        $pending_forms = $this->db->query($pending_forms);
        if($pending_forms){
            return $pending_forms->result_array();
        }
    }

    function notify_approvers( $forms_id=0, $form=array())
    {
        $notified = array();

        $this->db->order_by('sequence', 'asc');
        $approvers = $this->db->get_where('time_forms_approver', array('forms_id' => $forms_id, 'deleted' => 0));
    
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

            $form_status = $form['form_status_id'] == 2 ? "Applied for" : "Cancelled";
            //insert notification
            $insert = array(
                'status' => 'info',
                'message_type' => 'Time Record',
                'user_id' => $form['user_id'],
                'feed_content' => $form_status.' '.$form['form_code'],
                'recipient_id' => $approver->user_id
            );

            $this->db->insert('system_feeds', $insert);
            $id = $this->db->insert_id();
            $this->db->insert('system_feeds_recipient', array('id' => $id, 'user_id' => $approver->user_id));
            $notified[] = $approver->user_id;

            $first = false;

        }

        return $notified;
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

    public function check_time_record_workschedule($date='', $user_id=0){
        $time_record_workschedule_qry = "SELECT * FROM time_record WHERE date = '$date' AND user_id = $user_id";
        $time_record_workschedule = $this->db->query($time_record_workschedule_qry);
        if($time_record_workschedule){
            return $time_record_workschedule->result_array();   
        }   
        return false;
    }

    public function get_disapproved_cancelled_remarks($forms_id=0, $user_id=0){
        $disapproved_cancelled_remarks_qry = "SELECT CONCAT(firstname, ' ', lastname) as approver_name, tfa.comment, tfs.form_status
                                    FROM {$this->db->dbprefix}time_forms tf
                                    LEFT JOIN {$this->db->dbprefix}time_forms_approver tfa ON tf.`forms_id` = tfa.`forms_id`
                                    LEFT JOIN {$this->db->dbprefix}users_profile up ON tfa.`user_id` = up.`user_id`
                                    LEFT JOIN {$this->db->dbprefix}time_form_status tfs ON tf.`form_status_id` = tfs.`form_status_id`                                   
                                    WHERE tf.form_status_id IN (7,8) AND tf.deleted = 0
                                    AND tf.`forms_id` = $forms_id AND tfa.`form_status_id` IN (7,8)";

        $disapproved_cancelled_remarks = $this->db->query($disapproved_cancelled_remarks_qry);
        if($disapproved_cancelled_remarks->num_rows() > 0){
            return $disapproved_cancelled_remarks->row_array(); 
        }else{
            $disapproved_cancelled_remarks_qry = "SELECT CONCAT(firstname, ' ', lastname) as approver_name,
                                              IF(tf.form_status_id = 7, tfd.declined_comment, tfd.cancelled_comment) AS `comment` ,  
                                              tfs.form_status 
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
                return $disapproved_cancelled_remarks->row_array(); 
            }
        }
        return false;
    }


