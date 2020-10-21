<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Training_provider extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('training_provider_model', 'mod');
		parent::__construct();
	}
}