<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class clinicrecords_model extends Record
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
		$this->mod_id = 132;
		$this->mod_code = 'clinicrecords';
		$this->route = 'partners/clinic_records';
		$this->url = site_url('partners/clinic_records');
		$this->primary_key = 'clinic_records_id';
		$this->table = 'partners_clinic_records';
		$this->icon = 'fa-folder';
		$this->short_name = 'Clinic Records';
		$this->long_name  = 'Clinic Records';
		$this->description = '';
		$this->path = APPPATH . 'modules/clinicrecords/';

		parent::__construct();
	}
}