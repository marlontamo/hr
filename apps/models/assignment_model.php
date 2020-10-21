<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class assignment_model extends Record
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
		$this->mod_id = 232;
		$this->mod_code = 'assignment';
		$this->route = 'admin/assignment';
		$this->url = site_url('admin/assignment');
		$this->primary_key = 'assignment_id';
		$this->table = 'users_assignment';
		$this->icon = 'fa-edit';
		$this->short_name = 'Assignment';
		$this->long_name  = 'Assignment';
		$this->description = '';
		$this->path = APPPATH . 'modules/assignment/';

		parent::__construct();
	}
}