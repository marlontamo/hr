<?php 

class Mobile extends MY_Controller
{
	public function __construct()
	{
		$this->load->model('mobile_model', 'mod');
		parent::__construct();
	}
	
	function get_resource()
	{
		$this->_ajax_only();
		$this->response->resource = $this->load->view('common/mobile_resource', array(), true);
		$this->response->message[] = array(
	    	'message' => '',
	    	'type' => 'success'
		);
		$this->_ajax_return();
	}

	function get_settings()
	{
		$this->_ajax_only();
		$this->load->model('users_model', 'users');
		$vars['user_preview'] = $this->users->_get_user_preview( $this->user->user_id );
		$this->response->settings = $this->load->view('settings', $vars, true);
		$this->response->message[] = array(
	    	'message' => '',
	    	'type' => 'success'
		);
		$this->_ajax_return();
	}
}

/* End of file */
/* Location: system/application */
