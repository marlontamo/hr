<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class library_model extends Record
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
		$this->mod_id = 101;
		$this->mod_code = 'library';
		$this->route = 'admin/library';
		$this->url = site_url('admin/library');
		$this->primary_key = 'library_id';
		$this->table = 'performance_setup_library';
		$this->icon = '';
		$this->short_name = 'Competency Library';
		$this->long_name  = 'Competency Library';
		$this->description = '';
		$this->path = APPPATH . 'modules/library/';

		parent::__construct();
	}
}