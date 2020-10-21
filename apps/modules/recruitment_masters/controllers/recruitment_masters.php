<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Recruitment_masters extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('recruitment_masters_model', 'mod');
		parent::__construct();
	}
}