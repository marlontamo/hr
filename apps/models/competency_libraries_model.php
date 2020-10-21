<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class competency_libraries_model extends Record
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
		$this->mod_id = 97;
		$this->mod_code = 'competency_libraries';
		$this->route = 'admin/competency_libraries';
		$this->url = site_url('admin/competency_libraries');
		$this->primary_key = 'competency_libraries_id';
		$this->table = 'performance_competency_libraries';
		$this->icon = '';
		$this->short_name = 'Competency Libraries';
		$this->long_name  = 'Competency Libraries';
		$this->description = '';
		$this->path = APPPATH . 'modules/competency_libraries/';

		parent::__construct();
	}

}