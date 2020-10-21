<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class career_rank_model extends Record
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
		$this->mod_id = 218;
		$this->mod_code = 'career_rank';
		$this->route = 'admin/partner/careerrank';
		$this->url = site_url('admin/partner/careerrank');
		$this->primary_key = 'job_rank_id';
		$this->table = 'users_job_rank';
		$this->icon = 'fa-edit';
		$this->short_name = 'Career Rank';
		$this->long_name  = 'Career Rank';
		$this->description = '';
		$this->path = APPPATH . 'modules/career_rank/';

		parent::__construct();
	}
}