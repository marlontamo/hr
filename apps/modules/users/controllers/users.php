<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('users_model', 'mod');
		parent::__construct();
		$this->lang->load('users');
	}

	function save()
	{
		//validate if there are existing pending forms
		$record_id_check = $this->input->post('record_id');
		$user_profile_data = $this->input->post('users_profile');
		$new_company_id = $user_profile_data['company_id'];
		if($record_id_check > 0){			
			$user_record = $this->db->get_where( 'users_profile', array( $this->mod->primary_key => $record_id_check ) )->row_array();
			if($new_company_id != $user_record['company_id']){
				$select_pending_forms_qry = "SELECT  tr.forms_id, tr.user_id 
									FROM time_forms tr WHERE deleted=0
       								AND user_id = {$user_record['user_id']}
       								AND form_status_id IN (2,3,4,5) 
       								";
				$result_update = $this->db->query( $select_pending_forms_qry );
				$pending_forms_count = $result_update->num_rows();
				
				if($pending_forms_count > 0){
					$is_are = ($pending_forms_count == 1) ? "is" : "are";
					$form_s = ($pending_forms_count == 1) ? "form" : "forms";
					$this->response->message[] = array(
						'message' => "There {$is_are} {$pending_forms_count} pending {$form_s} affected.<br>Please dis/approve {$form_s} before changing the user's company.",
						'type' => 'warning'
					);
        		$this->_ajax_return();
				}
			}
		}

		parent::save( true );
		if( $this->response->saved )
        {
        	$this->mod->_create_config( $this->response->record_id );
        	
        	$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
        }
        $this->_ajax_return();
	}

	public function edit( $record_id = "", $child_call = false )
	{
		if( !$this->permission['edit'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_edit( $child_call );
	}

	private function _edit( $child_call, $new = false )
	{
		$record_check = false;
		$this->record_id = $data['record_id'] = '';

		if( !$new ){
			if( !$this->_set_record_id() )
			{
				echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
				die();
			}

			$this->record_id = $data['record_id'] = $_POST['record_id'];
		}
		
		$record_check = $this->mod->_exists( $this->record_id );
		if( $new || $record_check === true )
		{
			$result = $this->mod->_get( 'edit', $this->record_id );
			if( $new )
			{
				$field_lists = $result->list_fields();
				foreach( $field_lists as $field )
				{
					$data['record'][$field] = '';
				}
			}
			else{
				$record = $result->row_array();
				foreach( $record as $index => $value )
				{
					$record[$index] = trim( $value );	
				}
				$data['record'] = $record;
			}

			$this->db->where('deleted', '0');
			$this->db->where('user_id', $this->user->user_id);
			$data['current_user'] = $this->db->get('users')->row(); 

			$this->load->vars( $data );

			if( !$child_call ){
				$this->load->helper('form');
				$this->load->helper('file');
				echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
			}
		}
		else
		{
			$this->load->vars( $data );
			if( !$child_call ){
				echo $this->load->blade('pages.error', array('error' => $record_check))->with( $this->load->get_cached_vars() );
			}
		}
	}

	public function detail( $record_id = "", $child_call = false )
	{
		if( !$this->permission['detail'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_detail( $child_call );
	}

	private function _detail( $child_call, $new = false )
	{
		$record_check = false;
		$this->record_id = $data['record_id'] = '';

		if( !$new ){
			if( !$this->_set_record_id() )
			{
				echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
				die();
			}

			$this->record_id = $data['record_id'] = $_POST['record_id'];
		}
		
		$record_check = $this->mod->_exists( $this->record_id );
		if( $new || $record_check === true )
		{
			$result = $this->mod->_get( 'edit', $this->record_id );
			if( $new )
			{
				$field_lists = $result->list_fields();
				foreach( $field_lists as $field )
				{
					$data['record'][$field] = '';
				}
			}
			else{
				$record = $result->row_array();
				foreach( $record as $index => $value )
				{
					$record[$index] = trim( $value );	
				}
				$data['record'] = $record;
			}

			$this->db->where('deleted', '0');
			$this->db->where('user_id', $this->user->user_id);
			$data['current_user'] = $this->db->get('users')->row(); 

			$this->load->vars( $data );

			if( !$child_call ){
				$this->load->helper('form');
				$this->load->helper('file');
				echo $this->load->blade('pages.detail')->with( $this->load->get_cached_vars() );
			}
		}
		else
		{
			$this->load->vars( $data );
			if( !$child_call ){
				echo $this->load->blade('pages.error', array('error' => $record_check))->with( $this->load->get_cached_vars() );
			}
		}
	}

	public function add( $record_id = '', $child_call = false )
	{
		if( !$this->permission['add'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_edit( $child_call, true );
	}
}