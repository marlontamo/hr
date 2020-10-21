<?php //delete me
	function _create_permission_file( $profile_id )
	{
		$permission_file_folder = APPPATH . 'config/profiles/'. $profile_id;
		if( !is_dir( $permission_file_folder ) ){
			$this->load->helper('file');
			mkdir( $permission_file_folder, 0777, TRUE);
			$indexhtml = read_file( APPPATH .'index.html');
            write_file($permission_file_folder. '/index.html', $indexhtml);
		}

		$permission_file = APPPATH . 'config/profiles/'. $profile_id .'/permission.php';
		$this->load->helper('file');
		
		$to_write = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');\r\n\r\n";
		$to_write .= "$" . "permission = array();\r\n";

		$qry = "SELECT a.profile_id, b.mod_code, c.action, a.grant
		FROM {$this->db->dbprefix}profiles_permission a
		LEFT JOIN {$this->db->dbprefix}modules b on b.mod_id = a.mod_id
		LEFT JOIN {$this->db->dbprefix}modules_actions c on c.action_id = a.action_id
		WHERE a.profile_id = {$profile_id}";

		$permissions = $this->db->query( $qry );
		foreach( $permissions->result() as $permission )
		{
			if( !empty($permission->mod_code) && !empty($permission->action) )
				$to_write .= "$"."permission['{$permission->mod_code}']['{$permission->action}'] = {$permission->grant};\r\n";
		}

		$to_write .= "\r\n$" ."config['permission'] = $". "permission;";
		write_file($permission_file , $to_write); 

		//delete affected roles
		$roles = $this->db->get_where('roles_profile', array('profile_id' => $profile_id));
		foreach( $roles->result() as $role )
		{
			$permission_file = APPPATH . 'config/roles/'. $role->role_id .'/permission.php';
			if( file_exists($permission_file) )
				unlink( $permission_file );
		} 
	}
	