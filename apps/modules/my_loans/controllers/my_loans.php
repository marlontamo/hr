<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_loans extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('my_loans_model', 'mod');
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

        $data['loan'] = isset($this->permission['list']) ? $this->permission['list'] : 0;
        $this->load->model('my_payslip_model', 'payslip');
        $data['payslip'] = isset($permission[$this->payslip->mod_code]['list']) ? $permission[$this->payslip->mod_code]['list'] : 0;
        $this->load->model('my_contribution_model', 'contribution');
        $data['contribution'] = isset($permission[$this->contribution->mod_code]['list']) ? $permission[$this->contribution->mod_code]['list'] : 0;
		$this->load->model('my_tax_model', 'tax');
        $data['tax'] = isset($permission[$this->tax->mod_code]['list']) ? $permission[$this->tax->mod_code]['list'] : 0;
        
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
            $data['payments'] = array();

            $pay_qry = " SELECT * FROM partner_loan_payment 
                        WHERE {$this->mod->primary_key} = {$this->record_id} 
                        ORDER BY date_paid DESC";
            $payments = $this->db->query($pay_qry);
            if($payments->num_rows() > 0){
                $data['payments'] = $payments->result_array();
            }
            $this->load->vars( $data );
            // print_r($data);exit();
            if( !$child_call ){
                if( !IS_AJAX )
                {
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