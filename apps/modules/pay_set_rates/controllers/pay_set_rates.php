<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pay_set_rates extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('pay_set_rates_model', 'mod');
		parent::__construct();
		$this->lang->load('pay_steps_rates');
	}
}