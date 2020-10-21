<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Payroll_company extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('payroll_company_model', 'mod');
		parent::__construct();
	}
}