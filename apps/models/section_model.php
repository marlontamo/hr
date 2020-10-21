<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class section_model extends Record
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
		$this->mod_id = 237;
		$this->mod_code = 'section';
		$this->route = 'admin/section';
		$this->url = site_url('admin/section');
		$this->primary_key = 'section_id';
		$this->table = 'users_section';
		$this->icon = '';
		$this->short_name = 'Section';
		$this->long_name  = 'Section';
		$this->description = 'Manage and list section names';
		$this->path = APPPATH . 'modules/section/';

		parent::__construct();
	}
}