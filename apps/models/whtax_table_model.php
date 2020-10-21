<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class whtax_table_model extends Record
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
		$this->mod_id = 60;
		$this->mod_code = 'whtax_table';
		$this->route = 'payroll/whtax_table';
		$this->url = site_url('payroll/whtax_table');
		$this->primary_key = 'whtax_id';
		$this->table = 'payroll_whtax_table';
		$this->icon = 'fa-folder';
		$this->short_name = 'Withholding Tax Table';
		$this->long_name  = 'Withholding Tax Table';
		$this->description = '';
		$this->path = APPPATH . 'modules/whtax_table/';

		parent::__construct();
	}
}