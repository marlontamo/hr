<?php //delete me
	function _delete( $records )
	{ 
		$data['modified_on'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->user->user_id;
		$data['deleted'] = 1;

		$this->db->where_in('contacts_id', $records);
		$this->db->update('ww_users_company_contact', $data);
		
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
		}

		return $this->response;
	}

	function _new($table, $values){

		$qry = "INSERT INTO $table (
					company
					, company_code
					, address
					, city_id
					, country_id
					, zipcode
					, vat
					, logo)
				VALUES ( 
					'" . $values['company'] . "'
					, '" . $values['company_code'] . "'
					, '" . $values['address'] . "'
					, '" . $values['city_id'] . "'
					, '" . $values['country_id'] . "'
					, '" . $values['zipcode'] . "'
					, '" . $values['vat'] . "'
					, '" . $values['logo'] . "');";

		$this->db->query($qry);
		$id = $this->db->insert_id(); 

		return $id;
	}

	function update($table, $record_id, $values, $level){

		$result = '';

		switch($level){

			case 'parent':

				$qry = "UPDATE $table SET ";
				$fields = '';

				foreach($values as $field => $value){
					$fields .= $fields == '' ? $field . "='" . $value . "'" : ', ' . $field . "='" . $value . "'";
				}	

				$qry .= $fields . " WHERE company_id = '" . $record_id . "'";			
				$result = $this->db->query($qry);
				
				break;
			case 'child':
			
				$qry = '';

				foreach($values as $item_type => $child_table){

					//echo $item_type;
					foreach($child_table as $action => $child_fields){

						if($action === 'new'){

							foreach($child_fields as $field => $child_values){

								foreach($child_values as $index => $value){

									if($value !== ''){

										$qry = "INSERT INTO $table (company_id, contact_type, contact_no) 
												 VALUES ('$record_id', '$item_type', '$value');";

										$result = $this->db->query($qry);
									}																		
								}
							}						
						}
						elseif($action === 'update'){

							foreach($child_fields as $field => $child_values){

								foreach($child_values as $index => $value){

									if($value !== ''){

										$qry = "UPDATE $table 
												SET contact_no = '$value' 
												WHERE contacts_id = '$index' 
												AND company_id = '$record_id'";

										$result = $this->db->query($qry);
									}
								}
							}
						}
					}
				}

				break;
			default: 
				return false;
		}

		return $result;
	}