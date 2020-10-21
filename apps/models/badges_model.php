<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class badges_model extends Record
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
		$this->mod_id = 211;
		$this->mod_code = 'badges';
		$this->route = 'admin/badges';
		$this->url = site_url('admin/badges');
		$this->primary_key = 'badge_id';
		$this->table = 'play_badges';
		$this->icon = '';
		$this->short_name = 'Badges';
		$this->long_name  = 'Badges';
		$this->description = 'Play Bagdes';
		$this->path = APPPATH . 'modules/badges/';

		parent::__construct();
	}
}