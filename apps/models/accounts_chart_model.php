<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class accounts_chart_model extends Record
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
		$this->mod_id = 55;
		$this->mod_code = 'accounts_chart';
		$this->route = 'payroll/accounts_chart';
		$this->url = site_url('payroll/accounts_chart');
		$this->primary_key = 'account_id';
		$this->table = 'payroll_account';
		$this->icon = 'fa-copy';
		$this->short_name = 'Chart of Accounts';
		$this->long_name  = 'Chart of Accounts';
		$this->description = '';
		$this->path = APPPATH . 'modules/accounts_chart/';

		parent::__construct();
	}
}