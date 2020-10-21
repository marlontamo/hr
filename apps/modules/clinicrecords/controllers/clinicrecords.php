<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Clinicrecords extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('clinicrecords_model', 'mod');
		parent::__construct();
	}
}