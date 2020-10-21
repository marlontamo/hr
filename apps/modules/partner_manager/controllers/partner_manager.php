<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Partner_manager extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('partner_manager_model', 'mod');
		parent::__construct();
		$this->lang->load('partner_manager');
	}

    public function index(){
        echo $this->load->blade('list')->with( $this->load->get_cached_vars() );
        die();
    }
}