<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class recruit_benefits_model extends Record
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
		$this->mod_id = 119;
		$this->mod_code = 'recruit_benefits';
		$this->route = 'recruitment/benefits';
		$this->url = site_url('recruitment/benefits');
		$this->primary_key = 'package_id';
		$this->table = 'recruitment_benefit_package';
		$this->icon = 'fa-folder';
		$this->short_name = 'Benefits';
		$this->long_name  = 'Benefits';
		$this->description = '';
		$this->path = APPPATH . 'modules/recruit_benefits/';

		parent::__construct();
	}
}