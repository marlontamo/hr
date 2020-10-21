<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mobile_Timerecord extends MY_PrivateController
{
	public function __construct(){
		$this->load->model('mobile_timerecord_model', 'mod');
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

	public function get_timerecord_mobile() {

		$user_id = $this->input->post('user_id');
		$mobileapp = $this->input->post('mobileapp');
		$date =  $this->input->post('date_today');
		

		$records = $this->mod->get_list_mobile($user_id, $date);
		// debug($records); die();
		if($mobileapp) {
			$this->response->list = $records;
			
		}
		$this->_ajax_return();
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

		// if( $this->input->post('mobileapp') ){

		// 	$page 	= $this->input->post('page') - 1;
		// 	$value = date('Y-m-d', strtotime("-{$page} month"));
		// 	$this->response->value = $value;

		// }

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

		}else if($type === 'year'){

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

			}else{

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
		$user_id = $this->input->post('user_id');

		foreach( $ppfs as $ppf ){

			$this->response->ppf .= '<span 
										id="ppf-'.$ppf['record_id'].'" 
										data-ppf-value-from="'.$ppf['from'].'" 
										data-ppf-value-to="'.$ppf['to'].'"  
										class="event-block label label-default external-event period-filter">'
										.$ppf['payroll_date'].
									'</span>';
		
		}foreach( $records as $record ){
			$record['forms'] = array();
			if( $this->input->post('mobileapp') ){
				$record['forms'] = $this->mod->time_record_list_forms($record['date'], $user_id);
			} else {
				$record['forms'] = $this->mod->time_record_list_forms($record['date'], $record['user_id']);
			}
			
			//$record['remind_icon'] = $this->mod->is_dtr_editable($record['date'], $record['user_id']);
			if( $this->input->post('mobileapp') ){
				$this->response->list =  $record;
			} else {
				$this->response->list .= $this->load->blade('list_template_custom', $record, true);
			}
			
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

		$this->load->model('form_application_manage_model', 'form_manage');
        $this->response->form_details = '';

        $form_details = $this->mod->time_record_list_forms_details($forms_id, $this->user->user_id);
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

}