<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Erequest extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('erequest_model', 'mod');
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

        $data['erequest'] = isset($this->permission['list']) ? $this->permission['list'] : 0;

        $this->load->model('erequest_admin_model', 'erequest_ad');
        $data['erequest_admin'] = isset($permission[$this->erequest_ad->mod_code]['list']) ? $permission[$this->erequest_ad->mod_code]['list'] : 0;
     
        $this->load->vars($data);        
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }

	function save()
	{
		$_POST['resources_request']['request_status_id'] = $_POST['request_status_id'];
		$_POST['resources_request']['user_id'] = $this->user->user_id;
		$uploads = $_POST['resources_request_upload'];
		unset($_POST['resources_request_upload']);
		unset($_POST['request_status_id']);

		//date sent
		// if($_POST['resources_request']['request_status_id'] == 6){
		// }
		//closed if cancelled
		if($_POST['resources_request']['request_status_id'] == 6){
			$_POST['resources_request']['status'] = 'Close';
			$saved_message = 'cancelled';
		}else{
			$saved_message = 'saved and/or updated';
		}

		parent::save( true );
		
		if( $this->response->saved )
		{
			$where = array(
				'request_id' => $this->record_id,
			);
			$this->db->delete('resources_request_upload', $where);

			if( count($uploads['upload_id']) > 0 )
			{
				$uploads = explode(',', $uploads['upload_id']);
				foreach( $uploads as $upload_id )
				{
					$insert = array(
						'request_id' => $this->record_id,
						'upload_id' => $upload_id
					);
					$this->db->insert('resources_request_upload', $insert);
				}
			}
			if($_POST['resources_request']['request_status_id'] == 2){				
				$populate_erequest_approvers = "CALL sp_resources_request_populate_approvers({$this->record_id}, {$this->user->user_id})";
				$result_update = $this->db->query( $populate_erequest_approvers );
				mysqli_next_result($this->db->conn_id);
			}

            $erequest_details = $this->mod->get_erequest_details($this->record_id);
            if(in_array($_POST['resources_request']['request_status_id'], array(2,6))){
                //INSERT NOTIFICATIONS FOR APPROVERS
                $this->response->notified = $this->mod->notify_approvers( $this->record_id, $erequest_details );
                $this->response->notified = $this->mod->notify_filer( $this->record_id, $erequest_details );
            }
		}

		$this->response->message[] = array(
			'message' => "Record was successfully {$saved_message}.",
			'type' => 'success'
		);

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

			$uploads = array();
        	$upload_sql = $this->db->get_where( 'resources_request_upload', array( $this->mod->primary_key => $this->record_id ) )->result_array();
			foreach( $upload_sql as $index => $value )
			{
				$uploads[] = $value['upload_id'];
			}
			// echo "<pre>";
			// print_r($data);
			$data['record']['resources_request_upload.upload_id'] = implode(',', $uploads);
			$data['record']['view'] = 'edit';
        	$data['notes'] = $this->mod->get_notes($this->record_id, $this->user->user_id);
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

	function _list_options_active( $record, &$rec )
	{
		//temp remove until view functionality added
		if( $this->permission['detail'] )
		{
			$rec['detail_url'] = $this->mod->url . '/detail/' . $record['record_id'];
			$rec['options'] .= '<li><a href="'.$rec['detail_url'].'"><i class="fa fa-info"></i> View</a></li>';
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
	
	public function detail( $record_id, $child_call = false )
	{
		if( !$this->permission['detail'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_detail( $child_call );
	}

	private function _detail( $child_call )
	{
		if( !$this->_set_record_id() )
		{
			echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->record_id = $data['record_id'] = $_POST['record_id'];
		
		$record_check = $this->mod->_exists( $this->record_id );
		if( $record_check === true )
		{
			$result = $this->mod->_get( 'detail', $this->record_id );
			$data['record'] = $result->row_array();

			$uploads = array();
        	$upload_sql = $this->db->get_where( 'resources_request_upload', array( $this->mod->primary_key => $this->record_id ) )->result_array();
			foreach( $upload_sql as $index => $value )
			{
				$uploads[] = $value['upload_id'];
			}
			// echo "<pre>";
			// print_r($data);
			$data['record']['resources_request_upload.upload_id'] = implode(',', $uploads);
			$data['record']['view'] = 'detail';

        	$data['notes'] = $this->mod->get_notes($this->record_id, $this->user->user_id);
			$this->load->vars( $data );

			if( !$child_call ){
				if( !IS_AJAX )
				{
					$this->load->helper('form');
					$this->load->helper('file');
					echo $this->load->blade('pages.detail')->with( $this->load->get_cached_vars() );
				}
				else{
					$data['title'] = $this->mod->short_name .' - Detail';
					$data['content'] = $this->load->blade('pages.quick_detail')->with( $this->load->get_cached_vars() );

					$this->response->html = $this->load->view('templates/modal', $data, true);

					$this->response->message[] = array(
						'message' => '',
						'type' => 'success'
					);
					$this->_ajax_return();
				}
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

    public function submitDiscussion(){

        $this->_ajax_only();
        $data = array();

        $insert = array(
            'request_id' => $this->input->post('request_id'),
            'user_id' => $this->input->post('user_id'),
            'notes' => $this->input->post('discussion_notes'),
            'created_by' => $this->user->user_id,
            'created_on' => date('Y-m-d H:i:s')
        );

        $this->db->insert('resources_request_notes', $insert);
          // GET LATEST POSTED DATA AND RETURN IT BACK TO THE UI
        $new_notes_qry = " SELECT ud.department, CONCAT(up.lastname, ', ', up.firstname) as full_name, 
                    gettimeline('{$insert['created_on']}') as timeline, {$insert['created_by']} as created_by,
                    {$insert['user_id']} as user_id, up.photo
                    FROM {$this->db->dbprefix}users_profile up
                    LEFT JOIN {$this->db->dbprefix}users_department ud on ud.department_id = up.department_id 
                    WHERE up.user_id = {$this->user->user_id}";
                    
        $data['note'] = $this->db->query($new_notes_qry)->row_array();
        $data['note']['notes'] = $insert['notes'];
        $this->response->new_discussion   = $this->load->view('customs/new_discussion', $data, true);

        $this->response->message[] = array(
            'message' => 'Discussion successfully added.',
            'type' => 'success'
        );


        $this->_ajax_return();  
    }

}