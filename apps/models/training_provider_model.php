<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class training_provider_model extends Record
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
		$this->mod_id = 246;
		$this->mod_code = 'training_provider';
		$this->route = 'admin/training_provider';
		$this->url = site_url('admin/training_provider');
		$this->primary_key = 'provider_id';
		$this->table = 'training_provider';
		$this->icon = '';
		$this->short_name = 'Training Provider';
		$this->long_name  = 'Training Provider';
		$this->description = '';
		$this->path = APPPATH . 'modules/training_provider/';

		parent::__construct();
	}
}