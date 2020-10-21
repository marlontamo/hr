<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class rate_type_model extends Record
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
		$this->mod_id = 53;
		$this->mod_code = 'rate_type';
		$this->route = 'payroll/rate_types';
		$this->url = site_url('payroll/rate_types');
		$this->primary_key = 'payroll_rate_type_id';
		$this->table = 'payroll_rate_type';
		$this->icon = 'fa-pencil-square-o';
		$this->short_name = 'Rate Type';
		$this->long_name  = 'Rate Type';
		$this->description = '';
		$this->path = APPPATH . 'modules/rate_type/';

		parent::__construct();
	}
}