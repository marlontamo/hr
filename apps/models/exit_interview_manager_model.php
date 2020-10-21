<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class exit_interview_manager_model extends Record
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
		$this->mod_id = 165;
		$this->mod_code = 'exit_interview_manager';
		$this->route = 'admin/exit_interview_manager';
		$this->url = site_url('admin/exit_interview_manager');
		$this->primary_key = 'exit_interview_layout_id';
		$this->table = 'partners_clearance_exit_interview_layout';
		$this->icon = '';
		$this->short_name = 'Exit Interview';
		$this->long_name  = 'Exit Interview';
		$this->description = '';
		$this->path = APPPATH . 'modules/exit_interview_manager/';

		parent::__construct();
	}
}