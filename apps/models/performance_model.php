<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class performance_model extends Record
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
		$this->mod_id = 104;
		$this->mod_code = 'performance';
		$this->route = 'admin/performance';
		$this->url = site_url('admin/performance');
		$this->primary_key = 'performance_id';
		$this->table = 'performance_setup_performance';
		$this->icon = '';
		$this->short_name = 'Performance Type';
		$this->long_name  = 'Performance Type';
		$this->description = '';
		$this->path = APPPATH . 'modules/performance/';

		parent::__construct();
	}
}