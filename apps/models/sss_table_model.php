<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class sss_table_model extends Record
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
		$this->mod_id = 61;
		$this->mod_code = 'sss_table';
		$this->route = 'payroll/sss_table';
		$this->url = site_url('payroll/sss_table');
		$this->primary_key = 'sss_id';
		$this->table = 'payroll_sss_table';
		$this->icon = 'fa-folder';
		$this->short_name = 'SSS Table';
		$this->long_name  = 'SSS Table';
		$this->description = '';
		$this->path = APPPATH . 'modules/sss_table/';

		parent::__construct();
	}
}