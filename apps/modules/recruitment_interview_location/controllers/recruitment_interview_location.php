<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Recruitment_interview_location extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('recruitment_interview_location_model', 'mod');
		parent::__construct();
	}
}