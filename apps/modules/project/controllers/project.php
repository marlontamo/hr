<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Project extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('project_model', 'mod');
		parent::__construct();
	}
}