<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class phic_table_model extends Record
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
		$this->mod_id = 62;
		$this->mod_code = 'phic_table';
		$this->route = 'payroll/phic_table';
		$this->url = site_url('payroll/phic_table');
		$this->primary_key = 'phic_id';
		$this->table = 'payroll_phic_table';
		$this->icon = 'fa-folder';
		$this->short_name = 'PHIC Table';
		$this->long_name  = 'PHIC Table';
		$this->description = '';
		$this->path = APPPATH . 'modules/phic_table/';

		parent::__construct();
	}
}