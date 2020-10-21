<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Code_of_conduct extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('code_of_conduct_model', 'mod');
		parent::__construct();
	}
}