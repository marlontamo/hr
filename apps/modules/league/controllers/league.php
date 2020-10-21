<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class League extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('league_model', 'mod');
		parent::__construct();
	}
}