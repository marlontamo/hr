<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class branch_model extends Record
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
		$this->mod_id = 251;
		$this->mod_code = 'branch';
		$this->route = 'admin/branch';
		$this->url = site_url('admin/branch');
		$this->primary_key = 'branch_id';
		$this->table = 'users_branch';
		$this->icon = '';
		$this->short_name = 'Branch';
		$this->long_name  = 'Branch';
		$this->description = '';
		$this->path = APPPATH . 'modules/branch/';

		parent::__construct();
	}
}