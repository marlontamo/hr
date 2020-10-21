<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Recruit_benefits extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('recruit_benefits_model', 'mod');
		parent::__construct();
	}


	public function edit( $record_id, $child_call = false )
	{
		if( !$this->permission['edit'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_edit( $child_call );
	}
	
	public function add( $record_id = '', $child_call = false )
	{
		if( !$this->permission['add'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_edit( $child_call, true );
	}

	private function _edit( $child_call, $new = false )
	{
		$record_check = false;
		$this->record_id = $data['record_id'] = '';
		$data['benefits'] = array();

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

			//get rating scores
			$data['benefits'] = $this->db->get_where('recruitment_benefit', array($this->mod->primary_key => $this->record_id, 'deleted' => 0))->result_array();

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

	function add_form() {
		$this->_ajax_only();

		$data['form_value'] = $this->input->post('form_value');

		$this->load->helper('file');
		$this->response->add_form = $this->load->view('edit/forms/'.$this->input->post('add_form'), $data, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();
	}

	function delete_child()
	{
		$this->_ajax_only();
		
		// echo "<pre>";print_r($this->input->post());exit();
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

		$child_primary_id = 'benefit_id';
		$child_table = 'recruitment_benefit';
		$records = $this->input->post('child_id');
		$records = explode(',', $records);

		$this->db->where_in($child_primary_id, $records);
		$record = $this->db->get( $child_table )->result_array();

		foreach($record as $rec){
			// if($rec['can_delete'] == 1){
				$data['modified_on'] = date('Y-m-d H:i:s');
				$data['modified_by'] = $this->user->user_id;
				$data['deleted'] = 1;

				$this->db->where($child_primary_id, $rec[$child_primary_id]);
				$this->db->update($child_table, $data);
				
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
				$this->response->record_deleted = 1;
				}
			// }else{
			// 	$this->response->message[] = array(
			// 		'message' => 'Record(s) cannot be deleted.',
			// 		'type' => 'warning'
			// 	);
			// 	$this->response->record_deleted = 0;
			// }
		}

		$this->_ajax_return();
	}

	public function save( $child_call = false )
	{
		$this->_ajax_only();
		if( !$this->_set_record_id() )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'error'
			);
			$this->_ajax_return();	
		}
		
		if( (empty( $this->record_id ) && !$this->permission['add']) || ($this->record_id && !$this->permission['edit']) )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$child_table = 'recruitment_benefit';
		$child_primary_id = 'benefit_id';
		$child_table_data = array();
		if(isset($_POST['recruitment_benefit'])){
			$child_table_data = $_POST['recruitment_benefit'];
		}

		unset( $_POST['benefit_desc'] );
		unset( $_POST['recruitment_benefit'] );

		$transactions = true;
		$this->db->trans_begin();
		$this->response = $this->mod->_save( $child_call );
		$error = false;

		if( $this->response->saved )
		{
			if(!empty($child_table_data)){
				$child_record = array();
				foreach($child_table_data[$child_primary_id] as $index => $value){				
					//start saving with performance_setup_rating_score table
			        $record = $this->db->get_where( $child_table , array( $child_primary_id => $value ) );
			        $child_record['package_id'] = $this->response->record_id;
			        $child_record['benefit'] = $child_table_data['benefit'][$index];
			        $child_record['amount'] = $child_table_data['amount'][$index];
			        $child_record['status_id'] = $child_table_data['status_id'][$index];
			        switch( true )
			        {
			            case $record->num_rows() == 0:
			                //add mandatory fields
			                $child_record['created_on'] = date('Y-m-d H:i:s');
			                $child_record['created_by'] = $this->user->user_id;

			                $this->db->insert($child_table, $child_record);
			                if( $this->db->_error_message() == "" )
			                {
			                    $child_record_id = $this->child_record_id = $this->db->insert_id();
			                }
			                break;
			            case $record->num_rows() == 1:
			                $child_record['modified_by'] = $this->user->user_id;
			                $child_record['modified_on'] = date('Y-m-d H:i:s');

			                $this->db->update( $child_table, $child_record, array( $child_primary_id => $value) );
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

		$this->_ajax_return();
	}
}