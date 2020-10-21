<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Employment_type extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('employment_type_model', 'mod');
		parent::__construct();
		$this->lang->load( 'employment_type' );
	}
}