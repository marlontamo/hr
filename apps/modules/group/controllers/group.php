<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Group extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('group_model', 'mod');
		parent::__construct();
		$this->lang->load( 'group' );
		$this->lang->load('users');
	}

	function get_immediate_position(){

		$this->load->model('division_model', 'div_mod');
		$user_details = $this->div_mod->get_user_details($this->input->post('user_id'));
        echo json_encode($user_details);

	}
}