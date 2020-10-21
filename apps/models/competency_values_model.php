<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class competency_values_model extends Record
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
		$this->mod_id = 96;
		$this->mod_code = 'competency_values';
		$this->route = 'admin/competency_values';
		$this->url = site_url('admin/competency_values');
		$this->primary_key = 'competency_values_id';
		$this->table = 'performance_competency_values';
		$this->icon = '';
		$this->short_name = 'Competency Values';
		$this->long_name  = 'Competency Values';
		$this->description = '';
		$this->path = APPPATH . 'modules/competency_values/';

		parent::__construct();
	}
}