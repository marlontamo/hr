<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class training_course_model extends Record
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
		$this->mod_id = 203;
		$this->mod_code = 'training_course';
		$this->route = 'admin/training_course';
		$this->url = site_url('admin/training_course');
		$this->primary_key = 'course_id';
		$this->table = 'training_course';
		$this->icon = '';
		$this->short_name = 'Training Course';
		$this->long_name  = 'Training Course';
		$this->description = '';
		$this->path = APPPATH . 'modules/training_course/';

		parent::__construct();
	}
}