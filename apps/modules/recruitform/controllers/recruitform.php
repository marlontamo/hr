<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Recruitform extends MY_publicController
{
	public function __construct()
	{
		$this->load->model('appform_model', 'appform');		
		$this->load->model('recruitform_model', 'mod');
		parent::__construct();
		$this->lang->load( 'recruitform' );
		$this->lang->load( 'calendar' );
	}

	public function kiosk(){
		$data = array();
		$data['mrf'] = $this->appform->get_active_mrf_by_year();
		$data['employee'] = $this->appform->get_employee();
		$data['type_license'] = $this->appform->get_type_license();
		$data['sourcing_tool'] = $this->appform->get_sourcing_tools();
		$this->load->vars( $data );
		$this->load->helper('form');
		$this->load->helper('file');
		
		echo $this->load->blade('recruitment_kiosk')->with( $this->load->get_cached_vars() );
	}

	function validate_data(){

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
				'field' => 'recruitment[recruitment_date]',
				'label' => 'Date of Application',
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
			// $other
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal[resume]',
				'label' => 'Resume',
				'rules' => 'required'
				);
			// $other_tables['recruitment'] = $post['recruitment'];
			$partners_personal_table = "recruitment_personal";
			// $other_tables['partners'] = $post['partners'];
			// $other_tables['partners']['effectivity_date'] = date('Y-m-d', strtotime($post['partners']['effectivity_date']));
			$partners_personal_key = array('position_sought', 'desired_salary', 'photo', 'salary_pay_mode', 'currently_employed', 'resume'); //'how_hiring_heard'
			$partners_personal = $post['recruitment_personal'];
			break;
			case 2:
			//Contacts Tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment[email]',
				'label' => 'Email Address',
				'rules' => 'required|valid_email'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal[address_1]',
				'label' => 'Personal Address',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal[city_town]',
				'label' => 'City',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal[country]',
				'label' => 'Country',
				'rules' => 'required'
				);
			// $validation_rules[] = 
			// array(
			// 	'field' => 'recruitment_personal[zip_code]',
			// 	'label' => 'Zipcode',
			// 	'rules' => 'required'
			// 	);
			$partners_personal_table = "recruitment_personal";
			$partners_personal_key = array('phone', 'mobile', 'address_1', 'city_town', 'country', 'zip_code', 'emergency_name', 'emergency_relationship', 'emergency_phone', 'emergency_mobile', 'emergency_address', 'emergency_city', 'emergency_country', 'emergency_zip_code');
			$partners_personal = $post['recruitment_personal'];
			$partner_phone = $_POST['recruitment_personal']['phone'];
			$partner_mobile = $_POST['recruitment_personal']['mobile'];
			$emergency_phone = $_POST['recruitment_personal']['emergency_phone'];
			$emergency_mobile = $_POST['recruitment_personal']['emergency_mobile'];
			
			$this->response->invalid = false;
			// unset($partners_personal['mobile']);
			// foreach ($partner_mobile as $phone){
			// 	if(!empty($phone)){
			// 		$mobile = $this->check_mobile($phone);
			// 		if(!$mobile){
			// 			$this->response->invalid=true;
			// 			$this->response->invalid_message='Invalid mobile number';
			// 			$this->response->message[] = array(
			// 		    	'message' => 'Invalid mobile number',
			// 		    	'type' => 'warning'
			// 			);
		 //        	}else{
		 //        		$partners_personal['mobile'][] = $mobile;
		 //        	}
		 //        }
   //   //            else{
			// 		// $this->response->invalid=true;
			// 		// $this->response->invalid_message='Mobile Number filed is required';
			// 		// $this->response->message[] = array(
			// 	 //    	'message' => 'Mobile Number filed is required',
			// 	 //    	'type' => 'warning'
			// 		// );
		 //   //      }
			// }
   //      	if(!isset($partners_personal['mobile'])){
   //      		$partners_personal['mobile'] = array();
   //      	}
			// unset($partners_personal['phone']);
			// foreach ($partner_phone as $phone){
			// 	if(!empty($phone)){
			// 		$mobile = $this->check_phone($phone);
			// 		if(!$mobile){
			// 			$this->response->invalid=true;
			// 			$this->response->invalid_message='Invalid phone number';
			// 			$this->response->message[] = array(
			// 		    	'message' => 'Invalid phone number',
			// 		    	'type' => 'warning'
			// 			);
		 //        	}else{
		 //        		$partners_personal['phone'][] = $mobile;
		 //        	}
		 //        }
			// }
   //      	if(!isset($partners_personal['phone'])){
   //      		$partners_personal['phone'] = array();
   //      	}
			// if(!empty($partners_personal['emergency_mobile'])){
			// 	$mobile = $this->check_mobile($partners_personal['emergency_mobile']);
			// 	if(!$mobile){
			// 		$this->response->invalid=true;
			// 		$this->response->invalid_message='Invalid contact mobile number';
			// 		$this->response->message[] = array(
			// 	    	'message' => 'Invalid contact mobile number',
			// 	    	'type' => 'warning'
			// 		);
	  //       	}else{
	  //       		$partners_personal['emergency_mobile'] = $mobile;
	  //       	}
			// }

			// if(!empty($partners_personal['emergency_phone'])){
			// 	$mobile = $this->check_phone($partners_personal['emergency_phone']);
			// 	if(!$mobile){
			// 		$this->response->invalid=true;
			// 		$this->response->invalid_message='Invalid contact phone number';
			// 		$this->response->message[] = array(
			// 	    	'message' => 'Invalid contact phone number',
			// 	    	'type' => 'warning'
			// 		);
	  //       	}else{
	  //       		$partners_personal['emergency_phone'] = $mobile;
	  //       	}
			// }

			if($this->response->invalid==true){
				$this->_ajax_return();
			}

			break;
			case 3:
			//Personal Tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal[gender]',
				'label' => 'Gender',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment[birth_date]',
				'label' => 'Birthday',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal[dependents_count]',
				'label' => 'No. of Dependents',
				'rules' => 'numeric'
				);
			$partners_personal_table = "recruitment_personal";
			// $other_tables['users_profile'] = $post['users_profile'];
			// $other_tables['users_profile']['birth_date'] = date('Y-m-d', strtotime($post['users_profile']['birth_date']));
			$partners_personal_key = array('gender', 'birth_place', 'religion', 'nationality', 'civil_status', 'height', 'weight', 'interests_hobbies', 'language', 'dialect', 'dependents_count', 'solo_parent');
			$partners_personal = $post['recruitment_personal'];
			break;
			case 4:
			//Family tab
				if($post['family_count'] > 0){
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[family-name]',
						'label' => 'Name',
						'rules' => 'required'
						);
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[family-birthdate]',
						'label' => 'Birthday',
						'rules' => 'required'
						);
					$partners_personal_table = "recruitment_personal_history";
					$partners_personal_key = array('family-relationship', 'family-name', 'family-birthdate');
					if(array_key_exists('recruitment_personal_history', $post)){
						$partners_personal = $post['recruitment_personal_history'];
					}else{	
						$this->response->message[] = array(
								'message' => "Please add Family member.",
								'type' => 'warning'
								);  
						$this->_ajax_return();
					}
				}
			break;
			case 5:
			//Education Tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[education-school]',
				'label' => 'School',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[education-year-from]',
				'label' => 'Start Year',
				'rules' => 'required|numeric'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[education-year-to]',
				'label' => 'End Year',
				'rules' => 'required|numeric'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[education-status]',
				'label' => 'Status',
				'rules' => 'required'
				);

			$partners_personal_table = "recruitment_personal_history";
			$partners_personal_key = array('education-type', 'education-school', 'education-year-from', 'education-year-to', 'education-degree', 'education-status');
			// print_r($post);
			if(array_key_exists('recruitment_personal_history', $post)){
				$partners_personal = $post['recruitment_personal_history'];
				if(!array_key_exists('education-year-from', $partners_personal)){
					$this->response->message[] = array(
							'message' => "Please add educational attainments.",
							'type' => 'warning'
							); 
					$this->_ajax_return(); 
				}
				// if(array_key_exists('education-degree', $partners_personal)){					
				// 	$validation_rules[] = 
				// 	array(
				// 		'field' => 'recruitment_personal_history[education-degree]',
				// 		'label' => 'Degree',
				// 		'rules' => 'required'
				// 		);
				// }
			}else{	
				$this->response->message[] = array(
						'message' => "Please add educational attainments.",
						'type' => 'warning'
						); 
				$this->_ajax_return(); 
			}

			// validation for year end greater than year start and year end greater then current year
			$partners_personal_history = $_POST['recruitment_personal_history'];
			foreach ($partners_personal_history['education-year-from'] as $key => $value) 
			{
				$yr_from = $value;
			}
			foreach ($partners_personal_history['education-year-to'] as $key => $value) {
				$yr_to = $value;
			}

			if(!empty($yr_from) && !empty($yr_to)){
				if((!is_numeric($yr_from) || $yr_from < 1 || $yr_from != round($yr_from)) || (!is_numeric($yr_to) || $yr_to < 1 || $yr_to != round($yr_to))) {
					$this->response->invalid=true;
					$this->response->invalid_message='Year must be an integer.';
					$this->response->message[] = array(
				    	'message' => 'Year must be an integer.',
				    	'type' => 'warning'
					);
					$this->_ajax_return();
		        }	
		        else
		        {
		        	if($yr_from > $yr_to){
						$this->response->invalid=true;
						$this->response->invalid_message='Year end must be greater than year start.';
						$this->response->message[] = array(
					    	'message' => 'Year end must be greater than year start.',
					    	'type' => 'warning'
						);
						$this->_ajax_return();
		        	}
		        	else
		        	{
		        		$cur_yr = date('Y');
		        	 	if($yr_to > $cur_yr)
		        	 	{
		        	 		$this->response->invalid=true;
							$this->response->invalid_message='Year end must not be greater than the current year.';
							$this->response->message[] = array(
						    	'message' => 'Year end must not be greater than the current year.',
						    	'type' => 'warning'
							);
							$this->_ajax_return();
		        	 	}
		        	}
		        }	
			}
			break;
			case 6:
			//Employment History Tab
				if($post['employment_count'] > 0){
					
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[employment-company]',
						'label' => 'Company Name',
						'rules' => 'required'
						);
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[employment-position-title]',
						'label' => 'Position Title',
						'rules' => 'required'
						);
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[employment-year-hired]',
						'label' => 'Year Hired',
						'rules' => 'required|numeric'
						);
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[employment-year-end]',
						'label' => 'Year End',
						'rules' => 'required|numeric'
						);
					$partners_personal_table = "recruitment_personal_history";
					$partners_personal_key = array('employment-company', 'employment-position-title', 'employment-location', 'employment-duties', 'employment-month-hired', 'employment-month-end', 'employment-year-hired', 'employment-year-end');
					if(array_key_exists('recruitment_personal_history', $post)){
						$partners_personal = $post['recruitment_personal_history'];
					}else{	
						$this->response->message[] = array(
								'message' => "Please add employers.",
								'type' => 'warning'
								); 
						$this->_ajax_return(); 
					}
				}
			break;

			case 7:
			//Character Reference tab
				$partners_personal_table = "recruitment_personal_history";
				$partners_personal_key = array('reference-name', 'reference-occupation', 'reference-years-known', 'reference-phone', 'reference-mobile', 'reference-address', 'reference-city', 'reference-country', 'reference-zipcode');
				if(array_key_exists('recruitment_personal_history', $post)){
					$partners_personal = $post['recruitment_personal_history'];
					if(array_key_exists('reference-name', $partners_personal)){
						$validation_rules[] = 
						array(
							'field' => 'recruitment_personal_history[reference-name]',
							'label' => 'Name',
							'rules' => 'required'
							);
						$validation_rules[] = 
						array(
							'field' => 'recruitment_personal_history[reference-years-known]',
							'label' => 'Years Known',
							'rules' => 'required|numeric'
							);
					}
				}
				// else{	
				// 	$this->response->message[] = array(
				// 			'message' => "Please add references.",
				// 			'type' => 'warning'
				// 			);  
				// 	$this->_ajax_return();
				// }
			break;
		
			case 8:
			//Licensure tab
				if($post['licensure_count'] > 0){
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[licensure-title]',
						'label' => 'Title',
						'rules' => 'required'
						);
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[licensure-year-taken]',
						'label' => 'Year Taken',
						'rules' => 'required|numeric'
						);
					$partners_personal_table = "recruitment_personal_history";
					$partners_personal_key = array('licensure-title', 'licensure-number', 'licensure-remarks', 'licensure-month-taken', 'licensure-year-taken');
					if(array_key_exists('recruitment_personal_history', $post)){
						$partners_personal = $post['recruitment_personal_history'];
					}else{	
						$this->response->message[] = array(
								'message' => "Please add licensure.",
								'type' => 'warning'
								);  
						$this->_ajax_return();
					}
				}
			break;
			case 9:
			//Trainings and Seminars tab
				if($post['training_count'] > 0){
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[training-title]',
						'label' => 'Title',
						'rules' => 'required'
						);
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[training-venue]',
						'label' => 'Venue',
						'rules' => 'required'
						);
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[training-start-year]',
						'label' => 'Year Start',
						'rules' => 'required|numeric'
						);
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[training-end-year]',
						'label' => 'Year End',
						'rules' => 'required|numeric'
						);
					$partners_personal_table = "recruitment_personal_history";
					$partners_personal_key = array('training-category', 'training-title', 'training-venue', 'training-start-month', 'training-start-year', 'training-end-month', 'training-end-year');
					if(array_key_exists('recruitment_personal_history', $post)){
						$partners_personal = $post['recruitment_personal_history'];
					}else{	
						$this->response->message[] = array(
								'message' => "Please add trainings.",
								'type' => 'warning'
								);  
						$this->_ajax_return();
					}
				}
			break;
			case 10:
			//Skills tab
				if($post['skills_count'] > 0){
					// $validation_rules[] = 
					// array(
					// 	'field' => 'recruitment_personal_history[skill-type]',
					// 	'label' => 'Skill Type',
					// 	'rules' => 'required'
					// 	);
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[skill-name]',
						'label' => 'Skill Name',
						'rules' => 'required'
						);
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[skill-level]',
						'label' => 'Proficiency Level',
						'rules' => 'required'
						);
					$partners_personal_table = "recruitment_personal_history";
					$partners_personal_key = array('skill-name', 'skill-level', 'skill-remarks');
					if(array_key_exists('recruitment_personal_history', $post)){
						$partners_personal = $post['recruitment_personal_history'];
					}else{	
						$this->response->message[] = array(
								'message' => "Please add skills.",
								'type' => 'warning'
								);  
						$this->_ajax_return();
					}
				}
			break;
			case 11:
			//Affiliation tab
				if($post['affiliation_count'] > 0){
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[affiliation-name]',
						'label' => 'Affiliation Name',
						'rules' => 'required'
						);
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[affiliation-position]',
						'label' => 'Position',
						'rules' => 'required'
						);
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[affiliation-year-start]',
						'label' => 'Year Start',
						'rules' => 'required|numeric'
						);
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[affiliation-year-end]',
						'label' => 'Year End',
						'rules' => 'required|numeric'
						);
					$partners_personal_table = "recruitment_personal_history";
					$partners_personal_key = array('affiliation-name', 'affiliation-position', 'affiliation-month-start', 'affiliation-month-end', 'affiliation-year-start', 'affiliation-year-end');
					if(array_key_exists('recruitment_personal_history', $post)){
						$partners_personal = $post['recruitment_personal_history'];
					}else{	
						$this->response->message[] = array(
								'message' => "Please add affiliations.",
								'type' => 'warning'
								);  
						$this->_ajax_return();
					}
				}
			break;
			/*case 12:
			//Accountabilities tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[accountabilities-name]',
				'label' => 'Item Name',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[accountabilities-code]',
				'label' => 'Item Code',
				'rules' => 'required'
				);
			$partners_personal_table = "recruitment_personal_history";
			$partners_personal_key = array('accountabilities-name', 'accountabilities-code', 'accountabilities-quantity', 'accountabilities-date-issued', 'accountabilities-date-returned', 'accountabilities-remarks');
			if(array_key_exists('recruitment_personal_history', $post)){
				$partners_personal = $post['recruitment_personal_history'];
			}else{	
				$this->response->message[] = array(
						'message' => "Please add accountabilities.",
						'type' => 'warning'
						);  
				$this->_ajax_return();
			}
			break;
			case 13:
			//Attachment tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[attachment-name]',
				'label' => 'Filename',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[attachment-file]',
				'label' => 'Upload File',
				'rules' => 'required'
				);
			$partners_personal_table = "recruitment_personal_history";
			$partners_personal_key = array('attachment-name', 'attachment-file');
			if(array_key_exists('recruitment_personal_history', $post)){
				$partners_personal = $post['recruitment_personal_history'];
			}else{	
				$this->response->message[] = array(
						'message' => "Please add attachments.",
						'type' => 'warning'
						);  
				$this->_ajax_return();
			}
			break;
			*/

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


	function save(){

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
				'field' => 'recruitment[recruitment_date]',
				'label' => 'Date of Application',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal[position_sought]',
				'label' => 'Position Sought',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal[resume]',
				'label' => 'Resume',
				'rules' => 'required'
				);
			// $other_tables['recruitment'] = $post['recruitment'];
			$partners_personal_table = "recruitment_personal";
			// $other_tables['partners'] = $post['partners'];
			// $other_tables['partners']['effectivity_date'] = date('Y-m-d', strtotime($post['partners']['effectivity_date'])); 'how_hiring_heard',
			$partners_personal_key = array('position_sought','desired_salary', 'photo', 'salary_pay_mode', 'currently_employed', 'resume'
				,'phone', 'mobile', 'address_1', 'city_town', 'province', 'country', 'zip_code', 'emergency_name', 'emergency_relationship', 'emergency_phone', 'emergency_mobile', 'emergency_address', 'emergency_city', 'emergency_country', 'emergency_zip_code'
				,'gender', 'birth_place', 'religion', 'nationality', 'civil_status', 'height', 'weight', 'interests_hobbies', 'language', 'dialect', 'dependents_count', 'solo_parent', 'sss_number', 'tin_number', 'pagibig_number', 'philhealth_number'
				,'machine_operated', 'driver_license', 'driver_type_license', 'prc_license', 'prc_type_license', 'prc_license_no', 'prc_date_expiration', 'illness_question', 'illness_yes', 'trial_court', 'how_hiring_heard', 'work_start', 'referred_employee');
			
			$post['recruitment_personal']['desired_salary'] = $post['recruitment_personal']['desired_salary'].' - '.$post['recruitment_personal']['desired_salary_to']; 
			unset($post['recruitment_personal']['desired_salary_to']);
			$partners_personal = $post['recruitment_personal'];


			$partners_personal_history_table = "recruitment_personal_history";
			$partners_personal_history_key = array(
				'family-relationship', 'family-name', 'family-birthdate', 'family-age', 'family-occupation', 'family-employer', 
				'education-type', 'education-school', 'education-year-from', 'education-year-to', 'education-degree', 'education-status', 'education-honors_awards', 
				'employment-company', 'employment-position-title', 'employment-location', 'employment-duties', 'employment-month-hired', 'employment-month-end', 'employment-year-hired', 'employment-year-end', 'employment-last-salary', 'employment-reason-for-leaving',
				'reference-name', 'reference-occupation', 'reference-years-known', 'reference-phone', 'reference-mobile', 'reference-address', 'reference-city', 'reference-country', 'reference-zipcode', 'reference-organization',
				'licensure-title', 'licensure-number', 'licensure-remarks', 'licensure-month-taken', 'licensure-year-taken',
				'training-category', 'training-title', 'training-venue', 'training-start-month', 'training-start-year', 'training-end-month', 'training-end-year',
				'skill-name', 'skill-level', 'skill-remarks',
				'affiliation-name', 'affiliation-position', 'affiliation-month-start', 'affiliation-month-end', 'affiliation-year-start', 'affiliation-year-end',
				'friend-relative-employee', 'friend-relative-position', 'friend-relative-dept', 'friend-relative-relation'
				);
			if(array_key_exists('recruitment_personal_history', $post)){
				$partners_personal_history = $post['recruitment_personal_history'];
			}
			// break;
			case 2:
			//Contacts Tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment[email]',
				'label' => 'Email Address',
				'rules' => 'required|valid_email'
				);
			// $partners_personal_table = "recruitment_personal";
			// $partners_personal_key = array('phone', 'mobile', 'address_1', 'city_town', 'country', 'zip_code', 'emergency_name', 'emergency_relationship', 'emergency_phone', 'emergency_mobile', 'emergency_address', 'emergency_city', 'emergency_country', 'emergency_zip_code');
			// $partners_personal = $post['recruitment_personal'];

			$partner_phone = $_POST['recruitment_personal']['phone'];
			$partner_mobile = $_POST['recruitment_personal']['mobile'];
			$emergency_phone = $_POST['recruitment_personal']['emergency_phone'];
			$emergency_mobile = $_POST['recruitment_personal']['emergency_mobile'];

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
			// if(!empty($partners_personal['emergency_mobile'])){
			// 	$mobile = $this->check_mobile($partners_personal['emergency_mobile']);
			// 	if(!$mobile){
			// 		$this->response->invalid=true;
			// 		$this->response->invalid_message='Invalid contact mobile number';
			// 		$this->response->message[] = array(
			// 	    	'message' => 'Invalid contact mobile number',
			// 	    	'type' => 'warning'
			// 		);
	  //       		$this->_ajax_return();
	  //       	}else{
	  //       		$partners_personal['emergency_mobile'] = $mobile;
	  //       	}
			// }

			// if(!empty($partners_personal['emergency_phone'])){
			// 	$mobile = $this->check_phone($partners_personal['emergency_phone']);
			// 	if(!$mobile){
			// 		$this->response->invalid=true;
			// 		$this->response->invalid_message='Invalid contact phone number';
			// 		$this->response->message[] = array(
			// 	    	'message' => 'Invalid contact phone number',
			// 	    	'type' => 'warning'
			// 		);
	  //       		$this->_ajax_return();
	  //       	}else{
	  //       		$partners_personal['emergency_phone'] = $mobile;
	  //       	}
			// }
			// break;
			case 3:
			//Personal Tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal[gender]',
				'label' => 'Gender',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment[birth_date]',
				'label' => 'Birthday',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal[dependents_count]',
				'label' => 'No. of Dependents',
				'rules' => 'numeric'
				);
			// $partners_personal_table = "recruitment_personal";
			// // $other_tables['users_profile'] = $post['users_profile'];
			// // $other_tables['users_profile']['birth_date'] = date('Y-m-d', strtotime($post['users_profile']['birth_date']));
			// $partners_personal_key = array('gender', 'birth_place', 'religion', 'nationality', 'civil_status', 'height', 'weight', 'interests_hobbies', 'language', 'dialect', 'dependents_count', 'solo_parent');
			// $partners_personal = $post['recruitment_personal'];
			break;
			case 5:
			//Education Tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[education-school]',
				'label' => 'School',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[education-year-from]',
				'label' => 'Start Year',
				'rules' => 'required|numeric'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[education-year-to]',
				'label' => 'End Year',
				'rules' => 'required|numeric'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[education-status]',
				'label' => 'School',
				'rules' => 'required'
				);
			$partners_personal_table = "recruitment_personal_history";
			$partners_personal_key = array('education-type', 'education-school', 'education-year-from', 'education-year-to', 'education-degree', 'education-status');
			if(array_key_exists('recruitment_personal_history', $post)){
				$partners_personal = $post['recruitment_personal_history'];
			}else{	
				$this->response->message[] = array(
						'message' => "Please add educational attainments.",
						'type' => 'warning'
						); 
				$this->_ajax_return(); 
			}
			break;
			/*
			case 6:
			//Employment History Tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[employment-company]',
				'label' => 'Company Name',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[employment-position-title]',
				'label' => 'Position Title',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[employment-year-hired]',
				'label' => 'Year Hired',
				'rules' => 'required|numeric'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[employment-year-end]',
				'label' => 'Year End',
				'rules' => 'required|numeric'
				);
			$partners_personal_table = "recruitment_personal_history";
			$partners_personal_key = array('employment-company', 'employment-position-title', 'employment-location', 'employment-duties', 'employment-month-hired', 'employment-month-end', 'employment-year-hired', 'employment-year-end');
			if(array_key_exists('recruitment_personal_history', $post)){
				$partners_personal = $post['recruitment_personal_history'];
			}else{	
				$this->response->message[] = array(
						'message' => "Please add employers.",
						'type' => 'warning'
						); 
				$this->_ajax_return(); 
			}
			break;
			*/
			case 7:
			//Character Reference tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[reference-name]',
				'label' => 'Name',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[reference-years-known]',
				'label' => 'Years Known',
				'rules' => 'required|numeric'
				);
			$partners_personal_table = "recruitment_personal_history";
			$partners_personal_key = array('reference-name', 'reference-occupation', 'reference-years-known', 'reference-phone', 'reference-mobile', 'reference-address', 'reference-city', 'reference-country', 'reference-zipcode');
			if(array_key_exists('recruitment_personal_history', $post)){
				$partners_personal = $post['recruitment_personal_history'];
			}else{	
				$this->response->message[] = array(
						'message' => "Please add references.",
						'type' => 'warning'
						);  
				$this->_ajax_return();
			}
			break;
			case 11:
			//Affiliation tab
				if($post['affiliation_count'] > 0){
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[affiliation-name]',
						'label' => 'Affiliation Name',
						'rules' => 'required'
						);
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[affiliation-position]',
						'label' => 'Position',
						'rules' => 'required'
						);
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[affiliation-year-start]',
						'label' => 'Year Start',
						'rules' => 'required|numeric'
						);
					$validation_rules[] = 
					array(
						'field' => 'recruitment_personal_history[affiliation-year-end]',
						'label' => 'Year End',
						'rules' => 'required|numeric'
						);
					$partners_personal_table = "recruitment_personal_history";
					$partners_personal_key = array('affiliation-name', 'affiliation-position', 'affiliation-month-start', 'affiliation-month-end', 'affiliation-year-start', 'affiliation-year-end');
					if(array_key_exists('recruitment_personal_history', $post)){
						$partners_personal = $post['recruitment_personal_history'];
					}else{	
						$this->response->message[] = array(
								'message' => "Please add affiliations.",
								'type' => 'warning'
								);  
						$this->_ajax_return();
					}
				}
			break;
			case 12:
			//friend relative tab	
