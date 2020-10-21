<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Leave_setup_policy extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('leave_setup_policy_model', 'mod');
		parent::__construct();
	}
}