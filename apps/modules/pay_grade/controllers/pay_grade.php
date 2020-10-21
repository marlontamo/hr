<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pay_grade extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('pay_grade_model', 'mod');
		parent::__construct();
		$this->lang->load('pay_grade');
	}
}