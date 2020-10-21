<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Incident_manage extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('incident_manage_model', 'mod');
        $this->load->model('incident_admin_model', 'incident_ad');  
        $this->load->model('incident_report_model', 'incident_per');              
		parent::__construct();
        $this->lang->load( 'incident_admin' );
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

        $data['incident_report'] = isset($permission[$this->incident_per->mod_code]['list']) ? $permission[$this->incident_per->mod_code]['list'] : 0;
        $data['incident_manage'] = isset($this->permission['list']) ? $this->permission['list'] : 0;
        $data['incident_admin'] = isset($permission[$this->incident_ad->mod_code]['list']) ? $permission[$this->incident_ad->mod_code]['list'] : 0;
     
        $this->load->vars($data);        
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }

    function save()
    {
        switch ($this->mod->coc_process) {
            case 'immediate':
                $validation_rules[] = 
                array(
                    'field' => 'partners_incident[immediate_remarks]',
                    'label' => 'Immediate Remarks',
                    'rules' => 'required'
                    );
                break;
            default:
                $validation_rules[] = 
                array(
                    'field' => 'partners_incident_approver[comment]',
                    'label' => 'Immediate Remarks',
                    'rules' => 'required'
                    );
                break;
        }

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

        if ($this->mod->coc_process != 'immediate'){
            $approvers_comment['partners_incident_approver'] = $_POST['partners_incident_approver'];
            unset($_POST['partners_incident_approver']);
        }

        //closed if served
        //NTE
        $checkNTE = false;
        $incident_nte = array();
        $incident_to_email = array();
        $involve_info = '';        
        switch($_POST['partners_incident']['incident_status_id']){
            case 3:
                $saved_message = 'saved and/or updated';
            break;
            case 4:
                $saved_message = lang('incident_manage.forwarded_hr');
                $approvers_comment['partners_incident_approver']['incident_status_id'] = 4;
            break;
            case 9:
                $checkNTE = true;
                $incidents = $this->db->get_where($this->mod->table, array($this->mod->primary_key => $_POST['record_id']))->row_array();
                $nte= array('nte_partner', 'nte_immediate', 'nte_witnesses', 'nte_complainants', 'nte_others');
                $ntes= $_POST['partners_incident'];
                foreach($nte as $value){
                    if(array_key_exists($value, $ntes)){
                        $checkNTE = false;
                    }
                    if(isset($_POST['partners_incident'][$value])){
                        $_POST['partners_incident'][$value] = 1;
                        switch($value){
                            case 'nte_partner':
                                $users = explode(',', $incidents['involved_partners']);
                                foreach($users as $user){
                                    $incident_nte['partners_incident_nte']['category'][] = 'partner';
                                    $incident_nte['partners_incident_nte']['user_id'][] = $user;
                                    array_push($incident_to_email,$user);

                                    $involve_result = $this->db->get_where('ww_users',array('user_id' => $user));
                                    if ($involve_result && $involve_result->num_rows() > 0){
                                        $involve_row = $involve_result->row();
                                        $involve_info = $involve_row->full_name;
                                    }
                                }
                            break;
                            case 'nte_immediate':
                                $users = explode(',', $incidents['involved_partners']);
                                foreach($users as $user){
                                    $incident_nte['partners_incident_nte']['category'][] = 'immediate';
                                    $users_data = $this->db->get_where( 'users_profile', array( 'user_id' => $user ) )->row_array();   
                                    $incident_nte['partners_incident_nte']['user_id'][] = $users_data['reports_to_id'];
                                }
                            break;
                            case 'nte_witnesses':
                                $users = explode(',', $incidents['witnesses']);
                                foreach($users as $user){
                                    if(!in_array($user, $incident_nte['partners_incident_nte']['user_id'])){
                                        $incident_nte['partners_incident_nte']['category'][] = 'witness';
                                        $incident_nte['partners_incident_nte']['user_id'][] = $user;
                                        array_push($incident_to_email,$user);
                                    }
                                }
                            break;
                            case 'nte_complainants':
                                $users = explode(',', $incidents['complainants']);
                                foreach($users as $user){
                                    if(!in_array($user, $incident_nte['partners_incident_nte']['user_id'])){
                                        $incident_nte['partners_incident_nte']['category'][] = 'complainants';
                                        $incident_nte['partners_incident_nte']['user_id'][] = $user;
                                        array_push($incident_to_email,$user);
                                    }
                                }
                            break;
                            case 'nte_others':
                                $users = $_POST['partners_incident']['nte_others-temp'];
                                if ($users){
                                    foreach($users as $user){
                                        $incident_nte['partners_incident_nte']['category'][] = 'others';
                                        $incident_nte['partners_incident_nte']['user_id'][] = $user;
                                        array_push($incident_to_email,$user);
                                    }
                                }
                            break;
                        }
                    }else{
                        $_POST['partners_incident'][$value] = 0;
                    }
                }
                if ($this->mod->coc_process == 'immediate'){
                    $immediate_remarks = $_POST['partners_incident']['immediate_remarks'];
                    $_POST['partners_incident']['hr_remarks'] = $immediate_remarks;
                }                
                $saved_message = 'updated for NTE';
            break;            
            case 6:
                if ($this->mod->coc_process == 'immediate'){
                    $immediate_remarks = $_POST['partners_incident']['immediate_remarks'];
                    $status_incident = $_POST['partners_incident']['incident_status_id'];
                    unset($_POST['partners_incident']);
                    $_POST['partners_incident']['status'] = 'Close';
                    $_POST['partners_incident']['incident_status_id'] = $status_incident;
                    $_POST['partners_incident']['hr_remarks'] = $immediate_remarks;
                    $saved_message = 'served';
                }
                else{
                    $_POST['partners_incident']['status'] = 'Close';
                    $saved_message = 'served';
                }
            break;
        }

        parent::save( true );
        
        if( $this->response->saved )
        {
            switch ($this->mod->coc_process) {
                case 'immediate':
                    $setNTE[$this->mod->primary_key] = $this->record_id;
                    foreach($incident_nte as $key => $value) {
                        $this->db->delete($key, array( $this->mod->primary_key => $this->record_id ));
                        foreach($value['category'] as $index => $inserts){
                            $setNTE['user_id'] = $value['user_id'][$index];
                            $setNTE['category'] = $inserts;
                            $this->db->insert($key, $setNTE);
                            if(in_array($_POST['partners_incident']['incident_status_id'], array(9))){
                                //INSERT NOTIFICATIONS FOR NTE
                                $incident_details[$this->mod->primary_key] = $this->record_id;
                                $incident_details['user_id'] = $value['user_id'][$index];
                                $this->response->notified = $this->incident_ad->notify_nte( $this->record_id, $incident_details );
                            }
                        }
                        // $this->db->insert( $key, $value, array( $this->mod->primary_key => $this->record_id, 'user_id' => $this->user->user_id ) );
                        $this->response->action = 'insert';
                    }

                    $this->db->update('partners_incident_immediate', array('incident_status_id' => 9,'comment' => $_POST['partners_incident']['hr_remarks']), array( $this->mod->primary_key => $this->record_id, 'user_id' => $this->user->user_id ) );
                    $this->response->action = 'update';
                    break;
                default:
                    foreach($approvers_comment as $key => $value) {
                        $this->db->update( $key, $value, array( $this->mod->primary_key => $this->record_id, 'user_id' => $this->user->user_id ) );
                        $this->response->action = 'update';
                    }
                    break;
            }

            $incident_details = $this->mod->get_incident_details($this->record_id);

            if(in_array($_POST['partners_incident']['incident_status_id'], array(4, 6))){
                //INSERT NOTIFICATIONS FOR APPROVERS
                switch ($this->mod->coc_process) {
                    case 'immediate':
                        # code...
                        break;
                    default:
                        $this->response->notified = $this->mod->notify_approvers( $this->record_id, $incident_details );
                        break;
                }
                $this->response->notified = $this->mod->notify_filer( $this->record_id, $incident_details );
                $this->response->notified = $this->mod->notify_hr( $this->record_id, $incident_details );
            }

            if ($_POST['partners_incident']['incident_status_id'] == 4){
                $this->db->where('deleted',0);
                $this->db->where('incident_id',$this->record_id);
                $result = $this->db->get('partners_incident');
                $immediate_compainant = array();

                if ($result && $result->num_rows() > 0){
                    $incident_data = $result->row();

                    array_push($immediate_compainant, $incident_data->complainants);

                    $users_data = $this->db->get_where( 'users_profile', array( 'user_id' => $incident_data->involved_partners ) )->row_array();   

                    array_push($immediate_compainant, $users_data['reports_to_id']);

                    $this->db->where_in('user_id',$immediate_compainant);
                    $result1 = $this->db->get('users');              

                    if ($result1 && $result1->num_rows() > 0){
                        foreach ($result1->result() as $row) {
                            $qry = "CALL sp_partners_ir_approver_approve_email('".$row->full_name."','".$row->email."');";
                            $result2 = $this->db->query( $qry );
                        }
                    }
                }
            }
            elseif ($_POST['partners_incident']['incident_status_id'] == 9) {
                if ($this->mod->coc_process == 'immediate'){
                    array_unique($incident_to_email);

                    $this->db->where_in('user_id',$incident_to_email);
                    $result1 = $this->db->get('users');              

                    if ($result1 && $result1->num_rows() > 0){
                        foreach ($result1->result() as $row) {
                            $qry = "CALL sp_partners_ir_nte_from_hr_email('".$row->full_name."','".$row->email."','".$involve_info."');";
                            $result2 = $this->db->query( $qry );
                        }
                    }   
                }
            }            
        }

        $this->response->message[] = array(
            'message' => "Record was successfully {$saved_message}.",
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

            if ($this->mod->coc_process == 'immediate'){
                $other_nte = $this->db->get_where('partners_incident_nte', array($this->mod->primary_key => $this->record_id, 'category' => 'others'))->result_array();

                $nte_others = array();
                foreach($other_nte as $value){
                    $nte_others[] = $value['user_id'];
                }
                if(count($nte_others) > 0){
                    $data['record']['nte_others-temp'] = implode(',', $nte_others);   
                }else{                
                    $data['record']['nte_others-temp'] = null;
                }
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

    function get_cancel_form()
    {
        $this->_ajax_only();

        $vars['record_id'] = $this->input->post('record_id');
        $vars['comment'] = $this->input->post('partners_incident_approver');
        $this->load->vars( $vars );

        $data['title'] = 'Close Report';
        $data['content'] = $this->load->blade('edit/cancel_form')->with( $this->load->get_cached_vars() );
       
        $this->response->cancel_form = $this->load->view('templates/modal', $data, true);
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();   
    }

    function cancel_report()
    {
        $this->_ajax_only();

        $this->response->saved = false;

        $comment = $this->input->post('comment');

        if( !$this->input->post('remarks') )
        {
            $this->response->message[] = array(
                'message' => lang('incident_manage.remark_required'),
                'type' => 'warning'
            );

            $this->_ajax_return();    
        }

        $this->db->limit(1);

        $this->db->update( $this->mod->table, array('incident_status_id' => 7, 'status' => 'Close', 'cancel_remarks' => $this->input->post('remarks')), array($this->mod->primary_key => $this->input->post('record_id')) );
        $this->db->update( $this->mod->table_ir , array('incident_status_id' => 7, 'comment' => $comment), array('incident_id' => $this->input->post('record_id')) );
        
        $incident_details = $this->mod->get_incident_details($this->input->post('record_id'));
        
        $notif1 = $this->mod->notify_approvers( $this->input->post('record_id'), $incident_details );
        $notif2 = $this->mod->notify_filer( $this->input->post('record_id'), $incident_details );
        $this->response->notify = array_merge($notif1, $notif2);

        $this->response->saved = true;
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();   
    }
}