/*				if($post['friend_relative_count'] > 0){
					$partners_personal_table = "recruitment_personal_history";
					$partners_personal_history_key = array('friend-relative-employee', 'friend-relative-position', 'friend-relative-dept', 'friend-relative-relation');
					if(array_key_exists('recruitment_personal_history', $post)){
						$partners_personal_history = $post['recruitment_personal_history'];
					}
				}
			break;	*/
			case 13:
			//other question tab
/*				if($post['friend_relative_count'] > 0){
					$partners_personal_table = "recruitment_personal";
					$partners_personal_key = array('machine_operated', 'driver_license', 'driver_type_license', 'prc_license', 'prc_type_license', 'prc_license_no', 'prc_date_expiration', 'illness_question', 'illness_yes', 'trial_court', 'how_hiring_heard', 'work_start', 'referred_employee');
					$partners_personal = $post['recruitment_personal'];
				}*/
			break;						
			/*
			case 8:
			//Licensure tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[licensure-title]',
				'label' => 'Title',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[licensure-year-taken]',
				'label' => 'Year Taken',
				'rules' => 'required|numeric'
				);
			$partners_personal_table = "recruitment_personal_history";
			$partners_personal_key = array('licensure-title', 'licensure-number', 'licensure-remarks', 'licensure-month-taken', 'licensure-year-taken');
			if(array_key_exists('recruitment_personal_history', $post)){
				$partners_personal = $post['recruitment_personal_history'];
			}else{	
				$this->response->message[] = array(
						'message' => "Please add licensure.",
						'type' => 'warning'
						);  
				$this->_ajax_return();
			}
			break;
			case 9:
			//Trainings and Seminars tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[training-title]',
				'label' => 'Title',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[training-venue]',
				'label' => 'Venue',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[training-start-year]',
				'label' => 'Year Start',
				'rules' => 'required|numeric'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[training-end-year]',
				'label' => 'Year End',
				'rules' => 'required|numeric'
				);
			$partners_personal_table = "recruitment_personal_history";
			$partners_personal_key = array('training-category', 'training-title', 'training-venue', 'training-start-month', 'training-start-year', 'training-end-month', 'training-end-year');
			if(array_key_exists('recruitment_personal_history', $post)){
				$partners_personal = $post['recruitment_personal_history'];
			}else{	
				$this->response->message[] = array(
						'message' => "Please add trainings.",
						'type' => 'warning'
						);  
				$this->_ajax_return();
			}
			break;
			case 10:
			//Skills tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[skill-type]',
				'label' => 'Skill Type',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[skill-name]',
				'label' => 'Skill Name',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[skill-level]',
				'label' => 'Proficiency Level',
				'rules' => 'required'
				);
			$partners_personal_table = "recruitment_personal_history";
			$partners_personal_key = array('skill-type', 'skill-name', 'skill-level', 'skill-remarks');
			if(array_key_exists('recruitment_personal_history', $post)){
				$partners_personal = $post['recruitment_personal_history'];
			}else{	
				$this->response->message[] = array(
						'message' => "Please add skills.",
						'type' => 'warning'
						);  
				$this->_ajax_return();
			}
			break;
			case 12:
			//Accountabilities tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[accountabilities-name]',
				'label' => 'Item Name',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[accountabilities-code]',
				'label' => 'Item Code',
				'rules' => 'required'
				);
			$partners_personal_table = "recruitment_personal_history";
			$partners_personal_key = array('accountabilities-name', 'accountabilities-code', 'accountabilities-quantity', 'accountabilities-date-issued', 'accountabilities-date-returned', 'accountabilities-remarks');
			if(array_key_exists('recruitment_personal_history', $post)){
				$partners_personal = $post['recruitment_personal_history'];
			}else{	
				$this->response->message[] = array(
						'message' => "Please add accountabilities.",
						'type' => 'warning'
						);  
				$this->_ajax_return();
			}
			break;
			case 13:
			//Attachment tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[attachment-name]',
				'label' => 'Filename',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[attachment-file]',
				'label' => 'Upload File',
				'rules' => 'required'
				);
			$partners_personal_table = "recruitment_personal_history";
			$partners_personal_key = array('attachment-name', 'attachment-file');
			if(array_key_exists('recruitment_personal_history', $post)){
				$partners_personal = $post['recruitment_personal_history'];
			}else{	
				$this->response->message[] = array(
						'message' => "Please add attachments.",
						'type' => 'warning'
						);  
				$this->_ajax_return();
			}
			break;
			case 4:
			//Family tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[family-name]',
				'label' => 'Name',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[family-birthdate]',
				'label' => 'Birthday',
				'rules' => 'required'
				);
			$partners_personal_table = "recruitment_personal_history";
			$partners_personal_key = array('family-relationship', 'family-name', 'family-birthdate');
			if(array_key_exists('recruitment_personal_history', $post)){
				$partners_personal = $post['recruitment_personal_history'];
			}else{	
				$this->response->message[] = array(
						'message' => "Please add Family member.",
						'type' => 'warning'
						);  
				$this->_ajax_return();
			}
			break;
			*/
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
        /***** END Form Validation (hard coded) *****/

        //SAVING START   
		$transactions = true;
		// $this->recruit_id = 0;
		if( $transactions )
		{
			$this->db->trans_begin();
		}
		// echo "from here<pre>";
		//start saving with main table
		if(array_key_exists($this->mod->table, $post)){
			$main_record = $post[$this->mod->table];
			unset($main_record['request_id']);
			$main_record['status_id'] = 11;
			$record = $this->db->get_where( $this->mod->table, array( $this->mod->primary_key => $this->record_id ) );
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
					if(array_key_exists('recruitment_date', $main_record)){
						$main_record['recruitment_date'] = date('Y-m-d', strtotime($main_record['recruitment_date']));
					}
					if(array_key_exists('birth_date', $main_record)){
						$main_record['birth_date'] = date('Y-m-d', strtotime($main_record['birth_date']));
					}

					$main_record['source_id'] = 2;
					// echo "<pre>";print_r($main_record);
					$this->db->insert($this->mod->table, $main_record);
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
					if(array_key_exists('recruitment_date', $main_record)){
						$main_record['recruitment_date'] = date('Y-m-d', strtotime($main_record['recruitment_date']));
					}
					if(array_key_exists('birth_date', $main_record)){
						$main_record['birth_date'] = date('Y-m-d', strtotime($main_record['birth_date']));
					}

					$this->db->update( $this->mod->table, $main_record, array( $this->mod->primary_key => $this->record_id ) );
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
				if(isset($partners_personal[$key]) && !is_array($partners_personal[$key])){
					$record = $this->mod->get_recruitment_personal($this->record_id , $partners_personal_table, $key, $current_sequence);
					if(in_array($post['fgs_number'], $accountabilities_attachments) && $current_sequence == 0) //insert to personal history
					{
						$sequence = count($record) + 1;
						$record = array();
					}
					$data_personal = array('key_value' => $partners_personal[$key]);
					switch( true )
					{
						case count($record) == 0:
							$data_personal = $this->mod->insert_recruitment_personal($this->record_id, $key, $partners_personal[$key], $sequence, $this->recruit_id);
							$this->db->insert($partners_personal_table, $data_personal);
							// $this->record_id = $this->db->insert_id();
							break;
						case count($record) == 1:
							$recruit_id = $this->recruit_id;
							$where_array = in_array($post['fgs_number'], $accountabilities_attachments) ? array( 'recruit_id' => $recruit_id, 'key' => $key, 'sequence' => $current_sequence ) : array( 'recruit_id' => $recruit_id, 'key' => $key );
							$this->db->update( $partners_personal_table, $data_personal, $where_array );
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
				}else{
					$sequence = 1;
					$recruit_id = $this->recruit_id;
					$this->db->delete($partners_personal_table, array( 'recruit_id' => $recruit_id, 'key' => $key ));
					if (isset($partners_personal[$key])){
						foreach( $partners_personal[$key] as $table => $data_personal )
						{	
							$data_personal = $this->mod->insert_recruitment_personal($this->record_id, $key, $data_personal, $sequence, $this->recruit_id);
							$this->db->insert($partners_personal_table, $data_personal);

							if( $this->db->_error_message() != "" ){
								$this->response->message[] = array(
									'message' => $this->db->_error_message(),
									'type' => 'error'
								);
								$error = true;
							}	
							$sequence++;
						}
					}

				}
			}
		}


		//personal history profile
		if(count($partners_personal_history_key) > 0){
			// $this->load->model('my201_model', 'profile_mod');
			$sequence = 1;
			$post['fgs_number'];
			$accountabilities_attachments = array(12,13);
			$current_sequence = array_key_exists('sequence', $post) ? $post['sequence'] : 0;
			foreach( $partners_personal_history_key as $table => $key )
			{
				if(array_key_exists($key, $partners_personal_history)){
					if(!is_array($partners_personal_history[$key])){
						$record = $this->mod->get_recruitment_personal($this->record_id , $partners_personal_history_table, $key, $current_sequence);
						if(in_array($post['fgs_number'], $accountabilities_attachments) && $current_sequence == 0) //insert to personal history
						{
							$sequence = count($record) + 1;
							$record = array();
						}
						$data_personal = array('key_value' => $partners_personal_history[$key]);
						switch( true )
						{
							case count($record) == 0:
								$data_personal = $this->mod->insert_recruitment_personal($this->record_id, $key, $partners_personal_history[$key], $sequence, $this->recruit_id);
								$this->db->insert($partners_personal_history_table, $data_personal);
								// $this->record_id = $this->db->insert_id();
								break;
							case count($record) == 1:
								$recruit_id = $this->recruit_id;
								$where_array = in_array($post['fgs_number'], $accountabilities_attachments) ? array( 'recruit_id' => $recruit_id, 'key' => $key, 'sequence' => $current_sequence ) : array( 'recruit_id' => $recruit_id, 'key' => $key );
								$this->db->update( $partners_personal_history_table, $data_personal, $where_array );
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
					}else{
						$sequence = 1;
						$recruit_id = $this->recruit_id;
						$this->db->delete($partners_personal_history_table, array( 'recruit_id' => $recruit_id, 'key' => $key ));
						foreach( $partners_personal_history[$key] as $table => $data_personal )
						{	
							$data_personal = $this->mod->insert_recruitment_personal($this->record_id, $key, $data_personal, $sequence, $this->recruit_id);
							$this->db->insert($partners_personal_history_table, $data_personal);

							if( $this->db->_error_message() != "" ){
								$this->response->message[] = array(
									'message' => $this->db->_error_message(),
									'type' => 'error'
								);
								$error = true;
							}	
							$sequence++;
						}

					}
				}
			}
		}

		// $retrieve_record = $this->db->get_where( $this->mod->table, array( $this->mod->primary_key => $this->record_id ) );
		/*if( $main_record['request_id'] )
		{
			//check if exists in process
			$this->db->limit(1);
			$check = $this->db->get_where('recruitment_process', array('request_id' => $main_record['request_id'], 'recruit_id' => $this->recruit_id ));
			if( $check->num_rows() == 0 )
			{
				$insert = array(
					'request_id' => $main_record['request_id'], 
					'recruit_id' => $this->recruit_id, 
					'status_id' => 1,
					'created_by' => $this->user->user_id
				);
				$this->db->insert('recruitment_process', $insert);
				
				if( $this->db->_error_message() != "" ){
					$this->response->message[] = array(
						'message' => $this->db->_error_message(),
						'type' => 'error'
					);
					$error = true;
				}	
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

	function add_form() {
		$this->_ajax_only();

		$data['employee'] = $this->appform->get_employee();
		$data['count'] = $this->input->post('count');
		$data['counting'] = $this->input->post('counting');
		$data['category'] = $this->input->post('category');

		$this->response->count = ++$data['count'];
		$this->response->counting = ++$data['counting'];

		$this->load->helper('file');
		$this->response->add_form = $this->load->view('edit/forms/'.$this->input->post('add_form'), $data, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();
	}

	function check_duplicate() {
		$this->_ajax_only();

		// echo "<pre>";
		// print_r($this->input->post());
		$data['lastname'] = $this->input->post('lastname');
		$data['firstname'] = $this->input->post('firstname');
		$data['birth_date'] = strtotime($this->input->post('bday')) ? date( 'Y-m-d', strtotime($this->input->post('bday')) ) : '';
		$data['deleted'] = 0;

		$record = $this->db->get_where( 'recruitment', $data);

		$this->response->duplicate_count = $record->num_rows();
		// echo "<pre>";
		// print_r($this->db->last_query());
		// print_r($record->num_rows());

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();
	}

}