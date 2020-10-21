<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Accounts_chart extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('accounts_chart_model', 'mod');
		parent::__construct();
		$this->lang->load('account_charts');
	}
}