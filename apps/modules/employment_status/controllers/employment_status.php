<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Employment_status extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('employment_status_model', 'mod');
		parent::__construct();
		$this->lang->load( 'employment_status' );
	}
}