<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class specialization_model extends Record
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
		$this->mod_id = 240;
		$this->mod_code = 'specialization';
		$this->route = 'admin/partner/specialization';
		$this->url = site_url('admin/partner/specialization');
		$this->primary_key = 'specialization_id';
		$this->table = 'users_specialization';
		$this->icon = 'fa-edit';
		$this->short_name = 'Specialization';
		$this->long_name  = 'Specialization';
		$this->description = '';
		$this->path = APPPATH . 'modules/specialization/';

		parent::__construct();
	}
}