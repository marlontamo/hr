<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class competency_level_model extends Record
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
		$this->mod_id = 98;
		$this->mod_code = 'competency_level';
		$this->route = 'admin/competency_level';
		$this->url = site_url('admin/competency_level');
		$this->primary_key = 'competency_level_id';
		$this->table = 'performance_competency_level';
		$this->icon = '';
		$this->short_name = 'Competency Level';
		$this->long_name  = 'Competency Level';
		$this->description = '';
		$this->path = APPPATH . 'modules/competency_level/';

		parent::__construct();
	}
}