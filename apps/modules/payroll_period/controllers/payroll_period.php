<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Payroll_period extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('payroll_period_model', 'mod');
		parent::__construct();
	}

	function save()
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

		if( empty($this->record_id) ){
			$_POST['payroll_period']['period_status_id'] = 1; // if add set status to 1 = OPEN
		}

		$this->db->trans_begin();
		$applied_to = $_POST['payroll_period']['applied_to'];
		// To check if entry is duplicated
		foreach ($applied_to as $apply_to) {
			$this->db->join('payroll_period_apply_to','payroll_period.payroll_period_id = payroll_period_apply_to.payroll_period_id','left');
			$chk_exist = $this->db->get_where('payroll_period',array( 'payroll_date' => date('Y-m-d',strtotime($_POST['payroll_period']['payroll_date'])), 
																	  'date_from' => date('Y-m-d',strtotime($_POST['payroll_period']['date_from'])), 
																	  'date_to' => date('Y-m-d',strtotime($_POST['payroll_period']['date_to'])), 
																	  'week' => $_POST['payroll_period']['week'], 
																	  'payroll_schedule_id' => $_POST['payroll_period']['payroll_schedule_id'], 
																	  'period_processing_type_id' => $_POST['payroll_period']['period_processing_type_id'], 
																	  'apply_to_id' => $_POST['payroll_period']['apply_to_id'], 
																	  'apply_to' => $apply_to,
																	  'payroll_period.deleted' => 0
																	)
											);
			
			if( $chk_exist && $chk_exist->num_rows() > 0 ){
				if( $chk_exist->row()->payroll_period_id != $this->record_id ) {
					$category = $this->db->get_where('ww_payroll_apply_to',array('apply_to_id'=>$_POST['payroll_period']['apply_to_id']))->row();
					$this->response->saved = false;
					$this->response->message[] = array(
						'message' => 'Kindly review selected '  . strtolower($category->apply_to) . ', entry already exists.',
						'type' => 'warning'
					);
					$this->_ajax_return();
				}
			}
		}
		
		$this->response = $this->mod->_save( true, false );
		
		if( $this->response->saved ){
			if( isset($_POST['payroll_period']['applied_to']) )
			{	
				$this->db->delete('payroll_period_apply_to', array('payroll_period_id' => $this->response->record_id));

				foreach( $applied_to as $apply_to )
				{
					$insert = array(
						'payroll_period_id' => $this->response->record_id,
						'apply_to' => $apply_to
					);
					$this->db->insert('payroll_period_apply_to', $insert);
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
		}
		else{
			$this->db->trans_rollback();
		}
		
		$this->response->message[] = array(
			'message' => lang('common.save_success'),
			'type' => 'success'
		);

		$this->_ajax_return();
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
		
		$this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

		$this->_ajax_return();
	}

	public function _get_list( $trash )
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
		
		$page = ($page-1) * 10;
		$records = $this->mod->_get_list($page, 10, $search, $filter, $trash); 
		
		foreach ($records as $key => $value) {
			$this->db->select('GROUP_CONCAT(apply_to) AS apply_to');
			$apply_to = $this->db->get_where('payroll_period_apply_to',array('payroll_period_id'=>$value['record_id']));
			if($apply_to && $apply_to->num_rows() > 0){
				if($value['payroll_period_apply_to_id'] != 'Employee'){
					$this->db->select("GROUP_CONCAT(".strtolower($value['payroll_period_apply_to_id']).") AS applied_to");
					$this->db->where_in(strtolower($value['payroll_period_apply_to_id']).'_id',explode(",",$apply_to->row()->apply_to));
					$applied_to = $this->db->get('users_'.strtolower($value['payroll_period_apply_to_id']));
				} else {
					$this->db->select("GROUP_CONCAT(full_name) AS applied_to");
					$this->db->where_in('user_id', explode(",",$apply_to->row()->apply_to));
					$applied_to = $this->db->get('users');
				}	
			}
			$records[$key]['applied_to'] = str_replace(",", ", ",$applied_to->row()->applied_to);
		}
		
		return $records;
	}

	public function _process_lists( $records, $trash )
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
		//temp remove until view functionality added
		/*if( $this->permission['detail'] )
		{
			$rec['detail_url'] = $this->mod->url . '/detail/' . $record['record_id'];
			$rec['options'] .= '<li><a href="'.$rec['detail_url'].'"><i class="fa fa-info"></i> View</a></li>';
		}*/

		$status = $this->db->get_where('payroll_period', array('payroll_period_id' => $record['record_id']) )->row();

		if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}	
		if($status->period_status_id != 3){
			
			if( isset($this->permission['delete']) && $this->permission['delete'] )
			{
				$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
				$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
			}
		
			if( isset($this->permission['process']) && $this->permission['process'] )
			{
				$rec['process_url'] = $this->mod->url . '/process/' . $record['record_id'];
				$rec['options'] .= '<li><a href="javascript: process_record('.$record['record_id'].')"><i class="fa fa-gear"></i> Process</a></li>';
			}
		}
		
		$sensID = $this->config->config['user']['sensitivity'];

		// if($status->period_status_id == 2 && strpos($sensID, '4') ){
		if($status->period_status_id == 2 ){
			if( isset($this->permission['process']) && $this->permission['process'] )
			{
				$rec['closed_url'] = $this->mod->url . '/closed/' . $record['record_id'];
				$rec['options'] .= '<li><a href="javascript: closed_record('.$record['record_id'].')"><i class="fa fa-gear"></i> Close</a></li>';
			}
		}
	}

	function process_record()
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

		$sensID = $this->config->config['user']['sensitivity'];
		
		$this->db->query("CALL sp_payroll_period(".$period_id.", '".$sensID."');");

		$this->db->free_db_resource();

		$this->response->message[] = array(
			'message' => 'Period successfully processed, please confirm by creating neccesary reports.',
			'type' => 'success'
		);
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

		$this->db->query('CALL sp_payroll_closed_period('.$period_id.');');

		$this->db->free_db_resource();
		
		$this->response->message[] = array(
			'message' => 'Period successfully processed, please confirm by creating neccesary reports.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function delete_period()
	{
		$records = $this->input->post('records');
		$records = explode(',', $records);
		
		foreach ($records as $_record) {
			$period = $this->db->get_where('payroll_period', array( 'payroll_period_id' => $_record ));
			if( $period && $period->num_rows() > 0 ) {
				$p_period = $period->row();
				if( $p_period->period_status_id == 3) {
					$this->response->message[] = array(
						'message' => "Selected period is already closed and cannot be deleted.",
						'type' => 'error'
					);
					$this->_ajax_return();
				} elseif( $p_period->period_status_id == 2 ) {
					$this->response->message[] = array(
						'message' => "Selected period already has processed transactions.",
						'type' => 'warning'
					);
					$this->_ajax_return();
				}
			}
		}

		$data['deleted'] = 1;

		$this->db->where_in($this->mod->primary_key, $records);
		$this->db->update($this->mod->table, $data);

		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'delete', $this->mod->primary_key, array(), $records);
		
		if( $this->db->_error_message() != "" ){
			$this->response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}
		else{
			$this->response->message[] = array(
				'message' => count($records) . ' record(s) has been deleted.',
				'type' => 'success'
			);
		}

        $this->_ajax_return();
	}
}