<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Performance_appraisal_contributor extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('performance_appraisal_contributor_model', 'mod');
		parent::__construct();
	}

    public function index()
    {
        if( !$this->permission['list'] )
        {
            echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
            die();
        }
        
        $permission = parent::_check_permission('appraisal_individual_rate');
        $data['allow_personal'] = $permission['list'];
        $permission = parent::_check_permission('performance_appraisal_manage');
        $data['allow_manage'] = $permission['list'];

        $this->load->vars($data);
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }

    function edit( $appraisal_id, $user_id, $manager_id = '' )
    {
        $this->review( $appraisal_id, $user_id, $manager_id );
    }

	function review( $appraisal_id, $user_id, $manager_id = '' )
	{
		parent::edit('', true);

		$appraisee = $vars['appraisee'] = $this->mod->get_appraisee( $this->record_id, $user_id, $this->user->user_id );
        $vars['manager_id'] = $manager_id; 

        $this->load->model('appraisal_template_model', 'template');
        $vars['template'] = $this->template;
        $vars['templatefile'] = $this->template->get_template( $appraisee->template_id ); 

        $this->load->vars( $vars );

        $this->load->helper('form');
        $this->load->helper('file');
        echo $this->load->blade('pages.review')->with( $this->load->get_cached_vars() );  
	}

	function get_section_items()
    {
        $this->_ajax_only();
        
        $appraisee = $this->mod->get_appraisee( $this->input->post('appraisal_id'), $this->input->post('user_id'), $this->input->post('manager_id') );
        $this->db->limit(1);
        $section = $this->db->get_where('performance_template_section', array('template_section_id' => $_POST['section_id']))->row();
        $this->response->items = "";
        switch($section->section_type_id)
        {
        	case 4:
        		$this->response->items = $this->load->view('review/items_library_crowd', $_POST, true);
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

    function change_status()
    {
        $this->_ajax_only();
        
        $this->db->trans_begin();
        $error = false;
        $this->response->redirect = true;

        $appraisee = $this->mod->get_appraisee( $this->input->post('appraisal_id'), $this->input->post('user_id'), $this->input->post('manager_id') );

        if( $appraisee->contributor_id != $this->user->user_id )
        {
            $this->response->message[] = array(
                'message' => 'Record is not under your attention.',
                'type' => 'warning'
            );

            $this->_ajax_return();
        }

        if( isset($_POST['appraisal_field']) )
        {
            $fields = $_POST['appraisal_field'];
            foreach( $fields as $column_id => $items )
            {
                foreach( $items as $item_id => $value )
                {
                    if( $value == '' && $_POST['status_id'] == 4)
                    {
                        $this->response->message[] = array(
                            'message' => "Please fillup all fields.",
                            'type' => 'error'
                        );
                        $error = true;
                        goto stop;
                    }

                    $insert = array(
                        'appraisal_id' => $this->input->post('appraisal_id'),
                        'user_id' => $this->input->post('user_id'),
                        'contributor_id' => $this->user->user_id,
                        'item_id' => $item_id,
                        'section_column_id' => $column_id, 
                        'value' => $value
                    );

                    $where = array(
                        'appraisal_id' => $this->input->post('appraisal_id'),
                        'user_id' => $this->input->post('user_id'),
                        'contributor_id' => $this->user->user_id,
                        'item_id' => $item_id,
                        'section_column_id' => $column_id 
                    );

                    $check = $this->db->get_where('performance_appraisal_contributor_fields', $where);
                    if($check->num_rows() > 0)
                    {
                        $this->db->update('performance_appraisal_contributor_fields', $insert, $where);
                    }   
                    else{
                        $this->db->insert('performance_appraisal_contributor_fields', $insert);
                    }

                    if( $this->db->_error_message() != "" )
                    {
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

        $where = array(
            'appraisal_id' => $this->input->post('appraisal_id'),
            'user_id' => $this->input->post('user_id'),
            'contributor_id' => $this->user->user_id,
        );

        if( in_array($appraisee->status_id, array(0,1)) ){
            $update['status_id'] = $this->input->post('status_id');
        }else{
            if( in_array($this->input->post('status_id'), array(4)) ){
                $update['status_id'] = $this->input->post('status_id');
            }else{
                $update['status_id'] = 3;
            }
        }
        
        $this->db->update('performance_appraisal_contributor', $update, $where);

        if( $this->db->_error_message() != "" )
        {
            $this->response->message[] = array(
                'message' => $this->db->_error_message(),
                'type' => 'error'
            );
            $error = true;
        }

        //notify appraisee
        $user = $this->config->item('user');
        $this->load->model('system_feed');
        $feed = array(
            'status' => 'info',
            'message_type' => 'Comment',
            'user_id' => $this->user->user_id,
            'feed_content' => 'Please review your Crowdsourcing Form from '. $user['lastname'] .', '. $user['firstname'],
            'uri' => get_mod_route('appraisal_individual_rate', '', false) . '/crowdsource/'.$_POST['appraisal_id'].'/'.$_POST['user_id'],
            'recipient_id' => $_POST['user_id']
        );

        $recipients = array($_POST['user_id']);
        $this->system_feed->add( $feed, $recipients );

        $this->response->notify[] = $_POST['user_id'];

        //check all contributor
        $where = array(
            'appraisal_id' => $this->input->post('appraisal_id'),
            'user_id' => $this->input->post('user_id'),
        );
        $contributor = $this->db->get_where('performance_appraisal_contributor', $where);
        $all_done = true;
        foreach( $contributor->result() as $cs )
        {
            if( $cs->status_id != 4 )
            {
                $all_done = false;
                break;  
            }
        }

        if( $all_done )
        {
            $this->db->update('performance_appraisal_applicable', array('cs_status' => 3), $where);
        }

        stop:
        if( !$error ){
            $this->db->trans_commit();
        }
        else{
             $this->db->trans_rollback();
             $this->response->redirect = false;
        }

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
        $this->load->model('appraisal_individual_rate_model', 'air');
        $vars['discussions'] = $this->air->get_cs_discussion($_POST['appraisal_id'], $_POST['section_id'], $_POST['user_id'], $_POST['contributor_id']);
        $this->load->vars($vars);

        $contributor = $this->db->get_where('users', array('user_id' => $_POST['contributor_id']))->row();

        $data['title'] = $contributor->full_name .
        '<br><span class="text-muted">Discussion Logs</span>';
        $data['content'] = $this->load->blade('review.discussion_form')->with( $this->load->get_cached_vars() );

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

        $appraisee = $this->mod->get_appraisee( $this->input->post('appraisal_id'), $this->input->post('user_id'), $this->input->post('note_to') );
        
        $insert = $_POST;

        $this->db->insert('performance_appraisal_contributor_notes', $insert);
        
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->response->redirect = false;

        $this->_ajax_return();     
    }
}