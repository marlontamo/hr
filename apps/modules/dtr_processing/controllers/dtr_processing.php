<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dtr_processing extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('dtr_processing_model', 'mod');
		parent::__construct();
	}

	function get_applied_to_options()
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

		$this->response->options = $this->mod->_get_applied_to_options( '', false, $this->input->post('apply_to') );

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function _list_options_active( $record, &$rec )
	{
		if( $record['proces_status'] != 'Closed' ) {

			if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
			{
				$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
				$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
			}	

			if( isset($this->permission['process']) && $this->permission['process'] )
			{
				$rec['options'] .= '<li><a href="javascript:process_form('.$record['record_id'].')"><i class="fa fa-gear"></i> Process</a></li>';
				$rec['options'] .= '<li class="divider"></li>';
				$rec['options'] .= '<li><a href="javascript: closed_record('.$record['record_id'].')"><i class="fa fa-gear"></i> Close</a></li>';$rec['options'] .= '<li class="divider"></li>';
			}

			if( isset($this->permission['delete']) && $this->permission['delete'] )
			{
				$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
				$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
					
			}
		}	

	}

	function process_form()
	{
		$this->_ajax_only();
		if( !$this->permission['process'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		
		parent::detail( '', true);
		$data['title'] = 'Processing Details';
		$data['content'] = $this->load->view('process_form', '', true);
		
		$this->response->process_form = $this->load->view('templates/modal', $data, true);

		$this->_ajax_return();
	}

	function process()
	{
		$this->_ajax_only();
		if( !$this->permission['process'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		
		$period_id = $this->input->post('record_id');
		$user_id = $this->input->post('user_id');
		
		if( !$period_id )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$this->db->query('CALL sp_time_period_process('.$period_id.','.$user_id.');');

		$this->response->message[] = array(
			'message' => 'Period successfully processed, please confirm by creating neccesary reports.',
			'type' => 'success'
		);
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

		if(!isset($_POST['time_period']['company_id']))
		{
			$this->response->message[] = array(
				'message' => 'Company id field is required',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$this->db->trans_begin();

		$this->response = $this->mod->_save( $child_call );

		if( $this->response->saved ){
			if( isset($_POST['time_period']['applied_to']) )
			{	
				$applied_to = $_POST['time_period']['applied_to'];
				$this->db->delete('time_period_apply_to_id', array('period_id' => $this->response->record_id));

				foreach( $applied_to as $apply_to )
				{
					$insert = array(
						'period_id' => $this->response->record_id,
						'apply_to_id' => $apply_to
					);
					$this->db->insert('time_period_apply_to_id', $insert);
				}

				$this->db->trans_commit();
			}
			else{
				$this->db->trans_rollback();
				$this->response->saved = false;
				$this->response->message[] = array(
					'message' => 'Please choose applied to.',
					'type' => 'warning'
				);
				$this->_ajax_return();
			}

			$this->db->where($this->mod->primary_key, $this->record_id);
        	$this->db->update($this->mod->table, array('cutoff_monthly' => date('Y-m',strtotime($_POST['time_period']['date_from']))));			
		}
		else{
			$this->db->trans_rollback(); 
		}

		$this->record_id = $this->response->record_id;
		$time_period = $this->input->post('time_period');

		$this->db->where($this->mod->primary_key, $this->record_id);
    	$this->db->update($this->mod->table, array('cutoff_monthly' => date('Y-m',strtotime($_POST['time_period']['date_from']))));			

		if( !$child_call )
		{
			if(empty($time_period['previous_cutoff']) || $time_period['previous_cutoff'] == ''){
				
				$this->db->where($this->mod->primary_key, $this->record_id);
            	$this->db->update($this->mod->table, array('previous_cutoff' => '0000-00-00' ));
			}
			$this->_ajax_return();
		}
	}


	public function get_previous_cutoff()
	{
		$this->_ajax_only();
		$payroll_date = $this->input->post('payroll_date') != "" ? date('Y-m-d', strtotime($this->input->post('payroll_date'))) : null;
		$company_id = $this->input->post('company_id');
		$period = $this->mod->get_previous_cutoff($company_id, $payroll_date);

		$this->response->previous_cutoff = ($period) ? $period->date_from : '';
		
		$this->_ajax_return();
	}

	function closed_record()
	{
		$this->_ajax_only();
		if( !$this->permission['process'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		
		$period_id = $this->input->post('record_id');

		if( !$period_id )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$this->db->query( 'UPDATE ww_time_period SET closed = 1 WHERE period_id = '.$period_id );

		$this->response->message[] = array(
			'message' => 'Period successfully closed, please confirm by creating neccesary reports.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function user_lists_typeahead()
	{
		$this->_ajax_only();
		$this->response->users = $this->mod->getUsersTagList();
		$this->_ajax_return();
	}	
}