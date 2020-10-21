<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Training_bond extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('training_bond_model', 'mod');
		parent::__construct();
	}
}