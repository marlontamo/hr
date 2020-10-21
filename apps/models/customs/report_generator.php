<?php //delete me
	function get_report( $record_id )
	{
		$data = array();
		$this->db->limit(1);
		$data['main'] = $this->db->get_where( $this->table, array( $this->primary_key => $record_id ) )->row();
		$data['tables'] = $this->db->get_where( 'report_generator_tables', array( $this->primary_key => $record_id ) )->result();
		$data['columns'] = $this->db->get_where( 'report_generator_columns', array( $this->primary_key => $record_id ) )->result();
		$qry = "Select a.*, b.label
		FROM {$this->db->dbprefix}report_generator_filters a
		LEFT JOIN {$this->db->dbprefix}report_generator_filter_operators b ON b.operator = a.operator
		WHERE a.report_id = {$record_id} AND a.type = 1";
		$data['fixed_filters'] = $this->db->query( $qry );
		$qry = "Select a.*, b.label
		FROM {$this->db->dbprefix}report_generator_filters a
		LEFT JOIN {$this->db->dbprefix}report_generator_filter_operators b ON b.operator = a.operator
		WHERE a.report_id = {$record_id} AND a.type = 2";
		$data['editable_filters'] = $this->db->query( $qry );
		$data['groups'] = $this->db->get_where( 'report_generator_grouping', array( $this->primary_key => $record_id ) );
		$data['sorts'] = $this->db->get_where( 'report_generator_sorting', array( $this->primary_key => $record_id ) );
		$this->db->limit(1);
		$data['header'] = $this->db->get_where( 'report_generator_letterhead', array( $this->primary_key => $record_id, 'place_in' => 1 ) )->row();
		$this->db->limit(1);
		$data['footer'] = $this->db->get_where( 'report_generator_letterhead', array( $this->primary_key => $record_id, 'place_in' => 2 ) )->row();
		return $data;
		return $data;
	}

	function export_query( $report, $filters = false )
	{
		if($filters)
		{
			foreach( $report['editable_filters']->result() as $row )
			{
				$filter[$row->filter_id] = $row;
			}

			foreach ($filters as $filter_id => $value) {
				$row = $filter[$filter_id];
				
				switch( $row->uitype_id )
				{
					case 3:
						$value = date('Y-m-d', strtotime( $value ));
						break;
					case 4:
						$value = date('Y-m-d H:i:s', strtotime( $value ));
						break;
					case 5:
						$value = date('H:i:s', strtotime( $value ));
						break;
				}

				if( $row->uitype_id != 1 || ( $row->uitype_id == 1 && $value != 'all' ) )
					$where[$row->bracket][] = $row->column . $row->operator . '"' . $value .'" ' . $row->logical_operator;
				else
					$where[$row->bracket][] = "1 " . $row->logical_operator;
			}

			foreach( $where as $bracket => $filters )
			{
				$where_str[] = '(' . implode(' ', $filters) . ')';
			}

			if( $report['fixed_filters']->num_rows() > 0 )
				$query = $report['main']->main_query . " AND (" . implode(' AND ', $where_str) . ")";
			else
				$query = $report['main']->main_query . " WHERE " . implode(' AND ', $where_str);
		}
		else{
			$query = $report['main']->main_query;
		}
		
		if( $report['groups']->num_rows() > 0 )
		{
			$query .= " GROUP BY ";
			foreach($report['groups']->result() as $row)
			{
				$groups[] = $row->column;
			}
			$query .= implode(", ", $groups);
		}

		if( $report['sorts']->num_rows() > 0 )
		{
			$query .= " ORDER BY ";
			foreach($report['sorts']->result() as $row)
			{
				$sorts[] = $row->column . " " . $row->sorting;
			}
			$query .= implode(", ", $sorts);
		}

		return $query;
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

	function export_excel( $report, $columns, $result )
	{
		switch($report->report_code)
		{
			case 'TARDY':
				$excel = $this->load->view("templates/tardy", array('result' => $result), true);
				break;
			case 'IAR':
				$excel = $this->load->view("templates/iar", array('result' => $result), true);
				break;
			case 'OT':
				$excel = $this->load->view("templates/ot", array('result' => $result), true);
				break;
			case 'COMPLIANCE':
				$excel = $this->load->view("templates/compliance", array('result' => $result), true);
				break;
			case 'OT_ALLOWANCE':
				$excel = $this->load->view("templates/ot_allowance", array('result' => $result), true);
				break;	
			default:
				$excel = $this->load->view("templates/excel", array('result' => $result), true);
		}
		
		$this->load->helper('file');
		$path = 'uploads/reports/' . $report->report_code .'/excel/';
		$this->check_path( $path );
		$filename = $path . strtotime(date('Y-m-d H:i:s')) . '-' . $report->report_code . ".xlsx";
		$tmpfile = $path . strtotime(date('Y-m-d H:i:s')) . ".html";
		write_file( $tmpfile, $excel);

		$this->load->library('excel');

		$reader = new PHPExcel_Reader_HTML(); 
		$content = @$reader->load($tmpfile); 
		$content->getActiveSheet()->removeRow(1, 1); //somehow 1st row is an empty row so we remove it

		$vars =  $this->load->get_cached_vars();
		if( empty($vars['header']->template) ){
			
			$letters = range('A','Z');
			$index = 0;
			foreach($columns as $column)
			{
				$row = $letters[$index]."1";
				$content->getActiveSheet()->getStyle("$row:$row")->getFont()->setBold(true);
				$index++;
			}
		}

		$objWriter = PHPExcel_IOFactory::createWriter($content, 'Excel2007');
		$objWriter->save( $filename );

		// Delete temporary file
		unlink($tmpfile);

		return $filename;
	}

	function export_csv( $report, $columns, $result )
	{
		$csv = $this->load->view("templates/csv", array('columns' => $columns,'result' => $result), true);
		$this->load->helper('file');
		$path = 'uploads/reports/' . $report->report_code .'/csv/';
		$this->check_path( $path );
		$filename = $path . strtotime(date('Y-m-d H:i:s')) . '-' . $report->report_code . ".csv";
		write_file( $filename, $csv);
		return $filename;
	}

	function export_pdf( $report, $columns, $result )
	{
		$this->load->library('Pdf');
		$user = $this->config->item('user');

		$pdf = new Pdf();
		$pdf->SetTitle( $report->report_name );
		$pdf->SetFontSize(8,true);
		$pdf->SetAutoPageBreak(true, 5);
		$pdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );
		$pdf->SetDisplayMode('real', 'default');

		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);

		$pdf->AddPage();

		switch($report->report_code)
		{
			case 'TARDY':
				$pdf->setPageOrientation('L');
				$html = $this->load->view("templates/tardy", array('columns' => $columns,'result' => $result), true);
				break;
			case 'IAR':
				$pdf->setPageOrientation('L');
				$html = $this->load->view("templates/iar", array('columns' => $columns,'result' => $result), true);
				break;
			case 'OT':
				$pdf->setPageOrientation('L');
				$html = $this->load->view("templates/ot", array('columns' => $columns,'result' => $result), true);
				break;
			case 'COMPLIANCE':
				$pdf->setPageOrientation('L');
				$html = $this->load->view("templates/compliance", array('columns' => $columns,'result' => $result), true);
				break;
			case 'OT_ALLOWANCE':
				$pdf->setPageOrientation('L');
				$html = $this->load->view("templates/ot_allowance", array('columns' => $columns,'result' => $result), true);
				break;
			default:
				$html = $this->load->view("templates/pdf", array('columns' => $columns,'result' => $result), true);
		}

		$this->load->helper('file');
		$path = 'uploads/reports/' . $report->report_code .'/pdf/';
		$this->check_path( $path );
		$filename = $path . strtotime(date('Y-m-d H:i:s')) . '-' . $report->report_code . ".pdf";
		$pdf->writeHTML($html, true, false, false, false, '');
		$pdf->Output($filename, 'F');

		return $filename;
	}
	