<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Leave_balance extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('leave_balance_model', 'mod');
		parent::__construct();
        $this->lang->load( 'leave_balance' );
        $this->load->helper('url');
	}

    public function index()
    {

        if( !$this->permission['list'] )
        {
        	// redirect(site_url('time/leave_credit'));
            echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
            die();
        }

        $user_setting = APPPATH . 'config/users/'. $this->user->user_id .'.php';
        $user_id = $this->user->user_id;
        $this->load->config( "users/{$user_id}.php", false, true );
        $user = $this->config->item('user');

        $this->load->config( 'roles/'. $user['role_id'] .'/permission.php', false, true );
        $permission = $this->config->item('permission');

        $this->load->model('leave_credit_model', 'leave_credit');
        $data['leave_credit'] = isset($permission[$this->leave_credit->mod_code]['list']) ? $permission[$this->leave_credit->mod_code]['list'] : 0;
        $data['leave_balance'] = isset($this->permission['list']) ? $this->permission['list'] : 0;
        
        $this->load->model('addtl_leave_credit_model', 'addtl_leave_credit');
        $data['addtl_leave_credit'] = isset($permission[$this->addtl_leave_credit->mod_code]['list']) ? $permission[$this->addtl_leave_credit->mod_code]['list'] : 0;

        $this->load->vars($data);        
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }

	function _list_options_active( $record, &$rec )
	{
		//temp remove until view functionality added
		if( $this->permission['detail'] )
		{
			$this->load->model('leave_filed_model', 'leavef');
			$rec['detail_url'] = $this->leavef->url .'/index/'. $record['time_form_balance_form_id'].'/'. $record['time_form_balance_year'];
			// $rec['options'] .= '<li><a href="'.$rec['detail_url'].'"><i class="fa fa-info"></i> View</a></li>';
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

	
}