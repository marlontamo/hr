<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Training_facilitator extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('training_facilitator_model', 'mod');
		parent::__construct();
	}
}