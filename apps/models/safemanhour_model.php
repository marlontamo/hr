<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class safemanhour_model extends Record
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
		$this->mod_id = 133;
		$this->mod_code = 'safemanhour';
		$this->route = 'partners/safe_manhour';
		$this->url = site_url('partners/safe_manhour');
		$this->primary_key = 'safe_manhour_id';
		$this->table = 'partners_safe_manhour';
		$this->icon = 'fa-folder';
		$this->short_name = 'Safe Manhour';
		$this->long_name  = 'Safe Manhour';
		$this->description = '';
		$this->path = APPPATH . 'modules/safemanhour/';

		parent::__construct();
	}
}