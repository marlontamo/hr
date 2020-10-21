<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Branch extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('branch_model', 'mod');
		parent::__construct();
		$this->lang->load( 'branch' );
	}
}