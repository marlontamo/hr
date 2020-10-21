<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class recruitment_masters_model extends Record
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
		$this->mod_id = 118;
		$this->mod_code = 'recruitment_masters';
		$this->route = 'admin/recruitment';
		$this->url = site_url('admin/recruitment');
		$this->primary_key = 'recruit_id';
		$this->table = 'recruits';
		$this->icon = 'fa-folder';
		$this->short_name = 'Recruitment Masters ';
		$this->long_name  = 'Recruitment';
		$this->description = 'contents and setup';
		$this->path = APPPATH . 'modules/recruitment_masters/';

		parent::__construct();
	}
}