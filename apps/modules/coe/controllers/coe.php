<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Coe extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('coe_model', 'mod');
		parent::__construct();
	}
}