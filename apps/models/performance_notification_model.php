<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class performance_notification_model extends Record
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
		$this->mod_id = 105;
		$this->mod_code = 'performance_notification';
		$this->route = 'admin/notification';
		$this->url = site_url('admin/notification');
		$this->primary_key = 'notification_id';
		$this->table = 'performance_setup_notification';
		$this->icon = '';
		$this->short_name = 'Performance Notification';
		$this->long_name  = 'Performance Notification';
		$this->description = '';
		$this->path = APPPATH . 'modules/performance_notification/';

		parent::__construct();
	}
}