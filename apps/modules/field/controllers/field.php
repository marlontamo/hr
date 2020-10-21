<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Field extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('field_model', 'mod');
		parent::__construct();
	}

    function save()
    {
        $this->_ajax_only();
        $this->response->saved = false; 
        
        if( !$this->permission['add'] && !$this->permission['edit'] )
        {
            $this->response->message[] = array(
                'message' => 'You dont have sufficient permission to get the list of field groups for this module, please notify the System Administrator.',
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        $this->response = $this->mod->_save_field();
        $this->_ajax_return();
    }

    function delete()
    {
        $this->_ajax_only();
        
        if( !$this->permission['delete'] )
        {
            $this->response->message[] = array(
                'message' => 'You dont have sufficient permission to get the list of field groups for this module, please notify the System Administrator.',
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        $this->response =$this->mod->_delete_field();
        $this->_ajax_return();
    }
}