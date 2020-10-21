<?php //delete me
	function _create_config( $user_id )
	{
		$userconfig_file = APPPATH . 'config/users/'. $user_id .'.php';
		$this->load->helper('file');
		
		$to_write = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');\r\n\r\n";
		$qry = "SELECT a.role_id, a.login, a.email, b.lastname, b.firstname, b.middlename
		FROM {$this->db->dbprefix}users a
		LEFT JOIN {$this->db->dbprefix}users_profile b on b.user_id = a.user_id
		WHERE a.user_id = {$user_id}";

		$user = $this->db->query( $qry )->row();
		
		$to_write .= "$"."config['user']['user_id'] = {$user_id};\r\n";
		$to_write .= "$"."config['user']['role_id'] = {$user->role_id};\r\n";
		$to_write .= "$"."config['user']['username'] = '{$user->login}';\r\n";
		$to_write .= "$"."config['user']['email'] = '{$user->email}';\r\n";
	   	$to_write .= "$"."config['user']['firstname'] = '{$user->firstname}';\r\n";
	   	$to_write .= "$"."config['user']['lastname'] = '{$user->lastname}';\r\n";
	   	$to_write .= "$"."config['user']['middlename'] = '{$user->middlename}';\r\n";

		write_file($userconfig_file , $to_write);
	}