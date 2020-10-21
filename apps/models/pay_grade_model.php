<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class pay_grade_model extends Record
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
		$this->mod_id = 217;
		$this->mod_code = 'pay_grade';
		$this->route = 'admin/partner/paygrade';
		$this->url = site_url('admin/partner/paygrade');
		$this->primary_key = 'pay_level_id';
		$this->table = 'users_job_pay_level';
		$this->icon = 'fa-edit';
		$this->short_name = 'Pay Grade';
		$this->long_name  = 'Pay Grade';
		$this->description = '';
		$this->path = APPPATH . 'modules/pay_grade/';

		parent::__construct();
	}
}