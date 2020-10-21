<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Form_application extends MY_PrivateController
{
    public function __construct()
    {
        $this->load->model('form_application_manage_model', 'app_manage');
        $this->load->model('form_application_admin_model', 'app_admin');        
        $this->load->model('form_application_model', 'mod');
        $this->load->library('time_form_policies');
        parent::__construct();
        $this->lang->load( 'form_application' );
    }

    public function index()
    {

        if( !$this->permission['list'] )
        {
            echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
            die();
        }
        $user_setting = APPPATH . 'config/users/'. $this->user->user_id .'.php';
        $user_id = $this->user->user_id;
        $this->load->config( "users/{$user_id}.php", false, true );
        $user = $this->config->item('user');

        $this->load->config( 'roles/'. $user['role_id'] .'/permission.php', false, true );
        $permission = $this->config->item('permission');
        $data['permission_app_manage'] = isset($permission[$this->app_manage->mod_code]['list']);

        if(!$data['permission_app_manage']){
            if($this->check_reassign_approvals() > 0){
                $data['permission_app_manage'] = 1;
            }
        }

        $data['permission_app_admin'] = isset($permission[$this->app_admin->mod_code]['list']) ? $permission[$this->app_admin->mod_code]['list'] : 0;
        $data['permission_app_personal'] = isset($this->permission['list']) ? $this->permission['list'] : 0;

        $this->load->model('leave_convert_model', 'leave_convert');
        $data['leave_convert'] = isset($permission[$this->leave_convert->mod_code]['list']) ? $permission[$this->leave_convert->mod_code]['list'] : 0;

        $this->load->model('forms_request_model', 'forms_req');
        $data['permission_app_request'] = isset($permission[$this->forms_req->mod_code]['list']) ? $permission[$this->forms_req->mod_code]['list'] : 0;
        $this->load->model('hr_validation_model', 'hr_valid');
        $data['permission_validation'] = isset($permission[$this->hr_valid->mod_code]['list']) ? $permission[$this->hr_valid->mod_code]['list'] : 0;
        
        $this->load->model('my_calendar_model', 'my_calendar');
        $form_list = $this->my_calendar->get_form_policy_grant($this->user->user_id);
        $data['status'] = $this->my_calendar->get_form_status($this->user->user_id); // for status filter

        $this->load->model('form_application_model', 'form_application');
        $data['form_status'] = $this->form_application->get_form_statuses();

        $this->load->model('my201_model', 'profile_mod');

        $data['leave_forms'] = array();
        $data['other_forms'] = array();
        foreach($form_list as $index => $field )
        {
            if($field['is_leave'] == 1){
                if ($field['form_code'] == 'HL'){
                    $home_leave = $this->profile_mod->get_partners_personal($this->user->user_id, 'home_leave');
                    if (count($home_leave) > 0 && $home_leave[0]['key_value'] == 1){
                        $data['leave_forms'][$field['form_id']] = $field['form'];
                    }
                }
                else{
                    $data['leave_forms'][$field['form_id']] = $field['form'];
                }
            }else{
                $data['other_forms'][$field['form_id']] = $field['form'];
            }
        }

        // Pay period filter
        // limited to 5 paydates
        $data['pay_dates'] = $this->mod->get_period_list();

        $this->load->vars($data);        
        echo $this->load->blade('listing_custom')->with( $this->load->get_cached_vars() );
    }

    function add( $type = "" ){

        if( $type == "" ){

            $specialLeaves = $this->mod->get_specialLeaves_policy_grant($this->user->user_id);
            $regularLeaves = $this->mod->get_regularLeaves_policy_grant($this->user->user_id);
            $otherForms = $this->mod->get_otherForms_policy_grant($this->user->user_id);
            $no_credit_disable = array();
            $disable_no_credit = $this->mod->get_policy_disable_no_credit($this->user->user_id);
            foreach($disable_no_credit as $disable){
                $no_credit_disable[$disable['form_id']] = 0;

                $balance_data = $this->mod->get_leave_balance($this->user->user_id, date('Y-m-d'), $disable['form_id']);

                if(sizeof($balance_data) > 0){
                    // $balance_record = $balance_data[0];
                    foreach($balance_data as $balance){
                        if(array_key_exists($disable['form_id'], $no_credit_disable)){
                            $no_credit_disable[$disable['form_id']] = $no_credit_disable[$disable['form_id']] + $balance['balance'];
                        }else{
                            $no_credit_disable[$disable['form_id']] = $balance['balance'];
                        }
                    }
                }
            }

            $check_tenure =  array();
            $policy_check_tenure = $this->mod->get_policy_check_tenure($this->user->user_id);
            if(count($policy_check_tenure) > 0){
                foreach($policy_check_tenure as $policy_tenure){
                    $check_tenure[$policy_tenure['form_id']] = 0;
                    
                    $present_date = date('Y-m-d');
                    $date1 = $policy_tenure['effectivity_date'];
                    $date2 = $present_date;

                    $ts1 = strtotime($date1);
                    $ts2 = strtotime($date2);
                    
                    $year1 = date('Y', $ts1);
                    $year2 = date('Y', $ts2);
                    $month1 = date('m', $ts1);
                    $month2 = date('m', $ts2);

                    $months_stayed = (($year2 - $year1) * 12) + ($month2 - $month1);

                    if($months_stayed < $policy_tenure['class_value']){
                        $no_credit_disable[$policy_tenure['form_id']] = 0;
                    }
                }
            }
            
            $this->load->model('my_calendar_model', 'my_calendar');
            $form_info = $this->my_calendar->get_form_policy_grant($this->user->user_id);
            // $form_info = $this->mod->get_form_info();

            $form_status = $this->mod->get_form_status($this->user->user_id);

            $data['form_status'] = $form_status;
            $data['form_info'] = $form_info;
            $data['specialLeaves'] = $specialLeaves;
            $data['regularLeaves'] = $regularLeaves;
            $data['otherForms'] = $otherForms;
            $data['no_credit_disable'] = $no_credit_disable;

            $this->load->model('my_calendar_model', 'my_calendar');
            $form_list = $this->my_calendar->get_form_policy_grant($this->user->user_id);
            
            $data['leave_forms'] = array();
            $data['other_forms'] = array();
            foreach($form_list as $index => $field )
            {
                if($field['is_leave'] == 1){
                    $data['leave_forms'][] = $field['form_id'];
                }else{
                    $data['other_forms'][] = $field['form_id'];
                }
            }

            $this->load->model('timerecord_model', 'timerecord');
            $updating = $this->db->get_where('time_form', array('form_code' => 'DTRU', 'deleted' => 0));
            $data['is_dtru_applicable'] = $this->timerecord->is_dtru_applicable();
            $data['updating'] = $updating;

            $this->load->vars($data);

            $this->load->helper('form');
            $this->load->helper('file');
            if( $this->input->post('mobileapp') )
            {
                ob_start();
                echo $this->load->blade('form_list_mobile')->with( $this->load->get_cached_vars() );
                $this->response->forms = ob_get_clean();
                $this->response->message[] = array(
                    'message' => '',
                    'type' => 'success'
                );
                $this->_ajax_return();
            }
            else
                echo $this->load->blade('form_list_custom')->with( $this->load->get_cached_vars() );

        }
        else{

            parent::add('',true);

            $form_info = $this->mod->get_form_info($type);

            require( APPPATH . 'modules/'. $this->mod->mod_code .'/config/field_groups.php' );
            $fieldgroups = $config['fieldgroups'];
            $fg_fields_array = $fieldgroups[$form_info['form_id']]['fields'];

            require( APPPATH . 'modules/'. $this->mod->mod_code .'/config/fields.php' );
            $fields = $config['fields'];

            $data = array();

            $data['url'] = $this->mod->url;
            $data['form_status_id']["val"] = 1;
            $data['form_id'] = $form_info['form_id'];
            $data['form_code'] = $form_info['form_code'];
            $data['form_title'] = $form_info['form'].' '.lang('form_application.form');
            $data['upload_id']["val"] = array();
            $data['duration'] = $this->mod->get_duration();           
            $data['leave_balance'] = $this->mod->get_leave_balance($this->user->user_id, date('Y-m-d'), 0);
            $special_qry = "SELECT * FROM {$this->db->dbprefix}time_form_balance tfb
                    INNER JOIN {$this->db->dbprefix}time_form tf ON tf.form_id = tfb.form_id
                    WHERE user_id = {$this->user->user_id}
                    AND tf.special_leave = 1
                    AND tfb.year = '".date('Y')."'";
            $data['special_leaves'] = array();
            $special_leaves = $this->db->query($special_qry);
            if($special_leaves->num_rows > 0){
                $data['special_leaves'] = $special_leaves->result_array();
            }
            $data['back_url'] = get_mod_route('form_application').'/add';
            $policy_attachment = $this->mod->get_policy_attachment($this->user->user_id, $type);

            $data['policy_attachment'] = count($policy_attachment);

            switch( $form_info['form_id'] ){
                case get_time_form_id('OBT'): //OBT
                    $data['bt_type'] = 1;
                    $data['request_status_id'] = 1;
                    $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d"), $this->user->user_id);
                    $data['obt_transpo'] = array();
                break;
                case get_time_form_id('OT'): //OT
                    //Get Shift details
                    $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d"), $this->user->user_id);
                break;
                case get_time_form_id('UT'):
                    $data['ut_type'] = $data['form_id'] == 10 ? 0 :1;
                    $data['shifts'] = $this->mod->get_shifts();
                    $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d"), $this->user->user_id);
                break;
                case get_time_form_id('ET'):
                    $data['shifts'] = $this->mod->get_shifts();
                    $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d"), $this->user->user_id);
                break;
                case get_time_form_id('BL'):
                    $data['bday_duration'] = 1;
                break;
                case get_time_form_id('DTRP'): //DTRP
                    $data['dtrp_type'] = 1;
                    $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d"), $this->user->user_id);
                break;
                case get_time_form_id('CWS'):
                    $data['shifts'] = $this->mod->get_shifts();
                    $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d"), $this->user->user_id);
                break;
                case get_time_form_id('ADDL'): //ADDL
                    //Get Shift details
                    $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d"), $this->user->user_id);
                    $data['addl_type'] = 'File';
                    $data['ot_leave_credits'] = $this->mod->get_ot_leave_credits($this->user->user_id, $form_info['form_id']);
                    $data['selected_leave_credits'] = '';
                break;
                case get_time_form_id('RES'): // replacement sched                
                    $data['res_type'] = 1;
                    $data['shifts'] = $this->mod->get_shifts();
                    $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d"), $this->user->user_id);
                    
                    if (array_key_exists('logs_time_out', $data['shift_details'])){
                        $data['ut_time_in_out'] = ($data['shift_details']['logs_time_out'] == "-") ? date("h:i A", strtotime($data['shift_details']['shift_time_end'])) : date("h:i A", strtotime($data['shift_details']['logs_time_out']));
                    }else{
                        $data['ut_time_in_out'] = "-";
                    }
                break;
            }

            $record_id = "";

            if( $record_id ){
                 $forms_data = $this->mod->edit_cached_query( $record_id );
                 $forms_dates_duration = $this->mod->edit_cached_query( $record_id );

                $obt_selected_dates = $this->mod->get_selected_dates($record_id);                
                $data['bt_type'] = (count($obt_selected_dates) > 1) ? 2 : 1;
            
                $data['ut_type'] = $this->mod->check_ut_type($record_id);
                $ut_date_time = $this->mod->get_selected_dates($record_id);
                $data['ut_time_in_out'] = ($data['ut_type']  == 0) ? date("M d, Y - h:i A", strtotime($ut_date_time[0]['time_to'])) : date("M d, Y - h:i A", strtotime($ut_date_time[0]['time_from']));
            }
            else{
                if($form_info['form_id']  == 10){
                    if (array_key_exists('logs_time_out', $data['shift_details'])){
                        $data['ut_time_in_out'] = ($data['shift_details']['logs_time_out'] == "-") ? date("M d, Y - h:i A", strtotime($data['shift_details']['DATE'] .' '. $data['shift_details']['shift_time_end'])) : date("M d, Y - h:i A", strtotime($data['shift_details']['DATE'] .' '. $data['shift_details']['logs_time_out']));
                    }else{
                        $data['ut_time_in_out'] = "-";
                    }
                }elseif($form_info['form_id'] == 15){
                    if (array_key_exists('logs_time_in', $data['shift_details'])){
                        $data['ut_time_in_out'] = ($data['shift_details']['logs_time_in'] == "-") ? date("h:i A", strtotime($data['shift_details']['shift_time_start'])) : date("h:i A", strtotime($data['shift_details']['logs_time_in']));
                    }else{
                        $data['ut_time_in_out'] = "-";
                    }
                }

            }

            foreach($fg_fields_array as $index => $field )
            {
                $data[$fields[$data['form_id']][$field]['column']]["label"] = $fields[$data['form_id']][$field]['label'];
                switch($fields[$data['form_id']][$field]['uitype_id']){
                    case 8: //Single Upload
                    case 9: //Multiple Upload
                        $upload_forms = $this->mod->get_forms_upload($record_id);

                        $all_uploaded = array();
                        foreach( $upload_forms as $upload_form )
                        {
                            $all_uploaded[] = $upload_form['upload_id'];
                        }
                        $data[$fields[$data['form_id']][$field]['column']]["val"] = array();
                    break;
                    case 6: //DATE Picker
                        $date = date("F d Y");
                        $data[$fields[$data['form_id']][$field]['column']]["val"] = $date;
                        break;
                    case 16: //DATETIME Picker
                        $date = date("F d, Y - h:i a");
                        $data[$fields[$data['form_id']][$field]['column']]["val"] = $date;
                    break;
                    default:
                        $data[$fields[$data['form_id']][$field]['column']]["val"] = '';
                    break;
                }
                
            }

            switch( $form_info['form_id'] ){
                case get_time_form_id('CWS'):
                   $data['shift_id']['val'] = $data['shift_details']['shift_id'];
                break;
                case get_time_form_id('SL'):      
                case get_time_form_id('VL'):                
                case get_time_form_id('HL'):
                case get_time_form_id('LIP'):
                case get_time_form_id('SIL'):
                case get_time_form_id('FLV'):                
                    $data['scheduled'] = lang('form_application.yes');
                break;     
            }   

            $this->load->model('my_calendar_model', 'my_calendar');
            $data['approver_list'] = $this->my_calendar->call_sp_approvers(strtoupper($data['form_code']), $this->user->user_id);

            $this->load->vars($data);

            $this->load->helper('form');
            $this->load->helper('file');
            
            if( $this->input->post('mobileapp') )
            {
                ob_start();
                echo $this->load->blade('edit_mobile.edit_'.strtolower($form_info['form_code']).'_form')->with( $this->load->get_cached_vars() );
                $this->response->form = ob_get_clean();
                $this->response->message[] = array(
                    'message' => '',
                    'type' => 'success'
                );
                $this->_ajax_return();
            }
            else
                echo $this->load->blade('edit.edit_'.strtolower($form_info['form_code']).'_form')->with( $this->load->get_cached_vars() );

        }

    }

    function edit( $record_id = '' ){
        $this->_set_record_id();
        parent::edit($this->record_id,true);
        $record_id = $this->record_id;
        $forms_info = $this->mod->get_forms_details($this->record_id);
        $form_info = $this->mod->get_form_info($forms_info['form_id']);

        require( APPPATH . 'modules/'. $this->mod->mod_code .'/config/field_groups.php' );
        $fieldgroups = $config['fieldgroups'];
        $fg_fields_array = $fieldgroups[$forms_info['form_id']]['fields'];

        require( APPPATH . 'modules/'. $this->mod->mod_code .'/config/fields.php' );
        $fields = $config['fields'];

        $data = array();

        $data['url'] = $this->mod->url;
        $data['form_status_id']["val"] = $forms_info['form_status_id'];
        $data['form_id'] = $form_info['form_id'];
        $data['form_code'] = $form_info['form_code'];
        $data['form_title'] = $form_info['form'].' '.lang('form_application.form');
        $data['upload_id']["val"] = array();
        $data['ut_time_in_out'] = "";
        $data['duration'] = $this->mod->get_duration();
        $data['leave_balance'] = $this->mod->get_leave_balance($this->user->user_id, date('Y-m-d'), 0);      
            $special_qry = "SELECT * FROM {$this->db->dbprefix}time_form_balance tfb
                    INNER JOIN {$this->db->dbprefix}time_form tf ON tf.form_id = tfb.form_id
                    WHERE user_id = {$this->user->user_id}
                    AND tf.special_leave = 1
                    AND tfb.year = '".date('Y')."'";
            $data['special_leaves'] = array();
            $special_leaves = $this->db->query($special_qry);
            if($special_leaves->num_rows > 0){
                $data['special_leaves'] = $special_leaves->result_array();
            }
        $data['back_url'] = get_mod_route('form_application');
        $data['scheduled'] = $forms_info['scheduled'];
        $data['bt_type'] = 1;
        $data['dtrp_type'] = 1;
        $data['addl_type'] = $forms_info['type'];

        if( $record_id ){
             $forms_data = $this->mod->edit_cached_query( $record_id );

             $forms_dates_duration = $this->mod->edit_cached_query( $record_id );

            $bday_selected_date = $this->mod->get_selected_dates($record_id);
            if($bday_selected_date){
                $data['bday_duration'] = $bday_selected_date[0]['duration_id'];
            }

            $obt_selected_dates = $this->mod->get_selected_dates($record_id);  
            if($obt_selected_dates){              
                $data['bt_type'] = (count($obt_selected_dates) > 1) ? 2 : 1;
            }

            $data['ut_time_in_out'] = "";
            $data['ut_type'] = $data['form_id'] == 10 ? 0 :1;
            $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", $this->input->post('start_date')), $this->user->user_id);
            if (empty($record_id)){
                $data['date_from']["val"] = date("F d, Y", $this->input->post('start_date'));
                $data['date_to']["val"] = date("F d, Y", $this->input->post('start_date'));  
            }          
            if( $record_id ){
                $data['ut_type'] = $this->mod->check_ut_type($record_id);
                $ut_date_time = $this->mod->get_selected_dates($record_id);
                $data['ut_time_in_out'] = ($data['ut_type']  == 0) ? date("M d, Y - h:i A", strtotime($ut_date_time[0]['time_to'])) : date("M d, Y - h:i A", strtotime($ut_date_time[0]['time_from']));
            }else{                
                if($data['ut_type']  == 0){
                    $logs_out = array_key_exists('logs_time_out', $data['shift_details']) ? $data['shift_details']['logs_time_out'] : '-';
                    $data['ut_time_in_out'] = ($logs_out == "-") ? date("M d, Y - h:i A", strtotime(array_key_exists('shift_time_end', $data['shift_details']) ? $data['shift_details']['shift_time_end'] : '00:00:00')) : date("M d, Y - h:i A", strtotime($logs_out));
                }else{
                    $logs_in = array_key_exists('logs_time_in', $data['shift_details']) ? $data['shift_details']['logs_time_in'] : '-';
                    $data['ut_time_in_out'] = ($logs_in == "-") ? date("M d, Y - h:i A", strtotime(array_key_exists('shift_time_start', $data['shift_details']) ? $data['shift_details']['shift_time_start'] : '00:00:00')) : date("M d, Y - h:i A", strtotime($logs_in));
                }
            }

/*            $data['ut_type'] = $this->mod->check_ut_type($record_id);
            $ut_date_time = $this->mod->get_selected_dates($record_id);
            if($ut_date_time){
                $data['ut_time_in_out'] = ($data['ut_type']  == 0) ? date("h:i A", strtotime($ut_date_time[0]['time_to'])) : date("h:i A", strtotime($ut_date_time[0]['time_from']));
            }*/
            
            $data['dtrp_type'] = $record_id ? $this->mod->check_dtrp_type($record_id) : 1;

        }

        foreach($fg_fields_array as $index => $field )
        {

            $data[$fields[$data['form_id']][$field]['column']]["label"] = $fields[$data['form_id']][$field]['label'];
            if( $record_id )
            {    
                switch($fields[$data['form_id']][$field]['uitype_id']){
                    case 8: //Single Upload
                    case 9: //Multiple Upload
                        $upload_forms = $this->mod->get_forms_upload($record_id);
                        $all_uploaded = array();
                        foreach( $upload_forms as $upload_form )
                        {
                            $all_uploaded[] = $upload_form['upload_id'];
                        }
                        $data[$fields[$data['form_id']][$field]['column']]["val"] = $all_uploaded;
                    break;
                    case 6: //DATE Picker
                        if( in_array($data['form_id'], array(10, 15, 28)) && $fields[$data['form_id']][$field]['column'] != 'focus_date'){ //undertime form/ excused tardiness
                            if($fields[$data['form_id']][$field]['column'] == "date_from"){
                                $date_time = $this->mod->get_time_from_to_dates($record_id, date("Y-m-d", strtotime($forms_data[$field])), 'time_from', $data['form_id'], $data['bt_type']);
                                $data[$fields[$data['form_id']][$field]['column']]["val"] = (empty($date_time)) ? "" : date("F d, Y", strtotime($date_time));
                            }else{
                                $date_time = $this->mod->get_time_from_to_dates($record_id, date("Y-m-d", strtotime($forms_data[$field])), 'time_to', $data['form_id'], $data['bt_type']);
                                $data[$fields[$data['form_id']][$field]['column']]["val"] = (empty($date_time)) ? "" : date("F d, Y", strtotime($date_time));
                            }
                        }else{
                            $date = date("F d, Y", strtotime($forms_data[$field]));
                            $data[$fields[$data['form_id']][$field]['column']]["val"] = $date;
                        }
                        break;
                    case 16: //DATETIME Picker
                        if($fields[$data['form_id']][$field]['column'] == "date_from"){
                            $date_time = $this->mod->get_time_from_to_dates($record_id, date("Y-m-d", strtotime($forms_data[$field])), 'time_from', $data['form_id'], $data['bt_type']);
                            $data[$fields[$data['form_id']][$field]['column']]["val"] = (empty($date_time)) ? "" : date("F d, Y - h:i a", strtotime($date_time));
                        }else{
                            $date_time = $this->mod->get_time_from_to_dates($record_id, date("Y-m-d", strtotime($forms_data[$field])), 'time_to', $data['form_id'], $data['bt_type']);
                            $data[$fields[$data['form_id']][$field]['column']]["val"] = (empty($date_time)) ? "" : date("F d, Y - h:i a", strtotime($date_time));
                        }
                    break;
                    default:
                        $data[$fields[$data['form_id']][$field]['column']]["val"] = $forms_data[$field];
                    break;
                }
            }
        }

        switch( $form_info['form_id'] ){
            case get_time_form_id('OBT')://OBT
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($forms_dates_duration['time_forms.date_from'])), $this->user->user_id);
                $data['obt_transpo'] = array();
                if($record_id){
                    $qry = "SELECT obt_transpo.*, fstats.form_status as obt_status 
                            FROM {$this->db->dbprefix}time_forms_obt_transpo obt_transpo
                            INNER JOIN {$this->db->dbprefix}time_form_status fstats
                            ON obt_transpo.status_id = fstats.form_status_id 
                            WHERE {$this->mod->primary_key} = $record_id";
                    $obt_transpo = $this->db->query($qry);
                    if($obt_transpo->num_rows() > 0){
                        $data['obt_transpo'] = $obt_transpo->result_array();
                    }
                }
            break;
            case get_time_form_id('OT'): //OT
                //Get Shift details
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($forms_dates_duration['time_forms_focusdate'])), $this->user->user_id);
            break;
            case get_time_form_id('UT'):
                //$data['ut_type'] = $data['form_id'] == 10 ? 0 :1;
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($forms_dates_duration['time_forms_focusdate'])), $this->user->user_id);
            break;
            case get_time_form_id('ET'):
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($forms_dates_duration['time_forms.date_from'])), $this->user->user_id);
            break;
            case get_time_form_id('BL'):
                $data['bday_duration'] = 1;
            break;
            case get_time_form_id('DTRP'): //DTRP
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($forms_dates_duration['time_forms_focusdate'])), $this->user->user_id);
                break;
            case get_time_form_id('CWS'):
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($forms_dates_duration['time_forms.date_from'])), $this->user->user_id);
                $data['shift_id']['val'] = $data['shift_details']['shift_id'];
            break;
            case get_time_form_id('ADDL'): //ADDL
                //Get Shift details
                $data['shift_details']      = $this->mod->get_shift_details(date("Y-m-d", strtotime($forms_dates_duration['time_forms.date_from'])), $this->user->user_id);
                $data['ot_leave_credits']   = $this->mod->get_ot_leave_credits($this->user->user_id, $form_info['form_id'], $forms_info['forms_id']);
                $selected_leave_credits     = $this->mod->get_selected_leave_credits($this->user->user_id, $form_info['form_id'], '', $forms_info['forms_id']);
                $add_credits = array();
                foreach($selected_leave_credits as $credit){
                    $add_credits[] = $credit['forms_id'];
                }
                $data['selected_leave_credits']     = $add_credits;
                if($forms_info['type'] == 'Use'){
                    $data['date_from']['val']   = $forms_info['date_from'];
                    $data['date_to']['val']     = $forms_info['date_to'];
                }
            break;
            case get_time_form_id('RES'): //RES
                $date_time_from = $this->mod->get_time_from_to_dates($record_id, date("Y-m-d", strtotime($forms_data['time_forms.date_from'])), 'time_from', $data['form_id'], $data['bt_type']);
                $date_time_to = $this->mod->get_time_from_to_dates($record_id, date("Y-m-d", strtotime($forms_data['time_forms.date_to'])), 'time_to', $data['form_id'], $data['bt_type']);
                if( ( strtotime($date_time_from)) && ( strtotime($date_time_to)) ){
                    $data['date_from']["val"] = (!strtotime($date_time_from)) ? "" : date("F d, Y - h:i a", strtotime($date_time_from));
                    $data['date_to']["val"] = ( !strtotime($date_time_to)) ? "" : date("F d, Y - h:i a", strtotime($date_time_to));
                    $data['res_type'] = 2;
                    $data['ut_time_in_out'] = '';
                }else if( strtotime($date_time_from) ){
                    $data['res_type'] = 1;
                    $data['ut_time_in_out'] = date("h:i A", strtotime($date_time_from));
                }else if( strtotime($date_time_to) ){
                    $data['res_type'] = 0;
                    $data['ut_time_in_out'] = date("h:i A", strtotime($date_time_to));
                }
                
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($forms_dates_duration['time_forms.date_from'])), $this->user->user_id);
            break;
        }

        if(!$record_id){            
            if($form_info['form_id']  == 10){
                $data['ut_time_in_out'] = ($data['shift_details']['logs_time_out'] == "-") ? date("M d, Y - h:i A", strtotime($data['shift_details']['DATE'] .' '. $data['shift_details']['shift_time_end'])) : date("M d, Y - h:i A", strtotime($data['shift_details']['DATE'] .' '. $data['shift_details']['logs_time_out']));
            }elseif($form_info['form_id'] == 15){
                $data['ut_time_in_out'] = ($data['shift_details']['logs_time_in'] == "-") ? date("h:i A", strtotime($data['shift_details']['shift_time_start'])) : date("h:i A", strtotime($data['shift_details']['logs_time_in']));
            }
        }

        $this->load->model('my_calendar_model', 'my_calendar');
        if($data['form_status_id']['val'] > 1){
            $data['approver_list'] = $this->my_calendar->get_time_forms_approvers($record_id);
            $data['approver_title'] = lang('form_application.approval_status');
        }else{
            $data['approver_list'] = $this->my_calendar->call_sp_approvers(strtoupper($data['form_code']), $this->user->user_id);
            $data['approver_title'] = lang('form_application.approvers');
        }

        $profile_info_result = $this->db->get_where('users_profile',array('user_id' => $this->user->user_id));
        $company_id = '';
        if ($profile_info_result && $profile_info_result->num_rows() > 0){
            $company_id = $profile_info_result->row()->company_id;
        }

        $data['within_cutoff'] = $this->mod->check_within_cutoff('', $forms_data['time_forms.date_from'], $forms_data['time_forms.date_to'], $company_id);

        // $this->load->model('my_calendar_model', 'my_calendar');
        // $data['approver_list'] = $this->my_calendar->call_sp_approvers(strtoupper($data['form_code']), $this->user->user_id);
        $this->load->vars($data);

        $this->load->helper('form');
        $this->load->helper('file');
        if( $this->input->post('mobileapp') )
        {
            ob_start();
            echo $this->load->blade('edit_mobile.edit_'.strtolower($form_info['form_code']).'_form')->with( $this->load->get_cached_vars() );
            $this->response->form = ob_get_clean();
            $this->response->message[] = array(
                'message' => '',
                'type' => 'success'
            );
            $this->_ajax_return();
        }
        else
            echo $this->load->blade('edit.edit_'.strtolower($form_info['form_code']).'_form')->with( $this->load->get_cached_vars() );
        
    }

    public function detail( $record_id = '' )
    {   
        $this->_set_record_id();
        parent::detail($this->record_id,true);
        $record_id = $this->record_id;
        $forms_info = $this->mod->get_forms_details($this->record_id);
        $form_info = $this->mod->get_form_info($forms_info['form_id']);

        
        $upload_forms = $this->mod->get_forms_upload($this->record_id);
        $all_uploaded = array();
        foreach( $upload_forms as $upload_form )
        {
            $all_uploaded[] = $upload_form['upload_id'];
        }

        require( APPPATH . 'modules/'. $this->mod->mod_code .'/config/field_groups.php' );
        $fieldgroups = $config['fieldgroups'];
        $fg_fields_array = $fieldgroups[$forms_info['form_id']]['fields'];

        require( APPPATH . 'modules/'. $this->mod->mod_code .'/config/fields.php' );
        $fields = $config['fields'];

        $data = array();

        $data['forms_id'] = $this->record_id;
        $data['url'] = $this->mod->url;
        $data['form_status_id']["val"] = $forms_info['form_status_id'];
        $data['form_id'] = $form_info['form_id'];
        $data['form_code'] = $form_info['form_code'];
        $data['form_title'] = $form_info['form'].' '.lang('form_application.form');
        $data['upload_id']["val"] = array();
        $data['ut_time_in_out'] = "";
        $data['duration'] = $this->mod->get_duration();
        $data['leave_balance'] = $this->mod->get_leave_balance($this->user->user_id, date('Y-m-d'), 0);  
            $special_qry = "SELECT * FROM {$this->db->dbprefix}time_form_balance tfb
                    INNER JOIN {$this->db->dbprefix}time_form tf ON tf.form_id = tfb.form_id
                    WHERE user_id = {$this->user->user_id}
                    AND tf.special_leave = 1
                    AND tfb.year = '".date('Y')."'";
            $data['special_leaves'] = array();
            $special_leaves = $this->db->query($special_qry);
            if($special_leaves->num_rows > 0){
                $data['special_leaves'] = $special_leaves->result_array();
            }
        $data['back_url'] = get_mod_route('form_application');
        $data['bt_type'] = 1;
        $data['dtrp_type'] = 1;
        $data['scheduled'] = $forms_info['scheduled'];
        $data['addl_type'] = $forms_info['type'];

        $data['uploads'] = $all_uploaded;

        if( $record_id ){

            $forms_data = $this->mod->edit_cached_query( $record_id );
             $forms_dates_duration = $this->mod->edit_cached_query( $record_id );

            $bday_selected_date = $this->mod->get_selected_dates($record_id);
            if($bday_selected_date){
                $data['bday_duration'] = $bday_selected_date[0]['duration_id'];
            }

            $obt_selected_dates = $this->mod->get_selected_dates($record_id);   
            if($obt_selected_dates){
            $data['bt_type'] = (count($obt_selected_dates) > 1) ? 2 : 1;
            }             

            $data['ut_type'] = $this->mod->check_ut_type($record_id);
            $ut_date_time = $this->mod->get_selected_dates($record_id);
            if($ut_date_time){
                $data['ut_time_in_out'] = ($data['ut_type']  == 0) ? date("M d, Y - h:i A", strtotime($ut_date_time[0]['time_to'])) : date("M d, Y - h:i A", strtotime($ut_date_time[0]['time_from']));
            }
            $data['dtrp_type'] = $record_id ? $this->mod->check_dtrp_type($record_id) : 1;

        }
        else{
            if($form_info['form_id']  == 10){
                $data['ut_time_in_out'] = ($data['shift_details']['logs_time_out'] == "-") ? date("M d, Y - h:i A", strtotime($data['shift_details']['DATE'] .' '. $data['shift_details']['shift_time_end'])) : date("M d, Y - h:i A", strtotime($data['shift_details']['DATE'] .' '. $data['shift_details']['logs_time_out']));
            }elseif($form_info['form_id'] == 15){
                $data['ut_time_in_out'] = ($data['shift_details']['logs_time_in'] == "-") ? date("h:i A", strtotime($data['shift_details']['shift_time_start'])) : date("h:i A", strtotime($data['shift_details']['logs_time_in']));
            }
        }

        foreach($fg_fields_array as $index => $field )
        {
            // debug($fields);
            // debug($data['form_id']); 
            // die;
            $data[$fields[$data['form_id']][$field]['column']]["label"] = $fields[$data['form_id']][$field]['label'];
            if( $record_id )
            {    
                switch($fields[$data['form_id']][$field]['uitype_id']){
                    case 8: //Single Upload
                    case 9: //Multiple Upload
                        $upload_forms = $this->mod->get_forms_upload($record_id);
                        $all_uploaded = array();
                        foreach( $upload_forms as $upload_form )
                        {
                            $all_uploaded[] = $upload_form['upload_id'];
                        }
                        $data[$fields[$data['form_id']][$field]['column']]["val"] = $all_uploaded;
                    break;
                    case 6: //DATE Picker
                        if($data['form_id'] == 15){ //undertime form/ excused tardiness
                            if($fields[$data['form_id']][$field]['column'] == "date_from"){
                                $date_time = $this->mod->get_time_from_to_dates($record_id, date("Y-m-d", strtotime($forms_data[$field])), 'time_from', $data['form_id'], $data['bt_type']);
                                $data[$fields[$data['form_id']][$field]['column']]["val"] = (empty($date_time)) ? "" : date("F d, Y", strtotime($date_time));
                            }else{
                                $date_time = $this->mod->get_time_from_to_dates($record_id, date("Y-m-d", strtotime($forms_data[$field])), 'time_to', $data['form_id'], $data['bt_type']);
                                $data[$fields[$data['form_id']][$field]['column']]["val"] = (empty($date_time)) ? "" : date("F d, Y", strtotime($date_time));
                            }

                        }else{
                        $date = date("F d, Y", strtotime($forms_data[$field]));
                        $data[$fields[$data['form_id']][$field]['column']]["val"] = $date;
                        }
                        break;
                    case 16: //DATETIME Picker
                        if($fields[$data['form_id']][$field]['column'] == "date_from"){
                            $date_time = $this->mod->get_time_from_to_dates($record_id, date("Y-m-d", strtotime($forms_data[$field])), 'time_from', $data['form_id'], $data['bt_type']);
                            $data[$fields[$data['form_id']][$field]['column']]["val"] = (empty($date_time)) ? "" : date("F d, Y - h:i a", strtotime($date_time));
                        }else{
                            $date_time = $this->mod->get_time_from_to_dates($record_id, date("Y-m-d", strtotime($forms_data[$field])), 'time_to', $data['form_id'], $data['bt_type']);
                            $data[$fields[$data['form_id']][$field]['column']]["val"] = (empty($date_time)) ? "" : date("F d, Y - h:i a", strtotime($date_time));
                        }
                    break;
                    default:
                        $data[$fields[$data['form_id']][$field]['column']]["val"] = $forms_data[$field];
                    break;
                }
            }
        }

        switch( $form_info['form_id'] ){
            case get_time_form_id('OBT')://OBT
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($forms_dates_duration['time_forms.date_from'])), $this->user->user_id);
                $data['obt_transpo'] = array();
                if($record_id){
                    $qry = "SELECT obt_transpo.*, fstats.form_status as obt_status 
                            FROM {$this->db->dbprefix}time_forms_obt_transpo obt_transpo
                            INNER JOIN {$this->db->dbprefix}time_form_status fstats
                            ON obt_transpo.status_id = fstats.form_status_id 
                            WHERE {$this->mod->primary_key} = $record_id";
                    $obt_transpo = $this->db->query($qry);
                    if($obt_transpo->num_rows() > 0){
                        $data['obt_transpo'] = $obt_transpo->result_array();
                    }
                }
            break;
            case get_time_form_id('OT'): //OT
                //Get Shift details
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($forms_dates_duration['time_forms_focusdate'])), $this->user->user_id);
            break;
            case get_time_form_id('UT'):
                $data['ut_type'] = $data['form_id'] == 10 ? 0 :1;
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($forms_dates_duration['time_forms_focusdate'])), $this->user->user_id);
            break;
            case get_time_form_id('ET'):
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($forms_dates_duration['time_forms.date_from'])), $this->user->user_id);
            break;
            case get_time_form_id('BL'):
                $data['bday_duration'] = 1;
            break;
            case get_time_form_id('DTRP'): //DTRP
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($forms_dates_duration['time_forms_focusdate'])), $this->user->user_id);
                break;
            case get_time_form_id('CWS'):
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($forms_dates_duration['time_forms.date_from'])), $this->user->user_id);
                $data['shift_id']['val'] = $data['shift_details']['shift_id'];
            break;
            case get_time_form_id('ADDL'): //ADDL
                //Get Shift details
                $data['shift_details']      = $this->mod->get_shift_details(date("Y-m-d", strtotime($forms_dates_duration['time_forms.date_from'])), $this->user->user_id);
                $data['ot_leave_credits']   = $this->mod->get_ot_leave_credits($this->user->user_id, $form_info['form_id'], $forms_info['forms_id']);
                $selected_leave_credits     = $this->mod->get_selected_leave_credits($this->user->user_id, $form_info['form_id'], '', $forms_info['forms_id']);
                // $add_credits = array();
                // foreach($selected_leave_credits as $credit){
                //     $add_credits[] = $credit['forms_id'];
                // }
                $data['selected_leave_credits']     = $selected_leave_credits;
                if($forms_info['type'] == 'Use'){
                    $data['date_from']['val']   = $forms_info['date_from'];
                    $data['date_to']['val']     = $forms_info['date_to'];
                }
            break;
            case get_time_form_id('RES'): //RES
                $date_time_from = $this->mod->get_time_from_to_dates($record_id, date("Y-m-d", strtotime($forms_data['time_forms.date_from'])), 'time_from', $data['form_id'], $data['bt_type']);
                $date_time_to = $this->mod->get_time_from_to_dates($record_id, date("Y-m-d", strtotime($forms_data['time_forms.date_to'])), 'time_to', $data['form_id'], $data['bt_type']);
                if( ( strtotime($date_time_from)) && ( strtotime($date_time_to)) ){
                    $data['date_from']["val"] = (!strtotime($date_time_from)) ? "" : date("F d, Y - h:i a", strtotime($date_time_from));
                    $data['date_to']["val"] = ( !strtotime($date_time_to)) ? "" : date("F d, Y - h:i a", strtotime($date_time_to));
                    $data['res_type'] = 2;
                    $data['res_type_desc'] = 'In Between';
                    $data['ut_time_in_out'] = '';
                }else if( strtotime($date_time_from) ){
                    $data['res_type'] = 1;
                    $data['res_type_desc'] = 'Excused Tardiness';
                    $data['ut_time_in_out'] = date("h:i A", strtotime($date_time_from));
                }else if( strtotime($date_time_to) ){
                    $data['res_type'] = 0;
                    $data['res_type_desc'] = 'Official Undertime';
                    $data['ut_time_in_out'] = date("h:i A", strtotime($date_time_to));
                }
                
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($forms_dates_duration['time_forms.date_from'])), $this->user->user_id);
            break;
        }

        $data['remarks'] = $this->app_admin->get_approver_remarks($data['forms_id']);

        if(!$record_id){            
            if($form_info['form_id']  == 10){
                $data['ut_time_in_out'] = ($data['shift_details']['logs_time_out'] == "-") ? date("h:i A", strtotime($data['shift_details']['shift_time_end'])) : date("h:i A", strtotime($data['shift_details']['logs_time_out']));
            }elseif($form_info['form_id'] == 15){
                $data['ut_time_in_out'] = ($data['shift_details']['logs_time_in'] == "-") ? date("h:i A", strtotime($data['shift_details']['shift_time_start'])) : date("h:i A", strtotime($data['shift_details']['logs_time_in']));
            }
        }

        if($data['form_status_id']['val'] == 7 || $data['form_status_id']['val'] == 8){ //disapproved, display remarks
            $data['disapproved_cancelled_remarks'] = $this->mod->get_disapproved_cancelled_remarks($record_id);
            // $disapproved_cancelled_remarks = $this->mod->get_disapproved_cancelled_remarks($record_id);
            // $data['comment'] = $disapproved_cancelled_remarks['comment'];
            // $data['approver_name'] = $disapproved_cancelled_remarks['approver_name'];
            // $data['form_status'] = $disapproved_cancelled_remarks['form_status'];
        }
        
        $this->load->model('my_calendar_model', 'my_calendar');
        if($data['form_status_id']['val'] > 1){
            $data['approver_list'] = $this->my_calendar->get_time_forms_approvers($record_id);
            $data['approver_title'] = lang('form_application.approval_status');
        }else{
            $data['approver_list'] = $this->my_calendar->call_sp_approvers(strtoupper($data['form_code']), $this->user->user_id);
            $data['approver_title'] = lang('form_application.approvers');
        }
        
        $data['selected_dates'] = $this->selected_dates($data['forms_id']);
        
        $date_adc = '';
        switch ($data['form_status_id']['val']) {
            case 6:
                $label = 'Date Approved';
                $date_adc = $forms_info['date_approved'];
                break;
            case 7:
                $label = 'Date Disapproved';
                $date_adc = $forms_info['date_declined'];
                break;
            case 8:
                $label = 'Date Cancelled';
                $date_adc = $forms_info['date_cancelled'];
                break;                            
            default:
                $label = '';
                break;
        }
        
        $data['label_adc'] = $label;
        $data['date_adc'] = $date_adc;

        $this->load->vars($data);

        $this->load->helper('form');
        $this->load->helper('file');

        if( $this->input->post('mobileapp') )
        {
            ob_start();
            echo $this->load->blade('detail_mobile.detail_'.strtolower($form_info['form_code']).'_form')->with( $this->load->get_cached_vars() );
            $this->response->form = ob_get_clean();
            $this->response->message[] = array(
                'message' => '',
                'type' => 'success'
            );
            $this->_ajax_return();
        }
        else
            echo $this->load->blade('detail.detail_'.strtolower($form_info['form_code']).'_form')->with( $this->load->get_cached_vars() );

    }


    function save_form()
    {
        $this->_ajax_only();
        $this->response->saved = false; 
        $error = false;

        if( !$this->permission['add'] && !$this->permission['edit'] )
        {
            $this->response->message[] = array(
                'message' => lang('form_application.perm_listfg'),
                'type' => 'warning'
            );
            $this->_ajax_return();
        }
        $this->response->forms_id = $forms_id = $this->input->post('record_id');
        $form_id = $this->input->post('form_id');
        require( APPPATH . 'modules/'. $this->mod->mod_code .'/config/field_groups.php' );
        $fieldgroups = $config['fieldgroups'];
        $fg_fields_array = $fieldgroups[$form_id]['fields'];

        require( APPPATH . 'modules/'. $this->mod->mod_code .'/config/fields.php' );
        $fields = $config['fields'];
        
        // if( $this->input->post('time_forms') ){
            foreach($this->input->post('time_forms') as $key => $val ){
                $_POST[$key] = $val;
            }
        // }

        if( $this->input->post('time_forms_upload') ){
            foreach($this->input->post('time_forms_upload') as $key => $val ){
                $_POST[$key] = $val;
            }
        }

        if($this->input->post('time_forms_maternity')){
            foreach($this->input->post('time_forms_maternity') as $key => $val ){
                $_POST[$key] = $val;
            }
        }

        if($this->input->post('time_forms_obt')){
            foreach($this->input->post('time_forms_obt') as $key => $val ){
                $_POST[$key] = $val;
            }
        }
        // Not allow application on the selected date for SL VL
        $date_replace = str_replace(' - ', ' ', $this->input->post('date_from'));
        $date = date('Y-m-d', strtotime($date_replace));
        $get_application = $this->mod->time_forms_get_application($this->user->user_id, $date);

        $form_status = $this->input->post('form_status_id');
        $form_status_id = array( 1, 7, 8);

        if($get_application == true && !in_array($form_status, $form_status_id)) {
            $this->response->message[] = array(
                'message' => lang('form_application.cannot_file_within_date'),
                'type' => 'warning'
            );
            $this->_ajax_return();
        } 

        $date = substr($this->input->post('date_from'), 0, -11);

        if (!in_array($form_id , array(9,10,11))){
            $_POST['focus_date'] =  date('Y-m-d', strtotime($date));
        }
        else{
            if ($this->input->post('focus_date') && $this->input->post('focus_date') != ''){
                $_POST['focus_date'] = date('Y-m-d',strtotime($this->input->post('focus_date')));
            }
            else{
                $_POST['focus_date'] = date('Y-m-d', strtotime($date));
            }
        }

        /*******START Filed FORM validation********/
        $date_time_from = '';
        $date_time_to = '';
        $date_time = '';
        switch($form_id){
            case get_time_form_id('OBT'): //OBT
            case get_time_form_id('OT'): //OT
            case get_time_form_id('DTRP'): //DTRP
            $date_from = date('Y-m-d', strtotime(substr($this->input->post('date_from'), 0, -11))); 
            $date_to = date('Y-m-d', strtotime(substr($this->input->post('date_to'), 0, -11)));
            $date_time_from = date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('date_from'))));
            $date_time_to = date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('date_to'))));
            break;
            case get_time_form_id('UT')://UT
                $_POST['date_from'] = date('Y-m-d', strtotime(substr($this->input->post('ut_time_in_out'), 0, -11)));
                $_POST['date_to'] = date('Y-m-d', strtotime(substr($this->input->post('ut_time_in_out'), 0, -11)));
                $date_from = date('Y-m-d', strtotime(substr($this->input->post('ut_time_in_out'), 0, -11)));
                $date_to = date('Y-m-d', strtotime(substr($this->input->post('ut_time_in_out'), 0, -11)));
                //$_POST['focus_date'] = date('Y-m-d',strtotime($date_from));
                $date_time = date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('ut_time_in_out'))));
            break;
            case get_time_form_id('ET')://ET
                $_POST['date_to'] = $_POST['date_from'];
                $date_from = date('Y-m-d', strtotime($this->input->post('date_from'))); 
                $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
                $_POST['focus_date'] = date('Y-m-d',strtotime($date_to));
                $date_time = date('Y-m-d', strtotime($this->input->post('date_from')))." ".date("H:i",strtotime($this->input->post('ut_time_in_out')));  
            break;
            case get_time_form_id('BL'):
            $_POST['date_to'] = $_POST['date_from'];
            $date_from = date('Y-m-d', strtotime($this->input->post('date_from'))); 
            $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
            break;
            case get_time_form_id('CWS')://CWS
            $_POST['date_to'] = $_POST['date_from'];
            $date_from = date('Y-m-d', strtotime($this->input->post('date_from'))); 
            $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
            $_POST['focus_date'] = date('Y-m-d',strtotime($date_from));
            break;
            default:
            $date_from = date('Y-m-d', strtotime($this->input->post('date_from'))); 
            $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
            break;
            case get_time_form_id('ADDL'): //ADDL
            if( $this->input->post('addl_type') == 'File' ){
                $date_from = date('Y-m-d', strtotime(substr($this->input->post('date_from'), 0, -11))); 
                $date_to = date('Y-m-d', strtotime(substr($this->input->post('date_to'), 0, -11)));
                $date_time_from = date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('date_from'))));
                $date_time_to = date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('date_to'))));
            }else{
                $date_from = date('Y-m-d', strtotime($this->input->post('date_from'))); 
                $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
            }
            break;
            case get_time_form_id('RES')://RES
            if( $this->input->post('res_type') == 0 ){
                $_POST['date_from'] = $_POST['date_to'];
                $date_from = date('Y-m-d', strtotime($this->input->post('date_from'))); 
                $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
                $_POST['focus_date'] = date('Y-m-d',strtotime($date_from));
                $date_time = date('Y-m-d', strtotime($this->input->post('date_from')))." ".date("H:i",strtotime($this->input->post('ut_time_in_out')));  
            }else if( $this->input->post('res_type') == 1 ){
                $_POST['date_to'] = $_POST['date_from'];
                $date_from = date('Y-m-d', strtotime($this->input->post('date_from'))); 
                $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
                $_POST['focus_date'] = date('Y-m-d',strtotime($date_to));
                $date_time = date('Y-m-d', strtotime($this->input->post('date_from')))." ".date("H:i",strtotime($this->input->post('ut_time_in_out')));  
            }else if( $this->input->post('res_type') == 2 ){
                $date_from = date('Y-m-d', strtotime(substr($this->input->post('date_from'), 0, -11))); 
                $date_to = date('Y-m-d', strtotime(substr($this->input->post('date_to'), 0, -11)));
                $date_time_from = date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('date_from'))));
                $date_time_to = date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('date_to'))));
            }
            break;
        }

        //check if forms is still draft/for approval
        if(!empty($forms_id)){
            $form_details = $this->mod->get_forms_details($forms_id);
            
            if($form_details['form_status_id'] > 2 && $this->input->post('form_status_id') != 8){
                $this->response->message[] = array(
                    'message' => lang('form_application.cant_update'),
                    'type' => 'warning'
                );  
                $this->_ajax_return();            
            }


            if($form_details['form_status_id'] == 2){
                //INSERT NOTIFICATIONS FOR APPROVERS
                $this->response->notified = $this->mod->notify_approvers( $form_id, $form_details );
                $this->response->notified = $this->mod->notify_filer( $form_id, $form_details );
            }
        }

        //check if user has workschedule and shift on the selected date
        // $dtr_sched = $this->mod->check_time_record_workschedule($date_to, $this->user->user_id);
        // if(!$dtr_sched){
        //     $this->response->message[] = array(
        //         'message' => 'Advance filing is not possible due to absence of your workschedule.',
        //         'type' => 'warning'
        //         );  
        //     $this->_ajax_return();            
        // }

        //check if forms is for cancellation
        if($this->input->post('form_status_id') == 8){
            if(trim($this->input->post('cancelled_comment')) == ""){
                $this->response->message[] = array(
                    'message' => lang('form_application.remarks_required'),
                    'type' => 'warning'
                );  
                $this->_ajax_return();            
            }
        }

        /** START Validate Date From - Date To **/
        $leave_form_type = $this->mod->get_leave_form_type();
        $leaves_ids = array();
        foreach ($leave_form_type as $leave_form){
            $leaves_ids[] = $leave_form['form_id'];
        }
        $other_form_date = array(get_time_form_id('UT'), get_time_form_id('CWS'), get_time_form_id('ET'), get_time_form_id('RES')); //undertime, CWS, excused tardiness, RES
        $with_date_range = array_merge($leaves_ids, $other_form_date);

        if(in_array($form_id, $with_date_range)){
            if(strtotime($this->input->post('date_from')) > strtotime($this->input->post('date_to'))){
                $this->response->message[] = array(
                    'message' => lang('form_application.invalid_daterange'),
                    'type' => 'warning'
                );  
                $this->_ajax_return();
            }
        }

        $this->input->post('dtrp_type') == 3 ? $other_form_type = array(get_time_form_id('OBT'), get_time_form_id('OT'), get_time_form_id('DTRP')) : $other_form_type = array(get_time_form_id('OBT'), get_time_form_id('OT')); //business trip, overtime, dtrp
        if(in_array($form_id, $other_form_type)){
            if(strtotime(str_replace(" - "," ",$this->input->post('date_from'))) > strtotime(str_replace(" - "," ",$this->input->post('date_to')))){
                $this->response->message[] = array(
                    'message' => lang('dddd'),
                    'type' => 'warning'
                );  
                $this->_ajax_return();
            }
        }        
        /** END Validate Date From - Date To **/

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
        //validate if rest day/holiday
        $other_form_type = array(10, 15); //undertime and excused tardiness
        $not_allowed_rest_holidays = array_merge($leaves_ids, $other_form_type);

        //START Leave duration - whole or half day
            $counter_duration = 0;
            $duration_date = $this->input->post('duration');
        $duration_date = is_array($duration_date) ? $duration_date : array();
        $forms_rest_day = 0;
        foreach($period as $dt) {
            $forms_rest_day += $this->mod->check_rest_day($this->user->user_id, $dt->format('Y-m-d'));
        }
        $rest_day_not_allowed = 0;
        $holiday_not_allowed = 0;
        $total_duration=0;
        if($this->input->post('form_status_id') != 8){

            foreach($period as $dt) {
                if(in_array($form_id, $leaves_ids)){
                    $already_exist = $this->mod->get_approved_forms($dt->format('Y-m-d'), $this->user->user_id);
                        $pending_already_exist = $this->mod->get_pending_forms($dt->format('Y-m-d'), $this->user->user_id, $forms_id);
                    $total_filed_day = 0;
                    $total_filed_credit = 0;
                    $duration_day = 0;
                    $duration_credits = 0;
   
                    if (array_key_exists($counter_duration, $duration_date)){
                        $duration_details = $this->mod->get_duration($duration_date[$counter_duration]);
                        $duration_credits = $duration_details[0]['credit'];
                        $duration_day = $duration_date[$counter_duration] == 1 ? 1 : 0.5;
                        $total_duration += $duration_day;
                    }
                    if(strtoupper($this->input->post('form_code')) == "ADDL" ){
                        if($this->input->post('addl_type') != 'File') {
                            foreach($already_exist as $existed_form){
                                if(in_array($existed_form['form_id'], $leaves_ids)){
                                    $total_filed_day += ($existed_form['day'] + $duration_day);
                                    $total_filed_credit += ($existed_form['credit'] + $duration_credits);
                                            if(($total_filed_day > 1 && $total_filed_credit > 8) || $duration_date[$counter_duration] == $existed_form['duration_id']){
                                        $this->response->message[] = array(
                                            'message' => lang('form_application.already_approved'),
                                            'type' => 'warning'
                                        );  
                                        $this->_ajax_return();
                                        break;
                                    }
                                }
                            }
                        }
                    }else{
                        foreach($already_exist as $existed_form){
                            if(in_array($existed_form['form_id'], $leaves_ids)){
                                $total_filed_day += ($existed_form['day'] + $duration_day);
                                $total_filed_credit += ($existed_form['credit'] + $duration_credits);
                                        if(($total_filed_day > 1 && $total_filed_credit > 8) || $duration_date[$counter_duration] == $existed_form['duration_id']){
                                    $this->response->message[] = array(
                                        'message' => lang('form_application.already_approved'),
                                        'type' => 'warning'
                                    );  
                                    $this->_ajax_return();
                                    break;
                                }
                            }
                        }
                        
                        if(count($pending_already_exist) > 0){
                            foreach($pending_already_exist as $existed_pending_form){
                                if(in_array($existed_pending_form['form_id'], $leaves_ids)){
                                    $total_filed_day += ($existed_pending_form['day'] + $duration_day);
                                    $total_filed_credit += ($existed_pending_form['credit'] + $duration_credits);
                                    if(($total_filed_day > 1 && $total_filed_credit > 8) || $duration_date[$counter_duration] == $existed_pending_form['duration_id']){
                                        $this->response->message[] = array(
                                            'message' => lang('form_application.have_pending'),
                                            'type' => 'warning'
                                            );  
                                        $this->_ajax_return();
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    $counter_duration++;

                    //check if leave selected date is restday
                    //             foreach($forms_rest_day as $forms_rest){
                    //                 if($dt->format('l') == $forms_rest['rest_day']){
                    //                     $rest_day_not_allowed++;
                    //     }
                    // }
                    $form_holiday = $this->mod->check_if_holiday($dt->format('Y-m-d'), $this->user->user_id);

                    if(count($form_holiday) > 0){
                        $holiday_not_allowed++;
                    }

                }
                    //End Leave duration - whole or half day

                    // $rest_day_not_allowed = 0;
                    //START restday/holiday checking ET and UT
                if(in_array($form_id, $other_form_type)){
                    //check if restday
                    // foreach($forms_rest_day as $forms_rest){
                    //     if($dt->format('l') == $forms_rest['rest_day']){
                    //         $rest_day_not_allowed = 1;
                    //         break;
                    //     }
                    // }

                    if( $forms_rest_day > 0 ){
                        if(strtoupper($this->input->post('form_code')) == "ADDL" ){
                            if($this->input->post('addl_type') != 'File') {
                                $this->response->message[] = array(
                                    'message' => lang('form_application.notallow_restday'),
                                    'type' => 'warning'
                                    );  
                                $this->_ajax_return();
                            }
                        }else{
                            $this->response->message[] = array(
                                'message' => lang('form_application.notallow_restday'),
                                'type' => 'warning'
                                );  
                            $this->_ajax_return();
                        }
                    }

                    //check if holiday
                    $form_holiday = array();
                    $form_holiday = $this->mod->check_if_holiday($dt->format('Y-m-d'), $this->user->user_id);

                    if(count($form_holiday) > 0){
                        $this->response->message[] = array(
                            'message' => lang('form_application.notallow_holiday'),
                            'type' => 'warning'
                            );  
                        $this->_ajax_return();
                    }
                }
                //END restday/holiday checking ET and UT
            }

            if($counter_duration != 0){
                if($counter_duration == $forms_rest_day){
                    if( strtoupper($this->input->post('form_code')) == "ADDL" ){
                        if( $this->input->post('addl_type') != 'File' ) {
                            $this->response->message[] = array(
                                'message' => lang('form_application.notallow_restday'),
                                'type' => 'warning'
                                );  
                            $this->_ajax_return();
                        }
                    }else{
                        $this->response->message[] = array(
                            'message' => lang('form_application.notallow_restday'),
                            'type' => 'warning'
                            );  
                        $this->_ajax_return();
                    }
                }else if($counter_duration == $holiday_not_allowed){
                    if( strtoupper($this->input->post('form_code')) == "ADDL" ){
                        if( $this->input->post('addl_type') != 'File' ) {
                             $this->response->message[] = array(
                                'message' => lang('form_application.notallow_holiday'),
                                'type' => 'warning'
                                );  
                            $this->_ajax_return();
                        }
                       
                    }else{
                        $this->response->message[] = array(
                            'message' => lang('form_application.notallow_holiday'),
                            'type' => 'warning'
                            );  
                        $this->_ajax_return();
                    }
                }else if($counter_duration == ($forms_rest_day + $holiday_not_allowed)){
                    if( strtoupper($this->input->post('form_code')) == "ADDL" ){
                        if( $this->input->post('addl_type') != 'File' ) {
                            $this->response->message[] = array(
                                'message' => lang('form_application.not_holirestday'),
                                'type' => 'warning'
                                );  
                            $this->_ajax_return();
                        }
                    }else{
                        $this->response->message[] = array(
                            'message' => lang('form_application.not_holirestday'),
                            'type' => 'warning'
                            );  
                        $this->_ajax_return();
                    }
                }
            }

            //START : validate forms with focus date and OT overlap
            //obt, overtime, undertime, dtrp, excuse tardiness
            $this->input->post('bt_type') == 1 ? $form_type_with_focus = array(get_time_form_id('OBT'), get_time_form_id('OT'), get_time_form_id('UT'), get_time_form_id('DTRP'), get_time_form_id('ET')) : $form_type_with_focus = array(get_time_form_id('OT'), get_time_form_id('UT'), get_time_form_id('DTRP'), get_time_form_id('ET')); 
        if(in_array($form_id, $form_type_with_focus)){
                switch($form_id){
                    case get_time_form_id('OBT')://obt
                        if(strtotime($this->input->post('focus_date')) > strtotime($date_from. ' +1 day') || strtotime($this->input->post('focus_date')) < strtotime($date_from. ' -1 day')
                            || strtotime($this->input->post('focus_date')) > strtotime($date_to) || strtotime($this->input->post('focus_date')) < strtotime($date_to. ' -1 day')){
                            $this->response->message[] = array(
                                'message' => "lang('form_application.invalid_date')",
                                'type' => 'warning'
                                );  
                        $this->_ajax_return();
                        }

                        //OBT overlap
                        $existing_obt_forms =  $this->mod->validate_ot_forms(date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('date_from')))), date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('date_to')))), $this->user->user_id, $form_id, $forms_id);
                        if($existing_obt_forms > 0){
                          $this->response->message[] = array(
                            'message' => lang('form_application.obt_filed'),
                            'type' => 'warning'
                            );  
                            $this->_ajax_return();
                        }
                    break;
                    case get_time_form_id('OT')://overtime
                        if((strtotime($this->input->post('focus_date')) > strtotime($date_to. ' +1 day') && strtotime($this->input->post('focus_date')) > strtotime($date_to. ' +1 day')) || (strtotime($this->input->post('focus_date')) < strtotime($date_from) && strtotime($this->input->post('focus_date')) < strtotime($date_from. ' -1 day'))){
                            $this->response->message[] = array(
                                'message' => lang('form_application.invalid_date'),
                                'type' => 'warning'
                                );  
                             $this->_ajax_return();
                        }

                        $total_hrs = round((strtotime($date_time_to) - strtotime($date_time_from))/(60*60));

                        if( $total_hrs > 24 ){
                            $this->response->message[] = array(
                                'message' => "Filing of overtime should not greater than to 1 day",
                                'type' => 'error'
                                );  
                             $this->_ajax_return();
                        }

                        //OT overlap
                        $existing_ot_forms =  $this->mod->validate_ot_forms(date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('date_from')))), date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('date_to')))), $this->user->user_id, $form_id, $forms_id);
                        if($existing_ot_forms > 0){
                          $this->response->message[] = array(
                            'message' => lang('form_application.ot_filed'),
                            'type' => 'warning'
                            );  
                            $this->_ajax_return();
                        }
                    break;
                    case get_time_form_id('UT')://undertime
                    case get_time_form_id('ET')://Excused Tardiness
                        if($this->input->post('ut_type') == 1){ 
                            if(strtotime($this->input->post('focus_date')) > strtotime($date_from. ' +1 day') || strtotime($this->input->post('focus_date')) < strtotime($date_from. ' -1 day')){
                                $this->response->message[] = array(
                                    'message' => lang('form_application.invalid_date'),
                                    'type' => 'warning'
                                    );  
                            $this->_ajax_return();
                            }
                        }else{ 
                            if(strtotime($this->input->post('focus_date')) > strtotime($date_to) || strtotime($this->input->post('focus_date')) < strtotime($date_to. ' -1 day')){
                                    $this->response->message[] = array(
                                        'message' => lang('form_application.invalid_date'),
                                        'type' => 'warning'
                                    );  
                                    $this->_ajax_return();
                            }
                        }
                    break;
                    case get_time_form_id('DTRP')://dtrp
                        if($this->input->post('dtrp_type') == 1){ //IN
                            if(strtotime($this->input->post('focus_date')) > strtotime($date_from. ' +1 day') || strtotime($this->input->post('focus_date')) < strtotime($date_from. ' -1 day')){
                                $this->response->message[] = array(
                                    'message' => lang('form_application.invalid_date'),
                                    'type' => 'warning'
                                    );  
                            $this->_ajax_return();
                            }
                        }elseif($this->input->post('dtrp_type') == 2){ //OUT
                            if(strtotime($this->input->post('focus_date')) > strtotime($date_to) || strtotime($this->input->post('focus_date')) < strtotime($date_to. ' -1 day')){
                                $this->response->message[] = array(
                                    'message' => lang('form_application.invalid_date'),
                                    'type' => 'warning'
                                    );  
                            $this->_ajax_return();
                            }//date_time_to
                            if( strtotime($date_time_to) > strtotime(date('Y-m-d H:i:s')) ) {
                                $this->response->message[] = array(
                                    'message' => lang('form_application.invalid_timeout'),
                                    'type' => 'warning'
                                    );  
                            $this->_ajax_return();
                            }
                        }else{ //IN & OUT
                            if(strtotime($this->input->post('focus_date')) > strtotime($date_from. ' +1 day') || strtotime($this->input->post('focus_date')) < strtotime($date_from. ' -1 day')
                                || strtotime($this->input->post('focus_date')) > strtotime($date_to) || strtotime($this->input->post('focus_date')) < strtotime($date_to. ' -1 day')){
                                $this->response->message[] = array(
                                    'message' => lang('form_application.invalid_date'),
                                    'type' => 'warning'
                                    );  
                            $this->_ajax_return();
                            }
                        }
                    break;
                    case get_time_form_id('ADDL'): //ADDL
                    if( $this->input->post('addl_type') == 'File' ){
                        if(strtotime($this->input->post('focus_date')) > strtotime($date_from. ' +1 day') || strtotime($this->input->post('focus_date')) < strtotime($date_from. ' -1 day')
                            || strtotime($this->input->post('focus_date')) > strtotime($date_to) || strtotime($this->input->post('focus_date')) < strtotime($date_to. ' -1 day')){
                            $this->response->message[] = array(
                                'message' => lang('form_application.invalid_date'),
                                'type' => 'warning'
                                );  
                        $this->_ajax_return();
                        }
                        //OT overlap
                        $existing_ot_forms =  $this->mod->validate_ot_forms(date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('date_from')))), date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('date_to')))), $this->user->user_id, $form_id, $forms_id);
                        if($existing_ot_forms > 0){
                          $this->response->message[] = array(
                            'message' => lang('form_application.ot_filed'),
                            'type' => 'warning'
                            );  
                        $this->_ajax_return();
                        }
                    }
                    break;
                    case get_time_form_id('RES')://RES
                        if($this->input->post('res_type') == 1){ 
                            if(strtotime($this->input->post('focus_date')) > strtotime($date_from. ' +1 day') || strtotime($this->input->post('focus_date')) < strtotime($date_from. ' -1 day')){
                                $this->response->message[] = array(
                                    'message' => lang('form_application.invalid_date'),
                                    'type' => 'warning'
                                    );  
                            $this->_ajax_return();
                            }
                        }else if($this->input->post('res_type') == 0){ 
                            if(strtotime($this->input->post('focus_date')) > strtotime($date_to) || strtotime($this->input->post('focus_date')) < strtotime($date_to. ' -1 day')){
                                    $this->response->message[] = array(
                                        'message' => lang('form_application.invalid_date'),
                                        'type' => 'warning'
                                    );  
                                    $this->_ajax_return();
                            }
                        }else if($this->input->post('res_type') == 2){                            
                        if(strtotime($this->input->post('focus_date')) > strtotime($date_from. ' +1 day') || strtotime($this->input->post('focus_date')) < strtotime($date_from. ' -1 day')
                                        || strtotime($this->input->post('focus_date')) > strtotime($date_to) || strtotime($this->input->post('focus_date')) < strtotime($date_to. ' -1 day')){
                                        $this->response->message[] = array(
                                            'message' => lang('form_application.invalid_date'),
                                            'type' => 'warning'
                                            );  
                                    $this->_ajax_return();
                                    }
                                    //OT overlap
                                    $existing_ot_forms =  $this->mod->validate_ot_forms(date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('date_from')))), date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('date_to')))), $this->user->user_id, $form_id, $forms_id);
                                    if($existing_ot_forms > 0){
                                      $this->response->message[] = array(
                                        'message' => lang('form_application.ot_filed'),
                                        'type' => 'warning'
                                        );  
                                    $this->_ajax_return();
                                    }
                        }
                    break;
                }
            }
        }
        //END : validate forms with focus date

        //validation of fields on module manager
        $main_record = array();
        foreach($fg_fields_array as $index => $field )
        {            
            $validation_rules[] = 
                array(
                    'field' => $fields[$form_id][$field]['column'],
                    'label' => $fields[$form_id][$field]['label'],
                    'rules' => $fields[$form_id][$field]['datatype']
            );
            //getting fields from module manager and assign its values
            switch($fields[$form_id][$field]['uitype_id']){
                case 6: //DATE Picker
                    if( $this->input->post('res_type') == 2 ){
                        $date = substr($this->input->post($fields[$form_id][$field]['column']), 0, -11);
                        $main_record[$fields[$form_id][$field]['table']][$fields[$form_id][$field]['column']] = $date != "" ? date('Y-m-d', strtotime($date)) : "";
                    }else{
                        $date = $this->input->post($fields[$form_id][$field]['column']);
                        $main_record[$fields[$form_id][$field]['table']][$fields[$form_id][$field]['column']] = $date != "" ? date('Y-m-d', strtotime($date)) : "";
                    }
                break;
                case 16: //DATETIME Picker
                    if( $this->input->post('addl_type') == 'Use' ){
                        $date = $this->input->post($fields[$form_id][$field]['column']);
                        $main_record[$fields[$form_id][$field]['table']][$fields[$form_id][$field]['column']] = $date != "" ? date('Y-m-d', strtotime($date)) : "";
                    }else{
                        $date = substr($this->input->post($fields[$form_id][$field]['column']), 0, -11);
                        $main_record[$fields[$form_id][$field]['table']][$fields[$form_id][$field]['column']] = $date != "" ? date('Y-m-d', strtotime($date)) : "";
                    }
                break;
                default:
                    $main_record[$fields[$form_id][$field]['table']][$fields[$form_id][$field]['column']] = $this->input->post($fields[$form_id][$field]['column']);
                break;
            }
        }

        if($this->input->post('form_status_id') != 8){
            //fields not on module manager
            if($form_id == 10 || $form_id == 15){//undertime form      
                $validation_rules[] = 
                    array(
                        'field' => 'ut_time_in_out',
                        'label' => 'Time',
                        'rules' => 'required'
                );
            }
            $allowed_year_from = date('Y', strtotime('-1 year'));
            $allowed_year_to = date('Y', strtotime('+1 year'));

            if( date('Y', strtotime($main_record[$this->mod->table]['date_from'])) < $allowed_year_from || 
                  date('Y', strtotime($main_record[$this->mod->table]['date_from'])) > $allowed_year_to ){
                $this->response->message[] = array(
                'message' => "Date from should be between $allowed_year_from and $allowed_year_to",
                'type' => 'warning'
                );  
                $this->_ajax_return();
            }

            if( date('Y', strtotime($main_record[$this->mod->table]['date_to'])) < $allowed_year_from || 
                  date('Y', strtotime($main_record[$this->mod->table]['date_to'])) > $allowed_year_to ){
                $this->response->message[] = array(
                'message' => "Date to should be between $allowed_year_from and $allowed_year_to",
                'type' => 'warning'
                );  
                $this->_ajax_return();
            }

            //START Form Validation
            $this->load->library('form_validation');
            $this->form_validation->set_rules( $validation_rules );


            if ($this->form_validation->run() == false)
            {
                foreach( $this->form_validation->get_error_array() as $f => $f_error )
                {
                    $this->response->message[] = array(
                        'message' => $f_error,
                        'type' => 'warning'
                    );  
                }
                
                $this->_ajax_return();
            }
            //END Form Validation        

        //Validate form based on policies    
            $uploads = $this->input->post('upload_id');
            $shift_to = $this->input->post('shift_to');
            $schedule = $this->input->post('scheduled');
            $addl_type = $this->input->post('addl_type');

            $forms_validation = $this->time_form_policies->validate_form_filing($form_id, strtoupper($this->input->post('form_code')), $this->user->user_id, $date_from, $date_to, $uploads, $forms_id, $date_time_from, $date_time_to, $date_time, $shift_to, $schedule, $total_duration, $addl_type);

            if(array_key_exists('error', $forms_validation) ){ 
                if(count($forms_validation['error']) > 0 ){             
                    foreach( $forms_validation['error'] as $f => $f_error )
                    {
                        $this->response->message[] = array(
                            'message' => $f_error,
                            'type' => 'error'
                            );  
                    }     
                        $this->_ajax_return();
                }
            }
            if (array_key_exists('warning', $forms_validation)){ 
                if(count($forms_validation['warning']) > 0 ){  
                    foreach( $forms_validation['warning'] as $f => $f_error )
                    {
                        $this->response->message[] = array(
                            'message' => $f_error,
                            'type' => 'warning'
                            );  
                    }
                }
            }
        }else{
        //Validate form based on policies    
            $uploads = $this->input->post('upload_id');
            $shift_to = $this->input->post('shift_to');
            $schedule = $this->input->post('scheduled');
            $forms_validation = $this->time_form_policies->validate_form_change_status($forms_id,$this->input->post('form_status_id'));

            if(array_key_exists('error', $forms_validation) ){
                if(count($forms_validation['error']) > 0 ){         
                    foreach( $forms_validation['error'] as $f => $f_error )
                    {
                        $this->response->message[] = array(
                            'message' => $f_error,
                            'type' => 'error'
                            );  
                    }     
                        $this->_ajax_return();
                }
            }

            if (array_key_exists('warning', $forms_validation)){
                if(count($forms_validation['warning']) > 0 ){   
                    foreach( $forms_validation['warning'] as $f => $f_error )
                    {
                        $this->response->message[] = array(
                            'message' => $f_error,
                            'type' => 'warning'
                            );  
                    }
                }
            }
        }
        /*******END Filed FORM validation********/

        $focus_date_final = '0000-00-00';
        if ($this->input->post('focus_date') && $this->input->post('focus_date') != ''){
            $focus_date_final = date('Y-m-d', strtotime($this->input->post('focus_date')));
        }

        //fields not setup on module manager - value assignment
        if($this->input->post('form_status_id') == 2){
            $main_record[$this->mod->table]['form_status_id'] = $forms_validation['hr_validate'] == true ? 4 : $this->input->post('form_status_id');
        }else{
            $main_record[$this->mod->table]['form_status_id'] = $this->input->post('form_status_id');
        }
        $main_record[$this->mod->table]['form_id'] = $form_id;
        $main_record[$this->mod->table]['scheduled'] = $this->input->post('scheduled');
        $main_record[$this->mod->table]['type'] = $this->input->post('addl_type');
        $main_record[$this->mod->table]['form_code'] = strtoupper($this->input->post('form_code'));
        $main_record[$this->mod->table]['focus_date'] = $focus_date_final;
        $main_record[$this->mod->table]['user_id'] = $this->user->user_id;
        $main_record[$this->mod->table]['display_name'] = $this->mod->get_display_name($this->user->user_id);

        if($this->input->post('form_status_id') == 8){ //add cancelled date
            $main_record[$this->mod->table]['date_cancelled'] = date('Y-m-d H:i:s');
        }

        $time_forms_date_table = array();
        $breakout = false;
        $hrs = 0;
        $duration = $this->input->post('duration');
        $leave_duration = $this->input->post('leave_duration');
        $selected_date_count = 0;
             
        $rest_days= array();
        // foreach($period as $dt) {
        //     $forms_rest_day = $this->mod->check_if_rest_day($this->user->user_id, $dt->format('Y-m-d'));
        //     $forms_rest_day_count = $this->mod->check_rest_day($this->user->user_id, $dt->format('Y-m-d'));
        //     foreach($forms_rest_day as $forms_rest){
        //         $rest_days[] = $forms_rest['rest_day'];
        //     }
        // }
        
        $days = 0;
        foreach($period as $dt) {

            $form_holiday = array();
            $forms_rest_day_count = $this->mod->check_rest_day($this->user->user_id, $dt->format('Y-m-d'));
            $form_holiday = $this->mod->check_if_holiday($dt->format('Y-m-d'), $this->user->user_id);

            if( count($form_holiday) > 0 || ($forms_rest_day_count > 0) ){   
                if($form_id != 8){
                    $days--;
                }    
            }else{
                switch($form_id){
                    case get_time_form_id('SL'):
                    case get_time_form_id('VL'):
                    case get_time_form_id('EL'):
                    case get_time_form_id('FL'):
                    case get_time_form_id('ML'):
                    case get_time_form_id('PL'):
                    case get_time_form_id('LWOP'):
                    case get_time_form_id('BL'):
                    case get_time_form_id('SLW'):
                    case get_time_form_id('SPL'):
                    case get_time_form_id('VVL'):
                    case get_time_form_id('EML'):
                    case get_time_form_id('MEC'):
                    case get_time_form_id('ECC'):
                    case get_time_form_id('ECB'):
                    case get_time_form_id('RBL'):
                    case get_time_form_id('PiL'):
                    case get_time_form_id('MeL'):
                    case get_time_form_id('FBL'):
                    case get_time_form_id('LIP'):
                    case get_time_form_id('SIL'):
                    case get_time_form_id('HL'):
                    case get_time_form_id('FLV'):
                    $duration_details = $this->mod->get_duration($duration[$selected_date_count]);
                    $leave_durations = $this->mod->get_leave_duration($leave_duration[$selected_date_count]);
                    if($this->input->post('form_status_id') != 8){
                        $time_forms_date_table[] = array(
                            'forms_id' => $forms_id,
                            'date' => $dt->format('Y-m-d'),
                            'day' => $leave_durations[0]['leave_duration'] * 0.125,//$duration[$selected_date_count] == 1 ? 1 : 0.5,
                            'duration_id' => $duration[$selected_date_count],
                            'credit' => $leave_durations[0]['leave_duration'],//$duration_details[0]['credit']
                            'hrs' => $leave_durations[0]['leave_duration']
                            );
                    }else{
                        $time_forms_date_table[] = array(
                            'forms_id' => $forms_id,
                            'date' => $dt->format('Y-m-d'),
                            'day' => $leave_durations[0]['leave_duration'] * 0.125,//$duration[$selected_date_count] == 1 ? 1 : 0.5,
                            'duration_id' => $duration[$selected_date_count],
                            'credit' => $leave_durations[0]['leave_duration'],//$duration_details[0]['credit'],
                            'cancelled_comment' => $this->input->post('cancelled_comment') ,
                            'hrs' => $leave_durations[0]['leave_duration'],
                            );
                    }
/*                    if($duration[$selected_date_count] != 1){
                        $days -= 0.5;
                    }*/
                    //for abraham since they different durations, for standard just remove this line
                    $days += $leave_durations[0]['leave_duration'] * 0.125;

                    break;
                    case get_time_form_id('ADDL')://addl                    
                    if( $this->input->post('addl_type') == 'Use' ){
                        $duration_details = $this->mod->get_duration($duration[$selected_date_count]);
                        if($this->input->post('form_status_id') != 8){
                            $time_forms_date_table[] = array(
                                'forms_id' => $forms_id,
                                'date' => $dt->format('Y-m-d'),
                                'day' => $duration[$selected_date_count] == 1 ? 1 : 0.5,
                                'duration_id' => $duration[$selected_date_count],
                                'credit' => $duration_details[0]['credit']
                                );
                        }else{
                            $time_forms_date_table[] = array(
                                'forms_id' => $forms_id,
                                'date' => $dt->format('Y-m-d'),
                                'day' => $duration[$selected_date_count] == 1 ? 1 : 0.5,
                                'duration_id' => $duration[$selected_date_count],
                                'credit' => $duration_details[0]['credit'],
                                'cancelled_comment' => $this->input->post('cancelled_comment') 
                                );
                        }
                        if($duration[$selected_date_count] != 1){
                            $days -= 0.5;
                        }
                    }
                    break;
                }
                $selected_date_count++;
            }


                switch($form_id){
                    case get_time_form_id('OBT'): //OBT
                    if($this->input->post('form_status_id') != 8){
                        if($this->input->post('bt_type') == 1){
                            $time_forms_date_table[] = array(
                                'forms_id' => $forms_id,
                                'date' => $this->input->post('focus_date'),
                                'day' => 1,
                                'time_from' => $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($this->input->post('date_from'), -8))),
                                'time_to' => $date_to." ".date("H:i",strtotime(substr($this->input->post('date_to'), -8)))
                                );
                        $main_record[$this->mod->table]['date_from'] = $this->input->post('focus_date');
                        $main_record[$this->mod->table]['date_to'] = $this->input->post('focus_date');
                            $breakout = true;
                        }else{
                            $time_forms_date_table[] = array(
                                'forms_id' => $forms_id,
                                'date' => $dt->format('Y-m-d'),
                                'day' => 1,
                                'time_from' => $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($this->input->post('date_from'), -8))),
                                'time_to' => $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($this->input->post('date_to'), -8)))
                                );
                        }
                    }else{
                        if($this->input->post('bt_type') == 1){
                            $time_forms_date_table[] = array(
                                'forms_id' => $forms_id,
                                'date' => $this->input->post('focus_date'),
                                'day' => 1,
                                'time_from' => $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($this->input->post('date_from'), -8))),
                                'time_to' => $date_to." ".date("H:i",strtotime(substr($this->input->post('date_to'), -8))),
                                'cancelled_comment' => $this->input->post('cancelled_comment') 
                                );
                        $main_record[$this->mod->table]['date_from'] = $this->input->post('focus_date');
                        $main_record[$this->mod->table]['date_to'] = $this->input->post('focus_date');
                            $breakout = true;
                        }else{
                            $time_forms_date_table[] = array(
                                'forms_id' => $forms_id,
                                'date' => $dt->format('Y-m-d'),
                                'day' => 1,
                                'time_from' => $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($this->input->post('date_from'), -8))),
                                'time_to' => $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($this->input->post('date_to'), -8))),
                                'cancelled_comment' => $this->input->post('cancelled_comment') 
                                );
                        }
                    }

                    break;
                    case get_time_form_id('OT'): //OT
                    $time_from = $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($this->input->post('date_from'), -8)));    
                    $time_to = $date_to." ".date("H:i",strtotime(substr($this->input->post('date_to'), -8)));  
                    $hrs = ((strtotime($time_to) - strtotime($time_from))/60)/60;    
                    if($this->input->post('form_status_id') != 8){
                        $time_forms_date_table[] = array(
                            'forms_id' => $forms_id,
                            'date' => $this->input->post('focus_date'),
                            'day' => 1,
                            'hrs' => $hrs,
                            'time_from' => $time_from,
                            'time_to' => $time_to
                            );
                    }else{
                        $time_forms_date_table[] = array(
                            'forms_id' => $forms_id,
                            'date' => $this->input->post('focus_date'),
                            'day' => 1,
                            'hrs' => $hrs,
                            'time_from' => $time_from,
                            'time_to' => $time_to,
                            'cancelled_comment' => $this->input->post('cancelled_comment') 
                            );
                    }
                    $days = 1;
                        $main_record[$this->mod->table]['date_from'] = $date_from;
                        $main_record[$this->mod->table]['date_to'] = $date_to;
                    $breakout = true;
                        break;
                    case get_time_form_id('UT'): //UT
                    $date_time = date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('ut_time_in_out')))); 
 
                    if($this->input->post('form_status_id') != 8){
                        if($this->input->post('ut_type') == 1){ 
                            $time_forms_date_table[] = array(
                                'forms_id' => $forms_id,
                                'date' => $this->input->post('focus_date'),
                                'day' => 1,
                                'duration_id' => 1,
                                'time_from' => $date_time
                                );
                        }else{
                            $time_forms_date_table[] = array(
                                'forms_id' => $forms_id,
                                'date' => $this->input->post('focus_date'),
                                'day' => 1,
                                'duration_id' => 2,
                                'time_to' => $date_time
                                );
                        }
                    }else{
                       $time_forms_date_table[] = array(
                        'forms_id' => $forms_id,
                        'date' => $this->input->post('focus_date'),
                        'day' => 1,
                        'time_to' => $date_time,
                        'cancelled_comment' => $this->input->post('cancelled_comment') 
                        );
                    }
                    $days = 1;   
                        $main_record[$this->mod->table]['date_from'] = $date_to;
                        $main_record[$this->mod->table]['date_to'] = $date_to;
                    $breakout = true;
                    break;
                    case get_time_form_id('ET'): //ET
                    $date_time = $dt->format('Y-m-d')." ".date("H:i",strtotime($this->input->post('ut_time_in_out')));  

                    if($this->input->post('form_status_id') != 8){
                        $time_forms_date_table[] = array(
                            'forms_id' => $forms_id,
                            'date' => $this->input->post('focus_date'),
                            'day' => 1,
                            'time_from' => $date_time
                            );
                    }else{
                        $time_forms_date_table[] = array(
                            'forms_id' => $forms_id,
                            'date' => $this->input->post('focus_date'),
                            'day' => 1,
                            'time_from' => $date_time,
                            'cancelled_comment' => $this->input->post('cancelled_comment') 
                            );
                    }
                    $days = 1;
                        $main_record[$this->mod->table]['date_from'] = $this->input->post('focus_date');
                        $main_record[$this->mod->table]['date_to'] = $this->input->post('focus_date');
                    $breakout = true;
                        break;
                    case get_time_form_id('DTRP'): //DTRP
                        $time_from = $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($this->input->post('date_from'), -8)));    
                        $time_to = $date_to." ".date("H:i",strtotime(substr($this->input->post('date_to'), -8)));  
                        // $hrs = ((strtotime($time_to) - strtotime($time_from))/60)/60;   
                        if($this->input->post('form_status_id') != 8){
                            if($this->input->post('dtrp_type') == 1){ 
                                $time_forms_date_table[] = array(
                                    'forms_id' => $forms_id,
                                    'date' => $this->input->post('focus_date'),
                                    'day' => 1,
                                    'time_from' => $time_from
                                    );
                                $main_record[$this->mod->table]['date_from'] = $date_from;
                                $main_record[$this->mod->table]['date_to'] = $date_from;                                    
                            }elseif($this->input->post('dtrp_type') == 2){ 
                                $time_forms_date_table[] = array(
                                    'forms_id' => $forms_id,
                                    'date' => $this->input->post('focus_date'),
                                    'day' => 1,
                                    'time_to' => $time_to
                                    );
                                $main_record[$this->mod->table]['date_from'] = $date_to;
                                $main_record[$this->mod->table]['date_to'] = $date_to;                                   
                            }else{    
                                $time_forms_date_table[] = array(
                                    'forms_id' => $forms_id,
                                    'date' => $this->input->post('focus_date'),
                                    'day' => 1,
                                    'time_from' => $time_from,
                                    'time_to' => $time_to
                                    );
                                $main_record[$this->mod->table]['date_from'] = $date_from;
                                $main_record[$this->mod->table]['date_to'] = $date_to;                                
                            }
                        }else{
                            if($this->input->post('dtrp_type') == 1){ 
                                $time_forms_date_table[] = array(
                                    'forms_id' => $forms_id,
                                    'date' => $this->input->post('focus_date'),
                                    'day' => 1,
                                    'time_from' => $time_from,
                                    'cancelled_comment' => $this->input->post('cancelled_comment') 
                                    );
                                $main_record[$this->mod->table]['date_from'] = $date_from;
                                $main_record[$this->mod->table]['date_to'] = $date_from;                                  
                            }elseif($this->input->post('dtrp_type') == 2){ 
                                $time_forms_date_table[] = array(
                                    'forms_id' => $forms_id,
                                    'date' => $this->input->post('focus_date'),
                                    'day' => 1,
                                    'time_to' => $time_to,
                                    'cancelled_comment' => $this->input->post('cancelled_comment') 
                                    );
                                $main_record[$this->mod->table]['date_from'] = $date_to;
                                $main_record[$this->mod->table]['date_to'] = $date_to;                                   
                            }else{    
                                $time_forms_date_table[] = array(
                                    'forms_id' => $forms_id,
                                    'date' => $this->input->post('focus_date'),
                                    'day' => 1,
                                    'time_from' => $time_from,
                                    'time_to' => $time_to,
                                    'cancelled_comment' => $this->input->post('cancelled_comment') 
                                    );
                                $main_record[$this->mod->table]['date_from'] = $date_from;
                                $main_record[$this->mod->table]['date_to'] = $date_to;                                   
                            }
                        }
                        $days = 1;
                        $breakout = true;
                        break;
                    case get_time_form_id('CWS'): // CWS 
                    if($this->input->post('form_status_id') != 8){
                        $time_forms_date_table[] = array(
                            'forms_id' => $forms_id,
                            'date' => $dt->format('Y-m-d'),
                            'day' => 1
                            );
                    }else{
                        $time_forms_date_table[] = array(
                            'forms_id' => $forms_id,
                            'date' => $dt->format('Y-m-d'),
                            'day' => 1,
                            'cancelled_comment' => $this->input->post('cancelled_comment') 
                            );
                    }
                    $days = 1;
                    break;
                    case get_time_form_id('ADDL'): //ADDL
                    if( $this->input->post('addl_type') == 'File' ){
                        $time_from = $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($this->input->post('date_from'), -8)));    
                        $time_to = $date_to." ".date("H:i",strtotime(substr($this->input->post('date_to'), -8)));  
                        $hrs = ((strtotime($time_to) - strtotime($time_from))/60)/60;    
                        if($this->input->post('form_status_id') != 8){
                            $time_forms_date_table[] = array(
                                'forms_id' => $forms_id,
                                'date' => $this->input->post('focus_date'),
                                'day' => 1,
                                'hrs' => $hrs,
                                'time_from' => $time_from,
                                'time_to' => $time_to
                                );
                        }else{
                            $time_forms_date_table[] = array(
                                'forms_id' => $forms_id,
                                'date' => $this->input->post('focus_date'),
                                'day' => 1,
                                'hrs' => $hrs,
                                'time_from' => $time_from,
                                'time_to' => $time_to,
                                'cancelled_comment' => $this->input->post('cancelled_comment') 
                                );
                        }
                        $days = 1;
                            $main_record[$this->mod->table]['date_from'] = $this->input->post('focus_date');
                            $main_record[$this->mod->table]['date_to'] = $this->input->post('focus_date');
                        $breakout = true;
                    }
                    break;
                    case get_time_form_id('RES'): //RES
                    if( $this->input->post('res_type') == 0 ){
                         $date_time = $dt->format('Y-m-d')." ".date("H:i",strtotime($this->input->post('ut_time_in_out')));  
     
                        if($this->input->post('form_status_id') != 8){
                            $time_forms_date_table[] = array(
                                'forms_id' => $forms_id,
                                'date' => $this->input->post('focus_date'),
                                'day' => 1,
                                'time_to' => $date_time
                                );
                        }else{
                           $time_forms_date_table[] = array(
                            'forms_id' => $forms_id,
                            'date' => $this->input->post('focus_date'),
                            'day' => 1,
                            'time_to' => $date_time,
                            'cancelled_comment' => $this->input->post('cancelled_comment') 
                            );
                        }
                        $days = 1;   
                            $main_record[$this->mod->table]['date_from'] = $this->input->post('focus_date');
                            $main_record[$this->mod->table]['date_to'] = $this->input->post('focus_date');
                        $breakout = true;
                    }else if( $this->input->post('res_type') == 1 ){
                        $date_time = $dt->format('Y-m-d')." ".date("H:i",strtotime($this->input->post('ut_time_in_out')));  

                        if($this->input->post('form_status_id') != 8){
                            $time_forms_date_table[] = array(
                                'forms_id' => $forms_id,
                                'date' => $this->input->post('focus_date'),
                                'day' => 1,
                                'time_from' => $date_time
                                );
                        }else{
                            $time_forms_date_table[] = array(
                                'forms_id' => $forms_id,
                                'date' => $this->input->post('focus_date'),
                                'day' => 1,
                                'time_from' => $date_time,
                                'cancelled_comment' => $this->input->post('cancelled_comment') 
                                );
                        }
                        $days = 1;
                            $main_record[$this->mod->table]['date_from'] = $this->input->post('focus_date');
                            $main_record[$this->mod->table]['date_to'] = $this->input->post('focus_date');
                        $breakout = true;
                    }else if( $this->input->post('res_type') == 2 ){
                    $time_from = $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($this->input->post('date_from'), -8)));    
                    $time_to = $date_to." ".date("H:i",strtotime(substr($this->input->post('date_to'), -8)));  
                    $hrs = ((strtotime($time_to) - strtotime($time_from))/60)/60;    
                    if($this->input->post('form_status_id') != 8){
                        $time_forms_date_table[] = array(
                            'forms_id' => $forms_id,
                            'date' => $this->input->post('focus_date'),
                            'day' => 1,
                            'hrs' => $hrs,
                            'time_from' => $time_from,
                            'time_to' => $time_to
                            );
                    }else{
                        $time_forms_date_table[] = array(
                            'forms_id' => $forms_id,
                            'date' => $this->input->post('focus_date'),
                            'day' => 1,
                            'hrs' => $hrs,
                            'time_from' => $time_from,
                            'time_to' => $time_to,
                            'cancelled_comment' => $this->input->post('cancelled_comment') 
                            );
                    }
                    $days = 1;
                        $main_record[$this->mod->table]['date_from'] = $this->input->post('focus_date');
                        $main_record[$this->mod->table]['date_to'] = $this->input->post('focus_date');
                    $breakout = true;
                    }
                    break;

                }
                if($breakout === true) break;    
            
        }
        
        //day field not setup on module manager - value assignment
        $main_record[$this->mod->table]['day'] = $days;
        $main_record[$this->mod->table]['hrs'] = $hrs;
        //END get days count

        $form_type = $this->mod->get_form_type($form_id);

        if($form_type['is_leave'] == 1 && ($form_type['with_credits'] == 1) &&  $this->input->post('form_status_id') != 8){
            $balance_data = $this->mod->get_leave_balance($this->user->user_id, date('Y-m-d', strtotime($date_from)), $form_id);
            $leavebal = 0;
            $tfdatesbal = 0;
            
            if( count($balance_data) > 0 ){
                // foreach ($balance_data as $balancekey => $balance) {
                //     debug('start of loop - '.$balancekey);
                //     $leavebal += $balance['balance'];
                //     foreach($time_forms_date_table as $datekey => $tfdates){
                //         if($leavebal > 0){
                //             $tfdatesbal = $tfdates['day'];
                //             if(!isset($time_forms_date_table[$datekey]['leave_balance_id'])){
                //                 if(!isset($balance['balance']) && $tfdates['day'] > $balance['balance'] ) {
                //                     debug('aaa');
                //                     $time_forms_date_table[$datekey]['leave_balance_id'] = $balance['id'];
                //                 } elseif($tfdatesbal <= $balance_data[$balancekey]['balance']) {
                //                     debug('bbb');
                //                     debug('assigning leave_balance_id part'.$balancekey);
                //                     $time_forms_date_table[$datekey]['leave_balance_id'] = $balance_data[$balancekey]['id'];
                //                 } 
                //             }
                //         }
                //     } 
                //     $balance_data[$balancekey]['balance'] -= $tfdatesbal;
                //     $tfdatesbal += $tfdatesbal;  
                // }

                foreach ($balance_data as $balancekey => $balance) {
                    $leavebal += $balance['balance'];
                }

                $tfdatestot = 0;

                foreach($time_forms_date_table as $datekey => $tfdates){

                    if($leavebal > 0)
                    {
                        $tfdatesbal = $tfdates['day'];
                        $tfdatestot += $tfdatesbal;
                        $tfdatesrun = 0;
                        $tfcarryover = 0;

                        if(!isset($time_forms_date_table[$datekey]['leave_balance_id'])){
                            foreach ($balance_data as $balancekey => $balance) 
                            {
                                // debug($time_forms_date_table);
                                $tfdatesrun = $tfdates['day'] + $tfcarryover;
                                if($tfdatesrun <= $balance['balance'] ) {
                                    $time_forms_date_table[$datekey]['leave_balance_id'] = $balance_data[$balancekey]['id'];
                                    $balance_data[$balancekey]['balance'] -= $tfdatesrun;
                                    $tfcarryover = 0;
                                    //force exit loop
                                    break;
                                } else {
                                    if(($tfdatesrun - $balance_data[$balancekey]['balance'] >= 1)) {
                                        $time_forms_date_table[$datekey]['leave_balance_id'] = $balance_data[$balancekey]['id'];
                                        $tfcarryover = $tfdatesrun - $balance_data[$balancekey]['balance'];
                                        $balance_data[$balancekey]['balance'] = 0;
                                    }
                                    // else hayaan mo na lang!
                                }

                            }

                        }
                        

                    }

                } 
                
                // debug($balance_data);
                // debug($time_forms_date_table);
                // debug('bal - '.$leavebal);
                if($tfdatestot > $leavebal)
                {
                    $this->response->message[] = array(
                        'message' => 'Insufficient Leave Credits from application.',
                        'type' => 'warning'
                    );  
                    $this->_ajax_return();
                }
            }elseif(empty($balance_data)){
                    $this->response->message[] = array(
                        'message' => 'No Leave Credits to deduct on your application.',
                        'type' => 'warning'
                    );  
                    $this->_ajax_return();
            }
        }

        //Validate additional leave
        if($_POST['form_code'] == 'ADDL' && $this->input->post('form_status_id') != 8){
            if( $this->input->post('addl_type') == 'Use' ){
                $used_by_form = $this->input->post('used_by_form');
                if( empty($used_by_form) ){
                    $this->response->message[] = array(
                        'message' => "Additional Leave Credits is required.",
                        'type' => 'warning'
                    );  
                    $this->_ajax_return();
                }

                $used_by_form = implode( ",", $this->input->post('used_by_form') );
                $add_credits = $this->mod->get_selected_leave_credits($this->user->user_id, $this->input->post('form_id'), $used_by_form);
                $selected_credits = 0;
                foreach($add_credits as $credit){
                    $selected_credits += $credit['balance'] == 0 ? $credit['credit'] : $credit['balance'];
                }

                if($selected_credits < $days){
                    $this->response->message[] = array(
                        'message' => "Insufficient additional leave credits. <br>
                                    Please select date range covered by your leave credits.",
                        'type' => 'warning'
                    );  
                    $this->_ajax_return();
                }
            }
        }

        //SAVING START
        $transactions = true;
        if( $transactions )
        {
            $this->db->trans_begin();
        }

        //start saving with main table
        $record = $this->db->get_where( $this->mod->table, array( $this->mod->primary_key => $forms_id ) );
        // $record = $this->db->get_where( 'time_forms', array( 'forms_id' => $forms_id ) );
        switch( true )
        {
            case $record->num_rows() == 0:
                //add mandatory fields
                $main_record[$this->mod->table]['created_on'] = date('Y-m-d H:i:s');

                if( in_array($main_record[$this->mod->table]['form_status_id'],array(2,4)) ){
                    $main_record[$this->mod->table]['date_sent'] = date('Y-m-d H:i:s');
                }

                $this->db->insert($this->mod->table, $main_record[$this->mod->table]);
                if( $this->db->_error_message() == "" )
                {
                    $forms_id = $this->record_id = $this->db->insert_id();
                }
                break;
            case $record->num_rows() == 1:
                // $main_record['modified_by'] = $this->user->user_id;
                $main_record[$this->mod->table]['modified_on'] = date('Y-m-d H:i:s');

                if( in_array($main_record[$this->mod->table]['form_status_id'],array(2,4)) ){
                    $main_record[$this->mod->table]['date_sent'] = date('Y-m-d H:i:s');
                }


                $this->db->update( $this->mod->table, $main_record[$this->mod->table], array( $this->mod->primary_key => $forms_id) );
                // $this->db->update( 'time_forms', $main_record, array( 'forms_id' => $forms_id ) );
                break;
            default:
                $this->response->message[] = array(
                    'message' => lang('common.inconsistent_data'),
                    'type' => 'error'
                );
                $error = true;
                goto stop;
        }
        if( $this->db->_error_message() != "" ){
            $this->response->message[] = array(
                'message' => $this->db->_error_message(),
                'type' => 'error'
            );
            $error = true;
            goto stop;
        }
        
        // DELETE/INSERT to ww_time_forms_date
        $this->db->delete('time_forms_date', array( $this->mod->primary_key => $forms_id ) ); 
        foreach($time_forms_date_table as $field => $value){
            $value[$this->mod->primary_key] = $forms_id;
            $this->db->insert('time_forms_date', $value);

            if( $this->db->_error_message() != "" ){
                $this->response->message[] = array(
                    'message' => $this->db->_error_message(),
                    'type' => 'error'
                );
                $error = true;
                goto stop;
            }
        }

        //OBT
        if($this->input->post('form_code') == 'OBT'){
            // DELETE/INSERT to ww_time_forms_obt_transpo
            $this->db->delete('time_forms_obt_transpo', array( $this->mod->primary_key => $forms_id ) ); 
            if( isset($_POST['time_forms_obt_transpo']) ){
                $time_forms_obt_transpo = $_POST['time_forms_obt_transpo'];
                foreach($time_forms_obt_transpo['purpose_id'] as $index => $value){
                    $transpo_data[$this->mod->primary_key] = $forms_id;
                    $transpo_data['purpose_id'] = $value;
                    $transpo_data['amount'] = $time_forms_obt_transpo['amount'][$index];
                    $transpo_data['remarks'] = $time_forms_obt_transpo['remarks'][$index];
                    
                    $this->db->insert('time_forms_obt_transpo', $transpo_data);
                    if( $this->db->_error_message() != "" ){
                        $this->response->message[] = array(
                            'message' => $this->db->_error_message(),
                            'type' => 'error'
                        );
                        $error = true;
                        goto stop;
                    }
                }
            }
        }
        
        //start saving with sub table
        foreach( $main_record as $table => $data )
        {
            if($table == "time_forms_upload"){

                $this->db->delete($table, array( $this->mod->primary_key => $forms_id ) ); 
                if(!empty($data['upload_id'][0])){
                    $upload_ids = explode(',', $data['upload_id']);

                    foreach($upload_ids as $field => $value){
                        if($value > 0){
                            $data[$this->mod->primary_key] = $forms_id;
                            $data['upload_id'] = $value;
                            $this->db->insert($table, $data);

                            if( $this->db->_error_message() != "" ){
                                $this->response->message[] = array(
                                    'message' => $this->db->_error_message(),
                                    'type' => 'error'
                                );
                                $error = true;
                                goto stop;
                            }
                        }
                    }
                }
            }else{
                $record = $this->db->get_where( $table, array( $this->mod->primary_key => $forms_id ) );
                switch( true )
                {
                    case $record->num_rows() == 0:
                        $data[$this->mod->primary_key] = $forms_id;
                        $this->db->insert($table, $data);
                        $this->record_id = $this->db->insert_id();
                        break;
                    case $record->num_rows() == 1:
                        $this->db->update( $table, $data, array( $this->mod->primary_key => $forms_id) );
                        break;
                    default:
                        $this->response->message[] = array(
                            'message' => lang('common.inconsistent_data'),
                            'type' => 'error'
                        );
                        $error = true;
                        goto stop;
                }
            }

            if( $this->db->_error_message() != "" ){
                $this->response->message[] = array(
                    'message' => $this->db->_error_message(),
                    'type' => 'error'
                );
                $error = true;
            }
        }

        // if($this->input->post('form_status_id') == 2 ){  //submit
        //     //check if for validation
        //     $this->check_for_validation($main_record[$this->mod->table], $forms_id);
        // }
        
        if($_POST['form_code'] == 'ADDL'){
            if( $this->input->post('addl_type') == 'Use' ){
                if($this->input->post('form_status_id') != 8){
                    $used_by_form = implode( ",", $this->input->post('used_by_form') );
                    $add_credits = $this->mod->get_selected_leave_credits($this->user->user_id, $this->input->post('form_id'), $used_by_form);
                    $selected_days = $days;
                    $selected_OTleaves = array();
                    $this->db->update( 'time_forms_ot_leave', array('used_by_form' => 0), array( 'used_by_form' => $forms_id) );
                    
                    foreach($add_credits as $credit){
                        if($selected_days > 0){
                            if( $selected_days >= $credit['credit'] ){
                                $add_update = array('used_by_form' =>   $forms_id,
                                                    'used'         =>   $credit['credit']);
                                $selected_days -= $credit['credit'];
                            }else{
                                $add_update = array('used_by_form' =>   $forms_id,
                                                    'used'         =>   $selected_days);
                                $selected_days -= $selected_days;
                            }
                            $this->db->update( 'time_forms_ot_leave', $add_update, array( $this->mod->primary_key => $credit['forms_id']) );
                            $selected_OTleaves[] = $credit['forms_id'];
                            //insert on ww_time_forms_ot_leave_used
                            $used_ot_leave = $this->db->get_where( 'time_forms_ot_leave_used', array( $this->mod->primary_key => $credit['forms_id'], 'used_by_form' => $forms_id ) );
                            $add_update['forms_id'] = $credit['forms_id'];
                            switch( true )
                            {
                                case $used_ot_leave->num_rows() == 0:
                                    $this->db->insert('time_forms_ot_leave_used', $add_update);
                                    break;
                                case $used_ot_leave->num_rows() == 1:
                                    $this->db->update( 'time_forms_ot_leave_used', $add_update, array( $this->mod->primary_key => $credit['forms_id'], 'used_by_form' => $forms_id ) );
                                    break;
                                default:
                                    $this->response->message[] = array(
                                        'message' => lang('common.inconsistent_data'),
                                        'type' => 'error'
                                    );
                                    $error = true;
                                    goto stop;
                            }
                        }
                    }

                    $selected_OTleaves = implode( ",", $selected_OTleaves );
                    $update_used_sql = "SELECT SUM(used) as used_leaves FROM {$this->db->dbprefix}time_forms_ot_leave_used 
                                        WHERE forms_id IN ($selected_OTleaves) AND deleted = 0";
                    $update_used_qry = $this->db->query($update_used_sql);
                    if($update_used_qry->num_rows() > 0){
                        $update_used = $update_used_qry->row_array();
                        $update_leave_used = " UPDATE {$this->db->dbprefix}time_forms_ot_leave 
                                                SET used = {$update_used['used_leaves']} 
                                                WHERE forms_id IN ($selected_OTleaves) ";
                        $this->db->query($update_leave_used);
                    }

                }else{
                    $add_update = array('used_by_form' =>   0,
                                        'used'         =>   0);
                    $this->db->update( 'time_forms_ot_leave', $add_update, array( 'used_by_form' => $forms_id) );
                    $this->db->update( 'time_forms_ot_leave_used', array('deleted' => 1) , array( 'used_by_form' => $forms_id) );
                }
                $this->db->update( 'time_form_balance', array('modified_on' => date('Y-m-d H:i:s')), array('user_id' => $this->user->user_id, 'form_code' => 'ADDL') );
            }
        }

        stop:
        if( $transactions )
        {
            if( !$error ){
                $this->db->trans_commit();
            }
            else{
                 $this->db->trans_rollback();
            }
        }

        if(!empty($forms_id)){
            $form_details = $this->mod->get_forms_details($forms_id);

            if($form_details['form_status_id'] == 2 || $form_details['form_status_id'] == 8){
                //INSERT NOTIFICATIONS FOR APPROVERS
                $this->response->notified = $this->mod->notify_approvers( $form_id, $form_details );
                $this->response->notified = $this->mod->notify_filer( $form_id, $form_details );
            }

            if($_POST['form_code'] == 'ML' && $this->input->post('return_date') != ''){
                $result = $this->db->query("CALL sp_time_forms_maternity(".$forms_id.")");
            }
        }

        if( !$error )
        {

            $this->response->month = date('m', strtotime($date_from));
            $this->response->year = date('Y', strtotime($date_from));
            $this->response->forms_id = $forms_id;
            $this->response->saved = true; 
            $this->response->message[] = array(
                'message' => $this->input->post('forms_title').' '.lang('form_application.success_save'),
                'type' => 'success'
            );
        }

        $this->_ajax_return();
    }

    function cancel_record(){

        $this->_ajax_only();
        
        if( !$this->input->post('records') )
        {
            $this->response->message[] = array(
                'message' => lang('common.insufficient_data'),
                'type' => 'warning'
            );
            $this->_ajax_return();  
        }

        
        $forms_info = $this->mod->get_forms_details($this->input->post('records'));
        $form_info = $this->mod->get_form_info($forms_info['form_id']);

        $this->response = $this->mod->_cancel_record( $this->input->post('records'), $form_info['form'] );

        $this->_ajax_return();


    }

    function get_shift_details()
    {
        $this->_ajax_only();
        if($this->input->post('form_type') == 15 || $this->input->post('form_type') == 12){ //CWS, undertime or excused tardiness
            $date_from = date('Y-m-d', strtotime($this->input->post('date_from')));
            $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
        }else{// DTRP, OT
            $date_from = date('Y-m-d', strtotime(substr($this->input->post('date_from'), 0, -11)));
            $date_to = date('Y-m-d', strtotime(substr($this->input->post('date_to'), 0, -11)));
        }
        switch($this->input->post('type')){
            case 1: //IN
            $shift_details = $this->mod->get_shift_details( date('Y-m-d', strtotime($date_from)), $this->user->user_id);
            
            // $shift_details['date_from'] = $this->input->post('date_from');
            $shift_details['date_from'] = date("F d, Y", strtotime($date_to))." - ".date("h:i a", strtotime(array_key_exists('shift_time_start', $shift_details) ? $shift_details['shift_time_start'] : '00:00:00'));
            $shift_details['date_to'] = date("F d, Y", strtotime($date_from))." - ".date("h:i a", strtotime(array_key_exists('shift_time_end', $shift_details) ? $shift_details['shift_time_end'] : '00:00:00'));
            break;
            case 2: //OUT
            $shift_details = $this->mod->get_shift_details( date('Y-m-d', strtotime($date_to)), $this->user->user_id);
            $shift_details['date_from'] = date("F d, Y", strtotime($date_to))." - ".date("h:i a", strtotime(array_key_exists('shift_time_start', $shift_details) ? $shift_details['shift_time_start'] : '00:00:00'));
            $shift_details['date_to'] = date("F d, Y", strtotime($date_from))." - ".date("h:i a", strtotime(array_key_exists('shift_time_end', $shift_details) ? $shift_details['shift_time_end'] : '00:00:00'));
            // $shift_details['date_to'] = $this->input->post('date_to');
            break;
            case 3: //IN-OUT
            $shift_details = $this->mod->get_shift_details( date('Y-m-d', strtotime($date_from)), $this->user->user_id);
            $shift_details['date_from'] = date("F d, Y", strtotime($date_from))." - ".date("h:i a", strtotime(array_key_exists('shift_time_start', $shift_details) ? $shift_details['shift_time_start'] : '00:00:00'));
            $shift_details['date_to'] = date("F d, Y", strtotime($date_to))." - ".date("h:i a", strtotime(array_key_exists('shift_time_end', $shift_details) ? $shift_details['shift_time_end'] : '00:00:00'));
            break;
        }

        $shift_end = array_key_exists('shift_time_end', $shift_details) ? $shift_details['shift_time_end'] : '-';
        $shift_start = array_key_exists('shift_time_start', $shift_details) ? $shift_details['shift_time_start'] : '-';
        $logs_out = array_key_exists('logs_time_out', $shift_details) ? $shift_details['logs_time_out'] : '-';
        $logs_in = array_key_exists('logs_time_in', $shift_details) ? $shift_details['logs_time_in'] : '-';

        $shift_details['ut_time_in_out'] = "";
        if($this->input->post('form_type') == 10){ //undertime/excused tardiness form
            if($this->input->post('utype') == 0){
                $shift_details['ut_time_in_out'] = ($logs_out == "-") ? date("M d, Y - h:i A", strtotime(array_key_exists('shift_time_end', $shift_details) ? $shift_details['DATE'] .' '. $shift_details['shift_time_end'] : '00:00:00')) : date("M d, Y - h:i A", strtotime($logs_out));
            }else{
                $shift_details['ut_time_in_out'] = ($logs_in == "-") ? date("M d, Y - h:i A", strtotime(array_key_exists('shift_time_start', $shift_details) ? $shift_details['DATE'] .' '. $shift_details['shift_time_start'] : '00:00:00')) : date("h:i A", strtotime($logs_in));
            }
        }

        $shift_details['shift_time_end'] = $shift_end != '-' ? date("g:ia", strtotime(date("Y-m-d")." ".$shift_end)) : '-';
        $shift_details['shift_time_start'] = $shift_start != '-' ? date("g:ia", strtotime(date("Y-m-d")." ".$shift_start)) : '-';
        $shift_details['logs_time_out'] = $logs_out != '-' ? date("g:ia", strtotime($logs_out)) : '-'; 
        $shift_details['logs_time_in'] = $logs_in != '-' ? date("g:ia", strtotime($logs_in)) : '-'; 
        
        $this->response->shift_details = $shift_details;
        $this->response->message[] = array(
            'message' => lang('form_application.logs_fetched'),
            'type' => 'success'
        );
        $this->_ajax_return();
        // echo json_encode($shift_details);
    }


    function get_selected_dates(){

        $this->_ajax_only();

        $selected_dates = array();
        if($this->input->post('forms_id')){
            $selected_dates = $this->mod->get_selected_dates($this->input->post('forms_id'));
        }
        $data['duration'] = $this->mod->get_duration();
        $days = 0;

        if( $this->input->post('view') == 'edit'  ){
            $date_from = ( $this->input->post('date_from') == "" )? "" : date('Y-m-d', strtotime($this->input->post('date_from'))); 
            $date_to = ( $this->input->post('date_to') == "" )? "" : date('Y-m-d', strtotime($this->input->post('date_to')));
        }
        elseif( $this->input->post('view') == 'detail' ){
            $forms_info = $this->mod->get_forms_details($this->input->post('forms_id'));
            $date_from = ( $forms_info['date_from'] == "" )? "" : date('Y-m-d', strtotime($forms_info['date_from'])); 
            $date_to = ( $forms_info['date_to'] == "" )? "" : date('Y-m-d', strtotime($forms_info['date_to']));
        }

        //START get days count
        $start = new DateTime($date_from);
        $end = new DateTime($date_to);      
        // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        $interval = $end->diff($start);
        // total days
        $days = $interval->days;
        $day_count = 0;

        // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);
        $period = iterator_to_array($period);

        // best stored as array, so you can add more than one
        $holidays = array();
        $dates = array();
        $selected_dates_count = 0;
        $time_duration_arr = array();

        if( $date_from != "" || $date_to != "" ){

            $rest_days= array();
            // foreach($period as $dt) {
            //     $forms_rest_day = $this->mod->check_if_rest_day($this->user->user_id, $dt->format('Y-m-d'));
            //     $forms_rest_day_count = $this->mod->check_rest_day($this->user->user_id, $dt->format('Y-m-d'));
            //     foreach($forms_rest_day as $forms_rest){
            //         $rest_days[] = $forms_rest['rest_day'];
            //     }
            // }

            foreach($period as $dt) 
            {
                $form_holiday = array();
                $form_holiday = $this->mod->check_if_holiday($dt->format('Y-m-d'), $this->user->user_id);
                $forms_rest_day_count = $this->mod->check_rest_day($this->user->user_id, $dt->format('Y-m-d'));
                $shift_details = $this->mod->get_shift_details($dt->format('Y-m-d'), $this->user->user_id);

                if( count($form_holiday) > 0 || ( $forms_rest_day_count > 0) ){           
                    $days--;
                }else{
                    $duration_id = 1;
                    $curr = $dt->format('D');
                    
                    $w_selected_dates = 0;
                    foreach($selected_dates as $selected_date){
                        if($selected_date['date'] == $dt->format('Y-m-d')){
                            $duration_id = $selected_date['duration_id'];
                            $day_count += $selected_date['day'];

                            $user = $this->db->get_where('users_profile',array('user_id' => $this->user->user_id))->row();
                            if ($shift_details['cur_shift_id'] != ''){
                                $shift_policy = $this->mod->get_shift_policy($shift_details['cur_shift_id'],$user->company_id,'WORKING-HOURS');
                                $time_duration_arr[$dt->format('F d, Y')] = (isset($selected_date['hrs']) && $selected_date['hrs'] > 0  ? $selected_date['hrs'] : $shift_policy['class_value']);
                            }      
                            $w_selected_dates = 1;                             
                        }
                    }

                    if (!$w_selected_dates){
                        $user = $this->db->get_where('users_profile',array('user_id' => $this->user->user_id))->row();
                        if ($shift_details['cur_shift_id'] != ''){
                            $shift_policy = $this->mod->get_shift_policy($shift_details['cur_shift_id'],$user->company_id,'WORKING-HOURS');
                            $time_duration_arr[$dt->format('F d, Y')] = $shift_policy['class_value'];
                        }
                    }

                    $dates[$dt->format('F d, Y')][$curr] = $duration_id;
                    $selected_dates_count++;
                }
            }        
        }

        $data['default_hw'] = $time_duration_arr;
        $data['days'] = $days;
        $data['dates'] = $dates;
        $data['duration'] = $this->mod->get_duration();
        $data['disabled'] = $this->input->post('form_status_id')> 2 ? lang('form_application.disabled') : "";

        if( $this->input->post('view') == 'edit'  ){
            if( $this->input->post('form_code') == 'ADDL'){
                $view['content'] = $this->load->view('edit/addl_change_date', $data, true);
            }else{
                $view['content'] = $this->load->view('edit/change_date', $data, true);
            }
        }
        elseif( $this->input->post('view') == 'detail' ){
            $view['content'] = $this->load->view('detail/view_date', $data, true);
        }

        $this->response->selected_dates = $view['content'];
        $this->response->days = $days;

        if($day_count > 0 && $day_count < 1){
            $this->response->days = lang('form_application.half');
        }else{
            if (strpos($day_count,'.5') !== false) {
                $day_count = explode(".",$day_count); 
                $this->response->days = $day_count[0]." ".lang('form_application.and_ahalf');
            }else{
                $this->response->days = $days;
            }
        }

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }


    function _list_options( $record, &$rec )
    {

        if( $this->permission['edit'] )
        {
            $rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
            $rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
        }   

        if( $this->permission['detail'] )
        {
            if( $record['time_form_form'] == 'Daily Time Record Updating') {
                $rec['detail_url'] = get_mod_route('timerecord', 'updating'. '/');
            } else {
                $rec['detail_url'] = $this->mod->url . '/detail/' . $record['record_id'];
            }

            if( $record['time_forms_form_status_id'] == 1 || $record['time_forms_form_status_id'] == 2 ){
                $rec['options'] .= '<li><a href="'.$rec['detail_url'].'"><i class="fa fa-info"></i> '.lang('form_application.view').'</a></li>';
            }
        }

        if( $this->permission['delete'] )
        {
            $rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];

            if( $record['time_forms_form_status_id'] == 1 ){
                $rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
            }
        }

        // if( $record['time_forms_form_status_id'] == 2 ){

        //     $rec['options'] .= '<li><a href="javascript: cancel_record('.$record['record_id'].')"><i class="fa fa-ban"></i>Cancel</a></li>';

        // }



    }

    public function get_list()
    {
        $this->_ajax_only();
        if( !$this->permission['list'] )
        {
            $this->response->message[] = array(
                'message' => lang('common.insufficient_permission'),
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        $this->response->show_import_button = false;
        if( $this->input->post('page') == 1 )
        {
            $this->load->model('upload_utility_model', 'import');
            if( $this->import->get_templates( $this->mod->mod_id ) )
                $this->response->show_import_button = true;
        }

        $page = $this->input->post('page');
        $search = $this->input->post('search');
        $trash = $this->input->post('trash') == 'true' ? true : false;
        $filter = $this->input->post('filter');
        
        /** start - for status filter **/ 
        $pos = strpos($filter,"/");
        $filters = "";
        if($pos)
        { 
            $fil_arr = explode("/", $filter);
            foreach ($fil_arr as $val) {
                $pos_val = strpos($val, "undefined");
                if(!$pos_val)
                {
                    $filters = $val;
                }
            }
        }

        $filter = "";
        $filter_by = $this->input->post('filter_by');
        $filter_value = $this->input->post('filter_value');
        
        if( is_array( $filter_by ) )
        {
            foreach( $filter_by as $filter_by_key => $filter_value )
            {
                if( $filter_value != "" ) {
                    if($filter_by_key == "pay_date"){
                        if($filter_value > 0){
                            $fqry = "SELECT `record_id`,`period_id`,`period_year`,`payroll_date`,`from`,`to` 
                                        FROM time_period_list  tpl 
                                        JOIN users_profile up ON up.company_id =  tpl.`company_id`  
                                        AND up.`user_id` = '".$this->user->user_id."' 
                                        AND tpl.record_id = ".$filter_value;
                            $fresult = $this->db->query($fqry)->row_array();

                            $filter .= " AND ( ({$this->db->dbprefix}{$this->mod->table}.date_from BETWEEN '{$fresult['from']}' AND '{$fresult['to']}')";
                            $filter .= " OR ({$this->db->dbprefix}{$this->mod->table}.date_to BETWEEN '{$fresult['from']}' AND '{$fresult['to']}') )";
                        }
                    }else{
                        $filter .= " AND {$this->db->dbprefix}{$this->mod->table}.". $filter_by_key .' = "'.$filter_value.'"';      
                    }
                }
            }
        }
        /** end - for status filter **/ 

        if( $page == 1 )
        {
            $searches = $this->session->userdata('search');
            if( $searches ){
                foreach( $searches as $mod_code => $old_search )
                {
                    if( $mod_code != $this->mod->mod_code )
                    {
                        $searches[$this->mod->mod_code] = "";
                    }
                }
            }
            $searches[$this->mod->mod_code] = $search;
            $this->session->set_userdata('search', $searches);
        }
        $page = ($page-1) * 10; //echo $page;
        $page = ($page < 0 ? 0 : $page);
        $records = $this->mod->_get_list($page, 10, $search, $trash,$filter); // for status filter

        $this->response->records_retrieve = sizeof($records);
        $this->response->list = '';
        $this->response->total_record = count($records);

        if( count($records) > 0 ){

            foreach( $records as $record )
            {
                $rec = array(
                    'detail_url' => '#',
                    'edit_url' => '#',
                    'delete_url' => '#',
                    'options' => ''
                );

                $this->_list_options( $record, $rec );
                
                $record = array_merge($record, $rec);
                $forms_validation = $this->time_form_policies->validate_form_cancel_status($record['record_id']);
                $record = array_merge($record, $forms_validation);

                if( $this->input->post('mobileapp') )
                    $this->response->list .= $this->load->blade('list_template_mobile', $record, true);
                else
                    $this->response->list .= $this->load->blade('list_template', $record, true);
                
            }

            $this->response->no_record = '';

        }
        else{

            $this->response->list = "";
        }
    
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );
    
        $this->_ajax_return();
    }

    public function compute_maternity_days()
    {
        $this->_ajax_only();
        if( strtotime($this->input->post('date_from')) ){
            $date_from = $this->input->post('date_from');
        }else{
            $date_from = date('F d, Y');
        }

        if($this->input->post('delivery_id') == 0){
            $this->response->date_from = $date_from;
            $this->response->date_to = date('F d, Y', strtotime($date_from. " + 60 days"));
            $this->response->days = 60;
        }else{
            $this->db->select('leave_days');
            $this->db->where('deleted', '0');
            $this->db->where('delivery_id', $this->input->post('delivery_id'));
            $maternity_details = $this->db->get('time_delivery')->row_array();

            $date = date('Y-m-d', strtotime($date_from));
            $this->response->date_from = $date_from;
            $this->response->date_to = date('F d, Y', strtotime($date_from. " + {$maternity_details['leave_days']} days"));
            $this->response->days = $maternity_details['leave_days'];
        }

        $this->_ajax_return();
    }

    public function compute_paternity_days()
    {
        $this->_ajax_only();
        if( strtotime($this->input->post('date_from')) ){
            $date_from = $this->input->post('date_from');
        }else{
            $date_from = date('F d, Y');
        }

        if($this->input->post('delivery_id') == 0){
            $this->response->date_from = $date_from;
            $this->response->date_to = date('F d, Y', strtotime($date_from. " + 60 days"));
            $this->response->days = 60;
        }else{
            $this->db->select('paternity_leave_days');
            $this->db->where('deleted', '0');
            $this->db->where('delivery_id', $this->input->post('delivery_id'));
            $paternity_details = $this->db->get('time_delivery')->row_array();            

            //START get days count
            $date_to = date('F d, Y', strtotime($date_from. " + {$paternity_details['paternity_leave_days']} days"));
            $start = new DateTime($date_from);
            $end = new DateTime($date_to);      
            // otherwise the  end date is excluded (bug?)
            // $end->modify('+1 day');

            $interval = $end->diff($start);
            // total days
            $days = $paternity_details['paternity_leave_days'];
            $day_count = 0;

            // create an iterateable period of date (P1D equates to 1 day)
            $period = new DatePeriod($start, new DateInterval('P1D'), $end);
            $period = iterator_to_array($period);
            $rest_days= array();

            foreach($period as $dt) {
                $form_holiday = array();
                $form_holiday = $this->mod->check_if_holiday($dt->format('Y-m-d'), $this->user->user_id);
                $forms_rest_day_count = $this->mod->check_rest_day($this->user->user_id, $dt->format('Y-m-d'));

                if( count($form_holiday) > 0 || ( $forms_rest_day_count > 0) ){           
                    $day_count++;
                }
            }
            $days = $days + $day_count;

            $this->response->date_from = $date_from;
            $this->response->date_to = date('F d, Y', strtotime($date_from. " + {$days} days"));
            $this->response->days = $paternity_details['paternity_leave_days'];
        }

        $this->_ajax_return();
    }

    function selected_dates($forms_id){

        $selected_dates = $this->mod->get_selected_dates($forms_id);
        $data['duration'] = $this->mod->get_duration();
        $days = 0;

        $forms_info = $this->mod->get_forms_details($forms_id);
        $date_from = ( $forms_info['date_from'] == "" )? "" : date('Y-m-d', strtotime($forms_info['date_from'])); 
        $date_to = ( $forms_info['date_to'] == "" )? "" : date('Y-m-d', strtotime($forms_info['date_to']));
    
        //START get days count
        $start = new DateTime($date_from);
        $end = new DateTime($date_to);      
        // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        $interval = $end->diff($start);
        // total days
        $days = $interval->days;
        $day_count = 0;

        // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);
        $period = iterator_to_array($period);

        // best stored as array, so you can add more than one
        $holidays = array();
        $dates = array();
        $selected_dates_count = 0;

        if( $date_from != "" || $date_to != "" ){
            
            $rest_days= array();
            // foreach($period as $dt) {
            //     $forms_rest_day = $this->mod->check_if_rest_day($forms_info['user_id'], $dt->format('Y-m-d'));
            //     foreach($forms_rest_day as $forms_rest){
            //         $rest_days[] = $forms_rest['rest_day'];
            //     }
            // }

            foreach($period as $dt) {
                $form_holiday = array();
                $form_holiday = $this->mod->check_if_holiday($dt->format('Y-m-d'));
                $forms_rest_day_count = $this->mod->check_rest_day($forms_info['user_id'], $dt->format('Y-m-d'));

                if(count($form_holiday) > 0 || $forms_rest_day_count > 0){           
                    $days--;
                }else{
                    $duration_id = 1;
                    $curr = $dt->format('D');
                    $hours = 0;
                    // if($selected_dates_count < count($selected_dates)){
                        foreach($selected_dates as $selected_date){
                            if($selected_date['date'] == $dt->format('Y-m-d')){
                                $duration_id = $selected_date['duration_id'];
                                $hours = $selected_date['hrs'];
                                $day_count += $selected_date['day'];
                            }
                        }
                    // }else{
                    //     $duration_id = 1;
                    // }
                    $dates[$dt->format('F d, Y')][$curr] = $duration_id;
                    $dates[$dt->format('F d, Y')]['hrs'] = $hours;
                    $selected_dates_count++;
                }
            }        
        }

        $data['days'] = $days;
        $data['dates'] = $dates;
        $data['duration'] = $this->mod->get_duration();
        $data['disabled'] = $this->input->post('form_status_id')> 2 ? "disabled" : "";

        return $data;
    }
    
    function download_file($upload_id){   
        $this->db->select("upload_path")
        ->from("system_uploads")
        ->where("upload_id = {$upload_id}");

        $image_details = $this->db->get()->row_array();   
        $path = base_url() . $image_details['upload_path'];
        
        header('Content-disposition: attachment; filename='.substr( $image_details['upload_path'], strrpos( $image_details['upload_path'], '/' )+1 ).'');
        header('Content-type: txt/pdf');
        readfile($path);
    }   

    function check_reassign_approvals(){

        $this->load->model('form_application_manage_model', 'form_manage');
        $data['current_user']           = $this->user->user_id;
        $data['todos']                  = $this->form_manage->checkIfapprover($data['current_user']);

        return count($data['todos']);
    }

    function add_form() {
        $this->_ajax_only();

        $data['form_value'] = $this->input->post('form_value');

        $this->load->helper('file');
        $this->load->helper('form');
        $this->response->add_form = $this->load->view('forms/'.$this->input->post('add_form'), $data, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
            );

        $this->_ajax_return();
    }

    function check_for_validation($data=array(), $record_id=0){
        $valid_qry = "SELECT tf.* FROM {$this->db->dbprefix}time_form tf
                LEFT JOIN {$this->db->dbprefix}time_form_class tfc ON tf.form_id = tfc.form_id
                LEFT JOIN {$this->db->dbprefix}time_form_class_policy tfcp ON tfc.class_id = tfcp.class_id
                LEFT JOIN {$this->db->dbprefix}users_profile up ON FIND_IN_SET(up.company_id, tfcp.company_id)
                LEFT JOIN {$this->db->dbprefix}partners prs ON up.user_id = prs.user_id
                LEFT JOIN {$this->db->dbprefix}users usr ON up.user_id = usr.user_id
                LEFT JOIN {$this->db->dbprefix}partners_personal pp ON prs.partner_id = pp.partner_id AND pp.key = 'gender'
                LEFT JOIN {$this->db->dbprefix}partners_personal pps ON prs.partner_id = pps.partner_id AND pps.key = 'solo_parent'
                WHERE tf.form_code IN
                ('{$data['form_code']}')
                AND up.user_id = {$data['user_id']}
                AND tfcp.class_value = 'YES'
                AND tfc.class_code = '{$data['form_code']}-DO-VALIDATION-BEFORE-APPROVAL'
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
        $valid_sql = $this->db->query($valid_qry);
        
        if($valid_sql->num_rows() > 0){
            $valid_qry = "SELECT tf.* FROM {$this->db->dbprefix}time_form tf
                    LEFT JOIN {$this->db->dbprefix}time_form_class tfc ON tf.form_id = tfc.form_id
                    LEFT JOIN {$this->db->dbprefix}time_form_class_policy tfcp ON tfc.class_id = tfcp.class_id
                    LEFT JOIN {$this->db->dbprefix}users_profile up ON FIND_IN_SET(up.company_id, tfcp.company_id)
                    LEFT JOIN {$this->db->dbprefix}partners prs ON up.user_id = prs.user_id
                    LEFT JOIN {$this->db->dbprefix}users usr ON up.user_id = usr.user_id
                    LEFT JOIN {$this->db->dbprefix}partners_personal pp ON prs.partner_id = pp.partner_id AND pp.key = 'gender'
                    LEFT JOIN {$this->db->dbprefix}partners_personal pps ON prs.partner_id = pps.partner_id AND pps.key = 'solo_parent'
                    WHERE tf.form_code IN
                    ('{$data['form_code']}')
                    AND up.user_id = {$data['user_id']}
                    AND tfcp.class_value <= '{$data['day']}'
                    AND tfc.class_code = '{$data['form_code']}-DAYS-TO-VALIDATE-BEFORE-APPROVAL'
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
            $valid_sql = $this->db->query($valid_qry);
            if($valid_sql->num_rows() > 0){
                $updateRec['form_status_id'] = 4;
                $this->db->update( $this->mod->table, $updateRec, array( $this->mod->primary_key => $record_id) );
                $updateAppRec['form_status_id'] = 3;
                $this->db->update( 'time_forms_approver', $updateAppRec, array( $this->mod->primary_key => $record_id) );
            }
        }
    }

}