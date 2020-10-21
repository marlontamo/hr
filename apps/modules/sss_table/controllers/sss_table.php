<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sss_table extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('sss_table_model', 'mod');
		parent::__construct();
		$this->lang->load('sss_table');
	}
}