

	function _list_options_active( $record, &$rec )
	{

		if( $this->permission['detail'] )
		{
			$rec['detail_url'] = $this->mod->url . '/detail/'.strtotime($record['partners_personal_request_created_on']).'/'.$record['partners_personal_request_partner_id'].'/'.$record['partners_personal_request_status_id'];
			$rec['view_url'] = '<a href="'.$rec['detail_url'].'" class="btn btn-xs text-muted"><i class="fa fa-search"></i> View</a>';
			// $rec['view_url'] = '<a href="javascript: see_detail('.$record['partners_personal_request_partner_id'].', \''.$record['partners_personal_request_created_on'].'\', '.$record['partners_personal_request_status_id'].')" class="btn btn-xs text-muted"><i class="fa fa-search"></i> View</a>';
		}

		if( $this->permission['approve'] && $record['partners_personal_request_status_id'] == 2 )
		{
			$rec['options'] .= '<li><a href="javascript: change_status('.$record['partners_personal_request_partner_id'].', \''.$record['partners_personal_request_created_on'].'\', 3)"><i class="fa fa-check text-success"></i> Approve</a></li>';
		}

		if(  $this->permission['decline'] && $record['partners_personal_request_status_id'] == 2 )
		{
			$rec['options'] .= '<li><a href="javascript: change_status('.$record['partners_personal_request_partner_id'].', \''.$record['partners_personal_request_created_on'].'\', 4)"><i class="fa fa-times text-danger"></i> Decline</a></li>';
		}
	}

	function change_status()
	{
		$this->_ajax_only();

		$status = $this->input->post('status');
		$partner_id = $this->input->post('partner_id');
		$created_on = $this->input->post('created_on');

		switch( true )
		{
			case $status == 3:
				if( !$this->permission['approve'] )
				{
					$this->response->message[] = array(
						'message' => lang('common.insufficient_permission'),
						'type' => 'warning'
					);
					$this->_ajax_return();
				}
				break;
			case $status == 4:
				if( !$this->permission['decline'] )
				{
					$this->response->message[] = array(
						'message' => lang('common.insufficient_permission'),
						'type' => 'warning'
					);
					$this->_ajax_return();
				}
				break;
			default:
				$this->response->message[] = array(
					'message' => 'Unsupported type of status, please notify the System Administrator.',
					'type' => 'warning'
				);
				$this->_ajax_return();
		}


        //SAVING START   
        $error = false;
		$transactions = true;
		$this->partner_id = 0;
		if( $transactions )
		{
			$this->db->trans_begin();
		}

		$where = array('partner_id' => $partner_id, 
					'created_on' => $created_on);
		$this->mod->change_status($partner_id, $created_on, $status);

		$users_profile = $this->db->get_where('users_profile', array('partner_id' => $partner_id))->row_array();
		$check_if_exists = $this->db->get_where($this->mod->table, $where)->result_array();

		foreach($check_if_exists as $check_if_exist){
			$partners_key = $this->db->get_where('partners_key', array('deleted' => 0, 'key_id' => $check_if_exist['key_id']))->row_array();

			$sequence = 1;
			$this->load->model('partners_model', 'partners_mod');		
			$partners_personal = $this->partners_mod->get_partners_personal($users_profile['user_id'], 'partners_personal', $partners_key['key_code'], 1);
			$check_on_personal = $this->db->get_where('partners_personal', array('partner_id' => $partner_id, 'key_id' => $check_if_exist['key_id']))->result_array();

			$main_record = array();
			switch( true )
			{
				case count($check_on_personal) == 0:
					$data_personal = $this->partners_mod->insert_partners_personal($users_profile['user_id'], $partners_key['key_code'], $check_if_exist['key_value'], 1, $partner_id);
					$this->db->insert('partners_personal', $data_personal);
					$this->response->action = 'insert';
					break;
				case count($check_on_personal) > 0:
					$partners_personal = $partners_personal[0];
					$main_record['modified_by'] = $this->user->user_id;
					$main_record['modified_on'] = date('Y-m-d H:i:s');
					$main_record['key_value'] = $check_if_exist['key_value'];
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
				'message' => 'Record successfully updated.',
				'type' => 'success'
			);
		}
		
		$this->_ajax_return();
	
	}

	function cr_form()
	{
		$this->_ajax_only();

		$this->load->helper('form');
		$this->load->model('profile_model', 'profile');
		
		$key_classes = $this->profile->get_user_editable_key_classes();
		$data['key_classes'] = array();
		foreach( $key_classes as $row )
		{
			//check wether key_class has active request
			if( !$this->profile->has_active_request( $row->key_class_id, 0 ) )
				$data['key_classes'][$row->key_class_id] = $row->key_class; 
		}

		$drafts = $this->profile->get_user_editable_keys_draft( 0 );
		$draft = array();
		foreach( $drafts as $row )
		{
			$draft[$row->key_class_id][$row->key_id] = $row; 
		}

		$data['draft'] = '';
		foreach( $draft as $key_class_id => $keys )
		{
			$temp = array();
			foreach ($keys as $key_id => $key) {
				$temp[] = $this->profile->create_key_draft( $key, $key->key_value );
			}
			$temp = implode('', $temp);

			$data['draft'] .= $this->load->view('draft', array('key_class_id' => $key_class_id,'keys' => $temp), true);
		}

		$this->load->vars($data);

		$data = array();
		$data['title'] = 'Change Request';
		$data['content'] = $this->load->blade('cr_form')->with( $this->load->get_cached_vars() );
		$this->response->cr_form = $this->load->view('templates/modal', $data, true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function add_class_draft()
	{
		$this->_ajax_only();

		$key_class_id = $this->input->post('key_class_id');

		$this->load->model('profile_model', 'profile');

		$keys = $this->profile->get_user_editable_keys( $key_class_id );
		$temp = array();
		foreach( $keys as $key )
		{
			$temp[] = $this->profile->create_key_draft( $key, '' );	
		}
		$temp = implode('', $temp);

		$this->response->class_draft = $this->load->view('draft', array('key_class_id' => $key_class_id, 'keys' => $temp), true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function save_request()
	{
		$this->_ajax_only();

		$status = $this->input->post('status');
		$classes = $this->input->post('key');
		$partner_id = get_partner_id( $this->input->post('user_id') );

		$this->load->model('profile_model', 'profile');

		foreach( $classes as $class_id => $keys )
		{
			$active = $this->profile->has_active_request( $class_id, $partner_id );
			$ctr = 1;
			foreach($keys as $key_id => $value)
			{
				$where = $data = array(
					'partner_id' => $partner_id,
					'key_id' => $key_id,
				);

				$data['sequence'] = $ctr;
				$data['key_value'] = $value;
				$data['status'] = $status;
				
				if($active)
				{
					$this->db->update('partners_personal_request', $data, $where);
				}
				else{
					$this->db->insert('partners_personal_request', $data);
				}

				$ctr++;
			}
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	public function detail( $createdon, $partnerid, $statusid, $child_call = false )
	{

		if( !$this->permission['detail'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_detail( $createdon, $partnerid, $statusid, $child_call );
	}

	private function _detail( $createdon, $partnerid, $statusid, $child_call )
	{
		// $this->record_id = $data['record_id'] = $_POST['record_id'];
		
		// $status = $this->input->post('status');
		// $partner_id = $this->input->post('partner_id');
		// $created_on = $this->input->post('created_on');
		$status = $statusid;
		$partner_id = $partnerid;
		$created_on = date("Y-m-d H:i:s", $createdon);

		$record_check = $this->mod->_get_details($partner_id, $created_on, $status);

		if( count($record_check) > 0 )
		{
			$result = $this->mod->_get_details($partner_id, $created_on, $status);
			$data['partner_id'] = $partner_id;
			$data['created_on'] = $created_on;
			$data['status'] = $status;
			$data['record'] = $result;
			$this->load->vars( $data );

			// echo "<pre>";
			// print_r($data);
			// exit();
			if( !$child_call ){
				if( !IS_AJAX )
				{
					echo $this->load->blade('pages.detail')->with( $this->load->get_cached_vars() );
				}
				else{
					$data['title'] = $this->mod->short_name .' - Detail';
					$data['content'] = $this->load->blade('pages.detail')->with( $this->load->get_cached_vars() );

					// $this->response->html = $this->load->view('templates/modal', $data, true);

					$this->response->message[] = array(
						'message' => '',
						'type' => 'success'
					);
					$this->_ajax_return();
				}
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
