<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class training_source_model extends Record
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
		$this->mod_id = 204;
		$this->mod_code = 'training_source';
		$this->route = 'admin/training_source';
		$this->url = site_url('admin/training_source');
		$this->primary_key = 'source_id';
		$this->table = 'training_source';
		$this->icon = '';
		$this->short_name = 'Training Source';
		$this->long_name  = 'Training Source';
		$this->description = '';
		$this->path = APPPATH . 'modules/training_source/';

		parent::__construct();
	}
}