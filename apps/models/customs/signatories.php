<?php //delete me
	function get_company_signatories( $class_id, $company_id )
	{
		$signatories = $this->db->get_where('approver_class_company', array('class_id' => $class_id, 'company_id' => $company_id, 'deleted' => 0));
		if( $signatories->num_rows() > 0 )
		{
			return $signatories->result();
		}

		return false;
	}

	function get_department_signatories( $class_id, $department_id )
	{
		$signatories = $this->db->get_where('approver_class_department', array('class_id' => $class_id, 'department_id' => $department_id, 'deleted' => 0));
		if( $signatories->num_rows() > 0 )
		{
			return $signatories->result();
		}

		return false;
	}

	function get_position_signatories( $class_id, $position_id )
	{
		$signatories = $this->db->get_where('approver_class_position', array('class_id' => $class_id, 'position_id' => $position_id, 'deleted' => 0));
		if( $signatories->num_rows() > 0 )
		{
			return $signatories->result();
		}

		return false;
	}

	function delete_company_signatory( $records )
	{
		$response = new stdClass();

		$data['modified_on'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->user->user_id;
		$data['deleted'] = 1;

		$this->db->where_in('id', $records);
		$this->db->update('approver_class_company', $data);
		
		if( $this->db->_error_message() != "" ){
			$response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}
		else{
			$response->message[] = array(
				'message' => lang('common.delete_record', $this->db->affected_rows()),
				'type' => 'success'
			);
		}

		return $response;
	}

	function delete_department_signatory( $records )
	{
		$response = new stdClass();

		$data['modified_on'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->user->user_id;
		$data['deleted'] = 1;

		$this->db->where_in('id', $records);
		$this->db->update('approver_class_department', $data);
		
		if( $this->db->_error_message() != "" ){
			$response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}
		else{
			$response->message[] = array(
				'message' => lang('common.delete_record', $this->db->affected_rows()),
				'type' => 'success'
			);
		}

		return $response;
	}

	function delete_position_signatory( $records )
	{
		$response = new stdClass();

		$data['modified_on'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->user->user_id;
		$data['deleted'] = 1;

		$this->db->where_in('id', $records);
		$this->db->update('approver_class_position', $data);
		
		if( $this->db->_error_message() != "" ){
			$response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}
		else{
			$response->message[] = array(
				'message' => lang('common.delete_record', $this->db->affected_rows()),
				'type' => 'success'
			);
		}

		return $response;
	}

	function get_company_signatory( $id )
	{
		if( !empty($id) )
			return $this->db->get_where('approver_class_company', array('id' => $id))->row();
		else{
			$response = new stdClass();
			$response->id = '';
			$response->class_id = '';
			$response->company_id = '';
			$response->approver_id = '';
			$response->condition = '';
			$response->sequence = '';
			$response->approver = '';
			$response->email = '';
			return $response;
		}
	}

	function get_department_signatory( $id )
	{
		if( !empty($id) )
			return $this->db->get_where('approver_class_department', array('id' => $id))->row();
		else{
			$response = new stdClass();
			$response->id = '';
			$response->class_id = '';
			$response->company_id = '';
			$response->approver_id = '';
			$response->condition = '';
			$response->sequence = '';
			$response->approver = '';
			$response->email = '';
			return $response;
		}
	}

	function get_position_signatory( $id )
	{
		if( !empty($id) )
			return $this->db->get_where('approver_class_position', array('id' => $id))->row();
		else{
			$response = new stdClass();
			$response->id = '';
			$response->class_id = '';
			$response->company_id = '';
			$response->approver_id = '';
			$response->condition = '';
			$response->sequence = '';
			$response->approver = '';
			$response->email = '';
			return $response;
		}
	}
	
	function check_if_approver( $approver_id )
	{
		$qry = "select * from (";
		$qry .= "select id from {$this->db->dbprefix}approver_class_company where approver_id = {$approver_id} and approver = 1 and deleted = 0 limit 0, 1";
		$qry .= " UNION ";
		$qry .= "select id from {$this->db->dbprefix}approver_class_department where approver_id = {$approver_id} and approver = 1 and deleted = 0 limit 0, 1";
		$qry .= " UNION ";
		$qry .= "select id from {$this->db->dbprefix}approver_class_position where approver_id = {$approver_id} and approver = 1 and deleted = 0 limit 0, 1";
		$qry .= " UNION ";
		$qry .= "select id from {$this->db->dbprefix}approver_class_user where approver_id = {$approver_id} and approver = 1 and deleted = 0 limit 0, 1";
		$qry .= ") as t1";

		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
			return true;
		else
			return false;
	}