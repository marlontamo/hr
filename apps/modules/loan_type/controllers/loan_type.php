<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Loan_type extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('loan_type_model', 'mod');
		parent::__construct();
		$this->lang->load('loan_types');
	}
}