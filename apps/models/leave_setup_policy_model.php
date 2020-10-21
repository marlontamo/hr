<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
	$this->lang->load('leave_setup_policy');
}

class leave_setup_policy_model extends Record
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
		$this->mod_id = 227;
		$this->mod_code = 'leave_setup_policy';
		$this->route = 'admin/leave_setup_policy';
		$this->url = site_url('admin/leave_setup_policy');
		$this->primary_key = 'policy_id';
		$this->table = 'time_form_balance_setup_policy';
		$this->icon = 'fa-th-list';
		$this->short_name = 'Leave Credit Setup';
		$this->long_name  = 'Leave Credit Setup';
		$this->description = '';
		$this->path = APPPATH . 'modules/leave_setup_policy/';

		parent::__construct();
	}
}