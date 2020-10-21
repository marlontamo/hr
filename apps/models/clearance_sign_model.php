<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class clearance_sign_model extends Record
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
		$this->mod_id = 163;
		$this->mod_code = 'clearance_sign';
		$this->route = 'admin/clearance_sign';
		$this->url = site_url('admin/clearance_sign');
		$this->primary_key = 'clearance_layout_id';
		$this->table = 'partners_clearance_layout';
		$this->icon = '';
		$this->short_name = 'Clearance Signatories';
		$this->long_name  = 'Clearance Signatories';
		$this->description = '';
		$this->path = APPPATH . 'modules/clearance_sign/';

		parent::__construct();
	}
}