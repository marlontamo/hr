<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Timerecord extends MY_PrivateController
{
	public function __construct(){
		$this->load->model('timerecord_model', 'mod');
		parent::__construct();
	}

	public function index(){   
		
		$data = array();

		$data['year'] = date('Y');
        $data['prev_year']['key'] 	= date('Y') - 1;
        $data['prev_year']['value'] = date('Y') - 1;
        $data['next_year']['key'] 	= date('Y') + 1;
        $data['next_year']['value']	= date('Y') + 1;

        // filters
        $data['current_date'] 	= date("Y-m-d");
        $data['prev_month'] 	= date("Y-m-d", strtotime($data['current_date'] . ' - 1 months'));
        $data['next_month'] 	= date("Y-m-d", strtotime($data['current_date'] . ' + 1 months'));

		for ($m=1; $m<=12; $m++) {

			$month_key = date('Y-m-d', mktime(0,0,0,$m, 1, date('Y')));
    		$month_value = date('F', mktime(0,0,0,$m, 1, date('Y')));
     		$data['month_list'][$month_key] = $month_value;
     	}

        $user_setting = APPPATH . 'config/users/'. $this->user->user_id .'.php';
        $user_id = $this->user->user_id;
        $this->load->config( "users/{$user_id}.php", false, true );
        $user = $this->config->item('user');

        $this->load->config( 'roles/'. $user['role_id'] .'/permission.php', false, true );
        $permission = $this->config->item('permission');
        $this->load->model('timerecord_manage_model', 'tr_manage');

        $data['permission_tr_manage'] = isset($permission[$this->tr_manage->mod_code]['list']) ? $permission[$this->tr_manage->mod_code]['list'] : 0;
        $data['permission_tr_personal'] = isset($this->permission['list']) ? $this->permission['list'] : 0;

        $this->load->vars( $data );

        echo $this->load->blade('record_listing_custom')->with( $this->load->get_cached_vars() );
	}

	function get_list(){
		
		$this->_ajax_only();

		if( !$this->permission['list'] ){
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$range = '';
		$data = array();
		$data['pn'] = '';
		$data['sf'] = '';

		// determine list request
		$type 	= $this->input->post('type');
		$value 	= $this->input->post('value');

		if( $this->input->post('mobileapp') )
		{
			$page 	= $this->input->post('page') - 1;
			$value = date('Y-m-d', strtotime("-{$page} month"));
			$this->response->value = $value;
		}

		// get currently selected year
		$csy_value 	= $this->input->post('selected_year');
		$currently_selected_year = $csy_value == '' ? $csy_value : date("Y");
		$date = date("Y-m-d");

		if($type === 'month' || $type === 'current'){

			$value = $type === 'current' ? date("Y-m-d") : $value;

			// if month, move to selected month
			// and setup pagination and month list
			$date = $value;

			// pn - previous/next 
			$data['pn']['prev'] = date("Y-m-d", strtotime($value . ' - 1 months'));
			$data['pn']['current'] = date("Y-m-d", strtotime($value)); // remove this line
			$data['pn']['nxt'] 	= date("Y-m-d", strtotime($value . ' + 1 months'));

			// side filter
			$selected_year = date('Y', strtotime($value));
			$prev_year = date('Y', strtotime($value)) - 1;
			$next_year = date('Y', strtotime($value)) + 1;


			$sf = '<span id="yr-fltr-prev" data-year-value="' . $prev_year . '" class="event-block label label-info external-event year-filter">' . $prev_year . '</span>';

			for($m=1; $m<=12; $m++) {

				$month_key = date('Y-m-d', mktime(0,0,0,$m, 1, date('Y', strtotime($value))));
    			$month_value = date('F', mktime(0,0,0,$m, 1, date('Y', strtotime($value))));

    			$label_class = date("F", strtotime($value)) === $month_value ? 'label-success' : 'label-default';

				$sf .= '<span id="ml-'.$month_key.'" data-month-value="'.$month_key.'" class="event-block label ' . $label_class .' external-event month-list">'.$month_value.'</span>';
	     	}

	     	$sf .= '<span id="yr-fltr-next" data-year-value="' . $next_year . '" class="event-block label label-info external-event year-filter">
	                	' . $next_year . '
	                </span>';

			$data['sf'] = $sf;
			$range = "month";

			$this->response->current_title = date("F-Y", strtotime($value));
		}
		else if($type === 'year'){ 

			$range = "year";

			// if year, on previous year load the last month
			// otherwise move to first month of future year
			if($value < date('Y')){

				// now we're talking about previous year
				$data['pn']['prev'] = date("Y-m-d", strtotime($value . '-11-01'));
				$data['pn']['current'] = date("Y-m-d", strtotime($value . '-12-01'));
				$data['pn']['nxt'] 	= date("Y-m-d", strtotime($value + 1 . '-01-01'));

				// side filter
				$selected_year = date('Y', strtotime($value . '-01-01'));
				$prev_year = date('Y', strtotime($value . '-01-01')) - 1;
				$next_year = date('Y', strtotime($value . '-01-01')) + 1;
			}
			else{

				// future year
				$data['pn']['prev'] = date("Y-m-d", strtotime($value - 1 . '-12-01'));
				$data['pn']['current'] = date("Y-m-d", strtotime($value . '-01-01'));
				$data['pn']['nxt'] 	= date("Y-m-d", strtotime($value . '-02-01'));

				// side filter
				$selected_year = date('Y', strtotime($value . '-01-01'));
				$prev_year = date('Y', strtotime($value . '-01-01')) - 1;
				$next_year = date('Y', strtotime($value . '-01-01')) + 1;
			}

			$date = $data['pn']['current'];

			$sf = '';
			$sf = '<span 
						id="yr-fltr-prev" 
						data-year-value="' . $prev_year . '" 
						data-year-selected="' . $currently_selected_year . '" 
						class="event-block label label-info year-filter">' . $prev_year . '</span>';

			for($m = 1; $m <= 12; $m++) {

				$month_key = date('Y-m-d', mktime(0,0,0,$m, 1, $value));
    			$month_value = date('F', mktime(0,0,0,$m, 1, $value));

    			$label_class = date("F", strtotime($date)) === $month_value ? 'label-success' : 'label-default';

				$sf .= '<span id="ml-'.$month_key.'" data-month-value="'.$month_key.'" class="event-block label ' . $label_class .' external-event month-list">'.$month_value.'</span>';
	     	}

	     	$sf .= '<span 
	     				id="yr-fltr-next" 
	     				data-year-value="' . $next_year . '" 
	     				data-year-selected="' . $currently_selected_year . '" 
	     				class="event-block label label-info external-event year-filter">
	                	' . $next_year . '
	                </span>';

			$data['sf'] = $sf;

			$this->response->current_title = date("F-Y", strtotime($date));
		}

		// Pay period filter
		// limited to 5 paydates
		$ppfs = $this->mod->get_period_list();

		$records = $this->mod->_get_list($range, $date);
		$this->response->records_retrieve = sizeof($records);
		$this->response->list = '';

		$this->response->pn = $data['pn'];
		$this->response->sf = $data['sf'];
		$this->response->ppf = '';

		foreach( $ppfs as $ppf ){
			$this->response->ppf .= '<span 
										id="ppf-'.$ppf['record_id'].'" 
										data-ppf-value-from="'.$ppf['from'].'" 
										data-ppf-value-to="'.$ppf['to'].'"  
										class="event-block label label-default external-event period-filter">'
										.$ppf['payroll_date'].
									'</span>';
		}
		// debug($records); die;
		foreach( $records as $record ){
			$record['forms'] = array();
			$record['forms'] = $this->mod->time_record_list_forms($record['date'], $record['user_id']);
			//$record['remind_icon'] = $this->mod->is_dtr_editable($record['date'], $record['user_id']);

			$this->response->list .= $this->load->blade('list_template_custom', $record, true);
		}

		$this->response->message[] = array(
	    	'message' => '',
	    	'type' => 'success'
		);

		$this->_ajax_return();
	}

	function get_period_list(){

		if( !$this->permission['list'] ){
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$from 	= $this->input->post('from');
		$to 	= $this->input->post('to');

		$ppfs = $this->mod->get_period_list();
		$records = $this->mod->_get_list_by_period($from, $to);

		$this->response->list = '';

		foreach( $records as $record ){
			$record['forms'] = array();
			$record['forms'] = $this->mod->time_record_list_forms($record['date'], $record['user_id']);

			$this->response->list .= $this->load->blade('list_template_custom', $record, true);
		}

		$this->_ajax_return();
	}

    function get_form_details(){
        $this->_ajax_only();
        $form_id = $this->input->post('form_id');
        $forms_id = $this->input->post('forms_id');
        $date = $this->input->post('date');

		$this->load->model('form_application_manage_model', 'form_manage');
        $this->response->form_details = '';

        $form_details = $this->mod->time_record_list_forms_details($forms_id, $this->user->user_id,$date);
        $remarks['remarks'] = array();
        $comments = $this->form_manage->get_approver_remarks($forms_id);
        foreach ($comments as $comment){
            $remarks['remarks'][] = $comment;
        }
        $form_details = array_merge($form_details, $remarks);

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
            case 21: //Home Leave
            case 22: //Leave Incentive Program
            case 23: //Force Leave
            case 24: //Menstruation Leave
            case 25: //Family Bereavement Leave
                $this->response->form_details .= $this->load->blade('edit/dialog/leave_details', $form_details, true);
            break;
            case 8://obt
                $this->response->form_details .= $this->load->blade('edit/dialog/obt_details', $form_details, true);            
            break;
            case 9://ot
                $this->response->form_details .= $this->load->blade('edit/dialog/ot_details', $form_details, true);            
            break;
            case 10://ut
                $this->response->form_details .= $this->load->blade('edit/dialog/ut_details', $form_details, true);            
            break;
            case 11://dtrp
                $this->response->form_details .= $this->load->blade('edit/dialog/dtrp_details', $form_details, true);            
            break;
            case 12://cws
                $this->response->form_details .= $this->load->blade('edit/dialog/cws_details', $form_details, true);            
            break;
        }

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }

    function edit_timerecord(){
		$this->_ajax_only();

		$this->load->helper('form');
		$this->load->helper('file');
		
		$data['record_id'] = $record_id = $this->input->post('record_id');
		$sql_timerecord = $this->db->get_where('time_record', array('record_id' => $record_id));
		$timerecord_details = $sql_timerecord->row_array();

		$data['title'] = 'Editing: '.date( "F d, Y", strtotime($timerecord_details['date']) );
		$data['time_in'] = date( "h:i A", strtotime($timerecord_details['time_in']) );
		$data['time_out'] = date( "h:i A", strtotime($timerecord_details['time_out']) );
		$data['date'] = $timerecord_details['date'];

		$this->load->vars( $data );
		$data['content'] = $this->load->blade('templates.quick_edit')->with( $this->load->get_cached_vars() );
		$this->response->quick_edit_form = $this->load->view('templates/edit_timerecord', $data, true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
    }

    function save_timerecord(){
		$this->_ajax_only();


		$record_id = $this->input->post('record_id');
		$date = $this->input->post('date');
		$sql_timerecord = $this->db->get_where('time_record', array('record_id' => $record_id));
		$timerecord_details = $sql_timerecord->row_array();

		$main_record['override'] = 1;
		$main_record['time_in'] = $date.' '.date( 'H:i:s', strtotime($this->input->post('time_in')) );
		$main_record['time_out'] = $date.' '.date( 'H:i:s', strtotime($this->input->post('time_out')) );

		$this->db->update( 'time_record', $main_record, array( 'record_id' => $record_id ) );

		$this->response->saved = true;
		$this->response->message[] = array(
			'message' => lang('common.save_success'),
			'type' => 'success'
		);


		$this->_ajax_return();
	}

    function insert_dtr_raw(){
		$this->_ajax_only();

		$main_record['checktype'] = $this->input->post('type');
		$main_record['location'] = $this->input->post('location');
		$main_record['user_id'] = $this->user->user_id;
		$main_record['date'] = date('Y-m-d');
		$main_record['checktime'] = date('Y-m-d H:i:s');

		$this->db->insert( 'time_record_raw', $main_record );

		$this->response->saved = true;
		$this->response->message[] = array(
			'message' => lang('common.save_success'),
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function updating($manage=false, $record_id = 0)
	{
		if( !$this->mod->is_dtru_applicable() ){
			$this->_ajax_only();
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$this->load->model('my_calendar_model', 'my_calendar');

		$data = array();

		$data['year'] = date('Y');
        $data['prev_year']['key'] 	= date('Y') - 1;
        $data['prev_year']['value'] = date('Y') - 1;
        $data['next_year']['key'] 	= date('Y') + 1;
        $data['next_year']['value']	= date('Y') + 1;

        // filters
        $data['current_date'] 	= date("Y-m-d");
        $data['prev_month'] 	= date("Y-m-d", strtotime($data['current_date'] . ' - 1 months'));
        $data['next_month'] 	= date("Y-m-d", strtotime($data['current_date'] . ' + 1 months'));

		for ($m=1; $m<=12; $m++) {

			$month_key = date('Y-m-d', mktime(0,0,0,$m, 1, date('Y')));
    		$month_value = date('F', mktime(0,0,0,$m, 1, date('Y')));
     		$data['month_list'][$month_key] = $month_value;
     	}

     	if($record_id > 0 && ($manage !== false && $manage == 'manage')){
 			$this->load->model('form_application_manage_model', 'form_manage');
			$forms_info = $this->form_manage->get_forms_details($record_id);
			$data['forms_info'] = $forms_info;
		}
		
     	$ppfs = $this->mod->get_period_list();

     	$data['ppf'] = "<option></option>";
		foreach( $ppfs as $ppf ){
			$selected = (isset($forms_info['date_from']) && $forms_info['date_from'] == $ppf['from']) ? "selected='selected'" : '';
			$data['ppf'] .= '<option value-from="'.$ppf['from'].'" value-to="'.$ppf['to'].'" value="'.$ppf['record_id'].'" '.$selected.'>'.$ppf['payroll_date'].'</option>';
		}

		$query = "SELECT DISTINCT(tf.user_id), tf.display_name 
					FROM ww_time_forms tf
					  JOIN ww_time_forms_approver fa
					    ON tf.forms_id = fa.forms_id
					WHERE tf.form_code = 'DTRU'
					    AND fa.user_id = {$this->user->user_id}";

		$forms_to_approve = $this->db->query($query);
		if($forms_to_approve && $forms_to_approve->num_rows() > 0 ){
			$is_approver = true;
			$data['partners'] = $forms_to_approve->result_array();
			// $data['approver_name'] = $forms_to_approve->row()->approver;
			$data['approver_remarks'] = $this->db->get_where('time_forms_approver', array('user_id' => $this->user->user_id, 'forms_id' => $record_id))->row_array();

		}

		$user_setting = APPPATH . 'config/users/'. $this->user->user_id .'.php';
        $user_id = $this->user->user_id;
        $this->load->config( "users/{$user_id}.php", false, true );
        $user = $this->config->item('user');
		$this->load->config( 'roles/'. $user['role_id'] .'/permission.php', false, true );
        $permission = $this->config->item('permission');
        $this->load->model('timerecord_manage_model', 'tr_manage');	
        
        $data['permission_tr_manage'] = isset($permission[$this->tr_manage->mod_code]['list']) ? $permission[$this->tr_manage->mod_code]['list'] : 0;
        $data['permission_tr_personal'] = isset($this->permission['list']) ? $this->permission['list'] : 0;
		
		$data['user_id'] = $user_id;
		$this->load->vars( $data );
		if($manage !== false && $manage == 'manage'){
			echo $this->load->blade('tabs.updating.manage')->with( $this->load->get_cached_vars() );
		}else{

			echo $this->load->blade('tabs.updating.personal')->with( $this->load->get_cached_vars() );	
		}
   	    

	}

	function get_updating_period_list(){

		if( !$this->permission['list'] ){
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$from 	= $this->input->post('from');
		$to 	= $this->input->post('to');
		$type 	= $this->input->post('type');
		$user_id 	= $this->input->post('user_id');

		$ppfs = $this->mod->get_period_list();

		$this->load->model('Admin_timerecord_model', 'admin_manage');
		$periods = $this->admin_manage->_get_list_by_period($user_id, $from, $to);

		$this->response->list = '';
		$this->response->approver = '';
		$forms_id = 0;
		$status_id = 0;
		$hide_btn = false;
		$dates = array();
		foreach( $periods as $period ){
			$dates[] = $period['date'];
		}

		$this->db->where('form_code' , 'DTRU');
		$this->db->where('deleted' , 0);
		$this->db->where('user_id' , $user_id);
		$this->db->where('date_from' , current($dates));
		$this->db->where('date_to' , end($dates));
		$form_application = $this->db->get('time_forms');
		$for_approval = 0;
		if($form_application && $form_application->num_rows() > 0){
			$forms_id = $form_application->row()->forms_id;
			$status_id = $form_application->row()->form_status_id;
			if(in_array($status_id, array(2,3,6)) ){
				$hide_btn = true;
			}
			
			if($type == 'manage'){
				$query = "SELECT * FROM `time_forms_manage` WHERE form_code = 'DTRU' AND approver_id = {$this->user->user_id} AND forms_id = {$forms_id}";
				$form_to_approve = $this->db->query($query);

				if($form_to_approve && $form_to_approve->num_rows() > 0){
					$form_to_approve = $form_to_approve->row();
					if($form_to_approve->approver_status == "Approved"){
						$hide_btn = true;
					}elseif($form_to_approve->approver_status == "For Approval"){
						$hide_btn = false;
						$for_approval = 1;
					}
					
				}
			}else{
		
				$approvers['approvers'] = $this->db->get_where('time_forms_approver', array('forms_id' => $forms_id))->result_array();
		
				$this->response->approvers .= $this->load->blade('tabs.updating.approvers_remarks', $approvers, true);	
			}
			
			
		}

		foreach( $periods as $record ){
			$record['status'] = 0;
			$record['type'] = $type;

			$record['time_in_dtr'] = '';
			if($record['time_in'] == '') {
				$record['time_in_dtr'] = $record['aux_time_in'];
			} else if($record['aux_time_in'] == '') {
				$record['time_in_dtr'] = $record['time_in'];
			} else if($record['time_in'] >= $record['aux_time_in']) {
				$record['time_in_dtr'] = $record['aux_time_in'];
			} else if($record['time_in'] <= $record['aux_time_in']) {
				$record['time_in_dtr'] = $record['time_in'];
			} 

			$record['time_out_dtr'] = '';
			if($record['time_out'] == '') {
				$record['time_out_dtr'] = $record['aux_time_out'];
			} else if($record['aux_time_out'] == '') {
				$record['time_out_dtr'] = $record['time_out'];
			} else if($record['time_out'] >= $record['aux_time_out']) {
				$record['time_out_dtr'] = $record['aux_time_out'];
			} else if($record['time_out'] <= $record['aux_time_out']) {
				$record['time_out_dtr'] = $record['time_out'];
			}

			// ($record['time_in'] > $record['aux_time_in']) ? $record['aux_time_in'] : $record['time_in'];
	        //$record['time_out_dtr'] = ($record['time_out'] > $record['aux_time_out']) ? $record['aux_time_out'] : $record['time_out'];

			$time_record_aux = $this->mod->get_timerecord_aux($record['date'], $forms_id);

			$this->db->select('shift_id,shift');
	        $this->db->order_by('shift', '0');
	        $this->db->where('deleted', '0');
	        $options = $this->db->get('time_shift');
	        $time_shift_id_options = array('' => 'Select...');

	        foreach($options->result() as $option)
	        {
	            $time_shift_id_options[$option->shift_id] = $option->shift;
	        } 

	        $record['time_shift_id_options'] = $time_shift_id_options;

	        if(!empty($time_record_aux)){

				$record['record_id'] = $time_record_aux['id'];
				$record['shift_id'] = $time_record_aux['shift_id'];
				// $record['shift'] = $time_record_aux['shift'];
				$record['time_in'] = $time_record_aux['time_from'];
				$record['time_out'] = $time_record_aux['time_to'];
				$record['status'] = $status_id;
				$record['date_tag'] = date('M-d', strtotime($time_record_aux['date']));
				$record['aux_shift_id'] = $time_record_aux['shift_to'];;
				$record['remarks'] = $time_record_aux['approved_comment'];

				// if($time_record_aux['status'] == 6 || $time_record_aux['status'] == 2){
				// 	$hide_btn = true;
				// }
			}
			else{
				$record['time_in'] =  ''; //$time_record_aux['time_from'];
				$record['time_out'] = ''; //$time_record_aux['time_to'];
			}
			$record['for_approval'] = $for_approval;
			$this->response->list .= $this->load->blade('tabs.list_template_custom', $record, true);	
			
		}

		$this->response->forms_id = $forms_id;
		$this->response->from = $from;
		$this->response->for_approval = $for_approval;
		$this->response->forms_status = $status_id;
		$this->response->hide_btn = $hide_btn;
		$this->_ajax_return();
	}

	function save_timerecord_aux()
	{
		$this->_ajax_only();
		
		$error = false;
		$status 	= $this->input->post('status_id');
		$dates 		= $this->input->post('date');
		$user_id 	= $this->input->post('user_id');
		$timein 	= $this->input->post('timein');
		$timeout 	= $this->input->post('timeout');
		$remarks 	= $this->input->post('remarks');
		$shift_to 	= $this->input->post('shift');
		$shift_id 	= $this->input->post('shift_id');
		$shiftname 	= $this->input->post('shiftname');
		$periodname = $this->input->post('pay_date_name');
		$period_id  = $this->input->post('pay_dates');
		$forms_id  = $this->input->post('forms_id');
		$display_name = $this->mod->get_display_name($user_id);
		$time_in_dtr 	= $this->input->post('time_in_dtr');
		$time_out_dtr 	= $this->input->post('time_out_dtr');

		//SAVING START   
		$transactions = true;
		if( $transactions )
		{
			$this->db->trans_begin();
		}
		
		$approvers = $this->db->query("CALL sp_time_forms_get_approvers('DTRU', ".$user_id.")");
		mysqli_next_result($this->db->conn_id);

		if($approvers && $approvers->num_rows() > 0){

		}else{
			$this->response->message[] = array(
				'message' => 'Approver not set please call the System Administrator!',
				'type' => 'error'
			);
			$this->response->period_id = $this->input->post('pay_dates');
			$this->response->saved = false;
			$this->_ajax_return();
		}

        $date_from = current($dates);
		$date_to = end($dates);

		$data = array('form_status_id' => $status,
				 'form_id' => 18,
				 'form_code' => 'DTRU',
				 'user_id' => $user_id,
				 'display_name' => $display_name,
				 'date_from' => $date_from,
				 'date_to' => $date_to,
				 'reason' => 'Time Record Updating',
				 'day' => count($dates),
				 );

		$count_timeinout = 0;
		foreach ($dates as $key => $date) {

			if($timein[$date] == ''){
				$count_timeinout++;
			}

			if($this->input->post('status_id') >= 2){
				if($shiftname[$date] != 'Restday'){
					if(($timein[$date] != $time_in_dtr[$date] && $timeout[$date] == $time_out_dtr[$date]) || ($timein[$date] == $time_in_dtr[$date] && $timeout[$date] != $time_out_dtr[$date] )) {
						$this->response->message[] = array(
							'message' => 'Invalid Time in and Time out '. $time_in_dtr[$date] .  ' - ' . $time_out_dtr[$date],
							'type' => 'error'
						);
						$this->response->period_id = $this->input->post('pay_dates');
						$this->response->saved = false;
						$this->_ajax_return();
					}
				}
			}

			// if($this->input->post('status_id') >= 2){
			// 	if($shiftname[$date] != 'Restday'){
			// 		if(($timein[$date] != '' && $timeout[$date] == '') || ($timein[$date] == '' && $timeout[$date] != '')){
			// 			$this->response->message[] = array(
			// 				'message' => 'Invalid Time in and Time out1! '. $timein[$date] .  ' - ' . $timeout[$date] ,
			// 				'type' => 'error'
			// 			);
			// 			$this->response->period_id = $this->input->post('pay_dates');
			// 			$this->response->saved = false;
			// 			$this->_ajax_return();
			// 		}
			// 	}
			// }

			$time_in = str_replace(" - "," ",$timein[$date]);
			$time_out = str_replace(" - "," ",$timeout[$date]);

			if($timein[$date] != '' && $timeout[$date] != ''){
				if(strtotime($time_out) < strtotime($time_in) && $this->input->post('status_id') >= 2){
					$this->response->message[] = array(
						'message' => 'Invalid Time in and Time out! '. $timein[$date] .  ' - ' . $timeout[$date] ,
						'type' => 'error'
					);
					$this->response->period_id = $this->input->post('pay_dates');
					$this->response->saved = false;
					$this->_ajax_return();
				}
			}


		}
		
		if($count_timeinout == count($dates) && $this->input->post('status_id') >= 2){
			$this->response->message[] = array(
				'message' => 'Invalid Time in and Time out! ',
				'type' => 'error'
			);
			$this->response->period_id = $this->input->post('pay_dates');
			$this->response->saved = false;
			$this->_ajax_return();
		}

		$new = false;
		$dtru_details = false;
		if($forms_id > 0){
			$data['modified_on'] = date('Y-m-d H:i:s');
			$data['modified_by'] = $user_id;
			$this->db->update('time_forms', $data, array('forms_id' => $forms_id));
		}else{
			$data['created_by'] = $user_id;
			$this->db->insert('time_forms', $data);
			$forms_id = $this->db->insert_id();
			$new = true;
		}

		if( $this->db->_error_message() != "" )
		{
			$error = true;
			goto stop;
		}

		if(!empty($forms_id)){
			$this->load->model('form_application_model', 'form_application');
			$dtru_details = $this->form_application->get_forms_details($forms_id);
			if($this->input->post('status_id') == 2){
	            //INSERT NOTIFICATIONS FOR APPROVERS
	            $this->response->notified = $this->mod->notify_approvers( $user_id, $status, $periodname, $dtru_details);
	            $this->response->notified = $this->mod->notify_filer( $user_id, $periodname);
	        }
	    }

		foreach ($dates as $key => $date) {
			$time_in = str_replace(" - "," ",$timein[$date]);
			$time_out = str_replace(" - "," ",$timeout[$date]);

			$sql_timerecord_aux = $this->db->get_where('time_forms_date', array('date' => $date, 'forms_id' => $forms_id,));

			// $main_record['status'] 		= $status;
			$main_record['forms_id'] 	= $forms_id; 
			$main_record['time_from'] 	= (!strtotime($time_in)) ? null : date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$timein[$date])));
			$main_record['time_to'] 	= (!strtotime($time_out)) ? null : date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$timeout[$date])));
			$main_record['approved_comment'] = $remarks[$date];
			$main_record['shift_id'] 	= $shift_id[$date];
			$main_record['shift_to'] 	= ($shift_id[$date] !== $shift_to[$date]) ? $shift_to[$date] : 0;
			// $main_record['shift'] 		= $shiftname[$date];
			$main_record['date'] 		= $date;
			$main_record['day'] 		= 1;
		
			
			if($sql_timerecord_aux && $sql_timerecord_aux->num_rows() > 0){
				$timerecord_aux_details = $sql_timerecord_aux->row_array();
				$this->db->update( 'time_forms_date', $main_record, array( 'id' => $timerecord_aux_details['id'] ) );
			}else{
				$this->db->insert('time_forms_date', $main_record);
			}

			if( $this->db->_error_message() != "" )
			{
				$error = true;
				goto stop;
			}
		}

		if($this->input->post('type') == 'manage'){

			if(!$new && ($this->input->post('revision') == 1 || $status == 6) ){
				$this->_forms_decission($forms_id, $user_id, $status);	
			}
				
			$this->db->update('time_forms_approver', array('comment' => $this->input->post('approver_remarks')), array('user_id' => $this->user->user_id, 'forms_id' => $forms_id));
		}
		
		$data['modified_on'] = date('Y-m-d H:i:s');
		$this->db->update('time_forms', $data, array('forms_id' => $forms_id));

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
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
		}else{
			$this->response->message[] = array(
				'message' => lang('common.inconsistent_data'),
				'type' => 'error'
			);
		}
		$this->response->period_id = $this->input->post('pay_dates');
		$this->response->manage = $this->input->post('type');
		$this->response->saved = !$error;
		$this->_ajax_return();
	}


	private function _forms_decission($forms_id, $formownerid, $status){

        $this->current_user = $this->config->item('user');
        $data = array();
        $this->load->model('form_application_manage_model', 'form_manage');
        $form_name      = $this->form_manage->get_form_information($forms_id); 
            
        $recipient      = $formownerid;

        if($status == 1){
        	$action  = "Revision";
    		$notif_message  = 'Please revise your '.$form_name['form'].' Application filed on '. date('F d, Y' , strtotime($form_name['created_on']));
    	}else{
    		$action         = 'Approved';
    		$decision = $this->form_manage->setDecission(array('formid' => $forms_id, 'userid' => $this->session->userdata['user']->user_id, 'decission' => '1', 'comment' => 'Time Record Updating'));
        	$notif_message  = 'Filed ' . $form_name['form'] . ' on ' . date('F d, Y') . ' has been '.$action.'.';

    	}
        
        if(trim($this->input->post('comment')) != ""){
            $notif_message  .= '<br><br>Remarks: '.$this->input->post('comment');
        }

        $data['user_id']        = $this->session->userdata['user']->user_id;                                // THE CURRENT LOGGED IN USER 
        $data['display_name']   = $this->current_user['lastname']. ", ". $this->current_user['firstname'];  // THE CURRENT LOGGED IN USER'S DISPLAY NAME
        $data['feed_content']   = $notif_message;                                                           // THE MAIN FEED BODY
        $data['recipient_id']   = $recipient;                                                               // TO WHOM THIS POST IS INTENDED TO
        $data['status']         = 'info';                                                                   // DANGER, INFO, SUCCESS & WARNING
        $data['message_type']   = 'Time Record';
        $data['forms_id'] 		= $forms_id;
        
        //SAVING START   
		$transactions = true;
		$error = false;
		if( $transactions )
		{
			$this->db->trans_begin();
		}

        // ADD NEW DATA FEED ENTRY
        $qry = "INSERT INTO ww_system_feeds 
				(
					status
					, message_type
					, user_id
					, display_name
					, feed_content
					, recipient_id
					, uri
				) 
				VALUES
				(
					'" . $data['status'] . "',
					'" . $data['message_type'] . "',
					'" . $data['user_id'] . "',
					'" . $data['display_name'] . "',
					'" . $data['feed_content'] . "',
					'" . $data['recipient_id'] . "',
					'" . $this->mod->route.'/updating'. "'					
				)";
		
		$this->db->query($qry);   

		if( $this->db->_error_message() != "" )
		{
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
		if( $error ){
			$this->response->message[] = array(
					'message' => lang('common.inconsistent_data'),
					'type' => 'error'
				);
			$this->_ajax_return();
		}
        // determines to where the action was 
        // performed and used by after_save to
        // know which notification to broadcast
        $this->response->type       = 'todo';
        $this->response->action     = $action;
        $this->response->message[]  = array(
            'message'   => lang('common.save_successful'),
            'type'      => 'success'
        );
    }

    public function reassign_approver(){

        $this->_ajax_only();
		$data = array();
        $this->load->helper('form');
        $this->lang->load('form_application_manage');
        
        $data['form_title'] = "Select New Approver";
        $view['title'] = 'Re-assign Form Approver';
       
        $this->load->model('my_calendar_model', 'my_calendar');
	    $data['approver_list'] = $this->my_calendar->get_time_forms_approvers($this->input->post('forms_id'));
	    $data['approver_title'] = "Approver/s";

	    $this->load->model('form_application_manage_model', 'form_manage');
        $data['form_application_manage_route'] = $this->form_manage->route;

        $data['approver_id']= $this->input->post('approver_id');
        $data['forms_id']= $this->input->post('forms_id');
        $data['time_forms_form_status_id'] = $this->input->post('forms_status');
        
        $view['content'] = $this->load->view('edit/edit_reassign_approver', $data, true);
		
        $this->response->edit_reassign_approver = $view['content'];

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();

    }

    public function get_ot_info()
    {
    	$this->_ajax_only();
    	
    	$user_id = $this->input->post('user_id');
    	$date = date('Y-m-d', strtotime($this->input->post('date')));
    	$this->response->ot_details = '';
    	$ot_details['ot_details'] = $this->mod->get_ot_info($user_id, $date);
        $this->response->ot_details .= $this->load->blade('edit/dialog/ot_detail', $ot_details, true);
           
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );
        $this->_ajax_return();
    }

}
