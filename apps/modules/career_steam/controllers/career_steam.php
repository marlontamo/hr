<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Career_steam extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('career_steam_model', 'mod');
		parent::__construct();
	}
}