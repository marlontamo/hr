<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class transaction_mode_model extends Record
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
		$this->mod_id = 50;
		$this->mod_code = 'transaction_mode';
		$this->route = 'payroll/transaction_modes';
		$this->url = site_url('payroll/transaction_modes');
		$this->primary_key = 'payroll_transaction_mode_id';
		$this->table = 'payroll_transaction_mode';
		$this->icon = 'fa-folder';
		$this->short_name = 'Transaction Mode';
		$this->long_name  = 'Transaction Mode';
		$this->description = '';
		$this->path = APPPATH . 'modules/transaction_mode/';

		parent::__construct();
	}
}