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

		if( $this->response->saved )
		{
			$record = $this->db->get_where( 'payroll_current_transaction', array('id' => $this->record_id ) )->row();
			$this->db->query("CALL sp_payroll_recompute_netpay( ".$record->employee_id.", ".$record->period_id." )");
			$this->db->trans_commit();
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

	function recompute_all()
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

		$this->db->query("CALL sp_payroll_recompute_all_netpay()");

		$this->response->message[] = array(
			'message' => 'Records were successfully saved and/or updated.',
			'type' => 'success'
		);

		$this->_ajax_return();
	}