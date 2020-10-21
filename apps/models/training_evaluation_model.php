<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class training_evaluation_model extends Record
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
		$this->mod_id = 244;
		$this->mod_code = 'training_evaluation';
		$this->route = 'training/training_evaluation';
		$this->url = site_url('training/training_evaluation');
		$this->primary_key = 'training_calendar_id';
		$this->table = 'training_calendar';
		$this->icon = '';
		$this->short_name = 'Training Evaluation';
		$this->long_name  = 'Training Evaluation';
		$this->description = '';
		$this->path = APPPATH . 'modules/training_evaluation/';

		parent::__construct();
	}
}