<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class applicants_model extends Record
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
		$this->mod_id = 121;
		$this->mod_code = 'applicants';
		$this->route = 'recruitment/applicants';
		$this->url = site_url('recruitment/applicants');
		$this->primary_key = 'recruit_id';
		$this->table = 'recruitment';
		$this->icon = 'fa-user';
		$this->short_name = 'Applicants';
		$this->long_name  = 'Applicants';
		$this->description = 'personal information and more';
		$this->path = APPPATH . 'modules/applicants/';

		parent::__construct();
	}

	function get_employee(){
		$this->db->where('user_id !=',1);
		$result = $this->db->get('users');
		if ($result && $result->num_rows() > 0){
			return $result->result_array();
		}
		else{
			return array();
		}
	}

	function get_type_license(){
		$result = $this->db->get('recruitment_type_license');
		if ($result && $result->num_rows() > 0){
			return $result->result_array();
		}
		else{
			return array();
		}
	}

	function get_sourcing_tools(){
		$result = $this->db->get('recruitment_sourcing_tools');
		if ($result && $result->num_rows() > 0){
			return $result->result_array();
		}
		else{
			return array();
		}
	}	
		
	function get_recruitment_personal($recruit_id=0, $recruitment_personal_table='', $key='', $sequence=0){
		$this->db->select("{$this->table}.recruit_id, key_value")
	    ->from($recruitment_personal_table)
	    ->join($this->table, $recruitment_personal_table.".recruit_id = {$this->table}.recruit_id", 'left')
	    ->where("{$this->table}.recruit_id = {$recruit_id}")
	    ->where($recruitment_personal_table.".key = '$key'");
	    if($sequence != 0)
	    	$this->db->where($recruitment_personal_table.".sequence = '$sequence'");

		if($recruitment_personal_table == 'recruitment_personal'){
	    	$this->db->where("recruitment_personal.deleted = 0");
	    }

	    $recruitment_personal = $this->db->get('');	
		// echo "<pre>";print_r($this->db->last_query());
	    
		if( $recruitment_personal->num_rows() > 0 )
	    	return $recruitment_personal->result_array();
	    else
	    	return array();
	}

	function get_recruitment_personal_value($recruit_id=0, $key=''){

		$this->db->select('key_value')
	    ->from('recruitment_personal ')
	    ->join('recruitment', 'recruitment_personal.recruit_id = recruitment.recruit_id', 'left')
	    ->where("recruitment.recruit_id = $recruit_id")
	    ->where("recruitment_personal.key = '$key'")
	    ->where("recruitment_personal.deleted = 0");

	    $recruitment_personal = $this->db->get('');	

		if( $recruitment_personal->num_rows() > 0 )
	    	return $recruitment_personal->result_array();
	    else
	    	return array();
	}

	function get_recruitment_personal_value_history($recruit_id=0, $key_class_code=''){

		$this->db->select('key, sequence, key_value, personal_id')
	    ->from('recruitment_personal_history')
	    ->join('recruitment', 'recruitment_personal_history.recruit_id = recruitment.recruit_id', 'left')
	    ->join('recruitment_key', 'recruitment_personal_history.key_id = recruitment_key.key_id', 'left')
	    ->join('recruitment_key_class', 'recruitment_key.key_class_id = recruitment_key_class.key_class_id', 'left')
	    ->where("recruitment.recruit_id = $recruit_id")
	    ->where("recruitment_key_class.key_class_code = '$key_class_code'");

	    $recruitment_personal_history = $this->db->get();

	    if( $recruitment_personal_history->num_rows() > 0 )
	    	return $recruitment_personal_history->result_array();
	    else
	    	return array();
	}

	public function insert_recruitment_personal( $user_id =0, $key_code='', $key_value='', $sequence=0, $recruit_id=0)
	{
		// $sql_partner = $this->db->get_where('recruitment', array('user_id' => $user_id));
		// $partner_details = $sql_partner->row_array();

		// if(!count($partner_details) > 0){
		// 	$this->db->insert('recruitment', array('user_id' => $user_id));
		// 	$recruit_id = $this->db->insert_id();
		// }
		// debug($key_code); die;
		$key_id_value = 0;
		$key_code_value = '';
		$key_label_value = '';

		$this->db->where('key_code', $key_code);
		$sql_partner_key = $this->db->get('recruitment_key');
		$key_details = $sql_partner_key->row_array();
		$data = array();

		foreach ($key_details as $key) {
			$key_id_value = $key_details['key_id'];
			$key_code_value = $key_details['key_code'];
			$key_label_value = $key_details['key_label'];
		}

		$data = array(
			'recruit_id' => $recruit_id,
			'key_id' => $key_id_value,		
			'key' => $key_code_value,
			'sequence' => $sequence,
			'key_name' => $key_label_value,
			'key_value' => $key_value,
			'created_on' => date('Y-m-d H:i:s'),
			'created_by' => ( !$this->session->userdata('user') ) ? '' : $this->user->user_id
			);
		return $data;
	}

	public function _get_edit_cached_query_custom( $record_id=0 )
	{
		$this->load->config('edit_cached_query_custom');
		$cached_query = $this->config->item('edit_cached_query_custom');

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($cached_query, array('record_id' => $record_id), TRUE);

		return $this->db->query( $qry )->row_array();
	}

	public function _get_edit_cached_query_personal_custom( $record_id=0 )
	{
		$this->load->config('edit_cached_query_custom');
		$cached_query = $this->config->item('edit_cached_query_personal_custom');

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($cached_query, array('record_id' => $record_id), TRUE);

		return $this->db->query( $qry )->result_array();
	}

	function get_recruitment_personal_list_details($recruit_id=0, $key_class_code='', $sequence=0){

		// $recruit_id = $this->get_recruit_id($user_id);
		$this->db->select('key, sequence, key_value, personal_id')
	    ->from('recruitment_personal_history')
	    ->join('recruitment', 'recruitment_personal_history.recruit_id = recruitment.recruit_id', 'left')
	    ->join('recruitment_key', 'recruitment_personal_history.key_id = recruitment_key.key_id', 'left')
	    ->join('recruitment_key_class', 'recruitment_key.key_class_id = recruitment_key_class.key_class_id', 'left')
	    ->where("recruitment.recruit_id = $recruit_id")
	    ->where("recruitment_key_class.key_class_code = '$key_class_code'")
	    ->where("recruitment_personal_history.sequence = '$sequence'")
	    // ->order_by("sequence", "desc")
	    ;

	    $recruitment_personal_list_details = $this->db->get('');	
		return $recruitment_personal_list_details->result_array();
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
	
    // application info sheet
    function export_pdf_application_info_sheet($recruit_id, $applicant_surname){
    	$user = $this->config->item('user');

        $this->load->library('PDFm');

        $mpdf = new PDFm();
        $mpdf->SetTitle( 'Application Info Sheet' );
        $mpdf->SetAutoPageBreak(true, 1);
        $mpdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $mpdf->SetDisplayMode('real', 'default');
        $mpdf->AddPage();

        // $this->load->library('Pdf');
        // $pdf = new Pdf();
        // $pdf->SetTitle( 'Application Info Sheet' );
        // $pdf->SetFontSize(10,true);
        // $pdf->SetAutoPageBreak(true, 1);
        // $pdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        // $pdf->SetDisplayMode('real', 'default');

        // $pdf->SetPrintHeader(false);
        // $pdf->SetPrintFooter(false);
        // $pdf->AddPage();
        // $pdf->setPageOrientation('P');

        $vars['name_spouse'] = '';
        $vars['spouse_age'] = '';
        $vars['spouse_occupation'] = '';   

        $query = "SELECT * FROM applicant_details WHERE recruit_id = {$recruit_id} ";
        $appData = $this->db->query($query)->row();
        // echo "<pre>";
        // print_r($pdata['header'] );
        // exit();
        $vars['firstname'] = $appData->firstname;
        $vars['lastname'] = $appData->lastname;
        $vars['middlename'] = $appData->middlename;
        $vars['maidenname'] = $appData->maidenname;
        $vars['nickname'] = $appData->nickname;
        $vars['emailAdd'] = $appData->email;
        $vars['birthdate'] = date('F d, Y', strtotime($appData->birthdate));
        $vars['fullname'] = $appData->fullname;
		$vars['positionApplied'] = $appData->position_desired;
		$vars['desired_salary'] = $appData->desired_salary;	
		$vars['contact_number'] = ($appData->phone != '' && $appData->mobile != '') ? $appData->phone .' / '. $appData->mobile :  ($appData->phone != '') ? $appData->phone : $appData->mobile;
		$vars['recruitment_date'] = $appData->recruitment_date;
		$vars['press_address'] = $appData->present_address;
		$vars['prov_address'] = $appData->present_province;
		$vars['birthplace'] = $appData->birth_place;
		$vars['age'] = $appData->age;
		$vars['sex'] = $appData->gender;
		$vars['height'] = $appData->height;
		$vars['weight'] = $appData->weight;
		$vars['single'] = ($appData->civil_status == 'Single') ? 'X' : ' ';
		$vars['married'] = ($appData->civil_status == 'Married') ? 'X' : ' ';
		$vars['widow'] = ($appData->civil_status == 'Widow/Widower') ? 'X' : ' ';
		$vars['separated'] = ($appData->civil_status == 'Separated') ? 'X' : ' ';
		$vars['citizenship'] = $appData->citizenship;
		$vars['religion'] = $appData->religion;
		$vars['sss_no'] = $appData->sss_number;
		$vars['tin'] = $appData->tin_number;
		$vars['pagibig_no'] = $appData->pagibig_number;
		$vars['philhealth'] = $appData->philhealth_number;
		$vars['date'] = 'March 01,2013';
		$photo = $this->get_recruitment_personal_value($recruit_id, 'photo');

		$sourcing = '';
		if ($appData->how_hiring_heard != ''){
			$result_sourcing = $this->db->get_where('recruitment_sourcing_tools',array('sourcing_tool_id' => $appData->how_hiring_heard));
			if ($result_sourcing && $result_sourcing->num_rows() > 0){
				$sourcing = $result_sourcing->row()->sourcing_tool;
			}
		}

		$vars['sourcing'] = $sourcing;

		$profilepic = base_url($photo[0]['key_value']);
		$picture = "<img src=\"{$profilepic}\" style=\"width:180px;\" />";
		$vars['profilePic'] = count($photo) == 0 ? " " : $photo[0]['key_value'] == "" ? "" : $picture;

		//spouse
        $query = "SELECT * FROM applicant_personal_history WHERE recruit_id = {$recruit_id} AND relationship = 'Spouse'";
        $famData_result = $this->db->query($query);
        if ($famData_result && $famData_result->num_rows() > 0){
        	$famData = $famData_result->row();

	        $vars['name_spouse'] = $famData->spouse_name;
	        $vars['spouse_age'] = $famData->spouse_age;
	        $vars['spouse_occupation'] = $famData->spouse_occupation;        	
        }

		//children
		$html = '';
        $query = "SELECT * FROM applicant_personal_history WHERE recruit_id = {$recruit_id} AND relationship IN ('Son','Daughter')";
        $famData_result = $this->db->query($query);
        if ($famData_result && $famData_result->num_rows() > 0){
        	$ctr = 0;
        	foreach ($famData_result->result() as $row) {
                $ctr++;  
        		if ($ctr % 2 != 0){
	        		$html .= '<tr>
	                            <td style="border-right: 1px solid #000;width:232px">'.($row->relationship == "Son" ? $row->son_name : $row->daughter_name).'</td>
	                            <td style="border-right: 1px solid #000;width:90px">'.($row->relationship == "Son" ? $row->son_age : $row->daughter_age).'</td>';
                }
                else{
			  		$html .= '<td style="border-right: 1px solid #000;232px">'.($row->relationship == "Son" ? $row->son_name : $row->daughter_name).'</td>
	                            <td style="width:90px;">'.($row->relationship == "Son" ? $row->son_age : $row->daughter_age).'</td>
	                        </tr>';                	
                }
        	} 
        	if ($ctr % 2 != 0){
			  		$html .= '<td style="border-right: 1px solid #000;232px">'.($row->relationship == "Son" ? $row->son_name : $row->daughter_name).'</td>
	                            <td style="width:90px;">'.($row->relationship == "Son" ? $row->son_age : $row->daughter_age).'</td>
	                        </tr>';    
        	}  	
        }

        $vars['children'] = $html;

		//father
        $vars['name_father'] = '';
        $vars['father_age'] = '';
        $vars['father_occupation'] = '';    		
        $query = "SELECT * FROM applicant_personal_history WHERE recruit_id = {$recruit_id} AND relationship = 'Father'";
        $famData_result = $this->db->query($query);
        if ($famData_result && $famData_result->num_rows() > 0){
        	$famData = $famData_result->row();

	        $vars['name_father'] = $famData->father_name;
	        $vars['father_age'] = $famData->father_age;
	        $vars['father_occupation'] = $famData->father_occupation;        	
        }

		//mother
        $vars['name_mother'] = '';
        $vars['mother_age'] = '';
        $vars['mother_occupation'] = '';   		
        $query = "SELECT * FROM applicant_personal_history WHERE recruit_id = {$recruit_id} AND relationship = 'Mother'";
        $famData_result = $this->db->query($query);
        if ($famData_result && $famData_result->num_rows() > 0){
        	$famData = $famData_result->row();

	        $vars['name_mother'] = $famData->mother_name;
	        $vars['mother_age'] = $famData->mother_age;
	        $vars['mother_occupation'] = $famData->mother_occupation;        	
        }

		//brother and sister
		$html = '';
        $query = "SELECT * FROM applicant_personal_history WHERE recruit_id = {$recruit_id} AND relationship IN ('Brother','Sister')";
        $famData_result = $this->db->query($query);
        if ($famData_result && $famData_result->num_rows() > 0){
        	$ctr = 0;
        	foreach ($famData_result->result() as $row) {
                $ctr++;  
        		if ($ctr % 2 != 0){
	        		$html .= '<tr>
	                            <td style="border-right: 1px solid #000;width:25%">'.($row->relationship == "Brother" ? $row->brother_name : $row->sister_name).'</td>
	                            <td style="border-right: 1px solid #000;width:10%">'.($row->relationship == "Brother" ? $row->brother_age : $row->sister_age).'</td>
	                            <td style="width: 15%;border-right: 1px solid #000;">'.($row->relationship == "Brother" ? $row->brother_occupation : $row->sister_occupation).'</td>';
                }
                else{
			  		$html .= '<td style="border-right: 1px solid #000;25%">'.($row->relationship == "Brother" ? $row->brother_name : $row->sister_name).'</td>
	                          <td style="width:8%;">'.($row->relationship == "Brother" ? $row->brother_age : $row->sister_age).'</td>
	                          <td style="width: 17%;border-right: 1px solid #000;">'.($row->relationship == "Brother" ? $row->brother_occupation : $row->sister_occupation).'</td>
	                        </tr>';                	
                }
        	} 
        	if ($ctr % 2 != 0){
			  		$html .= '<td style="border-right: 1px solid #000;25%">'.($row->relationship == "Brother" ? $row->brother_name : $row->sister_name).'</td>
	                          <td style="width:8%;">'.($row->relationship == "Brother" ? $row->brother_age : $row->sister_age).'</td>
	                          <td style="width: 17%;border-right: 1px solid #000;">'.($row->relationship == "Brother" ? $row->brother_occupation : $row->sister_occupation).'</td>
	                        </tr>';    
        	}  	
        }

        $vars['brother_sister'] = $html;

	    //Education
		$education_tab = array();
		$educational_tab = array();
		$education_tab = $this->get_recruitment_personal_value_history($recruit_id, 'education');
		foreach($education_tab as $educ){
			$educational_tab[$educ['sequence']][$educ['key']] = $educ['key_value'];
		}
		$vars['education_tab'] = '';
	    foreach($educational_tab as $index => $education){  
	        $count_education++;
	        if(strtolower($education['education-status']) == "graduated"){
	        	$graduated = "Yes";
	        }else{
	        	$graduated = "No, ".$education['education-lastsem-attended'];
	        }
		    $vars['education_tab'] .= '<tr>
                <td style="border-right: 1px solid #000;">'.$education["education-type"].'</td>
                <td style="border-right: 1px solid #000;">'.$education["education-school"].'</td>
                <td style="border-right: 1px solid #000;">'.$education["education-year-from"].'</td>
                <td style="border-right: 1px solid #000;">'.$education["education-year-to"].'</td>
                <td style="border-right: 1px solid #000;">'.$education["education-status"].'</td>
                <td style="">'.$education["education-honors_awards"].'</td>
            </tr>';
    	}

    	//Employment
		$employment_tab = array();
		$employments_tab = array();
		$employment_tab = $this->get_recruitment_personal_value_history($recruit_id, 'employment');
		foreach($employment_tab as $emp){
			$employments_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
		}

		$vars['employment_tab'] = '';
	    foreach($employments_tab as $index => $employment){ 
	        $count_employment++;
	        $no_years = $employment["employment-year-end"] - $employment["employment-year-hired"];
	        $no_months = date("m", strtotime($employment["employment-month-hired"])) - date("m", strtotime($employment["employment-month-end"]));
	        if (count($employments_tab) != $count_employment){
				$vars['employment_tab'] .= '<tr>
	                <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;">'.$employment["employment-company"].'</td>
	                <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;">'.$employment["employment-position-title"].'</td>
	                <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;">'.$employment["employment-month-hired"].' '.$employment["employment-year-hired"].'</td>
	                <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;">'.$employment["employment-month-end"].' '.$employment["employment-year-end"].'</td>
	                <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;">'.$no_years.' / '.$no_months.'</td>
	                <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;">'.$employment["employment-last-salary"].'</td>
	                <td style="border-bottom: 1px solid #000;">'.$employment["employment-reason-for-leaving"].'</td>
	            </tr> ';	        	
	        }
	        else{
				$vars['employment_tab'] .= '<tr>
	                <td style="border-right: 1px solid #000;">'.$employment["employment-company"].'</td>
	                <td style="border-right: 1px solid #000;">'.$employment["employment-position-title"].'</td>
	                <td style="border-right: 1px solid #000;">'.$employment["employment-month-hired"].' '.$employment["employment-year-hired"].'</td>
	                <td style="border-right: 1px solid #000;">'.$employment["employment-month-end"].' '.$employment["employment-year-end"].'</td>
	                <td style="border-right: 1px solid #000;">'.$no_years.' / '.$no_months.'</td>
	                <td style="border-right: 1px solid #000;">'.$employment["employment-last-salary"].'</td>
	                <td style="">'.$employment["employment-reason-for-leaving"].'</td>
	            </tr> ';
	        }
	    }

	    //skills
		$skill_tabs = array();
		$skill_tab = $this->get_recruitment_personal_value_history($recruit_id, 'skill');
		foreach($skill_tab as $skill){
			if ($skill['key'] == 'skill-name'){
				array_push($skill_tabs, $skill['key_value']);
			}
		}

		$skills = '';
		if (!empty($skill_tabs)){
			$skills = implode(',', $skill_tabs);
		}

		$vars['skills'] = $skills;

    	//Training
		$training_tab = array();
		$trainings_tab = array();
		$training_tab = $this->get_recruitment_personal_value_history($recruit_id, 'training');
		foreach($training_tab as $emp){
			$trainings_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
		}

		$vars['training_tab'] = '';
		$count_training = 0;
	    foreach($trainings_tab as $index => $training){ 
	        $count_training++;
	        if (count($trainings_tab) != $count_training){
				$vars['training_tab'] .= '<tr>
	                <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;">'.$training["training-title"].'</td>
	                <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;">'.$training["training-venue"].'</td>
	                <td style="border-bottom: 1px solid #000;">'.$training["training-start-month"].' '.$training["training-start-year"].' to '.$training["training-end-month"].' '.$training["training-end-year"].'</td>
	            </tr> ';
	        }
	        else{
				$vars['training_tab'] .= '<tr>
	                <td style="border-right: 1px solid #000;">'.$training["training-title"].'</td>
	                <td style="border-right: 1px solid #000;">'.$training["training-venue"].'</td>
	                <td style="">'.$training["training-start-month"].' '.$training["training-start-year"].' to '.$training["training-end-month"].' '.$training["training-end-year"].'</td>
	            </tr> ';
	        }
	    }

    	//Affiliation
		$affiliation_tab = array();
		$affiliations_tab = array();
		$affiliation_tab = $this->get_recruitment_personal_value_history($recruit_id, 'affiliation');
		foreach($affiliation_tab as $emp){
			$affiliations_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
		}

		$vars['affiliation_tab'] = '';
		$count_affiliation = 0;
	    foreach($affiliations_tab as $index => $affiliation){ 
	        $count_affiliation++;
	        if (count($affiliations_tab) != $count_affiliation){
				$vars['affiliation_tab'] .= '<tr>
	                <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;">'.$affiliation["affiliation-name"].'</td>
	                <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;">'.$affiliation["affiliation-position"].'</td>
	                <td style="border-bottom: 1px solid #000;">'.$affiliation["affiliation-month-start"].' '.$affiliation["affiliation-year-start"].' to '.$affiliation["affiliation-month-end"].' '.$affiliation["affiliation-year-end"].'</td>
	            </tr> ';
	        }
	        else{
				$vars['affiliation_tab'] .= '<tr>
	                <td style="border-right: 1px solid #000;">'.$affiliation["affiliation-name"].'</td>
	                <td style="border-right: 1px solid #000;">'.$affiliation["affiliation-position"].'</td>
	                <td style="">'.$affiliation["affiliation-month-start"].' '.$affiliation["affiliation-year-start"].' to '.$affiliation["affiliation-month-end"].' '.$affiliation["affiliation-year-end"].'</td>
	            </tr> ';
	        }
	    }

    	//Friends and Relatives
		$friend_relative_tab = array();
		$friend_relatives_tab = array();
		$friend_relative_tab = $this->get_recruitment_personal_value_history($recruit_id, 'friends_relatives');
		foreach($friend_relative_tab as $emp){
			$friend_relatives_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
		}

		$vars['friend_relative_tab'] = '';
		$count_friend_relative = 0;

	    foreach($friend_relatives_tab as $index => $friend_relative){ 
	        $count_affiliation++;
	        $emp_name = '';
	        $employee_name = $this->db->get_where('users',array('user_id' => $friend_relative['friend-relative-employee']));
	        if ($employee_name && $employee_name->num_rows() > 0){
	        	$emp_name = $employee_name->row()->full_name;
	        }
	        $vars['friend_relative_tab'] .= '<tr>
                <td style="">&nbsp;</td>
                <td style="border-bottom: 1px solid #000;">'.$emp_name.'</td>
                <td style="">&nbsp;</td>
                <td style="border-bottom: 1px solid #000;">'.$friend_relative['friend-relative-relation'].'</td>
                <td style="">&nbsp;</td>
                <td style="border-bottom: 1px solid #000;">'.$friend_relative['friend-relative-position'].'</td>
                <td style="">&nbsp;</td>
                <td style="border-bottom: 1px solid #000;">'.$friend_relative['friend-relative-dept'].'</td>
                <td style="">&nbsp;</td>
            </tr>';
	    }

    	//Character Reference
		$reference_tab = array();
		$references_tab = array();
		$reference_tab = $this->get_recruitment_personal_value_history($recruit_id, 'reference');
		foreach($reference_tab as $emp){
			$references_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
		}

		$vars['reference_tab'] = '';
		$count_reference = 0;

	    foreach($references_tab as $index => $reference){ 
	        $count_affiliation++;
	        $emp_name = '';
	        $employee_name = $this->db->get_where('users',array('user_id' => $reference['friend-relative-employee']));
	        if ($employee_name && $employee_name->num_rows() > 0){
	        	$emp_name = $employee_name->row()->full_name;
	        }
	        $vars['reference_tab'] .= '<tr>
                <td style="">&nbsp;</td>
                <td style="border-bottom: 1px solid #000;">'.$reference['reference-name'].'</td>
                <td style="">&nbsp;</td>
                <td style="border-bottom: 1px solid #000;">'.$reference['reference-organization'].'</td>
                <td style="">&nbsp;</td>
                <td style="border-bottom: 1px solid #000;">'.$reference['reference-occupation'].'</td>
                <td style="">&nbsp;</td>
                <td style="border-bottom: 1px solid #000;">'.$reference['reference-phone'].'</td>
                <td style="">&nbsp;</td>
            </tr>';
	    }

		$vars['language_dialect'] = $appData->language .' '. $appData->dialect;
		$vars['interests_hobbies'] = $appData->interests_hobbies;
		$vars['machine_operated'] = $appData->machine_operated;
		$vars['driver_license_yes'] = ($appData->driver_license == 1 ? 'X' : '');
		$vars['driver_license_no'] = ($appData->driver_license == 0 ? 'X' : '');
		$vars['driver_type_license_nonpro'] = ($appData->driver_type_license == 1 ? 'X' : '');
		$vars['driver_type_license_pro'] = ($appData->driver_type_license == 2 ? 'X' : '');
		$vars['driver_type_license_student'] = ($appData->driver_type_license == 3 ? 'X' : '');
		$vars['prc_license_yes'] = ($appData->prc_license == 1 ? 'X' : '');
		$vars['prc_license_no'] = ($appData->prc_license == 0 ? 'X' : '');
		$vars['prc_type_license'] = $appData->prc_type_license;
		$vars['prc_license_number'] = $appData->prc_license_no;
		$vars['prc_date_expiration'] = ($appData->prc_date_expiration != '' ? date('F d, Y', strtotime($appData->prc_date_expiration)) : '');
		$vars['illness_question_yes'] = ($appData->illness_question == 1 ? 'X' : '');
		$vars['illness_question_no'] = ($appData->illness_question == 0 ? 'X' : '');
		$vars['illness_yes'] = $appData->illness_yes;
		$vars['trial_court_yes'] = ($appData->trial_court == 'Yes' ? 'X' : '');
		$vars['trial_court_no'] = ($appData->trial_court == 'No' ? 'X' : '');
		$vars['trial_court_aquitted'] = ($appData->trial_court == 'Acquitted' ? 'X' : '');
		$vars['trial_court_found_guilty'] = ($appData->trial_court == 'Found Guilty' ? 'X' : '');

		$how_heard = $this->db->get_where('recruitment_sourcing_tools',array('sourcing_tool_id' => $appData->how_hiring_heard));
		$heard = '';
		if ($how_heard && $how_heard->num_rows() > 0){
			$heard = $how_heard->row()->sourcing_tool;
		}
		$vars['how_heard'] = $heard;
		$vars['work_start'] = $appData->work_start;

		$refered_employee_result = $this->db->get_where('users',array('user_id' => $appData->referred_employee));
		$refered_employee = '';
		if ($refered_employee_result && $refered_employee_result->num_rows() > 0){
			$refered_employee = $refered_employee_result->row()->full_name;
		}
		$vars['refered_employee'] = $refered_employee;

		$reference_tab = array();
		$references_tab = array();
		$reference_tab = $this->get_recruitment_personal_value_history($recruit_id, 'reference');
		foreach($reference_tab as $emp){
			$references_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
		}
		$vars['charref_tab'] = '';
	    foreach($references_tab as $index => $reference){ 
	        $count_reference++;
	        $vars['charref_tab'] .= "<tr style='border: 1px solid #ccc;'>
                <td style='padding-left: 20px; height: 20px;'>{$reference['reference-name']}</td>
                <td>{$reference['reference-relationship']}</td>
                <td>{$reference['reference-occupation']}</td>
                <td>{$reference['reference-employer']}</td>
                <td>{$reference['reference-mobile']}, {$reference['reference-phone']}</td>
            </tr>";
	    }
		// print_r($mobiles);
        // $pdata['query'] = $this->db->query($query);
        $this->load->helper('file');
		$this->load->library('parser');
		$this->parser->set_delimiters('{{', '}}');
		
		$template = $this->db->get_where( 'system_template', array( 'code' => 'APPLICATION-FORM') )->row_array();
		$this->parser->set_delimiters('{{', '}}');
		$html = $this->parser->parse_string($template['body'], $vars, TRUE);
		
        $path = 'uploads/templates/app_info_sheet/pdf/';
        $this->check_path( $path );
        $filename = $path .$recruit_id."-". $applicant_surname. "-"."applicationInfoSheet.pdf";
        // $pdf->writeHTML($html, true, false, false, false, '');
        // $pdf->Output($filename, 'F');  

        $mpdf->WriteHTML($html);
        $mpdf->Output($filename, 'F');

        return $filename;
    }

    //check for duplicate application
  	function check_dupplicate_app($post)
  	{
  		if( is_array($post) )
  		{
  			$email = $post['recruitment']['email'];
  			$lname = $post['recruitment']['lastname'];
  			$fname = $post['recruitment']['firstname'];
  			
  			
		    $recruitment_email = $this->db->get_where('recruitment',"email = '".$email."'");	
		   	if( $recruitment_email->num_rows() > 0 ) {
		   		return true;
		   	}	
		    else {
		    	return false;
		    }	
  		}	
  	}

		
	function _get_list($start, $limit, $search, $filter, $trash = false)
	{
		$data = array();				
		
		$qry = $this->_get_list_cached_query();
		
		if( $trash )
		{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 1";
		}
		else{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 0";	
		}
		
		$qry .= ' '. $filter;
		$qry .= " ORDER BY {$this->db->dbprefix}{$this->table}.{$this->primary_key} DESC ";
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}


}