<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rating_score extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('rating_score_model', 'mod');
		parent::__construct();
	}
}