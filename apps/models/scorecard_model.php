<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class scorecard_model extends Record
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
		$this->mod_id = 100;
		$this->mod_code = 'scorecard';
		$this->route = 'admin/scorecard';
		$this->url = site_url('admin/scorecard');
		$this->primary_key = 'scorecard_id';
		$this->table = 'performance_setup_scorecard';
		$this->icon = '';
		$this->short_name = 'Balance Scorecard';
		$this->long_name  = 'Balance Scorecard';
		$this->description = '';
		$this->path = APPPATH . 'modules/scorecard/';

		parent::__construct();
	}
}