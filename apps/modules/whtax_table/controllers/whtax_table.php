<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Whtax_table extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('whtax_table_model', 'mod');
		parent::__construct();
		$this->lang->load('whtax_table');
	}
}