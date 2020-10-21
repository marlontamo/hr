<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class payroll_company_model extends Record
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
		$this->mod_id = 56;
		$this->mod_code = 'payroll_company';
		$this->route = 'payroll/companies';
		$this->url = site_url('payroll/companies');
		$this->primary_key = 'company_id';
		$this->table = 'users_company';
		$this->icon = '';
		$this->short_name = 'Company';
		$this->long_name  = 'Payroll Company';
		$this->description = '';
		$this->path = APPPATH . 'modules/payroll_company/';

		parent::__construct();
	}
}