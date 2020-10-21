<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class clearance_model extends Record
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
		$this->mod_id = 134;
		$this->mod_code = 'clearance';
		$this->route = 'partners/clearance';
		$this->url = site_url('partners/clearance');
		$this->primary_key = 'clearance_id';
		$this->table = 'partners_clearance';
		$this->icon = 'fa-folder';
		$this->short_name = 'Clearance';
		$this->long_name  = 'Clearance';
		$this->description = '';
		$this->path = APPPATH . 'modules/clearance/';

		parent::__construct();
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
		$qry .= " ORDER BY {$this->db->dbprefix}{$this->table}.effectivity_date DESC";
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

	function get_movement_record($user_id, $action_id)
	{
		$query = "SELECT pma.status_id as movement_action_status, pm.*, pma.* FROM {$this->db->dbprefix}partners_movement pm 
					LEFT JOIN {$this->db->dbprefix}partners_movement_action pma
					    ON pm.movement_id = pma.movement_id
					WHERE action_id = ". $action_id . "
					    AND user_id = ". $user_id. "
					LIMIT 1";

		$movement = $this->db->query($query);
		if($movement && $movement->num_rows() > 0){
			return $movement->row_array();	
		}else {
			return false;
		}
		
	}

	function update_movement($user_id, $action_id, $clearance_id)
	{
		$error = false;
		$movement_record = $this->get_movement_record($user_id, $action_id);
		if(!$movement_record){
			return false;
		}

		$transactions = true;
		if( $transactions )
		{
			$this->db->trans_begin();
		}

			if($movement_record['movement_action_status'] == 6){
			
				// update_201
				$transfer_details = $this->db->get_where('partners_movement_action_transfer', array('movement_id' => $movement_record['movement_id'], 'action_id' => $action_id, 'field_id' => 9));
				
				if($transfer_details && $transfer_details->num_rows() > 0){
					$transfer = $transfer_details->row_array();

					$this->db->where('user_id', $user_id);
					$this->db->update('partners', array('status_id' => $transfer['from_id'], 'resigned_date' => '0000-00-00') );
					if( $this->db->_error_message() != "" ){
						$error = true;
						goto stop;
					}

					$this->db->where('user_id', $user_id);
					$this->db->update('users', array('active' => 1));
					if( $this->db->_error_message() != "" ){
						$error = true;
						goto stop;
					}
				}
			}

			$this->db->where('partners_movement_action.action_id', $action_id);
			$this->db->update('partners_movement_action', array('status_id' => 5));
			if( $this->db->_error_message() != "" ){
				$error = true;
				goto stop;
			}

			$this->db->where('partners_movement.movement_id', $movement_record['movement_id']);
			$this->db->update('partners_movement', array('status_id' => 5));
			if( $this->db->_error_message() != "" ){
				$error = true;
				goto stop;
			}

			$this->db->update('partners_clearance', array('status_id' => 5), array('clearance_id' => $clearance_id));
			if( $this->db->_error_message() != "" ){
				$error = true;
				goto stop;
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


		return true;

	}

	//excel export for exit clearance
	function export_excel( $clearance_id )
	{
		ini_set('memory_limit', '1024M');   
        ini_set('max_execution_time', 1800);

		$this->load->helper('file');
		$path = 'uploads/templates/clearance_form/';
		$this->check_path( $path );
		$filename = $path . strtotime(date('Y-m-d H:i:s')) . '-EXIT_CLEARANCE' . ".xlsx";

		$this->load->library('excel');

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setTitle("Exit Clearance")
		            ->setDescription("Exit Clearance");
		               
		// Assign cell values
		$objPHPExcel->setActiveSheetIndex(0);
		$activeSheet = $objPHPExcel->getActiveSheet();

		//header
		$alphabet  = range('A','Z');
		$alpha_ctr = 0;
		$sub_ctr   = 0;				

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.86);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(3.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5.29);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(4);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22.29);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(2.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(3.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(21.71);
		$activeSheet->getStyle('A')->getFont()->setSize(10);
		$activeSheet->getStyle('B')->getFont()->setSize(10);
		$activeSheet->getStyle('C')->getFont()->setSize(10);
		$activeSheet->getStyle('D')->getFont()->setSize(10);
		$activeSheet->getStyle('E')->getFont()->setSize(10);
		$activeSheet->getStyle('F')->getFont()->setSize(10);
		$activeSheet->getStyle('G')->getFont()->setSize(10);
		$activeSheet->getStyle('H')->getFont()->setSize(10);
		$activeSheet->getStyle('I')->getFont()->setSize(10);
		$activeSheet->getStyle('J')->getFont()->setSize(10);

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

		$align_left = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
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

		$border_style_dash = array(
			'borders' => array(
			    'allborders' => array(
			      'style' => PHPExcel_Style_Border::BORDER_DOTTED
			    )
			  )
			);

		$border_style_dash_bottom = array(
			'borders' => array(
			    'bottom' => array(
			      'style' => PHPExcel_Style_Border::BORDER_DOTTED
			    )
			  )
			);

		$border_style_dash_right = array(
			'borders' => array(
			    'right' => array(
			      'style' => PHPExcel_Style_Border::BORDER_DOTTED
			    )
			  )
			);

		$border_style_dash_top = array(
			'borders' => array(
			    'top' => array(
			      'style' => PHPExcel_Style_Border::BORDER_DOTTED
			    )
			  )
			);

		$objPHPExcel->getActiveSheet()->setShowGridlines(false);

		$line = 4;
		$xcoor = $alphabet[$alpha_ctr];

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'EXIT CLEARANCE');
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);	
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->getFont()->setSize(20);
		$activeSheet->mergeCells($xcoor.$line.':J'.$line);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($center);

        $clearance_record = $this->db->get_where('partners_clearance', array('clearance_id'=>$clearance_id) );
        $clearance_record = $clearance_record->row_array();

        $clearance = "SELECT up.*, p.alias as display_name, uproj.project, ud.department as dept, u.login, upos.position, p.effectivity_date as date_hired, p.resigned_date, pmr.reason, uc.company as comp FROM {$this->db->dbprefix}users_profile up
                        INNER JOIN {$this->db->dbprefix}users_company uc ON up.company_id = uc.company_id
                        LEFT JOIN {$this->db->dbprefix}users_department ud ON up.department_id = ud.department_id
                        LEFT JOIN {$this->db->dbprefix}users u ON up.user_id = u.user_id
                        LEFT JOIN {$this->db->dbprefix}users_position upos ON up.position_id = upos.position_id
                        LEFT JOIN {$this->db->dbprefix}users_profile uprof ON u.user_id = uprof.user_id
                        LEFT JOIN {$this->db->dbprefix}users_project uproj ON uproj.project_id = uprof.project_id
                        LEFT JOIN {$this->db->dbprefix}partners p ON up.partner_id = p.partner_id
                        LEFT JOIN {$this->db->dbprefix}partners_movement_action pma ON up.user_id = pma.user_id
                        LEFT JOIN {$this->db->dbprefix}partners_movement_action_moving pmam ON pma.movement_id = pmam.movement_id
                        LEFT JOIN {$this->db->dbprefix}partners_movement_reason pmr ON pmam.reason_id = pmr.reason_id
                        WHERE up.partner_id = {$clearance_record['partner_id']} ";
        $clearance = $this->db->query($clearance);

		if ($clearance && $clearance->num_rows() > 0){
			$clearance_data = $clearance->row();

			$objPHPExcel->getActiveSheet()->setCellValue('B6', $clearance_data->display_name );
			$objPHPExcel->getActiveSheet()->setCellValue('D7', $clearance_data->position );
			$objPHPExcel->getActiveSheet()->setCellValue('C8', $clearance_data->date_hired );
			$objPHPExcel->getActiveSheet()->setCellValue('E9', $clearance_data->reason );
			$objPHPExcel->getActiveSheet()->setCellValue('I6', $clearance_data->login );
			$objPHPExcel->getActiveSheet()->setCellValue('I7', $clearance_data->project );
			$objPHPExcel->getActiveSheet()->setCellValue('H8', date('F d, Y',strtotime($clearance_record['effectivity_date'])));
			
		}

		$line = 6;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'Name:');
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'Employee ID Number:');
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);		
		$activeSheet->getStyle('B'.$line.':'.'E'.$line)->applyFromArray($border_bottom);
		$activeSheet->getStyle('I'.$line.':'.'J'.$line)->applyFromArray($border_bottom);
		$activeSheet->mergeCells('I'.$line.':J'.$line);
		$activeSheet->getStyle('I'.$line.':J'.$line)->applyFromArray($align_left);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'Job/Position Title:');
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'Place of Work/Project:');
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);	
		$activeSheet->getStyle('D'.$line.':'.'E'.$line)->applyFromArray($border_bottom);
		$activeSheet->getStyle('I'.$line.':'.'J'.$line)->applyFromArray($border_bottom);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'Date Hired:');
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'Effectivity Date:');
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);	
		$activeSheet->getStyle('C'.$line.':'.'E'.$line)->applyFromArray($border_bottom);
		$activeSheet->getStyle('H'.$line.':'.'J'.$line)->applyFromArray($border_bottom);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'Reason for Separation:');
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);	
		$activeSheet->getStyle('E'.$line.':'.'J'.$line)->applyFromArray($border_bottom);

		$line++;
		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, '1. Accountabilities');
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);	

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'Central Office');
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'Project');
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);	
		$activeSheet->mergeCells($xcoor.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':J'.$line);
		$activeSheet->getStyle($xcoor.$line.':'.'J'.$line)->applyFromArray($border_style);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($center);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'Engineering and Operation');
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'Warehouse');
		$activeSheet->mergeCells($xcoor.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':J'.$line);
		$activeSheet->getStyle($xcoor.$line.':'.'E'.$line)->applyFromArray($border_right);
		$activeSheet->getStyle('F'.$line.':'.'J'.$line)->applyFromArray($border_right);

		$line++;

		$activeSheet->mergeCells($xcoor.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':J'.$line);
		$activeSheet->getStyle($xcoor.$line.':'.'E'.$line)->applyFromArray($border_right);
		$activeSheet->getStyle('F'.$line.':'.'J'.$line)->applyFromArray($border_right);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'Department Manager');
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'Project Warehouseman');
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);	
		$activeSheet->mergeCells($xcoor.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':J'.$line);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($center);
		$activeSheet->getStyle($xcoor.$line.':'.'E'.$line)->applyFromArray($border_bottom);
		$activeSheet->getStyle($xcoor.$line.':'.'E'.$line)->applyFromArray($border_right);
		$activeSheet->getStyle('F'.$line.':'.'J'.$line)->applyFromArray($border_bottom);
		$activeSheet->getStyle('F'.$line.':'.'J'.$line)->applyFromArray($border_right);


		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'Accounting and Finance Dept.');
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'Accounting Dept.');
		$activeSheet->mergeCells($xcoor.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':J'.$line);
		$activeSheet->getStyle($xcoor.$line.':'.'E'.$line)->applyFromArray($border_right);
		$activeSheet->getStyle('F'.$line.':'.'J'.$line)->applyFromArray($border_right);

		$line++;

		$activeSheet->mergeCells($xcoor.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':J'.$line);
		$activeSheet->getStyle($xcoor.$line.':'.'E'.$line)->applyFromArray($border_right);
		$activeSheet->getStyle('F'.$line.':'.'J'.$line)->applyFromArray($border_right);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'Department Manager');
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'Project Accountant');
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);	
		$activeSheet->mergeCells($xcoor.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':J'.$line);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($center);
		$activeSheet->getStyle($xcoor.$line.':'.'E'.$line)->applyFromArray($border_bottom);
		$activeSheet->getStyle($xcoor.$line.':'.'E'.$line)->applyFromArray($border_right);
		$activeSheet->getStyle('F'.$line.':'.'J'.$line)->applyFromArray($border_bottom);
		$activeSheet->getStyle('F'.$line.':'.'J'.$line)->applyFromArray($border_right);


		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'Personnel Dept.');
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'Personnel and Administration Dept.');
		$activeSheet->mergeCells($xcoor.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':J'.$line);
		$activeSheet->getStyle($xcoor.$line.':'.'E'.$line)->applyFromArray($border_right);
		$activeSheet->getStyle('F'.$line.':'.'J'.$line)->applyFromArray($border_right);

		$line++;

		$activeSheet->mergeCells($xcoor.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':J'.$line);
		$activeSheet->getStyle($xcoor.$line.':'.'E'.$line)->applyFromArray($border_right);
		$activeSheet->getStyle('F'.$line.':'.'J'.$line)->applyFromArray($border_right);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'Department Manager');
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'Project Personel Officer');
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);	
		$activeSheet->mergeCells($xcoor.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':J'.$line);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($center);
		$activeSheet->getStyle($xcoor.$line.':'.'E'.$line)->applyFromArray($border_bottom);
		$activeSheet->getStyle($xcoor.$line.':'.'E'.$line)->applyFromArray($border_right);
		$activeSheet->getStyle('F'.$line.':'.'J'.$line)->applyFromArray($border_bottom);
		$activeSheet->getStyle('F'.$line.':'.'J'.$line)->applyFromArray($border_right);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'Administration Dept.');
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'Engineering and Operation');
		$activeSheet->mergeCells($xcoor.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':J'.$line);
		$activeSheet->getStyle($xcoor.$line.':'.'E'.$line)->applyFromArray($border_right);
		$activeSheet->getStyle('F'.$line.':'.'J'.$line)->applyFromArray($border_right);

		$line++;

		$activeSheet->mergeCells($xcoor.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':J'.$line);
		$activeSheet->getStyle($xcoor.$line.':'.'E'.$line)->applyFromArray($border_right);
		$activeSheet->getStyle('F'.$line.':'.'J'.$line)->applyFromArray($border_right);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'Department Manager');
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'Project Manager / In-charge');
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);	
		$activeSheet->mergeCells($xcoor.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':J'.$line);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($center);
		$activeSheet->getStyle($xcoor.$line.':'.'E'.$line)->applyFromArray($border_bottom);
		$activeSheet->getStyle($xcoor.$line.':'.'E'.$line)->applyFromArray($border_right);
		$activeSheet->getStyle('F'.$line.':'.'J'.$line)->applyFromArray($border_bottom);
		$activeSheet->getStyle('F'.$line.':'.'J'.$line)->applyFromArray($border_right);

		$line++;
		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, '2. Amount Due to Employee');
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'Item');
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$line, 'Particulars');
		$activeSheet->mergeCells('B'.$line.':E'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'Equivalent');
		$activeSheet->mergeCells('F'.$line.':I'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line, 'Amount');
		$activeSheet->getStyle($xcoor.$line.':'.'J'.$line)->applyFromArray($border_style_dash);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($center);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, '2.1');
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$line, '13th Month Pay');
		$activeSheet->mergeCells('B'.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':I'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line, '₱');
		$activeSheet->getStyle($xcoor.$line.':'.'J'.$line)->applyFromArray($border_style_dash);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($align_left);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, '2.2');
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$line, 'Earned Vacation Leave');
		$activeSheet->mergeCells('B'.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':I'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line, '₱');
		$activeSheet->getStyle($xcoor.$line.':'.'J'.$line)->applyFromArray($border_style_dash);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($align_left);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, '2.3');
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$line, 'Earned Sick Leave');
		$activeSheet->mergeCells('B'.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':I'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line, '₱');
		$activeSheet->getStyle($xcoor.$line.':'.'J'.$line)->applyFromArray($border_style_dash);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($align_left);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, '2.4');
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$line, 'Service Incentive Leave');
		$activeSheet->mergeCells('B'.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':I'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line, '₱');
		$activeSheet->getStyle($xcoor.$line.':'.'J'.$line)->applyFromArray($border_style_dash);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($align_left);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, '2.5');
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$line, 'Tax Refund');
		$activeSheet->mergeCells('B'.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':I'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line, '₱');
		$activeSheet->getStyle($xcoor.$line.':'.'J'.$line)->applyFromArray($border_style_dash);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($align_left);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, '2.6');
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$line, 'Last Salary and Overtime Pay');
		$activeSheet->mergeCells('B'.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':I'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line, '₱');
		$activeSheet->getStyle($xcoor.$line.':'.'J'.$line)->applyFromArray($border_style_dash);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($align_left);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, '2.7');
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$line, 'Others');
		$activeSheet->mergeCells('B'.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':I'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line, '₱');
		$activeSheet->getStyle($xcoor.$line.':'.'J'.$line)->applyFromArray($border_style_dash);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($align_left);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);


		$line++;

		$activeSheet->mergeCells('B'.$line.':E'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'Total');
		$activeSheet->mergeCells('F'.$line.':I'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line, '₱');
		$activeSheet->getStyle($xcoor.$line.':'.'J'.$line)->applyFromArray($border_style_dash);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);

		$line++;

		$activeSheet->mergeCells('B'.$line.':E'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'Less Accountabilities');
		$activeSheet->mergeCells('F'.$line.':I'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line, '₱');
		$activeSheet->getStyle($xcoor.$line.':'.'J'.$line)->applyFromArray($border_style_dash);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);

		$line++;

		$activeSheet->mergeCells('B'.$line.':E'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'Total Amount Due');
		$activeSheet->mergeCells('F'.$line.':I'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line, '₱ ______________');
		$activeSheet->getStyle($xcoor.$line.':'.'J'.$line)->applyFromArray($border_style_dash);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);


		$line++;
		
		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'By:');
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'By:');
		$activeSheet->getStyle($xcoor.$line.':'.'J'.$line)->applyFromArray($border_style_dash_top);
		$activeSheet->getStyle('E'.$line)->applyFromArray($border_style_dash_right);
		$activeSheet->getStyle('J'.$line)->applyFromArray($border_style_dash_right);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'Personnel Department');
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'Accounting Department');
		$activeSheet->mergeCells($xcoor.$line.':E'.$line);
		$activeSheet->mergeCells('F'.$line.':J'.$line);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($center);
		$activeSheet->getStyle($xcoor.$line.':'.'J'.$line)->applyFromArray($border_style_dash_bottom);
		$activeSheet->getStyle('E'.$line)->applyFromArray($border_style_dash_right);
		$activeSheet->getStyle('J'.$line)->applyFromArray($border_style_dash_right);

		$line++;
		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'RELEASE OF CLAIM');
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);
		$activeSheet->mergeCells($xcoor.$line.':J'.$line);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($center);

		$line++;

		
		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'This is to certify that I have received in full all my salaries, wages, and overtime pay as of the date they fell due corresponding to my services');
		$activeSheet->getStyle($xcoor.$line)->getFont()->setSize(8);
		$activeSheet->mergeCells($xcoor.$line.':J'.$line);

		$line++;

		
		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'rendered, as well as, all benefits due me under the New Labor Code, Social Security Act (SSA) and all existing labor laws, during my');
		$activeSheet->getStyle($xcoor.$line)->getFont()->setSize(8);
		$activeSheet->mergeCells($xcoor.$line.':J'.$line);

		$line++;

		
		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'employment and I hereby declare that I have no claim whatsoever against said Company and / or Project.  By these presents and all legal intents ');
		$activeSheet->getStyle($xcoor.$line)->getFont()->setSize(8);
		$activeSheet->mergeCells($xcoor.$line.':J'.$line);

		$line++;

		
		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'and purposes, I hereby forever release and discharge Riofil Corporation from any liability or responsibility arising out of my employment, under the ');
		$activeSheet->getStyle($xcoor.$line)->getFont()->setSize(8);
		$activeSheet->mergeCells($xcoor.$line.':J'.$line);

		$line++;

		
		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'New Labor Code, SSA and other labor laws, the same having been fully compensated, settled and fully paid to me and to my satisfaction.');
		$activeSheet->getStyle($xcoor.$line)->getFont()->setSize(8);
		$activeSheet->mergeCells($xcoor.$line.':J'.$line);

		$line++;
		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'Employee:');
		$activeSheet->mergeCells($xcoor.$line.':B'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$line, 'Date:');
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->applyFromArray($bold);	
		$activeSheet->getStyle('C'.$line.':'.'E'.$line)->applyFromArray($border_bottom);
		$activeSheet->getStyle('H'.$line.':'.'J'.$line)->applyFromArray($border_bottom);
		$activeSheet->mergeCells('C'.$line.':E'.$line);
		$activeSheet->getStyle($xcoor.$line.':J'.$line)->getFont()->setSize(11);

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