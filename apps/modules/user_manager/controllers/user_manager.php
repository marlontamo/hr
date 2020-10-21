<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_manager extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('user_manager_model', 'mod');
		parent::__construct();
		$this->lang->load('user_manager');
	}

	public function index(){
		$data = array();
		$data['permission']['division'] = $this->_check_permission('division');
		$data['permission']['group'] = $this->_check_permission('group');		
		$data['list'] = $this->mod->getUserManagerList();
		$this->load->vars($data);
		echo $this->load->blade('list')->with( $this->load->get_cached_vars() );
	}
}