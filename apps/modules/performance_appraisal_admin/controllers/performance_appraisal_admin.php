<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Performance_appraisal_admin extends MY_PrivateController
{
	private $current_user = array();

	public function __construct()
	{
		$this->load->model('appraisal_individual_rate_model', 'mod_personal');
		$this->load->model('performance_appraisal_admin_model', 'mod');
		$this->load->model('performance_appraisal_manage_model', 'mod_manage');
		parent::__construct();

		$this->current_user = $this->config->item('user');
		$this->lang->load('performance_appraisal_admin');
	}
	
	public function index($appraisal_id=0)
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}
		
		$data['appraisal_id'] = $appraisal_id;
		$data['status'] = $this->db->get_where('performance_status', array('deleted' => 0))->result();


		$this->load->vars( $data );
		echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
	}

	function review( $appraisal_id, $user_id )
    {
        parent::edit('', true);

        $this->load->model('performance_appraisal_manage_model', 'pam');
        $appraisee = $vars['appraisee'] = $this->pam->get_appraisee( $this->record_id, $user_id );
        $vars['self_review'] = $this->pam->get_self_review( $this->record_id, $user_id );

        $vars['back_url_admin'] = get_mod_route('performance_appraisal_admin').'/index/'.$this->record_id;
        $this->load->model('appraisal_template_model', 'template');
        $vars['template'] = $this->template;
        $vars['templatefile'] = $this->template->get_template( $appraisee->template_id ); 

        $vars['approversLog'] = array();
        $approvers_log = "SELECT IF(ppar.display_name='', CONCAT(usp.lastname,' ',usp.firstname), ppar.display_name) AS display_name, 
                        ppl.created_on, ppap.user_id, pstat.performance_status, REPLACE(pstat.class, 'btn', 'badge') as class, ppar.approved_date, pos.position, ppap.to_user_id, ppar.approver_id  
                        FROM {$this->db->dbprefix}performance_appraisal_applicable ppap 
                        INNER JOIN {$this->db->dbprefix}performance_appraisal_approver ppar ON ppap.appraisal_id = ppar.appraisal_id 
                        AND ppap.user_id = ppar.appraisee_id 
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
		
		$this->db->where('approver_id',$this->user->user_id);
		$this->db->where('performance_status_id',2);
		$this->db->order_by('sequence');
		$this->db->limit(1);
        $approver = $this->db->get('performance_appraisal_approver');
        if ($approver && $approver->num_rows() > 0){
        	$approver_info = $approver->row();
        	$vars['approver'] = $approver_info;
        }

        $this->db->where('user_id',$appraisee->user_id);
        $this->db->where('appraisal_id',$appraisee->appraisal_id);
        $appraisal_info = $this->db->get('performance_appraisal_applicable');

        $vars['applicable_status_id'] = $appraisal_info->row()->status_id; 
        $vars['appraisal_date'] = $appraisal_info->row()->approved_date;

        $vars['login_user_id'] = $this->user->user_id;

        $this->load->vars( $vars );

        $this->load->helper('form');
        $this->load->helper('file');
        echo $this->load->blade('pages.review')->with( $this->load->get_cached_vars() );  
    }

	public function get_list($appraisal_id=0)
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

		$trash = $this->input->post('trash') == 'true' ? true : false;

		$records = $this->_get_list( $trash,  $appraisal_id);
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

			//get crowdsource
			$rec['crowdsource'] = $this->db->get_where('performance_appraisal_contributor', array('appraisal_id' => $record['record_id'], 'user_id' => $record['user_id']))->num_rows();

			if(!$trash)
				$this->_list_options_active( $record, $rec );
			else
				$this->_list_options_trash( $record, $rec );

			$rec['mod_manage'] = $this->mod_manage;

			$record = array_merge($record, $rec);
			$this->response->list .= $this->load->blade('list_template', $record, true)->with( $this->load->get_cached_vars() );
		}
	}

	private function _get_list( $trash, $appraisal_id=0 )
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
				if( $filter_value != "" ) $filter = 'AND '. $filter_by_key .' = "'.$filter_value.'"';	
			}
		}
		else{
			if( $filter_by && $filter_by != "" )
			{
				$filter = 'AND '. $filter_by .' = "'.$filter_value.'"';
			}
		}

		if($appraisal_id > 0){
			$filter .= " AND {$this->db->dbprefix}{$this->mod->table}.{$this->mod->primary_key} = {$appraisal_id}";
		}else{
			$filter .= " AND 1 <> 1";
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

    function get_observations()
    {
        $this->_ajax_only();
        
        $vars = $_POST;
        $vars['user_id'] = $_POST['user_id'];
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

		$data['current_user'] 	= $this->session->userdata['user']->user_id;
		$data['user_id'] 		= $this->session->userdata['user']->user_id; 								// THE CURRENT LOGGED IN USER 
		$data['display_name'] 	= $this->current_user['lastname']. ", ". $this->current_user['firstname'];	// THE CURRENT LOGGED IN USER'S DISPLAY NAME
		$data['feed_content'] 	= mysqli_real_escape_string($this->db->conn_id, $_POST['observation_message']);		// THE MAIN FEED BODY
		$data['recipient_id'] 	= '0';																		// TO WHOM THIS POST IS INTENDED TO
		$data['status'] 		= 'info';																	// DANGER, INFO, SUCCESS & WARNING
		
		$data['recipients']	=  $this->input->post('user_id') === '' ? array() : explode(',', $this->input->post('user_id'));
		$data['to']				= 'user'; // TODO: change this when division is okay!!!

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
		$this->response->target	= $latest;

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

		$data['department']				= $dept['department'];
		$data['observations'] 			= $this->dashboard_mod->getLatestPostData($latest, $data['user_id'] );
		$this->response->new_feedback 	= $this->load->view('customs/obervation_display', $data, true);
		
		// NOW TELL THESE RECIPIENTS THEY'VE GOT SOMETHING!
		$this->response->recipients = $data['recipients'];
		$this->response->action 		= 'insert';
		// determines to where the action was 
		// performed and used by after_save to
		// know which notification to broadcast
		$this->response->type 			= 'feed';

        $this->response->message[] = array(
		    'message' => 'Feedback successfully added.',
		    'type' => 'success'
		);

    	$this->_ajax_return();	
	}

	function crowdsource( $record_id, $user_id )
    {
        parent::edit('', true);

        $this->load->model('performance_appraisal_manage_model', 'pam');
        $appraisee = $vars['appraisee'] = $this->pam->get_appraisee( $this->record_id, $user_id );
        
        $vars['back_url_admin'] = get_mod_route('performance_appraisal_admin').'/index/'.$this->record_id;
        $this->load->model('appraisal_template_model', 'template');
        $vars['template'] = $this->template;
        $vars['templatefile'] = $this->template->get_template( $appraisee->template_id ); 

        $vars['approversLog'] = array();
        $approvers_log = "SELECT ppar.display_name, ppl.created_on, ppap.user_id, pstat.performance_status, REPLACE(pstat.class, 'btn', 'badge') as class, pos.position, ppap.to_user_id, ppar.approver_id  
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

	function get_section_items()
    {
        $this->_ajax_only();
        $this->load->model('performance_appraisal_manage_model', 'pam');
        $appraisee = $this->pam->get_appraisee( $this->input->post('appraisal_id'), $this->input->post('user_id') );
        $this->db->limit(1);
        $section = $this->db->get_where('performance_template_section', array('template_section_id' => $_POST['section_id']))->row();
        $this->load->vars( array('section' => $section) );
        
        $_POST['applicable_status_id'] = $appraisee->status_id;

        switch( $appraisee->status_id )
        {
            case 9:
                $folder = 'crowdsource';
                break;    
            default:
                $folder = 'review';
        }

        $this->response->items = "";
        switch($section->section_type_id)
        {
            case 2:
                $this->response->items = $this->load->view($folder.'/section_items', $_POST, true);
                break;
            case 3:
                $this->response->items = $this->load->view($folder.'/items_library', $_POST, true);
                break;
            case 4:
                $this->response->items = $this->load->view($folder.'/items_library_crowd', $_POST, true);
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

    function change_status( $return = false )
    {
        $this->_ajax_only();

        $error = false;
        if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			$this->response->message[] = array(
	            'message' => lang('common.insufficient_permission'),
	            'type' => 'warning'
	        );
			$this->_ajax_return();
		}
		$this->load->model('performance_appraisal_manage_model', 'pam');
        $appraisee = $this->pam->get_appraisee( $_POST['appraisal_id'], $_POST['user_id'] );
        $update['status_id'] = $status_id = $this->input->post('status_id');
        $this->load->model('system_feed');
        switch( $status_id )
        {
        	case 3: //save as draft or pending

        		$where = array(
		            'appraisal_id' => $this->input->post('appraisal_id'),
		            'user_id' => $this->input->post('user_id')
		        );
		        
		        $this->db->update('performance_appraisal_applicable_user', $update, $where);

		        $this->db->update('performance_appraisal_applicable', $update, $where);

        		//notify appraisee
/*                $feed = array(
                    'status' => 'info',
                    'message_type' => 'Comment',
                    'user_id' => $this->user->user_id,
                    'feed_content' => 'Please revise your appraisal form',
                    'uri' => get_mod_route('appraisal_individual_rate', '', false) . '/edit/'.$_POST['appraisal_id'].'/'.$_POST['user_id'],
                    'recipient_id' => $appraisee->user_id
                );

                $recipients = array($appraisee->user_id);
                $this->system_feed->add( $feed, $recipients );

                $this->response->notify[] = $appraisee->user_id;*/
        	break;
            case 2: //for approval
		        //get approvers
		        $where = array(
		            'appraisal_id' => $this->input->post('appraisal_id'),
		            'user_id' => $this->user->user_id,
		            'appraisee_id' => $appraisee->user_id,
		            'performance_status_id' => 0,
		        );
		        $this->db->limit(1);
		        $this->db->order_by('sequence');
		        $approvers = $this->db->get_where('performance_appraisal_approver', $where);

		        if ($approvers && $approvers->num_rows() > 0){
		        	$approver = $approvers->row();

			        $where = array(
			            'id' => $approver->id
			        );

			        $update_approver['performance_status_id'] = $this->input->post('status_id');

					$this->db->update('performance_appraisal_approver', $update_approver, $where);

                    $feed = array(
                        'status' => 'info',
                        'message_type' => 'Performance Appraisal',
                        'user_id' => $this->user->user_id,
                        'feed_content' => 'Please review '.$appraisee->fullname.'\'s appraisal form.',
                        'uri' => $this->mod->route. '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'].'/'.$approver->approver_id,
                        'recipient_id' => $approver->approver_id
                    );

                    $recipients = array($approver->approver_id);
                    $this->system_feed->add( $feed, $recipients );

                    $this->response->notify[] = $approver->approver_id;		        	
	            }

		        $where = array(
		            'appraisal_id' => $this->input->post('appraisal_id'),
		            'user_id' => $this->input->post('user_id')
		        );

		        $this->db->update('performance_appraisal_applicable_user', $update, $where);

		        $this->db->update('performance_appraisal_applicable', $update, $where);

                $this->response->redirect = site_url( $this->mod->route );
                break;   
            case 4: //approved
		        //get approvers
		        $where = array(
		            'appraisal_id' => $this->input->post('appraisal_id'),
		            'appraisee_id' => $appraisee->user_id,
		            'approver_id' => $this->user->user_id,
		        );

		        $update_approver['performance_status_id'] = $this->input->post('status_id');

				$this->db->update('performance_appraisal_approver', $update_approver, $where);

		        $where = array(
		            'appraisal_id' => $this->input->post('appraisal_id'),
		            'user_id' => $this->user->user_id,
		            'appraisee_id' => $appraisee->user_id,
		            'performance_status_id' => 0,
		        );
		        $this->db->limit(1);
		        $this->db->order_by('sequence');
		        $approvers = $this->db->get_where('performance_appraisal_approver', $where);

		        if ($approvers && $approvers->num_rows() > 0){
		        	$approver = $approvers->row();

			        $where = array(
			            'id' => $approver->id
			        );

			        $update_approver['performance_status_id'] = 2;

					$this->db->update('performance_appraisal_approver', $update_approver, $where);        	

	                $feed = array(
	                    'status' => 'info',
	                    'message_type' => 'Performance Appraisal',
	                    'user_id' => $this->user->user_id,
	                    'feed_content' => 'Please review '.$appraisee->fullname.'\'s appraisal form.',
	                    'uri' => $this->mod->route. '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'].'/'.$approver->approver_id,
	                    'recipient_id' => $approver->approver_id
	                );

	                $recipients = array($approver->approver_id);
	                $this->system_feed->add( $feed, $recipients );

	                $this->response->notify[] = $approver->approver_id;						
	            }

	            //update appraisal applcable status
		        $where = array(
		            'appraisal_id' => $this->input->post('appraisal_id'),
		            'user_id' => $this->input->post('user_id')
		        );

		        $this->db->update('performance_appraisal_applicable_user', $update, $where);

		        $this->db->update('performance_appraisal_applicable', $update, $where);

                $this->response->redirect = site_url( $this->mod->route );

                //notifications for employee appraisal
                $feed = array(
                    'status' => 'info',
                    'message_type' => 'Performance Appraisal',
                    'user_id' => $this->user->user_id,
                    'feed_content' => 'Please review '.$appraisee->fullname.'\'s appraisal form.',
                    'uri' => $this->mod_personal->route. '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'],
                    'recipient_id' => $appraisee->user_id
                );

                $recipients = array($appraisee->user_id);
                $this->system_feed->add( $feed, $recipients );

                $this->response->notify[] = $appraisee->user_id;	

                //notifications for employee appraisal immediate
                $feed = array(
                    'status' => 'info',
                    'message_type' => 'Performance Appraisal',
                    'user_id' => $this->user->user_id,
                    'feed_content' => 'Please review '.$appraisee->fullname.'\'s appraisal form.',
                    'uri' => $this->mod->route. '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'],
                    'recipient_id' => $appraisee->planning_created_by
                );

                $recipients = array($appraisee->planning_created_by);
                $this->system_feed->add( $feed, $recipients );

                $this->response->notify[] = $appraisee->planning_created_by;	
                break;   
        	case 1: //disapproved

		        $where = array(
		            'appraisal_id' => $this->input->post('appraisal_id'),
		            'appraisee_id' => $appraisee->user_id,
		            'approver_id' => $this->user->user_id,
		        );

		        $update_approver['performance_status_id'] = 12;

				$this->db->update('performance_appraisal_approver', $update_approver, $where);

        		$where = array(
		            'appraisal_id' => $this->input->post('appraisal_id'),
		            'user_id' => $this->input->post('user_id')
		        );
		        
		        $this->db->update('performance_appraisal_applicable_user', $update, $where);

		        $this->db->update('performance_appraisal_applicable', $update, $where);

        		//notify appraisee
/*                $feed = array(
                    'status' => 'info',
                    'message_type' => 'Comment',
                    'user_id' => $this->user->user_id,
                    'feed_content' => 'Please revise your appraisal form',
                    'uri' => get_mod_route('appraisal_individual_rate', '', false) . '/edit/'.$_POST['appraisal_id'].'/'.$_POST['user_id'],
                    'recipient_id' => $appraisee->user_id
                );

                $recipients = array($appraisee->user_id);
                $this->system_feed->add( $feed, $recipients );

                $this->response->notify[] = $appraisee->user_id;*/
        	break;                                     	
        	case 10:
        		$where = array(
		            'appraisal_id' => $this->input->post('appraisal_id'),
		            'user_id' => $this->input->post('user_id')
		        );
		        $this->db->update('performance_appraisal_applicable_user', $update, $where);

		        $update['status_id'] = 5;
       			
        		//get approvers
		        $where = array(
		            'appraisal_id' => $this->input->post('appraisal_id'),
		            'appraisee_id' => $appraisee->user_id,
		            'user_id' => $this->input->post('user_id'),
		        );
		        $this->db->order_by('sequence');
		        $approvers = $this->db->get_where('performance_appraisal_approver', $where)->result();
		        $fstapprover = $approvers[0];
		        $no_approvers = sizeof($approvers);
		        $condition = $approvers[0]->condition;
		        $update['to_user_id'] = $fstapprover->approver_id;

		        $this->db->update('performance_appraisal_applicable', $update, $where);

		        //notify approver
        		$feed = array(
                    'status' => 'info',
                    'message_type' => 'Comment',
                    'user_id' => $this->user->user_id,
                    'feed_content' => $appraisee->fullname.' appraisal form is ready for your assessment.',
                    'uri' => get_mod_route('performance_appraisal_manage', '', false) . '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'].'/'.$fstapprover->approver_id,
                    'recipient_id' => $fstapprover->approver_id
                );

                $recipients = array($fstapprover->approver_id);
                $this->system_feed->add( $feed, $recipients );

                $this->response->notify[] = $fstapprover->approver_id;

                //notify appraisee
                $feed = array(
                    'status' => 'info',
                    'message_type' => 'Comment',
                    'user_id' => $this->user->user_id,
                    'feed_content' => 'Your appraisal form has been forwarded to your immediate superior.',
                    'uri' => get_mod_route('appraisal_individual_rate', '', false) . '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'],
                    'recipient_id' => $appraisee->user_id
                );

                $recipients = array($appraisee->user_id);
                $this->system_feed->add( $feed, $recipients );

                $this->response->notify[] = $appraisee->user_id;

        	break;
        }

