<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class code_of_conduct_model extends Record
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
		$this->mod_id = 138;
		$this->mod_code = 'code_of_conduct';
		$this->route = 'partner/code_of_conduct';
		$this->url = site_url('partner/code_of_conduct');
		$this->primary_key = 'conduct_id';
		$this->table = 'code_conduct';
		$this->icon = 'fa-folder';
		$this->short_name = 'Code of Conduct';
		$this->long_name  = 'Code of Conduct';
		$this->description = '';
		$this->path = APPPATH . 'modules/code_of_conduct/';

		parent::__construct();
	}
}