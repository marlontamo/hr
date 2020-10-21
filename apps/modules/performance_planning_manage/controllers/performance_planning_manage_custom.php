


	public function index()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}
		
		$data['planning'] = $this->mod->get_list($this->user->user_id);

		foreach($data['planning'] as $index => $plan ){

			$planning_data = $this->mod->get_department($this->user->user_id, $plan['planning_id']);
			$data['planning'][$index]['department'] = $planning_data['department'];
			$data['planning'][$index]['users'] = $planning_data['users'];
			$data['planning'][$index]['status'] = $planning_data['status'];
		}

		foreach($data['planning'] as $index => $plan ){			
			foreach($data['planning'][$index]['department'] as $dept_id => $dept ){
				if(!empty($data['planning'][$index]['users'][$dept_id])){
					foreach($plan['users'][$dept_id] as $user_id => $user){
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
						$data['planning'][$index]['department'][$dept_id]['users'] .= '<span class="margin-right-5"><a type="button" class="btn '.$color_class.' btn-xs margin-bottom-6" data-id="'.$user_id.'"> '.$user['name'].' </a></span>';
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
						$data['planning'][$index]['department'][$dept_id]['status_count'] .= '<span class="pull-right margin-right-5">
						<a type="button" data-planning-id="'.$plan['planning_id'].'" data-dept-id="'.$dept_id.'" data-status-id="'.$status.'" 
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
		$planning_id = $this->input->post('planning_id');
		$status_id = $this->input->post('status_id');

		$users = $this->mod->filter_status($department_id, $planning_id, $this->user->user_id, $status_id);
		
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

