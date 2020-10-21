<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Offense_level extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('offense_level_model', 'mod');
		parent::__construct();
		$this->lang->load('offense_level');
	}
}