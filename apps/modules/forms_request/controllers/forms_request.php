<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Forms_request extends MY_PrivateController
{
    public function __construct()
    {
        $this->load->model('forms_request_model', 'mod');
        $this->load->library('time_form_policies');

        $this->lang->load( 'form_application_admin' );
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
        $this->load->model('form_application_admin_model', 'app_admin');
        $user_setting = APPPATH . 'config/users/'. $this->user->user_id .'.php';
        $user_id = $this->user->user_id;
        $this->load->config( "users/{$user_id}.php", false, true );
        $user = $this->config->item('user');

        $this->load->config( 'roles/'. $user['role_id'] .'/permission.php', false, true );
        $permission = $this->config->item('permission');
        $data['permission_app_manage'] = isset($permission[$this->app_manage->mod_code]['list']) ? $permission[$this->app_manage->mod_code]['list'] : 0;
        $data['permission_app_admin'] = isset($permission[$this->app_admin->mod_code]['list']) ? $permission[$this->app_admin->mod_code]['list'] : 0;
        $data['permission_app_request'] = isset($this->permission['list']) ? $this->permission['list'] : 0;
        $data['permission_app_personal'] = isset($permission[$this->app_personal->mod_code]['list']) ? $permission[$this->app_personal->mod_code]['list'] : 0;

        $this->load->model('leave_convert_model', 'leave_convert');
        $data['leave_convert'] = isset($permission[$this->leave_convert->mod_code]['list']) ? $permission[$this->leave_convert->mod_code]['list'] : 0;
        $this->load->model('hr_validation_model', 'hr_valid');
        $data['permission_validation'] = isset($permission[$this->hr_valid->mod_code]['list']) ? $permission[$this->hr_valid->mod_code]['list'] : 0;
        
        $leave_qry = "SELECT * FROM {$this->db->dbprefix}time_form WHERE is_leave = 1 AND deleted = 0";
        $data['leaves_data'] = $this->db->query($leave_qry)->result_array();
        $leave_qry = "SELECT * FROM {$this->db->dbprefix}time_form WHERE is_leave = 0 AND deleted = 0";
        $data['others_data'] = $this->db->query($leave_qry)->result_array();
        
        // Pay period filter
        // limited to 5 paydates
        $data['pay_dates'] = $this->app_personal->get_period_list();
        
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
            $data['dtrp_type'] = 1;
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
            case 8:
                $data['bt_type'] = 1;
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['date_from'])), $forms_info['user_id']);
                $data['obt_transpo'] = array();
                if($data['forms_id']){
                    $qry = "SELECT * FROM {$this->db->dbprefix}time_forms_obt_transpo 
                            WHERE {$this->mod->primary_key} = {$data['forms_id']}";
                    $obt_transpo = $this->db->query($qry);
                    if($obt_transpo->num_rows() > 0){
                        $data['obt_transpo'] = $obt_transpo->result_array();
                    }
                    $qry = "SELECT transpo.*, fstatus.form_status 
                            FROM {$this->db->dbprefix}time_forms_obt_transpo transpo
                            INNER JOIN {$this->db->dbprefix}time_form_status fstatus
                            ON fstatus.form_status_id = transpo.status_id
                            WHERE transpo.{$this->mod->primary_key} = {$data['forms_id']} 
                            LIMIT 1";
                    $obt_transpo = $this->db->query($qry);
                    if($obt_transpo->num_rows() > 0){
                        $data['req_remarks'] = $obt_transpo->row_array();
                    }
                }
            break;
            case 9:
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['date_from'])), $forms_info['user_id']);
            break;
            case 10:
                $data['ut_type'] = $data['form_id'] == 10 ? 0 :1;
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['date_from'])), $forms_info['user_id']);
            break;
            case 15:
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['date_from'])), $forms_info['user_id']);
            break;
            case 13:
                $data['bday_duration'] = 1;
            break;
            case 11:
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['date_from'])), $forms_info['user_id']);
            break;
            case 12:
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['date_from'])), $forms_info['user_id']);
               $data['shift_id']['val'] = $data['shift_details']['shift_id'];
            break;
        }

        $data['remarks'] = $this->mod->get_approver_remarks($data['forms_id']);
        $data['approver_details'] = $this->mod->get_approver_details($data['forms_id'], $this->user->user_id);

        if($data['form_status_id']['val'] > 2){
            $this->load->model('my_calendar_model', 'my_calendar');
            $data['approver_list'] = $this->my_calendar->get_time_forms_approvers($record_id);
            $data['approver_title'] = "Approval Status";
        }else{
            $this->load->model('form_application_manage_model', 'manage_app');
            $data['approver_list'] = $this->manage_app->get_form_approvers($data['forms_id']);
            $data['approver_title'] = "Approver/s";
        }

        $data['selected_dates'] = $this->selected_dates($data['forms_id']);

        $this->load->vars($data);

        $this->load->helper('form');
        $this->load->helper('file');
        echo $this->load->blade('detail.detail_'.strtolower($form_info['form_code']).'_form')->with( $this->load->get_cached_vars() );

    }

    function _list_options( $record, &$rec )
    {

        if( $this->permission['detail'] )
        {
            $rec['detail_url'] = $this->mod->url . '/detail/' . $record['forms_id'];
        }
        if( $this->permission['edit'] )
        {
            $rec['edit_url'] = $this->mod->url . '/edit_form/' . $record['forms_id'];
        }

        if($record['form_status_id'] != 8){
            $rec['options'] .= '<li><a href="#"><i class="fa fa-check text-success"></i> Approved</a></li>';
            $rec['options'] .= '<li><a href="#"><i class="fa fa-times text-danger"></i> Disapproved</a></li>';
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

        $forms_validation = $this->time_form_policies->validate_form_change_status($this->input->post('formid'));         
            
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
            

            // determines to where the action was 
            // performed and used by after_save to
            // know which notification to broadcast
            $this->response->type       = 'todo';
            $this->response->action     = 'insert';

            $this->response->message[]  = array(
                'message'   => 'Successfully Saved!',
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
                                        JOIN users_profile up ON up.company_id =  tpl.`company_id`  
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
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
            case 7:
            case 13:
            case 14:
            case 16:
            case 17:
            case 18:
            case 19:
            case 20:
            case 21:
            case 22:
            case 23:
            case 24:
            case 25:
            case 26:
                $form_details = $this->mod->get_leave_details($forms_id, $this->user->user_id);
                $remarks['remarks'] = array();
                $comments = $this->mod->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);

                $this->response->form_details .= $this->load->blade('edit/leave_details', $form_details, true);
            break;
            case 8://obt
                $form_details = $this->mod->get_obt_details($forms_id, $this->user->user_id);
                $remarks['remarks'] = array();
                $comments = $this->mod->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);

                $this->response->form_details .= $this->load->blade('edit/obt_details', $form_details, true);            
            break;
            case 9://ot
                $form_details = $this->mod->get_ot_ut_dtrp_details($forms_id, $this->user->user_id);
                $remarks['remarks'] = array();
                $comments = $this->mod->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);

                $this->response->form_details .= $this->load->blade('edit/ot_details', $form_details, true);            
            break;
            case 10://ut
                $form_details = $this->mod->get_ot_ut_dtrp_details($forms_id, $this->user->user_id);
                $remarks['remarks'] = array();
                $comments = $this->mod->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);

                $this->response->form_details .= $this->load->blade('edit/ut_details', $form_details, true);            
            break;
            case 11://dtrp
                $form_details = $this->mod->get_ot_ut_dtrp_details($forms_id, $this->user->user_id);
                $remarks['remarks'] = array();
                $comments = $this->mod->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);

                $this->response->form_details .= $this->load->blade('edit/dtrp_details', $form_details, true);            
            break;
            case 12://cws
                $form_details = $this->mod->get_cws_details($forms_id, $this->user->user_id);
                $remarks['remarks'] = array();
                $comments = $this->mod->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);

                $this->response->form_details .= $this->load->blade('edit/cws_details', $form_details, true);            
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
        $data['record']['users_department.department_id'] = '';
        $data['record']['partners.partner_id'] = '';

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
        $data['ut_time_in_out'] = '';
        $data['form_status_id'] = '';
        $data['record_id'] = '';

        //filter
        $data['record']['users_location.location_id'] = '';
        $data['record']['users_company.company_id'] = '';
        $data['record']['users_department.department_id'] = '';
        $data['record']['partners.partner_id'] = '';

        //url
        $data['url'] = $this->mod->url;
        $data['back_url'] = get_mod_route('applicationadmin');

        switch($data['form_type']){
            case 3: //emergency leave
            $data['form_code'] = 'EL';
            $data['form_title'] = 'Emergency Leave Blanket';
            $blanket_file_name = 'el_blanket.php';
            break;
            case 26: //public leave
            $data['form_code'] = 'PUL';
            $data['form_title'] = 'Public Leave';
            $blanket_file_name = 'pul_blanket.php';
            break;
            case 10: //undertime
            $data['form_code'] = 'UT';
            $data['form_title'] = 'Undertime Blanket';
            $blanket_file_name = 'ut_blanket.php';
            break;
            case 15: //excused tardiness
            $data['form_code'] = 'ET';
            $data['form_title'] = 'Excused Tardiness Blanket';
            $blanket_file_name = 'et_blanket.php';
            break;
        }

        $data['record']['partners.partner_id'] = '';
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
        $company_id = $this->input->post('company_id');
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
        if ($this->input->post('company_id')){
            $company_id = implode(',',$this->input->post('company_id'));
            $qry .= " AND company_id IN ({$company_id}) ";
        }
        if ($this->input->post('department_id')){
            $department_id = implode(',',$this->input->post('department_id'));
            $qry .= " AND department_id IN ({$department_id})  ";
        }
        $qry .= " ORDER BY partners.alias ASC";

        $employees = $this->db->query( $qry );
        $this->response->count = $employees->num_rows();
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
        switch($form_id){
            case 10://UT
                $_POST['date_from'] = $_POST['date_to'];
                $date_from = date('Y-m-d', strtotime($_POST['date_from'])); 
                $date_to = date('Y-m-d', strtotime($_POST['date_to']));
                $_POST['focus_date'] = date('Y-m-d',strtotime($date_from));
                $date_time = date('Y-m-d', strtotime($_POST['focus_date']))." ".date("H:i",strtotime($this->input->post('ut_time_in_out')));  
                $_POST['focus_date'] = date('Y-m-d',strtotime($date_from));
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
            case 15://ET
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
        $with_date_range = array(3, 10, 15); //Emergency leave, undertime

        if(in_array($form_id, $with_date_range)){
            if(strtotime($_POST['date_from']) > strtotime($_POST['date_to'])){
                $this->response->message[] = array(
                    'message' => 'Invalid Date Range - Date From should not be greater than Date To ',
                    'type' => 'warning'
                );  
                $this->_ajax_return();
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
        $duration = $this->input->post('duration');
        $selected_date_count = 0;

        foreach($period as $dt) {
            $form_holiday = array();
            $form_holiday = $this->mod->check_if_holiday($dt->format('Y-m-d'), $this->user->user_id);

            if(count($form_holiday) > 0 ){
                $days--;
            }else{
                switch($form_id){
                    case 3:
                    case 26:
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
                    $hrs = $duration_details[0]['credit'];
                    break;
                }
                $selected_date_count++;
            }
            switch($form_id){
                case 10: //UT
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
                        
                    $main_record[$this->mod->table]['date_from'] = $this->input->post('focus_date');
                    $main_record[$this->mod->table]['date_to'] = $this->input->post('focus_date');
                $breakout = true;
                break;
                case 15: //UT
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
                        
                    $main_record[$this->mod->table]['date_from'] = $this->input->post('focus_date');
                    $main_record[$this->mod->table]['date_to'] = $this->input->post('focus_date');
                $breakout = true;
                break;
            }
                if($breakout === true) break;
        }

        if($days <= 0){
            $this->response->message[] = array(
                'message' => 'You are not allowed to file the selected form on holiday',
                'type' => 'warning'
                );  
            $this->_ajax_return();
        }
        //validation of fields on module manager
        $main_record = array();
        $main_record[$this->mod->table]['form_status_id'] = $this->input->post('form_status_id');
        $main_record[$this->mod->table]['form_id'] = $this->input->post('form_type');
        $main_record[$this->mod->table]['form_code'] = $this->input->post('form_code');
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

                if($this->input->post('form_type') == 26){
                    $ALqry = " SELECT * FROM {$this->db->dbprefix}time_form_balance 
                            WHERE year = '".date('Y')."' AND user_id= {$user_id}
                            AND form_id= 2";
                    $ALresults = $this->db->query($ALqry);
                    if($ALresults->num_rows() > 0){
                        $ALresult = $ALresults->row_array();
                        $daysleave = $ALresult['balance'] - $days;
                        if($daysleave < 0){
                            $PULqry = " SELECT * FROM {$this->db->dbprefix}time_form_balance 
                                    WHERE year = '".date('Y')."' AND user_id= {$user_id}
                                    AND form_id= 26";
                            $PULresult = $this->db->query($PULqry);
                            if($PULresult->num_rows() > 0){
                                $balance_record = array(
                                    'used_insert' => abs($daysleave),
                                    'modified_on' => date('Y-m-d H:i:s')
                                );
                                $where_bal = array( 
                                    'year' => date('Y'),
                                    'form_id' => 26,
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
                                    'form_id' => 2,
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
                                    'form_id' => 2,
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
                                'form_id' => 2,
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
                            'form_id' => 26,
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
                // $blanket_values .= "($forms_id, $partners[user_id]), ";
                $this->db->insert('time_forms_blanket', array('forms_id' => $forms_id, 'user_id' => $partners['user_id']));            
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
                'message' => $this->input->post('forms_title').' was successfully saved.',
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
            case 8:
                $data['bt_type'] = 1;
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['date_from'])), $forms_info['user_id']);
            break;
            case 9:
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['date_from'])), $forms_info['user_id']);
            break;
            case 10:
                $data['ut_type'] = $data['form_id'] == 10 ? 0 :1;
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['date_from'])), $forms_info['user_id']);
            break;
            case 15:
                $data['shifts'] = $this->mod->get_shifts();
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['date_from'])), $forms_info['user_id']);
            break;
            case 13:
                $data['bday_duration'] = 1;
            break;
            case 11:
                $data['dtrp_type'] = 1;
                $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", strtotime($data['form_approver_details']['date_from'])), $forms_info['user_id']);
            break;
            case 12:
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
                        case 1:
                        case 2:
                        case 3:
                        case 4:
                        case 5:
                        case 6:
                        case 7:
                        case 13:
                        case 14:
                        case 16:
                        case 17:
                        case 18:
                        case 19:
                        case 20:
                        case 21:
                        case 22:
                        case 23:
                        case 24:
                        case 25:
                        case 26:
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


    function update_request()
    {
        $validation_rules_d[] = 
        array(
            'field' => 'request_remarks',
            'label' => 'Request Remarks',
            'rules' => 'required'
            );

        if( sizeof( $validation_rules_d ) > 0 )
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules( $validation_rules_d );
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

            $this->form_validation->clear_field_data();
        }
       
        $record_id = $this->input->post('record_id');
        $transpo_record['request_remarks'] = $this->input->post('request_remarks');
        if($_POST['action'] == 'approve'){
            $transpo_record['status_id'] = 6;
            $status_update = 'approved';
        }else{
            $transpo_record['status_id'] = 7;
            $status_update = 'disapproved';
        }

        // $transpo_record['modified_by'] = $this->user->user_id;
        $transpo_record['modified_on'] = date('Y-m-d H:i:s');
        $this->db->update( 'time_forms_obt_transpo', $transpo_record, array( $this->mod->primary_key => $record_id ) );
        $this->response->action = 'update';

        $this->response->saved = true;
        $this->response->message[] = array(
            'message' => "Record was {$status_update} successfully.",
            'type' => 'success'
        );
        
        $this->_ajax_return();
    }


}