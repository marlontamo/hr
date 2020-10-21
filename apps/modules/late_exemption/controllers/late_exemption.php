<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Late_exemption extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('late_exemption_model', 'mod');
		parent::__construct();
		$this->lang->load('late_exemption');
	}
}