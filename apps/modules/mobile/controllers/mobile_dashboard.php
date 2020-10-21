<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mobile_Dashboard extends MY_PrivateController{

	private $current_user = array();

	public function __construct(){
		
		$this->load->model('mobile_dashboard_model', 'mod');
        $this->load->library('time_form_policies');
		
		parent::__construct();
		$this->current_user = $this->config->item('user');
		$this->lang->load( 'dashboard' );
		$this->lang->load( 'form_application_manage' );

	}

		public function get_index(){
		if( IS_AJAX ){

			$user = $this->_get_user_config();
			$page 					= $this->input->post('page');
			$page 					= ($page-1) * 10;
			$data 					= array();
			$data['current_user'] 	= $this->user->user_id;
			$data['feeds'] 			= $this->mod->getDashboardFeeds($data['current_user'], $page, 10);			
			$this->response->records_retrieve = count($data['feeds']);

			// MOBILE v1
			/*if( $this->input->post('mobileapp') )
				$this->response->list	= $this->load->view('customs/feed_display_mobile', $data, true);
			else
				$this->response->list	= $this->load->view('customs/feed_display', $data, true);*/

				/*$this->response->message[] = array(
		    	'message' => '',
		    	'type' => 'success'
			);*/

			// MOBILE v2				
			if( $this->input->post('mobileapp') ){
				
				$data['count_feed_like'] = array();
				$data['count_feed_comment'] = array();

				foreach ($data['feeds'] as $feed) {

				$data['count_feed_like'][$feed->id] = ($this->mod->get_feed_likes($feed->id) ? count($this->mod->get_feed_likes($feed->id)) : false );

				$data['count_feed_comment'][$feed->id] = ($this->mod->get_feed_comments($feed->id) ? count($this->mod->get_feed_comments($feed->id)) : false);
				//$data['feed_like'][$feed->id] = $this->mod->get_feed_likes($feed->id);
				//$data['count_feed_comment'][$feed->id] = $this->mod->get_feed_comments($feed->id);

				}
			
				ob_start();
				echo json_encode($data);
	            $this->response->feeds = ob_get_clean();
	            
			}else

				$this->response->list	= $this->load->view('customs/feed_display', $data, true);

			$this->response->message = array(
		    	'message' => '',
		    	'type' => 'success'
			);
			
			$this->_ajax_return();

		}else{

			$data 					= array();
			$data['current_user'] 	= $this->session->userdata['user']->user_id;
			$data['birthdays'] 		= $this->mod->getBirthdayFeeds($data['current_user']);		
			
			$this->load->model('signatories_model', 'signatories');
			$data['approver'] = $this->signatories->check_if_approver( $this->user->user_id );

			if( $data['approver'] == false){

				if($this->mod->getTodoFeeds($data['current_user']) > 0){
					$data['approver'] = true;
				}

			}

			$data['holidayEvents'] = $this->getHolidayEvents();
			
			$this->load->model('partners_model', 'partners_mod');
			$partner_id = $this->partners_mod->get_partner_id($this->user->user_id);
			$data['partner_id'] = empty($partner_id) ? 0 : $partner_id;

			$this->load->vars($data);
			echo $this->load->blade('main_custom')->with( $this->load->get_cached_vars() );
		}

	}//ENd of Index

		function get_feed_like(){

		$this->_ajax_only();

		//MOBILE V1
		/*$this->mod->feed_like( $this->input->post('feed_id'), $this->input->post('status') );
		$this->response->feed_id = $this->input->post('feed_id');
		$this->response->like_str = $this->mod->feed_like_str( $this->input->post('feed_id'), $this->input->post('mobileapp') );
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);*/

		//MOBILE v2
		$this->mod->feed_like( $this->input->post('feed_id'), $this->input->post('status'));
		$this->response->feed_id = $this->input->post('feed_id');
		$this->response->message = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();

	}//End of Feed Like

	function get_update_feed_like(){
		$this->_ajax_only();

		//MOBILE v1
		/*$this->response->like_str = $this->mod->feed_like_str( $this->input->post('feed_id') );
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);*/

		//MOBILE v2
		if( $this->mod->get_feed_likes( $this->input->post('feed_id') ) )
			$this->response->count_like = count($this->mod->get_feed_likes( $this->input->post('feed_id') )); 
		else
			$this->response->count_like = false;

		$this->response->feed_like = $this->mod->get_feed_likes( $this->input->post('feed_id') );
		$this->response->message = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();	
	}//End Of update feed likes

	function get_feed_comments(){
		//MOBILE v1
		/*$this->_ajax_only();
		$vars['feed_id'] = $feed_id = $this->input->post('feed_id');
		$vars['likes'] = $this->mod->get_feed_likes( $feed_id );
		
		$vars['comments'] = '';
		$comments = $this->mod->get_feed_comments( $feed_id );
		foreach( $comments as $comment )
			$vars['comments'] .= $this->load->view('customs/feed_comments_mobile', array('comment' => $comment ), true);

		$this->response->comments = $this->load->view('customs/feed_comments_form_mobile', $vars, true);
		$this->response->message[] = array(
		    'message' => '',
		    'type' => 'success'
		);*/

		//MOBILE V2
		$this->_ajax_only();

		//$data['count_feed_comment'][$feed->id] = $this->mod->get_feed_comments($feed->id);
		$this->response->feed_comments = $this->mod->get_feed_comments($this->input->post('feed_id'));
		$this->response->message = array(
		    'message' => '',
		    'type' => 'success'
		);
		$this->_ajax_return();	
	}// End Of get_feed_comment

	public function post_save_comment(){

		$this->_ajax_only();
		$data = array();
		$data['id'] = $this->input->post('feeds_id');
		$data['user_id'] = $this->session->userdata['user']->user_id;
		$data['comment'] = $this->input->post('trimmed_comment');
		$data['comment_count'] = $this->input->post('comment_counts');
		$data['feeds_userid'] = $this->input->post('feeds_userid');
	
        /***** END Form Validation (hard coded) *****/
        //SAVING START   
		$error = false;
		$transactions = true;

		if( $transactions )
		{
			$this->db->trans_begin();
		}

		//start saving with main table
		$main_record = array(
			'id' => $data['id'],
			'user_id' => $data['user_id'],
			'comment' => $data['comment']
			);
		$data['feeds_comment_id'] = $this->response->record_id = $this->record_id = $this->input->post('comment_id');

		$record = $this->db->get_where( 'system_feeds_comments', array( 'feeds_comment_id' => $this->record_id ) );

		switch( true )
		{
			case $record->num_rows() == 0:
                //add mandatory fields
                $data['createdon'] = $main_record['createdon'] = date('Y-m-d H:i:s');
				$this->db->insert('system_feeds_comments', $main_record);
				if( $this->db->_error_message() == "" )
				{
					$data['feeds_comment_id'] = $this->response->record_id = $this->record_id = $this->db->insert_id();
				}
				$this->response->action = 'insert';
				break;
			case $record->num_rows() == 1:
                //add mandatory fields
                $main_record['modifiedon'] = date('Y-m-d H:i:s');
                // print_r($record->row_array());
                $data['createdon'] = date('Y-m-d H:i:s', strtotime($record->row('createdon')));
				$this->db->update( 'system_feeds_comments', $main_record, array( 'feeds_comment_id' => $this->record_id ) );
				$this->response->action = 'update';
				break;
			default:
				$this->response->message[] = array(
					'message' => lang('common.inconsistent_data'),
					'type' => 'error'
				);
				$error = true;
				goto stop;
		}

		if( $this->db->_error_message() != "" ){
			$this->response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
			$error = true;
			goto stop;
		}

		stop:
		if( $transactions )
		{
			if( !$error ){
				$this->db->trans_commit();
			}
			else{
				 $this->db->trans_rollback();
			}
		}

		if( !$error  ){
			//MOBILEV1
			/*$this->response->message[] = array(
				'message' => 'Comment was successfully saved and/or updated.',
				'type' => 'success'
			);

			if( $this->input->post('mobileapp') )
			{
				$vars['comment'] = $this->mod->get_feed_comment( $data['feeds_comment_id'] );
				$this->response->comment = $this->load->view('customs/feed_comments_mobile', array( 'comment' => $vars['comment']), true);
			}*/

			//MOBILEV2
			$this->response->message = array(
				'message' => 'Comment was successfully saved and/or updated.',
				'type' => 'success'
			);
			
			if( $this->input->post('mobileapp') )
			{
				/*$vars['comment'] = $this->mod->get_feed_comment( $data['feeds_comment_id'] );
				$this->response->comment = $this->load->view('customs/feed_comments_mobile', array( 'comment' => $vars['comment']), true);*/

				$this->response->comment = krsort($this->mod->get_feed_comment( $data['feeds_comment_id'] ));
			}
			else{
				// GET LATEST POSTED DATA AND RETURN IT BACK TO THE UI
				if($this->response->action == 'insert'){
					$this->response->new_comment = $this->load->view('customs/feeds_comment', $data, true);
				}else{
					$this->response->edit_comment = $this->load->view('customs/update_comment', $data, true);
				}
			}
			$this->response->comment_feed = true;
		}

		$this->response->saved = !$error;
        $this->_ajax_return();
	}//ENd of save comment

	public function get_tag_user(){

		$this->_ajax_only();

		$data = array();
		$data = $this->mod->getUsersTagList();

		header('Content-type: application/json');
		echo json_encode($data);
		die();
	}//End of Tag_user

	public function post_update_post(){

		$this->_ajax_only();
		$data = array();

		$data['current_user'] 	= $this->session->userdata['user']->user_id;
		$data['user_id'] 		= $this->session->userdata['user']->user_id; 								// THE CURRENT LOGGED IN USER 
		$data['display_name'] 	= $this->current_user['lastname']. ", ". $this->current_user['firstname'];	// THE CURRENT LOGGED IN USER'S DISPLAY NAME
		$data['feed_content'] 	= mysqli_real_escape_string($this->db->conn_id, $_POST['new_post']);		// THE MAIN FEED BODY
		$data['recipient_id'] 	= '0';																		// TO WHOM THIS POST IS INTENDED TO
		$data['status'] 		= 'info';																	// DANGER, INFO, SUCCESS & WARNING
		
		$feed_to = $this->input->post('feed_to');
		if( $feed_to == "user" )
			$data['recipients']	=  $this->input->post('recipient') === '' ? array() : explode(',', $this->input->post('recipient'));
		else{
			$companies = $this->input->post('recipient') === '' ? array() : explode(',', $this->input->post('recipient'));
			foreach( $companies as $company_id )
			{
				$users = $this->db->query("SELECT * FROM users_profile WHERE company_id = {$company_id}");
				if( $users->num_rows() > 0 )
				{
					foreach($users->result() as $row)
					{
						$data['recipients'][] = $row->user_id;
					}
				}
			}
		}

		$data['to']	= 'user'; // TODO: change this when division is okay!!!

		if( count( $data['recipients'] ) == 0 ){
			$data['recipient_id'] = $data['user_id'];
		}

		if( !in_array( $data['user_id'], $data['recipients']) )
		{
			$data['recipients'][] = $data['user_id'];
		} 	

		// NOW SAVE THE POSTED DATA AND GET THE INSERT ID
		$data['message_type'] = $this->input->post('message_type');
		$latest = $this->mod->newPostData($data);
		$this->response->target	= $latest;


		// SAVE RECIPIENTS
		if(count($data['recipients']) > 0){
			$recipients_result = $this->mod->saveRecipients($latest, $data['to'], $data['recipients']);
		}

		// GET LATEST POSTED DATA AND RETURN IT BACK TO THE UI
		$data['feeds'] 			= $this->mod->getLatestPostData($latest, $data['user_id'] );
		$this->response->new_feed 	= $this->load->view('customs/feed_display', $data, true);
		
		// NOW TELL THESE RECIPIENTS THEY'VE GOT SOMETHING!
		$this->response->recipients = $data['recipients'];

		$this->response->action 		= 'insert';

		// determines to where the action was 
		// performed and used by after_save to
		// know which notification to broadcast
		$this->response->type 			= 'feed';

        $this->response->message[] = array(
		    'message' => '',
		    'type' => 'success'
		);

    	$this->_ajax_return();
	}


	public function get_todos(){

		//MOBILE V1
		/*$this->_ajax_only();
		$data = array();

		$data['todos'] 					= $this->mod->getTodoFeeds( $this->user->user_id );
		if( $this->input->post('mobileapp') )
			$this->response->todos 			= $this->load->view('customs/todos_mobile', $data, true);
		else	
			$this->response->todos 			= $this->load->view('customs/todos', $data, true);
		$this->response->count 			= count($data['todos']);

		$this->response->message[] 		= array(
		    'message' 	=> '',
		    'type' 		=> 'success'
		);

		$this->_ajax_return();*/

		//MOBILE V2
		$this->_ajax_only();

		if( $this->input->post('mobileapp') ) 
			$this->response->todos 			= $this->mod->getTodoFeeds( $this->user->user_id );		
		else	
			$this->response->todos 			= $this->load->view('customs/todos', $data, true);
		$this->response->count 			= count($this->mod->getTodoFeeds( $this->user->user_id ));

		$this->response->message 		= array(
		    'message' 	=> '',
		    'type' 		=> 'success'
		);

		$this->_ajax_return();
	}

//End Of Dashboard
}