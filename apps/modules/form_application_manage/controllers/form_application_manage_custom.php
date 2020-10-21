
    public function __construct()
    {
        $this->load->model('form_application_manage_model', 'mod');
        $this->load->library('time_form_policies');
        parent::__construct();

        $this->check_reassign_approvals();   
    }

    private $current_user = array();

    public function index()
    {

        if( !$this->permission['list'] )
        {
            echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
            die();
        }
        $this->load->model('form_application_admin_model', 'app_admin');
        $this->load->model('form_application_model', 'app_personal');
        $user_setting = APPPATH . 'config/users/'. $this->user->user_id .'.php';
        $user_id = $this->user->user_id;
        $this->load->config( "users/{$user_id}.php", false, true );
        $user = $this->config->item('user');

        $this->load->config( 'roles/'. $user['role_id'] .'/permission.php', false, true );
        $permission = $this->config->item('permission');
        $data['permission_app_manage'] = isset($this->permission['list']) ? $this->permission['list'] : 0;
        $data['permission_app_admin'] = isset($permission[$this->app_admin->mod_code]['list']) ? $permission[$this->app_admin->mod_code]['list'] : 0;
        $data['permission_app_personal'] = isset($permission[$this->app_personal->mod_code]['list']) ? $permission[$this->app_personal->mod_code]['list'] : 0;

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
        $data['leave_balance'] = $this->mod->get_leave_balance($forms_info['user_id'], date('Y'), '');
        $data['form_approver_details'] = $this->mod->get_form_approver_info($this->record_id,$this->user->user_id);
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
            $data['approver_list'] = $this->mod->get_form_approvers($data['forms_id']);
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

        if($record['form_status_id'] != 8){
            $rec['options'] .= '<li><a href="#"><i class="fa fa-check text-success"></i> Approved</a></li>';
            $rec['options'] .= '<li><a href="#"><i class="fa fa-times text-danger"></i> Disapproved</a></li>';
        }
    }

    function get_selected_dates(){

        $this->_ajax_only();

        $selected_dates = $this->mod->get_selected_dates($this->input->post('forms_id'));
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

        if( $date_from != "" || $date_to != "" ){
            
            $rest_days= array();
            foreach($period as $dt) {
                $forms_rest_day = $this->mod->check_if_rest_day($this->user->user_id, $dt->format('Y-m-d'));
                foreach($forms_rest_day as $forms_rest){
                    $rest_days[] = $forms_rest['rest_day'];
                }
            }

            foreach($period as $dt) {
                $form_holiday = array();
                $form_holiday = $this->mod->check_if_holiday($dt->format('Y-m-d'));
                if(count($form_holiday) > 0 || in_array($dt->format('l'), $rest_days)){           
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

        $view['content'] = $this->load->view('detail/view_date', $data, true);

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
            $form_name      = $this->mod->get_form_information($this->input->post('formid')); 
            $recipient      = $this->input->post('formownerid');
            $notif_message  = 'Filed ' . $form_name['form'] . ' on ' . date('F d, Y') . ' has been '.$action.'.';
            if(trim($this->input->post('comment')) != ""){
                $notif_message  .= '<br><br>Remarks: '.$this->input->post('comment');
            }

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

    public function reassign_approver(){

        $this->_ajax_only();

        $this->load->helper('form');
        $data = array();

        $data['form_title'] = "Select New Approver";
        $view['title'] = 'Re-assign Form Approver';
        
        $data['approver_id']= $this->input->post('approver_id');
        $data['forms_id']= $this->input->post('forms_id');
        $view['content'] = $this->load->view('edit/edit_reassign_approver', $data, true);

        $this->response->edit_reassign_approver = $view['content'];

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();

    }

    function get_approvers()
    {
        $this->_ajax_only();
        $search_str = $this->input->post('search_str');
        $current_approver_id = $this->input->post('current_approver_id');

        $user_info = $this->mod->get_users_info($current_approver_id);

        $qry = "SELECT *, CONCAT(a.lastname, ', ',a.firstname) as approver_name
        FROM users_profile a
        WHERE a.company_id = {$user_info['company_id']} 
        AND (
            a.lastname LIKE '%{$search_str}%' OR 
            a.firstname LIKE '%{$search_str}%' OR 
            a.middlename LIKE '%{$search_str}%')
        ORDER BY a.lastname ASC";
        
        $approver_qry = $this->db->query( $qry );

        $this->response->approver_list = '';
        foreach( $approver_qry->result() as $approver )
        {
            $this->response->approver_list .= '<option value="'.$approver->user_id.'" selected="selected">'.$approver->approver_name.'</option>';
        }

        $this->_ajax_return();  
    }

    function update_approver()
    {
        $this->_ajax_only();

        $new_approver = $this->input->post('new_approver');
        $current_approver_id = $this->input->post('current_approver_id');
        $forms_id = $this->input->post('forms_id');

        if(!$new_approver > 0){
        $this->response->message[] = array(
                                    'message' => 'Please select approver.',
                                    'type' => 'warning'
                                    );  
                            $this->_ajax_return();
        }else{
            $data = array(
               'user_id' => $new_approver
               );
            $this->db->update( 'time_forms_approver', $data, array('forms_id' => $forms_id, 'user_id' => $current_approver_id) );
        }

        $this->response->saved = true; 
        $this->response->message[] = array(
            'message' => 'Approver was successfully updated.',
            'type' => 'success'
        );

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
            foreach($period as $dt) {
                $forms_rest_day = $this->mod->check_if_rest_day($forms_info['user_id'], $dt->format('Y-m-d'));
                foreach($forms_rest_day as $forms_rest){
                    $rest_days[] = $forms_rest['rest_day'];
                }
            }

            foreach($period as $dt) {
                $form_holiday = array();
                $form_holiday = $this->mod->check_if_holiday($dt->format('Y-m-d'));
                if(count($form_holiday) > 0 || in_array($dt->format('l'), $rest_days)){           
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

    function check_reassign_approvals(){
        $data['current_user']           = $this->user->user_id;
        $data['todos']                  = $this->mod->checkIfapprover($data['current_user']);

        if(count($data['todos']) >0 ){
            $this->permission['list'] = 1;
            $this->permission['detail'] = 1;
            $this->permission['add'] = 1;
            $this->permission['edit'] = 1;
            $this->permission['approve'] = 1;
            $this->permission['decline'] = 1;
        }
    }

