<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class department_model extends Record
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
		$this->mod_id = 34;
		$this->mod_code = 'department';
		$this->route = 'admin/user/department';
		$this->url = site_url('admin/user/department');
		$this->primary_key = 'department_id';
		$this->table = 'users_department';
		$this->icon = '';
		$this->short_name = 'Department';
		$this->long_name  = 'Department';
		$this->description = '';
		$this->path = APPPATH . 'modules/department/';

		parent::__construct();
	}

	public function get_user_details($user_id=0)
	{
		$this->db->join('users_profile','users_profile.user_id = users.user_id','left');
		$this->db->join('users_position','users_position.position_id = users_profile.position_id','left');
		$this->db->where('users.user_id',$user_id);
		$user_details = $this->db->get('users');
	    return $user_details->row();
	}

	function get_depthead( $department_id )
	{
		$this->db->limit(1);
		$dept = $this->db->get_where( $this->table, array( $this->primary_key => $department_id ) )->row();
		return $dept->immediate;
	}
}