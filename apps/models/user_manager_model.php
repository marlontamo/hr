<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class user_manager_model extends Record
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
		$this->mod_id = 23;
		$this->mod_code = 'user_manager';
		$this->route = 'admin/user/manager';
		$this->url = site_url('admin/user/manager');
		$this->primary_key = '1';
		$this->table = '1';
		$this->icon = '';
		$this->short_name = 'User Manager';
		$this->long_name  = 'User Manager';
		$this->description = 'user management and configuration section.';
		$this->path = APPPATH . 'modules/user_manager/';

		parent::__construct();
	}

	function getUserManagerList(){ 

		$data = array();

		$qry = "SELECT  
					mod_id, route, short_name, icon, description
				FROM ww_modules
				WHERE mod_id IN ('10', '25', ' 34', '16', '33', '35', '2')
				AND deleted = '0'"; 
		
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
			
			$data['count'] = $result->num_rows();

			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}
}