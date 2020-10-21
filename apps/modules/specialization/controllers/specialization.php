<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Specialization extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('specialization_model', 'mod');
		parent::__construct();
	}
}