<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class group_model extends Record
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
		$this->mod_id = 16;
		$this->mod_code = 'group';
		$this->route = 'admin/group';
		$this->url = site_url('admin/group');
		$this->primary_key = 'group_id';
		$this->table = 'users_group';
		$this->icon = '';
		$this->short_name = 'Group';
		$this->long_name  = 'Group';
		$this->description = 'Group';
		$this->path = APPPATH . 'modules/group/';

		parent::__construct();
	}
}