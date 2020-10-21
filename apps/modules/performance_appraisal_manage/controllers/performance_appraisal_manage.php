<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Performance_appraisal_manage extends MY_PrivateController
{
    private $current_user = array();
    private $hr_admin = 0;

	public function __construct()
	{
		$this->load->model('performance_appraisal_manage_model', 'mod');
		parent::__construct();
        $this->current_user = $this->config->item('user');
        $this->lang->load('performance_appraisal_manage');
        $this->hasAccessonAppraisalAdmin();   
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
        $permission = parent::_check_permission('performance_appraisal');
        $data['allow_admin'] = $permission['list'];

        $performance_appraisal_year = $this->db->get_where('performance_appraisal', array('deleted' => 0));
        $data['performance_appraisal_year'] = $performance_appraisal_year->result();

        $this->load->vars($data);
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
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

        $trash = $this->input->post('trash') == 'true' ? true : false;

        $records = $this->_get_list( $trash );
        $this->_process_lists( $records, $trash );

        $this->_ajax_return();
    }

    private function _process_lists( $records, $trash )
    {
        $this->response->records_retrieve = sizeof($records);
        $this->response->list = '';
        foreach( $records as $record )
        {
            $rec = array(
                'detail_url' => '#',
                'edit_url' => '#',
                'delete_url' => '#',
                'options' => ''
            );

            if(!$trash)
                $this->_list_options_active( $record, $rec );
            else
                $this->_list_options_trash( $record, $rec );

            $record = array_merge($record, $rec);
            $this->response->list .= $this->load->blade('list_template', $record, true)->with( $this->load->get_cached_vars() );
        }
    }

    private function _get_list( $trash )
    {
        $page = $this->input->post('page');
        $search = $this->input->post('search');
        $filter = "";
        
        $filter_by = $this->input->post('filter_by');
        $filter_value = $this->input->post('filter_value');
        
        if( is_array( $filter_by ) )
        {
            foreach( $filter_by as $filter_by_key => $filter_value )
            {
                if ($filter_by_key == 'status_id'){
                    $filter_by_key = 'ww_performance_appraisal.status_id';
                }

                if( $filter_value != "" ) $filter = 'AND '. $filter_by_key .' = "'.$filter_value.'"';   
            }
        }
        else{
            if( $filter_by && $filter_by != "" )
            {
                if ($filter_by == 'status_id'){
                    $filter_by = 'ww_performance_appraisal.status_id';
                }
                                
                $filter = 'AND '. $filter_by .' = "'.$filter_value.'"';
            }
        }

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
        
        $page = ($page-1) * 10;
        $records = $this->mod->_get_list($page, 10, $search, $filter, $trash);
        return $records;
    }

    function _list_options_active( $record, &$rec )
    {
        //add options to view users selected in appraisal
        $this->load->model('performance_appraisal_admin_model', 'appraise_admin');
        $rec['view_users'] = $this->appraise_admin->url . '/index/' . $record['record_id'];
        $rec['options'] .= '<li><a href="'.$rec['view_users'].'"><i class="fa fa-user"></i> '.lang('performance_appraisal_manage.view_emp').'</a></li>';

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

	function filter_status() {
		$this->_ajax_only();

		$department_id = $this->input->post('dept_id');
		$appraisal_id = $this->input->post('appraisal_id');
		$status_id = $this->input->post('status_id');

		$users = $this->mod->filter_status($department_id, $appraisal_id, $this->user->user_id, $status_id);

        $statuses = $this->db->get_where('performance_status', array('deleted' => 0))->result();
        foreach($statuses as $status)
        {
            $stat[$status->performance_status_id] = $status;
        }

		$this->response->filter_status = '';
		foreach($users as $user_id => $user){
			$_stat = $stat[$user['status_id']];
           $this->response->filter_status  .= '<span class="margin-right-5"><a type="button" class="'.$_stat->class.' label-sm margin-bottom-6" data-id="'.$user_id.'"> '.$user['name'].' </a></span>';
		}
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();
	}

	function review( $appraisal_id, $user_id, $manager_id = '' )
	{
		parent::edit('', true);

		$vars['appraisee'] = $appraisee = $this->mod->get_appraisee( $this->record_id, $user_id );
        $vars['self_review'] = $this->mod->get_self_review( $this->record_id, $user_id );
        $vars['manager_id'] = $manager_id; 

        //get approvers
        $where = array(
            'appraisal_id' => $appraisal_id,
            'user_id' => $user_id
        );
        $this->db->order_by('sequence');
        $approvers = $this->db->get_where('performance_appraisal_approver', $where)->result();
        foreach( $approvers as $approver )
        {
            if($approver->approver_id == $this->user->user_id)
                goto proceed;
        }

        if ($this->user->user_id == $appraisee->planning_created_by){
            goto proceed;
        }

        echo $this->load->blade('pages.not_under_attention')->with( $this->load->get_cached_vars() );
        die();

        proceed:

        $fstapprover = $approvers[0];
        $vars['approver'] = $approver;
        $this->load->model('appraisal_template_model', 'template');
        $vars['template'] = $this->template;
        $vars['templatefile'] = $this->template->get_template($appraisee->template_id); 

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
        if( $appraisee->to_user_id == $this->user->user_id && $appraisee->status_id == 7 )
        {
            echo $this->load->blade('pages.final_approval')->with( $this->load->get_cached_vars() ); 
        }
        else if( $appraisee->to_user_id == $this->user->user_id && $appraisee->status_id == 3 )
        {
            echo $this->load->blade('pages.pending')->with( $this->load->get_cached_vars() ); 
        }
        else if( $appraisee->to_user_id == $this->user->user_id && $appraisee->status_id == 11 )
        {
            echo $this->load->blade('pages.appraisers_review')->with( $this->load->get_cached_vars() ); 
        }
        else if( $appraisee->to_user_id == $this->user->user_id && $appraisee->status_id != 4 )
        {
            echo $this->load->blade('pages.review')->with( $this->load->get_cached_vars() ); 
        }
        else{
            echo $this->load->blade('pages.super')->with( $this->load->get_cached_vars() );   
        }        
    }

	function get_section_items()
    {
        // debug($_POST);
        $this->_ajax_only();
        
        $appraisee = $this->mod->get_appraisee( $this->input->post('appraisal_id'), $this->input->post('user_id') );
        // debug($this->db->last_query());
        $this->db->limit(1);
        $section = $this->db->get_where('performance_template_section', array('template_section_id' => $_POST['section_id']))->row();
        $this->load->vars( array('section' => $section) );

        //get approvers
        $where = array(
            'appraisal_id' => $this->input->post('appraisal_id'),
            'user_id' => $this->input->post('user_id')
        );
        $this->db->order_by('sequence');
        $approvers = $this->db->get_where('performance_appraisal_approver', $where)->result();
        foreach( $approvers as $approver )
        {
            if($approver->approver_id == $this->user->user_id || $this->hr_admin == 1)
                goto proceed;
        }
        
        $this->response->message[] = array(
            'message' => 'Record is not under your attention.',
            'type' => 'warning'
        );

        $this->_ajax_return(); 

        proceed:

        if( $approver->sequence > 1 && $approver->performance_status_id == 4 )
            $folder = 'super';
        else if( $approver->performance_status_id == 3 )
            $folder = 'pending';
        else if( $approver->sequence > 1 && $approver->performance_status_id != 4 )
            $folder = 'final_approval';
        else if( $appraisee->status_id == 11 )
            $folder = 'appraisers_review';
        else if( $appraisee->status_id == 4 )
            $folder = 'super';
        else
            $folder = 'review';

        switch($section->section_type_id)
        {
        	case 2:
        		$this->response->items = $this->load->view($folder.'/items_balancescorecard', $_POST, true);
        		break;
        	case 3:
        		$this->response->items = $this->load->view($folder.'/items_library', $_POST, true);
        		break;
        	case 4:
        		$this->response->items = $this->load->view($folder.'/items_library_crowd', $_POST, true);
        		break;
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

    function change_status( $return = false )
    {
        $this->_ajax_only();
        
        $this->db->trans_begin();
        $error = false;
        $this->response->validate_error = false;

        $appraisee = $this->mod->get_appraisee( $_POST['appraisal_id'], $_POST['user_id'] );      
        $approver = $this->mod->get_approver(  $_POST['appraisal_id'], $_POST['user_id'], $_POST['manager_id'] );
        if( !$approver )
        {
            $this->response->message[] = array(
                'message' => 'Record is not under your attention.',
                'type' => 'warning'
            );

            $this->_ajax_return();
        }

        $update['status_id'] = $status_id = $this->input->post('status_id');
        
        //get approvers
        $where = array(
            'appraisal_id' => $this->input->post('appraisal_id'),
            'user_id' => $this->input->post('user_id'),
        );
        $this->db->order_by('sequence');
        $approvers = $this->db->get_where('performance_appraisal_approver', $where)->result();
        $fstapprover = $approvers[0];
        $no_approvers = sizeof($approvers);
        $condition = $approvers[0]->condition;

        $this->response->redirect = false;
        $this->load->model('system_feed');
        switch( $status_id )
        {
            case 3: //pending
                //assume this is from approver
                //bring it down
                foreach(  $approvers as $index => $approver )
                {
                    if( $approver->approver_id == $this->user->user_id ){
                        if( $index != 0 ){
                            $down = $approvers[$index-1];
                            $this->db->update('performance_appraisal_approver', array('performance_status_id' => 3), array('id' => $down->id));
                            $this->db->update('performance_appraisal_approver', array('performance_status_id' => 0), array('id' => $approver->id));
                            $update['to_user_id'] = $down->approver_id;

                            $feed = array(
                                'status' => 'info',
                                'message_type' => 'Comment',
                                'user_id' => $this->user->user_id,
                                'feed_content' => 'Please review '.$appraisee->fullname.'\'s appraisal form.',
                                'uri' => $this->mod->route. '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'].'/'.$down->approver_id,
                                'recipient_id' => $down->approver_id
                            );

                            $recipients = array($down->approver_id);
                            $this->system_feed->add( $feed, $recipients );

                            $this->response->notify[] = $down->approver_id;
                        }
                    }
                }
                $this->response->redirect = site_url( $this->mod->route );
                break;
            case 6: //appraisees summary
                if( empty($_POST['supervisor_summary']) )
                {
                    $this->response->message[] = array(
                        'message' => 'Please add your comment on the summary section.',
                        'type' => 'error'
                    );
                    $error = true;
                }

                $update['to_user_id'] = $appraisee->user_id;
                $this->db->update('performance_appraisal_approver', array('performance_status_id' => 6), array('id' => $fstapprover->id));
                $this->db->update('performance_appraisal_applicable_user', array('to_user_id' => $appraisee->user_id, 'status_id' => 6), array( 'appraisal_id' => $this->input->post('appraisal_id'), 'user_id' => $this->input->post('user_id'))); 

                $feed = array(
                    'status' => 'info',
                    'message_type' => 'Comment',
                    'user_id' => $this->user->user_id,
                    'feed_content' => 'Please review your appraisal by '. $fstapprover->display_name .'.',
                    'uri' => get_mod_route('appraisal_individual_rate', '', false) . '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'],
                    'recipient_id' => $appraisee->user_id
                );

                $recipients = array($appraisee->user_id);
                $this->system_feed->add( $feed, $recipients );

                $this->response->notify[] = $appraisee->user_id;
                $this->response->redirect = true;

                break;
            case 7: //final approval
                //bring it up
                foreach(  $approvers as $index => $approver )
                {
                    if( $approver->approver_id == $this->user->user_id ){
                        $this->db->update('performance_appraisal_approver', array('performance_status_id' => 4), array('id' => $approver->id));

                        if( ($index+1) == $no_approvers ){
                            //single approver
                            $this->db->update('performance_appraisal_applicable_user', array('to_user_id' => $appraisee->user_id, 'status_id' => 4), array( 'appraisal_id' => $this->input->post('appraisal_id'), 'user_id' => $this->input->post('user_id')));  
                            
                            //notify appraisee
                            $update['status_id'] = 4;
                            $update['to_user_id'] = $appraisee->user_id;

                            $feed = array(
                                'status' => 'info',
                                'message_type' => 'Comment',
                                'user_id' => $this->user->user_id,
                                'feed_content' => 'Your performance form has been approved.',
                                'uri' => get_mod_route('appraisal_individual_rate', '', false) . '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'],
                                'recipient_id' => $appraisee->user_id
                            );

                            $recipients = array($appraisee->user_id);
                            $this->system_feed->add( $feed, $recipients );

                            $this->response->notify[] = $appraisee->user_id;
                        }
                        else{
                            $up = $approvers[$index+1];
                            $this->db->update('performance_appraisal_approver', array('performance_status_id' => 2), array('id' => $up->id));
                            $update['to_user_id'] = $up->approver_id; 
                            $feed = array(
                                'status' => 'info',
                                'message_type' => 'Comment',
                                'user_id' => $this->user->user_id,
                                'feed_content' => 'Please review '.$appraisee->fullname.'\'s performance form.',
                                'uri' => $this->mod->route . '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'].'/'.$update['to_user_id'],
                                'recipient_id' => $update['to_user_id']
                            );

                            $recipients = array($update['to_user_id']);
                            $this->system_feed->add( $feed, $recipients );

                            $this->response->notify[] = $update['to_user_id']; 
                        }
                    }
                }

                $this->response->redirect = true;
                break;
            case 4: //approved
                //bring it up
                foreach(  $approvers as $index => $approver )
                {
                    if( $approver->approver_id == $this->user->user_id ){
                        $this->db->update('performance_appraisal_approver', array('performance_status_id' => 4, 'approved_date' => date('Y-m-d H:i:s')), array('id' => $approver->id));

                        if( ($index+1) == $no_approvers ){
                            $this->db->update('performance_appraisal_approver', array('performance_status_id' => 4, 'approved_date' => date('Y-m-d H:i:s')), array('appraisal_id' => $_POST['appraisal_id'], 'user_id' => $_POST['user_id']));
                            $this->db->update('performance_appraisal_applicable_user', array('status_id' => 4, 'approved_date' => date('Y-m-d H:i:s')), array('appraisal_id' => $_POST['appraisal_id'], 'user_id' => $_POST['user_id']));
                            $status_id = 4;
                            
                            //notify appraisee
                            $update['to_user_id'] = $appraisee->user_id;

                            $feed = array(
                                'status' => 'info',
                                'message_type' => 'Comment',
                                'user_id' => $this->user->user_id,
                                'feed_content' => 'Your appraisal form has been approved.',
                                'uri' => get_mod_route('appraisal_individual_rate', '', false) . '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'],
                                'recipient_id' => $appraisee->user_id
                            );

                            $recipients = array($appraisee->user_id);
                            $this->system_feed->add( $feed, $recipients );

                            $this->response->notify[] = $appraisee->user_id;
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
                }
                $update['status_id'] = 7;
                $this->response->redirect = true;
                break;
            default: //draft
                $where = array(
                    'appraisal_id' => $this->input->post('appraisal_id'),
                    'user_id' => $this->input->post('user_id'),
                    'approver_id' => $this->user->user_id
                );
                $this->db->update('performance_appraisal_approver', array('performance_status_id' => 1), $where);
                unset($update);  
        }

        if( isset($_POST['appraisal_field']) )
        {
            $empty_fields = array();
            $fields = $_POST['appraisal_field'];
            foreach( $fields as $column_id => $items )
            {
                foreach( $items as $item_id => $value )
                {
                    if( $value == '' && $_POST['status_id'] > 1)
                    {
                        //check which item
                        // $this->db->where('performance_template_section_column.deleted', 0);
                        // $this->db->where('performance_template_section_column.section_column_id', $column_id);
                        // $this->db->join('performance_template_section', 'performance_template_section_column.template_section_id = performance_template_section.template_section_id', 'left');
                        // $item_columns = $this->db->get('performance_template_section_column')->row_array();
                        // // echo "<pre>\n{$this->db->last_query()}";
                        // $empty_fields[$item_columns['template_section']] = $item_columns['title'];

                        $this->response->message[] = array(
                            'message' => "Please fill out all fields highlighted with red.",
                            'type' => 'error'
                        );
                        $error = true;
                        $this->response->validate_error = true;
                        goto stop;
                    }

                    $insert = array(
                        'appraisal_id' => $this->input->post('appraisal_id'),
                        'user_id' => $this->input->post('user_id'),
                        'item_id' => $item_id,
                        'section_column_id' => $column_id, 
                        'value' => $value
                    );

                    $where = array(
                        'appraisal_id' => $this->input->post('appraisal_id'),
                        'user_id' => $this->input->post('user_id'),
                        'item_id' => $item_id,
                        'section_column_id' => $column_id 
                    );

                    $check = $this->db->get_where('performance_appraisal_fields', $where);
                    if($check->num_rows() > 0)
                    {
                        $this->db->update('performance_appraisal_fields', $insert, $where);
                    }   
                    else{
                        $this->db->insert('performance_appraisal_fields', $insert);
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
            // if( !empty($empty_fields) && count($empty_fields) > 0 ){
            //     $err_msg = 'The following fields are required: <br>';
            //     // $err_msg .= "<ul>";
            //     $last_column = '';
            //     foreach ( $empty_fields as $column => $empty_item ) {
            //         $err_msg .= "<br> - $empty_item on $column";
            //     }
            //     // $err_msg .= "</ul>";    
            //     $this->response->message[] = array(
            //         'message' => $err_msg,
            //         'type' => 'error'
            //     );
            //     $error = true;
            //     goto stop;
            // }
        }

        if( isset($_POST['pdp_library']) )
        {
            $pdp_library = $_POST['pdp_library'];
            $pdp_comment = $_POST['pdp_comment'];
            $pdp_date = $_POST['pdp_date'];
            foreach(  $pdp_library as $item_id => $cols )
            {
                foreach($cols as $column_id => $value)
                {
                    foreach($value as $index => $library_id){
                        $comment = $pdp_comment[$item_id][$column_id][$index];
                        $date = $pdp_date[$item_id][$column_id][$index];
                        
                        if( ($library_id == '' || $comment == '' || $date == '' ) && $_POST['status_id'] > 1)
                        {
                            $this->response->message[] = array(
                                'message' => "Please fill out all fields highlighted with red.",
                                'type' => 'error'
                            );
                            $error = true;
                            goto stop;
                        }

                        $insert = array(
                            'appraisal_id' => $this->input->post('appraisal_id'),
                            'user_id' => $this->input->post('user_id'),
                            'item_id' => $item_id,
                            'column_id' => $column_id,
                            'library_id' => $library_id,
                            'comment' => $comment,
                            'date' => $date
                        );

                        $where = array(
                            'appraisal_id' => $this->input->post('appraisal_id'),
                            'user_id' => $this->input->post('user_id'),
                            'item_id' => $item_id,
                            'column_id' => $column_id,
                            'library_id' => $library_id 
                        );

                        $check = $this->db->get_where('performance_appraisal_pdp', $where);
                        if($check->num_rows() > 0)
                        {
                            $this->db->update('performance_appraisal_pdp', $insert, $where);
                        }   
                        else{
                            $this->db->insert('performance_appraisal_pdp', $insert);
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
        }

        if( isset($_POST['performance_appraisal_personnel_action']) )
        {
            $_POST['performance_appraisal_personnel_action']['appraisal_id'] = $_POST['appraisal_id'];
            $_POST['performance_appraisal_personnel_action']['user_id'] = $_POST['user_id'];
            $_POST['performance_appraisal_personnel_action']['date'] = date('Y-m-d', strtotime($_POST['performance_appraisal_personnel_action']['date']));
            $this->db->delete('performance_appraisal_personnel_action', array('appraisal_id' => $_POST['appraisal_id'], 'user_id' => $_POST['user_id']));
            $this->db->insert('performance_appraisal_personnel_action', $_POST['performance_appraisal_personnel_action']);
        }

        if( $status_id == 4 )
        {
            $where = array(
                'appraisal_id' => $this->input->post('appraisal_id'),
                'user_id' => $this->input->post('user_id'),
            );
            $this->db->order_by('sequence');
            $approvers = $this->db->get_where('performance_appraisal_approver', $where)->result();
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
                    $all_approved = false;
                    foreach( $approvers as $approver )
                    {
                        if($approver->performance_status_id == 4)
                        {
                            $all_approved = true;
                            break;
                        }
                    }
                    if($all_approved)
                    {
                        $status_id = 4;
                    }
                    break;
            }

            if($all_approved)
            {
                $update['status_id'] = 4;
                $update['to_user_id'] = $appraisee->user_id;
                //notify appraisee
                $feed = array(
                    'status' => 'info',
                    'message_type' => 'Comment',
                    'user_id' => $this->user->user_id,
                    'feed_content' => 'Your appraisal form has been approved.',
                    'uri' => get_mod_route('appraisal_individual_rate', '', false) . '/review/'.$appraisee->appraisal_id.'/'.$appraisee->user_id,
                    'recipient_id' => $appraisee->user_id
                );

                $recipients = array($appraisee->user_id);
                $this->system_feed->add( $feed, $recipients );
                $this->response->notify[] = $appraisee->user_id;

                if($condition == 'By Level' && $no_approvers > 1)
                {
                    //notify first approver
                   $feed = array(
                        'status' => 'info',
                        'message_type' => 'Comment',
                        'user_id' => $this->user->user_id,
                        'feed_content' => $appraisee->fullname.'\'s appraisal form has been approved.',
                        'uri' => $this->mod->route. '/review/'.$appraisee->appraisal_id.'/'.$appraisee->user_id.'/'.$fstapprover->approver_id,
                        'recipient_id' => $fstapprover->approver_id
                    );

                    $recipients = array($fstapprover->approver_id);
                    $this->system_feed->add( $feed, $recipients );

                    $this->response->notify[] = $fstapprover->approver_id;
                }
                
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
        
        if(isset($_POST['supervisor_summary'])) $update['supervisor_summary'] = $this->input->post('supervisor_summary');
        if( empty( $appraisee->date ) )
        {
            $update['date'] = date('Y-m-d');
        }

        if( isset($update))
        {
            $where = array(
                'appraisal_id' => $this->input->post('appraisal_id'),
                'user_id' => $this->input->post('user_id')
            );
            $this->db->update('performance_appraisal_applicable', $update, $where);
            if($_POST['status_id'] > 1){
                if(isset($update['supervisor_summary'])) unset($update['supervisor_summary']);
                $this->db->update('performance_appraisal_applicable_user', $update, $where);
                $this->db->update('performance_appraisal_applicable', $update, $where);
            }
            
            if( $this->db->_error_message() != "" )
            {
                $this->response->message[] = array(
                    'message' => $this->db->_error_message(),
                    'type' => 'error'
                );
                $error = true;
            }
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

        if($_POST['status_id']==1){
            $this->response->message[] = array(
                'message' => 'Successfully saved as draft',
                'type' => 'success'
            );
        }else{
            $this->response->message[] = array(
                'message' => '',
                'type' => 'success'
            );
        }

        $this->_ajax_return();
    }
    
    function review_admin( $appraisal_id, $user_id, $manager_id = '' )
    {
        parent::edit('', true);

        $appraisee = $vars['appraisee'] = $this->mod->get_appraisee( $this->record_id, $user_id );
        $vars['self_review'] = $this->mod->get_self_review( $this->record_id, $user_id );

        $vars['manager_id'] = $manager_id; 

        $this->load->model('appraisal_template_model', 'template');
        $vars['template'] = $this->template;
        $vars['templatefile'] = $this->template->get_template( $appraisee->template_id ); 

        $this->load->vars( $vars );

        $this->load->helper('form');
        $this->load->helper('file');
        echo $this->load->blade('pages.super')->with( $this->load->get_cached_vars() );  
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
        
        if( !empty($_POST['status_id']) )
            $this->change_status();

        $this->response->message[] = array(
            'message' => 'Discussion successfully added.',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

    function add_tripart()
    {
        $this->_ajax_only();
        

        $this->response->tripart = $this->load->view('review/tripart_form', $_POST, true);

        $this->response->message[] = array(
            'message' => 'Discussion successfully added.',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

    function hasAccessonAppraisalAdmin(){
        $user_setting = APPPATH . 'config/users/'. $this->user->user_id .'.php';
        $user_id = $this->user->user_id;
        $this->load->config( "users/{$user_id}.php", false, true );
        $user = $this->config->item('user');

        $this->load->config( 'roles/'. $user['role_id'] .'/permission.php', false, true );
        $permission = $this->config->item('permission');
        $this->load->model('performance_appraisal_admin_model', 'appraisal_admin');

        $this->hr_admin = isset($permission[$this->appraisal_admin->mod_code]['list']) ? $permission[$this->appraisal_admin->mod_code]['list'] : 0;
    }

    function cs_discussion()
    {
        $this->_ajax_only();
        
        $vars = $_POST;
        $this->load->model('appraisal_individual_rate_model', 'air');
        $vars['discussions'] = $this->air->get_cs_discussion($_POST['appraisal_id'],$_POST['section_id'], $_POST['user_id'], $_POST['contributor_id']);
        $this->load->vars($vars);

        // if( !empty( $_POST['contributor_id'] ) )
        // {
            $contributor = $this->db->get_where('users', array('user_id' => $_POST['user_id']))->row();
            $data['title'] = $contributor->full_name . '<br><span class="text-muted">Discussion Logs</span>';
        // }
        // else{
        //     $data['title'] = 'OD and Training' . '<br><span class="text-muted">Discussion Logs</span>';     
        // }

        $data['content'] = $this->load->blade('customs.discussion_form')->with( $this->load->get_cached_vars() );

        $this->response->notes = $this->load->view('templates/modal', $data, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

    function get_rating_class()
    {
        $this->_ajax_only();
        $this->load->model('rating_class_model', 'rc');
        $this->_ajax_return();
    }

    function view_transaction_logs()
    {
        $this->_ajax_only();

        $approvers_list = array();
        $approvers = "SELECT ppa.display_name, upos.position FROM {$this->db->dbprefix}performance_appraisal_approver  ppa 
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