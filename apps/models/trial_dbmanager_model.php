<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class trial_dbmanager_model extends Record
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
		parent::__construct();
	}

	function create_trial_db()
	{
		$trialdb = FCPATH . 'uploads\data\trialdb.sql';
		$trialdb_data_loc = FCPATH . 'uploads/data/wwv4_data.sql';

		$business_groups = $this->db->get_where('business_group', array('deleted' => 0));

		if( $business_groups->num_rows() > 0 )
		{
			foreach( $business_groups->result() as $group )
			{
				if( $group->db !== 'default' )
				{
					$dbconfig['hostname'] = $this->db->hostname;
					$dbconfig['username'] = $this->db->username;
					$dbconfig['password'] = $this->db->password;
					$dbconfig['database'] = 'workwise.'.$group->db;
					$dbconfig['dbdriver'] = 'mysqli';
					$dbconfig['dbprefix'] = 'ww_';
					$dbconfig['pconnect'] = FALSE;
					$dbconfig['db_debug'] = FALSE;
					$dbconfig['cache_on'] = FALSE;
					$dbconfig['cachedir'] = '';
					$dbconfig['char_set'] = 'utf8';
					$dbconfig['dbcollat'] = 'utf8_general_ci';
					$dbconfig['swap_pre'] = '';
					$dbconfig['autoinit'] = FALSE;
					$dbconfig['stricton'] = FALSE;
	
					$group_db = $this->load->database($dbconfig, TRUE);
					$connected = $group_db->initialize();
					if( !$connected )
					{
						$this->load->dbforge();
						if ($this->dbforge->create_database('`workwise.'.$group->db.'`'))
						{
							$qry = 'D:\WebServer\mysql\bin\mysql.exe -u '. $this->db->username .' -p'.$this->db->password.' -h '.$this->db->hostname.' workwise.'.$group->db.' < '.$trialdb;
							echo exec( trim($qry) );
							$this->db_clean($group_db);

							$insert = array(
								'company_code' => $group->db,
								'company' => $group->group
							);
							$group_db->insert('users_company', $insert);

							$insert = array(
								'division_code' => $group->db,
								'division' => $group->group
							);
							$group_db->insert('users_division', $insert);
							$division_id = $group_db->insert_id();

							$insert = array(
								'division_id' => $division_id,
								'department_code' => $group->db,
								'department' => $group->group
							);
							$group_db->insert('users_department', $insert);

							$insert = array(
								'location_code' => $group->db,
								'location' => $group->group
							);
							$group_db->insert('users_location', $insert);

							$insert = array(
								'group' => $group->db,
								'group_code' => $group->db,
								'region_id' => 1,
								'db' => $group->db,
								'icon' => 'assets/img/flags/ph.png',
								'logo' => 'assets/img/hdi-logo-resource.png'
							);
							$group_db->insert('ww_business_group', $insert);
							
							$this->load->library('phpass');
							$password = $this->phpass->hash( 'password' );
							$user = array(
								'role_id' => 1,
								'email' => 'webmaster@xhdisystech.com',
								'login' => $group->db,
								'hash' => $password
							);

							$group_db->insert('ww_users', $user);
							$user_id = $group_db->insert_id();

							$user_profile = array(
								'user_id' => $user_id,
								'lastname' => 'Doe',
								'firstname' => 'John',
								'company_id' => 1,
								'division_id' => 1,
								'department_id' => 1,
								'position_id' => 1,
								'location_id' => 1,
								'photo' => 'uploads/users/avatar.jpg',
								'birth_date' => '2006-08-01',
								'business_level_id' => '3'
							);

							$group_db->insert('ww_users_profile', $user_profile);
						}	
					}
				}
			}
		}

		$this->create_multidb_file();	
	}

	private function db_clean( $db )
	{
		$tables = array(
			'ww_approver_class_company',
			'ww_approver_class_department',
			'ww_approver_class_position',
			'ww_approver_class_users',
			'ww_business_group',
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
			'ww_partners_clearance_signatory',
			'ww_partners_clearance_signatories_accountabilities',
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
			'ww_partners_offense',
			'ww_partners_offense_sanction',
			'ww_partners_personal',
			'ww_partners_personal_approver',
			'ww_partners_personal_history',
			'ww_partners_personal_history_orig',
			'ww_partners_personal_orig',
			'ww_partners_personal_request',
			'ww_partners_safe_manhour',
			'ww_payroll_account',
			'ww_payroll_bank',
			'ww_payroll_bonus',
			'ww_payroll_bonus_accrual',
			'ww_payroll_bonus_employee',
			'ww_payroll_closed_summary',
			'ww_payroll_closed_transaction',
			'ww_payroll_current_transaction',
			'ww_payroll_entry_batch',
			'ww_payroll_entry_batch_employee',
			'ww_payroll_entry_recurring',
			'ww_payroll_entry_recurring_employee',
			'ww_payroll_loan',
			'ww_payroll_location',
			'ww_payroll_partners',
			'ww_payroll_partners_contribution',
			'ww_payroll_partners_loan',
			'ww_payroll_partners_loan_payment',
			'ww_payroll_paycode',
			'ww_payroll_period',
			'ww_payroll_upload_results',
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
			'ww_performance_setup_notification',
			'ww_performance_setup_performance',
			'ww_performance_setup_scorecard',
			'ww_performance_template',
			'ww_performance_template_applicable',
			'ww_performance_template_section',
			'ww_performance_template_section_column',
			'ww_performance_template_section_column_fields',
			'ww_performance_template_section_column_item',
			'ww_quarters',
			'ww_recruitment',
			'ww_recruitment_benefit',
			'ww_recruitment_benefit_package',
			'ww_recruitment_interview_details',
			'ww_recruitment_manpower_plan',
			'ww_recruitment_manpower_plan_approver',
			'ww_recruitment_manpower_plan_incumbent',
			'ww_recruitment_manpower_plan_position',
			'ww_recruitment_manpower_plan_position_new',
			'ww_recruitment_mrf_pointperson',
			'ww_recruitment_personal',
			'ww_recruitment_personal_history',
			'ww_recruitment_process',
			'ww_recruitment_process_employment',
			'ww_recruitment_process_employment_checklist',
			'ww_recruitment_process_interview',
			'ww_recruitment_process_offer',
			'ww_recruitment_process_offer_compben',
			'ww_recruitment_process_schedule',
			'ww_recruitment_process_signing',
			'ww_recruitment_process_timeline',
			'ww_recruitment_request_details',
			'ww_recruitment_request',
			'ww_recruitment_request_approver',
			'ww_report_results',
			'ww_report_result_filters',
			'ww_resources_downloadable',
			'ww_resources_policies',
			'ww_resources_request',
			'ww_resources_request_approver',
			'ww_resources_request_notes',
			'ww_resources_request_upload',
			'ww_resources_request_upload_hr',
			'ww_sessions',
			'ww_system_birthday',
			'ww_system_feeds_comments',
			'ww_system_feeds',
			'ww_system_email_queue',
			'ww_system_chat',
			'ww_system_feeds_recipient',
			'ww_system_inbox',
			'ww_system_inbox_recipient',
			'ww_system_messages',
			'ww_system_password_request',
			'ww_system_sms_queue',
			'ww_system_upload_log',
			'ww_system_upload_template',
			'ww_system_upload_template_column',
			'ww_system_uploads',
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
			'ww_time_shift_class_company',
			'ww_time_shift_company',
			'ww_time_shift_restday',
			'ww_users_company_contact',
			'ww_users_department_position',
			'ww_users_job_family',
			'ww_users_job_family_department',
			'ww_users_job_pay_level',
			'ww_users_job_rank',
			'ww_users_job_title',
			'ww_users_profile_public',
			'ww_users_profile_public_data',
			'ww_users_company',
			'ww_users_division',
			'ww_users_department',
			'ww_users_location'
		);

		foreach( $tables as $table )
		{
			$db->truncate($table);
		}

		$db->delete('ww_users', array('user_id !=' => 1));
		$db->delete('ww_users_profile', array('user_id !=' => 1));
	}

	private function create_multidb_file()
	{
		$to_write = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');\r\n\r\n";

		$business_groups = $this->db->get_where('business_group', array('deleted' => 0));
		if( $business_groups->num_rows() > 0 )
		{
			foreach( $business_groups->result() as $group )
			{
				if( $group->db !== 'default' )
				{
        			$to_write .= "$"."config['".$group->db."']['hostname'] = '".$this->db->hostname."';\r\n";
					$to_write .= "$"."config['".$group->db."']['username'] = '".$this->db->username."';\r\n";
					$to_write .= "$"."config['".$group->db."']['password'] = '".$this->db->password."';\r\n";
					$to_write .= "$"."config['".$group->db."']['database'] = 'workwise.".$group->db."';\r\n";
					$to_write .= "$"."config['".$group->db."']['dbdriver'] = 'mysqli';\r\n";
					$to_write .= "$"."config['".$group->db."']['dbprefix'] = 'ww_';\r\n";
					$to_write .= "$"."config['".$group->db."']['pconnect'] = FALSE;\r\n";
					$to_write .= "$"."config['".$group->db."']['db_debug'] = FALSE;\r\n";
					$to_write .= "$"."config['".$group->db."']['cache_on'] = FALSE;\r\n";
					$to_write .= "$"."config['".$group->db."']['cachedir'] = '';\r\n";
					$to_write .= "$"."config['".$group->db."']['char_set'] = 'utf8';\r\n";
					$to_write .= "$"."config['".$group->db."']['dbcollat'] = 'utf8_general_ci';\r\n";
					$to_write .= "$"."config['".$group->db."']['swap_pre'] = '';\r\n";
					$to_write .= "$"."config['".$group->db."']['autoinit'] = FALSE;\r\n";
					$to_write .= "$"."config['".$group->db."']['stricton'] = FALSE;\r\n\r\n";;
				}
			}
		}
		
		$multidb = APPPATH . 'config/multidb.php';
        $this->load->helper('file');
		write_file($multidb , $to_write);
	}
}