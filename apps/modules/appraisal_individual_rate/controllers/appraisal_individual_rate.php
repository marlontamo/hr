<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Appraisal_individual_rate extends MY_PrivateController
{
    private $current_user = array();

	public function __construct()
	{
		$this->load->model('appraisal_individual_rate_model', 'mod');
        $this->load->model('performance_appraisal_admin_model', 'mod_admin');
		parent::__construct();
        $this->current_user = $this->config->item('user');
	}


    public function index()
    {
        if( !$this->permission['list'] )
        {
            echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
            die();
        }
        
        $permission = parent::_check_permission('performance_appraisal_manage');
        $data['allow_manage'] = $permission['list'];
        $permission = parent::_check_permission('performance_appraisal');
        $data['allow_admin'] = $permission['list'];

        $this->load->vars($data);
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }

    function get_observations()
    {
        $this->_ajax_only();
        
        $vars = $_POST;
        $vars['user_id'] = $_POST['user_id'];
        $vars['hidden'] = "";
        if($this->user->user_id == $vars['user_id']){
            $vars['hidden'] = "hidden";
        }
        $vars['observations'] = $this->mod->get_observations($_POST['performance_appraisal_year'], $_POST['user_id']);
        $this->load->vars($vars);

        $data['title'] = $_POST['fullname'].
        '<br><span class="text-muted">'.$_POST['performance_appraisal_year'].' Observations and Feedbacks</span>';
        $data['content'] = $this->load->blade('edit.observations')->with( $this->load->get_cached_vars() );

        $this->response->notes = $this->load->view('templates/modal', $data, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

    public function submitObservation(){

        $this->_ajax_only();
        $data = array();

        $this->load->model('dashboard_model', 'dashboard_mod');

        $data['current_user']   = $this->session->userdata['user']->user_id;
        $data['user_id']        = $this->session->userdata['user']->user_id;                                // THE CURRENT LOGGED IN USER 
        $data['display_name']   = $this->current_user['lastname']. ", ". $this->current_user['firstname'];  // THE CURRENT LOGGED IN USER'S DISPLAY NAME
        $data['feed_content']   = mysqli_real_escape_string($this->db->conn_id, $_POST['observation_message']);     // THE MAIN FEED BODY
        $data['recipient_id']   = '0';                                                                      // TO WHOM THIS POST IS INTENDED TO
        $data['status']         = 'info';                                                                   // DANGER, INFO, SUCCESS & WARNING
        
        $data['recipients'] =  $this->input->post('user_id') === '' ? array() : explode(',', $this->input->post('user_id'));
        $data['to']             = 'user'; // TODO: change this when division is okay!!!

        if( count( $data['recipients'] ) == 0 ){
            $data['recipient_id'] = $data['user_id'];
        }

        if( !in_array( $data['user_id'], $data['recipients']) )
        {
            $data['recipients'][] = $data['user_id'];
        }   

        // NOW SAVE THE POSTED DATA AND GET THE INSERT ID
        $data['message_type'] = $this->input->post('message_type');
        $latest = $this->dashboard_mod->newPostData($data);
        $this->response->target = $latest;

        // SAVE RECIPIENTS
        if(count($data['recipients']) > 0){
            $recipients_result = $this->dashboard_mod->saveRecipients($latest, $data['to'], $data['recipients']);
        }

        // GET LATEST POSTED DATA AND RETURN IT BACK TO THE UI
        $dept_qry = " SELECT ud.department 
                    FROM {$this->db->dbprefix}users_profile up
                    LEFT JOIN {$this->db->dbprefix}users_department ud on ud.department_id = up.department_id 
                    WHERE up.user_id = {$data['user_id']}";
        $dept = $this->db->query($dept_qry)->row_array();

        $data['department']             = $dept['department'];
        $data['observations']           = $this->dashboard_mod->getLatestPostData($latest, $data['user_id'] );
        $this->response->new_feedback   = $this->load->view('customs/observation_display', $data, true);
        
        // NOW TELL THESE RECIPIENTS THEY'VE GOT SOMETHING!
        $this->response->recipients = $data['recipients'];
        $this->response->action         = 'insert';
        // determines to where the action was 
        // performed and used by after_save to
        // know which notification to broadcast
        $this->response->type           = 'feed';

        $this->response->message[] = array(
            'message' => 'Feedback successfully added.',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

    public function edit( $record_id, $user_id )
    {
        parent::edit('', true);
        $this->after_edit_parent( $user_id );
    }

    public function after_edit_parent( $user_id )
    {
        $vars['manager_id'] ='';
        $appraisee = $vars['appraisee'] = $this->mod->get_appraisee( $this->record_id, $user_id );
        $this->load->model('performance_appraisal_manage_model', 'pam');
        $vars['self_review'] = $this->pam->get_self_review( $this->record_id, $user_id );
        if( $vars['appraisee']->user_id != $this->user->user_id && $vars['appraisee']->to_user_id != $this->user->user_id )
        {
            echo $this->load->blade('pages.not_under_attention')->with( $this->load->get_cached_vars() );
            die();
        }

        $this->load->model('appraisal_template_model', 'template');
        $vars['template'] = $this->template;
        $vars['templatefile'] = $this->template->get_template( $appraisee->template_id ); 

        $vars['approversLog'] = array();
        $approvers_log = "SELECT IF(ppar.display_name='', CONCAT(usp.lastname,' ',usp.firstname), ppar.display_name) AS display_name, 
                        ppl.created_on, ppap.user_id, pstat.performance_status, REPLACE(pstat.class, 'btn', 'badge') as class, pos.position, ppap.to_user_id, ppar.approver_id  
                        FROM {$this->db->dbprefix}performance_appraisal_applicable ppap 
                        INNER JOIN {$this->db->dbprefix}performance_appraisal_approver ppar ON ppap.appraisal_id = ppar.appraisal_id 
                        AND ppap.user_id = ppar.user_id 
                        INNER JOIN {$this->db->dbprefix}users_profile usp ON ppar.approver_id = usp.user_id
                        INNER JOIN {$this->db->dbprefix}users_position pos ON usp.position_id = pos.position_id
                        INNER JOIN {$this->db->dbprefix}performance_status pstat ON ppar.performance_status_id = pstat.performance_status_id 
                        LEFT JOIN {$this->db->dbprefix}performance_appraisal_logs ppl ON ppap.appraisal_id = ppl.appraisal_id 
                        AND ppap.user_id = ppl.user_id AND ppar.approver_id = ppl.to_user_id 
                        WHERE ppap.appraisal_id = {$appraisee->appraisal_id} AND ppap.user_id = {$appraisee->user_id} GROUP BY ppar.approver_id ORDER BY ppl.id ";

        $approversLog = $this->db->query($approvers_log);
        if( $approversLog->num_rows() > 0 ){
            $vars['approversLog'] = $approversLog->result_array();
        }

        $this->load->vars( $vars );

        $this->load->helper('form');
        $this->load->helper('file');
        
        if( $vars['appraisee']->status_id > 1 )
        {
            echo $this->load->blade('pages.review')->with( $this->load->get_cached_vars() );
        }
        else{
            echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
        }
    }

    function get_section_items()
    {
        $this->_ajax_only();
        
        $appraisee = $this->mod->get_appraisee( $this->input->post('appraisal_id'), $this->input->post('user_id') );
        $this->load->model('performance_appraisal_manage_model', 'pam');
        $vars['self_review'] = $this->pam->get_self_review( $this->record_id, $this->input->post('user_id') );
        $this->db->limit(1);
        $section = $this->db->get_where('performance_template_section', array('template_section_id' => $_POST['section_id']))->row();

        switch( $appraisee->status_id )
        {
            case 6:
                $folder = "summary";
                break;
            case 0:
            case 1:
            case 3:
                $folder = 'edit';
                break;    
            default:
                $folder = 'review';
        }

        $this->response->items = "";
        switch($section->section_type_id)
        {
            case 2:
                $this->response->items = $this->load->view($folder.'/items_balancescorecard', $_POST, true);
                break;
            case 4:
                $this->response->items = $this->load->view($folder.'/items_library_crowd', $_POST, true);
                break;
        }

        $this->response->section_id = $_POST['section_id'];
        $this->response->close_modal = true;

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();      
    }

    function change_status( $return = false )
    {
        $this->_ajax_only();
        
        $this->db->trans_begin();
        $error = false;

        $appraisee = $this->mod->get_appraisee( $_POST['appraisal_id'], $_POST['user_id'] );      
        $status_id = $this->input->post('status_id');
        
        //get approvers
        $where = array(
            'appraisal_id' => $this->input->post('appraisal_id'),
            'user_id' => $this->input->post('user_id'),
        );
        $this->db->order_by('sequence');
        $approvers = $this->db->get_where('performance_appraisal_approver', $where)->result();

        $appraisal_other_info = isset($_POST['individual_appraisal']) ? $_POST['individual_appraisal'] : array();

        $this->response->redirect = false;
        $this->load->model('system_feed');
        switch( $status_id )
        {
            case 1:
                $update_data = array('status_id' => 1);
                //get previous data for audit logs
                $where_array = array( 'appraisal_id' => $this->input->post('appraisal_id'), 'user_id' => $this->input->post('user_id'));
                $previous_main_data = $this->db->get_where('performance_appraisal_applicable', $where_array)->row_array();
                $this->db->update('performance_appraisal_applicable', $update_data, $where_array);
                $this->response->redirect = false;
                break;
            case 2:
               /* if( empty($_POST['partner_summary']) )
                {
                    $this->response->message[] = array(
                        'message' => 'Please add your comment on the summary section.',
                        'type' => 'error'
                    );
                    $error = true;
                }*/
                $update_data = array('to_user_id' => $fstapprover->approver_id, 'status_id' => 2, 'partner_summary' => $_POST['partner_summary']);
                $where_array = array( 'appraisal_id' => $this->input->post('appraisal_id'), 'user_id' => $this->input->post('user_id'));
                //get previous data for audit logs
                $previous_main_data = $this->db->get_where('performance_appraisal_applicable', $where_array)->row_array();
                $this->db->update('performance_appraisal_applicable', $update_data, $where_array);

                $feed = array(
                    'status' => 'info',
                    'message_type' => 'Comment',
                    'user_id' => $this->user->user_id,
                    'feed_content' => 'Please review '.$appraisee->fullname.'\'s appraisal form.',
                    'uri' => get_mod_route('performance_appraisal_manage', '', false) . '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'].'/'.$fstapprover->approver_id,
                    'recipient_id' => $fstapprover->approver_id
                );

                $recipients = array($fstapprover->approver_id);
                $this->system_feed->add( $feed, $recipients );

                $this->response->notify[] = $fstapprover->approver_id;
                $this->response->redirect = true;

                break;
                case 11:
                if( empty($_POST['partner_summary']) )
                {
                    $this->response->message[] = array(
                        'message' => 'Please add your comment on the summary section.',
                        'type' => 'error'
                    );
                    $error = true;
                    goto stop;
                }
                $update_data = array('to_user_id' => $fstapprover->approver_id, 'status_id' => 11, 'partner_summary' => $_POST['partner_summary']);
                $where_array = array( 'appraisal_id' => $this->input->post('appraisal_id'), 'user_id' => $this->input->post('user_id'));
                //get previous data for audit logs
                $previous_main_data = $this->db->get_where('performance_appraisal_applicable', $where_array)->row_array();
                $this->db->update('performance_appraisal_applicable', $update_data, $where_array);

                $feed = array(
                    'status' => 'info',
                    'message_type' => 'Comment',
                    'user_id' => $this->user->user_id,
                    'feed_content' => 'Please review '.$appraisee->fullname.'\'s appraisal form.',
                    'uri' => get_mod_route('performance_appraisal_manage', '', false) . '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'].'/'.$fstapprover->approver_id,
                    'recipient_id' => $fstapprover->approver_id
                );

                $recipients = array($fstapprover->approver_id);
                $this->system_feed->add( $feed, $recipients );

                $this->response->notify[] = $fstapprover->approver_id;
                $this->response->redirect = true;

                break;
            case 5: //for appraisers summary
                $update_data = array('status_id' => 5);
                //get previous data for audit logs
                $where_array = array( 'appraisal_id' => $this->input->post('appraisal_id'), 'user_id' => $this->input->post('user_id'));
                $previous_main_data = $this->db->get_where('performance_appraisal_applicable', $where_array)->row_array();
                $this->db->update('performance_appraisal_applicable', $update_data, $where_array);

                //bring it up
                foreach(  $approvers as $index => $approver )
                {
                    if( $approver->approver_id == $this->user->user_id ){
                        $this->db->update('performance_appraisal_approver', array('performance_status_id' => 4), array('id' => $approver->id));

                        if( ($index+1) == $no_approvers ){
                            $this->db->update('performance_appraisal_approver', array('performance_status_id' => 4), array('appraisal_id' => $_POST['appraisal_id'], 'user_id' => $_POST['user_id']));
                            $this->db->update('performance_appraisal_applicable_user', array('status_id' => 4), array('appraisal_id' => $_POST['appraisal_id'], 'user_id' => $_POST['user_id']));
                            $status_id = 4;
                            $update['to_user_id'] = $fstapprover->approver_id;

                            $feed = array(
                                'status' => 'info',
                                'message_type' => 'Comment',
                                'user_id' => $this->user->user_id,
                                'feed_content' => 'Your appraisal form of '.$appraisee->fullname.' has been approved.',
                                'uri' => $this->mod->route . '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'],
                                'recipient_id' => $fstapprover->approver_id
                            );

                            $recipients = array($fstapprover->approver_id);
                            $this->system_feed->add( $feed, $recipients );

                            $this->response->notify[] = $fstapprover->approver_id;
                        }
                        else{
                            $up = $approvers[$index+1];
                            $this->db->update('performance_appraisal_approver', array('performance_status_id' => 2), array('id' => $up->id));
                            $update['to_user_id'] = $up->approver_id; 
                            $feed = array(
                                'status' => 'info',
                                'message_type' => 'Comment',
                                'user_id' => $this->user->user_id,
                                'feed_content' => 'Please review '.$appraisee->fullname.'\'s appraisal form.',
                                'uri' => $this->mod->route . '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'].'/'.$update['to_user_id'],
                                'recipient_id' => $update['to_user_id']
                            );

                            $recipients = array($update['to_user_id']);
                            $this->system_feed->add( $feed, $recipients );

                            $this->response->notify[] = $update['to_user_id']; 
                        }
                    }
                    else{
                        //employee pushing it to first approver
                        $update_data = array('to_user_id' => $fstapprover->approver_id, 'status_id' => 5);
                        $where_array = array( 'appraisal_id' => $this->input->post('appraisal_id'), 'user_id' => $this->input->post('user_id'));
                        $previous_main_data = $this->db->get_where('performance_appraisal_applicable', $where_array)->row_array();
                        $this->db->update('performance_appraisal_applicable', $update_data, $where_array);

                        $feed = array(
                            'status' => 'info',
                            'message_type' => 'Comment',
                            'user_id' => $this->user->user_id,
                            'feed_content' => 'Please review '.$appraisee->fullname.'\'s appraisal form.',
                            'uri' => get_mod_route('performance_appraisal_manage', '', false) . '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'].'/'.$fstapprover->approver_id,
                            'recipient_id' => $fstapprover->approver_id
                        );

                        $recipients = array($fstapprover->approver_id);
                        $this->system_feed->add( $feed, $recipients );

                        $this->response->notify[] = $fstapprover->approver_id;
                        $this->response->redirect = true;
                    }
                }

                $this->response->redirect = true;
                break;
            case 8: //approved
                //count crowdsource
                $where = array(
                    'section_type_id' => 4,
                    'template_id' => $appraisee->template_id,
                    'deleted' => 0
                );
                $sections = $this->db->get_where('performance_template_section', $where);
                if($sections->num_rows() > 0)
                {
                    $crowdsource_error = 0;
                    foreach($sections->result() as $section)
                    {
                        //check for current contributors 
                        $where = array(
                            'appraisal_id' => $appraisee->appraisal_id,
                            'user_id' => $appraisee->user_id,
                            'template_section_id' => $section->template_section_id,
                        );
                        $contributors = array();
                        $current = $this->db->get_where('performance_appraisal_contributor', $where);
                        foreach($current->result() as $cs)
                        {
                            if( !in_array($cs->contributor_id, $contributors) )
                                $contributors[] = $cs->contributor_id;
                        }
                        if( !empty($section->min_crowdsource) && sizeof($contributors) < $section->min_crowdsource )
                        { 
                            $feed_content = "Please finalized ".$section->template_section." of Crowdsource Feedback.";
                            $this->response->message[] = array(
                                'message' => $feed_content,
                                'type' => 'warning'
                            );
                            // goto stop;
                            $crowdsource_error++;
                        }
                    }
                    if($crowdsource_error > 0){
                        $this->response->redirect = false;
                        $error = true;
                        goto stop;
                    }
                }

                $update_data = array('status_id' => 8);
                //get previous data for audit logs
                $where_array = array( 'appraisal_id' => $this->input->post('appraisal_id'), 'user_id' => $this->input->post('user_id'));
                $previous_main_data = $this->db->get_where('performance_appraisal_applicable', $where_array)->row_array();
                $this->db->update('performance_appraisal_applicable', $update_data, $where_array);
                
                //update crowdsource to finalized
                $this->db->update('performance_appraisal_contributor', array('finalized' => 1), array( 'appraisal_id' => $this->input->post('appraisal_id'), 'user_id' => $this->input->post('user_id') ) );
                //notify crowdsource
                $qry = "select a.contributor_id, pts.template_section
                FROM {$this->db->dbprefix}performance_appraisal_contributor a
                INNER JOIN ww_performance_template_section pts 
                 ON a.template_section_id = pts.template_section_id
                WHERE a.user_id = {$_POST['user_id']} AND a.appraisal_id = {$_POST['appraisal_id']}
                GROUP BY a.contributor_id";
                $contributors = $this->db->query( $qry );
                foreach( $contributors->result() as $contributor )
                {
                    $feed_content = "{$appraisee->fullname} has chosen you as his/her crowdsource on his/her {$contributor->template_section}.";
                    $feed = array(
                        'status' => 'info',
                        'message_type' => 'Comment',
                        'user_id' => $this->user->user_id,
                        'feed_content' => $feed_content,
                        'uri' => get_mod_route('performance_appraisal_contributor', '', false) . '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'].'/'.$contributor->contributor_id,
                        'recipient_id' => $contributor->contributor_id
                    );

                    $recipients = array($contributor->contributor_id);
                    $this->system_feed->add( $feed, $recipients );
                
                    $this->response->notify[] = $contributor->contributor_id;   
                }

                $this->response->redirect = true;
                break;
            case 9: //hr validation
                $update_data = array('status_id' => 9);
                //get previous data for audit logs
                $where_array = array( 'appraisal_id' => $this->input->post('appraisal_id'), 'user_id' => $this->input->post('user_id'));
                $previous_main_data = $this->db->get_where('performance_appraisal_applicable', $where_array)->row_array();
                $this->db->update('performance_appraisal_applicable', $update_data, $where_array);

                $this->response->redirect = true;
                
                //notify HR OD AND TRAINING
                $hrods = $this->db->get_where('users', array('deleted' => 0, 'active' => 1, 'role_id' => 16));
                foreach( $hrods->result() as $hrod )
                {
                    $feed = array(
                        'status' => 'info',
                        'message_type' => 'Comment',
                        'user_id' => $this->user->user_id,
                        'feed_content' => 'Please review '.$appraisee->fullname.'\'s crowdsource feedbacks.',
                        'uri' => get_mod_route('performance_appraisal_admin', '', false) . '/crowdsource/'.$_POST['appraisal_id'].'/'.$_POST['user_id'],
                        'recipient_id' => $hrod->user_id
                    );

                    $recipients = array($hrod->user_id);
                    $this->system_feed->add( $feed, $recipients );
                
                    $this->response->notify[] = $hrod->user_id;    
                }

                break;
            case 13: //for immediate supervisors review.
                $where = array(
                    'appraisal_id' => $appraisee->appraisal_id,
                    'user_id' => $appraisee->user_id             
                );

                $update['status_id'] = $status_id;
                $update['appraisee_acceptance'] = isset($appraisal_other_info['appraisee_acceptance']) ? $appraisal_other_info['appraisee_acceptance'] : 0;
                $update['appraisee_remarks'] = isset($appraisal_other_info['appraisee_remarks']) ? $appraisal_other_info['appraisee_remarks'] : '';
                //get previous data for audit logs
                $this->db->update('performance_appraisal_applicable', $update, $where);                
                $this->db->update('performance_appraisal_applicable_user', $update, $where);   
                $this->load->model('system_feed');

                $feed = array(
                    'status' => 'info',
                    'message_type' => 'Comment',
                    'user_id' => $this->user->user_id,
                    'feed_content' => 'Please review '.$appraisee->fullname.'\'s performance targets.',
                    'uri' => $this->mod_admin->route . '/review/'.$_POST['planning_id'].'/'.$_POST['user_id'],
                    'recipient_id' => $appraisee->planning_created_by
                );

                $recipients = array($appraisee->planning_created_by);
                $this->system_feed->add( $feed, $recipients );
            
                $this->response->notify[] = $appraisee->planning_created_by;                    

                $this->response->redirect = true;
        }     

        //create system logs
        //$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'performance_appraisal_applicable', (array)$previous_main_data, $update_data);

        $where = array(
            'appraisal_id' => $this->input->post('appraisal_id'),
            'user_id' => $this->input->post('user_id')
        );
        $update['status_id'] = $status_id;
        if( empty($appraisee->selfrate_date) )
        {
            $update['selfrate_date'] = date('Y-m-d');    
        }
        //get previous data for audit logs
        $previous_main_data = $this->db->get_where('performance_appraisal_applicable_user', $where)->row_array();
        $this->db->update('performance_appraisal_applicable_user', $update, $where);   
        
        //create system logs
        $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'performance_appraisal_applicable_user', (array)$previous_main_data, $update);   

        if( $this->db->_error_message() != "" )
        {
            $this->response->message[] = array(
                'message' => $this->db->_error_message(),
                'type' => 'error'
            );
            $error = true;
            goto stop;
        }

        stop:
        if( !$error ){
            $this->db->trans_commit();
        }
        else{
             $this->db->trans_rollback();
             $this->response->redirect = false;
        }

        if( $return )
        {
            return !$error;
        }

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }

    function review( $record_id, $user_id )
    {
        parent::edit('', true);

        $vars['manager_id'] ='';
        $this->load->model('performance_appraisal_manage_model', 'pam');
        $appraisee = $vars['appraisee'] = $this->mod->get_appraisee( $this->record_id, $user_id );
        $vars['self_review'] = $this->pam->get_self_review( $this->record_id, $user_id );

	if( empty($vars['appraisee']) || ($vars['appraisee']->user_id != $this->user->user_id && $vars['appraisee']->status_id != 6 ))
        {
            echo $this->load->blade('pages.not_under_attention')->with( $this->load->get_cached_vars() );
            die();
        }

        $this->load->model('appraisal_template_model', 'template');
        $vars['template'] = $this->template; 
        $vars['templatefile'] = $this->template->get_template( $appraisee->template_id ); 

        $vars['approversLog'] = array();
        $approvers_log = "SELECT IF(ppar.display_name='', CONCAT(usp.lastname,' ',usp.firstname), ppar.display_name) AS display_name, 
                        ppl.created_on, ppap.user_id, pstat.performance_status, REPLACE(pstat.class, 'btn', 'badge') as class, pos.position, ppap.to_user_id, ppar.approver_id  
                        FROM {$this->db->dbprefix}performance_appraisal_applicable ppap 
                        INNER JOIN {$this->db->dbprefix}performance_appraisal_approver ppar ON ppap.appraisal_id = ppar.appraisal_id 
                        -- AND ppap.user_id = ppar.user_id 
                        INNER JOIN {$this->db->dbprefix}users_profile usp ON ppar.approver_id = usp.user_id
                        INNER JOIN {$this->db->dbprefix}users_position pos ON usp.position_id = pos.position_id
                        INNER JOIN {$this->db->dbprefix}performance_status pstat ON ppar.performance_status_id = pstat.performance_status_id 
                        LEFT JOIN {$this->db->dbprefix}performance_appraisal_logs ppl ON ppap.appraisal_id = ppl.appraisal_id 
                        AND ppap.user_id = ppl.user_id AND ppar.approver_id = ppl.to_user_id 
                        WHERE ppap.appraisal_id = {$appraisee->appraisal_id} AND ppap.user_id = {$appraisee->user_id} GROUP BY ppar.approver_id ORDER BY ppl.id ";
                        
        $approversLog = $this->db->query($approvers_log);
        if( $approversLog->num_rows() > 0 ){
            $vars['approversLog'] = $approversLog->result_array();
        }
        $this->load->vars( $vars );

        $this->load->helper('form');
        $this->load->helper('file');
        echo $this->load->blade('pages.summary')->with( $this->load->get_cached_vars() );          
    }

    function crowdsource( $record_id, $user_id )
    {
        parent::edit('', true);

        $this->load->model('performance_appraisal_manage_model', 'pam');
        $appraisee = $vars['appraisee'] = $this->mod->get_appraisee( $this->record_id, $user_id );
        $vars['self_review'] = $this->pam->get_self_review( $this->record_id, $user_id );

        if( $vars['appraisee']->user_id != $this->user->user_id && $vars['appraisee']->status_id != 6 )
        {
            echo $this->load->blade('pages.not_under_attention')->with( $this->load->get_cached_vars() );
            die();
        }

        $this->load->model('appraisal_template_model', 'template');
        $vars['template'] = $this->template;
        $vars['templatefile'] = $this->template->get_template( $appraisee->template_id ); 

        $vars['approversLog'] = array();
        $approvers_log = "SELECT IF(ppar.display_name='', CONCAT(usp.lastname,' ',usp.firstname), ppar.display_name) AS display_name, 
                        ppl.created_on, ppap.user_id, pstat.performance_status, REPLACE(pstat.class, 'btn', 'badge') as class, pos.position, ppap.to_user_id, ppar.approver_id  
                        FROM {$this->db->dbprefix}performance_appraisal_applicable ppap 
                        INNER JOIN {$this->db->dbprefix}performance_appraisal_approver ppar ON ppap.appraisal_id = ppar.appraisal_id 
                        AND ppap.user_id = ppar.user_id 
                        INNER JOIN {$this->db->dbprefix}users_profile usp ON ppar.approver_id = usp.user_id
                        INNER JOIN {$this->db->dbprefix}users_position pos ON usp.position_id = pos.position_id
                        INNER JOIN {$this->db->dbprefix}performance_status pstat ON ppar.performance_status_id = pstat.performance_status_id 
                        LEFT JOIN {$this->db->dbprefix}performance_appraisal_logs ppl ON ppap.appraisal_id = ppl.appraisal_id 
                        AND ppap.user_id = ppl.user_id AND ppar.approver_id = ppl.to_user_id 
                        WHERE ppap.appraisal_id = {$appraisee->appraisal_id} AND ppap.user_id = {$appraisee->user_id} GROUP BY ppar.approver_id ORDER BY ppl.id ";
        
        $approversLog = $this->db->query($approvers_log);
        if( $approversLog->num_rows() > 0 ){
            $vars['approversLog'] = $approversLog->result_array();
        }

        $this->load->vars( $vars );

        $this->load->helper('form');
        $this->load->helper('file');
        echo $this->load->blade('pages.crowdsource')->with( $this->load->get_cached_vars() );          
    }

    function get_section_item_summary()
    {
        $this->_ajax_only();
        
        $appraisee = $this->mod->get_appraisee( $this->input->post('appraisal_id'), $this->input->post('user_id') );
        $this->db->limit(1);
        $section = $this->db->get_where('performance_template_section', array('template_section_id' => $_POST['section_id']))->row();
        $this->load->vars( array('section' => $section) );

        $_POST['applicable_status_id'] = $appraisee->status_id;

        switch( $appraisee->status_id )
        {
            case 8:
                $folder = "crowdsource";
                break;
            default:
                $folder = "summary";
        }

        switch($section->section_type_id)
        {
            case 2:
                $this->response->items = $this->load->view($folder . '/section_items', $_POST, true);
                break;
            case 3:
                $this->response->items = $this->load->view($folder . '/items_library', $_POST, true);
                break;
            case 4:
                $this->response->items = $this->load->view($folder . '/items_library_crowd', $_POST, true);
                break;
            case 5:
                $this->response->items = $this->load->view($folder.'/personal_development_plan', $_POST, true);                                          
        }   

        $this->response->section_id = $_POST['section_id'];
        $this->response->section_type = $section->section_type_id;
        $this->response->close_modal = true;

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();      
    }

    function contributor_form()
    {
        $this->_ajax_only();

        //check for current
        $current = $this->db->get_where('performance_appraisal_contributor', $_POST);
        $contributor = array();
        $approved = array();
        if($current->num_rows() > 0)
        {
            foreach( $current->result() aS $cont )
            {
                $contributor[] = $cont->contributor_id;
                
                if($cont->status_id != 0)
                    $approved[] = $cont->contributor_id;
            }

           
        }
        else{
            //get from draft
            $this->db->limit(1);
            $appraisal = $this->db->get_where('performance_appraisal', array('appraisal_id' => $_POST['appraisal_id']))->row();
            $this->db->limit(1);
            $planning = $this->db->get_where('performance_planning', array('planning_id' => $appraisal->planning_id))->row();
            $this->db->limit(1);
            $planning_user = $this->db->get_where('performance_planning_crowdsource', array('planning_id' => $appraisal->planning_id, 'user_id' => $_POST['user_id'], 'section_id' => $_POST['template_section_id']))->row();

            $contributor = isset( $planning_user->crowdsource_user_id ) && !empty($planning_user->crowdsource_user_id) ? explode(',', $planning_user->crowdsource_user_id) : array();
        }

        $vars = array(
            'post' => $_POST,
            'contributor' => $contributor,
            'approved_con' => $approved
        );
        
        $data['title'] = 'Add/Edit Section';
        $data['content'] = $this->load->view('edit/contributor_form', $vars, true);

        $this->response->contributor_form = $this->load->view('templates/modal', $data, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();      
    }

    public function tag_user(){

        $this->_ajax_only();

        $data = array();
        $this->load->model('dashboard_model');
        $data = $this->dashboard_model->getUsersTagList();

        header('Content-type: application/json');
        echo json_encode($data);
        die();
    }

    function add_contributors()
    {
        $this->_ajax_only();
        $this->response->close_modal = false;

        $appraisee = $this->mod->get_appraisee(  $_POST['appraisal_id'], $_POST['user_id'] );
        $section = $this->db->get_where('performance_template_section', array('template_section_id' => $_POST['template_section_id']))->row();

        $contributors = $this->input->post('contributors');
        $contributors = explode(',', $contributors);
        
        $delete_contri = array();
        $select_delete = array(
            'appraisal_id' => $_POST['appraisal_id'],
            'user_id' => $_POST['user_id'],
            'template_section_id' => $_POST['template_section_id']
        );
        $delete_crowd = $this->db->get_where('performance_appraisal_contributor', $select_delete);
        if($delete_crowd->num_rows() > 0){
            $delete_crowd = $delete_crowd->result_array();
            foreach( $delete_crowd as $contrib_id )
            {
                if( !in_array($contrib_id['contributor_id'], $contributors) ){

                    $where = array(
                        'appraisal_id' => $_POST['appraisal_id'],
                        'user_id' => $_POST['user_id'],
                        'template_section_id' => $_POST['template_section_id'],
                        'contributor_id' => $contrib_id['contributor_id']
                    );
                    $this->db->delete('performance_appraisal_contributor', $where);
                }
            }

        }

        $users_info = $this->db->get_where('users_profile', array('user_id' => $_POST['user_id']) )->row_array();
        if( in_array($users_info['reports_to_id'], $contributors) ){
            $this->response->message[] = array(
                'message' => 'You cannot choose your immediate superior as your crowdsource.',
                'type' => 'warning'
            );
            $this->_ajax_return();  
        }
        $template_info = $this->db->get_where('performance_template', array('template_id' => $section->template_id))->row();
        if($template_info->max_crowdsource > 0){
            foreach ($contributors as $key => $value) {
                $crowdsource_count = "SELECT * FROM {$this->db->dbprefix}performance_appraisal_contributor
                                    WHERE appraisal_id = {$appraisee->appraisal_id} AND template_section_id = {$this->input->post('template_section_id')} 
                                    AND contributor_id = $value
                                    GROUP BY user_id";
                $crowd_count = $this->db->query($crowdsource_count);
                if($crowd_count->num_rows() >= $template_info->max_crowdsource){
                    $crowd_info = $this->db->get_where('users', array('user_id' => $value) )->row_array();
                    $this->response->message[] = array(
                        'message' => $crowd_info['full_name']." has already reached {$template_info->max_crowdsource} crowdourced feedback requests. 
                                            Kindly choose another employee as your crowdsource.",
                        'type' => 'warning'
                    );
                    $this->_ajax_return();  
                }
            }
        }
        //check for current contributors 
        $where = array(
            'appraisal_id' => $this->input->post('appraisal_id'),
            'user_id' => $this->input->post('user_id'),
            'template_section_id' => $this->input->post('template_section_id'),
        );
        $current = $this->db->get_where('performance_appraisal_contributor', $where);
        foreach($current->result() as $cs)
        {
            if( !in_array($cs->contributor_id, $contributors) )
                $contributors[] = $cs->contributor_id;
        }

        if( !empty($section->min_crowdsource) && sizeof($contributors) < $section->min_crowdsource )
        {
            $this->response->message[] = array(
                'message' => 'A minimum of '. $section->min_crowdsource .' crowdsource is needed for this section.',
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        if( sizeof($contributors) > 5 )
        {
            $this->response->message[] = array(
                'message' => 'Number of contributors exceeded allowed.',
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        foreach( $contributors as $contributor_id )
        {
            $insert = array(
                'appraisal_id' => $_POST['appraisal_id'],
                'user_id' => $_POST['user_id'],
                'template_section_id' => $_POST['template_section_id'],
                'contributor_id' => $contributor_id
            );

            $this->db->limit(1);
            $check = $this->db->get_where('performance_appraisal_contributor', $insert);
            if( $check->num_rows() == 0 )
            {
                $this->db->insert('performance_appraisal_contributor', $insert); 
            }
        }

        $this->response->close_modal = true;
        $this->response->section_id = $_POST['template_section_id'];

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

    function remove_contributor()
    {
        $this->_ajax_only();

        $this->db->delete('performance_appraisal_contributor', $_POST);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();   
    }

    function cs_discussion()
    {
        $this->_ajax_only();
        
        $vars = $_POST;
        $vars['discussions'] = $this->mod->get_cs_discussion($_POST['appraisal_id'],$_POST['section_id'], $_POST['user_id'], $_POST['contributor_id']);
        $contributor = array();

        // if( !empty( $_POST['contributor_id'] ) )
        // {
            $contributor = $this->db->get_where('users', array('user_id' => $_POST['user_id']))->row();
            $data['title'] = $contributor->full_name . '<br><span class="text-muted">Discussion Logs</span>';
        // }
        // else{
        //     $data['title'] = 'OD and Training' . '<br><span class="text-muted">Discussion Logs</span>';     
        // }
        $vars['contributor'] = $contributor;       
        $this->load->vars($vars);
        $data['content'] = $this->load->blade('crowdsource.discussion_form')->with( $this->load->get_cached_vars() );

        $this->response->notes = $this->load->view('templates/modal', $data, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

    function sendback_cs()
    {
        $this->_ajax_only();

        $appraisee = $this->mod->get_appraisee( $this->input->post('appraisal_id'), $this->input->post('user_id') );
        
        $insert = $_POST;
        if(trim($insert['note'])){
        $this->db->insert('performance_appraisal_contributor_notes', $insert);
        }
        
        if( $this->input->post('note_to') != '' )
        {
            $where = array(
                'appraisal_id' => $this->input->post('appraisal_id'),
                'user_id' => $this->input->post('user_id')
            );
            $this->db->update('performance_appraisal_applicable', array('cs_status' => 2), $where);

            $where = array(
                'appraisal_id' => $this->input->post('appraisal_id'),
                'user_id' => $this->input->post('user_id'),
                'contributor_id' => $this->input->post('note_to')
            );
            $this->db->update('performance_appraisal_contributor', array('status_id' => 3), $where);

            //notify contributor
            $this->load->model('system_feed');
            $feed = array(
                'status' => 'info',
                'message_type' => 'Comment',
                'user_id' => $this->user->user_id,
                'feed_content' => 'There was a remark regarding your crowdsource feedback for '.$appraisee->fullname.'\'s, kindly check.',
                'uri' => get_mod_route('performance_appraisal_contributor', '', false) . '/edit/'.$_POST['appraisal_id'].'/'.$_POST['user_id'].'/'.$_POST['note_to'],
                'recipient_id' => $_POST['note_to']
            );

            $recipients = array($_POST['note_to']);
            $this->system_feed->add( $feed, $recipients );

            $this->response->notify[] = $_POST['note_to'];  
            $this->response->redirect = true;
        }
        else{
            $this->response->redirect = false;
        }

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        

        $this->_ajax_return();     
    }

    function save_crowd_message()
    {
        $this->_ajax_only();

        $appraisee = $this->mod->get_appraisee( $this->input->post('appraisal_id'), $this->input->post('user_id') );
        
        $insert = $_POST;
        $insert['created_on'] = date('Y-m-d H:i:s');
        $this->db->insert('performance_appraisal_contributor_notes', $insert);
        
        // $this->db->insert('performance_planning_notes', $insert);
          // GET LATEST POSTED DATA AND RETURN IT BACK TO THE UI
        $new_notes_qry = " SELECT ud.department, CONCAT(up.lastname, ', ', up.firstname) as full_name, 
                    gettimeline('{$insert['created_on']}') as timeline, {$insert['created_by']} as created_by,
                    '{$insert['note']}' as notes, {$insert['user_id']} as user_id, up.photo
                    FROM {$this->db->dbprefix}users_profile up
                    LEFT JOIN {$this->db->dbprefix}users_department ud on ud.department_id = up.department_id 
                    WHERE up.user_id = {$this->user->user_id}";
                    
        $data['note'] = $this->db->query($new_notes_qry)->row_array();

        $this->response->new_discussion   = $this->load->view('customs/new_comment', $data, true);
        $this->response->redirect = false;

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        

        $this->_ajax_return();     
    }

    function view_discussion()
    {
        $this->_ajax_only();
        
        $this->load->model('appraisal_individual_planning_model', 'ig_mod');
        $vars = $_POST;
        $vars['notes'] = $this->ig_mod->get_notes($_POST['planning_id'], $_POST['user_id']);

        $this->load->vars($vars);

        $data['title'] = 'Discussion Logs';
        $data['content'] = $this->load->blade('edit.discussion_logs')->with( $this->load->get_cached_vars() );

        $this->response->notes = $this->load->view('templates/modal', $data, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

    public function submitDiscussion(){

        $this->_ajax_only();
        $data = array();

        $insert = array(
            'planning_id' => $this->input->post('planning_id'),
            'user_id' => $this->input->post('user_id'),
            'notes' => $this->input->post('discussion_notes'),
            'created_by' => $this->user->user_id,
            'created_on' => date('Y-m-d H:i:s')
        );

        $this->db->insert('performance_planning_notes', $insert);
          // GET LATEST POSTED DATA AND RETURN IT BACK TO THE UI
        $new_notes_qry = " SELECT ud.department, CONCAT(up.lastname, ', ', up.firstname) as full_name, 
                    gettimeline('{$insert['created_on']}') as timeline, {$insert['created_by']} as created_by,
                    '{$insert['notes']}' as notes, {$insert['user_id']} as user_id, up.photo
                    FROM {$this->db->dbprefix}users_profile up
                    LEFT JOIN {$this->db->dbprefix}users_department ud on ud.department_id = up.department_id 
                    WHERE up.user_id = {$this->user->user_id}";
                    
        $data['note'] = $this->db->query($new_notes_qry)->row_array();

        $this->response->new_discussion   = $this->load->view('customs/new_discussion', $data, true);

        $this->response->message[] = array(
            'message' => 'Discussion successfully added.',
            'type' => 'success'
        );


        $this->_ajax_return();  
    }

    function view_transaction_logs()
    {
        $this->_ajax_only();

        $approvers_list = array();
        $approvers = "SELECT IF(ppa.display_name='', CONCAT(up.lastname,', ',up.firstname), ppa.display_name) as display_name, upos.position FROM {$this->db->dbprefix}performance_appraisal_approver  ppa 
                        INNER JOIN {$this->db->dbprefix}users_profile up 
                        ON ppa.approver_id = up.user_id 
                        INNER JOIN {$this->db->dbprefix}users_position upos 
                        ON up.position_id = upos.position_id 
                        WHERE ppa.appraisal_id = {$_POST['appraisal_id']} AND ppa.user_id = {$_POST['user_id']}
                    ";
        $app_sql = $this->db->query($approvers);
        if($app_sql->num_rows() > 0){
            $approvers_list = $app_sql->result_array();
        }

        $logs_list = array();
        $logs = "SELECT CONCAT(up.firstname,' ',up.lastname) as partner_name, upos.position, 
                        ppa.created_on, performance_status, pstat.class 
                        FROM {$this->db->dbprefix}performance_appraisal_logs  ppa 
                        INNER JOIN {$this->db->dbprefix}users_profile up 
                        ON ppa.to_user_id = up.user_id
                        INNER JOIN {$this->db->dbprefix}users_position upos 
                        ON up.position_id = upos.position_id 
                        INNER JOIN ww_performance_status pstat 
                        ON ppa.status_id = pstat.performance_status_id 
                        WHERE ppa.appraisal_id = {$_POST['appraisal_id']} AND ppa.user_id = {$_POST['user_id']}
                    ";
        $log_sql = $this->db->query($logs);
        if($log_sql->num_rows() > 0){
            $logs_list = $log_sql->result_array();
        }

        $vars['approvers_list'] = $approvers_list;
        $vars['logs_list'] = $logs_list;

        // $this->load->vars( $vars );
        $this->load->helper('form');
        $this->load->helper('file');
        // // $data['title'] = 'Add/Edit Column Item';
        // $data['content'] = $this->load->blade('edit.view_logs')->with( $this->load->get_cached_vars() );

        // $this->response->redeem_form = $this->load->view('form/redeem', $data, true);

        $this->response->trans_logs = $this->load->view('edit/view_logs', $vars, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }
}
