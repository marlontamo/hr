<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Phic_table extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('phic_table_model', 'mod');
		parent::__construct();
		$this->lang->load('phic_table');
	}
}