<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Training_category extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('training_category_model', 'mod');
		parent::__construct();
	}
}