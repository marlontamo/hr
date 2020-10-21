<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class pay_set_rates_model extends Record
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
		$this->mod_id = 220;
		$this->mod_code = 'pay_set_rates';
		$this->route = 'admin/partner/paysetrates';
		$this->url = site_url('admin/partner/paysetrates');
		$this->primary_key = 'pay_set_rates_id';
		$this->table = 'users_pay_set_rates';
		$this->icon = 'fa-edit';
		$this->short_name = 'Pay Rates';
		$this->long_name  = 'Pay Rates';
		$this->description = '';
		$this->path = APPPATH . 'modules/pay_set_rates/';

		parent::__construct();
	}
}