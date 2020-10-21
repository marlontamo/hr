<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Division extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('division_model', 'mod');
		parent::__construct();
		$this->lang->load( 'division' );
		$this->lang->load( 'users' );
	}

	function get_immediate_position(){
		$this->_ajax_only();
		$user_id = $this->input->post('user_id');
		
		if(empty($user_id)){
			$this->response->position = '';
        	$this->_ajax_return();
			exit();
		}

		$user_details = $this->mod->get_user_details($this->input->post('user_id'));
       // echo json_encode($user_details);
        $this->response->position = $user_details->position;
        $this->_ajax_return();

	}
}