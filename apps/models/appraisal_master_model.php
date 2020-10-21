<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class appraisal_master_model extends Record
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
		$this->mod_id = 95;
		$this->mod_code = 'appraisal_master';
		$this->route = 'admin/appraisal_master';
		$this->url = site_url('admin/appraisal_master');
		$this->primary_key = 'competency_category_id';
		$this->table = 'performance_competency_category';
		$this->icon = '';
		$this->short_name = 'Performance Appraisal';
		$this->long_name  = 'Performance Appraisal';
		$this->description = '';
		$this->path = APPPATH . 'modules/appraisal_master/';

		parent::__construct();
	}
}