<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Email_queue extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('email_queue_model', 'mod');
		parent::__construct();
	}

    public function index()
    {

        if( !$this->permission['list'] )
        {
            echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
            die();
        }

        $user_setting = APPPATH . 'config/users/'. $this->user->user_id .'.php';
        $user_id = $this->user->user_id;
        $this->load->config( "users/{$user_id}.php", false, true );
        $user = $this->config->item('user');

        $this->load->config( 'roles/'. $user['role_id'] .'/permission.php', false, true );
        $permission = $this->config->item('permission');

        $this->load->model('sms_queue_model', 'sms');
        $data['sms'] = isset($permission[$this->sms->mod_code]['list']) ? $permission[$this->sms->mod_code]['list'] : 0;
        $data['email'] = isset($this->permission['list']) ? $this->permission['list'] : 0;
     
        $this->load->vars($data);        
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }

	function _list_options_active( $record, &$rec )
	{
		//temp remove until view functionality added
		if( $this->permission['detail'] )
		{
			$rec['detail_url'] = $this->mod->url . '/detail/' . $record['record_id'];
			$rec['options'] .= '<li><a href="'.$rec['detail_url'].'"><i class="fa fa-info"></i> View</a></li>';
			$rec['quickview_url'] = 'javascript:quick_view( '. $record['record_id'] .' )';
		}

		if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}	
		
		if( isset($this->permission['delete']) && $this->permission['delete'] )
		{
			$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
			$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
		}
	}

	function quick_edit( $child_call = false )
	{
		$this->_ajax_only();

		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$this->_quick_edit( $child_call, false );
		$this->_ajax_return();
	}

	private function _quick_edit( $child_call, $new = false )
	{
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
				$data['record'] = $result->row_array();
			}

			$this->load->vars( $data );

			if( !$child_call ){
				$this->load->helper('form');
				$this->load->helper('file');
				
				$data['title'] = $this->mod->short_name .' - View';
				$data['content'] = $this->load->blade('pages.quick_detail')->with( $this->load->get_cached_vars() );

				$this->response->quick_edit_form = $this->load->view('templates/modal', $data, true);

				$this->response->message[] = array(
					'message' => '',
					'type' => 'success'
				);
			}
		}
		else
		{
			$this->load->vars( $data );
			$this->response->message[] = array(
				'message' => $record_check,
				'type' => 'error'
			);
		}	
	}
	
	function save()
	{
		$error = false;
		$post = $_POST;
		$table = $this->mod->table;

		

		$this->response->record_id = $this->record_id =  $post['record_id'];
		unset( $post['record_id'] );
		
		$this->db->where($this->mod->primary_key, $this->record_id);
		$record = $this->db->get($table);

		if( (empty( $this->record_id ) && !$this->permission['add']) || ($this->record_id && !$this->permission['edit']) )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$validation_rules = array();
	
		$validation_rules[] = 
		array(
			'field' => 'system_email_queue[to]',
			'label' => 'To',
			'rules' => 'required'
			);
		
		$validation_rules[] = 
		array(
			'field' => 'system_email_queue[subject]',
			'label' => 'Subject',
			'rules' => 'required'
			);

		if( sizeof( $validation_rules ) > 0 )
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules( $validation_rules );
			if ($this->form_validation->run() == false)
			{
				foreach( $this->form_validation->get_error_array() as $f => $f_error )
				{
					$this->response->message[] = array(
						'message' => $f_error,
						'type' => 'warning'
						);  
				}

				$this->_ajax_return();
			}
		}

        /***** END Form Validation (hard coded) *****/
        //SAVING START   
		$transactions = true;
		if( $transactions )
		{
			$this->db->trans_begin();
		}
		
		$main_record = $post[$this->mod->table];
		$main_record['to'] = implode(',', $post[$this->mod->table]['to']);

		switch( true )
		{				
			case $record->num_rows() == 0:
				$this->db->insert($this->mod->table, $main_record);
				if( $this->db->_error_message() == "" )
				{
					$this->response->record_id = $this->record_id = $this->db->insert_id();
				}
				$this->response->action = 'insert';
				break;
			case $record->num_rows() == 1:
				$this->db->update( $this->mod->table, $main_record, array( $this->mod->primary_key => $this->record_id ) );
				$this->response->action = 'update';
				break;
			default:
				$this->response->message[] = array(
					'message' => lang('common.inconsistent_data'),
					'type' => 'error'
				);
				$error = true;
				goto stop;
		}

	   	stop:
		if( $transactions )
		{
			if( !$error ){
				$this->db->trans_commit();
			}
			else{
				 $this->db->trans_rollback();
			}
		}

		if( !$error  )
		{
			$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
		}

		$this->response->saved = !$error;

        $this->_ajax_return();
	}

}