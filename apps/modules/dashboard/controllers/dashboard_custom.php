
	public function __construct(){
		
		$this->load->model('dashboard_model', 'mod');
        $this->load->library('time_form_policies');
		
		parent::__construct();
		$this->current_user = $this->config->item('user');
	}

	public function index(){ 

		if( IS_AJAX ){

			$page 					= $this->input->post('page');
			$page 					= ($page-1) * 10;
			$data 					= array();
			$data['current_user'] 	= $this->user->user_id;
			$data['feeds'] 			= $this->mod->getDashboardFeeds($data['current_user'], $page, 10);
			
			$this->response->records_retrieve = count($data['feeds']);
			$this->response->list	= $this->load->view('customs/feed_display', $data, true);

			$this->response->message[] = array(
		    	'message' => '',
		    	'type' => 'success'
			);

			$this->_ajax_return();
		}
		else{

			// First Page load, serve them the first 10?
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

			$this->load->vars($data);
			echo $this->load->blade('main_custom')->with( $this->load->get_cached_vars() );
		}
	}

	public function tag_user(){

		$this->_ajax_only();

		$data = array();
		$data = $this->mod->getUsersTagList();

		header('Content-type: application/json');
		echo json_encode($data);
		die();
	}

	public function tag_company(){

		$this->_ajax_only();

		$data = array();
		$data = $this->mod->getCompanyTagList();

		header('Content-type: application/json');
		echo json_encode($data);
		die();
	}


	public function update_post(){

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


	public function get_user_notification(){

		// $this->response->x = $this->input->post();
		// $this->_ajax_return();

		// die();

		$this->_ajax_only();
		$data = array();

		$user_id 	= $this->input->post('user_id'); 
		//$itemID  	= $this->input->post('notif_data')['item'];
		$notif_data = $this->input->post('notif_data');
		$itemID 	= $notif_data['item']; 
		$itemType	= $notif_data['type']; 
		$lgid 		= isset($notif_data['lgid']) ? $notif_data['lgid'] : ''; 

		$this->response = $this->mod->getUserNotification($user_id, $itemID);

		if($this->response){

			$data['current_user'] 			= $user_id;
			//$data['feeds'] 					= $this->mod->getLatestPostData($itemID); 
			$data['feeds'] 					= $this->mod->getLatestPostData($itemID, $user_id);
			$this->response->feed_latest 	= $this->load->view('customs/feed_display', $data, true);

			// if notification is a birthday greetings
			// get that latest birthday greetings
			// which will automatically be prepended to
			// to the greetings modal dialog when open
			if($itemType === 'greetings'){

				$greetings = array();
				$greetings['latest'] = $this->mod->getLatestGreetingsData($lgid);	
				//print_r($greetings); 
				//die();
				$this->response->greetings 	= $this->load->view('customs/greetings_only', $greetings, true);
			}
		}



		$this->_ajax_return();	
	}

	public function get_feed(){

		$this->_ajax_only();
		$data = array();
		$feedId = $this->input->post('feed_id');

		$data['current_user'] 			= $this->session->userdata['user']->user_id;
		$data['user_id'] 				= $this->session->userdata['user']->user_id; 

		$data['feeds'] 					= $this->mod->getLatestPostData($feedId); 
		$this->response->feed_latest 	= $this->load->view('customs/feed_display', $data, true);

        $this->response->message[] 		= array(
		    'message' 	=> '',
		    'type' 		=> 'success'
		);

		$this->_ajax_return();
	}

	public function get_todos(){

		$this->_ajax_only();
		$data = array();

		$data['current_user'] 			= $this->user->user_id;
		$data['todos'] 					= $this->mod->getTodoFeeds($data['current_user']);
		$this->response->todos 			= $this->load->view('customs/todos', $data, true);
		$this->response->count 			= count($data['todos']);

		$this->response->message[] 		= array(
		    'message' 	=> '',
		    'type' 		=> 'success'
		);

		$this->_ajax_return();
	}

	public function get_timekeeping_stats(){

		$this->_ajax_only();
		$this->response->stats = array();
		$this->response->stat_graph = "";

		$this->db->limit(1);
		$stat = $this->db->query("select * from `time_stats` where user_id = {$this->user->user_id}");
		if( $stat->num_rows() == 1 )
		{
			$this->response->stats = $data['stat'] = $stat->row();
			$this->response->stat_graph = $this->load->view('customs/time_stats', $data, true);
		}

		$this->response->message[] 		= array(
		    'message' 	=> '',
		    'type' 		=> 'success'
		);

		$this->_ajax_return();
	}	

	public function get_post_time(){

		// todo: add function level security

		$data = array();

		$current_user = $this->session->userdata['user']->user_id;
		$this->response->post_time 	= $this->mod->getPostTime($current_user);

		$this->response->message[] = array(
		    'message' => '',
		    'type' => 'success'
		);

    	$this->_ajax_return();
	}


	public function update_greetings(){

		$this->_ajax_only();
		$data = array();
		$greetings_content		= mysqli_real_escape_string($this->db->conn_id, $this->input->post('new_greetings'));
		$display_name			= $this->current_user['lastname']. ", ". $this->current_user['firstname'];

		$data['current_user'] 	= $this->session->userdata['user']->user_id;
		$data['user_id'] 		= $this->session->userdata['user']->user_id; 		// THE CURRENT LOGGED IN USER 
		$data['display_name'] 	= $display_name;									// THE CURRENT LOGGED IN USER'S DISPLAY NAME
		$data['content'] 		= $greetings_content;								// THE MAIN FEED BODY
		$data['birtday'] 		= $this->input->post('birthday');
		$data['recipient_id'] 	= $this->input->post('celebrant');
		$data['status'] 		= 'info';											// DANGER, INFO, SUCCESS & WARNING

		// NOW SAVE THE POSTED DATA AND GET THE INSERT ID
		$latest 				= $this->mod->newGreetingsData($data);
		$this->response->lgid 	= $latest;
		
		// GET LATEST POSTED DATA AND RETURN IT BACK TO THE UI
		$data['latest'] 		= $this->mod->getLatestGreetingsData($latest);

		$data['feed_content'] 	= $data['content'];



		// ADD NEW DATA FEED ENTRY
		$latest = $this->mod->newPostData($data);
		$this->response->target	= $latest;

		// WHO OWES FOR THE GREETINGS?
		$this->response->celebrant = $data['recipient_id'];

		// determines to where the action was 
		// performed and used by after_save to
		// know which notification to broadcast
		$this->response->type 		= 'greetings';
		$this->response->action 	= 'insert';

		$this->response->greetings 	= $this->load->view('customs/greetings_only', $data, true);

        $this->response->message[] 	= array(
		    'message' 	=> '',
		    'type' 		=> 'success'
		);

    	$this->_ajax_return();		
	}


	public function get_birthday_greetings(){

		$this->_ajax_only();
		$data = array();

		$data['celebrant']['celebrant_id'] = $this->input->post('celebrant_id');
		$data['celebrant']['celebrant_name'] = $this->input->post('celebrant_name');
		$data['celebrant']['birth_date'] = $this->input->post('birth_date');

		$data['greetings'] = $this->mod->getBirthdayGreetings($data['celebrant']);		
		$this->response->greetings = $this->load->view('customs/birthday_greetings', $data, true);

        $this->response->message[] = array(
		    'message' => '',
		    'type' => 'success'
		);

    	$this->_ajax_return();
	}


	public function forms_decission(){

		$this->_ajax_only();
		$data = array();

        $forms_validation = $this->time_form_policies->validate_form_change_status($this->input->post('formid'));

        if(array_key_exists('error', $forms_validation) ){
            if(count($forms_validation['error']) > 0 ){            
                foreach( $forms_validation['error'] as $f => $f_error )
                {
                    $this->response->message[] = array(
                        'message' => $f_error,
                        'type' => 'error'
                        );  
                }  
            }
        }
        if (array_key_exists('warning', $forms_validation)){
            if(count($forms_validation['warning']) > 0 ){   
                foreach( $forms_validation['warning'] as $f => $f_error )
                {
                    $this->response->message[] = array(
                        'message' => $f_error,
                        'type' => 'warning'
                        );  
                }
            }
        }

        if(count($forms_validation['error']) > 0 ){
            $this->_ajax_return();            
        }else{

			// 1. set forms approver decision
			$result = $this->mod->setDecission($this->input->post());

			// 2. build a notification message
			// 	  designed to determine the type of form
			// 	  the recipient has submitted.

			$approver 		= $this->input->post('username');
			$action 		= $this->input->post('decission') == '1' ? ' approved ' : ' disapproved '; 
			$form_name 		= $this->input->post('formname'); 
			$recipient 		= $this->input->post('formownerid');
			$notif_message 	= 'Filed ' . $form_name . ' on ' . date('F d, Y') . ' has been '.$action.'.';
			if(trim($this->input->post('comment')) != ""){
				$notif_message 	.= '<br><br>Remarks: '.$this->input->post('comment');
			}

			$data['user_id'] 		= $this->session->userdata['user']->user_id; 								// THE CURRENT LOGGED IN USER 
			$data['display_name'] 	= $this->current_user['lastname']. ", ". $this->current_user['firstname'];	// THE CURRENT LOGGED IN USER'S DISPLAY NAME
			$data['feed_content'] 	= $notif_message;															// THE MAIN FEED BODY
			$data['recipient_id'] 	= $recipient;																// TO WHOM THIS POST IS INTENDED TO
			$data['status'] 		= 'info';																	// TO WHOM THIS POST IS INTENDED TO
			$data['message_type'] 	= 'Time Record';																	// DANGER, INFO, SUCCESS & WARNING

			// ADD NEW DATA FEED ENTRY
			$latest = $this->mod->newPostData($data);
			$this->response->target	= $latest;

			// determines to where the action was 
			// performed and used by after_save to
			// know which notification to broadcast
			$this->response->type 		= 'todo';
			$this->response->action 	= 'insert';

	        $this->response->message[] 	= array(
			    'message' 	=> 'Successfully Saved!',
			    'type' 		=> 'success'
			);
			
	    	$this->_ajax_return();
        }
        
	}

	function payroll()
	{
		echo $this->load->blade('dashboards.payroll_manager')->with( $this->load->get_cached_vars() );
	}

	function payroll_setup()
	{
		echo $this->load->blade('dashboards.payroll_setup')->with( $this->load->get_cached_vars() );
	}

	function reports()
	{
		$user = $this->config->item('user');
		$this->db->order_by('category');
		$categories = $this->db->get_where('report_generator_category', array('deleted' => 0));
		foreach( $categories->result_array() as $category )
		{
			$this->db->join('report_generator_role', 'report_generator.report_id = report_generator_role.report_id','left');
			$where = array(
				'category_id' => $category['category_id'], 
				'report_generator.deleted' => 0, 
				'report_generator_role.role_id' => $user['role_id']);
			$category['reports'] = $this->db->get_where('report_generator', $where);
			$data['categories'][] = $category;
		}

		$this->load->vars($data);
		echo $this->load->blade('dashboards.reports')->with( $this->load->get_cached_vars() );	
	}

	function utilities()
	{
		$user = $this->config->item('user');
		if( $user['role_id'] != 1 )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		echo $this->load->blade('dashboards.admin_utilities')->with( $this->load->get_cached_vars() );
	}

	function assembla()
	{
		$this->load->library('curl');
		$this->curl->create('https://api.assembla.com/v1/spaces/cl13nt_p10n33r/tickets.json?page=3&per_page=100&report=1');
		//$this->curl->http_header( array('X-Api-Key: edf434d07cb63e7d6ba2', 'X-Api-Secret: a79c680cdbaf867ac3fc004f93e46ae34f3dfb4b') );
		$this->curl->option(CURLOPT_HTTPHEADER, array('X-Api-Key: edf434d07cb63e7d6ba2', 'X-Api-Secret: a79c680cdbaf867ac3fc004f93e46ae34f3dfb4b'));
		$this->curl->option(CURLOPT_SSL_VERIFYPEER, false);
		$tickets = $this->curl->execute();
		
		if( empty( $this->curl->error_code ) )
		{
			$tickets = json_decode( $tickets );
			debug( $tickets ); 
		}
		else{
			debug( $this->curl->error_code . ' - ' . $this->curl->error_string );
		}

		// Errors
		
		// Information
		//debug( $this->curl->info ); // array 
	}

    function get_form_details(){
        $this->_ajax_only();
        $form_id = $this->input->post('form_id');
        $forms_id = $this->input->post('forms_id');

		$this->load->model('form_application_manage_model', 'form_manage');
        $this->response->form_details = '';
        switch($form_id){
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
            case 7:
            case 13:
            case 14:
            case 16:
            case 17:
                $form_details = $this->form_manage->get_leave_details($forms_id, $this->user->user_id);
                $remarks['remarks'] = array();
                $comments = $this->form_manage->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);
                $this->response->form_details .= $this->load->blade('edit/leave_details', $form_details, true);
            break;
            case 8://obt
                $form_details = $this->form_manage->get_obt_details($forms_id, $this->user->user_id);
                $remarks['remarks'] = array();
                $comments = $this->form_manage->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);
                $this->response->form_details .= $this->load->blade('edit/obt_details', $form_details, true);            
            break;
            case 9://ot
                $form_details = $this->form_manage->get_ot_ut_dtrp_details($forms_id, $this->user->user_id);
                $remarks['remarks'] = array();
                $comments = $this->form_manage->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);
                $this->response->form_details .= $this->load->blade('edit/ot_details', $form_details, true);            
            break;
            case 10://ut
                $form_details = $this->form_manage->get_ot_ut_dtrp_details($forms_id, $this->user->user_id);
                $remarks['remarks'] = array();
                $comments = $this->form_manage->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);
                $this->response->form_details .= $this->load->blade('edit/ut_details', $form_details, true);            
            break;
            case 11://dtrp
                $form_details = $this->form_manage->get_ot_ut_dtrp_details($forms_id, $this->user->user_id);
                $remarks['remarks'] = array();
                $comments = $this->form_manage->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);
                $this->response->form_details .= $this->load->blade('edit/dtrp_details', $form_details, true);            
            break;
            case 12://cws
                $form_details = $this->form_manage->get_cws_details($forms_id, $this->user->user_id);
                $remarks['remarks'] = array();
                $comments = $this->form_manage->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);
                $this->response->form_details .= $this->load->blade('edit/cws_details', $form_details, true);            
            break;
        }

        $this->_ajax_return();
    }

	public function filter_feeds(){ 

		if( IS_AJAX ){

			$message_type			= $this->input->post('filter');
			$page 					= $this->input->post('page');
			$page 					= ($page-1) * 10;
			$data 					= array();
			$data['current_user'] 	= $this->user->user_id;
			$data['feeds'] 			= $this->mod->filterDashboard($data['current_user'], $page, 10, $message_type);
			
			$this->response->records_retrieve = count($data['feeds']);
			$this->response->list	= $this->load->view('customs/feed_display', $data, true);

			$this->response->message[] = array(
		    	'message' => '',
		    	'type' => 'success'
			);

			$this->_ajax_return();
		}
	}

	public function save_comment(){

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

		if( !$error  )
		{
			$this->response->message[] = array(
				'message' => 'Comment was successfully saved and/or updated.',
				'type' => 'success'
			);
			// GET LATEST POSTED DATA AND RETURN IT BACK TO THE UI
			if($this->response->action == 'insert'){
				$this->response->new_comment = $this->load->view('customs/feeds_comment', $data, true);
			}else{
				$this->response->edit_comment = $this->load->view('customs/update_comment', $data, true);
			}

			$this->response->comment_feed = true;
		}

		$this->response->saved = !$error;
        $this->_ajax_return();
	}

	function delete_comment()
	{
		$this->_ajax_only();
		
		if( !$this->permission['delete'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		if( !$this->input->post('records') )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();	
		}

		$records = $this->input->post('records');
		$records = explode(',', $records);

		$data['modifiedon'] = date('Y-m-d H:i:s');
		$data['deleted'] = 1;

		$this->db->where_in('feeds_comment_id', $records);
		$this->db->update('system_feeds_comments', $data);
		
		if( $this->db->_error_message() != "" ){
			$this->response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}
		else{
			$this->response->message[] = array(
				'message' => $this->db->affected_rows() . ' comment has been deleted.',
				'type' => 'success'
			);
		}

		$this->_ajax_return();
	}

	public function edit_comment(){

		$this->_ajax_only();
		$data = array();

		$data = $_POST;
	
		$this->response->message[] = array(
	    	'message' => '',
	    	'type' => 'success'
		);
		$this->response->edit_comment = $this->load->view('customs/edit_comment', $data, true);
		$this->response->comment_feed = true;
		
        $this->_ajax_return();
	}

	public function getHolidayEvents(){
		$this->load->model('holiday_event_model', 'event_mod');
		$holiday_events = $this->event_mod->getHolidayEvents();

		$today = date('Y-m-d');
		$today_strtotime = strtotime($today);
		$holidayEvents = array();
        foreach( $holiday_events as $holiday => $event )
        {
        	$event_date = date('Y').'-'.$event['event_month'].'-'.$event['event_day'];
        	$event_date_from = date('Y-m-d', strtotime("-".$event['days_before']." days", strtotime($event_date)));
        	$event_date_to = date('Y-m-d', strtotime("+".$event['days_after']." days", strtotime($event_date)));
        	
        	if($today_strtotime >= strtotime($event_date_from) && $today_strtotime <= strtotime($event_date_to)){
        		$holidayEvents['event'][] = $event['event'];

        		switch(trim($event['event'])){
		    		case "SNOW":
		    			$holidayEvents['event_plugin'][] = '<script src="'.base_url().'/assets/plugins/jqSnow-master/jquery.snow.js"></script>';
		    			$holidayEvents['event_script'][] = '<script src="'.base_url().'/assets/plugins/holiday_events/SNOW.js"></script>';
		    		break;
        		}
        	}
        }
        return $holidayEvents;
	}

	function update_mobile(){
		$this->_ajax_only();

		$this->load->model('partners_model', 'partners_mod');
		$partner_id = $this->partners_mod->get_partner_id($this->user->user_id);
		if(!empty($partner_id)){
			$request_done = array();
			$partners_key = $this->db->get_where('partners_key', array('deleted' => 0, 'key_code' => 'mobile'))->row_array();
			$request_done = $this->db->get_where('partners_personal_request', array('deleted' => 0, 'partner_id' => $partner_id, 'key_id' => $partners_key['key_id']))->row_array();
			if(!(count($request_done) > 0)){
				$this->response->message[] = array(
			    	'message' => '',
			    	'type' => 'success'
				);
				$data= array();
				$this->response->update_mobile = $this->load->view('customs/prompt_entermobile', $data, true);
			}
		}
        $this->_ajax_return();
	} 

	function update_mobilephone(){
		$this->_ajax_only();
		$this->response->invalid=false;
		$error = false;

		$mobileNumber = trim(str_replace(' ', '', $_POST['partners_personal']['mobile']));
		$mobileNumber =  str_replace('-', '', $mobileNumber);

		if(!empty($mobileNumber)){
			if ((substr($mobileNumber,0,1) != 0) && strlen($mobileNumber) < 11){
				$mobileNumber = '0'.$mobileNumber;
			}	
			$output = preg_replace( '/(0|\+?\d{2})(\d{9,10})/', '0$2', $mobileNumber);

			preg_match( '/(0|\+?\d{2})(\d{9,10})/', $mobileNumber, $matches);
			if(isset($matches[1]) && isset($matches[2])){
				$mobile_prefix = substr($matches[2], 0, 2);
				if($matches[2] != $output || $mobile_prefix == 00){
					$this->response->invalid=true;
					$this->response->invalid_message='Invalid number';
					$this->response->message[] = array(
				    	'message' => 'Invalid number',
				    	'type' => 'warning'
					);
	        		$this->_ajax_return();
				}
			}else{
					$this->response->invalid=true;
					$this->response->invalid_message='Invalid number';
					$this->response->message[] = array(
				    	'message' => 'Invalid number',
				    	'type' => 'warning'
					);
	        		$this->_ajax_return();
			}
		}else{
				$this->response->invalid=true;
				$this->response->invalid_message='Invalid number';
					$this->response->message[] = array(
				    	'message' => 'Invalid number',
				    	'type' => 'warning'
					);
        		$this->_ajax_return();
		}

		//force format to +63 and 10 digit number
		$mobileNumber = '+63'.$matches[2];
		$sequence = 1;
		$this->load->model('partners_model', 'partners_mod');
		$partner_id = $this->partners_mod->get_partner_id($this->user->user_id);
		$partners_personal = $this->partners_mod->get_partners_personal($this->user->user_id, 'partners_personal', 'mobile', 1);

        //SAVING START   
		$transactions = true;
		$this->partner_id = 0;
		if( $transactions )
		{
			$this->db->trans_begin();
		}
		
		$main_record = array();
		switch( true )
		{
			case count($partners_personal) == 0:
				$data_personal = $this->partners_mod->insert_partners_personal($this->user->user_id, 'mobile', $mobileNumber, 1, $partner_id);
				$this->db->insert('partners_personal', $data_personal);
				$this->response->action = 'insert';
				break;
			case count($partners_personal) > 0:
				$partners_personal = $partners_personal[0];
				$main_record['modified_by'] = $this->user->user_id;
				$main_record['modified_on'] = date('Y-m-d H:i:s');
				$main_record['key_value'] = $mobileNumber;
				$this->db->update( 'partners_personal', $main_record, array( 'personal_id' => $partners_personal['personal_id'] ) );
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
		}else{			
			$partners_key = $this->db->get_where('partners_key', array('deleted' => 0, 'key_code' => 'mobile'))->row_array();
			$data_personal_request = array();
			$data_personal_request['partner_id'] = $partner_id;
			$data_personal_request['key_id'] = $partners_key['key_id'];
			$data_personal_request['key'] = 'mobile';
			$data_personal_request['sequence'] = 1;
			$data_personal_request['key_value'] = $mobileNumber;
			$data_personal_request['status'] = 3;
			$data_personal_request['created_by'] = $this->user->user_id;
			$this->db->insert('partners_personal_request', $data_personal_request);
			
			if( $this->db->_error_message() != "" ){
				$this->response->message[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
				$error = true;
				goto stop;
			}
		}

		stop:
		if( true )
		{
			if( !$error ){
				$this->db->trans_commit();
			}
			else{
				 $this->db->trans_rollback();
			}
		}

		if( !$error  )
		{
			$this->response->message[] = array(
				'message' => 'Mobile number was successfully saved and/or updated.',
				'type' => 'success'
			);
		}

        $this->_ajax_return();
		
	}

