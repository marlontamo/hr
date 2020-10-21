<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class job_title_model extends Record
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
		$this->mod_id = 35;
		$this->mod_code = 'job_title';
		$this->route = 'admin/user/jobtitle';
		$this->url = site_url('admin/user/jobtitle');
		$this->primary_key = 'job_title_id';
		$this->table = 'users_job_title';
		$this->icon = '';
		$this->short_name = 'Job Title';
		$this->long_name  = 'Job Title';
		$this->description = '';
		$this->path = APPPATH . 'modules/job_title/';

		parent::__construct();
	}
}