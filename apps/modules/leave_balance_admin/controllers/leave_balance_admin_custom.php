<?php //delete me
	function save()
	{
		//validate if duplicate entry (user, form, year)
		$record_id_check = $this->input->post('record_id');
		$time_form_balance = $this->input->post('time_form_balance');

		$is_exist_sql = "SELECT *
							FROM ww_time_form_balance tb WHERE deleted=0
								AND user_id = {$time_form_balance['user_id']}
								AND form_id = {$time_form_balance['form_id']}
								AND year = {$time_form_balance['year']}
								
								";	
		if($this->input->post('record_id') > 0){
			$is_exist_sql .= " AND id != {$record_id_check}";
		}

		$result_exist = $this->db->query( $is_exist_sql );
		$is_exist = $result_exist->num_rows();
		
		if($is_exist > 0){
			$this->response->message[] = array(
				'message' => "Duplicate entry! <br>Leave balance for the selected employee already created",
				'type' => 'warning'
			);
		$this->_ajax_return();
		}

		parent::save( true );
		if( $this->response->saved )
        {        	
        	$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
        }
        $this->_ajax_return();
	}