

	public function index()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}
		
		$data['appraisal'] = $this->mod->get_list($this->user->user_id);

		foreach($data['appraisal'] as $index => $plan ){

			$appraisal_data = $this->mod->get_department($this->user->user_id, $plan['appraisal_id']);
			$data['appraisal'][$index]['department'] = $appraisal_data['department'];
			$data['appraisal'][$index]['users'] = $appraisal_data['users'];
			$data['appraisal'][$index]['status'] = $appraisal_data['status'];
		}

		foreach($data['appraisal'] as $index => $plan ){			
			foreach($data['appraisal'][$index]['department'] as $dept_id => $dept ){
				if(!empty($data['appraisal'][$index]['users'][$dept_id])){
					foreach($plan['users'][$dept_id] as $user_id => $user){
						$href = "javascript:void(0)";
						switch($user['status_id']){
							case 1: //Draft
								$color_class = 'orange';
							break;
							case 2: //For Approval
								$color_class = 'yellow';
							break;
							case 3: //Pending
								$color_class = 'red';
							break;
							case 4: //Approved
								$color_class = 'green';
							break;
							default:
								$color_class = 'default';
							break;
						}
						$href = base_url($this->mod->route) . '/review/'.$plan['appraisal_id'].'/'.$user_id.'/'.$this->user->user_id;
						$data['appraisal'][$index]['department'][$dept_id]['users'] .= '<span class="margin-right-5"><a href="'.$href.'" class="btn '.$color_class.' btn-xs margin-bottom-6" data-id="'.$user_id.'"> '.$user['name'].' </a></span>';
					}

					foreach($plan['status'][$dept_id]['status'] as $status_id => $status){
						switch($status){
							case 1: //Draft
								$color_class = 'orange';
							break;
							case 2: //For Approval
								$color_class = 'yellow';
							break;
							case 3: //Pending
								$color_class = 'red';
							break;
							case 4: //Approved
								$color_class = 'green';
							break;
							default:
								$color_class = 'default';
							break;
						}
						$data['appraisal'][$index]['department'][$dept_id]['status_count'] .= '<span class="pull-right margin-right-5">
						<a type="button" data-appraisal-id="'.$plan['appraisal_id'].'" data-dept-id="'.$dept_id.'" data-status-id="'.$status.'" 
						class="btn '.$color_class.' btn-xs filter_status"> '.$plan['status'][$dept_id]['status_count'][$status_id].'</a></span>';
					}
				}
			}
		}

        $this->load->vars($data);
		echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
	}

	function filter_status() {
		$this->_ajax_only();

		$department_id = $this->input->post('dept_id');
		$appraisal_id = $this->input->post('appraisal_id');
		$status_id = $this->input->post('status_id');

		$users = $this->mod->filter_status($department_id, $appraisal_id, $this->user->user_id, $status_id);
		
		// echo "<pre>";print_r($users);
		// exit();
		$this->response->filter_status = '';
		foreach($users as $user_id => $user){
			switch($user['status_id']){
				case 1: //Draft
					$color_class = 'orange';
				break;
				case 2: //For Approval
					$color_class = 'yellow';
				break;
				case 3: //Pending
					$color_class = 'red';
				break;
				case 4: //Approved
					$color_class = 'green';
				break;
				default:
					$color_class = 'default';
				break;
			}
			$this->response->filter_status  .= '<span class="margin-right-5"><a type="button" class="btn '.$color_class.' btn-xs margin-bottom-6" data-id="'.$user_id.'"> '.$user['name'].' </a></span>';
		}
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();
	}

	function review( $appraisal_id, $user_id, $manager_id = '' )
	{
		parent::edit('', true);

		$vars['appraisee'] = $this->mod->get_appraisee( $this->record_id, $user_id );

        $vars['manager'] = $manager_id; 

        $this->load->model('appraisal_template_model', 'template');
        $vars['template'] = $this->template; 

        $this->load->vars( $vars );

        $this->load->helper('form');
        $this->load->helper('file');
        echo $this->load->blade('pages.review')->with( $this->load->get_cached_vars() );  
	}

	function get_section_items()
    {
        $this->_ajax_only();
        
        $appraisee = $this->mod->get_appraisee( $this->input->post('appraisal_id'), $this->input->post('user_id') );
        $this->db->limit(1);
        $section = $this->db->get_where('performance_template_section', array('template_section_id' => $_POST['section_id']))->row();

        switch($section->section_type_id)
        {
        	case 2:
        		$this->response->items = $this->load->view('review/items_balancescorecard', $_POST, true);
        		break;
        	case 3:
        		$this->response->items = $this->load->view('review/items_library', $_POST, true);
        		break;
        	case 4:
        		$this->response->items = $this->load->view('review/items_library_crowd', $_POST, true);
        		break;
        }
        	

        $this->response->section_id = $_POST['section_id'];
        $this->response->close_modal = true;

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();      
    }

    function contributor_form()
    {
        $this->_ajax_only();
        
        $data['title'] = 'Add/Edit Section';
		$data['content'] = $this->load->view('review/contributor_form', array('post' => $_POST), true);

		$this->response->contributor_form = $this->load->view('templates/modal', $data, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();      
    }

    public function tag_user(){

		$this->_ajax_only();

		$data = array();
		$this->load->model('dashboard_model');
		$data = $this->dashboard_model->getUsersTagList();

		header('Content-type: application/json');
		echo json_encode($data);
		die();
	}

	function add_contributors()
	{
		$this->_ajax_only();
        $this->response->close_modal = false;

        $contributors = $this->input->post('contributors');
        $contributors = explode(',', $contributors);
        if( sizeof($contributors) > 5 )
        {
        	$this->response->message[] = array(
				'message' => 'Number of contributors exceeded allowed.',
				'type' => 'warning'
			);
			$this->_ajax_return();
        }

        foreach( $contributors as $contributor_id )
        {
        	$insert = array(
        		'appraisal_id' => $_POST['appraisal_id'],
        		'user_id' => $_POST['user_id'],
        		'template_section_id' => $_POST['template_section_id'],
        		'contributor_id' => $contributor_id,
        	);

        	$this->db->insert('performance_appraisal_contributor', $insert);
        }

        $this->response->close_modal = true;
         $this->response->section_id = $_POST['template_section_id'];

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return(); 	
	}

	function change_status( $return = false )
    {
        $this->_ajax_only();
        
        $this->db->trans_begin();
        $error = false;

        $vars['appraisee'] = $this->mod->get_appraisee( $_POST['appraisal_id'], $_POST['user_id'] );      

        if( $vars['appraisee']->to_user_id != $this->user->user_id   )
        {
            $this->response->message[] = array(
                'message' => 'Record is not under your attention.',
                'type' => 'warning'
            );

            $this->_ajax_return();
        }

        $status_id = $this->input->post('status_id');
        
        //get approvers
        $where = array(
            'appraisal_id' => $this->input->post('appraisal_id'),
            'user_id' => $this->input->post('user_id'),
        );
        $this->db->order_by('sequence');
        $approvers = $this->db->get_where('performance_appraisal_approver', $where)->result();
        $no_approvers = sizeof($approvers);

        $condition = $approvers[0]->condition;

        $this->response->redirect = false;
        switch( $status_id )
        {
            case 2: //for approval
                //update all approvers
                foreach(  $approvers  as $index => $approver )
                {
                    $this->db->update('performance_appraisal_approver', array('performance_status_id' => 2), array('id' => $approver->id));
                    if( $index == 0 )
                    {
                        $update['to_user_id'] = $approver->approver_id;
                    }
                }
                $this->response->redirect = true;
            case 3: //pending
                //assume this is from approver
                //bring it down
                foreach(  $approvers as $index => $approver )
                {
                    if( $approver->approver_id == $this->user->user_id ){
                        if( $index != 0 ){
                            $down = $approvers[$index-1];
                            $this->db->update('performance_appraisal_approver', array('performance_status_id' => 3), array('id' => $down->id));
                            $update['to_user_id'] = $down->approver_id;
                        }
                        else{
                            $update['to_user_id'] = $this->input->post('user_id');
                        }
                    }
                }
                $this->response->redirect = true;
                break;
            case 4: //approved
                //assume this is from approver
                //bring it up
                foreach(  $approvers as $index => $approver )
                {
                    if( $approver->approver_id == $this->user->user_id ){
                        $this->db->update('performance_appraisal_approver', array('performance_status_id' => 4), array('id' => $approver->id));

                        if( ($index+1) == $no_approvers ){
                            $update['to_user_id'] = $this->input->post('user_id');
                        }
                        else{
                            $up = $approvers[$index+1];
                            $update['to_user_id'] = $up->approver_id;  
                        }
                    }
                }

                $this->response->redirect = true;
                break;
            default: //draft
        }

        if( $this->db->_error_message() != "" )
        {
        	$this->response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
        	$error = true;
        	goto stop;
        }

        if( isset($_POST['appraisal_field']) )
        {
            $fields = $_POST['appraisal_field'];
            foreach( $fields as $column_id => $items )
            {
                foreach( $items as $item_id => $value )
                {
                    if( $value == '' )
                    {
                    	$this->response->message[] = array(
							'message' => "Please fillup all fields.",
							'type' => 'error'
						);
                    	$error = true;
                    	goto stop;
                    }

                    $insert = array(
                        'appraisal_id' => $this->input->post('appraisal_id'),
                        'user_id' => $this->input->post('user_id'),
                        'item_id' => $item_id,
                        'section_column_id' => $column_id, 
                        'value' => $value
                    );

                    $where = array(
                        'appraisal_id' => $this->input->post('appraisal_id'),
                        'user_id' => $this->input->post('user_id'),
                        'item_id' => $item_id,
                        'section_column_id' => $column_id 
                    );

                    $check = $this->db->get_where('performance_appraisal_fields', $where);
                    if($check->num_rows() > 0)
                    {
                        $this->db->update('performance_appraisal_fields', $insert, $where);
                    }   
                    else{
                        $this->db->insert('performance_appraisal_fields', $insert);
                    }

                    if( $this->db->_error_message() != "" )
			        {
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

        if( $status_id == 4 )
        {
            //get approvers
            $where = array(
                'appraisal_id' => $this->input->post('appraisal_id'),
                'user_id' => $this->input->post('user_id'),
            );
            $this->db->order_by('sequence');
            $approvers = $this->db->get_where('performance_appraisal_approver', $where)->result();
            switch ($condition) {
                case 'ALL':
                case 'By Level':
                    $all_approved = true;
                    foreach( $approvers as $approver )
                    {
                        if($approver->performance_status_id != 4)
                        {
                            $all_approved = false;
                            break;
                        }
                    }
                    if($all_approved)
                    {
                        $status_id = 4;
                    }
                    break;
                
                    # code...
                    break;
                case 'Either Of':
                    $one_approved = false;
                    foreach( $approvers as $approver )
                    {
                        if($approver->performance_status_id == 4)
                        {
                            $one_approved = true;
                            break;
                        }
                    }
                    if($all_approved)
                    {
                        $status_id = 4;
                    }
                    break;
            }

            if( $this->db->_error_message() != "" )
	        {
	        	$this->response->message[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
	        	$error = true;
	        	goto stop;
	        }
        }
        
        $where = array(
            'appraisal_id' => $this->input->post('appraisal_id'),
            'user_id' => $this->input->post('user_id')
        );
        $update['status_id'] = $status_id;
        $this->db->update('performance_appraisal_applicable', $update, $where);
        
        if( $this->db->_error_message() != "" )
        {
        	$this->response->message[] = array(
                'message' => $this->db->_error_message(),
                'type' => 'error'
            );
            $error = true;
        }

        stop:
		if( !$error ){
			$this->db->trans_commit();
		}
		else{
			 $this->db->trans_rollback();
			 $this->response->redirect = false;
		}

        if( $return )
        {
            return !$error;
        }

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }
    
    function review_admin( $appraisal_id, $user_id, $manager_id = '' )
    {
        parent::edit('', true);

        $vars['appraisee'] = $this->mod->get_appraisee( $this->record_id, $user_id );

        $vars['manager'] = $manager_id; 

        $this->load->model('appraisal_template_model', 'template');
        $vars['template'] = $this->template; 

        $this->load->vars( $vars );

        $this->load->helper('form');
        $this->load->helper('file');
        echo $this->load->blade('pages.review')->with( $this->load->get_cached_vars() );  
    }
