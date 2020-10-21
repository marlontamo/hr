<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class transaction_method_model extends Record
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
		$this->mod_id = 49;
		$this->mod_code = 'transaction_method';
		$this->route = 'payroll/transaction_methods';
		$this->url = site_url('payroll/transaction_methods');
		$this->primary_key = 'payroll_transaction_method_id';
		$this->table = 'payroll_transaction_method';
		$this->icon = 'fa-folder';
		$this->short_name = 'Transaction Methods';
		$this->long_name  = 'Transaction Methods';
		$this->description = '';
		$this->path = APPPATH . 'modules/transaction_method/';

		parent::__construct();
	}
}