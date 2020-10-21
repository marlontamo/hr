<?php //delete me
	public function login()
	{
		if( $this->session->userdata('user') )
		{
			$this->session->set_flashdata('flashmessage', array('msg_type' => 'attention', 'msg' => 'You are already logged in.'));
			redirect('');
		}

		echo $this->load->blade('loginform')->with( $this->load->get_cached_vars() );
	}

	public function screenlock()
	{
		if( !$this->session->userdata('user') )
		{
			$this->session->set_flashdata('flashmessage', array('msg_type' => 'attention', 'msg' => 'Please login.'));
			redirect('login');
		}

		if( !$this->session->userdata('uri_request') ){
			$this->session->set_userdata('uri_request', $_SERVER['HTTP_REFERER']);
		}

		$this->session->set_userdata('screenlock', true );

		$this->user = $this->session->userdata('user');
		$user_setting = APPPATH . 'config/users/'. $this->user->user_id .'.php';
		if( !file_exists( $user_setting ) )
		{
			$this->load->model('users_model', 'users');
			$this->users->_create_config( $this->user->user_id );
		}
		$user_id = $this->user->user_id;
		$this->load->config( "users/{$user_id}.php", false, true );
		$user = $data['user'] = $this->config->item('user');

		$this->load->vars( $data );

		echo $this->load->blade('screenlock')->with( $this->load->get_cached_vars() );
	}

	public function check_credentials()
	{
		$this->_ajax_only();
		
		$data = json_decode(file_get_contents('php://input'));
		$username = $data->username;
		$password = $data->password;
		$rememberme = $data->rememberme;

		if( $this->authentication->_check_username_exists( $username ) )
		{
			if( $user = $this->authentication->_try_login( $username, $password ) )
			{
				$this->response->message = array(
					'message' => 'Login successful.',
					'type' => 'success'
				);

				if( $this->session->userdata('uri_request') )
				{
					$this->response->redirect = $this->session->userdata('uri_request');
					$this->session->unset_userdata( 'uri_request' );
				}

				if( $rememberme  )
				{
					$this->session->set_userdata('sess_length',(60*60*24*14));
				}
				$this->session->set_userdata('user', $user);
			}
			else{
				$this->response->message = array(
					'message' => 'Password did not match.',
					'type' => 'error'
				);	
			}
		}
		else{
			$this->response->message = array(
				'message' => 'Username is not registered.',
				'type' => 'error'
			);
		}
		
		$this->_ajax_return();
	}

	public function unlock()
	{
		$this->_ajax_only();
		
		$this->authentication->_login_check();
		
		$password = $this->input->post('password');
		$this->user = $this->session->userdata('user');
		$user = $this->db->get_where('users', array('user_id' => $this->user->user_id))->row();
		
		if( $user = $this->authentication->_try_login( $user->login, $password ) )
		{
			$this->response->message = array(
				'message' => 'Login successful.',
				'type' => 'success'
			);

			if( $this->session->userdata('uri_request') )
			{
				$this->response->redirect = $this->session->userdata('uri_request');
				$this->session->unset_userdata( 'uri_request' );
			}

			$this->session->unset_userdata('screenlock');
		}
		else{
			$this->response->message = array(
				'message' => 'Password did not match.',
				'type' => 'error'
			);	
		}
		
		$this->_ajax_return();	
	}

	public function logout()
	{
		$this->session->unset_userdata('user');
		$this->session->sess_destroy();
		redirect('login');
	}

	function request_reset_pass()
	{
		$this->_ajax_only();

		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_error_delimiters('','');
		if ( $this->form_validation->run() != FALSE ){
			if( $this->mod->_check_username_exists( $this->input->post('email') ) )
			{
				$this->mod->_send_reset_pass( $this->input->post('email') );
				$this->response->success = true;
			}
			else{
				$this->response->success = false;
				$this->response->message = array(
					'message' => 'Email is not registered or is not active.',
					'type' => 'error'
				);	
			}
		}
		else{
			$this->response->success = false;
			$this->response->message = array(
				'message' => 'Please see to it that your email is valid.',
				'type' => 'error'
			);
		}

		$this->_ajax_return();	
	}

	function reset_pass()
	{
		$id = $this->input->get('id');
		$salt = $this->input->get('salt');
		if( !empty($id) && !empty( $salt ) )
		{
			$data = $this->mod->_reset_pass( $id, $salt );
		}
		else{
			$data['reset'] = false;
			$data['message'] = "Incomplete data supplied!";
		}

		$this->load->vars( $data );
		echo $this->load->blade('reset_pass')->with( $this->load->get_cached_vars() );
	}

	function get_password_form()
	{
		$this->mod->_login_check();
		$this->_ajax_only();
		$data['title'] = 'Change Password';
		$data['content'] = $this->load->blade('forms.password')->with( $this->load->get_cached_vars() );
		$this->response->password_form = $this->load->view('templates/modal', $data, true);
		$this->_ajax_return();	
	}

	function update_password()
	{
		$this->mod->_login_check();
		$this->_ajax_only();
		$this->response->update = false;
		if( $this->input->post('current_password') && $this->input->post('new_password') && $this->input->post('confirm_password')  )
		{
			//check password matches current password
			$this->user = $this->session->userdata('user');
			$user = $this->_get_user_config();

			$current_pass = $this->input->post('current_password');

			if( $this->mod->_try_login( $user['username'], $current_pass ) )
			{
				$new_pass = $this->input->post('new_password');
				
				//do not allow same password
				if( strcmp( $new_pass, $current_pass ) == 0 )
				{
					$this->response->message[] = array(
						'message' => 'Current password and new password is the same.',
						'type' => 'error'
					);
					$this->_ajax_return();
				}

				$confirm_pass = $this->input->post('confirm_password');

				//check that the new pass and confirm password are the same
				if( strcmp( $new_pass, $confirm_pass ) != 0 )
				{
					$this->response->message[] = array(
						'message' => 'New password does not match confirm password.',
						'type' => 'error'
					);
					$this->_ajax_return();
				}

				$update = $this->mod->change_password( $user['user_id'], $new_pass );

				if( $update === true )
				{
					$this->response->update = true;
					$this->response->message[] = array(
						'message' => 'Password updated.',
						'type' => 'success'
					);
				}
				else{
					$this->response->message[] = array(
						'message' => $update,
						'type' => 'error'
					);
					$this->_ajax_return();	
				}
			}
			else{
				$this->response->message[] = array(
					'message' => 'Current password did not match.',
					'type' => 'error'
				);
				$this->_ajax_return();	
			}
		}
		else{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'error'
			);
			$this->_ajax_return();
		}

		$this->_ajax_return();	
	}
