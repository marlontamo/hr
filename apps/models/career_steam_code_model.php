<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class career_steam_code_model extends Record
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
		$this->mod_id = 215;
		$this->mod_code = 'career_steam_code';
		$this->route = 'admin/partner/careersteamcode';
		$this->url = site_url('admin/partner/careersteamcode');
		$this->primary_key = 'job_rank_code_id';
		$this->table = 'users_job_rank_code';
		$this->icon = 'fa-edit';
		$this->short_name = 'Career Steam Code';
		$this->long_name  = 'Career Steam Code';
		$this->description = '';
		$this->path = APPPATH . 'modules/career_steam_code/';

		parent::__construct();
	}
}