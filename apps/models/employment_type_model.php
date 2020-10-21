<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class employment_type_model extends Record
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
		$this->mod_id = 234;
		$this->mod_code = 'employment_type';
		$this->route = 'admin/partner/type';
		$this->url = site_url('admin/partner/type');
		$this->primary_key = 'employment_type_id';
		$this->table = 'partners_employment_type';
		$this->icon = '';
		$this->short_name = 'Employment Type';
		$this->long_name  = 'Employment Type';
		$this->description = '';
		$this->path = APPPATH . 'modules/employment_type/';

		parent::__construct();
	}
}