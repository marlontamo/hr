<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Badges extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('badges_model', 'mod');
		parent::__construct();
	}
}