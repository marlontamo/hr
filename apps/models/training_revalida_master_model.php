<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class training_revalida_master_model extends Record
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
		$this->mod_id = 243;
		$this->mod_code = 'training_revalida_master';
		$this->route = 'admin/training_revalida_master';
		$this->url = site_url('admin/training_revalida_master');
		$this->primary_key = 'training_revalida_master_id';
		$this->table = 'training_revalida_master';
		$this->icon = '';
		$this->short_name = 'Level 2 & 3 Training Evaluation';
		$this->long_name  = 'Level 2 and 3 Training Evaluation Master';
		$this->description = '';
		$this->path = APPPATH . 'modules/training_revalida_master/';

		parent::__construct();
	}
}