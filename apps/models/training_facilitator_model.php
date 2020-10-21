<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class training_facilitator_model extends Record
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
		$this->mod_id = 248;
		$this->mod_code = 'training_facilitator';
		$this->route = 'admin/training_facilitator';
		$this->url = site_url('admin/training_facilitator');
		$this->primary_key = 'facilitator_id';
		$this->table = 'training_facilitator';
		$this->icon = '';
		$this->short_name = 'Training Facilitator';
		$this->long_name  = 'Training Facilitator';
		$this->description = '';
		$this->path = APPPATH . 'modules/training_facilitator/';

		parent::__construct();
	}
}