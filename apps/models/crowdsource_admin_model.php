<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class crowdsource_admin_model extends Record
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
		$this->mod_id = 186;
		$this->mod_code = 'crowdsource_admin';
		$this->route = 'appraisal/crowdsource_admin';
		$this->url = site_url('appraisal/crowdsource_admin');
		$this->primary_key = 'appraisal_id';
		$this->table = 'performance_appraisal_contributor';
		$this->icon = '';
		$this->short_name = 'Crowdsource Admin';
		$this->long_name  = 'Crowdsource Admin';
		$this->description = '';
		$this->path = APPPATH . 'modules/crowdsource_admin/';

		parent::__construct();
	}
}