<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Leave_conversion extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('leave_conversion_model', 'mod');
		parent::__construct();
		$this->lang->load('leave_conversion');
	}

	
}