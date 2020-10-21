<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Training_competency extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('training_competency_model', 'mod');
		parent::__construct();
	}
}