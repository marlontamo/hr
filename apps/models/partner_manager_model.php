<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class partner_manager_model extends Record
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
		$this->mod_id = 219;
		$this->mod_code = 'partner_manager';
		$this->route = 'admin/partner/manager';
		$this->url = site_url('admin/partner/manager');
		$this->primary_key = '1';
		$this->table = '1';
		$this->icon = '';
		$this->short_name = 'Partner Manager';
		$this->long_name  = 'Partner Manager';
		$this->description = 'partner management and configuration section.';
		$this->path = APPPATH . 'modules/partner_manager/';

		parent::__construct();
	}
}