<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'third_party/TCPDF/config/tcpdf_config.php';
include_once APPPATH.'third_party/TCPDF/tcpdf.php';

class Applicants extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('applicants_model', 'mod');
		$this->load->model('applicant_monitoring_model', 'monitoring');
		$this->lang->load('applicant_monitoring');
		$this->load->model('mrf_admin_model', 'mrf_am');

		parent::__construct();
	}

	public function index()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$process_status = $this->db->get_where( 'recruitment_status', array( 'deleted' => 0 ) );
		$data['process_status'] = $process_status->result_array();
		$recruit_source = $this->db->get_where( 'recruitment_source', array( 'deleted' => 0 ) );
		$data['recruit_source'] = $recruit_source->result_array();

		$this->load->vars( $data );
		echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
	}

	public function get_list()
	{
		$this->_ajax_only();
		if( !$this->permission['list'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
				);
			$this->_ajax_return();
		}

		$page = $this->input->post('page');
		$search = $this->input->post('search');
		$filter = "";
		$filter_by = $this->input->post('filter_by');
		$filter_value = $this->input->post('filter_value');

		$this->response->show_import_button = false;
		if( $this->input->post('page') == 1 )
		{
			$this->load->model('upload_utility_model', 'import');
			if( $this->import->get_templates( $this->mod->mod_id ) )
				$this->response->show_import_button = true;
		}

		if( is_array( $filter_by ) )
		{
			foreach( $filter_by as $filter_by_key => $filter_value )
			{
				if( $filter_value != "" ) {
					if($filter_by_key == "mrf_status"){
						if($filter_value == 'active'){
							$filter .= " AND IF({$this->db->dbprefix}{$this->mod->table}.request_id = 0, 1, req.status_id IN(3,4,5,7))";
						}else{
							$filter .= " AND req.status_id IN (5,6)";
						}
					}else{
						$filter .= " AND {$this->db->dbprefix}{$this->mod->table}.". $filter_by_key .' = "'.$filter_value.'"';	
					}
				}
			}
		}
		else{
			if( $filter_by && $filter_by != "" )
			{
				$filter .= " AND {$this->db->dbprefix}{$this->mod->table}.". $filter_by .' = "'.$filter_value.'"';
			}
		}

		$trash = $this->input->post('trash') == 'true' ? true : false;

		if( $page == 1 )
		{
			$searches = $this->session->userdata('search');
			if( $searches ){
				foreach( $searches as $mod_code => $old_search )
				{
					if( $mod_code != $this->mod->mod_code )
					{
						$searches[$this->mod->mod_code] = "";
					}
				}
			}
			$searches[$this->mod->mod_code] = $search;
			$this->session->set_userdata('search', $searches);
		}

		$page = ($page-1) * 10; //echo $page;
		$records = $this->mod->_get_list($page, 10, $search, $filter, $trash);
		$this->response->records_retrieve = sizeof($records);
		$this->response->list = '';
        if( count($records) > 0 ){

			foreach( $records as $record )
			{
				$rec = array(
					'detail_url' => '#',
					'edit_url' => '#',
					'delete_url' => '#',
					'options' => ''
					);

	           	$this->db->where('recruit_id',$record['record_id']);
	            $this->db->like('key','education','after');
	            $personal_history = $this->db->get('recruitment_personal_history');

	            $arHistory = array();
	            $arHistory_d_s = array();
	            $record['degree'] = '';
	            $record['school'] = '';
	            if ($personal_history && $personal_history->num_rows() > 0){
	                foreach ($personal_history->result() as $row) {
	                    if ($row->key == 'education-type'){
				            switch ($row->key_value) {
				                case 'Primary':
				                    $arHistory[1][$row->sequence] = 'Primary';
				                    break;
				               case 'Secondary':
				                    $arHistory[2][$row->sequence] = 'Secondary';
				                    break;
				               case 'Tertiary':
				                    $arHistory[3][$row->sequence] = 'Tertiary';
				                    break;
				               case 'Vocational':
				                    $arHistory[4][$row->sequence] = 'Vocational';
				                    break;    
				               case 'Graduate Studies':
				                    $arHistory[5][$row->sequence] = 'Graduate Studies';
				                    break;                                             
				                default:
				                    $arHistory[0][$row->sequence] = '';
				                    break;
				            } 
	                    }
	                    if ($row->key == 'education-degree'){
	                    	$arHistory_d_s[$row->sequence]['degree'] = $row->key_value;
	                    }
	                    if ($row->key == 'education-school'){
	                    	$arHistory_d_s[$row->sequence]['school'] = $row->key_value;
	                    }	                    	                    
	                }

		            $max_graudates = max(array_keys($arHistory));;
		            $max_graudates_ar_val = $arHistory[$max_graudates];
		            $rec_history = $arHistory_d_s[key($max_graudates_ar_val)];
		            $record = array_merge($record, $rec_history);
	            } 


				if(!$trash)
					$this->_list_options_active( $record, $rec );
				else
					$this->_list_options_trash( $record, $rec );				
				
				$record = array_merge($record, $rec);

				$permission_list['permission'] = $this->permission;
				$record = array_merge($record, $permission_list);
				
				// $record['users_profile_photo'] = file_exists($record['users_profile_photo']) ? $record['users_profile_photo'] : "assets/img/avatar.png";         
	   //          $parts = pathinfo($record['users_profile_photo']);
	   //          $record['users_profile_photo'] = str_replace($parts['filename'], 'thumbnail/'.$parts['filename'], $record['users_profile_photo']);
				
				$this->response->list .= $this->load->blade('list_template_custom', $record, true);
			}
        }
        else{

            $this->response->list = "";

        }

		$this->_ajax_return();
	}
	
	function _list_options_active( $record, &$rec )
	{
		// if( $this->permission['detail'] )
		// {
		// 	$rec['detail_url'] = $this->mod->url . '/detail/' . $record['record_id'];
		// 	$rec['options'] .= '<li><a href="'.$rec['detail_url'].'"><i class="fa fa-search"></i> View</a></li>';
		// }

		if( $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}	
		
		if( $this->permission['delete'] )
		{
			$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
			$rec['delete_url_javascript'] = "javascript: delete_record(".$record['record_id'].")";
        	
        	$path = base_url().'uploads/templates/app_info_sheet/pdf/';
        	$filename = $path .$record['record_id']."-". $record['recruitment_lastname']. "-applicationInfoSheet.pdf";
			// $rec['options'] .= '<li><a href="'. $filename .'" target="_blank" ><i class="fa fa-print"></i> Print</a></li>';
			$rec['options'] .= '<li><a href="javascript: ajax_export('.$record['record_id'].',\''.$record['recruitment_lastname'].'\')"><i class="fa fa-print"></i> Print</a></li>';
			$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
		}
	}

	public function edit( $recruit_id=0 )
	{
		$record_check = false;
		$this->record_id = $recruit_id;

		$result = $this->mod->_get_edit_cached_query_custom( $this->record_id );
		$result_personal = $this->mod->_get_edit_cached_query_personal_custom( $this->record_id );

		if( empty($recruit_id) )
		{
			$field_lists = $result->list_fields();
			foreach( $field_lists as $field )
			{
				$data['record'][$field] = '';
			}
		}
		else{
			$this->load->model('profile_model', 'profile_mod');
			$data['record'] = $result;

			$photo = $this->mod->get_recruitment_personal_value($recruit_id, 'photo');
			$data['record']['photo'] = count($photo) == 0 ? " " : $photo[0]['key_value'] == "" ? "" : $photo[0]['key_value'];

			$middle_initial = empty($result['middlename']) ? " " : " ".ucfirst(substr($result['middlename'],0,1)).". ";
			$data['profile_name'] = $result['firstname'].$middle_initial.$result['lastname'];
			$birthday = new DateTime($result['birth_date']);
			$data['profile_age'] = $birthday->diff(new DateTime)->y;

			//application
			$this->load->model('recruitform_model', 'rec_mod');
			$data['mrf'] = $this->rec_mod->get_active_mrf_by_year();
			$position_sought = $this->mod->get_recruitment_personal_value($recruit_id, 'position_sought');
			$data['record']['position_sought'] = count($position_sought) == 0 ? " " : $position_sought[0]['key_value'] == "" ? "" : $position_sought[0]['key_value'];
			$desired_salary = $this->mod->get_recruitment_personal_value($recruit_id, 'desired_salary');
			$data['record']['desired_salary'] = count($desired_salary) == 0 ? " " : $desired_salary[0]['key_value'] == "" ? "" : $desired_salary[0]['key_value'];
			$salary_pay_mode = $this->mod->get_recruitment_personal_value($recruit_id, 'salary_pay_mode');
			$data['record']['salary_pay_mode'] = count($salary_pay_mode) == 0 ? " " : $salary_pay_mode[0]['key_value'] == "" ? "" : $salary_pay_mode[0]['key_value'];
			$currently_employed = $this->mod->get_recruitment_personal_value($recruit_id, 'currently_employed');
			$data['record']['currently_employed'] = count($currently_employed) == 0 ? " " : $currently_employed[0]['key_value'] == "" ? "" : $currently_employed[0]['key_value'];
			$how_hiring_heard = $this->mod->get_recruitment_personal_value($recruit_id, 'how_hiring_heard');
			$data['record']['how_hiring_heard'] = count($how_hiring_heard) == 0 ? " " : $how_hiring_heard[0]['key_value'] == "" ? "" : $how_hiring_heard[0]['key_value'];
			
			$sourcing_tools = $this->mod->get_recruitment_personal_value($recruit_id, 'sourcing_tools');
			$data['record']['sourcing_tools'] = count($sourcing_tools) == 0 ? " " : $sourcing_tools[0]['key_value'] == "" ? "" : $sourcing_tools[0]['key_value'];
	
			$resume = $this->mod->get_recruitment_personal_value($recruit_id, 'resume');
			$data['record']['resume'] = count($resume) == 0 ? " " : $resume[0]['key_value'] == "" ? "" : $resume[0]['key_value'];

			$telephones = array();
			$phone_numbers = $this->mod->get_recruitment_personal_value($recruit_id, 'phone');
			foreach($phone_numbers as $phone){
				// $telephones[] = $this->format_phone($phone['key_value']);
				$telephones[] = $phone['key_value'];
			}
			$data['profile_telephones'] = $telephones;	
			$fax = array();
			$fax_numbers = $this->mod->get_recruitment_personal_value($recruit_id, 'fax');
			foreach($fax_numbers as $fax_no){
				// $fax[] = $this->format_phone($fax_no['key_value']);
				$fax[] = $fax_no['key_value'];
			}
			$data['profile_fax'] = $fax;		
			$mobiles = array();
			$mobile_numbers = $this->mod->get_recruitment_personal_value($recruit_id, 'mobile');
			foreach($mobile_numbers as $mobile){
				// $mobiles[] = $this->format_phone($mobile['key_value']);
				$mobiles[] = $mobile['key_value'];
			}
			$data['profile_mobiles'] = $mobiles;
			$city_town = $this->mod->get_recruitment_personal_value($recruit_id, 'city_town');
			$city_town = count($city_town) == 0 ? " " : $city_town[0]['key_value'] == "" ? "" : $city_town[0]['key_value'];
			$data['profile_live_in'] = $city_town;
			$countries = $this->mod->get_recruitment_personal_value($recruit_id, 'country');
			$data['profile_country'] = count($countries) == 0 ? " " : $countries[0]['key_value'] == "" ? "" : $countries[0]['key_value'];
			$civil_status = $this->mod->get_recruitment_personal_value($recruit_id, 'civil_status');
			$data['profile_civil_status'] = count($civil_status) == 0 ? " " : $civil_status[0]['key_value'] == "" ? "" : $civil_status[0]['key_value'];
			$spouse = $this->mod->get_recruitment_personal_value($recruit_id, 'spouse');
			$data['profile_spouse'] = count($spouse) == 0 ? " " : $spouse[0]['key_value'] == "" ? "" : $spouse[0]['key_value'];

			$solo_parent = $this->mod->get_recruitment_personal_value($recruit_id, 'solo_parent');
			$data['record']['personal_solo_parent'] = count($solo_parent) == 0 ? " " : $solo_parent[0]['key_value'] == "" ? "" : $solo_parent[0]['key_value'];
				//Personal Contact
			$address_1 = $this->mod->get_recruitment_personal_value($recruit_id, 'address_1');
			$address_1 = count($address_1) == 0 ? " " : $address_1[0]['key_value'] == "" ? "" : $address_1[0]['key_value'];
			$address_2 = $this->mod->get_recruitment_personal_value($recruit_id, 'address_2');
			$address_2 = count($address_2) == 0 ? " " : $address_2[0]['key_value'] == "" ? "" : $address_2[0]['key_value'];
			$data['complete_address'] = $address_1." ".$address_2;	
			$data['record']['address_1'] = $address_1;	
			$data['record']['address_2'] = $data['address_2'] = $address_2;
			$zip_code = $this->mod->get_recruitment_personal_value($recruit_id, 'zip_code');
			$data['record']['zip_code'] = count($zip_code) == 0 ? " " : $zip_code[0]['key_value'] == "" ? "" : $zip_code[0]['key_value'];
			$province = $this->mod->get_recruitment_personal_value($recruit_id, 'province');
			$data['record']['province'] = count($province) == 0 ? " " : $province[0]['key_value'] == "" ? "" : $province[0]['key_value'];
			$presentadd_no = $this->mod->get_recruitment_personal_value($recruit_id, 'presentadd_no');
			$data['record']['presentadd_no'] = count($presentadd_no) == 0 ? " " : $presentadd_no[0]['key_value'] == "" ? "" : $presentadd_no[0]['key_value'];
			$presentadd_village = $this->mod->get_recruitment_personal_value($recruit_id, 'presentadd_village');
			$data['record']['presentadd_village'] = count($presentadd_village) == 0 ? " " : $presentadd_village[0]['key_value'] == "" ? "" : $presentadd_village[0]['key_value'];
			$town = $this->mod->get_recruitment_personal_value($recruit_id, 'town');
			$data['record']['town'] = count($town) == 0 ? " " : $town[0]['key_value'] == "" ? "" : $town[0]['key_value'];
						
			$duration_years = $this->mod->get_recruitment_personal_value($recruit_id, 'duration_years');
			$data['record']['duration_years'] = count($duration_years) == 0 ? " " : $duration_years[0]['key_value'] == "" ? "" : $duration_years[0]['key_value'];
			$duration_month = $this->mod->get_recruitment_personal_value($recruit_id, 'duration_month');
			$data['record']['duration_month'] = count($duration_month) == 0 ? " " : $duration_month[0]['key_value'] == "" ? "" : $duration_month[0]['key_value'];
		
			//permanent address
			$same_as_present_address = $this->mod->get_recruitment_personal_value($recruit_id, 'same_as_present_address');
			$data['record']['same_as_present_address'] = count($same_as_present_address) == 0 ? " " : $same_as_present_address[0]['key_value'] == "" ? "" : $same_as_present_address[0]['key_value'];
			$permanent_address_1 = $this->mod->get_recruitment_personal_value($recruit_id, 'permanent_address_1');
			$data['record']['permanent_address_1'] = count($permanent_address_1) == 0 ? " " : $permanent_address_1[0]['key_value'] == "" ? "" : $permanent_address_1[0]['key_value'];
			$permanent_address_2 = $this->mod->get_recruitment_personal_value($recruit_id, 'permanent_address_2');
			$data['record']['permanent_address_2'] = count($permanent_address_2) == 0 ? " " : $permanent_address_2[0]['key_value'] == "" ? "" : $permanent_address_2[0]['key_value'];
			$permanent_city_town = $this->mod->get_recruitment_personal_value($recruit_id, 'permanent_city_town');
			$data['record']['permanent_city_town'] = count($permanent_city_town) == 0 ? " " : $permanent_city_town[0]['key_value'] == "" ? "" : $permanent_city_town[0]['key_value'];
			$permanent_province = $this->mod->get_recruitment_personal_value($recruit_id, 'permanent_province');
			$data['record']['permanent_province'] = count($permanent_province) == 0 ? " " : $permanent_province[0]['key_value'] == "" ? "" : $permanent_province[0]['key_value'];
			$permanent_country = $this->mod->get_recruitment_personal_value($recruit_id, 'permanent_country');
			$data['record']['permanent_country'] = count($permanent_country) == 0 ? " " : $permanent_country[0]['key_value'] == "" ? "" : $permanent_country[0]['key_value'];
			$permanent_zipcode = $this->mod->get_recruitment_personal_value($recruit_id, 'permanent_zipcode');
			$data['record']['permanent_zipcode'] = count($permanent_zipcode) == 0 ? " " : $permanent_zipcode[0]['key_value'] == "" ? "" : $permanent_zipcode[0]['key_value'];
			$permanent_add_no = $this->mod->get_recruitment_personal_value($recruit_id, 'permanent_add_no');
			$data['record']['permanent_add_no'] = count($permanent_add_no) == 0 ? " " : $permanent_add_no[0]['key_value'] == "" ? "" : $permanent_add_no[0]['key_value'];
			$permanent_add_village = $this->mod->get_recruitment_personal_value($recruit_id, 'permanent_add_village');
			$data['record']['permanent_add_village'] = count($permanent_add_village) == 0 ? " " : $permanent_add_village[0]['key_value'] == "" ? "" : $permanent_add_village[0]['key_value'];
			$permanent_town = $this->mod->get_recruitment_personal_value($recruit_id, 'permanent_town');
			$data['record']['permanent_town'] = count($permanent_town) == 0 ? " " : $permanent_town[0]['key_value'] == "" ? "" : $permanent_town[0]['key_value'];
		
			//employment info
			$probationary_date = $this->mod->get_recruitment_personal_value($recruit_id, 'probationary_date');
			$data['record_personal'][1]['recruitment_personal.probationary_date'] = count($probationary_date) == 0 ? " " : $probationary_date[0]['key_value'] == "" ? "" : date("F d, Y", strtotime($probationary_date[0]['key_value']));
			$original_date_hired = $this->mod->get_recruitment_personal_value($recruit_id, 'original_date_hired');
			$data['record_personal'][1]['recruitment_personal.original_date_hired'] = count($original_date_hired) == 0 ? " " : $original_date_hired[0]['key_value'] == "" ? "" : date("F d, Y", strtotime($original_date_hired[0]['key_value']));
			$last_probationary = $this->mod->get_recruitment_personal_value($recruit_id, 'last_probationary');
			$data['record_personal'][1]['recruitment_personal.last_probationary'] = count($last_probationary) == 0 ? " " : $last_probationary[0]['key_value'] == "" ? "" : date("F d, Y", strtotime($last_probationary[0]['key_value']));
			$last_salary_adjustment = $this->mod->get_recruitment_personal_value($recruit_id, 'last_salary_adjustment');
			$data['record_personal'][1]['recruitment_personal.last_salary_adjustment'] = count($last_salary_adjustment) == 0 ? " " : $last_salary_adjustment[0]['key_value'] == "" ? "" : date("F d, Y", strtotime($last_salary_adjustment[0]['key_value']));
			$organization = $this->mod->get_recruitment_personal_value($recruit_id, 'organization');
			$data['record_personal'][1]['recruitment_personal.organization'] = count($organization) == 0 ? " " : $organization[0]['key_value'] == "" ? "" : $organization[0]['key_value'];
			
			//Emergency Contact
			$emergency_name = $this->mod->get_recruitment_personal_value($recruit_id, 'emergency_name');
			$data['record']['emergency_name'] = count($emergency_name) == 0 ? " " : $emergency_name[0]['key_value'] == "" ? "" : $emergency_name[0]['key_value'];
			$emergency_relationship = $this->mod->get_recruitment_personal_value($recruit_id, 'emergency_relationship');
			$data['record']['emergency_relationship'] = count($emergency_relationship) == 0 ? " " : $emergency_relationship[0]['key_value'] == "" ? "" : $emergency_relationship[0]['key_value'];
			$emergency_phone = $this->mod->get_recruitment_personal_value($recruit_id, 'emergency_phone');
			$data['record']['emergency_phone'] = count($emergency_phone) == 0 ? " " : $emergency_phone[0]['key_value'] == "" ? "" : $emergency_phone[0]['key_value'];
			$emergency_mobile = $this->mod->get_recruitment_personal_value($recruit_id, 'emergency_mobile');
			$data['record']['emergency_mobile'] = count($emergency_mobile) == 0 ? " " : $emergency_mobile[0]['key_value'] == "" ? "" : $emergency_mobile[0]['key_value'];
			$emergency_address = $this->mod->get_recruitment_personal_value($recruit_id, 'emergency_address');
			$data['record']['emergency_address'] = count($emergency_address) == 0 ? " " : $emergency_address[0]['key_value'] == "" ? "" : $emergency_address[0]['key_value'];
			$emergency_city = $this->mod->get_recruitment_personal_value($recruit_id, 'emergency_city');
			$data['record']['emergency_city'] = count($emergency_city) == 0 ? " " : $emergency_city[0]['key_value'] == "" ? "" : $emergency_city[0]['key_value'];
			$emergency_country = $this->mod->get_recruitment_personal_value($recruit_id, 'emergency_country');
			$data['record']['emergency_country'] = count($emergency_country) == 0 ? " " : $emergency_country[0]['key_value'] == "" ? "" : $emergency_country[0]['key_value'];
			$emergency_zip_code = $this->mod->get_recruitment_personal_value($recruit_id, 'emergency_zip_code');
			$data['record']['emergency_zip_code'] = count($emergency_zip_code) == 0 ? " " : $emergency_zip_code[0]['key_value'] == "" ? "" : $emergency_zip_code[0]['key_value'];

			/***** PERSONAL TAB *****/
				//Personal
			$gender = $this->mod->get_recruitment_personal_value($recruit_id, 'gender');
			$data['record']['gender'] = count($gender) == 0 ? " " : $gender[0]['key_value'] == "" ? "" : $gender[0]['key_value'];
			$birth_place = $this->mod->get_recruitment_personal_value($recruit_id, 'birth_place');
			$data['record']['birth_place'] = count($birth_place) == 0 ? " " : $gender[0]['key_value'] == "" ? "" : $birth_place[0]['key_value'];
			$religion = $this->mod->get_recruitment_personal_value($recruit_id, 'religion');
			$data['record']['religion'] = count($religion) == 0 ? " " : $religion[0]['key_value'] == "" ? "" : $religion[0]['key_value'];
			$nationality = $this->mod->get_recruitment_personal_value($recruit_id, 'nationality');
			$data['record']['nationality'] = count($nationality) == 0 ? " " : $nationality[0]['key_value'] == "" ? "" : $nationality[0]['key_value'];
				//Other Information
			$height = $this->mod->get_recruitment_personal_value($recruit_id, 'height');
			$data['record']['height'] = count($height) == 0 ? " " : $height[0]['key_value'] == "" ? "" : $height[0]['key_value'];
			$weight = $this->mod->get_recruitment_personal_value($recruit_id, 'weight');
			$data['record']['weight'] = count($weight) == 0 ? " " : $weight[0]['key_value'] == "" ? "" : $weight[0]['key_value'];
			$interests_hobbies = $this->mod->get_recruitment_personal_value($recruit_id, 'interests_hobbies');
			$data['record']['interests_hobbies'] = count($interests_hobbies) == 0 ? " " : $interests_hobbies[0]['key_value'] == "" ? "" : $interests_hobbies[0]['key_value'];
			$language = $this->mod->get_recruitment_personal_value($recruit_id, 'language');
			$data['record']['language'] = count($language) == 0 ? " " : $language[0]['key_value'] == "" ? "" : $language[0]['key_value'];
			$dialect = $this->mod->get_recruitment_personal_value($recruit_id, 'dialect');
			$data['record']['dialect'] = count($dialect) == 0 ? " " : $dialect[0]['key_value'] == "" ? "" : $dialect[0]['key_value'];
			$dependents_count = $this->mod->get_recruitment_personal_value($recruit_id, 'dependents_count');
			$data['record']['dependents_count'] = count($dependents_count) == 0 ? " " : $dependents_count[0]['key_value'] == "" ? "" : $dependents_count[0]['key_value'];

			//other questions
			$machine_operated = $this->mod->get_recruitment_personal_value($recruit_id, 'machine_operated');
			$data['record']['machine_operated'] = count($machine_operated) == 0 ? " " : $machine_operated[0]['key_value'] == "" ? "" : $machine_operated[0]['key_value'];
			$driver_license = $this->mod->get_recruitment_personal_value($recruit_id, 'driver_license');
			$data['record']['driver_license'] = count($driver_license) == 0 ? " " : $driver_license[0]['key_value'] == "" ? "" : $driver_license[0]['key_value'];			
			$driver_type_license = $this->mod->get_recruitment_personal_value($recruit_id, 'driver_type_license');
			$data['record']['driver_type_license'] = count($driver_type_license) == 0 ? " " : $driver_type_license[0]['key_value'] == "" ? "" : $driver_type_license[0]['key_value'];						
			$prc_license = $this->mod->get_recruitment_personal_value($recruit_id, 'prc_license');
			$data['record']['prc_license'] = count($prc_license) == 0 ? " " : $prc_license[0]['key_value'] == "" ? "" : $prc_license[0]['key_value'];			
			$prc_type_license = $this->mod->get_recruitment_personal_value($recruit_id, 'prc_type_license');
			$data['record']['prc_type_license'] = count($prc_type_license) == 0 ? " " : $prc_type_license[0]['key_value'] == "" ? "" : $prc_type_license[0]['key_value'];						
			$prc_license_no = $this->mod->get_recruitment_personal_value($recruit_id, 'prc_license_no');
			$data['record']['prc_license_no'] = count($prc_license_no) == 0 ? " " : $prc_license_no[0]['key_value'] == "" ? "" : $prc_license_no[0]['key_value'];			
			$prc_date_expiration = $this->mod->get_recruitment_personal_value($recruit_id, 'prc_date_expiration');
			$data['record']['prc_date_expiration'] = count($prc_date_expiration) == 0 ? " " : $prc_date_expiration[0]['key_value'] == "" ? "" : $prc_date_expiration[0]['key_value'];			
			$illness_question = $this->mod->get_recruitment_personal_value($recruit_id, 'illness_question');
			$data['record']['illness_question'] = count($illness_question) == 0 ? " " : $illness_question[0]['key_value'] == "" ? "" : $illness_question[0]['key_value'];			
			$illness_yes = $this->mod->get_recruitment_personal_value($recruit_id, 'illness_yes');
			$data['record']['illness_yes'] = count($illness_yes) == 0 ? " " : $illness_yes[0]['key_value'] == "" ? "" : $illness_yes[0]['key_value'];						
			$trial_court = $this->mod->get_recruitment_personal_value($recruit_id, 'trial_court');
			$data['record']['trial_court'] = count($trial_court) == 0 ? " " : $trial_court[0]['key_value'] == "" ? "" : $trial_court[0]['key_value'];			
			$how_hiring_heard = $this->mod->get_recruitment_personal_value($recruit_id, 'how_hiring_heard');
			$data['record']['how_hiring_heard'] = count($how_hiring_heard) == 0 ? " " : $how_hiring_heard[0]['key_value'] == "" ? "" : $how_hiring_heard[0]['key_value'];						
			$work_start = $this->mod->get_recruitment_personal_value($recruit_id, 'work_start');
			$data['record']['work_start'] = count($work_start) == 0 ? " " : $work_start[0]['key_value'] == "" ? "" : $work_start[0]['key_value'];			
			$referred_employee = $this->mod->get_recruitment_personal_value($recruit_id, 'referred_employee');
			$data['record']['referred_employee'] = count($referred_employee) == 0 ? " " : $referred_employee[0]['key_value'] == "" ? "" : $referred_employee[0]['key_value'];						
			$illness_question = $this->mod->get_recruitment_personal_value($recruit_id, 'illness_question');
			$data['record']['illness_question'] = count($illness_question) == 0 ? " " : $illness_question[0]['key_value'] == "" ? "" : $illness_question[0]['key_value'];			

			$tin_number = $this->mod->get_recruitment_personal_value($recruit_id, 'tin_number');
			$data['record']['tin_number'] = count($tin_number) == 0 ? " " : $tin_number[0]['key_value'] == "" ? "" : $tin_number[0]['key_value'];
			$sss_number = $this->mod->get_recruitment_personal_value($recruit_id, 'sss_number');
			$data['record']['sss_number'] = count($sss_number) == 0 ? " " : $sss_number[0]['key_value'] == "" ? "" : $sss_number[0]['key_value'];
			$pagibig_number = $this->mod->get_recruitment_personal_value($recruit_id, 'pagibig_number');
			$data['record']['pagibig_number'] = count($pagibig_number) == 0 ? " " : $pagibig_number[0]['key_value'] == "" ? "" : $pagibig_number[0]['key_value'];
			$philhealth_number = $this->mod->get_recruitment_personal_value($recruit_id, 'philhealth_number');
			$data['record']['philhealth_number'] = count($philhealth_number) == 0 ? " " : $philhealth_number[0]['key_value'] == "" ? "" : $philhealth_number[0]['key_value'];


			$cert_member_to_trade = $this->mod->get_recruitment_personal_value($recruit_id, 'cert_member_to_trade');
			$data['record']['cert_member_to_trade'] = count($cert_member_to_trade) == 0 ? " " : $cert_member_to_trade[0]['key_value'] == "" ? "" : $cert_member_to_trade[0]['key_value'];
			$previously_employed_at_hdi = $this->mod->get_recruitment_personal_value($recruit_id, 'previously_employed_at_hdi');
			$data['record']['previously_employed_at_hdi'] = count($previously_employed_at_hdi) == 0 ? " " : $previously_employed_at_hdi[0]['key_value'] == "" ? "" : $previously_employed_at_hdi[0]['key_value'];
			$known_people_at_hdi = $this->mod->get_recruitment_personal_value($recruit_id, 'known_people_at_hdi');
			$data['record']['known_people_at_hdi'] = count($known_people_at_hdi) == 0 ? " " : $known_people_at_hdi[0]['key_value'] == "" ? "" : $known_people_at_hdi[0]['key_value'];
			$physical_disabilities = $this->mod->get_recruitment_personal_value($recruit_id, 'physical_disabilities');
			$data['record']['physical_disabilities'] = count($physical_disabilities) == 0 ? " " : $physical_disabilities[0]['key_value'] == "" ? "" : $physical_disabilities[0]['key_value'];
			$work_limitations = $this->mod->get_recruitment_personal_value($recruit_id, 'work_limitations');
			$data['record']['work_limitations'] = count($work_limitations) == 0 ? " " : $work_limitations[0]['key_value'] == "" ? "" : $work_limitations[0]['key_value'];
			$illness_injuries = $this->mod->get_recruitment_personal_value($recruit_id, 'illness_injuries');
			$data['record']['illness_injuries'] = count($illness_injuries) == 0 ? " " : $illness_injuries[0]['key_value'] == "" ? "" : $illness_injuries[0]['key_value'];
			$illness_injuries_desc = $this->mod->get_recruitment_personal_value($recruit_id, 'illness_injuries_desc');
			$data['record']['illness_injuries_desc'] = count($illness_injuries_desc) == 0 ? " " : $illness_injuries_desc[0]['key_value'] == "" ? "" : $illness_injuries_desc[0]['key_value'];
			$illness_compensated = $this->mod->get_recruitment_personal_value($recruit_id, 'illness_compensated');
			$data['record']['illness_compensated'] = count($illness_compensated) == 0 ? " " : $illness_compensated[0]['key_value'] == "" ? "" : $illness_compensated[0]['key_value'];
			$willing_to_relocate = $this->mod->get_recruitment_personal_value($recruit_id, 'willing_to_relocate');
			$data['record']['willing_to_relocate'] = count($willing_to_relocate) == 0 ? " " : $willing_to_relocate[0]['key_value'] == "" ? "" : $willing_to_relocate[0]['key_value'];
			$days_notice_to_work = $this->mod->get_recruitment_personal_value($recruit_id, 'days_notice_to_work');
			$data['record']['days_notice_to_work'] = count($days_notice_to_work) == 0 ? " " : $days_notice_to_work[0]['key_value'] == "" ? "" : $days_notice_to_work[0]['key_value'];
			/***** HISTORY TAB *****/
				//Education
			$education_tab = array();
			$educational_tab = array();
			$education_tab = $this->mod->get_recruitment_personal_value_history($recruit_id, 'education');
			foreach($education_tab as $educ){
				$educational_tab[$educ['sequence']][$educ['key']] = $educ['key_value'];
			}
			$data['education_tab'] = $educational_tab;
		//Employment
			$employment_tab = array();
			$employments_tab = array();
			$employment_tab = $this->mod->get_recruitment_personal_value_history($recruit_id, 'employment');
			foreach($employment_tab as $emp){
				$employments_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['employment_tab'] = $employments_tab;
		//Character Reference
			$reference_tab = array();
			$references_tab = array();
			$reference_tab = $this->mod->get_recruitment_personal_value_history($recruit_id, 'reference');
			foreach($reference_tab as $emp){
				$references_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['reference_tab'] = $references_tab;
		//Licensure
			$licensure_tab = array();
			$licensures_tab = array();
			$details_data_id = array();
			$licensure_tab = $this->mod->get_recruitment_personal_value_history($recruit_id, 'licensure');
			foreach($licensure_tab as $emp){
				$licensures_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
				$details_data_id[$emp['sequence']][$emp['key']] = $emp['personal_id'];
			}
			$data['licensure_tab'] = $licensures_tab;
			$data['details_data_id'] = $details_data_id;
		//Trainings and Seminars
			$training_tab = array();
			$trainings_tab = array();
			$training_tab = $this->mod->get_recruitment_personal_value_history($recruit_id, 'training');
			foreach($training_tab as $emp){
				$trainings_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['training_tab'] = $trainings_tab;
		//Skills
			$skill_tab = array();
			$skills_tab = array();
			$skill_tab = $this->mod->get_recruitment_personal_value_history($recruit_id, 'skill');
			foreach($skill_tab as $emp){
				$skills_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['skill_tab'] = $skills_tab;
		//Affiliation
			$affiliation_tab = array();
			$affiliations_tab = array();
			$affiliation_tab = $this->mod->get_recruitment_personal_value_history($recruit_id, 'affiliation');
			foreach($affiliation_tab as $emp){
				$affiliations_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['affiliation_tab'] = $affiliations_tab;
		//Friends and Relatives
			$friend_relative_tab = array();
			$friend_relatives_tab = array();
			$friend_relative_tab = $this->mod->get_recruitment_personal_value_history($recruit_id, 'friends_relatives');
			foreach($friend_relative_tab as $emp){
				$friend_relatives_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['friend_relative_tab'] = $friend_relatives_tab;			
		//Accountabilities
			$accountabilities_tab = array();
			$accountable_tab = array();
			$accountabilities_tab = $this->mod->get_recruitment_personal_value_history($recruit_id, 'accountabilities');
			foreach($accountabilities_tab as $emp){
				$accountable_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['accountabilities_tab'] = $accountable_tab;
		//Attachments
			$attachment_tab = array();
			$attachments_tab = array();
			$attachment_tab = $this->mod->get_recruitment_personal_value_history($recruit_id, 'attachment');
			foreach($attachment_tab as $emp){
				$attachments_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['attachment_tab'] = $attachments_tab;
		//Family
			$family_tab = array();
			$families_tab = array();
			$family_tab = $this->mod->get_recruitment_personal_value_history($recruit_id, 'family');
			foreach($family_tab as $emp){
				$families_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['family_tab'] = $families_tab;

			$data['employee'] = $this->mod->get_employee();
			$data['type_license'] = $this->mod->get_type_license();
			$data['sourcing_tool'] = $this->mod->get_sourcing_tools();			
		}

		$this->load->vars( $data );

		$this->load->helper('form');
		$this->load->helper('file');
		echo $this->load->blade('edit.edit_custom')->with( $this->load->get_cached_vars() );
	}

	public function add( $recruit_id=0 )
	{
		$record_check = false;
		$this->record_id = $data['record']['record_id']  = $data['record_id'] = "";

			$data['profile_name'] = '';
			$data['record']['photo'] = "assets/img/avatar.png";
			$data['record']['desired_position'] = "";
			$data['record']['email'] = "";
			$data['record']['birthdate'] = "";
			$data['profile_age'] = "";
			$data['profile_telephones'] = array();
			$data['profile_fax'] = array();
			$data['profile_mobiles'] = array();
			$data['profile_live_in'] = "";
			$data['profile_country'] = "";
			$data['profile_civil_status'] = "";
			$data['profile_spouse'] = "";
			$data['record']['oth_position'] = "";

			//general
			$data['record']['lastname'] = "";
			$data['record']['firstname'] = "";
			$data['record']['middlename'] = "";
			$data['record']['maidenname'] = "";
			$data['record']['nickname'] = "";
			$data['record']['photo'] = "";

			//application
			$this->load->model('recruitform_model', 'rec_mod');
			$data['mrf'] = $this->rec_mod->get_active_mrf_by_year();
			$data['record']['recruitment_date'] = "";
			$data['record']['position_sought'] = "";
			$data['record']['desired_salary'] = "";
			$data['record']['salary_pay_mode'] = "";
			$data['record']['currently_employed'] = "";
			$data['record']['how_hiring_heard'] = "";
			$data['record']['sourcing_tools'] = "";
			$data['record']['resume'] = "";
			$data['record']['recruit_status'] = "";

			$data['record']['request_id'] = "";

			//personal contacts
			$data['record']['email'] = "";
			$data['record']['address_1'] = "";
			$data['record']['address_2'] = "";
			$data['record']['zip_code'] = "";

			//emergency contacts
			$data['record']['emergency_name'] = "";
			$data['record']['emergency_relationship'] = "";
			$data['record']['emergency_phone'] = "";
			$data['record']['emergency_mobile'] = "";
			$data['record']['emergency_address'] = "";
			$data['record']['emergency_city'] = "";
			$data['record']['emergency_country'] = "";
			$data['record']['emergency_zip_code'] = "";
		
			//personal info
			$data['record']['gender'] = "";
			$data['record']['birth_date'] = "";
			$data['record']['birth_place'] = "";
			$data['record']['religion'] = "";
			$data['record']['nationality'] = "";
			$data['record']['personal_solo_parent'] = "";
		
			//other info
			$data['record']['height'] = "";
			$data['record']['weight'] = "";
			$data['record']['interests_hobbies'] = "";
			$data['record']['language'] = "";
			$data['record']['dependents_count'] = "";
			$data['record']['dialect'] = "";
			$data['record']['religion'] = "";
			$data['record']['religion'] = "";

			//other questions
			$data['record']['machine_operated'] = "";
			$data['record']['driver_license'] = "";
			$data['record']['driver_type_license'] = "";
			$data['record']['prc_license'] = "";
			$data['record']['prc_type_license'] = "";
			$data['record']['prc_license_no'] = "";
			$data['record']['prc_date_expiration'] = "";
			$data['record']['illness_question'] = "";
			$data['record']['illness_yes'] = "";
			$data['record']['trial_court'] = "";
			$data['record']['how_hiring_heard'] = "";
			$data['record']['work_start'] = "";
			$data['record']['referred_employee'] = "";
			$data['record']['illness_question'] = "";

		//Family
			$families_tab = array();
			$data['family_tab'] = $families_tab;
			/***** HISTORY TAB *****/
				//Education
			$educational_tab = array();
			$data['education_tab'] = $educational_tab;
		//Employment
			$employments_tab = array();
			$data['employment_tab'] = $employments_tab;
		//Character Reference
			$references_tab = array();
			$data['reference_tab'] = $references_tab;
		//Licensure
			$licensures_tab = array();
			$details_data_id = array();
			$data['licensure_tab'] = $licensures_tab;
			$data['details_data_id'] = $details_data_id;
		//Trainings and Seminars
			$trainings_tab = array();
			$data['training_tab'] = $trainings_tab;
		//Skills
			$skills_tab = array();
			$data['skill_tab'] = $skills_tab;
		//Affiliation
			$affiliations_tab = array();
			$data['affiliation_tab'] = $affiliations_tab;
		//Accountabilities
			$accountable_tab = array();
			$data['accountabilities_tab'] = $accountable_tab;
		//Attachments
			$attachments_tab = array();
			$data['attachment_tab'] = $attachments_tab;

			//others
			$data['record']['same_as_present_address'] = "";
			$data['record']['permanent_add_no'] = "";
			$data['record']['permanent_address_1'] = "";
			$data['record']['permanent_add_village'] = "";
			$data['record']['permanent_address_2'] = "";
			$data['record']['permanent_town'] = "";
			$data['record']['permanent_city_town'] = "";
			$data['record']['permanent_country'] = "";
			$data['record']['permanent_zipcode'] = "";
			$data['record']['permanent_province'] = "";
			$data['record']['tin_number'] = "";
			$data['record']['sss_number'] = "";
			$data['record']['pagibig_number'] = "";
			$data['record']['philhealth_number'] = "";
			$data['record']['cert_member_to_trade'] = "";
			$data['record']['previously_employed_at_hdi'] = "";
			$data['record']['known_people_at_hdi'] = "";
			$data['record']['physical_disabilities'] = "";
			$data['record']['work_limitations'] = "";
			$data['record']['illness_injuries'] = "";
			$data['record']['illness_injuries_desc'] = "";
			$data['record']['illness_compensated'] = "";
			$data['record']['willing_to_relocate'] = "";
			$data['record']['days_notice_to_work'] = "";
			$data['record']['presentadd_no'] = "";
			$data['record']['presentadd_village'] = "";
			$data['record']['town'] = "";
			$data['record']['province'] = "";
			$data['record']['duration_years'] = "";
			$data['record']['duration_month'] = "";

		$this->load->vars( $data );

		$this->load->helper('form');
		$this->load->helper('file');
		echo $this->load->blade('edit.edit_custom')->with( $this->load->get_cached_vars() );
	}

    function get_overview_details(){
    	
    	$this->_ajax_only();  	

		$this->record_id = $recruit_id = $this->input->post('record_id');

		$result = $this->mod->_get_edit_cached_query_custom( $this->record_id );
		
			$this->load->model('my201_model', 'profile_mod');
			$data['record'] = $result;

			$photo = $this->mod->get_recruitment_personal_value($recruit_id, 'photo');
			$data['record']['photo'] = count($photo) == 0 ? " " : $photo[0]['key_value'] == "" ? "" : $photo[0]['key_value'];
			$position_sought = $this->mod->get_recruitment_personal_value($recruit_id, 'position_sought');
			$data['record']['position_sought'] = count($position_sought) == 0 ? " " : $position_sought[0]['key_value'] == "" ? "" : $position_sought[0]['key_value'];

			$middle_initial = empty($result['middlename']) ? " " : " ".ucfirst(substr($result['middlename'],0,1)).". ";
			$data['profile_name'] = $result['firstname'].$middle_initial.$result['lastname'];
			$birthday = new DateTime($result['birth_date']);
			$data['profile_age'] = $birthday->diff(new DateTime)->y;

			$telephones = array();
			$phone_numbers = $this->mod->get_recruitment_personal_value($recruit_id, 'phone');
			foreach($phone_numbers as $phone){
				$telephones[] = $phone['key_value'];
			}
			$data['profile_telephones'] = $telephones;	
			$fax = array();
			$fax_numbers = $this->mod->get_recruitment_personal_value($recruit_id, 'fax');
			foreach($fax_numbers as $fax_no){
				$fax[] = $fax_no['key_value'];
			}
			$data['profile_fax'] = $fax;		
			$mobiles = array();
			$mobile_numbers = $this->mod->get_recruitment_personal_value($recruit_id, 'mobile');
			foreach($mobile_numbers as $mobile){
				$mobiles[] = $mobile['key_value'];
			}
			$data['profile_mobiles'] = $mobiles;
			$city_town = $this->mod->get_recruitment_personal_value($recruit_id, 'city_town');
			$city_town = count($city_town) == 0 ? " " : $city_town[0]['key_value'] == "" ? "" : $city_town[0]['key_value'];
			$data['profile_live_in'] = $city_town;
			$countries = $this->mod->get_recruitment_personal_value($recruit_id, 'country');
			$data['profile_country'] = count($countries) == 0 ? " " : $countries[0]['key_value'] == "" ? "" : $countries[0]['key_value'];
			$civil_status = $this->mod->get_recruitment_personal_value($recruit_id, 'civil_status');
			$data['profile_civil_status'] = count($civil_status) == 0 ? " " : $civil_status[0]['key_value'] == "" ? "" : $civil_status[0]['key_value'];
			$spouse = $this->mod->get_recruitment_personal_value($recruit_id, 'spouse');
			$data['profile_spouse'] = count($spouse) == 0 ? " " : $spouse[0]['key_value'] == "" ? "" : $spouse[0]['key_value'];

		// $data['attachment_tab'] = $attachments_tab;
	    $view['content'] = $this->load->view('edit/forms/profile_header_overview', $data, true);
		
	    $this->response->lists = $view['content'];

	    $this->response->message[] = array(
	        'message' => '',
	        'type' => 'success'
	        );

	    $this->_ajax_return();
    }

	function add_form() {
		$this->_ajax_only();

		$data['count'] = $this->input->post('count');
		$data['counting'] = $this->input->post('counting');
		$data['category'] = $this->input->post('category');
		$data['employee'] = $this->mod->get_employee();

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
			// $validation_rules[] = 
			// array(
			// 	'field' => 'recruitment_personal[desired_salary]',
			// 	'label' => 'Desired Salary',
			// 	'rules' => 'required'
			// 	);
			// $other_tables['recruitment'] = $post['recruitment'];
			$partners_personal_table = "recruitment_personal";
			// $other_tables['partners'] = $post['partners'];
			// $other_tables['partners']['effectivity_date'] = date('Y-m-d', strtotime($post['partners']['effectivity_date']));
			$partners_personal_key = array('position_sought', 'desired_salary', 'photo', 'salary_pay_mode', 'currently_employed', 'sourcing_tools', 'resume');
			$partners_personal = $post['recruitment_personal'];
			break;
			case 3:
			//Contacts Tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment[email]',
				'label' => 'Email Address',
				'rules' => 'required|valid_email'
				);
			$partners_personal_table = "recruitment_personal";
			$partners_personal_key = array('phone', 'mobile', 
								'address_1', 'city_town', 'country', 'zip_code', 'address_2', 'province', 'presentadd_no', 'presentadd_village', 'town',
								'duration_years', 'duration_month',
								'same_as_present_address', 'permanent_address_1', 'permanent_address_2', 'permanent_city_town', 'permanent_province', 'permanent_country', 'permanent_zipcode', 'permanent_add_no', 'permanent_add_village', 'permanent_town',
								'emergency_name', 'emergency_relationship', 'emergency_phone', 'emergency_mobile', 'emergency_address', 'emergency_city', 'emergency_country', 'emergency_zip_code');
			$partners_personal = $post['recruitment_personal'];

			$partner_phone = $_POST['recruitment_personal']['phone'];
			$partner_mobile = $_POST['recruitment_personal']['mobile'];
			$emergency_phone = $_POST['recruitment_personal']['emergency_phone'];
			$emergency_mobile = $_POST['recruitment_personal']['emergency_mobile'];

			unset($partners_personal['mobile']);
			foreach ($partner_mobile as $phone){
				$mobile = $this->check_mobile($phone);
				if(!empty($phone)){
					if(!$mobile){
						$this->response->invalid=true;
						$this->response->invalid_message='Invalid mobile number';
						$this->response->message[] = array(
					    	'message' => 'Invalid mobile number',
					    	'type' => 'warning'
						);
		        		$this->_ajax_return();
		        	}else{
		        		$partners_personal['mobile'][] = $mobile;
		        	}
		        }
			}
        	if(!isset($partners_personal['mobile'])){
        		$partners_personal['mobile'] = array();
        	}
			unset($partners_personal['phone']);
			foreach ($partner_phone as $phone){
				$mobile = $this->check_phone($phone);
				if(!empty($phone)){
					if(!$mobile){
						$this->response->invalid=true;
						$this->response->invalid_message='Invalid phone number';
						$this->response->message[] = array(
					    	'message' => 'Invalid phone number',
					    	'type' => 'warning'
						);
		        		$this->_ajax_return();
		        	}else{
		        		$partners_personal['phone'][] = $mobile;
		        	}
		        }
			}
        	if(!isset($partners_personal['phone'])){
        		$partners_personal['phone'] = array();
        	}
			if(!empty($partners_personal['emergency_mobile'])){
				$mobile = $this->check_mobile($partners_personal['emergency_mobile']);
				if(!$mobile){
					$this->response->invalid=true;
					$this->response->invalid_message='Invalid contact mobile number';
					$this->response->message[] = array(
				    	'message' => 'Invalid contact mobile number',
				    	'type' => 'warning'
					);
	        		$this->_ajax_return();
	        	}else{
	        		$partners_personal['emergency_mobile'] = $mobile;
	        	}
			}

			if(!empty($partners_personal['emergency_phone'])){
				$mobile = $this->check_phone($partners_personal['emergency_phone']);
				if(!$mobile){
					$this->response->invalid=true;
					$this->response->invalid_message='Invalid contact phone number';
					$this->response->message[] = array(
				    	'message' => 'Invalid contact phone number',
				    	'type' => 'warning'
					);
	        		$this->_ajax_return();
	        	}else{
	        		$partners_personal['emergency_phone'] = $mobile;
	        	}
			}
			break;
			case 4:
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
			$partners_personal_key = array('gender', 'birth_place', 'religion', 'nationality', 'civil_status', 
									'tin_number', 'sss_number','pagibig_number','philhealth_number',
									'machine_operated', 'driver_license', 'driver_type_license', 'prc_license', 'prc_type_license', 'prc_license_no', 'prc_date_expiration', 'illness_question', 'illness_yes', 'trial_court', 'how_hiring_heard', 'work_start', 'referred_employee',
									'cert_member_to_trade', 'previously_employed_at_hdi', 'known_people_at_hdi', 'physical_disabilities', 'work_limitations', 'illness_injuries', 'illness_injuries_desc', 'illness_compensated', 'willing_to_relocate', 'days_notice_to_work', 
									'height', 'weight', 'interests_hobbies', 'language', 'dialect', 'dependents_count', 'solo_parent');
			$partners_personal = $post['recruitment_personal'];
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
			$partners_personal_key = array('education-type', 'education-school', 'education-year-from', 'education-year-to', 'education-degree', 'education-status', 'education-lastsem-attended', 'education-honors_awards');
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
			$partners_personal_key = array('employment-company', 'employment-position-title', 'employment-location', 'employment-duties', 'employment-month-hired', 'employment-month-end', 'employment-year-hired', 'employment-year-end',
								'employment-nature-of-business', 'employment-contact-number', 'employment-last-salary', 'employment-supervisor', 'employment-reason-for-leaving');
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
			$partners_personal_key = array('reference-name', 'reference-occupation', 'reference-years-known', 'reference-phone', 'reference-mobile', 'reference-address', 'reference-city', 'reference-country', 'reference-zipcode', 'reference-organization',
									'reference-relationship', 'reference-employer');
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
/*			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[skill-type]',
				'label' => 'Skill Type',
				'rules' => 'required'
				);*/
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
			case 11:
			//Affiliation tab
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
			case 14:
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
			$partners_personal_key = array('family-age', 'family-relationship', 'family-name', 'family-birthdate', 'family-occupation', 'family-employer');
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
			case 15:
			//friend and relative tab
			$validation_rules[] = 
			array(
				'field' => 'recruitment_personal_history[friend-relative-employee]',
				'label' => 'Relative Employee Name',
				'rules' => 'required'
				);

			$partners_personal_table = "recruitment_personal_history";
			$partners_personal_key = array('friend-relative-employee', 'friend-relative-position', 'friend-relative-dept', 'friend-relative-relation');
			if(array_key_exists('recruitment_personal_history', $post)){
				$partners_personal = $post['recruitment_personal_history'];
			}else{	
				$this->response->message[] = array(
						'message' => "Please add friend relatives.",
						'type' => 'warning'
						);  
				$this->_ajax_return();
			}
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
        /***** END Form Validation (hard coded) *****/

        //SAVING START   
		$transactions = true;
		// $this->recruit_id = 0;
		if( $transactions )
		{
			$this->db->trans_begin();
		}

		//start saving with main table
		if(array_key_exists($this->mod->table, $post)){
			$previous_main_data = array();
			$main_record = $post[$this->mod->table];
			$record = $this->db->get_where( $this->mod->table, array( $this->mod->primary_key => $this->record_id ) );

			switch( true )
			{
				case $record->num_rows() == 0:
					//add mandatory fields
					$main_record['created_by'] = $this->user->user_id;
					if(array_key_exists('recruitment_date', $main_record)){
						$main_record['recruitment_date'] = date('Y-m-d', strtotime($main_record['recruitment_date']));
					}
					if(array_key_exists('birth_date', $main_record)){
						$main_record['birth_date'] = date('Y-m-d', strtotime($main_record['birth_date']));
					}

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
					$main_record['modified_by'] = $this->user->user_id;
					$main_record['modified_on'] = date('Y-m-d H:i:s');
					if(array_key_exists('recruitment_date', $main_record)){
						$main_record['recruitment_date'] = date('Y-m-d', strtotime($main_record['recruitment_date']));
					}
					if(array_key_exists('birth_date', $main_record)){
						$main_record['birth_date'] = date('Y-m-d', strtotime($main_record['birth_date']));
					}
				//get previous data for audit logs
					$previous_main_data = $this->db->get_where($this->mod->table, array($this->mod->primary_key => $this->record_id))->row_array();
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
			//create system logs
			$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, $this->response->action, $this->mod->table, $previous_main_data, $main_record);
		
			if(array_key_exists('lastname', $main_record))
				$this->response->lastname = $main_record['lastname'];
	
			if(array_key_exists('request_id', $post['recruitment'])){
				if( $post['recruitment']['request_id'] )
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
				}
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
				if (isset($partners_personal[$key])){
					if(!is_array($partners_personal[$key])){
						$record = $this->mod->get_recruitment_personal($this->record_id , $partners_personal_table, $key, $current_sequence);
						if(in_array($post['fgs_number'], $accountabilities_attachments) && $current_sequence == 0) //insert to personal history
						{
							$sequence = count($record) + 1;
							$record = array();
						}
						$data_personal = array('key_value' => $partners_personal[$key]);
						$previous_main_data = array();
						switch( true )
						{
							case count($record) == 0:
								$data_personal = $this->mod->insert_recruitment_personal($this->record_id, $key, $partners_personal[$key], $sequence, $this->recruit_id);
								
								if($data_personal['key_id'] != 0){
									$this->db->insert($partners_personal_table, $data_personal);
								}
								// $this->record_id = $this->db->insert_id();
								$action = 'insert';
								break;
							case count($record) == 1:
								$recruit_id = $this->recruit_id;
								$where_array = in_array($post['fgs_number'], $accountabilities_attachments) ? array( 'recruit_id' => $recruit_id, 'key' => $key, 'sequence' => $current_sequence ) : array( 'recruit_id' => $recruit_id, 'key' => $key );
							//get previous data for audit logs
								$previous_main_data = $this->db->get_where($partners_personal_table, $where_array)->row_array();
								$this->db->update( $partners_personal_table, $data_personal, $where_array );
								$action = 'update';
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
						$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, $action, $partners_personal_table, $previous_main_data, $data_personal);
					}else{
						$sequence = 1;
						$recruit_id = $this->recruit_id;
						$this->db->delete($partners_personal_table, array( 'recruit_id' => $recruit_id, 'key' => $key ));
						//create system logs
						$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'delete', "$partners_personal_table - recruit_id", array(), array('recruit_id' => $recruit_id));

						foreach( $partners_personal[$key] as $table => $data_personal )
						{
							$data_personal = $this->mod->insert_recruitment_personal($this->record_id, $key, $data_personal, $sequence, $this->recruit_id);
							if($data_personal['key_id'] != 0){
								$this->db->insert($partners_personal_table, $data_personal);
							}
							if( $this->db->_error_message() != "" ){
								$this->response->message[] = array(
									'message' => $this->db->_error_message(),
									'type' => 'error'
								);
								$error = true;
							}	
							$sequence++;
							//create system logs
							$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', $partners_personal_table, array(), $data_personal);
						}

					}
				}
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

	function view_personal_details(){
		$this->_ajax_only();

		//Attachments
		$details = array();
		$details_data = array();
		$details_data_id = array();
		
			$details = $this->mod->get_recruitment_personal_list_details($this->input->post('record_id'), $this->input->post('key_class'), $this->input->post('sequence'));
			foreach($details as $detail){
				$details_data[$detail['key']] = $detail['key_value'];
				$details_data_id[$detail['key']] = $detail['personal_id'];
			}

		$data['details'] = $details_data;
		$data['details_data_id'] = $details_data_id;
		$data['sequence'] = $this->input->post('sequence');

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

    function account_attach_list(){    	
    	$this->_ajax_only();  	
    	$recruit_id = $this->input->post('record_id');
    	$partner_id = $this->input->post('partner_id');

		if($partner_id == 12){
			//Accountabilities
			$accountabilities_tab = array();
			$accountable_tab = array();
			$accountabilities_tab = $this->mod->get_recruitment_personal_value_history($recruit_id, 'accountabilities');
			foreach($accountabilities_tab as $emp){
				$accountable_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['accountabilities_tab'] = $accountable_tab;
	    	$view['content'] = $this->load->view('edit/forms/accountabilities_list', $data, true);
		}else{ //partner_id == 13
		//Attachments
			$attachment_tab = array();
			$attachments_tab = array();
			$attachment_tab = $this->mod->get_recruitment_personal_value_history($recruit_id, 'attachment');
			foreach($attachment_tab as $emp){
				$attachments_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['attachment_tab'] = $attachments_tab;
	    	$view['content'] = $this->load->view('edit/forms/attachments_list', $data, true);
		}

	    $this->response->lists = $view['content'];

	    $this->response->message[] = array(
	        'message' => '',
	        'type' => 'success'
	        );

	    $this->_ajax_return();
    }

	function download_file($personal_id){	
		$this->load->model('my201_model', 'profile_mod');	
		$image_details = $this->profile_mod->get_partners_personal_image_details($this->user->user_id, $personal_id);
		$path = base_url() . $image_details['key_value'];
		
		header('Content-disposition: attachment; filename='.substr( $image_details['key_value'], strrpos( $image_details['key_value'], '/' )+1 ).'');
		header('Content-type: txt/pdf');
		readfile($path);
	}	

    // application info sheet
    function export_pdf_application_info_sheet(){
        $recruit_id = $this->input->post('record_id');
        $applicant_surname = $this->input->post('lastname');

        $filename = $this->mod->export_pdf_application_info_sheet($recruit_id, $applicant_surname);

        $this->response->message[] = array(
            'message' => 'Download file ready.',
            'type' => 'success'
        );

        $this->response->filename = $filename;
        $this->_ajax_return();
    }

    private function check_path( $path, $create = true )
    {
        if( !is_dir( FCPATH . $path ) ){
            if( $create )
            {
                $folders = explode('/', $path);
                $cur_path = FCPATH;
                foreach( $folders as $folder )
                {
                    $cur_path .= $folder;

                    if( !is_dir( $cur_path ) )
                    {
                        mkdir( $cur_path, 0777, TRUE);
                        $indexhtml = read_file( APPPATH .'index.html');
                        write_file( $cur_path .'/index.html', $indexhtml);
                    }

                    $cur_path .= '/';
                }
            }
            return false;
        }
        return true;
    } 


    public function app_info_sheet(){
    	$data = array();

		$this->load->vars( $data );

		$this->load->helper('form');
		$this->load->helper('file');
		echo $this->load->blade('templates.applicant_monitoring.en.application_info_sheet')->with( $this->load->get_cached_vars() );
	}

	public function get_history($value='')
	{
		$this->_ajax_only();
		$vars['process_id'] = $process_id = $this->input->post('process_id');
		$vars['recuser_user_id'] = $recuser_user_id = $this->input->post('user_id');
		$this->db->limit(1);
		$vars['process'] = $process = $this->db->get_where('recruitment_process', array('process_id' => $process_id))->row();
		$this->db->limit(1);
		$request = $this->db->get_where('recruitment_request', array('request_id' => $process->request_id))->row();
		$this->db->limit(1);
		$vars['recruit'] = $recruit = $this->db->get_where('recruitment', array('recruit_id' => $process->recruit_id))->row();
		$vars['is_interviewer'] = $this->monitoring->is_interviewer();

		$vars['position'] = "";
		$vars['phone'] = "";
		$vars['mobile'] = "";
		
		$position = $this->mod->get_recruitment_personal_value($process->recruit_id, 'position_sought');
		if(sizeof($position)>0)
		{
			$vars['position'] = $position[0]['key_value'];	
		}
		$phone = $this->mod->get_recruitment_personal_value($process->recruit_id, 'phone');
		if(sizeof($phone)>0)
		{
			$vars['phone'] = $phone[0]['key_value'];	
		}
		$mobile = $this->mod->get_recruitment_personal_value($process->recruit_id, 'mobile');
		if(sizeof($mobile)>0)
		{
			$vars['mobile'] = $mobile[0]['key_value'];	
		}

		$vars['saved_scheds'] = $this->monitoring->get_scheds($process_id);

		$vars['recuser_company_id'] = $request->company_id;
		$vars['recuser_department_id'] = $request->department_id;
		$vars['recuser_reports_to_id'] = $request->user_id;
		$vars['recuser_location_id'] = "";
		$vars['recuser_shift_id'] = "";

		$company_code = $this->db->get_where('users_company', array('company_id' => $request->company_id))->row()->company_code;
		$series = get_system_series('ID_NUMBER', $company_code);

		$vars['recuser_login'] = $series;
		if( !empty($recuser_user_id) )
		{
			$qry = "SELECT a.company_id as recuser_company_id, a.department_id as recuser_department_id, a.reports_to_id as recuser_reports_to_id, 
			a.location_id as recuser_location_id, b.shift_id as recuser_shift_id, c.login as recuser_login
			FROM {$this->db->dbprefix}users_profile a
			LEFT JOIN {$this->db->dbprefix}partners b on a.user_id = b.user_id
			LEFT JOIN {$this->db->dbprefix}users c on c.user_id = a.user_id
			WHERE a.user_id = {$recuser_user_id} LIMIT 1 OFFSET 0";
			$recuser = $this->db->query($qry)->row_array();
			$vars = array_merge($vars, $recuser);
		}

		$this->db->limit(1);

		$jo = $this->db->get_where('recruitment_process_offer', array('process_id' => $process_id));
		if( $jo->num_rows() == 1 )
		{
			$jo = $jo->row_array();
			$vars = array_merge($vars, $jo);
		}

		$vars['employment_status'] = '';
		$vars['template_jo'] = '';
		$employment_status = $this->db->get_where('partners_employment_status', array('active' => 1, 'deleted' => 0, 'employment_status_id' => $jo['employment_status_id']));
        if($employment_status && $employment_status->num_rows() > 0){
            $vars['employment_status'] =  $employment_status->row()->employment_status;
        }
        $template_jo = $this->db->get_where('system_template', array('code' => 'STEP-4', 'mod_id' => $this->monitoring->mod_id, 'deleted' => 0, 'template_id' => $jo['template_id']));
		if($template_jo && $template_jo->num_rows() > 0){
            $vars['template_jo'] =  $template_jo->row()->name;
        }
		$vars['blacklisted'] = $recruit->blacklisted;
		if(strtotime($vars['start_date'])){
			$vars['start_date'] = date('F d, Y', strtotime($vars['start_date']));
		}else{
			$vars['start_date'] = "";
		}
		if(strtotime($vars['end_date'])){
			$vars['end_date'] = date('F d, Y', strtotime($vars['end_date']));
		}else{
			$vars['end_date'] = "";
		}

		$vars['exams'] = $this->monitoring->get_exams($process_id);

		$vars['bis'] = $this->monitoring->get_backgrounds($process_id);

/*		$this->db->limit(1);
		$cs = $this->db->get_where('recruitment_process_signing', array('process_id' => $process_id));
		$vars['template_id'] = '';
		$vars['signing_accepted'] = '1';

		if( $cs->num_rows() == 1 )
		{
			$cs = $cs->row();
			$vars['template_id'] = $cs->template_id;
			$template_cs = $this->db->get_where('system_template', array('code' => 'STEP-5', 'mod_id' => $this->monitoring->mod_id, 'deleted' => 0, 'template_id' => $cs->template_id))->row();

			$vars['template_cs'] = $template_cs->name;
			$vars['signing_accepted'] = $cs->accepted;
		}*/
		$vars['monitoring_route'] = $this->monitoring->route;

		$compben = $this->db->get_where('recruitment_benefit', array('deleted' => 0));
        $cbopt = array();
        foreach( $compben->result() as $cb )
        {
            $cbopt[$cb->benefit_id] = $cb->benefit;
        }

        $rates = $this->db->get_where('payroll_rate_type', array('deleted' => 0));
        $rateopt = array();
        foreach( $rates->result() as $rate )
        {
            $rateopt[$rate->payroll_rate_type_id] = $rate->payroll_rate_type;
        }

        $qry = "SELECT a.*, b.benefit
                    FROM {$this->db->dbprefix}recruitment_process_offer_compben a
                    LEFT JOIN {$this->db->dbprefix}recruitment_benefit b on b.benefit_id = a.benefit_id
                    WHERE a.process_id = {$process_id}";
        $benefits = $this->db->query($qry);
        $vars['benefits'] = $benefits;
        $vars['cbopt'] = $cbopt;
        $vars['rateopt'] = $rateopt;

        $qry = "SELECT ec.checklist, pec.checklist_id, pec.submitted, ec.for_submission, 
                    pec.created_on, pec.modified_on, pec.process_id, ec.print_function
                    FROM {$this->db->dbprefix}recruitment_process_employment_checklist pec
                    LEFT JOIN {$this->db->dbprefix}recruitment_employment_checklist ec
                    ON pec.checklist_id = ec.checklist_id
                    WHERE pec.deleted = 0 AND pec.process_id = {$process_id}";
  
                                    $checklist = $this->db->query($qry);
        $vars['checklist'] = $checklist;      

		$vars['bi'] = $this->monitoring->get_bi($process_id);

		// for joboffer template
        $option = $this->db->get_where('recruitment_process_offer_template', array('deleted' => 0));
        $options = array('' => 'Select...');
        foreach ($option->result() as $opt) {
            $options[$opt->template_id] = $opt->template_name;
        }

        $vars['jo_template_options'] = $options;

        // for reports to
        $option = $this->db->query("SELECT users.* FROM users
                                    LEFT JOIN users_profile ON users.user_id = users_profile.user_id
                                    WHERE users.active = 1 AND users.deleted = 0 AND users.user_id != 0
                                    ORDER BY full_name");
        $options = array('' => 'Select...');
        foreach ($option->result() as $opt) {
            $options[$opt->user_id] = $opt->full_name;
        }

        $vars['reports_to_options'] = $options;

        // employment status
        $option = $this->db->get_where('partners_employment_status', array('active' => 1, 'deleted' => 0));
        $options = array('' => 'Select...');
        foreach ($option->result() as $opt) {
            $options[$opt->employment_status_id] = $opt->employment_status;
        }
		$vars['employment_status_options'] = $options;

		$this->load->helper('form');
		$this->load->helper('file');

		// $this->response->history = $this->load->view('pages/history', $vars, true);
		$this->load->vars( $vars );

		$vars['title'] = $recruit->firstname . ' ' . $recruit->lastname;
		$vars['description'] = $vars['position'];

		$vars['description'] .= '<ul class="list-inline text-muted">';
            if(!empty($phone)):
            	$vars['description'] .= '<li class="small"><i class="fa fa-phone"></i><span>'.$vars['phone'].'</span></li>';
            endif;
            if(!empty($mobile)):
                $vars['description'] .= '<li class="small"><i class="fa fa-mobile"></i><span>'.$vars['mobile'].'</span></li>';
            endif;
            if(!empty($recruit->email)):
                $vars['description'] .= '<li class="small"><i class="fa fa-envelope"></i><span>'.$recruit->email.'</span></li>';
            endif;
        $vars['description'] .= '</ul>';
      

		$vars['content'] = $this->load->blade('pages.history')->with( $this->load->get_cached_vars() );
		$this->response->history = $this->load->view('templates/modal', $vars, true);


		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
		
	}

	function print_interview()
	{
		$this->_ajax_only();

		$process_id = $this->input->post('process_id');
    	$user = $this->config->item('user');

        $this->load->library('PDFm');
        $mpdf = new PDFm();

        $mpdf->SetTitle( 'Interview Assessment' );
        $mpdf->SetAutoPageBreak(true, 1);
        $mpdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $mpdf->SetDisplayMode('real', 'default');
        $mpdf->AddPage();


	 	$interview_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_process recp 
	 					LEFT JOIN {$this->db->dbprefix}recruitment rec ON recp.recruit_id = rec.recruit_id
	 					WHERE recp.process_id = {$process_id}";
	 	$recruit_details = $this->db->query($interview_qry)->row_array();
	 	$template_data['dear'] = $recruit_details['firstname'].' '.$recruit_details['lastname'];
		$template_data['recipients'] = $recruit_details['firstname'].' '.$recruit_details['lastname'];
		$template_data['date'] = date('M d Y',strtotime($recruit_details['recruitment_date']));

	 	$request_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_request rr 
	 					LEFT JOIN {$this->db->dbprefix}users_company uc ON rr.company_id = uc.company_id
	 					LEFT JOIN {$this->db->dbprefix}users_department ud ON rr.department_id = ud.department_id
	 					WHERE rr.request_id = {$recruit_details['request_id']}";
	 	$request_details = $this->db->query($request_qry)->row_array();
		$template_data['company_name'] = $request_details['company'];
		$template_data['company_code'] = $request_details['company_code'];
		$template_data['department'] = $request_details['department'];
		$template_data['logo'] = base_url().$request_details['print_logo'];
		$template_data['section'] = 'RECRUITMENT';

        $optional_requirements = $this->mrf_am->get_recruitment_request_key_value($recruit_details['request_id'], 'optional_requirements');
        $optional_requirements = count($optional_requirements) == 0 ? " " : $optional_requirements[0]['key_value'] == "" ? "" : $optional_requirements[0]['key_value'];
        $optional_requirements = unserialize($optional_requirements);
        $template_data['optional_requirements1'] = $optional_requirements[0];
        $template_data['optional_requirements2'] = $optional_requirements[1];
        $template_data['optional_requirements3'] = $optional_requirements[2];
		$position_where = array( 'recruit_id' => $recruit_details['recruit_id'], 'key' => 'position_sought');
		$position_sought = $this->db->get_where( 'recruitment_personal', $position_where )->row_array();
		$template_data['position'] = $position_sought['key_value'];
        // get recruitment interview details
        $recruitment_process_interview_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_process_interview rpi 
                        LEFT JOIN {$this->db->dbprefix}recruitment_process rp ON rpi.process_id = rp.process_id
                        WHERE rpi.process_id = {$process_id}";
        $recruit_inteview_details = $this->db->query($recruitment_process_interview_qry);
        if ($recruit_inteview_details && $recruit_inteview_details->num_rows() > 0){
        	$html = '';
        	foreach ($recruit_inteview_details->result() as $row) {
		        $recommendation = $this->monitoring->get_recruitment_interview_details($row->id, 'technical_recommendation');
		        if (count($recommendation) > 0){
		        	$recommendation_val = ($recommendation['key_value'] == "") ? "" : $recommendation['key_value'];
		        	$remarks = $this->monitoring->get_recruitment_interview_details($row->id, 'remarks');
		        	$remarks_val = ($remarks['key_value'] == "") ? "" : $remarks['key_value'];
		        	$interviewer = $this->monitoring->get_recruitment_interview_details($row->id, 'interviewer');
		        	$interviewer_val = ($interviewer['key_value'] == "") ? "" : $interviewer['key_value'];
		        	$interviewer_date = $this->monitoring->get_recruitment_interview_details($row->id, 'interviewer_date');
		        	$interviewer_date_val = ($interviewer_date['key_value'] == "") ? "" : $interviewer_date['key_value'];				        			        	
		        	$html .= '<tr>
		                <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;width:70%">'.$remarks_val.'</td>
		                <td style="width:30%;border-bottom: 1px solid #000;">
		                    <u>&nbsp;&nbsp;&nbsp;'.($recommendation_val == 'Consider' ? "X" : "&nbsp;&nbsp;").'&nbsp;&nbsp;&nbsp;</u> consider <br>
		                    <u>&nbsp;&nbsp;&nbsp;'.($recommendation_val == 'Hold' ? "X" : "&nbsp;&nbsp;").'&nbsp;&nbsp;&nbsp;</u> hold <br>
		                    <u>&nbsp;&nbsp;&nbsp;'.($recommendation_val == 'Reject' ? "X" : "&nbsp;&nbsp;").'&nbsp;&nbsp;&nbsp;</u> reject <br><br><br><br>
		                    By: <u>&nbsp;&nbsp;&nbsp;'.$interviewer_val.'&nbsp;&nbsp;&nbsp;</u> <br>
		                    Date: <u>&nbsp;&nbsp;&nbsp;'.$interviewer_date_val.'&nbsp;&nbsp;&nbsp;</u>
		                </td>
		            </tr> ';
		        }	        
        	}
        }

        $template_data['comments'] = $html;

		$template_data['system_url'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'URL' LIMIT  1")->row_array();
    	$template_data['system_title'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'application_title' LIMIT  1")->row_array();
    	$template_data['system_author'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'author' LIMIT  1")->row_array();

        $this->load->helper('file');
		$this->load->library('parser');

       	$mrf_template = $this->db->get_where( 'system_template', array( 'code' => 'INTERVIEW-ASSESSMENT', 'deleted' => 0) )->row_array();
		$this->parser->set_delimiters('{{', '}}');
		$html = $this->parser->parse_string($mrf_template['body'], $template_data, TRUE);

        $this->load->helper('file');
        $path = 'uploads/templates/interview/pdf/';
        $this->check_path( $path );
        $filename = $path .$template_data['dear']."-".$template_data['position']. "-".'Interview Assessment' .".pdf";

        $mpdf->WriteHTML($html, 0, true, false);
        $mpdf->Output($filename, 'F');

        $this->response->filename = $filename;
		$this->response->message[] = array(
			'message' => 'File successfully loaded.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function print_jo()
	{
		$this->_ajax_only();

		$process_id = $this->input->post('process_id');
		$jo = $this->db->get_where('recruitment_process_offer', array('process_id' => $process_id));

		if($jo->num_rows() == 0){
			$this->response->message[] = array(
				'message' => 'Please fillout first Job Offer details before sending email.',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

    	$user = $this->config->item('user');
        $this->load->library('PDFm');
        $mpdf=new PDFm();

        $mpdf->SetTitle( 'Job Offer' );
        $mpdf->SetAutoPageBreak(true, 1);
        $mpdf->SetMargins(0, 0, 40);
        $mpdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $mpdf->SetDisplayMode('real', 'default');
        $mpdf->AddPage();
        
        // this is line is for AHI
        $template_jo = '';
        $offer_saved = $this->db->get_where('recruitment_process_offer',array('process_id' => $process_id));
        if ($offer_saved && $offer_saved->num_rows() > 0){
        	$template_jo = $offer_saved->row()->template_value;
        }

        $template_data['jo_template'] = (isset($_POST['jo']['template_value']) && $_POST['jo']['template_value'] != '' ? $_POST['jo']['template_value'] : $template_jo);

        $benefit_html = '<table align="center" cellpadding="2px" cellspacing="0" style="width: 95%; height: auto; background: #fff; border: 1px solid #000;margin-bottom: 10px;">
        					<tr>
            					<td style="border-right: 1px solid #000;border-bottom: 1px solid #000" align="center">Compensation</td>
            					<td style="border-bottom: 1px solid #000" align="center">Amount</td>
        					</tr>';

    	$this->db->join('payroll_transaction','recruitment_process_offer_compben.benefit_id = payroll_transaction.transaction_id');
    	$benefit_saved = $this->db->get_where('recruitment_process_offer_compben',array('process_id' => $process_id, 'permanent' => 0));
    	if ($benefit_saved && $benefit_saved->num_rows() > 0){
    		$total = 0;
    		foreach ($benefit_saved->result() as $row) {
    			$total += $row->amount;
        		$benefit_html .= '<tr>
                					<td style="border-right: 1px solid #000" align="lect">'.$row->transaction_label.'</td>
                					<td align="left">'.number_format($row->amount, 2, '.', ',').'</td>
            					</tr>';
    		}
    		$benefit_html .= '<tr>
            					<td style="border-right: 1px solid #000" align="lect"><b>Gross Pay</b></td>
            					<td align="left">'.number_format($total, 2, '.', ',').'</td>
        					</tr>';    		
    	}


        $benefit_html .= '</table>';

        $permanent_html = '<table align="center" cellpadding="2px" cellspacing="0" style="width: 95%; height: auto; background: #fff; border: 1px solid #000;margin-bottom: 10px;">
        					<tr>
            					<td style="border-right: 1px solid #000;border-bottom: 1px solid #000" align="center">Compensation</td>
            					<td style="border-bottom: 1px solid #000" align="center">Amount</td>
        					</tr>';

    	$this->db->join('payroll_transaction','recruitment_process_offer_compben.benefit_id = payroll_transaction.transaction_id');
    	$benefit_saved = $this->db->get_where('recruitment_process_offer_compben',array('process_id' => $process_id, 'permanent' => 0));
    	if ($benefit_saved && $benefit_saved->num_rows() > 0){
    		$total = 0;
    		foreach ($benefit_saved->result() as $row) {
    			$total += $row->amount;
        		$permanent_html .= '<tr>
                					<td style="border-right: 1px solid #000" align="lect">'.$row->transaction_label.'</td>
                					<td align="left">'.number_format($row->amount, 2, '.', ',').'</td>
            					</tr>';
    		}
    		$permanent_html .= '<tr>
            					<td style="border-right: 1px solid #000" align="lect"><b>Gross Pay</b></td>
            					<td align="left">'.number_format($total, 2, '.', ',').'</td>
        					</tr>';    		
    	}


        $permanent_html .= '</table>';

        $vars['compensation'] = $benefit_html;
        $vars['probationary_appoinment'] = $permanent_html;
        $vars['permanent_appoinment'] = '';

        $this->load->helper('file');
		$this->load->library('parser');
		$this->parser->set_delimiters('{{', '}}');

		$template_data['jo_template'] = $this->parser->parse_string($template_data['jo_template'], $vars, TRUE);

       	$mrf_template = $this->db->get_where( 'system_template', array( 'code' => 'JOB-OFFER-FORM') )->row_array();
		$html = $this->parser->parse_string($mrf_template['body'], $template_data, TRUE);
		// this is line is for AHI

        $this->load->helper('file');
        $path = 'uploads/templates/job_offer/pdf/';
        $this->check_path( $path );
        $filename = $path .$template_data['dear']."-".$template_data['position']. "-".'Job Offer' .".pdf";

        $mpdf->WriteHTML($html, 0, true, false);
        $mpdf->Output($filename, 'F');

        $this->response->filename = $filename;
		$this->response->message[] = array(
			'message' => 'File successfully loaded.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function print_bi()
	{
		$this->_ajax_only();

		$process_id = $this->input->post('process_id');
/*		$jo = $this->db->get_where('recruitment_process_offer', array('process_id' => $process_id));*/

    	$user = $this->config->item('user');

        $this->load->library('PDFm');
        $mpdf = new PDFm();

        $mpdf->SetTitle( 'Background Investigation' );
        $mpdf->SetAutoPageBreak(true, 1);
        $mpdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $mpdf->SetDisplayMode('real', 'default');
        $mpdf->AddPage();

/*		$offer = $jo->row_array();
		$template_data['date'] = date('F d, Y');
		$template_data['start_date'] = date('F d, Y', strtotime($offer['start_date']));
		if(strtotime($offer['end_date'])){
			$template_data['end_probi_date'] = date('F d, Y', strtotime($offer['end_date']));
		}else{
			$template_data['end_probi_date'] = '';
		}*/

/*	 	$immediate_qry = "SELECT pos.* FROM {$this->db->dbprefix}users_profile up
					LEFT JOIN {$this->db->dbprefix}users_position pos ON up.position_id = pos.position_id
					WHERE up.user_id = {$offer['reports_to']}";
	 	$immediate = $this->db->query($immediate_qry)->row_array();
		$template_data['immediateposition'] = $immediate['position'];*/

		$this->db->where('recruitment_process_background.process_id',$process_id);
		$bi_header = $this->db->get('recruitment_process_background');
		if ($bi_header && $bi_header->num_rows() > 0){
			$bi_header_row = $bi_header->row();
		}

	 	$template_data['date'] = 'MARCH 01, 2013';
	 	$template_data['date_created'] = date('F d, Y',strtotime($bi_header_row->created_on));
	 	$interview_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_process recp 
	 					LEFT JOIN {$this->db->dbprefix}recruitment rec ON recp.recruit_id = rec.recruit_id
	 					WHERE recp.process_id = {$process_id}";
	 	$recruit_details = $this->db->query($interview_qry)->row_array();
	 	$template_data['dear'] = $recruit_details['firstname'].' '.$recruit_details['lastname'];
		$template_data['recipients'] = $recruit_details['firstname'].' '.$recruit_details['lastname'];
		$template_data['lastname'] = $recruit_details['lastname'];
		$template_data['firstname'] = $recruit_details['firstname'];
		$template_data['middlename'] = $recruit_details['middlename'];
		$template_data['section'] = 'RECRUITMENT';

	 	$request_qry = "SELECT * FROM {$this->db->dbprefix}recruitment_request rr 
	 					LEFT JOIN {$this->db->dbprefix}users_company uc ON rr.company_id = uc.company_id
	 					LEFT JOIN {$this->db->dbprefix}users_department ud ON rr.department_id = ud.department_id
	 					WHERE rr.request_id = {$recruit_details['request_id']}";
	 	$request_details = $this->db->query($request_qry)->row_array();
		$template_data['company_name'] = $request_details['company'];
		$template_data['interview_venue'] = $request_details['address'];
		$template_data['company_code'] = $request_details['company_code'];
		$template_data['department'] = $request_details['department'];
		$template_data['logo'] = base_url().$request_details['print_logo'];

		$position_where = array( 'recruit_id' => $recruit_details['recruit_id'], 'key' => 'position_sought');
		$position_sought = $this->db->get_where( 'recruitment_personal', $position_where )->row_array();
		$template_data['position'] = $position_sought['key_value'];

	 	$hr_qry = "SELECT up.* FROM {$this->db->dbprefix}users_profile up
						LEFT JOIN {$this->db->dbprefix}users_position pos ON up.position_id = pos.position_id
						WHERE pos.position_code = 'HRM-RES'";
	 	$hr = $this->db->query($hr_qry)->row_array();
		$template_data['HRmanager'] = $hr['firstname'].' '.$hr['lastname'];

		$template_data['system_url'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'URL' LIMIT  1")->row_array();
    	$template_data['system_title'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'application_title' LIMIT  1")->row_array();
    	$template_data['system_author'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'author' LIMIT  1")->row_array();

		$this->db->where('recruitment_process_background.process_id',$process_id);
		$this->db->join('recruitment_process_background_items','recruitment_process_background.rpb_id = recruitment_process_background_items.rpb_id');
		$work_related['result'] = $this->db->get('recruitment_process_background');

		$prev_work_related = $this->load->view('pages/bi_forms_print', $work_related, true);

		$template_data['prev_work_related'] = $prev_work_related;
		$template_data['address1'] = $vars['presentadd_no'].' '.$vars['address_1'].' '.$vars['presentadd_village'].' '.$vars['address_2'];
		$template_data['address2'] = $vars['town'].' '.$vars['city_town'].' '.$vars['province'].' '.$vars['zip_code'];
        
        $this->load->helper('file');
		$this->load->library('parser');

       	$mrf_template = $this->db->get_where( 'system_template', array( 'code' => 'BACKGROUND-CHECK-FORM') )->row_array();
		$this->parser->set_delimiters('{{', '}}');
		$html = $this->parser->parse_string($mrf_template['body'], $template_data, TRUE);

        $this->load->helper('file');
        $path = 'uploads/templates/background_check/pdf/';
        $this->check_path( $path );
        $filename = $path .$template_data['dear']."-".$template_data['position']. "-".' Background Check Form' .".pdf";

        $mpdf->WriteHTML($html, 0, true, false);
        $mpdf->Output($filename, 'F');

        $this->response->filename = $filename;
		$this->response->message[] = array(
			'message' => 'File successfully loaded.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}		

}