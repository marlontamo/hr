<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Exit_interview_manager extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('exit_interview_manager_model', 'mod');
		parent::__construct();
		$this->lang->load('exit_interview');
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
            'field' => 'partners_clearance_exit_interview_layout[layout_name]',
            'label' => 'Questionaire Title',
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
				$previous_main_data = $this->db->get_where($this->mod->table, array($this->mod->primary_key => $this->record_id))->row_array();
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
			$record = $this->db->get_where( 'partners_clearance_exit_interview_layout_item', array( 'exit_interview_layout_item_id' => $vars['sign_id'] ) )->row_array();
		}else{
			$record['user_id'] = 0;
			$record['item'] = '';
			$record['wiht_yes_no'] = 0;
			$record['exit_interview_layout_id'] = $vars['record_id'];
			$record['exit_interview_layout_item_id'] = '';
		}
        // echo "<pre>";print_r($record);

        $this->load->vars($record);
		$this->load->helper('form');
		$this->load->helper('file');

        $data['title'] = 'Exit Interview';
        $data['content'] = $this->load->blade('edit.sign')->with( $this->load->get_cached_vars() );

        $this->response->sign = $this->load->view('templates/modal', $data, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

    function add_sign_sub()
    {
        $this->_ajax_only();
        
        $vars = $_POST;
		$record = array();

		if($vars['exit_interview_layout_item_sub_id']){
			$record = $this->db->get_where( 'partners_clearance_exit_interview_layout_item_sub', array( 'exit_interview_layout_item_sub_id' => $vars['exit_interview_layout_item_sub_id'] ) )->row_array();
		}

		$record['exit_interview_layout_item_sub_id'] = $vars['exit_interview_layout_item_sub_id'];
		$record['exit_interview_layout_item_id'] = $vars['exit_interview_layout_item_id'];

        $this->load->vars($record);
		$this->load->helper('form');
		$this->load->helper('file');

        $data['title'] = 'Exit Interview';
        $data['content'] = $this->load->blade('edit.sub_sign')->with( $this->load->get_cached_vars() );

        $this->response->sign = $this->load->view('templates/modal', $data, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

    function save_sign()
    {

		$sign_table = 'partners_clearance_exit_interview_layout_item';
		$sign_key = 'exit_interview_layout_item_id';
        $transactions = true;
		$error = false;
		$post = $_POST;
		$this->response->record_id = $this->record_id = $post[$sign_table]['exit_interview_layout_item_id'];
		$this->response->exit_interview_layout_id = $this->exit_interview_layout_id = $post[$sign_table]['exit_interview_layout_id'];

        $validation_rules[] = 
        array(
            'field' => 'partners_clearance_exit_interview_layout_item[item]',
            'label' => 'Question Item',
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

    function save_sub_sign()
    {

		$sign_table = 'partners_clearance_exit_interview_layout_item_sub';
		$sign_key = 'exit_interview_layout_item_sub_id';
        $transactions = true;
		$error = false;
		$post = $_POST;
		$this->response->record_id = $this->record_id = $post[$sign_table]['exit_interview_layout_item_sub_id'];
		$this->response->exit_interview_layout_item_id = $this->exit_interview_layout_item_id = $post[$sign_table]['exit_interview_layout_item_id'];

        $validation_rules[] = 
        array(
            'field' => 'partners_clearance_exit_interview_layout_item_sub[question]',
            'label' => 'Question Item',
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

		$sign_table = 'partners_clearance_exit_interview_layout_item';
		$sign_key = 'exit_interview_layout_id';
		$record = $this->db->get_where( $sign_table, array( $sign_key => $this->input->post('exit_interview_layout_id'), 'deleted' => 0) );
// echo $this->db->last_query();
		$this->load->helper('form');
		$this->load->helper('file');
		$sign_record['records'] = $record->result_array();

  		// $this->load->vars($sign_record);
		// $content = $this->load->blade('edit.signatory')->with( $this->load->get_cached_vars() );

        $this->response->signatory = $this->load->view('edit/signatory', $sign_record, true);
    
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }

    function get_detail_signatories(){

		$sign_table = 'partners_clearance_exit_interview_layout_item';
		$sign_key = 'exit_interview_layout_id';
		$record = $this->db->get_where( $sign_table, array( $sign_key => $this->input->post('exit_interview_layout_id'), 'deleted' => 0) );

		$this->load->helper('form');
		$this->load->helper('file');
		$sign_record['records'] = $record->result_array();

  		// $this->load->vars($sign_record);
		// $content = $this->load->blade('edit.signatory')->with( $this->load->get_cached_vars() );

        $this->response->signatory = $this->load->view('detail/signatory', $sign_record, true);
    
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

		$sign_table = 'partners_clearance_exit_interview_layout_item';
		$sign_key = 'exit_interview_layout_item_id';
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

	function delete_sub_question( )
	{
		// $data['modified_on'] = date('Y-m-d H:i:s');
		// $data['modified_by'] = $this->user->user_id;

		$sign_table = 'partners_clearance_exit_interview_layout_item_sub';
		$sign_key = 'exit_interview_layout_item_sub_id';
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
	
}