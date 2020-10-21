<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class gamification_model extends Record
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
		$this->mod_id = 212;
		$this->mod_code = 'gamification';
		$this->route = 'admin/gamification';
		$this->url = site_url('admin/gamification');
		$this->primary_key = 'gamification_id';
		$this->table = 'gamification';
		$this->icon = '';
		$this->short_name = 'Gamification';
		$this->long_name  = 'Gamification';
		$this->description = 'contents and setup';
		$this->path = APPPATH . 'modules/gamification/';

		parent::__construct();
	}
}