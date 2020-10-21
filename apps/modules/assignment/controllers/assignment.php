<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Assignment extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('assignment_model', 'mod');
		parent::__construct();
		$this->lang->load('assignment');
	}
}