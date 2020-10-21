<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class permission_model extends Record
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
		$this->mod_code = 'permission';
		$this->route = 'admin/permissions';
		$this->url = site_url('admin/permissions');
		$this->primary_key = 'profile_id';
		$this->table = 'profie';
		$this->icon = 'fa-key';
		$this->short_name = 'Roles';
		$this->long_name  = 'Roles';
		$this->description = 'Manage permissions to a module.';
		$this->path = APPPATH . 'modules/permission/';

		parent::__construct();
	}
}