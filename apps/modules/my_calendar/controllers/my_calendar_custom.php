


    public function index(){    

        if( !$this->permission['list'] )
        {
            $this->response->message[] = array(
                'message' => lang('common.insufficient_permission'),
                'type' => 'warning'
                );
            $this->_ajax_return();
        }    

        echo $this->load->blade('record_listing_custom')->with( $this->load->get_cached_vars() );
    }

    function get_events(){

        $this->_ajax_only();
        $date_from = $_GET['start'] == '' ? date('Y-01-01') : date("Y-m-d", $_GET['start']);
        $date_to = $_GET['end'] == '' ? date('Y-12-31') : date("Y-m-d", $_GET['end']);

        $sp_time_calendar = $this->mod->call_sp_time_calendar($date_from, $date_to, $this->user->user_id);
        // echo json_encode($sp_time_calendar);

        $this->response->time_calendar_events = $sp_time_calendar;
        $this->response->form_types = $this->mod->get_form_policy_grant($this->user->user_id);
        $this->response->message[] = array(
            'message' => 'Events called succesfully!',
            'type' => 'success'
            );
        $this->_ajax_return();
    }

    function edit_forms()
    {
        $this->_ajax_only();

        if( !$this->permission['add'] && !$this->permission['edit'] )
        {
            $this->response->message[] = array(
                'message' => 'You dont have sufficient permission to file forms on this calendar, please notify the System Administrator.',
                'type' => 'warning'
                );
            $this->_ajax_return();
        }

        $forms_id = $data['forms_id'] = $this->input->post('forms_id');
        $data['url'] = $this->mod->url;
        $data['form_id'] = $this->input->post('form_id') ;
        $data['date_from']["val"] = date("F d, Y", $this->input->post('start_date'));
        $data['date_to']["val"] = date("F d, Y", $this->input->post('start_date'));
        $data['reason']["val"] = '';
        $data['form_status_id']["val"] = 1;
        $data['upload_id']["val"] = array();        
        $data['bt_type'] = "";
        $data['scheduled'] = "";

        /********** START VALIDATION before opening modal ********/

        //validate if there's already an existing approved application
        if(empty($forms_id)){
            //leaves only
            $leave_form_type = $this->mod->get_leave_form_type();
            $leaves_ids = array();
            foreach ($leave_form_type as $leave_form){
                $leaves_ids[] = $leave_form['form_id'];
            }

            if(in_array($data['form_id'], $leaves_ids)){
                $already_exist = $this->mod->get_approved_forms(date("Y-m-d",$this->input->post('start_date')), $this->user->user_id);

                $total_filed_day = 0;
                $total_filed_credit = 0;
                foreach($already_exist as $existed_form){
                    if(in_array($existed_form['form_id'], $leaves_ids)){
                        $total_filed_day += $existed_form['day'];
                        $total_filed_credit += $existed_form['credit'];
                        if($total_filed_day == 1 && $total_filed_credit == 8){
                            $this->response->message[] = array(
                                'message' => 'You already have an approved whole day leave on this date',
                                'type' => 'warning'
                                );  
                            $this->_ajax_return();
                            break;
                        }
                    }
                }
            }

            //validate if rest day/holiday
            $other_form_type = array(10, 15); //undertime and excused tardiness
            $not_allowed_rest_holidays = array_merge($leaves_ids, $other_form_type);

            if(in_array($data['form_id'], $not_allowed_rest_holidays)){
                //check if restday
                $forms_rest_day = $this->mod->check_if_rest_day($this->user->user_id, date("Y-m-d",$this->input->post('start_date')));
                $rest_day_not_allowed = 0;
                foreach($forms_rest_day as $forms_rest){
                    if(date("l", $this->input->post('start_date')) == $forms_rest['rest_day']){
                        $rest_day_not_allowed = 1;
                        break;
                    }
                }

                if($rest_day_not_allowed == 1){
                    $this->response->message[] = array(
                        'message' => 'You are not allowed to file the selected form on Rest day',
                        'type' => 'warning'
                        );  
                    $this->_ajax_return();
                }

                //check if holiday
                $form_holiday = array();
                $form_holiday = $this->mod->check_if_holiday(date("Y-m-d",$this->input->post('start_date')), $this->user->user_id);

                if(count($form_holiday) > 0){
                    $this->response->message[] = array(
                        'message' => 'You are not allowed to file the selected form on Holiday',
                        'type' => 'warning'
                        );  
                    $this->_ajax_return();
                }

            }
        }

        /********** END VALIDATION before opening modal ********/


        switch($this->input->post('form_id')){
            case 1: //Sick Leave
            case 2: //Annual Leave
            case 3: //Emergency
            case 4: //Bereavement
            case 7: //Leave Without Pay
            case 14: //Special Leave for Women
            case 16: //SOLO Parent Leave
            case 17: //Victim of Violence Leave
            //Get LEAVE BALANCE
            $data['leave_balance'] = $this->mod->get_leave_balance($this->user->user_id, date('Y'), '');
            break;

            case 5: //Maternity
            //Get LEAVE BALANCE
            $data['leave_balance'] = $this->mod->get_leave_balance($this->user->user_id, date('Y'), '');
            $data['delivery'] = $this->mod->get_delivery();
            $data['delivery_id']["val"] = 1;
            $data['pregnancy_no']["val"] = '';
            $data['expected_date']["val"] = '';
            $data['actual_date']["val"] = '';
            $data['return_date']["val"] = '';
            break;

            case 6: //Paternity
            //Get LEAVE BALANCE
            $data['leave_balance'] = $this->mod->get_leave_balance($this->user->user_id, date('Y'), '');
            $data['actual_date']["val"] = '';
            break;

            case 8: //OBT
            //Get LEAVE BALANCE
            $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", $this->input->post('start_date')), $this->user->user_id);
            $data['leave_balance'] = $this->mod->get_leave_balance($this->user->user_id, date('Y'), '');
            $data['date_from']["val"] = date("F d, Y", $this->input->post('start_date'))." - ".date("h:i a", strtotime(array_key_exists('shift_time_start', $data['shift_details']) ? $data['shift_details']['shift_time_start'] : '00:00:00'));
            $data['date_to']["val"] = date("F d, Y", $this->input->post('start_date'))." - ".date("h:i a", strtotime(array_key_exists('shift_time_end', $data['shift_details']) ? $data['shift_details']['shift_time_end'] : '00:00:00'));
            $data['location']["val"] = '';
            $data['company_to_visit']["val"] = '';
            $data['name']["val"] = '';
            $data['position']["val"] = '';
            $data['contact_no']["val"] = '';
            if( $forms_id ){
                $obt_selected_dates = $this->mod->get_selected_dates($forms_id);                
                $data['bt_type'] = (count($obt_selected_dates) > 1) ? 2 : 1;
            }
            break;

            case 9: //OT
            //Get LEAVE BALANCE
            $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", $this->input->post('start_date')), $this->user->user_id);
            $data['date_from']["val"] = date("F d, Y", $this->input->post('start_date'))." - ".date("h:i a", strtotime(array_key_exists('shift_time_end', $data['shift_details']) ? $data['shift_details']['shift_time_end'] : '00:00:00'));
            $data['date_to']["val"] = date("F d, Y", $this->input->post('start_date'))." - ".date("h:i a", strtotime(array_key_exists('shift_time_end', $data['shift_details']) ? $data['shift_details']['shift_time_end'] : '00:00:00'));
            break;

            case 10: //UT
            case 15: //Excused tardiness
            //Get LEAVE BALANCE
            $data['ut_time_in_out'] = "";
            $data['ut_type'] = $data['form_id'] == 10 ? 0 :1;
            $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", $this->input->post('start_date')), $this->user->user_id);
            $data['date_from']["val"] = date("F d, Y", $this->input->post('start_date'));
            $data['date_to']["val"] = date("F d, Y", $this->input->post('start_date'));            
            if( $forms_id ){
                $data['ut_type'] = $this->mod->check_ut_type($forms_id);
                $ut_date_time = $this->mod->get_selected_dates($forms_id);
                $data['ut_time_in_out'] = ($data['ut_type']  == 0) ? date("h:i A", strtotime($ut_date_time[0]['time_to'])) : date("h:i A", strtotime($ut_date_time[0]['time_from']));
            }else{                
                if($data['ut_type']  == 0){
                    $logs_out = array_key_exists('logs_time_out', $data['shift_details']) ? $data['shift_details']['logs_time_out'] : '-';
                    $data['ut_time_in_out'] = ($logs_out == "-") ? date("h:i A", strtotime(array_key_exists('shift_time_end', $data['shift_details']) ? $data['shift_details']['shift_time_end'] : '00:00:00')) : date("h:i A", strtotime($logs_out));
                }else{
                    $logs_in = array_key_exists('logs_time_in', $data['shift_details']) ? $data['shift_details']['logs_time_in'] : '-';
                    $data['ut_time_in_out'] = ($logs_in == "-") ? date("h:i A", strtotime(array_key_exists('shift_time_start', $data['shift_details']) ? $data['shift_details']['shift_time_start'] : '00:00:00')) : date("h:i A", strtotime($logs_in));
                }
            }
            break;

            case 11: //DTRP
            //Get LEAVE BALANCE
            $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", $this->input->post('start_date')), $this->user->user_id);
            $data['date_from']["val"] = date("F d, Y", $this->input->post('start_date'))." - ".date("h:i a", strtotime(array_key_exists('shift_time_start', $data['shift_details']) ? $data['shift_details']['shift_time_start'] : '00:00:00'));
            $data['date_to']["val"] = date("F d, Y", $this->input->post('start_date'))." - ".date("h:i a", strtotime(array_key_exists('shift_time_end', $data['shift_details']) ? $data['shift_details']['shift_time_end'] : '00:00:00'));
            $data['dtrp_type'] = $forms_id ? $this->mod->check_dtrp_type($forms_id) : 1;
            break;

            case 12: //CWS
            //Get LEAVE BALANCE
            $data['shift_details'] = $this->mod->get_shift_details(date("Y-m-d", $this->input->post('start_date')), $this->user->user_id);
            
            $data['date_to']["val"] = date("F d, Y", $this->input->post('start_date'));
            $data['shifts'] = $this->mod->get_shifts();
            $data['shift_id']['val'] = array_key_exists('shift_id', $data['shift_details']) ? $data['shift_details']['shift_id'] : 0;
            break;

            case 13: //Birthday Leave
            //Get LEAVE BALANCE
            $data['leave_balance'] = $this->mod->get_leave_balance($this->user->user_id, date('Y'), '');
            $data['date_to']["val"] = date("F d, Y", $this->input->post('start_date'));
            $data['duration'] = $this->mod->get_duration();

            if( $forms_id ){
                $bday_selected_date = $this->mod->get_selected_dates($forms_id);
                $data['bday_duration'] = $bday_selected_date[0]['duration_id'];
            }else{
                $data['bday_duration'] = 1;
            }
            break;

            default:
            break;
        }
        require( APPPATH . 'modules/'. $this->mod->mod_code .'/config/field_groups.php' );
        $fieldgroups = $config['fieldgroups'];
        $fg_fields_array = $fieldgroups[$data['form_id']]['fields'];

        require( APPPATH . 'modules/'. $this->mod->mod_code .'/config/fields.php' );
        $fields = $config['fields'];

        if( $forms_id ){
           $forms_data = $this->mod->edit_cached_query( $forms_id );
           $forms_dates_duration = $this->mod->edit_cached_query( $forms_id );
           $data['scheduled'] = $forms_dates_duration['time_forms.scheduled'];
       }

       foreach($fg_fields_array as $index => $field )
       {
        $data[$fields[$data['form_id']][$field]['column']]["label"] = $fields[$data['form_id']][$field]['label'];
        if( $forms_id )
        {
            switch($fields[$data['form_id']][$field]['uitype_id']){
                    case 8: //Single Upload
                    case 9: //Multiple Upload
                    $upload_forms = $this->mod->get_forms_upload($forms_id);
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
                                $date_time_from = $this->mod->get_time_from_to_dates($forms_id, date("Y-m-d", strtotime($forms_data[$field])), 'time_from', $data['form_id'], $data['bt_type']);
                                $date_time_to = $this->mod->get_time_from_to_dates($forms_id, date("Y-m-d", strtotime($forms_data[$field])), 'time_to', $data['form_id'], $data['bt_type']);
                                $data[$fields[$data['form_id']][$field]['column']]["val"] = (empty($date_time_from) || $date_time_from == '0000-00-00 00:00:00') ? date("F d, Y", strtotime($date_time_to)) : date("F d, Y", strtotime($date_time_from));
                            }else{
                                $date_time_from = $this->mod->get_time_from_to_dates($forms_id, date("Y-m-d", strtotime($forms_data[$field])), 'time_from', $data['form_id'], $data['bt_type']);
                                $date_time_to = $this->mod->get_time_from_to_dates($forms_id, date("Y-m-d", strtotime($forms_data[$field])), 'time_to', $data['form_id'], $data['bt_type']);
                                $data[$fields[$data['form_id']][$field]['column']]["val"] = (empty($date_time_to) || $date_time_to == '0000-00-00 00:00:00') ? date("F d, Y", strtotime($date_time_from)) : date("F d, Y", strtotime($date_time_to));
                            }
                        }else{
                            if(strtotime($forms_data[$field])) $date = date("F d, Y", strtotime($forms_data[$field]));
                            else $date = '';
                            $data[$fields[$data['form_id']][$field]['column']]["val"] = $date;
                        }
                        break;
                    case 16: //DATETIME Picker
                    if($fields[$data['form_id']][$field]['column'] == "date_from"){
                        $date_time = $this->mod->get_time_from_to_dates($forms_id, date("Y-m-d", strtotime($forms_data[$field])), 'time_from', $data['form_id'], $data['bt_type']);
                        $data[$fields[$data['form_id']][$field]['column']]["val"] = (empty($date_time)) ? "" : date("F d, Y - h:i a", strtotime($date_time));
                    }else{
                        $date_time = $this->mod->get_time_from_to_dates($forms_id, date("Y-m-d", strtotime($forms_data[$field])), 'time_to', $data['form_id'], $data['bt_type']);
                        $data[$fields[$data['form_id']][$field]['column']]["val"] = (empty($date_time)) ? "" : date("F d, Y - h:i a", strtotime($date_time));
                    }
                    break;
                    default:
                    $data[$fields[$data['form_id']][$field]['column']]["val"] = $forms_data[$field];
                    break;
                }
            }
        }

        $data['time_shift'] = $this->db->get('time_shift')->result_array();
        $form_type = $this->mod->get_form_type($this->input->post('form_id'));
        $data['forms_title_date'] = date("F d, Y", $this->input->post('start_date')). " - ".date("D", $this->input->post('start_date'));
        $data['forms_title'] = $this->input->post('form_title') == "" ? $form_type['form']." Form" : $this->input->post('form_title')." Form";
        $data['form_code'] = $this->input->post('form_code');
        $data['focus_date'] = date("Y-m-d", $this->input->post('start_date'));

        $data['disabled'] = $data['form_status_id']['val'] > 2 ? "disabled" : "";

        $data['comment'] = "";
        $data['approver_name'] = "";
        $data['form_status'] = "";
        if($data['form_status_id']['val'] == 7 || $data['form_status_id']['val'] == 8){ //disapproved, display remarks
            $this->load->model('form_application_model', 'form_app');
            $disapproved_cancelled_remarks = $this->form_app->get_disapproved_cancelled_remarks($forms_id);
        
            $data['comment'] = $disapproved_cancelled_remarks['comment'];
            $data['approver_name'] = $disapproved_cancelled_remarks['approver_name'];
            $data['form_status'] = $disapproved_cancelled_remarks['form_status'];
        }

        if($data['form_status_id']['val'] > 2){
            $data['approver_list'] = $this->mod->get_time_forms_approvers($forms_id);
            $data['approver_title'] = "Approval Status";
        }else{
            $data['approver_list'] = $this->mod->call_sp_approvers(strtoupper($this->input->post('form_code')), $this->user->user_id);
            $data['approver_title'] = "Approver/s";
        }

        $this->load->helper('form');
        $this->load->helper('file');
        $view['title'] = $data['forms_title'];
        $view['content'] = $this->load->view('edit/edit_'.strtolower($this->input->post('form_code')).'_form', $data, true);
        
        $this->response->edit_forms = $this->load->view('edit/form_modal', $view, true);
        
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
            );

        $this->_ajax_return();
    }

    function get_shift_details()
    {
        $this->_ajax_only();
        if($this->input->post('form_type') == 10 || $this->input->post('form_type') == 15 || $this->input->post('form_type') == 12){ //CWS, undertime or excused tardiness
            $date_from = date('Y-m-d', strtotime($this->input->post('date_from')));
            $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
        }else{//DTRP, OT
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
                $shift_details['ut_time_in_out'] = ($logs_out == "-") ? date("h:i A", strtotime(array_key_exists('shift_time_end', $shift_details) ? $shift_details['shift_time_end'] : '00:00:00')) : date("h:i A", strtotime($logs_out));
            }else{
                $shift_details['ut_time_in_out'] = ($logs_in == "-") ? date("h:i A", strtotime(array_key_exists('shift_time_start', $shift_details) ? $shift_details['shift_time_start'] : '00:00:00')) : date("h:i A", strtotime($logs_in));
            }
        }

        $shift_details['shift_time_end'] = $shift_end != '-' ? date("g:ia", strtotime(date("Y-m-d")." ".$shift_end)) : '-';
        $shift_details['shift_time_start'] = $shift_start != '-' ? date("g:ia", strtotime(date("Y-m-d")." ".$shift_start)) : '-';
        $shift_details['logs_time_out'] = $logs_out != '-' ? date("g:ia", strtotime($logs_out)) : '-'; 
        $shift_details['logs_time_in'] = $logs_in != '-' ? date("g:ia", strtotime($logs_in)) : '-'; 
        
        $this->response->shift_details = $shift_details;
        $this->response->message[] = array(
            'message' => 'Shift logs fetched succesfully!',
            'type' => 'success'
            );
        $this->_ajax_return();
        // echo json_encode($shift_details);
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

        $this->response->forms_id = $forms_id = $this->input->post('forms_id');
        $form_id = $this->input->post('form_id');
        require( APPPATH . 'modules/'. $this->mod->mod_code .'/config/field_groups.php' );
        $fieldgroups = $config['fieldgroups'];
        $fg_fields_array = $fieldgroups[$form_id]['fields'];

        require( APPPATH . 'modules/'. $this->mod->mod_code .'/config/fields.php' );
        $fields = $config['fields'];

        /*******START Filed FORM validation********/
        $date_time_from = '';
        $date_time_to = '';
        $date_time = '';
        switch($form_id){
            case 8: //OBT
            case 9: //OT
            case 11: //DTRP
            $date_from = date('Y-m-d', strtotime(substr($this->input->post('date_from'), 0, -11))); 
            $date_to = date('Y-m-d', strtotime(substr($this->input->post('date_to'), 0, -11)));            
            $date_time_from = date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('date_from'))));
            $date_time_to = date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('date_to'))));
            break;
            case 10: //UT
            case 15: //ET
            $date_from = date('Y-m-d', strtotime($this->input->post('date_from'))); 
            $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
            $date_time = date('Y-m-d', strtotime($this->input->post('date_from')))." ".date("H:i",strtotime($this->input->post('ut_time_in_out')));  
            break;
            default:
            $date_from = date('Y-m-d', strtotime($this->input->post('date_from'))); 
            $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
            break;
        }

        //check if forms is still draft/for approval
        if(!empty($forms_id)){
            $can_update_status = array(7,8);
            $form_details = $this->mod->get_forms_details($forms_id);
            if($form_details['form_status_id'] > 2 && $this->input->post('form_status_id') != 8){
                $this->response->message[] = array(
                    'message' => ' Selected form cannot be updated anymore.',
                    'type' => 'warning'
                    );  
                $this->_ajax_return();            
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

        if($this->input->post('form_status_id') == 8){ //check if forms is for cancellation
                if(trim($this->input->post('cancelled_comment')) == ""){
                    $this->response->message[] = array(
                        'message' => "The Remarks field is required",
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

        $other_form_date = array(10, 12, 15); //undertime, CWS, excused tardiness
        $with_date_range = array_merge($leaves_ids, $other_form_date);
        if(in_array($form_id, $with_date_range)){
            if(strtotime($this->input->post('date_from')) > strtotime($this->input->post('date_to'))){
                $this->response->message[] = array(
                    'message' => 'Invalid Date Range - Date From should not be greater than Date To ',
                    'type' => 'warning'
                    );  
                $this->_ajax_return();
            }
        }

        $this->input->post('dtrp_type') == 3 ? $other_form_type = array(8, 9, 11) : $other_form_type = array(8, 9); //business trip, overtime, dtrp
        if(in_array($form_id, $other_form_type)){
            if(strtotime(str_replace(" - "," ",$this->input->post('date_from'))) > strtotime(str_replace(" - "," ",$this->input->post('date_to')))){
                $this->response->message[] = array(
                    'message' => 'Invalid Date Range - Date From should not be greater than Date To ',
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
        foreach($period as $dt) {
        $forms_rest_day = $this->mod->check_if_rest_day($this->user->user_id, $dt->format('Y-m-d'));
        }
        $rest_day_not_allowed = 0;
        $holiday_not_allowed = 0;
        $duration_total=0;
        if($this->input->post('form_status_id') != 8){
            foreach($period as $dt) {

                if(in_array($form_id, $leaves_ids)){
                $already_exist = $this->mod->get_approved_forms($dt->format('Y-m-d'), $this->user->user_id);
                    $pending_already_exist = $this->mod->get_pending_forms($dt->format('Y-m-d'), $this->user->user_id);
                $total_filed_day = 0;
                $total_filed_credit = 0;
                $duration_day = 0;
                $duration_credits = 0;
                $duration_total=0;
                if (array_key_exists($counter_duration, $duration_date)){
                    $duration_details = $this->mod->get_duration($duration_date[$counter_duration]);
                    $duration_credits = $duration_details[0]['credit'];
                    $duration_day = $duration_date[$counter_duration] == 1 ? 1 : 0.5;
                    $duration_total += $duration_day;
                }
                foreach($already_exist as $existed_form){
                        if(in_array($existed_form['form_id'], $leaves_ids)){
                    $total_filed_day += ($existed_form['day'] + $duration_day);
                    $total_filed_credit += ($existed_form['credit'] + $duration_credits);
                            if(($total_filed_day > 1 && $total_filed_credit > 8) || $duration_date[$counter_duration] == $existed_form['duration_id']){
                        $this->response->message[] = array(
                            'message' => 'You already have an approved whole day leave on the selected date',
                            'type' => 'warning'
                        );  
                        $this->_ajax_return();
                        break;
                    }
                }
            }
                    foreach($pending_already_exist as $existed_pending_form){
                        if(in_array($existed_pending_form['form_id'], $leaves_ids)){
                            $total_filed_day += ($existed_pending_form['day'] + $duration_day);
                            $total_filed_credit += ($existed_pending_form['credit'] + $duration_credits);
                            if(($total_filed_day > 1 && $total_filed_credit > 8) || $duration_date[$counter_duration] == $existed_pending_form['duration_id']){
                                $this->response->message[] = array(
                                    'message' => 'You already have a pending whole day leave on the selected date',
                                    'type' => 'warning'
                                    );  
                                // $this->_ajax_return();
                                break;
                            }
                        }
                    }
                    $counter_duration++;

                    //check if leave selected date is restday
                    foreach($forms_rest_day as $forms_rest){
                        if($dt->format('l') == $forms_rest['rest_day']){
                            $rest_day_not_allowed++;
                        }
                    }
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
                    foreach($forms_rest_day as $forms_rest){
                        if($dt->format('l') == $forms_rest['rest_day']){
                            $rest_day_not_allowed = 1;
                            break;
                        }
                    }

                    if($rest_day_not_allowed == 1){
                        $this->response->message[] = array(
                            'message' => 'You are not allowed to file the selected form on Rest day',
                            'type' => 'warning'
                            );  
                        $this->_ajax_return();
                    }

                    //check if holiday
                    $form_holiday = array();
                    $form_holiday = $this->mod->check_if_holiday($dt->format('Y-m-d'), $this->user->user_id);

                    if(count($form_holiday) > 0){
                        $this->response->message[] = array(
                            'message' => 'You are not allowed to file the selected form on Holiday',
                            'type' => 'warning'
                            );  
                        $this->_ajax_return();
                    }
                }
                //END restday/holiday checking ET and UT
            }

            if($counter_duration != 0){
                if($counter_duration == $rest_day_not_allowed){
                    $this->response->message[] = array(
                        'message' => 'You are not allowed to file the selected form on restday',
                        'type' => 'warning'
                        );  
                    $this->_ajax_return();
                }else if($counter_duration == $holiday_not_allowed){
                    $this->response->message[] = array(
                        'message' => 'You are not allowed to file the selected form on holiday',
                        'type' => 'warning'
                        );  
                    $this->_ajax_return();
                }else if($counter_duration == ($rest_day_not_allowed + $holiday_not_allowed)){
                    $this->response->message[] = array(
                        'message' => 'You are not allowed to file the selected form on restday/holiday',
                        'type' => 'warning'
                        );  
                    $this->_ajax_return();
                }
            }

            //START : validate forms with focus date and OT overlap
            //obt, overtime, undertime, dtrp, excuse tardiness
            $this->input->post('bt_type') == 1 ? $form_type_with_focus = array(8, 9, 10, 11, 15) : $form_type_with_focus = array(9, 10, 11, 15); 
            if(in_array($form_id, $form_type_with_focus)){
                switch($form_id){
                    case 8://obt
                        if(strtotime($this->input->post('focus_date')) > strtotime($date_from. ' +1 day') || strtotime($this->input->post('focus_date')) < strtotime($date_from. ' -1 day')
                            || strtotime($this->input->post('focus_date')) > strtotime($date_to) || strtotime($this->input->post('focus_date')) < strtotime($date_to. ' -1 day')){
                            $this->response->message[] = array(
                                'message' => 'Invalid date selection.',
                                'type' => 'warning'
                                );  
                        $this->_ajax_return();
                        }
                    break;
                    case 9://overtime
                        if(strtotime($this->input->post('focus_date')) > strtotime($date_from. ' +1 day') || strtotime($this->input->post('focus_date')) < strtotime($date_from. ' -1 day')
                            || strtotime($this->input->post('focus_date')) > strtotime($date_to) || strtotime($this->input->post('focus_date')) < strtotime($date_to. ' -1 day')){
                            $this->response->message[] = array(
                                'message' => 'Invalid date selection.',
                                'type' => 'warning'
                                );  
                        $this->_ajax_return();
                        }
                        //OT overlap
                        $existing_ot_forms =  $this->mod->validate_ot_forms(date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('date_from')))), date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$this->input->post('date_to')))), $this->user->user_id, $form_id, $forms_id);
                        if($existing_ot_forms > 0){
                          $this->response->message[] = array(
                            'message' => 'Overtime application has already been filed.',
                            'type' => 'warning'
                            );  
                        $this->_ajax_return();
                        }
                    break;
                    case 10://undertime
                    case 15://Excused Tardiness
                        if($this->input->post('ut_type') == 1){ 
                            if(strtotime($this->input->post('focus_date')) > strtotime($date_from. ' +1 day') || strtotime($this->input->post('focus_date')) < strtotime($date_from. ' -1 day')){
                                $this->response->message[] = array(
                                    'message' => 'Invalid date selection.',
                                    'type' => 'warning'
                                    );  
                            $this->_ajax_return();
                            }
                        }else{ 
                            if(strtotime($this->input->post('focus_date')) > strtotime($date_to) || strtotime($this->input->post('focus_date')) < strtotime($date_to. ' -1 day')){
                                $this->response->message[] = array(
                                    'message' => 'Invalid date selection.',
                                    'type' => 'warning'
                                    );  
                            $this->_ajax_return();
                            }
                        }
                    break;
                    case 11://dtrp
                        if($this->input->post('dtrp_type') == 1){ //IN
                            if(strtotime($this->input->post('focus_date')) > strtotime($date_from. ' +1 day') || strtotime($this->input->post('focus_date')) < strtotime($date_from. ' -1 day')){
                                $this->response->message[] = array(
                                    'message' => 'Invalid date selection.',
                                    'type' => 'warning'
                                    );  
                            $this->_ajax_return();
                            }
                        }elseif($this->input->post('dtrp_type') == 2){ //OUT
                            if(strtotime($this->input->post('focus_date')) > strtotime($date_to) || strtotime($this->input->post('focus_date')) < strtotime($date_to. ' -1 day')){
                                $this->response->message[] = array(
                                    'message' => 'Invalid date selection.',
                                    'type' => 'warning'
                                    );  
                            $this->_ajax_return();
                            }
                        }else{ //IN & OUT
                            if(strtotime($this->input->post('focus_date')) > strtotime($date_from. ' +1 day') || strtotime($this->input->post('focus_date')) < strtotime($date_from. ' -1 day')
                                || strtotime($this->input->post('focus_date')) > strtotime($date_to) || strtotime($this->input->post('focus_date')) < strtotime($date_to. ' -1 day')){
                                $this->response->message[] = array(
                                    'message' => 'Invalid date selection.',
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
                $date = $this->input->post($fields[$form_id][$field]['column']);
                $main_record[$fields[$form_id][$field]['table']][$fields[$form_id][$field]['column']] = $date != "" ? date('Y-m-d', strtotime($date)) : "";
                break;
                case 16: //DATETIME Picker
                $date = substr($this->input->post($fields[$form_id][$field]['column']), 0, -11);
                $main_record[$fields[$form_id][$field]['table']][$fields[$form_id][$field]['column']] = $date != "" ? date('Y-m-d', strtotime($date)) : "";
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
            $forms_validation = $this->time_form_policies->validate_form_filing($form_id, strtoupper($this->input->post('form_code')), $this->user->user_id, $date_from, $date_to, $uploads, $forms_id, $date_time_from, $date_time_to, $date_time, $shift_to, $schedule, $duration_total);

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
            $forms_validation = $this->time_form_policies->validate_form_change_status($forms_id);

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

        //fields not setup on module manager - value assignment
        if($this->input->post('form_status_id') == 2){
            $main_record[$this->mod->table]['form_status_id'] = $forms_validation['hr_validate'] == true ? 4 : $this->input->post('form_status_id');
        }else{
            $main_record[$this->mod->table]['form_status_id'] = $this->input->post('form_status_id');
        }
        $main_record[$this->mod->table]['form_id'] = $form_id;
        $main_record[$this->mod->table]['scheduled'] = $this->input->post('scheduled');
        $main_record[$this->mod->table]['form_code'] = strtoupper($this->input->post('form_code'));
        $main_record[$this->mod->table]['user_id'] = $this->user->user_id;
        $main_record[$this->mod->table]['display_name'] = $this->mod->get_display_name($this->user->user_id);

        if($this->input->post('form_status_id') == 8){ //add cancelled date
            $main_record[$this->mod->table]['date_cancelled'] = date('Y-m-d H:i:s');
        }
        
        $time_forms_date_table = array();
        $breakout = false;
        $hrs = 0;
        $duration = $this->input->post('duration');
        $selected_date_count = 0;
        
        $rest_days= array();
        foreach($period as $dt) {
            $forms_rest_day = $this->mod->check_if_rest_day($this->user->user_id, $dt->format('Y-m-d'));
            foreach($forms_rest_day as $forms_rest){
                $rest_days[] = $forms_rest['rest_day'];
            }
        }
        foreach($period as $dt) {

            $form_holiday = array();
            $form_holiday = $this->mod->check_if_holiday($dt->format('Y-m-d'), $this->user->user_id);
            if(count($form_holiday) > 0 || in_array($dt->format('l'), $rest_days)){     
                if($form_id != 8){           
                    $days--;
                }
            }else{
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
                        $time_forms_date_table = array(
                            'cancelled_comment' => $this->input->post('cancelled_comment') 
                            );
                    }
                    if($duration[$selected_date_count] != 1){
                        $days -= 0.5;
                    }
                    break;
                }
                $selected_date_count++;
            }
                switch($form_id){
                    case 8: //OBT
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
                        $time_forms_date_table = array(
                            'cancelled_comment' => $this->input->post('cancelled_comment') 
                            );
                    }
                    break;
                    case 9: //OT
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
                        $time_forms_date_table = array(
                            'cancelled_comment' => $this->input->post('cancelled_comment') 
                            );
                    }
                    $days = 1;
                    $main_record[$this->mod->table]['date_from'] = $this->input->post('focus_date');
                    $main_record[$this->mod->table]['date_to'] = $this->input->post('focus_date');
                    $breakout = true;
                    break;
                    case 10: //UT
                    case 15: //ET
                    $date_time = $dt->format('Y-m-d')." ".date("H:i",strtotime($this->input->post('ut_time_in_out')));  
                    // $hrs = ((strtotime($time_to) - strtotime($time_from))/60)/60;    
                    if($this->input->post('form_status_id') != 8){ 
                        if($this->input->post('ut_type') == 1){ 
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
                                'time_to' => $date_time
                                );
                        }
                    }else{
                        $time_forms_date_table = array(
                            'cancelled_comment' => $this->input->post('cancelled_comment') 
                            );
                    }
                    $days = 1;
                    $main_record[$this->mod->table]['date_from'] = $this->input->post('focus_date');
                    $main_record[$this->mod->table]['date_to'] = $this->input->post('focus_date');
                    $breakout = true;
                    break;
                    case 11: //DTRP
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
                        }elseif($this->input->post('dtrp_type') == 2){ 
                            $time_forms_date_table[] = array(
                                'forms_id' => $forms_id,
                                'date' => $this->input->post('focus_date'),
                                'day' => 1,
                                'time_to' => $time_to
                                );
                        }else{    
                            $time_forms_date_table[] = array(
                                'forms_id' => $forms_id,
                                'date' => $this->input->post('focus_date'),
                                'day' => 1,
                                'time_from' => $time_from,
                                'time_to' => $time_to
                                );
                        }
                    }else{ 
                        $time_forms_date_table = array(
                            'cancelled_comment' => $this->input->post('cancelled_comment') 
                            );
                    }
                    $days = 1;
                    $main_record[$this->mod->table]['date_from'] = $this->input->post('focus_date');
                    $main_record[$this->mod->table]['date_to'] = $this->input->post('focus_date');
                    $breakout = true;
                    break;
                    case 12://CWS
                    if($this->input->post('form_status_id') != 8){ 
                        $time_forms_date_table[] = array(
                            'forms_id' => $forms_id,
                            'date' => $dt->format('Y-m-d'),
                            'day' => 1
                            );
                    }else{
                        $time_forms_date_table = array(
                            'cancelled_comment' => $this->input->post('cancelled_comment') 
                            );
                    }
                    $days = 1;
                    break;
                }
                if($breakout === true) break;            
            
            
        }
        
        //day field not setup on module manager - value assignment
        $main_record[$this->mod->table]['day'] = $days;
        $main_record[$this->mod->table]['hrs'] = $hrs;
        //END get days count

        //SAVING START
        $transactions = true;
        if( $transactions )
        {
            $this->db->trans_begin();
        }

        //start saving with main table
        $record = $this->db->get_where( $this->mod->table, array( $this->mod->primary_key => $forms_id ) );
        // $record = $this->db->get_where( 'time_forms', array( 'forms_id' => $forms_id ) );
        if($this->input->post('form_status_id') != 8){
        switch( true )
        {
            case $record->num_rows() == 0:
                //add mandatory fields
            $main_record[$this->mod->table]['created_on'] = date('Y-m-d H:i:s');
            $this->db->insert($this->mod->table, $main_record[$this->mod->table]);
            if( $this->db->_error_message() == "" )
            {
                $forms_id = $this->record_id = $this->db->insert_id();
            }
            break;
            case $record->num_rows() == 1:
                // $main_record['modified_by'] = $this->user->user_id;
            $main_record[$this->mod->table]['modified_on'] = date('Y-m-d H:i:s');
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
        
        //start saving with sub table
        foreach( $main_record as $table => $data )
        {
            if($table == "time_forms_upload"){
                $this->db->delete($table, array( $this->mod->primary_key => $forms_id ) ); 
                if(!empty($data['upload_id'][0])){
                    $upload_ids = explode(',', $data['upload_id'][0]);
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
        }else{
            $this->db->update( 'time_forms_date', $time_forms_date_table, array( 'forms_id' => $forms_id) );
            $this->db->update( $this->mod->table, array( 'form_status_id' => $this->input->post('form_status_id')), array( 'forms_id' => $forms_id) );
        
            if( $this->db->_error_message() != "" ){
                $this->response->message[] = array(
                    'message' => $this->db->_error_message(),
                    'type' => 'error'
                    );
                $error = true;
                goto stop;
            }
        }
        
        if(!empty($forms_id)){
            $form_details = $this->mod->get_forms_details($forms_id);
            if($form_details['form_status_id'] == 2 || $form_details['form_status_id'] == 8){
                //INSERT NOTIFICATIONS FOR APPROVERS
                $this->load->model('form_application_model');
                $this->response->notified = $this->form_application_model->notify_approvers( $form_id, $form_details );
                $this->response->notified = $this->form_application_model->notify_filer( $form_id, $form_details );
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

       if( !$error )
       {
        $this->response->month = date('m', strtotime($date_from));
        $this->response->year = date('Y', strtotime($date_from));
        $this->response->forms_id = $forms_id;
        $this->response->saved = true; 
        $this->response->message[] = array(
            'message' => $this->input->post('forms_title').' was successfully saved.',
            'type' => 'success'
            );
    }

    $this->_ajax_return();
}

function get_selected_dates(){

    $this->_ajax_only();

    $selected_dates = array();
    if($this->input->post('forms_id')){
        $selected_dates = $this->mod->get_selected_dates($this->input->post('forms_id'));
    }
    $data['duration'] = $this->mod->get_duration();
    $days = 0;

    $date_from = date('Y-m-d', strtotime($this->input->post('date_from'))); 
    $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));

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

        $rest_days= array();
        foreach($period as $dt) {
            $forms_rest_day = $this->mod->check_if_rest_day($this->user->user_id, $dt->format('Y-m-d'));
            foreach($forms_rest_day as $forms_rest){
                $rest_days[] = $forms_rest['rest_day'];
            }
        }

    foreach($period as $dt) {
        $form_holiday = array();
        $form_holiday = $this->mod->check_if_holiday($dt->format('Y-m-d'), $this->user->user_id);
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

    $data['days'] = $days;
    $data['dates'] = $dates;
    $data['duration'] = $this->mod->get_duration();
    $data['disabled'] = $this->input->post('form_status_id')> 2 ? "disabled" : "";

    $view['content'] = $this->load->view('edit/change_date', $data, true);

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
            $this->response->days = $maternity_details['leave_days'];
        }

        $this->_ajax_return();
    }

