<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report extends MY_PrivateController{

	public function __construct(){

		$this->load->model('report_model', 'mod');
		$this->load->library('pagination');
		parent::__construct();
	}

	public function index(){

		$data = array();

		$data['company_list'] = $this->mod->_get_company_list(); 
		$data['report_list'] = $this->mod->_get_reports_list(); 

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// die();
		
		$this->load->vars($data);
		echo $this->load->blade('record_listing_custom')->with( $this->load->get_cached_vars() );
	}

	public function get_report(){

		$report_result = array();
		$report = new stdClass();

		if($this->input->post('report-type')) { 

			$report_type = $this->input->post('report-type');

			switch ($report_type) {

				case '1': //die('oks');
					
					// Incomplete Attendance
					if(($this->input->post('date_from') != '' ) && ($this->input->post('date_to') != '')) {

						$params = array();
						$params['date_from'] =  date("Y-m-d", strtotime($this->input->post('date_from')));
						$params['date_to'] = date("Y-m-d", strtotime($this->input->post('date_to')));
						$params['company'] = $this->input->post('selected-company') ? implode(",", $this->input->post('selected-company')) : '';

						$page =  $this->input->post('page');
						$data_fn = "report_inc_att";

						$report = $this->_get_report_data($params, $page, 'web', 'timerecord_manage', 'report_inc_att');

						echo json_encode($report);
						die();
					}
					else{

						$this->_date_filter_error();
					}

					break;

				case '2':

					// DTR Summary Report - Lates/Undertime
					if(($this->input->post('date_from') != '' ) && ($this->input->post('date_to') != '')) {

						$params = array();
						$params['date_from'] =  date("Y-m-d", strtotime($this->input->post('date_from')));
						$params['date_to'] = date("Y-m-d", strtotime($this->input->post('date_to')));
						$params['company'] = $this->input->post('selected-company') ? implode(",", $this->input->post('selected-company')) : '';

						$page =  $this->input->post('page');
						$data_fn = "report_dtr_summary";

						$report = $this->_get_report_data($params, $page, 'web', 'timerecord_manage', 'report_dtr_summary');

						echo json_encode($report);
						die();
					}
					else{

						$this->_date_filter_error();
					}

					break;

				case '3':

					// Tardiness Report  per month for Memo
					if(($this->input->post('date_from') != '' ) && ($this->input->post('date_to') != '')) {

						$params = array();
						$params['date_from'] =  date("Y-m-d", strtotime($this->input->post('date_from')));
						$params['date_to'] = date("Y-m-d", strtotime($this->input->post('date_to')));
						$params['company'] = $this->input->post('selected-company') ? implode(",", $this->input->post('selected-company')) : '';

						$page =  $this->input->post('page');
						$data_fn = "report_tardiness_report_for_memo";

						$report = $this->_get_report_data($params, $page, 'web', 'timerecord_manage', 'report_dtr_summary');

						echo json_encode($report);
						die();
					}
					else{

						$this->_date_filter_error();
					}

					break;
				
				default:
					
					$report->message[] = array(
						'message' => 'Requested report not found.',
						'type' => 'warning'
					);
					
					echo json_encode($report);
					die();
					break;
			}
		}
		else {

			$report->message[] = array(
				'message' => 'Please choose a report type.',
				'type' => 'warning'
			);

			echo json_encode($report);
			die();
		}
	}

	public function export_report(){

		$error = array();

		if(!empty($_GET)){

			if(!$this->input->get('report-type')) {

				$error['type'] = "Unidentified report type.";
				$error['message'] = "Unable to export requested report. Could not determine report type.";
				echo json_encode($error);
				die();
			}
			
			if(!$this->input->get('date_from') || !$this->input->get('date_to')) {

				$error['type'] = "Missing required date parameters.";
				$error['message'] = "Unable to export requested report. Date parameters are missing.";
				echo json_encode($error);
				die();
			}

			$id 		= $this->input->get('report-type');
			$date_from 	= $this->input->get('date_from');
			$date_to 	= $this->input->get('date_to');

			$details = $this->_get_report_details($id);

			// echo "<pre>";
			// print_r($details);
			// echo "<br><br>";
			// echo "</pre>"; die();

			// get total number of columns
			$cell = $this->_get_letter_from_number($details['columns']); 

			
			/*!***********************************************************
			PROTOTYPE PROTOTYPE PROTOTYPE PROTOTYPE PROTOTYPE PROTOTYPE 
			PROTOTYPE PROTOTYPE PROTOTYPE PROTOTYPE PROTOTYPE PROTOTYPE 

			Code from here down below is a prototype for the main reporting
			module
			*************************************************************/

			$this->load->library('excel');

			$current_user = $this->config->item('user');
			$creator = $current_user['firstname']." ".$current_user['middlename']." ".$current_user['lastname'];

			// Set Export file properties
			$this->excel->getProperties()->setCreator($creator);
			$this->excel->getProperties()->setLastModifiedBy($creator);
			$this->excel->getProperties()->setTitle($details['title']);
			$this->excel->getProperties()->setSubject($details['title']);
			$this->excel->getProperties()->setDescription($details['description']);

			// Sheet
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle($details['title']);

			//die();
			// report headings setup
			$headerX = 1; // cell number for X or Left
			$headerY = 1; // cell number for Y or Down

			// transform number to equivalent cell letter
			$xFrom = $this->_get_letter_from_number($headerX); 
			// determine cell number by adding headerY
			$xFrom = $xFrom.''.$headerY; 

			// get defined number of cells and transform to equivalent cell letter
			$xTo = $this->_get_letter_from_number($details['columns']); 
			// determine cell number by adding headerY
			$xTo = $xTo.''.$headerY; 

			$merge = $xFrom.":".$xTo;

			// Report Header title
			// COMPANY INFO
			// ??? One question though, where will i am going to get company name
			// ??? as for instances like an umbrella company
			$this->excel->getActiveSheet()->getStyle($xFrom)->getFont()->setSize(12);
			$this->excel->getActiveSheet()->getStyle($xFrom)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue($xFrom, 'HDI Group of Companies');

			//merge cells that needs to be merged 
			$this->excel->getActiveSheet()->mergeCells($merge);

			//set aligment to center for that merged cell (A1 to E1)
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


			
			// REPORT TITLE
			$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);
			$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('A2', $details['title']);

			//merge cells that needs to be merged 
			$this->excel->getActiveSheet()->mergeCells("A2:F2");

			//set aligment to center for that merged cell (A2 to E2)
			$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



			// REPORT DATE
			$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(12);
			$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->setCellValue('A3', $date_from.'-'.$date_to);

			//merge cells that needs to be merged 
			$this->excel->getActiveSheet()->mergeCells("A3:F3");

			//set aligment to center for that merged cell (A3 to F3)
			$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


			// TEMPORARY
			$lastIndex = 3;

			// merge space heading cell
			$spacerIndex = $lastIndex + 1;
			$spacerA = 'A'.$spacerIndex;
			$spacerB = $cell.$spacerIndex;
			$spacerAB= $spacerA.":".$spacerB;
			$this->excel->getActiveSheet()->mergeCells($spacerAB);


			// Report fields headers
			// This will depend on the number of fields from report $details
			// should report headers be defined together with the report $details?
			for($i=0; $i<count($details['labels']); $i++){

				// must get the last index number of cells used from the report
				// headers and add 1 as space separator for the data headers

				$cellX = $this->_get_letter_from_number($i + 1);
				$cellY = $lastIndex + 2;

				$targetCell = $cellX."".$cellY; 

				$this->excel->getActiveSheet()->getStyle($targetCell)->getFont()->setSize(12);
				$this->excel->getActiveSheet()->getStyle($targetCell)->getFont()->setBold(true);
				$this->excel->getActiveSheet()->setCellValue($targetCell, $details['labels'][$i]);
			}

			// DETERMINE WHICH INDEX WE ARE NOW BASED ON DATA HEADER!!!!

			$params = array();

			foreach($_GET as $paramKey => $paramValue){

				if($paramKey !== 'report-type' && $paramKey !== "selected-company")
					$params[$paramKey] = $paramValue;

				if($paramKey == "selected-company")
					$params['company'] = implode(",", $paramValue);
			}

			// echo "<pre>";
			// 	print_r($params);
			// 	echo "</pre>";
			// 	die();
			// die();

			$page = 0;
			$type = 'file';

			// Report Data
			$report = $this->_get_report_data($params, $page, $type, $details['module'], $details['method']);

			// echo "<pre>CCCCC";
			// print_r($report);
			// echo "</pre>";
			// die();


			// now get the export fields ready
			$export_fields = explode(',', $details['export_fields']);

			for($i=0; $i<count($report); $i++){

					$cellPosition = 1;

					foreach ($export_fields as $index => $export_field) {
						
						// echo "<pre>";
						// print_r($export_field);
						// echo "<br>";
						// print_r($report[$i][$export_field]);
						// echo "<br>";
						// echo "</pre>";
						//die();

						
						$cellLeft = $this->_get_letter_from_number($cellPosition);
						$cellTop  = $lastIndex + 5 + $i;
						$dataCell = $cellLeft.''.$cellTop;
						$cellPosition++;

						$this->excel->getActiveSheet()->setCellValue($dataCell, $report[$i][$export_field]);
						$this->excel->getActiveSheet()->getColumnDimension($cellLeft)->setAutoSize(true);
					}
				//die();
				//echo "<br><br><br>";
			}

			// echo "<pre>";
			// print_r($details);
			// echo "</pre>";
			// die();


			//die('Wait!!! Stop!!!');

			$filename = $details['filename'];

			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0'); //no cache

			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  

			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
		}
		else{

			// something here
			// remember that this is opened on a new window/dialog.
			// how am i going to handle this? :D
			$error['type'] = "Missing report parameters.";
			$error['message'] = "Required report export parameters should not be empty";
			echo json_encode($error);
			die();
		}
	}


	function _get_letter_from_number($number) {

	    $numeric = ($number - 1) % 26;
	    $letter = chr(65 + $numeric);
	    $number = intval(($number - 1) / 26);

	    if ($number > 0) {

	        return _get_letter_from_number($number) . $letter;
	    } 
	    else {

	        return $letter;
	    }
	}

	// Fetch the report details
	// such as report name, company,.. etc and other 
	// heading info
	private function _get_report_details($id){

		// report details are 
		// 1. report file name.ext || title_date.ext
		// 2. report name/title - tab name/title ???????
		// 3. company name ->> ????????
		// 4. report request date ->????? auto in file meta
		// 5. report # of columns - will be used in report header calculation too

		// EXCEL FILE PROPERTIES
		// 6. meta - current date and time ????? - autogenerated i guess
		// 7. meta - report author/current user who generated it ----------------------> setCreator, setLastModifiedBy()
		// 8. meta - report file title 	-----------------------------------------------> setTitle()
		// 9. meta - report description.. from database -------------------------------> setDescription()
		// 10. meta - report subject ---------------------------------------------------> setSubject()

		$details = array();
		$info	 = $this->mod->_get_report_info($id);

			// echo "<pre>";
			// print_r($info);
			// echo "</pre>";
			// die();

		if(count($info) > 0){

			$user = $this->config->item('user');

			$details['filename'] 	= preg_replace("/[\s_]/", "_", $info[0]->report)."_".date("Y-m-d-H-i-s").'.xls';
			$details['title'] 		= $info[0]->report;
			$details['description']	= $info[0]->description;
			$details['columns']		= $info[0]->columns;
			$details['labels']		= empty($info[0]->labels) ? '' : explode(",", $info[0]->labels);
			$details['module']		= $info[0]->module;
			$details['method']		= $info[0]->method;
			$details['author'] 		= $user['firstname']. " " .$user['middlename']. " " .$user['lastname'];
			$details['export_fields']	= $info[0]->export_fields;

			return $details;
		}
		else{

			return false;
		}
	}

	private function _get_report_data($params, $page, $type, $module, $method){

		if($type === 'file'){

			$params['action'] = 'export';
			$report_result = modules::run($module.'/'.$module.'/'.$method, $params);

			// echo "<pre>";
			// print_r($report_result);
			// echo "</pre>";
			// die();

			return $report_result;
		}
		else{

			$limit	= 10;
			$page 	= $page;
			$page 	= $page ? $page : 0;

			$offset = $page;
			$params['page'] = $page;
			$params['limit'] = $limit;
			$params['type'] = $type;

			// echo modules::run('module/controller/method', $param1, $params2);
			//$report_result = modules::run('timerecord_manage/timerecord_manage/' . $data_fn, $params);
			$report_result = modules::run($module.'/'.$module.'/'.$method, $params);

			// echo "<pre>";
			// print_r($report_result);
			// echo "</pre>";
			// die();

			// prepare pagination
			// we use blank base_url here because we are not using
			// pagination on typical href based link but rather we
			// will be using ajax
			//$config['base_url'] 	= base_url()."/".$this->router->fetch_class()."/".$this->router->fetch_method();
			$config['base_url'] 		= '';
			$config['total_rows'] 		= $report_result->total_records;
			$config['per_page'] 		= $limit; 
			$config['num_links'] 		= 1;
			$config['full_tag_open']	= '<div class="btn-group btn-group-sm btn-group-solid page-group">';
			$config['full_tag_close'] 	= '</div>';
			$config['first_link'] 		= 'First';
			$config['last_link'] 		= 'Last';

			$this->pagination->initialize($config); 
			$this->pagination->cur_page = $offset;

			$report = $report_result;
			$report->pages = $this->pagination->create_links();

			return $report;
		}
	}

	private function _date_filter_error(){

		$report->message[] = array(
			'message' => 'Please choose start date and end date.',
			'type' => 'warning'
		);

		echo json_encode($report);
		die();
	}
}