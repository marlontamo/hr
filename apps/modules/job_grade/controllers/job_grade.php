<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job_grade extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('job_grade_model', 'mod');
		parent::__construct();
		$this->lang->load('job_grade');
	}
}