<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Training_type extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('training_type_model', 'mod');
		parent::__construct();
	}
}