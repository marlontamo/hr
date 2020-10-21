<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Scorecard extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('scorecard_model', 'mod');
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

        $data['allow_scorecard'] = isset($this->permission['list']) ? $this->permission['list'] : 0;
        $this->load->model('performance_notification_model', 'notif');
        $data['allow_notification'] = isset($permission[$this->notif->mod_code]['list']) ? $permission[$this->notif->mod_code]['list'] : 0;
        $this->load->model('performance_model', 'perform');
        $data['allow_performance'] = isset($permission[$this->perform->mod_code]['list']) ? $permission[$this->perform->mod_code]['list'] : 0;
        $this->load->model('rating_group_model', 'rate');
        $data['allow_rating_scale'] = isset($permission[$this->rate->mod_code]['list']) ? $permission[$this->rate->mod_code]['list'] : 0;
        $this->load->model('library_model', 'lib');
        $data['allow_library'] = isset($permission[$this->lib->mod_code]['list']) ? $permission[$this->lib->mod_code]['list'] : 0;

        $this->load->vars($data);        
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }


    function delete()
    {
        $this->_ajax_only();
        
        if( !$this->permission['delete'] )
        {
            $this->response->message[] = array(
                'message' => lang('common.insufficient_permission'),
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        if( !$this->input->post('records') )
        {
            $this->response->message[] = array(
                'message' => lang('common.insufficient_data'),
                'type' => 'warning'
            );
            $this->_ajax_return();  
        }

        $records = $this->input->post('records');
        $records = explode(',', $records);

        $this->db->where_in($this->mod->primary_key, $records);
        $record = $this->db->get( $this->mod->table )->result_array();

        foreach($record as $rec){
            if($rec['can_delete'] == 1){
                $data['modified_on'] = date('Y-m-d H:i:s');
                $data['modified_by'] = $this->user->user_id;
                $data['deleted'] = 1;

                $this->db->where($this->mod->primary_key, $rec[$this->mod->primary_key]);
                $this->db->update($this->mod->table, $data);
                
                if( $this->db->_error_message() != "" ){
                    $this->response->message[] = array(
                        'message' => $this->db->_error_message(),
                        'type' => 'error'
                    );
                }
                else{
                    $this->response->message[] = array(
                        'message' => lang('common.delete_record', $this->db->affected_rows()),
                        'type' => 'success'
                    );
                }
            }else{
                $this->response->message[] = array(
                    'message' => 'Record(s) cannot be deleted.',
                    'type' => 'warning'
                );
            }
        }

        $this->_ajax_return();
    }

}