<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sms_queue extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('sms_queue_model', 'mod');
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

        $this->load->model('email_queue_model', 'email');
        $data['email'] = isset($permission[$this->email->mod_code]['list']) ? $permission[$this->email->mod_code]['list'] : 0;
        $data['sms'] = isset($this->permission['list']) ? $this->permission['list'] : 0;
     
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
				$data['content'] = $this->load->blade('pages.quick_edit')->with( $this->load->get_cached_vars() );

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
}