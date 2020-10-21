<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class bank_settings_model extends Record
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
		$this->mod_id = 235;
		$this->mod_code = 'bank_settings';
		$this->route = 'payroll/bank_settings';
		$this->url = site_url('payroll/bank_settings');
		$this->primary_key = 'bank_id';
		$this->table = 'payroll_bank';
		$this->icon = 'fa-file-text-o';
		$this->short_name = 'Bank Settings';
		$this->long_name  = 'Bank Settings';
		$this->description = '';
		$this->path = APPPATH . 'modules/bank_settings/';

		parent::__construct();
	}
}