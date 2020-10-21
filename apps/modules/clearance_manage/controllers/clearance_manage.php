<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Clearance_manage extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('clearance_manage_model', 'mod');
		parent::__construct();
	}

	public function edit( $record_id = "", $child_call = false )
	{
		if( !$this->permission['edit'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_edit( $child_call );
	}

	private function _edit( $child_call, $new = false )
	{
		$record_check = false;
		$this->record_id = $data['record_id'] = '';

		if( !$new ){
			if( !$this->_set_record_id() )
			{
				echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
				die();
			}

			$this->record_id = $data['record_id'] = $_POST['record_id'];
		}
		
		$record_check = $this->mod->_exists( $this->record_id );
		if( $new || $record_check === true )
		{
			$result = $this->mod->_get( 'edit', $this->record_id );
			echo $this->db->_error_message();
			if( $new )
			{
				$field_lists = $result->list_fields();
				foreach( $field_lists as $field )
				{
					$data['record'][$field] = '';
				}
			}
			else{
				$record = $result->row_array();
				foreach( $record as $index => $value )
				{
					$record[$index] = trim( $value );	
				}
				$data['record'] = $record;
			}
			
			$this->db->select('partners_clearance_signatories.*, users_profile.lastname, users_profile.firstname');
			$this->db->join('users_profile','partners_clearance_signatories.user_id = users_profile.user_id','inner');
			$this->db->where('clearance_id', $this->record_id);
			$this->db->where('partners_clearance_signatories.user_id', $this->user->user_id);
			$this->db->where('status_id !=', 4);
			$sign_record = $this->db->get('partners_clearance_signatories');

			$data['sign'] = $sign_record->row_array();

			$account_record = $this->db->get_where( 'partners_clearance_signatories_accountabilities', array( 'clearance_signatories_id' => $data['sign']['clearance_signatories_id'] ) );
			$data['account'] = $account_record->result_array();

			$this->load->vars( $data );
			if( !$child_call ){
				$this->load->helper('form');
				$this->load->helper('file');
				echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
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

	public function detail( $record_id, $child_call = false )
	{
		if( !$this->permission['detail'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_detail( $child_call );
	}

	private function _detail( $child_call, $new = false )
	{
		$record_check = false;
		$this->record_id = $data['record_id'] = '';	

		if( !$new )
		{
			if( !$this->_set_record_id() )
			{
				echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
				die();
			}

			$this->record_id = $data['record_id'] = $_POST['record_id'];
		}

		$this->record_id = $data['record_id'] = $_POST['record_id'];
		
		$record_check = $this->mod->_exists( $this->record_id );
		if( $new || $record_check === true )
		{
			$result = $this->mod->_get( 'detail', $this->record_id );
			if( $new )
			{
				$field_lists = $result->list_fields();
				foreach( $field_lists as $field )
				{
					$data['record'][$field] = '';
				}
			}
			else{
				$record = $result->row_array();
				foreach( $record as $index => $value )
				{
					$record[$index] = trim( $value );	
				}
				$data['record'] = $record;
			}

			$this->db->select('partners_clearance_signatories.*, users_profile.lastname, users_profile.firstname');
			$this->db->join('users_profile','partners_clearance_signatories.user_id = users_profile.user_id','inner');
			$this->db->where('clearance_id', $this->record_id);
			$this->db->where('partners_clearance_signatories.user_id', $this->user->user_id);
			$sign_record = $this->db->get('partners_clearance_signatories');
			$data['sign'] = $sign_record->row_array();

			$account_record = $this->db->get_where( 'partners_clearance_signatories_accountabilities', array( 'clearance_signatories_id' => $data['sign']['clearance_signatories_id'] ) );
			$data['account'] = $account_record->result_array();
			
			$this->record = $data['record'];
			$this->load->vars( $data );

			if( !$child_call ){
				$this->load->helper('form');
				$this->load->helper('file');
				echo $this->load->blade('pages.detail')->with( $this->load->get_cached_vars() );
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

	public function add_account(){
		$sign_record = array();
        $this->response->accountability = $this->load->view('edit/accountability', $sign_record, true);
    
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
	}

    function save()
    {
        $transactions = true;
		$error = false;
		$post = $_POST;
		$this->response->record_id = $this->record_id = $post['partners_clearance_signatories']['clearance_signatories_id'];
		unset( $post['record_id'] );
		unset( $post['partners_clearance_signatories']['clearance_signatories_id'] );

        $validation_rules[] = 
        array(
            'field' => 'partners_clearance_signatories[remarks]',
            'label' => 'Remarks',
            'rules' => 'required'
            );
        $validation_rules[] = 
        array(
            'field' => 'partners_clearance_signatories[status_id]',
            'label' => 'Status',
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
		$main_record = $post['partners_clearance_signatories'];
	
		$record = $this->db->get_where( 'partners_clearance_signatories', array( 'clearance_signatories_id' => $this->record_id ) );
		switch( true )
		{
			case $record->num_rows() == 1:
				// $main_record['modified_by'] = $this->user->user_id;
				// $main_record['modified_on'] = date('Y-m-d H:i:s');
				if($main_record['status_id'] == 4){
					$main_record['date_cleared'] = date('Y-m-d');
				}

				$this->db->update( 'partners_clearance_signatories', $main_record, array( 'clearance_signatories_id' => $this->record_id ) );
				$this->response->action = 'update';

				$attachment_info = array(
											'clearance_signatories_id' => $this->record_id,
											'attachments' => $main_record['attachments'],
											'type' => 1
										 );
				$this->db->insert('partners_clearance_signatories_attachment', $attachment_info);
				
				$pending = $this->mod->get_pending_status($record->row()->clearance_id);

				if($pending == 0){
					$this->db->where('clearance_id', $record->row()->clearance_id);
					$this->db->update('partners_clearance', array('status_id' => 3, 'date_cleared' => date('Y-m-d')));

					if( $this->db->_error_message() != "" ){
						$error = true;
						goto stop;
					}
				}

				if ($main_record['status_id'] >= 4){
					$this->db->query("CALL sp_partners_clearance_action_email( {$record->row()->clearance_id} )");
					mysqli_next_result($this->db->conn_id);

					if( $this->db->_error_message() != "" ){
						$error = true;
						goto stop;
					}
				}
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

		$account_record = array();
		$accountabilities = $post['partners_clearance_signatories_accountabilities']['accountability'];
		$this->db->delete('partners_clearance_signatories_accountabilities', array('clearance_signatories_id' => $this->record_id )); 
		if(count($accountabilities) > 0){
			foreach( $accountabilities as $val ){
				if(strlen(trim($val)) > 0){
					$account_record['clearance_signatories_id'] = $this->record_id;
					$account_record['accountability'] = $val;
					$this->db->insert('partners_clearance_signatories_accountabilities', $account_record);
					$this->response->action = 'insert';

					if( $this->db->_error_message() != "" ){
						$this->response->message[] = array(
							'message' => $this->db->_error_message(),
							'type' => 'error'
						);
						$error = true;
						goto stop;
					}
				}
			}
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
}