/*        if (isset($_POST['item'])){
	        $item = $_POST['item'];
	        $field = $_POST['field'];

	        $this->db->where('planning_id',$this->input->post('record_id'));
	        $this->db->delete('performance_planning_applicable_items');

	        $this->db->where('planning_id',$this->input->post('record_id'));
	        $this->db->delete('performance_planning_applicable_items_header');

	        $this->db->where('planning_id',$this->input->post('record_id'));
	        $this->db->delete('performance_planning_applicable_fields');

	        $this->db->where('planning_id',$this->input->post('record_id'));
	        $this->db->delete('performance_planning_applicable_fields_header');
	        			        			        			        
	        $ctr = 1;
	        foreach ($item as $key_item => $value_item) {
	        	foreach ($value_item as $key1 => $value1) {
	        		$item_info = array(
	        				'planning_id' => $this->input->post('record_id'),
	        				'user_id' => $id,
	        				'section_column_id' => $key_item,
	        				'item' => $key1 + 1,
	        				'parent_id' => ($value1 == 1 ? 1 : ''),
	        				'sequence' => $ctr
	        			);
					
                	$this->db->insert('performance_planning_applicable_items',$item_info);
                	$item_id = $this->db->insert_id();

                	$this->db->insert('performance_planning_applicable_items_header',$item_info);
                	$item_id_header = $this->db->insert_id();

	        		$field_info = array(
	        				'planning_id' => $this->input->post('record_id'),
	        				'user_id' => $id,
	        				'item_id' => $item_id,
	        				'section_column_id' => $key_item,
	        				'value' => (isset($field[$key_item][$key1]) ? $field[$key_item][$key1] : '')
	        			);   

					$this->db->insert('performance_planning_applicable_fields',$field_info);

					$this->db->insert('performance_planning_applicable_fields_header',$field_info);
                    $ctr++;
                }
	        }	
	    }
*/
        if( isset($_POST['appraisal_field']) )
        {
            $empty_fields = array();
            $fields = $_POST['appraisal_field'];

            foreach( $fields as $column_id => $items )
            {
                foreach( $items as $item_id => $value )
                {
/*                    if( $value == '' && $_POST['status_id'] > 1)
                    {
                        $this->response->message[] = array(
                            'message' => "Please fill out all fields highlighted with red.",
                            'type' => 'error'
                        );
                        $error = true;
                        $this->response->validate_error = true;
                        goto stop;
                    }*/

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


		$this->response->appraisal_id = $_POST['appraisal_id'];
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );
        $this->response->redirect = $this->mod->url . '/index/'.$this->input->post('appraisal_id');

        $this->_ajax_return();
    }

    function cs_discussion()
    {
        $this->_ajax_only();
        
        $vars = $_POST;
        $vars['created_by'] = $this->user->user_id;
        $this->load->model('appraisal_individual_rate_model', 'air');
        $vars['discussions'] = $this->air->get_cs_discussion($_POST['appraisal_id'], $_POST['section_id'], $_POST['user_id'], $_POST['contributor_id']);
        $this->load->vars($vars);

        $user = $this->db->get_where('users', array('user_id' => $_POST['user_id']))->row();

        $data['title'] = $user->full_name .
        '<br><span class="text-muted">Discussion Logs</span>';
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
        
        $insert = $_POST;

        $this->db->insert('performance_appraisal_contributor_notes', $insert);
        
        $where = array(
        	'appraisal_id' => $this->input->post('appraisal_id'),
        	'user_id' => $this->input->post('user_id'),
        );
        $this->db->update('performance_appraisal_applicable_user', array('status_id' => 8), $where);

        $where = array(
        	'appraisal_id' => $this->input->post('appraisal_id'),
        	'user_id' => $this->input->post('user_id'),
        );
        $this->db->update('performance_appraisal_applicable', array('status_id' => 8), $where);

        //notify appraisee
        $this->load->model('system_feed');
        $feed = array(
            'status' => 'info',
            'message_type' => 'Comment',
            'user_id' => $this->user->user_id,
            'feed_content' => 'There was a remark regarding your crowdsource form, kindly check.',
            'uri' => get_mod_route('appraisal_individual_rate', '', false) . '/crowdsource/'.$_POST['appraisal_id'].'/'.$_POST['user_id'],
            'recipient_id' => $_POST['note_to']
        );

        $recipients = array($_POST['note_to']);
        $this->system_feed->add( $feed, $recipients );

        $this->response->notify[] = $_POST['note_to']; 

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->response->appraisal_id = $_POST['appraisal_id'];
        $this->response->redirect = $this->mod->url . '/index/'.$this->input->post('appraisal_id');

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

	function add_contributors()
    {
        $this->_ajax_only();
        $this->response->close_modal = false;
		
		$this->load->model('performance_appraisal_manage_model', 'pam');
        $appraisee = $this->pam->get_appraisee(  $_POST['appraisal_id'], $_POST['user_id'] );
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
                'contributor_id' => $contributor_id,
                'finalized' => 1
            );

            $this->db->limit(1);
            $check = $this->db->get_where('performance_appraisal_contributor', $insert);
            if( $check->num_rows() == 0 )
            {
                $this->db->insert('performance_appraisal_contributor', $insert); 
	            $feed_content = "{$appraisee->fullname} has chosen you as his/her crowdsource on his/her {$section->template_section}.";
                $feed = array(
                    'status' => 'info',
                    'message_type' => 'Comment',
                    'user_id' => $this->user->user_id,
                    'feed_content' => $feed_content,
                    'uri' => get_mod_route('performance_appraisal_contributor', '', false) . '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'].'/'.$contributor_id,
                    'recipient_id' => $contributor_id
                );
                 	$this->load->model('system_feed');
	                $recipients = array($contributor_id);
	                $this->system_feed->add( $feed, $recipients );
	            
	                $this->response->notify[] = $contributor_id; 

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
}