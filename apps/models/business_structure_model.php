<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class business_structure_model extends Record
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
		$this->mod_id = 135;
		$this->mod_code = 'business_structure';
		$this->route = 'admin/business_structure';
		$this->url = site_url('admin/business_structure');
		$this->primary_key = 'region_id';
		$this->table = 'business_reqion';
		$this->icon = 'fa-folder';
		$this->short_name = 'Business Structure';
		$this->long_name  = 'Business Structure';
		$this->description = '';
		$this->path = APPPATH . 'modules/business_structure/';

		parent::__construct();
	}
}