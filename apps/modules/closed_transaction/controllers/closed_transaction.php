<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Closed_transaction extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('closed_transaction_model', 'mod');
		parent::__construct();
	}
}