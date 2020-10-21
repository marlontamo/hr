<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Training_course extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('training_course_model', 'mod');
		parent::__construct();
	}

/*	function save(){
		debug($_POST);die();
	}*/
}