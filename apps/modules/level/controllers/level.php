<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Level extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('level_model', 'mod');
		parent::__construct();
	}
}