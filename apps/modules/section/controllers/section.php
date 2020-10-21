<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Section extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('section_model', 'mod');
		parent::__construct();
		$this->lang->load('section');
	}
}