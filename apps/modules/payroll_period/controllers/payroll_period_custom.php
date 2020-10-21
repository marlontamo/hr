<?php //delete me
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
			
			if( isset($_POST['payroll_period']['applied_to']) )
			{
				$applied_to = $_POST['payroll_period']['applied_to'];
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
		if( isset($this->permission['process']) && $this->permission['process'] )
		{
			$rec['process_url'] = $this->mod->url . '/process/' . $record['record_id'];
			$rec['options'] .= '<li><a href="javascript: process_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> Process</a></li>';
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

		$this->db->query('CALL sp_payroll_period('.$period_id.');');

		$this->response->message[] = array(
			'message' => 'Period successfully processed, please confirm by creating neccesary reports.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}
}