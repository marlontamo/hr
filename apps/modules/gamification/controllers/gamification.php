<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gamification extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('gamification_model', 'mod');
		parent::__construct();
	}
}