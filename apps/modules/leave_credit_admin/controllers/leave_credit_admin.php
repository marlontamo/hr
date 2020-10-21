<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Leave_credit_admin extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('leave_credit_admin_model', 'mod');
		parent::__construct();
        $this->lang->load( 'leave_balance' );
        $this->lang->load( 'leave_balance_admin' );
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

        $this->load->model('leave_balance_admin_model', 'leave_balance');
        $data['leave_balance_admin'] = isset($permission[$this->leave_balance->mod_code]['list']) ? $permission[$this->leave_balance->mod_code]['list'] : 0;
        $data['leave_credit_admin'] = isset($this->permission['list']) ? $this->permission['list'] : 0;

        $this->load->vars($data);        
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }

    public function addl_list()
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

        $this->load->model('leave_balance_admin_model', 'leave_balance');
        $data['leave_balance_admin'] = isset($permission[$this->leave_balance->mod_code]['list']) ? $permission[$this->leave_balance->mod_code]['list'] : 0;
        $data['leave_credit_admin'] = isset($this->permission['list']) ? $this->permission['list'] : 0;

        $this->load->vars($data);        
        echo $this->load->blade('pages.addl_listing')->with( $this->load->get_cached_vars() );
    }

    public function special_list()
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

        $this->load->model('leave_balance_admin_model', 'leave_balance');
        $data['leave_balance_admin'] = isset($permission[$this->leave_balance->mod_code]['list']) ? $permission[$this->leave_balance->mod_code]['list'] : 0;
        $data['leave_credit_admin'] = isset($this->permission['list']) ? $this->permission['list'] : 0;

        $this->load->vars($data);        
        echo $this->load->blade('pages.special_listing')->with( $this->load->get_cached_vars() );
    }

    public function sick_list()
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

        $this->load->model('leave_balance_admin_model', 'leave_balance');
        $data['leave_balance_admin'] = isset($permission[$this->leave_balance->mod_code]['list']) ? $permission[$this->leave_balance->mod_code]['list'] : 0;
        $data['leave_credit_admin'] = isset($this->permission['list']) ? $this->permission['list'] : 0;

        $this->load->vars($data);        
        echo $this->load->blade('pages.sick_listing')->with( $this->load->get_cached_vars() );
    }

	function _list_options_active( $record, &$rec )
	{
		//temp remove until view functionality added
		if( $this->permission['detail'] )
		{
			if( in_array(strtoupper($record['form_code']), array('ADDL')) ){
				$this->load->model('addtl_credit_admin_model', 'addtl_credit');
				$rec['detail_url'] = $this->addtl_credit->url .'/index/'. $record['user_id'];
			}else{
				$this->load->model('leave_filed_period_admin_model', 'leavef');
				$rec['detail_url'] = $this->leavef->url .'/index?form_id='. $record['time_form_balance_form_id'].'&leave_balance_id='. $record['record_id'];
			}
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


	public function get_list()
	{
		$this->_ajax_only();
		if( !$this->permission['list'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$this->response->show_import_button = false;
		if( $this->input->post('page') == 1 )
		{
			$this->load->model('upload_utility_model', 'import');
			if( $this->import->get_templates( $this->mod->mod_id ) )
				$this->response->show_import_button = true;
		}
		
		$trash = $this->input->post('trash') == 'true' ? true : false;

		$records = $this->_get_list( $trash );
		$this->_process_lists( $records, $trash );

		$this->_ajax_return();
	}

	private function _process_lists( $records, $trash )
	{
		$this->response->records_retrieve = sizeof($records);
		$this->response->list = '';
		foreach( $records as $record )
		{
			$rec = array(
				'detail_url' => '#',
				'edit_url' => '#',
				'delete_url' => '#',
				'options' => ''
			);

			if(!$trash)
				$this->_list_options_active( $record, $rec );
			else
				$this->_list_options_trash( $record, $rec );

			$record = array_merge($record, $rec);
			$this->response->list .= $this->load->blade('list_template', $record, true)->with( $this->load->get_cached_vars() );
		}
	}

	private function _get_list( $trash )
	{
		$page = $this->input->post('page');
		$search = $this->input->post('search');
		$filter = "";
		
		$filter_by = $this->input->post('filter_by');
		$filter_value = $this->input->post('filter_value');
		
		if( is_array( $filter_by ) )
		{
			foreach( $filter_by as $filter_by_key => $filter_value )
			{
				if( $filter_value != "" ) $filter = 'AND '. $filter_by_key .' = "'.$filter_value.'"';	
			}
		}
		else{
			if( $filter_by && $filter_by != "" )
			{
				$filter = 'AND '. $filter_by .' = "'.$filter_value.'"';
			}
		}

		if( $page == 1 )
		{
			$searches = $this->session->userdata('search');
			if( $searches ){
				foreach( $searches as $mod_code => $old_search )
				{
					if( $mod_code != $this->mod->mod_code )
					{
						$searches[$this->mod->mod_code] = "";
					}
				}
			}
			$searches[$this->mod->mod_code] = $search;
			$this->session->set_userdata('search', $searches);
		}
		

		$balance_qry = "SELECT * FROM {$this->db->dbprefix}{$this->mod->table} 
		WHERE 1=1 "; // WHERE user_id = '$userID';
		if( $trash )
		{
			$balance_qry .= " AND {$this->db->dbprefix}{$this->mod->table}.deleted = 1";
		}
		else{
			$balance_qry .= " AND {$this->db->dbprefix}{$this->mod->table}.deleted = 0";	
		}
		$balance_result = $this->db->query($balance_qry);
		
		if($balance_result->num_rows() > 0){
			$limit = $balance_result->num_rows();
		}

		$page = ($page-1) * $limit;		
		$records = $this->mod->_get_list($page, $limit, $search, $filter, $trash, $_GET['list_view']);
		return $records;
	}
	
	function save()
	{
		//validate if duplicate entry (user, form, year)
		$record_id_check = $this->input->post('record_id');
		$time_form_balance = $this->input->post('time_form_balance');

		$is_exist_sql = "SELECT *
							FROM ww_time_form_balance tb WHERE deleted=0
								AND user_id = {$time_form_balance['user_id']}
								AND form_id = {$time_form_balance['form_id']}
								AND year = {$time_form_balance['year']}
								
								";	
		if($this->input->post('record_id') > 0){
			$is_exist_sql .= " AND id != {$record_id_check}";
		}

		$result_exist = $this->db->query( $is_exist_sql );
		$is_exist = $result_exist->num_rows();
		
		if($is_exist > 0){
			$this->response->message[] = array(
				'message' => "Duplicate entry! <br>Leave balance for the selected employee already created",
				'type' => 'warning'
			);
		$this->_ajax_return();
		}

		parent::save( true );
		if( $this->response->saved )
        {        	
        	$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
        }
        $this->_ajax_return();
	}
}