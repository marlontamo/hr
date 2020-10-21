<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Import201 extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('import201_model', 'mod');
		parent::__construct();
		$this->filename = 'C:\xampp\htdocs\victoria\employee data.xls';
	}

	function import_company(){
		$this->db->truncate('users_company');

		$this->load->library('excel');

		$objReader = new PHPExcel_Reader_Excel5;

		if (!$objReader) {
			show_error('Could not get reader.');
		}

		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($this->filename);
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
	
		$ctr = 0;	
		$import_data = array();

		foreach($rowIterator as $row){
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
			
			$rowIndex = $row->getRowIndex();
			
			// Build the array to insert and check for validation errors as well.
			foreach ($cellIterator as $cell) {
				$import_data[$ctr][] = $cell->getCalculatedValue();
			}

			if ($rowIndex == 1) {

				foreach ($import_data as $row) {
					foreach ($row as $cell => $value) {
						switch ($value) {
							case 'Company':
								$valid_cells[] = 'company';
								break;
							case 'Code':
								$valid_cells[] = 'company_code';
								break;
							case 'Address':
								$valid_cells[] = 'address';
								break;								
							case 'Zipcode':
								$valid_cells[] = 'zipcode';
								break;									
							case 'Telephone':
								$valid_cells_contact[4] = 'telephone';
								break;
							case 'Mobile':
								$valid_cells_contact[5] = 'mobile';
								break;
							case 'Fax No':
								$valid_cells_contact[6] = 'fax_no';
								break;
							case 'VAT Registration':
								$valid_cells[7] = 'vat';
								break;																	
						}
					}
				}

				unset($import_data[$ctr]);
			}

			$ctr++;
		}


		$ctr = 0;

		// Remove non-matching cells.
		foreach ($import_data as $row) {		
			$arr_field_val = array();
			foreach ($valid_cells as $key => $value) {
				if ($value == 'employer_number'){
					$row[$key] = '';
				}
				$arr_field_val[$value] = $row[$key];
			}
			$this->db->insert('users_company',$arr_field_val);
			$company_id = $this->db->insert_id();	

			foreach ($valid_cells_contact as $key => $value) {
				switch ($value) {
					case 'telephone':
						$contact_type = 'Phone';
						break;	
					case 'mobile':
						$contact_type = 'Mobile';
						break;																
					case 'fax_no':
						$contact_type = 'Fax';
						break;						
				}	
				if ($row[$key] != ''){
					$arr_field_val_contact['company_id'] = $company_id;						
					$arr_field_val_contact['contact_no'] = $row[$key];			
					$arr_field_val_contact['contact_type'] = $contact_type;
					$this->db->insert('users_company_contact',$arr_field_val_contact);
				}
			}
		}

		echo "Done.";	
	}


	function import_position(){
		$this->db->truncate('users_position');

		$this->load->library('excel');

		$objReader = new PHPExcel_Reader_Excel5;

		if (!$objReader) {
			show_error('Could not get reader.');
		}

		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($this->filename);
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
	
		$ctr = 0;	
		$import_data = array();

		foreach($rowIterator as $row){
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
			
			$rowIndex = $row->getRowIndex();
			
			// Build the array to insert and check for validation errors as well.
			foreach ($cellIterator as $cell) {
				$import_data[$ctr][] = $cell->getCalculatedValue();
			}

			if ($rowIndex == 1) {

				foreach ($import_data as $row) {
					foreach ($row as $cell => $value) {
						switch ($value) {														
							case 'Position':
								$valid_cells[] = 'position';
								break;
							case 'Code':
								$valid_cells[] = 'position_code';
								break;
							case 'Employee Type':
								$valid_cells[] = 'employee_type_id';
								break;
							case 'Immediate Head':
								$valid_cells[] = 'immediate_id';
								break;																							
						}
					}
				}

				unset($import_data[$ctr]);
			}

			$ctr++;
		}


		$ctr = 0;

		// Remove non-matching cells.
		foreach ($import_data as $row) {		
			$arr_field_val = array();
			foreach ($valid_cells as $key => $value) {
				switch ($value) {
					case 'employee_type_id':
						$result = $this->db->get_where('partners_employment_type',array('employment_type' => $row[$key]));
						if ($result && $result->num_rows() > 0){
							$row_employment_type = $result->row();
							$row[$key] = $row_employment_type->employment_type_id;						
						}
						else{
							$row[$key] = '';
						}
						break;
					case 'immediate_id':
						$result = $this->db->get_where('partners',array('alias' => $row[$key]));
						if ($result && $result->num_rows() > 0){
							$row_partners = $result->row();
							$row[$key] = $row_partners->user_id;						
						}
						else{
							$row[$key] = '';
						}
						break;														
				}			
				$arr_field_val[$value] = $row[$key];
			}

			$this->db->insert('users_position',$arr_field_val);
		}

		echo "Done.";	
	}

	function import_location(){
		$this->db->truncate('users_location');

		$this->load->library('excel');

		$objReader = new PHPExcel_Reader_Excel5;

		if (!$objReader) {
			show_error('Could not get reader.');
		}

		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($this->filename);
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
	
		$ctr = 0;	
		$import_data = array();

		foreach($rowIterator as $row){
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
			
			$rowIndex = $row->getRowIndex();
			
			// Build the array to insert and check for validation errors as well.
			foreach ($cellIterator as $cell) {
				$import_data[$ctr][] = $cell->getCalculatedValue();
			}

			if ($rowIndex == 1) {

				foreach ($import_data as $row) {
					foreach ($row as $cell => $value) {
						switch ($value) {
							case 'Location':
								$valid_cells[] = 'location';
								break;							
						}
					}
				}

				unset($import_data[$ctr]);
			}

			$ctr++;
		}


		$ctr = 0;

		// Remove non-matching cells.
		foreach ($import_data as $row) {		
			$arr_field_val = array();
			foreach ($valid_cells as $key => $value) {						
				$arr_field_val[$value] = $row[$key];
			}

			$this->db->insert('users_location',$arr_field_val);

		}

		echo "Done.";	
	}	

	function import_department(){
		$this->db->truncate('users_department');

		$this->load->library('excel');

		$objReader = new PHPExcel_Reader_Excel5;

		if (!$objReader) {
			show_error('Could not get reader.');
		}

		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($this->filename);
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
	
		$ctr = 0;	
		$import_data = array();

		foreach($rowIterator as $row){
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
			
			$rowIndex = $row->getRowIndex();
			
			// Build the array to insert and check for validation errors as well.
			foreach ($cellIterator as $cell) {
				$import_data[$ctr][] = $cell->getCalculatedValue();
			}

			if ($rowIndex == 1) {

				foreach ($import_data as $row) {
					foreach ($row as $cell => $value) {
						switch ($value) {							
							case 'Department':
								$valid_cells[] = 'department';
								break;							
							case 'Code':
								$valid_cells[] = 'department_code';
								break;
							case 'Immediate Head (id number of employee as immediate head':
								$valid_cells[] = 'immediate_id';
								break;																
						}
					}
				}

				unset($import_data[$ctr]);
			}

			$ctr++;
		}


		$ctr = 0;

		// Remove non-matching cells.
		foreach ($import_data as $row) {		
			$arr_field_val = array();
			foreach ($valid_cells as $key => $value) {	
				switch ($value) {			
					case 'immediate_id':
						$result = $this->db->get_where('partners',array('alias' => $row[$key]));
						if ($result && $result->num_rows() > 0){
							$row_partners = $result->row();
							$row[$key] = $row_partners->user_id;						
						}
						else{
							$row[$key] = '';
						}
						break;														
				}								
				$arr_field_val[$value] = $row[$key];
			}

			$this->db->insert('users_department',$arr_field_val);

		}

		echo "Done.";	
	}		

	function import_section(){
		$this->db->truncate('users_section');

		$this->load->library('excel');

		$objReader = new PHPExcel_Reader_Excel5;

		if (!$objReader) {
			show_error('Could not get reader.');
		}

		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($this->filename);
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
	
		$ctr = 0;	
		$import_data = array();

		foreach($rowIterator as $row){
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
			
			$rowIndex = $row->getRowIndex();
			
			// Build the array to insert and check for validation errors as well.
			foreach ($cellIterator as $cell) {
				$import_data[$ctr][] = $cell->getCalculatedValue();
			}

			if ($rowIndex == 1) {

				foreach ($import_data as $row) {
					foreach ($row as $cell => $value) {
						switch ($value) {
							case 'Section':
								$valid_cells[] = 'section';
								break;							
							case 'Code':
								$valid_cells[] = 'section_code';
								break;							
						}
					}
				}

				unset($import_data[$ctr]);
			}

			$ctr++;
		}


		$ctr = 0;

		// Remove non-matching cells.
		foreach ($import_data as $row) {		
			$arr_field_val = array();
			foreach ($valid_cells as $key => $value) {					
				$arr_field_val[$value] = $row[$key];
			}

			$this->db->insert('users_section',$arr_field_val);
		}

		echo "Done.";	
	}	

	function import_branch(){
		$this->db->truncate('users_branch');

		$this->load->library('excel');

		$objReader = new PHPExcel_Reader_Excel5;

		if (!$objReader) {
			show_error('Could not get reader.');
		}

		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($this->filename);
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
	
		$ctr = 0;	
		$import_data = array();

		foreach($rowIterator as $row){
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
			
			$rowIndex = $row->getRowIndex();
			
			// Build the array to insert and check for validation errors as well.
			foreach ($cellIterator as $cell) {
				$import_data[$ctr][] = $cell->getCalculatedValue();
			}

			if ($rowIndex == 1) {

				foreach ($import_data as $row) {
					foreach ($row as $cell => $value) {
						switch ($value) {
							case 'Branch':
								$valid_cells[] = 'branch';
								break;							
							case 'Branch Code':
								$valid_cells[] = 'branch_code';
								break;							
						}
					}
				}

				unset($import_data[$ctr]);
			}

			$ctr++;
		}


		$ctr = 0;

		// Remove non-matching cells.
		foreach ($import_data as $row) {		
			$arr_field_val = array();
			foreach ($valid_cells as $key => $value) {					
				$arr_field_val[$value] = $row[$key];
			}

			$this->db->insert('users_branch',$arr_field_val);
		}

		echo "Done.";	
	}

	function import_job_level(){
		$this->db->truncate('user_section');

		$this->load->library('excel');

		$objReader = new PHPExcel_Reader_Excel5;

		if (!$objReader) {
			show_error('Could not get reader.');
		}

		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($this->filename);
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
	
		$ctr = 0;	
		$import_data = array();

		foreach($rowIterator as $row){
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
			
			$rowIndex = $row->getRowIndex();
			
			// Build the array to insert and check for validation errors as well.
			foreach ($cellIterator as $cell) {
				$import_data[$ctr][] = $cell->getCalculatedValue();
			}

			if ($rowIndex == 1) {

				foreach ($import_data as $row) {
					foreach ($row as $cell => $value) {
						switch ($value) {
							case 'Job Level':
								$valid_cells[] = 'job_level';
								break;							
							case 'Code':
								$valid_cells[] = 'job_grade_code';
								break;							
						}
					}
				}

				unset($import_data[$ctr]);
			}

			$ctr++;
		}


		$ctr = 0;

		// Remove non-matching cells.
		foreach ($import_data as $row) {		
			$arr_field_val = array();
			foreach ($valid_cells as $key => $value) {					
				$arr_field_val[$value] = $row[$key];
			}

			$this->db->insert('users_job_grade_level',$arr_field_val);
		}

		echo "Done.";	
	}

	function import_shift(){
		$this->db->where('shift_id >',1);
		$this->db->delete('time_shift');
		$this->db->query("ALTER TABLE time_shift AUTO_INCREMENT = 2");
		// $this->db->truncate('timekeeping_shift');

		$this->load->library('excel');

		$objReader = new PHPExcel_Reader_Excel5;

		if (!$objReader) {
			show_error('Could not get reader.');
		}

		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($this->filename);
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
	
		$ctr = 0;	
		$import_data = array();

		foreach($rowIterator as $row){
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
			
			$rowIndex = $row->getRowIndex();
			
			// Build the array to insert and check for validation errors as well.
			foreach ($cellIterator as $cell) {
				$import_data[$ctr][] = $cell->getCalculatedValue();
			}

			if ($rowIndex == 1) {

				foreach ($import_data as $row) {
					foreach ($row as $cell => $value) {
						switch ($value) {
							case 'Company':
								$valid_cells[] = 'company_id';
								break;								
							case 'Shift Name':
								$valid_cells[] = 'shift';
								break;	
							case 'From':
								$valid_cells[] = 'time_start';
								break;
							case 'To':
								$valid_cells[] = 'time_end';
								break;													
						}
					}
				}

				unset($import_data[$ctr]);
			}

			$ctr++;
		}


		$ctr = 0;

		// Remove non-matching cells.
		foreach ($import_data as $row) {		
			$arr_field_val = array();
			foreach ($valid_cells as $key => $value) {
				if ($value == 'time_start' || $value == 'time_end'){
					$row[$key] = PHPExcel_Style_NumberFormat::toFormattedString($row[$key], 'H:i');
					if ($row[$key] == NULL){
						$row[$key] = '';
					}
				}
				elseif ($value == 'company_id'){
					$result = $this->db->get_where('users_company',array('company' => $row[$key]));
					if ($result && $result->num_rows() > 0){
						$row_company = $result->row();
						$row[$key] = $row_company->company_id;						
					}
					else{
						$row[$key] = '';
					}
				}

				$arr_field_val[$value] = $row[$key];
			}

			$this->db->insert('time_shift',$arr_field_val);
		}

		echo "Done.";	
	}	

	function import_employee(){
/*		$this->db->where('employee_id >',3);
		$this->db->delete('user');
		$this->db->query("ALTER TABLE hr_user AUTO_INCREMENT = 4");

		$this->db->truncate('employee');
		$this->db->truncate('employee_dtr_setup');*/

		$this->load->library('excel');

		$objReader = new PHPExcel_Reader_Excel5;

		if (!$objReader) {
			show_error('Could not get reader.');
		}

		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($this->filename);
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
	
		$ctr = 0;	
		$import_data = array();

		foreach($rowIterator as $row){
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
			
			$rowIndex = $row->getRowIndex();
			
			// Build the array to insert and check for validation errors as well.
			foreach ($cellIterator as $cell) {
				$import_data[$ctr][] = $cell->getCalculatedValue();
			}

			if ($rowIndex == 1) {

				foreach ($import_data as $row) {
					foreach ($row as $cell => $value) {
						switch ($value) {
							case '*ID Number':
								$valid_cells_partners[] = 'id_number';
								break;							
							case '*Last Name':
								$valid_cells_users_profile[1] = 'lastname';
								break;								
							case '*First Name':
								$valid_cells_users_profile[2] = 'firstname';
								break;	
							case '*Middle Name':
								$valid_cells_users_profile[3] = 'middlename';
								break;								
							case 'Suffix':
								$valid_cells_users_profile[4] = 'suffix';
								break;
							case 'Maiden Name (if applicable)':
								$valid_cells_users_profile[5] = 'maidenname';
								break;
							case '*System Role':
								$valid_cells_users[6] = 'role_id';
								break;
							case '*Position Title':
								$valid_cells_users_profile[7] = 'position_id';
								break;		
							case 'Job Title':
								$valid_cells_users_profile[8] = 'job_title_id';
								break;	
							case '*Biometrics  ID(Finger Print)':
								$valid_cells_partners[9] = 'biometric';
								break;	
							case '*Company Name':
								$valid_cells_users_profile[10] = 'company_id';
								break;	
							case '*Location':
								$valid_cells_users_profile[11] = 'location_id';
								break;	
							case '*Department':
								$valid_cells_users_profile[12] = 'department_id';
								break;	
							case 'SECTION':
								$valid_cells_users[13] = 'section_id';
								break;	
							case 'Branch':
								$valid_cells_users[14] = 'branch_id';
								break;	
							case 'Employee Type':
								$valid_cells_partners[15] = 'employment_type_id';
								break;	
							case 'Job Level':
								$valid_cells_partners[16] = 'job_grade_id';
								break;																	
							case '*Date Hired':
								$valid_cells_partners[17] = 'effectivity_date';
								break;	
							case 'Original Hired Date':
								$valid_cells_partners[18] = 'original_hired_date';
								break;
							case '*Date of Regularization':
								$valid_cells_partners[19] = 'regularization_date';
								break;
							case '*Employment Status':
								$valid_cells_partners[20] = 'status_id';
								break;	
							case 'Reports To':
								$valid_cells_users_profile[21] = 'reports_to_id';
								break;														
						}
					}
				}

				unset($import_data[$ctr]);
			}

			$ctr++;
		}


/*		dbug($import_data[1]);
		dbug($valid_cells_user);
		dbug($valid_cells_dtr_setup);
		dbug($valid_cells_employee);
		die();*/

		$ctr = 0;
		foreach ($import_data as $row) {		
			$arr_field_val = array();
			foreach ($valid_cells_users as $key => $value) {
				switch ($value) {				
					case 'role_id':
						$result = $this->db->get_where('roles',array('role' => $row[$key]));
						if ($result && $result->num_rows() > 0){
							$row_role = $result->row();
							$row[$key] = $row_role->role_id;						
						}
						else{
							$row[$key] = '';
						}
						break;
					case 'section_id':
						$result = $this->db->get_where('users_section',array('section' => $row[$key]));
						if ($result && $result->num_rows() > 0){
							$row_section = $result->row();
							$row[$key] = $row_section->section_id;						
						}
						else{
							$row[$key] = '';
						}
						break;				
					case 'branch_id':
						$result = $this->db->get_where('users_branch',array('branch' => $row[$key]));
						if ($result && $result->num_rows() > 0){
							$row_branch = $result->row();
							$row[$key] = $row_branch->branch_id;						
						}
						else{
							$row[$key] = '';
						}
						break;
					default:
						if ($row[$key] == ''){
							$row[$key] = '';
						}
						break;												
				}
				$arr_field_val[$value] = $row[$key];
			}

			$this->db->insert('users',$arr_field_val);
			$user_id = $this->db->insert_id();	

			/********************************************************************/
			$arr_field_val = array();
			foreach ($valid_cells_users_profile as $key => $value) {
				switch ($value) {
					case 'shift_calendar_id':
						$result = $this->db->get_where('timekeeping_shift_calendar',array('shift_calendar' => $row[$key]));
						if ($result && $result->num_rows() > 0){
							$row_role = $result->row();
							$row[$key] = $row_role->shift_calendar_id;						
						}
						else{
							$row[$key] = '';
						}
						break;
					case 'position_id':
						$result = $this->db->get_where('users_position',array('position' => $row[$key]));
						if ($result && $result->num_rows() > 0){
							$row_position = $result->row();
							$row[$key] = $row_position->position_id;						
						}
						else{
							$row[$key] = '';
						}
						break;		
					case 'job_title_id':
						$result = $this->db->get_where('users_job_title',array('job_title' => $row[$key]));
						if ($result && $result->num_rows() > 0){
							$row_job_title = $result->row();
							$row[$key] = $row_job_title->job_title_id;						
						}
						else{
							$row[$key] = '';
						}
						break;	
					case 'company_id':
						$result = $this->db->get_where('users_company',array('company' => $row[$key]));
						if ($result && $result->num_rows() > 0){
							$row_company = $result->row();
							$row[$key] = $row_company->company_id;						
						}
						else{
							$row[$key] = '';
						}
						break;
					case 'location_id':
						$result = $this->db->get_where('users_location',array('location' => $row[$key]));
						if ($result && $result->num_rows() > 0){
							$row_location = $result->row();
							$row[$key] = $row_location->location_id;						
						}
						else{
							$row[$key] = '';
						}
						break;	
					case 'department_id':
						$result = $this->db->get_where('users_department',array('department' => $row[$key]));
						if ($result && $result->num_rows() > 0){
							$row_department = $result->row();
							$row[$key] = $row_department->department_id;						
						}
						else{
							$row[$key] = '';
						}
						break;		
					case 'reports_to_id':
						$result = $this->db->get_where('partners',array('id_number' => $row[$key]));
						if ($result && $result->num_rows() > 0){
							$row_partners = $result->row();
							$row[$key] = $row_partners->user_id;						
						}
						else{
							$row[$key] = '';
						}
						break;																																	
				}
				$arr_field_val[$value] = $row[$key];
			}

			$this->db->insert('users_profile',$arr_field_val);	

			/********************************************************************/
			$arr_field_val = array();
			foreach ($valid_cells_partners as $key => $value) {
				switch ($value) {
					case 'employment_type_id':
						$result = $this->db->get_where('partners_employment_type',array('employment_type' => $row[$key]));
						if ($result && $result->num_rows() > 0){
							$row_employment_type = $result->row();
							$row[$key] = $row_employment_type->employment_type_id;						
						}
						else{
							$row[$key] = '';
						}
						break;
					case 'job_grade_id':
						$result = $this->db->get_where('users_job_grade_level',array('job_level' => $row[$key]));
						if ($result && $result->num_rows() > 0){
							$row_job_level = $result->row();
							$row[$key] = $row_job_level->job_grade_id;						
						}
						else{
							$row[$key] = '';
						}
						break;
					case 'status_id':
						$result = $this->db->get_where('partners_employment_status',array('employment_status' => $row[$key]));
						if ($result && $result->num_rows() > 0){
							$row_employment_status = $result->row();
							$row[$key] = $row_employment_status->employment_status_id;						
						}
						else{
							$row[$key] = '';
						}
						break;	
					case 'effectivity_date':
					case 'original_hired_date':
					case 'regularization_date':
						if ($row[$key] != ''){
							$row[$key] = date ( 'Y-m-d', strtotime($row[$key]));
						}
						else{
							$row[$key] = '';
						}
						break;									
				}
				$arr_field_val[$value] = $row[$key];
			}	

			$arr_field_val['user_id'] = $user_id;
			$this->db->insert('partners',$arr_field_val);						
		}

		echo "Done.";	
	}

	function import_contact_no(){
		$this->load->library('excel');

		$objReader = new PHPExcel_Reader_Excel5;

		if (!$objReader) {
			show_error('Could not get reader.');
		}

		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($this->filename);
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
	
		$ctr = 0;	
		$import_data = array();

		foreach($rowIterator as $row){
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
			
			$rowIndex = $row->getRowIndex();
			
			// Build the array to insert and check for validation errors as well.
			foreach ($cellIterator as $cell) {
				$import_data[$ctr][] = $cell->getCalculatedValue();
			}

			if ($rowIndex == 1) {

				foreach ($import_data as $row) {
					foreach ($row as $cell => $value) {
						switch ($value) {
							case 'Id Number':
								$valid_cells[] = 'id_number';
								break;
							case 'Home Phone':
								$valid_cells[] = 'home_phone';
								break;								
							case 'Mobile':
								$valid_cells[] = 'mobile';
								break;	
							case 'E-mail':
								$valid_cells[] = 'email';
								break;
							case 'Office Phone':
								$valid_cells[] = 'office_phone';
								break;
							case 'UnitNo. / Bldg. Name / House No. Street':
								$valid_cells[] = 'address_1';
								break;
							case 'Subdivision / Village / Barangay':
								$valid_cells[] = 'address_2';
								break;
							case 'City/Municipality':
								$valid_cells[] = 'city_town';
								break;
							case 'Province':
								$valid_cells[] = 'country';
								break;
							case 'Zip Code ':
								$valid_cells[] = 'zip_code';
								break;								
						}
					}
				}

				unset($import_data[$ctr]);
			}

			$ctr++;
		}

		$ctr = 0;
		foreach ($import_data as $row) {		
			$partner_result = $this->db->get_where('partners',array('id_number' => $row[1]));
			if ($partner_result && $partner_result->num_rows() > 0){
				$partner = $partner_result->row();
				$partner_id = $partner->partner_id;
			}

			$arr_field_val = array();
			foreach ($valid_cells as $key => $value) {
				if ($row[$key] != ''){
					$result = $this->db->get_where('partners_key',array('key_code' => $row[$key]))
					if ($result && $result->num_rows() > 0){
						$row_key = $result->row();
						$arr_field_val['partner_id'] = $partner_id;
						$arr_field_val['key_id'] = $row_key->key_id;
						$arr_field_val['key'] = $row_key->key_code;
						$arr_field_val['key_name'] = $row_key->key_label;
						$arr_field_val['key_value'] = $row_key[$key];
					}
					$this->db->insert('partners_personal',$arr_field_val);					
				}
			}
		}

		echo "Done.";	
	}	

	function import_personal_info(){
		$this->load->library('excel');

		$objReader = new PHPExcel_Reader_Excel5;

		if (!$objReader) {
			show_error('Could not get reader.');
		}

		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($this->filename);
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
	
		$ctr = 0;	
		$import_data = array();

		foreach($rowIterator as $row){
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
			
			$rowIndex = $row->getRowIndex();
			
			// Build the array to insert and check for validation errors as well.
			foreach ($cellIterator as $cell) {
				$import_data[$ctr][] = $cell->getCalculatedValue();
			}

			if ($rowIndex == 1) {

				foreach ($import_data as $row) {
					foreach ($row as $cell => $value) {
						switch ($value) {
							case 'Id Number':
								$valid_cells[] = 'id_number';
								break;
							case 'Date of Birth':
								$valid_cells[] = 'birth_date';
								break;	
							case 'Place of Birth':
								$valid_cells[] = 'birth_place';
								break;	
							case ' Religion':
								$valid_cells[] = 'religion';
								break;																															
							case 'Gender':
								$valid_cells[] = 'gender';
								break;	
							case 'Nationality':
								$valid_cells[] = 'nationality';
								break;								
							case 'Civil Status':
								$valid_cells[] = 'civil_status';
								break;
							case 'Height':
								$valid_cells[] = 'height';
								break;
							case 'Weight':
								$valid_cells[] = 'weight';
								break;																																											
						}
					}
				}

				unset($import_data[0]);
				unset($import_data[1]);
				unset($import_data[$ctr]);
			}

			$ctr++;
		}

		$ctr = 0;
		foreach ($import_data as $row) {	
			$partner_result = $this->db->get_where('partners',array('id_number' => $row[1]));
			if ($partner_result && $partner_result->num_rows() > 0){
				$partner = $partner_result->row();
				$partner_id = $partner->partner_id;
				$user_id = $partner->user_id;
			}

			$arr_field_val = array();
			$arr_field_val_user = array();
			foreach ($valid_cells as $key => $value) {
				if ($value == 'birth_date') {
					$arr_field_val_user[$value] = $row[$key];
				}
				else{
					if ($row[$key] != ''){
						$result = $this->db->get_where('partners_key',array('key_code' => $row[$key]))
						if ($result && $result->num_rows() > 0){
							$row_key = $result->row();
							$arr_field_val['partner_id'] = $partner_id;
							$arr_field_val['key_id'] = $row_key->key_id;
							$arr_field_val['key'] = $row_key->key_code;
							$arr_field_val['key_name'] = $row_key->key_label;
							$arr_field_val['key_value'] = $row_key[$key];
						}
						$this->db->insert('partners_personal',$arr_field_val);					
					}					
				}
			}

			$this->db->where('user_id',$user_id);
			$this->db->update('users_profile',$arr_field_val_user);

		}

		echo "Done.";	
	}	

	function import_emergency_contact(){
		$this->load->library('excel');

		$objReader = new PHPExcel_Reader_Excel5;

		if (!$objReader) {
			show_error('Could not get reader.');
		}

		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($this->filename);
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
	
		$ctr = 0;	
		$import_data = array();

		foreach($rowIterator as $row){
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
			
			$rowIndex = $row->getRowIndex();
			
			// Build the array to insert and check for validation errors as well.
			foreach ($cellIterator as $cell) {
				$import_data[$ctr][] = $cell->getCalculatedValue();
			}

			if ($rowIndex == 1) {
				foreach ($import_data as $row) {
					foreach ($row as $cell => $value) {
						switch ($value) {
							case 'Id Number':
								$valid_cells[] = 'id_number';
								break;
							case 'Name':
								$valid_cells[] = 'emergency_name';
								break;	
							case 'Relationship':
								$valid_cells[] = 'emergency_relationship';
								break;	
							case 'Address':
								$valid_cells[] = 'emergency_address';
								break;	
							case 'Mobile':
								$valid_cells[] = 'emergency_mobile';
								break;	
							case 'Phone No.':
								$valid_cells[] = 'emergency_phone';
								break;																																				
						}
					}
				}

				unset($import_data[$ctr]);
			}

			$ctr++;
		}

		$ctr = 0;
		foreach ($import_data as $row) {	
			$partner_result = $this->db->get_where('partners',array('id_number' => $row[1]));
			if ($partner_result && $partner_result->num_rows() > 0){
				$partner = $partner_result->row();
				$partner_id = $partner->partner_id;
				$user_id = $partner->user_id;
			}

			$arr_field_val = array();
			foreach ($valid_cells as $key => $value) {
				if ($row[$key] != ''){
					$result = $this->db->get_where('partners_key',array('key_code' => $row[$key]))
					if ($result && $result->num_rows() > 0){
						$row_key = $result->row();
						$arr_field_val['partner_id'] = $partner_id;
						$arr_field_val['key_id'] = $row_key->key_id;
						$arr_field_val['key'] = $row_key->key_code;
						$arr_field_val['key_name'] = $row_key->key_label;
						$arr_field_val['key_value'] = $row_key[$key];
					}
					$this->db->insert('partners_personal',$arr_field_val);					
				}	
			}
		}

		echo "Done.";	
	}	

	function import_id_no(){
		$this->load->library('excel');

		$objReader = new PHPExcel_Reader_Excel5;

		if (!$objReader) {
			show_error('Could not get reader.');
		}

		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($this->filename);
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
	
		$ctr = 0;	
		$import_data = array();

		foreach($rowIterator as $row){
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
			
			$rowIndex = $row->getRowIndex();
			
			// Build the array to insert and check for validation errors as well.
			foreach ($cellIterator as $cell) {
				$import_data[$ctr][] = $cell->getCalculatedValue();
			}

			if ($rowIndex == 1) {

				foreach ($import_data as $row) {
					foreach ($row as $cell => $value) {
						switch ($value) {
							case 'Id Number':
								$valid_cells[] = 'id_number';
								break;
							case 'SSS':
								$valid_cells[] = 'sss_number';
								break;								
							case 'HDMF NO.':
								$valid_cells[] = 'pagibig_number';
								break;	
							case 'TIN                                TAX REGISTRATION NO.':
								$valid_cells[] = 'tin_number';
								break;	
							case 'Tax Status                 TAX CODE':
								$valid_cells[] = 'taxcode';
								break;								
							case 'Philhealth                      BPJS HEALTHCARE NO.':
								$valid_cells[] = 'philhealth_number';
								break;														
							case 'Bank Account No.':
								$valid_cells[] = 'bank_account_number_savings';
								break;																						
						}
					}
				}

				unset($import_data[$ctr]);
			}

			$ctr++;
		}

		$ctr = 0;
		foreach ($import_data as $row) {
			$partner_result = $this->db->get_where('partners',array('id_number' => $row[1]));
			if ($partner_result && $partner_result->num_rows() > 0){
				$partner = $partner_result->row();
				$partner_id = $partner->partner_id;
				$user_id = $partner->user_id;
			}

			$arr_field_val = array();
			foreach ($valid_cells as $key => $value) {
				if ($row[$key] != ''){
					$result = $this->db->get_where('partners_key',array('key_code' => $row[$key]))
					if ($result && $result->num_rows() > 0){
						$row_key = $result->row();
						$arr_field_val['partner_id'] = $partner_id;
						$arr_field_val['key_id'] = $row_key->key_id;
						$arr_field_val['key'] = $row_key->key_code;
						$arr_field_val['key_name'] = $row_key->key_label;
						$arr_field_val['key_value'] = $row_key[$key];
					}
					$this->db->insert('partners_personal',$arr_field_val);					
				}
			}
		}

		echo "Done.";	
	}		
	/************************************************************************************************/	

	public function get_import_form()
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

		$data['title'] = $this->mod->short_name .' - Import';
		$data['content'] = $this->load->blade('common.import-form')->with( $this->load->get_cached_vars() );

		$this->response->import_form = $this->load->view('templates/modal', $data, true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		
		$this->_ajax_return();
	}	

	public function validate_import($validation=0) {

		$this->lang->load('upload_utility');
		$this->_ajax_only();

		if( !$this->permission['list'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		
		$template_id = $this->input->post('template_id');
		$file = $this->input->post('template');

		if( !file_exists( urldecode($file) ) )
		{
			$this->response->message[] = array(
				'message' => lang('upload_utility.file_missing'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$ext = pathinfo($file, PATHINFO_EXTENSION);

		$accepted_file_types = array('xls');

		if (!in_array($ext, $accepted_file_types)) {
            $this->response->message[] = array(
				'message' => lang('upload_utility.file_type_not_accepted'),
				'type' => 'warning'
			);
			$this->_ajax_return();
        }

        $this->load->model('upload_utility_model', 'import');

        $csv_convert = false;

        if( in_array($ext, array('xls', 'xlsx')) )
        {
        	$csv_convert = time().'.csv';
        	$this->load->library('excel');
        	$inputFileType = PHPExcel_IOFactory::identify(urldecode($file));
        	$reader = PHPExcel_IOFactory::createReader($inputFileType);
			//$reader->setReadDataOnly(true);
			$excel = $reader->load(urldecode($file)); 
			$writer = PHPExcel_IOFactory::createWriter($excel, 'CSV');
			$writer->setDelimiter("\t");
			$writer->save($csv_convert);

			$fdata = file($csv_convert);
			$cnt = 0;
			$file_record = array();
			foreach($fdata as $row){
				$cnt++;
		    	if($template->skip_headers == 1 && $cnt == 1){
		    		continue;
		    	}

		    	$process = $this->import->process_row($row,$delimiter);

				foreach ($process as $k => $val) {
					if (array_key_exists($k, $col)){
		   				$file_record[$col[$k]] = $val;
					}
		   		}
		        $result[] = $file_record ;			    	
			}
        }
	   	//validation of record
	   	$error_msg = "";
	   	$error_cnt = 0;
	   	$valid_cnt = 0;
	   	$row_cnt = count($result);
	   	foreach ($result as $line => $_record) {
	   		$err = 0;
	   		foreach ($_record as $k_col => $_rec) {
	   			$_rec = trim($_rec, '"');
	   			// check if biometric id is valid
	   			if($k_col == 'biometric') {
	   				$this->db->where('biometric',$_rec,FALSE);
	   				$chk_bio = $this->db->get('partners');
					if( $chk_bio && $chk_bio->num_rows() > 0 ){
	   					$res[$line][$k_col] = $_rec;
	   					$res[$line]['user_id'] = $chk_bio->row()->user_id;
	   				} else {
	   					$error_msg .= "Invalid biometric id number in line ".($line+2)." | ". $_rec .".<br />";
	   					$err = 1; 
	   				}
	   			}
	   			if($k_col == 'checktime') {
	   				$res[$line][$k_col] = date("Y-m-d H:i:s",strtotime($_rec));;
	   				$res[$line]['date'] = date("Y-m-d",strtotime($_rec));
	   			}

	   			if($k_col == 'trans_type'){
	   				$chk_type = '';
	   				switch ($_rec) {
	   					case '0':
	   						$chk_type = 'C/In';
	   						break;
	   					case '1':
	   						$chk_type = 'C/Out';
	   						break;
	   					case '2':
	   						$chk_type = 'B/In';
	   						break;
	   					case '3':
	   						$chk_type = 'B/Out';
	   						break;
	   					case '4':
	   						$chk_type = 'OT/In';
	   						break;
	   					case '5':
	   						$chk_type = 'OT/Out';
	   						break;
	   				}
	   				$res[$line]['checktype'] = $chk_type;
	   			}
	   		}

	   		if($err == 1)  
	   			$error_cnt++ ;
	   		else 
	   			$valid_cnt++;
	   	}

	   	// validation of records
	   	if($validation == 1){
        	$this->response->valid_count = $valid_cnt;
        	$this->response->error_count = $error_cnt;
		    $this->response->error_details = $error_msg;
        	$this->response->rows = $row_cnt;

        	$this->response->message[] = array(
				'message' => 'Validation compler,te. Ready for upload!',
				'type' => 'success'
			);
        }
        else { //loading to database
        	//insert the upload log
        	$log = array(
				'template_id' => $template->template_id,
				'file_path' => urldecode($file),
				'filesize' => filesize(urldecode($file)),
				'rows' => $row_cnt,
				'valid_count' => $valid_cnt,
				'error_count' => $error_cnt,
				'created_by' => $this->user->user_id
			);

			$this->db->insert('system_upload_log', $log);
        	$this->db->trans_start();
        	foreach ($res as $key => $value) {
        		if (isset($value['user_id'])){
        			$this->db->where('user_id',$value['user_id']);
        		}
        		$this->db->where('date',$value['date']);
        		$this->db->where('checktime',$value['checktime']);
        		$dtr = $this->db->get('time_record_raw');

        		if (!$dtr || $dtr->num_rows() < 1){
        			$insert = $this->db->insert('time_record_raw', $value);
        		}
        	}

        	if ($this->db->trans_status() === FALSE) {# Something went wrong.
			    $this->db->trans_rollback();
			    $this->response->message[] = array(
						'message' => "Duplicate Record",
						'type' => 'error'
					);
			} 
			else {
			    $this->db->trans_commit();
			    $this->response->message[] = array(
					'message' => "Records successfully uploaded",
					'type' => 'success'
				);
			}
        	$this->db->trans_complete();
        }	        

		$this->_ajax_return();
	}	
}