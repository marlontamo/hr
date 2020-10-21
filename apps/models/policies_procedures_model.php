<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class policies_procedures_model extends Record
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
		$this->mod_id = 146;
		$this->mod_code = 'policies_procedures';
		$this->route = 'partner/policies_procedures';
		$this->url = site_url('partner/policies_procedures');
		$this->primary_key = 'resource_policy_id';
		$this->table = 'resources_policies';
		$this->icon = 'fa-folder';
		$this->short_name = 'Policies and Procedure';
		$this->long_name  = 'Policies and Procedure';
		$this->description = '1';
		$this->path = APPPATH . 'modules/policies_procedures/';

		parent::__construct();
	}
}