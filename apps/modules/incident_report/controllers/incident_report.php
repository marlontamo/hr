<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Incident_report extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('incident_report_model', 'mod');
		parent::__construct();
        $this->load->model('incident_manage_model', 'incident_per');        
        $this->load->model('incident_admin_model', 'incident_ad');
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

        $data['incident_manage'] = isset($permission[$this->incident_per->mod_code]['list']) ? $permission[$this->incident_per->mod_code]['list'] : 0;
        $data['incident_report'] = isset($this->permission['list']) ? $this->permission['list'] : 0;
        $data['incident_admin'] = isset($permission[$this->incident_ad->mod_code]['list']) ? $permission[$this->incident_ad->mod_code]['list'] : 0;
     
        $this->load->vars($data);        
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }

    public function add( $record_id = '', $child_call = false )
    {
        if( !$this->permission['add'] )
        {
            echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
            die();
        }

        $this->_edit( $child_call, true );
    }

    public function edit( $record_id = "", $child_call = false )
    {
        if( !$this->permission['edit'] )
        {
            echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
            die();
        }

        $this->_edit( $child_call );
    }

    private function _edit( $child_call, $new = false )
    {
        $record_check = false;
        $this->record_id = $data['record_id'] = '';

        if( !$new ){
            if( !$this->_set_record_id() )
            {
                echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
                die();
            }

            $this->record_id = $data['record_id'] = $_POST['record_id'];
        }
        
        $record_check = $this->mod->_exists( $this->record_id );
        if( $new || $record_check === true )
        {
            $result = $this->mod->_get( 'edit', $this->record_id );
            if( $new )
            {
                $field_lists = $result->list_fields();
                foreach( $field_lists as $field )
                {
                    $data['record'][$field] = '';
                }
            }
            else{
                $record = $result->row_array();
                foreach( $record as $index => $value )
                {
                    $record[$index] = trim( $value );   
                }
                $data['record'] = $record;
            }

            $this->db->where('deleted', '0');
            $this->db->where('user_id', $this->user->user_id);
            $data['current_user'] = $this->db->get('users')->row(); 

            $this->load->vars( $data );

            if( !$child_call ){
                $this->load->helper('form');
                $this->load->helper('file');
                echo $this->load->blade('pages.edit_custom')->with( $this->load->get_cached_vars() );
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

    function save()
    {
        if(isset($_POST['partners_incident']['complainants'])){
            $_POST['partners_incident']['complainants'] = implode(',', $_POST['partners_incident']['complainants']);
        }else{
            $_POST['partners_incident']['complainants'] = null;
        }
        
        if(isset($_POST['partners_incident']['witnesses'])){
            $_POST['partners_incident']['witnesses'] = implode(',', $_POST['partners_incident']['witnesses']);
        }else{
            $_POST['partners_incident']['witnesses'] = null;
        }
        $_POST['partners_incident']['incident_status_id'] = $_POST['incident_status_id'];

        unset($_POST['incident_status_id']);

        //closed if cancelled
        if($_POST['partners_incident']['incident_status_id'] == 7){
            $_POST['partners_incident']['status'] = 'Close';
            $saved_message = 'cancelled';
        }else{
            $_POST['partners_incident']['date_sent'] = date('Y-m-d H:i:s');
            $saved_message = 'saved and/or updated';
        }

        parent::save( true );
        
        if( $this->response->saved )
        {
            if($_POST['partners_incident']['incident_status_id'] == 2){    
                switch ($this->mod->coc_process) {
                    case 'immediate':
                        $immediate = $this->mod->get_immediate($_POST['partners_incident']['involved_partners']);
                        $immediate_array = array(
                                'incident_id' => $this->record_id,
                                'user_id' => $immediate,
                                'incident_status_id' => 2
                            );
                        $this->db->insert('partners_incident_immediate',$immediate_array);

                        $complainant_info= '';
                        $this->db->where('user_id',$_POST['partners_incident']['complainants']);
                        $complainant_info_result = $this->db->get('users');
                        if ($complainant_info_result && $complainant_info_result->num_rows() > 0){
                            $complainant_info_row = $complainant_info_result->row();
                            $complainant_info = $complainant_info_row->full_name;
                        }

                        $this->db->where('user_id',$immediate);
                        $result1 = $this->db->get('users');
                        if ($result1 && $result1->num_rows() > 0){
                            $row1 = $result1->row();
                            $qry = "CALL sp_partners_ir_immediate_email('".$row1->full_name."','".$row1->email."','".$complainant_info."');";
                            $result2 = $this->db->query( $qry );
                        }                        
                        break;
                    default:
                        $populate_incident_approvers = "CALL sp_partners_incident_populate_approvers({$this->record_id}, {$_POST['partners_incident']['involved_partners']})";
                        $result_update = $this->db->query( $populate_incident_approvers );
                        mysqli_next_result($this->db->conn_id);                    
                        break;
                } 
            }

            $incident_details = $this->mod->get_incident_details($this->record_id);
            if(in_array($_POST['partners_incident']['incident_status_id'], array(2,7))){
                //INSERT NOTIFICATIONS FOR APPROVERS
                switch ($this->mod->coc_process) {
                    case 'immediate':
                        //$this->response->notified = $this->mod->notify_hr( $this->record_id, $incident_details );
                        $this->response->notified = $this->mod->notify_immediate( $this->record_id, $incident_details );
                        break;
                    default:
                        $this->response->notified = $this->mod->notify_approvers( $this->record_id, $incident_details );
                        $this->response->notified = $this->mod->notify_filer( $this->record_id, $incident_details );
                        break;
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

        // echo "<pre>";
        // print_r($data['record']);
        // exit();
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
        $this->load->vars( $vars );

        $data['title'] = 'Cancel Report';
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

        if( !$this->input->post('remarks') )
        {
            $this->response->message[] = array(
                'message' => lang('incident_report.remark_required'),
                'type' => 'warning'
            );

            $this->_ajax_return();    
        }

        $this->db->limit(1);
        $report = $this->db->get_where($this->mod->table, array($this->mod->primary_key => $this->input->post('record_id')))->row();
        
        if( $report->created_by != $this->user->user_id )
        {
            $this->response->message[] = array(
                'message' => lang('incident_report.cannot_cancel'),
                'type' => 'error'
            );

            $this->_ajax_return();   
        }

        $this->db->update( $this->mod->table, array('incident_status_id' => 7), array($this->mod->primary_key => $this->input->post('record_id')) );
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