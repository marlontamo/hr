<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Nte_admin extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('nte_admin_model', 'mod');
		parent::__construct();
        $this->lang->load( 'nte_admin' );
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

        $this->load->model('nte_model', 'nte_per');
        $data['nte_report'] = isset($permission[$this->nte_per->mod_code]['list']) ? $permission[$this->nte_per->mod_code]['list'] : 0;
        $data['nte_admin'] = isset($this->permission['list']) ? $this->permission['list'] : 0;
        $this->load->model('nte_manage_model', 'nte_ad');
        $data['nte_manage'] = isset($permission[$this->nte_ad->mod_code]['list']) ? $permission[$this->nte_ad->mod_code]['list'] : 0;
     
        $this->load->vars($data);        
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }

    function save()
    {
        $_POST['partners_incident']['incident_status_id'] = $_POST['incident_status_id'];
        unset($_POST['incident_status_id']);

        switch ($_POST['partners_incident']['incident_status_id']){
			case 6:
				$saved_message = 'saved and/or updated';
				$_POST['partners_incident']['status'] = 'Close';
			break;
			case 10:
				$saved_message = 'forwarded for hearing schedule';
			break;
			case 11:
				$saved_message = 'forwarded for disciplinary action';
			break;
        }
		// echo "<pre>";
		// print_r($_POST);
		// exit();

        parent::save( true );        
        $this->response->message[] = array(
            'message' => "Record successfully {$saved_message}.",
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
            $data['coc_process'] = $this->mod->coc_process;
            
			$iquery = "SELECT inte.*, users.full_name FROM {$this->db->dbprefix}partners_incident_nte inte
						LEFT JOIN users ON inte.user_id = users.user_id AND inte.category IN ('immediate')
						WHERE inte.{$this->mod->primary_key} = {$this->record_id} 
						AND inte.category IN ('immediate')"; 
            $get_immediate = $this->db->query( $iquery )->row_array();

            // $get_immediate = $this->db->get_where( 'partners_incident_nte', array( $this->mod->primary_key => $this->record_id, 'category' => 'immediate') )->row_array();
            $data['record']['immediate_explanation'] = $get_immediate;

            $get_involved = $this->db->get_where( 'partners_incident_nte', array( $this->mod->primary_key => $this->record_id, 'category' => 'partner') )->row_array();
            $data['record']['involved_explanation'] = $get_involved;

            $wquery = "SELECT inte.*, users.full_name FROM {$this->db->dbprefix}partners_incident_nte inte
                        LEFT JOIN users ON inte.user_id = users.user_id AND inte.category IN ('witness', 'others')
                        WHERE inte.{$this->mod->primary_key} = {$this->record_id} 
                        AND inte.category IN ('witness', 'others')"; 
            $get_witnesses = $this->db->query( $wquery )->result_array();
            $data['record']['witnesses_explanation'] = $get_witnesses;

            $cquery = "SELECT inte.*, users.full_name FROM {$this->db->dbprefix}partners_incident_nte inte
                        LEFT JOIN users ON inte.user_id = users.user_id AND inte.category IN ('complainants')
                        WHERE inte.{$this->mod->primary_key} = {$this->record_id} 
                        AND inte.category IN ('complainants')"; 
            $get_complainants = $this->db->query( $cquery )->result_array();
            $data['record']['complainants_explanation'] = $get_complainants;

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