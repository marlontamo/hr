<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class policies_procedures_admin_model extends Record
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
		$this->mod_id = 147;
		$this->mod_code = 'policies_procedures_admin';
		$this->route = 'partner/policies_procedures_admin';
		$this->url = site_url('partner/policies_procedures_admin');
		$this->primary_key = 'resource_policy_id';
		$this->table = 'resources_policies';
		$this->icon = '';
		$this->short_name = 'Policies and Procedure ';
		$this->long_name  = 'Policies and Procedure ';
		$this->description = '';
		$this->path = APPPATH . 'modules/policies_procedures_admin/';

		parent::__construct();
	}
}