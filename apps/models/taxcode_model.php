<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class taxcode_model extends Record
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
		$this->mod_id = 63;
		$this->mod_code = 'taxcode';
		$this->route = 'payroll/taxcode';
		$this->url = site_url('payroll/taxcode');
		$this->primary_key = 'taxcode_id';
		$this->table = 'taxcode';
		$this->icon = 'fa-folder';
		$this->short_name = 'Tax Code';
		$this->long_name  = 'Tax Code';
		$this->description = '';
		$this->path = APPPATH . 'modules/taxcode/';

		parent::__construct();
	}
}