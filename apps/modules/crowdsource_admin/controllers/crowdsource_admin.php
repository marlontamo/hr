<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crowdsource_admin extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('crowdsource_admin_model', 'mod');
		parent::__construct();
	}
}