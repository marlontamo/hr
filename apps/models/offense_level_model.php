<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class offense_level_model extends Record
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
		$this->mod_id = 255;
		$this->mod_code = 'offense_level';
		$this->route = 'admin/offense_level';
		$this->url = site_url('admin/offense_level');
		$this->primary_key = 'offense_level_id';
		$this->table = 'partners_offense_level';
		$this->icon = 'fa-th-list';
		$this->short_name = 'Offense level';
		$this->long_name  = 'Offense level';
		$this->description = 'Manage and list offense level';
		$this->path = APPPATH . 'modules/offense_level/';

		parent::__construct();
	}
}