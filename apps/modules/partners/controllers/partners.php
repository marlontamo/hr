<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Partners extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('partners_model', 'mod');
		parent::__construct();
	}

	function index()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$company = array();
		$company_result = $this->db->get_where('users_company',array('deleted' => 0));
		if ($company_result && $company_result->result() > 0){
			$company = $company_result->result();
		}

		$this->db->order_by('employment_type', 'asc');
		$partners_employment_type = $this->db->get_where('partners_employment_type', array('deleted' => 0));
		$data['employment_types'] = $partners_employment_type->result();
		$data['companys'] = $company;		
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

		$this->response->show_import_button = false;
		if( $this->input->post('page') == 1 )
		{
			$this->load->model('upload_utility_model', 'import');
			if( $this->import->get_templates( $this->mod->mod_id ) )
				$this->response->show_import_button = true;
		}

		$page = $this->input->post('page');
		$search = $this->input->post('search');
		$filter = "";
		$filter_by = $this->input->post('filter_by');
		$filter_value = $this->input->post('filter_value');
		
		if( is_array( $filter_by ) )
		{
			foreach( $filter_by as $filter_by_key => $filter_value )
			{
				if( $filter_value != "" ) {
					if($filter_by_key == "active" || $filter_by_key == "company_id"){
						$filter_by_key = "{$this->db->dbprefix}users.".$filter_by_key;
					}
					$filter .= ' AND '. $filter_by_key .' = "'.$filter_value.'"';	
				}
			}
		}
		else{
			if( $filter_by && $filter_by != "" )
			{
				$filter = ' AND '. $filter_by .' = "'.$filter_value.'"';
			}
			else
			{
				if($filter_value > 0)
					$filter = ' AND employment_type_id = "'.$filter_value.'"';
			}	
		}

		$user = $this->config->item('user');
		//Remove for Optimum(Client)
		// $filter .= " AND `{$this->db->dbprefix}users_profile`.company_id in ({$user['region_companies']})";

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

				if(!$trash)
					$this->_list_options_active( $record, $rec );
				else
					$this->_list_options_trash( $record, $rec );				
				
				$record = array_merge($record, $rec);

				$permission_list['permission'] = $this->permission;
				$record = array_merge($record, $permission_list);
				
				$record['users_profile_photo'] = file_exists(urldecode($record['users_profile_photo'])) ? $record['users_profile_photo'] : "assets/img/avatar.png";         
	            $parts = pathinfo($record['users_profile_photo']);
	            $record['users_profile_photo'] = str_replace($parts['filename'], 'thumbnail/'.$parts['filename'], $record['users_profile_photo']);
				
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
		if( $this->permission['detail'] )
		{
			$rec['detail_url'] = $this->mod->url . '/detail/' . $record['record_id'];
			$rec['options'] .= '<li><a href="'.$rec['detail_url'].'"><i class="fa fa-search"></i>' .lang('common.view').'</a></li>';
		}

		if($this->permission['list']){

			$rec['print_url'] = $this->mod->url . '/print_resume/' . $record['record_id'];
			$rec['options'] .= '<li><a href="'.$rec['print_url'].'"><i class="fa fa-print"></i>Print</a></li>';
		}

		if( $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}	
		
		if( $this->permission['delete'] )
		{
			$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
			$rec['delete_url_javascript'] = "javascript: delete_record(".$record['record_id'].")";
			$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
		}

		if( $record['users_active'] == "No" && $record['blacklisted'] == "")
		{
			$rec['rehire_url'] = $this->mod->url . '/rehire/' . $record['record_id'];
			$rec['options'] .= '<li><a href="'.$rec['rehire_url'].'"><i class="fa fa-reply"></i> Rehire</a></li>';
		}	

	}

	public function print_resume($user_id=0){

		if(!$this->permission['list'])
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
				);
			$this->_ajax_return();
		}

		$data['record']['record_id'] = $user_id;
		$this->load->model('my201_model', 'profile_mod');

		$profile_header_details = $this->profile_mod->get_profile_header_details($user_id);

		$data['location'] = $profile_header_details['location'];
		$data['profile_position'] = $profile_header_details['position'];
		$data['profile_company'] = $profile_header_details['company'];
		$data['date_hired'] = $profile_header_details['effectivity_date'] == "0000-00-00" || $profile_header_details['effectivity_date'] == "" ? "" : date("F d, Y", strtotime($profile_header_details['effectivity_date']));
		$data['resigned_date'] = $profile_header_details['resigned_date'] == "" || $profile_header_details['resigned_date'] == "0000-00-00" ? "Present" : date("F d, Y", strtotime($profile_header_details['resigned_date']));

		$middle_initial = empty($profile_header_details['middlename']) ? " " : " ".ucfirst(substr($profile_header_details['middlename'],0,1)).". ";
		$data['profile_name'] = $profile_header_details['firstname'].$middle_initial.$profile_header_details['lastname'].'&nbsp;'.$profile_header_details['suffix'];
		$data['profile_birthdate'] = date("F d, Y", strtotime($profile_header_details['birth_date']));
		$birth_place = $this->profile_mod->get_partners_personal($user_id, 'birth_place');
		$data['birth_place'] = count($birth_place) == 0 ? " " : $birth_place[0]['key_value'] == "" ? "" : $birth_place[0]['key_value'];
		$civil_status = $this->profile_mod->get_partners_personal($user_id, 'civil_status');
		$data['profile_civil_status'] = count($civil_status) == 0 ? " " : $civil_status[0]['key_value'] == "" ? "" : $civil_status[0]['key_value'];

		//Education
		$education_tab = array();
		$educational_tab = array();
		$education_tab = $this->profile_mod->get_partners_personal_history($user_id, 'education');
		foreach($education_tab as $educ){
			$educational_tab[$educ['sequence']][$educ['key']] = $educ['key_value'];
		}
		$data['education_tab'] = $educational_tab;

		//Employment
		$employment_tab = array();
		$employments_tab = array();
		$employment_tab = $this->profile_mod->get_partners_personal_history($user_id, 'employment');
		foreach($employment_tab as $emp){
			$employments_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
		}
		$data['employment_tab'] = $employments_tab;

		//Trainings and Seminars
		$training_tab = array();
		$trainings_tab = array();
		$training_tab = $this->profile_mod->get_partners_personal_history($user_id, 'training');
		foreach($training_tab as $emp){
			$trainings_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
		}
		$data['training_tab'] = $trainings_tab;

		//Affiliation
		$affiliation_tab = array();
		$affiliations_tab = array();
		$affiliation_tab = $this->profile_mod->get_partners_personal_history($user_id, 'affiliation');
		foreach($affiliation_tab as $emp){
			$affiliations_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
		}
		$data['affiliation_tab'] = $affiliations_tab;

		//Licensure
		$licensure_tab = array();
		$licensures_tab = array();
		$details_data_id = array();
		$licensure_tab = $this->profile_mod->get_partners_personal_history($user_id, 'licensure');
		foreach($licensure_tab as $emp){
			$licensures_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			$details_data_id[$emp['sequence']][$emp['key']] = $emp['personal_id'];
		}
		$data['licensure_tab'] = $licensures_tab;
		$data['details_data_id'] = $details_data_id;

		$filename = $this->export_pdf($data);

		header("Content-type: application/pdf");
		header("Content-Disposition: inline; filename=". $filename[1]);
		@readfile($filename[0]);
	}

	function export_pdf($data)
	{
		$this->load->library('Pdf');
		$user = $this->config->item('user');

		$pdf = new Pdf();
		$pdf->SetTitle('Resume');
		$pdf->SetFontSize(11,true);
		$pdf->SetMargins(20, 20, 20, false);
		$pdf->SetAutoPageBreak(true, 5);
		$pdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );
		$pdf->SetDisplayMode('real', 'default');

		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);

		$pdf->AddPage();

		$html = '<table cellspacing="0" cellpadding="1" border="0">
					<tr>
						<td width="100%" align="center"><hr></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td width="100%" align="center"><b>BIO-DATA</b></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td width="25%">Name</td>
						<td width="5%">:</td>
						<td width="70%">'.$data['profile_name'].'</td>
					</tr>
					<tr>
						<td>Date of Birth</td>
						<td>:</td>
						<td>'.$data['profile_birthdate'].'</td>
					</tr>
					<tr>
						<td>Place of Birth</td>
						<td>:</td>
						<td>'.$data['birth_place'].'</td>
					</tr>
					<tr>
						<td>Civil Status</td>
						<td>:</td>
						<td>'.$data['profile_civil_status'].'</td>
					</tr>
					<tr>
						<td>Educational Attainment</td>
						<td>:</td>
					</tr>
					<tr>
						<td></td>
					</tr>';

		foreach($data['education_tab'] as $row){

			$html .= '<tr>
					  	<td width="5%"></td>
					  	<td width="20%"><b>'.$row['education-type'].'</b></td>
					  	<td width="5%">:</td>
					  	<td width="70%"><b>' .$row['education-school']. '</b></td>
					</tr>';

			if(!empty($row['education-degree'])){		

				$html .= '
						<tr>
							<td width="8%"></td>
							<td width="17%">Degree</td>
							<td width="5%">:</td>
							<td width="70%">' .$row['education-degree']. '</td>
						</tr>';
			}

			$html .= '
					<tr>
						<td width="8%"></td>
						<td width="17%">Status</td>
						<td width="5%">:</td>
						<td width="70%">' .$row['education-status']. '</td>
					</tr>
					<tr>
						<td width="8%"></td>
						<td width="17%">Period</td>
						<td width="5%">:</td>
						<td width="70%">' .$row['education-year-from']. " - " .$row['education-year-to']. '</td>
					</tr>
					<tr>
						<td></td>
					</tr>';
		}

		$html .= '
					<tr>
						<td></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td width="100%"><b><u>WORK EXPERIENCE</u></b></td>
					</tr>
					<tr>
						<td></td>
					</tr>';

		$html .= '<tr>
					<td width="5%"><b>1.</b></td>
				  	<td width="20%"><b>Company</b></td>
				  	<td width="5%">:</td>';
		$html .= '<td><b>' .$data['profile_company']. '</b></td>
				</tr>
				<tr>
					<td width="30%"></td>
					<td width="70%">' .$data['location']. '</td>
				</tr>
				<tr>
					<td width="8%"></td>
					<td width="17%">Designation</td>
					<td width="5%">:</td>
					<td width="70%">' .$data['profile_position']. '</td>
				</tr>
				<tr>
					<td width="8%"></td>
					<td width="17%">Period</td>
					<td width="5%">:</td>
					<td width="70%">' .$data['date_hired']. " - " .$data['resigned_date']. '</td>
				</tr>
				<tr>
					<td></td>
				</tr>';

		$ctr = 2;
		foreach($data['employment_tab'] as $row){

			$html .= '<tr>
						<td width="5%"><b>'.$ctr.'.</b></td>
					  	<td width="20%"><b>Company</b></td>
					  	<td width="5%">:</td>';
			$html .= '<td><b>' .$row['employment-company']. '</b></td>
					</tr>
					<tr>
						<td width="30%"></td>
						<td width="70%">' .$row['employment-location']. '</td>
					</tr>
					<tr>
						<td width="8%"></td>
						<td width="17%">Designation</td>
						<td width="5%">:</td>
						<td width="70%">' .$row['employment-position-title']. '</td>
					</tr>
					<tr>
						<td width="8%"></td>
						<td width="17%">Period</td>
						<td width="5%">:</td>
						<td width="70%">' .$row['employment-month-hired']. " " .$row['employment-year-hired']. " - " .$row['employment-month-end']. " " .$row['employment-year-end']. '</td>
					</tr>
					<tr>
						<td></td>
					</tr>';

			$ctr++;
		}

		$html .= '	<tr>
						<td></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td width="100%"><b><u>TRAINING AND/OR SEMINARS ATTENDED</u></b></td>
					</tr>
					<tr>
						<td></td>
					</tr>';

		foreach($data['training_tab'] as $row){

			$html .= '<tr>
						<td width="4%"></td>
					  	<td width="4%">- </td>';
			$html .= '<td width="92%">' .$row['training-title']. '</td>
					</tr>';
		}

		$html .= '	<tr>
						<td></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td width="100%"><b><u>OTHERS:</u></b></td>
					</tr>
					<tr>
						<td></td>
					</tr>';

		if(!empty($data['affiliation_tab'])){
			$html .= '
				<tr>
					<td width="5%"></td>
					<td width="95%"><b>Affiliation:</b></td>
				</tr>';
		}

		foreach($data['affiliation_tab'] as $row){

			$html .= '<tr>
						<td width="9%"></td>
					  	<td width="4%">- </td>';
			$html .= '<td width="87%">' .$row['affiliation-name']. '</td>
					</tr>';
		}

		if(!empty($data['licensure_tab'])){
			$html .= '
				<tr>
					<td width="5%"></td>
					<td width="95%"><b>Licensure:</b></td>
				</tr>';
		}

		foreach($data['licensure_tab'] as $row){

			$html .= '<tr>
						<td width="9%"></td>
					  	<td width="4%">- </td>';
			$html .= '<td width="87%">' .$row['licensure-title']. '</td>
					</tr>';
		}
						
		$html .= '</table>';

		$this->load->helper('file');
		$path = 'uploads/reports/RESUME/pdf/';
		$this->check_path( $path );
		$file = strtotime(date('Y-m-d H:i:s')) . '-' . 'RESUME' . ".pdf";
		$filename[0] = $path . $file;
		$filename[1] = $file;
		$pdf->writeHTML($html, true, false, false, false, '');
		$pdf->Output($filename[0], 'F');

		return $filename;
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

	function format_phone($phone){
		if(is_numeric($phone)){
			$phone = preg_replace("/[^0-9]/", "", $phone);

			if(strlen($phone) == 7)
				return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
			elseif(strlen($phone) == 11)
				return preg_replace("/([0-9]{4})([0-9]{4})([0-9]{3})/", "$1-$2-$3", $phone);
			else
				return $phone;
		}else{
			return $phone;
		}
	}

	public function detail($user_id=0){
		
		if( !$this->permission['list'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
				);
			$this->_ajax_return();
		}
		$data['record']['record_id'] = $user_id;
		$this->load->model('my201_model', 'profile_mod');
		$profile_header_details = $this->profile_mod->get_profile_header_details($user_id);

		$middle_initial = empty($profile_header_details['middlename']) ? " " : " ".ucfirst(substr($profile_header_details['middlename'],0,1)).". ";
		$data['profile_name'] = $profile_header_details['firstname'].$middle_initial.$profile_header_details['lastname'].'&nbsp;'.$profile_header_details['suffix'];

		// $department = empty($profile_header_details['department']) ? "" : " on ".ucwords(strtolower($profile_header_details['department']));
		$department = empty($profile_header_details['department']) ? "" : " on ".$profile_header_details['department'];
		// $data['profile_position'] = ucwords(strtolower($profile_header_details['position']));
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
		$data['calendar'] = $profile_header_details['calendar'] == "" ? "n/a" : $profile_header_details['calendar'];
		//Employment Information
		$data['status'] = $profile_header_details['employment_status'] == "" ? "n/a" : $profile_header_details['employment_status'];
		$data['type'] = $profile_header_details['employment_type'] == "" ? "n/a" : $profile_header_details['employment_type'];
		$data['job_level'] = $profile_header_details['job_level'] == "" ? "n/a" : $profile_header_details['job_level'];
		$data['classification'] = $profile_header_details['classification'] == "" ? "n/a" : $profile_header_details['classification'];
		$data['date_hired'] = $profile_header_details['effectivity_date'] == "" || $profile_header_details['effectivity_date'] == "0000-00-00" ? "n/a" : date("F d, Y", strtotime($profile_header_details['effectivity_date']));
		$data['regularization_date'] = $profile_header_details['regularization_date'] == "" || $profile_header_details['regularization_date'] == "0000-00-00" ? "n/a" : date("F d, Y", strtotime($profile_header_details['regularization_date']));
		$data['resigned_date'] = $profile_header_details['resigned_date'] == "" ? "n/a" : date("F d, Y", strtotime($profile_header_details['resigned_date']));
		$probationary_date = $this->profile_mod->get_partners_personal($user_id, 'probationary_date');
		$data['probationary_date'] = count($probationary_date) == 0 ? "n/a" : $probationary_date[0]['key_value'] == "" ? "n/a" : date("F d, Y", strtotime($probationary_date[0]['key_value']));
		$original_date_hired = $this->profile_mod->get_partners_personal($user_id, 'original_date_hired');
		$data['original_date_hired'] = count($original_date_hired) == 0 ? "n/a" : $original_date_hired[0]['key_value'] == "" ? "n/a" : date("F d, Y", strtotime($original_date_hired[0]['key_value']));
		$last_probationary = $this->profile_mod->get_partners_personal($user_id, 'last_probationary');
		$data['last_probationary'] = count($last_probationary) == 0 ? "n/a" : $last_probationary[0]['key_value'] == "" ? "n/a" : date("F d, Y", strtotime($last_probationary[0]['key_value']));
		$last_salary_adjustment = $this->profile_mod->get_partners_personal($user_id, 'last_salary_adjustment');
		$data['last_salary_adjustment'] = count($last_salary_adjustment) == 0 ? "n/a" : $last_salary_adjustment[0]['key_value'] == "" ? "n/a" : date("F d, Y", strtotime($last_salary_adjustment[0]['key_value']));
		//Work Assignment
		$reports_to = $profile_header_details['immediate'] == "" ? "n/a" : $this->profile_mod->get_user_details($profile_header_details['immediate']);
		if($reports_to == "n/a"){
			$data['reports_to'] = $reports_to;
		}
		else{
			if(count($reports_to) > 0){
				$reports_to_MI = empty($reports_to['middlename']) ? " " : " ".ucfirst(substr($reports_to['middlename'],0,1)).". ";
				$data['reports_to'] = $reports_to['firstname'].$reports_to_MI.$reports_to['lastname'];
			}else{
				$data['reports_to'] = "n/a";
			}
		}
		$organization = $this->profile_mod->get_partners_personal($user_id, 'organization');
		$data['organization'] = count($organization) == 0 ? "n/a" : $organization[0]['key_value'] == "" ? "n/a" : $organization[0]['key_value'];
		$agency_assignment = $this->profile_mod->get_partners_personal($user_id, 'agency_assignment');
        $data['record']['agency_assignment'] = count($agency_assignment) == 0 ? " " : $agency_assignment[0]['key_value'] == "" ? "" : $agency_assignment[0]['key_value'];   
        $data['project'] = $profile_header_details['project'] == "" ? "n/a" : $profile_header_details['project'];
        $data['start_date'] = $profile_header_details['start_date'] == "" ? "n/a" : date("F d, Y", strtotime($profile_header_details['start_date']));
        $data['end_date'] = $profile_header_details['end_date'] == "" ? "n/a" : date("F d, Y", strtotime($profile_header_details['end_date']));
        $data['division'] = $profile_header_details['division'] == "" ? "n/a" : $profile_header_details['division'];
		$data['department'] = $profile_header_details['department'] == "" ? "n/a" : $profile_header_details['department'];
		$data['group'] = $profile_header_details['group'] == "" ? "n/a" : $profile_header_details['group'];

		/***** CONTACTS TAB *****/
		//Personal Contact
		$address_1 = $this->profile_mod->get_partners_personal($user_id, 'address_1');
		$address_1 = count($address_1) == 0 ? " " : $address_1[0]['key_value'] == "" ? "" : $address_1[0]['key_value'];
        
		$address_2 = $this->profile_mod->get_partners_personal($user_id, 'address_2');
		$address_2 = count($address_2) == 0 ? " " : $address_2[0]['key_value'] == "" ? "" : $address_2[0]['key_value'];
		$city_town = $this->profile_mod->get_partners_personal($user_id, 'city_town');
		$city_town = count($city_town) == 0 ? " " : $city_town[0]['key_value'] == "" ? "" : $city_town[0]['key_value'];
		$data['complete_address'] = $address_1." ".$address_2;		
		$zip_code = $this->profile_mod->get_partners_personal($user_id, 'zip_code');
		$data['zip_code'] = count($zip_code) == 0 ? " " : $zip_code[0]['key_value'] == "" ? "" : $zip_code[0]['key_value'];
		//Emergency Contact
		$emergency_name = $this->profile_mod->get_partners_personal($user_id, 'emergency_name');
		$data['emergency_name'] = count($emergency_name) == 0 ? " " : $emergency_name[0]['key_value'] == "" ? "" : $emergency_name[0]['key_value'];
		$emergency_relationship = $this->profile_mod->get_partners_personal($user_id, 'emergency_relationship');
		$data['emergency_relationship'] = count($emergency_relationship) == 0 ? " " : $emergency_relationship[0]['key_value'] == "" ? "" : $emergency_relationship[0]['key_value'];
		$emergency_phone = $this->profile_mod->get_partners_personal($user_id, 'emergency_phone');
		$data['emergency_phone'] = count($emergency_phone) == 0 ? "n/a" : $emergency_phone[0]['key_value'] == "" ? "n/a" : $emergency_phone[0]['key_value'];
		$emergency_mobile = $this->profile_mod->get_partners_personal($user_id, 'emergency_mobile');
		$data['emergency_mobile'] = count($emergency_mobile) == 0 ? "n/a" : $emergency_mobile[0]['key_value'] == "" ? "n/a" : $emergency_mobile[0]['key_value'];
		$emergency_address = $this->profile_mod->get_partners_personal($user_id, 'emergency_address');
		$data['emergency_address'] = count($emergency_address) == 0 ? " " : $emergency_address[0]['key_value'] == "" ? "" : $emergency_address[0]['key_value'];
		$emergency_city = $this->profile_mod->get_partners_personal($user_id, 'emergency_city');
		$data['emergency_city'] = count($emergency_city) == 0 ? " " : $emergency_city[0]['key_value'] == "" ? "" : $emergency_city[0]['key_value'];
		$emergency_country = $this->profile_mod->get_partners_personal($user_id, 'emergency_country');
		$data['emergency_country'] = count($emergency_country) == 0 ? " " : $emergency_country[0]['key_value'] == "" ? "" : $emergency_country[0]['key_value'];
		$emergency_zip_code = $this->profile_mod->get_partners_personal($user_id, 'emergency_zip_code');
		$data['emergency_zip_code'] = count($emergency_zip_code) == 0 ? " " : $emergency_zip_code[0]['key_value'] == "" ? "" : $emergency_zip_code[0]['key_value'];

        $taxcode = $this->profile_mod->get_partners_personal($user_id, 'taxcode');
        $taxcode_result =  $this->profile_mod->get_taxcode($taxcode);
        $data['record']['taxcode'] = $taxcode_result == "" ? " " : $taxcode_result['taxcode'] == "" ? "" : $taxcode_result['taxcode'];
		$tin_number = $this->profile_mod->get_partners_personal($user_id, 'tin_number');
		$data['record']['tin_number'] = count($tin_number) == 0 ? " " : $tin_number[0]['key_value'] == "" ? "" : $tin_number[0]['key_value'];
		$sss_number = $this->profile_mod->get_partners_personal($user_id, 'sss_number');
		$data['record']['sss_number'] = count($sss_number) == 0 ? " " : $sss_number[0]['key_value'] == "" ? "" : $sss_number[0]['key_value'];			
		$pagibig_number = $this->profile_mod->get_partners_personal($user_id, 'pagibig_number');
		$data['record']['pagibig_number'] = count($pagibig_number) == 0 ? " " : $pagibig_number[0]['key_value'] == "" ? "" : $pagibig_number[0]['key_value'];
		$philhealth_number = $this->profile_mod->get_partners_personal($user_id, 'philhealth_number');
		$data['record']['philhealth_number'] = count($philhealth_number) == 0 ? " " : $philhealth_number[0]['key_value'] == "" ? "" : $philhealth_number[0]['key_value'];
		$bank_number_savings = $this->profile_mod->get_partners_personal($user_id, 'bank_account_number_savings');
		$data['record']['bank_number_savings'] = count($bank_number_savings) == 0 ? " " : $bank_number_savings[0]['key_value'] == "" ? "" : $bank_number_savings[0]['key_value'];
		$bank_number_current = $this->profile_mod->get_partners_personal($user_id, 'bank_account_number_current');
		$data['record']['bank_number_current'] = count($bank_number_current) == 0 ? " " : $bank_number_current[0]['key_value'] == "" ? "" : $bank_number_current[0]['key_value'];
		$bank_account_name = $this->profile_mod->get_partners_personal($user_id, 'bank_account_name');
		$data['record']['bank_account_name'] = count($bank_account_name) == 0 ? " " : $bank_account_name[0]['key_value'] == "" ? "" : $bank_account_name[0]['key_value'];
		$health_care = $this->profile_mod->get_partners_personal($user_id, 'health_care');
		$data['record']['health_care'] = count($health_care) == 0 ? " " : $health_care[0]['key_value'] == "" ? "" : $health_care[0]['key_value'];
			$job_class = $this->profile_mod->get_partners_personal($user_id, 'job_class');
			$data['record']['job_class'] = count($job_class) == 0 ? " " : $job_class[0]['key_value'] == "" ? "" : $job_class[0]['key_value'];
			$employee_grade = $this->profile_mod->get_partners_personal($user_id, 'employee_grade');
			$data['record']['employee_grade'] = count($employee_grade) == 0 ? " " : $employee_grade[0]['key_value'] == "" ? "" : $employee_grade[0]['key_value'];
		$job_rank_level = $this->profile_mod->get_partners_personal($user_id, 'job_rank_level');
        $data['record']['job_rank_level'] = count($job_rank_level) == 0 ? " " : $job_rank_level[0]['key_value'] == "" ? "" : $job_rank_level[0]['key_value'];
        $job_level = $this->profile_mod->get_partners_personal($user_id, 'job_level');
        $data['record']['job_level'] = count($job_level) == 0 ? " " : $job_level[0]['key_value'] == "" ? "" : $job_level[0]['key_value'];      
        $pay_level = $this->profile_mod->get_partners_personal($user_id, 'pay_level');
        $data['record']['pay_level'] = count($pay_level) == 0 ? " " : $pay_level[0]['key_value'] == "" ? "" : $pay_level[0]['key_value'];            
		$pay_set_rates = $this->profile_mod->get_partners_personal($user_id, 'pay_set_rates');
        $data['record']['pay_set_rates'] = count($pay_set_rates) == 0 ? " " : $pay_set_rates[0]['key_value'] == "" ? "" : $pay_set_rates[0]['key_value'];
        $competency_level = $this->profile_mod->get_partners_personal($user_id, 'competency_level');
        $data['record']['competency_level'] = count($competency_level) == 0 ? " " : $competency_level[0]['key_value'] == "" ? "" : $competency_level[0]['key_value'];
        $section = $this->profile_mod->get_partners_personal($user_id, 'section');
		$data['record']['section'] = count($section) == 0 ? " " : $section[0]['key_value'] == "" ? "" : $section[0]['key_value'];	
		/***** PERSONAL TAB *****/
		//Personal
		$gender = $this->profile_mod->get_partners_personal($user_id, 'gender');
		$data['gender'] = count($gender) == 0 ? " " : $gender[0]['key_value'] == "" ? "" : $gender[0]['key_value'];
		$birth_place = $this->profile_mod->get_partners_personal($user_id, 'birth_place');
		$data['birth_place'] = count($birth_place) == 0 ? " " : $birth_place[0]['key_value'] == "" ? "" : $birth_place[0]['key_value'];
		$religion = $this->profile_mod->get_partners_personal($user_id, 'religion');
		$data['religion'] = count($religion) == 0 ? " " : $religion[0]['key_value'] == "" ? "" : $religion[0]['key_value'];
		$nationality = $this->profile_mod->get_partners_personal($user_id, 'nationality');
		$data['nationality'] = count($nationality) == 0 ? " " : $nationality[0]['key_value'] == "" ? "" : $nationality[0]['key_value'];
		//Other Information
		$height = $this->profile_mod->get_partners_personal($user_id, 'height');
		$data['height'] = count($height) == 0 ? " " : $height[0]['key_value'] == "" ? "" : $height[0]['key_value'];
		$weight = $this->profile_mod->get_partners_personal($user_id, 'weight');
		$data['weight'] = count($weight) == 0 ? " " : $weight[0]['key_value'] == "" ? "" : $weight[0]['key_value'];
		$interests_hobbies = $this->profile_mod->get_partners_personal($user_id, 'interests_hobbies');
		$data['interests_hobbies'] = count($interests_hobbies) == 0 ? " " : $interests_hobbies[0]['key_value'] == "" ? "" : $interests_hobbies[0]['key_value'];
		$language = $this->profile_mod->get_partners_personal($user_id, 'language');
		$data['language'] = count($language) == 0 ? " " : $language[0]['key_value'] == "" ? "" : $language[0]['key_value'];
		$dialect = $this->profile_mod->get_partners_personal($user_id, 'dialect');
		$data['dialect'] = count($dialect) == 0 ? " " : $dialect[0]['key_value'] == "" ? "" : $dialect[0]['key_value'];
		$dependents_count = $this->profile_mod->get_partners_personal($user_id, 'dependents_count');
		$data['dependents_count'] = count($dependents_count) == 0 ? " " : $dependents_count[0]['key_value'] == "" ? "" : $dependents_count[0]['key_value'];

		/***** Header Details *****/
		$data['profile_live_in'] = $city_town;
		$countries = $this->profile_mod->get_partners_personal($user_id, 'country');
		$data['profile_country'] = count($countries) == 0 ? " " : $countries[0]['key_value'] == "" ? "" : $countries[0]['key_value'];
		$telephones = array();
		$phone_numbers = $this->profile_mod->get_partners_personal($user_id, 'phone');
		foreach($phone_numbers as $phone){
				if(!empty($phone['key_value'])){
					$telephones[] = $phone['key_value'];
				}
		}
		$data['profile_telephones'] = $telephones;
		$fax = array();
		$fax_numbers = $this->profile_mod->get_partners_personal($user_id, 'fax');
		foreach($fax_numbers as $fax_no){
			if(!empty($fax_no['key_value'])){
				$fax[] = $fax_no['key_value'];
			}
		}
		$data['profile_fax'] = $fax;
		$mobiles = array();
		$mobile_numbers = $this->profile_mod->get_partners_personal($user_id, 'mobile');
		foreach($mobile_numbers as $mobile){
				if(!empty($mobile['key_value'])){
					$mobiles[] = $mobile['key_value'];
				}
		}
		$data['profile_mobiles'] = $mobiles;
		$civil_status = $this->profile_mod->get_partners_personal($user_id, 'civil_status');
		$data['profile_civil_status'] = count($civil_status) == 0 ? " " : $civil_status[0]['key_value'] == "" ? "" : $civil_status[0]['key_value'];
		$spouse = $this->profile_mod->get_partners_personal($user_id, 'spouse');
		$data['profile_spouse'] = count($spouse) == 0 ? " " : $spouse[0]['key_value'] == "" ? "" : $spouse[0]['key_value'];

		$solo_parent = $this->profile_mod->get_partners_personal($user_id, 'solo_parent');
		$data['personal_solo_parent'] = count($solo_parent) == 0 ? " " : $solo_parent[0]['key_value'] == 0 ? "No" : "Yes";

		$home_leave = $this->profile_mod->get_partners_personal($user_id, 'home_leave');
		$data['personal_home_leave'] = count($home_leave) == 0 ? " " : $home_leave[0]['key_value'] == 0 ? "No" : "Yes";		
		/***** HISTORY TAB *****/
		//Education
		$education_tab = array();
		$educational_tab = array();
		$education_tab = $this->profile_mod->get_partners_personal_history($user_id, 'education');
		foreach($education_tab as $educ){
			$educational_tab[$educ['sequence']][$educ['key']] = $educ['key_value'];
		}
		$data['education_tab'] = $educational_tab;
		//Employment
		$employment_tab = array();
		$employments_tab = array();
		$employment_tab = $this->profile_mod->get_partners_personal_history($user_id, 'employment');
		foreach($employment_tab as $emp){
			$employments_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
		}
		$data['employment_tab'] = $employments_tab;
		//Character Reference
		$reference_tab = array();
		$references_tab = array();
		$reference_tab = $this->profile_mod->get_partners_personal_history($user_id, 'reference');
		foreach($reference_tab as $emp){
			$references_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
		}
		$data['reference_tab'] = $references_tab;
		//Licensure
		$licensure_tab = array();
		$licensures_tab = array();
		$details_data_id = array();
		$licensure_tab = $this->profile_mod->get_partners_personal_history($user_id, 'licensure');
		foreach($licensure_tab as $emp){
			$licensures_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			$details_data_id[$emp['sequence']][$emp['key']] = $emp['personal_id'];
		}
		$data['licensure_tab'] = $licensures_tab;
		$data['details_data_id'] = $details_data_id;
		//Trainings and Seminars
		$training_tab = array();
		$trainings_tab = array();
		$training_tab = $this->profile_mod->get_partners_personal_history($user_id, 'training');
		foreach($training_tab as $emp){
			$trainings_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
		}
		$data['training_tab'] = $trainings_tab;
		//Skills
		$skill_tab = array();
		$skills_tab = array();
		$skill_tab = $this->profile_mod->get_partners_personal_history($user_id, 'skill');
		foreach($skill_tab as $emp){
			$skills_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
		}
		$data['skill_tab'] = $skills_tab;
		//Affiliation
		$affiliation_tab = array();
		$affiliations_tab = array();
		$affiliation_tab = $this->profile_mod->get_partners_personal_history($user_id, 'affiliation');
		foreach($affiliation_tab as $emp){
			$affiliations_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
		}
		$data['affiliation_tab'] = $affiliations_tab;
		//Accountabilities
		$accountabilities_tab = array();
		$accountable_tab = array();
		$accountabilities_tab = $this->profile_mod->get_partners_personal_history($user_id, 'accountabilities');
		foreach($accountabilities_tab as $emp){
			$accountable_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
		}

		$data['accountabilities_tab'] = $accountable_tab;
		//Attachments
		$attachment_tab = array();
		$attachments_tab = array();
		$attachment_tab = $this->profile_mod->get_partners_personal_history($user_id, 'attachment');
		foreach($attachment_tab as $emp){
			$attachments_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
		}
		$data['attachment_tab'] = $attachments_tab;
		//Family
		$family_tab = array();
		$families_tab = array();
		$family_tab = $this->profile_mod->get_partners_personal_history($user_id, 'family');
		foreach($family_tab as $emp){
			if($emp['key'] == 'family-dependent'){
				$families_tab[$emp['sequence']][$emp['key']] = $emp['key_value'] == 0 ? "No" : "Yes";
			}else{
				$families_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
		}
		$data['family_tab'] = $families_tab;
		
		$old_id_number = $this->profile_mod->get_partners_personal($user_id, 'old_id_number');
		$data['old_id_number'] = count($old_id_number) == 0 ? " " : $old_id_number[0]['key_value'] == "" ? "" : $old_id_number[0]['key_value'];

		$with_parking = $this->profile_mod->get_partners_personal($user_id, 'with_parking');
		$data['with_parking'] = count($with_parking) == 0 ? " " : $with_parking[0]['key_value'] == 0 ? "No" : "Yes";
		//Movements
		$movements_tab = array();
		$movement_qry = " SELECT  pma.action_id, pma.movement_id, pma.type_id,
							pma.effectivity_date, pma.type, pmc.cause, pma.created_on, pm.remarks
						FROM {$this->db->dbprefix}partners_movement_action pma
						INNER JOIN {$this->db->dbprefix}partners_movement pm 
							ON pma.movement_id = pm.movement_id
						INNER JOIN {$this->db->dbprefix}partners_movement_cause pmc 
							ON pm.due_to_id = pmc.cause_id 
						WHERE pm.status_id = 3 
						AND pma.user_id = {$user_id}";
		$movement_sql = $this->db->query($movement_qry);

		if($movement_sql->num_rows() > 0){
			$movements_tab = $movement_sql->result_array();
		}
		$data['movement_tab'] = $movements_tab;

		$da_tab = array();
		$da_qry = " SELECT  offense,offense_level,sanction,pda.created_on
						FROM {$this->db->dbprefix}partners_disciplinary_action pda
						LEFT JOIN {$this->db->dbprefix}partners_incident pi 
							ON pda.incident_id = pi.incident_id	
						LEFT JOIN {$this->db->dbprefix}partners_offense po 
							ON pi.offense_id = po.offense_id													
						LEFT JOIN {$this->db->dbprefix}partners_offense_sanction pos 
							ON pda.sanction_id = pos.sanction_id
						LEFT JOIN {$this->db->dbprefix}partners_offense_level pol 
							ON pos.offense_level_id = pol.offense_level_id 
						WHERE pi.involved_partners IN ({$user_id})";
		$da_sql = $this->db->query($da_qry);

		if($da_sql->num_rows() > 0){
			$da_tab = $da_sql->result_array();
		}
		$data['da_tab'] = $da_tab;

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

		$this->load->helper('file');
		$this->load->vars($data);
		echo $this->load->blade('edit.detail_custom')->with( $this->load->get_cached_vars() );
	}

	function view_personal_details(){
		$this->_ajax_only();

		//Attachments
		$details = array();
		$details_data = array();
		$details_data_id = array();
		
			$details = $this->mod->get_partners_personal_list_details($this->input->post('record_id'), $this->input->post('key_class'), $this->input->post('sequence'));
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

	function download_file($personal_id){	
		$this->load->model('my201_model', 'profile_mod');	
		$image_details = $this->profile_mod->get_partners_personal_image_details($this->user->user_id, $personal_id);
		$path = base_url() . $image_details['key_value'];
		
		header('Content-disposition: attachment; filename='.substr( $image_details['key_value'], strrpos( $image_details['key_value'], '/' )+1 ).'');
		header('Content-type: txt/pdf');
		readfile($path);
	}	


	public function edit( $user_id=0, $rehire=false )
	{
		$record_check = false;
		$this->record_id = $user_id;

		$result = $this->mod->_get_edit_cached_query_custom( $this->record_id );
		$result_personal = $this->mod->_get_edit_cached_query_personal_custom( $this->record_id );

		if( empty($user_id) )
		{
			$field_lists = $result->list_fields();
			foreach( $field_lists as $field )
			{
				$data['record'][$field] = '';
			}
		}
		else{
			$this->load->model('my201_model', 'profile_mod');
			$data['record'] = $result;
			$data['record']['users_profile.photo'] = $data['record']['users_profile.photo'] == "" ? "assets/img/avatar.png" : $data['record']['users_profile.photo'];
			// $data['record']['users_profile.photo'] = file_exists($data['record']['users_profile.photo'] ) ? $data['record']['users_profile.photo'] :"assets/img/avatar.png";
			
			$middle_initial = empty($result['users_profile.middlename']) ? " " : " ".ucfirst(substr($result['users_profile.middlename'],0,1)).". ";
			$data['profile_name'] = $result['users_profile.firstname'].$middle_initial.$result['users_profile.lastname'];
			$birthday = new DateTime($result['users_profile.birth_date']);
			$data['profile_age'] = $birthday->diff(new DateTime)->y;

			$telephones = array();
			$phone_numbers = $this->profile_mod->get_partners_personal($user_id, 'phone');
			foreach($phone_numbers as $phone){
				// $telephones[] = $this->format_phone($phone['key_value']);
				if(!empty($phone['key_value'])){
					$telephones[] = $phone['key_value'];
				}
			}
			$data['profile_telephones'] = $telephones;	
			$fax = array();
			$fax_numbers = $this->profile_mod->get_partners_personal($user_id, 'fax');
			foreach($fax_numbers as $fax_no){
				// $fax[] = $this->format_phone($fax_no['key_value']);
				if(!empty($fax_no['key_value'])){
					$fax[] = $fax_no['key_value'];
				}
			}
			$data['profile_fax'] = $fax;		
			$mobiles = array();
			$mobile_numbers = $this->profile_mod->get_partners_personal($user_id, 'mobile');
			foreach($mobile_numbers as $mobile){
				// $mobiles[] = $this->format_phone($mobile['key_value']);
				if(!empty($mobile['key_value'])){
					$mobiles[] = $mobile['key_value'];
				}
			}
			$data['profile_mobiles'] = $mobiles;
			$city_town = $this->profile_mod->get_partners_personal($user_id, 'city_town');
			$city_town = count($city_town) == 0 ? " " : $city_town[0]['key_value'] == "" ? "" : $city_town[0]['key_value'];
			$data['profile_live_in'] = $city_town;
			$countries = $this->profile_mod->get_partners_personal($user_id, 'country');
			$data['profile_country'] = count($countries) == 0 ? " " : $countries[0]['key_value'] == "" ? "" : $countries[0]['key_value'];
			$civil_status = $this->profile_mod->get_partners_personal($user_id, 'civil_status');
			$data['profile_civil_status'] = count($civil_status) == 0 ? " " : $civil_status[0]['key_value'] == "" ? "" : $civil_status[0]['key_value'];
			$spouse = $this->profile_mod->get_partners_personal($user_id, 'spouse');
			$data['profile_spouse'] = count($spouse) == 0 ? " " : $spouse[0]['key_value'] == "" ? "" : $spouse[0]['key_value'];

			$solo_parent = $this->profile_mod->get_partners_personal($user_id, 'solo_parent');
			$data['personal_solo_parent'] = count($solo_parent) == 0 ? " " : $solo_parent[0]['key_value'] == "" ? "" : $solo_parent[0]['key_value'];

			$home_leave = $this->profile_mod->get_partners_personal($user_id, 'home_leave');
			$data['personal_home_leave'] = count($home_leave) == 0 ? " " : $home_leave[0]['key_value'] == "" ? "" : $home_leave[0]['key_value'];			
				//Personal Contact
			$address_1 = $this->profile_mod->get_partners_personal($user_id, 'address_1');
			$address_1 = count($address_1) == 0 ? " " : $address_1[0]['key_value'] == "" ? "" : $address_1[0]['key_value'];
			$address_2 = $this->profile_mod->get_partners_personal($user_id, 'address_2');
			$address_2 = count($address_2) == 0 ? " " : $address_2[0]['key_value'] == "" ? "" : $address_2[0]['key_value'];
			$data['complete_address'] = $address_1." ".$address_2;	
			$data['address_1'] = $address_1;	
			$data['address_2'] = $address_2;	

			$zip_code = $this->profile_mod->get_partners_personal($user_id, 'zip_code');
			$data['zip_code'] = count($zip_code) == 0 ? " " : $zip_code[0]['key_value'] == "" ? "" : $zip_code[0]['key_value'];
		
			//employment info
			$probationary_date = $this->profile_mod->get_partners_personal($user_id, 'probationary_date');
			$data['record_personal'][1]['partners_personal.probationary_date'] = count($probationary_date) == 0 ? " " : $probationary_date[0]['key_value'] == "" ? "" : date("F d, Y", strtotime($probationary_date[0]['key_value']));
			$original_date_hired = $this->profile_mod->get_partners_personal($user_id, 'original_date_hired');
			$data['record_personal'][1]['partners_personal.original_date_hired'] = count($original_date_hired) == 0 ? " " : $original_date_hired[0]['key_value'] == "" ? "" : date("F d, Y", strtotime($original_date_hired[0]['key_value']));
			$last_probationary = $this->profile_mod->get_partners_personal($user_id, 'last_probationary');
			$data['record_personal'][1]['partners_personal.last_probationary'] = count($last_probationary) == 0 ? " " : $last_probationary[0]['key_value'] == "" ? "" : date("F d, Y", strtotime($last_probationary[0]['key_value']));
			$last_salary_adjustment = $this->profile_mod->get_partners_personal($user_id, 'last_salary_adjustment');
			$data['record_personal'][1]['partners_personal.last_salary_adjustment'] = count($last_salary_adjustment) == 0 ? " " : $last_salary_adjustment[0]['key_value'] == "" ? "" : date("F d, Y", strtotime($last_salary_adjustment[0]['key_value']));
			$organization = $this->profile_mod->get_partners_personal($user_id, 'organization');
			$data['record_personal'][1]['partners_personal.organization'] = count($organization) == 0 ? " " : $organization[0]['key_value'] == "" ? "" : $organization[0]['key_value'];
			//Emergency Contact
			$emergency_name = $this->profile_mod->get_partners_personal($user_id, 'emergency_name');
			$data['emergency_name'] = count($emergency_name) == 0 ? " " : $emergency_name[0]['key_value'] == "" ? "" : $emergency_name[0]['key_value'];
			$emergency_relationship = $this->profile_mod->get_partners_personal($user_id, 'emergency_relationship');
			$data['emergency_relationship'] = count($emergency_relationship) == 0 ? " " : $emergency_relationship[0]['key_value'] == "" ? "" : $emergency_relationship[0]['key_value'];
			$emergency_phone = $this->profile_mod->get_partners_personal($user_id, 'emergency_phone');
			$data['emergency_phone'] = count($emergency_phone) == 0 ? " " : $emergency_phone[0]['key_value'] == "" ? "" : $emergency_phone[0]['key_value'];
			$emergency_mobile = $this->profile_mod->get_partners_personal($user_id, 'emergency_mobile');
			$data['emergency_mobile'] = count($emergency_mobile) == 0 ? " " : $emergency_mobile[0]['key_value'] == "" ? "" : $emergency_mobile[0]['key_value'];
			$emergency_address = $this->profile_mod->get_partners_personal($user_id, 'emergency_address');
			$data['emergency_address'] = count($emergency_address) == 0 ? " " : $emergency_address[0]['key_value'] == "" ? "" : $emergency_address[0]['key_value'];
			$emergency_city = $this->profile_mod->get_partners_personal($user_id, 'emergency_city');
			$data['emergency_city'] = count($emergency_city) == 0 ? " " : $emergency_city[0]['key_value'] == "" ? "" : $emergency_city[0]['key_value'];
			$emergency_country = $this->profile_mod->get_partners_personal($user_id, 'emergency_country');
			$data['emergency_country'] = count($emergency_country) == 0 ? " " : $emergency_country[0]['key_value'] == "" ? "" : $emergency_country[0]['key_value'];
			$emergency_zip_code = $this->profile_mod->get_partners_personal($user_id, 'emergency_zip_code');
			$data['emergency_zip_code'] = count($emergency_zip_code) == 0 ? " " : $emergency_zip_code[0]['key_value'] == "" ? "" : $emergency_zip_code[0]['key_value'];

            $taxcode = $this->profile_mod->get_partners_personal($user_id, 'taxcode');
            $data['record']['taxcode'] = count($taxcode) == 0 ? " " : $taxcode[0]['key_value'] == "" ? "" : $taxcode[0]['key_value'];
			$tin_number = $this->profile_mod->get_partners_personal($user_id, 'tin_number');
			$data['record']['tin_number'] = count($tin_number) == 0 ? " " : $tin_number[0]['key_value'] == "" ? "" : $tin_number[0]['key_value'];
			$sss_number = $this->profile_mod->get_partners_personal($user_id, 'sss_number');
			$data['record']['sss_number'] = count($sss_number) == 0 ? " " : $sss_number[0]['key_value'] == "" ? "" : $sss_number[0]['key_value'];			
			$pagibig_number = $this->profile_mod->get_partners_personal($user_id, 'pagibig_number');
			$data['record']['pagibig_number'] = count($pagibig_number) == 0 ? " " : $pagibig_number[0]['key_value'] == "" ? "" : $pagibig_number[0]['key_value'];
			$philhealth_number = $this->profile_mod->get_partners_personal($user_id, 'philhealth_number');
			$data['record']['philhealth_number'] = count($philhealth_number) == 0 ? " " : $philhealth_number[0]['key_value'] == "" ? "" : $philhealth_number[0]['key_value'];
			$bank_number_savings = $this->profile_mod->get_partners_personal($user_id, 'bank_account_number_savings');
			$data['record']['bank_number_savings'] = count($bank_number_savings) == 0 ? " " : $bank_number_savings[0]['key_value'] == "" ? "" : $bank_number_savings[0]['key_value'];
			$bank_number_current = $this->profile_mod->get_partners_personal($user_id, 'bank_account_number_current');
			$data['record']['bank_number_current'] = count($bank_number_current) == 0 ? " " : $bank_number_current[0]['key_value'] == "" ? "" : $bank_number_current[0]['key_value'];
			$bank_account_name = $this->profile_mod->get_partners_personal($user_id, 'bank_account_name');
			$data['record']['bank_account_name'] = count($bank_account_name) == 0 ? " " : $bank_account_name[0]['key_value'] == "" ? "" : $bank_account_name[0]['key_value'];
			$health_care = $this->profile_mod->get_partners_personal($user_id, 'health_care');
			$data['record']['health_care'] = count($health_care) == 0 ? " " : $health_care[0]['key_value'] == "" ? "" : $health_care[0]['key_value'];
			$job_class = $this->profile_mod->get_partners_personal($user_id, 'job_class');
			$data['record']['job_class'] = count($job_class) == 0 ? " " : $job_class[0]['key_value'] == "" ? "" : $job_class[0]['key_value'];
			$employee_grade = $this->profile_mod->get_partners_personal($user_id, 'employee_grade');
			$data['record']['employee_grade'] = count($employee_grade) == 0 ? " " : $employee_grade[0]['key_value'] == "" ? "" : $employee_grade[0]['key_value'];
			$job_rank_level = $this->profile_mod->get_partners_personal($user_id, 'job_rank_level');
            $data['record']['job_rank_level'] = count($job_rank_level) == 0 ? " " : $job_rank_level[0]['key_value'] == "" ? "" : $job_rank_level[0]['key_value'];	
/*            $job_level = $this->profile_mod->get_partners_personal($user_id, 'job_level');
            $data['record']['job_level'] = count($job_level) == 0 ? " " : $job_level[0]['key_value'] == "" ? "" : $job_level[0]['key_value'];   */
    		$pay_level = $this->profile_mod->get_partners_personal($user_id, 'pay_level');
            $data['record']['pay_level'] = count($pay_level) == 0 ? " " : $pay_level[0]['key_value'] == "" ? "" : $pay_level[0]['key_value'];
            $pay_set_rates = $this->profile_mod->get_partners_personal($user_id, 'pay_set_rates');
            $data['record']['pay_set_rates'] = count($pay_set_rates) == 0 ? " " : $pay_set_rates[0]['key_value'] == "" ? "" : $pay_set_rates[0]['key_value'];   
            $competency_level = $this->profile_mod->get_partners_personal($user_id, 'competency_level');
            $data['record']['competency_level'] = count($competency_level) == 0 ? " " : $competency_level[0]['key_value'] == "" ? "" : $competency_level[0]['key_value'];      
            
            $section = $this->profile_mod->get_partners_personal($user_id, 'section');
    		$data['record']['section'] = count($section) == 0 ? " " : $section[0]['key_value'] == "" ? "" : $section[0]['key_value'];	
			$agency_assignment = $this->profile_mod->get_partners_personal($user_id, 'agency_assignment');
            $data['record']['agency_assignment'] = count($agency_assignment) == 0 ? " " : $agency_assignment[0]['key_value'] == "" ? "" : $agency_assignment[0]['key_value'];   
            /***** PERSONAL TAB *****/

				//Personal
			$gender = $this->profile_mod->get_partners_personal($user_id, 'gender');
			$data['gender'] = count($gender) == 0 ? " " : $gender[0]['key_value'] == "" ? "" : $gender[0]['key_value'];
			$birth_place = $this->profile_mod->get_partners_personal($user_id, 'birth_place');
			$data['birth_place'] = count($birth_place) == 0 ? " " : $gender[0]['key_value'] == "" ? "" : $birth_place[0]['key_value'];
			$religion = $this->profile_mod->get_partners_personal($user_id, 'religion');
			$data['religion'] = count($religion) == 0 ? " " : $religion[0]['key_value'] == "" ? "" : $religion[0]['key_value'];
			$nationality = $this->profile_mod->get_partners_personal($user_id, 'nationality');
			$data['nationality'] = count($nationality) == 0 ? " " : $nationality[0]['key_value'] == "" ? "" : $nationality[0]['key_value'];
				//Other Information
			$height = $this->profile_mod->get_partners_personal($user_id, 'height');
			$data['height'] = count($height) == 0 ? " " : $height[0]['key_value'] == "" ? "" : $height[0]['key_value'];
			$weight = $this->profile_mod->get_partners_personal($user_id, 'weight');
			$data['weight'] = count($weight) == 0 ? " " : $weight[0]['key_value'] == "" ? "" : $weight[0]['key_value'];
			$interests_hobbies = $this->profile_mod->get_partners_personal($user_id, 'interests_hobbies');
			$data['interests_hobbies'] = count($interests_hobbies) == 0 ? " " : $interests_hobbies[0]['key_value'] == "" ? "" : $interests_hobbies[0]['key_value'];
			$language = $this->profile_mod->get_partners_personal($user_id, 'language');
			$data['language'] = count($language) == 0 ? " " : $language[0]['key_value'] == "" ? "" : $language[0]['key_value'];
			$dialect = $this->profile_mod->get_partners_personal($user_id, 'dialect');
			$data['dialect'] = count($dialect) == 0 ? " " : $dialect[0]['key_value'] == "" ? "" : $dialect[0]['key_value'];
			$dependents_count = $this->profile_mod->get_partners_personal($user_id, 'dependents_count');
			$data['dependents_count'] = count($dependents_count) == 0 ? " " : $dependents_count[0]['key_value'] == "" ? "" : $dependents_count[0]['key_value'];

				//Education
			$education_tab = array();
			$educational_tab = array();
			$education_tab = $this->profile_mod->get_partners_personal_history($user_id, 'education');
			foreach($education_tab as $educ){
				$educational_tab[$educ['sequence']][$educ['key']] = $educ['key_value'];
			}
			$data['education_tab'] = $educational_tab;
		//Employment
			$employment_tab = array();
			$employments_tab = array();
			$employment_tab = $this->profile_mod->get_partners_personal_history($user_id, 'employment');
			foreach($employment_tab as $emp){
				$employments_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['employment_tab'] = $employments_tab;
		//Character Reference
			$reference_tab = array();
			$references_tab = array();
			$reference_tab = $this->profile_mod->get_partners_personal_history($user_id, 'reference');
			foreach($reference_tab as $emp){
				$references_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['reference_tab'] = $references_tab;
		//Licensure
			$licensure_tab = array();
			$licensures_tab = array();
			$details_data_id = array();
			$licensure_tab = $this->profile_mod->get_partners_personal_history($user_id, 'licensure');
			foreach($licensure_tab as $emp){
				$licensures_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
				$details_data_id[$emp['sequence']][$emp['key']] = $emp['personal_id'];
			}
			$data['licensure_tab'] = $licensures_tab;
			$data['details_data_id'] = $details_data_id;
		//Trainings and Seminars
			$training_tab = array();
			$trainings_tab = array();
			$training_tab = $this->profile_mod->get_partners_personal_history($user_id, 'training');
			foreach($training_tab as $emp){
				$trainings_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['training_tab'] = $trainings_tab;
		//Skills
			$skill_tab = array();
			$skills_tab = array();
			$skill_tab = $this->profile_mod->get_partners_personal_history($user_id, 'skill');
			foreach($skill_tab as $emp){
				$skills_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['skill_tab'] = $skills_tab;
		//Cost Center
			$cost_center_tab = array();
			$cost_centers_tab = array();
			$cost_center_tab = $this->profile_mod->get_partners_personal_history($user_id, 'cost_center');

			if(!empty($cost_center_tab)){

				foreach($cost_center_tab as $emp){
					
					$cost_centers_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
				}
			}
			else{

				$this->db->select('project_id,project_code');
                $this->db->where('project_id', $data['record']['users_profile.project_id']);
                $this->db->where('deleted', '0');
                $project = $this->db->get('users_project')->result_array();

				if(!empty($project)){

					$cost_centers_tab[1]['cost_center-cost_center'] = $project[0]['project_id'];
					$cost_centers_tab[1]['cost_center-code'] = $project[0]['project_code'];
				}
				else{

					$cost_centers_tab[1]['cost_center-cost_center'] = '';
					$cost_centers_tab[1]['cost_center-code'] = '';
				}

				$cost_centers_tab[1]['cost_center-percentage'] = '';
			}

			$data['cost_center_tab'] = $cost_centers_tab;
		//Affiliation
			$affiliation_tab = array();
			$affiliations_tab = array();
			$affiliation_tab = $this->profile_mod->get_partners_personal_history($user_id, 'affiliation');
			foreach($affiliation_tab as $emp){
				$affiliations_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['affiliation_tab'] = $affiliations_tab;
		//Accountabilities
			$accountabilities_tab = array();
			$accountable_tab = array();
			$accountabilities_tab = $this->profile_mod->get_partners_personal_history($user_id, 'accountabilities');
			foreach($accountabilities_tab as $emp){
				// get department name
				//if($emp['key'] == 'accountabilities-department_id') {
				//	$department = $this->db->get_where('users_department',array('department_id' => $emp['key_value'], 'deleted' => 0))->row();
				//	$accountable_tab[$emp['sequence']]['accountabilities-department'] = $department->department;
				//}
				$accountable_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['accountabilities_tab'] = $accountable_tab;
		//Attachments
			$attachment_tab = array();
			$attachments_tab = array();
			$attachment_tab = $this->profile_mod->get_partners_personal_history($user_id, 'attachment');
			foreach($attachment_tab as $emp){
				$attachments_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['attachment_tab'] = $attachments_tab;
		//Family
			$family_tab = array();
			$families_tab = array();
			$family_tab = $this->profile_mod->get_partners_personal_history($user_id, 'family');
			foreach($family_tab as $emp){
				$families_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['family_tab'] = $families_tab;
		//test profile
			$test_tab = array();
			$tests_tab = array();
			$test_tab = $this->profile_mod->get_partners_personal_history($user_id, 'test');
			foreach($test_tab as $emp){
				$tests_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['test_tab'] = $tests_tab;

			$old_id_number = $this->profile_mod->get_partners_personal($user_id, 'old_id_number');
			$data['old_id_number'] = count($old_id_number) == 0 ? " " : $old_id_number[0]['key_value'] == "" ? "" : $old_id_number[0]['key_value'];
	
			$with_parking = $this->profile_mod->get_partners_personal($user_id, 'with_parking');
			$data['with_parking'] = count($with_parking) == 0 ? " " : $with_parking[0]['key_value'] == "" ? "" : $with_parking[0]['key_value'];
	
		//Movements
			$movements_tab = array();
			$movement_qry = " SELECT  pma.action_id, pma.movement_id, pma.type_id,
								pma.effectivity_date, pma.type, pmc.cause, pma.created_on, pm.remarks
							FROM {$this->db->dbprefix}partners_movement_action pma
							INNER JOIN {$this->db->dbprefix}partners_movement pm 
								ON pma.movement_id = pm.movement_id
							INNER JOIN {$this->db->dbprefix}partners_movement_cause pmc 
								ON pm.due_to_id = pmc.cause_id 
							WHERE pma.status_id = 6 
							AND pma.user_id = {$user_id}";
			$movement_sql = $this->db->query($movement_qry);

			if($movement_sql->num_rows() > 0){
				$movements_tab = $movement_sql->result_array();
			}
			$data['movement_tab'] = $movements_tab;
		}

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

		// Signatory Tab
		$this->load->model('signatories_model', 'signatory');
		$data['signatory_model'] = $this->signatory; //->get_position_signatories( $class_id, $position_id, $department_id, $company_id );
		$data['signatory'] = $this->mod->get_signatories($user_id);


		$this->load->vars( $data );

		$this->load->helper('form');
		$this->load->helper('file');
		if($rehire){
			echo $this->load->blade('edit.rehire.edit_custom')->with( $this->load->get_cached_vars() );
		}else{
			echo $this->load->blade('edit.edit_custom')->with( $this->load->get_cached_vars() );
		}
		
	}

	function add_form() {
		$this->_ajax_only();

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

	public function single_upload()
	{
		$this->_ajax_only();
		define('UPLOAD_DIR', 'uploads/users/');
		$this->load->library("UploadHandler");
		$files = $this->uploadhandler->post();
		$file = $files[0];
		if( isset($file->error) && $file->error != "" )
		{
			$this->response->message[] = array(
				'message' => $file->error,
				'type' => 'error'
			);	
		}
		$this->response->file = $file;
		$this->_ajax_return();
	}

	function save(){
		$error = false;
		$post = $_POST;
		$this->response->record_id = $this->record_id = $post['record_id'];
		unset( $post['record_id'] );
		
        /***** START Form Validation (hard coded) *****/
		//table assignment (manual saving)
		$other_tables = array();
		$partners_personal = array();
		$validation_rules = array();
		$partners_personal_key = array();
		switch($post['fgs_number']){
			case 0:
			$validation_rules[] = 
			array(
				'field' => 'users_profile[title]',
				'label' => 'Title',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'users_profile[lastname]',
				'label' => 'Last Name',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'users_profile[firstname]',
				'label' => 'First Name',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'users_profile[company_id]',
				'label' => 'Company',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'users_profile[department_id]',
				'label' => 'Department',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'users_profile[position_id]',
				'label' => 'Position',
				'rules' => 'required'
				);
            $validation_rules[] = 
            array(
                'field' => 'users_profile[location_id]',
                'label' => 'Location',
                'rules' => 'required'
                );
			$validation_rules[] = 
			array(
				'field' => 'users[role_id]',
				'label' => 'Role',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'partners_personal[gender]',
				'label' => 'Gender',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'users_profile[birth_date]',
				'label' => 'Birthday',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'users_profile[reports_to_id]',
				'label' => 'Reports To',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'partners[id_number]',
				'label' => 'ID Number',
				'rules' => 'required'
				);
/*			$validation_rules[] = 
			array(
				'field' => 'users_profile[project_id]',
				'label' => 'Project',
				'rules' => 'required'
				);*/
			$validation_rules[] = 
			array(
				'field' => 'partners[biometric]',
				'label' => 'Biometric ID',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'partners[shift_id]',
				'label' => 'Schedule',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'users[email]',
				'label' => 'Email',
				'rules' => 'required|valid_email'
				);
			$validation_rules[] = 
			array(
				'field' => 'partners_personal[civil_status]',
				'label' => lang('partners.civil_status'),
				'rules' => 'required'
				);
			$partners_personal_table = "partners_personal";
			$post[$this->mod->table]['login'] = $post['partners']['id_number'];
			$other_tables['users_profile'] = $post['users_profile'];
			$partners_add = $post['partners'];
			$other_tables['users_profile']['birth_date'] = date('Y-m-d', strtotime($post['users_profile']['birth_date']));
			$partners_personal_key = array('gender', 'civil_status');
			$partners_personal = $post['partners_personal'];
			//check if id/biometric number is unique
			$idnumber = trim($post['partners']['id_number']);
			if(strlen($idnumber) > 0){
				$id_number_qry = "SELECT  partner_id, id_number
											FROM {$this->db->dbprefix}partners 
											WHERE id_number = '{$post['partners']['id_number']}' 
											AND deleted = 0;

		       								";
				$idnum_sql = $this->db->query( $id_number_qry );
				$idnum_count = $idnum_sql->num_rows();
				
				if($idnum_count > 0){
					$this->response->message[] = array(
						'message' => "Partner ID number already exist.",
						'type' => 'warning'
					);
	    		$this->_ajax_return();
				}
			}
			$biometric = trim($post['partners']['biometric']);
			if(strlen($biometric) > 0){
				$id_number_qry = "SELECT  partner_id, biometric
											FROM {$this->db->dbprefix}partners 
											WHERE id_number = '{$post['partners']['biometric']}' 
											AND deleted = 0;

		       								";
				$idnum_sql = $this->db->query( $id_number_qry );
				$idnum_count = $idnum_sql->num_rows();
				
				if($idnum_count > 0){
					$this->response->message[] = array(
						'message' => "Partner Biometric number already exist.",
						'type' => 'warning'
					);
	    		$this->_ajax_return();
				}
			}
			break;
			case 1:
				//General Tab
				$validation_rules[] = 
				array(
					'field' => 'users_profile[title]',
					'label' => 'Title',
					'rules' => 'required'
					);
				$validation_rules[] = 
				array(
					'field' => 'users_profile[lastname]',
					'label' => 'Last Name',
					'rules' => 'required'
					);
				$validation_rules[] = 
				array(
					'field' => 'users_profile[firstname]',
					'label' => 'First Name',
					'rules' => 'required'
					);
				$other_tables['users_profile'] = $post['users_profile'];
				break;
			case 2:
				//Employment Tab
				$validation_rules[] = 
				array(
					'field' => 'users_profile[company_id]',
					'label' => 'Company',
					'rules' => 'required'
					);
				$validation_rules[] = 
				array(
					'field' => 'users_profile[location_id]',
					'label' => 'Location',
					'rules' => 'required'
					);
				$validation_rules[] = 
				array(
					'field' => 'users_profile[position_id]',
					'label' => 'Position Title',
					'rules' => 'required'
					);
	            $validation_rules[] = 
	            array(
	                'field' => 'users_profile[location_id]',
	                'label' => 'Location',
	                'rules' => 'required'
	                );
	            $validation_rules[] = 
	            array(
	                'field' => 'users_profile[branch_id]',
	                'label' => 'Branch',
	                'rules' => 'required'
	                );	            
				$validation_rules[] = 
				array(
					'field' => 'users[role_id]',
					'label' => 'Role',
					'rules' => 'required'
					);
				$validation_rules[] = 
				array(
					'field' => 'partners[id_number]',
					'label' => 'ID Number',
					'rules' => 'required'
					);
				$validation_rules[] = 
				array(
					'field' => 'partners[biometric]',
					'label' => 'Biometric Number',
					'rules' => 'required'
					);
				$validation_rules[] = 
				array(
					'field' => 'partners[status_id]',
					'label' => 'Status',
					'rules' => 'required'
					);
				$validation_rules[] = 
				array(
					'field' => 'partners[employment_type_id]',
					'label' => 'Type',
					'rules' => 'required'
					);
				$validation_rules[] = 
				array(
					'field' => 'partners[effectivity_date]',
					'label' => 'Date Hired',
					'rules' => 'required'
					);
				$partners_personal_table = "partners_personal";
				$other_tables['users_profile'] = $post['users_profile'];
				$other_tables['users_profile']['coordinator_id'] = !empty($post['users_profile']['coordinator_id']) ? implode(',', $post['users_profile']['coordinator_id']) : "";
				$other_tables['users_profile']['start_date'] = !empty($post['users_profile']['start_date']) ? date('Y-m-d', strtotime($post['users_profile']['start_date'])) : "";
				$other_tables['users_profile']['end_date'] = !empty($post['users_profile']['end_date']) ? date('Y-m-d', strtotime($post['users_profile']['end_date'])) : "";
				$other_tables['partners'] = $post['partners'];
				$other_tables['partners']['effectivity_date'] = date('Y-m-d', strtotime($post['partners']['effectivity_date']));
				$other_tables['partners']['regularization_date'] = !empty($post['partners']['regularization_date']) ? date('Y-m-d', strtotime($post['partners']['regularization_date'])) : "";

				$status_info = $this->db->get_where( 'partners_employment_status', array( 'employment_status_id' => $other_tables['partners']['status_id']) )->row_array();
				if($status_info && $status_info['active'] == 0){
					$validation_rules[] = 
					array(
						'field' => 'partners[resigned_date]',
						'label' => 'End Date',
						'rules' => 'required'
						);
				}else{
					$post['partners']['resigned_date'] = '';
				}
				$other_tables['partners']['resigned_date'] = (strtotime($post['partners']['resigned_date'])) ? date('Y-m-d', strtotime($post['partners']['resigned_date'])) : '0000-00-00';

				$partners_personal_key = array(
										'login_old' 	=> array_key_exists('old_id_number', $post['partners_personal']) ? $post['partners_personal']['old_id_number'] : null
										);

				$other_tables['users'] = $partners_personal_key;
				$partners_personal_key = array('old_id_number', 'probationary_date', 'original_date_hired', 'last_probationary', 'last_salary_adjustment', 'organization',  'job_class', 'job_rank_level', 'job_level', 'pay_level', 'pay_set_rates', 'competency_level', 'employee_grade', 'section', 'home_leave');
				$partners_personal = $post['partners_personal'];

				//validate if there are existing pending forms
				$record_id_check = $this->input->post('record_id');
				$user_profile_data = $this->input->post('users_profile');
				$new_company_id = $user_profile_data['company_id'];
				$new_department_id = $user_profile_data['department_id'];
				$new_position_id = $user_profile_data['position_id'];
				if($record_id_check > 0){								
					$user_record = $this->db->get_where( 'users_profile', array( $this->mod->primary_key => $record_id_check ) )->row_array();
					if( ($new_company_id != $user_record['company_id']) || ($new_department_id != $user_record['department_id']) || ($new_position_id != $user_record['position_id']) ){
						$select_pending_forms_qry = "SELECT  tr.forms_id, tr.user_id 
											FROM time_forms tr WHERE deleted=0
		       								AND user_id = {$user_record['user_id']}
		       								AND form_status_id IN (2,3,4,5) 
		       								";
						$result_update = $this->db->query( $select_pending_forms_qry );
						$pending_forms_count = $result_update->num_rows();
						
						if($pending_forms_count > 0){
							$is_are = ($pending_forms_count == 1) ? "is" : "are";
							$form_s = ($pending_forms_count == 1) ? "form" : "forms";
							$this->response->message[] = array(
								'message' => "There {$is_are} {$pending_forms_count} pending {$form_s} affected.<br>Please dis/approve {$form_s} before changing the user's company.",
								'type' => 'warning'
							);
		        		// $this->_ajax_return(); // temporary remove - cannot proceed updating 3/9/2016
						}
					}
				}
				//check if id/biometric number is unique
				$idnumber = trim($post['partners']['id_number']);
				if(strlen($idnumber) > 0){
					$id_number_qry = "SELECT  partner_id, id_number
												FROM {$this->db->dbprefix}partners 
												WHERE id_number = '{$post['partners']['id_number']}' 
												AND deleted = 0
												AND user_id != {$this->record_id}
			       								;";
					$idnum_sql = $this->db->query( $id_number_qry );
					$idnum_count = $idnum_sql->num_rows();
					
					if($idnum_count > 0){
						$this->response->message[] = array(
							'message' => "Partner ID number already exist.",
							'type' => 'warning'
						);
		    		$this->_ajax_return();
					}
				}
				$biometric = trim($post['partners']['biometric']);
				if(strlen($biometric) > 0){
					$id_number_qry = "SELECT  partner_id, biometric
												FROM {$this->db->dbprefix}partners 
												WHERE biometric = '{$post['partners']['biometric']}' 
												AND deleted = 0 
												AND user_id != {$this->record_id}
												;";
					$idnum_sql = $this->db->query( $id_number_qry );
					$idnum_count = $idnum_sql->num_rows();
					
					if($idnum_count > 0){
						$this->response->message[] = array(
							'message' => "Partner Biometric number already exist.",
							'type' => 'warning'
						);
		    		$this->_ajax_return();
					}
				}
				break;
			case 3:
				//Contacts Tab
				// $validation_rules[] = 
				// array(
				// 	'field' => 'users[email]',
				// 	'label' => 'Email Address',
				// 	'rules' => 'required|valid_email'
				// 	);
				// $validation_rules[] = 
				// array(
				// 	'field' => 'partners_personal[phone]',
				// 	'label' => 'Phone',
				// 	'rules' => 'numeric'
				// 	);
				// $validation_rules[] = 
				// array(
				// 	'field' => 'partners_personal[mobile]',
				// 	'label' => 'Mobile',
				// 	'rules' => 'numeric'
				// 	);
				// $validation_rules[] = 
				// array(
				// 	'field' => 'partners_personal[emergency_phone]',
				// 	'label' => 'Emergency Contact Phone',
				// 	'rules' => 'numeric'
				// 	);
				// $validation_rules[] = 
				// array(
				// 	'field' => 'partners_personal[emergency_mobile]',
				// 	'label' => 'Emergency Contact Mobile',
				// 	'rules' => 'numeric'
				// 	);
				$partners_personal_table = "partners_personal";
				$partners_personal_key = array('phone', 'mobile', 'address_1', 'city_town', 'country', 'zip_code', 'emergency_name', 'emergency_relationship', 'emergency_phone', 'emergency_mobile', 'emergency_address', 'emergency_city', 'emergency_country', 'emergency_zip_code');
				$partners_personal = $post['partners_personal'];

				$partner_phone = $_POST['partners_personal']['phone'];
				$partner_mobile = $_POST['partners_personal']['mobile'];
				$emergency_phone = $_POST['partners_personal']['emergency_phone'];
				$emergency_mobile = $_POST['partners_personal']['emergency_mobile'];

				unset($partners_personal['mobile']);
				foreach ($partner_mobile as $phone){
					$mobile = $this->check_mobile($phone, $this->record_id);
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
					$mobile = $this->check_phone($phone, $this->record_id);
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
					$mobile = $this->check_mobile($partners_personal['emergency_mobile'], $this->record_id);
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
					$mobile = $this->check_phone($partners_personal['emergency_phone'], $this->record_id);
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
					'field' => 'partners_personal[gender]',
					'label' => 'Gender',
					'rules' => 'required'
					);
				$validation_rules[] = 
				array(
					'field' => 'users_profile[birth_date]',
					'label' => 'Birthday',
					'rules' => 'required'
					);
				$validation_rules[] = 
				array(
					'field' => 'partners_personal[dependents_count]',
					'label' => 'No. of Dependents',
					'rules' => 'numeric'
					);
				$partners_personal_table = "partners_personal";
				$other_tables['users_profile'] = $post['users_profile'];
				$other_tables['users_profile']['birth_date'] = date('Y-m-d', strtotime($post['users_profile']['birth_date']));
				$partners_personal_key = array('gender', 'birth_place', 'religion', 'nationality', 'civil_status', 'height', 'weight', 'interests_hobbies', 'language', 'dialect', 'dependents_count', 'solo_parent', 'with_parking');
				$partners_personal = $post['partners_personal'];
				break;
			case 5:
				//Education Tab
				$validation_rules[] = 
				array(
					'field' => 'partners_personal_history[education-school]',
					'label' => 'School',
					'rules' => 'required'
					);
				$validation_rules[] = 
				array(
					'field' => 'partners_personal_history[education-year-from]',
					'label' => 'Start Year',
					'rules' => 'required|numeric'
					);
				$validation_rules[] = 
				array(
					'field' => 'partners_personal_history[education-year-to]',
					'label' => 'End Year',
					'rules' => 'required|numeric'
					);
				$validation_rules[] = 
				array(
					'field' => 'partners_personal_history[education-status]',
					'label' => 'School',
					'rules' => 'required'
					);
				$partners_personal_table = "partners_personal_history";
				$partners_personal_key = array('education-type', 'education-school', 'education-year-from', 'education-year-to', 'education-degree', 'education-status');
				$partners_personal = $post['partners_personal_history'];
				break;
			case 6:
				//Employment History Tab
				$validation_rules[] = 
				array(
					'field' => 'partners_personal_history[employment-company]',
					'label' => 'Company Name',
					'rules' => 'required'
					);
				$validation_rules[] = 
				array(
					'field' => 'partners_personal_history[employment-position-title]',
					'label' => 'Position Title',
					'rules' => 'required'
					);
				$validation_rules[] = 
				array(
					'field' => 'partners_personal_history[employment-year-hired]',
					'label' => 'Year Hired',
					'rules' => 'numeric'
					);
				$validation_rules[] = 
				array(
					'field' => 'partners_personal_history[employment-year-end]',
					'label' => 'Year End',
					'rules' => 'numeric'
					);
				$partners_personal_table = "partners_personal_history";
				$partners_personal_key = array('employment-company', 'employment-position-title', 'employment-location', 'employment-duties', 'employment-month-hired', 'employment-month-end', 'employment-year-hired', 'employment-year-end');
				$partners_personal = $post['partners_personal_history'];
				break;
			case 7:
				//Character Reference tab
				$validation_rules[] = 
				array(
					'field' => 'partners_personal_history[reference-name]',
					'label' => 'Name',
					'rules' => 'required'
					);
				$validation_rules[] = 
				array(
					'field' => 'partners_personal_history[reference-years-known]',
					'label' => 'Years Known',
					'rules' => 'required|numeric'
					);
				$partners_personal_table = "partners_personal_history";
				$partners_personal_key = array('reference-name', 'reference-occupation', 'reference-years-known', 'reference-phone', 'reference-mobile', 'reference-address', 'reference-city', 'reference-country', 'reference-zipcode');
				$partners_personal = $post['partners_personal_history'];
				break;
			case 8:
				//Licensure tab
				$validation_rules[] = 
				array(
					'field' => 'partners_personal_history[licensure-title]',
					'label' => 'Title',
					'rules' => 'required'
					);
				$validation_rules[] = 
				array(
					'field' => 'partners_personal_history[licensure-year-taken]',
					'label' => 'Year Taken',
					'rules' => 'required|numeric'
					);
				$partners_personal_table = "partners_personal_history";
				$partners_personal_key = array('licensure-title', 'licensure-number', 'licensure-remarks', 'licensure-month-taken', 'licensure-year-taken', 'licensure-attach');
				$partners_personal = $post['partners_personal_history'];
				break;
			case 9:
				//Trainings and Seminars tab
				$validation_rules[] = 
				array(
					'field' => 'partners_personal_history[training-title]',
					'label' => 'Title',
					'rules' => 'required'
					);
				$validation_rules[] = 
				array(
					'field' => 'partners_personal_history[training-venue]',
					'label' => 'Venue',
					'rules' => 'required'
					);
				$validation_rules[] = 
				array(
					'field' => 'partners_personal_history[training-start-year]',
					'label' => 'Year Start',
					'rules' => 'required|numeric'
					);
				$validation_rules[] = 
				array(
					'field' => 'partners_personal_history[training-end-year]',
					'label' => 'Year End',
					'rules' => 'required|numeric'
					);
				$partners_personal_table = "partners_personal_history";
				$partners_personal_key = array('training-category', 'training-title', 'training-venue', 'training-start-month', 'training-start-year', 'training-end-month', 'training-end-year', 'training-remarks');
				$partners_personal = $post['partners_personal_history'];
				break;
			case 10:
				//Skills tab
				// $validation_rules[] = 
				// array(
				// 	'field' => 'partners_personal_history[skill-type]',
				// 	'label' => 'Skill Type',
				// 	'rules' => 'required'
				// 	);
				// $validation_rules[] = 
				// array(
				// 	'field' => 'partners_personal_history[skill-name]',
				// 	'label' => 'Skill Name',
				// 	'rules' => 'required'
				// 	);
				// $validation_rules[] = 
				// array(
				// 	'field' => 'partners_personal_history[skill-level]',
				// 	'label' => 'Proficiency Level',
				// 	'rules' => 'required'
				// 	);
				$partners_personal_table = "partners_personal_history";
				$partners_personal_key = array('skill-type', 'skill-name', 'skill-level', 'skill-remarks');
				$partners_personal = $post['partners_personal_history'];
			break;
			case 11:
			//Affiliation tab
			$validation_rules[] = 
			array(
				'field' => 'partners_personal_history[affiliation-name]',
				'label' => 'Affiliation Name',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'partners_personal_history[affiliation-position]',
				'label' => 'Position',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'partners_personal_history[affiliation-year-start]',
				'label' => 'Year Start',
				'rules' => 'required|numeric'
				);
			$validation_rules[] = 
			array(
				'field' => 'partners_personal_history[affiliation-year-end]',
				'label' => 'Year End',
				'rules' => 'required|numeric'
				);
			$partners_personal_table = "partners_personal_history";
			$partners_personal_key = array('affiliation-name', 'affiliation-position', 'affiliation-month-start', 'affiliation-month-end', 'affiliation-year-start', 'affiliation-year-end');
			$partners_personal = $post['partners_personal_history'];
			break;
			case 12:
			//Accountabilities tab
			//$validation_rules[] = 
			//array(
			//	'field' => 'partners_personal_history[accountabilities-department_id]',
			//	'label' => 'Department',
			//	'rules' => 'required'
			//	);
			$validation_rules[] = 
			array(
				'field' => 'partners_personal_history[accountabilities-name]',
				'label' => 'Item Name',
				'rules' => 'required'
				);
			// $validation_rules[] = 
			// array(
			// 	'field' => 'partners_personal_history[accountabilities-code]',
			// 	'label' => 'Item Code',
			// 	'rules' => 'required'
			// 	);
			$partners_personal_table = "partners_personal_history";
			$partners_personal_key = array(/*'accountabilities-department_id',*/'accountabilities-name', 'accountabilities-code', 'accountabilities-quantity', 'accountabilities-date-issued', 'accountabilities-date-returned', 'accountabilities-remarks', 'accountabilities-attachment');
			$partners_personal = $post['partners_personal_history'];
			break;
			case 13:
			//Accountabilities tab
			//$validation_rules[] = 
			//array(
			//	'field' => 'partners_personal_history[accountabilities-department_id]',
			//	'label' => 'Department',
			//	'rules' => 'required'
			//	);
			$validation_rules[] = 
			array(
				'field' => 'partners_personal_history[attachment-name]',
				'label' => 'Filename',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'partners_personal_history[attachment-file]',
				'label' => 'Upload File',
				'rules' => 'required'
				);
			$partners_personal_table = "partners_personal_history";
			$partners_personal_key = array('attachment-name', 'attachment-file');
			$partners_personal = $post['partners_personal_history'];
			break;
			case 14:
			//Family tab
			$validation_rules[] = 
			array(
				'field' => 'partners_personal_history[family-name]',
				'label' => 'Name',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'partners_personal_history[family-birthdate]',
				'label' => 'Birthday',
				'rules' => 'required'
				);
			$partners_personal_table = "partners_personal_history";
			$partners_personal_key = array('family-relationship', 'family-name', 'family-birthdate', 'family-dependent');
			$partners_personal = (isset($post['partners_personal_history'])) ? $post['partners_personal_history'] : '';
			break;
			case 15:
			//ID numbers
			$partners_personal_table = "partners_personal";
			$partners_personal = $post['partners_personal'];
			$partners_personal_key = array(
                                    'taxcode_id'    => $partners_personal['taxcode'], 
									'sss_no' 	=> $partners_personal['sss_number'], 
									'hdmf_no' 	=> $partners_personal['pagibig_number'], 
									'phic_no' 	=> $partners_personal['philhealth_number'], 
									'tin' 		=> $partners_personal['tin_number']);

			$payroll_partners = $this->db->query("SELECT * FROM ww_payroll_partners WHERE user_id = {$this->record_id}");
			$payroll_partners_result = $payroll_partners->row_array();

			if($payroll_partners_result['account_type_id'] == 1){

				$partners_personal_key['bank_account'] = $partners_personal['bank_account_number_current'];
			}
			elseif($payroll_partners_result['account_type_id'] == 2){

				$partners_personal_key['bank_account'] = $partners_personal['bank_account_number_savings'];
			}

			$other_tables['payroll_partners'] = $partners_personal_key;
			$partners_personal_key = array('taxcode', 'sss_number', 'pagibig_number', 'philhealth_number', 'tin_number', 'bank_account_number_savings', 'bank_account_number_current', 'bank_account_name', 'health_care');
			break;
			case 16:
			//Test Profile tab
			$validation_rules[] = 
			array(
				'field' => 'partners_personal_history[test-title]',
				'label' => 'Title',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'partners_personal_history[test-date-taken]',
				'label' => 'Date Taken',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'partners_personal_history[test-location]',
				'label' => 'Location',
				'rules' => 'required'
				);
			$validation_rules[] = 
			array(
				'field' => 'partners_personal_history[test-score]',
				'label' => 'Score/Rating',
				'rules' => 'required'
				);
			$partners_personal_table = "partners_personal_history";
			$partners_personal_key = array('test-category', 'test-date-taken', 'test-location', 'test-score', 'test-result', 'test-remarks', 'test-attachments', 'test-title');
			$partners_personal = $post['partners_personal_history'];
			break;
			case 17:
				$partners_personal_table = "partners_personal_history";
				$partners_personal_key = array('cost_center-cost_center', 'cost_center-code', 'cost_center-percentage');
				$partners_personal = $post['partners_personal_history'];
			break;
		}

		$partner_details = false;
        if( isset($post['rehire']) && $post['rehire'] == 1 ){
        	if(!isset($status_info['employment_status_id'])){
        		$validation_rules[] = 
				array(
					'field' => 'partners[status_id]',
					'label' => 'Status',
					'rules' => 'required'
					);
        	}
        	

        	$sql_partner_details = $this->db->query("SELECT * FROM `partners` WHERE user_id = {$this->record_id}");
			$partner_result = $sql_partner_details->row_array();

			if(isset($status_info['employment_status_id'])){
		        $partner_details = array('user_id' => $partner_result['user_id'],
		        					'display_name' => $partner_result['alias'],
		        					'from_id' => $partner_result['status_id'],
		        					'to_id' => $status_info['employment_status_id'],
		        					'from_name' => $partner_result['status'],
		        					'to_name' => $status_info['employment_status'],
		        					);
	       	}
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
		$this->partner_id = 0;
		if( $transactions )
		{
			$this->db->trans_begin();
		}

		//start saving with main table
		if(array_key_exists($this->mod->table, $post)){
			$main_record = $post[$this->mod->table];
		
			$record = $this->db->get_where( $this->mod->table, array( $this->mod->primary_key => $this->record_id ) );

			switch( true )
			{
				case $record->num_rows() == 0:
					//add mandatory fields
					$main_record['created_by'] = $this->user->user_id;
					$this->db->insert($this->mod->table, $main_record);
					if($this->db->affected_rows() == 0){
						$this->response->message[] = array(
							'message' => lang('common.inconsistent_data'),
							'type' => 'error'
						);
						$error = true;
						goto stop;
					}

					if( $this->db->_error_message() == "" )
					{
						$this->response->record_id = $this->record_id = $this->db->insert_id();
						$partners_add['user_id'] = $this->record_id;
						$this->db->insert('partners', $partners_add);
						if($this->db->affected_rows() == 0){
							$this->response->message[] = array(
								'message' => lang('common.inconsistent_data'),
								'type' => 'error'
							);
							$error = true;
							goto stop;
						}
						$this->partner_id = $this->db->insert_id();



/*						if(CLIENT_DIR == 'riofil'){
							$system_series = $this->db->get_where('system_series', array('series_code' => 'RIOFIL_ID_NUMBER'))->row();
						}
						elseif(CLIENT_DIR == 'optimum'){

							$company_id = $_POST['users_profile']['company_id'];
            				$company_code = $this->db->get_where('users_company', array('company_id' => $company_id))->row()->company_code;
        					
        					switch($company_code){
        						case 'OSI': $series_code = 'OPTIMUM-OSI_ID_NUMBER'; break;
				        		case 'OEME': $series_code = 'OPTIMUM-OEME_ID_NUMBER'; break;
				        		case 'OIC': $series_code = 'OPTIMUM-OIC_ID_NUMBER'; break;
				        		case 'OTI': $series_code = 'OPTIMUM-OTI_ID_NUMBER'; break;

				        		default : $series_code = 'ID_NUMBER';
        					}

        					$system_series = $this->db->get_where('system_series', array('series_code' => $series_code))->row();
        				}
        				else{
        					$system_series = $this->db->get_where('system_series', array('series_code' => 'AHI_ID_NUMBER'))->row();

        				}*/

						$system_series = $this->db->get_where('system_series', array('series_code' => 'AHI_ID_NUMBER'))->row();

        				if(!(empty($system_series))){
						    // records have been returned
						    $sequence = $system_series->sequence + 1; 
							$this->db->update('system_series',  array('last_sequence' => $idnumber, 'sequence' => $sequence), array('id' => $system_series->id));
						}
						

					}

					//to notify hr payroll newly added employee
					$this->load->model('system_feed');
					$hrpayrolls = $this->db->get_where('users', array('deleted' => 0, 'active' => 1, 'role_id' => 8));
					$user_profile_data = $this->input->post('users_profile');

		            foreach( $hrpayrolls->result() as $hrpayroll )
		            {
		                $feed = array(
		                    'status' => 'info',
			                'message_type' => 'Personnel',
			                'user_id' => $this->user->user_id,
			                'feed_content' => $user_profile_data['lastname'].','.$user_profile_data['firstname'].' was added to partner list.',
			                'uri' => get_mod_route('payroll_employee', '', false). '/add/'.$this->record_id,
		                    'recipient_id' => $hrpayroll->user_id
		                );

		                $recipients = array($hrpayroll->user_id);
		                $this->system_feed->add( $feed, $recipients );
		            
		                $this->response->notify[] = $hrpayroll->user_id;    
		            }

					$this->response->action = 'insert';
					$this->db->trans_complete(); 
					break;
				case $record->num_rows() == 1:
					// insert holiday
					$this->mod->add_to_holiday_location($this->record_id,$post['users_profile']['location_id']);

		        	if( isset($post['rehire']) && $post['rehire'] == 1 ){
		        		$main_record['active'] = 1;
		        	}	

					$main_record['modified_by'] = $this->user->user_id;
					$main_record['modified_on'] = date('Y-m-d H:i:s');
					$this->db->update( $this->mod->table, $main_record, array( $this->mod->primary_key => $this->record_id ) );
					
					$this->response->action = 'update';
					$this->db->trans_complete();
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

		foreach( $other_tables as $table => $data )
		{
			$record = $this->db->get_where( $table, array( $this->mod->primary_key => $this->record_id ) );
			switch( true )
			{
				case $record->num_rows() == 0:
					$data[$this->mod->primary_key] = $this->record_id;
					if($table == 'users_profile'){
						$data['partner_id'] = $this->partner_id;
					}
					$this->db->insert($table, $data);
					if($this->db->affected_rows() == 0){
						$this->response->message[] = array(
							'message' => lang('common.inconsistent_data'),
							'type' => 'error'
						);
						$error = true;
						goto stop;
					}
					$this->record_id = $this->db->insert_id();
					break;
				case $record->num_rows() == 1:
					$this->db->update( $table, $data, array( $this->mod->primary_key => $this->record_id ) );
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
		}

		//personal profile
		if(count($partners_personal_key) > 0){
			// $this->load->model('my201_model', 'profile_mod');
			$sequence = 1;
			$post['fgs_number'];
			$accountabilities_attachments = array(12,13);
			$current_sequence = array_key_exists('sequence', $post) ? $post['sequence'] : 0;

			if(count($partners_personal_key) > 0){
				foreach( $partners_personal_key as $table => $key )
				{
					if(isset($partners_personal[$key]) && !is_array($partners_personal[$key])){
						if( array_key_exists($key, $partners_personal) ){
							$record = $this->mod->get_partners_personal($this->response->record_id , $partners_personal_table, $key, $current_sequence);
							if(in_array($post['fgs_number'], $accountabilities_attachments) && $current_sequence == 0) //insert to personal history
							{
								$sequence = count($record) + 1;
								$record = array();
							}
							$data_personal = array('key_value' => $partners_personal[$key]);
							switch( true )
							{
								case count($record) == 0:
									$data_personal = $this->mod->insert_partners_personal($this->response->record_id, $key, $partners_personal[$key], $sequence, $this->partner_id);
									$this->db->insert($partners_personal_table, $data_personal);
									if($this->db->affected_rows() == 0){
										$this->response->message[] = array(
											'message' => lang('common.inconsistent_data'),
											'type' => 'error'
										);
										$error = true;
										goto stop;
									}
									// $this->record_id = $this->db->insert_id();
									break;
								case count($record) == 1:
									$partner_id = ($this->partner_id == 0) ? $this->mod->get_partner_id($this->response->record_id) : $this->partner_id;
									$where_array = in_array($post['fgs_number'], $accountabilities_attachments) ? array( 'partner_id' => $partner_id, 'key' => $key, 'sequence' => $current_sequence ) : array( 'partner_id' => $partner_id, 'key' => $key );
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
								goto stop;
							}
						}
					}else{
						$sequence = 1;
						$partner_id = ($this->partner_id == 0) ? $this->mod->get_partner_id($this->response->record_id) : $this->partner_id;
						$this->db->delete($partners_personal_table, array( 'partner_id' => $partner_id, 'key' => $key ));
						if( isset($partners_personal[$key] ) && is_array($partners_personal[$key]) )
						{
							foreach( $partners_personal[$key] as $table => $data_personal )
							{	
								$data_personal = $this->mod->insert_partners_personal($this->response->record_id, $key, $data_personal, $sequence, $this->partner_id);
								$this->db->insert($partners_personal_table, $data_personal);
								if($this->db->affected_rows() == 0){
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
								$sequence++;
							}
						}
					}
				}
			}
		}
		
		if( isset($post['rehire']) && $post['rehire'] == 1 ){
			if(is_array($partner_details)){
				$this->mod->create_movement($partner_details, 'EMPSTATUS'); // auto creation of movement	

				if( $this->db->_error_message() != "" ){
					$error = true;
					goto stop;
				}
			
			}
			
			$system_series = $this->db->get_where('system_series', array('series_code' => 'ID_NUMBER'))->row();
			$sequence = $system_series->sequence + 1; 
			$this->db->update('system_series',  array('last_sequence' => $idnumber, 'sequence' => $sequence), array('id' => $system_series->id));

			if( $this->db->_error_message() != "" ){
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


		if( $this->response->saved )
        {
        	$this->load->model('users_model');
        	$this->users_model->_create_config( $this->response->record_id );
        }

        $this->_ajax_return();

	}

	function delete()
	{
		$records = $this->input->post('records');
		$records = explode(',', $records);

		foreach($records as $record){
			$details = $this->mod->get_partners_personal_list_details($this->input->post('record_id'), $this->input->post('key_class'), $record);
		
			foreach($details as $detail){
				$partner_id = $this->mod->get_partner_id($this->input->post('record_id'));
				$this->db->delete('partners_personal_history', array( 'partner_id' => $partner_id, 'personal_id' => $detail['personal_id'] ));
			}
		}


		if( $this->db->_error_message() != "" ){
			$this->response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}
		else{
			$this->response->message[] = array(
				'message' => count($records) . ' record(s) has been deleted.',
				'type' => 'success'
			);
		}

        $this->_ajax_return();
	}

	function delete_partner()
	{
		$records = $this->input->post('records');
		$records = explode(',', $records);
		
		$data['modified_on'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->user->user_id;
		$data['deleted'] = 1;

		$this->db->where_in($this->mod->primary_key, $records);
		$this->db->update($this->mod->table, $data);

		$this->db->where_in($this->mod->primary_key, $records);
		$this->db->update('partners', $data);

		if( $this->db->_error_message() != "" ){
			$this->response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}
		else{
			$this->response->message[] = array(
				'message' => count($records) . ' record(s) has been deleted.',
				'type' => 'success'
			);
		}

        $this->_ajax_return();
	}

    function add_partner()
    {
        $this->_ajax_only();

        if( !$this->permission['add'] && !$this->permission['edit'] )
        {
            $this->response->message[] = array(
                'message' => 'You dont have sufficient permission to get the list of field groups for this module, please notify the System Administrator.',
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        $data = array();

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

        $this->load->helper('form');
        $view['title'] = 'Partner';
        $view['description'] = 'add';

        $series = get_system_series('AHI_ID_NUMBER', '');
        
        $data['series'] = $series;

        $view['content'] = $this->load->view('edit/add_partner_form', $data, true);

        $this->response->add_partner_form = $this->load->view('templates/partner_custom_modal', $view, true);
        
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }

    function account_attach_list(){  
    	
    	$this->_ajax_only();  	
    	$user_id = $this->input->post('record_id');
    	$partner_id = $this->input->post('partner_id');

		$this->load->model('my201_model', 'profile_mod');

		if($partner_id == 12){
			//Accountabilities
			$accountabilities_tab = array();
			$accountable_tab = array();
			$accountabilities_tab = $this->profile_mod->get_partners_personal_history($user_id, 'accountabilities');
			foreach($accountabilities_tab as $emp){
				$accountable_tab[$emp['sequence']][$emp['key']] = $emp['key_value'];
			}
			$data['accountabilities_tab'] = $accountable_tab;
	    	$view['content'] = $this->load->view('edit/forms/accountabilities_list', $data, true);
		}else{ //partner_id == 13
		//Attachments
			$attachment_tab = array();
			$attachments_tab = array();
			$attachment_tab = $this->profile_mod->get_partners_personal_history($user_id, 'attachment');
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

    function get_overview_details(){
    	
    	$this->_ajax_only();  	

		$this->record_id = $user_id = $this->input->post('record_id');

		$result = $this->mod->_get_edit_cached_query_custom( $this->record_id );
		$result_personal = $this->mod->_get_edit_cached_query_personal_custom( $this->record_id );

			$this->load->model('my201_model', 'profile_mod');
			$data['record'] = $result;
			$data['record']['users_profile.photo'] = $data['record']['users_profile.photo'] == "" ? "assets/img/avatar.png" : $data['record']['users_profile.photo'];
			// $data['record']['users_profile.photo'] = file_exists($data['record']['users_profile.photo'] ) ? $data['record']['users_profile.photo'] :"assets/img/avatar.png";
			
			$middle_initial = empty($result['users_profile.middlename']) ? " " : " ".ucfirst(substr($result['users_profile.middlename'],0,1)).". ";
			$data['profile_name'] = $result['users_profile.firstname'].$middle_initial.$result['users_profile.lastname'];
			$birthday = new DateTime($result['users_profile.birth_date']);
			$data['profile_age'] = $birthday->diff(new DateTime)->y;

			$telephones = array();
			$phone_numbers = $this->profile_mod->get_partners_personal($user_id, 'phone');
			foreach($phone_numbers as $phone){
				if(!empty($phone['key_value'])){
					$telephones[] = $phone['key_value'];
				}
			}
			$data['profile_telephones'] = $telephones;	
			$fax = array();
			$fax_numbers = $this->profile_mod->get_partners_personal($user_id, 'fax');
			foreach($fax_numbers as $fax_no){
				if(!empty($fax_no['key_value'])){
					$fax[] = $fax_no['key_value'];
				}
			}
			$data['profile_fax'] = $fax;		
			$mobiles = array();
			$mobile_numbers = $this->profile_mod->get_partners_personal($user_id, 'mobile');
			foreach($mobile_numbers as $mobile){
				if(!empty($mobile['key_value'])){
					$mobiles[] = $mobile['key_value'];
				}
			}
			$data['profile_mobiles'] = $mobiles;
			$city_town = $this->profile_mod->get_partners_personal($user_id, 'city_town');
			$city_town = count($city_town) == 0 ? " " : $city_town[0]['key_value'] == "" ? "" : $city_town[0]['key_value'];
			$data['profile_live_in'] = $city_town;
			$countries = $this->profile_mod->get_partners_personal($user_id, 'country');
			$data['profile_country'] = count($countries) == 0 ? " " : $countries[0]['key_value'] == "" ? "" : $countries[0]['key_value'];
			$civil_status = $this->profile_mod->get_partners_personal($user_id, 'civil_status');
			$data['profile_civil_status'] = count($civil_status) == 0 ? " " : $civil_status[0]['key_value'] == "" ? "" : $civil_status[0]['key_value'];
			$spouse = $this->profile_mod->get_partners_personal($user_id, 'spouse');
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

    function check_mobile($phoneNum=0, $user_id=0){ 	
		$mobileNumber = trim(str_replace(' ', '', $phoneNum));
		$mobileNumber =  str_replace('-', '', $mobileNumber);

		if(!empty($mobileNumber)){
			$country_qry = "SELECT cs.* FROM {$this->db->dbprefix}users_profile up
							INNER JOIN {$this->db->dbprefix}users_company uc ON up.company_id = uc.company_id 
							INNER JOIN {$this->db->dbprefix}countries cs ON uc.country_id = cs.country_id
							WHERE up.user_id = {$user_id}";
			$country_sql = $this->db->query($country_qry)->row_array();
			$countries = $country_sql;

			if ((substr($mobileNumber,0,1) != 0) && strlen($mobileNumber) < 11){
				$mobileNumber = '0'.$mobileNumber;
			}
			$pregs = '/(0|\+?\d{2})(\d{';
			$pregs .= ($countries['mobile_count']-1).',';
			$pregs .= $countries['mobile_count'].'})/';

			$output = preg_replace( $pregs, '0$2', $mobileNumber);

			preg_match( $pregs, $mobileNumber, $matches);

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

		return '+'.$countries['calling_code'].$matches[2];
    }

    function check_phone($phoneNum=0, $user_id=0){
		$mobileNumber = trim(str_replace(' ', '', $phoneNum));
		$mobileNumber =  str_replace('-', '', $mobileNumber);

		if(!empty($mobileNumber)){
			$country_qry = "SELECT cs.* FROM {$this->db->dbprefix}users_profile up
							INNER JOIN {$this->db->dbprefix}users_company uc ON up.company_id = uc.company_id 
							INNER JOIN {$this->db->dbprefix}countries cs ON uc.country_id = cs.country_id
							WHERE up.user_id = {$user_id}";
			$country_sql = $this->db->query($country_qry)->row_array();
			$countries = $country_sql;

			if ((substr($mobileNumber,0,1) != 0) && strlen($mobileNumber) < 9){
				$mobileNumber = '0'.$mobileNumber;
			}
			$pregs = '/(0|\+?\d{2})(\d{';
			$pregs .= ($countries['phone_count']-1).',';
			$pregs .= $countries['phone_count'].'})/';

			$output = preg_replace( $pregs, '0$2', $mobileNumber);
			preg_match( $pregs, $mobileNumber, $matches);

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

		return '+'.$countries['calling_code'].$matches[2];
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
			$data['photo'] = $action_details['photo'];
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
				case 18://Salary Increase
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
				case 17://Develop
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

	function get_employee_id_no()
	{
		$this->_ajax_only();
		if(CLIENT_DIR == 'riofil'){
	        $project_id = $this->input->post('project_id');
	        if(!empty($project_id)) 
	        {
	            $project_code = $this->db->get_where('users_project', array('project_id' => $project_id))->row()->project_code;
	            $series = get_system_series('ID_NUMBER', $project_code);

	            $this->response->id_number = $series;
	            $this->response->message[] = array(
	                'message' => '',
	                'type' => 'success'
	            );
	        } else {
	            $this->response->message[] = array(
	                'message' => 'Project is required to generate ID Number.',
	                'type' => 'error'
	            );
	        }
	    }
        elseif(CLIENT_DIR == 'bayleaf'){
            $location_id = $this->input->post('location_id');
            if(!empty($location_id)) 
            {
                $location_code = $this->db->get_where('users_location', array('location_id' => $location_id))->row()->location_code;
                $series = get_system_series('ID_NUMBER', $location_code);

                $this->response->id_number = $series;
                $this->response->message[] = array(
                    'message' => '',
                    'type' => 'success'
                );
            } else {
                $this->response->message[] = array(
                    'message' => 'Location is required to generate ID Number.',
                    'type' => 'error'
                );
            }
        } else {
            $company_id = $this->input->post('company_id');
            $company_code = $this->db->get_where('users_company', array('company_id' => $company_id))->row()->company_code;
        
            $series = get_system_series('AHI_ID_NUMBER', $company_code);

            $this->response->id_number = $series;
            $this->response->message[] = array(
                'message' => '',
                'type' => 'success'
            );
        }

	    $this->_ajax_return();
	}

	function get_project_code()
	{
		$this->_ajax_only();

        $project_id = $this->input->post('project_id');
        $project_code = $this->db->get_where('users_project', array('project_id' => $project_id))->row()->project_code;

        $this->response->project_code = $project_code;
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

	    $this->_ajax_return();
	}

	function rehire($partner_id = 0)
	{
		$this->edit($partner_id, true);
	}


	function edit_signatory()
	{
		$this->_ajax_only();
		
		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		$this->load->model('signatories_model', 'signatory');

		$data['company_id'] = $this->input->post('company_id');
		$data['department_id'] = $this->input->post('department_id');
		$data['position_id'] = $this->input->post('position_id');
		$data['user_id'] = $this->input->post('user_id');
		$data['set_for'] = $this->input->post('set_for');
		$data['class_id'] = $this->input->post('class_id');
		$data['id'] = $this->input->post('sig_id');

		if( !empty( $data['company_id'] ) )
		{
			$company = $this->db->get_where('users_company', array('company_id' => $data['company_id']))->row();
			$data['company'] = $company->company;
		}
		
		if( !empty( $data['department_id'] ) )
		{
			$department = $this->db->get_where('users_department', array('department_id' => $data['department_id']))->row();
			$data['department'] = $department->department;
		}
		
		if( !empty( $data['position_id'] ) )
		{
			$position = $this->db->get_where('users_position', array('position_id' => $data['position_id']))->row();
			$data['position'] = $position->position;
		}

		if( !empty( $data['class_id'] ) )
		{
			$class = $this->db->get_where('approver_class', array('class_id' => $data['class_id']))->row();
			$data['class'] = $class->class.' ('. $class->class_code.')';
		}


		if( !empty( $data['user_id'] ) )
		{
			$employee = $this->db->get_where('users', array('user_id' => $data['user_id']))->row();
			$data['employee'] = $employee->full_name;
		}

		if($data['class_id'] == 16){ //Change Request
			$data['conditions']  = array(
				"Either Of" => "Either Of"
			);
		}else{
			$data['conditions']  = array(
				"All" => "All",
				"By Level" => "By Level",
				"Either Of" => "Either Of",
			);
		}
		$this->db->select('user_id,full_name');
		$this->db->order_by('full_name');
		$users = $this->db->get_where('users', array('deleted' => 0, 'active' => 1, 'user_id <>' => 1));
		
		$data['users'][''] = 'Select an option';
		foreach( $users->result() as $user )
		{
			$data['users'][$user->user_id] = $user->full_name;
		}

		$signatories = $this->signatory->get_user_signatories( $data['class_id'], $data['user_id'], $data['position_id'], $data['department_id'], $data['company_id']);

		$data['signatories'] = ($signatories) ? $signatories : array();

		$data['signatory'] = $this->signatory->get_user_signatory( $this->input->post('sig_id') );	

		$this->load->helper('form');
		$data['content'] = $this->load->view('edit/edit_signatory_modal', $data, true);
		$data['title'] = 'Signatory Add/Edit';
		$this->response->edit_form = $this->load->view('templates/modal', $data, true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function get_user_signatories()
	{
		$this->_ajax_only();

		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		$this->load->model('signatories_model', 'signatory');

		$class_id = $this->input->post('class_id');
		$user_id = $this->input->post('user_id');
		$position_id = $this->input->post('position_id');
		$company_id = $this->input->post('company_id');
		$department_id = $this->input->post('department_id');

		$signatories = $this->signatory->get_user_signatories( $class_id, $user_id, $position_id, $department_id, $company_id );

		if( $signatories )
		{
			$this->response->signatories = $this->load->view('edit/signatory_list', array('signatories' => $signatories), true);
		}
		else{
			$this->response->signatories = $this->load->view('edit/no_signatory', '', true);
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	public function assign_all(){
		$this->_ajax_only();
		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		$this->load->model('signatories_model', 'signatory');

		$data['company_id'] = $this->input->post('company_id');
		$data['department_id'] = $this->input->post('department_id');
		$data['position_id'] = $this->input->post('position_id');
		$data['user_id'] = $this->input->post('user_id');
		$data['set_for'] = $this->input->post('set_for');
		$data['id'] = $this->input->post('sig_id');

		if( !empty( $data['company_id'] ) )
		{
			$company = $this->db->get_where('users_company', array('company_id' => $data['company_id']))->row();
			$data['company'] = $company->company;
		}

		if( !empty( $data['department_id'] ) )
		{
			$department = $this->db->get_where('users_department', array('department_id' => $data['department_id']))->row();
			$data['department'] = $department->department;
		}
		
		if( !empty( $data['position_id'] ) )
		{
			$position = $this->db->get_where('users_position', array('position_id' => $data['position_id']))->row();
			$data['position'] = $position->position;
		}

		if( !empty( $data['user_id'] ) )
		{
			$employee = $this->db->get_where('users', array('user_id' => $data['user_id']))->row();
			$data['employee'] = $employee->full_name;
		}

		$data['conditions']  = array(
			"All" => "All",
			"By Level" => "By Level",
			"Either Of" => "Either Of",
		);

		$this->db->select('user_id,full_name');
		$this->db->order_by('full_name');
		$users = $this->db->get_where('users', array('deleted' => 0, 'active' => 1, 'user_id <>' => 1));
		
		foreach( $users->result() as $user )
		{
			$data['users'][$user->user_id] = $user->full_name;
		}

		$signatories = $this->signatory->get_users_signatories( $data['user_id'], $data['position_id'], $data['department_id'], $data['company_id']);

		$data['signatories'] = ($signatories) ? $signatories : array();

		$data['signatory'] = $this->signatory->get_users_signatory( $this->input->post('sig_id') );	

		$this->load->helper('form');
		$data['content'] = $this->load->view('edit/edit_assign_all_modal', $data, true);
		$data['title'] = 'Signatory Assign All Add/Edit';
		$this->response->edit_form = $this->load->view('templates/modal', $data, true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function get_users_signatories()
	{
		$this->_ajax_only();

		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		$this->load->model('signatories_model', 'signatory');

		$user_id = $this->input->post('user_id');
		$position_id = $this->input->post('position_id');
		$company_id = $this->input->post('company_id');
		$department_id = $this->input->post('department_id');

		$signatories = $this->signatory->get_users_signatories( $user_id, $position_id, $department_id, $company_id );

		if( $signatories )
		{
			$this->response->signatories = $this->load->view('edit/assign_all_list', array('signatories' => $signatories), true);
		}
		else{
			$this->response->signatories = $this->load->view('edit/no_signatory', '', true);
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	public function push_to_class_users()
	{
		$user_id = $this->input->post('user_id');
		$update = "CALL `sp_approver_assign_all`($user_id)";

		$result_update = $this->db->query( $update );
		mysqli_next_result($this->db->conn_id);

		$this->response->message[] = array(
				'message' => 'Record was successfully saved and/or updated.',
				'type' => 'success'
			);

		$this->_ajax_return();
	}
}


