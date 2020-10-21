<?php //delete me
	function _create_permission_file( $role_id )
	{
		$permission_file_folder = APPPATH . 'config/roles/'. $role_id;
		if( !is_dir( $permission_file_folder ) ){
			$this->load->helper('file');
			mkdir( $permission_file_folder, 0777, TRUE);
			$indexhtml = read_file( APPPATH .'index.html');
            write_file($permission_file_folder. '/index.html', $indexhtml);
		}

		$permission_file = APPPATH . 'config/roles/'. $role_id .'/permission.php';
		$this->load->helper('file');
		
		//get profiles associated profiles
		$profiles = $this->db->get_where('roles_profile', array('role_id' => $role_id));
		$role_permission = array();
		if($profiles->num_rows() > 0)
		{
			foreach( $profiles->result() as $profile )
			{
				$permission = array();
				
				if( !file_exists(APPPATH . 'config/profiles/'. $profile->profile_id .'/permission.php') )
				{
					$this->load->model('profiles_model', 'profiles');
					$this->profiles->_create_permission_file( $profile->profile_id );
				}

				require_once( APPPATH . 'config/profiles/'. $profile->profile_id .'/permission.php' );
				foreach( $permission as $mod_code => $actions )
				{
					foreach( $actions as $action => $grant )
					{
						if( !isset($role_permission[$mod_code][$action]) )
						{
							$role_permission[$mod_code][$action] = $grant;	
						}
						else{
							if( !empty( $grant ) )
							{
								$role_permission[$mod_code][$action] = $grant;	
							}
						}
					}
				}
			}
		}

		$to_write = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');\r\n\r\n";
		$to_write .= "$" . "permission = array();\r\n";

		foreach( $role_permission as $mod_code => $actions )
		{
			foreach( $actions as $action => $grant )
			{
				$to_write .= "$"."permission['{$mod_code}']['{$action}'] = {$grant};\r\n";
			}
		}

		$to_write .= "\r\n$" ."config['permission'] = $". "permission;";
		write_file($permission_file , $to_write);   
	}