<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Training_master extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('training_master_model', 'mod');
		parent::__construct();
		$this->lang->load('training');
	}
}