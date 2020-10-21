<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class employment_status_model extends Record
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
		$this->mod_id = 40;
		$this->mod_code = 'employment_status';
		$this->route = 'admin/partner/status';
		$this->url = site_url('admin/partner/status');
		$this->primary_key = 'employment_status_id';
		$this->table = 'partners_employment_status';
		$this->icon = '';
		$this->short_name = 'Employment Status';
		$this->long_name  = 'Employment Status';
		$this->description = 'Employment Status';
		$this->path = APPPATH . 'modules/employment_status/';

		parent::__construct();
	}
}