<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class my_hive_model extends Record
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
		$this->mod_id = 210;
		$this->mod_code = 'my_hive';
		$this->route = 'account/hive';
		$this->url = site_url('account/hive');
		$this->primary_key = 'hive_id';
		$this->table = 'hive';
		$this->icon = '';
		$this->short_name = 'My Hive';
		$this->long_name  = 'My Hive';
		$this->description = 'My Hive';
		$this->path = APPPATH . 'modules/my_hive/';

		parent::__construct();
	}
}