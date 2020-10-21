<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Appform extends MY_publicController
{
	public function __construct()
	{
		$this->load->model('appform_model', 'mod');
		parent::__construct();
		$this->lang->load( 'appform' );
	}

	public function kiosk(){
		$data = array();
		// $this->load->model('recruitform_model', 'rec');
		$data['mrf'] = $this->mod->get_active_mrf_by_year();
		
		$this->load->vars( $data );
		echo $this->load->blade('recruitment_kiosk')->with( $this->load->get_cached_vars() );
	}

	function save(){
		$this->load->model('applicants_model', 'app');

		$error = false;
		$post = $_POST;
		$this->response->record_id = $this->record_id = $this->recruit_id = $post['record_id'];
		unset( $post['record_id'] );
		$this->response->fgs_number = $post['fgs_number'];
        /***** START Form Validation (hard coded) *****/
		//table assignment (manual saving)
		$other_tables = array();
		$partners_personal = array();
		$validation_rules = array();
		$partners_personal_key = array();
		switch($post['fgs_number']){
			case 1:
			//General Tab
			//Application Tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment[lastname]',
				'label' => 'Last Name',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment[firstname]',
				'label' => 'First Name',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal[position_sought]',
				'label' => 'Position Sought',
				'rules' => 'required'
				);
			// $validation_rules[] = 
			// array(
			// 	'field' => 'recruitment_personal[how_hiring_heard]',
			// 	'label' => 'How did you learn about HDI?',
			// 	'rules' => 'required'
			// 	);
			// $validation_rules[] = 
			// array(
			// 	'field' => 'recruitment_personal[desired_salary]',
			// 	'label' => 'Desired Salary',
			// 	'rules' => 'required'
			// 	);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal[resume]',
				'label' => 'Resume',
				'rules' => 'required'
				);

			// $partners_personal_table = "recruitment_personal";
			// $partners_personal_key = array('position_sought', 'desired_salary', 'salary_pay_mode', 'how_hiring_heard', 'resume');
			// $partners_personal = $post['recruitment_personal'];
			// break;
			// case 3:
			//Contacts Tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment[email]',
				'label' => 'Email Address',
				'rules' => 'required|valid_email'
				);
			// $validation_rules[] = 
			// array(
			// 	'field' => 'recruitment_personal[phone]',
			// 	'label' => 'Phone',
			// 	'rules' => 'required'
			// // 	);
			// $validation_rules[] = 
			// array(
			// 	'field' => 'recruitment_personal[mobile]',
			// 	'label' => 'Mobile Phone',
			// 	'rules' => 'required'
			// 	);
			$partners_personal_table = "recruitment_personal";
			$partners_personal_key = array('phone', 'mobile', 'position_sought', 'resume');//'how_hiring_heard',
			$partners_personal = $post['recruitment_personal'];

			// $partner_phone = $_POST['recruitment_personal']['phone'];
			// $partner_mobile = $_POST['recruitment_personal']['mobile'];

			// unset($partners_personal['mobile']);
			// foreach ($partner_mobile as $phone){
			// 	$mobile = $this->check_mobile($phone);
			// 	if(!empty($phone)){
			// 		if(!$mobile){
			// 			$this->response->invalid=true;
			// 			$this->response->invalid_message='Invalid mobile number';
			// 			$this->response->message[] = array(
			// 		    	'message' => 'Invalid mobile number',
			// 		    	'type' => 'warning'
			// 			);
		 //        		$this->_ajax_return();
		 //        	}else{
		 //        		$partners_personal['mobile'][] = $mobile;
		 //        	}
		 //        }
			// }

   //      	if(!isset($partners_personal['mobile'])){
   //      		$partners_personal['mobile'] = array();
   //      	}
			// unset($partners_personal['phone']);
			// foreach ($partner_phone as $phone){
			// 	$mobile = $this->check_phone($phone);
			// 	if(!empty($phone)){
			// 		if(!$mobile){
			// 			$this->response->invalid=true;
			// 			$this->response->invalid_message='Invalid phone number';
			// 			$this->response->message[] = array(
			// 		    	'message' => 'Invalid phone number',
			// 		    	'type' => 'warning'
			// 			);
		 //        		$this->_ajax_return();
		 //        	}else{
		 //        		$partners_personal['phone'][] = $mobile;
		 //        	}
		 //        }
			// }
   //      	if(!isset($partners_personal['phone'])){
   //      		$partners_personal['phone'] = array();
   //      	}
			break;
		}

		if( sizeof( $validation_rules ) > 0 )
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules( $validation_rules );
			if ($this->form_validation->run() == false)
			{
				foreach( $this->form_validation->get_error_array() as $f => $f_error )
				{
					$this->response->message[] = array(
						'message' => $f_error,
						'type' => 'warning'
						);  
				}

				$this->_ajax_return();
			}
		}

		// echo "<pre>";
		// print_r($post);
		// print_r($validation_rules);
		// exit();

		//validation for duplicate application
		$chk_dup = $this->app->check_dupplicate_app($post);
		if($chk_dup == "true")
		{
			$this->response->invalid=true;
			$this->response->invalid_message='We have already seen your information on our list.';
			$this->response->message[] = array(
		    	'message' => 'Duplicate email address.',
		    	'type' => 'warning'
			);
			$this->response->duplicate = true;
			$this->_ajax_return();
		}	

        /***** END Form Validation (hard coded) *****/

        //SAVING START   
		$transactions = true;
		// $this->recruit_id = 0;
		if( $transactions )
		{
			$this->db->trans_begin();
		}

		//start saving with main table
		if(array_key_exists($this->app->table, $post)){
			$previous_main_data = array();	
			$main_record = $post[$this->app->table];
			unset($main_record['request_id']);
			$main_record['status_id'] = 11;
			$record = $this->db->get_where( $this->app->table, array( $this->app->primary_key => $this->record_id ) );

			switch( true )
			{
				case $record->num_rows() == 0:
					//add mandatory fields
					if( !$this->session->userdata('user') ) {
						$main_record['created_by'] =  '';
					}else{
						$this->user = $this->session->userdata('user');
						$main_record['created_by'] =  $this->user->user_id;
					} 
					$main_record['recruitment_date'] = date('Y-m-d');
					$main_record['source_id'] = 3;
					$this->db->insert($this->app->table, $main_record);
					if( $this->db->_error_message() == "" )
					{
						$this->recruit_id = $this->response->record_id = $this->record_id = $this->db->insert_id();
						// $partners_add['user_id'] = $this->record_id;
						// $this->db->insert('partners', $partners_add);
						// $this->recruit_id = $this->db->insert_id();
					}
					$this->response->action = 'insert';
					break;
				case $record->num_rows() == 1:
					if( !$this->session->userdata('user') ) {
						$main_record['modified_by'] =  '';
					}else{
						$this->user = $this->session->userdata('user');
						$main_record['modified_by'] =  $this->user->user_id;
					} 
					$main_record['modified_on'] = date('Y-m-d H:i:s');
					// if(array_key_exists('birth_date', $main_record)){
					// 	$main_record['birth_date'] = date('Y-m-d', strtotime($main_record['birth_date']));
					// }
				//get previous data for audit logs
					$previous_main_data = $this->db->get_where($this->app->table, array($this->app->primary_key => $this->record_id))->row_array();
					$this->db->update( $this->app->table, $main_record, array( $this->app->primary_key => $this->record_id ) );
					$this->response->action = 'update';
					break;
				default:
					$this->response->message[] = array(
						'message' => lang('common.inconsistent_data'),
						'type' => 'error'
					);
					$error = true;
					goto stop;
			}

			//create system logs
			$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, $this->response->action, $this->app->table, $previous_main_data, $main_record);
			
			if( $this->db->_error_message() != "" ){
				$this->response->message[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
				$error = true;
				goto stop;
			}
		}

		//personal profile
		if(count($partners_personal_key) > 0){
			// $this->load->model('my201_model', 'profile_mod');
			$sequence = 1;
			$post['fgs_number'];
			$accountabilities_attachments = array(12,13);
			$current_sequence = array_key_exists('sequence', $post) ? $post['sequence'] : 0;
			foreach( $partners_personal_key as $table => $key )
			{
				$previous_other_data = array();
				if(!is_array($partners_personal[$key])){
					$record = $this->app->get_recruitment_personal($this->record_id , $partners_personal_table, $key, $current_sequence);
					if(in_array($post['fgs_number'], $accountabilities_attachments) && $current_sequence == 0) //insert to personal history
					{
						$sequence = count($record) + 1;
						$record = array();
					}
					$data_personal = array('key_value' => $partners_personal[$key]);
					switch( true )
					{
						case count($record) == 0:
							$data_personal = $this->app->insert_recruitment_personal($this->record_id, $key, $partners_personal[$key], $sequence, $this->recruit_id);
							$this->db->insert($partners_personal_table, $data_personal);
							$other_action = 'insert';
							// $this->record_id = $this->db->insert_id();
							break;
						case count($record) == 1:
							$recruit_id = $this->recruit_id;
							$where_array = in_array($post['fgs_number'], $accountabilities_attachments) ? array( 'recruit_id' => $recruit_id, 'key' => $key, 'sequence' => $current_sequence ) : array( 'recruit_id' => $recruit_id, 'key' => $key );
						//get previous data for audit logs
							$previous_other_data = $this->db->get_where($partners_personal_table, $where_array )->row_array();
							$this->db->update( $partners_personal_table, $data_personal, $where_array );
							$other_action = 'update';
							break;
						default:
							$this->response->message[] = array(
								'message' => lang('common.inconsistent_data'),
								'type' => 'error'
							);
							$error = true;
							goto stop;
					}

					if( $this->db->_error_message() != "" ){
						$this->response->message[] = array(
							'message' => $this->db->_error_message(),
							'type' => 'error'
						);
						$error = true;
					}
						//create system logs
						$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, $other_action, $partners_personal_table, $previous_other_data, $data_personal);
				}else{
					$sequence = 1;
					$recruit_id = $this->recruit_id;
					$this->db->delete($partners_personal_table, array( 'recruit_id' => $recruit_id, 'key' => $key ));
					//create system logs
					$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'delete', "$partners_personal_table - recruit_id", array(), explode(',', $this->record_id));

					foreach( $partners_personal[$key] as $table => $data_personal )
					{	
						$data_personal = $this->app->insert_recruitment_personal($this->record_id, $key, $data_personal, $sequence, $this->recruit_id);
						$this->db->insert($partners_personal_table, $data_personal);

						if( $this->db->_error_message() != "" ){
							$this->response->message[] = array(
								'message' => $this->db->_error_message(),
								'type' => 'error'
							);
							$error = true;
						}	
						$sequence++;
						$other_action = 'insert';
						//create system logs
						$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, $other_action, $partners_personal_table, $previous_other_data, $data_personal);
					}

				}
			}
		}

