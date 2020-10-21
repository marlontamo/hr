<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class roles_model extends Record
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
		$this->mod_id = 4;
		$this->mod_code = 'roles';
		$this->route = 'admin/roles';
		$this->url = site_url('admin/roles');
		$this->primary_key = 'role_id';
		$this->table = 'roles';
		$this->icon = 'fa-key';
		$this->short_name = 'Roles';
		$this->long_name  = 'Roles';
		$this->description = 'Manage permissions to a module.';
		$this->path = APPPATH . 'modules/roles/';

		parent::__construct();
	}

	function _get_list($start, $limit, $search, $filter, $trash = false)
	{
		$data = array();				
		
		$qry = $this->_get_list_cached_query();
		
		if( $trash )
		{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 1";
		}
		else{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 0";	
		}

		$role = $this->config->item('user');
		$roleid = $role['role_id'];
		
		if( $roleid <> 1)
			$qry .= " AND {$this->db->dbprefix}{$this->table}.role_id <> {$roleid} ";
		
		$qry .= ' '. $filter;
        $qry .= " ORDER BY {$this->db->dbprefix}{$this->table}.role_id ";
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	function _create_permission_file( $role_id )
	{
		$current_db_config_path = APPPATH . 'config/'.$this->session->userdata('current_db');
		if( !is_dir( $current_db_config_path ) ){
			$this->load->helper('file');
			mkdir( $current_db_config_path, 0777, TRUE);
			$indexhtml = read_file( APPPATH .'index.html');
            write_file($current_db_config_path. '/index.html', $indexhtml);
		}
		$permission_filepath = $current_db_config_path .'/roles';
		if( !is_dir( $permission_filepath ) ){
			$this->load->helper('file');
			mkdir( $permission_filepath, 0777, TRUE);
			$indexhtml = read_file( APPPATH .'index.html');
            write_file($permission_filepath. '/index.html', $indexhtml);
		}
		$permission_file_folder = $permission_filepath .'/'. $role_id;
		if( !is_dir( $permission_file_folder ) ){
			$this->load->helper('file');
			mkdir( $permission_file_folder, 0777, TRUE);
			$indexhtml = read_file( APPPATH .'index.html');
            write_file($permission_file_folder. '/index.html', $indexhtml);
		}

		$permission_file = $permission_file_folder . '/permission.php';
		$this->load->helper('file');
		
		//get profiles associated profiles
		$profiles = $this->db->get_where('roles_profile', array('role_id' => $role_id));
		$role_permission = array();
		if($profiles->num_rows() > 0)
		{
			foreach( $profiles->result() as $profile )
			{
				$permission = array();
				
				if( !file_exists($current_db_config_path .'/profiles/'. $profile->profile_id .'/permission.php') )
				{
					$this->load->model('profiles_model', 'profiles');
					$this->profiles->_create_permission_file( $profile->profile_id );
				}

				require_once( $current_db_config_path .'/profiles/'. $profile->profile_id .'/permission.php' );
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
}