<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class report_query_model extends Record
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
		$this->mod_id = 71;
		$this->mod_code = 'report_query';
		$this->route = 'admin/report_query';
		$this->url = site_url('admin/report_query');
		$this->primary_key = 'report_id';
		$this->table = 'report_query';
		$this->icon = '';
		$this->short_name = 'Report Query';
		$this->long_name  = 'Report Query';
		$this->description = 'export and report';
		$this->path = APPPATH . 'modules/report_query/';

		parent::__construct();
	}
}