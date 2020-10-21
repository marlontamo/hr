<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class loan_type_model extends Record
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
		$this->mod_id = 51;
		$this->mod_code = 'loan_type';
		$this->route = 'payroll/loan_types';
		$this->url = site_url('payroll/loan_types');
		$this->primary_key = 'loan_type_id';
		$this->table = 'payroll_loan_type';
		$this->icon = 'fa-folder';
		$this->short_name = 'Loan Types';
		$this->long_name  = 'Loan Types';
		$this->description = '';
		$this->path = APPPATH . 'modules/loan_type/';

		parent::__construct();
	}
}