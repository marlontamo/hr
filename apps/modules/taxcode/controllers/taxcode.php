<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Taxcode extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('taxcode_model', 'mod');
		parent::__construct();
	}
}