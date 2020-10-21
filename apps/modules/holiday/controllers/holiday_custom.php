<?php //delete me

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
		$holiday_info['holiday_date']	= $holiday_date;
		$holiday_info['legal']			= $legal;
		$holiday_info['locations']		= isset($_POST['time_holiday_location']) ? implode(",",$_POST['time_holiday_location']['location_id']) : '';
		$holiday_info['loc_count']		= $location_count;
		$holiday_info['user_id']		= $this->user->user_id;

		$holiday_saved = $this->mod->_save($record_id, $holiday_info);

		
		if(isset($_POST['time_holiday_location']) && is_array($this->input->post('time_holiday_location'))){
			
			if($record_id !== ''){
				// update command, delete all holiday locations under current holiday
				$this->mod->remove_holiday_locations($record_id);
			}

			$posted_holiday = $this->mod->get_posted_holiday($holiday_date);
			$location_ids = $this->input->post('time_holiday_location');

			for($i=0; $i<count($location_ids['location_id']); $i++){

				$location = $this->mod->get_location_data($location_ids['location_id'][$i]);

				$users = $this->mod->get_users_from_location($location_ids['location_id'][$i]);
				$users_count = count($users);

				// update users count for the current location
				// since upon saving holiday we do not know yet
				// if there's a location specified 
				$user_count_update = $this->mod->update_holiday_user_count($posted_holiday[0]['holiday_id'], $users_count);
				
				if($users_count > 0){

					for($j=0; $j<$users_count; $j++){

						// no prepare the data
						$users_to_location = array();
						$users_to_location['holiday_id'] = $posted_holiday[0]['holiday_id'];  
						$users_to_location['location_id'] = $location[0]['location_id'];
						$users_to_location['location'] = $location[0]['location'];
						$users_to_location['user_id'] = $users[$j]['user_id'];
						$users_to_location['user'] = $users[$j]['name'];
						$users_to_location['user_'] = $users[$j]['name'];

						$this->mod->add_to_holiday_location($users_to_location);
					}	
				}
			} 
		}

		if($holiday_saved){

			$this->response->message[] = array(
				'message' => 'Record/s successfully saved/updated.',
				'type' => 'success'
			);
			$this->_ajax_return();
		}
		else{

			$this->response->message[] = array(
				'message' => 'A problem has occurred! Record not saved.',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
	}