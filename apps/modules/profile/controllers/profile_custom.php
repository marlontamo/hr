

	public function index(){
		
		if( !$this->permission['list'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$this->record_id = $data['user_id'] = $this->user->user_id;
		/***** Header Details *****/
		$profile_header_details = $this->mod->get_profile_header_details($this->record_id);
		$middle_initial = empty($profile_header_details['middlename']) ? " " : " ".ucfirst(substr($profile_header_details['middlename'],0,1)).". ";
		$data['profile_name'] = $profile_header_details['firstname'].$middle_initial.$profile_header_details['lastname'];
		
		$department = empty($profile_header_details['department']) ? "" : " on ".$profile_header_details['department'];
		$data['profile_position'] = $profile_header_details['position'];
		$data['profile_company'] = $profile_header_details['company'];
		$data['profile_email'] = $profile_header_details['email'];
		$data['profile_birthdate'] = date("F d, Y", strtotime($profile_header_details['birth_date']));
			$birthday = new DateTime($profile_header_details['birth_date']);
		$data['profile_age'] = $birthday->diff(new DateTime)->y;
		$data['profile_photo'] = $profile_header_details['photo'] == "" ? "assets/img/avatar.png" : $profile_header_details['photo'];

		$city_town = $this->mod->get_partners_personal($this->record_id, 'city_town');
			$city_town = count($city_town) == 0 ? " " : $city_town[0]['key_value'] == "" ? "" : $city_town[0]['key_value'];

		$data['profile_live_in'] = $city_town;
		$countries = $this->mod->get_partners_personal($this->record_id, 'country');
			$data['profile_country'] = count($countries) == 0 ? " " : $countries[0]['key_value'] == "" ? "" : $countries[0]['key_value'];
		$telephones = array();
		$phone_numbers = $this->mod->get_partners_personal($this->record_id, 'phone');
			foreach($phone_numbers as $phone){
				$telephones[] = $this->format_phone($phone['key_value']);
			}
			$data['profile_telephones'] = $telephones;
		$fax = array();
		$fax_numbers = $this->mod->get_partners_personal($this->record_id, 'fax');
			foreach($fax_numbers as $fax_no){
				$fax[] = $this->format_phone($fax_no['key_value']);
			}
			$data['profile_fax'] = $fax;
		$mobiles = array();
		$mobile_numbers = $this->mod->get_partners_personal($this->record_id, 'mobile');
			foreach($mobile_numbers as $mobile){
				$mobiles[] = $this->format_phone($mobile['key_value']);
			}
			$data['profile_mobiles'] = $mobiles;
		$civil_status = $this->mod->get_partners_personal($this->record_id, 'civil_status');
			$data['profile_civil_status'] = count($civil_status) == 0 ? " " : $civil_status[0]['key_value'] == "" ? "" : $civil_status[0]['key_value'];
		$spouse = $this->mod->get_partners_personal($this->record_id, 'spouse');
			$data['profile_spouse'] = count($spouse) == 0 ? " " : $spouse[0]['key_value'] == "" ? "" : $spouse[0]['key_value'];

		$data['public_profile_details'] = $this->mod->get_public_profile($this->record_id);
		if(!empty($data['public_profile_details'])){
			$data['public_profile_details']['interest'] = (explode(",",$data['public_profile_details']['interest']));
			$data['public_profile_details']['language_spoken'] = unserialize($data['public_profile_details']['language_spoken']);
			$data['public_profile_details']['social'] = unserialize($data['public_profile_details']['social']);
		}else{
			$data['public_profile_details']['summary'] = '';
			$data['public_profile_details']['interest'] = '';
			$data['public_profile_details']['language_spoken'] = '';
			$data['public_profile_details']['social'] = '';
		}

        $this->load->helper('file');
		$this->load->vars($data);
		echo $this->load->blade('record_listing_custom')->with( $this->load->get_cached_vars() );
	}

	public function edit(){
		
		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$this->record_id = $data['user_id'] = $this->user->user_id;
		/***** Header Details *****/
		$profile_header_details = $this->mod->get_profile_header_details($this->record_id);
		$middle_initial = empty($profile_header_details['middlename']) ? " " : " ".ucfirst(substr($profile_header_details['middlename'],0,1)).". ";
		$data['profile_name'] = $profile_header_details['firstname'].$middle_initial.$profile_header_details['lastname'];
		
		$department = empty($profile_header_details['department']) ? "" : " on ".$profile_header_details['department'];
		$data['profile_position'] = $profile_header_details['position'];
		$data['profile_company'] = $profile_header_details['company'];
		$data['profile_email'] = $profile_header_details['email'];
		$data['profile_birthdate'] = date("F d, Y", strtotime($profile_header_details['birth_date']));
			$birthday = new DateTime($profile_header_details['birth_date']);
		$data['profile_age'] = $birthday->diff(new DateTime)->y;
		$data['profile_photo'] = $profile_header_details['photo'] == "" ? "assets/img/avatar.png" : $profile_header_details['photo'];

		$city_town = $this->mod->get_partners_personal($this->record_id, 'city_town');
			$city_town = count($city_town) == 0 ? " " : $city_town[0]['key_value'] == "" ? "" : $city_town[0]['key_value'];

		$data['profile_live_in'] = $city_town;
		$countries = $this->mod->get_partners_personal($this->record_id, 'country');
			$data['profile_country'] = count($countries) == 0 ? " " : $countries[0]['key_value'] == "" ? "" : $countries[0]['key_value'];
		$telephones = array();
		$phone_numbers = $this->mod->get_partners_personal($this->record_id, 'phone');
			foreach($phone_numbers as $phone){
				$telephones[] = $this->format_phone($phone['key_value']);
			}
			$data['profile_telephones'] = $telephones;
		$fax = array();
		$fax_numbers = $this->mod->get_partners_personal($this->record_id, 'fax');
			foreach($fax_numbers as $fax_no){
				$fax[] = $this->format_phone($fax_no['key_value']);
			}
			$data['profile_fax'] = $fax;
		$mobiles = array();
		$mobile_numbers = $this->mod->get_partners_personal($this->record_id, 'mobile');
			foreach($mobile_numbers as $mobile){
				$mobiles[] = $this->format_phone($mobile['key_value']);
			}
			$data['profile_mobiles'] = $mobiles;
		$civil_status = $this->mod->get_partners_personal($this->record_id, 'civil_status');
			$data['profile_civil_status'] = count($civil_status) == 0 ? " " : $civil_status[0]['key_value'] == "" ? "" : $civil_status[0]['key_value'];
		$spouse = $this->mod->get_partners_personal($this->record_id, 'spouse');
			$data['profile_spouse'] = count($spouse) == 0 ? " " : $spouse[0]['key_value'] == "" ? "" : $spouse[0]['key_value'];

		$data['public_profile_details'] = $this->mod->get_public_profile($this->record_id);
		if(!empty($data['public_profile_details'])){
			$data['public_profile_details']['language_spoken'] = unserialize($data['public_profile_details']['language_spoken']);
			$data['public_profile_details']['social'] = unserialize($data['public_profile_details']['social']);
		}else{
			$data['public_profile_details']['summary'] = '';
			$data['public_profile_details']['interest'] = '';
			$data['public_profile_details']['language_spoken'] = '';
			$data['public_profile_details']['social'] = '';
		}
        $this->load->helper('file');
		$this->load->vars($data);
		echo $this->load->blade('edit.edit_profile')->with( $this->load->get_cached_vars() );
	}

	function save(){

		$error = false;
		$post = $_POST;
		$this->response->record_id = $this->record_id = $post['record_id'];
		unset( $post['record_id'] );

        /***** END Form Validation (hard coded) *****/
		if($post['section'] == 'language'){
			if(isset($post['users_profile_public']['language_spoken'])){
	        	$users_profile_public = $post['users_profile_public'];
	        	foreach($users_profile_public['language_spoken'] as $index => $value){
	        		$languag_spoken[$value] = $users_profile_public = $post['users_profile_public']['language_spoken_proficiency'][$index];
	        	}
		        unset( $post['users_profile_public'] );
		        $post['users_profile_public']['language_spoken'] = serialize($languag_spoken);
	    	}else{
	    		$post['users_profile_public']['language_spoken'] = '';
	    	}
    	}

		if($post['section'] == 'social'){
	    	if(isset($post['users_profile_public']['social'])){
	        	$users_profile_public = $post['users_profile_public'];
	        	foreach($users_profile_public['social'] as $index => $value){
	        		$social_account = rtrim($post['users_profile_public']['social_account'][$index], '/');
	        		if (strpos($social_account,'/') == true) {
	        			$social_account = substr( $post['users_profile_public']['social_account'][$index], strrpos( $post['users_profile_public']['social_account'][$index], '/' )+1 );
					}
	        		$social_networks[$value] = $users_profile_public = trim($social_account);
	        	}
		        unset( $post['users_profile_public'] );
		        $post['users_profile_public']['social'] = serialize($social_networks);
	    	}else{
	    		$post['users_profile_public']['social'] = '';
	    	}
    	}

        //SAVING START   
		$transactions = true;
		$this->partner_id = 0;
		if( $transactions )
		{
			$this->db->trans_begin();
		}

		//start saving with main table
		if(array_key_exists($this->mod->table, $post)){
			$main_record = $post[$this->mod->table];
			$main_record[$this->mod->primary_key] = $this->record_id;	
			$record = $this->db->get_where( $this->mod->table, array( $this->mod->primary_key => $this->record_id ) );

			switch( true )
			{				
				case $record->num_rows() == 0:
					$this->db->insert($this->mod->table, $main_record);
					if( $this->db->_error_message() == "" )
					{
						$this->response->record_id = $this->record_id = $this->db->insert_id();
					}
					$this->response->action = 'insert';
					break;
				case $record->num_rows() == 1:
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


			if($post['section'] == 'interest'){
				$interests = explode(',',$post['users_profile_public']['interest']);
				if(is_array($interests)){
					foreach($interests as $index => $value){
						$value = trim(strtolower($value));
						$this->db->select('interest')
					    ->from('users_profile_public_data')
					    ->where("LOWER(interest) = '{$value}'");
					    $qry_result = $this->db->get('');	
					    
						$public_data_count = $qry_result->num_rows();
						if($public_data_count == 0){
							$this->db->insert('users_profile_public_data', array('interest' => $value));
						}
					}
				}
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
		$data['category'] = $this->input->post('category');
		$data['form_value'] = $this->input->post('form_value');

		$this->load->helper('file');
		$this->response->add_form = $this->load->view('edit/forms/'.$this->input->post('add_form'), $data, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();
	}

	function reset_form() {
		$this->_ajax_only();
		$post = $_POST;

		$this->db->select($post['column'])
	    ->from($post['table'])
	    ->where("user_id = {$post['record_id']}");

	    $qry_result = $this->db->get('');	
		$public_data = $qry_result->row_array();
		$data['public_profile_details'][$post['column']] = $this->response->public_data = $public_data[$post['column']];
		
		$with_files = array('interest', 'language_spoken', 'social');
		if(in_array($post['column'], $with_files)){
			$this->load->helper('file');
			$this->response->reset_public = $this->load->view('edit/forms/reset/'.$post['column'], $data, true);
		}
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();
	}

	function get_public_data() {
		$this->_ajax_only();

		$value = trim(strtolower($_GET['term']));
		$column = $_GET['column'];
		$this->db->select($column)
	    ->from('users_profile_public_data')
	    ->where("LOWER({$column}) LIKE '%{$value}%'");
	    $result = $this->db->get('');	

		$data = array();
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$row['label'] = trim($row[$column]);
				$data[] = $row;
			}			
		}			
		$result->free_result();

		header('Content-type: application/json');
		echo json_encode($data);
		die();
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
	
