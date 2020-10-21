<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class location_model extends Record
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
		$this->mod_id = 231;
		$this->mod_code = 'location';
		$this->route = 'admin/user/location';
		$this->url = site_url('admin/user/location');
		$this->primary_key = 'location_id';
		$this->table = 'users_location';
		$this->icon = 'fa-edit';
		$this->short_name = 'Location';
		$this->long_name  = 'Location';
		$this->description = '';
		$this->path = APPPATH . 'modules/location/';

		parent::__construct();
	}
}