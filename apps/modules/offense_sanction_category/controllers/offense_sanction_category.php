<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Offense_sanction_category extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('offense_sanction_category_model', 'mod');
		parent::__construct();
	}
}