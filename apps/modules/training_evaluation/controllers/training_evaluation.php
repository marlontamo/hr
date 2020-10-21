<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Training_evaluation extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('training_evaluation_model', 'mod');
		parent::__construct();
	}
}