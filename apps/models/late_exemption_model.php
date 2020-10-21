<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class late_exemption_model extends Record
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
		$this->mod_id = 260;
		$this->mod_code = 'late_exemption';
		$this->route = 'admin/time/late_exemption';
		$this->url = site_url('admin/time/late_exemption');
		$this->primary_key = 'payroll_late_exemption_id';
		$this->table = 'payroll_late_exemption';
		$this->icon = 'fa-th-list';
		$this->short_name = 'Late Exemption';
		$this->long_name  = 'Late Exemption';
		$this->description = 'Setup for late exemption for payroll only but with tardiness';
		$this->path = APPPATH . 'modules/late_exemption/';

		parent::__construct();
	}
}