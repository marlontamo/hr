<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report_query extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('report_query_model', 'mod');
		parent::__construct();
	}
}