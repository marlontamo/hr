<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class account_type_model extends Record
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
		$this->mod_id = 54;
		$this->mod_code = 'account_type';
		$this->route = 'payroll/account_type';
		$this->url = site_url('payroll/account_type');
		$this->primary_key = 'account_type_id';
		$this->table = 'payroll_account_type';
		$this->icon = 'fa-file-text-o';
		$this->short_name = 'Account Type';
		$this->long_name  = 'Account Type';
		$this->description = '';
		$this->path = APPPATH . 'modules/account_type/';

		parent::__construct();
	}
}