<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Form_application_admin extends MY_PrivateController
{
    public function __construct()
    {
        $this->load->model('form_application_admin_model', 'mod');
        $this->load->library('time_form_policies');

        $this->lang->load( 'form_application_admin' );
        $this->lang->load( 'form_application' );
        parent::__construct();
    }
    
    private $current_user = array();

    public function index()
    {
        if( !$this->permission['list'] )
        {
            echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
            die();
        }
        $this->load->model('form_application_manage_model', 'app_manage');
        $this->load->model('form_application_model', 'app_personal');
        $user_setting = APPPATH . 'config/users/'. $this->user->user_id .'.php';
        $user_id = $this->user->user_id;
        $this->load->config( "users/{$user_id}.php", false, true );
        $user = $this->config->item('user');

        $this->load->config( 'roles/'. $user['role_id'] .'/permission.php', false, true );
        $permission = $this->config->item('permission');
        $data['permission_app_manage'] = isset($permission[$this->app_manage->mod_code]['list']) ? $permission[$this->app_manage->mod_code]['list'] : 0;
        $data['permission_app_admin'] = isset($this->permission['list']) ? $this->permission['list'] : 0;
        $data['permission_app_personal'] = isset($permission[$this->app_personal->mod_code]['list']) ? $permission[$this->app_personal->mod_code]['list'] : 0;
        
        $this->load->model('leave_convert_model', 'leave_convert');
        $data['leave_convert'] = isset($permission[$this->leave_convert->mod_code]['list']) ? $permission[$this->leave_convert->mod_code]['list'] : 0;
        $this->load->model('forms_request_model', 'forms_req');
        $data['permission_app_request'] = isset($permission[$this->forms_req->mod_code]['list']) ? $permission[$this->forms_req->mod_code]['list'] : 0;
        $this->load->model('hr_validation_model', 'hr_valid');
        $data['permission_validation'] = isset($permission[$this->hr_valid->mod_code]['list']) ? $permission[$this->hr_valid->mod_code]['list'] : 0;

        $leave_qry = "SELECT * FROM {$this->db->dbprefix}time_form WHERE is_leave = 1 AND deleted = 0";
        $data['leaves_data'] = $this->db->query($leave_qry)->result_array();
        $leave_qry = "SELECT * FROM {$this->db->dbprefix}time_form WHERE is_leave = 0 AND deleted = 0";
        $data['others_data'] = $this->db->query($leave_qry)->result_array();
        
        // Pay period filter
        // limited to 5 paydates
        $data['pay_dates'] = $this->app_personal->get_period_list();

        $this->load->model('form_application_model', 'form_application');
        $data['form_status'] = $this->form_application->get_form_statuses();
                
        $this->load->vars($data);
        echo $this->load->blade('listing_custom')->with( $this->load->get_cached_vars() );
    }

    public function detail( $record_id )
    {

        parent::detail($record_id,true);

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
        $data['form_title'] = $form_info['form'].' Form';
        $data['upload_id']["val"] = array();
        $data['ut_time_in_out'] = "";
        $data['duration'] = $this->mod->get_duration();
        $this->load->model('form_application_model', 'formapp');
        $data['leave_balance'] = $this->formapp->get_leave_balance($forms_info['user_id'], date('Y-m-d'), 0);
        $data['form_approver_details'] = $this->mod->get_form_approver_info($this->record_id,$this->user->user_id);
        $data['form_approver_details']['approver_id'] = $this->user->user_id; //set user as the approver for administrator
        $data['bt_type'] = '';
        $data['scheduled'] = $forms_info['scheduled'];
        $data['addl_type'] = $forms_info['type'];
            $special_qry = "SELECT * FROM {$this->db->dbprefix}time_form_balance tfb
                    INNER JOIN {$this->db->dbprefix}time_form tf ON tf.form_id = tfb.form_id
                    WHERE user_id = {$forms_info['user_id']}
                    AND tf.special_leave = 1
                    AND tfb.year = '".date('Y')."'";
            $data['special_leaves'] = array();
            $special_leaves = $this->db->query($special_qry);
            if($special_leaves->num_rows > 0){
                $data['special_leaves'] = $special_leaves->result_array();
            }

        $data['uploads'] = $all_uploaded;

        $data['form_approver_details']['within_cutoff'] = $this->mod->check_within_cutoff('', $data['form_approver_details']['date_from'], $data['form_approver_details']['date_to'], $data['form_approver_details']['company_id']);

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
            $data['dtrp_type'] = 1;
            if($form_info['form_id']  == 10){
                $data['ut_time_in_out'] = ($data['shift_details']['logs_time_out'] == "-") ? date("M d, Y - h:i A", strtotime($data['shift_details']['shift_time_end'])) : date("M d, Y - h:i A", strtotime($data['shift_details']['logs_time_out']));
            }elseif($form_info['form_id'] == 15){
                $data['ut_time_in_out'] = ($data['shift_details']['logs_time_in'] == "-") ? date("h:i A", strtotime($data['shift_details']['shift_time_start'])) : date("h:i A", strtotime($data['shift_details']['logs_time_in']));
            }
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
                        if($data['form_id'] == 10 || $data['form_id'] == 15){ //undertime form/ excused tardiness
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
            case get_time_form_id('OBT'):
                //$data['bt_type'] = 1;
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['date_from'])), $forms_info['user_id']);
                $data['obt_transpo'] = array();
                if($data['forms_id']){
                    $qry = "SELECT * FROM {$this->db->dbprefix}time_forms_obt_transpo 
                            WHERE {$this->mod->primary_key} = {$data['forms_id']}";
                    $obt_transpo = $this->db->query($qry);
                    if($obt_transpo->num_rows() > 0){
                        $data['obt_transpo'] = $obt_transpo->result_array();
                    }
                }
            break;
            case get_time_form_id('OT'):
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['focus_date'])), $forms_info['user_id']);
            break;
            case get_time_form_id('UT'):
                $data['ut_type'] = $data['form_id'] == 10 ? 0 :1;
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['focus_date'])), $forms_info['user_id']);
            break;
            case get_time_form_id('MS'):
                $data['ut_type'] = $data['form_id'] == 10 ? 0 :1;
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['date_from'])), $forms_info['user_id']);
            break;
            case get_time_form_id('ET'):
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['date_from'])), $forms_info['user_id']);
            break;
            case get_time_form_id('BL'):
                $data['bday_duration'] = 1;
            break;
            case get_time_form_id('DTRP'):
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['focus_date'])), $forms_info['user_id']);
            break;
            case get_time_form_id('CWS'):
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['date_from'])), $forms_info['user_id']);
               $data['shift_id']['val'] = $data['shift_details']['shift_id'];
            break;
            case get_time_form_id('ADDL'): //ADDL
                $this->load->model('form_application_model', 'form_app');
                //Get Shift details
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['date_from'])), $forms_info['user_id']);
                $data['ot_leave_credits']   = $this->form_app->get_ot_leave_credits($forms_info['user_id'], $form_info['form_id'], $forms_info['forms_id']);
                $selected_leave_credits     = $this->form_app->get_selected_leave_credits($forms_info['user_id'], $form_info['form_id'], '', $forms_info['forms_id']);
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
                $this->load->model('form_application_model', 'form_app');
                $date_time_from = $this->form_app->get_time_from_to_dates($record_id, date("Y-m-d", strtotime($forms_data['time_forms.date_from'])), 'time_from', $data['form_id'], $data['bt_type']);
                $date_time_to = $this->form_app->get_time_from_to_dates($record_id, date("Y-m-d", strtotime($forms_data['time_forms.date_to'])), 'time_to', $data['form_id'], $data['bt_type']);
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
                    $data['date_from']["val"] = (!strtotime($date_time_from)) ? "" : date("F d, Y", strtotime($date_time_from));
                }else if( strtotime($date_time_to) ){
                    $data['res_type'] = 0;
                    $data['res_type_desc'] = 'Official Undertime';
                    $data['ut_time_in_out'] = date("h:i A", strtotime($date_time_to));
                    $data['date_to']["val"] = ( !strtotime($date_time_to)) ? "" : date("F d, Y", strtotime($date_time_to));
                }
                
                $data['shifts'] = $this->form_app->get_shifts();
                $data['shift_details'] = $this->form_app->get_shift_details(date("Y-m-d", strtotime($forms_dates_duration['time_forms.date_from'])), $this->user->user_id);
            break;
        }

        $data['remarks'] = $this->mod->get_approver_remarks($data['forms_id']);

        if($data['form_status_id']['val'] == 8){ //disapproved, display remarks
            $data['disapproved_cancelled_remarks'] = $this->mod->get_disapproved_cancelled_remarks($record_id);
        }
        
        $data['approver_details'] = $this->mod->get_approver_details($data['forms_id'], $this->user->user_id);
        if(!count($data['approver_details']) > 0){
            $data['approver_details']['user_id'] = $this->user->user_id;
            $data['approver_details']['form_status_id'] = $data['form_approver_details']['approver_status_id'];
        }

        if($data['form_status_id']['val'] > 1){
            $this->load->model('my_calendar_model', 'my_calendar');
            $data['approver_list'] = $this->my_calendar->get_time_forms_approvers($record_id);
            $data['approver_title'] = "Approval Status";
        }else{
            $this->load->model('form_application_manage_model', 'manage_app');
            $data['approver_list'] = $this->manage_app->get_form_approvers($data['forms_id']);
            $data['approver_title'] = "Approver/s";
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
        echo $this->load->blade('detail.detail_'.strtolower($form_info['form_code']).'_form')->with( $this->load->get_cached_vars() );

    }

    function _list_options( $record, &$rec )
    {

        if( $this->permission['detail'] )
        {
            if( $record['form_code'] == 'DTRU') {
                $rec['detail_url'] = get_mod_route('timerecord', 'updating'. '/manage/' . $record['forms_id']);
            } else {
                $rec['detail_url'] = $this->mod->url . '/detail/' . $record['forms_id'];
            }
        }
        if( $this->permission['edit'] )
        {
            $rec['edit_url'] = $this->mod->url . '/edit_form/' . $record['forms_id'];
        }

        if($record['form_status_id'] != 8){
            $rec['options'] .= '<li><a href="#"><i class="fa fa-check text-success"></i> '.lang('form_application_admin.approved').'</a></li>';
            $rec['options'] .= '<li><a href="#"><i class="fa fa-times text-danger"></i> '.lang('form_application_admin.disapproved').'</a></li>';
        }
    }

    function get_selected_dates(){

        $this->_ajax_only();

        $selected_dates = array();
        if($this->input->post('forms_id') > 0){
            $selected_dates = $this->mod->get_selected_dates($this->input->post('forms_id'));
        }
        $data['duration'] = $this->mod->get_duration();
        $days = 0;

        if( $this->input->post('view') == 'edit' || $this->input->post('view') == 'edit_blanket'  ){
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

        if( $date_from != "" || $date_to != "" ){

            $rest_days= array();
            // foreach($period as $dt) {
            //     $forms_rest_day = $this->mod->check_if_rest_day($this->user->user_id, $dt->format('Y-m-d'));
            //     foreach($forms_rest_day as $forms_rest){
            //         $rest_days[] = $forms_rest['rest_day'];
            //     }
            // }

            foreach($period as $dt) {
                $form_holiday = array();
                $form_holiday = $this->mod->check_if_holiday($dt->format('Y-m-d'));
                $forms_rest_day_count = $this->mod->check_rest_day($this->user->user_id, $dt->format('Y-m-d'));

                if(count($form_holiday) > 0 || $forms_rest_day_count > 0){           
                    $days--;
                }else{
                    $duration_id = 1;
                    $curr = $dt->format('D');
                    
                    // if($selected_dates_count < count($selected_dates)){
                        foreach($selected_dates as $selected_date){
                            if($selected_date['date'] == $dt->format('Y-m-d')){
                                $duration_id = $selected_date['duration_id'];
                                $day_count += $selected_date['day'];
                            }
                        }
                    // }else{
                    //     $duration_id = 1;
                    // }
                    $dates[$dt->format('F d, Y')][$curr] = $duration_id;
                    $selected_dates_count++;
                }
            }
        
        }

        $data['days'] = $days;
        $data['dates'] = $dates;
        $data['duration'] = $this->mod->get_duration();
        $data['disabled'] = $this->input->post('form_status_id')> 2 ? "disabled" : "";

        if($this->input->post('view') == 'detail'){
            $view['content'] = $this->load->view('detail/view_date', $data, true);
        }else{
            $view['content'] = $this->load->view('edit/change_date', $data, true);
        }
		$this->response->data = $data;
        $this->response->selected_dates = $view['content'];
        $this->response->days = $days;

        if($day_count > 0 && $day_count < 1){
            $this->response->days = "half";
        }else{
            if (strpos($day_count,'.5') !== false) {
                $day_count = explode(".",$day_count); 
                $this->response->days = $day_count[0]." and a half";
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


    public function forms_decission(){

        $this->current_user = $this->config->item('user');

        $this->_ajax_only();
        $data = array();

        $forms_validation = $this->time_form_policies->validate_form_change_status($this->input->post('formid'),$this->input->post('decission'));         
            
        if(array_key_exists('error', $forms_validation) ){
            if(count($forms_validation['error']) > 0 ){            
                foreach( $forms_validation['error'] as $f => $f_error )
                {
                    $this->response->message[] = array(
                        'message' => $f_error,
                        'type' => 'error'
                        );  
                }  
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
        
        if(count($forms_validation['error']) > 0 ){  
            $this->_ajax_return();  
        }else{
            // 1. set forms approver decision
            $result = $this->mod->setDecission($this->input->post());

            // 2. build a notification message
            //    designed to determine the type of form
            //    the recipient has submitted.
            $approver       = $this->input->post('username');
            $action         = $this->input->post('decission') == '1' ? ' Approved ' : ' Declined '; 
            $form_name      = $this->input->post('formname'); 
            $recipient      = $this->input->post('formownerid');
            $notif_message  = $approver . $action . ' your ' . $form_name . ' application.';

            $data['user_id']        = $this->session->userdata['user']->user_id;                                // THE CURRENT LOGGED IN USER 
            $data['display_name']   = $this->current_user['lastname']. ", ". $this->current_user['firstname'];  // THE CURRENT LOGGED IN USER'S DISPLAY NAME
            $data['feed_content']   = $notif_message;                                                           // THE MAIN FEED BODY
            $data['recipient_id']   = $recipient;                                                               // TO WHOM THIS POST IS INTENDED TO
            $data['status']         = 'info';                                                                   // DANGER, INFO, SUCCESS & WARNING
            $data['message_type']       = 'Time Record';

            // ADD NEW DATA FEED ENTRY
            $latest = $this->mod->newPostData($data);
            $this->response->target = $latest;
            
            //Check if filed form is approved and hr validation is enabled
            if($form_name['form_status_id'] == 6){ //approved already
                $this->load->model('form_application_manage_model', 'form_manage');
                $this->form_manage->transfer_to_validation($form_name);
            }elseif($form_name['form_status_id'] == 7){ //disapproved
                $this->load->model('form_application_manage_model', 'form_manage');
                $this->form_manage->remove_additiona_leave($form_name);
            }

            // determines to where the action was 
            // performed and used by after_save to
            // know which notification to broadcast
            $this->response->type       = 'todo';
            $this->response->action     = 'insert';

            $this->response->message[]  = array(
                'message'   => lang('common.save_successful'),
                'type'      => 'success'
            );

            $this->_ajax_return();
    }

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
        $filter = $this->input->post('filter');
        $trash = $this->input->post('trash') == 'true' ? true : false;

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
                                        JOIN users_profile up ON up.project_id =  tpl.`project_id`  
                                        AND up.`user_id` = '".$this->user->user_id."' 
                                        AND tpl.record_id = ".$filter_value;
                            $fresult = $this->db->query($fqry)->row_array();

                            $filter .= " AND ( (date_from BETWEEN '{$fresult['from']}' AND '{$fresult['to']}')";
                            $filter .= " OR ( date_to BETWEEN '{$fresult['from']}' AND '{$fresult['to']}') )";
                        }
                    }else{
                        $filter .= " AND ". $filter_by_key .' = "'.$filter_value.'"';      
                    }
                }
            }
        }
        
        $filter .= " AND form_status_id <> 4"; // exclude all for hr validation

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
        $records = $this->mod->_get_list($page, 10, $search, $trash,$filter);

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
                $remarks['remarks'] = array();
                $comments = $this->mod->get_approver_remarks($record['forms_id']);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $record = array_merge($record, $remarks);
                
                $this->response->list .= $this->load->blade('list_template', $record, true);
            }

            $this->response->no_record = '';

        }
        else{

            $this->response->list = "";

        }

    
        $this->_ajax_return();
    }

    function get_form_details(){
        $this->_ajax_only();
        $form_id = $this->input->post('form_id');
        $forms_id = $this->input->post('forms_id');

        $this->response->form_details = '';
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
            case get_time_form_id('EML'): //Employee’s Marriage
            case get_time_form_id('MEC'): //Marriage of Child
            case get_time_form_id('ECC'): //Childs Circumcision
            case get_time_form_id('ECB'): //Childs Baptism
            case get_time_form_id('RBL'): //Relatives Bereavement Leave
            case get_time_form_id('PiL'): //Pilgrimage Leave
            case get_time_form_id('MeL'): //Menstruation Leave
            case get_time_form_id('FBL'): //Family Bereavement Leave
            case get_time_form_id('PUL'):
            case get_time_form_id('EXL'):
                $form_details = $this->mod->get_leave_details($forms_id, $this->user->user_id);
                $remarks['remarks'] = array();
                $comments = $this->mod->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);

                $this->response->form_details .= $this->load->blade('edit/leave_details', $form_details, true);
            break;
            case get_time_form_id('OBT')://obt
                $form_details = $this->mod->get_obt_details($forms_id, $this->user->user_id);
                $remarks['remarks'] = array();
                $comments = $this->mod->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);

                $this->response->form_details .= $this->load->blade('edit/obt_details', $form_details, true);            
            break;
            case get_time_form_id('OT')://ot
                $form_details = $this->mod->get_ot_ut_dtrp_details($forms_id, $this->user->user_id);
                $remarks['remarks'] = array();
                $comments = $this->mod->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);

                $this->response->form_details .= $this->load->blade('edit/ot_details', $form_details, true);            
            break;
            case get_time_form_id('UT')://ut
                $form_details = $this->mod->get_ot_ut_dtrp_details($forms_id, $this->user->user_id);
                $remarks['remarks'] = array();
                $comments = $this->mod->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);

                $this->response->form_details .= $this->load->blade('edit/ut_details', $form_details, true);            
            break;
            case get_time_form_id('DTRP')://dtrp
                $form_details = $this->mod->get_ot_ut_dtrp_details($forms_id, $this->user->user_id);
                $remarks['remarks'] = array();
                $comments = $this->mod->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);

                $this->response->form_details .= $this->load->blade('edit/dtrp_details', $form_details, true);            
            break;
            case get_time_form_id('CWS')://cws
                $form_details = $this->mod->get_cws_details($forms_id, $this->user->user_id);
                $remarks['remarks'] = array();
                $comments = $this->mod->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);

                $this->response->form_details .= $this->load->blade('edit/cws_details', $form_details, true);            
            break;
            case get_time_form_id('ADDL'): //ADDL
                $form_details = $this->mod->get_ot_ut_dtrp_details($forms_id, $this->user->user_id);
                $form_page = 'addl_details';
                if($form_details['type'] == 'Use'){
                    $form_details = $this->mod->get_leave_details($forms_id, $this->user->user_id);
                    $form_page = 'leave_details';
                }
                $remarks['remarks'] = array();
                $comments = $this->mod->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);
                $this->response->form_details .= $this->load->blade('edit/'.$form_page, $form_details, true);            
            break;
            case get_time_form_id('RES'): //RES
                $form_details = $this->mod->get_ot_ut_dtrp_details($forms_id, $this->user->user_id);
                if( ( strtotime($form_details['time_from'])) && ( strtotime($form_details['time_to'])) ){
                    $form_details['date_from'] = (!strtotime($form_details['time_from'])) ? "" : date("F d, Y - h:i a", strtotime($form_details['time_from']));
                    $form_details['date_to'] = ( !strtotime($form_details['time_to'])) ? "" : date("F d, Y - h:i a", strtotime($form_details['time_to']));
                    $form_details['res_type'] = 2;
                    $form_details['res_type_desc'] = 'In Between';
                    $form_details['ut_time_in_out'] = '';
                }else if( strtotime($form_details['time_from']) ){
                    $form_details['res_type'] = 1;
                    $form_details['res_type_desc'] = 'Excused Tardiness';
                    $form_details['date_from'] = (!strtotime($form_details['time_from'])) ? "" : date("F d, Y - h:i a", strtotime($form_details['time_from']));
                }else if( strtotime($form_details['time_to']) ){
                    $form_details['res_type'] = 0;
                    $form_details['res_type_desc'] = 'Official Undertime';
                    $form_details['date_to'] = (!strtotime($form_details['time_to'])) ? "" : date("F d, Y - h:i a", strtotime($form_details['time_to']));
                }
                $remarks['remarks'] = array();
                $comments = $this->mod->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);
                $form_page = 'res_details';
                // echo "<pre>";
                // print_r($form_details);
                $this->response->form_details .= $this->load->blade('edit/'.$form_page, $form_details, true);  
                
            break;
        }

        $this->_ajax_return();
    }

    public function edit($record_id=0)
    {
        if( !$this->permission['edit'] )
        {
            echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
            die();
        }

        $data['form_type'] = '';
        $data['record']['time_forms.date_from'] = date('F j, Y');
        $data['record']['time_forms.date_to'] = date('F j, Y');
        $data['record']['time_forms.reason'] = '';
        $data['ut_time_in_out'] = '';
        $data['form_status_id'] = '';
        $data['record_id'] = '';
        $data['form_id'] = '';
        $data['form_code'] = '';
        $data['form_title'] = '';

        //filter
        $data['record']['users_location.location_id'] = '';
        $data['record']['users_company.company_id'] = '';
        $data['record']['users_project.project_id'] = '';
        $data['record']['users_department.department_id'] = '';
        $data['record']['partners.partner_id'] = '';
        $data['record']['users_assignment.assignment_id'] = '';

        //url
        $data['url'] = $this->mod->url;
        $data['back_url'] = get_mod_route('applicationadmin');

        $this->load->vars($data);

        $this->load->helper('form');
        $this->load->helper('file');
        echo $this->load->blade('edit.blanket_form')->with( $this->load->get_cached_vars() );
    }

    public function edit_blanket_form($record_id=0)
    {
        if( !$this->permission['edit'] )
        {
            echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
            die();
        }

        $data['form_type'] = $data['form_id'] = $this->input->post('form_type');
        $data['record']['time_forms.date_from'] = date('F j, Y');
        $data['record']['time_forms.date_to'] = date('F j, Y');
        $data['record']['time_forms.reason'] = '';
        $data['work_schedule'] = '';
        $data['record']['time_forms.form_date'] = date('F j, Y');
        $data['ut_time_in_out'] = '';
        $data['form_status_id'] = '';
        $data['record_id'] = '';

        //filter
        $data['record']['users_location.location_id'] = '';
        $data['record']['users_company.company_id'] = '';
        $data['record']['users_project.project_id'] = '';
        $data['record']['users_department.department_id'] = '';
        $data['record']['partners.partner_id'] = '';
        $data['record']['users_assignment.assignment_id'] = '';

        //url
        $data['url'] = $this->mod->url;
        $data['back_url'] = get_mod_route('applicationadmin');

        switch($data['form_type']){
            case 1: //sick leave  
            $data['form_code'] = 'SL';
            $data['form_title'] = 'Emergency Leave Blanket';
            $blanket_file_name = 'el_blanket.php';    
            break;        
            case 2: //vacation leave  
            $data['form_code'] = 'VL';
            $data['form_title'] = 'Emergency Leave Blanket';
            $blanket_file_name = 'el_blanket.php';     
            break;                           
            case 3: //emergency leave
            $data['form_code'] = 'EL';
            $data['form_title'] = 'Emergency Leave Blanket';
            $blanket_file_name = 'el_blanket.php';   
            break;           
            case 4: //bereavement leave
            $data['form_code'] = 'FL';
            $data['form_title'] = 'Emergency Leave Blanket';
            $blanket_file_name = 'el_blanket.php';       
            break;       
            case 5: //maternity leave
            $data['form_code'] = 'ML';
            $data['form_title'] = 'Emergency Leave Blanket';
            $blanket_file_name = 'el_blanket.php';   
            break;           
            case 6: //paternity leave
            $data['form_code'] = 'PL';
            $data['form_title'] = 'Emergency Leave Blanket';
            $blanket_file_name = 'el_blanket.php';     
            break;       
            case 7: //leave without pay leave
            $data['form_code'] = 'LWOP';
            $data['form_title'] = 'Emergency Leave Blanket';
            $blanket_file_name = 'el_blanket.php'; 
            break;            
            case 14: //Special Leave for Women
            $data['form_code'] = 'SLW';
            $data['form_title'] = 'Emergency Leave Blanket';
            $blanket_file_name = 'el_blanket.php';   
            break;          
            case 16: //Solo Parent Leave
            $data['form_code'] = 'SPL';
            $data['form_title'] = 'Emergency Leave Blanket';
            $blanket_file_name = 'el_blanket.php';   
            break;           
            case 17: //Victim of Violence Leave
            $data['form_code'] = 'VVL';
            $data['form_title'] = 'Emergency Leave Blanket';
            $blanket_file_name = 'el_blanket.php';
            break;  
            case 8: //Business Trip
            $data['bt_type'] = 1;
            $data['request_status_id'] = 1;
            $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d"), $this->user->user_id);
            $data['obt_transpo'] = array();            
            $data['form_code'] = 'OBT';
            $data['form_title'] = 'Business Trip';
            $blanket_file_name = 'obt_blanket.php';
            break;   
            case 9: //overtime
            $data['form_code'] = 'OT';
            $data['form_title'] = 'Overtime';
            $blanket_file_name = 'ot_blanket.php';
            break;  
            case 10: //undertime
            $data['form_code'] = 'UT';
            $data['form_title'] = 'Undertime Blanket';
            $blanket_file_name = 'ut_blanket.php';
            break;                                         
            case 11: //dtrp
            $data['dtrp_type'] = 1;
            $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d"), $this->user->user_id);            
            $data['form_code'] = 'DTRP';
            $data['form_title'] = 'Daily Time Record Problem';
            $blanket_file_name = 'dtrp_blanket.php'; 
            break;  
            case 12: //cws
            $data['shifts'] = $this->mod->get_shifts();
            $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d"), $this->user->user_id);            
            $data['shift_id']['val'] = '';
            $data['shift_to']['val'] = '';
            $data['form_code'] = 'CWS';
            $data['form_title'] = 'Change Work Schedule';
            $blanket_file_name = 'cws_blanket.php'; 
            break;                      
            case 15: //excused tardiness
            $data['form_code'] = 'ET';
            $data['form_title'] = 'Excused Tardiness Blanket';
            $blanket_file_name = 'et_blanket.php';
            break;
            case 29: //exceptional leave
            $data['form_code'] = 'EXL';
            $data['form_title'] = 'Exceptional Leave Blanket';
            $blanket_file_name = 'exl_blanket.php';
            break;
            case 20: //exceptional leave
            $data['form_code'] = 'MS';
            $data['form_title'] = 'Mandatory Saturday Blanket';
            $blanket_file_name = 'ms_blanket.php';
            break;
            case 26: //public leave
            $data['form_code'] = 'PUL';
            $data['form_title'] = 'Public Leave';
            $blanket_file_name = 'pul_blanket.php';
            break;    
            case 19: //service incetive leave  
            $data['form_code'] = 'SIL';
            $data['form_title'] = 'Emergency Leave Blanket';
            $blanket_file_name = 'el_blanket.php';     
            break;    
            case 21: //home leave
            $data['form_code'] = 'HL';
            $data['form_title'] = 'Home Leave Blanket';
            $blanket_file_name = 'el_blanket.php';   
            break;
            case 22: //leave incentive program
            $data['form_code'] = 'LIP';
            $data['form_title'] = 'Leave Incentive Program Blanket';
            $blanket_file_name = 'el_blanket.php';   
            break; 
            case 23: //force leave
            $data['form_code'] = 'FL';
            $data['form_title'] = 'Force Leave Blanket';
            $blanket_file_name = 'el_blanket.php';   
            break;                                          
        }

        $data['record']['partners.partner_id'] = '';
        $this->load->helper('form');
        $view['content'] = $this->load->view('edit/blanket_forms/'.$blanket_file_name, $data, true);

        $this->response->blanket_form = $view['content'];

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

    function update_department()
    {
        $this->_ajax_only();
        $this->response->departments = '';

        $company_id = implode(',',$this->input->post('company_id'));

        $qry = "SELECT DISTINCT(a.department_id), b.department_id, b.department
        FROM users_profile a
        LEFT JOIN {$this->db->dbprefix}users_department b ON b.department_id = a.department_id
        WHERE a.company_id IN ({$company_id}) AND b.deleted = 0
        ORDER BY b.department ASC";
        $departments = $this->db->query( $qry );
        $this->response->count = $departments->num_rows();
        foreach( $departments->result() as $department )
        {
            $this->response->departments .= '<option value="'.$department->department_id.'" selected="selected">'.$department->department.'</option>';
        }
        $this->_ajax_return();  
    }

    function update_employees()
    {
        $this->_ajax_only();
        $location_id = $this->input->post('location_id');
        $project_id = $this->input->post('project_id');
        $department_id = $this->input->post('department_id');

        $qry = "SELECT partners.alias, partners.partner_id, partners.user_id 
                FROM partners
                INNER JOIN users_profile ON partners.user_id = users_profile.user_id
                WHERE partners.deleted = 0 
                ";
        if ($this->input->post('location_id')){
            $location_id = implode(',',$this->input->post('location_id'));
            $qry .= " AND location_id IN ({$location_id}) ";
        }
        if ($this->input->post('project_id')){
            $project_id = implode(',',$this->input->post('project_id'));
            $qry .= " AND project_id IN ({$project_id}) ";
        }
        if ($this->input->post('department_id')){
            $department_id = implode(',',$this->input->post('department_id'));
            $qry .= " AND department_id IN ({$department_id})  ";
        }

        // for role caegory filtering
        $qry_category = $this->mod->get_role_category('users_profile');

        if ($qry_category != ''){
            $qry .= ' AND ' . $qry_category;
        }

        $qry .= " ORDER BY partners.alias ASC";

        $employees = $this->db->query( $qry );
        $this->response->count = $employees->num_rows();
        $this->response->employees = '';
        foreach( $employees->result() as $employee )
        {   
            $data['partner_id_options'][$employee->user_id] = $employee->alias;
            $this->response->employees .= '<option value="'.$employee->user_id.'" selected="selected">'.$employee->alias.'</option>';
        }

        $data['record']['partners.partner_id'] = '';
        $view['content'] = $this->load->view('edit/change_employees', $data, true);

        $this->response->filtered_employees = $view['content'];

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

    function save_form()
    {
        $this->_ajax_only();
        $this->response->saved = false; 
        $error = false;
        if( !$this->permission['add'] && !$this->permission['edit'] )
        {
            $this->response->message[] = array(
                'message' => 'You dont have sufficient permission to get the list of field groups for this module, please notify the System Administrator.',
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        $form_id = $this->input->post('form_type');

        foreach($this->input->post('time_forms') as $key => $val ){
            $_POST[$key] = $val;
        }

        $this->response->forms_id = $forms_id = $this->input->post('record_id');
        /*******START Filed FORM validation********/
        $date_time_from = '';
        $date_time_to = '';
        $date_time = '';

        $date = substr($this->input->post('date_from'), 0, -11);

        if (!in_array($form_id , array(9,10,11))){
            $_POST['focus_date'] = date('Y-m-d',strtotime($date));
        }
        else{
            if ($this->input->post('focus_date') && $this->input->post('focus_date') != ''){
                $_POST['focus_date'] = date('Y-m-d',strtotime($this->input->post('focus_date')));
            }
            else{
                $_POST['focus_date'] = date('Y-m-d',strtotime($date));
            }
        }

        switch($form_id){
            case get_time_form_id('OT'): //OT
            case get_time_form_id('DTRP'): //DTRP
            $date_from = date('Y-m-d', strtotime(substr($_POST['date_from'], 0, -11))); 
            $date_to = date('Y-m-d', strtotime(substr($_POST['date_to'], 0, -11)));
            $date_time_from = date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$_POST['date_from'])));
            $date_time_to = date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$_POST['date_to'])));
            //$_POST['focus_date'] = date('Y-m-d',strtotime($date_from));
            break;   
            case get_time_form_id('OBT'): //OBT
            $date_from = date('Y-m-d', strtotime(substr($_POST['date_from'], 0, -11))); 
            $date_to = date('Y-m-d', strtotime(substr($_POST['date_to'], 0, -11)));
            $date_time_from = date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$_POST['date_from'])));
            $date_time_to = date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$_POST['date_to'])));
            $_POST['focus_date'] = date('Y-m-d',strtotime($date_from));  
            break;                   
            case get_time_form_id('UT')://UT
                $_POST['date_from'] = $_POST['date_to'];
                $date_from = date('Y-m-d', strtotime($_POST['date_from'])); 
                $date_to = date('Y-m-d', strtotime($_POST['date_to']));
                //$_POST['focus_date'] = date('Y-m-d',strtotime($date_from));
                $date_time = date('Y-m-d', strtotime($_POST['focus_date']))." ".date("H:i",strtotime($this->input->post('ut_time_in_out')));  
                //$_POST['focus_date'] = date('Y-m-d',strtotime($date_from));
                $validation_rules[] = 
                    array(
                        'field' => 'time_forms[date_to]',
                        'label' => 'Date',
                        'rules' => 'required'
                );
                $validation_rules[] = 
                    array(
                        'field' => 'ut_time_in_out',
                        'label' => 'Time',
                        'rules' => 'required'
                );

            break;
            case get_time_form_id('ET')://ET
                $_POST['date_to'] = $_POST['date_from'];
                $date_from = date('Y-m-d', strtotime($_POST['date_from'])); 
                $date_to = date('Y-m-d', strtotime($_POST['date_to']));
                $_POST['focus_date'] = date('Y-m-d',strtotime($date_from));
                $date_time = date('Y-m-d', strtotime($_POST['focus_date']))." ".date("H:i",strtotime($this->input->post('ut_time_in_out')));  
                $_POST['focus_date'] = date('Y-m-d',strtotime($date_from));
                $validation_rules[] = 
                    array(
                        'field' => 'time_forms[date_from]',
                        'label' => 'Date',
                        'rules' => 'required'
                );
                $validation_rules[] = 
                    array(
                        'field' => 'ut_time_in_out',
                        'label' => 'Time',
                        'rules' => 'required'
                );

            break;
            case get_time_form_id('CWS')://CWS
                $_POST['date_to'] = $_POST['date_from'];
                $date_from = date('Y-m-d', strtotime($this->input->post('date_from'))); 
                $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
                $_POST['focus_date'] = date('Y-m-d',strtotime($date_from));
                break;            
            case get_time_form_id('MS')://Mandatory Saturday
                $date_from = date('Y-m-d', strtotime($_POST['form_date'])); 
                $date_to = date('Y-m-d', strtotime($_POST['form_date'])); 
                $_POST['focus_date'] = date('Y-m-d',strtotime($date_from));
                $validation_rules[] = 
                    array(
                        'field' => 'time_forms[form_date]',
                        'label' => 'Date',
                        'rules' => 'required'
                );
                $validation_rules[] = 
                    array(
                        'field' => 'work_schedule',
                        'label' => 'Work Schedule',
                        'rules' => 'required'
                );

            break;
            case get_time_form_id('RL')://Reserve Leave
                $date_from = date('Y-m-d', strtotime($_POST['date_from'])); 
                $date_to = date('Y-m-d', strtotime($_POST['date_to'])); 
                $_POST['focus_date'] = date('Y-m-d',strtotime($date_from));
                
                $validation_rules[] = 
                    array(
                        'field' => 'time_forms[date_from]',
                        'label' => 'Date From',
                        'rules' => 'required'
                );
                $validation_rules[] = 
                    array(
                        'field' => 'time_forms[date_to]',
                        'label' => 'Date To',
                        'rules' => 'required'
                );

            break;
            default:
                $date_from = date('Y-m-d', strtotime($_POST['date_from'])); 
                $date_to = date('Y-m-d', strtotime($_POST['date_to']));
                $_POST['focus_date'] = date('Y-m-d',strtotime($date_from));

                $validation_rules[] = 
                    array(
                        'field' => 'time_forms[date_from]',
                        'label' => 'Date From',
                        'rules' => 'required'
                );
                $validation_rules[] = 
                    array(
                        'field' => 'time_forms[date_to]',
                        'label' => 'Date To',
                        'rules' => 'required'
                );
            break;
        }

        //check if forms is for cancellation
        if($this->input->post('form_status_id') == 8){
            if(trim($this->input->post('cancelled_comment')) == ""){
                $this->response->message[] = array(
                    'message' => "The Remarks field is required",
                    'type' => 'warning'
                );  
                $this->_ajax_return();            
            }
        }

        /** START Validate Date From - Date To **/
        $with_date_range = array(1, 2, 3, 4, 5, 6, 7, 8, 14, 16, 19, 20, 21, 22, 23); //Emergency leave, undertime

        if(in_array($form_id, $with_date_range) && $form_id <> 8){
            if(strtotime($_POST['date_from']) > strtotime($_POST['date_to'])){
                $this->response->message[] = array(
                    'message' => 'Invalid Date Range - Date From should not be greater than Date To ',
                    'type' => 'warning'
                );  
                $this->_ajax_return();
            }
        }else{
            switch($form_id){
                case get_time_form_id('OBT')://obt
                    if(strtotime($_POST['date_from']) > strtotime($_POST['date_to'])){
                        $this->response->message[] = array(
                            'message' => 'Invalid Date Range - Date From should not be greater than Date To ',
                            'type' => 'warning'
                        );  
                        $this->_ajax_return();
                    }

                    //OBT overlap
                    $existing_obt_forms =  $this->mod->validate_ot_forms(date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$_POST['date_from']))), date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$_POST['date_to']))), $this->user->user_id, $form_id, $forms_id);
                    if($existing_obt_forms > 0){
                      $this->response->message[] = array(
                        'message' => lang('form_application.obt_filed'),
                        'type' => 'warning'
                        );  
                        $this->_ajax_return();
                    }
                break;
                case get_time_form_id('OT')://overtime
                    if(strtotime($_POST['focus_date']) > strtotime($date_from. ' +1 day') || strtotime($_POST['focus_date']) < strtotime($date_from. ' -1 day')
                        || strtotime($_POST['focus_date']) > strtotime($date_to) || strtotime($_POST['focus_date']) < strtotime($date_to. ' -1 day')){
                        $this->response->message[] = array(
                            'message' => lang('form_application.invalid_date'),
                            'type' => 'warning'
                            );  
                         $this->_ajax_return();
                    }
                    //OT overlap
                    $existing_ot_forms =  $this->mod->validate_ot_forms(date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$date_from))), date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$date_to))), $this->user->user_id, $form_id, $forms_id);
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
                        if(strtotime($_POST['focus_date']) > strtotime($date_from. ' +1 day') || strtotime($_POST['focus_date']) < strtotime($date_from. ' -1 day')){
                            $this->response->message[] = array(
                                'message' => lang('form_application.invalid_date'),
                                'type' => 'warning'
                                );  
                        $this->_ajax_return();
                        }
                    }else{ 
                        if(strtotime($_POST['focus_date']) > strtotime($date_to) || strtotime($_POST['focus_date']) < strtotime($date_to. ' -1 day')){
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
                        if(strtotime($_POST['focus_date']) > strtotime($date_from. ' +1 day') || strtotime($_POST['focus_date']) < strtotime($date_from. ' -1 day')){
                            $this->response->message[] = array(
                                'message' => lang('form_application.invalid_date'),
                                'type' => 'warning'
                                );  
                        $this->_ajax_return();
                        }
                    }elseif($this->input->post('dtrp_type') == 2){ //OUT
                        if(strtotime($_POST['focus_date']) > strtotime($date_to) || strtotime($_POST['focus_date']) < strtotime($date_to. ' -1 day')){
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
                        if(strtotime($_POST['focus_date']) > strtotime($date_from. ' +1 day') || strtotime($_POST['focus_date']) < strtotime($date_from. ' -1 day')
                            || strtotime($_POST['focus_date']) > strtotime($date_to) || strtotime($_POST['focus_date']) < strtotime($date_to. ' -1 day')){
                            $this->response->message[] = array(
                                'message' => lang('form_application.invalid_date'),
                                'type' => 'warning'
                                );  
                        $this->_ajax_return();
                        }
                    }
                break;
            }            
        }

        //START Form Validation
        $validation_rules[] = 
            array(
                'field' => 'time_forms[reason]',
                'label' => 'Reason',
                'rules' => 'required'
        );

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

        if ($date_to == '' || $date_to == '1970-01-01'){
            $date_to = $date_from;
        }
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

        $time_forms_date_table = array();
        $breakout = false;
        $hrs = 0;
        $days = 0;
        $duration = $this->input->post('duration');
        $leave_duration = $this->input->post('leave_duration');
        $selected_date_count = 0;

        foreach($period as $dt) {
            $form_holiday = array();
            $form_holiday = $this->mod->check_if_holiday($dt->format('Y-m-d'), $this->user->user_id);

            if(count($form_holiday) > 0 ){
                $days--;
            }else{
                if(in_array($form_id, $with_date_range) && $form_id <> 8){
                    $duration_details = $this->mod->get_duration($duration[$selected_date_count]);
                    $leave_durations = $this->mod->get_leave_duration($leave_duration[$selected_date_count]);
                    if($this->input->post('form_status_id') != 8){
                        $time_forms_date_table[] = array(
                            'forms_id' => $forms_id,
                            'date' => $dt->format('Y-m-d'),
                            'day' => $leave_durations[0]['leave_duration'] * 0.125,//$duration[$selected_date_count] == 1 ? 1 : 0.5,
                            'duration_id' => $duration[$selected_date_count],
                            'credit' => $duration_details[0]['credit'],
                            'hrs' => $leave_durations[0]['leave_duration']
                            );
                    }else{
                        $time_forms_date_table[] = array(
                            'forms_id' => $forms_id,
                            'date' => $dt->format('Y-m-d'),
                            'day' => $leave_durations[0]['leave_duration'] * 0.125,//$duration[$selected_date_count] == 1 ? 1 : 0.5,
                            'duration_id' => $duration[$selected_date_count],
                            'credit' => $duration_details[0]['credit'],
                            'cancelled_comment' => $this->input->post('cancelled_comment'),
                            'hrs' => $leave_durations[0]['leave_duration']
                            );
                    }                    
                    $hrs = $leave_durations[0]['leave_duration']; 
                    $days += $leave_durations[0]['leave_duration'] * 0.125; 
                    $selected_date_count++;               
                }
                else{
                    switch($form_id){
                        case get_time_form_id('OBT'): //OBT
                        $hrs = ((strtotime( $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($date_time_to, -8)))) - strtotime($dt->format('Y-m-d')." ".date("H:i",strtotime(substr($date_time_from, -8)))))/60)/60; 
                        if($this->input->post('form_status_id') != 8){
                            if($this->input->post('bt_type') == 1){
                                $time_forms_date_table[] = array(
                                    'forms_id' => $forms_id,
                                    'date' => $dt->format('Y-m-d'),
                                    'day' => 1,
                                    'hrs' => $hrs,
                                    'time_from' => $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($date_time_from, -8))),
                                    'time_to' =>  $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($date_time_to, -8)))
                                    );
                            $main_record[$this->mod->table]['date_from'] = $dt->format('Y-m-d');
                            $main_record[$this->mod->table]['date_to'] = $dt->format('Y-m-d');
                                $breakout = true;
                            }else{
                                $time_forms_date_table[] = array(
                                    'forms_id' => $forms_id,
                                    'date' => $dt->format('Y-m-d'),
                                    'day' => 1,
                                    'hrs' => $hrs,
                                    'time_from' => $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($date_time_from, -8))),
                                    'time_to' => $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($date_time_to, -8)))
                                    );
                            }
                        }else{
                            if($this->input->post('bt_type') == 1){
                                $time_forms_date_table[] = array(
                                    'forms_id' => $forms_id,
                                    'date' => $dt->format('Y-m-d'),
                                    'day' => 1,
                                    'hrs' => $hrs,
                                    'time_from' => $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($date_time_from, -8))),
                                    'time_to' => $date_to." ".date("H:i",strtotime(substr($date_time_to, -8))),
                                    'cancelled_comment' => $this->input->post('cancelled_comment') 
                                    );
                            $main_record[$this->mod->table]['date_from'] = $dt->format('Y-m-d');
                            $main_record[$this->mod->table]['date_to'] = $dt->format('Y-m-d');
                                $breakout = true;
                            }else{
                                $time_forms_date_table[] = array(
                                    'forms_id' => $forms_id,
                                    'date' => $dt->format('Y-m-d'),
                                    'day' => 1,
                                    'hrs' => $hrs,
                                    'time_from' => $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($date_time_from, -8))),
                                    'time_to' => $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($date_time_to, -8))),
                                    'cancelled_comment' => $this->input->post('cancelled_comment') 
                                    );
                            }
                        }                        
                        break;                        
                        case get_time_form_id('OT'): //OT
                            $date_from = date('Y-m-d', strtotime(substr($this->input->post('date_from'), 0, -11))); 
                            $date_to = date('Y-m-d', strtotime(substr($this->input->post('date_to'), 0, -11)));
                            $date_time_from = date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$date_time_from)));
                            $date_time_to = date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$date_time_to))); 

                            $time_from = $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($date_time_from, -8)));    
                            $time_to = $date_to." ".date("H:i",strtotime(substr($date_time_to, -8)));  
                            $hrs = ((strtotime($time_to) - strtotime($time_from))/60)/60;  

                            if($this->input->post('form_status_id') != 8){
                                $time_forms_date_table[] = array(
                                    'forms_id' => $forms_id,
                                    'date' => $_POST['focus_date'],
                                    'day' => 1,
                                    'hrs' => $hrs,
                                    'time_from' => $time_from,
                                    'time_to' => $time_to
                                    );
                            }else{
                               $time_forms_date_table[] = array(
                                'forms_id' => $forms_id,
                                'date' => $_POST['focus_date'],
                                'day' => 1,
                                'hrs' => $hrs,
                                'time_from' => $time_from,
                                'time_to' => $time_to,
                                'cancelled_comment' => $this->input->post('cancelled_comment') 
                                );
                            }
                                
                            $main_record[$this->mod->table]['date_from'] = $_POST['focus_date'];
                            $main_record[$this->mod->table]['date_to'] = $_POST['focus_date'];
                            $breakout = true;
                        break;                        
                        case 10: //UT
                            $date_time = $dt->format('Y-m-d')." ".date("H:i",strtotime($this->input->post('ut_time_in_out')));  
                            if($this->input->post('form_status_id') != 8){
                                $time_forms_date_table[] = array(
                                    'forms_id' => $forms_id,
                                    'date' => $_POST['focus_date'],
                                    'day' => 1,
                                    'time_to' => $date_time
                                    );
                            }else{
                               $time_forms_date_table[] = array(
                                'forms_id' => $forms_id,
                                'date' => $_POST['focus_date'],
                                'day' => 1,
                                'time_to' => $date_time,
                                'cancelled_comment' => $this->input->post('cancelled_comment') 
                                );
                            }
                                
                            $main_record[$this->mod->table]['date_from'] = $_POST['focus_date'];
                            $main_record[$this->mod->table]['date_to'] = $_POST['focus_date'];
                            $breakout = true;
                        break;
                        case 11: //DTRP
                            $time_from = $dt->format('Y-m-d')." ".date("H:i",strtotime(substr($date_time_from, -8)));    
                            $time_to = $date_to." ".date("H:i",strtotime(substr($date_time_to, -8)));  
                            // $hrs = ((strtotime($time_to) - strtotime($time_from))/60)/60;   
                            if($this->input->post('form_status_id') != 8){
                                if($this->input->post('dtrp_type') == 1){ 
                                    $time_forms_date_table[] = array(
                                        'forms_id' => $forms_id,
                                        'date' => $_POST['focus_date'],
                                        'day' => 1,
                                        'time_from' => $time_from
                                        );
                                }elseif($this->input->post('dtrp_type') == 2){ 
                                    $time_forms_date_table[] = array(
                                        'forms_id' => $forms_id,
                                        'date' => $_POST['focus_date'],
                                        'day' => 1,
                                        'time_to' => $time_to
                                        );
                                }else{    
                                    $time_forms_date_table[] = array(
                                        'forms_id' => $forms_id,
                                        'date' => $_POST['focus_date'],
                                        'day' => 1,
                                        'time_from' => $time_from,
                                        'time_to' => $time_to
                                        );
                                }
                            }else{
                                if($this->input->post('dtrp_type') == 1){ 
                                    $time_forms_date_table[] = array(
                                        'forms_id' => $forms_id,
                                        'date' => $_POST['focus_date'],
                                        'day' => 1,
                                        'time_from' => $time_from,
                                        'cancelled_comment' => $this->input->post('cancelled_comment') 
                                        );
                                }elseif($this->input->post('dtrp_type') == 2){ 
                                    $time_forms_date_table[] = array(
                                        'forms_id' => $forms_id,
                                        'date' => $_POST['focus_date'],
                                        'day' => 1,
                                        'time_to' => $time_to,
                                        'cancelled_comment' => $this->input->post('cancelled_comment') 
                                        );
                                }else{    
                                    $time_forms_date_table[] = array(
                                        'forms_id' => $forms_id,
                                        'date' => $_POST['focus_date'],
                                        'day' => 1,
                                        'time_from' => $time_from,
                                        'time_to' => $time_to,
                                        'cancelled_comment' => $this->input->post('cancelled_comment') 
                                        );
                                }
                            }
                            $main_record[$this->mod->table]['date_from'] = $_POST['focus_date'];
                            $main_record[$this->mod->table]['date_to'] = $_POST['focus_date'];
                            $breakout = true;
                        break;
                        case 12: // CWS 
                            if($this->input->post('form_status_id') != 8){
                                $time_forms_date_table[] = array(
                                    'shift_id' => $this->input->post('shift_id'),
                                    'shift_to' => $this->input->post('shift_to'),
                                    'forms_id' => $forms_id,
                                    'date' => $dt->format('Y-m-d'),
                                    'day' => 1
                                    );
                            }else{
                                $time_forms_date_table[] = array(
                                    'shift_id' => $this->input->post('shift_id'),
                                    'shift_to' => $this->input->post('shift_to'),                                  
                                    'forms_id' => $forms_id,
                                    'date' => $dt->format('Y-m-d'),
                                    'day' => 1,
                                    'cancelled_comment' => $this->input->post('cancelled_comment') 
                                    );
                            }
                            $breakout = true;
                        break;                        
                        case 15: //ET
                            $date_time = $dt->format('Y-m-d')." ".date("H:i",strtotime($this->input->post('ut_time_in_out')));  
                            if($this->input->post('form_status_id') != 8){
                                $time_forms_date_table[] = array(
                                    'forms_id' => $forms_id,
                                    'date' => $_POST['focus_date'],
                                    'day' => 1,
                                    'time_from' => $date_time
                                    );
                            }else{
                               $time_forms_date_table[] = array(
                                'forms_id' => $forms_id,
                                'date' => $_POST['focus_date'],
                                'day' => 1,
                                'time_from' => $date_time,
                                'cancelled_comment' => $this->input->post('cancelled_comment') 
                                );
                            }
                                
                            $main_record[$this->mod->table]['date_from'] = $_POST['focus_date'];
                            $main_record[$this->mod->table]['date_to'] = $_POST['focus_date'];
                            $breakout = true;
                        break;
                    }
                    
                    if($breakout === true) break;
                }
            }
        }

        if($form_id == get_time_form_id('MS')) {
            if($this->input->post('users_location')) {
                foreach($this->input->post('users_location') as $key => $val ) {
                    foreach($val as $id) {
                         $location_id = $val;
                    }
                } 
            }
            if($this->input->post('users_project')) {
                foreach($this->input->post('users_project') as $key => $val ) {
                    foreach($val as $id) {
                        $project_id = $val;
                    }
                } 
            }
            if($this->input->post('users_department')) {
                foreach($this->input->post('users_department') as $key => $val ) {
                    foreach($val as $id) {
                        $department_id = $val;
                    }
                } 
            }
            if($this->input->post('users_assignment')) {
                foreach($this->input->post('users_assignment') as $key => $val ) {
                    foreach($val as $id) {
                        $users_assignment = $val;
                    }
                } 
            }
            if($this->input->post('partners')) {
                foreach($this->input->post('partners') as $key => $val ) {
                    foreach($val as $id) {
                        $partner_id = $val;
                    }
                } 
            }
            // debug($users_assignment); die;
            $this->db->select('users_profile.user_id');
            if($this->input->post('users_location')) {
                $this->db->where_in('users_profile.location_id', $location_id);
            }
            if($this->input->post('users_project')) {
                $this->db->where_in('users_profile.project_id', $project_id);
            }
            if($this->input->post('users_department')) {
                $this->db->where_in('users_profile.department_id', $department_id);
            }
            if($this->input->post('partners')) {
                $this->db->where_in('users_profile.user_id', $partner_id);
            }
            if($this->input->post('users_assignment')) {
                $this->db->where_in('users_assignment.assignment_id', $users_assignment);
                $this->db->where("partners_personal.key = 'agency_assignment'");
            }

            $this->db->from('users_profile');
            if($this->input->post('users_assignment')) {
                $this->db->join('partners', 'partners.user_id = users_profile.user_id');
                $this->db->join('partners_personal', 'partners_personal.partner_id = partners.user_id');
                $this->db->join('users_assignment', 'users_assignment.assignment = partners_personal.key_value');
            }
            $result = $this->db->get();

            $user = array();
            if($result->num_rows() > 0) {
                $user = $result->result_array();
            }

            foreach($user as $val => $key) {
                $user_id = $key['user_id'];
                $form_date = date('Y-m-d', strtotime($_POST['form_date']));
                $shift_id = $this->input->post('work_schedule');

                $data = array();
                $qry = "CALL sp_time_forms_blanket('".$user_id."', '".$form_date."', $shift_id)";
                $result = $this->db->query( $qry );
    
                mysqli_next_result($this->db->conn_id);
            }
        }

        if($form_id == get_time_form_id('RL')) {
            $forms_info = $this->mod->get_time_forms_details($form_id);
            $ms_day = 0;
            $d_from = '';
            $d_to = '';
            foreach($forms_info as $val => $key) {
                $ms_day += $key['day'];
                $d_from = date('Y-m-d', strtotime($key['date_from']));
                $d_to = date('Y-m-d', strtotime($key['date_to']));
            }

            if(($date_from >= $d_from && $date_from <= $d_to) || ($date_to >= $d_from && $date_to <= $d_to)) {
                $this->response->message[] = array(
                    'message' => "Duplicate Reserved Leave date.",
                    'type' => 'warning'
                );  
                $this->_ajax_return();  
            }

            $count_days = $days + $ms_day;

            if($ms_day > 3 || $count_days > 3) {
                $this->response->message[] = array(
                    'message' => "You cannot file more than three days Reserved Leave.",
                    'type' => 'warning'
                );  
                $this->_ajax_return();  
            }

            if($this->input->post('users_location')) {
                foreach($this->input->post('users_location') as $key => $val ) {
                    foreach($val as $id) {
                         $location_id = $val;
                    }
                } 
            }
            if($this->input->post('users_project')) {
                foreach($this->input->post('users_project') as $key => $val ) {
                    foreach($val as $id) {
                        $project_id = $val;
                    }
                } 
            }
            if($this->input->post('users_department')) {
                foreach($this->input->post('users_department') as $key => $val ) {
                    foreach($val as $id) {
                        $department_id = $val;
                    }
                } 
            }
            if($this->input->post('partners')) {
                foreach($this->input->post('partners') as $key => $val ) {
                    foreach($val as $id) {
                        $partner_id = $val;
                    }
                } 
            }

            $this->db->select('users_profile.user_id');
            $this->db->where('users.active', 1);
            $this->db->where('users.deleted', 0);
            $this->db->where('time_form_balance.form_id', 2);
            if($this->input->post('users_location')) {
                $this->db->where_in('users_profile.location_id', $location_id);
            }
            if($this->input->post('users_project')) {
                $this->db->where_in('users_profile.project_id', $project_id);
            }
            if($this->input->post('users_department')) {
                $this->db->where_in('users_profile.department_id', $department_id);
            }
            if($this->input->post('partners')) {
                $this->db->where_in('users_profile.user_id', $partner_id);
            }
            $this->db->from('users_profile');
            $this->db->join('users', 'users.user_id = users_profile.user_id', 'inner');
            $this->db->join('time_form_balance', 'time_form_balance.user_id = users_profile.user_id', 'inner');

            $result = $this->db->get();
            // $this->db->last_query($result); die;
            $user = array();
            if($result->num_rows() > 0) {
                $user = $result->result_array();
            }

            foreach($user as $val => $key) {
                $user_id = $key['user_id'];

                $data = array();
                $qry = "CALL sp_time_forms_reserved_leave('".$date_from."','".$user_id."', '".$days."')";
                $result = $this->db->query( $qry );
    
                mysqli_next_result($this->db->conn_id);
            }  

        }

        if($days <= 0){
            if($this->input->post('form_code') != 'OT'){
                $this->response->message[] = array(
                    'message' => 'You are not allowed to file the selected form on holiday',
                    'type' => 'warning'
                    );  
                $this->_ajax_return();
            }
        }

        //validation of leave
        $form_type = $this->mod->get_form_type($form_id);

        if($form_type['is_leave'] == 1 && ($form_type['with_credits'] == 1) &&  $this->input->post('form_status_id') != 8){

            if($this->input->post('partners')) {
                foreach($this->input->post('partners') as $key => $val ) {

                    if(count($val) > 1){
                        $this->response->message[] = array(
                            'message' => 'You are not allowed to select multiple partners',
                            'type' => 'error'
                            );  
                        $this->_ajax_return();
                    }

                    foreach($val as $key1 => $id) {
                        $partner_id = $id;
                    }
                } 
            }     

            $balance_data = $this->mod->get_leave_balance($partner_id, date('Y-m-d', strtotime($date_from)), $form_id);

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
        //validtion of leave

        //validation of fields on module manager
        $focus_date_final = '0000-00-00';
        if ($this->input->post('focus_date') && $this->input->post('focus_date') != ''){
            $focus_date_final = date('Y-m-d', strtotime($this->input->post('focus_date')));
        }

        $main_record = array();
        $main_record[$this->mod->table]['form_status_id'] = $this->input->post('form_status_id');
        $main_record[$this->mod->table]['form_id'] = $this->input->post('form_type');
        $main_record[$this->mod->table]['form_code'] = $this->input->post('form_code');
        $main_record[$this->mod->table]['focus_date'] = $focus_date_final;
        $main_record[$this->mod->table]['user_id'] = 0;
        $main_record[$this->mod->table]['day'] = $days;
        $main_record[$this->mod->table]['hrs'] = $hrs;
        $main_record[$this->mod->table]['date_from'] = $date_from;
        $main_record[$this->mod->table]['date_to'] = $date_to;
        $main_record[$this->mod->table]['reason'] = $_POST['reason'];
        $main_record[$this->mod->table]['display_name'] = 'Blanket';

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
                $main_record[$this->mod->table]['created_by'] = $this->user->user_id;

                // if( in_array($main_record[$this->mod->table]['form_status_id'],array(2,4)) ){
                    $main_record[$this->mod->table]['date_sent'] = date('Y-m-d H:i:s');
                // }

                $this->db->insert($this->mod->table, $main_record[$this->mod->table]);
                if( $this->db->_error_message() == "" )
                {
                    $forms_id = $this->record_id = $this->db->insert_id();
                }
                break;
            case $record->num_rows() == 1:
                // $main_record['modified_by'] = $this->user->user_id;
                $main_record[$this->mod->table]['modified_on'] = date('Y-m-d H:i:s');
                $main_record[$this->mod->table]['modified_by'] = $this->user->user_id;

                // if( in_array($main_record[$this->mod->table]['form_status_id'],array(2,4)) ){
                    $main_record[$this->mod->table]['date_sent'] = date('Y-m-d H:i:s');
                // }

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

        $blanket_values = '';
        if($this->input->post('partners')) {
            $selected_partners = $this->input->post('partners');
            foreach($selected_partners['partner_id'] as $index => $user_id){

                if($this->input->post('form_type') == get_time_form_id('PUL')){
                    $ALqry = " SELECT * FROM {$this->db->dbprefix}time_form_balance 
                            WHERE year = '".date('Y')."' AND user_id= {$user_id}
                            AND form_id= ".get_time_form_id('VL')."";
                    $ALresults = $this->db->query($ALqry);
                    if($ALresults->num_rows() > 0){
                        $ALresult = $ALresults->row_array();
                        $daysleave = $ALresult['balance'] - $days;
                        if($daysleave < 0){
                            $PULqry = " SELECT * FROM {$this->db->dbprefix}time_form_balance 
                                    WHERE year = '".date('Y')."' AND user_id= {$user_id}
                                    AND form_id= ".get_time_form_id('PUL')."";
                            $PULresult = $this->db->query($PULqry);
                            if($PULresult->num_rows() > 0){
                                $balance_record = array(
                                    'used_insert' => abs($daysleave),
                                    'modified_on' => date('Y-m-d H:i:s')
                                );
                                $where_bal = array( 
                                    'year' => date('Y'),
                                    'form_id' => get_time_form_id('PUL'),
                                    'user_id' => $user_id
                                    );
                                $this->db->update( 'time_form_balance', $balance_record, $where_bal );

                                $rdaysleave = $days + ($daysleave);
                                $balance_record = array(
                                    'used_insert' => abs($rdaysleave),
                                    'modified_on' => date('Y-m-d H:i:s')
                                );
                                $where_bal = array( 
                                    'year' => date('Y'),
                                    'form_id' => get_time_form_id('VL'),
                                    'user_id' => $user_id
                                    );
                                $this->db->update( 'time_form_balance', $balance_record, $where_bal );
                            }else{
                                $balance_record = array(
                                    'used_insert' => $days,
                                    'modified_on' => date('Y-m-d H:i:s')
                                );
                                $where_bal = array( 
                                    'year' => date('Y'),
                                    'form_id' => get_time_form_id('VL'),
                                    'user_id' => $user_id
                                    );
                                $this->db->update( 'time_form_balance', $balance_record, $where_bal );
                            }
                        }else{
                            $balance_record = array(
                                'used_insert' => $days,
                                'modified_on' => date('Y-m-d H:i:s')
                            );
                            $where_bal = array( 
                                'year' => date('Y'),
                                'form_id' => get_time_form_id('VL'),
                                'user_id' => $user_id
                                );
                            $this->db->update( 'time_form_balance', $balance_record, $where_bal );
                        }
                    }else{
                        $balance_record = array(
                            'used_insert' => abs($days),
                            'modified_on' => date('Y-m-d H:i:s')
                        );
                        $where_bal = array( 
                            'year' => date('Y'),
                            'form_id' => get_time_form_id('PUL'),
                            'user_id' => $user_id
                            );
                        $this->db->update( 'time_form_balance', $balance_record, $where_bal );
                    }
                }
                // $blanket_values .= "($forms_id, $user_id), ";s
                $this->db->insert('time_forms_blanket', array('forms_id' => $forms_id, 'user_id' => $user_id));
                if( $this->db->_error_message() != "" ){
                    $this->response->message[] = array(
                        'message' => $this->db->_error_message(),
                        'type' => 'error'
                    );
                    $error = true;
                    goto stop;
                }
            }
        }else{
            $selected_partners = $this->mod->get_partners();
            
            foreach($selected_partners as $index => $partners){
                $user_id = $partners['user_id'];
                if($this->input->post('form_type') == get_time_form_id('PUL')){
                    $ALqry = " SELECT * FROM {$this->db->dbprefix}time_form_balance 
                            WHERE year = '".date('Y')."' AND user_id= ".$user_id."
                            AND form_id= ".get_time_form_id('VL')."";
                    $ALresults = $this->db->query($ALqry);
                    if($ALresults->num_rows() > 0){
                        $ALresult = $ALresults->row_array();
                        $daysleave = $ALresult['balance'] - $days;
                        if($daysleave < 0){
                            $PULqry = " SELECT * FROM {$this->db->dbprefix}time_form_balance 
                                    WHERE year = '".date('Y')."' AND user_id= ".$user_id."
                                    AND form_id= ".get_time_form_id('PUL')."";
                            $PULresult = $this->db->query($PULqry);
                            if($PULresult->num_rows() > 0){

                                $balance_record = array(
                                    'used_insert' => abs($daysleave),
                                    'modified_on' => date('Y-m-d H:i:s')
                                );
                                $where_bal = array( 
                                    'year' => date('Y'),
                                    'form_id' => get_time_form_id('PUL'),
                                    'user_id' => $user_id
                                    );
                                $this->db->update( 'time_form_balance', $balance_record, $where_bal );

                                $rdaysleave = $days + ($daysleave);
                                $balance_record = array(
                                    'used_insert' => abs($rdaysleave),
                                    'modified_on' => date('Y-m-d H:i:s')
                                );
                                $where_bal = array( 
                                    'year' => date('Y'),
                                    'form_id' => get_time_form_id('VL'),
                                    'user_id' => $user_id
                                    );
                                $this->db->update( 'time_form_balance', $balance_record, $where_bal );
                                debug($this->db->last_query()); die;
                            }else{
                                $balance_record = array(
                                    'used_insert' => $days,
                                    'modified_on' => date('Y-m-d H:i:s')
                                );
                                $where_bal = array( 
                                    'year' => date('Y'),
                                    'form_id' => get_time_form_id('VL'),
                                    'user_id' => $user_id
                                    );
                                $this->db->update( 'time_form_balance', $balance_record, $where_bal );
                            }
                        }else{
                            $balance_record = array(
                                'used_insert' => $days,
                                'modified_on' => date('Y-m-d H:i:s')
                            );
                            $where_bal = array( 
                                'year' => date('Y'),
                                'form_id' => get_time_form_id('VL'),
                                'user_id' => $user_id
                                );
                            $this->db->update( 'time_form_balance', $balance_record, $where_bal );
                        }
                    }else{
                        $balance_record = array(
                            'used_insert' => abs($days),
                            'modified_on' => date('Y-m-d H:i:s')
                        );
                        $where_bal = array( 
                            'year' => date('Y'),
                            'form_id' => get_time_form_id('PUL'),
                            'user_id' => $user_id
                            );
                        $this->db->update( 'time_form_balance', $balance_record, $where_bal );
                    }
                }

                $this->db->insert('time_forms_blanket', array('forms_id' => $forms_id, 'user_id' => $user_id));            
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
        // $blanket_values = substr($blanket_values, 0, -2);

        // $insert_blanket_qry = "INSERT INTO {$this->db->dbprefix}time_forms_blanket (forms_id, user_id)
        //                         VALUES ($blanket_values)";
        //                         echo $insert_blanket_qry;
        // if(!$this->db->query($insert_blanket_qry)){
        //     $this->response->message[] = array(
        //         'message' => $this->db->_error_message(),
        //         'type' => 'error'
        //     );
        //     $error = true;
        //     goto stop;
        // }

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

        if( !$error )
        {

            $this->response->forms_id = $forms_id;
            $this->response->saved = true; 
            $this->response->message[] = array(
                'message' => $this->input->post('forms_title').' ' . lang('form_application_admin.success_save'),
                'type' => 'success'
            );
        }

        $this->_ajax_return();

    }

    function selected_dates($forms_id=0, $date_from='', $date_to=''){

        $selected_dates = $this->mod->get_selected_dates($forms_id);
        $data['duration'] = $this->mod->get_duration();
        $days = 0;

        $forms_info = $this->mod->get_forms_details($forms_id);
        if($date_from==''){
            $date_from = ( $forms_info['date_from'] == "" )? "" : date('Y-m-d', strtotime($forms_info['date_from'])); 
        }else{
            $date_from = date('Y-m-d', strtotime($date_from)); 
        }
        if($date_to==''){
            $date_to = ( $forms_info['date_to'] == "" )? "" : date('Y-m-d', strtotime($forms_info['date_to']));
        }else{
            $date_to = date('Y-m-d', strtotime($date_to)); 
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
    
    public function edit_form( $record_id )
    {

        parent::detail($record_id,true);

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
        $data['form_title'] = $form_info['form'].' Form';
        $data['upload_id']["val"] = array();
        $data['ut_time_in_out'] = "";
        $data['duration'] = $this->mod->get_duration();
        $this->load->model('form_application_model', 'formapp');
        $data['leave_balance'] = $this->formapp->get_leave_balance($forms_info['user_id'], date('Y-m-d'), 0);
        $data['form_approver_details'] = $this->mod->get_form_approver_info($this->record_id,$this->user->user_id);
        $data['form_approver_details']['approver_id'] = $this->user->user_id; //set user as the approver for administrator
        $data['bt_type'] = '';
        $data['scheduled'] = $forms_info['scheduled'];

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
            $data['ut_time_in_out'] = ($data['ut_type']  == 0) ? date("h:i A", strtotime($ut_date_time[0]['time_to'])) : date("h:i A", strtotime($ut_date_time[0]['time_from']));
            }
            $data['dtrp_type'] = $record_id ? $this->mod->check_dtrp_type($record_id) : 1;

        }
        else{
            if($form_info['form_id']  == 10){
                $data['ut_time_in_out'] = ($data['shift_details']['logs_time_out'] == "-") ? date("h:i A", strtotime($data['shift_details']['shift_time_end'])) : date("h:i A", strtotime($data['shift_details']['logs_time_out']));
            }elseif($form_info['form_id'] == 15){
                $data['ut_time_in_out'] = ($data['shift_details']['logs_time_in'] == "-") ? date("h:i A", strtotime($data['shift_details']['shift_time_start'])) : date("h:i A", strtotime($data['shift_details']['logs_time_in']));
            }
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
                        if($data['form_id'] == 10 || $data['form_id'] == 15){ //undertime form/ excused tardiness
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
            case get_time_form_id('OBT'):
                $data['bt_type'] = 1;
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['date_from'])), $forms_info['user_id']);
            break;
            case get_time_form_id('OT'):
            case get_time_form_id('ADDL'): //addl
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['focus_date'])), $forms_info['user_id']);
            break;
            case get_time_form_id('UT'):
                $data['ut_type'] = $data['form_id'] == 10 ? 0 :1;
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['focus_date'])), $forms_info['user_id']);
            break;
            case get_time_form_id('ET'):
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['date_from'])), $forms_info['user_id']);
            break;
            case get_time_form_id('BL'):
                $data['bday_duration'] = 1;
            break;
            case get_time_form_id('DTRP'):
                $data['dtrp_type'] = 1;
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['focus_date'])), $forms_info['user_id']);
            break;
            case get_time_form_id('CWS'):
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['date_from'])), $forms_info['user_id']);
               $data['shift_id']['val'] = $data['shift_details']['shift_id'];
            break;
        }

        $data['remarks'] = $this->mod->get_approver_remarks($data['forms_id']);
        $data['approver_details'] = $this->mod->get_approver_details($data['forms_id'], $this->user->user_id);

        $this->load->model('form_application_manage_model', 'manage_app');
        $data['approver_list'] = $this->manage_app->get_form_approvers($data['forms_id']);
        $data['selected_dates'] = $this->selected_dates($data['forms_id']);

        $this->load->vars($data);

        $this->load->helper('form');
        $this->load->helper('file');
        echo $this->load->blade('edit.forms.edit_'.strtolower($form_info['form_code']).'_form')->with( $this->load->get_cached_vars() );

    }

    public function compute_maternity_days()
    {
        $this->_ajax_only();

        if($this->input->post('delivery_id') == 0){
            $this->response->date_from = date('F d, Y');
            $date = date('Y-m-d');
            $this->response->date_to = date('F d, Y', strtotime($date. " + 60 days"));
            $this->response->days = 60;
        }else{
            $this->db->select('leave_days');
            $this->db->where('deleted', '0');
            $this->db->where('delivery_id', $this->input->post('delivery_id'));
            $maternity_details = $this->db->get('time_delivery')->row_array();

            $date = date('Y-m-d', strtotime($this->input->post('date_from')));
            $this->response->date_from = $this->input->post('date_from');
            $this->response->date_to = date('F d, Y', strtotime($date. " + {$maternity_details['leave_days']} days"));
            $this->response->date_to_display = $this->response->date_to.' - '.date('D',strtotime($this->response->date_to));
            $this->response->days = $maternity_details['leave_days'];
        }

        $forms_id = $this->input->post('record_id');
        $data['selected_dates'] = $this->selected_dates($forms_id, $this->response->date_from, $this->response->date_to);
        $this->response->days_leaved = $this->load->view('edit/forms/ml_selected_dates', $data, true);
        
        // $this->mod->check_if_rest_day($forms_info['user_id'], $dt->format('Y-m-d'));

        $this->_ajax_return();
    }

    function update_details(){
        // echo "<pre>"; print_r($_POST);exit();
        $error = false;
        $post = $_POST;
        $this->response->record_id = $this->record_id = $post['record_id'];
        $form_view = $post['view'];
        unset( $post['record_id'] );
        unset( $post['view'] );

        $validation_rules = array();

        if( sizeof( $validation_rules ) > 0 )
        {
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
        }
        /***** END Form Validation (hard coded) *****/
        //SAVING START   
        $transactions = true;
        $this->partner_id = 0;
        if( $transactions )
        {
            $this->db->trans_begin();
        }

        //start saving with main table
        if(array_key_exists($this->mod->table, $post)){
            $main_record = $post[$this->mod->table];   
            foreach ($main_record as $column => $value){
                switch ($column){
                    case 'date_from':
                    case 'date_to':
                        $main_record[$column] = date('Y-m-d', strtotime($value));
                    break;
                }
            }
            $record = $this->db->get_where( $this->mod->table, array( $this->mod->primary_key => $this->record_id ) );
            $record_detail = $record->row_array();
            //insert time form dates
            $tables_dates = "time_forms_date";
            $start = new DateTime($main_record['date_from']);
            $end = new DateTime($main_record['date_to']);               
            $end->modify('+1 day');

            $interval = $end->diff($start);
            $days = $interval->days;
            $period = new DatePeriod($start, new DateInterval('P1D'), $end);
            $period = iterator_to_array($period);

            $selected_date_count = 0;
                 
            $rest_days= array();
            // foreach($period as $dt) {
            //     $forms_rest_day = $this->mod->check_if_rest_day($record_detail['user_id'], $dt->format('Y-m-d'));
            //     foreach($forms_rest_day as $forms_rest){
            //         $rest_days[] = $forms_rest['rest_day'];
            //     }
            // }

            foreach($period as $dt) {
                $form_holiday = array();
                $form_holiday = $this->mod->check_if_holiday($dt->format('Y-m-d'), $record_detail['user_id']);
                $forms_rest_day_count = $this->mod->check_rest_day($record_detail['user_id'], $dt->format('Y-m-d'));

                if(count($form_holiday) > 0 || $forms_rest_day_count > 0){   
                    if($record_detail['form_id'] != 8){
                        $days--;
                    }    
                }else{
                    switch($record_detail['form_id']){
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
                        case get_time_form_id('EML'): //Employee’s Marriage
                        case get_time_form_id('MEC'): //Marriage of Child
                        case get_time_form_id('ECC'): //Childs Circumcision
                        case get_time_form_id('ECB'): //Childs Baptism
                        case get_time_form_id('RBL'): //Relatives Bereavement Leave
                        case get_time_form_id('PiL'): //Pilgrimage Leave
                        case get_time_form_id('MeL'): //Menstruation Leave
                        case get_time_form_id('FBL'):
                        case get_time_form_id('PUL'):
                        case get_time_form_id('EXL'): 
                        //insert if not exist date record
                        $date_record = $this->db->get_where( $tables_dates, array( $this->mod->primary_key => $this->record_id, 'date' => $dt->format('Y-m-d') ) );
                        
                        if ($date_record->num_rows() == 0){
                            $time_forms_date_table = array(
                                'forms_id' => $this->record_id,
                                'date' => $dt->format('Y-m-d'),
                                'day' => 1,
                                'duration_id' => 1,
                                'credit' => 8
                                );
                            $this->db->insert($tables_dates, $time_forms_date_table);
                        }
                        break;
                    }
                    $selected_date_count++;
                }
            }
            
            $main_record['day'] = $days;
            //insert/update main record
            switch( true )
            {               
                case $record->num_rows() == 0:
                    $this->db->insert($this->mod->table, $main_record);
                    if( $this->db->_error_message() == "" )
                    {
                        $this->response->record_id = $this->record_id = $this->db->insert_id();
                    }
                    $this->response->action = 'insert';
                    break;
                case $record->num_rows() == 1:
                    $main_record['modified_by'] = $this->user->user_id;
                    $main_record['modified_on'] = date('Y-m-d H:i:s');
                    $this->db->update( $this->mod->table, $main_record, array( $this->mod->primary_key => $this->record_id ) );
                    $this->response->action = 'update';
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
        }

        $other_tables = $post;
        unset( $other_tables[$this->mod->table] );

        foreach( $other_tables as $table => $data )
        {            
            foreach ($data as $column => $value){
                switch ($column){
                    case 'expected_date':
                    case 'actual_date':
                    case 'return_date':
                        $data[$column] = date('Y-m-d', strtotime($value));
                    break;
                }
            }
            $record = $this->db->get_where( $table, array( $this->mod->primary_key => $this->record_id ) );
            switch( true )
            {
                case $record->num_rows() == 0:
                    $data[$this->mod->primary_key] = $this->record_id;
                    $this->db->insert($table, $data);
                    $this->record_id = $this->db->insert_id();
                    break;
                case $record->num_rows() == 1:
                    $this->db->update( $table, $data, array( $this->mod->primary_key => $this->record_id ) );
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

        if( !$error  )
        {
            $this->response->message[] = array(
                'message' => lang('common.save_success'),
                'type' => 'success'
            );
        }

        $this->response->saved = !$error;

        $this->_ajax_return();
    }

    function leave_convert()
    {       
        $record_id = $this->input->post('record_id');

        $this->db->where('deleted', '0');
        $this->db->where( $this->mod->primary_key, $record_id );
        $form_details = $this->db->get('time_forms')->row_array();

        $transpo_record['remarks'] = $this->input->post('validate_remarks');
        $transpo_record['status_id'] = $form_details['form_status_id'];

        $this->load->model('time_form_processes_model', 'time_process');
        $this->time_process->leave_conversion_processes($form_details, $transpo_record); 

        $this->response->saved = true;
    }
}