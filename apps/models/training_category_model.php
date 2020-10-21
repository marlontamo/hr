<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class training_category_model extends Record
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
		$this->mod_id = 200;
		$this->mod_code = 'training_category';
		$this->route = 'admin/training_category';
		$this->url = site_url('admin/training_category');
		$this->primary_key = 'category_id';
		$this->table = 'training_category';
		$this->icon = '';
		$this->short_name = 'Training Category';
		$this->long_name  = 'Training Category';
		$this->description = '';
		$this->path = APPPATH . 'modules/training_category/';

		parent::__construct();
	}
}