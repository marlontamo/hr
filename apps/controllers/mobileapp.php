<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MobileApp extends MY_PublicController
{	

	public function login(){
		if( $this->session->userdata('user') )
		{
			$this->session->set_flashdata('flashmessage', array('msg_type' => 'attention', 'msg' => 'You are already logged in.'));
			redirect('');
		}
		
		echo $this->load->blade('loginform')->with( $this->load->get_cached_vars() );
	}

	public function check_credentials()
	{
		$this->_ajax_only();
		$data = json_decode(file_get_contents('php://input'));
		$username = $data->username;
		// $password = $data->password;
		$rememberme = $data->rememberme;
		$this->_check_credentials( $username, $rememberme );
		$this->_ajax_return();
	}

	private function _check_credentials( $username, $rememberme )
	{	
		$this->load->model('authentication_model','auth');
		$this->response->username = $_POST;
		$uname_check = $this->auth->_check_username_exists( $username );
		$api_key = $this->api_key();
		$this->user = false;
		if( $uname_check === TRUE )
		{
			if( $this->user = $this->auth->_try_login_mobile( $username, $api_key ) )
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
				else{
					$user = $this->_get_user_config();
					if( !$this->session->userdata('language') )
					{
						$this->session->set_userdata('language', $user['language']);
					}
					$this->lang->switch_uri( $this->session->userdata('language' ) );
					$this->response->redirect =  $this->session->userdata('language');
				}

				if( $rememberme  )
				{
					$this->session->set_userdata('sess_length',(60*60*24*14));
				}
				$this->session->set_userdata('user', $this->user);
				
				//system logs
				$this->auth->audit_logs($this->user->user_id, $this->auth->mod_code, "login", "login");
				//cannot set it yet, database at this point is indeterminable
			}
			else{
				$this->response->message = array(
					'message' => 'api key did not match.',
					'type' => 'error'
				);
				$this->response->error_field = "password";
			}
		}
		else if( $uname_check === FALSE ){
			$this->response->message = array(
				'message' => 'Username is not registered.',
				'type' => 'error'
			);
			$this->response->error_field = "username";
		}
		else{
			$this->response->message = array(
				'message' => $uname_check,
				'type' => 'error'
			);	
		}
	}

	//function is not defined yet
	//for now return true
	private function api_key(){
		return true;
	}
}