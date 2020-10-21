<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class purchasing_model extends Record
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
		$this->mod_id = 197;
		$this->mod_code = 'purchasing';
		$this->route = 'purchasing/requisition';
		$this->url = site_url('purchasing/requisition');
		$this->primary_key = 'requisition_id';
		$this->table = 'requisition';
		$this->icon = 'fa-folder';
		$this->short_name = 'Purchasing';
		$this->long_name  = 'Purchasing';
		$this->description = '';
		$this->path = APPPATH . 'modules/purchasing/';

		parent::__construct();
	}
}