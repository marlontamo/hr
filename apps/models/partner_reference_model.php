<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class partner_reference_model extends Record
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
		$this->mod_id = 159;
		$this->mod_code = 'partner_reference';
		$this->route = 'admin/partner_reference';
		$this->url = site_url('admin/partner_reference');
		$this->primary_key = 'partner_id';
		$this->table = 'partners';
		$this->icon = '';
		$this->short_name = 'Partner Reference';
		$this->long_name  = 'Partner Reference';
		$this->description = '';
		$this->path = APPPATH . 'modules/partner_reference/';

		parent::__construct();
	}
}