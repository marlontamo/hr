<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Training_source extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('training_source_model', 'mod');
		parent::__construct();
	}
}