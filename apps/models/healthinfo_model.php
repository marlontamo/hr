<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class healthinfo_model extends Record
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
		$this->mod_id = 130;
		$this->mod_code = 'healthinfo';
		$this->route = 'partners/health';
		$this->url = site_url('partners/health');
		$this->primary_key = 'health_id';
		$this->table = 'health';
		$this->icon = '';
		$this->short_name = 'Health Information';
		$this->long_name  = 'Health Information';
		$this->description = '';
		$this->path = APPPATH . 'modules/healthinfo/';

		parent::__construct();
	}
}