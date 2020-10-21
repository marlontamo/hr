<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class training_cost_model extends Record
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
		$this->mod_id = 249;
		$this->mod_code = 'training_cost';
		$this->route = 'admin/training_cost';
		$this->url = site_url('admin/training_cost');
		$this->primary_key = 'cost_id';
		$this->table = 'training_cost';
		$this->icon = '';
		$this->short_name = 'Training Cost';
		$this->long_name  = 'Training Cost';
		$this->description = '';
		$this->path = APPPATH . 'modules/training_cost/';

		parent::__construct();
	}
}