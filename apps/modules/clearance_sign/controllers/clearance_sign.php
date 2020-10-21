<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Clearance_sign extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('clearance_sign_model', 'mod');
		parent::__construct();
		$this->lang->load('clearance_signatories');
	}

    function save()
    {

        $transactions = true;
		$error = false;
		$post = $_POST;
		$this->response->record_id = $this->record_id = $post['record_id'];
		unset( $post['record_id'] );

        $validation_rules[] = 
        array(
            'field' => 'partners_clearance_layout[layout_name]',
            'label' => 'Signatory Layout',
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

        if(isset($_POST['partners_clearance_layout']['department_id']))
        {
        	$post['partners_clearance_layout']['department_id'] = implode(',', $_POST['partners_clearance_layout']['department_id']);
        }else{
        	$post['partners_clearance_layout']['department_id'] = 0;
        }

		if( $transactions )
		{
			$this->db->trans_begin();
		}

		//start saving with main table
		$previous_main_data = array();
		$main_record = $post[$this->mod->table];
		$record = $this->db->get_where( $this->mod->table, array( $this->mod->primary_key => $this->record_id ) );
		switch( true )
		{
			case $record->num_rows() == 0:
				//add mandatory fields
				$main_record['created_by'] = $this->user->user_id;
				$this->db->insert($this->mod->table, $main_record);
				if( $this->db->_error_message() == "" )
				{
					$this->response->record_id = $this->record_id = $this->db->insert_id();
				}
				$this->response->action = 'insert';
				break;
			case $record->num_rows() == 1:
				//get previous data for audit logs
				$previous_other_data = $this->db->get_where($this->mod->table, array($this->mod->primary_key => $this->record_id))->row_array();
				$main_record['modified_by'] = $this->user->user_id;
				$main_record['modified_on'] = date('Y-m-d H:i:s');
				$this->db->update( $this->mod->table, $main_record, array( $this->mod->primary_key => $this->record_id ) );
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

		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, $this->response->action, $this->mod->table, $previous_main_data, $main_record);

		if( $this->db->_error_message() != "" ){
			$this->response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
			$error = true;
			goto stop;
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

		if( !$error )
		{
			$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
		}

		$this->response->saved = !$error;

        $this->_ajax_return();
    }
   
    function add_sign()
    {
        $this->_ajax_only();
        
        $vars = $_POST;
		// $record['user_id']
		if($vars['sign_id']){
			$record = $this->db->get_where( 'partners_clearance_layout_sign', array( 'clearance_layout_sign_id' => $vars['sign_id'] ) )->row_array();
		}else{
			$record['user_id'] = 0;
			$record['panel_title'] = '';
			$record['clearance_layout_id'] = $vars['record_id'];
			$record['clearance_layout_sign_id'] = '';
			$record['item_description'] = '';
			$record['properties_tagging'] = $vars['properties_tag'];
			$record['company_id'] = '';
			$record['department_id'] = '';
			$record['is_immediate'] = 0;
		}
        // echo "<pre>";print_r($record);

        $this->load->vars($record);
		$this->load->helper('form');
		$this->load->helper('file');

        $data['title'] = 'Clearance Signatories';
        $data['content'] = $this->load->blade('edit.sign')->with( $this->load->get_cached_vars() );

        $this->response->sign = $this->load->view('templates/modal', $data, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

    function save_sign()
    {

		$sign_table = 'partners_clearance_layout_sign';
		$sign_key = 'clearance_layout_sign_id';
        $transactions = true;
		$error = false;
		$post = $_POST;
		$this->response->record_id = $this->record_id = $post[$sign_table]['clearance_layout_sign_id'];
		$this->response->clearance_layout_id = $this->clearance_layout_id = $post[$sign_table]['clearance_layout_id'];

        $validation_rules[] = 
        array(
            'field' => 'partners_clearance_layout_sign[item_description]',
            'label' => 'Item / Description',
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

		if( $transactions )
		{
			$this->db->trans_begin();
		}

		$post[$sign_table]['panel_title'] = $post[$sign_table]['item_description'];

		//start saving with main table
		$main_record = $post[$sign_table];
		$record = $this->db->get_where( $sign_table, array( $sign_key => $this->record_id ) );
		switch( true )
		{
			case $record->num_rows() == 0:
				//add mandatory fields
				// $main_record['created_by'] = $this->user->user_id;
				$this->db->insert($sign_table, $main_record);
				if( $this->db->_error_message() == "" )
				{
					$this->response->record_id = $this->record_id = $this->db->insert_id();
				}
				$this->response->action = 'insert';
				break;
			case $record->num_rows() == 1:
				// $main_record['modified_by'] = $this->user->user_id;
				// $main_record['modified_on'] = date('Y-m-d H:i:s');
				$this->db->update( $sign_table, $main_record, array( $sign_key => $this->record_id ) );
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

		if( !$error )
		{
			$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
		}

		$this->response->saved = !$error;

        $this->_ajax_return();
    }

    function get_signatories(){

		$sign_table = 'partners_clearance_layout_sign';
		$sign_key = 'clearance_layout_id';
		$record = $this->db->get_where( $sign_table, array( $sign_key => $this->input->post('clearance_layout_id'), 'deleted' => 0, 'properties_tagging' => 0) );

		$this->load->helper('form');
		$this->load->helper('file');
		$sign_record['records'] = $record->result_array();

  //       $this->load->vars($sign_record);
		// $content = $this->load->blade('edit.signatory')->with( $this->load->get_cached_vars() );

		$record_head_office = $this->db->get_where( $sign_table, array( $sign_key => $this->input->post('clearance_layout_id'), 'deleted' => 0, 'properties_tagging' => 1) );
		$sign_record_head_office['records'] = $record_head_office->result_array();

        $this->response->signatory = $this->load->view('edit/signatory', $sign_record, true);

        $this->response->signatory_head_office = $this->load->view('edit/signatory', $sign_record_head_office, true);
    
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

    function get_detail_signatories(){

		$sign_table = 'partners_clearance_layout_sign';
		$sign_key = 'clearance_layout_id';
		$record = $this->db->get_where( $sign_table, array( $sign_key => $this->input->post('clearance_layout_id'), 'deleted' => 0, 'properties_tagging' => 0) );

		$this->load->helper('form');
		$this->load->helper('file');
		$sign_record['records'] = $record->result_array();

  //       $this->load->vars($sign_record);
		// $content = $this->load->blade('edit.signatory')->with( $this->load->get_cached_vars() );

		$record_head_office = $this->db->get_where( $sign_table, array( $sign_key => $this->input->post('clearance_layout_id'), 'deleted' => 0, 'properties_tagging' => 1) );
		$sign_record_head_office['records'] = $record_head_office->result_array();

        $this->response->signatory = $this->load->view('detail/signatory', $sign_record, true);
    
    	$this->response->signatory_head_office = $this->load->view('edit/signatory', $sign_record_head_office, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

	function delete_signatories( )
	{
		// $data['modified_on'] = date('Y-m-d H:i:s');
		// $data['modified_by'] = $this->user->user_id;

		$sign_table = 'partners_clearance_layout_sign';
		$sign_key = 'clearance_layout_sign_id';
		$data['deleted'] = 1;

		$this->db->where_in($sign_key, $_POST['records']);
		$this->db->update($sign_table, $data);
		
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

        $this->_ajax_return();  
	}

	function get_partners()
	{
		$this->_ajax_only();

		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		$options = '';
		$this->db->select('users_profile.user_id, users.full_name');
		$this->db->join('users','users_profile.user_id = users.user_id', 'left');
		$users = $this->db->get_where( 'users_profile', array( 'users_profile.department_id' => $this->input->post('department_id') ) );
		if( $users && $users->num_rows() > 0 ){
			foreach ($users->result() as $key => $value) {
				$options .= '<option value="'.$value->user_id.'">'.$value->full_name.'</option>';
			}
		}		
		$this->response->options = $options;
		// echo"<pre>";print_r($this->response->options);exit;
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}
	
}