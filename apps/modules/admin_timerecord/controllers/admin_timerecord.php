<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_timerecord extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('admin_timerecord_model', 'mod');
		parent::__construct();
		$this->lang->load( 'timerecord' );
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
        $data['user_id'] = $this->user->user_id;
        $this->load->model('timerecord_model', 'timerecord');
        $ppfs = $this->timerecord->get_period_list();
     	$data['ppf'] = "<option></option>";
		foreach( $ppfs as $ppf ){
			$selected = (isset($forms_info['date_from']) && $forms_info['date_from'] == $ppf['from']) ? "selected='selected'" : '';
			$data['ppf'] .= '<option value-from="'.$ppf['from'].'" value-to="'.$ppf['to'].'" value="'.$ppf['record_id'].'" '.$selected.'>'.$ppf['payroll_date'].'</option>';
		}

		for ($m=1; $m<=12; $m++) {

			$month_key = date('Y-m-d', mktime(0,0,0,$m, 1, date('Y')));
    		$month_value = date('F', mktime(0,0,0,$m, 1, date('Y')));
     		$data['month_list'][$month_key] = $month_value;
     	}

        // $user_setting = APPPATH . 'config/users/'. $this->user->user_id .'.php';
        // $user_id = $this->user->user_id;
        // $this->load->config( "users/{$user_id}.php", false, true );
        // $user = $this->config->item('user');

        // $this->load->config( 'roles/'. $user['role_id'] .'/permission.php', false, true );
        // $permission = $this->config->item('permission');
        // $this->load->model('override_timerecord_model', 'ovverride_mod');

        // $data['override_timerecord'] = isset($permission[$this->ovverride_mod->mod_code]['list']) ? $permission[$this->ovverride_mod->mod_code]['list'] : 0;
        // $data['admin_timerecord'] = isset($this->permission['list']) ? $this->permission['list'] : 0;

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


			$sf = '<span id="yr-fltr-prev" data-year-value="' . $prev_year . '" class="event-block label label-info year-filter">' . $prev_year . '</span> ';

			for($m=1; $m<=12; $m++) {

				$month_key = date('Y-m-d', mktime(0,0,0,$m, 1, date('Y', strtotime($value))));
    			$month_value = date('F', mktime(0,0,0,$m, 1, date('Y', strtotime($value))));

    			$label_class = date("F", strtotime($value)) === $month_value ? 'label-success' : 'label-default';

				$sf .= '<span id="ml-'.$month_key.'" data-month-value="'.$month_key.'" class="event-block label ' . $label_class .' month-list">'.$month_value.'</span> ';
	     	}

	     	$sf .= '<span id="yr-fltr-next" data-year-value="' . $next_year . '" class="event-block label label-info year-filter">
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
						class="event-block label label-info year-filter">' . $prev_year . '</span> ';

			for($m = 1; $m <= 12; $m++) {

				$month_key = date('Y-m-d', mktime(0,0,0,$m, 1, $value));
    			$month_value = date('F', mktime(0,0,0,$m, 1, $value));

    			$label_class = date("F", strtotime($date)) === $month_value ? 'label-success' : 'label-default';

				$sf .= '<span id="ml-'.$month_key.'" data-month-value="'.$month_key.'" class="event-block label ' . $label_class .' month-list">'.$month_value.'</span> ';
	     	}

	     	$sf .= '<span 
	     				id="yr-fltr-next" 
	     				data-year-value="' . $next_year . '" 
	     				data-year-selected="' . $currently_selected_year . '" 
	     				class="event-block label label-info year-filter">
	                	' . $next_year . '
	                </span> ';

			$data['sf'] = $sf;

			$this->response->current_title = date("F-Y", strtotime($date));
		}


		// Pay period filter
		// limited to 5 paydates
		$ppfs = $this->mod->get_period_list( $this->input->post('user_id') );


		if( in_array($type, array('by_date')) ){			
			$dateSelected 	= $this->input->post('value');
			$dept_id 	= $this->input->post('dept_id');
			$records = $this->mod->_get_list_by_date($this->input->post('user_id'), $range, $dateSelected, $dept_id);
		} else if( in_array($type, array('by_period')) ) {
			$pay_dates_id = $this->input->post('value');
			$period_user_id = $this->input->post('user_id');

            $this->db->select('time_period.date_from, time_period.date_to');
            $this->db->where('time_period.period_id', $pay_dates_id);
            $this->db->where('users_profile.user_id', $period_user_id);
            $this->db->join('users_profile', 'users_profile.company_id = time_period.company_id');
            $this->db->from('time_period');
            $pay_dates = $this->db->get();
            $periods = array('date_from' => '', 'date_to' => '');
            if($pay_dates->num_rows() > 0){            
                $periods = $pay_dates->row_array();
            }
			$records = $this->mod->_get_list_by_period($period_user_id, $periods['date_from'], $periods['date_to']);
		}
		else{
			$records = $this->mod->_get_list($this->input->post('user_id'), $range, $date);
		}
		$this->response->records_retrieve = sizeof($records);
		$this->response->list = '';

		$this->response->pn = $data['pn'];
		$this->response->sf = $data['sf'];
		$this->response->ppf = '';
		//echo "<pre>";print_r($ppfs);exit;
		foreach( $ppfs as $ppf ){
			$this->response->ppf .= '<span 
										id="ppf-'.$ppf['record_id'].'" 
										data-ppf-value-from="'.$ppf['from'].'" 
										data-ppf-value-to="'.$ppf['to'].'"  
										class="event-block label label-default period-filter">'
										.$ppf['payroll_date'].
									'</span> ';
		}

		foreach( $records as $record ){
			$record['forms'] = array();
			$record['forms'] = $this->mod->time_record_list_forms($record['date'], $record['user_id']);

			if( in_array($type, array('by_date')) ){
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
	            $this->load->helper('form');
	            $this->load->helper('file');
				$this->response->list .= $this->load->blade('list_template_by_date', $record, true);
			} else if( in_array($type, array('by_period')) ) {
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
	            $this->load->helper('form');
	            $this->load->helper('file');
				$this->response->list .= $this->load->blade('list_template_by_period', $record, true);
			} else{
				$this->response->list .= $this->load->blade('list_template_custom', $record, true);
			}
		}

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
		$user_id = $this->input->post('user_id');

		$ppfs = $this->mod->get_period_list($user_id);
		$records = $this->mod->_get_list_by_period($user_id, $from, $to);

		$this->response->list = '';

		foreach( $records as $record ){
			$record['forms'] = array();
			$record['forms'] = $this->mod->time_record_list_forms($record['date'], $record['user_id']);
			$this->response->list .= $this->load->blade('list_template_custom', $record, true);
		}

		$this->_ajax_return();
	}

	function update_department()
	{
		$this->_ajax_only();
		$departments = $this->db->query('SELECT * FROM approver_class_department WHERE company_id='.$this->input->post('company_id'));
		$this->response->departments = '<option value="" selected="selected">Select...</option>';
		foreach( $departments->result() as $department )
		{
			$this->response->departments .= '<option value="'.$department->department_id.'">'.$department->department.'</option>';
		}
		$this->_ajax_return();	
	}

	function update_employees()
	{
		$this->_ajax_only();

        $qry_category = $this->mod->get_role_category();

		$this->db->order_by('alias');
		$this->db->where('partners.deleted', 0);

        if ($qry_category != ''){
            $this->db->where($qry_category, '', false);
        }
        else{
			if($this->input->post('department_id') != "")
				$this->db->where('users_profile.department_id', $this->input->post('department_id'));

			if($this->input->post('company_id') != "")
					$this->db->where('users_profile.company_id', $this->input->post('company_id'));			
        }

		if($this->input->post('status_id') != "")
			$this->db->where('partners.status_id', $this->input->post('status_id'));

		$this->db->join('partners', 'partners.user_id = users_profile.user_id', 'left');
		$employees = $this->db->get('users_profile');

		$this->response->last_db = $this->db->last_query();
		// $employees = $this->db->get_where('users', array('deleted' => 0, 'company_id' => $this->input->post('company_id'), 'department_id' => $this->input->post('department_id')));
		$this->response->employees = '<option value="">Select...</option>';
		foreach( $employees->result() as $employee )
		{
			$this->response->employees .= '<option value="'.$employee->user_id.'">'.$employee->alias.'</option>';
		}
		$this->_ajax_return();	
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
        	if (trim($comment['comment']) != ''){
            	$remarks['remarks'][] = $comment;
        	}
        }
        $form_details = array_merge($form_details, $remarks);

        switch ($form_details['form_status_id']) {
            case 6:
                $label = 'Date Approved';
                $date_adc = $form_details['date_approved'];
                break;
            case 7:
                $label = 'Date Disapproved';
                $date_adc = $form_details['date_declined'];
                break;
            case 8:
                $label = 'Date Cancelled';
                $date_adc = $form_details['date_cancelled'];
                break;                            
            default:
                $label = '';
                $date_adc = '';
                break;
        }

        $form_details['label_adc'] = $label;
        $form_details['date_adc'] = $date_adc;

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

	function save_timerecord(){
		$error = false;
		$post = $_POST;
		$this->response->record_id = $this->record_id = $post['record_id'];
		unset( $post['record_id'] );

		// echo "<pre>\n";
		// print_r($post);
        /***** END Form Validation (hard coded) *****/
        //SAVING START   
		$transactions = true;
		$this->partner_id = 0;
		if( $transactions )
		{
			$this->db->trans_begin();
		}

		$aux_shift_id = $post['time_shift_id'];
		$time_in = str_replace(" - "," ",$post['timein']);
		$time_out = str_replace(" - "," ",$post['timeout']);

		if($aux_shift_id > 0){
			$main_record['aux_shift_id'] = $post['time_shift_id'];
		}
		$main_record['time_in'] = (!strtotime($time_in)) ? null : date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$post['timein'])));
		$main_record['time_out'] = (!strtotime($time_out)) ? null : date('Y-m-d H:i:s', strtotime(str_replace(" - "," ",$post['timeout'])));
		$main_record['modified_on'] = date('Y-m-d H:i:s');
		$main_record['modified_by'] = $this->user->user_id;
		$main_record['override'] = 1;

		//start saving with main table		
		$this->db->update( 'time_record', $main_record, array( 'record_id' => $this->record_id ) );
		$this->response->action = 'update';

			if( $this->db->_error_message() != "" ){
				$this->response->message[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
				$error = true;
				goto stop;
			}
		// }

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
				'message' => 'Employee DTR successfully updated.',
				'type' => 'success'
			);
		}

		$this->response->saved = !$error;

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

    function get_user_to_options()
	{
		$this->_ajax_only();

		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$this->response->options = $this->mod->_get_user_to_options( '', false, $this->input->post('user_id') );

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

}