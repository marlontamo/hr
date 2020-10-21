<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Career_rank extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('career_rank_model', 'mod');
		parent::__construct();
	}
}