<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Partner_reference extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('partner_reference_model', 'mod');
		parent::__construct();
	}
}