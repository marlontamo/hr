<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class training_bond_model extends Record
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
		$this->mod_id = 199;
		$this->mod_code = 'training_bond';
		$this->route = 'admin/training_bond';
		$this->url = site_url('admin/training_bond');
		$this->primary_key = 'bond_id';
		$this->table = 'training_bond';
		$this->icon = '';
		$this->short_name = 'Training Bond';
		$this->long_name  = 'Training Bond';
		$this->description = '';
		$this->path = APPPATH . 'modules/training_bond/';

		parent::__construct();
	}
}