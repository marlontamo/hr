<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class ytd_model extends Record
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
		$this->mod_id = 185;
		$this->mod_code = 'ytd';
		$this->route = 'payroll/ytd';
		$this->url = site_url('payroll/ytd');
		$this->primary_key = 'id';
		$this->table = 'payroll_closed_summary';
		$this->icon = '';
		$this->short_name = 'Year To Date';
		$this->long_name  = 'Year To Date';
		$this->description = '';
		$this->path = APPPATH . 'modules/ytd/';

		parent::__construct();
	}
}