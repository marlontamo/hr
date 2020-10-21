<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class users_model extends Record
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

	public function __construct()
	{
		$this->mod_id = 2;
		$this->mod_code = 'users';
		$this->route = 'admin/users';
		$this->url = site_url('admin/users');
		$this->primary_key = 'user_id';
		$this->table = 'users';
		$this->icon = 'fa-user';
		$this->short_name = 'Users';
		$this->long_name  = 'Users';
		$this->description = 'manage and list application users. ';
		$this->path = APPPATH . 'modules/users/';

		parent::__construct();
	}

	function _create_config( $user_id )
	{
		$userconfig_currentdbpath = APPPATH . 'config/'.$this->session->userdata('current_db');
		$userconfig_filepath = $userconfig_currentdbpath.'/users';
		$userconfig_file = $userconfig_filepath .'/'. $user_id .'.php';
		if (!is_dir($userconfig_currentdbpath)) {
            mkdir($userconfig_currentdbpath, 0755, true);
            copy(APPPATH .'index.html', $userconfig_currentdbpath.'/index.html');
        }
        if (!is_dir($userconfig_filepath)) {
            mkdir($userconfig_filepath, 0755, true);
            copy(APPPATH .'index.html', $userconfig_filepath.'/index.html');
        }

		$this->load->helper('file');
		
		$to_write = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');\r\n\r\n";
		$qry = "SELECT get_sensitivity(a.role_id) as sensitivity, a.role_id, b.business_level_id, a.language, a.login, a.email, a.timezone, b.lastname, b.firstname, b.middlename, b.suffix, b.photo
		FROM {$this->db->dbprefix}users a
		LEFT JOIN {$this->db->dbprefix}users_profile b on b.user_id = a.user_id
		WHERE a.user_id = {$user_id}";

		$user = $this->db->query( $qry )->row();
		$this->db->limit(1);
		$profile = $this->db->get_where('users_profile', array('user_id' => $user_id))->row();
		$region_companies[] = $profile->company_id;
		
		switch($user->business_level_id)
		{
			case 2: //group
				$this->db->limit(1);
				$company = $this->db->get_where('users_company', array('company_id' => $profile->company_id))->row();
				$companies = $this->db->get_where('users_company', array('deleted' => 0, 'business_group_id' => $company->business_group_id, 'company_id !=' => $company->company_id ));
				foreach( $companies->result() as $comp )
					$region_companies[] = $comp->company_id;
				break;
			case 3: //region
				$this->db->limit(1);
				$company = $this->db->get_where('users_company', array('company_id' => $profile->company_id))->row();
				$this->db->limit(1);
				$group = $this->db->get_where('business_group', array('group_id' => $company->business_group_id))->row();
				$groups = $this->db->get_where('business_group', array('region_id' => $group->region_id));
				foreach($groups->result() as $group)
				{
					$companies = $this->db->get_where('users_company', array('deleted' => 0, 'business_group_id' => $group->group_id, 'company_id !=' => $company->company_id ));
					foreach( $companies->result() as $comp )
						$region_companies[] = $comp->company_id;
				}
				break;
			case 4:
				$companies = $this->db->get_where('users_company', array('deleted' => 0, 'company_id !=' => $company->company_id ));
				foreach( $companies->result() as $comp )
					$region_companies[] = $comp->company_id;
				break;
		}
		$region_companies = implode(',', $region_companies);


		$to_write .= "$"."config['user']['user_id'] = {$user_id};\r\n";
		$to_write .= "$"."config['user']['role_id'] = {$user->role_id};\r\n";
		$to_write .= "$"."config['user']['sensitivity'] = '{$user->sensitivity}';\r\n";
		$to_write .= "$"."config['user']['region_companies'] = '{$region_companies}';\r\n";
		$to_write .= "$"."config['user']['language'] = '{$user->language}';\r\n";
		$to_write .= "$"."config['user']['username'] = '{$user->login}';\r\n";
		$to_write .= "$"."config['user']['email'] = '{$user->email}';\r\n";
	   	$to_write .= "$"."config['user']['firstname'] = \"{$user->firstname}\";\r\n";
	   	$to_write .= "$"."config['user']['lastname'] = \"{$user->lastname}\";\r\n";
	   	$to_write .= "$"."config['user']['middlename'] = \"{$user->middlename}\";\r\n";
	   	$to_write .= "$"."config['user']['suffix'] = \"{$user->suffix}\";\r\n";
	   	$to_write .= "$"."config['user']['photo'] = '{$user->photo}';\r\n";
	   	$to_write .= "$"."config['user']['timezone'] = '{$user->timezone}';\r\n";

		write_file($userconfig_file , $to_write);
	}

	function _get_user_preview($id){

		$data = new stdClass();

		$qry = "SELECT 
					`up`.`user_id`, 
					CONCAT(`up`.`firstname`, ' ', `up`.`middlename`, ' ', `up`.`lastname`) AS `user_name`, 
					`upos`.`position`,
					`up`.`company`,
					`up`.`photo`,
					`u`.`email` 
				FROM (
					(`users_profile` `up` JOIN `users_position` `upos`)
					JOIN `users` `u`
				)

				WHERE 
					`up`.`position_id` = `upos`.`position_id`
					AND `u`.`user_id` = `up`.`user_id`
					AND `up`.`user_id` = '$id' 
					LIMIT 1";

		$result = $this->db->query($qry);

		if ($result->num_rows() > 0)
			$data 	= $result->row();

		else
			return false;

		return $data;
	}

	function _get_user_contacts($id){

		$data = array();

		$qry = "SELECT `ucc`.`contacts_id`, `ucc`.`contact_type`, `ucc`.`contact_no`
				FROM (`ww_users_company_contact` `ucc` JOIN `ww_users_profile` `up`)
				WHERE `ucc`.`company_id` = `up`.`company_id`
				AND `up`.`user_id` = '$id'";

		$result = $this->db->query($qry);
		
		if ($result->num_rows() > 0){

			foreach( $result->result_array() as $contact ){

				$data[] = $contact;
			}
		}

		return $data;
	}

	function chat_users()
	{
		$qry = "SELECT a.user_id, a.full_name, a.email, a.lastactivity, b.photo
		FROM `users` a
		JOIN `users_profile` b ON b.user_id = a.user_id
		WHERE a.active = 1 and a.role_id <> 1
		ORDER BY a.lastactivity DESC, a.full_name ASC";
		$users = $this->db->query( $qry );
		if( $users->num_rows() > 0 )
		{
			$image_dir_thumb = FCPATH.'uploads/users/thumbnail/';
			$image_dir_full  = FCPATH.'uploads/users/';

			$chat_users = array();
			foreach( $users->result() as $user )
			{
				$avatar = basename(base_url( $user->photo ));

    			$file_name_thumbnail = urldecode($image_dir_thumb . $avatar);
        		$file_name_full = urldecode($image_dir_full . $avatar);

		        if(file_exists($file_name_thumbnail)){
					$file_name_full = "uploads/users/" . $avatar;
		            $avatar = "uploads/users/thumbnail/" . $avatar;
		        }
		        else if(file_exists($file_name_full)){
		            $avatar = "uploads/users/" . $avatar;
					$file_name_full = $avatar;
		        }
		        else{
		            $avatar = "uploads/users/avatar.png";
					$file_name_full = $avatar;
		        }

		        $user->photo = $avatar;

				$now = time();
				$activity = ( $now - $user->lastactivity ) / 60;
				switch( true )
				{
					case empty( $user->lastactivity):
						$user->status = "offline";
						break;
					case $activity <= 5:
						$user->status = "online";
						break; 
					case $activity > 5:
						$user->status = 'idle';
						break;
					/*case $activity > 5 && $activity <= 10:
						$user->status = 'idle';
						break; 
					case $activity > 10 && $activity <= 20:
						$user->status = 'idle10';
						break; 
					case $activity > 20:
						$user->status = 'idle20';
						break; */
				}
				$chat_users[]= $user;
			}
			return $chat_users;
		}

		return false;
	}

	function seen_pm( $from )
	{
		$this->db->update('system_chat', array('seen' => 1), array('from' => $from, 'to' => $this->user->user_id));
	}

	function send_pm( $to, $message )
	{
		$insert = array(
			'to' => $to,
			'from' => $this->user->user_id,
			'message' => $message
		);
		$this->db->insert('system_chat', $insert);
	}

	function get_recent_pm( $from )
	{
		$qry = "select *, gettimeline(`time`) as timeline
		FROM {$this->db->dbprefix}system_chat
		WHERE (`from` = '{$from}' AND `to` = '{$this->user->user_id}') OR (`to` = '{$from}' AND `from` = '{$this->user->user_id}')
		ORDER BY `time` desc LIMIT 10";
		$messages = $this->db->query( $qry );

		if( $messages->num_rows() > 0 )
			return $messages->result_array();
		else
			return false;
	}
}