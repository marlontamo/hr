<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Training_library extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('training_library_model', 'mod');
		parent::__construct();
	}
}