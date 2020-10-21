<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class career_level_model extends Record
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
		$this->mod_id = 214;
		$this->mod_code = 'career_level';
		$this->route = 'admin/partner/careerlevel';
		$this->url = site_url('admin/partner/careerlevel');
		$this->primary_key = 'job_rank_level_id';
		$this->table = 'users_job_rank_level';
		$this->icon = 'fa-edit';
		$this->short_name = 'Job Rank Level';
		$this->long_name  = 'Job Rank Level';
		$this->description = '';
		$this->path = APPPATH . 'modules/career_level/';

		parent::__construct();
	}
}