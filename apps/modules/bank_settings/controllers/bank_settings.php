<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bank_settings extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('bank_settings_model', 'mod');
		parent::__construct();
		$this->lang->load('bank_settings');
	}
}