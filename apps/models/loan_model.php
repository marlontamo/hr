<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class loan_model extends Record
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
		$this->mod_id = 52;
		$this->mod_code = 'loan';
		$this->route = 'payroll/loans';
		$this->url = site_url('payroll/loans');
		$this->primary_key = 'loan_id';
		$this->table = 'payroll_loan';
		$this->icon = 'fa-folder';
		$this->short_name = 'Loans';
		$this->long_name  = 'Loans';
		$this->description = '';
		$this->path = APPPATH . 'modules/loan/';

		parent::__construct();
	}
}