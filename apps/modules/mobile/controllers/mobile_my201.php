<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mobile_My201 extends MY_PrivateController{

	public function __construct(){

		$this->load->model('mobile_my201_model', 'mod');
		parent::__construct();
        $this->lang->load( 'my201' );

	}

	public function get_my201(){
		
		if( !$this->permission['list'] ){

			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
			
		}

		$profile_header_details = $this->mod->get_profile_header_details($this->user->user_id);
		$middle_initial = empty($profile_header_details['middlename']) ? " " : " ".ucfirst(substr($profile_header_details['middlename'],0,1)).". ";
		$data['profile_name'] = $profile_header_details['firstname'].$middle_initial.$profile_header_details['lastname'];

		// $department = empty($profile_header_details['department']) ? "" : " on ".ucwords(strtolower($profile_header_details['department']));
		// $data['profile_position'] = ucwords(strtolower($profile_header_details['position']));
		$department = empty($profile_header_details['department']) ? "" : " on ".$profile_header_details['department'];
		$data['profile_position'] = $profile_header_details['position'];
		$data['profile_company'] = $profile_header_details['company'];
		$data['profile_email'] = $profile_header_details['email'];
		$data['profile_birthdate'] = date("F d, Y", strtotime($profile_header_details['birth_date']));
			$birthday = new DateTime($profile_header_details['birth_date']);
		$data['profile_age'] = $birthday->diff(new DateTime)->y;
		$data['profile_photo'] = $profile_header_details['photo'] == "" ? "assets/img/avatar.png" : $profile_header_details['photo'];
		// $data['profile_photo'] = file_exists($profile_photo) ? $profile_header_details['photo'] : "assets/img/avatar.png";
		/***** EMPLOYMENT TAB *****/
		//Company Information
		$data['location'] = $profile_header_details['location'] == "" ? "n/a" : $profile_header_details['location'];
		$data['position'] = $profile_header_details['position'] == "" ? "n/a" : $profile_header_details['position'];
		$data['permission'] = $profile_header_details['role'] == "" ? "n/a" : $profile_header_details['role'];
		$data['id_number'] = $profile_header_details['id_number'] == "" ? "n/a" : $profile_header_details['id_number'];
		$data['biometric'] = $profile_header_details['biometric'] == "" ? "n/a" : $profile_header_details['biometric'];
		$data['shift'] = $profile_header_details['shift'] == "" ? "n/a" : $profile_header_details['shift'];
		//Employment Information
		$data['status'] = $profile_header_details['employment_status'] == "" ? "n/a" : $profile_header_details['employment_status'];
		$data['type'] = $profile_header_details['employment_type'] == "" ? "n/a" : $profile_header_details['employment_type'];
		$data['date_hired'] = $profile_header_details['effectivity_date'] == "" ? "n/a" : date("F d, Y", strtotime($profile_header_details['effectivity_date']));
		$probationary_date = $this->mod->get_partners_personal($this->user->user_id, 'probationary_date');
			$data['probationary_date'] = count($probationary_date) == 0 ? "n/a" : $probationary_date[0]['key_value'] == "" ? "n/a" : date("F d, Y", strtotime($probationary_date[0]['key_value']));
		$original_date_hired = $this->mod->get_partners_personal($this->user->user_id, 'original_date_hired');
			$data['original_date_hired'] = count($original_date_hired) == 0 ? "n/a" : $original_date_hired[0]['key_value'] == "" ? "n/a" : date("F d, Y", strtotime($original_date_hired[0]['key_value']));
		$last_probationary = $this->mod->get_partners_personal($this->user->user_id, 'last_probationary');
			$data['last_probationary'] = count($last_probationary) == 0 ? "n/a" : $last_probationary[0]['key_value'] == "" ? "n/a" : date("F d, Y", strtotime($last_probationary[0]['key_value']));
		$last_salary_adjustment = $this->mod->get_partners_personal($this->user->user_id, 'last_salary_adjustment');
			$data['last_salary_adjustment'] = count($last_salary_adjustment) == 0 ? "n/a" : $last_salary_adjustment[0]['key_value'] == "" ? "n/a" : date("F d, Y", strtotime($last_salary_adjustment[0]['key_value']));
		//Work Assignment
		$reports_to = $profile_header_details['immediate'] == "" ? "n/a" : $this->mod->get_user_details($profile_header_details['immediate']);
		if($reports_to == "n/a"){
			$data['reports_to'] = $reports_to;
		}
		else{
			$reports_to_MI = empty($reports_to['middlename']) ? " " : " ".ucfirst(substr($reports_to['middlename'],0,1)).". ";
			$data['reports_to'] = $reports_to['firstname'].$reports_to_MI.$reports_to['lastname'];
		}
		$organization = $this->mod->get_partners_personal($this->user->user_id, 'organization');
			$data['organization'] = count($organization) == 0 ? "n/a" : $organization[0]['key_value'] == "" ? "n/a" : $organization[0]['key_value'];
		$data['division'] = $profile_header_details['division'] == "" ? "n/a" : $profile_header_details['division'];
		$data['department'] = $profile_header_details['department'] == "" ? "n/a" : $profile_header_details['department'];
		$data['group'] = $profile_header_details['group'] == "" ? "n/a" : $profile_header_details['group'];

		/***** CONTACTS TAB *****/
		//Personal Contact
		$address_1 = $this->mod->get_partners_personal($this->user->user_id, 'address_1');
			$address_1 = count($address_1) == 0 ? " " : $address_1[0]['key_value'] == "" ? "" : $address_1[0]['key_value'];
		$address_2 = $this->mod->get_partners_personal($this->user->user_id, 'address_2');
			$address_2 = count($address_2) == 0 ? " " : $address_2[0]['key_value'] == "" ? "" : $address_2[0]['key_value'];
		$city_town = $this->mod->get_partners_personal($this->user->user_id, 'city_town');
			$city_town = count($city_town) == 0 ? " " : $city_town[0]['key_value'] == "" ? "" : $city_town[0]['key_value'];
		$data['complete_address'] = $address_1." ".$address_2;		
		$zip_code = $this->mod->get_partners_personal($this->user->user_id, 'zip_code');
			$data['zip_code'] = count($zip_code) == 0 ? " " : $zip_code[0]['key_value'] == "" ? "" : $zip_code[0]['key_value'];
		//Emergency Contact
		$emergency_name = $this->mod->get_partners_personal($this->user->user_id, 'emergency_name');
			$data['emergency_name'] = count($emergency_name) == 0 ? " " : $emergency_name[0]['key_value'] == "" ? "" : $emergency_name[0]['key_value'];
		$emergency_relationship = $this->mod->get_partners_personal($this->user->user_id, 'emergency_relationship');
			$data['emergency_relationship'] = count($emergency_relationship) == 0 ? " " : $emergency_relationship[0]['key_value'] == "" ? "" : $emergency_relationship[0]['key_value'];
		$emergency_phone = $this->mod->get_partners_personal($this->user->user_id, 'emergency_phone');
			$data['emergency_phone'] = count($emergency_phone) == 0 ? "n/a" : $emergency_phone[0]['key_value'] == "" ? "n/a" : $emergency_phone[0]['key_value'];
		$emergency_mobile = $this->mod->get_partners_personal($this->user->user_id, 'emergency_mobile');
			$data['emergency_mobile'] = count($emergency_mobile) == 0 ? "n/a" : $emergency_mobile[0]['key_value'] == "" ? "n/a" : $emergency_mobile[0]['key_value'];
		$emergency_address = $this->mod->get_partners_personal($this->user->user_id, 'emergency_address');
			$data['emergency_address'] = count($emergency_address) == 0 ? " " : $emergency_address[0]['key_value'] == "" ? "" : $emergency_address[0]['key_value'];
		$emergency_city = $this->mod->get_partners_personal($this->user->user_id, 'emergency_city');
			$data['emergency_city'] = count($emergency_city) == 0 ? " " : $emergency_city[0]['key_value'] == "" ? "" : $emergency_city[0]['key_value'];
		$emergency_country = $this->mod->get_partners_personal($this->user->user_id, 'emergency_country');
			$data['emergency_country'] = count($emergency_country) == 0 ? " " : $emergency_country[0]['key_value'] == "" ? "" : $emergency_country[0]['key_value'];
		$emergency_zip_code = $this->mod->get_partners_personal($this->user->user_id, 'emergency_zip_code');
			$data['emergency_zip_code'] = count($emergency_zip_code) == 0 ? " " : $emergency_zip_code[0]['key_value'] == "" ? "" : $emergency_zip_code[0]['key_value'];

		$tin_number = $this->mod->get_partners_personal($this->user->user_id, 'tin_number');
		$data['record']['tin_number'] = count($tin_number) == 0 ? " " : $tin_number[0]['key_value'] == "" ? "" : $tin_number[0]['key_value'];
		$sss_number = $this->mod->get_partners_personal($this->user->user_id, 'sss_number');
		$data['record']['sss_number'] = count($sss_number) == 0 ? " " : $sss_number[0]['key_value'] == "" ? "" : $sss_number[0]['key_value'];			
		$pagibig_number = $this->mod->get_partners_personal($this->user->user_id, 'pagibig_number');
		$data['record']['pagibig_number'] = count($pagibig_number) == 0 ? " " : $pagibig_number[0]['key_value'] == "" ? "" : $pagibig_number[0]['key_value'];
		$philhealth_number = $this->mod->get_partners_personal($this->user->user_id, 'philhealth_number');
		$data['record']['philhealth_number'] = count($philhealth_number) == 0 ? " " : $philhealth_number[0]['key_value'] == "" ? "" : $philhealth_number[0]['key_value'];
		$bank_number = $this->mod->get_partners_personal($this->user->user_id, 'bank_account_number');
		$data['record']['bank_number'] = count($bank_number) == 0 ? " " : $bank_number[0]['key_value'] == "" ? "" : $bank_number[0]['key_value'];
		$bank_account_name = $this->mod->get_partners_personal($this->user->user_id, 'bank_account_name');
		$data['record']['bank_account_name'] = count($bank_account_name) == 0 ? " " : $bank_account_name[0]['key_value'] == "" ? "" : $bank_account_name[0]['key_value'];		
		$health_care = $this->mod->get_partners_personal($this->user->user_id, 'health_care');
		$data['record']['health_care'] = count($health_care) == 0 ? " " : $health_care[0]['key_value'] == "" ? "" : $health_care[0]['key_value'];
		$job_class = $this->mod->get_partners_personal($this->user->user_id, 'job_class');
		$data['record']['job_class'] = count($job_class) == 0 ? " " : $job_class[0]['key_value'] == "" ? "" : $job_class[0]['key_value'];
		$employee_grade = $this->mod->get_partners_personal($this->user->user_id, 'employee_grade');
		$data['record']['employee_grade'] = count($employee_grade) == 0 ? " " : $employee_grade[0]['key_value'] == "" ? "" : $employee_grade[0]['key_value'];
		
		$section = $this->mod->get_partners_personal($this->user->user_id, 'section');
		$data['record']['section'] = count($section) == 0 ? " " : $section[0]['key_value'] == "" ? "" : $section[0]['key_value'];

		/***** PERSONAL TAB *****/
		//Personal
		$gender = $this->mod->get_partners_personal($this->user->user_id, 'gender');
			$data['gender'] = count($gender) == 0 ? " " : $gender[0]['key_value'] == "" ? "" : $gender[0]['key_value'];
		$birth_place = $this->mod->get_partners_personal($this->user->user_id, 'birth_place');
			$data['birth_place'] = count($birth_place) == 0 ? " " : $gender[0]['key_value'] == "" ? "" : $birth_place[0]['key_value'];
		$religion = $this->mod->get_partners_personal($this->user->user_id, 'religion');
			$data['religion'] = count($religion) == 0 ? " " : $religion[0]['key_value'] == "" ? "" : $religion[0]['key_value'];
		$nationality = $this->mod->get_partners_personal($this->user->user_id, 'nationality');
			$data['nationality'] = count($nationality) == 0 ? " " : $nationality[0]['key_value'] == "" ? "" : $nationality[0]['key_value'];
		//Other Information
		$height = $this->mod->get_partners_personal($this->user->user_id, 'height');
			$data['height'] = count($height) == 0 ? " " : $height[0]['key_value'] == "" ? "" : $height[0]['key_value'];
		$weight = $this->mod->get_partners_personal($this->user->user_id, 'weight');
			$data['weight'] = count($weight) == 0 ? " " : $weight[0]['key_value'] == "" ? "" : $weight[0]['key_value'];
		$interests_hobbies = $this->mod->get_partners_personal($this->user->user_id, 'interests_hobbies');
			$data['interests_hobbies'] = count($interests_hobbies) == 0 ? " " : $interests_hobbies[0]['key_value'] == "" ? "" : $interests_hobbies[0]['key_value'];
		$language = $this->mod->get_partners_personal($this->user->user_id, 'language');
			$data['language'] = count($language) == 0 ? " " : $language[0]['key_value'] == "" ? "" : $language[0]['key_value'];
		$dialect = $this->mod->get_partners_personal($this->user->user_id, 'dialect');
			$data['dialect'] = count($dialect) == 0 ? " " : $dialect[0]['key_value'] == "" ? "" : $dialect[0]['key_value'];
		$dependents_count = $this->mod->get_partners_personal($this->user->user_id, 'dependents_count');
			$data['dependents_count'] = count($dependents_count) == 0 ? " " : $dependents_count[0]['key_value'] == "" ? "" : $dependents_count[0]['key_value'];

		/***** Header Details *****/
		$data['profile_live_in'] = $city_town;
		$countries = $this->mod->get_partners_personal($this->user->user_id, 'country');
			$data['profile_country'] = count($countries) == 0 ? " " : $countries[0]['key_value'] == "" ? "" : $countries[0]['key_value'];
		$telephones = array();
		$phone_numbers = $this->mod->get_partners_personal($this->user->user_id, 'phone');
			foreach($phone_numbers as $phone){
				$telephones[] = $phone['key_value'];
			}
			$data['profile_telephones'] = $telephones;
		$fax = array();
		$fax_numbers = $this->mod->get_partners_personal($this->user->user_id, 'fax');
			foreach($fax_numbers as $fax_no){
				$fax[] = $fax_no['key_value'];
			}
			$data['profile_fax'] = $fax;
		$mobiles = array();
		$mobile_numbers = $this->mod->get_partners_personal($this->user->user_id, 'mobile');
			foreach($mobile_numbers as $mobile){
				$mobiles[] = $mobile['key_value'];
			}
			$data['profile_mobiles'] = $mobiles;
		$civil_status = $this->mod->get_partners_personal($this->user->user_id, 'civil_status');
			$data['profile_civil_status'] = count($civil_status) == 0 ? " " : $civil_status[0]['key_value'] == "" ? "" : $civil_status[0]['key_value'];
		$spouse = $this->mod->get_partners_personal($this->user->user_id, 'spouse');
			$data['profile_spouse'] = count($spouse) == 0 ? " " : $spouse[0]['key_value'] == "" ? "" : $spouse[0]['key_value'];

		$solo_parent = $this->mod->get_partners_personal($this->user->user_id, 'solo_parent');
		$data['personal_solo_parent'] = count($solo_parent) == 0 ? " " : $solo_parent[0]['key_value'] == 0 ? "No" : "Yes";
		/***** HISTORY TAB *****/
		//Education
		$education_tab = array();
		$educational_tab = array();
		$education_tab = $this->mod->get_partners_personal_history($this->user->user_id, 'education');
			foreach($education_tab as $educ){
				$educational_tab[$educ['sequence']][$educ['key']] = $educ['key_value'];
			}
			$data['education_tab'] = $educational_tab;
		//Employment
		$employment_tab = array();
		$employments_tab = array();
		$employment_tab = $this->mod->get_partners_personal_history($this->user->user_id, 'employment');
			foreach($employment_tab as $emp){
				$employments_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['employment_tab'] = $employments_tab;
		//Character Reference
		$reference_tab = array();
		$references_tab = array();
		$reference_tab = $this->mod->get_partners_personal_history($this->user->user_id, 'reference');
			foreach($reference_tab as $emp){
				$references_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['reference_tab'] = $references_tab;
		//Licensure
		$licensure_tab = array();
		$licensures_tab = array();
		$details_data_id = array();
		$licensure_tab = $this->mod->get_partners_personal_history($this->user->user_id, 'licensure');
			foreach($licensure_tab as $emp){
				$licensures_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
				$details_data_id[$emp['sequence']][$emp['key']] = $emp['personal_id'];
			}
			$data['licensure_tab'] = $licensures_tab;
			$data['details_data_id'] = $details_data_id;
		//Trainings and Seminars
		$training_tab = array();
		$trainings_tab = array();
		$training_tab = $this->mod->get_partners_personal_history($this->user->user_id, 'training');
			foreach($training_tab as $emp){
				$trainings_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['training_tab'] = $trainings_tab;
		//Skills
		$skill_tab = array();
		$skills_tab = array();
		$skill_tab = $this->mod->get_partners_personal_history($this->user->user_id, 'skill');
			foreach($skill_tab as $emp){
				$skills_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['skill_tab'] = $skills_tab;
		//Affiliation
		$affiliation_tab = array();
		$affiliations_tab = array();
		$affiliation_tab = $this->mod->get_partners_personal_history($this->user->user_id, 'affiliation');
			foreach($affiliation_tab as $emp){
				$affiliations_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['affiliation_tab'] = $affiliations_tab;
		//Accountabilities
		$accountabilities_tab = array();
		$accountable_tab = array();
		$accountabilities_tab = $this->mod->get_partners_personal_history($this->user->user_id, 'accountabilities');
			foreach($accountabilities_tab as $emp){
				$accountable_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['accountabilities_tab'] = $accountable_tab;
		//Attachments
		$attachment_tab = array();
		$attachments_tab = array();
		$attachment_tab = $this->mod->get_partners_personal_history($this->user->user_id, 'attachment');
			foreach($attachment_tab as $emp){
				$attachments_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['attachment_tab'] = $attachments_tab;
		//Family
		$family_tab = array();
		$families_tab = array();
		$family_tab = $this->mod->get_partners_personal_history($this->user->user_id, 'family');
		foreach($family_tab as $emp){
			if($emp['key'] == 'family-dependent'){
				$families_tab[$emp['sequence']][$emp['key']] = $emp['key_value'] == 0 ? "No" : "Yes";
			}else{
				$families_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
		}
		$data['family_tab'] = $families_tab;

		$old_id_number = $this->mod->get_partners_personal($this->user->user_id, 'old_id_number');
		$data['old_id_number'] = count($old_id_number) == 0 ? " " : $old_id_number[0]['key_value'] == "" ? "" : $old_id_number[0]['key_value'];
		
		$with_parking = $this->mod->get_partners_personal($this->user->user_id, 'with_parking');
		$data['with_parking'] = count($with_parking) == 0 ? " " : $with_parking[0]['key_value'] == 0 ? "No" : "Yes";

		//Movements
		$movements_tab = array();
		$movement_qry = " SELECT  pma.action_id, pma.movement_id, pma.type_id,
							pma.effectivity_date, pma.type, pmc.cause, pma.created_on
						FROM {$this->db->dbprefix}partners_movement_action pma
						INNER JOIN {$this->db->dbprefix}partners_movement pm 
							ON pma.movement_id = pm.movement_id
						INNER JOIN {$this->db->dbprefix}partners_movement_cause pmc 
							ON pm.due_to_id = pmc.cause_id 
						WHERE pma.status_id = 6 
						AND pma.user_id = {$this->user->user_id}";
		$movement_sql = $this->db->query($movement_qry);

		if($movement_sql->num_rows() > 0){
			$movements_tab = $movement_sql->result_array();
		}
		$data['movement_tab'] = $movements_tab;

		$key_sql = "SELECT * FROM {$this->db->dbprefix}partners_key pk 
					LEFT JOIN {$this->db->dbprefix}partners_key_class pkc 
					ON pk.key_class_id = pkc.key_class_id 
					WHERE pk.deleted = 0 AND pkc.user_view = 1 ";
		$key_qry = $this->db->query($key_sql);

		$partners_keys = $key_qry->result_array();
		foreach($partners_keys as $keys){
			$data['partners_keys'][] = $keys['key_code'];
			$data['partners_labels'][$keys['key_code']] = $keys['key_label'];
		}

		//specific indo requirement
		if ($this->db->database == 'workwise.indo') {
			$this->mod->long_name = lang('my201.my201_indo');
			// $data['partners_labels'][$keys['employment_type_id']] = 'Grade';
		}
			
        $this->load->helper('file');
		$this->load->vars($data);

		if( $this->input->post('mobileapp') )
		{
			ob_start();
			// MOBILE v1
            /*echo $this->load->blade('201_mobile')->with( $this->load->get_cached_vars() );
            $this->response->cache = $this->load->get_cached_vars();
            $this->response->my201 = ob_get_clean();
            $this->response->message[] = array(
                'message' => '',
                'type' => 'success'
            );*/
            // MOBILE v2
            echo json_encode($data);
            $this->response->cache = $this->load->get_cached_vars();
            $this->response->my201 = ob_get_clean();
            $this->response->message = array(
                'message' => '',
                'type' => 'success'
            );

            $this->_ajax_return();
		}
		else
			echo $this->load->blade('record_listing_custom')->with( $this->load->get_cached_vars() );
	}

	function format_phone($phone){
	    $phone = preg_replace("/[^0-9]/", "", $phone);

	    if(strlen($phone) == 7)
	        return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
	    elseif(strlen($phone) == 11)
	        return preg_replace("/([0-9]{4})([0-9]{4})([0-9]{3})/", "$1-$2-$3", $phone);
	    else
	        return $phone;
	}

	function view_personal_details(){
        $this->_ajax_only();

		//Attachments
		$details = array();
		$details_data = array();
		$details_data_id = array();
		$details = $this->mod->get_partners_personal_list_details($this->user->user_id, $this->input->post('key_class'), $this->input->post('sequence'));
			foreach($details as $detail){
				$details_data[$detail['key']] = $detail['key_value'];
				$details_data_id[$detail['key']] = $detail['personal_id'];
			}
			$data['details'] = $details_data;
			$data['details_data_id'] = $details_data_id;

        $this->load->helper('file');
        // $view['title'] = $data['forms_title'];
        // $view['content'] = $this->load->view('edit/edit_'.$this->input->post('form_code').'_form', $data, true);
        $this->response->view_details = $this->load->view('edit/'.$this->input->post('modal_form'), $data, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
	}

	function download_file($personal_id){		
		$image_details = $this->mod->get_partners_personal_image_details($this->user->user_id, $personal_id);
		$path = base_url() . $image_details['key_value'];
		header('Content-disposition: attachment; filename='.substr( $image_details['key_value'], strrpos( $image_details['key_value'], '/' )+1 ).'');
		header('Content-type: txt/pdf');
		readfile($path);
	}

	function cr_form()
	{
		$this->_ajax_only();

		$this->load->helper('form');
		
		$key_classes = $this->mod->get_user_editable_key_classes();
		$partner_id = get_partner_id( $this->user->user_id );
		$data['key_classes'] = array();
		foreach( $key_classes as $row )
		{
			//check wether key_class has active request
			if( !$this->mod->has_active_request( $row->key_class_id, $partner_id ) )
				$data['key_classes'][$row->key_class_id] = $row->key_class; 
		}

		$drafts = $this->mod->get_user_editable_keys_draft( $this->user->user_id );
		$draft = array();
		foreach( $drafts as $row )
		{
			$draft[$row->key_class_id][$row->key_id] = $row; 
		}

		$data['draft'] = '';
		foreach( $draft as $key_class_id => $keys )
		{
			$temp = array();
			foreach ($keys as $key_id => $key) {
				$temp[] = $this->mod->create_key_draft( $key, $key->key_value );
			}
			$temp = implode('', $temp);

			$data['draft'] .= $this->load->view('draft', array('key_class_id' => $key_class_id,'keys' => $temp), true);
		}

		$this->load->vars($data);

		$data = array();
		$data['title'] = 'Change Request';
		$data['content'] = $this->load->blade('cr_form')->with( $this->load->get_cached_vars() );
		$this->response->cr_form = $this->load->view('templates/modal', $data, true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function add_class_draft()
	{
		$this->_ajax_only();

		$key_class_id = $this->input->post('key_class_id');

		$keys = $this->mod->get_user_editable_keys( $key_class_id );
		$temp = array();
		foreach( $keys as $key )
		{
			$temp[] = $this->mod->create_key_draft( $key, '' );	
		}
		$temp = implode('', $temp);

		$this->response->class_draft = $this->load->view('draft', array('key_class_id' => $key_class_id, 'keys' => $temp), true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function save_request()
	{
		$this->_ajax_only();

		$status = $this->input->post('status');
		$classes = $this->input->post('key');
		$partner_id = get_partner_id( $this->user->user_id );

		foreach( $classes as $class_id => $keys )
		{
			$active = $this->mod->has_active_request( $class_id, $partner_id );
			$ctr = 1;
			foreach($keys as $key_id => $value)
			{
				$where = $data = array(
					'partner_id' => $partner_id,
					'key_id' => $key_id,
				);

				$data['sequence'] = $ctr;
				$data['key_value'] = $value;
				$data['status'] = $status;
				
				if($active)
				{
					$this->db->update('partners_personal_request', $data, $where);
				}
				else{
					$this->db->insert('partners_personal_request', $data);
				}

				$ctr++;
			}
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}		

	function get_public_data() {
		$this->_ajax_only();

		$result = array();
		$value = trim(strtolower($_GET['term']));
		$column = $_GET['column'];

		switch($column){
			case 'countries';
			$field = 'short_name';
				$this->db->select($field)
			    ->from('countries')
			    ->where("LOWER({$field}) LIKE '%{$value}%'");
			    $result = $this->db->get('');	
		    break;
			case 'cities';
			$field = 'city';
				$this->db->select($field)
			    ->from('cities')
			    ->where("LOWER({$field}) LIKE '%{$value}%'");
			    $result = $this->db->get('');	
		    break;
		}
		
		$data = array();
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$row['label'] = trim($row[$field]);
				$data[] = $row;
			}			
		}			
		$result->free_result();

		header('Content-type: application/json');
		echo json_encode($data);
		die();
	}	

    function get_partnerskey($key_code=''){    	
		$partners_key = $this->db->get_where('partners_key', array('deleted' => 0, 'key_code' => $key_code));
    	if($partners_key->num_rows() > 0){
    		return $partners_key->row_array();
    	}
    	return array();
    }

	function get_action_movement_details(){
		$this->_ajax_only();

		$this->response->action_id = $action_id = $this->input->post("action_id");
		$this->response->type_id = $type_id = $this->input->post("type_id");
		$data['cause'] = $this->input->post("cause");

		$this->load->model('movement_model', 'move_mod');
		$action_details = $this->move_mod->get_action_movement($action_id);
		$data['count'] = 0;
		
		$data['movement_file'] = '';
		if($action_id > 0){
			$data['type'] = $action_details['type'];
			$data['type_id'] = $action_details['type_id'];
			$data['record']['partners_movement_action.action_id'] = $action_details['action_id'];//user
			$data['record']['partners_movement_action.type_id'] = $action_details['type_id'];//user
			$data['record']['partners_movement_action.user_id'] = $action_details['user_id'];//user
			$data['record']['partners_movement_action.effectivity_date'] = date("F d, Y", strtotime($action_details['effectivity_date']));//effectivity_date
			$data['record']['partners_movement_action.remarks'] = $action_details['remarks'];//action_remarks
			switch($type_id){
				case 1://Regularization
				case 3://Promotion
				case 8://Transfer
				case 9://Employment Status
				case 12://Temporary Assignment
				$end_date = $this->move_mod->get_transfer_movement($action_id, 11);
				$data['end_date'] = (count($end_date) > 0) ? $end_date[0]['to_name'] : '' ;

				$data['transfer_fields'] = $this->move_mod->getTransferFields();
				$data['partner_info'] = $this->move_mod->get_employee_details($action_details['user_id']);
				foreach($data['transfer_fields'] as $index => $field){
					$movement_type_details = $this->move_mod->get_transfer_movement($action_id, $field['field_id']);
					if(count($movement_type_details) > 0){
						$data['transfer_fields'][$index]['from_id'] = $movement_type_details[0]['from_id'];
						$data['transfer_fields'][$index]['to_id'] = $movement_type_details[0]['to_id'];
						$data['transfer_fields'][$index]['from_name'] = $movement_type_details[0]['from_name'];
						$data['transfer_fields'][$index]['to_name'] = $movement_type_details[0]['to_name'];
					}else{
						$data['transfer_fields'][$index]['from_id'] = $data['partner_info'][0][$field['field_name'].'_id'];
						$data['transfer_fields'][$index]['from_name'] = $data['partner_info'][0][$field['field_name']];
						$data['transfer_fields'][$index]['to_id'] = '';
						$data['transfer_fields'][$index]['to_name'] = '';
					}
				}
					$data['movement_file'] = 'transfer.blade.php';
				break;
				case 2://Salary Increase
				$movement_type_details = $this->move_mod->get_compensation_movement($action_id);
					$data['record']['partners_movement_action_compensation.id'] = $movement_type_details['id'];//id
					$data['record']['partners_movement_action_compensation.current_salary'] = $movement_type_details['current_salary'];//current_salary
					$data['record']['partners_movement_action_compensation.to_salary'] = $movement_type_details['to_salary'];//to_salary
					$data['movement_file'] = 'compensation.blade.php';
				break;
				case 4://Wage Order
				$movement_type_details = $this->move_mod->get_compensation_movement($action_id);
					$data['record']['partners_movement_action_compensation.id'] = $movement_type_details['id'];//id
					$data['record']['partners_movement_action_compensation.current_salary'] = $movement_type_details['current_salary'];//current_salary
					$data['record']['partners_movement_action_compensation.to_salary'] = $movement_type_details['to_salary'];//to_salary
					$data['movement_file'] = 'wage.blade.php';
				break;
				case 6://Resignation
				case 7://Termination
				$movement_type_details = $this->move_mod->get_moving_movement($action_id);
					$data['record']['partners_movement_action_moving.id'] = $movement_type_details['id'];//id
					$data['record']['partners_movement_action_moving.blacklisted'] = $movement_type_details['blacklisted'];//blacklisted
					$data['record']['partners_movement_action_moving.end_date'] = date("F d, Y", strtotime($movement_type_details['end_date']));//end_date
					$data['record']['partners_movement_action_moving.reason_id'] = $movement_type_details['reason_id'];//reason_id
					$data['record']['partners_movement_action_moving.further_reason'] = $movement_type_details['further_reason'];//further_reason
					$data['movement_file'] = 'endservice.blade.php';
				break;
				case 10://End Contract
				case 11://Retirement
				$movement_type_details = $this->move_mod->get_moving_movement($action_id);
					$data['record']['partners_movement_action_moving.id'] = $movement_type_details['id'];//id
					$data['record']['partners_movement_action_moving.blacklisted'] = $movement_type_details['blacklisted'];//blacklisted
					$data['record']['partners_movement_action_moving.end_date'] = date("F d, Y", strtotime($movement_type_details['end_date']));//end_date
					// $data['record']['partners_movement_action_moving.reason_id'] = $movement_type_details['reason_id'];//reason_id
					$data['record']['partners_movement_action_moving.further_reason'] = $movement_type_details['further_reason'];//further_reason
					$data['movement_file'] = 'retire_endo.blade.php';
				break;
				case 15://Extension
				$movement_type_details = $this->move_mod->get_extension_movement($action_id);
					$data['record']['partners_movement_action_extension.id'] = $movement_type_details['id'];//id
					$data['record']['partners_movement_action_extension.no_of_months'] = $movement_type_details['no_of_months'];//no_of_months
					$data['record']['partners_movement_action_extension.end_date'] = date("F d, Y", strtotime($movement_type_details['end_date']));//end_date
					$data['movement_file'] = 'extension.blade.php';
				break;
			}
		}

		$this->response->count = ++$data['count'];
		$this->load->helper('file');
		$this->load->helper('form');

		$this->response->add_movement = $this->load->view('edit/forms/movement/nature.blade.php', $data, true);
		$this->response->type_of_movement = $this->load->view('edit/forms/movement/'.$data['movement_file'], $data, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();
	}
}