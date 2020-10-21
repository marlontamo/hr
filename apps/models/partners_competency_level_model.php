<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class partners_competency_level_model extends Record
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
		$this->mod_id = 221;
		$this->mod_code = 'partners_competency_level';
		$this->route = 'admin/partner/competencylevel';
		$this->url = site_url('admin/partner/competencylevel');
		$this->primary_key = 'competency_level_id';
		$this->table = 'users_competency_level';
		$this->icon = 'fa-edit';
		$this->short_name = 'Competency Level';
		$this->long_name  = 'Competency Level';
		$this->description = '';
		$this->path = APPPATH . 'modules/partners_competency_level/';

		parent::__construct();
	}
}