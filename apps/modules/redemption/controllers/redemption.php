<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Redemption extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('redemption_model', 'mod');
		parent::__construct();
	}
}