<?php //delete me
	function _list_options_active( $record, &$rec )
	{
		if( $this->permission['process'] )
		{
			$rec['options'] .= '<li><a href="javascript:process_form('.$record['record_id'].')"><i class="fa fa-gear"></i> Process</a></li>';
		}

		parent::_list_options_active( $record, $rec );
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
	