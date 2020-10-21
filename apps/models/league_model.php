<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class league_model extends Record
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
		$this->mod_id = 214;
		$this->mod_code = 'league';
		$this->route = 'admin/league';
		$this->url = site_url('admin/league');
		$this->primary_key = 'league_id';
		$this->table = 'play_league';
		$this->icon = '';
		$this->short_name = 'League';
		$this->long_name  = 'League';
		$this->description = '';
		$this->path = APPPATH . 'modules/league/';

		parent::__construct();
	}
}