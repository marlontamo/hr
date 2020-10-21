<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class import201_model extends Record
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
		$this->mod_id = 251;
		$this->mod_code = 'import201';
		$this->route = 'admin/import201';
		$this->url = site_url('admin/import201');
		$this->primary_key = 'user_id';
		$this->table = 'users';
		$this->icon = 'fa-user';
		$this->short_name = 'Import 201';
		$this->long_name  = 'Import 201';
		$this->description = '';
		$this->path = APPPATH . 'modules/import201/';

		parent::__construct();
	}
}