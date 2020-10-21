<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class recruitment_interview_location_model extends Record
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
		$this->mod_id = 229;
		$this->mod_code = 'recruitment_interview_location';
		$this->route = 'admin/interview_location';
		$this->url = site_url('admin/interview_location');
		$this->primary_key = 'interview_location_id';
		$this->table = 'recruitment_interview_location';
		$this->icon = 'fa-edit';
		$this->short_name = 'Interview Location';
		$this->long_name  = 'Interview Location';
		$this->description = '';
		$this->path = APPPATH . 'modules/recruitment_interview_location/';

		parent::__construct();
	}
}