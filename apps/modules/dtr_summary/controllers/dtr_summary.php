<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dtr_summary extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('dtr_summary_model', 'mod');
		parent::__construct();
	}

	public function index()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->load->model('timerecord_model', 'timerecord');

		$data['payroll_dates'] = $this->timerecord->get_period_list();
		$this->load->vars($data);
		
		echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
	}
}