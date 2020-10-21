<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Timerecord_manage extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('timerecord_manage_model', 'mod');
		parent::__construct();
		$this->lang->load('timerecord');
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
        $data['currentDate'] 	= date("F d, Y");
        $data['prev_month'] 	= date("Y-m-d", strtotime($data['current_date'] . ' - 1 months'));
        $data['next_month'] 	= date("Y-m-d", strtotime($data['current_date'] . ' + 1 months'));

		for ($m=1; $m<=12; $m++) {

			$month_key = date('Y-m-d', mktime(0,0,0,$m, 1, date('Y')));
    		$month_value = date('F', mktime(0,0,0,$m, 1, date('Y')));
     		$data['month_list'][$month_key] = $month_value;
     	}

 		$data['partners'] = $this->mod->getManagerPartners();

        $user_setting = APPPATH . 'config/users/'. $this->user->user_id .'.php';
        $user_id = $this->user->user_id;
        $this->load->config( "users/{$user_id}.php", false, true );
        $user = $this->config->item('user');

        $this->load->config( 'roles/'. $user['role_id'] .'/permission.php', false, true );
        $permission = $this->config->item('permission');
        $this->load->model('timerecord_model', 'tr_personal');

        $data['permission_tr_personal'] = isset($permission[$this->tr_personal->mod_code]['list']) ? $permission[$this->tr_personal->mod_code]['list'] : 0;
        $data['permission_tr_manage'] = isset($this->permission['list']) ? $this->permission['list'] : 0;

        $this->load->vars( $data );

        echo $this->load->blade('record_listing_manager_custom')->with( $this->load->get_cached_vars() );
	}

	public function get_list(){

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
		$partner_id	= $this->input->post('id');

		// get currently selected year
		$csy_value 	= $this->input->post('selected_year');
		$currently_selected_year = $csy_value == '' ? $csy_value : date("Y");
	

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
						class="event-block label label-info external-event year-filter">' . $prev_year . '</span>';

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
		$ppfs = $this->mod->get_period_list_manager($partner_id);

		if( in_array($type, array('by_date')) ){			
			$dateSelected 	= $this->input->post('value');
			$records = $this->mod->_get_list_manager_by_date($range, $dateSelected, $partner_id);
		}else{
			$records = $this->mod->_get_list_manager($range, $date, $partner_id);
		}
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

		foreach( $records as $record ){
			$record['forms'] = array();
			$record['forms'] = $this->mod->time_record_list_forms($record['date'], $record['user_id']);


			if( in_array($type, array('by_date')) ){
				$this->response->list .= $this->load->blade('list_template_by_date', $record, true);
			}else{
				$this->response->list .= $this->load->blade('list_template_custom', $record, true);
			}
		}

		$this->_ajax_return();
	}

	public function get_period_list(){

		if( !$this->permission['list'] ){
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$from 	= $this->input->post('from');
		$to 	= $this->input->post('to');
		$partner_id	= $this->input->post('id');

		$ppfs = $this->mod->get_period_list_manager($partner_id);
		$records = $this->mod->_get_list_by_period_manager($from, $to, $partner_id);

		$this->response->list = '';

		foreach( $records as $record ){
			$record['forms'] = array();
			$record['forms'] = $this->mod->time_record_list_forms($record['date'], $record['user_id']);

			$this->response->list .= $this->load->blade('list_template_custom', $record, true);
		}

		$this->_ajax_return();
	}


	/*!
	* Incomplete Attendance Report
	* @see Routes
	* Raw URI - time/manage/timerecords/report_inc_att
	* URI: time/manage/timerecords/report/reportname??? 
	* 	   OR
	*	   time/report/reportname
	*	   OR 
	*	   report/time/xxx/yyy/zzz
	*/
	public function report_inc_att($params){ 

		if( !$this->permission['list'] ){
			echo "You have insufficient permission, please notify the System Administrator.";
			die();
		}

		$this->load->model('report_model', 'report');


		if(isset($params['action']) && $params['action'] == 'export'){

			$report_data = $this->report->_get_incomplete_attendance_list($params);
			// echo "<pre>";
			// print_r($list);
			// echo "</pre>";
			// die('export!!!!! :P');

			return $report_data;
			die();
		}

		$report = new stdClass();
		$report->header = "";
		$report->body = "";

		$this->report->short_name = "Report Analytics";
		$this->report->long_name = "Report Analytics";
		$this->report->description = "";

		$data = array();
		$list = $this->report->_get_incomplete_attendance_list($params);
		$count = count($list) - 1;

		$this->load->vars( $data );

		$report->header .= $this->load->blade('report.time.incomplete_attendance_header');
		$report->count = $count;

		foreach( $list as $data ){ 

			if(is_array($data))
				$report->body .= $this->load->blade('report.time.incomplete_attendance_body', $data, true);
			
			else
				$report->total_records = $data;
		}

		return $report;
	}


	public function report_dtr_summary($params){ 

		if( !$this->permission['list'] ){
			echo "You have insufficient permission, please notify the System Administrator.";
			die();
		}

		$report = new stdClass();
		$report->header = "";
		$report->body = "";

		$this->load->model('report_model', 'report');

		if(isset($params['action']) && $params['action'] == 'export'){ 

			$report_data = $this->report->_get_dtr_summary_report($params);
			// echo "<pre>";
			// print_r($list);
			// echo "</pre>";
			// die('export!!!!! :P');

			return $report_data;
			die();
		}


		$this->report->short_name = "Report Analytics";
		$this->report->long_name = "Report Analytics";
		$this->report->description = "";

		$data = array();
		$list = $this->report->_get_dtr_summary_report($params);
		$count = count($list) - 1;

		$this->load->vars( $data );

		$report->header .= $this->load->blade('report.time.dtr_summary_report_header');
		$report->count = $count;

		foreach( $list as $data ){ 

			if(is_array($data))
				$report->body .= $this->load->blade('report.time.dtr_summary_report_body', $data, true);
			
			else
				$report->total_records = $data;
		}

		return $report;
	}

	public function report_tardiness_report_for_memo($params){ 

		if( !$this->permission['list'] ){
			echo "You have insufficient permission, please notify the System Administrator.";
			die();
		}

		$report = new stdClass();
		$report->header = "";
		$report->body = "";

		$this->load->model('report_model', 'report');

		if(isset($params['action']) && $params['action'] == 'export'){

			$report_data = $this->report->_get_tardiness_report_for_memo($params);
			// echo "<pre>";
			// print_r($list);
			// echo "</pre>";
			// die('export!!!!! :P');

			return $report_data;
			die();
		}

		$this->report->short_name = "Report Analytics";
		$this->report->long_name = "Report Analytics";
		$this->report->description = "";

		$data = array();
		$list = $this->report->_get_tardiness_report_for_memo($params);
		$count = count($list) - 1;

		$this->load->vars( $data );

		$report->header .= $this->load->blade('report.time.tardiness_report_per_month_for_memo_header');
		$report->count = $count;

		foreach( $list as $data ){ 

			if(is_array($data))
				$report->body .= $this->load->blade('report.time.tardiness_report_per_month_for_memo_body', $data, true);
			
			else
				$report->total_records = $data;
		}

		return $report;
	}



    function get_form_details(){

        $this->_ajax_only();
        $form_id = $this->input->post('form_id');
        $forms_id = $this->input->post('forms_id');
        $date = $this->input->post('date');

		$this->load->model('timerecord_model', 'time_model');
		$this->load->model('form_application_manage_model', 'form_manage');
        $this->response->form_details = '';

        $form_details = $this->time_model->time_record_list_forms_details($forms_id, $this->user->user_id,$date);
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
            case 21: //Childs Baptism
            case 22: //Relatives Bereavement Leave
            case 23: //Pilgrimage Leave
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

        $this->_ajax_return();
    }

	function update_subordinates()
	{
		$this->_ajax_only();

		$subFilter = $this->input->post('subFilter');
		if($subFilter == '2'){
 			$data['subordinates'] = $this->mod->getAllSubordinates();
		}else{
 			$data['subordinates'] = $this->mod->getManagerPartners();
		}

 		$this->response->subordinates = '<option value="">Select...</option>';
		foreach( $data['subordinates'] as $subordinate )
		{
			$this->response->subordinates .= '<option value="'.$subordinate['partner_id'].'">'.$subordinate['partner_name'].'</option>';
		}

		$this->_ajax_return();	
	}

}