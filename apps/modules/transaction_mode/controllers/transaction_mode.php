<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Transaction_mode extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('transaction_mode_model', 'mod');
		parent::__construct();
		$this->lang->load('transaction_mode');
	}
}