<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Appraisal_master extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('appraisal_master_model', 'mod');
		parent::__construct();
	}

    public function index()
    {

        if( !$this->permission['list'] )
        {
            echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
            die();
        }

        $this->load->model('competency_values_model', 'com_val');
        $this->load->model('competency_libraries_model', 'com_lib');
        $this->load->model('competency_level_model', 'com_lev');
        $user_setting = APPPATH . 'config/users/'. $this->user->user_id .'.php';
        $user_id = $this->user->user_id;
        $this->load->config( "users/{$user_id}.php", false, true );
        $user = $this->config->item('user');

        $this->load->config( 'roles/'. $user['role_id'] .'/permission.php', false, true );
        $permission = $this->config->item('permission');
        $data['permission_competency_values'] = isset($permission[$this->com_val->mod_code]['list']) ? $permission[$this->com_val->mod_code]['list'] : 0;
        $data['permission_competency_libraries'] = isset($permission[$this->com_lib->mod_code]['list']) ? $permission[$this->com_lib->mod_code]['list'] : 0;
        $data['permission_competency_level'] = isset($permission[$this->com_lev->mod_code]['list']) ? $permission[$this->com_lev->mod_code]['list'] : 0;
        $data['permission_appraisal_master'] = isset($this->permission['list']) ? $this->permission['list'] : 0;


        $this->load->vars($data);        
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }
}