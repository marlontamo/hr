<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class dtr_summary_model extends Record
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
		$this->mod_id = 89;
		$this->mod_code = 'dtr_summary';
		$this->route = 'time/dtr_summary';
		$this->url = site_url('time/dtr_summary');
		$this->primary_key = 'record_id';
		$this->table = 'time_record_summary';
		$this->icon = 'fa-folder';
		$this->short_name = 'DTR Summary';
		$this->long_name  = 'DTR Summary';
		$this->description = '';
		$this->path = APPPATH . 'modules/dtr_summary/';

		parent::__construct();
	}
}