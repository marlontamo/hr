<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class rating_score_model extends Record
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
		$this->mod_id = 103;
		$this->mod_code = 'rating_score';
		$this->route = 'admin/rating_score';
		$this->url = site_url('admin/rating_score');
		$this->primary_key = 'rating_score_id';
		$this->table = 'performance_setup_rating_score';
		$this->icon = '';
		$this->short_name = 'Rating Score';
		$this->long_name  = 'Rating Score';
		$this->description = '';
		$this->path = APPPATH . 'modules/rating_score/';

		parent::__construct();
	}
}