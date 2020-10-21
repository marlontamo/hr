<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class job_grade_model extends Record
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
		$this->mod_id = 216;
		$this->mod_code = 'job_grade';
		$this->route = 'admin/partner/jobgrade';
		$this->url = site_url('admin/partner/jobgrade');
		$this->primary_key = 'job_grade_id';
		$this->table = 'users_job_grade_level';
		$this->icon = 'fa-edit';
		$this->short_name = 'Job Grade';
		$this->long_name  = 'Job Grade';
		$this->description = '';
		$this->path = APPPATH . 'modules/job_grade/';

		parent::__construct();
	}
}