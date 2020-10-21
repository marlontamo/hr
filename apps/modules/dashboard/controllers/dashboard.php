<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_PrivateController{

	private $current_user = array();

	public function __construct(){
		
		$this->load->model('dashboard_model', 'mod');
        $this->load->library('time_form_policies');
		
		parent::__construct();
		$this->current_user = $this->config->item('user');
		$this->lang->load( 'dashboard' );
		$this->lang->load( 'form_application_manage' );
		$this->lang->load( 'user_manager' );
	}

	public function index(){ 
		if( IS_AJAX ){

			$user = $this->_get_user_config();
			$page 					= $this->input->post('page');
			$page 					= ($page-1) * 10;
			$data 					= array();
			$data['current_user'] 	= $this->user->user_id;
			$data['feeds'] 			= $this->mod->getDashboardFeeds($data['current_user'], $page, 10);
			
			$this->response->records_retrieve = count($data['feeds']);

			if( $this->input->post('mobileapp') )
				$this->response->list	= $this->load->view('customs/feed_display_mobile', $data, true);
			else
				$this->response->list	= $this->load->view('customs/feed_display', $data, true);

			$this->response->message[] = array(
		    	'message' => '',
		    	'type' => 'success'
			);

			$this->_ajax_return();
		}
		else{
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

	public function check_default_pass(){

		$data = array();

		$current_user_id = $this->session->userdata['user']->user_id;

		$result = $this->db->get_where('users',array('user_id' => $current_user_id));

		$this->load->library('phpass');
		
		$default = false;
		if ($result && $result->num_rows() > 0){
			$row = $result->row();
			if ($this->phpass->check('password', $row->hash)){
				$default = true;
			}
		}

		$this->response->check_default 	= $default;

		$this->response->message[] = array(
		    'message' => '',
		    'type' => 'success'
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
		$data['bday_id'] 	= $latest;
		$data['message_type'] 	= 'Birthday';



		// ADD NEW DATA FEED ENTRY
		$latest = $this->mod->newPostData($data, 'bday');
		$this->response->target	= $latest;

		// WHO OWES FOR THE GREETINGS?
		$this->response->celebrant = $data['recipient_id'];

		//insert to celebrant and user who greets
		$this->db->insert('system_feeds_recipient', array('id' => $latest, 'user_id' => $data['recipient_id']));
		$this->db->insert('system_feeds_recipient', array('id' => $latest, 'user_id' => $data['user_id']));
		
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
		$this->db->limit(1);
		$user = $this->db->get_where('users_profile', array('user_id' => $this->input->post('celebrant_id')))->row();
		$data['celebrant']['celebrant_name'] = $user->lastname . ', '. $user->firstname;
		$data['celebrant']['birth_date'] = date('Y').'-'. date('m-d', strtotime($user->birth_date) );

		$data['greetings'] = $this->mod->getBirthdayGreetings($data['celebrant']);		
		if( $this->input->post('mobileapp') )
			$this->response->greetings = $this->load->view('customs/birthday_greetings_mobile', $data, true);
		else
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
			$this->load->model('form_application_manage_model', 'dash_mod');

			$approver 		= $this->input->post('username');
			$action 		= $this->input->post('decission') == '1' ? ' approved ' : ' disapproved '; 
            $form_name      = $this->dash_mod->get_form_information($this->input->post('formid')); 
			// $form_name 		= $this->input->post('formname'); 
			$recipient 		= $this->input->post('formownerid');
			$notif_message 	= 'Filed ' . $form_name['form'] . ' for ' . date('F j, Y', strtotime($form_name['date_from'])) . ' has been '.$action.'.';
			if(trim($this->input->post('comment')) != ""){
				$notif_message 	.= '<br><br>Remarks: '.$this->input->post('comment');
			}

			$data['user_id'] 		= $this->session->userdata['user']->user_id; 								// THE CURRENT LOGGED IN USER 
			$data['display_name'] 	= $this->current_user['lastname']. ", ". $this->current_user['firstname'];	// THE CURRENT LOGGED IN USER'S DISPLAY NAME
			$data['feed_content'] 	= $notif_message;															// THE MAIN FEED BODY
			$data['recipient_id'] 	= $recipient;																// TO WHOM THIS POST IS INTENDED TO
			$data['status'] 		= 'info';																	// TO WHOM THIS POST IS INTENDED TO
			$data['message_type'] 	= 'Time Record';	
            $data['forms_id'] = $this->input->post('formid');																// DANGER, INFO, SUCCESS & WARNING

			// ADD NEW DATA FEED ENTRY
			$latest = $this->mod->newPostData($data, 'appforms');
			$this->response->target	= $latest;

            //Check if filed form is approved and hr validation is enabled
            if($form_name['form_status_id'] == 6){ //approved already
				$this->load->model('form_application_manage_model', 'form_manage');
                $this->form_manage->transfer_to_validation($form_name);
                $this->form_manage->notify_accounting($form_name);
            }elseif($form_name['form_status_id'] == 7){ //disapproved
				$this->load->model('form_application_manage_model', 'form_manage');
                $this->form_manage->remove_additiona_leave($form_name);
            }

			// determines to where the action was 
			// performed and used by after_save to
			// know which notification to broadcast
			$this->response->type 		= 'todo';
			$this->response->action 	= 'insert';

	        $this->response->message[] 	= array(
			    'message' 	=> lang('common.save_successful'),
			    'type' 		=> 'success'
			);
			
	    	$this->_ajax_return();
        }
        
	}

	function check_payroll_view_permission(){

		$payroll_modules = array('transaction_class', 'payroll_transactions', 'transaction_method', 'transaction_mode', 'loan', 'loan_type','overtime_rates','overtime_rates_fixed_amount',
								'settings', 'rate_type', 'account_type', 'accounts_chart', 'sub_accounts_chart', 'leave_conversion', 'bank_settings', 
								'whtax_table', 'sss_table', 'phic_table', 'annual_tax_rate');

		foreach ($payroll_modules as $module){
			
			$permission = $this->_check_permission($module);

			if($permission && $permission['list'] == 1){

				$view_permission[$module] = 1;
			}
			else{

				$view_permission[$module] = 0;
			}
		}

		return $view_permission;
	}

	function payroll()
	{
		$data = $this->load->get_cached_vars();
		$data['payroll_view_permission'] = $this->check_payroll_view_permission();;

		echo $this->load->blade('dashboards.payroll_manager')->with( $data );
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
			$this->db->order_by('report_name');
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
            case 18: //Employee’s Marriage
            case 19: //Marriage of Child
            case 20: //Childs Circumcision
            case 21: //Childs Baptism
            case 22: //Relatives Bereavement Leave
            case 23: //Pilgrimage Leave
            case 24: //Menstruation Leave
            case 25: //Family Bereavement Leave
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
            case 27://addl
                $form_details = $this->form_manage->get_ot_ut_dtrp_details($forms_id, $this->user->user_id);
                $form_page = 'addl_details';
                if($form_details['type'] == 'Use'){
                    $form_details = $this->mod->get_leave_details($forms_id, $this->user->user_id);
                    $form_page = 'leave_details';
                }
                $remarks['remarks'] = array();
                $comments = $this->form_manage->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);
                $this->response->form_details .= $this->load->blade('edit/'.$form_page, $form_details, true);            
            break;
            case 28: //RES
                $form_details = $this->form_manage->get_ot_ut_dtrp_details($forms_id, $this->user->user_id);
                if( ( strtotime($form_details['time_from'])) && ( strtotime($form_details['time_to'])) ){
                    $form_details['date_from'] = (!strtotime($form_details['time_from'])) ? "" : date("F d, Y - h:i a", strtotime($form_details['time_from']));
                    $form_details['date_to'] = ( !strtotime($form_details['time_to'])) ? "" : date("F d, Y - h:i a", strtotime($form_details['time_to']));
                    $form_details['res_type'] = 2;
                    $form_details['res_type_desc'] = 'In Between';
                    $form_details['ut_time_in_out'] = '';
                }else if( strtotime($form_details['time_from']) ){
                    $form_details['res_type'] = 1;
                    $form_details['res_type_desc'] = 'Excused Tardiness';
                    $form_details['date_from'] = (!strtotime($form_details['time_from'])) ? "" : date("F d, Y - h:i a", strtotime($form_details['time_from']));
                }else if( strtotime($form_details['time_to']) ){
                    $form_details['res_type'] = 0;
                    $form_details['res_type_desc'] = 'Official Undertime';
                    $form_details['date_to'] = (!strtotime($form_details['time_to'])) ? "" : date("F d, Y - h:i a", strtotime($form_details['time_to']));
                }
                $remarks['remarks'] = array();
                $comments = $this->form_manage->get_approver_remarks($forms_id);
                foreach ($comments as $comment){
                    $remarks['remarks'][] = $comment;
                }
                $form_details = array_merge($form_details, $remarks);
                $form_page = 'res_details';
                $this->response->form_details .= $this->load->blade('edit/'.$form_page, $form_details, true);  
            break;
        }

        $this->response->message[] = array(
	    	'message' => '',
	    	'type' => 'success'
		);

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
			
			if( $this->input->post('mobileapp') )
			{
				$vars['comment'] = $this->mod->get_feed_comment( $data['feeds_comment_id'] );
				$this->response->comment = $this->load->view('customs/feed_comments_mobile', array( 'comment' => $vars['comment']), true);
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
	}

	function delete_comment()
	{
		$this->_ajax_only();
		
		/*if( !$this->permission['delete'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		} */

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
		    		case "HALLOWEEN":
		    			//$holidayEvents['event_plugin'][] = '<script src="'.base_url().'/assets/plugins/holiday_events/halloween-bats.js"></script>';
		    			//$holidayEvents['event_script'][] = '<script src="'.base_url().'/assets/plugins/holiday_events/HALLOWEEN.js"></script>';
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
			$key_personal_qry = " SELECT * FROM {$this->db->dbprefix}partners_personal 
								WHERE partner_id = {$partner_id} AND deleted = 0 
								AND key_id = {$partners_key['key_id']} AND key_value !='' ";
			$key_personal_sql = $this->db->query($key_personal_qry);
			$request_done = $this->db->get_where('partners_personal_request', array('status' => 2, 'deleted' => 0, 'partner_id' => $partner_id, 'key_id' => $partners_key['key_id']))->row_array();
			
			if( !(count($request_done) > 0) && !($key_personal_sql->num_rows() > 0) ){
				$this->response->message[] = array(
			    	'message' => '',
			    	'type' => 'success'
				);
				$data = array();
				$country_sql = array();
				$country_qry = "SELECT cs.* FROM {$this->db->dbprefix}users_profile up
								INNER JOIN {$this->db->dbprefix}users_company uc ON up.company_id = uc.company_id 
								INNER JOIN {$this->db->dbprefix}countries cs ON uc.country_id = cs.country_id
								WHERE up.user_id = {$this->user->user_id}";
				$country_sql = $this->db->query($country_qry)->row_array();
				$data['countries'] = $country_sql;
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
			$country_qry = "SELECT cs.* FROM {$this->db->dbprefix}users_profile up
							INNER JOIN {$this->db->dbprefix}users_company uc ON up.company_id = uc.company_id 
							INNER JOIN {$this->db->dbprefix}countries cs ON uc.country_id = cs.country_id
							WHERE up.user_id = {$this->user->user_id}";
			$country_sql = $this->db->query($country_qry)->row_array();
			$countries = $country_sql;

			if ((substr($mobileNumber,0,1) != 0) && strlen($mobileNumber) < 11){
				$mobileNumber = '0'.$mobileNumber;
			}
			$pregs = '/(0|\+?\d{2})(\d{';
			$pregs .= ($countries['mobile_count']-1).',';
			$pregs .= $countries['mobile_count'].'})/';

			$output = preg_replace( $pregs, '0$2', $mobileNumber);

			preg_match( $pregs, $mobileNumber, $matches);
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
		$mobileNumber = '+'.$countries['calling_code'].$matches[2];
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

	function get_gender_stats()
	{
		$this->_ajax_only();	
		
		$year = date('Y');
		$month = date('m');
		
		$this->load->model('demographic_model', 'demographic');
		switch($this->input->post('filter'))
		{
			case "company":
				$stats = $this->demographic->get_gender_stats( $this->input->post('filter_value'), '', date('Y-m-d'));
				$population = $this->demographic->get_population_division_status( $this->input->post('filter_value'), '', date('Y-m-d'));
				break;
			case "department":
				$stats = $this->demographic->get_gender_stats( '', $this->input->post('filter_value'), date('Y-m-d'));
				$population = $this->demographic->get_population_division_status( $this->input->post('filter_value'), '', date('Y-m-d'));
				break;
			default:
				$stats = $this->demographic->get_gender_stats( '', '', date('Y-m-d'));
				$population = $this->demographic->get_population_division_status( '', '', date('Y-m-d'));
		}

		if( $stats )
		{
			$this->load->vars(array('stats' => $stats, 'population' => $population));
			$this->response->stat = $this->load->view('dashboards/gender_stats', array('stats' => $stats, 'population' => $population), true);
		}
		else{
			$this->response->stat = "";
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function internal_hiring(){
		$this->_ajax_only();
		$request_id = $this->input->post('request_id');
		$position = $this->input->post('position');

		$request_key_data = $this->db->get_where('recruitment_request_key', array('deleted' => 0, 'key_code' => 'job_description'))->row_array();
		$job_description = $this->db->get_where('recruitment_request_details', array('request_id' => $request_id, 'key_id' => $request_key_data['key_id']))->row_array();

		$this->response->message[] = array(
	    	'message' => '',
	    	'type' => 'success'
		);
		$data= array();
		$data['position'] = $position;
		$data['request_id'] = $request_id;
		$data['job_description'] = $job_description['key_value'];
		$this->response->internal_hiring = $this->load->view('edit/internal_hiring', $data, true);

        $this->_ajax_return();
	}

	function save_internal_hiring(){
		$this->_ajax_only();
		$this->response->invalid=false;
		$error = false;

		$data['user_id'] 		= $this->user->user_id;
		$data['request_id'] 	= $this->input->post('request_id');
		$data['cover_letter'] 	= $this->input->post('cover_letter');
		$data['position'] 		= $this->input->post('position');

		$users_details_qry = "SELECT upro.title, upro.suffix, upro.lastname, upro.firstname, 
							upro.middlename, upro.maidenname, upro.nickname, users.email, 
							upro.birth_date, upro.partner_id
							FROM {$this->db->dbprefix}users_profile upro
							LEFT JOIN {$this->db->dbprefix}users users 
							ON users.user_id = upro.user_id
							WHERE upro.user_id = {$data['user_id']} ";

		$users_details = $this->db->query($users_details_qry)->row_array();

		//recruitment table details
		$recruitment_data['recruitment']['recruitment_date'] = date('Y-m-d');
		$recruitment_data['recruitment']['title'] = $users_details['title']; 
		$recruitment_data['recruitment']['suffix'] = $users_details['suffix'];
		$recruitment_data['recruitment']['lastname'] = $users_details['lastname']; 
		$recruitment_data['recruitment']['firstname'] = $users_details['firstname'];
		$recruitment_data['recruitment']['middlename'] = $users_details['middlename']; 
		$recruitment_data['recruitment']['maidenname'] = $users_details['maidenname'];
		$recruitment_data['recruitment']['nickname'] = $users_details['nickname']; 
		$recruitment_data['recruitment']['email'] = $users_details['email'];
		$recruitment_data['recruitment']['birth_date'] = $users_details['birth_date']; 
		$recruitment_data['recruitment']['request_id'] = $data['request_id']; 
		$recruitment_data['recruitment']['partner_id'] = $users_details['partner_id']; 
		// $recruitment_data['recruitment']['cover_letter'] = $data['cover_letter']; 
	
        //SAVING START   
		$transactions = true;
		$this->partner_id = 0;
		if( $transactions )
		{
			$this->db->trans_begin();
		}

		$main_table = 'recruitment';
		$main_record = $recruitment_data['recruitment'];

		//add mandatory fields
		$main_record['created_by'] = $this->user->user_id;
		$this->db->insert($main_table, $main_record);
		if( $this->db->_error_message() == "" )
		{
			$this->recruit_id = $this->response->record_id = $this->record_id = $this->db->insert_id();
		}
		$this->response->action = 'insert';

		if( $this->db->_error_message() != "" ){
			$this->response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
			$error = true;
			goto stop;
		}else{
			//additional keys
			$recruit_keys = array();
			$recruitKeys = array(
						'position_sought' 		=> $data['position'], 
						'currently_employed' 	=> 1,
						'cover_letter'			=> $data['cover_letter']
						);
			foreach($recruitKeys as $keys => $value){
				$key_details = $this->db->get_where('recruitment_key', array('deleted' => 0, 'key_code' => $keys))->row_array();
				if(count($key_details) > 0){
					$recruit_keys['recruit_id'] = $this->recruit_id;
					$recruit_keys['key_id'] = $key_details['key_id'];
					$recruit_keys['key'] = $key_details['key_code'];
					$recruit_keys['sequence'] = 1;
					$recruit_keys['key_name'] = $key_details['key_label'];
					$recruit_keys['key_value'] = $value;
					$recruit_keys['created_by'] = $this->user->user_id;

					$this->db->insert('recruitment_personal', $recruit_keys);
							
					if( $this->db->_error_message() != "" ){
						$this->response->message[] = array(
							'message' => $this->db->_error_message(),
							'type' => 'error'
						);
						$error = true;
						goto stop;
					}
				}
			}

			$recruit_personal_qry = "SELECT * 
									FROM {$this->db->dbprefix}partners_personal 
									WHERE partner_id = {$users_details['partner_id']}";
			$recruit_personal_details = $this->db->query($recruit_personal_qry)->result_array();
			
			foreach($recruit_personal_details as $data){
				$key_details = $this->db->get_where('recruitment_key', array('deleted' => 0, 'key_code' => $data['key']))->row_array();
				if(count($key_details) > 0){
					$recruit_keys['recruit_id'] = $this->recruit_id;
					$recruit_keys['key_id'] = $key_details['key_id'];
					$recruit_keys['key'] = $key_details['key_code'];
					$recruit_keys['sequence'] = $data['sequence'];
					$recruit_keys['key_name'] = $key_details['key_label'];
					$recruit_keys['key_value'] = $data['key_value'];
					$recruit_keys['created_by'] = $this->user->user_id;

					$this->db->insert('recruitment_personal', $recruit_keys);
							
					if( $this->db->_error_message() != "" ){
						$this->response->message[] = array(
							'message' => $this->db->_error_message(),
							'type' => 'error'
						);
						$error = true;
						goto stop;
					}
				}
			}

			$recruit_personal_history_qry = "SELECT * 
									FROM {$this->db->dbprefix}partners_personal_history 
									WHERE partner_id = {$users_details['partner_id']}";
			$recruit_personal_history_details = $this->db->query($recruit_personal_history_qry)->result_array();
			
			$recruit_keys = array();
			foreach($recruit_personal_history_details as $data){
				$key_details = $this->db->get_where('recruitment_key', array('deleted' => 0, 'key_code' => $data['key']))->row_array();
				if(count($key_details) > 0){
					$recruit_keys['recruit_id'] = $this->recruit_id;
					$recruit_keys['key_id'] = $key_details['key_id'];
					$recruit_keys['key'] = $key_details['key_code'];
					$recruit_keys['sequence'] = $data['sequence'];
					$recruit_keys['key_name'] = $key_details['key_label'];
					$recruit_keys['key_value'] = $data['key_value'];
					$recruit_keys['created_by'] = $this->user->user_id;

					$this->db->insert('recruitment_personal_history', $recruit_keys);
							
					if( $this->db->_error_message() != "" ){
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
				'message' => 'Application successfully submitted.',
				'type' => 'success'
			);
		}

        $this->_ajax_return();

	}

	function get_demographic_filter()
	{
		$this->_ajax_only();
		$filter = array('<option value="">Select...</option>');
		switch( $this->input->post('filter_by') )
		{
			case "company":
				$this->db->order_by('company');
				$companies = $this->db->get_where('users_company', array('deleted' => 0));
				foreach($companies->result() as $company)
				{
					$filter[] = '<option value="'.$company->company_id.'">'.$company->company.'</option>';
				}
				break;
			case "department":
				$this->db->order_by('department');
				$departments = $this->db->get_where('users_department', array('deleted' => 0));
				foreach($departments->result() as $department)
				{
					$filter[] = '<option value="'.$department->department_id.'">'.$department->department.'</option>';
				}
				break;	
		}
		$this->response->filter = implode('',$filter);
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function feed_like()
	{
		$this->_ajax_only();
		$this->mod->feed_like( $this->input->post('feed_id'), $this->input->post('status') );
		$this->response->feed_id = $this->input->post('feed_id');
		$this->response->like_str = $this->mod->feed_like_str( $this->input->post('feed_id'), $this->input->post('mobileapp') );
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();	
	}

	function update_feed_like()
	{
		$this->_ajax_only();
		$this->response->like_str = $this->mod->feed_like_str( $this->input->post('feed_id') );
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();	
	}

	function view_post()
	{
		$this->_ajax_only();
		$this->mod->view_post( $this->input->post('feed_id') );
		$this->response->feed_id = $this->input->post('feed_id');
		$this->response->like_str = $this->mod->feed_like_str( $this->input->post('feed_id'), $this->input->post('mobileapp') );
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();	
	}

	function get_birthday_celebrants()
	{
		$this->_ajax_only();
		$data['birthdays'] = $this->mod->getBirthdayFeeds( $this->user->user_id );
		$this->response->celebrants = $this->load->view('celebrants', $data, true);
		$this->response->message[] = array(
		    'message' => '',
		    'type' => 'success'
		);
		$this->_ajax_return();	
	}

	function get_feed_comments()
	{
		$this->_ajax_only();
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
		);
		$this->_ajax_return();	
	}

    function update_department()
    {
        $company = '';
        $this->_ajax_only();
		$company_id = $this->input->post('company_id');
        if(!empty($company_id) ){
        	if(is_array($company_id)){
        		$comp_arr = array();
	            foreach ($company_id as $comp) 
	            {
	                $comp_arr[] = $comp;    
	            }
	            $comp_id = implode(',', $comp_arr);
	            $company = ' AND a.company_id IN ('.$comp_id.') ';
        	}
            if(!is_array($company_id) && $company_id != 'all'){
            	$company = ' AND a.company_id = '.$company_id;
            }

        }

		$departments = $this->db->query('SELECT DISTINCT a.company_id, b.department_id, c.department
										 FROM ww_payroll_partners a, ww_users_profile b, ww_users_department c
										 WHERE a.user_id=b.user_id AND c.department_id=b.department_id  '.$company);
		
        $this->response->departments = '<option value="" selected="selected">Select...</option>';
        foreach( $departments->result() as $department )
        {
            $this->response->departments .= '<option value="'.$department->department_id.'">'.$department->department.'</option>';
        }
        $this->_ajax_return();  
    }

    function get_support_box_form()
	{
		$this->_ajax_only();
		$data = array();
		$data['title'] = 'Support Box';	
		$data['description'] = date('F d, Y');	
		$this->load->vars( $data );
	
		$data['content'] = $this->load->blade('customs.support_box')->with( $this->load->get_cached_vars() );
		$this->response->support_box_form = $this->load->view('templates/modal', $data, true);

        $this->response->message[] = array(
		    'message' => '',
		    'type' => 'success'
		);

    	$this->_ajax_return();
	}

	function save_feedback()
	{
		$this->_ajax_only();
		$data = array();

		$data['msg_code'] = $this->input->post('msg_code');
		$data['msg'] = $this->input->post('feedback');
		$data['user_id'] = $this->user->user_id;
		$data['created_by'] = $this->user->user_id;
		$data['upload'] = $this->input->post('upload-photo');
		$image = $this->input->post('canvas_attachment');

		$validation_rules[] = 
			array(
				'field' => 'feedback',
				'label' => 'Message',
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

		$img = str_replace('data:image/png;base64,', '', $image);
		$img = str_replace(' ', '+', $img);
		$decoded = base64_decode($img);

		define('UPLOAD_DIR', 'uploads/support_box/');
		$support_box_folder = 'uploads/support_box/';
		if (!file_exists($support_box_folder)) {
		    mkdir($support_box_folder, 0755, true);
            copy(APPPATH .'index.html', $support_box_folder.'index.html');
		}

		$data['attachment'] = UPLOAD_DIR.date('YmdHis').'-'.$data['msg_code'].'-'.$this->user->user_id.'.png';
		file_put_contents($data['attachment'], $decoded);
		
        /***** END Form Validation (hard coded) *****/
        //SAVING START   
		$error = false;
		$transactions = true;

		if( $transactions )
		{
			$this->db->trans_begin();
		}
		
		//start saving with main table
		$this->db->insert('system_support', $data);

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
				'message' => 'Feedback was successfully saved.',
				'type' => 'success'
			);
		}

		$this->response->saved = !$error;
        $this->_ajax_return();
	}

	function screen_shot()
	{
		$this->_ajax_only();
		$image = $this->input->post('image');

		$this->response->screen_shot = 'test';
        $this->_ajax_return();
	}

	function get_upload_path($file_name = null, $version = null) {
        $file_name = $file_name ? $file_name : '';
        if (empty($version)) {
            $version_path = '';
        } else {
            $version_path = $version.'/';
        }
        return UPLOAD_DIR.$version_path.$file_name;
    }

    public function single_upload_support_box()
	{
		define('UPLOAD_DIR', 'uploads/support_box/');
		//$this->load->library("UploadHandler", 'uploadhandler');
		$this->load->library("UploadHandler");

		$file_uploaded = $_FILES['files']['name']; 
		$file_ext = pathinfo($file_uploaded[0], PATHINFO_EXTENSION);
		$allowable_file_type = array('jpg', 'jpeg', 'gif', 'png', 'pdf');

		if (!in_array($file_ext, $allowable_file_type)){			
			$this->response->message[] = array(
				'message' => 'Allow only image and pdf files.',
				'type' => 'warning'
			);
			$this->response->uploaded = false;
			$this->_ajax_return();
		}

		$files = $this->uploadhandler->post();
		$file = $files[0];

		if( isset($file->error) && $file->error != "" )
		{
			$this->response->message[] = array(
				'message' => $file->error,
				'type' => 'error'
			);	
		}

		$directory = substr($file->url, 0, strrpos( $file->url, '/')).'/'.$file->name;
		list($width, $height, $type, $attr) = getimagesize($directory);

		//create dashboard image
		$support_box_folder = 'uploads/support_box/support_box';
		if (!file_exists($support_box_folder)) {
		    mkdir($support_box_folder, 0755, true);
            copy(APPPATH .'index.html', $support_box_folder.'index.html');
		}
		$options = array(
	                'max_width' => ($width < 480) ? $width : 480,
	                'max_height' => $height
	                );

		$this->create_scaled_image($file->name,'support_box', $options);
	
        if (strtolower(substr(strrchr($file->name, '.'), 1)) == 'pdf') {
			//create dashboard-sized image
			$base_path = str_replace("\\", "/", FCPATH);
			$thumbFormat = 'jpg';
			$pdf_thumbName = substr($file->name, 0, strrpos( $file->name, '.'));
			$pdf_dash = new imagick($base_path.$directory.'[0]');
			$pdf_dash->setImageFormat($thumbFormat);
			$pdf_dash->thumbnailImage( 480, 480);
			// write to disk
			$pdf_dash->writeImage($base_path.$support_box_folder.$pdf_thumbName.'.'.$thumbFormat );

			//create thumbnail-sized image
			$thumbnail_folder = 'uploads/support_box/thumbnail/';
			if (!file_exists($thumbnail_folder)) {
			    mkdir($thumbnail_folder, 0755, true);
	            copy(APPPATH .'index.html', $thumbnail_folder.'index.html');
			}
			$pdf_thumb = new imagick($base_path.$directory.'[0]');
			$pdf_thumb->setImageFormat($thumbFormat);
			$pdf_thumb->thumbnailImage( 45, 43);
			// write to disk
			$pdf_thumb->writeImage($base_path.$thumbnail_folder.$pdf_thumbName.'.'.$thumbFormat );
		}

		$this->response->file = $file;
		$this->_ajax_return();
	}

     function create_scaled_image($file_name, $version, $options) {
        $file_path = $this->get_upload_path($file_name);
        if (!empty($version)) {
        	$version_dir = $this->get_upload_path(null, $version);
            $new_file_path = $version_dir.'/'.$file_name;
    	}else{
        	$new_file_path = $file_path;
    	}

        if (!function_exists('getimagesize')) {
            error_log('Function not found: getimagesize');
            return false;
        }
        list($img_width, $img_height) = @getimagesize($file_path);
        if (!$img_width || !$img_height) {
            return false;
        }
        $max_width = $options['max_width'];
        $max_height = $options['max_height'];
        $scale = min(
            $max_width / $img_width,
            $max_height / $img_height
        );
        if ($scale >= 1) {
            if ($file_path !== $new_file_path) {
                return copy($file_path, $new_file_path);
            }
            return true;
        }
        if (!function_exists('imagecreatetruecolor')) {
            error_log('Function not found: imagecreatetruecolor');
            return false;
        }
        if (empty($options['crop'])) {
            $new_width = $img_width * $scale;
            $new_height = $img_height * $scale;
            $dst_x = 0;
            $dst_y = 0;
            $new_img = imagecreatetruecolor($new_width, $new_height);
        } else {
            if (($img_width / $img_height) >= ($max_width / $max_height)) {
                $new_width = $img_width / ($img_height / $max_height);
                $new_height = $max_height;
            } else {
                $new_width = $max_width;
                $new_height = $img_height / ($img_width / $max_width);
            }
            $dst_x = 0 - ($new_width - $max_width) / 2;
            $dst_y = 0 - ($new_height - $max_height) / 2;
            $new_img = imagecreatetruecolor($max_width, $max_height);
        }
        switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
            case 'jpg':
            case 'jpeg':
                $src_img = imagecreatefromjpeg($file_path);
                $write_image = 'imagejpeg';
                $image_quality = isset($options['jpeg_quality']) ?
                    $options['jpeg_quality'] : 75;
                break;
            case 'gif':
                imagecolortransparent($new_img, imagecolorallocate($new_img, 0, 0, 0));
                $src_img = imagecreatefromgif($file_path);
                $write_image = 'imagegif';
                $image_quality = null;
                break;
            case 'png':
                imagecolortransparent($new_img, imagecolorallocate($new_img, 0, 0, 0));
                imagealphablending($new_img, false);
                imagesavealpha($new_img, true);
                $src_img = imagecreatefrompng($file_path);
                $write_image = 'imagepng';
                $image_quality = isset($options['png_quality']) ?
                    $options['png_quality'] : 9;
                break;
            default:
                imagedestroy($new_img);
                return false;
        }
        $success = imagecopyresampled(
            $new_img,
            $src_img,
            $dst_x,
            $dst_y,
            0,
            0,
            $new_width,
            $new_height,
            $img_width,
            $img_height
        ) && $write_image($new_img, $new_file_path, $image_quality);
        // Free up memory (imagedestroy does not delete files):
        imagedestroy($src_img);
        imagedestroy($new_img);
        return $success;
    }

}
