<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rate_type extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('rate_type_model', 'mod');
		parent::__construct();
		$this->lang->load('rate_type');
	}
}