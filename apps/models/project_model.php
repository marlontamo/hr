<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class project_model extends Record
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
		$this->mod_id = 239;
		$this->mod_code = 'project';
		$this->route = 'admin/project';
		$this->url = site_url('admin/project');
		$this->primary_key = 'project_id';
		$this->table = 'users_project';
		$this->icon = '';
		$this->short_name = 'Project';
		$this->long_name  = 'Project';
		$this->description = 'Manage and list project names';
		$this->path = APPPATH . 'modules/project/';

		parent::__construct();
	}
}