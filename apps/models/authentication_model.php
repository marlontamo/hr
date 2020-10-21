<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class Authentication_model extends Record
{
	var $mod_id;
	var $mod_code;
	var $route;
	var $url;
	var $primary_key;
	var $table;
	var $icon;
	var $short_name;
	var $long_name;
	var $description;
	var $path;

	function __construct()
	{
		$this->mod_id = 1;
		$this->mod_code = 'authentication';
		$this->route = 'authentication';
		$this->url = site_url('authentication');
		$this->primary_key = 'user_id';
		$this->table = 'users';
		$this->icon = 'fa-user';
		$this->short_name = 'Authentication';
		$this->long_name = 'Authentication';
		$this->description = '';
		$this->path = APPPATH . 'modules/authentication/';

		parent::__construct();
	}	


	public function _login_check()
	{
		if( !$this->session->userdata('user') ){
			if( IS_AJAX ){
				$this->output->set_status_header('403');
				$this->output->set_output(lang('authentication.access_forbidden'));
				die();
			}
			else
			{
				$this->session->set_userdata('uri_request', $this->uri->uri_string());
				redirect('authentication/login');
			}
		}
		else{
			$user = $this->session->userdata('user');
			$this->db->update('users', array('lastactivity' => time()), array('user_id' => $user->user_id));
			return $user;
		}	
	}

	public function _try_login( $username, $password )
	{
		$this->load->library('phpass');
		$business_groups = array();
		$connected = $this->db->initialize();
		if( $connected )
		{
			$this->db->where('deleted', 0);
			$this->db->where('active', 1);
			$this->db->where( "(login = '{$username}' OR email = '{$username}')" );
			$this->db->select('user_id, hash');
			$user = $this->db->get('users');
			if( $user->num_rows() > 0 )
			{
				$user = $user->row();
				if ($this->phpass->check($password , $user->hash))
				{
					$this->db->limit(1);
					$bg = $this->db->get_where('business_group', array('deleted' => 0, 'db' => 'default'));
					if( $bg->num_rows() == 1 )
					{
						$bg = $bg->row();
						$business_groups['default'] = $bg;
					}
					unset( $user->hash );
					$users['default'] =  $user;
				}				
				//update last_login
				$this->db->update('users', array('last_login' => date('Y-m-d H:i:s')), array('user_id' => $user->user_id));
			}
		}

		$multidb = $this->load->config('multidb', true, true);
		if( $multidb )
		{
			foreach( $multidb as $dbname => $db )
			{
				$new_db = $this->load->database($db, TRUE);
				$connected = $new_db->initialize();
				if( $connected )
				{
					$new_db->where('deleted', 0);
					$new_db->where('active', 1);
					$new_db->where( "(login = '{$username}' OR email = '{$username}')" );
					$new_db->select('user_id, hash');
					$new_db->limit(1);
					$user = $new_db->get('users');

					if( $user->num_rows() == 0 )
						continue;

					$user = $user->row();
					if ($this->phpass->check($password , $user->hash))
					{
						$new_db->limit(1);
						$bg = $new_db->get_where('business_group', array('deleted' => 0, 'db' => $dbname));
						if( $bg->num_rows() == 1 )
						{
							$bg = $bg->row();
							$business_groups[$dbname] = $bg;
						}
						unset( $user->hash );
						$users[$dbname] =  $user;

						//update last_login
						$new_db->update('users', array('last_login' => date('Y-m-d H:i:s')), array('user_id' => $user->user_id));
					}
				}	
			}
		}
		if( isset( $users ) )
		{
			if( !$this->session->userdata('business_group') )
				$this->session->set_userdata('business_group', $business_groups);
			if( !$this->session->userdata('business_user') )
				$this->session->set_userdata('business_user', $users);
			if( !$this->session->userdata('current_db') )
			{
				reset($business_groups);
				$this->session->set_userdata('current_db', key($business_groups));	
			}

			reset($users);
			return $users[key($users)];
		}

		return false;
	}

	public function _try_login_mobile( $username, $api_key )
	{
		$this->load->library('phpass');
		$business_groups = array();
		$connected = $this->db->initialize();
		if( $connected )
		{
			$this->db->where('deleted', 0);
			$this->db->where('active', 1);
			$this->db->where( "(login = '{$username}' OR email = '{$username}')" );
			$this->db->select('user_id, hash');
			$user = $this->db->get('users');
			if( $user->num_rows() > 0 )
			{
				$user = $user->row();
				if ($api_key)
				{
					$this->db->limit(1);
					$bg = $this->db->get_where('business_group', array('deleted' => 0, 'db' => 'default'));
					if( $bg->num_rows() == 1 )
					{
						$bg = $bg->row();
						$business_groups['default'] = $bg;
					}
					unset( $user->hash );
					$users['default'] =  $user;
				}				
				//update last_login
				$this->db->update('users', array('last_login' => date('Y-m-d H:i:s')), array('user_id' => $user->user_id));
			}
		}

		$multidb = $this->load->config('multidb', true, true);
		if( $multidb )
		{
			foreach( $multidb as $dbname => $db )
			{
				$new_db = $this->load->database($db, TRUE);
				$connected = $new_db->initialize();
				if( $connected )
				{
					$new_db->where('deleted', 0);
					$new_db->where('active', 1);
					$new_db->where( "(login = '{$username}' OR email = '{$username}')" );
					$new_db->select('user_id, hash');
					$new_db->limit(1);
					$user = $new_db->get('users');

					if( $user->num_rows() == 0 )
						continue;

					$user = $user->row();
					if ($api_key)
					{
						$new_db->limit(1);
						$bg = $new_db->get_where('business_group', array('deleted' => 0, 'db' => $dbname));
						if( $bg->num_rows() == 1 )
						{
							$bg = $bg->row();
							$business_groups[$dbname] = $bg;
						}
						unset( $user->hash );
						$users[$dbname] =  $user;

						//update last_login
						$new_db->update('users', array('last_login' => date('Y-m-d H:i:s')), array('user_id' => $user->user_id));
					}
				}	
			}
		}
		if( isset( $users ) )
		{
			if( !$this->session->userdata('business_group') )
				$this->session->set_userdata('business_group', $business_groups);
			if( !$this->session->userdata('business_user') )
				$this->session->set_userdata('business_user', $users);
			if( !$this->session->userdata('current_db') )
			{
				reset($business_groups);
				$this->session->set_userdata('current_db', key($business_groups));	
			}

			reset($users);
			return $users[key($users)];
		}

		return false;
	}

	public function _check_username_exists( $username )
	{
		$connected = false;		
		$connected = $this->db->initialize();
		if( $connected )
		{
			$this->db->where('deleted', 0);
			$this->db->where('active', 1);
			$this->db->where( "(login = '{$username}' OR email = '{$username}')" );
			$user = $this->db->get('users');
			if( $user->num_rows() == 1 ) return true;
		}

		$multidb = $this->load->config('multidb', true, true);
		if( $multidb )
		{
			foreach( $multidb as $db )
			{
				$new_db = $this->load->database($db, TRUE);
				$connected = $new_db->initialize();
				if( $connected )
				{
					$new_db->where('deleted', 0);
					$new_db->where('active', 1);
					$new_db->where( "(login = '{$username}' OR email = '{$username}')" );
					$user = $new_db->get('users');
					if( $user->num_rows() == 1 ) return true;
				}	
			}
		}

		if( !$connected )
		{
			return "Cannot connect to database";
		}

		return false;
	}

	function _send_reset_pass( $email )
	{
		$connected = $this->db->initialize();
		if( $connected )
		{
			$this->__send_reset_pass( $email );	
		}

		$multidb = $this->load->config('multidb', true, true);
		if( $multidb )
		{
			foreach( $multidb as $dbname => $db )
			{
				$new_db = $this->load->database($db, TRUE);
				$connected = $new_db->initialize();
				if( $connected )
				{
					$this->db = $new_db;
					$this->__send_reset_pass( $email );
				}	
			}
		}		
	}

	private function __send_reset_pass( $email )
	{
		$this->db->limit(1);
		$user = $this->db->get_where('users', array('email' => $email, 'deleted' => 0, 'active' => 1));
		if( $user->num_rows() == 1 )
			$user = $user->row();
		else
			return;
		
		$this->load->helper('string');
		$this->load->library('phpass');

		$salt = random_string( 'alnum', 8);
		$hash = $this->phpass->hash( $salt );
		
		$data = array(
			'user_id' => $user->user_id,
			'email' => $email,
			'hash' => $hash,
			'link' => site_url('reset_pass?salt='.$salt) 
		);

		$this->db->insert('system_password_request', $data);
	}

	function _reset_pass( $id, $salt )
	{
		$request = $this->db->get_where('system_password_request', array('id' => $id));
		if( $request->num_rows() == 1 )
		{
			$request = $request->row();
			$now = date('Y-m-d H:i:s');
			$now = strtotime($now);
			$expiration = strtotime( $request->expiration );
			
			if( $now > $expiration )
			{
				return array(
					'reset' => false,
					'message' => lang('authentication.reset_expired')
				);
			}

			$this->load->library('phpass');
			
			if( !$this->phpass->check($salt , $request->hash) )
			{
			    return array(
					'reset' => false,
					'message' => lang('authentication.invalid_parametres')
				);  
			}

			$this->load->helper('string');
			$password = random_string( 'alnum', 8);
			$hash = $this->phpass->hash( $password );

			$this->db->update('system_password_request', array('hash' => $hash, 'randomized' => $password, 'confirmed' => 1), array('id' => $id));
			$this->db->update('users', array('hash' => $hash), array('user_id' => $request->user_id));
			return array(
				'reset' => true,
				'message' => lang('authentication.password_sent')
			);

		}
		else{
			echo $this->load->blade('public.pages.request_missing')->with( $this->load->get_cached_vars() );
			return array(
				'reset' => false,
				'message' => lang('authentication.request_missing')
			);
		}
	}

	function change_password( $user_id, $new_password )
	{
		$this->load->library('phpass');
		$hash = $this->phpass->hash( $new_password );

		$previous_data = $this->db->get_where('users', array('user_id' => $user_id))->row();
		$this->db->update('users', array('hash' => $hash), array('user_id' => $user_id));

		$this->audit_logs($user_id, $this->mod_code, "update", "users - hash", $previous_data->hash, $hash);

		if( $this->db->_error_message() != "" )
			return $this->db->_error_message();
		else
			return true;
	}
}
