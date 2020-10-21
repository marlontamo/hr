<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class formsdownload_admin_model extends Record
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
		$this->mod_id = 148;
		$this->mod_code = 'formsdownload_admin';
		$this->route = 'partner/formsdownload_admin';
		$this->url = site_url('partner/formsdownload_admin');
		$this->primary_key = 'resource_download_id';
		$this->table = 'resources_downloadable';
		$this->icon = '';
		$this->short_name = 'Downloadable Forms';
		$this->long_name  = 'Downloadable Forms';
		$this->description = '';
		$this->path = APPPATH . 'modules/formsdownload_admin/';

		parent::__construct();
	}
}