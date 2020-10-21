<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Leave_conversion_period extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('leave_conversion_period_model', 'mod');
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

		$this->db->trans_begin();
		$this->response = $this->mod->_save( true, false );

		if( $this->response->saved ){
			
			if( isset($_POST['payroll_leave_conversion_period']['applied_to']) )
			{
				$applied_to = $_POST['payroll_leave_conversion_period']['applied_to'];
				$this->db->delete('payroll_leave_conversion_period_apply_to', array('leave_conversion_id' => $this->response->record_id));

				foreach( $applied_to as $apply_to )
				{
					$insert = array(
						'leave_conversion_id' => $this->response->record_id,
						'apply_to' => $apply_to
					);
					$this->db->insert('payroll_leave_conversion_period_apply_to', $insert);
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
			$apply_to = $this->db->get_where('payroll_leave_conversion_period_apply_to',array('leave_conversion_id'=>$value['record_id']));
			if($apply_to && $apply_to->num_rows() > 0){
				if($value['payroll_leave_conversion_period_apply'] != 'Employee'){
					$this->db->select("GROUP_CONCAT(".strtolower($value['payroll_leave_conversion_period_apply']).") AS applied_to");
					$this->db->where_in(strtolower($value['payroll_leave_conversion_period_apply']).'_id',explode(",",$apply_to->row()->apply_to));
					$applied_to = $this->db->get('users_'.strtolower($value['payroll_leave_conversion_period_apply']));
				} else {
					$this->db->select("GROUP_CONCAT(full_name) AS applied_to");
					$this->db->where_in('user_id', explode(",",$apply_to->row()->apply_to));
					$applied_to = $this->db->get('users');
				}	
			}
			$records[$key]['applied_to'] = str_replace(",", ", ",$applied_to->row()->applied_to);
		}
		// 
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
		$status = $this->db->get_where('payroll_leave_conversion_period', array('leave_conversion_period_id' => $record['record_id']) )->row();

		if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}	
		if($status->status != 3){
			
			if( isset($this->permission['delete']) && $this->permission['delete'] )
			{
				$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
				$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
			}
		}
	}
}