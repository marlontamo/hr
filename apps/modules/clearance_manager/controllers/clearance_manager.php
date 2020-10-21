<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Clearance_manager extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('clearance_manager_model', 'mod');
		parent::__construct();
	}
}