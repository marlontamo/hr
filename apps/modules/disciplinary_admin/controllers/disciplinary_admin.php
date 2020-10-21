<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Disciplinary_admin extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('disciplinary_admin_model', 'mod');
		parent::__construct();
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

        $this->load->model('disciplinary_model', 'disciplinary_per');
        $data['disciplinary_report'] = isset($permission[$this->disciplinary_per->mod_code]['list']) ? $permission[$this->disciplinary_per->mod_code]['list'] : 0;
        $this->load->model('disciplinary_manage_model', 'disciplinary_mng');
        $data['disciplinary_manage'] = isset($permission[$this->disciplinary_mng->mod_code]['list']) ? $permission[$this->disciplinary_mng->mod_code]['list'] : 0;
        $data['disciplinary_admin'] = isset($this->permission['list']) ? $this->permission['list'] : 0;

        $this->load->vars($data);        
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }

    function save()
    {
        $validation_rules_d[] = 
        array(
            'field' => 'partners_disciplinary_action[sanction_id]',
            'label' => 'Sanction',
            'rules' => 'required'
            );
        $validation_rules_d[] = 
        array(
            'field' => 'partners_disciplinary_action[remarks]',
            'label' => 'Sanction Remarks',
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

        $disciplinary = $_POST['partners_disciplinary_action'];
        unset($_POST['partners_disciplinary_action']);

        // if(isset($_POST['partners_incident']['involved_partners'])){
        //     $_POST['partners_incident']['involved_partners'] = implode(',', $_POST['partners_incident']['involved_partners']);
        // }else{
        //     $_POST['partners_incident']['involved_partners'] = null;
        // }

        // if(isset($_POST['partners_incident']['complainants'])){
        //     $_POST['partners_incident']['complainants'] = implode(',', $_POST['partners_incident']['complainants']);
        // }else{
        //     $_POST['partners_incident']['complainants'] = null;
        // }
        
        // if(isset($_POST['partners_incident']['witnesses'])){
        //     $_POST['partners_incident']['witnesses'] = implode(',', $_POST['partners_incident']['witnesses']);
        // }else{
        //     $_POST['partners_incident']['witnesses'] = null;
        // }

        // //closed if cancelled
        // if($_POST['partners_incident']['incident_status_id'] == 7){
        //     $_POST['partners_incident']['status'] = 'Close';
        //     $saved_message = 'cancelled';
        // }else{
        //     $_POST['partners_incident']['date_sent'] = date('Y-m-d H:i:s');
        //     $saved_message = 'saved and/or updated';
        // }

        $_POST['partners_incident']['incident_status_id'] = 6;
        unset($_POST['incident_status_id']);

        $_POST['partners_incident']['status'] = 'Close';
        $saved_message = 'served';

        if(isset($_POST['partners_incident']['complainants'])){
            $_POST['partners_incident']['complainants'] = implode(',', $_POST['partners_incident']['complainants']);
        }

        if(isset($_POST['partners_incident']['witnesses'])){
            $_POST['partners_incident']['witnesses'] = implode(',', $_POST['partners_incident']['witnesses']);
        }

        parent::save( true );
        if( $this->response->saved )
        {
            if($_POST['partners_incident']['incident_status_id'] == 2){          
                $populate_incident_approvers = "CALL sp_partners_incident_populate_approvers({$this->record_id}, {$_POST['partners_incident']['involved_partners']})";
                $result_update = $this->db->query( $populate_incident_approvers );
                mysqli_next_result($this->db->conn_id);
            }


            $da_email = array();
            $involve_employee = '';
            if($_POST['partners_incident']['incident_status_id'] == 6){ 
                $this->db->where('deleted',0);
                $this->db->where('incident_id',$this->record_id);
                $result_approver = $this->db->get('partners_incident_approver');
                if ($result_approver && $result_approver->num_rows() > 0){
                    $result_approver_row = $result_approver->row();
                    array_push($da_email ,$result_approver_row->user_id);
                }

                $this->db->where('incident_id',$this->record_id);
                $this->db->where_in('category',array("partner", "immediate"));
                $result_nte = $this->db->get('partners_incident_nte');
                if ($result_nte && $result_nte->num_rows() > 0){
                    foreach ($result_nte->result() as $row_nte) {
                        array_push($da_email ,$row_nte->user_id);

                        if ($row_nte->category == 'partner'){
                            $this->db->where('deleted',0);
                            $this->db->where('user_id',$row_nte->user_id);
                            $involve_employee_result = $this->db->get('users');
                            if ($involve_employee_result && $involve_employee_result->num_rows() > 0){
                                $involve_employee = $involve_employee_result->row()->full_name;
                            }
                        }
                    }
                } 

                $this->db->where_in('user_id',$da_email);
                $result1 = $this->db->get('users');              

                if ($result1 && $result1->num_rows() > 0){
                    foreach ($result1->result() as $row) {
                        $qry = "CALL sp_partners_ir_da_email('".$row->full_name."','".$row->email."','".$involve_employee."');";
                        $result2 = $this->db->query( $qry );
                    }
                }                                 
            }

            // $incident_details = $this->mod->get_incident_details($this->record_id);
            // if(in_array($_POST['partners_incident']['incident_status_id'], array(2,7))){
            //     //INSERT NOTIFICATIONS FOR APPROVERS
            //     $this->response->notified = $this->mod->notify_approvers( $this->record_id, $incident_details );
            //     $this->response->notified = $this->mod->notify_filer( $this->record_id, $incident_details );
            // }

            $disciplinary[$this->mod->primary_key] = $this->record_id; 
            $disciplinary['date_from'] = ($disciplinary['date_from'] != '') ? date('Y-m-d', strtotime($disciplinary['date_from'])) : '0000-00-00'; 
            $disciplinary['date_to'] = ($disciplinary['date_to'] != '') ? date('Y-m-d', strtotime($disciplinary['date_to'])) : '0000-00-00';            
			$record = $this->db->get_where( 'partners_disciplinary_action', array( $this->mod->primary_key => $this->record_id ) );
			switch( true )
			{
				case $record->num_rows() == 0:
					//add mandatory fields
					$disciplinary['created_by'] = $this->user->user_id;
					$this->db->insert('partners_disciplinary_action', $disciplinary);
					if( $this->db->_error_message() == "" )
					{
						$this->response->record_id = $this->db->insert_id();
					}
					$this->response->action = 'insert';
					break;
				case $record->num_rows() == 1:
					$disciplinary['modified_by'] = $this->user->user_id;
					$disciplinary['modified_on'] = date('Y-m-d H:i:s');
					$this->db->update( 'partners_disciplinary_action', $disciplinary, array( $this->mod->primary_key => $this->record_id ) );
					$this->response->action = 'update';
					break;
				default:
					$this->response->message[] = array(
						'message' => lang('common.inconsistent_data'),
						'type' => 'error'
					);
        			$this->_ajax_return();
			}

            $incident_details[$this->mod->primary_key] = $this->record_id;
      
            $this->response->notified = $this->mod->notify_involved_immediate( $this->record_id, $incident_details );
        
            $this->response->message[] = array(
                'message' => "Record was successfully {$saved_message}.",
                'type' => 'success'
            );
        }
        // else{            
        //     $this->response->message[] = array(
        //         'message' => $this->db->_error_message().'error here',
        //         'type' => 'error'
        //     );
        // }

        $this->_ajax_return();
    }

    function print_disciplinary()
    {

        $this->_ajax_only();
        $user = $this->config->item('user');

        $this->load->library('PDFm');
        $mpdf = new PDFm();

        $mpdf->SetTitle( 'Employee Incident Report' );
        $mpdf->SetAutoPageBreak(true, 1);
        $mpdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $mpdf->SetDisplayMode('real', 'default');
        $mpdf->AddPage();

        // template data
        $record_id = $this->input->post('record_id');
        $disciplinary_record = $this->db->get_where( $this->mod->table, array( $this->mod->primary_key => $record_id) );
        $disciplinary_record = $disciplinary_record->row_array();


        $partner_record = "SELECT 
                            CASE WHEN (uc.print_logo = '' AND COALESCE(uc.print_logo,0) != 0 ) THEN conf.value ELSE uc.print_logo END AS print_logo,
                              i.date_time_of_offense,
                              i.location,
                              i.violation_details,
                              i.damages,
                              u.full_name AS 'involved_employee',
                              upos.position,
                              o.offense,
                              complainants.full_name AS 'complainants',
                              immediate_approver.full_name AS 'incident_approver',
                              upos_approver.position AS 'position_involved_approver',
                              sanc.sanction,
                              dis_act.date_from AS 'susp_date_from',
                              dis_act.date_to AS 'susp_date_to',
                              sanc_categ.offense_sanction_category AS 'sanc_category'
                            FROM
                              ww_partners_incident i 
                              LEFT JOIN ww_users u 
                                ON u.user_id = i.involved_partners 
                              LEFT JOIN ww_users complainants 
                                ON complainants.user_id = i.complainants 
                              LEFT JOIN ww_partners_offense o 
                                ON o.offense_id = i.offense_id 
                              INNER JOIN ww_users_profile up 
                                ON up.user_id = u.user_id 
                              INNER JOIN ww_users_company uc 
                                ON up.company_id = uc.company_id 
                              LEFT JOIN ww_users_department ud 
                                ON up.department_id = ud.department_id 
                              LEFT JOIN ww_users_position upos 
                                ON up.position_id = upos.position_id 
                              LEFT JOIN ww_partners_incident_approver approver 
                                ON approver.`incident_id` = i.`incident_id` 
                              LEFT JOIN ww_partners_incident_immediate pii 
                                ON pii.`incident_id` = i.`incident_id`  
                              LEFT JOIN ww_users immediate_approver 
                                ON immediate_approver.user_id = pii.user_id   
                              LEFT JOIN ww_users_profile up_approver 
                                ON up_approver.user_id = immediate_approver.user_id 
                              LEFT JOIN ww_users_position upos_approver 
                                ON up_approver.position_id = upos_approver.position_id                                                                                              
/*                              LEFT JOIN ww_users incident_approver 
                                ON incident_approver.user_id = approver.user_id */
/*                              LEFT JOIN ww_users_profile up_approver 
                                ON up_approver.user_id = approver.user_id 
                              LEFT JOIN ww_users_position upos_approver 
                                ON up_approver.position_id = upos_approver.position_id */
                              LEFT JOIN ww_partners_disciplinary_action dis_act  
                                ON dis_act.incident_id = i.`incident_id` 
                              LEFT JOIN ww_partners_offense_sanction sanc 
                                ON sanc.`sanction_id` = dis_act.`sanction_id`
                              LEFT JOIN ww_partners_offense_sanction_category sanc_categ 
                                ON sanc.`sanction_category_id` = sanc_categ.`offense_sanction_category_id`, ww_config conf                                
                            WHERE conf.key = 'print_logo' AND i.incident_id = {$record_id} ";
        $partner_record = $this->db->query($partner_record)->row_array();

        $template_data['logo'] = base_url().$partner_record['print_logo'];
        $template_data['involved_employee'] = $partner_record['involved_employee'];
        $template_data['involved_employee_position'] = $partner_record['position'];
        $template_data['incident'] = $partner_record['offense'];
        $template_data['date_of_offense'] = date('F d, Y', strtotime($partner_record['date_time_of_offense']));
        $template_data['time_of_offense'] = date("h:i a",strtotime($partner_record['date_time_of_offense']));
        $template_data['location'] = $partner_record['location'];
        $template_data['incident_approver'] = $partner_record['incident_approver'];
        $template_data['position_involved_approver'] = $partner_record['position_involved_approver'];
        $template_data['violation_details'] = $partner_record['violation_details'];
        $template_data['damages'] = $partner_record['damages'];
        $template_data['sanction'] = $partner_record['sanction'];
        $template_data['susp_date_from'] = ($partner_record['susp_date_from'] != '' && $partner_record['susp_date_from'] != '0000-00-00' && $partner_record['susp_date_from'] != '1970-01-01') ? date('M d, Y',strtotime($partner_record['susp_date_from'])): '';
        $template_data['susp_date_to'] = ($partner_record['susp_date_to'] != '' && $partner_record['susp_date_to'] != '0000-00-00' && $partner_record['susp_date_to'] != '1970-01-01') ? date('M d, Y',strtotime($partner_record['susp_date_to'])): '';
        switch ($partner_record['sanc_category']) {
            case 'Verbal Warning':
                $template_data['v_action'] = "checked='true'";
                $template_data['w_action'] = " ";
                $template_data['p_action'] = " ";
                $template_data['s_action'] = " ";
                $template_data['d_action'] = " ";
                $template_data['o_action'] = " ";
                break;
            case 'Written Warning':
                $template_data['w_action'] = "checked='true'";
                $template_data['v_action'] = " ";
                $template_data['p_action'] = " ";
                $template_data['s_action'] = " ";
                $template_data['d_action'] = " ";
                $template_data['o_action'] = " ";
                break;
            case 'Probation':
                $template_data['p_action'] = "checked='true'";
                $template_data['v_action'] = " ";
                $template_data['w_action'] = " ";
                $template_data['s_action'] = " ";
                $template_data['d_action'] = " ";
                $template_data['o_action'] = " ";
                break;
            case 'Suspension':
                $template_data['s_action'] = "checked='true'";
                $template_data['v_action'] = " ";
                $template_data['w_action'] = " ";
                $template_data['p_action'] = " ";
                $template_data['d_action'] = " ";
                $template_data['o_action'] = " ";
                break;
            case 'Dismissal':
                $template_data['d_action'] = "checked='true'";
                $template_data['v_action'] = " ";
                $template_data['w_action'] = " ";
                $template_data['p_action'] = " ";
                $template_data['s_action'] = " ";
                $template_data['o_action'] = " ";
                break;
            default:
                $template_data['v_action'] = " ";
                $template_data['w_action'] = " ";
                $template_data['p_action'] = " ";
                $template_data['s_action'] = " ";
                $template_data['d_action'] = " ";
                $template_data['o_action'] = "checked='true'";
                break;
        }

        $template_data['current_date'] = date("F d, Y");

        $this->load->helper('file');
        $this->load->library('parser');

        $template = $this->db->get_where( 'system_template', array( 'code' => 'EMPLOYEE-INCIDENT-REPORT', 'deleted' => 0) )->row_array();
        $this->parser->set_delimiters('{{', '}}');
        $html = $this->parser->parse_string($template['body'], $template_data, TRUE);

        $this->load->helper('file');
        $path = 'uploads/templates/disciplinary_form/';
        $this->check_path( $path );
        $filename = $path .$partner_record['involved_employee']."-".'EMPLOYEE INCIDENT REPORT' .".pdf";

        $mpdf->WriteHTML($html, 0, true, false);
        $mpdf->Output($filename, 'F');

        $this->response->filename = $filename;
        $this->response->message[] = array(
            'message' => 'File successfully loaded.',
            'type' => 'success'
        );
        $this->_ajax_return();
    }

    private function check_path( $path, $create = true )
    {
        if( !is_dir( FCPATH . $path ) ){
            if( $create )
            {
                $folders = explode('/', $path);
                $cur_path = FCPATH;
                foreach( $folders as $folder )
                {
                    $cur_path .= $folder;

                    if( !is_dir( $cur_path ) )
                    {
                        mkdir( $cur_path, 0777, TRUE);
                        $indexhtml = read_file( APPPATH .'index.html');
                        write_file( $cur_path .'/index.html', $indexhtml);
                    }

                    $cur_path .= '/';
                }
            }
            return false;
        }
        return true;
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

            // $other_nte = $this->db->get_where('partners_incident_nte', array($this->mod->primary_key => $this->record_id, 'category' => 'others'))->result_array();

            // foreach($other_nte as $value){
            //     $nte_others[] = $value['user_id'];
            // }

            // $data['record']['nte_others-temp'] = implode(',', $nte_others);

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
                // $data['record'] = $record;
            }

            $result = $this->mod->_get( 'detail', $this->record_id );    
            $detail_record = $result->row_array();
            $data['record'] = array_merge($record, $detail_record);

            $this->load->vars( $data );

            if( !$child_call ){
                $this->load->helper('form');
                $this->load->helper('file');
                echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
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