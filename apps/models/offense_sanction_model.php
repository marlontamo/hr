<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class offense_sanction_model extends Record
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
		$this->mod_id = 162;
		$this->mod_code = 'offense_sanction';
		$this->route = 'admin/offense_sanction';
		$this->url = site_url('admin/offense_sanction');
		$this->primary_key = 'sanction_id';
		$this->table = 'partners_offense_sanction';
		$this->icon = '';
		$this->short_name = 'Sanction';
		$this->long_name  = 'Code of Discipline';
		$this->description = '';
		$this->path = APPPATH . 'modules/offense_sanction/';

		parent::__construct();
	}
}