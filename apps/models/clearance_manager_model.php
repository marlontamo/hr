<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class clearance_manager_model extends Record
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
		$this->mod_id = 160;
		$this->mod_code = 'clearance_manager';
		$this->route = 'admin/clearance_manager';
		$this->url = site_url('admin/clearance_manager');
		$this->primary_key = 'clearance_manager_id';
		$this->table = 'clearance_manager';
		$this->icon = '';
		$this->short_name = 'Clearance Manager';
		$this->long_name  = 'Clearance Manager';
		$this->description = '';
		$this->path = APPPATH . 'modules/clearance_manager/';

		parent::__construct();
	}
}