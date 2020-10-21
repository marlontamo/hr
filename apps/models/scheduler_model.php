<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class scheduler_model extends Record
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
		$this->mod_id = 252;
		$this->mod_code = 'scheduler';
		$this->route = 'admin/scheduler';
		$this->url = site_url('admin/scheduler');
		$this->primary_key = 'scheduler_id';
		$this->table = 'scheduler';
		$this->icon = '';
		$this->short_name = 'Scheduler';
		$this->long_name  = 'Scheduler';
		$this->description = '';
		$this->path = APPPATH . 'modules/scheduler/';

		parent::__construct();
	}
}