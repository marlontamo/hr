<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class company_model extends Record
{
	var $mod_id;
	var $mod_code;
	var $route;
	var $url;
	var $primary_key;
	var $table;
	var $icon;
	var $short_name;
	var $long_name;
	var $description;
	var $path;

	public function __construct()
	{
		$this->mod_id = 10;
		$this->mod_code = 'company';
		$this->route = 'admin/company';
		$this->url = site_url('admin/company');
		$this->primary_key = 'company_id';
		$this->table = 'users_company';
		$this->icon = 'fa-sitemap';
		$this->short_name = 'Company';
		$this->long_name  = 'Company';
		$this->description = 'Manage and list company names registered in the government.';
		$this->path = APPPATH . 'modules/company/';

		parent::__construct();
	}

	
	function _delete( $records )
	{ 
		$data['modified_on'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->user->user_id;
		$data['deleted'] = 1;
		$response = array();

		$this->db->where_in($this->primary_key, $records);
		$result = $this->db->get($this->table);
		$result_data = $result->result();
		if($result->num_rows > 0){
			$count = 0;
			foreach($result_data as $row){
        		if(isset($row->can_delete) && $row->can_delete == '0'){
					$count++;
				}
        	}

        	if($count > 0){
        		$response[] = array(
                	'message' => lang('common.can_delete', $count),
                	'type' => 'error'
            	);      
            	goto stop;	
        	}
	
		}

		stop:

		$this->db->where_in($this->primary_key, $records);
		$this->db->where('can_delete','1');
		$this->db->update($this->table, $data);

		//create system logs
		$this->audit_logs($this->user->user_id, $this->mod_code, 'delete', $this->primary_key, array(), $records);
		
		
		$count_deleted = $this->db->affected_rows();

		if( $this->db->_error_message() != "" ){
			$response[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}
		else{
			$this->db->where_in($this->primary_key, $records);
			$this->db->update('users_company_contact', $data);

			if( $this->db->_error_message() != "" ){
				$response[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
			}
			else{
				$response[] = array(
					'message' => lang('common.delete_record', $count_deleted),
					'type' => 'success'
				);
			}
		}

		return $response;
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

					if(!$result) $result = 1; //empty contacts ???
				}

				break;
			default: 
				return false;
		}

		return $result;
	}

	function save_company_contact( $records ){
		$response = new stdClass();
		$previous_main_data = array();
		$main_record = $records;
		$error=false;
		// debug($main_record);die();
		$record = $this->db->get_where( 'users_company_contact', array( 'company_id' => $this->record_id ) );
		switch( $record->num_rows() )
		{
			case $record->num_rows() == 0:
				//add mandatory fields
				$contact_record = array(
					'company_id' => $main_record['company_id'],
					'contact_type' => $main_record['contact_type'],
					'contact_no' => $main_record['contact_no'],
					'created_by' => $this->user->user_id
				);
				$this->db->insert('users_company_contact', $contact_record);
				if( $this->db->_error_message() == "" )
				{
					$response->record_id = $this->record_id = $this->db->insert_id();
				}
				$action = 'insert';
				break;
			case $record->num_rows() > 0:
				if($main_record['type'] == 'new'){
					$contact_record = array(
						'company_id' => $main_record['company_id'],
						'contact_type' => $main_record['contact_type'],
						'contact_no' => $main_record['contact_no'],
						'created_by' => $this->user->user_id
					);

					$this->db->insert('users_company_contact', $contact_record);

					if( $this->db->_error_message() == "" )
					{
						$response->record_id = $this->record_id = $this->db->insert_id();
					}

					$action = 'insert';
				}else{
					//get previous data for audit logs
					$previous_main_data = $this->db->get_where('users_company_contact', array('contacts_id' => $main_record['contacts_id']))->row_array();

					$contact_record = array(
						'company_id' => $main_record['company_id'],
						'contact_type' => $main_record['contact_type'],
						'contact_no' => $main_record['contact_no'],
						'modified_by' => $this->user->user_id,
						'modified_on' => date('Y-m-d H:i:s')
					);


					$this->db->update( 'users_company_contact', $contact_record, array( 'contacts_id' => $main_record['contacts_id'] ) );
					$action = 'update';
				}

				break;
			default:
				$response->message[] = array(
					'message' => lang('common.inconsistent_data'),
					'type' => 'error'
				);
				$error = true;
				goto stop;
		}

		if( $this->db->_error_message() != "" ){
			$response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
			$error = true;
			goto stop;
		}

		//create system logs
		$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, $action, 'users_company_contact', $previous_main_data, $contact_record);

		stop:
		if( !$error )
		{
			$response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
		}

		$response->saved = !$error;
		return $response;	
	}
}