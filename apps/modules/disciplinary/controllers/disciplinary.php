<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Disciplinary extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('disciplinary_model', 'mod');
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

        $this->load->model('disciplinary_admin_model', 'disciplinary_per');
        $data['disciplinary_admin'] = isset($permission[$this->disciplinary_per->mod_code]['list']) ? $permission[$this->disciplinary_per->mod_code]['list'] : 0;
        $this->load->model('disciplinary_manage_model', 'disciplinary_mng');
        $data['disciplinary_manage'] = isset($permission[$this->disciplinary_mng->mod_code]['list']) ? $permission[$this->disciplinary_mng->mod_code]['list'] : 0;
        $data['disciplinary_report'] = isset($this->permission['list']) ? $this->permission['list'] : 0;

        $this->load->vars($data);        
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }

    function save()
    {
        $_POST['partners_incident']['incident_status_id'] = $_POST['incident_status_id'];
        unset($_POST['incident_status_id']);

        $_POST['partners_incident']['status'] = 'Close';
        $saved_message = 'served';

        $validation_rules[] = 
        array(
            'field' => 'partners_disciplinary_action[sanction_id]',
            'label' => 'Sanction',
            'rules' => 'required'
            );
        $validation_rules[] = 
        array(
            'field' => 'partners_disciplinary_action[remarks]',
            'label' => 'Remarks',
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

        $disciplinary = $_POST['partners_disciplinary_action'];
        unset($_POST['partners_disciplinary_action']);
        
        parent::save( true );
        if( $this->response->saved )
        {
            $disciplinary[$this->mod->primary_key] = $this->record_id; 
            $disciplinary['date_from'] = date('Y-m-d', strtotime($disciplinary['date_from'])); 
            $disciplinary['date_to'] = date('Y-m-d', strtotime($disciplinary['date_to']));            
			$record = $this->db->get_where( 'partners_disciplinary_action', array( $this->mod->primary_key => $this->record_id ) );
			switch( true )
			{
				case $record->num_rows() == 0:
					//add mandatory fields
					$disciplinary['created_by'] = $this->user->user_id;
					$this->db->insert('partners_disciplinary_action', $disciplinary);
					if( $this->db->_error_message() == "" )
					{
						$this->response->record_id = $this->record_id = $this->db->insert_id();
					}
					$this->response->action = 'insert';
					break;
				case $record->num_rows() == 1:
					$disciplinary['modified_by'] = $this->user->user_id;
					$disciplinary['modified_on'] = date('Y-m-d H:i:s');
					$this->db->update( 'partners_disciplinary_action', $disciplinary, array( $this->mod->primary_key => $this->record_id ) );
					$this->response->action = 'update';
					break;
				default:
					$this->response->message[] = array(
						'message' => lang('common.inconsistent_data'),
						'type' => 'error'
					);
        			$this->_ajax_return();
			}
        }

        $this->response->message[] = array(
            'message' => "Record was successfully {$saved_message}.",
            'type' => 'success'
        );

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