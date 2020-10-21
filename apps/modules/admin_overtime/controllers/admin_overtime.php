<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_overtime extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('admin_overtime_model', 'mod');
		parent::__construct();
        $this->lang->load( 'form_application' );
	}


	public function index()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}
		
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

		$this->load->model('timerecord_model', 'timeRecord');
		$data['periodList'] = $this->timeRecord->get_period_list();

        $this->load->vars( $data );
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
				if( $filter_value != "" ) $filter = 'AND '. $filter_by_key .' = "'.$filter_value.'"';	
			}
		}
		else{
			if( $filter_by && $filter_by != "" )
			{
				if($filter_by == 'month'){					
					$data['date_from'] = date("Y-m-d", strtotime($filter_value . ' - 1 days'));
					$data['selected_date'] = date("Y-m-d", strtotime($filter_value)); // remove this line
					$data['date_to'] 	= date("Y-m-d", strtotime($filter_value . ' + 1 months'));

					$filter = 'AND (date > "'.$data['date_from'].'" AND date < "'.$data['date_to'].'")';
				}elseif($filter_by == 'period'){
					$period_details = $this->mod->get_period_details($filter_value);
					
					$filter = 'AND (date >= "'.$period_details['from'].'" AND date <= "'.$period_details['to'].'")';
				}
			}
		}

		//company, dept, employee filter
		$company_id = $this->input->get('company');
		if($company_id > 0){					
			$filter .= ' AND company_id = '.$company_id;
		}
		$department_id = $this->input->get('department');
		if($department_id > 0){					
			$filter .= ' AND department_id = '.$department_id;
		}
		$user_id = $this->input->get('user');
		if($user_id > 0){					
			$filter .= ' AND user_id = '.$user_id;
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

			// if(!$trash)
			// 	$this->_list_options_active( $record, $rec );
			// else
			// 	$this->_list_options_trash( $record, $rec );

			$record = array_merge($record, $rec);
			$this->response->list .= $this->load->blade('list_template', $record, true)->with( $this->load->get_cached_vars() );
		}
	}

	public function move_year_filter()
	{
		$this->_ajax_only();
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}
		
		$data = array();

		$data['selected_year'] = $this->input->post('selected_year');
        $data['prev_year'] 	= $data['selected_year'] - 1;
        $data['next_year'] 	= $data['selected_year'] + 1;

        $selected_filterMonth = trim($this->input->post('selected_filterMonth'));
        $selected_filterDate = trim($this->input->post('selected_filterDate'));

		$sf = '<span id="yr-fltr-prev" data-year-value="' . $data['prev_year'] . '" class="event-block label label-info year-filter">' . $data['prev_year'] . '</span>';

		for ($m=1; $m<=12; $m++) {
			$month_key = date('Y-m-d', mktime(0,0,0,$m, 1, $data['selected_year']));
    		$month_value = date('F', mktime(0,0,0,$m, 1, $data['selected_year']));

     		$label_class = $month_value == $selected_filterMonth ? 'label-success' : 'label-default';
     		$sf .= '<span id="ml-'.$month_key.'" data-month-value="'.$month_key.'" class="event-block label ' . $label_class .' external-event month-list">'.$month_value.'</span>';
     	}

     	$selected_filterDate = $data['selected_year'].date('-m-01', strtotime($selected_filterMonth));
		$sf .= '<input type="hidden" value="'.$selected_filterMonth.'" data-date="'.$selected_filterDate.'" id="selected_filterMonth" name="selected_filterMonth" >';
     	$sf .= '<span id="yr-fltr-next" data-year-value="' . $data['next_year'] . '" class="event-block label label-info external-event year-filter">
                	' . $data['next_year'] . '
                </span>';

		$this->response->sf = $sf;
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
		$this->db->order_by('alias');
		$this->db->where('partners.deleted', 0);
		$this->db->where('company_id', $this->input->post('company_id'));
		$this->db->where('department_id', $this->input->post('department_id'));
		// $this->db->where('partners.status_id', $this->input->post('status_id'));
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
}