<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Training_cost extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('training_cost_model', 'mod');
		parent::__construct();
	}
}