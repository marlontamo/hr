<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Time_reference extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('time_reference_model', 'mod');
		parent::__construct();
		$this->lang->load( 'time_reference' );
	}

	public function index(){
		$data = array();
		$data['list'] = $this->mod->getTimeReferrenceList();
		$this->load->vars($data);
		echo $this->load->blade('list')->with( $this->load->get_cached_vars() );
	}

}