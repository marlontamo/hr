<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Transaction_class extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('transaction_class_model', 'mod');
		parent::__construct();
		$this->lang->load('transaction_class');
	}
}