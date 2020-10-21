<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Nte extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('nte_model', 'mod');
		parent::__construct();
        $this->lang->load( 'nte' );
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

        $this->load->model('nte_manage_model', 'nte_per');
        $data['nte_manage'] = isset($permission[$this->nte_per->mod_code]['list']) ? $permission[$this->nte_per->mod_code]['list'] : 0;
        $data['nte_report'] = isset($this->permission['list']) ? $this->permission['list'] : 0;
        $this->load->model('nte_admin_model', 'nte_ad');
        $data['nte_admin'] = isset($permission[$this->nte_ad->mod_code]['list']) ? $permission[$this->nte_ad->mod_code]['list'] : 0;
        
        $data['coc_process'] = $this->mod->coc_process;
        
        $this->load->vars($data);        
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }

    function save()
    {

        $validation_rules[] = 
        array(
            'field' => 'partners_incident_nte[explanation]',
            'label' => 'Explanation',
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

        $_POST['partners_incident_nte']['nte_status_id'] = $_POST['incident_status_id'];
        unset($_POST['incident_status_id']);
        $_POST['partners_incident']['deleted'] = 0;
		$saved_message = 'saved and/or updated';
        
		$error = false;
		$post = $_POST;
		$this->response->record_id = $this->record_id = $post['record_id'];
		unset( $post['record_id'] );

		$transactions = true;

		if( $transactions )
		{
			$this->db->trans_begin();
		}

		//start saving with main table
		$main_record = $_POST['partners_incident_nte'];
		$record = $this->db->get_where( 'partners_incident_nte', array( $this->mod->primary_key => $this->record_id, 'user_id' => $this->user->user_id) );

		switch( true )
		{
			case $record->num_rows() == 1:
				// $main_record['modified_by'] = $this->user->user_id;
				// $main_record['modified_on'] = date('Y-m-d H:i:s');
				$this->db->update( 'partners_incident_nte', $main_record, array( $this->mod->primary_key => $this->record_id, 'user_id' => $this->user->user_id ) );
				$this->response->action = 'update';
				break;
            case $record->num_rows() == 2:
                $this->db->update( 'partners_incident_nte', $main_record, array( $this->mod->primary_key => $this->record_id, 'user_id' => $this->user->user_id, 'category' => 'others') );
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

		if( $this->db->_error_message() != "" ){
			$this->response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
			$error = true;
			goto stop;
		}

        $incident_details = $this->mod->get_incident_details($this->record_id);
        if(in_array($_POST['partners_incident_nte']['nte_status_id'], array(2))){
            //INSERT NOTIFICATIONS FOR APPROVERS
            switch ($this->mod->coc_process) {
                case 'immediate':
                    //$this->response->notified = $this->mod->notify_hr( $this->record_id, $incident_details );
                    $this->response->notified = $this->mod->notify_immediate( $this->record_id, $incident_details );
                    break;
                default:
                    $this->response->notified = $this->mod->notify_approvers( $this->record_id, $incident_details );
                    $this->response->notified = $this->mod->notify_filer( $this->record_id, $incident_details );
                    $this->response->notified = $this->mod->notify_hr( $this->record_id, $incident_details );                    
                    break;
            } 
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

        $this->response->message[] = array(
            'message' => "Record was successfully {$saved_message}.",
            'type' => 'success'
        );

		$this->response->saved = !$error;
        $this->_ajax_return();
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
            $data['coc_process'] = $this->mod->coc_process;

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
}