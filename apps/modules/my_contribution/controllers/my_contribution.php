<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_contribution extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('my_contribution_model', 'mod');
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

        $data['contribution'] = isset($this->permission['list']) ? $this->permission['list'] : 0;
        $this->load->model('my_payslip_model', 'payslip');
        $data['payslip'] = isset($permission[$this->payslip->mod_code]['list']) ? $permission[$this->payslip->mod_code]['list'] : 0;
        $this->load->model('my_tax_model', 'tax');
        $data['tax'] = isset($permission[$this->tax->mod_code]['list']) ? $permission[$this->tax->mod_code]['list'] : 0;
        $this->load->model('my_loans_model', 'loan');
        $data['loan'] = isset($permission[$this->loan->mod_code]['list']) ? $permission[$this->loan->mod_code]['list'] : 0;

        $this->load->vars($data);        
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }
}