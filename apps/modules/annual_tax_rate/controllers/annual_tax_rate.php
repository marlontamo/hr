<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Annual_tax_rate extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('annual_tax_rate_model', 'mod');
		parent::__construct();
		$this->lang->load('annual_tax_rate');
	}
}