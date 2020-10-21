<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class career_stream_model extends Record
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
		$this->mod_id = 213;
		$this->mod_code = 'career_stream';
		$this->route = 'admin/partner/careerstream';
		$this->url = site_url('admin/partner/careerstream');
		$this->primary_key = 'job_class_id';
		$this->table = 'users_job_class';
		$this->icon = 'fa-edit';
		$this->short_name = 'Job Class';
		$this->long_name  = 'Job Class';
		$this->description = '';
		$this->path = APPPATH . 'modules/career_stream/';

		parent::__construct();
	}
}