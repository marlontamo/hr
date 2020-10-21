<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Position extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('position_model', 'mod');
		parent::__construct();
		$this->lang->load( 'position' );
		$this->lang->load( 'users' );
	}

	function get_immediate_position(){
		$user_id = $this->input->post('user_id');

		if(empty($user_id)){
			$this->response->position = '';
        	$this->_ajax_return();
			exit();
		}

		$user_details = $this->mod->get_user_details($this->input->post('user_id'));
        // echo json_encode($user_details);
        $this->response->position = $user_details->position;

	    $this->response->message[] = array(
	        'message' => '',
	        'type' => 'success'
	        );

	    $this->_ajax_return();

	}

	public function single_upload()
	{
		$this->_ajax_only();
		define('UPLOAD_DIR', 'uploads/position/');
		$this->load->library("UploadHandler");
		$files = $this->uploadhandler->post();
		$file = $files[0];
		if( isset($file->error) && $file->error != "" )
		{
			$this->response->message[] = array(
				'message' => $file->error,
				'type' => 'error'
			);	
		}
		$this->response->file = $file;
		$this->_ajax_return();
	}	
}