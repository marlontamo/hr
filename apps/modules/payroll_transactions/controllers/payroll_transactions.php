<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Payroll_transactions extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('payroll_transactions_model', 'mod');
		parent::__construct();
		$this->lang->load('payroll_transactions');
	}
}