<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class db_prep_model extends Record
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
		$this->mod_id = 174;
		$this->mod_code = 'db_prep';
		$this->route = 'admin/db_prep';
		$this->url = site_url('admin/db_prep');
		$this->primary_key = '1';
		$this->table = '1';
		$this->icon = 'fa-folder';
		$this->short_name = 'Database Installer and Uploader';
		$this->long_name  = 'Database Installer and Uploader';
		$this->description = '';
		$this->path = APPPATH . 'modules/db_prep/';

		parent::__construct();
	}
}