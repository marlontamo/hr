<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Db_prep extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('db_prep_model', 'mod');
		parent::__construct();
	}

	function index()
	{
		echo "Clearing Refence Tables<br/>";
		$this->clear_reference_tables();
		echo "Clearing User Data leaving Admin<br/>";
		$this->delete_except_admin_data();
		echo "Done";
	}

	function clear_reference_tables()
	{
		$tables = array(
			'ww_cities',
			'ww_payroll_govt_contribution',
			'ww_payroll_loan',
			'ww_payroll_loan_type',
			'ww_payroll_location',
			'ww_payroll_overtime',
			'ww_payroll_overtime_rates',
			'ww_payroll_period',
			'ww_payroll_period_apply_to',
			'ww_payroll_phic_table',
			'ww_payroll_sss_table',
			'ww_payroll_whtax_table',
			'ww_performance_appraisal',
			'ww_performance_appraisal_applicable',
			'ww_performance_appraisal_applicable_user',
			'ww_performance_appraisal_approver',
			'ww_performance_appraisal_contributor',
			'ww_performance_appraisal_contributor_fields',
			'ww_performance_appraisal_fields',
			'ww_performance_appraisal_pdp',
			'ww_performance_appraisal_personnel_action',
			'ww_performance_appraisal_reminder',
			'ww_performance_appraisal_self_review',
			'ww_performance_planning',
			'ww_performance_planning_applicable',
			'ww_performance_planning_applicable_fields',
			'ww_performance_planning_applicable_items',
			'ww_performance_planning_approver',
			'ww_performance_planning_notes',
			'ww_performance_planning_reminder',
			'ww_performance_setup_library',
			'ww_performance_setup_performance',
			'ww_performance_setup_rating_group',
			'ww_performance_setup_rating_score',
			'ww_performance_setup_scorecard',
			'ww_performance_template',
			'ww_performance_template_section',
			'ww_performance_template_section_column',
			'ww_performance_template_section_column_fields',
			'ww_performance_template_section_column_item',
			'ww_profile_menu',
			'ww_profiles_sensitivity',
			'ww_recruitment_manpower_plan',
			'ww_recruitment_manpower_plan_approver',
			'ww_recruitment_manpower_plan_incumbent',
			'ww_recruitment_manpower_plan_position',
			'ww_recruitment_manpower_plan_position_new',
			'ww_recruitment_mrf_pointperson',
			'ww_report_list',
			'ww_report_query',
			'ww_report_query_param',
			'ww_report_repository',
			'ww_report_results',
			'ww_report_result_filters',
			'ww_reports',
			'ww_resources_downloadable',
			'ww_resources_policies',
			'ww_resources_request',
			'ww_resources_request_approver',
			'ww_resources_request_notes',
			'ww_resources_request_upload',	
			'ww_resources_request_upload_hr',
			'ww_roles_menu',
			'ww_system_birthday',
			'ww_system_chat',
			'ww_system_email_queue',
			'ww_system_feeds',
			'ww_system_feeds_comments',
			'ww_system_feeds_recipient',
			'ww_system_inbox',
			'ww_system_inbox_recipient',
			'ww_system_messages',
			'ww_system_messages_template',
			'ww_system_password_request',
			'ww_system_sms_queue',
			'ww_system_uploads',
			'ww_taxcode',
			'ww_approver_class_company',
			'ww_approver_class_department',
			'ww_approver_class_position',
			'ww_approver_class_users',
			'ww_memo',
			'ww_memo_recipient',
			'ww_partners',
			'ww_partners_accountability',
			'ww_partners_clearance',
			'ww_partners_clearance_exit_interview_answers',
			'ww_partners_clearance_exit_interview_layout',
			'ww_partners_clearance_exit_interview_layout_item',
			'ww_partners_clearance_layout',
			'ww_partners_clearance_layout_sign',
			'ww_partners_clearance_signatories',
			'ww_partners_clearance_signatories_accountabilities',
			'ww_partners_clearance_signatory',
			'ww_partners_clinic_records',
			'ww_partners_disciplinary_action',
			'ww_partners_health_records',
			'ww_partners_incident',
			'ww_partners_incident_approver',
			'ww_partners_incident_nte',
			'ww_partners_movement',
			'ww_partners_movement_action',
			'ww_partners_movement_action_compensation',
			'ww_partners_movement_action_extension',
			'ww_partners_movement_action_leave_credits',
			'ww_partners_movement_action_moving',
			'ww_partners_movement_action_transfer',
			'ww_partners_movement_approver',
			'ww_partners_movement_cause',
			'ww_partners_movement_fields',
			'ww_partners_movement_reason',
			'ww_partners_offense',
			'ww_partners_offense_sanction',
			'ww_partners_personal',
			'ww_partners_personal_approver',
			'ww_partners_personal_request',
			'ww_partners_safe_manhour',
			'ww_payroll_account',
			'ww_payroll_annual_tax',
			'ww_payroll_bank',
			'ww_payroll_bonus',
			'ww_payroll_bonus_accrual',
			'ww_payroll_bonus_employee',
			'ww_payroll_closed_summary',
			'ww_payroll_closed_summary_id',
			'ww_payroll_closed_transaction',
			'ww_payroll_current_transaction',
			'ww_payroll_entry_batch',
			'ww_payroll_entry_batch_employee',
			'ww_payroll_entry_recurring',
			'ww_payroll_entry_recurring_employee',
			'ww_payroll_partners',
			'ww_payroll_partners_contribution',
			'ww_payroll_partners_loan',
			'ww_payroll_partners_loan_payment',
			'ww_payroll_paycode',
			'ww_recruitment',
			'ww_recruitment_benefit',
			'ww_recruitment_benefit_package',
			'ww_recruitment_employment_checklist',
			'ww_recruitment_interview_details',
			'ww_recruitment_personal',
			'ww_recruitment_personal_history',
			'ww_recruitment_process',
			'ww_recruitment_process_employment',
			'ww_recruitment_process_employment_checklist',
			'ww_recruitment_process_interview',
			'ww_recruitment_process_interview_result',
			'ww_recruitment_process_offer',		
			'ww_recruitment_process_offer_compben',
			'ww_recruitment_process_schedule',
			'ww_recruitment_process_signing',
			'ww_recruitment_process_timeline',
			'ww_recruitment_request',
			'ww_recruitment_request_approver',
			'ww_recruitment_request_details',
			'ww_time_day_allowance',
			'ww_time_day_break',
			'ww_time_day_break_range',
			'ww_time_day_meal',
			'ww_time_day_meal_range',
			'ww_time_day_transpo',
			'ww_time_day_transpo_range',
			'ww_time_day_type_allowance',
			'ww_time_day_type_break',
			'ww_time_device',
			'ww_time_device_column',
			'ww_time_form_balance',
			'ww_time_form_balance_setup',
			'ww_time_form_balance_setup_increment',
			'ww_time_form_balance_setup_policy',
			'ww_time_form_class',
			'ww_time_form_class_policy',
			'ww_time_form_employment',
			'ww_time_forms',
			'ww_time_forms_approver',
			'ww_time_forms_blanket',
			'ww_time_forms_date',
			'ww_time_forms_maternity',
			'ww_time_forms_obt',
			'ww_time_forms_obt_transpo',
			'ww_time_forms_upload',
			'ww_time_grace_period',
			'ww_time_holiday',
			'ww_time_holiday_event',
			'ww_time_holiday_location',
			'ww_time_period',
			'ww_time_period_extension',
			'ww_time_period_log',
			'ww_time_record',
			'ww_time_record_allowance',
			'ww_time_record_process',
			'ww_time_record_raw',
			'ww_time_record_summary',
			'ww_time_shift',
			'ww_time_shift_class',
			'ww_time_shift_class_company',
			'ww_time_shift_company',
			'ww_time_shift_restday',
			'ww_time_shift_weekly',
			'ww_time_shift_weekly_calendar',
			'ww_upload_results',
			'ww_users_company',
			'ww_users_company_contact',
			'ww_users_department',
			'ww_users_department_position',
			'ww_users_division',
			'ww_users_group',
			'ww_users_job_family',
			'ww_users_job_family_department',
			'ww_users_job_pay_level',
			'ww_users_job_rank',
			'ww_users_job_title',
			'ww_users_location',
			'ww_users_profile_public',
			'ww_users_profile_public_data',
			'ww_utility_task',
			'ww_partners_personal_history'
		);

		foreach( $tables as $table )
		{
			echo "Clearing {$table}<br/>";
			//$this->db->truncate($table);
		}
	}

	function delete_except_admin_data()
	{
		/*$this->db->delete('ww_profiles', array('profile_id !=' => 1));
		$this->db->delete('ww_profiles_permission', array('profile_id !=' => 1));
		$this->db->delete('ww_roles', array('role_id !=' => 1));
		$this->db->delete('ww_roles_profile', array('profile_id !=' => 1, 'role_id !=' => 1));
		$this->db->delete('ww_users', array('user_id !=' => 1));
		$this->db->delete('ww_users_profile', array('user_id !=' => 1));
		$this->db->delete('ww_users_position', array('position_id !=' => 1));
		*/
	}

	function upload_from_folder( $folder = "default" )
	{
		$this->upload_position( $folder );
	}

	function reference_uploder( $table = "", $folder = "default" )
	{
		if( $table != "" )
		{
			$fdata = file('uploads/'.$folder.'/'.$table.'.txt');
			$skip = true;
			$count = 0;
			$count_row = 0;
			foreach($fdata as $row)
			{
				$data = explode("\t", $row);
				if(!$skip)
				{
					$count_row++;
					$insert = array();

					foreach( $data as $index => $value ){
						if( !empty($index_key[$index]) ){
							$insert[$index_key[$index]] = trim($value);
							$insert[$index_key[$index]] = str_replace('"', '', $insert[$index_key[$index]]);
						}
					}

					//$this->db->insert($table, $insert);
				}
				else{
					foreach( $data as $index => $value ){
						if( !empty($value) ) $index_key[$index] = trim($value);
					} 
				}
				$skip = false;
			}
		}
	}

	function users_upload( $folder = "default" )
	{
		$fdata = file('uploads/'.$folder.'/users.txt');
		$skip = true;
		$count = 0;
		$count_row = 0;
		foreach($fdata as $row)
		{
			$data = explode("\t", $row);
			if(!$skip)
			{
				$count_row++;
				$insert = array();

				foreach( $data as $index => $value ){
					if( !empty($index_key[$index]) ){
						$insert[$index_key[$index]] = trim($value);
						$insert[$index_key[$index]] = str_replace('"', '', $insert[$index_key[$index]]);
					}
				}

				//$this->db->insert('users', $insert);
			}
			else{
				foreach( $data as $index => $value ){
					if( !empty($value) ) $index_key[$index] = trim($value);
				} 
			}
			$skip = false;
		}
	}

	function users_profile( $folder = "default" )
	{
		$fdata = file('uploads/'.$folder.'/users_profile.txt');
		$skip = true;
		$count = 0;
		$count_row = 0;
		foreach($fdata as $row)
		{
			$data = explode("\t", $row);
			if(!$skip)
			{
				$count_row++;
				$insert = array();

				foreach( $data as $index => $value ){
					if( !empty($index_key[$index]) ){
						$insert[$index_key[$index]] = trim($value);
						$insert[$index_key[$index]] = str_replace('"', '', $insert[$index_key[$index]]);
					}
				}

				//get user
				$this->db->limit(1);
				$user = $this->db->get_where('users', array('login' => $insert['login']))->row();
				unset($insert['login']);
				$insert['user_id'] = $user->user_id;
				
				//get position
				$this->db->limit(1);
				$position = $this->db->get_where('users_position', array('position' => $insert['position_id']))->row();
				$insert['position_id'] = $position->position_id;

				//get company
				$this->db->limit(1);
				$company = $this->db->get_where('users_company', array('company' => $insert['company_id']))->row();
				$insert['company_id'] = $company->company_id;

				//get location
				$this->db->limit(1);
				$location = $this->db->get_where('users_location', array('location' => $insert['location_id']))->row();
				$insert['location_id'] = $location->location_id;
				
				//get division
				$this->db->limit(1);
				$division = $this->db->get_where('users_division', array('division' => $insert['division_id']))->row();
				$insert['division_id'] = $division->division_id;

				//get department
				$this->db->limit(1);
				$department = $this->db->get_where('users_department', array('UPPER(department)' => $insert['department_id']))->row();
				$insert['department_id'] = $department->department_id;
				
				$this->db->limit(1);
				$check = $user = $this->db->get_where('users_profile', array('user_id' => $user->user_id));
				if($check->num_rows() == 0)
				{
					$this->db->insert('users_profile', $insert);
					if( $this->db->_error_message() != "")
					{
						echo $this->db->_error_message();
						debug($data[7]);
					}
				}
			}
			else{
				foreach( $data as $index => $value ){
					if( !empty($value) ) $index_key[$index] = trim($value);
				} 
			}
			$skip = false;
		}
	}

	function partners( $folder = "default" )
	{
		$fdata = file('uploads/'.$folder.'/partners.txt');
		$skip = true;
		$count = 0;
		$count_row = 0;
		foreach($fdata as $row)
		{
			$data = explode("\t", $row);
			if(!$skip)
			{
				$count_row++;
				$insert = array();

				foreach( $data as $index => $value ){
					if( !empty($index_key[$index]) ){
						$insert[$index_key[$index]] = trim($value);
						$insert[$index_key[$index]] = str_replace('"', '', $insert[$index_key[$index]]);
					}
				}

				//get user
				$this->db->limit(1);
				$user = $this->db->get_where('users', array('login' => $insert['login']))->row();
				unset($insert['login']);
				$insert['user_id'] = $user->user_id;
			
				//get shift
				$this->db->limit(1);
				$shift = $this->db->get_where('time_shift', array('shift' => $insert['shift_id']))->row();
				$insert['shift_id'] = $shift->shift_id;

				//get status
				$this->db->limit(1);
				$status = $this->db->get_where('partners_employment_status', array('employment_status' => $insert['status_id']))->row();
				$insert['status_id'] = $status->employment_status_id;
				
				$this->db->insert('partners', $insert);
				$partner_id = $this->db->insert_id();
				$this->db->update('users_profile', array('partner_id' => $partner_id), array('user_id' => $user->user_id));
			}
			else{
				foreach( $data as $index => $value ){
					if( !empty($value) ) $index_key[$index] = trim($value);
				} 
			}
			$skip = false;
		}
	}

	function upload_position( $folder = "default" )
	{
		$fdata = file('uploads/'.$folder.'/position.txt');
		$skip = true;
		$count = 0;
		$count_row = 0;
		foreach($fdata as $row)
		{
			$data = explode("\t", $row);
			if(!$skip)
			{
				$count_row++;
				$insert = array();

				foreach( $data as $index => $value ){
					if( !empty($index_key[$index]) ){
						$insert[$index_key[$index]] = trim($value);
						$insert[$index_key[$index]] = str_replace('"', '', $insert[$index_key[$index]]);
					}
				}

				$this->db->insert('users_position', $insert);
			}
			else{
				foreach( $data as $index => $value ){
					if( !empty($value) ) $index_key[$index] = trim($value);
				} 
			}
			$skip = false;
		}	
	}

	function partners_key( $folder = "default" )
	{
		$fdata = file('uploads/'.$folder.'/emergency.txt');
		$skip = true;
		$count = 0;
		$count_row = 0;
		foreach($fdata as $row)
		{
			$data = explode("\t", $row);
			if(!$skip)
			{
				$count_row++;
				$insert = array();

				foreach( $data as $index => $value ){
					if( !empty($index_key[$index]) ){
						if( $index_key[$index] != "login" )
						{
							$this->db->limit(1);
							$key = $this->db->get_where('partners_key', array('key_code' => $index_key[$index]))->row();	
						
							$insert['partner_id'] = $partner->partner_id;
							$insert['key'] = $key->key_code;
							$insert['key_id'] = $key->key_id;
							$insert['key_name'] = $key->key_label;
							$insert['key_value'] = trim($value);
							$insert['created_by'] = 1;

							$this->db->insert('partners_personal', $insert);
						}
						else{
							$this->db->limit(1);
							$user = $this->db->get_where('users', array('login' => $value))->row();
							$this->db->limit(1);
							$partner = $this->db->get_where('partners', array('user_id' => $user->user_id))->row();
						}
					}
				}
			}
			else{
				foreach( $data as $index => $value ){
					if( !empty($value) ) $index_key[$index] = trim($value);
				} 
			}
			$skip = false;
		}
	}

	function payroll_partners( $folder = "default" )
	{
		$fdata = file('uploads/'.$folder.'/payroll_partners.txt');
		$skip = true;
		$count = 0;
		$count_row = 0;
		foreach($fdata as $row)
		{
			$data = explode("\t", $row);
			if(!$skip)
			{
				$count_row++;
				$insert = array();

				foreach( $data as $index => $value ){
					if( !empty($index_key[$index]) ){
						$insert[$index_key[$index]] = trim($value);
						$insert[$index_key[$index]] = str_replace('"', '', $insert[$index_key[$index]]);
					}
				}

				//get user
				$this->db->limit(1);
				$user = $this->db->get_where('users', array('login' => $insert['login']))->row();
				unset($insert['login']);
				$insert['user_id'] = $user->user_id;
			
				$this->db->insert('payroll_partners', $insert);
			}
			else{
				foreach( $data as $index => $value ){
					if( !empty($value) ) $index_key[$index] = trim($value);
				} 
			}
			$skip = false;
		}
	}

	function birthdate( $folder = "default" )
	{
		$fdata = file('uploads/'.$folder.'/birthdate.txt');
		$skip = true;
		$count = 0;
		$count_row = 0;
		foreach($fdata as $row)
		{
			$data = explode("\t", $row);
			if(!$skip)
			{
				$count_row++;
				$insert = array();

				foreach( $data as $index => $value ){
					if( !empty($index_key[$index]) ){
						$insert[$index_key[$index]] = trim($value);
						$insert[$index_key[$index]] = str_replace('"', '', $insert[$index_key[$index]]);
					}
				}

				//get user
				$this->db->limit(1);
				$user = $this->db->get_where('users', array('login' => $insert['login']))->row();
				unset($insert['login']);
				$insert['user_id'] = $user->user_id;
			
				
				$this->db->update('partners', array('id_number' => $user->login), array('user_id' => $user->user_id));
			}
			else{
				foreach( $data as $index => $value ){
					if( !empty($value) ) $index_key[$index] = trim($value);
				} 
			}
			$skip = false;
		}
	}

	function biometric( $folder = "default" )
	{
		$fdata = file('uploads/'.$folder.'/biometric.txt');
		$skip = true;
		$count = 0;
		$count_row = 0;
		foreach($fdata as $row)
		{
			$data = explode("\t", $row);
			if(!$skip)
			{
				$count_row++;
				$insert = array();

				foreach( $data as $index => $value ){
					if( !empty($index_key[$index]) ){
						$insert[$index_key[$index]] = trim($value);
						$insert[$index_key[$index]] = str_replace('"', '', $insert[$index_key[$index]]);
					}
				}

				//get user
				$this->db->limit(1);
				$user = $this->db->get_where('users', array('login' => $insert['login']))->row();
				unset($insert['login']);
				$insert['user_id'] = $user->user_id;
			
				
				$this->db->update('partners', $insert, array('user_id' => $user->user_id));
			}
			else{
				foreach( $data as $index => $value ){
					if( !empty($value) ) $index_key[$index] = trim($value);
				} 
			}
			$skip = false;
		}
	}

	function email_update( $folder = "default" )
	{
		$fdata = file('uploads/'.$folder.'/email_update.txt');
		$skip = true;
		$count = 0;
		$count_row = 0;
		foreach($fdata as $row)
		{
			$data = explode("\t", $row);
			if(!$skip)
			{
				$count_row++;
				$insert = array();

				foreach( $data as $index => $value ){
					if( !empty($index_key[$index]) ){
						$insert[$index_key[$index]] = trim($value);
						$insert[$index_key[$index]] = str_replace('"', '', $insert[$index_key[$index]]);
					}
				}

				//get user
				$this->db->limit(1);
				$user = $this->db->get_where('users', array('login' => $insert['login']))->row();
				unset($insert['login']);
				
				$this->db->update('users', $insert, array('user_id' => $user->user_id));
			}
			else{
				foreach( $data as $index => $value ){
					if( !empty($value) ) $index_key[$index] = trim($value);
				} 
			}
			$skip = false;
		}
	}

	function reports_to( $folder = "default" )
	{
		$fdata = file('uploads/'.$folder.'/reports_to.txt');
		$skip = true;
		$count = 0;
		$count_row = 0;
		foreach($fdata as $row)
		{
			$data = explode("\t", $row);
			if(!$skip)
			{
				$count_row++;
				$insert = array();

				foreach( $data as $index => $value ){
					if( !empty($index_key[$index]) ){
						$insert[$index_key[$index]] = trim($value);
						$insert[$index_key[$index]] = str_replace('"', '', $insert[$index_key[$index]]);
					}
				}

				//get user
				$this->db->limit(1);
				$user = $this->db->get_where('users', array('login' => $insert['login']))->row();
				unset($insert['login']);
				
				//get reports to
				$this->db->limit(1);
				$qry = "select * from ww_users_profile
				where CONCAT(firstname, if(middlename != '', CONCAT(' ', middlename, ' '), ' '), lastname) = '{$insert['reports_to_id']}'";
				$reports_to = $this->db->query($qry);
				
				if( $reports_to->num_rows() == 1 )
				{
					$reports_to = $reports_to->row();
					$insert['reports_to_id'] = $reports_to->user_id;
					$this->db->update('users_profile', $insert, array('user_id' => $user->user_id));
				}
				else{
					echo $user->user_id.' - '.$insert['reports_to_id'].'<br/>';
				}

				
			}
			else{
				foreach( $data as $index => $value ){
					if( !empty($value) ) $index_key[$index] = trim($value);
				} 
			}
			$skip = false;
		}
	}

	function new_login( $folder = "default" )
	{
		$fdata = file('uploads/'.$folder.'/new_login.txt');
		$skip = true;
		$count = 0;
		$count_row = 0;
		foreach($fdata as $row)
		{
			$data = explode("\t", $row);
			if(!$skip)
			{
				$count_row++;
				$insert = array();

				foreach( $data as $index => $value ){
					if( !empty($index_key[$index]) ){
						$insert[$index_key[$index]] = trim($value);
						$insert[$index_key[$index]] = str_replace('"', '', $insert[$index_key[$index]]);
					}
				}

				//get user
				$this->db->limit(1);
				$user = $this->db->get_where('users', array('login' => $insert['old_login']))->row();
				unset($insert['old_login']);
				
				$this->db->update('users', $insert, array('user_id' => $user->user_id));
			}
			else{
				foreach( $data as $index => $value ){
					if( !empty($value) ) $index_key[$index] = trim($value);
				} 
			}
			$skip = false;
		}
	}

	function create_trial_db()
	{
		$this->load->model('trial_dbmanager_model', 'trial_dbm');
		$result = $this->trial_dbm->create_trial_db();
		debug( $result );
	}

	function approvers( $folder = "default" )
	{
		$fdata = file('uploads/'.$folder.'/approvers.txt');
		$skip = true;
		$count = 0;
		$count_row = 0;
		foreach($fdata as $row)
		{
			$data = explode("\t", $row);
			if(!$skip)
			{
				$count_row++;
				$insert = array();

				foreach( $data as $index => $value ){
					if( !empty($index_key[$index]) ){
						$insert[$index_key[$index]] = trim($value);
						$insert[$index_key[$index]] = str_replace('"', '', $insert[$index_key[$index]]);
					}
				}

				$classes = array(2,8,9,12,11);
				foreach( $classes as $class_id )
				{
					$insert['class_id'] = $class_id;
					
					$where = array(
						'class_id' => $insert['class_id'],
						'company_id' => $insert['company_id'], 
						'department_id' => $insert['department_id'], 
						'position_id' => $insert['position_id'],
						'sequence' => $insert['sequence']
					);

					$this->db->limit(1);
					$check = $this->db->get_where('approver_class_position', $where);

					if( $check->num_rows() == 1 )
						$this->db->update('approver_class_position', $insert, $where);
					else
						$this->db->insert('approver_class_position', $insert);
				}				
			}
			else{
				foreach( $data as $index => $value ){
					if( !empty($value) ) $index_key[$index] = trim($value);
				} 
			}
			$skip = false;
		}	
	}

	function position_update( $folder = "default" )
	{
		$fdata = file('uploads/'.$folder.'/user_new_position.txt');
		$skip = true;
		$count = 0;
		$count_row = 0;
		foreach($fdata as $row)
		{
			$data = explode("\t", $row);
			if(!$skip)
			{
				$count_row++;
				$insert = array();

				foreach( $data as $index => $value ){
					if( !empty($index_key[$index]) ){
						$insert[$index_key[$index]] = trim($value);
						$insert[$index_key[$index]] = str_replace('"', '', $insert[$index_key[$index]]);
					}
				}

				//get user
				$this->db->limit(1);
				$user = $this->db->get_where('users', array('login' => $insert['login']))->row();
				unset($insert['login']);
				if( !isset($user->user_id) )
				{
					echo $this->db->last_query() . '<br/>'; 
					continue;
				}

				//get position
				$this->db->limit(1);
				$position = $this->db->get_where('users_position', array('position' => $insert['position']))->row();
				unset($insert['position']);
				$insert['position_id'] = $position->position_id;
				
				$this->db->update('users_profile', $insert, array('user_id' => $user->user_id));
			}
			else{
				foreach( $data as $index => $value ){
					if( !empty($value) ) $index_key[$index] = trim($value);
				} 
			}
			$skip = false;
		}	
	}

	function leave_credits( $folder = "default" )
	{
		$fdata = file('uploads/'.$folder.'/leave_credits.txt');
		$skip = true;
		$count = 0;
		$count_row = 0;
		foreach($fdata as $row)
		{
			$data = explode("\t", $row);
			if(!$skip)
			{
				$count_row++;
				$insert = array();

				foreach( $data as $index => $value ){
					if( !empty($index_key[$index]) ){
						$insert[$index_key[$index]] = trim($value);
						$insert[$index_key[$index]] = str_replace('"', '', $insert[$index_key[$index]]);
					}
				}

				//get user
				$this->db->limit(1);
				$user = $this->db->get_where('users', array('login' => $insert['login']))->row();
				unset($insert['login']);
				if( !isset($user->user_id) )
				{
					echo $this->db->last_query() . '<br/>'; 
					continue;
				}
				$insert['user_id'] = $user->user_id;
				
				$where = array(
					'form_code' => $insert['form_code'],
					'year' => $insert['year'],
					'user_id' => $insert['user_id']
				);

				$check = $this->db->get_where('time_form_balance', $where);
				if( $check->num_rows() == 0 )
					$this->db->insert('time_form_balance', $insert);
				else
					$this->db->update('time_form_balance', $insert, $where);

				echo $this->db->_error_message();
			}
			else{
				foreach( $data as $index => $value ){
					if( !empty($value) ) $index_key[$index] = trim($value);
				} 
			}
			$skip = false;
		}	
	}

	function sick_leaves( $folder = "default" )
	{
		$fdata = file('uploads/'.$folder.'/sick_leaves.txt');
		$skip = true;
		$count = 0;
		$count_row = 0;
		foreach($fdata as $row)
		{
			$data = explode("\t", $row);
			if(!$skip)
			{
				$count_row++;
				$insert = array();

				foreach( $data as $index => $value ){
					if( !empty($index_key[$index]) ){
						$insert[$index_key[$index]] = trim($value);
						$insert[$index_key[$index]] = str_replace('"', '', $insert[$index_key[$index]]);
					}
				}

				//get user
				$this->db->limit(1);
				$user = $this->db->get_where('users', array('login' => $insert['login']))->row();
				unset($insert['login']);
				if( !isset($user->user_id) )
				{
					echo $this->db->last_query() . '<br/>'; 
					continue;
				}
				$insert['user_id'] = $user->user_id;
				
				$where = array(
					'form_code' => $insert['form_code'],
					'year' => $insert['year'],
					'user_id' => $insert['user_id']
				);

				$check = $this->db->get_where('time_form_balance', $where);
				if( $check->num_rows() == 0 )
					$this->db->insert('time_form_balance', $insert);
				else
					$this->db->update('time_form_balance', $insert, $where);
			}
			else{
				foreach( $data as $index => $value ){
					if( !empty($value) ) $index_key[$index] = trim($value);
				} 
			}
			$skip = false;
		}	
	}

	function employee_grade( $folder = "default" )
	{
		$fdata = file('uploads/'.$folder.'/employee_grade.txt');
		$skip = true;
		$count = 0;
		$count_row = 0;
		foreach($fdata as $row)
		{
			$data = explode("\t", $row);
			if(!$skip)
			{
				$count_row++;
				$insert = array();

				foreach( $data as $index => $value ){
					if( !empty($index_key[$index]) ){
						$insert[$index_key[$index]] = trim($value);
						$insert[$index_key[$index]] = str_replace('"', '', $insert[$index_key[$index]]);
					}
				}

				//get user
				$this->db->limit(1);
				$user = $this->db->get_where('users', array('login' => $insert['login']))->row();
				unset($insert['login']);
				if( !isset($user->user_id) )
				{
					echo $this->db->last_query() . '<br/>'; 
					continue;
				}
				$partner = $this->db->get_where('partners', array('user_id' => $user->user_id))->row();
				if( !isset($partner->user_id) )
				{
					echo $this->db->last_query() . '<br/>'; 
					continue;
				}
				$insert['partner_id'] = $partner->partner_id;
				
				$where = array(
					'key_id' => $insert['key_id'],
					'partner_id' => $insert['partner_id'],
				);

				$check = $this->db->get_where('partners_personal', $where);
				if( $check->num_rows() == 0 )
					$this->db->insert('partners_personal', $insert);
				else
					$this->db->update('partners_personal', $insert, $where);
			}
			else{
				foreach( $data as $index => $value ){
					if( !empty($value) ) $index_key[$index] = trim($value);
				} 
			}
			$skip = false;
		}	
	}

	function signatories_update( $folder = "default" )
	{
		$fdata = file('uploads/'.$folder.'/updated_signatories.txt');
		$skip = true;
		$count = 0;
		$count_row = 0;
		foreach($fdata as $row)
		{
			$data = explode("\t", $row);
			if(!$skip)
			{
				$count_row++;
				$insert = array();

				foreach( $data as $index => $value ){
					if( !empty($index_key[$index]) ){
						$insert[$index_key[$index]] = trim($value);
						$insert[$index_key[$index]] = str_replace('"', '', $insert[$index_key[$index]]);
					}
				}

				//get user
				$this->db->limit(1);
				$user = $this->db->get_where('users', array('login' => $insert['login']))->row();
				unset($insert['login']);
				if( !isset($user->user_id) )
				{
					echo $this->db->last_query() . '<br/>'; 
					continue;
				}

				$insert['user_id'] = $user->user_id;
				$classes = array(1,2,5,6,7,8,9,10,11,23,24,25,26,27,28,29,30,31,32);
				foreach( $classes as $class_id )
				{
					$insert['class_id'] = $class_id;
					$this->db->insert('approver_class_user', $insert);
				}
			}
			else{
				foreach( $data as $index => $value ){
					if( !empty($value) ) $index_key[$index] = trim($value);
				} 
			}
			$skip = false;
		}	
	}
}