<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Disciplinary_manage extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('disciplinary_manage_model', 'mod');
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
        $this->load->model('disciplinary_admin_model', 'disciplinary_mng');
        $data['disciplinary_admin'] = isset($permission[$this->disciplinary_mng->mod_code]['list']) ? $permission[$this->disciplinary_mng->mod_code]['list'] : 0;
        $data['disciplinary_manage'] = isset($this->permission['list']) ? $this->permission['list'] : 0;

        $this->load->vars($data);        
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }

    function save()
    {
        $_POST['partners_incident']['incident_status_id'] = $_POST['incident_status_id'];
        unset($_POST['incident_status_id']);

        $_POST['partners_incident']['status'] = 'Close';
        $saved_message = 'served';

        $validation_rules[] = 
        array(
            'field' => 'partners_disciplinary_action[sanction_id]',
            'label' => 'Sanction',
            'rules' => 'required'
            );
        $validation_rules[] = 
        array(
            'field' => 'partners_disciplinary_action[remarks]',
            'label' => 'Remarks',
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

        $disciplinary = $_POST['partners_disciplinary_action'];
        unset($_POST['partners_disciplinary_action']);
        // echo "<pre>";
        // // print_r($data['record']['nte_others-temp']);
        // print_r($_POST);
        // exit();
        parent::save( true );
        if( $this->response->saved )
        {
            $disciplinary[$this->mod->primary_key] = $this->record_id; 
            $disciplinary['date_from'] = date('Y-m-d', strtotime($disciplinary['date_from'])); 
            $disciplinary['date_to'] = date('Y-m-d', strtotime($disciplinary['date_to']));            
			$record = $this->db->get_where( 'partners_disciplinary_action', array( $this->mod->primary_key => $this->record_id ) );
			switch( true )
			{
				case $record->num_rows() == 0:
					//add mandatory fields
					$disciplinary['created_by'] = $this->user->user_id;
					$this->db->insert('partners_disciplinary_action', $disciplinary);
					if( $this->db->_error_message() == "" )
					{
						$this->response->record_id = $this->record_id = $this->db->insert_id();
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

            $incident_details = $this->mod->get_incident_details($this->record_id);
            
            switch ($this->mod->coc_process) {
                case 'immediate':
                    $this->response->notified = $this->mod->notify_hr( $this->record_id, $incident_details );
                    $this->response->notified = $this->mod->notify_involved( $this->record_id, $incident_details );
                    break;
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
            $involved_partners = $data['record']['involved_partners'];
            
            $da_tab = array();
            $da_qry = " SELECT  offense,offense_level,sanction,pda.created_on
                            FROM {$this->db->dbprefix}partners_disciplinary_action pda
                            LEFT JOIN {$this->db->dbprefix}partners_incident pi 
                                ON pda.incident_id = pi.incident_id 
                            LEFT JOIN {$this->db->dbprefix}partners_offense po 
                                ON pi.offense_id = po.offense_id                                                    
                            LEFT JOIN {$this->db->dbprefix}partners_offense_sanction pos 
                                ON pda.sanction_id = pos.sanction_id
                            LEFT JOIN {$this->db->dbprefix}partners_offense_level pol 
                                ON pos.offense_level_id = pol.offense_level_id 
                            WHERE pi.involved_partners IN ({$involved_partners})";
            $da_sql = $this->db->query($da_qry);

            if($da_sql->num_rows() > 0){
                $da_tab = $da_sql->result_array();
            }
            $data['da_tab'] = $da_tab;            

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
}