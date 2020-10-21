<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Healthinfo extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('healthinfo_model', 'mod');
		parent::__construct();
	}
	
}