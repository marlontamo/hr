<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Training_revalida extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('training_revalida_model', 'mod');
		parent::__construct();
	}
}