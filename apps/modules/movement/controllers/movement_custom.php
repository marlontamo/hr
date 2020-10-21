
	public function add( $record_id = '', $child_call = false )
	{
		if( !$this->permission['add'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_edit( $child_call, true );
	}

	public function edit( $record_id = '', $child_call = false )
	{
		if( !$this->permission['add'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_edit( $child_call );
	}

	function _edit( $child_call, $new = false )
	{
		$record_check = false;
		$this->record_id = $data['record_id'] = '';

		if( !$new ){
			if( !$this->_set_record_id() )
			{
				echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
				die();
			}

			$this->record_id = $data['record_id'] = $_POST['record_id'];
		}
		
		$record_check = $this->mod->_exists( $this->record_id );
		if( $new || $record_check === true )
		{
			$result = $this->mod->_get( 'edit', $this->record_id );
			if( $new )
			{
				$field_lists = $result->list_fields();
				foreach( $field_lists as $field )
				{
					$data['record'][$field] = '';
				}
					$data['record']['movement_count'] = 0;
					$data['movement_details'] = array();
			}
			else{
				$record = $result->row_array();
				foreach( $record as $index => $value )
				{
					$record[$index] = trim( $value );	
				}
				$data['record'] = $record;
				$data['movement_details'] = $this->mod->get_movement_details($this->record_id);
				$data['record']['movement_count'] = count($data['movement_details']);
			}

			$this->load->vars( $data );

			if( !$child_call ){
				$this->load->helper('form');
				$this->load->helper('file');
				echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
			}
		}
		else
		{
			$this->load->vars( $data );
			if( !$child_call ){
				echo $this->load->blade('pages.error', array('error' => $record_check))->with( $this->load->get_cached_vars() );
			}
		}
	}

	function save_movement(){

		$error = false;
		$post = $_POST;
		$this->response->record_id = $this->record_id = $post['record_id'];
		unset( $post['record_id'] );

		if($post['save_from'] != 'modal'){
			if(!($post['movement_count']) > 0){
	            $this->response->message[] = array(
	                'message' => 'Please add movement type.',
	                'type' => 'warning'
	                );
	            $this->_ajax_return();
			}
		}

		$validation_rules = array();
			$validation_rules[] = 
			array(
				'field' => 'partners_movement[due_to_id]',
				'label' => 'Due To',
				'rules' => 'required'
				);

			if($post['save_from'] == 'modal'){
				$validation_rules[] = 
				array(
					'field' => 'partners_movement_action[effectivity_date]',
					'label' => 'Effective',
					'rules' => 'required'
					);
				$validation_rules[] = 
				array(
					'field' => 'partners_movement_action[user_id]',
					'label' => 'Partner',
					'rules' => 'required'
					);
				switch ($post['partners_movement_action']['type_id']){
					case 1://Regularization
					case 3://Promotion
					case 8://Transfer
					case 9://Employment Status
					case 12://Temporary Assignment
					$error_val = false;
					$count_values = array_count_values($post['partners_movement_action_transfer']['to_name']);
					if(!(count($count_values)>1)){
						$error_val = true;
					}
					if($error_val){
			            $this->response->message[] = array(
			                'message' => 'Please change at least one field.',
			                'type' => 'warning'
			                );
			            $this->_ajax_return();
					}
					break;
					case 2://Salary Increase
					case 4://Wage Order
						$validation_rules[] = 
						array(
							'field' => 'partners_movement_action_compensation[current_salary]',
							'label' => 'Current Salary',
							'rules' => 'required'
							);
						$validation_rules[] = 
						array(
							'field' => 'partners_movement_action_compensation[to_salary]',
							'label' => 'New Salary',
							'rules' => 'required'
							);
					break;
					case 6://Resignation
					case 7://Termination
					case 10://End Contract
					case 11://Retirement
						$validation_rules[] = 
						array(
							'field' => 'partners_movement_action_moving[end_date]',
							'label' => 'End Date',
							'rules' => 'required'
							);
						$validation_rules[] = 
						array(
							'field' => 'partners_movement_action_moving[reason_id]',
							'label' => 'Reason',
							'rules' => 'required'
							);
					break;
					case 13://extension
						$validation_rules[] = 
						array(
							'field' => 'partners_movement_action_extension[no_of_months]',
							'label' => 'Months',
							'rules' => 'required'
							);
						//end date
					break;
				}
			}

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

        /***** END Form Validation (hard coded) *****/
        //SAVING START   
		$transactions = true;
		$this->partner_id = 0;
		if( $transactions )
		{
			$this->db->trans_begin();
		}

		//start saving with main table
		if(array_key_exists($this->mod->table, $post)){
			$main_record = $post[$this->mod->table];	
			if($post['save_from'] == 2){ //status_id					
				$main_record['status_id'] = 2;
			}	
			$record = $this->db->get_where( $this->mod->table, array( $this->mod->primary_key => $this->record_id ) );
			switch( true )
			{				
				case $record->num_rows() == 0:
					$main_record['created_on'] = date('Y-m-d H:i:s');
					$main_record['created_by'] = $this->user->user_id;
					$this->db->insert($this->mod->table, $main_record);
					if( $this->db->_error_message() == "" )
					{
						$this->response->record_id = $this->record_id = $this->db->insert_id();
					}
					$this->response->action = 'insert';
					break;
				case $record->num_rows() == 1:
					$main_record['modified_on'] = date('Y-m-d H:i:s');
					$main_record['modified_by'] = $this->user->user_id;
					$this->db->update( $this->mod->table, $main_record, array( $this->mod->primary_key => $this->record_id ) );
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
			if($post['save_from'] == 'modal'){
				//partners_movement_action
				$movement_action = $post['partners_movement_action'];	
				$movement_action['movement_id'] =  $this->response->record_id;
				$movement_action['effectivity_date'] = date('Y-m-d', strtotime($movement_action['effectivity_date']));	
				$record = $this->db->get_where('partners_movement_action', array( 'action_id' => $movement_action['action_id'] ) );
				$this->response->action_id = $this->action_id = $movement_action['action_id'];
				switch( true )
				{				
					case $record->num_rows() == 0:
						$movement_action['created_on'] = date('Y-m-d H:i:s');
						$movement_action['created_by'] = $this->user->user_id;
						//status_id
						$this->db->insert('partners_movement_action', $movement_action);
						if( $this->db->_error_message() == "" )
						{
							$this->response->action_id = $this->action_id = $this->db->insert_id();
						}
						$this->response->action = 'insert';
						break;
					case $record->num_rows() == 1:
						$movement_action['modified_on'] = date('Y-m-d H:i:s');
						$movement_action['modified_by'] = $this->user->user_id;
						$this->db->update( 'partners_movement_action', $movement_action, array( 'action_id' => $movement_action['action_id'] ) );
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

				$movement_details = array();
				$not_transfer = true;
				switch ($movement_action['type_id']){
					case 1://Regularization
					case 3://Promotion
					case 8://Transfer
					case 9://Employment Status
					case 12://Temporary Assignment
						$movement_details = $post['partners_movement_action_transfer'];

						$transfer_record['action_id'] = $this->action_id;
						$transfer_record['movement_id'] = $this->response->record_id;
						//delete transfer details
						$this->db->where('action_id', $this->action_id);
						$this->db->delete('partners_movement_action_transfer'); 
						foreach ($movement_details['to_name'] as $to_index => $to_name){
							if($to_name != ''){
								$transfer_record['field_id'] = $movement_details['field_id'][$to_index];
								$transfer_record['field_name'] = $movement_details['field_name'][$to_index];
								$transfer_record['from_id'] = $movement_details['from_id'][$to_index];
								$transfer_record['from_name'] = $movement_details['from_name'][$to_index];
								$transfer_record['to_id'] = $movement_details['to_id'][$to_index];
								$transfer_record['to_name'] = $movement_details['to_name'][$to_index];
								$this->db->insert('partners_movement_action_transfer', $transfer_record);
							}
						}
					$not_transfer = false;	
						break;
					case 2://Salary Increase
					case 4://Wage Order
						$movement_details = $post['partners_movement_action_compensation'];
						$movement_details['action_id'] = $this->action_id;
						$movement_details['movement_id'] = $this->response->record_id;
						$movement_details_table = 'partners_movement_action_compensation';
						break;
					case 6://Resignation
					case 7://Termination
					case 10://End Contract
					case 11://Retirement
						$movement_details = $post['partners_movement_action_moving'];
						$movement_details['action_id'] = $this->action_id;
						$movement_details['movement_id'] = $this->response->record_id;
						$movement_details['end_date'] = date('Y-m-d', strtotime($movement_details['end_date']));
						$movement_details_table = 'partners_movement_action_moving';
						break;
					case 13://extension
						$movement_details = $post['partners_movement_action_extension'];
						$movement_details['action_id'] = $this->action_id;
						$movement_details['movement_id'] = $this->response->record_id;
						$movement_details['end_date'] = date('Y-m-d', strtotime($movement_details['end_date']));
						$movement_details_table = 'partners_movement_action_extension';
						break;
				}

				//partners_movement details	
				if($not_transfer == true){
					$record = $this->db->get_where($movement_details_table, array( 'id' => $movement_details['id'] ) );
					switch( true )
					{				
						case $record->num_rows() == 0:
							//status_id
							$this->db->insert($movement_details_table, $movement_details);
							if( $this->db->_error_message() == "" )
							{
								$this->response->id = $this->id = $this->db->insert_id();
							}
							$this->response->action = 'insert';
							break;
						case $record->num_rows() == 1:
							$this->db->update( $movement_details_table, $movement_details, array( 'id' => $movement_details['id'] ) );
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
				}
			}

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
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
		}

		$this->response->saved = !$error;

        $this->_ajax_return();
    }

	function get_employee_details(){
		$this->_ajax_only();

		$user_id = $this->input->post('user_id');
		$this->response->partner_info = $this->mod->get_employee_details($user_id);
		$this->response->retrieved_partners = true;

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

        $this->_ajax_return();
	}

	function get_action_movement_details(){
		$this->_ajax_only();

		$this->response->action_id = $action_id = $this->input->post("action_id");
		$this->response->type_id = $type_id = $this->input->post("type_id");

		$action_details = $this->mod->get_action_movement($action_id);
		$data['count'] = 0;
		
		$data['movement_file'] = '';
		if($action_id > 0){
			$data['type'] = $action_details['type'];
			$data['type_id'] = $action_details['type_id'];
			$data['record']['partners_movement_action.action_id'] = $action_details['action_id'];//user
			$data['record']['partners_movement_action.type_id'] = $action_details['type_id'];//user
			$data['record']['partners_movement_action.user_id'] = $action_details['user_id'];//user
			$data['record']['partners_movement_action.effectivity_date'] = date("F d, Y", strtotime($action_details['effectivity_date']));//effectivity_date
			$data['record']['partners_movement_action.remarks'] = $action_details['remarks'];//action_remarks
			switch($type_id){
				case 1://Regularization
				case 3://Promotion
				case 8://Transfer
				case 9://Employment Status
				case 12://Temporary Assignment
				$data['transfer_fields'] = $this->mod->getTransferFields();
				$data['partner_info'] = $this->mod->get_employee_details($action_details['user_id']);
				foreach($data['transfer_fields'] as $index => $field){
					$movement_type_details = $this->mod->get_transfer_movement($action_id, $field['field_id']);
					if(count($movement_type_details) > 0){
						$data['transfer_fields'][$index]['from_id'] = $movement_type_details[0]['from_id'];
						$data['transfer_fields'][$index]['to_id'] = $movement_type_details[0]['to_id'];
						$data['transfer_fields'][$index]['from_name'] = $movement_type_details[0]['from_name'];
						$data['transfer_fields'][$index]['to_name'] = $movement_type_details[0]['to_name'];
					}else{
						$data['transfer_fields'][$index]['from_id'] = $data['partner_info'][0][$field['field_name'].'_id'];
						$data['transfer_fields'][$index]['from_name'] = $data['partner_info'][0][$field['field_name']];
						$data['transfer_fields'][$index]['to_id'] = '';
						$data['transfer_fields'][$index]['to_name'] = '';
					}
				}
					$data['movement_file'] = 'transfer.blade.php';
				break;
				case 2://Salary Increase
				case 4://Wage Order
				$movement_type_details = $this->mod->get_compensation_movement($action_id);
					$data['record']['partners_movement_action_compensation.id'] = $movement_type_details['id'];//id
					$data['record']['partners_movement_action_compensation.current_salary'] = $movement_type_details['current_salary'];//current_salary
					$data['record']['partners_movement_action_compensation.to_salary'] = $movement_type_details['to_salary'];//to_salary
					$data['movement_file'] = 'compensation.blade.php';
				break;
				case 6://Resignation
				case 7://Termination
				case 10://End Contract
				case 11://Retirement
				$movement_type_details = $this->mod->get_moving_movement($action_id);
					$data['record']['partners_movement_action_moving.id'] = $movement_type_details['id'];//id
					$data['record']['partners_movement_action_moving.blacklisted'] = $movement_type_details['blacklisted'];//blacklisted
					$data['record']['partners_movement_action_moving.end_date'] = date("F d, Y", strtotime($movement_type_details['end_date']));//end_date
					$data['record']['partners_movement_action_moving.reason_id'] = $movement_type_details['reason_id'];//reason_id
					$data['record']['partners_movement_action_moving.further_reason'] = $movement_type_details['further_reason'];//further_reason
					$data['movement_file'] = 'endservice.blade.php';
				break;
				case 13://Extension
				$movement_type_details = $this->mod->get_extension_movement($action_id);
					$data['record']['partners_movement_action_extension.id'] = $movement_type_details['id'];//id
					$data['record']['partners_movement_action_extension.no_of_months'] = $movement_type_details['no_of_months'];//no_of_months
					$data['record']['partners_movement_action_extension.end_date'] = date("F d, Y", strtotime($movement_type_details['end_date']));//end_date
					$data['movement_file'] = 'extension.blade.php';
				break;
				case 17://Developmental Assignment
				$movement_type_details = $this->mod->get_extension_movement($action_id);
					$data['record']['partners_movement_action_extension.id'] = $movement_type_details['id'];//id
					$data['record']['partners_movement_action_extension.no_of_months'] = $movement_type_details['no_of_months'];//no_of_months
					$data['record']['partners_movement_action_extension.end_date'] = date("F d, Y", strtotime($movement_type_details['end_date']));//end_date
					$data['movement_file'] = 'extension.blade.php';
				break;
			}
		}else{	
			$data['count'] = $this->input->post('count');
			$type_id = $data['type_id'] = $this->input->post('type_id');
			$type = $data['type'] = $this->input->post('type_name');	
			$data['record']['partners_movement_action.action_id'] = '';	
			switch($type_id){
				case 1://Regularization
				case 3://Promotion
				case 8://Transfer
				case 9://Employment Status
				case 12://Temporary Assignment
					$data['movement_file'] = 'transfer.blade.php';
					$data['transfer_fields'] = $this->mod->getTransferFields();

					foreach($data['transfer_fields'] as $index => $field){				
						$data['transfer_fields'][$index]['from_id'] = '';
						$data['transfer_fields'][$index]['to_id'] = '';
						$data['transfer_fields'][$index]['from_name'] = '';
						$data['transfer_fields'][$index]['to_name'] = '';
					}
				break;
				case 2://Salary Increase
				case 4://Wage Order
					$data['movement_file'] = 'compensation.blade.php';
					$data['record']['partners_movement_action_compensation.id'] = '';//id
				break;
				case 6://Resignation
				case 7://Termination
				case 10://End Contract
				case 11://Retirement
					$data['movement_file'] = 'endservice.blade.php';
					$data['record']['partners_movement_action_moving.id'] = '';//id
				break;
				case 13://Extension
					$data['movement_file'] = 'extension.blade.php';
					$data['record']['partners_movement_action_extension.id'] = '';//id
				break;
				case 17://Developmental Assignment
					$data['movement_file'] = 'extension.blade.php';
					$data['record']['partners_movement_action_extension.id'] = '';//id
				break;
			}

			$result = $this->mod->_get( 'edit', 0 );
			$field_lists = $result->list_fields();
			foreach( $field_lists as $field )
			{
				$data['record'][$field] = '';
			}
		}

			$this->response->count = ++$data['count'];
			$this->load->helper('file');
			$this->load->helper('form');
			$this->response->add_movement = $this->load->view('edit/custom_fgs/nature.blade.php', $data, true);
			$this->response->type_of_movement = $this->load->view('edit/custom_fgs/'.$data['movement_file'], $data, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();
	}

	function delete_movement_type()
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

		$data['deleted'] = 1;
		//other tables
		$this->db->where_in('action_id', $records);
		$this->db->update('partners_movement_action_extension', $data);
		$this->db->where_in('action_id', $records);
		$this->db->update('partners_movement_action_compensation', $data);
		$this->db->where_in('action_id', $records);
		$this->db->update('partners_movement_action_moving', $data);
		$this->db->where_in('action_id', $records);
		$this->db->update('partners_movement_action_transfer', $data);

		$data['modified_on'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->user->user_id;
		//action table
		$this->db->where_in('action_id', $records);
		$this->db->update('partners_movement_action', $data);

		if( $this->db->_error_message() != "" ){
			$this->response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}
		else{
			$this->response->message[] = array(
				'message' => lang('common.delete_record', $this->db->affected_rows()),
				'type' => 'success'
			);
		}

		$this->_ajax_return();
	}

    function movement_details_list(){  
    	
    	$this->_ajax_only();  	
    	$record_id = $this->input->post('record_id');

		$data['movement_details'] = $this->mod->get_movement_details($record_id);
    	$view['content'] = $this->load->view('edit/custom_fgs/movement_type_list.php', $data, true);
	
	    $this->response->lists = $view['content'];

	    $this->response->message[] = array(
	        'message' => '',
	        'type' => 'success'
	        );

	    $this->_ajax_return();
    }

