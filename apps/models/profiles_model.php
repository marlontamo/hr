<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class profiles_model extends Record
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
		$this->mod_id = 3;
		$this->mod_code = 'profiles';
		$this->route = 'admin/permissions';
		$this->url = site_url('admin/permissions');
		$this->primary_key = 'profile_id';
		$this->table = 'profiles';
		$this->icon = 'fa-gear';
		$this->short_name = 'Data Access and Permissions';
		$this->long_name  = 'Data Access and Permissions';
		$this->description = '';
		$this->path = APPPATH . 'modules/profiles/';

		parent::__construct();
	}

	function _create_permission_file( $profile_id )
	{
		$current_db_config_path = APPPATH . 'config/'.$this->session->userdata('current_db');
		if( !is_dir( $current_db_config_path ) ){
			$this->load->helper('file');
			mkdir( $current_db_config_path, 0777, TRUE);
			$indexhtml = read_file( APPPATH .'index.html');
            write_file($current_db_config_path. '/index.html', $indexhtml);
		}
		$permission_filepath = $current_db_config_path .'/profiles';
		if( !is_dir( $permission_filepath ) ){
			$this->load->helper('file');
			mkdir( $permission_filepath, 0777, TRUE);
			$indexhtml = read_file( APPPATH .'index.html');
            write_file($permission_filepath. '/index.html', $indexhtml);
		}
		$permission_file_folder = $permission_filepath .'/'. $profile_id;
		if( !is_dir( $permission_file_folder ) ){
			$this->load->helper('file');
			mkdir( $permission_file_folder, 0777, TRUE);
			$indexhtml = read_file( APPPATH .'index.html');
            write_file($permission_file_folder. '/index.html', $indexhtml);
		}

		// debug($permission_file_folder);die();

		$permission_file = $permission_file_folder .'/permission.php';
		$this->load->helper('file');

		//delete affected roles
		$roles = $this->db->get_where('roles_profile', array('profile_id' => $profile_id));
		foreach( $roles->result() as $role )
		{
			$permission_file_roles = $current_db_config_path .'/roles/'. $role->role_id .'/permission.php';
			if( file_exists($permission_file_roles) ){
				unlink( $permission_file_roles );
			}	
		}
		
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

		 
	}
}