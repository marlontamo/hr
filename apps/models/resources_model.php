<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class resources_model extends Record
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
		$this->mod_id = 143;
		$this->mod_code = 'resources';
		$this->route = 'partner/resources';
		$this->url = site_url('partner/resources');
		$this->primary_key = 'resources_id';
		$this->table = 'partners_resources';
		$this->icon = '';
		$this->short_name = 'Resources';
		$this->long_name  = 'Partners Resources';
		$this->description = '';
		$this->path = APPPATH . 'modules/resources/';

		parent::__construct();
	}
}