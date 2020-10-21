<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Holiday extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('holiday_model', 'mod');
		parent::__construct();
	}


	public function get_list(){

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

		$page = $this->input->post('page');
		$search = $this->input->post('search');
		$filter = "";
		$filter_by = $this->input->post('filter_by');
		$filter_value = $this->input->post('filter_value');
		
		if( $filter_by && !empty($filter_by) )
		{
			$filter = 'AND '. $filter_by .' = "'.$filter_value.'"';
		}

		$trash = $this->input->post('trash') == 'true' ? true : false;

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
			$this->response->list .= $this->load->blade('list_template', $record, true);
		}

		$this->_ajax_return();
	}


	public function save(){

		$this->_ajax_only();
		
		if( !$this->_set_record_id() ){

			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'error'
			);
			$this->_ajax_return();	
		}
		
		if( (empty( $this->record_id ) && !$this->permission['add']) || ($this->record_id && !$this->permission['edit']) ){

			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$record_id 		= isset($_POST['record_id']) ? $_POST['record_id'] : '';
		$holiday 		= $_POST['time_holiday']['holiday'];
		$holiday_date 	= $_POST['time_holiday']['holiday_date'];
		$legal 			= $_POST['time_holiday']['legal'];
		$location_count = isset($_POST['time_holiday_location']) ? count($_POST['time_holiday_location']['location_id']) : 0;

		$holiday_info['holiday']		= $holiday;
		$holiday_info['holiday_date']	= date('Y-m-d', strtotime($holiday_date));
		$holiday_info['legal']			= $legal;
		$holiday_info['locations']		= isset($_POST['time_holiday_location']) ? implode(",",$_POST['time_holiday_location']['location_id']) : '';
		$holiday_info['location_count']		= $location_count;
		
		$this->response->record_id = $this->record_id = $this->mod->_save($record_id, $holiday_info);
		if( !is_integer($this->response->record_id ) )
		{
			$this->response->message[] = array(
				'message' => $this->response->record_id,
				'type' => 'warning'
			);
			$this->response->record_id = $this->record_id = false;
			$this->_ajax_return();	
		}


		if( empty($record_id) ){
			$this->response->record_id = $this->record_id = $this->db->insert_id();
			$this->response->action = 'insert';
		}
		$this->response->saved = true;
		
		// save affected partners 
		$this->mod->remove_holiday_locations($this->record_id);
		$this->mod->add_to_holiday_location($this->record_id);


		$this->response->message[] = array(
			'message' => 'Record/s successfully saved/updated.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

    function populate_holiday_form()
    {
        $this->_ajax_only();
        
		$this->load->helper('form');
		$this->load->helper('file');

        $data['title'] = 'Enter Year to Populate';
        $data['content'] = $this->load->blade('edit.holiday_year')->with( $this->load->get_cached_vars() );

        $this->response->year_holiday = $this->load->view('templates/modal', $data, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }	

	function save_populated_holiday()
	{
        $validation_rules[] = 
        array(
            'field' => 'year',
            'label' => 'Year',
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

		$this->db->select_max('holiday_date');
		$this->db->where('deleted', 0);
		$this->db->where('legal', 1);
		$result = $this->db->get('time_holiday');

		if ($result && $result->num_rows() > 0){
			$annual_holiday = $result->row();
			$year_query = date('Y', strtotime($annual_holiday->holiday_date));

			if ($year_query == $this->input->post('year')){
				$this->response->message[] = array(
					'message' => 'Year inputed already exists',
					'type' => 'error'
				);
				
				$this->_ajax_return(); 
			}

			if(date('Y', strtotime($annual_holiday->holiday_date)) > $this->input->post('year')){
				$year = date('Y', strtotime($annual_holiday->holiday_date)) - $this->input->post('year');
				$to_do = 0;
			} else {
				$year = $this->input->post('year') - date('Y', strtotime($annual_holiday->holiday_date));
				$to_do = 1;
			}

			$query = "INSERT INTO ".$this->db->dbprefix."time_holiday (holiday, holiday_date, legal)
					  SELECT holiday, ".($to_do == 1 ? 'DATE_ADD' : 'DATE_SUB')."(holiday_date, INTERVAL ".$year." YEAR), legal
					  FROM ".$this->db->dbprefix."time_holiday
					  WHERE deleted = 0
					  AND legal = 1
					  AND holiday_date LIKE '%".$year_query."%'";

			$this->db->query($query);	
		}

		$this->response->message[] = array(
			'message' => lang('common.save_success'),
			'type' => 'success'
		);

        $this->response->saved = true;

        $this->_ajax_return();        
	}    
}	