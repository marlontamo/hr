<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class payroll_transactions_model extends Record
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
		$this->mod_id = 48;
		$this->mod_code = 'payroll_transactions';
		$this->route = 'payroll/transactions';
		$this->url = site_url('payroll/transactions');
		$this->primary_key = 'transaction_id';
		$this->table = 'payroll_transaction';
		$this->icon = 'fa-folder';
		$this->short_name = 'Transaction Lists';
		$this->long_name  = 'Transaction Lists';
		$this->description = '';
		$this->path = APPPATH . 'modules/payroll_transactions/';

		parent::__construct();
	}
}