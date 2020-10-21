<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class redemption_model extends Record
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
		$this->mod_id = 213;
		$this->mod_code = 'redemption';
		$this->route = 'admin/redemption';
		$this->url = site_url('admin/redemption');
		$this->primary_key = 'item_id';
		$this->table = 'play_redeemable';
		$this->icon = '';
		$this->short_name = 'Redemption';
		$this->long_name  = 'Redemption';
		$this->description = 'Redeemable items';
		$this->path = APPPATH . 'modules/redemption/';

		parent::__construct();
	}
}