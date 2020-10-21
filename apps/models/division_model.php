<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class division_model extends Record
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
		$this->mod_id = 25;
		$this->mod_code = 'division';
		$this->route = 'admin/division';
		$this->url = site_url('admin/division');
		$this->primary_key = 'division_id';
		$this->table = 'users_division';
		$this->icon = '';
		$this->short_name = 'Division';
		$this->long_name  = 'Division';
		$this->description = '';
		$this->path = APPPATH . 'modules/division/';

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
}