<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class incident_master_model extends Record
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
		$this->mod_id = 142;
		$this->mod_code = 'incident_master';
		$this->route = 'admin/incident';
		$this->url = site_url('admin/incident');
		$this->primary_key = 'incident_master_id';
		$this->table = 'partner_incident_master';
		$this->icon = '';
		$this->short_name = 'Incident Resources';
		$this->long_name  = 'Incident Resources';
		$this->description = '';
		$this->path = APPPATH . 'modules/incident_master/';

		parent::__construct();
	}
}