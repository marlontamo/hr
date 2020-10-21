<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Account_type extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('account_type_model', 'mod');
		parent::__construct();
		$this->lang->load('account_type');
	}
}