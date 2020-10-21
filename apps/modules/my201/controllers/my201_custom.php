


	public function index(){
		
		if( !$this->permission['list'] )
		{
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
			$families_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
		}
		$data['family_tab'] = $families_tab;

        $this->load->helper('file');
		$this->load->vars($data);
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
