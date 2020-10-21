<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class overtime_rates_fixed_amount_model extends Record
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
		$this->mod_id = 259;
		$this->mod_code = 'overtime_rates_fixed_amount';
		$this->route = 'admin/payroll/overtime_rates_fixed_amount';
		$this->url = site_url('admin/payroll/overtime_rates_fixed_amount');
		$this->primary_key = 'overtime_rate_amount_id';
		$this->table = 'payroll_overtime_rates_amount';
		$this->icon = '';
		$this->short_name = 'Overtime Rates Fixed Amount';
		$this->long_name  = 'Overtime Rates Fixed Amount';
		$this->description = 'Setup of Overtime Fixed Amount Base on Payroll Location';
		$this->path = APPPATH . 'modules/overtime_rates_fixed_amount/';

		parent::__construct();
	}
}