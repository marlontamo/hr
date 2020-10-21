<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Appraisal_individual_planning extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('appraisal_individual_planning_model', 'mod');
		parent::__construct();
        $this->lang->load('appraisal_individual_planning');
	}

    public function index()
    {
        $permission = $this->config->item('permission');
        $vars['performance_planning_manage'] = isset($permission['performance_planning_manage']) ? $permission['performance_planning_manage'] : 0;
        $vars['performance_planning'] = isset($permission['performance_planning']) ? $permission['performance_planning'] : 0;
        $this->load->vars($vars);
        parent::index();
    }

	public function edit( $record_id, $user_id )
    {
        parent::edit('', true);
        $this->after_edit_parent( $user_id );
    }

    public function review( $record_id, $user_id, $manager_id = '' )
    {
        parent::edit('', true);

        $appraisee = $vars['appraisee'] = $this->mod->get_appraisee( $this->record_id, $user_id );
        $vars['approver'] = $this->mod->get_approver( $this->record_id, $user_id, $manager_id );

        if( !$vars['approver'] )
        {
            echo $this->load->blade('pages.not_under_attention')->with( $this->load->get_cached_vars() );
            die();
        }

        $vars['manager_id'] = $manager_id; 

        $this->load->model('appraisal_template_model', 'template');
        $vars['template'] = $this->template;
        $vars['templatefile'] = $this->template->get_template( $appraisee->template_id );

        $vars['approversLog'] = array();
        $approvers_log = "SELECT ppar.display_name, ppl.created_on, ppap.user_id, pstat.performance_status, REPLACE(pstat.class, 'btn', 'badge') as class, pos.position, ppap.to_user_id, ppar.approver_id  
                        FROM {$this->db->dbprefix}performance_planning_applicable ppap 
                        INNER JOIN {$this->db->dbprefix}performance_planning_approver ppar ON ppap.planning_id = ppar.planning_id 
                        AND ppap.user_id = ppar.appraisee_id 
                        INNER JOIN {$this->db->dbprefix}users_profile usp ON ppar.approver_id = usp.user_id
                        INNER JOIN {$this->db->dbprefix}users_position pos ON usp.position_id = pos.position_id
                        INNER JOIN {$this->db->dbprefix}performance_status pstat ON ppar.performance_status_id = pstat.performance_status_id 
                        LEFT JOIN {$this->db->dbprefix}performance_planning_logs ppl ON ppap.planning_id = ppl.planning_id 
                        AND ppap.user_id = ppl.user_id AND ppar.approver_id = ppl.to_user_id 
                        WHERE ppap.planning_id = {$appraisee->planning_id} AND ppap.user_id = {$appraisee->user_id} GROUP BY ppar.approver_id ORDER BY ppl.id ";

        $approversLog = $this->db->query($approvers_log);
        if( $approversLog->num_rows() > 0 ){
            $vars['approversLog'] = $approversLog->result_array();
        }
        
        $this->load->vars( $vars );

        $this->load->helper('form');
        $this->load->helper('file');
        echo $this->load->blade('pages.review')->with( $this->load->get_cached_vars() );  
    }

    public function after_edit_parent( $user_id )
    {
    	$appraisee = $vars['appraisee'] = $this->mod->get_appraisee( $this->record_id, $user_id );
    	
        $vars['manager_id'] = '';
        $vars['current_user_id'] = $this->user->user_id;
        $this->load->model('appraisal_template_model', 'template');
        $vars['template'] = $this->template;
        $vars['templatefile'] = $this->template->get_template( $appraisee->template_id ); 
        
        $vars['approversLog'] = array();
        $approvers_log = "SELECT ppar.display_name, ppl.created_on, ppap.user_id, pstat.performance_status, REPLACE(pstat.class, 'btn', 'badge') as class, pos.position, ppap.to_user_id, ppar.approver_id  
                        FROM {$this->db->dbprefix}performance_planning_applicable ppap 
                        INNER JOIN {$this->db->dbprefix}performance_planning_approver ppar ON ppap.planning_id = ppar.planning_id 
                        AND ppap.user_id = ppar.appraisee_id 
                        INNER JOIN {$this->db->dbprefix}users_profile usp ON ppar.approver_id = usp.user_id
                        INNER JOIN {$this->db->dbprefix}users_position pos ON usp.position_id = pos.position_id
                        INNER JOIN {$this->db->dbprefix}performance_status pstat ON ppar.performance_status_id = pstat.performance_status_id 
                        LEFT JOIN {$this->db->dbprefix}performance_planning_logs ppl ON ppap.planning_id = ppl.planning_id 
                        AND ppap.user_id = ppl.user_id AND ppar.approver_id = ppl.to_user_id 
                        WHERE ppap.planning_id = {$appraisee->planning_id} AND ppap.user_id = {$appraisee->user_id} GROUP BY ppar.approver_id ORDER BY ppl.id ";

        $approversLog = $this->db->query($approvers_log);
        if( $approversLog->num_rows() > 0 ){
            $vars['approversLog'] = $approversLog->result_array();
        }

        $vars['transaction_type'] = 'edit';

        $this->load->vars( $vars );

    	$this->load->helper('form');
		$this->load->helper('file');
		
        if( $vars['appraisee']->status_id == 4 || $vars['appraisee']->status_id == 6 || $vars['appraisee']->user_id != $this->user->user_id )
        {
            echo $this->load->blade('pages.review')->with( $this->load->get_cached_vars() );
        }
        else{
            echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
        }
    }

    function get_item_form()
    {
        $this->_ajax_only();

        $this->db->limit(1);
        $column = $this->db->get_where('performance_template_section_column', array('section_column_id' => $_POST['section_column_id']))->row();
        $where = array(
            'planning_id' => $_POST['planning_id'],
            'user_id' => $_POST['user_id'],
        );

        if( !empty( $_POST['parent_id'] ) )
        {
            $where['parent_id'] = $_POST['parent_id'];
        }
        else{
            $where['section_column_id'] = $_POST['section_column_id'];
        }
        
        $items = $this->db->get_where('performance_planning_applicable_items', $where)->num_rows();
        if( !empty($column->max_items) && $items >= $column->max_items )
        {
            $this->response->message[] = array(
                'message' => lang('appraisal_individual_planning.max_items_reached'),
                'type' => 'warning'
            );
            $this->_ajax_return();   
        }

        $vars = $_POST;
        $vars['sequence'] = '';
        $vars['item'] = '';

        if( !empty( $vars['item_id'] ) )
        {
            $this->db->limit(1);
            $vars = $this->db->get_where('performance_planning_applicable_items', array('item_id' => $vars['item_id']))->row_array();
        }

        $this->load->vars( $vars );

        $this->load->helper('form');
        $data['title'] = 'Add/Edit Column Item';
        $data['content'] = $this->load->blade('edit.item_form')->with( $this->load->get_cached_vars() );

        $this->response->item_form = $this->load->view('templates/modal', $data, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }

    function save_item()
    {
        $this->_ajax_only();

        $this->load->library('form_validation');

        $this->db->limit(1);
        $column = $this->db->get_where('performance_template_section_column', array('section_column_id' => $_POST['section_column_id']))->row();
        $where = array(
            'planning_id' => $_POST['planning_id'],
            'user_id' => $_POST['user_id'],
        );
        
        if( !empty( $_POST['parent_id'] ) )
        {
            $where['parent_id'] = $_POST['parent_id'];
        }
        else{
            $where['section_column_id'] = $_POST['section_column_id'];
        }

        $items = $this->db->get_where('performance_planning_applicable_items', $where)->num_rows();
        if( !empty($column->max_items) && $items >= $column->max_items )
        {
            $this->response->message[] = array(
                'message' => lang('appraisal_individual_planning.max_items_reached'),
                'type' => 'warning'
            );
            $this->_ajax_return();   
        }

        $config = array(
            array(
                'field'   => 'item',
                'label'   => 'Item',
                'rules'   => 'required'
            )
        );

        $this->response->show_add_row = ($items+1) == $column->max_items ? false : true;
        $this->response->section_column_id = $_POST['section_column_id'];

        $this->form_validation->set_rules($config); 

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

        $item_id = $this->input->post('item_id');
        unset( $_POST['item_id'] );
        $previous_main_data = array();
        if( empty( $item_id )  )
        {
            $this->db->insert('performance_planning_applicable_items', $_POST);
            $action = 'insert';
        }
        else{
        //get previous data for audit logs
            $previous_main_data = $this->db->get_where('performance_planning_applicable_items', array('item_id' => $item_id))->row_array();
            $this->db->update('performance_planning_applicable_items', $_POST, array('item_id' => $item_id));
            $action = 'update';
        }
        //create system logs
        $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, $action, 'performance_planning_applicable_items', $previous_main_data, $_POST);

        $this->response->close_modal = true;

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();   
    }

    function get_items()
    {
        $this->_ajax_only();

        $column_id = $this->input->post('column_id');
        $column = $this->db->get_where('performance_template_section_column', array('section_column_id' => $column_id))->row();
        $_POST['section_id'] = $column->template_section_id;
        $this->get_section_items();
        $this->_ajax_return();   
    }

    function get_section_items()
    {
        $this->_ajax_only();
        
        $appraisee = $this->mod->get_appraisee( $this->input->post('planning_id'), $this->input->post('user_id') );
        $section = $this->db->get_where('performance_template_section', array('template_section_id' => $_POST['section_id']))->row();

        $_POST['status_id'] = $appraisee->status_id; 
        $_POST['to_user_id'] = $appraisee->to_user_id;
        switch($section->section_type_id)
        {
            case 2:
                if ($this->input->post('item_id') == 1){
                    $items_form = 'section_items_new';
                }
                else{
                    $items_form = 'section_items';
                }
                break;
            case 4:
                $items_form = 'items_library_crowd';
                break;
            case 5:
                $items_form = 'personal_development_plan';
                break;                
        }

        switch(true)
        {
            case $appraisee->user_id != $this->user->user_id && $appraisee->status_id == 1:
                $this->response->items = $this->load->view('edit/'.$items_form, $_POST, true);
            break;
            case $appraisee->user_id == $this->user->user_id && $appraisee->status_id == 4:
            case $appraisee->user_id == $this->user->user_id && ($appraisee->status_id == 6 || $appraisee->status_id == 1):
            case $appraisee->user_id != $this->user->user_id && ($appraisee->status_id == 11 || $appraisee->status_id == 2 || $appraisee->status_id == 4):
                $this->response->items = $this->load->view('review/'.$items_form, $_POST, true);
                break;
            default:
                $this->response->items = $this->load->view('edit/'.$items_form, $_POST, true);
        }
        
        $this->response->section_id = $_POST['section_id'];
        $this->response->close_modal = true;

        $vars = $this->load->get_cached_vars();
        if(isset( $vars['show_add_row'] ))
        {
            $this->response->show_add_row = true; 
            $this->response->section_column_id = $vars['show_add_row']['section_column_id'];  
        }
        else{
            $this->response->show_add_row = false;
        }

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();      
    }

    function get_section_items_new()
    {
        $this->_ajax_only();
        
        $this->response->items = $this->load->view('edit/section_items_new', $_POST, true);

        $this->response->section_id = $_POST['section_id'];
        $this->response->close_modal = true;

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();      
    }

    function delete_item()
    {
        $this->_ajax_only();
        
        $this->db->delete('performance_planning_applicable_items', array('item_id' => $this->input->post('item_id')));
        //create system logs
        $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'delete', 'performance_planning_applicable_items - item_id', array(), array('item_id' => $this->input->post('item_id')));
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

    private function _change_status_partner()
    {        
        $appraisee = $this->mod->get_appraisee(  $_POST['planning_id'], $_POST['user_id'] );
/*        if( $appraisee->created_by != $this->user->user_id   )
        {
            $this->response->message[] = array(
                'message' => 'Record is not under your attention.',
                'type' => 'warning'
            );

            $this->_ajax_return();
        }
*/
        $this->response->redirect = $this->mod->url;

        $planning_other_info = isset($_POST['individual_planning']) ? $_POST['individual_planning'] : array();
        //get approvers
        $where = array(
            'planning_id' => $this->input->post('planning_id'),
            'user_id' => $appraisee->created_by,
            'appraisee_id' => $appraisee->user_id,
            'performance_status_id <=' => 2
        );
        $this->db->order_by('sequence');
        $approvers = $this->db->get_where('performance_planning_approver', $where)->result();
        $no_approvers = sizeof($approvers);

        $this->db->trans_begin();
        $status_id = $this->input->post('status_id');
        switch( $status_id )
        {
            case 1://draft
                $where = array(
                    'planning_id' => $this->input->post('planning_id'),
                    'template_id' => $this->input->post('template_id'),
                    'user_id' => $this->input->post('user_id'),
                );

                $update['status_id'] = $status_id;
                //get previous data for audit logs
                $previous_main_data = $this->db->get_where('performance_planning_applicable', $where)->row_array();
                $this->db->update('performance_planning_applicable', $update, $where);

                $this->response->redirect = get_mod_route('performance_planning_admin');                
                break;
            case 6: //for employees review and acceptance
                $where = array(
                    'planning_id' => $this->input->post('planning_id'),
                    'template_id' => $this->input->post('template_id'),
                    'user_id' => $this->input->post('user_id')
                );

                $update['appraisee_acceptance'] = isset($planning_other_info['appraisee_acceptance']) ? $planning_other_info['appraisee_acceptance'] : 0;
                $update['appraisee_remarks'] = isset($planning_other_info['appraisee_remarks']) ? $planning_other_info['appraisee_remarks'] : '';
                $update['status_id'] = $status_id;
                //get previous data for audit logs
                $previous_main_data = $this->db->get_where('performance_planning_applicable', $where)->row_array();
                $this->db->update('performance_planning_applicable', $update, $where);                

                $this->load->model('system_feed');

                if ($appraisee->user_id != $this->user->user_id){
                    $feed = array(
                        'status' => 'info',
                        'message_type' => 'Comment',
                        'user_id' => $this->user->user_id,
                        'feed_content' => 'Please review performance targets.',
                        'uri' => $this->mod->route . '/edit/'.$_POST['planning_id'].'/'.$_POST['user_id'],
                        'recipient_id' => $this->input->post('user_id')
                    );

                    $recipients = array($this->input->post('user_id'));
                    $this->system_feed->add( $feed, $recipients );
                
                    $this->response->notify[] = $this->input->post('user_id');    

                    $this->response->redirect = get_mod_route('performance_planning_admin');                
                }
                break; 
            case 11: //for immediate supervisors review.
                $where = array(
                    'planning_id' => $this->input->post('planning_id'),
                    'approver_id' => $this->user->user_id,
                    'user_id' => $this->input->post('user_id')
                );            
                $this->db->update('performance_planning_approver', array('performance_status_id' => 12, 'disapproved_date' => date('Y-m-d')), $where);

                $where = array(
                    'planning_id' => $this->input->post('planning_id'),
                    'template_id' => $this->input->post('template_id'),
                    'user_id' => $this->input->post('user_id')
                );

                $update['status_id'] = $status_id;
                $update['appraisee_acceptance'] = isset($planning_other_info['appraisee_acceptance']) ? $planning_other_info['appraisee_acceptance'] : 0;
                $update['appraisee_remarks'] = isset($planning_other_info['appraisee_remarks']) ? $planning_other_info['appraisee_remarks'] : '';
                //get previous data for audit logs
                $previous_main_data = $this->db->get_where('performance_planning_applicable', $where)->row_array();
                $this->db->update('performance_planning_applicable', $update, $where);                

                $this->load->model('system_feed');

                $feed = array(
                    'status' => 'info',
                    'message_type' => 'Comment',
                    'user_id' => $this->user->user_id,
                    'feed_content' => 'Please review '.$appraisee->fullname.'\'s performance targets.',
                    'uri' => $this->mod->route . '/review_admin/'.$_POST['planning_id'].'/'.$_POST['user_id'],
                    'recipient_id' => $appraisee->created_by
                );

                $recipients = array($appraisee->created_by);
                $this->system_feed->add( $feed, $recipients );
            
                $this->response->notify[] = $appraisee->created_by;     

                $this->response->redirect = get_mod_route('appraisal_individual_planning'); 
                break;                        
            case 4: //for immediate supervisor approver approval
                //update all approvers

                $where = array(
                    'planning_id' => $this->input->post('planning_id'),
                    'user_id' => $appraisee->created_by,
                    'appraisee_id' => $appraisee->user_id,
                    'performance_status_id <=' => 2
                );
                $this->db->order_by('sequence');
                $approvers = $this->db->get_where('performance_planning_approver', $where)->result();

                foreach(  $approvers  as $index => $approver )
                {
                    $this->db->update('performance_planning_approver', array('performance_status_id' => 4, 'approved_date' => date('Y-m-d H:i:s')), array('id' => $approver->id));
                    if( $index == 0 )
                    {
                        $this->load->model('system_feed');

                        $feed = array(
                            'status' => 'info',
                            'message_type' => 'Comment',
                            'user_id' => $this->user->user_id,
                            'feed_content' => 'Please review '.$appraisee->fullname.'\'s performance targets.',
                            'uri' => $this->mod->route . '/review_admin/'.$_POST['planning_id'].'/'.$_POST['user_id'].'/'.$approver->approver_id,
                            'recipient_id' => $appraisee->created_by
                        );

                        $recipients = array($appraisee->created_by);
                        $this->system_feed->add( $feed, $recipients );
                    
                        $this->response->notify[] = $appraisee->created_by;
                    }
                    else{
                        $this->db->update('performance_planning_approver', array('performance_status_id' => 2), array('id' => $approver->id));
                        continue;
                    }
                }

                // to check if all approver approved
                $where = array(
                    'planning_id' => $this->input->post('planning_id'),
                    'user_id' => $appraisee->created_by,
                    'appraisee_id' => $appraisee->user_id,
                    'performance_status_id <=' => 2
                );
                $this->db->order_by('sequence');
                $approvers = $this->db->get_where('performance_planning_approver', $where);
                if (!$approvers || $approvers->num_rows() == 0){
                    $update['approved_date'] = date('Y-m-d');
                    $update['status_id'] = $status_id;
                }
                else{
                    $update['status_id'] = 2;
                }
                // to check if all approver approved

                $where = array(
                    'planning_id' => $this->input->post('planning_id'),
                    'template_id' => $this->input->post('template_id'),
                    'user_id' => $this->input->post('user_id')
                );
                //get previous data for audit logs
                //$previous_main_data = $this->db->get_where('performance_planning_applicable', $where)->row_array();
                $this->db->update('performance_planning_applicable', $update, $where);

                $this->response->redirect = get_mod_route('performance_planning_admin'); 
                break;
            case 2: //for immediate supervisors review.
                $where = array(
                    'planning_id' => $this->input->post('planning_id'),
                    'template_id' => $this->input->post('template_id'),
                    'user_id' => $this->input->post('user_id')
                );

                $update['status_id'] = $status_id;

                //get previous data for audit logs
                //$previous_main_data = $this->db->get_where('performance_planning_applicable', $where)->row_array();

                $this->db->update('performance_planning_applicable', $update, $where);                

                $this->load->model('system_feed');

                foreach(  $approvers  as $index => $approver )
                {
                    $this->db->update('performance_planning_approver', array('performance_status_id' => 2), array('id' => $approver->id));
                    if( $index == 0 )
                    {
                        $this->load->model('system_feed');

                        $feed = array(
                            'status' => 'info',
                            'message_type' => 'Comment',
                            'user_id' => $this->user->user_id,
                            'feed_content' => 'Please review '.$appraisee->fullname.'\'s performance targets.',
                            'uri' => $this->mod->route . '/review_admin/'.$_POST['planning_id'].'/'.$_POST['user_id'],
                            'recipient_id' => $approver->approver_id
                        );

                        $recipients = array($approver->approver_id);
                        $this->system_feed->add( $feed, $recipients );
                    
                        $this->response->notify[] = $approver->approver_id;
                    }
                }                
/*
                $involves = array($appraisee->created_by,$appraisee->user_id);

                foreach(  $involves  as $index => $involve ){
                    $feed = array(
                        'status' => 'info',
                        'message_type' => 'Comment',
                        'user_id' => $this->user->user_id,
                        'feed_content' => 'Please review '.$appraisee->fullname.'\'s performance targets.',
                        'uri' => $this->mod->route . '/review/'.$_POST['planning_id'].'/'.$_POST['user_id'],
                        'recipient_id' => $involve
                    );

                    $recipients = array($involve);
                    $this->system_feed->add( $feed, $recipients );
                
                    $this->response->notify[] = $involve;                   
                }*/

                $this->response->redirect = get_mod_route('performance_planning_admin'); 
                break;
        }
        //create system logs
        //$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'performance_planning_applicable', $previous_main_data, $update);

        if (($status_id == 6 || $status_id == 1) && $appraisee->user_id != $this->user->user_id){
            $item = $_POST['item'];
            $field = $_POST['field'];

            $this->db->where('user_id',$this->input->post('user_id'));
            $this->db->where('planning_id',$this->input->post('record_id'));
            $this->db->delete('performance_planning_applicable_items');

            $this->db->where('user_id',$this->input->post('user_id'));
            $this->db->where('planning_id',$this->input->post('record_id'));
            $this->db->delete('performance_planning_applicable_items_header');

            $this->db->where('user_id',$this->input->post('user_id'));
            $this->db->where('planning_id',$this->input->post('record_id'));
            $this->db->delete('performance_planning_applicable_fields');

            $this->db->where('user_id',$this->input->post('user_id'));
            $this->db->where('planning_id',$this->input->post('record_id'));
            $this->db->delete('performance_planning_applicable_fields_header');
                                                                        
            $ctr = 1;
            foreach ($item as $key_item => $value_item) {
                foreach ($value_item as $key1 => $value1) {
                    $item_info = array(
                            'planning_id' => $this->input->post('record_id'),
                            'user_id' => $this->input->post('user_id'),
                            'section_column_id' => $key_item,
                            'item' => $key1 + 1,
                            'parent_id' => ($value1 == 1 ? 1 : ''),
                            'sequence' => $ctr
                        );

    /*                          $where = array(
                        'planning_id' => $this->input->post('record_id'),
                        'user_id' => $id,
                    );*/
                    
                    $this->db->insert('performance_planning_applicable_items',$item_info);
                    $item_id = $this->db->insert_id();

                    $this->db->insert('performance_planning_applicable_items_header',$item_info);
                    $item_id_header = $this->db->insert_id();

                    $field_info = array(
                            'planning_id' => $this->input->post('record_id'),
                            'user_id' => $this->input->post('user_id'),
                            'item_id' => $item_id,
                            'section_column_id' => $key_item,
                            'value' => (isset($field[$key_item][$key1]) ? $field[$key_item][$key1] : '')
                        );   

                    $this->db->insert('performance_planning_applicable_fields',$field_info);

                    $this->db->insert('performance_planning_applicable_fields_header',$field_info);
    /*                          $check = $this->db->get_where('performance_planning_applicable_items', $where);
                    if ($check && $check->num_rows() > 0){

                    }
                    else{
                        $this->db->insert('performance_planning_applicable_items',$item_info);
                        $item_id = $this->db->insert_id();

                        $field_info = array(
                                'planning_id' => $this->input->post('record_id'),
                                'user_id' => $id,
                                'item_id' => $item_id,
                                'section_column_id' => $key_item,
                                'value' => $field[$key_item][$key1]
                            );   

                        $this->db->insert('performance_planning_applicable_fields',$field_info);                                                
                    }*/
                    $ctr++;
                }
            }   
        }

        $this->db->trans_commit();
    }

    private function _change_status_approver()
    {
        $appraisee = $this->mod->get_appraisee(  $_POST['planning_id'], $_POST['user_id'] );
        $approver = $this->mod->get_approver(  $_POST['planning_id'], $_POST['user_id'], $_POST['manager_id'] );
        if( !$approver )
        {
            $this->response->message[] = array(
                'message' => 'Record is not under your attention.',
                'type' => 'warning'
            );

            $this->_ajax_return();
        }

        $status_id = $this->input->post('status_id');
        
        //get approvers
        $where = array(
            'planning_id' => $this->input->post('planning_id'),
            'user_id' => $this->input->post('user_id'),
        );
        $this->db->order_by('sequence');
        $approvers = $this->db->get_where('performance_planning_approver', $where)->result();
        $no_approvers = sizeof($approvers);

        $condition = $approvers[0]->condition;
        $fst_approver = $approvers[0];

        $this->response->redirect = false;
        $this->load->model('system_feed');
        switch( $status_id )
        {
            case 3: //pending
                //bring it down
                foreach(  $approvers as $index => $approver )
                {
                    if( $approver->approver_id == $this->user->user_id ){
                        if( $index != 0 ){
                            $down = $approvers[$index-1];
                            $update_data = array('performance_status_id' => 3);
                            $where_array = array('id' => $down->id);
                        //get previous data for audit logs
                            $previous_main_data = $this->db->get_where('performance_planning_approver', $where_array)->row_array();
                            $this->db->update('performance_planning_approver', $update_data, $where_array);
                            $update['to_user_id'] = $down->approver_id;

                            $feed = array(
                                'status' => 'info',
                                'message_type' => 'Comment',
                                'user_id' => $this->user->user_id,
                                'feed_content' => 'Please review '.$appraisee->fullname.'\'s performance targets.',
                                'uri' => $this->mod->route . '/review/'.$_POST['planning_id'].'/'.$_POST['user_id'].'/'.$down->approver_id,
                                'recipient_id' => $down->approver_id
                            );

                            $recipients = array($down->approver_id);
                            $this->system_feed->add( $feed, $recipients );

                            $this->response->notify[] = $down->approver_id;
                        }
                        else{
                            $update['to_user_id'] = $this->input->post('user_id');
                            $update_data = $update;
                            $where_array = array(
                                'planning_id' => $this->input->post('planning_id'),
                                'user_id' => $this->input->post('user_id'),
                            );
                            $previous_main_data = $this->db->get_where('performance_planning_applicable', $where_array)->row_array();

                            $feed = array(
                                'status' => 'info',
                                'message_type' => 'Comment',
                                'user_id' => $this->user->user_id,
                                'feed_content' => 'Please review your performance targets.',
                                'uri' => $this->mod->route . '/review/'.$_POST['planning_id'].'/'.$_POST['user_id'],
                                'recipient_id' => $update['to_user_id']
                            );

                            $recipients = array($update['to_user_id']);
                            $this->system_feed->add( $feed, $recipients );

                            $this->response->notify[] = $update['to_user_id'];
                        }
                    }
                }
                
                break;
            case 4: //approved
                //bring it up
                foreach(  $approvers as $index => $approver )
                {
                    if( $approver->approver_id == $this->user->user_id ){
                        $update_data = array('performance_status_id' => 4);
                        $where_array = array('id' => $approver->id);
                        //get previous data for audit logs
                        $previous_main_data = $this->db->get_where('performance_planning_approver', $where_array)->row_array();
                        $this->db->update('performance_planning_approver', $update_data, $where_array);

                        if( ($index+1) == $no_approvers ){
                            $update['to_user_id'] = $this->input->post('user_id');

                            $feed = array(
                                'status' => 'info',
                                'message_type' => 'Comment',
                                'user_id' => $this->user->user_id,
                                'feed_content' => 'Your performance targets have been approved.',
                                'uri' => $this->mod->route . '/review/'.$_POST['planning_id'].'/'.$_POST['user_id'],
                                'recipient_id' => $update['to_user_id']
                            );

                            $recipients = array($update['to_user_id']);
                            $this->system_feed->add( $feed, $recipients );

                            $this->response->notify[] = $update['to_user_id'];
                        

                            if( $fst_approver->approver_id != $approver->approver_id )
                            {
                                $feed = array(
                                'status' => 'info',
                                'message_type' => 'Comment',
                                'user_id' => $this->user->user_id,
                                'feed_content' => 'The performance targets of '.$appraisee->fullname.' has been approved.',
                                'uri' => $this->mod->route . '/review/'.$_POST['planning_id'].'/'.$_POST['user_id'],
                                'recipient_id' => $fst_approver->approver_id
                            );

                            $recipients = array($fst_approver->approver_id);
                            $this->system_feed->add( $feed, $recipients );

                            $this->response->notify[] = $fst_approver->approver_id;    
                            }

                        }
                        else{
                            $up = $approvers[$index+1];
                            $update['to_user_id'] = $up->approver_id;
                            $feed = array(
                                'status' => 'info',
                                'message_type' => 'Comment',
                                'user_id' => $this->user->user_id,
                                'feed_content' => 'Please review '.$appraisee->fullname.'\'s performance targets.',
                                'uri' => $this->mod->route . '/review/'.$_POST['planning_id'].'/'.$_POST['user_id'].'/'.$update['to_user_id'],
                                'recipient_id' => $update['to_user_id']
                            );

                            $recipients = array($update['to_user_id']);
                            $this->system_feed->add( $feed, $recipients );

                            $this->response->notify[] = $update['to_user_id'];
                        }
                    }
                }

                break;
            default: //draft
        }    
        //create system logs
        $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'performance_planning_approver', $previous_main_data, $update_data);
        $this->response->notify[] = $approver->approver_id;

        if( $status_id == 4 )
        {
            //get approvers
            $where = array(
                'planning_id' => $this->input->post('planning_id'),
                'user_id' => $this->input->post('user_id'),
            );
            $this->db->order_by('sequence');
            $approvers = $this->db->get_where('performance_planning_approver', $where)->result();
            switch ($condition) {
                case 'ALL':
                case 'By Level':
                    $all_approved = true;
                    foreach( $approvers as $approver )
                    {
                        if($approver->performance_status_id != 4)
                        {
                            $all_approved = false;
                            break;
                        }
                    }
                    if($all_approved)
                    {
                        $status_id = 4;
                    }
                    else{
                        $status_id = 2;
                    }
                    break;
                
                    # code...
                    break;
                case 'Either Of':
                    $one_approved = false;
                    foreach( $approvers as $approver )
                    {
                        if($approver->performance_status_id == 4)
                        {
                            $one_approved = true;
                            break;
                        }
                    }
                    if($one_approved)
                    {
                        $status_id = 4;
                    }
                    break;
            }
        }
        
        $update['status_id'] = $status_id;
        $where = array(
            'planning_id' => $this->input->post('planning_id'),
            'template_id' => $this->input->post('template_id'),
            'user_id' => $this->input->post('user_id'),
        );
    //get previous data for audit logs
        $previous_main_data = $this->db->get_where('performance_planning_applicable', $where)->row_array();
        $this->db->update('performance_planning_applicable', $update, $where);
        //create system logs
        $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', 'performance_planning_applicable', $previous_main_data, $update);
    
        $this->response->redirect = get_mod_route('performance_planning_manage');
    }


    function change_status( $return = false )
    {
        $this->_ajax_only();
        
        if( $this->input->post('manager_id') )
            $this->_change_status_approver();
        else
            $this->_change_status_partner();

        if( $return )
        {
            return true;
        }

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }

    function get_notes()
    {
        $this->_ajax_only();
        
        $vars = $_POST;
        $vars['notes'] = $this->mod->get_notes($_POST['planning_id'], $_POST['user_id']);
        $this->load->vars($vars);

        $data['title'] = 'For Discussion';
        $data['content'] = $this->load->blade('edit.notes')->with( $this->load->get_cached_vars() );

        $this->response->notes = $this->load->view('templates/modal', $data, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

    function save_note()
    {
        $this->_ajax_only();

        $this->change_status( true );

        if(trim($this->input->post('notes')) != ''){
            $insert = array(
                'planning_id' => $this->input->post('planning_id'),
                'user_id' => $this->input->post('user_id'),
                'notes' => $this->input->post('notes'),
                'created_by' => $this->user->user_id
            );

            $this->db->insert('performance_planning_notes', $insert);
            //create system logs
            $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'performance_planning_notes', array(), $insert);
        }
        
        if( isset($_POST['manager_id']) && !empty($_POST['manager_id']) )
            $this->response->redirect = get_mod_route('performance_planning_manage');
        else if( !isset($_POST['manager_id']) )
            $this->response->redirect = get_mod_route('appraisal_individual_planning');
        else
            $this->response->redirect = base_url();
        
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

    public function review_admin( $record_id, $user_id, $manager = '' )
    {
        parent::edit('', true);

        $appraisee = $vars['appraisee'] = $this->mod->get_appraisee( $this->record_id, $user_id );
        $vars['manager_id'] = '';
        $vars['current_user_id'] = $this->user->user_id;
        $vars['manager'] = $manager; 

        $vars['back_url_admin'] = get_mod_route('performance_planning_admin').'/index/'.$this->record_id;
        $this->load->model('appraisal_template_model', 'template');
        $vars['template'] = $this->template;
        $vars['templatefile'] = $this->template->get_template( $appraisee->template_id );

        $vars['approversLog'] = array();
        $approvers_log = "SELECT ppar.display_name, ppl.created_on, ppap.user_id, pstat.performance_status, REPLACE(pstat.class, 'btn', 'badge') as class, pos.position, ppap.to_user_id, ppar.approver_id  
                        FROM {$this->db->dbprefix}performance_planning_applicable ppap 
                        INNER JOIN {$this->db->dbprefix}performance_planning_approver ppar ON ppap.planning_id = ppar.planning_id AND ppap.user_id = ppar.appraisee_id 
                        INNER JOIN {$this->db->dbprefix}users_profile usp ON ppar.approver_id = usp.user_id
                        INNER JOIN {$this->db->dbprefix}users_position pos ON usp.position_id = pos.position_id
                        INNER JOIN {$this->db->dbprefix}performance_status pstat ON ppar.performance_status_id = pstat.performance_status_id 
                        LEFT JOIN {$this->db->dbprefix}performance_planning_logs ppl ON ppap.planning_id = ppl.planning_id 
                        AND ppap.user_id = ppl.user_id AND ppar.approver_id = ppl.to_user_id 
                        WHERE ppap.planning_id = {$appraisee->planning_id} AND ppap.user_id = {$appraisee->user_id} GROUP BY ppar.approver_id ORDER BY ppl.id ";

        $approversLog = $this->db->query($approvers_log);

        if( $approversLog && $approversLog->num_rows() > 0 ){
            $vars['approversLog'] = $approversLog->result_array();
        }

        $vars['transaction_type'] = 'view';

        $this->db->where('approver_id',$this->user->user_id);
        $this->db->where('performance_status_id',2);
        $this->db->order_by('sequence');
        $this->db->limit(1);
        $approver = $this->db->get('performance_planning_approver');
        if ($approver && $approver->num_rows() > 0){
            $approver_info = $approver->row();
            $vars['approver'] = $approver_info;
        }

        $this->load->vars( $vars );

        $this->load->helper('form');
        $this->load->helper('file');
        echo $this->load->blade('pages.review')->with( $this->load->get_cached_vars() );  
    }

    function view_discussion()
    {
        $this->_ajax_only();
        
        $vars = $_POST;
        $this->db->limit(1);
        $vars['planning'] = $this->db->get_where('performance_planning_applicable', array('planning_id' => $_POST['planning_id'], 'user_id' => $_POST['user_id']))->row();
        $vars['notes'] = $this->mod->get_notes($_POST['planning_id'], $_POST['user_id']);

        $planning_get_approvers = $this->db->query("CALL sp_performance_planning_get_approvers(".$_POST['planning_id'].", ".$_POST['user_id'].")")->result_array();
        mysqli_next_result($this->db->conn_id);

        $back_to = 0;
        $vars['sent_to'] = '';
        foreach ($planning_get_approvers as $approver){
            if($_POST['user_id'] == $this->user->user_id){
                if($approver['sequence'] == 1){
                    $user_details = $this->db->get_where('users_profile', array('user_id' => $approver['approver_id']))->row_array();
                    $vars['sent_to'] = $user_details['firstname'].' '.$user_details['lastname'];
                }
            }else{
                if($approver['approver_id'] == $this->user->user_id){
                    if($approver['sequence'] == 1){
                        $user_details = $this->db->get_where('users_profile', array('user_id' => $_POST['user_id']))->row_array();
                        
                        $vars['sent_to'] = $user_details['firstname'].' '.$user_details['lastname'];
                    }else{
                        $back_to = --$approver['sequence'];
                    }
                }   
            }
        }

        if($back_to > 0){
            foreach ($planning_get_approvers as $approver){
                if($approver['sequence'] == $back_to){
                    $user_details = $this->db->get_where('users_profile', array('user_id' => $approver['approver_id']))->row_array();
                    $vars['sent_to'] = $user_details['firstname'].' '.$user_details['lastname'];
                }
            }
        }

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
        //create system logs
        $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'performance_planning_notes', array(), $insert);
        
        // GET LATEST POSTED DATA AND RETURN IT BACK TO THE UI
        $new_notes_qry = " SELECT ud.department, CONCAT(up.lastname, ', ', up.firstname) as full_name, 
                    gettimeline('{$insert['created_on']}') as timeline, {$insert['created_by']} as created_by,
                    {$insert['user_id']} as user_id, up.photo
                    FROM {$this->db->dbprefix}users_profile up
                    LEFT JOIN {$this->db->dbprefix}users_department ud on ud.department_id = up.department_id 
                    WHERE up.user_id = {$this->user->user_id}";
                    
        $data['note'] = $this->db->query($new_notes_qry)->row_array();
        $data['note']['notes'] = $insert['notes'];
        $this->response->new_discussion   = $this->load->view('customs/new_discussion', $data, true);

        $this->response->message[] = array(
            'message' => 'Discussion successfully added.',
            'type' => 'success'
        );


        $this->_ajax_return();  
    }

    function get_crowdsource_draft()
    {
        $this->_ajax_only();  

        $where = array(
            'planning_id' => $this->input->post('planning_id'),
            'user_id' => $this->input->post('user_id'),
            'section_id' => $this->input->post('section_id')
        );
        $vars['planning'] = $this->db->get_where('performance_planning_applicable', array('planning_id' => $_POST['planning_id'], 'user_id' => $_POST['user_id']))->row();
        $vars['section'] = $this->db->get_where('performance_template_section', array('template_section_id' => $this->input->post('section_id')))->row();

        $this->db->limit(1);
        $crowdsource = $this->db->get_where('performance_planning_crowdsource', $where);
        if( $crowdsource->num_rows() )
        {
            $crowdsource = $crowdsource->row();
            $_POST['crowdsource_user_id'] = $crowdsource->crowdsource_user_id;
        }
        else
            $_POST['crowdsource_user_id'] = "";

        $this->load->vars($_POST);
        $this->load->vars($vars);
        
        $data['title'] = 'Crowdsource Draft';
        $data['description'] = 'Input crowdsource draft list on each section for future guide on appraisal.';
        $data['content'] = $this->load->view('edit/crowdsource_draft', '', true);
        $this->response->form = $this->load->view('templates/modal', $data, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }

    public function tag_user(){
        $this->_ajax_only();
        $data = array();
        $this->load->model('dashboard_model', 'dashboard');
        $data = $this->dashboard->getUsersTagList();
        header('Content-type: application/json');
        echo json_encode($data);
        die();
    }

    function save_crowdsource_draft()
    {
        $this->_ajax_only();
        $this->response->success = false;
        $crowdsource = $this->input->post('crowdsource_user_id');
        $section = $this->db->get_where('performance_template_section', array('template_section_id' => $this->input->post('section_id')))->row();
        
        if(empty( $crowdsource )){
            $this->response->message[] = array(
                'message' => 'Mininum number of crowdsource should be at least '. $section->min_crowdsource .'.',
                'type' => 'warning'
            );

            $this->_ajax_return();  
        }
        if( !empty( $section->min_crowdsource ) && !empty( $crowdsource ) )
        {
            $crowdsource = explode( ',', $crowdsource );
            if( sizeof( $crowdsource ) < $section->min_crowdsource )
            {
                $this->response->message[] = array(
                    'message' => 'Mininum number of crowdsource should be at least '. $section->min_crowdsource .'.',
                    'type' => 'warning'
                );

                $this->_ajax_return();   
            }
        }

        $users_info = $this->db->get_where('users_profile', array('user_id' => $this->input->post('user_id')) )->row_array();
        if( in_array($users_info['reports_to_id'], $crowdsource) ){
            $this->response->message[] = array(
                'message' => 'You cannot choose your immediate superior as your crowdsource.',
                'type' => 'warning'
            );
            $this->_ajax_return();  
        }

        $template_info = $this->db->get_where('performance_template', array('template_id' => $section->template_id))->row();
        if($template_info->max_crowdsource > 0){
            foreach ($crowdsource as $key => $value) {
                $crowdsource_count = "SELECT * FROM {$this->db->dbprefix}performance_planning_crowdsource
                                    WHERE planning_id = {$this->input->post('planning_id')} 
                                    AND FIND_IN_SET($value, crowdsource_user_id) AND section_id = {$this->input->post('section_id')} 
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

        $where = array(
            'planning_id' => $this->input->post('planning_id'),
            'user_id' => $this->input->post('user_id'),
            'section_id' => $this->input->post('section_id')
        );
        $this->db->limit(1);
        $check = $this->db->get_where('performance_planning_crowdsource', $where);
        if( $check->num_rows() )
            $this->db->update('performance_planning_crowdsource', array('crowdsource_user_id' => $this->input->post('crowdsource_user_id')), $where);
        else
            $this->db->insert('performance_planning_crowdsource', $_POST);

        $contributors = array();
        $this->response->list_of_contributors = '';
        $crowdsource_draft = array();
        $crowdsource_draft = $this->db->get_where('performance_planning_crowdsource', $where);
        if($crowdsource_draft->num_rows() > 0){
            $crowdsource_draft = $crowdsource_draft->row_array();   
            // $contributors = explode( ',', $crowdsource_draft['crowdsource_user_id'] );
            $contributors = $this->db->query("SELECT full_name FROM users WHERE user_id IN ({$crowdsource_draft['crowdsource_user_id']})")->result_array();
        // print_r($crowdsource_draft);
        }
        if(count($contributors) > 0){   
            $this->response->list_of_contributors .= '<label class="control-label ">List of Crowdsource</label><br>';
            foreach($contributors as $contributor){    
                $this->response->list_of_contributors .=  '<a class="btn default btn-sm">'. $contributor['full_name'].'</a>&nbsp;';
            }
        }

        $this->response->success = true;
        $this->response->tsection_id = $this->input->post('section_id');
        $this->response->message[] = array(
            'message' => 'Crowdsource successfully drafted.',
            'type' => 'success'
        );

        $this->_ajax_return();
    }
    

    function view_transaction_logs()
    {
        $this->_ajax_only();

        $approvers_list = array();
        $approvers = "SELECT ppa.display_name, upos.position FROM {$this->db->dbprefix}performance_planning_approver  ppa 
                        INNER JOIN {$this->db->dbprefix}users_profile up 
                        ON ppa.approver_id = up.user_id 
                        INNER JOIN {$this->db->dbprefix}users_position upos 
                        ON up.position_id = upos.position_id 
                        WHERE ppa.planning_id = {$_POST['planning_id']} AND ppa.user_id = {$_POST['user_id']}
                    ";
        $app_sql = $this->db->query($approvers);
        if($app_sql->num_rows() > 0){
            $approvers_list = $app_sql->result_array();
        }

        $logs_list = array();
        $logs = "SELECT CONCAT(up.firstname,' ',up.lastname) as partner_name, upos.position, 
                        ppa.created_on, performance_status, pstat.class 
                        FROM {$this->db->dbprefix}performance_planning_logs  ppa 
                        INNER JOIN {$this->db->dbprefix}users_profile up 
                        ON ppa.to_user_id = up.user_id
                        INNER JOIN {$this->db->dbprefix}users_position upos 
                        ON up.position_id = upos.position_id 
                        INNER JOIN {$this->db->dbprefix}performance_status pstat 
                        ON ppa.status_id = pstat.performance_status_id 
                        WHERE ppa.planning_id = {$_POST['planning_id']} AND ppa.user_id = {$_POST['user_id']}
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
