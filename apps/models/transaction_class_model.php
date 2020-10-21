<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class transaction_class_model extends Record
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
		$this->mod_id = 47;
		$this->mod_code = 'transaction_class';
		$this->route = 'payroll/transaction_class';
		$this->url = site_url('payroll/transaction_class');
		$this->primary_key = 'transaction_class_id';
		$this->table = 'payroll_transaction_class';
		$this->icon = 'fa-folder';
		$this->short_name = 'Transaction Class';
		$this->long_name  = 'Transaction Class';
		$this->description = 'Transaction Class';
		$this->path = APPPATH . 'modules/transaction_class/';

		parent::__construct();
	}
}