<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class rating_group_model extends Record
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
		$this->mod_id = 102;
		$this->mod_code = 'rating_group';
		$this->route = 'admin/rating_group';
		$this->url = site_url('admin/rating_group');
		$this->primary_key = 'rating_group_id';
		$this->table = 'performance_setup_rating_group';
		$this->icon = '';
		$this->short_name = 'Rating Group';
		$this->long_name  = 'Rating Group';
		$this->description = '';
		$this->path = APPPATH . 'modules/rating_group/';

		parent::__construct();
	}
}