<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Performance_master extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('performance_master_model', 'mod');
		parent::__construct();
		$this->lang->load('performance');
	}
}