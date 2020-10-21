<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class training_application_model extends Record
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
		$this->mod_id = 207;
		$this->mod_code = 'training_application';
		$this->route = 'admin/training_application';
		$this->url = site_url('admin/training_application');
		$this->primary_key = 'application_id';
		$this->table = 'training_application';
		$this->icon = '';
		$this->short_name = 'Training Application';
		$this->long_name  = 'Training Application';
		$this->description = '';
		$this->path = APPPATH . 'modules/training_application/';

		parent::__construct();
	}
}