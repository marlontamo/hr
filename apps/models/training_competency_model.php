<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class training_competency_model extends Record
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
		$this->mod_id = 201;
		$this->mod_code = 'training_competency';
		$this->route = 'admin/training_competency';
		$this->url = site_url('admin/training_competency');
		$this->primary_key = 'competency_id';
		$this->table = 'training_competency';
		$this->icon = '';
		$this->short_name = 'Training Competency';
		$this->long_name  = 'Training Competency';
		$this->description = '';
		$this->path = APPPATH . 'modules/training_competency/';

		parent::__construct();
	}
}