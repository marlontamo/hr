<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Incident_master extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('incident_master_model', 'mod');
		parent::__construct();
	}
}