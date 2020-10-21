<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MobileApp extends MY_publicController{
	
	public function __construct(){

		$this->load->model('mobileapp_model', 'mod');
		parent::__construct();
		$this->db->initialize();
		$this->lang->load( 'authentication' );
	}

	public function get_check_credentials(){
		$this->_ajax_only();
		$this->_get_check_credentials( $this->input->post('username'), $this->input->post('password'), $this->input->post('rememberme') );
		if( $this->user ){

			$this->response->user = $this->_get_user_config();
			
		}
		$this->_ajax_return();
	}

	public function check_credentials(){

		$this->_ajax_only();
		$data = json_decode(file_get_contents('php://input'));
		$username = $data->username;
		$password = $data->password;
		$rememberme = $data->rememberme;
		$this->_get_check_credentials( $username, $password, $rememberme );
		$this->_ajax_return();

	}

	private function _get_check_credentials( $username, $password, $rememberme ){
		$this->response->username = $_POST;
		$uname_check = $this->mod->_check_username_exists( $username );
		$this->user = false;
		if( $uname_check === TRUE )
		{
			if( $this->user = $this->mod->_try_login( $username, $password ) )
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
				//$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, "login", "login");
				//cannot set it yet, database at this point is indeterminable
			}else{

				$this->response->message = array(
					'message' => 'Password did not match.',
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

		}else{

			$this->response->message = array(
				'message' => $uname_check,
				'type' => 'error'
			);	

		}
	}

	public function logout(){

		if( $this->session->userdata('user') )
		{
			$this->user = $this->mod->_login_check();
			$this->db->update('users', array('lastactivity' => 0), array('user_id' => $this->user->user_id) );
		}	
		$this->session->unset_userdata('user');
		$this->session->sess_destroy();

		//system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, "logout", "logout");
		
		if( $this->input->post('mobileapp') ){

			$this->response->message = array(
				'message' => '',
				'type' => 'success'
			);
			$this->_ajax_return();
			
		}else
		
			redirect('login');
	}

}