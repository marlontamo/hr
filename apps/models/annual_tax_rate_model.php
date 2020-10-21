<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class annual_tax_rate_model extends Record
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
		$this->mod_id = 59;
		$this->mod_code = 'annual_tax_rate';
		$this->route = 'payroll/annual_tax_rates';
		$this->url = site_url('payroll/annual_tax_rates');
		$this->primary_key = 'annual_tax_id';
		$this->table = 'payroll_annual_tax';
		$this->icon = 'fa-money';
		$this->short_name = 'Annual Tax Rates';
		$this->long_name  = 'Annual Tax Rates';
		$this->description = '';
		$this->path = APPPATH . 'modules/annual_tax_rate/';

		parent::__construct();
	}
}