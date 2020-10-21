<?php //delete me	
	public function save(){
		
		$this->_ajax_only();
		
		if( (empty( $this->record_id ) && !$this->permission['add']) || ($this->record_id && !$this->permission['edit']) )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		if(empty($this->input->post('users_company')['company']) || empty($this->input->post('users_company')['company_code'])){
			
			$this->response->message[] = array(
				'message' => 'Please fill in required fields!',
				'type' => 'warning'
			);

			$this->_ajax_return();
		} 

		if($this->input->post('record_id')){

			$result = $this->mod->update(
				'ww_users_company'
				 , $this->input->post('record_id')
				 , $this->input->post('users_company')
				 , 'parent');

			$result = $this->mod->update(
				'ww_users_company_contact'
				, $this->input->post('record_id')
				, $this->input->post('users_company_contact')
				, 'child' );

		}
		else{ 

			$result = $record_id = $this->mod->_new(
				'ww_users_company'
				, $this->input->post('users_company')); 

			$this->mod->update(
				'ww_users_company_contact'
				, $record_id
				, $this->input->post('users_company_contact')
				, 'child' );
		}
		
		if($result){

			$this->response->message[] = array(
				'message' => 'Record successfull saved/updated.',
				'type' => 'success'
			);

			$this->_ajax_return();				
		}
		else{

			$this->response->message[] = array(
				'message' => 'A problem has occured! Please contact Administrator.',
				'type' => 'error'
			);

			$this->_ajax_return();	
		}
	}

	public function delete(){ 

		if( (empty( $this->record_id ) && !$this->permission['add']) || ($this->record_id && !$this->permission['edit']) )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$records = $this->input->post('records');
		$records = explode(',', $records);

		$result = $this->mod->_delete( $records );

		$this->response->message[] = array(
			'message' => $result['message'], 
			'type' => $result['type']
		);

		$this->_ajax_return();
	}
}