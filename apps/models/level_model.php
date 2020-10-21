<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class level_model extends Record
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
		$this->mod_id = 215;
		$this->mod_code = 'level';
		$this->route = 'admin/level';
		$this->url = site_url('admin/level');
		$this->primary_key = 'level_id';
		$this->table = 'play_level';
		$this->icon = '';
		$this->short_name = 'Level';
		$this->long_name  = 'Level';
		$this->description = 'Play Level';
		$this->path = APPPATH . 'modules/level/';

		parent::__construct();
	}
}