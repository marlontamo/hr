<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Competency_libraries extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('competency_libraries_model', 'mod');
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
        $this->load->model('appraisal_master_model', 'app_master');
        $this->load->model('competency_level_model', 'com_lev');
        $user_setting = APPPATH . 'config/users/'. $this->user->user_id .'.php';
        $user_id = $this->user->user_id;
        $this->load->config( "users/{$user_id}.php", false, true );
        $user = $this->config->item('user');

        $this->load->config( 'roles/'. $user['role_id'] .'/permission.php', false, true );
        $permission = $this->config->item('permission');
        $data['permission_competency_values'] = isset($permission[$this->com_val->mod_code]['list']) ? $permission[$this->com_val->mod_code]['list'] : 0;
        $data['permission_competency_libraries'] = isset($this->permission['list']) ? $this->permission['list'] : 0;
        $data['permission_competency_level'] = isset($permission[$this->com_lev->mod_code]['list']) ? $permission[$this->com_lev->mod_code]['list'] : 0;
        $data['permission_appraisal_master'] = isset($permission[$this->app_master->mod_code]['list']) ? $permission[$this->app_master->mod_code]['list'] : 0;

        $this->db->order_by('competency_category', 'asc');
        $competency_category = $this->db->get_where('performance_competency_category', array('deleted' => 0));
        $data['competency_categories'] = $competency_category->result();
        
        $this->load->vars($data);        
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }

    function update_values()
    {
        $this->_ajax_only();

        $values_qry = "SELECT * 
            FROM {$this->db->dbprefix}performance_competency_values 
            WHERE competency_category_id =".$this->input->post('category_id');
        $values = $this->db->query($values_qry);
        
        $this->response->values = '<option value="" selected="selected">Select...</option>';

        foreach( $values->result() as $value )
        {
            $this->response->values .= '<option value="'.$value->competency_values_id.'">'.$value->competency_values.'</option>';
        }

        $this->_ajax_return();  
    }

}