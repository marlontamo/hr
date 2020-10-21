<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Partners_competency_level extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('partners_competency_level_model', 'mod');
		parent::__construct();
        $this->lang->load('competency_level');
	}
}