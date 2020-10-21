<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class coe_model extends Record
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
		$this->mod_id = 261;
		$this->mod_code = 'coe';
		$this->route = 'partner/coe';
		$this->url = site_url('partner/coe');
		$this->primary_key = 'coe_id';
		$this->table = 'certificate_of_employment';
		$this->icon = '';
		$this->short_name = 'Certificate of Employment';
		$this->long_name  = 'Certificate of Employment';
		$this->description = 'Certificate of Employment';
		$this->path = APPPATH . 'modules/coe/';

		parent::__construct();
	}
}