<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class training_master_model extends Record
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
		$this->mod_id = 198;
		$this->mod_code = 'training_master';
		$this->route = 'admin/training_master';
		$this->url = site_url('admin/training_master');
		$this->primary_key = 'training_id';
		$this->table = 'training';
		$this->icon = '';
		$this->short_name = 'Training Admin';
		$this->long_name  = 'Training Manager';
		$this->description = 'contents and setup';
		$this->path = APPPATH . 'modules/training_master/';

		parent::__construct();
	}
}