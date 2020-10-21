
	public function index(){   

		$data['permission'] = $this->permission;
        $this->load->vars( $data );

        echo $this->load->blade('record_listing_custom')->with( $this->load->get_cached_vars() );
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

        $page = $this->input->post('page');
        $search = $this->input->post('search');
        $filter = $this->input->post('filter');
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
        
        $page = ($page-1) * 10; //echo $page;
        $page = ($page < 0 ? 0 : $page);
        $company_id = $this->input->post('filter');
        $shift_id = $this->input->post('filter_by');
        $records = $this->mod->_get_list($page, 10, $search, $trash, $company_id,$shift_id);

        $this->response->records_retrieve = sizeof($records);
        $this->response->list = '';
        $this->response->total_record = count($records);

        if( count($records) > 0 ){

            foreach( $records as $record )
            {
                $rec = array(
                    'detail_url' => '#',
                    'edit_url' => '#',
                    'delete_url' => '#',
                    'options' => ''
                );

                $this->_list_options_active( $record, $rec );
                $record = array_merge($record, $rec);

                $this->response->list .= $this->load->blade('list_template', $record, true);
            }

            $this->response->no_record = '';

        }
        else{

            $this->response->list = "";

        }

    
        $this->_ajax_return();
    }

	function _list_options_active( $record, &$rec )
	{

		if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}	
		
	}

    public function edit( $record_id=0 )
    {
    	$data = array();
    	$data = $this->mod->get_shift_class_details($record_id);

        $this->load->vars($data);

        $this->load->helper('form');
        $this->load->helper('file');
        if($record_id){
        	echo $this->load->blade('edit.edit_form')->with( $this->load->get_cached_vars() );
        }else{
        	echo $this->load->blade('edit.add_form')->with( $this->load->get_cached_vars() );
        }

    }

	function save(){

		$error = false;
		$post = $_POST;
		$this->response->record_id = $this->record_id = $post['record_id'];
		unset( $post['record_id'] );

		$validation_rules = array();
		if(!$this->record_id > 0){
			$validation_rules[] = 
			array(
				'field' => 'time_shift_class_company[class_value]',
				'label' => 'Class Value',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'time_shift_class_company[class_id]',
				'label' => 'Class Code',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'time_shift_class_company[shift_id]',
				'label' => 'Shift',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'time_shift_class_company[company_id]',
				'label' => 'Company',
				'rules' => 'required'
				);
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
			$record = $this->db->get_where( $this->mod->table, array( $this->mod->primary_key => $this->record_id ) );

			//if other fields
			if(array_key_exists('employment_status_id', $main_record)){
				$main_record['employment_status_id'] = implode(",", $main_record['employment_status_id']);
			}else{
				$main_record['employment_status_id'] = "ALL";
			}
			if(array_key_exists('employment_type_id', $main_record)){
				$main_record['employment_type_id'] = implode(",", $main_record['employment_type_id']);
			}else{
				$main_record['employment_type_id'] = "ALL";
			}
			if(array_key_exists('partners_id', $main_record)){
				$main_record['partners_id'] = implode(",", $main_record['partners_id']);
			}else{
				$employee_filter = $this->input->post('employee_filtered');
				if( strtolower($this->input->post('partners_id')) == 'all' ){
					$main_record['partners_id'] = "ALL";
				}else{
					$main_record['partners_id'] = $this->input->post('partners_id');
				}
			}

			switch( true )
			{				
				case $record->num_rows() == 0:
					$this->db->insert($this->mod->table, $main_record);
					if( $this->db->_error_message() == "" )
					{
						$this->response->record_id = $this->record_id = $this->db->insert_id();
					}
					$this->response->action = 'insert';
					break;
				case $record->num_rows() == 1:
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

	function update_class_codes()
	{
		$this->_ajax_only();

		$company_id = $this->input->post('company_id');
		$shift_id = $this->input->post('shift_id');
		$qry = "SELECT tsc.class_code, tsc.class_id
	 			FROM {$this->db->dbprefix}time_shift_class tsc
				LEFT JOIN {$this->db->dbprefix}time_shift_class_company tscc ON tscc.class_id = tsc.class_id
				AND tscc.shift_id = {$shift_id} AND tscc.company_id = {$company_id}
				WHERE tscc.id IS NULL 
				ORDER BY tsc.class_code ASC";
		$class_codes = $this->db->query( $qry );
		$this->response->class_codes = '<option value="">Select...</option>';
		
		foreach( $class_codes->result() as $class_code )
		{
			$this->response->class_codes .= '<option value="'.$class_code->class_id.'">'.$class_code->class_code.'</option>';
		}

		$this->_ajax_return();	
	}

    function update_employees()
    {
        $this->_ajax_only();

        $qry = "SELECT partners.alias, partners.partner_id, partners.user_id 
                FROM partners
                INNER JOIN users_profile ON partners.user_id = users_profile.user_id
                WHERE partners.deleted = 0 
                ";

        $qry .= " ORDER BY partners.alias ASC";

        $employees = $this->db->query( $qry );
        $this->response->count = $employees->num_rows();
        foreach( $employees->result() as $employee )
        {   
            $data['partner_id_options'][$employee->user_id] = $employee->alias;
            $this->response->employees .= '<option value="'.$employee->partner_id.'" selected="selected">'.$employee->alias.'</option>';
        }

        if($this->input->post('record_id')){
    		$data['shift_class_details'] = $this->mod->get_shift_class_details($this->input->post('record_id'));
        }

        $data['record']['partners.partner_id'] = '';
        $view['content'] = $this->load->view('edit/change_employees', $data, true);

        $this->response->filtered_employees = $view['content'];

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

	function save_value(){

		$error = false;
		$post = $_POST;
		$this->response->record_id = $this->record_id = $post['record_id'];
		unset( $post['record_id'] );

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
			$record = $this->db->get_where( $this->mod->table, array( $this->mod->primary_key => $this->record_id ) );

			switch( true )
			{				
				case $record->num_rows() == 0:
					$this->db->insert($this->mod->table, $main_record);
					if( $this->db->_error_message() == "" )
					{
						$this->response->record_id = $this->record_id = $this->db->insert_id();
					}
					$this->response->action = 'insert';
					break;
				case $record->num_rows() == 1:
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
				'message' => 'Class value successfully updated.',
				'type' => 'success'
			);
		}

		$this->response->saved = !$error;

        $this->_ajax_return();
    }

