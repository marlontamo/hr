<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class mobile_model extends Record
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
		$this->mod_id = 59;
		$this->mod_code = 'mobile';
		$this->route = 'mobile';
		$this->url = site_url('mobile');
		$this->primary_key = 'mobile_id';
		$this->table = 'mobile';
		$this->icon = 'fa-default';
		$this->short_name = 'Mobile';
		$this->long_name  = 'Mobile';
		$this->description = '';
		$this->path = APPPATH . 'controllers/';

		parent::__construct();
	}
}