<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class movement_model extends Record
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
		$this->mod_id = 87;
		$this->mod_code = 'movement';
		$this->route = 'partners/admin/movement';
		$this->url = site_url('partners/admin/movement');
		$this->primary_key = 'movement_id';
		$this->table = 'partners_movement';
		$this->icon = 'fa-user';
		$this->short_name = 'Employee Movement';
		$this->long_name  = 'Employee Movement';
		$this->description = 'Manage Employee Movement';
		$this->path = APPPATH . 'modules/movement/';

		parent::__construct();
	}

		
	function _get_list($start, $limit, $search, $filter, $trash = false)
	{
		$data = array();				
		
		
		$qry = $this->_get_list_cached_query();
		
		if( $trash )
		{
			$qry .= " AND ww_partners_movement.deleted = 1";
		}
		else{
			$qry .= " AND ww_partners_movement.deleted = 0";	
		}
		
		$qry .= " AND ww_partners_movement_action.user_id = " . $this->user->user_id;

		$filter .= ' GROUP BY record_id ORDER BY ww_partners_movement.created_on DESC';

		$qry .= ' '. $filter;
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );

		if($result && $result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	public function _get_list_cached_query()
	{
		$this->load->config('list_cached_query_custom');
		return $this->config->item('list_cached_query');	
	}

	function getTransferFields(){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_fields WHERE from_to = 1 "; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_employee_details($user_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT *, 
		'' AS rank_id, 
		'' AS rank
		 FROM partner_movement_current WHERE user_id = {$user_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_movement_details($movement_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT 
				pmove.movement_id,
				pmove.status_id,
				pmove.due_to_id,
				pmove.remarks AS movement_remarks,
				pmoveact.action_id,
				pmoveact.user_id,
				pmoveact.effectivity_date,
				pmoveact.type_id,
				pmoveact.type,
				pmoveremarks.remarks_print_report AS action_remarks,
				pmoveact.action_id,
				pmoveact.display_name,
				pmoveastat.status,
				pmoveact.status_id as act_status_id,
				pmoveact.photo,
				pmoveactm.further_reason,
				pmoveactr.reason
				FROM {$this->db->dbprefix}partners_movement pmove
				LEFT JOIN {$this->db->dbprefix}partners_movement_action pmoveact 
				ON pmove.movement_id = pmoveact.movement_id 
				LEFT JOIN {$this->db->dbprefix}partners_movement_action_moving pmoveactm
				ON pmoveact.action_id = pmoveactm.action_id 	
				LEFT JOIN {$this->db->dbprefix}partners_movement_reason pmoveactr
				ON pmoveactm.reason_id = pmoveactr.reason_id 	
				LEFT JOIN {$this->db->dbprefix}partners_movement_remarks pmoveremarks
				ON pmoveremarks.remarks_print_report_id = pmoveact.remarks_print_report_id 											
				LEFT JOIN {$this->db->dbprefix}partners_movement_status pmoveastat 
				ON pmove.status_id = pmoveastat.status_id 
				WHERE pmove.movement_id = {$movement_id}
				AND pmoveact.deleted = 0
				ORDER BY pmoveact.effectivity_date DESC"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_action_movement($action_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action pma
				LEFT JOIN {$this->db->dbprefix}users u ON pma.user_id = u.user_id
				LEFT JOIN {$this->db->dbprefix}partners_movement_remarks pmr ON pmr.remarks_print_report_id = pma.remarks_print_report_id
				WHERE pma.action_id = {$action_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_action_movement_attachment($action_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_attachment pmaa
				WHERE pmaa.action_id = {$action_id} AND deleted = 0";
		$result = $this->db->query($qry);
		
		if($result && $result->num_rows() > 0){
			$data = $result->result();		
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_extension_movement($action_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_extension
				WHERE action_id = {$action_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_moving_movement($action_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_moving pmam
				LEFT JOIN {$this->db->dbprefix}partners_movement_reason pmr ON pmam.reason_id = pmr.reason_id
				WHERE pmam.action_id = {$action_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_compensation_movement($action_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_compensation
				WHERE action_id = {$action_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_transfer_movement($action_id=0, $field_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_transfer
				WHERE action_id = {$action_id} 
				AND field_id = {$field_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	function get_partners_personal($user_id=0, $partners_personal_table='', $key='', $sequence=0){
		$this->db->select('personal_id, key_value')
	    ->from($partners_personal_table)
	    ->join('partners', $partners_personal_table.'.partner_id = partners.partner_id', 'left')
	    ->where("partners.user_id = $user_id")
	    ->where($partners_personal_table.".key = '$key'");
	    if($sequence != 0)
	    	$this->db->where($partners_personal_table.".sequence = '$sequence'");

		if($partners_personal_table == 'partners_personal'){
	    	$this->db->where("partners_personal.deleted = 0");
	    }

	    $partners_personal = $this->db->get('');	
	    
		if( $partners_personal->num_rows() > 0 )
	    	return $partners_personal->row_array();
	    else
	    	return array();
	}

    // print movement information
    function export_pdf( $recruit_id ){
    	$user = $this->config->item('user');

        $this->load->library('PDFm');

        $mpdf = new PDFm();
        $mpdf->SetTitle( 'Movement Info Sheet' );
        $mpdf->SetAutoPageBreak(true, 1);
        $mpdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $mpdf->SetDisplayMode('real', 'default');
        $mpdf->AddPage();
		
		$html = '<table><thead><tr><td>dasdf</td></tr></thead><tbody><tr><td>dddd</td></tr></tbody></table>';

        $path = 'uploads/templates/movement/pdf/';
        $this->check_path( $path );
        $filename = $path . "movement_info.pdf";

        $mpdf->WriteHTML($html);
        $mpdf->Output($filename, 'F');

        return $filename;
    }

	function export_excel( $movement_id )
	{
		ini_set('memory_limit', '1024M');   
        ini_set('max_execution_time', 1800);

		$this->load->helper('file');
		$path = 'uploads/reports/movement/excel/';
		$this->check_path( $path );
		$filename = $path . strtotime(date('Y-m-d H:i:s')) . 'Movement' . ".xlsx";

		$this->load->library('excel');

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setTitle("Movement Report")
		            ->setDescription("Movement Report");
		               
		// Assign cell values
		$objPHPExcel->setActiveSheetIndex(0);
		$activeSheet = $objPHPExcel->getActiveSheet();

		//header
		$alphabet  = range('A','Z');
		$alpha_ctr = 0;
		$sub_ctr   = 0;				

	    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);

		//Initialize style
		$styleArray = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		);

		$bold = array(
			'font' => array(
				'bold' => true,
			)
		);

		$leftstyleArray = array(
			'font' => array(
				'italic' => true,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		);

		$center = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		);

        $border_bottom = array(
            'borders' => array(
                'bottom' =>array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );

        $border_top = array(
            'borders' => array(
                'top' =>array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );

        $border_right = array(
            'borders' => array(
                'right' =>array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );

        $border_left = array(
            'borders' => array(
                'left' =>array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );

		$border_style = array(
			'borders' => array(
			    'allborders' => array(
			      'style' => PHPExcel_Style_Border::BORDER_THIN
			    )
			  )
			);

		$objPHPExcel->getActiveSheet()->setShowGridlines(false);

		$line = 1;
		$xcoor = $alphabet[$alpha_ctr];

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'NOTICE OF PERSONNEL ACTION - DAILY');
		$activeSheet->getStyle($xcoor.$line)->applyFromArray($bold);	
		$activeSheet->getStyle($xcoor.$line)->getFont()->setSize(16);

		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'RIOFIL CORPORATION');
		$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Units 1704-1706 Hanston Square');
		$objPHPExcel->getActiveSheet()->setCellValue('D3', '17 San Miguel Ave., Ortigas Center');
		$objPHPExcel->getActiveSheet()->setCellValue('D4', 'Pasig City');

		$this->db->where('partners_movement.movement_id',$movement_id);
		$this->db->join('partners_movement_action','partners_movement.movement_id = partners_movement_action.movement_id');
		$movement = $this->db->get('partners_movement');

		$action_id = '';
		if ($movement && $movement->num_rows() > 0){
			$movement_data = $movement->row();
			$action_id = $movement_data->action_id;

			$partners = $this->db->get_where('partners',array('user_id' => $movement_data->user_id));
			if ($partners && $partners->num_rows() > 0){
				$partners_info = $partners->row();
			}

			$objPHPExcel->getActiveSheet()->setCellValue('B8', date('d M Y',strtotime($movement_data->effectivity_date)));
			$objPHPExcel->getActiveSheet()->setCellValue('B9', $movement_data->display_name);
			$objPHPExcel->getActiveSheet()->setCellValue('B10', $movement_data->type);

			switch ($partners_info->status_id) {
				case 1:
					$objPHPExcel->getActiveSheet()->setCellValue('E9', 'X');
					$activeSheet->getStyle('E9')->applyFromArray($center);
					break;
				case 2:
					$objPHPExcel->getActiveSheet()->setCellValue('G9', 'X');
					$activeSheet->getStyle('G9')->applyFromArray($center);
					break;
				case 4:
					$objPHPExcel->getActiveSheet()->setCellValue('I9', 'X');
					$activeSheet->getStyle('I9')->applyFromArray($center);
					break;										
			}
		}

		$line = 8;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'EFFECTIVE DATE        :');
		$activeSheet->getStyle($xcoor.$line)->getFont()->setSize(12);
		$activeSheet->getStyle('B'.$line.':'.'C'.$line)->applyFromArray($border_bottom);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$line, 'EMPLOYMENT STATUS');
		$activeSheet->getStyle('E'.$line)->applyFromArray($bold);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'EMPLOYEE NAME      :');
		$activeSheet->getStyle($xcoor.$line)->getFont()->setSize(12);
		$activeSheet->getStyle('B'.$line.':'.'C'.$line)->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(3);

		$activeSheet->getStyle('E'.$line)->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(3);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'R');
		$activeSheet->getStyle('F'.$line)->applyFromArray($bold);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(3);

		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(3);
		$activeSheet->getStyle('G'.$line)->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$line, 'P');
		$activeSheet->getStyle('H'.$line)->applyFromArray($bold);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(3);

		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(3);
		$activeSheet->getStyle('I'.$line)->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line, 'PJ');
		$activeSheet->getStyle('J'.$line)->applyFromArray($bold);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(3);		

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'NATURE OF ACTION  :');
		$activeSheet->getStyle($xcoor.$line)->getFont()->setSize(12);
		$activeSheet->getStyle('B'.$line.':'.'C'.$line)->applyFromArray($border_bottom);

		$line++;

		if ($action_id != ''){
			$this->db->select('field_label,from_name,to_name');
			$this->db->where('action_id',$action_id);
			$this->db->join('partners_movement_fields','partners_movement_action_transfer.field_id = partners_movement_fields.field_id');
			$movement_action = $this->db->get('partners_movement_action_transfer');
			if ($movement_action && $movement_action->num_rows() > 0){
				$header = array('PARTICULARS','FROM','TO');

				$line = 13;
				foreach ($header as $key => $value) {
					if ($alpha_ctr >= count($alphabet)) {
						$alpha_ctr = 0;
						$sub_ctr++;
					}

					if ($sub_ctr > 0) {
						$xcoor = $alphabet[$sub_ctr - 1] . $alphabet[$alpha_ctr];
					} else {
						$xcoor = $alphabet[$alpha_ctr];
					}	

					$activeSheet->setCellValue($xcoor.$line, $value);
					$activeSheet->getStyle($xcoor.$line)->applyFromArray($bold);

					$alpha_ctr++;
				}

				$line++;

				foreach ($movement_action->result() as $row) {
					if ($row->field_label == 'End Date of Temporary Assignment'){
						$row->from_name = '';
					}
					$activeSheet->setCellValue('A'.$line, $row->field_label);
					$activeSheet->setCellValue('B'.$line, $row->from_name);
					$activeSheet->setCellValue('D'.$line, $row->to_name);
					$activeSheet->getStyle('A'.$line.':K'.$line)->applyFromArray($border_style);
					$activeSheet->mergeCells('B'.$line.':C'.$line);
					$activeSheet->mergeCells('D'.$line.':K'.$line);
					$line++;							
				}
			}
		}

		if ($action_id != ''){
			$line++;
			$alpha_ctr = 0;		
					
			$this->db->select('type_name,current_salary,to_salary');
			$this->db->where('action_id',$action_id);
			$movement_action = $this->db->get('partners_movement_action_compensation');
			if ($movement_action && $movement_action->num_rows() > 0){

				$header = array('CHANGES','FROM','TO');
				foreach ($header as $key => $value) {
					if ($alpha_ctr >= count($alphabet)) {
						$alpha_ctr = 0;
						$sub_ctr++;
					}

					if ($sub_ctr > 0) {
						$xcoor = $alphabet[$sub_ctr - 1] . $alphabet[$alpha_ctr];
					} else {
						$xcoor = $alphabet[$alpha_ctr];
					}	

					$activeSheet->setCellValue($xcoor.$line, $value);
					$activeSheet->getStyle($xcoor.$line)->applyFromArray($bold);

					$alpha_ctr++;
				}

				$line++;
				foreach ($movement_action->result() as $row) {
					$activeSheet->setCellValue('A'.$line, 'Salary Rate');
					$activeSheet->setCellValue('B'.$line, $row->current_salary);
					$activeSheet->setCellValue('D'.$line, $row->to_salary);
					$activeSheet->getStyle('A'.$line.':K'.$line)->applyFromArray($border_style);
					$activeSheet->mergeCells('B'.$line.':C'.$line);
					$activeSheet->mergeCells('D'.$line.':K'.$line);					
					$line++;							
				}
			}
		}

		$line++;

		$activeSheet->setCellValue('A'.$line, 'Approved by :');
		$activeSheet->getStyle('A'.$line)->applyFromArray($bold);

		$line++;

		$activeSheet->getStyle('A'.$line.':K'.$line)->applyFromArray($border_top);

		$activeSheet->getStyle('A'.$line.':A'.($line+4))->applyFromArray($border_left);

		$activeSheet->getStyle('K'.$line.':K'.($line+4))->applyFromArray($border_right);

		$activeSheet->getStyle('A'.($line+4).':K'.($line+4))->applyFromArray($border_bottom);

		$activeSheet->setCellValue('A'.($line+2), '     __________________________     ');
		$activeSheet->setCellValue('B'.($line+2), '     __________________________     ');
		$activeSheet->setCellValue('D'.($line+2), '     _________________________  ');

		$line = $line + 6;

		$activeSheet->setCellValue('A'.$line, 'Employee: ____________________________________');
		$activeSheet->getStyle('A'.$line)->applyFromArray($bold);

		$line++;

		$activeSheet->setCellValue('A'.$line, '                        Signature over Printed Name / Date');

		$activeSheet->getStyle('D'.$line)->applyFromArray($border_style);
		$activeSheet->setCellValue('E'.$line, 'Employee');

		$activeSheet->getStyle('I'.$line)->applyFromArray($border_style);
		$activeSheet->setCellValue('J'.$line, 'Personnel');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save( $filename );

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


}