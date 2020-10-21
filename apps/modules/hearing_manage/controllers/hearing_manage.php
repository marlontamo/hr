<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hearing_manage extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('hearing_manage_model', 'mod');
		parent::__construct();
        $this->lang->load('hearing_admin');
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

        $this->load->model('hearing_model', 'hearing_per');
        $data['hearing_report'] = isset($permission[$this->hearing_per->mod_code]['list']) ? $permission[$this->hearing_per->mod_code]['list'] : 0;
        $data['hearing_manage'] = isset($this->permission['list']) ? $this->permission['list'] : 0;
        $this->load->model('hearing_admin_model', 'hearing_ad');
        $data['hearing_admin'] = isset($permission[$this->hearing_ad->mod_code]['list']) ? $permission[$this->hearing_ad->mod_code]['list'] : 0;
     
        $this->load->vars($data);        
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }

    function save()
    {
        $validation_rules[] = 
        array(
            'field' => 'partners_incident_nte[hearing_date]',
            'label' => 'Date of Hearing',
            'rules' => 'required'
            );

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

        $_POST['partners_incident']['incident_status_id'] = $_POST['incident_status_id'];
        unset($_POST['incident_status_id']);

        $nte_record = $_POST['partners_incident_nte'];
        unset($_POST['partners_incident_nte']);

        switch ($_POST['partners_incident']['incident_status_id']){
            case 6:
                $saved_message = 'saved and/or updated';
                $_POST['partners_incident']['status'] = 'Close';
            break;
            case 10:
                $saved_message = 'set hearing schedule';
            break;
            case 11:
                $saved_message = 'forwarded for disciplinary action';
            break;
        }

        //NTE
        $checkNTE = false;
        $incident_nte = array();
        $incident_to_email = array();
        $involve_info = '';        
        switch($_POST['partners_incident']['incident_status_id']){
            case 10:
                $checkNTE = true;
                $incidents = $this->db->get_where($this->mod->table, array($this->mod->primary_key => $_POST['record_id']))->row_array();
                $nte= array('hearing_partner', 'hearing_immediate', 'hearing_witnesses', 'hearing_complainants', 'hearing_others');
                $ntes= $_POST['partners_incident'];
                foreach($nte as $value){
                    if(array_key_exists($value, $ntes)){
                        $checkNTE = false;
                    }
                    if(isset($_POST['partners_incident'][$value])){
                        $_POST['partners_incident'][$value] = 1;
                        switch($value){
                            case 'hearing_partner':
                                $users = explode(',', $incidents['involved_partners']);
                                foreach($users as $user){
                                    $incident_nte['partners_incident_hearing']['category'][] = 'partner';
                                    $incident_nte['partners_incident_hearing']['user_id'][] = $user;
                                }
                            break;
                            case 'hearing_immediate':
                                $users = explode(',', $incidents['involved_partners']);
                                foreach($users as $user){
                                    $incident_nte['partners_incident_hearing']['category'][] = 'immediate';
                                    $users_data = $this->db->get_where( 'users_profile', array( 'user_id' => $user ) )->row_array();   
                                    $incident_nte['partners_incident_hearing']['user_id'][] = $users_data['reports_to_id'];
                                }
                            break;
                            case 'hearing_witnesses':
                                $users = explode(',', $incidents['witnesses']);
                                foreach($users as $user){
                                    if(!in_array($user, $incident_nte['partners_incident_hearing']['user_id'])){
                                        $incident_nte['partners_incident_hearing']['category'][] = 'witness';
                                        $incident_nte['partners_incident_hearing']['user_id'][] = $user;
                                    }
                                }
                            break;
                            case 'hearing_complainants':
                                $users = explode(',', $incidents['complainants']);
                                foreach($users as $user){
                                    if(!in_array($user, $incident_nte['partners_incident_hearing']['user_id'])){
                                        $incident_nte['partners_incident_hearing']['category'][] = 'complainants';
                                        $incident_nte['partners_incident_hearing']['user_id'][] = $user;
                                    }
                                }
                            break;
                            case 'hearing_others':
                                $users = $_POST['partners_incident']['hearing_others-temp'];
                                if ($users){
                                    foreach($users as $user){
                                        $incident_nte['partners_incident_hearing']['category'][] = 'others';
                                        $incident_nte['partners_incident_hearing']['user_id'][] = $user;
                                    }
                                }
                            break;
                        }
                    }else{
                        $_POST['partners_incident'][$value] = 0;
                    }
                }
                $saved_message = 'updated for NTE';
            break;            
        }

        parent::save( true );
        
        $nte_records = array();
        $hearing_date = '';
        $involved_employee = '';
        if( $this->response->saved )
        {
            // saving of hearing invited
            $setNTE[$this->mod->primary_key] = $this->record_id;
            foreach($incident_nte as $key => $value) {       
                $this->db->delete($key, array( $this->mod->primary_key => $this->record_id ));
                foreach($value['category'] as $index => $inserts){
                    $setNTE['user_id'] = $value['user_id'][$index];
                    $setNTE['category'] = $inserts;
                    $this->db->insert($key, $setNTE);
                }
                // $this->db->insert( $key, $value, array( $this->mod->primary_key => $this->record_id, 'user_id' => $this->user->user_id ) );
                $this->response->action = 'insert';
            }

            //$this->db->update('partners_incident',array('hr_remarks' => $nte_record['hr_remarks']),array('incident_id' => $this->record_id));

            $nte_record['hearing_date'] = date('Y-m-d H:i:s', strtotime(str_replace(' - ', ' ', $nte_record['hearing_date'])));
            $this->db->update( 'partners_incident_hearing', $nte_record, array( $this->mod->primary_key => $this->record_id ) );
            $this->response->action = 'update';

            if( in_array($_POST['partners_incident']['incident_status_id'], array(10)) ){
                $get_nte = $this->db->get_where( 'partners_incident_hearing', array( $this->mod->primary_key => $this->record_id) )->result_array();
                foreach($get_nte as $index => $value){
                    //INSERT NOTIFICATIONS FOR NTE
                    $incident_details[$this->mod->primary_key] = $this->record_id;
                    $incident_details['user_id'] = $value['user_id'];
                    $incident_details['hearing_date'] = $value['hearing_date'];
                    $this->response->notified = $this->mod->notify_nte( $this->record_id, $incident_details );
                    $hearing_date = $value['hearing_date'];
                    array_push($nte_records, $value['user_id']);

                    if ($value['category'] == 'partner'){
                        $this->db->where('user_id',$value['user_id']);
                        $involve_employee_result = $this->db->get('users');   
                        if ($involve_employee_result && $involve_employee_result->num_rows() > 0){
                            $involved_employee = $involve_employee_result->row()->full_name;
                        }
                    }
                }

                array_unique($nte_records);

                $this->db->where_in('user_id',$nte_records);
                $result1 = $this->db->get('users');              

                if ($result1 && $result1->num_rows() > 0){
                    foreach ($result1->result() as $row) {
                        $qry = "CALL sp_partners_ir_hearing_schedule_email('".$row->full_name."','".$row->email."','".$involved_employee."','".$hearing_date."');";
                        $result2 = $this->db->query( $qry );
                    }
                }    

                switch ($this->mod->coc_process) {
                    case 'immediate':
                        $this->response->notified = $this->mod->notify_hr( $this->record_id, $incident_details );
                        break;
                }

            }
        }

        $this->response->message[] = array(
            'message' => "Record successfully {$saved_message}.",
            'type' => 'success'
        );

        $this->_ajax_return();
    }

    function _list_options_active( $record, &$rec )
    {
        //temp remove until view functionality added
        if( $this->permission['detail'] )
        {
            $rec['detail_url'] = $this->mod->url . '/detail/' . $record['record_id'];
            $rec['options'] .= '<li><a href="'.$rec['detail_url'].'"><i class="fa fa-info"></i> View</a></li>';
        }

        if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
        {
            $rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
            $rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
        }   
        
        if( isset($this->permission['delete']) && $this->permission['delete'] )
        {
            $rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
            $rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
        }
    }

    public function detail( $record_id, $child_call = false )
    {
        if( !$this->permission['detail'] )
        {
            echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
            die();
        }

        $this->_detail( $child_call );
    }

    private function _detail( $child_call )
    {
        if( !$this->_set_record_id() )
        {
            echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
            die();
        }

        $this->record_id = $data['record_id'] = $_POST['record_id'];
        
        $record_check = $this->mod->_exists( $this->record_id );
        if( $record_check === true )
        {
            $result = $this->mod->_get( 'detail', $this->record_id );            
            $data['record'] = $result->row_array();
            $data['coc_process'] = $this->mod->coc_process;
            $immediate_remarks = '';
            $immediate_full_name = '';
            $this->db->join('users','partners_incident_immediate.user_id = users.user_id','left');
            $immediate_remarks_result = $this->db->get_where('partners_incident_immediate',array('incident_id' => $this->record_id));
            if ($immediate_remarks_result){
                $immediate_remarks_row = $immediate_remarks_result->row();
                $immediate_remarks = $immediate_remarks_row->comment;
                $immediate_full_name = $immediate_remarks_row->full_name;
            }   

            switch ($this->mod->coc_process) {
                case 'immediate':

                    $data['record']['immediate_explanation']['explanation'] = $immediate_remarks;
                    $data['record']['immediate_explanation']['full_name'] = $immediate_full_name;

                    $get_involved = $this->db->get_where( 'partners_incident_nte', array( $this->mod->primary_key => $this->record_id, 'category' => 'partner') )->row_array();
                    $data['record']['involved_explanation'] = $get_involved;

                    $wquery = "SELECT inte.*, users.full_name FROM {$this->db->dbprefix}partners_incident_nte inte
                                LEFT JOIN users ON inte.user_id = users.user_id AND inte.category IN ('witness', 'others')
                                WHERE inte.{$this->mod->primary_key} = {$this->record_id} 
                                AND inte.category IN ('witness', 'others')"; 
                    $get_witnesses = $this->db->query( $wquery )->result_array();
                    $data['record']['witnesses_explanation'] = $get_witnesses;

                    $other_hearing = $this->db->get_where('partners_incident_hearing', array($this->mod->primary_key => $this->record_id, 'category' => 'others'))->result_array();

                    $hearing_others = array();
                    foreach($other_hearing as $value){
                        $hearing_others[] = $value['user_id'];
                    }
                    if(count($hearing_others) > 0){
                        $data['record']['hearing_others-temp'] = implode(',', $hearing_others);   
                    }else{                
                        $data['record']['hearing_others-temp'] = null;
                    }
                    break;
                default:          
                    $iquery = "SELECT inte.*, users.full_name FROM {$this->db->dbprefix}partners_incident_nte inte
                                LEFT JOIN users ON inte.user_id = users.user_id AND inte.category IN ('immediate')
                                WHERE inte.{$this->mod->primary_key} = {$this->record_id} 
                                AND inte.category IN ('immediate')"; 
                    $get_immediate = $this->db->query( $iquery )->row_array();


                    // $get_immediate = $this->db->get_where( 'partners_incident_nte', array( $this->mod->primary_key => $this->record_id, 'category' => 'immediate') )->row_array();
                    $data['record']['immediate_explanation'] = $get_immediate;

                    $get_involved = $this->db->get_where( 'partners_incident_nte', array( $this->mod->primary_key => $this->record_id, 'category' => 'partner') )->row_array();
                    $data['record']['involved_explanation'] = $get_involved;

                    $wquery = "SELECT inte.*, users.full_name FROM {$this->db->dbprefix}partners_incident_nte inte
                                LEFT JOIN users ON inte.user_id = users.user_id AND inte.category IN ('witness', 'others')
                                WHERE inte.{$this->mod->primary_key} = {$this->record_id} 
                                AND inte.category IN ('witness', 'others')"; 
                    $get_witnesses = $this->db->query( $wquery )->result_array();
                    $data['record']['witnesses_explanation'] = $get_witnesses;
                    break;
            }

            $this->load->vars( $data );

            if( !$child_call ){
                if( !IS_AJAX )
                {
                    $this->load->helper('form');
                    $this->load->helper('file');
                    echo $this->load->blade('pages.detail')->with( $this->load->get_cached_vars() );
                }
                else{
                    $data['title'] = $this->mod->short_name .' - Detail';
                    $data['content'] = $this->load->blade('pages.quick_detail')->with( $this->load->get_cached_vars() );

                    $this->response->html = $this->load->view('templates/modal', $data, true);

                    $this->response->message[] = array(
                        'message' => '',
                        'type' => 'success'
                    );
                    $this->_ajax_return();
                }
            }
        }
        else
        {
            $this->load->vars( $data );
            if( !$child_call ){
                echo $this->load->blade('pages.error', array('error' => $record_check))->with( $this->load->get_cached_vars() );
            }
        }
    }
}