/*		if( $post['recruitment']['request_id'] )
		{
			//check if exists in process
			$this->db->limit(1);
			$check = $this->db->get_where('recruitment_process', array('request_id' => $post['recruitment']['request_id'], 'recruit_id' => $this->record_id ));
			if( $check->num_rows() == 0 )
			{
				$insert = array(
					'request_id' => $post['recruitment']['request_id'], 
					'recruit_id' => $this->record_id, 
					'status_id' => 1,
					'created_by' => $this->user->user_id
				);
				$this->db->insert('recruitment_process', $insert);
				//create system logs
				$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'recruitment_process', array(), $insert);
			}
		}*/

		stop:
		if( $transactions )
		{
			if( !$error ){
				$this->db->trans_commit();
			}
			else{
				 $this->db->trans_rollback();
			}
		}

		if( !$error  )
		{
			$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
		}

		$this->response->saved = !$error;

        $this->_ajax_return();
	}

    function check_mobile($phoneNum=0){ 	
		$mobileNumber = trim(str_replace(' ', '', $phoneNum));
		$mobileNumber =  str_replace('-', '', $mobileNumber);

		if(!empty($mobileNumber)){
			if ((substr($mobileNumber,0,1) != 0) && strlen($mobileNumber) < 11){
				$mobileNumber = '0'.$mobileNumber;
			}	
			$output = preg_replace( '/(0|\+?\d{2})(\d{9,10})/', '0$2', $mobileNumber);

			preg_match( '/(0|\+?\d{2})(\d{9,10})/', $mobileNumber, $matches);

			if(isset($matches[1]) && isset($matches[2])){
				$mobile_prefix = substr($matches[2], 0, 2);
				if($matches[2] != $output || $mobile_prefix == 00){
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}

		return '+63'.$matches[2];
    }

    function check_phone($phoneNum=0){
		$mobileNumber = trim(str_replace(' ', '', $phoneNum));
		$mobileNumber =  str_replace('-', '', $mobileNumber);

		if(!empty($mobileNumber)){
			if ((substr($mobileNumber,0,1) != 0) && strlen($mobileNumber) < 9){
				$mobileNumber = '0'.$mobileNumber;
			}	

			$output = preg_replace( '/(0|\+?\d{2})(\d{8})/', '0$2', $mobileNumber);
			preg_match( '/(0|\+?\d{2})(\d{8})/', $mobileNumber, $matches);

			if(isset($matches[1]) && isset($matches[2])){
				$mobile_prefix = substr($matches[2], 0, 2);
				if('0'.$matches[2] != $output || $mobile_prefix == 00){
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}

		return '+63'.$matches[2];
    }
}