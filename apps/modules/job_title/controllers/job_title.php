<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job_title extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('job_title_model', 'mod');
		parent::__construct();
		$this->lang->load('job_title');
	}
}