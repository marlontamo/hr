<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Career_stream extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('career_stream_model', 'mod');
		parent::__construct();
		$this->lang->load('career_stream');
	}
}