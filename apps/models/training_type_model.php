<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class training_type_model extends Record
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
		$this->mod_id = 202;
		$this->mod_code = 'training_type';
		$this->route = 'admin/training_type';
		$this->url = site_url('admin/training_type');
		$this->primary_key = 'type_id';
		$this->table = 'training_type';
		$this->icon = '';
		$this->short_name = 'Training Type';
		$this->long_name  = 'Training Type';
		$this->description = '';
		$this->path = APPPATH . 'modules/training_type/';

		parent::__construct();
	}
}