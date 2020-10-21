<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class training_library_model extends Record
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
		$this->mod_id = 247;
		$this->mod_code = 'training_library';
		$this->route = 'admin/training_library';
		$this->url = site_url('admin/training_library');
		$this->primary_key = 'library_id';
		$this->table = 'training_library';
		$this->icon = '';
		$this->short_name = 'Training Library';
		$this->long_name  = 'Training Library';
		$this->description = '';
		$this->path = APPPATH . 'modules/training_library/';

		parent::__construct();
	}
}