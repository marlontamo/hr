<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class performance_master_model extends Record
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
		$this->mod_id = 113;
		$this->mod_code = 'performance_master';
		$this->route = 'admin/performance_master';
		$this->url = site_url('admin/performance_master');
		$this->primary_key = 'template_id';
		$this->table = 'performance_template';
		$this->icon = '';
		$this->short_name = 'Performance Admin';
		$this->long_name  = 'Performance';
		$this->description = 'contents and setup';
		$this->path = APPPATH . 'modules/performance_master/';

		parent::__construct();
	}
}