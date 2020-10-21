<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

include_once APPPATH.'third_party/TCPDF/config/tcpdf_config.php';
include_once APPPATH.'third_party/TCPDF/tcpdf.php';

class MYPDF extends TCPDF {
	public function Header(){
		if($_POST['background'] != 0 ){
			// get the current page break margin
	        $bMargin = $this->getBreakMargin();
	        // get current auto-page-break mode
	        $auto_page_break = $this->AutoPageBreak;
	        // disable auto-page-break
	        $this->SetAutoPageBreak(false, 0);
	        // set bacground image
	        switch ($_POST['report_code']) {

	            case 'SSSR3':
	                $background = 'uploads/payroll_report/sss_monthly-1_web.jpg';
	                $this->Image($background, 10, 10, 260, 195, 'JPG', '', '', false, 100, '', false, false, 0, false, false, false);
	                break;
	            case 'SSSR1A': 
	                $background = 'uploads/payroll_report/sss_r-1a.jpg';
	                $this->Image($background, 10, 10, 260, 195, 'JPG', '', '', false, 100, '', false, false, 0, false, false, false);
	                break;    
	            case 'SSSR5':
	                $background = 'uploads/payroll_report/sss-r5-edit.jpg';
	                $this->Image($background, 11, 15, 187, 194.8, 'JPG', '', '', false, 100, '', false, false, 0, false, false, false);
	                break;   
	            case 'PHICRF1':
	            	$background = 'uploads/payroll_report/rf1.jpg';
		        	$this->Image($background, 10, 10, 260, 195, 'JPG', '', '', false, 100, '', false, false, 0, false, false, false);
		        	break;
	            case 'PHICER2':
	            	$background = 'uploads/payroll_report/PHIC_er2.JPG';
		        	$this->Image($background, 18, 10, 260, 195, 'JPG', '', '', false, 100, '', false, false, 0, false, false, false);
		        	break;
	            case 'HDMFM1': 
	                $background = 'uploads/payroll_report/pagibig_m1-1_web.jpg';
	                $this->Image($background, 8, 7, 199.5, 264.8, 'JPG', '', '', false, 100, '', false, false, 0, false, 0, false);
	                break;
	            case 'HDMFP2-4':
	            	$background = 'uploads/payroll_report/HDMF_P2_4.jpg';
	                $this->Image($background, 8, 7, 199.5, 264.8, 'JPG', '', '', false, 100, '', false, false, 0, false, 0, false);
	                break;
	            case 'HDMFMCRF': 
	                $background = 'uploads/payroll_report/mcrf_001.jpg';
	                $this->Image($background, 8, 7, 199.5, 264.8, 'JPG', '', '', false, 100, '', false, false, 0, false, 0, false);
	                break;
	            case 'HDMFSTLRF': 
	                $background = 'uploads/payroll_report/stlrf_001.jpg';
	                $this->Image($background, 8, 7, 199.5, 264.8, 'JPG', '', '', false, 100, '', false, false, 0, false, 0, false);
	                break;
	            case 'BIR1601C': 
	                $background = 'uploads/payroll_report/BIR_1601-C.JPG';
	                $this->Image($background, 8, 7, 199.5, 264.8, 'JPG', '', '', false, 100, '', false, false, 0, false, 0, false);
	                break;
	            case 'schedule_7_1':
	            case 'schedule_7_3':
	            	$header = '	<table>
				                    <tr>
				                        <td style=" width: 50%; text-align:   left; font-size: 6; ">Run Date : '.date('h:m:sa, m/d/Y').'</td>
				                        <td style=" width: 50%; text-align:  right; font-size: 6; ">Page : &nbsp;'.$this->getAliasNumPage().' of '.$this->getAliasNbPages().'</td>
				                    </tr>
								    <tr>
								        <td width="100%" style=" font-size: 6 ; text-align: left   ;">'.$_POST['schedule'].'></td>
								    </tr>
								    <tr>
								        <td width="100%" style=" font-size: 7 ; text-align: center ;"><strong>'.$_POST['company'].'></strong></td>
								    </tr>
								    <tr>
								        <td width="100%" style=" font-size: 7 ; text-align: center ;"><strong>'.$_POST['address'].'></strong> </td>
								    </tr>
								    <tr>
								        <td width="100%" style=" font-size: 5 ; text-align: center ;"></td>
								    </tr>
								    <tr>
								        <td width="100%" style=" font-size: 7 ; text-align: center ;"><strong>'.$_POST['title'].'></strong></td>
								    </tr>
								    <tr>
								        <td width="100%" style=" font-size: 7 ; text-align: center ;"><strong>'.$_POST['label'].'></strong> </td>
								    </tr>
								    <tr>
								        <td width="100%" style=" font-size: 5 ; text-align: center ;"></td>
								    </tr>
								</table>
								<table style="padding: 1; border: .5px solid black;"> 
								    <tr>
								        <td width=" 1.5%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">SEQ<br>NO.<br><br><br><br><br><br><br><br>(1)</td>
								        <td width="   4%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">TAXPAYER<br>ID NUMBER<br><br><br><br><br><br><br><br>(2)</td>
								        <td width="  10%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">NAME OF EMPLOYEE<br><br><br><br><br><br><br><br><br>(3a-3c)</td>
								        <td width="   5%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">GROSS<br>COMPENSATION<br>INCOME<br><br><br><br><br><br><br>(4a)</td>
								        <td width="   4%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">NON<br>TAXABLE<br>13TH MONTH<br>PAY &<br>OTHER<br>BENEFITS<br><br><br><br>(4b)</td>
								        <td width="   4%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">NON<br>TAXABLE<br>DEMMINIMIS<br>BENEFITS<br><br><br><br><br><br>(4c)</td>
								        <td width="   4%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">NON<br>TAXABLE<br>SSS,GSIS<br>PHC &<br>PAG-IBIG<br>CONTRIBUTION<br>& UNION<br>DUES<br>(4d)</td>
								        <td width="   4%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">NON<br>TAXABLE<br>SALARIES &<br>OTHER<br>FORMS OF<br>COMPENSATION<br><br><br>(4e)</td>
								        <td width="   4%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">TOTAL NON<br>TAXABLE/<br>EXEMPT<br>COMPENSATION<br>INCOME<br><br><br><br>(4f)</td>
								        <td width="   5%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">TAXABLE<br>BASIC<br>SALARY<br><br><br><br><br><br><br>(4g)</td>
								        <td width="   5%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">TAXABLE<br>13TH MONTH<br>PAY & OTHER<br>BENEFITS<br><br><br><br><br><br>(4h)</td>
								        <td width="   6%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">TAXABLE<br>SALARIES &<br>OTHER<br>FORMS OF<br>COMPENSATION<br><br><br><br><br>(4i)</td>
								        <td width="   6%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">TOTAL TAXABLE<br>COMPENSATION<br>INCOME<br><br><br><br><br><br><br>(4j)</td>
								        <td width="   2%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">EXEM<br>PTION<br>CODE<br><br><br><br><br><br><br>(5a)</td>
								        <td width=" 3.5%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">EXMEPT<br>ION AMT<br><br><br><br><br><br><br><br>(5b)</td>
								        <td width=" 2.5%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">PREM.<br>PAID ON<br>HEALTH<br>AND/OR<br>HOSP.<br>INS.<br><br><br><br>(6)</td>
								        <td width="   5%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">NET TAXABLE<br>COMPENSATION<br><br><br><br><br><br><br><br>(7)</td>
								        <td width=" 4.5%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">TAX DUE<br>(JAN.-DEC.)<br><br><br><br><br><br><br><br>(8)</td>
								        <td width=" 4.5%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">TAX<br>WITHHELD<br>(JAN-NOV.30)<br><br><br><br><br><br><br>(9)</td>
								        <td width="   4%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">YEAR-END<br>ADJUSTMENT<br>AMOUNT<br>WITHHELD<br>& PAID<br>FOR DEC<br><br><br>(10a) = <br>(8) - (9)</td>
								        <td width="   4%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">YEAR-END<br>ADJUSTMENT<br>OVER<br>W/HELD TAX<br>REFUNDED TO<br>EMPLOYEE<br><br><br>(10b) = <br>(9) - (8)</td>
								        <td width="   5%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">AMOUNT OF<br>TAX W/HELD<br>AS<br>ADJUSTED<br><br><br><br>(11) = <br>(9+10a)<br>OR (9-10b)</td>
								        <td width="   2%" style=" font-size: 5 ; text-align:center; vertical-align:top; border-left: 1px solid black; border-right: 1px solid black;">SUBS<br>TITU<br>TED<br>FILING<br>YES<br>/NO<br><br><br><br>(12)</td>
								    </tr>
								</table>';
					break;
				case 'schedule_7_3':
					break;
	                
	        }
	        // restore auto-page-break status
	        $this->SetAutoPageBreak($auto_page_break, $bMargin);
	        // set the starting point for the page content
	        $this->setPageMark();
		}else{
			$header = '<table>
		                    <tr>
		                        <td style=" width: 50%; text-align:   left; font-size: 6; ">Run Date : '.date('h:m:sa, m/d/Y').'</td>
		                        <td style=" width: 50%; text-align:  right; font-size: 6; ">Page : &nbsp;'.$this->getAliasNumPage().' of '.$this->getAliasNbPages().'</td>
		                    </tr>
		              </table>';
        	$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $header, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
		}
        
    }

    public function Footer(){
        $footer = '<table style="width: 100%">
                    <tr>
                        <td style=" width: 30%; text-align:left  ; font-size: 7; ">Prepared By: </td>
                        <td style=" width:  3%; text-align:center; font-size: 7; "></td>
                        <td style=" width: 30%; text-align:left  ; font-size: 7; ">Checked By: </td>
                        <td style=" width:  3%; text-align:center; font-size: 7; "></td>
                        <td style=" width: 30%; text-align:left  ; font-size: 7; ">Approved By:</td>
                        <td style=" width:  3%; text-align:center; font-size: 7; "></td>
                    </tr>
                    <tr><td></td></tr><tr><td></td></tr>
                    <tr>
                        <td style=" width: 30%; text-align:left; border-top: 1px solid black ; font-size: 7; "></td>
                        <td style=" width:  3%; text-align:right; font-size: 7; "></td>
                        <td style=" width: 30%; text-align:left; border-top: 1px solid black ; font-size: 7; "></td>
                        <td style=" width:  3%; text-align:right;"></td>
                        <td style=" width: 30%; text-align:left; border-top: 1px solid black ; font-size: 7; "></td>
                        <td style=" width:  3%; text-align:right; font-size: 7; "></td>                                    
                    </tr>
                    <tr><td style=" width: 100%; font-size: 15; border-bottom: 1px solid black; "></td></tr>
                    <tr>
                        <td style=" width: 50%; text-align:   left; font-size: 6; ">Run Date : '.date('h:m:sa, m/d/Y').'</td>
                        <td style=" width: 50%; text-align:  right; font-size: 6; ">Page : &nbsp;'.$this->getAliasNumPage().' of '.$this->getAliasNbPages().'</td>
                    </tr>
              </table>';
        $this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $footer, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
    }
}

class report_generator_model extends Record
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
		$this->mod_id = 88;
		$this->mod_code = 'report_generator';
		$this->route = 'admin/report_generator';
		$this->url = site_url('admin/report_generator');
		$this->primary_key = 'report_id';
		$this->table = 'report_generator';
		$this->icon = '';
		$this->short_name = 'Reports Generator';
		$this->long_name  = 'Reports Generator';
		$this->description = '';
		$this->path = APPPATH . 'modules/report_generator/';

		parent::__construct();
	}

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
		WHERE a.report_id = {$record_id} AND a.type = 2 ORDER BY order_by";
		$data['editable_filters'] = $this->db->query( $qry );
		$data['groups'] = $this->db->get_where( 'report_generator_grouping', array( $this->primary_key => $record_id ) );
		$data['sorts'] = $this->db->get_where( 'report_generator_sorting', array( $this->primary_key => $record_id ) );
		$this->db->limit(1);
		$data['header'] = $this->db->get_where( 'report_generator_letterhead', array( $this->primary_key => $record_id, 'place_in' => 1 ) )->row();
		$this->db->limit(1);
		$data['footer'] = $this->db->get_where( 'report_generator_letterhead', array( $this->primary_key => $record_id, 'place_in' => 2 ) )->row();
		
		$user = $this->config->item('user');
		$data['region_companies'] = $user['region_companies'];
		return $data;	}

	function export_query( $report, $filters = false )
	{
		if($filters)
		{
			foreach( $report['editable_filters']->result() as $row )
			{
				$filter[$row->filter_id] = $row;
			}

			foreach ($filters as $filter_id => $value) {
				
				if (array_key_exists($filter_id, $filter)){
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

					// Post al filters 
					$col = substr($row->column, strpos($row->column, ".")+1, strlen($row->column));

					$_POST[$col] = $value;					
				}

				if( is_array($value) ){
					
					$value = array_filter($value);
					$value = implode(',', $value);
					
					if(empty($value)) continue;
					
					$where[$row->bracket][] = $row->column .'  '. $row->operator . '  (' . $value .') '; //. $row->logical_operator;
					
				}else{
					if( $row->uitype_id != 1 || ( $row->uitype_id == 1 && $value != 'all' ) )
						if ($row->uitype_id == 3){
							$col = 'DATE (' . substr($row->column, strpos($row->column, ".")+1, strlen($row->column)) .')';
							$where[$row->bracket][] = 'DATE (' . $row->column .')' . $row->operator . ' "' . $value .'" '; //. $row->logical_operator;
						}
						else{
							$where[$row->bracket][] = $row->column . $row->operator . ' "' . $value .'" '; //. $row->logical_operator;
						}						
					else
						$where[$row->bracket][] = "1 "; //. $row->logical_operator;
				}

			}
			
			foreach( $where as $bracket => $filters )
			{
				$where_str[] = '(' . implode(' AND ', $filters) . ')';
			}

			if( $report['fixed_filters']->num_rows() > 0 ){
				$query = $report['main']->main_query . " AND (" . implode(' AND ', $where_str) . ")";
			}
			else{
				$query = $report['main']->main_query . " WHERE " . implode(' AND ', $where_str);
			}
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

	function export_excel( $report, $columns, $result, $filter )
	{
		ini_set('memory_limit', '1024M');   
        ini_set('max_execution_time', 1800);
        $excelcolumn = '';
        $header = 1; // to bold the header default is BOLD
        $lmr_header = 0; 
        $slvlm_header = 0; 
        $od_header = 0; //other deduction 
        $manstatus_header = 0; //manpower status report
        $sd_header = 0; //salary distribution report
        $payreg_header = 0; //for payroll register per position
        $pmcs_header = 0; //payroll manpower charging summary
        $pec_header = 0; //payroll exit clearance
        if(isset($_POST['filter']))
            $filter = $_POST['filter'];
        else
            $filter = '';

        // for "LOGS MONITORING" filter of Riofil
        if(isset($_POST['filter'])) {
            $company = array_slice($_POST['filter'],0);
            $project = array_slice($_POST['filter'],2);
            $payroll_rate_type = array_slice($_POST['filter'],3);

            if(!empty($company)){
                $report_company = $company[0];
            }

            if(!empty($project)){
                $report_project = $project[0];
            }

            if(!empty($payroll_rate_type)){
                $report_payroll_rate_type = $payroll_rate_type[0];
            }
        }

        // for "SL VL MONITORING" filter of riofil
        if(isset($_POST['filter'])) {
            $company_riofil = array_slice($_POST['filter'],0);
            $project_riofil = array_slice($_POST['filter'],1);
            $department_riofil = array_slice($_POST['filter'],2);
            $payroll_year_riofil = array_slice($_POST['filter'],3);

            if(!empty($project_riofil)){ 
                $report_project_riofil = $project_riofil[0];
            }

            if(!empty($payroll_year_riofil)){
                $report_payroll_year_riofil = $payroll_year_riofil[0];
            }

            if(!empty($company_riofil)){
                $report_company_riofil = $company_riofil[0];
            }

            if(!empty($department_riofil)){
                $report_department_riofil = $department_riofil[0];
            }
        }

        $reports = $this->get_report( $this->input->post( 'record_id' ) );
		$query = $this->export_query( $reports, $filter );	
		switch($report->report_code)
		{
			case 'INCIDENT':
				$excel = $this->load->view("templates/incident", array('result' => $result, 'filter' => $filter), true);
				break;				
			case 'TARDY':
				$excel = $this->load->view("templates/timekeeping_tardy", array('result' => $result, 'month' => $report_company_riofil), true);
				break;
			case 'PAR': 
				$excel = $this->load->view("templates/timekeeping_par", array('result' => $result, 'month' => $report_company_riofil), true);
				break;					
			case 'IAR':
				$excel = $this->load->view("templates/timekeeping_iar", array('result' => $result), true);
				break;
			case 'OT':
				$excel = $this->load->view("templates/timekeeping_ot", array('result' => $result), true);
				break;
			case 'COMPLIANCE':
				$excel = $this->load->view("templates/timekeeping_compliance", array('result' => $result), true);
				break;
			case 'OT_ALLOWANCE':
				$excel = $this->load->view("templates/payroll_ot_allowance", array('result' => $result), true);
				break;
			case 'BALMA':
				$excel = $this->load->view("templates/balma", array('result' => $result), true);
				break;	
			case 'OTTRANSAL':
				$excel = $this->load->view("templates/ottransal", array('result' => $result), true);
				break;
			case 'MMAC':
				$excel = $this->load->view("templates/mmac", array('result' => $result), true);
				break;
			case 'MATADTO':
				$excel = $this->load->view("templates/matadto", array('result' => $result), true);
				break;
			case 'MARBD':
				$excel = $this->load->view("templates/marbd", array('result' => $result), true);
				break;	
            case 'Manpower Movement Report':
                $excel = $this->load->view("templates/partners_manpower_movement_report", array('result' => $result), true);
                break;
            case 'attrition_report':
                $excel = $this->load->view("templates/partners_attrition_report", array('result' => $result), true);
                $excelcolumn = 'BV';
                break;
            case 'THIRTEEN_MONTH_BASIS':
                $excel = $this->load->view("templates/payroll_thirteen_month_basis", array('result' => $result), true);
                $excelcolumn = 'AZ';
                break;
            case 'HDMFMR':
            	$excel = $this->load->view("templates/hdmf_monthly_remittance_excel", array('result' => $result), true);
                // $excelcolumn = 'AZ';
                break;
            case 'SSSMR':
            	$excel = $this->load->view("templates/sss_monthly_remittance_excel", array('result' => $result), true);
            	// $excelcolumn = 'AZ';
                break;
            case 'PRELIM';  
            	$header = 0;  
            	$excel = $this->load->view("templates/payroll_prelim_excel",array('columns' => $columns,'result' => $result), true);    
				break;
            case 'PAYREGEARN';    
            case 'PAYREGDED';    
            case 'PRELIM DED';    
            case 'PRELIM_EARN':
            	$excel = $this->load->view("templates/payroll_earning_deduction_excel",array('columns' => $columns,'result' => $result, 'query' => $query, 'report_name' => $report->report_name), true);    
				break;   
            case 'ATMREG':
            	$excel = $this->load->view("templates/payroll_atmreg_excel",array('columns' => $columns,'result' => $result, 'query' => $query, 'report_name' => $report->report_name), true);    
				break; 
            case 'DEDSCHEDDTL':
            	$excel = $this->load->view("templates/payroll_deduction_schedule_detail_excel",array('columns' => $columns,'result' => $result), true);    
				break;
            case 'HDMFQRT':
			    $header = $this->db->query($query)->row();
            	$excel = $this->load->view("templates/hdmf_quarterly_excel",array('columns' => $columns,'result' => $result, 'query' => $query, 'header' => $header), true);    
				break;
            case 'PAYREG':
            	$header = 0;
            	$excel = $this->load->view("templates/payroll_payreg_excel",array('columns' => $columns,'result' => $result), true);    
				break;
			case 'PAYROLL REGISTER HISTORICAL':
            	$excel = $this->load->view("templates/payroll_payregclosed_excel",array('columns' => $columns,'result' => $result), true);    
				break;	
			case 'PAYROLL REGISTER PRELIMINARY':
            	$excel = $this->load->view("templates/payroll_payregcurrent_excel",array('columns' => $columns,'result' => $result), true);    
				break;	
			case 'PAYREG_COST_CENTER':	
				$excel = $this->load->view("templates/payroll_payregcostcenter_excel",array('columns' => $columns,'result' => $result), true);    
				break;	
			case 'Journal Details Bayleaf':
				$header = 0;
				$excel = $this->load->view("templates/payroll_journal_details_bayleaf_excel",array('result' => $result), true);
				break;
			case 'Journal Headers Bayleaf':
				$header = 0;
				$excel = $this->load->view("templates/payroll_journal_headers_bayleaf_excel",array('result' => $result), true);
				break;
			case 'Journal Voucher Bayleaf':
				$header = 0;
				$excel = $this->load->view("templates/payroll_journal_voucher_bayleaf_excel",array('result' => $result), true);
				break;
			case 'Journal Voucher':
				$header = 0;
				$excel = $this->load->view("templates/payroll_journal_voucher_excel",array('result' => $result), true);
				break;
			case 'SALARIES PER DEPARTMENT':
				$excel = $this->load->view("templates/payroll_salaries_per_dept",array('columns' => $columns,'result' => $result, 'query' => $query, 'report_name' => $report->report_name), true);    
				break;
			case 'MONTHLY_TAX_SCHED':
				$excel = $this->load->view("templates/monthly_tax_sched_excel",array('columns' => $columns,'result' => $result, 'query' => $query, 'report_name' => $report->report_name), true);    
				break;			
			case 'ALPHALIST SUMMARY':
				$header = 0;
				$excel = $this->load->view("templates/year_end_summary",array('result' => $result), true);
				break;	
			case 'YTD_TAX_SUMMARY':
				$header = 0;
				$excel = $this->load->view("templates/ytd_tax_summary",array('result' => $result), true);
				break;
			case 'LEAVE_SUM':
				$excel = $this->load->view("templates/leave_summary", array('result' => $result), true);
				break;
			case 'PAYROLL_EXIT_CLEARANCE':
				$header = 0;
				$pec_header = 1;
				$excel = $this->load->view("templates/payroll_exit_clearance", array('columns' => $columns, 'result' => $result, 'query' => $query, 'report_name' => $report->report_name,'r_company' => $report_company, 'r_payroll_rate_type'=> $report_project), true);
				break;
			case 'PAYROLL_MANPOWER_CHARGING':
				$header = 0;
				//$pmcs_header = 1;
				$excel = $this->load->view("templates/payroll_manpower_charging", array('columns' => $columns, 'result' => $result, 'query' => $query, 'report_name' => $report->report_name,'r_company' => $report_company, 'r_payroll_rate_type'=> $report_project), true);
				break;
			case 'PAYROLL_MANPOWER_CHARGING_SUMMARY':
				$header = 0;
				$pmcs_header = 1;
				$excel = $this->load->view("templates/payroll_manpower_charging_summary", array('columns' => $columns, 'result' => $result, 'query' => $query, 'report_name' => $report->report_name,'r_company' => $report_company, 'r_payroll_rate_type'=> $report_project), true);
				break;
			case 'PAYROLL_REGISTER_POSITION_PRELIMINARY':
				$header = 0;
				$payreg_header = 1;
				$excel = $this->load->view("templates/payroll_register_position_preliminary", array('columns' => $columns, 'result' => $result, 'query' => $query, 'report_name' => $report->report_name,'r_company' => $report_company, 'r_payroll_rate_type'=> $report_project), true);
				break;
			case 'PAYROLL_REGISTER_POSITION_HISTORICAL':
				$header = 0;
				$payreg_header = 1;
				$excel = $this->load->view("templates/payroll_register_position_historical", array('columns' => $columns, 'result' => $result, 'query' => $query, 'report_name' => $report->report_name,'r_company' => $report_company, 'r_payroll_rate_type'=> $report_project), true);
				break;
			case 'SALARY_DISTRIBUTION':
				$header = 0;
				$sd_header = 1;
				$excel = $this->load->view("templates/payroll_salary_distribution", array('columns' => $columns, 'result' => $result, 'query' => $query, 'report_name' => $report->report_name,'r_company' => $report_company, 'r_payroll_rate_type'=> $report_project), true);
				break;
			case 'OTHER_DEDUCTION':
				$header = 0;
				$od_header = 1;
				$excel = $this->load->view("templates/payroll_other_deduction", array('columns' => $columns, 'result' => $result, 'query' => $query, 'report_name' => $report->report_name,'r_company' => $report_company), true);
				break;
			case 'MANSTATUS':
				$header = 0;
				$manstatus_header = 1;
				$excel = $this->load->view("templates/manpower_status", array('columns' => $columns, 'result' => $result, 'query' => $query, 'report_name' => $report->report_name,'r_company' => $report_company), true);
				break;
			case 'LEAVE_MONITORING':
				$header = 0;
				$excel = $this->load->view("templates/leave_monitoring", array('columns' => $columns, 'result' => $result, 'query' => $query, 'report_name' => $report->report_name,'r_company' => $report_company, 'r_project' => $report_project), true);
				break;
			case 'LMR':
			    $header = 0;
			    $lmr_header = 1;
				$excel = $this->load->view("templates/logs_monitoring", array('columns' => $columns, 'result' => $result, 'query' => $query, 'report_name' => $report->report_name,'r_company' => $report_company, 'r_project' => $report_project, 'r_payroll_rate_type'=> $report_payroll_rate_type), true);
				break;
			case 'SL_VL_MONITORING':
			    $header = 0;
			    $slvlm_header = 1;
				$excel = $this->load->view("templates/sl_vl_monitoring", array('columns' => $columns, 'result' => $result, 'query' => $query, 'report_name' => $report->report_name,'r_company' => $report_company_riofil, 'r_project' => $report_project_riofil, 'r_department'=> $report_department_riofil, 'r_payroll_year'=> $report_payroll_year_riofil), true);
				break;
			case 'LATE':
				$excel = $this->load->view("templates/late_monitoring_report", array('result' => $result), true);
				break;
			case 'TAX_COMPENSATION':
				$excel = $this->load->view("templates/payroll_tax_compensation", array('result' => $result), true);
				break;
			case 'PHICMRMR':
				$excel = $this->load->view("templates/phic_monthly_remittance_excel", array('result' => $result), true);
				break;
			case 'PAYROLLLOAN':
				$header = 0;
				$excel = $this->load->view("templates/payroll_loan_excel", array('result' => $result), true);
				break;
			case 'AUTHORITY TO DEBIT':
				$header = 0;
				$excel = $this->load->view("templates/payroll_authority_debit_excel", array('result' => $result), true);
				break;
			case 'PAYROLL_PAYMENT_SUMMARY':
				$header = 0;
				$excel = $this->load->view("templates/payroll_payment_summary", array('result' => $result), true);
				break;
            case 'PAYROLL_CASH_PAYMENT':
            	$header = 0;
				$excel = $this->load->view("templates/payroll_cash_payment", array('result' => $result), true);
				break;
			case 'HDMFSTLRF': //Pag-Ibig STLRF
				$header = 0;
        		$excel = $this->load->view("templates/hdmf_stlrf_excel", array('result' => $result), true);
                break;
            case 'SSSLOAN': //Pag-Ibig STLRF
				$header = 0;
        		$excel = $this->load->view("templates/sss_loan_excel", array('result' => $result), true);
                break;
			default:
				$excel = $this->load->view("templates/excel", array('result' => $result), true);
				break;
		}
		
		$this->load->helper('file');
		$path = 'uploads/reports/' . $report->report_code .'/excel/';
		$this->check_path( $path );
		$filename = $path . strtotime(date('Y-m-d H:i:s')) . '-' . $report->report_code . ".xlsx";
		$tmpfile = $path . strtotime(date('Y-m-d H:i:s')) . ".html";
		write_file( $tmpfile, $excel);

		$this->load->library('excel');

		$reader = new PHPExcel_Reader_HTML(); 
		$content = $reader->load($tmpfile); 
		
		if($header > 0){
			$vars =  $this->load->get_cached_vars();
			if( empty($vars['header']->template) ){
				
	            // $letters = range('A','Z');
	            //Use createColumnsArray for long excel columns, php  range() cant handle long columns
	            $excelcolumn = ($excelcolumn == '') ? 'Z' : $excelcolumn;
				$letters = $this->createColumnsArray($excelcolumn);
				$index = 0;
				foreach($columns as $column)
				{
					$row = $letters[$index]."1";
					$content->getActiveSheet()->getStyle("$row:$row")->getFont()->setBold(true);
					$index++;
				}
			}
		}

		$border_style = array(
					'borders' => array(
					    'allborders' => array(
					      'style' => PHPExcel_Style_Border::BORDER_THIN
					    )
					  )
					);

		if($lmr_header == 1){

	            $excelcolumn = ($excelcolumn == '') ? 'Z' : $excelcolumn;
				$letters = $this->createColumnsArray($excelcolumn);
				$index = 0;
				$index_to_wrap = 1;
				$style = array(
			        'alignment' => array(
			            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			        )
			    );

				for ($index; $index <= 25; $index++) {

				  	$row = $letters[$index]."1";
				  	$row_date_range = $letters[$index]."2";
				  	$row_company = $letters[$index]."4";
				  	$row_project = $letters[$index]."5";
				  	$row_header = $letters[$index]."6";
					$row_wrap_num = $letters[$index]."100";

					$content->getActiveSheet()->getColumnDimension($letters[$index])->setAutoSize(true);
					$content->getActiveSheet()->getStyle("$row:$row")->getFont()->setBold(true);
					$content->getActiveSheet()->getStyle("$row:$row")->getFont()->setSize(14);

					$content->getActiveSheet()->getStyle("$row_date_range:$row_date_range")->getFont()->setBold(true);
					$content->getActiveSheet()->getStyle("$row_date_range:$row_date_range")->getFont()->setSize(12);

					$content->getActiveSheet()->getStyle("$row_company:$row_company")->getFont()->setBold(true);
					$content->getActiveSheet()->getStyle("$row_project:$row_project")->getFont()->setBold(true);

					$content->getActiveSheet()->getStyle("$row_header:$row_header")->getFont()->setBold(true);
					$content->getActiveSheet()->getStyle("$row_header:$row_header")->applyFromArray($style);

					$content->getActiveSheet()->getStyle("$row:$row_wrap_num")->getAlignment()->setWrapText(true);
				}
			
		}

		if($slvlm_header == 1){

	            $excelcolumn = ($excelcolumn == '') ? 'Z' : $excelcolumn;
				$letters = $this->createColumnsArray($excelcolumn);
				$index = 0;

				for ($index; $index <= 25; $index++) {
					$row = $letters[$index]."1";
					
					$content->getActiveSheet()->getColumnDimension($letters[$index])->setAutoSize(true);
					$content->getActiveSheet()->getStyle("$row:$row")->getFont()->setBold(true);
					$content->getActiveSheet()->getStyle("$row:$row")->getFont()->setSize(14);
				}
			
		}

		if($manstatus_header == 1){
				
				$excelcolumn = ($excelcolumn == '') ? 'Z' : $excelcolumn;
				$letters = $this->createColumnsArray($excelcolumn);
				$index = 0;
				$index_to_wrap = 1;

				$style = array(
			        'alignment' => array(
			            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			        )
			    );

			    $style_vertical = array(
			        'alignment' => array(
			            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			        )
			    );

			    
			    $border_none = array(
					'borders' => array(
					    'allborders' => array(
					      'style' => PHPExcel_Style_Border::BORDER_NONE
					    )
					  )
					);
			  	 $border_bottom = array(
		            'borders' => array(
		                'bottom' =>array(
		                    'style' => PHPExcel_Style_Border::BORDER_THIN,
		                ),
		            ),
		            'font' => array(
						'bold' => true,
						'color' => array('rgb' => 'FF0000')
					)
		        );
			    $border_bottom_dotted = array(
		            'borders' => array(
		                'bottom' =>array(
		                    'style' => PHPExcel_Style_Border::BORDER_DOTTED,
		                ),
		            ),
		            'font' => array(
						'bold' => true,
						'color' => array('rgb' => 'FF0000')
					)
		        );
		         $border_top_dotted = array(
		            'borders' => array(
		                'top' =>array(
		                    'style' => PHPExcel_Style_Border::BORDER_DOTTED,
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
		        $border_top = array(
		            'borders' => array(
		                'top' =>array(
		                    'style' => PHPExcel_Style_Border::BORDER_THIN,
		                ),
		            )
		        );
		        $black_font = array(
		        'font' => array(
						'bold' => true,
						'color' => array('rgb' => '000000')
					)
		       );
				$content->getActiveSheet()->mergeCells("A4:A6");
				for ($index; $index <= 25; $index++) {

				  	$row = $letters[$index]."1";
				  	$row_date_range = $letters[$index]."2";
				  	$row_division = $letters[$index]."4";
				  	$row_dep_project = $letters[$index]."5";
				  	$row_current = $letters[$index]."7";
					$row_wrap_num = $letters[$index]."100";

					
					
					$content->getActiveSheet()->getColumnDimension($letters[$index])->setAutoSize(true);
					$content->getActiveSheet()->getStyle("$row:$row")->getFont()->setBold(true);
					$content->getActiveSheet()->getStyle("$row:$row")->getFont()->setSize(14);

					
					$content->getActiveSheet()->getStyle("$row_date_range:$row_date_range")->getFont()->setSize(14);

					$content->getActiveSheet()->getStyle("$row_division:$row_division")->getFont()->setBold(true);
					$content->getActiveSheet()->getStyle("$row_division:$row_division")->applyFromArray($style);
					$content->getActiveSheet()->getStyle("$row_dep_project:$row_dep_project")->applyFromArray($style);
					$content->getActiveSheet()->getStyle("$row_dep_project:$row_dep_project")->getFont()->setBold(true);

					$content->getActiveSheet()->getStyle("$row_current:$row_current")->getFont()->setBold(true);
					

					$content->getActiveSheet()->getStyle("$row:$row_wrap_num")->applyFromArray($style_vertical);
					$content->getActiveSheet()->getStyle("$letters[$index]"."4".":$letters[$index]"."6")->applyFromArray($border_style);
					$content->getActiveSheet()->getStyle("$letters[$index]"."8".":$letters[$index]"."31")->applyFromArray($border_right);
					$content->getActiveSheet()->getStyle("$letters[$index]"."8".":$letters[$index]"."31")->applyFromArray($border_left);
					$content->getActiveSheet()->getStyle("$letters[$index]"."8".":$letters[$index]"."8")->applyFromArray($border_top);
					$content->getActiveSheet()->getStyle("$letters[$index]"."7".":$letters[$index]"."7")->applyFromArray($border_none);
					$content->getActiveSheet()->getStyle("$letters[$index]"."8".":$letters[$index]"."8")->applyFromArray($border_bottom_dotted);
					$content->getActiveSheet()->getStyle("$letters[$index]"."8".":$letters[$index]"."8")->applyFromArray($black_font);
					$content->getActiveSheet()->getStyle("$letters[$index]"."10".":$letters[$index]"."10")->applyFromArray($border_bottom_dotted);
					$content->getActiveSheet()->getStyle("$letters[$index]"."12".":$letters[$index]"."12")->applyFromArray($border_bottom_dotted);
					$content->getActiveSheet()->getStyle("$letters[$index]"."14".":$letters[$index]"."14")->applyFromArray($border_bottom_dotted);
					
					$content->getActiveSheet()->getStyle("$letters[$index]"."17".":$letters[$index]"."17")->applyFromArray($border_bottom_dotted);
					$content->getActiveSheet()->getStyle("$letters[$index]"."17".":$letters[$index]"."17")->applyFromArray($black_font);
					$content->getActiveSheet()->getStyle("$letters[$index]"."19".":$letters[$index]"."19")->applyFromArray($border_bottom_dotted);
					$content->getActiveSheet()->getStyle("$letters[$index]"."21".":$letters[$index]"."21")->applyFromArray($border_bottom_dotted);
					$content->getActiveSheet()->getStyle("$letters[$index]"."23".":$letters[$index]"."23")->applyFromArray($border_bottom_dotted);
					$content->getActiveSheet()->getStyle("$letters[$index]"."16".":$letters[$index]"."16")->applyFromArray($border_bottom);
					$content->getActiveSheet()->getStyle("$letters[$index]"."25".":$letters[$index]"."25")->applyFromArray($border_bottom);
					$content->getActiveSheet()->getStyle("$letters[$index]"."27".":$letters[$index]"."27")->applyFromArray($border_bottom);
					$content->getActiveSheet()->getStyle("$letters[$index]"."29".":$letters[$index]"."29")->applyFromArray($border_bottom);
					$content->getActiveSheet()->getStyle("$letters[$index]"."31".":$letters[$index]"."31")->applyFromArray($border_bottom);
					
				}
		}

		if($od_header == 1){

	            $excelcolumn = ($excelcolumn == '') ? 'Z' : $excelcolumn;
				$letters = $this->createColumnsArray($excelcolumn);
				$index = 0;

				for ($index; $index <= 25; $index++) {
					$row = $letters[$index]."1";
					$row_wrap_num = $letters[$index]."100";
					
					$content->getActiveSheet()->getColumnDimension($letters[$index])->setAutoSize(true);
					$content->getActiveSheet()->getStyle("$row:$row")->getFont()->setBold(true);
					
					$content->getActiveSheet()->getStyle("$letters[$index]"."6".":$letters[$index]"."6")->getFont()->setBold(true);
					
					$content->getActiveSheet()->getStyle("$letters[$index]"."6".":G6")->applyFromArray($border_style);
				}
			
		}

		if($sd_header == 1){

	            $excelcolumn = ($excelcolumn == '') ? 'Z' : $excelcolumn;
				$letters = $this->createColumnsArray($excelcolumn);
				$index = 0;

				for ($index; $index <= 25; $index++) {
					$row = $letters[$index]."1";
					$row_wrap_num = $letters[$index]."100";
					
					$content->getActiveSheet()->getColumnDimension($letters[$index])->setAutoSize(true);
					$content->getActiveSheet()->getStyle("$row:$row")->getFont()->setBold(true);
					
					$content->getActiveSheet()->getStyle("$letters[$index]"."2".":$letters[$index]"."2")->getFont()->setBold(true);
					$content->getActiveSheet()->getStyle("$letters[$index]"."3".":$letters[$index]"."3")->getFont()->setBold(true);
					$content->getActiveSheet()->getStyle("$letters[$index]"."5".":$letters[$index]"."5")->getFont()->setBold(true);
					
					$content->getActiveSheet()->getStyle("$letters[$index]"."5".":K5")->applyFromArray($border_style);
					$content->getActiveSheet()->getStyle("$letters[$index]"."5".":$letters[$index]"."100")->getAlignment()->setWrapText(true);

				}
			
		}

		if($payreg_header == 1){

	            $excelcolumn = ($excelcolumn == '') ? 'Z' : $excelcolumn;
				$letters = $this->createColumnsArray($excelcolumn);
				$index = 0;

				for ($index; $index <= 25; $index++) {
					$row = $letters[$index]."1";
					$row_wrap_num = $letters[$index]."100";
					
					$content->getActiveSheet()->getColumnDimension($letters[$index])->setAutoSize(true);
					$content->getActiveSheet()->getStyle("$row:$row")->getFont()->setBold(true);
					
					$content->getActiveSheet()->getStyle("$letters[$index]"."2".":$letters[$index]"."2")->getFont()->setBold(true);
					$content->getActiveSheet()->getStyle("$letters[$index]"."3".":$letters[$index]"."3")->getFont()->setBold(true);
					$content->getActiveSheet()->getStyle("$letters[$index]"."5".":$letters[$index]"."5")->getFont()->setBold(true);
					
					$content->getActiveSheet()->getStyle("$letters[$index]"."5".":P5")->applyFromArray($border_style);
					$content->getActiveSheet()->getStyle("$letters[$index]"."5".":$letters[$index]"."100")->getAlignment()->setWrapText(true);

				}
			
		}

		if($pmcs_header == 1){

	            $excelcolumn = ($excelcolumn == '') ? 'Z' : $excelcolumn;
				$letters = $this->createColumnsArray($excelcolumn);
				$index = 0;

				for ($index; $index <= 25; $index++) {
					$row = $letters[$index]."1";
					$row_wrap_num = $letters[$index]."100";
					
					$content->getActiveSheet()->getColumnDimension($letters[$index])->setAutoSize(true);
					$content->getActiveSheet()->getStyle("$row:$row")->getFont()->setBold(true);
					
					$content->getActiveSheet()->getStyle("$letters[$index]"."2".":$letters[$index]"."2")->getFont()->setBold(true);
					$content->getActiveSheet()->getStyle("$letters[$index]"."3".":$letters[$index]"."3")->getFont()->setBold(true);
					$content->getActiveSheet()->getStyle("$letters[$index]"."5".":$letters[$index]"."5")->getFont()->setBold(true);
					
					$content->getActiveSheet()->getStyle("$letters[$index]"."5".":V5")->applyFromArray($border_style);
					$content->getActiveSheet()->getStyle("$letters[$index]"."5".":$letters[$index]"."100")->getAlignment()->setWrapText(true);

				}
			
		}

		if($pec_header == 1){

	            $excelcolumn = ($excelcolumn == '') ? 'Z' : $excelcolumn;
				$letters = $this->createColumnsArray($excelcolumn);
				$index = 0;

				for ($index; $index <= 25; $index++) {
					$row = $letters[$index]."1";
					$row_wrap_num = $letters[$index]."100";
					
					$content->getActiveSheet()->getColumnDimension($letters[$index])->setAutoSize(true);
					$content->getActiveSheet()->getStyle("$row:$row")->getFont()->setBold(true);
					
					$content->getActiveSheet()->getStyle("$letters[$index]"."2".":$letters[$index]"."2")->getFont()->setBold(true);
					$content->getActiveSheet()->getStyle("$letters[$index]"."3".":$letters[$index]"."3")->getFont()->setBold(true);
					

				}
			
		}

		$objWriter = PHPExcel_IOFactory::createWriter($content, 'Excel2007');
		$objWriter->save( $filename );

		// Delete temporary file
		unlink($tmpfile);

		return $filename;
	}

    function createColumnsArray($end_column, $first_letters = '')
    {
        $columns = array();
        $length = strlen($end_column);
        $letters = range('A', 'Z');

        // Iterate over 26 letters.
        foreach ($letters as $letter) {
            // Paste the $first_letters before the next.
            $column = $first_letters . $letter;

            // Add the column to the final array.
            $columns[] = $column;

            // If it was the end column that was added, return the columns.
            if ($column == $end_column)
                return $columns;
        }

        // Add the column children.
        foreach ($columns as $column) {
            // Don't itterate if the $end_column was already set in a previous itteration.
            // Stop iterating if you've reached the maximum character length.
            if (!in_array($end_column, $columns) && strlen($column) < $length) {
                $new_columns = createColumnsArray($end_column, $column);
                // Merge the new columns which were created with the final columns array.
                $columns = array_merge($columns, $new_columns);
            }
      }

      return $columns;
    }

	function export_csv( $report, $columns, $result )
	{
		ini_set('memory_limit', '1024M');   
        ini_set('max_execution_time', 1800);
        // switch($report->report_code)
        // {
        //     case 'Manpower Movement Report':
        //         $csv = $this->load->view("templates/manpower_movement_report", array('result' => $result), true);
        //         break;
        //     default:
        //         $csv = $this->load->view("templates/csv", array('columns' => $columns,'result' => $result), true);
        // }
		$csv = $this->load->view("templates/csv", array('columns' => $columns,'result' => $result), true);
		$this->load->helper('file');
		$path = 'uploads/reports/' . $report->report_code .'/csv/';
		$this->check_path( $path );
		$filename = $path . strtotime(date('Y-m-d H:i:s')) . '-' . $report->report_code . ".csv";
		write_file( $filename, $csv);
		return $filename;
	}

	function export_pdf( $report, $columns, $result, $filter )
	{
		ini_set('memory_limit', '1024M');   
        ini_set('max_execution_time', 1800);
        $reports = $this->get_report( $this->input->post( 'record_id' ) );
        $this->load->vars( $reports );
        $this->load->library('parser');
        $this->parser->set_delimiters('{$', '}');

        if(isset($_POST['filter']))
            $filter = $_POST['filter'];
        else
            $filter = '';		
        // for "DAILY TIME RECORD" filter
        if(isset($_POST['filter'])) {
            $company = array_slice($_POST['filter'],0);
            $department = array_slice($_POST['filter'],1);
            $first_period = array_slice($_POST['filter'],2);
            $second_period = array_slice($_POST['filter'],3);

            if(!empty($first_period)){ 
                $first_period = $first_period[0];
            }

            if(!empty($second_period)){
                $second_period = $second_period[0];
            }

            if(!empty($company)){
                $report_company = $company[0];
            }

            if(!empty($department)){
                $report_department = $department[0];
            }
        }

        // for "DAILY TIME RECORD OPTIMUM" filter
        $month = 1;
        $year = '';
        if(isset($_POST['filter'])) {
            $company_optimum = array_slice($_POST['filter'],0);
            $department_optimum = array_slice($_POST['filter'],1);
            $employee_name_optimum = array_slice($_POST['filter'],2);
            $first_period_optimum = array_slice($_POST['filter'],3);
            $second_period_optimum = array_slice($_POST['filter'],4);

            if(!empty($first_period_optimum)){ 
                $first_period_optimum = $first_period_optimum[0];
            }

            if(!empty($second_period_optimum)){
                $second_period_optimum = $second_period_optimum[0];
            }

            if(!empty($company_optimum)){
                $report_company_optimum = $company_optimum[0];
            }

            if(!empty($department_optimum)){
                $report_department_optimum = $department_optimum[0];
            }

            $complete_filter = $_POST['filter'];
            $month = end($complete_filter); 
            $year = prev($complete_filter);
        }

		$query = $this->export_query( $reports, $filter );	
		$this->load->library('Pdf');
		$user = $this->config->item('user');

		$pdf = new myPdf;
		$pdf->SetTitle( $report->report_name );
		$pdf->SetFontSize(8,true);
		$pdf->SetAutoPageBreak(true, 5);
		$pdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );
		$pdf->SetDisplayMode('real', 'default');
		$_POST['background'] = 0;
		// $pdf->SetPrintHeader(false);
		// $pdf->SetPrintFooter(false);
		switch($report->report_code)
		{
			case 'TARDY':
				$pdf->SetPrintHeader(false);
				$pdf->SetPrintFooter(false);
				$html = $this->load->view("templates/timekeeping_tardy", array('columns' => $columns,'result' => $result,'month' => $month, 'year' => $year), true);
				$pdf->AddPage('L', 'LETTER', true); 
				break;
			case 'IAR':
				$pdf->SetPrintHeader(false);
				$pdf->SetPrintFooter(false);
				$html = $this->load->view("templates/timekeeping_iar", array('columns' => $columns,'result' => $result), true);
				$pdf->AddPage('L', 'LETTER', true); 
				break;
			case 'PAR':
				$pdf->SetPrintHeader(false);
				$pdf->SetPrintFooter(false);
				$html = $this->load->view("templates/timekeeping_par", array('columns' => $columns,'result' => $result), true);
				$pdf->AddPage('L', 'LETTER', true); 
				break;
			case 'AESR':
				$pdf->SetPrintHeader(false);
				$pdf->SetPrintFooter(false);
				$html = $this->load->view("templates/partners_aesr", array('columns' => $columns,'result' => $result), true);
				$pdf->AddPage('L', 'LETTER', true); 
				break;
			case 'OT':
				$pdf->SetPrintHeader(false);
				$pdf->SetPrintFooter(false);
				$html = $this->load->view("templates/timekeeping_ot", array('columns' => $columns,'result' => $result), true);
				$pdf->AddPage('L', 'LETTER', true); 
				break;
			case 'COMPLIANCE':
				$pdf->SetPrintHeader(false);
				$pdf->SetPrintFooter(false);
				$html = $this->load->view("templates/timekeeping_compliance", array('columns' => $columns,'result' => $result), true);
				$pdf->AddPage('L', 'LETTER', true); 
				break;
			case 'OT_ALLOWANCE':
				$pdf->SetPrintHeader(false);
				$pdf->SetPrintFooter(true);
				$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
				$html = $this->load->view("templates/payroll_ot_allowance", array('columns' => $columns,'result' => $result), true);
				$pdf->AddPage('L', 'LETTER', true); 
				break;
			// PAYROLL REPORTS
			case 'PRELIM':
				$pdf->SetPrintHeader(false);
				$pdf->SetPrintFooter(true);
				$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
				$pdf->SetFontSize(6);
				$html = $this->load->view("templates/payroll_prelim", array('columns' => $columns,'result' => $result,'filter' => $filter), true);
				$pdf->AddPage('L', 'LEGAL', true); 
				break;
			case 'PAYREG':
				$pdf->SetPrintHeader(false);
				$pdf->SetPrintFooter(true);
				$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
				$pdf->SetFontSize(8);
				$html = $this->load->view("templates/payroll_payreg", array('columns' => $columns,'result' => $result,'filter' => $filter), true);
				$pdf->AddPage('L', 'LEGAL', true); 
				break;
			case 'PAYREG_PER_DEPARTMENT':
				$pdf->SetPrintHeader(false);
				$pdf->SetPrintFooter(true);
				$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
				$pdf->SetFontSize(8);
				$html = $this->load->view("templates/payroll_payreg_per_dept", array('columns' => $columns,'result' => $result), true);
				$pdf->AddPage('L', 'LEGAL', true); 
				break;				
            case 'PAYROLL REGISTER PRELIMINARY':
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(true);
                $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
				$result = $this->db->query($query." , employee_name ASC");
                $html = $this->load->view("templates/payroll_payregcurrent", array('columns' => $columns,'result' => $result), true);
                $pdf->AddPage('L', 'LEGAL', true); 
            	break;
            case 'PAYROLL REGISTER HISTORICAL':
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(true);
                $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
				$result = $this->db->query($query." , employee_name ASC");
                $html = $this->load->view("templates/payroll_payregclosed", array('columns' => $columns,'result' => $result), true);
                $pdf->AddPage('L', 'LEGAL', true); 
            	break;
            case 'PAYREG_COST_CENTER':
                $pdf->SetPrintHeader(true);
                $pdf->SetPrintFooter(false);
                $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
                $html = $this->load->view("templates/payroll_payregcostcenter", array('columns' => $columns,'result' => $result), true);
                $pdf->AddPage('L', 'LEGAL', true); 
            	break;
			case 'ATMREG':
				$pdf->SetPrintHeader(true);
				$pdf->SetPrintFooter(false);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER+2);
				$html = $this->load->view("templates/payroll_atmreg", array('columns' => $columns,'result' => $result), true);
				$pdf->AddPage('P', 'LETTER', true); 
				break;
			case 'NONATMREG':
				$pdf->SetPrintHeader(true);
				$pdf->SetPrintFooter(false);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER+2);
				$html = $this->load->view("templates/payroll_nonatmreg", array('columns' => $columns,'result' => $result), true);
				$pdf->AddPage('P', 'LETTER', true); 
				break;
			case 'Journal Voucher':
				$pdf->SetPrintHeader(false);
				$pdf->SetPrintFooter(true);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
				$html = $this->load->view("templates/payroll_journal_voucher", array('columns' => $columns,'result' => $result, 'query' => $query), true);
				$pdf->AddPage('P', 'LETTER', true); 
				break;
            case 'Journal Voucher Bayleaf':
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(true);
                $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
                $html = $this->load->view("templates/payroll_journal_voucher_bayleaf", array('columns' => $columns,'result' => $result, 'query' => $query), true);
                $pdf->AddPage('L', 'LETTER', true); 
                break;
            case 'Journal Details Bayleaf':
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(true);
                $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
                $html = $this->load->view("templates/payroll_journal_details_bayleaf", array('columns' => $columns,'result' => $result), true);
                $pdf->AddPage('L', 'LEGAL', true); 
                break;
			case 'DEDSCHEDDTL':
				$_POST['background'] = 0;
				$pdf->SetPrintHeader(true);
				$pdf->SetPrintFooter(false);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER+2);
				$html = $this->load->view("templates/payroll_deduction_schedule_detail", array('columns' => $columns,'result' => $result, 'query' => $query), true);
				$pdf->AddPage('P', 'LETTER', true); 
				break;
			case 'MONTHLYDED':
				$_POST['background'] = 0;
				$pdf->SetPrintHeader(true);
				$pdf->SetPrintFooter(false);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER+2);
				$html = $this->load->view("templates/payroll_monthly_deduction", array('columns' => $columns,'result' => $result, 'query' => $query), true);
				$pdf->AddPage('P', 'LETTER', true); 
				break;
			case 'CONTRI_LOANSUMMARY':
				$_POST['background'] = 0;
				$pdf->SetPrintHeader(true);
				$pdf->SetPrintFooter(false);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER+2);
				$html = $this->load->view("templates/payroll_contribution_loan_summary", array('columns' => $columns,'result' => $result, 'query' => $query), true);
				$pdf->AddPage('P', 'LETTER', true); 
				break;
			case 'PRELIM_EARN': //Preliminary Earnings Report
                $pdf->SetPrintHeader(true);
				$pdf->SetPrintFooter(true);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER+2);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
				$hdr = $this->db->query($query)->row();
				$html = $this->load->view("templates/payroll_earning_deduction", array('columns' => $columns,'result' => $result, 'query' => $query, 'report_name' => $report->report_name), true);
				$header = $query.' GROUP BY transaction_label ORDER BY transaction_label';
				$header_row = $this->db->query($header)->num_rows();
				if( $header_row > 10 ){
					$pdf->AddPage('L', 'LETTER', true); 
				} else { 
					$pdf->AddPage('P', 'LETTER', true); 
				}
                break;
            case 'PRELIM DED': //Preliminary Earnings Report
                $pdf->SetPrintHeader(true);
				$pdf->SetPrintFooter(true);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER+2);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
				$hdr = $this->db->query($query)->row();
				$html = $this->load->view("templates/payroll_earning_deduction", array('columns' => $columns,'result' => $result, 'query' => $query, 'report_name' => $report->report_name), true);
				$header = $query.' GROUP BY transaction_label ORDER BY transaction_label';
				$header_row = $this->db->query($header)->num_rows();
				if( $header_row > 10 ){
					$pdf->AddPage('L', 'LETTER', true); 
				} else { 
					$pdf->AddPage('P', 'LETTER', true); 
				}
                break;
            case 'PAYREGEARN': //Preliminary Earnings Report
                $pdf->SetPrintHeader(true);
				$pdf->SetPrintFooter(true);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER+2);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
				$hdr = $this->db->query($query)->row();
				$html = $this->load->view("templates/payroll_earning_deduction", array('columns' => $columns,'result' => $result, 'query' => $query, 'report_name' => $report->report_name,'filter' => $filter), true);
				$header = $query.' GROUP BY transaction_label ORDER BY transaction_label';
				$header_row = $this->db->query($header)->num_rows();
				if( $header_row > 10 ){
					$pdf->AddPage('L', 'LETTER', true); 
				} else { 
					$pdf->AddPage('P', 'LETTER', true); 
				}
                break;
            case 'PAYREGDED': //Preliminary Earnings Report
            	$_POST['background'] = 0;
                $pdf->SetPrintHeader(true);
				$pdf->SetPrintFooter(true);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER+2);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
				$hdr = $this->db->query($query)->row();
				$html = $this->load->view("templates/payroll_earning_deduction", array('columns' => $columns,'result' => $result, 'query' => $query, 'report_name' => $report->report_name,'filter' => $filter), true);
				$header = $query.' GROUP BY transaction_label ORDER BY transaction_label';
				$header_row = $this->db->query($header)->num_rows();
				if( $header_row > 10 ){
					$pdf->AddPage('L', 'LETTER', true); 
				} else { 
					$pdf->AddPage('P', 'LETTER', true); 
				}
                break;
            case 'Payslip': //Preliminary Earnings Report
                $pdf->SetPrintHeader(false);
				$pdf->SetPrintFooter(false);
				$pdf->SetMargins(5, 5, 5);
				$result = $this->db->query($query." AND type = 'Netpay' ORDER BY full_name")->result();
				$html = $this->load->view("templates/payroll_payslip", array('columns' => $columns,'result' => $result, 'query' => $query), true);
				$pdf->AddPage('L', 'P5', true);
                break; 
            case 'Payslip Bayleaf': //Preliminary Earnings Report for bayleaf
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                $pdf->SetMargins(5, 5, 5);
                $result = $this->db->query($query." AND type = 'Netpay' ORDER BY full_name")->result();
                $html = $this->load->view("templates/payroll_payslip_bayleaf", array('columns' => $columns,'result' => $result, 'query' => $query), true);
                $pdf->AddPage('L', 'P5', true);
                break;
            case 'Payslip Riofil': //Preliminary Earnings Report for bayleaf
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                $pdf->SetMargins(5, 5, 5);
                $result = $this->db->query($query." AND type = 'Netpay' ORDER BY full_name")->result();
                $html = $this->load->view("templates/payroll_payslip_riofil", array('columns' => $columns,'result' => $result, 'query' => $query), true);
                $pdf->AddPage('L', 'P5', true);
                break;
            case 'Payslip Abraham': //Preliminary Earnings Report for bayleaf
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                $pdf->SetMargins(5, 5, 5);
                $result = $this->db->query($query." AND type = 'Netpay' ORDER BY full_name")->result();
                $html = $this->load->view("templates/payroll_payslip_abraham", array('columns' => $columns,'result' => $result, 'query' => $query), true);
                $pdf->AddPage('L', 'P5', true);
                break;                
            case 'Payslip OSI': //Preliminary Earnings Report for bayleaf
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                $pdf->SetMargins(5, 5, 5);
                $result = $this->db->query($query." AND type = 'Netpay' ORDER BY full_name")->result();
                $html = $this->load->view("templates/payroll_payslip_osi", array('columns' => $columns,'result' => $result, 'query' => $query), true);
                $pdf->AddPage('L', 'P5', true);
                break;
            case 'AUTHORITY TO DEBIT':
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                // $pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
                $pdf->SetMargins(20, 40, 20, true);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
                $html = $this->load->view("templates/payroll_authority_debit", array('columns' => $columns,'result' => $result), true);
                $pdf->AddPage('P', 'LETTER', true); 
            	break;
            case 'TAX CONTRIBUTION':
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
                $html = $this->load->view("templates/payroll_tax_contribution", array('columns' => $columns,'result' => $result), true);
                $pdf->AddPage('L', 'FOLIO', true); 
            	break;
            case 'BANK DETAILS':
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(true);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
                $html = $this->load->view("templates/payroll_bank_details", array('columns' => $columns,'result' => $result, 'query' => $query, 'filter' => $filter), true);
                $pdf->AddPage('P', 'LETTER', true); 
                break;
            case 'Account Code':
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
                $html = $this->load->view("templates/payroll_account_code", array('columns' => $columns,'result' => $result, 'query' => $query), true);
                $pdf->AddPage('P', 'LETTER', true); 
                break;
            case 'COE BAYLEAF':
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                $pdf->SetMargins(20, 40, 20, true);
                $html = $this->load->view("templates/partners_coe", array('columns' => $columns,'result' => $result, 'query' => $query), true);
                $pdf->AddPage('P', 'LETTER', true); 
                break;
            case 'RELEASE WEAVER AND QUITCLAIM':
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                $pdf->SetMargins(20, 40, 20, true);
                $html = $this->load->view("templates/partners_release_weaver", array('columns' => $columns,'result' => $result, 'query' => $query), true);
                $pdf->AddPage('P', 'LETTER', true); 
                break;
            case 'CLEARANCE FORM':
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                $pdf->SetMargins(20, 40, 20, true);
                $html = $this->load->view("templates/partners_clearance_form", array('columns' => $columns,'result' => $result, 'query' => $query), true);
                $pdf->AddPage('P', 'LETTER', true); 
                break;
            case 'HIRE DATE':
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                $pdf->SetMargins(20, 40, 20, true);
                $html = $this->load->view("templates/timekeeping_hire_date", array('columns' => $columns,'result' => $result, 'query' => $query), true);
                $pdf->AddPage('P', 'LETTER', true); 
                break;
            case 'DAILY TIME RECORD':
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
                $html = $this->load->view("templates/timekeeping_daily_time_record", array('columns' => $columns,'result' => $result, 'first_period' => $first_period, 'second_period' => $second_period, 'r_company' => $report_company, 'r_department' => $report_department), true);
                $pdf->AddPage('L', 'LEGAL', true); 
            	break;
            case 'DAILY TIME RECORD OPTIMUM':
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
                $html = $this->load->view("templates/timekeeping_daily_time_record_optimum", array('columns' => $columns,'result' => $result, 'first_period' => $first_period_optimum, 'second_period' => $second_period_optimum, 'r_company' => $report_company_optimum, 'r_department' => $report_department_optimum), true);
                $pdf->AddPage('P', 'LEGAL', true); 
            	break;
            case 'LEAVE BALANCE DETAILED':
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
                $html = $this->load->view("templates/timekeeping_leave_balance_detailed", array('columns' => $columns,'result' => $result), true);
                $pdf->AddPage('L', 'LEGAL', true); 
            	break;
            case 'LEAVE BALANCE':
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
                $html = $this->load->view("templates/timekeeping_leave_balance", array('columns' => $columns,'result' => $result), true);
                $pdf->AddPage('L', 'LEGAL', true); 
            	break;
            case 'PERFECT ATTENDANCE':
                $pdf->SetPrintHeader(false);
                $pdf->SetPrintFooter(false);
                $pdf->SetMargins(20, 40, 20, true);
                $html = $this->load->view("templates/timekeeping_perfect_attendance", array('columns' => $columns,'result' => $result, 'first_period' => $first_period, 'second_period' => $second_period, 'query' => $query), true);
                $pdf->AddPage('P', 'LETTER', true); 
                break;
            case 'PAYROLLLOAN':
			        $pdf->SetPrintHeader(false);
			        $pdf->SetPrintFooter(false);
			        $pdata['header'] = $this->db->query($query)->row();
			        $pdata['query'] = $this->db->query($query.' ORDER BY loan_type, full_name');
			        $html = $this->load->view("templates/payroll_loan", $pdata, true);
			        $pdf->SetMargins(5, 5, 5);
			        $pdf->AddPage('P','A4',true);
			        break;
			// ADDITIONAL REPORT
        	case 'PAYROLL_SUMMARY_YTD':
        		$pdf->SetPrintHeader(false);
		        $pdf->SetPrintFooter(false);
		        $pdf->SetFontSize(8,true);
		        $pdf->SetMargins(5, 5, 5);
	        	$pdf->AddPage('L','LEGAL',true);	
		        $res = $this->db->query($query);
		        $page_number = 1;
		        $html = '';
		        foreach ($res->result() as $value) {
		        	$pdata['employee'] = $value->{'Employee'};
		        	$pdata['paytype'] = $value->{'Pay Type'};
		        	$pdata['page_count'] = $page_number;
		        	$pdata['id_number'] = $value->{'Id Number'};
		        	$pdata['full_name'] = $value->{'Full Name'};
		        	$pdata['taxcode'] = $value->{'Taxcode'};
		        	$pdata['dependent'] = $value->{'Dependent'};
		        	$pdata['title'] = $report->report_name;
		        	$pdata['year'] = $value->{'Year'};
		        	$pdata['company'] = $value->{'Company Name'};
		        	$pdata['result'] = $this->db->query("SELECT * FROM payroll_summary_ytd WHERE `year` = ".$value->{'Year'}." AND employee = ".$value->{'Employee'}." ORDER BY category DESC, description ASC ")->result();
		        	$html .= $this->load->view("templates/payroll_summary_ytd", $pdata, true);		        	
		        	$page_number++;
		        }
		        break;
		    case 'RESBID':
				$pdf->SetTitle('Resume');
				$pdf->SetFontSize(11,true);
				$pdf->SetMargins(20, 20, 20, false);
				$pdf->SetAutoPageBreak(true, 5);
		    	$pdata = $this->db->query($query);
		    	$pdata = $pdata->result();
		    	foreach($pdata as $key => $value) {
		    		$user_id = $value->{'User Id'};

		    		//Get education history
		    		$this->db->select('key, sequence, key_value, personal_id')
			    		->from('partners_personal_history')
					    ->join('partners', 'partners_personal_history.partner_id = partners.partner_id', 'left')
					    ->join('partners_key', 'partners_personal_history.key_id = partners_key.key_id', 'left')
					    ->join('partners_key_class', 'partners_key.key_class_id = partners_key_class.key_class_id', 'left')
					    ->where("partners.user_id = $user_id")
					    ->where("partners_key_class.key_class_code = 'education'");

					$educational_tab = $this->db->get();   

					$education = array();
					$education_data = array();
					if($educational_tab->num_rows > 0 ){
						$education = $educational_tab->result_array();
					}

					if(!empty($education)){
						foreach($education as $educ){
							$education_data[$educ['sequence']][$educ['key']] = $educ['key_value'];
						}
					}
					$pdata[$key]->education = $education_data;
		    		
		    		//Get employment history
					$this->db->select('key, sequence, key_value, personal_id')
					    ->from('partners_personal_history')
					    ->join('partners', 'partners_personal_history.partner_id = partners.partner_id', 'left')
					    ->join('partners_key', 'partners_personal_history.key_id = partners_key.key_id', 'left')
					    ->join('partners_key_class', 'partners_key.key_class_id = partners_key_class.key_class_id', 'left')
					    ->where("partners.user_id = $user_id")
					    ->where("partners_key_class.key_class_code = 'employment'");

					$employment_tab = $this->db->get();

					$employment = array();
					$employment_data = array();
					if($employment_tab->num_rows > 0){
						$employment = $employment_tab->result_array();
					}

					if(!empty($employment)){
						foreach($employment as $employ){
							$employment_data[$employ['sequence']][$employ['key']] = $employ['key_value'];
						}
					}
					$pdata[$key]->employment = $employment_data;

		    		//Get training history
					$this->db->select('key, sequence, key_value, personal_id')
					    ->from('partners_personal_history')
					    ->join('partners', 'partners_personal_history.partner_id = partners.partner_id', 'left')
					    ->join('partners_key', 'partners_personal_history.key_id = partners_key.key_id', 'left')
					    ->join('partners_key_class', 'partners_key.key_class_id = partners_key_class.key_class_id', 'left')
					    ->where("partners.user_id = $user_id")
					    ->where("partners_key_class.key_class_code = 'training'");	

					$training_tab = $this->db->get();

					$training = array();
					$training_data = array();
					if($training_tab->num_rows > 0){
						$training = $training_tab->result_array();
					}

					if(!empty($training)){
						foreach($training as $train){
							$training_data[$train['sequence']][$train['key']] = $train['key_value'];
						}
					}
					$pdata[$key]->training = $training_data;

		    		//Get affiliation history
					$this->db->select('key, sequence, key_value, personal_id')
					    ->from('partners_personal_history')
					    ->join('partners', 'partners_personal_history.partner_id = partners.partner_id', 'left')
					    ->join('partners_key', 'partners_personal_history.key_id = partners_key.key_id', 'left')
					    ->join('partners_key_class', 'partners_key.key_class_id = partners_key_class.key_class_id', 'left')
					    ->where("partners.user_id = $user_id")
					    ->where("partners_key_class.key_class_code = 'affiliation'");

					$affiliation_tab = $this->db->get();

					$affiliation = array();
					$affiliation_data = array();
					if($affiliation_tab->num_rows > 0){
						$affiliation = $affiliation_tab->result_array();
					}

					if(!empty($affiliation)){
						foreach($affiliation as $aff){
							$affiliation_data[$aff['sequence']][$aff['key']] = $aff['key_value'];
						}
					}
					$pdata[$key]->affiliation = $affiliation_data;

		    		//Get licensure history
					$this->db->select('key, sequence, key_value, personal_id')
					    ->from('partners_personal_history')
					    ->join('partners', 'partners_personal_history.partner_id = partners.partner_id', 'left')
					    ->join('partners_key', 'partners_personal_history.key_id = partners_key.key_id', 'left')
					    ->join('partners_key_class', 'partners_key.key_class_id = partners_key_class.key_class_id', 'left')
					    ->where("partners.user_id = $user_id")
					    ->where("partners_key_class.key_class_code = 'licensure'");

					$licensure_tab = $this->db->get();

					$licensure = array();
					$licensure_data = array();
					if($licensure_tab->num_rows > 0){
						$licensure = $licensure_tab->result_array();
					}

					if(!empty($licensure)){
						foreach($licensure as $lic){
							$licensure_data[$lic['sequence']][$lic['key']] = $lic['key_value'];
						}
					}
					$pdata[$key]->licensure = $licensure_data;
		    	}
	    	 	$html = $this->load->view("templates/resume_bidding", array('result' => $pdata), true);
		    	$pdf->AddPage('P','A4',true);
		    	break;
            // GOVERNMENT REPORTS
            // SSS
	            case 'SSSR3':
	            	$_POST['background'] = 1;
	            	$_POST['report_code'] = 'SSSR3';
	            	$pdf->SetPrintHeader(true);
			    	$pdf->SetPrintFooter(false);
			        $pdf->SetMargins(5, 5, 5);
	            	$pdata['header'] = $this->db->query($query)->row();
			        $pdata['query'] = $this->db->query($query.' ORDER BY full_name');
			        $html = $this->load->view("templates/sss_quarterly", $pdata, true);
			        $pdf->AddPage('L','LETTER',true);
			        break;
			    case 'SSSMR':
			        $pdf->SetPrintHeader(false);
			        $pdf->SetPrintFooter(false);
			        $pdata['header'] = $result->row();//$this->db->query($query)->row();
			        $pdata['query'] = '';//$this->db->query($query);
			        $pdata['result'] = $result;
			        $html = $this->load->view("templates/sss_monthly_remittance", $pdata, true);
			        $pdf->SetMargins(5, 5, 5);
			        $pdf->AddPage('P','A4',true);
			        break;
			    case 'SSSR1A':
	            	$_POST['background'] = 1;
	            	$_POST['report_code'] = 'SSSR1A';
	            	$pdf->SetPrintHeader(true);
			    	$pdf->SetPrintFooter(false);
			        $pdf->SetMargins(5, 5, 5);
	            	$pdata['header'] = $this->db->query($query)->row();
			        $pdata['query'] = $this->db->query($query.' ORDER BY full_name');
			        $html = $this->load->view("templates/sss_r1a", $pdata, true);
			        $pdf->AddPage('L','LETTER',true);
			        break;  
			    case 'SSSR5':
	            	$_POST['background'] = 1;
	            	$_POST['report_code'] = 'SSSR5';
			        $pdf->SetPrintHeader(true);
			        $pdf->SetPrintFooter(false);
			        $qry = $this->db->query($query);
			        $count = count($qry->result());
			        $Ctr = 0;
			        $res = array();

					$t_ssc = 0;
					$t_ec = 0;
					$t_total = 0;
		        	foreach ( $qry->result() as $key_re => $value_res ) {
		        		$Ctr++;
						$month_id  = $value_res->{'Month'};
						for ($i=1; $i <= 12 ; $i++) { 
							
							if(!array_key_exists($i, $res)) {
								if($month_id == $i){
								 	$res[$i] = array( 'year' => $value_res->{'Year'},
		                				  'ssc'	  => number_format($value_res->{'Sss Emp'} + $value_res->{'Sss Com'}, 2, ".", ","),
		                				  'ec' 	  => number_format($value_res->{'Sss Ecc'}, 2, ".", ","),
		                				  'total' => number_format($value_res->{'Sss Emp'} + $value_res->{'Sss Com'} + $value_res->{'Sss Ecc'}, 2, ".", ",")
		                				);	
									$t_ssc += $value_res->{'Sss Emp'} + $value_res->{'Sss Com'};
									$t_ec += $value_res->{'Sss Ecc'};
									$t_total += $value_res->{'Sss Emp'} + $value_res->{'Sss Com'} + $value_res->{'Sss Ecc'};
								 	if($Ctr != $count)
								 		$i = 13;
								} else {
									$res[$i] = array( 'year' => '',
		                				  'ssc'	  => '',
		                				  'ec' 	  => '',
		                				  'total' => ''
		                				);
								} 
							}
						}	
		        	}
			        $pdata['header'] = $qry->row();
			        $pdata['query'] = $res;
			        $pdata['t_ssc'] = number_format($t_ssc, 2, ".", ",");
			        $pdata['t_ec'] = number_format($t_ec, 2, ".", ",");
			        $pdata['t_total'] = number_format($t_total, 2, ".", ",");
			                    
			        $html = $this->load->view("templates/sss_r5", $pdata, true);
			        $pdf->SetMargins(5, 5, 5);
			        $pdf->AddPage('P','A4',true);
			        break;
			    case 'SSSLOAN':
			        $pdf->SetPrintHeader(false);
			        $pdf->SetPrintFooter(false);
			        $pdata['header'] = $this->db->query($query)->row();
			        $pdata['result'] = $this->db->query($query)->result();
			        $html = $this->load->view("templates/sss_loan", $pdata, true);
			        $pdf->SetMargins(10, 10, 10);
			        $pdf->SetFontSize(8,true);
			        $pdf->AddPage('L','A4',true);
			        break;
            // PHILHEALTH
			    case 'PHICRF1':
			    	$_POST['background'] = 1;
			    	$_POST['report_code'] = 'PHICRF1';
			    	$pdf->SetPrintHeader(true);
			    	$pdf->SetPrintFooter(false);
			        $pdf->SetMargins(5, 5, 5);
			        $pdata['header'] = $this->db->query($query)->row();
			        $pdata['query'] = $this->db->query($query.' ORDER BY full_name');
			        $html = $this->load->view("templates/phic_rf1", $pdata, true);
			        $pdf->AddPage('L','LETTER',true);
			        break;
			    case 'PHICMRMR':
			    	$pdf->SetPrintHeader(false);
			        $pdf->SetPrintFooter(false);
			        $pdata['header'] = $this->db->query($query)->row();
			        $pdata['query'] = $this->db->query($query);
			        $html = $this->load->view("templates/phic_monthly_remittance", $pdata, true);
			        $pdf->SetMargins(5, 5, 5);
			        $pdf->AddPage('P','A4',true);
			        break;
			    case 'PHICER2':
			    	$_POST['background'] = 1;
			    	$_POST['report_code'] = 'PHICER2';
			    	$pdf->SetPrintHeader(true);
			    	$pdf->SetPrintFooter(false);
			        $pdf->SetMargins(5, 5, 5);
			        $pdata['header'] = $this->db->query($query)->row();
			        $pdata['query'] = $this->db->query($query.' ORDER BY full_name');
			        $html = $this->load->view("templates/phic_er2", $pdata, true);
			        $pdf->AddPage('L','A4',true);
			        break;
            // PAGIBIG
			    case 'HDMFMCRF':
			    	$_POST['background'] = 1;
			    	$_POST['report_code'] = 'HDMFMCRF';
			    	$pdf->SetPrintHeader(true);
			    	$pdf->SetPrintFooter(false);
			        $pdf->SetMargins(5, 5, 5);
			        $pdf->SetFontSize(8,true);
			        $pdata['header'] = $this->db->query($query)->row();
			        $pdata['query'] = $this->db->query($query.' ORDER BY full_name');
			        $html = $this->load->view("templates/hdmf_mcrf", $pdata, true);
			        $pdf->AddPage('P','LETTER',true);
	        		break;
	        	case 'HDMFSTLRF':
			    	$_POST['background'] = 1;
			    	$_POST['report_code'] = 'HDMFSTLRF';
			    	$pdf->SetPrintHeader(true);
			    	$pdf->SetPrintFooter(false);
			        $pdf->SetMargins(5, 5, 5);
			        $pdf->SetFontSize(8,true);
			        $pdata['header'] = $this->db->query($query)->row();
			        $pdata['query'] = $this->db->query($query.' ORDER BY full_name');
			        $html = $this->load->view("templates/hdmf_stlrf", $pdata, true);
			        $pdf->AddPage('P','LETTER',true);
	        		break;
	        	case 'HDMFP2-4':
			    	$_POST['background'] = 1;
			    	$_POST['report_code'] = 'HDMFP2-4';
			    	$pdf->SetPrintHeader(true);
			    	$pdf->SetPrintFooter(false);
			        $pdf->SetMargins(5, 5, 5);
			        $pdf->SetFontSize(8,true);
			        $pdata['header'] = $this->db->query($query)->row();
			        $pdata['query'] = $this->db->query($query.' ORDER BY full_name');
			        $html = $this->load->view("templates/hdmf_p2_4", $pdata, true);
			        $pdf->AddPage('P','LETTER',true);
	        		break;
	        	case 'HDMFM1': 
	        		$_POST['background'] = 1;
	                $_POST['report_code'] = 'HDMFM1';
	                $pdf->SetPrintHeader(true);
			    	$pdf->SetPrintFooter(false);
			        $pdf->SetMargins(5, 5, 5);
			        $pdf->SetFontSize(8,true);
			        $pdata['header'] = $this->db->query($query)->row();
			        $pdata['query'] = $this->db->query($query.' ORDER BY full_name');
			        $html = $this->load->view("templates/hdmf_m1", $pdata, true);
			        $pdf->AddPage('P','LETTER',true);
			        break;
			    case 'HDMFMR':
			    	$pdf->SetPrintHeader(false);
			        $pdf->SetPrintFooter(false);
			        $pdata['header'] = $this->db->query($query)->row();
			        $pdata['query'] = $this->db->query($query);
			        $html = $this->load->view("templates/hdmf_monthly_remittance", $pdata, true);
			        $pdf->SetMargins(5, 5, 5);
			        $pdf->AddPage('P','A4',true);
			        break;
			    case 'HDMFQRT':
			    	$pdf->SetPrintHeader(false);
			        $pdf->SetPrintFooter(false);
			        $pdata['header'] = $this->db->query($query)->row();
			        $pdata['query'] = $this->db->query($query.' ORDER BY full_name');
			        $html = $this->load->view("templates/hdmf_quarterly", $pdata, true);
			        $pdf->SetMargins(5, 5, 5);
			        $pdf->AddPage('P','A4',true);
			        break;
			// BIR
	        	case 'BIR1601C':
			    	$_POST['background'] = 1;
			    	$_POST['report_code'] = 'BIR1601C';
			    	$pdf->SetPrintHeader(true);
			    	$pdf->SetPrintFooter(false);
			        $pdf->SetMargins(5, 5, 5);
			        $pdf->SetFontSize(8,true);
			        $res = $this->db->query($query);
			        
			        $pdata['qry'] = $res;
			        $html = $this->load->view("templates/bir_1601c", $pdata, true);
			        $pdf->AddPage('P','LETTER',true);
	        		break;  
        		case 'LEAVE BALANCE DETAILS REPORT':
				$pdf->SetPrintHeader(false);
				$pdf->SetPrintFooter(false);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER+30);
				$html = $this->load->view("templates/timekeeping_leave_balance_details", array('columns' => $columns,'result' => $result, 'query' => $query), true);
				$pdf->AddPage('P', 'LETTER', true); 
					break;   
				case 'LEAVE_SUM':
				$pdf->SetPrintHeader(false);
				$pdf->SetPrintFooter(false);
				$html = $this->load->view("templates/leave_summary", array('columns' => $columns,'result' => $result), true);
				$pdf->AddPage('L', 'LETTER', true); 
				break;
	        // ALPHALIST
				case 'schedule_7_1':
					$pdf->SetPrintHeader(true);
					$pdf->SetPrintFooter(false);
					$pdf->SetMargins(PDF_MARGIN_LEFT, 50, PDF_MARGIN_RIGHT);
					$pdf->SetFontSize( 7 );
					$_POST['schedule'] = 'schedule';
			    	$_POST['company'] = 'company';
			    	$_POST['address'] = 'address';
			    	$_POST['title'] = 'title';
			    	$_POST['label'] = 'label';
					$html = $this->load->view("templates/schedule_7_1", array('columns' => $columns,'result' => $result), true);
					$pdf->AddPage('L', 'LEGAL', true); 
					break;
				case 'TERMINATION_LETTER':
					$pdf->SetPrintHeader(false);
					$pdf->SetPrintFooter(false);
					$pdf->SetMargins(20, 30, 20, true);
					$html = $this->load->view("templates/termination_letter", array('columns' => $columns,'result' => $result), true);
					$pdf->AddPage('P', 'LETTER', true); 
					break;
				case 'Time Record Schedule History':
					$pdf->SetPrintHeader(false);
					$pdf->SetPrintFooter(false);
					$html = $this->load->view("templates/time_record_schedule", array('columns' => $columns,'result' => $result), true);
					$pdf->AddPage('L', 'LETTER', true); 
					break;					
			default:
				$pdf->AddPage('P','A4');
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

    // coe
    function export_coe( $user_id, $post ){
    	$user = $this->config->item('user');

        $this->load->library('PDFm');
        $mpdf=new PDFm();

        $mpdf->SetTitle( 'Certificate of Employment' );
        $mpdf->SetAutoPageBreak(true, 1);
        $mpdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $mpdf->SetDisplayMode('real', 'default');
        $mpdf->AddPage();

        $query = "SELECT upr.firstname, upr.lastname, uco.company, 
        			prt.effectivity_date, prt.status, ups.position, 
        			AES_DECRYPT(`ppr`.`salary`,`encryption_key`()) as salary, uco.address
        			FROM {$this->db->dbprefix}partners prt
        			INNER JOIN {$this->db->dbprefix}users_profile upr
        				ON prt.user_id = upr.user_id 
        			INNER JOIN {$this->db->dbprefix}users_position ups
        				ON upr.position_id = ups.position_id 
        			INNER JOIN {$this->db->dbprefix}users_company uco
        				ON upr.company_id = uco.company_id 
        			INNER JOIN {$this->db->dbprefix}payroll_partners ppr
        				ON prt.user_id = ppr.user_id 
        			WHERE prt.user_id = {$user_id}";

        $coeData = $this->db->query($query)->row();
    
        $vars['employee_name'] = $coeData->firstname.' '.$coeData->lastname;
        $vars['company_name'] = $coeData->company;
        $vars['effectivity_date'] = date( 'F d, Y', strtotime($coeData->effectivity_date) );
        $vars['employment_status'] = $coeData->status;
        $vars['employee_position'] = $coeData->position;
        $vars['employee_salary'] = $coeData->salary;
        $today = date('Y-m-d');
        $vars['given_date'] = date( 'jS of F Y', strtotime($today) );
        $vars['company_address'] = $coeData->address;
        $vars['request_reason'] = $post['reason'];

	 	$hr_qry = "SELECT upr.firstname, upr.lastname, pos.position 
	 				FROM {$this->db->dbprefix}users_profile upr
					LEFT JOIN {$this->db->dbprefix}users_position pos 
						ON upr.position_id = pos.position_id
					WHERE upr.user_id = {$post['signatory']}";
	 	$hr = $this->db->query($hr_qry)->row_array();
		$vars['signatory'] = $hr['firstname'].' '.$hr['lastname'];
		$vars['signatory_position'] = $hr['position'];

        // $pdata['query'] = $this->db->query($query);
        $this->load->helper('file');
		$this->load->library('parser');
        // $html = read_file(APPPATH.'templates/coe/en/coe.txt');
       	$coe_template = $this->db->get_where( 'system_template', array( 'code' => 'COE-FORM') )->row_array();
		$this->parser->set_delimiters('{{', '}}');
		$html = $this->parser->parse_string($coe_template['body'], $vars, TRUE);
		// $msg = $this->parser->parse_string($interviewer_template['body'], $joData, TRUE);
		
        $this->load->helper('file');
        $path = 'uploads/reports/COE/pdf/';
        $this->check_path( $path );
        $filename = $path .date('Y-m-d_Hi').$vars['employee_name']. "-".'COE' .".pdf";

        $mpdf->WriteHTML($html, 0, true, false);
        $mpdf->Output($filename, 'F');

            $insert = array(
                'report_id' => $post['record_id'],
                'filepath' => $filename,
                'file_type' => 'pdf',
                'created_by' => $this->user->user_id
            );
            $this->db->insert('report_results', $insert);
            $insert_id = $this->db->insert_id();
            // array('user_id')
            // //save filters
            // if(isset($post['filter']))
            // {
            //     foreach ($post['filter'] as $filter_id => $value) {
            //         $row = $filter[$filter_id];
            
            //         $insert = array(
            //             'result_id' => $insert_id,
            //             'column' => $row->column,
            //             'operator' => $row->operator,
            //             'filter' => $value
            //         );
                
            //         $this->db->insert('report_result_filters', $insert);
            //     }
            // }

        return $filename;
    }

    // coc
    function export_coc( $user_id, $post ){
    	$user = $this->config->item('user');

        $this->load->library('PDFm');
        $mpdf=new PDFm();

        $mpdf->SetTitle( 'Certificate of Contribution' );
        $mpdf->SetAutoPageBreak(true, 1);
        $mpdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $mpdf->SetDisplayMode('real', 'default');
        $mpdf->AddPage();

        $query = "SELECT upr.firstname, upr.lastname, uco.company, 
        			ppr.sss_no, ppr.hdmf_no, ppr.phic_no
        			FROM {$this->db->dbprefix}partners prt
        			INNER JOIN {$this->db->dbprefix}users_profile upr
        				ON prt.user_id = upr.user_id 
        			INNER JOIN {$this->db->dbprefix}users_company uco
        				ON upr.company_id = uco.company_id 
        			INNER JOIN {$this->db->dbprefix}payroll_partners ppr
        				ON prt.user_id = ppr.user_id 
        			WHERE prt.user_id = {$user_id}";

        $coeData = $this->db->query($query)->row();
    
        $vars['employee_name'] = $coeData->firstname.' '.$coeData->lastname;
        if($post['contribution'] == 'sss'){
        	$vars['contribution_type'] = 'SSS';
        	$vars['contribution_no'] = $coeData->sss_no;
        }elseif($post['contribution'] == 'hdmf'){
        	$vars['contribution_type'] = 'PagIBIG';
        	$vars['contribution_no'] = $coeData->hdmf_no;
        }elseif($post['contribution'] == 'phic'){
        	$vars['contribution_type'] = 'PhilHealth';
        	$vars['contribution_no'] = $coeData->phic_no;
        }
        $vars['company_name'] = $coeData->company;

	 	$hr_qry = "SELECT upr.firstname, upr.lastname, pos.position 
	 				FROM {$this->db->dbprefix}users_profile upr
					LEFT JOIN {$this->db->dbprefix}users_position pos 
						ON upr.position_id = pos.position_id
					WHERE upr.user_id = {$post['signatory']}";
	 	$hr = $this->db->query($hr_qry)->row_array();
		$vars['signatory'] = $hr['firstname'].' '.$hr['lastname'];
		$vars['signatory_position'] = $hr['position'];

		$vars['contrib_list'] = '';
	 	$contrib_qry = "SELECT * FROM partner_contribution 
					WHERE user_id = {$user_id}";
	 	$contributions = $this->db->query($contrib_qry);
	 	// echo "<pre>$contrib_qry";
	 	if( $contributions->num_rows() > 0 ){
	 		foreach( $contributions->result_array() as $contrib){                
				$vars['contrib_list'] .= "<tr style='border: 1px solid #ccc;'>
                   <td>{$contrib['month']}</td>
                   <td>".$contrib[$vars['contribution_type']]."</td>
                   <td>{$contrib['year']}</td>
                </tr>";
	 		}
	 	}

        $this->load->helper('file');
		$this->load->library('parser');
        // $html = read_file(APPPATH.'templates/coe/en/coe.txt');
       	$coe_template = $this->db->get_where( 'system_template', array( 'code' => 'COC-FORM') )->row_array();
		$this->parser->set_delimiters('{{', '}}');
		$html = $this->parser->parse_string($coe_template['body'], $vars, TRUE);
		// $msg = $this->parser->parse_string($interviewer_template['body'], $joData, TRUE);
		
        $this->load->helper('file');
        $path = 'uploads/reports/COC/pdf/';
        $this->check_path( $path );
        $filename = $path .date('Y-m-d_Hi').$vars['employee_name']. "-".'COC' .".pdf";

        $mpdf->WriteHTML($html, 0, true, false);
        $mpdf->Output($filename, 'F');

            $insert = array(
                'report_id' => $post['record_id'],
                'filepath' => $filename,
                'file_type' => 'pdf',
                'created_by' => $this->user->user_id
            );
            $this->db->insert('report_results', $insert);
            $insert_id = $this->db->insert_id();

        return $filename;
    }

    function export_txt( $report, $columns, $result, $posting_date = NULL, $filter )
    {
		ini_set('memory_limit', '1024M');   
        ini_set('max_execution_time', 1800);
    	$res = $result->result_array();
        switch($report->report_code)
        {
            case 'BANKREMITTANCE':
                $txt = $this->load->view("templates/payroll_bank_remittance", array('columns' => $columns,'result' => $result, 'posting_date' => $posting_date, 'filter' => $filter), true);
                $fname = $res[0]['Bank Code Alpha'].date('Ymd', strtotime($res[0]['Posting Date']));
                break;
            case 'BIR1604CF 7.1':
                $txt = $this->load->view("templates/bir1604cf_7_1", array('columns' => $columns,'result' => $result, 'posting_date' => $posting_date, 'filter' => $filter), true);
                $fname = substr(str_replace('-', '', $res[0]['Comp Tin']),0,8).'.S71';
                break;                
            case 'SSSTD':
            	$records = $result->row();
            	$txt = $this->load->view("templates/txt_template", array('columns' => $columns,'result' => $result, 'report_code' => $report->report_code, 'filter' => $filter ), true);
			    if (isset($filter)){
		            $year_param = array_slice($_POST['filter'],1);
		            $month_param = array_slice($_POST['filter'],2);
			        $doc_year = $year_param[0] . str_pad($month_param[0],2,"0",STR_PAD_LEFT);
			    }               	
                $fname = $records->{'Company Code'}.'MCL'.$doc_year;
                break;
            case 'SSSLTD':
            	$records = $result->row();
            	$txt = $this->load->view("templates/sss_loan_to_disk", array('columns' => $columns,'result' => $result, 'report_code' => $report->report_code, 'filter' => $filter ), true);
			    if (isset($filter)){
		            $year_param = array_slice($_POST['filter'],2);
		            $month_param = array_slice($_POST['filter'],3);
			        $doc_year = $year_param[0] . str_pad($month_param[0],2,"0",STR_PAD_LEFT);
			    }               	
                $fname = $records->{'Company Code'}.'LCL'.$doc_year;
                break;                
            case 'SSSTDR3':
            	$txt = $this->load->view("templates/sssr3_to_disk", array('columns' => $columns,'result' => $result, 'report_code' => $report->report_code, 'filter' => $filter ), true);
                $fname = $report->report_code.date('Ymd');
                break;
            case 'HDMFTD':
            	$txt = $this->load->view("templates/hdmf_to_disk", array('columns' => $columns,'result' => $result, 'report_code' => $report->report_code, 'filter' => $filter ), true);
			    if (isset($filter)){
			        $doc_year = date('Ym', strtotime(end($filter)));
			    }               	
                $fname = $doc_year.substr(date('His'), -3);
                break;  
            case 'HDMFLTD':
            	$txt = $this->load->view("templates/hdmf_loan_to_disk", array('columns' => $columns,'result' => $result, 'report_code' => $report->report_code, 'filter' => $filter ), true);
			    if (isset($filter)){
			        $doc_year = date('Ym', strtotime(end($filter)));
			    }               	
                $fname = $doc_year.substr(date('His'), -3);
                break;                              
            case 'METROBANK':
            	$txt = $this->load->view("templates/bank_remittance_metrobank", array('columns' => $columns,'result' => $result, 'posting_date' => $posting_date), true);
            	$fname = 'Payroll';
            	break;
            case 'AUTHORITY TO DEBIT':
            	$txt = $this->load->view("templates/bank_remittance_rcbc", array('columns' => $columns,'result' => $result, 'posting_date' => $posting_date), true);
            	$fname = 'Payroll';
            	break;
            default:
                $txt = $this->load->view("templates/txt", array('columns' => $columns,'result' => $result), true);
                $fname = $report->report_code.date('Ymd');
                break;
        }

        $this->load->helper('file');

        $filereport = $fname;
    	$path = 'uploads/reports/' . $report->report_code .'/txt/';
        $this->check_path( $path );
        //$filename = $path . strtotime(date('Y-m-d H:i:s')) . '-' . $report->report_code . ".txt";
        $filename = $path . $filereport . ".txt";
    
        // creation of file
        write_file( $filename, $txt);

        return $filename;
    }

    // excel format
	function application_employment( $report, $columns, $result )
	{
		ini_set('memory_limit', '1024M');   
        ini_set('max_execution_time', 1800);

		$this->load->helper('file');
		$path = 'uploads/reports/recruitment/excel/';
		$this->check_path( $path );
		$filename = $path . strtotime(date('Y-m-d H:i:s')) . 'Application' . ".xlsx";

		$this->load->library('excel');

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setTitle("Application Report")
		            ->setDescription("Application Report");
		               
		// Assign cell values
		$objPHPExcel->setActiveSheetIndex(0);
		$activeSheet = $objPHPExcel->getActiveSheet();

		//header
		$alphabet  = range('A','Z');
		$alpha_ctr = 0;
		$sub_ctr   = 0;				

/*	    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);*/

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

		$right = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
			)
		);

		$v_center = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
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

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4.85);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5.14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(3.85);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(4.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(4);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(3.43);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(5.91);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(8.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(3.42);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(4);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(6.14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(4);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(6.14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(8.14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(5.28);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(5.28);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(4.42);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(2.85);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(3);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(4.14);

		if ($result && $result->num_rows() > 0){
			$record = $result->row_array();

			$father_name = '';
			$father_occupation = '';
			$father_age = '';

			$family_father_result = $this->db->get_where('recruitment_personal_history',array('recruit_id' => $record['recruit_id'],'key_value' => 'Father'));
			if ($family_father_result && $family_father_result->num_rows() > 0){
				$family_father_row = $family_father_result->row();

				$family_father_info_result = $this->db->get_where('recruitment_personal_history',array('recruit_id' => $record['recruit_id'],'sequence' => $family_father_row->sequence));
				if ($family_father_info_result && $family_father_info_result->num_rows() > 0){
					foreach ($family_father_info_result->result() as $row) {
						if ($row->key == 'family-name'){
							$father_name = $row->key_value;
						}
						elseif ($row->key == 'family-occupation'){
							$father_occupation = $row->key_value;
						}
						elseif ($row->key == 'family-birthdate'){
							$father_birthdate = $row->key_value;
				            $birthDate = date('m/d/Y', strtotime($father_birthdate));
				            //explode the date to get month, day and year
				            $birthDate = explode("/", $birthDate);
				            //get age from date or birthdate
				            $father_age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
				                    ? ((date("Y") - $birthDate[2]) - 1)
				                    : (date("Y") - $birthDate[2]));							
						}													
					}
				}
			}

			$mother_name = '';
			$mother_occupation = '';
			$mother_age = '';
									
			$family_mother_result = $this->db->get_where('recruitment_personal_history',array('recruit_id' => $record['recruit_id'],'key_value' => 'Mother'));
			if ($family_mother_result && $family_mother_result->num_rows() > 0){
				$family_mother_row = $family_mother_result->row();

				$family_mother_info_result = $this->db->get_where('recruitment_personal_history',array('recruit_id' => $record['recruit_id'],'sequence' => $family_mother_row->sequence));
				if ($family_mother_info_result && $family_mother_info_result->num_rows() > 0){
					foreach ($family_mother_info_result->result() as $row) {
						if ($row->key == 'family-name'){
							$mother_name = $row->key_value;
						}
						elseif ($row->key == 'family-occupation'){
							$mother_occupation = $row->key_value;
						}
						elseif ($row->key == 'family-birthdate'){
							$mother_birthdate = $row->key_value;
				            $birthDate = date('m/d/Y', strtotime($mother_birthdate));
				            //explode the date to get month, day and year
				            $birthDate = explode("/", $birthDate);
				            //get age from date or birthdate
				            $mother_age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
				                    ? ((date("Y") - $birthDate[2]) - 1)
				                    : (date("Y") - $birthDate[2]));							
						}													
					}
				}
			}	

			$family_brother_count = 0;
			$family_brother_ages = array();
			$family_brother_result = $this->db->get_where('recruitment_personal_history',array('recruit_id' => $record['recruit_id'],'key_value' => 'Brother'));
			if ($family_brother_result && $family_brother_result->num_rows() > 0){
				$family_brother_count = $family_brother_result->num_rows();
				$family_brother_row = $family_brother_result->row();

				$family_brother_info_result = $this->db->get_where('recruitment_personal_history',array('recruit_id' => $record['recruit_id'],'sequence' => $family_brother_row->sequence));
				if ($family_brother_info_result && $family_brother_info_result->num_rows() > 0){
					foreach ($family_brother_info_result->result() as $row) {
						$brother_age = 0;
						if ($row->key == 'family-birthdate'){
							$mother_birthdate = $row->key_value;
				            $birthDate = date('m/d/Y', strtotime($mother_birthdate));
				            //explode the date to get month, day and year
				            $birthDate = explode("/", $birthDate);
				            //get age from date or birthdate
				            $brother_age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
				                    ? ((date("Y") - $birthDate[2]) - 1)
				                    : (date("Y") - $birthDate[2]));		
				            $family_brother_ages[] = $brother_age;					
						}													
					}
				}
			}	

			$family_sister_count = 0;
			$family_sister_ages = array();
			$family_sister_result = $this->db->get_where('recruitment_personal_history',array('recruit_id' => $record['recruit_id'],'key_value' => 'Sister'));
			if ($family_sister_result && $family_sister_result->num_rows() > 0){
				$family_sister_count = $family_sister_result->num_rows();
				$family_sister_row = $family_sister_result->row();

				$family_sister_info_result = $this->db->get_where('recruitment_personal_history',array('recruit_id' => $record['recruit_id'],'sequence' => $family_sister_row->sequence));
				if ($family_sister_info_result && $family_sister_info_result->num_rows() > 0){
					foreach ($family_sister_info_result->result() as $row) {
						$sister_age = 0;
						if ($row->key == 'family-birthdate'){
							$mother_birthdate = $row->key_value;
				            $birthDate = date('m/d/Y', strtotime($mother_birthdate));
				            //explode the date to get month, day and year
				            $birthDate = explode("/", $birthDate);
				            //get age from date or birthdate
				            $sister_age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
				                    ? ((date("Y") - $birthDate[2]) - 1)
				                    : (date("Y") - $birthDate[2]));		
				            $family_sister_ages[] = $sister_age;					
						}													
					}
				}
			}	

			$spouse_name = '';
			$spouse_occupation = '';
			$spouse_age = '';
									
			$family_spouse_result = $this->db->get_where('recruitment_personal_history',array('recruit_id' => $record['recruit_id'],'key_value' => 'Spouse'));
			if ($family_spouse_result && $family_spouse_result->num_rows() > 0){
				$family_spouse_row = $family_spouse_result->row();

				$family_spouse_info_result = $this->db->get_where('recruitment_personal_history',array('recruit_id' => $record['recruit_id'],'sequence' => $family_spouse_row->sequence));
				if ($family_spouse_info_result && $family_spouse_info_result->num_rows() > 0){
					foreach ($family_spouse_info_result->result() as $row) {
						if ($row->key == 'family-name'){
							$spouse_name = $row->key_value;
						}
						elseif ($row->key == 'family-occupation'){
							$spouse_occupation = $row->key_value;
						}
						elseif ($row->key == 'family-birthdate'){
							$spouse_birthdate = $row->key_value;
				            $birthDate = date('m/d/Y', strtotime($spouse_birthdate));
				            //explode the date to get month, day and year
				            $birthDate = explode("/", $birthDate);
				            //get age from date or birthdate
				            $spouse_age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
				                    ? ((date("Y") - $birthDate[2]) - 1)
				                    : (date("Y") - $birthDate[2]));							
						}													
					}
				}
			}									
		}

		$line = 4;
		$xcoor = $alphabet[$alpha_ctr];

		$objPHPExcel->getActiveSheet()->setCellValue('A4', 'APPLICATION FOR EMPLOYMENT');	
		$activeSheet->getStyle('A4')->getFont()->setSize(16);

		$objPHPExcel->getActiveSheet()->setCellValue('A6', 'Positon Desired');

		$objPHPExcel->getActiveSheet()->setCellValue('E6', $record['position_desired']);
		$activeSheet->getStyle('D6:M6')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('N6', 'Salary Desired');
		$objPHPExcel->getActiveSheet()->setCellValue('P6', $record['desired_salary']);
		$activeSheet->getStyle('P6')->applyFromArray($center);
		$activeSheet->mergeCells('P6:T6');		
		$activeSheet->getStyle('P6:T6')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Name');
		$activeSheet->getStyle('A7:T7')->getFont()->setSize(10);
		$activeSheet->getStyle('B7:T7')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('E7', $record['position_desired']);
		$objPHPExcel->getActiveSheet()->setCellValue('E8', 'Surname');
		$objPHPExcel->getActiveSheet()->setCellValue('K7', $record['firstname']);
		$objPHPExcel->getActiveSheet()->setCellValue('K8', 'Given Name');
		$objPHPExcel->getActiveSheet()->setCellValue('Q7', $record['middlename']);
		$objPHPExcel->getActiveSheet()->setCellValue('Q8', 'Middle Name');
		$activeSheet->getStyle('E8')->getFont()->setSize(8);
		$activeSheet->getStyle('K8')->getFont()->setSize(8);
		$activeSheet->getStyle('Q8')->getFont()->setSize(8);

		$objPHPExcel->getActiveSheet()->setCellValue('A9', 'City Address');
		$objPHPExcel->getActiveSheet()->setCellValue('D9', $record['present_ddress']);
		$activeSheet->getStyle('C9:O9')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('P9', 'Tel No.');
		$objPHPExcel->getActiveSheet()->setCellValue('R9', $record['phone']);
		$activeSheet->getStyle('Q9:T9')->applyFromArray($border_bottom);


		$objPHPExcel->getActiveSheet()->setCellValue('A10', 'Provincial Address');
		$objPHPExcel->getActiveSheet()->setCellValue('E10', $record['present_province']);
		$activeSheet->getStyle('D10:O10')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('P10', 'Tel No.');
		$objPHPExcel->getActiveSheet()->setCellValue('R10', '');
		$activeSheet->getStyle('Q10:T10')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('A11', 'Age');
		$objPHPExcel->getActiveSheet()->setCellValue('B11', $record['age']);
		$activeSheet->getStyle('B11:C11')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('D11', 'Height');
		$objPHPExcel->getActiveSheet()->setCellValue('F11', $record['height']);
		$activeSheet->getStyle('E11:G11')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('H11', 'Weight');
		$objPHPExcel->getActiveSheet()->setCellValue('I11', $record['weight']);
		$activeSheet->getStyle('I11:K11')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('L11', 'Birthdate');
		$objPHPExcel->getActiveSheet()->setCellValue('N11', $record['birthdate']);
		$activeSheet->getStyle('N11:O11')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('P11', 'Birthplace');
		$objPHPExcel->getActiveSheet()->setCellValue('R11', $record['birth_place']);
		$activeSheet->getStyle('R11:T11')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('A12', 'Religion');
		$objPHPExcel->getActiveSheet()->setCellValue('C12', $record['religion']);
		$activeSheet->getStyle('C12:G12')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('H12', 'Citizenship');
		$objPHPExcel->getActiveSheet()->setCellValue('J12', $record['citizenship']);
		$activeSheet->getStyle('I12:O12')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('P12', 'Civil Status');
		$objPHPExcel->getActiveSheet()->setCellValue('S12', $record['civil_status']);
		$activeSheet->getStyle('R12:T12')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('A13', 'PRC No.');
		$objPHPExcel->getActiveSheet()->setCellValue('C13', ' ');
		$activeSheet->getStyle('C13:F13')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('G13', 'SSS No.');
		$objPHPExcel->getActiveSheet()->setCellValue('H13', $record['sss_number']);
		$activeSheet->getStyle('H13:J13')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('K13', 'TIN No.');
		$objPHPExcel->getActiveSheet()->setCellValue('L13', $record['tin_number']);
		$activeSheet->getStyle('L13:O13')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('P13', 'Pag-Ibig No.');
		$objPHPExcel->getActiveSheet()->setCellValue('R13', ' 234-234324');
		$activeSheet->getStyle('R13:T13')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('A14', 'Father\'s Name');
		$objPHPExcel->getActiveSheet()->setCellValue('D14', $father_name);
		$activeSheet->getStyle('D14:I14')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('J14', 'Age');
		$objPHPExcel->getActiveSheet()->setCellValue('K14', $father_age);
		$activeSheet->getStyle('K14:M14')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('N14', 'Occupation');
		$objPHPExcel->getActiveSheet()->setCellValue('P14', $father_occupation);
		$activeSheet->getStyle('O14:T14')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('A15', 'Mother\'s Name');
		$objPHPExcel->getActiveSheet()->setCellValue('D15', $mother_name);
		$activeSheet->getStyle('D15:I15')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('J15', 'Age');
		$objPHPExcel->getActiveSheet()->setCellValue('K15', $mother_age);
		$activeSheet->getStyle('K15:M15')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('N15', 'Occupation');
		$objPHPExcel->getActiveSheet()->setCellValue('P15', $mother_occupation);
		$activeSheet->getStyle('O15:T15')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('A16', 'No. of Brothers');
		$objPHPExcel->getActiveSheet()->setCellValue('D16', $family_brother_count);
		$activeSheet->getStyle('D16:F16')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('G16', 'Age(s)');
		$objPHPExcel->getActiveSheet()->setCellValue('H16', implode(',', $family_brother_ages));
		$activeSheet->getStyle('H16:I16')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('J16', 'No. of Sisters');
		$objPHPExcel->getActiveSheet()->setCellValue('M16', $family_sister_count);
		$activeSheet->getStyle('L16:N16')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('O16', 'Age(s)');
		$objPHPExcel->getActiveSheet()->setCellValue('P16', implode(',', $family_sister_ages));
		$activeSheet->getStyle('P16:T16')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('A17', 'Spouse Name');
		$objPHPExcel->getActiveSheet()->setCellValue('D17', $spouse_name);
		$activeSheet->getStyle('D17:I17')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('J17', 'Age');
		$objPHPExcel->getActiveSheet()->setCellValue('K17', $spouse_age);
		$activeSheet->getStyle('K17:M17')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('N17', 'Occupation');
		$objPHPExcel->getActiveSheet()->setCellValue('P17', $spouse_occupation);
		$activeSheet->getStyle('O17:T17')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('A18', 'IN CASE OF EMERGENCY (CONTACT PERSON)');
		$objPHPExcel->getActiveSheet()->setCellValue('I18', $record['emergency_name']);
		$activeSheet->getStyle('H18:M18')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('N18', 'Telephone No');
		$objPHPExcel->getActiveSheet()->setCellValue('P18', $record['emergency_phone']);
		$activeSheet->getStyle('P18:T18')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('B19', 'Relationship');
		$objPHPExcel->getActiveSheet()->setCellValue('E19', $record['emergency_relationship']);
		$activeSheet->getStyle('D19:H19')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('I19', 'Address');
		$objPHPExcel->getActiveSheet()->setCellValue('K19', $record['emergency_ddress']);
		$activeSheet->getStyle('K19:T19')->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->setCellValue('I20', ' ');
		$activeSheet->getStyle('I20:T20')->applyFromArray($border_bottom);

		$activeSheet->getStyle('A9:T20')->getFont()->setSize(10);


		$line = 21;

		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'EMPLOYMENT RECORD:');
		$activeSheet->getStyle('A'.$line.'')->getFont()->setSize(9);
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($bold);

		$line++;
		$line1 = $line + 1;
		$begline = $line;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'COMPANY NAME/        ADDRESS');
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($center);
		$activeSheet->getStyle('A'.$line.'')->getAlignment()->setWrapText(true);
		$activeSheet->mergeCells('A'.$line.':F'.$line1);

		$objPHPExcel->getActiveSheet()->setCellValue('G'.$line.'', 'JOB POSITION');
		$activeSheet->getStyle('G'.$line.'')->applyFromArray($center);
		$activeSheet->getStyle('G'.$line.'')->applyFromArray($v_center);
		$activeSheet->mergeCells('G'.$line.':I'.$line1);

		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line.'', 'INCLUSIVE DATES');
		$activeSheet->getStyle('J'.$line.'')->applyFromArray($center);
		$activeSheet->mergeCells('J'.$line.':M'.$line);

		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line1.'', 'From');
		$activeSheet->getStyle('J'.$line1.'')->applyFromArray($center);
		$activeSheet->mergeCells('J'.$line1.':K'.$line1);

		$objPHPExcel->getActiveSheet()->setCellValue('L'.$line1.'', 'To');
		$activeSheet->getStyle('L'.$line1.'')->applyFromArray($center);
		$activeSheet->mergeCells('L'.$line1.':M'.$line1);

		$objPHPExcel->getActiveSheet()->setCellValue('N'.$line.'', 'LAST                         SALARY');
		$activeSheet->getStyle('N'.$line.'')->applyFromArray($center);
		$activeSheet->getStyle('N'.$line.'')->getAlignment()->setWrapText(true);
		$activeSheet->mergeCells('N'.$line.':O'.$line1);

		$objPHPExcel->getActiveSheet()->setCellValue('P'.$line.'', 'REASON FOR LEAVING');
		$activeSheet->getStyle('P'.$line.'')->applyFromArray($center);
		$activeSheet->getStyle('P'.$line.'')->applyFromArray($v_center);
		$activeSheet->mergeCells('P'.$line.':T'.$line1);

		$activeSheet->getStyle('A'.$line.':T'.$line1)->getFont()->setSize(10);
		$activeSheet->getStyle('A'.$line.':T'.$line1)->applyFromArray($bold);

		$line = $line1 + 1;
		$this->db->where('recruit_id',$record['recruit_id']);
		$this->db->like('key', 'employment', 'after'); 
		$this->db->order_by('sequence,key_id');
		$employment_result = $this->db->get('recruitment_personal_history');

		if ($employment_result && $employment_result->num_rows() > 0){	
			$sequence = array();
			$ctr = 0;
			foreach ($employment_result->result() as $row) {
				if (!in_array($row->sequence, $sequence)){
					$sequence[] = $row->sequence;

					$inlusive_from = array();
					$inlusive_end = array();

					if ($ctr > 0){
						$line++;	
					}										
				}

				$activeSheet->mergeCells('A'.$line.':F'.$line);
				$activeSheet->mergeCells('G'.$line.':I'.$line);	
				$activeSheet->mergeCells('J'.$line.':K'.$line);	
				$activeSheet->mergeCells('J'.$line.':K'.$line);
				$activeSheet->mergeCells('L'.$line.':M'.$line);	
				$activeSheet->mergeCells('L'.$line.':M'.$line);
				$activeSheet->mergeCells('N'.$line.':O'.$line);	
				$activeSheet->mergeCells('P'.$line.':T'.$line);	

				switch ($row->key) {
					case 'employment-company':
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'',  $row->key_value);
						break;
					case 'employment-position-title':
							$objPHPExcel->getActiveSheet()->setCellValue('G'.$line.'',  $row->key_value);	
						break;			
					case 'employment-month-hired':
							$inlusive_from[] = $row->key_value;
							$objPHPExcel->getActiveSheet()->setCellValue('J'.$line.'',  implode(' ', $inlusive_from));
						break;	
					case 'employment-year-hired':
							$inlusive_from[] = $row->key_value;
							$objPHPExcel->getActiveSheet()->setCellValue('J'.$line.'',  implode(' ', $inlusive_from));
						break;	
					case 'employment-month-end':
							$inlusive_end[] = $row->key_value;
							$objPHPExcel->getActiveSheet()->setCellValue('L'.$line.'',  implode(' ', $inlusive_end));
						break;	
					case 'employment-year-end':
							$inlusive_end[] = $row->key_value;
							$objPHPExcel->getActiveSheet()->setCellValue('L'.$line.'',  implode(' ', $inlusive_end));		
						break;	
					case 'employment-last-salary':
							$objPHPExcel->getActiveSheet()->setCellValue('N'.$line.'',  $row->key_value);	
						break;	
					case 'employment-reason-for-leaving':
							$objPHPExcel->getActiveSheet()->setCellValue('P'.$line.'',  $row->key_value);	
						break;
				}
				$ctr++;
			}			

			$endline = $line;

			$activeSheet->getStyle('A'.$begline.':T'.$endline)->applyFromArray($border_style);			
		}
		else{
			$endline = $line - 1;

			$activeSheet->getStyle('A'.$begline.':T'.$endline)->applyFromArray($border_style);				
		}


		$line = $line + 2;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'SCHOOL RECORD:');
		$activeSheet->getStyle('A'.$line.'')->getFont()->setSize(9);
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($bold);

		$line++;
		$line1 = $line + 1;
		$begline = $line;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'CURRICULUM');
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($center);
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($v_center);
		$activeSheet->mergeCells('A'.$line.':D'.$line1);

		$objPHPExcel->getActiveSheet()->setCellValue('E'.$line.'', 'SCHOOL NAME /                                      ADDRESS');
		$activeSheet->getStyle('E'.$line.'')->applyFromArray($center);
		$activeSheet->getStyle('E'.$line.'')->getAlignment()->setWrapText(true);
		$activeSheet->mergeCells('E'.$line.':I'.$line1);

		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line.'', 'INCLUSIVE DATES');
		$activeSheet->getStyle('J'.$line.'')->applyFromArray($center);
		$activeSheet->mergeCells('J'.$line.':M'.$line);

		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line1.'', 'From');
		$activeSheet->getStyle('J'.$line1.'')->applyFromArray($center);
		$activeSheet->mergeCells('J'.$line1.':K'.$line1);

		$objPHPExcel->getActiveSheet()->setCellValue('L'.$line1.'', 'To');
		$activeSheet->getStyle('L'.$line1.'')->applyFromArray($center);
		$activeSheet->mergeCells('L'.$line1.':M'.$line1);

		$objPHPExcel->getActiveSheet()->setCellValue('N'.$line.'', 'DEGREE');
		$activeSheet->getStyle('N'.$line.'')->applyFromArray($center);
		$activeSheet->getStyle('N'.$line.'')->getAlignment()->setWrapText(true);
		$activeSheet->mergeCells('N'.$line.':O'.$line1);

		$objPHPExcel->getActiveSheet()->setCellValue('P'.$line.'', 'REMARKS');
		$activeSheet->getStyle('P'.$line.'')->applyFromArray($center);
		$activeSheet->getStyle('P'.$line.'')->applyFromArray($v_center);
		$activeSheet->mergeCells('P'.$line.':T'.$line1);

		$activeSheet->getStyle('A'.$line.':T'.$line1)->getFont()->setSize(10);
		$activeSheet->getStyle('A'.$line.':T'.$line1)->applyFromArray($bold);

		$line = $line1 + 1;
		$this->db->where('recruit_id',$record['recruit_id']);
		$this->db->like('key', 'education', 'after'); 
		$this->db->order_by('sequence,key_id');
		$employment_result = $this->db->get('recruitment_personal_history');

		if ($employment_result && $employment_result->num_rows() > 0){	
			$sequence = array();
			$ctr = 0;
			foreach ($employment_result->result() as $row) {
				if (!in_array($row->sequence, $sequence)){
					$sequence[] = $row->sequence;

					if ($ctr > 0){
						$line++;	
					}										
				}

				$activeSheet->mergeCells('A'.$line.':D'.$line);
				$activeSheet->mergeCells('E'.$line.':I'.$line);	
				$activeSheet->mergeCells('J'.$line.':K'.$line);	
				$activeSheet->mergeCells('L'.$line.':M'.$line);
				$activeSheet->mergeCells('N'.$line.':O'.$line);

				switch ($row->key) {
					case 'education-type':
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'',  $row->key_value);
						break;
					case 'education-school':
							$objPHPExcel->getActiveSheet()->setCellValue('E'.$line.'',  $row->key_value);
						break;						
					case 'education-year-from':
							$objPHPExcel->getActiveSheet()->setCellValue('J'.$line.'',  $row->key_value);	
						break;
					case 'education-year-to':
							$objPHPExcel->getActiveSheet()->setCellValue('L'.$line.'',  $row->key_value);		
						break;
					case 'education-degree':
							$objPHPExcel->getActiveSheet()->setCellValue('N'.$line.'',  $row->key_value);		
						break;
				}
				$objPHPExcel->getActiveSheet()->setCellValue('P'.$line.'',  '');
				$activeSheet->mergeCells('P'.$line.':T'.$line);					
				$ctr++;
			}
			$endline = $line;

			$activeSheet->getStyle('A'.$begline.':T'.$endline)->applyFromArray($border_style);	
		}	
		else{
			$endline = $line - 1;

			$activeSheet->getStyle('A'.$begline.':T'.$endline)->applyFromArray($border_style);				
		}	

		$line = $line + 2;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'Other Skills:');

		$line++;
		$activeSheet->getStyle('B'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$line.'', ' ');
		$activeSheet->getStyle('B'.$line.'')->applyFromArray($center);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$line.'', 'Typing');

		$activeSheet->getStyle('I'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$line.'', ' ');
		$activeSheet->getStyle('I'.$line.'')->applyFromArray($center);		
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line.'', 'Computer (indicate programs familiar with)');

		$line = $line + 2;
		$activeSheet->getStyle('B'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$line.'', ' ');
		$activeSheet->getStyle('B'.$line.'')->applyFromArray($center);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$line.'', 'Driving');

		$activeSheet->getStyle('J'.$line.':T'.$line)->applyFromArray($border_bottom);

		$line = $line + 2;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'Languages / Dialects Spoken & Written');

		$activeSheet->getStyle('I'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$line.'', ' ');
		$activeSheet->getStyle('I'.$line.'')->applyFromArray($center);		
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line.'', 'English');

		$activeSheet->getStyle('L'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('L'.$line.'', ' ');
		$activeSheet->getStyle('L'.$line.'')->applyFromArray($center);		
		$objPHPExcel->getActiveSheet()->setCellValue('M'.$line.'', 'English');

		$activeSheet->getStyle('O'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('O'.$line.'', ' ');
		$activeSheet->getStyle('O'.$line.'')->applyFromArray($center);		
		$objPHPExcel->getActiveSheet()->setCellValue('P'.$line.'', 'Others');
		$activeSheet->getStyle('R'.$line.':T'.$line)->applyFromArray($border_bottom);

		//DEPENDENTS:
		$line = $line + 2;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'DEPENDENTS:');
		$activeSheet->getStyle('A'.$line.'')->getFont()->setSize(9);
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($bold);

		$line++;
		$line1 = $line + 1;
		$begline = $line;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'NAME');
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($center);
		$activeSheet->mergeCells('A'.$line.':F'.$line);

		$objPHPExcel->getActiveSheet()->setCellValue('G'.$line.'', 'RELATION');
		$activeSheet->getStyle('G'.$line.'')->applyFromArray($center);
		$activeSheet->mergeCells('G'.$line.':I'.$line);

		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line.'', 'DATE OF BIRTH');
		$activeSheet->getStyle('J'.$line.'')->applyFromArray($center);
		$activeSheet->mergeCells('J'.$line.':M'.$line);

		$objPHPExcel->getActiveSheet()->setCellValue('N'.$line.'', 'AGE');
		$activeSheet->getStyle('N'.$line.'')->applyFromArray($center);

		$objPHPExcel->getActiveSheet()->setCellValue('O'.$line.'', 'ADDRESS');
		$activeSheet->getStyle('O'.$line.'')->applyFromArray($center);
		$activeSheet->mergeCells('O'.$line.':T'.$line);

		$activeSheet->getStyle('A'.$line.':T'.$line)->getFont()->setSize(10);
		$activeSheet->getStyle('A'.$line.':T'.$line)->applyFromArray($bold);

		$employment = array(' ',' ',' ');

		$line++;
		foreach ($employment as $key => $value) {
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'',  $value);
			$activeSheet->mergeCells('A'.$line.':F'.$line);

			$objPHPExcel->getActiveSheet()->setCellValue('G'.$line.'',  $value);
			$activeSheet->mergeCells('G'.$line.':I'.$line);			

			$objPHPExcel->getActiveSheet()->setCellValue('J'.$line.'',  $value);
			$activeSheet->mergeCells('J'.$line.':M'.$line);	

			$objPHPExcel->getActiveSheet()->setCellValue('N'.$line.'',  $value);					

			$objPHPExcel->getActiveSheet()->setCellValue('O'.$line.'',  $value);
			$activeSheet->mergeCells('O'.$line.':T'.$line);	

			$line++;						
		}

		$endline = $line - 1;

		$activeSheet->getStyle('A'.$begline.':T'.$endline)->applyFromArray($border_style);

		$line = $line + 2;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'REFERENCES :');
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$line.'', '(Names and address of responsible persons, preferably those in business profession, ');

		$line++;
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$line.'', 'whom you have known for at least three years)');

		//References
		$line++;
		$line1 = $line + 1;
		$begline = $line;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'NAME');
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($center);
		$activeSheet->mergeCells('A'.$line.':F'.$line);

		$objPHPExcel->getActiveSheet()->setCellValue('G'.$line.'', 'ADDRESS / TELEPHONE NO.');
		$activeSheet->getStyle('G'.$line.'')->applyFromArray($center);
		$activeSheet->mergeCells('G'.$line.':M'.$line);

		$objPHPExcel->getActiveSheet()->setCellValue('N'.$line.'', 'OCCUPATION / YRS. OF ACQUAINTANCE');
		$activeSheet->getStyle('N'.$line.'')->applyFromArray($center);
		$activeSheet->mergeCells('N'.$line.':T'.$line);

		$activeSheet->getStyle('A'.$line.':T'.$line)->getFont()->setSize(10);
		$activeSheet->getStyle('A'.$line.':T'.$line)->applyFromArray($bold);

		$employment = array(' ',' ',' ');

		$line++;
		foreach ($employment as $key => $value) {
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'',  $value);
			$activeSheet->mergeCells('A'.$line.':F'.$line);

			$objPHPExcel->getActiveSheet()->setCellValue('G'.$line.'',  $value);
			$activeSheet->mergeCells('G'.$line.':M'.$line);			

			$objPHPExcel->getActiveSheet()->setCellValue('N'.$line.'',  $value);
			$activeSheet->mergeCells('N'.$line.':T'.$line);

			$line++;						
		}

		$endline = $line - 1;

		$activeSheet->getStyle('A'.$begline.':T'.$endline)->applyFromArray($border_style);

		//
		$line = $line + 2;	
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'Other information that will help in the evaluation of your application:');
		$activeSheet->getStyle('A'.$line.'')->getFont()->setSize(10);
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($bold);

		$line++;
		$begline = $line;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', '1 .');
		$activeSheet->getStyle('A'.$line)->applyFromArray($right);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$line.'', 'Do you have other sources of income?');
		$activeSheet->getStyle('H'.$line.':J'.$line)->applyFromArray($border_bottom);
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$line.'', 'If yes, specify');
		$activeSheet->getStyle('M'.$line.':T'.$line)->applyFromArray($border_bottom);

		$line++;
		$objPHPExcel->getActiveSheet()->getRowDimension($line)->setRowHeight(5);

		$line++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', '2 .');
		$activeSheet->getStyle('A'.$line)->applyFromArray($right);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$line.'', 'Do you live in  :');
		$activeSheet->getStyle('F'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$line.'', 'own house');
		$activeSheet->getStyle('J'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$line.'', 'rented house');
		$activeSheet->getStyle('O'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('p'.$line.'', 'others (specify)');
		$activeSheet->getStyle('R'.$line.':T'.$line)->applyFromArray($border_bottom);

		$line++;
		$objPHPExcel->getActiveSheet()->getRowDimension($line)->setRowHeight(5);

		$line++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', '3 .');
		$activeSheet->getStyle('A'.$line)->applyFromArray($right);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$line.'', 'How did you come to know of the company? Referred by');
		$activeSheet->getStyle('J'.$line.':N'.$line)->applyFromArray($border_bottom);
		$objPHPExcel->getActiveSheet()->setCellValue('O'.$line.'', 'or thru');
		$activeSheet->getStyle('P'.$line.':T'.$line)->applyFromArray($border_bottom);

		$line++;
		$objPHPExcel->getActiveSheet()->getRowDimension($line)->setRowHeight(5);

		$line++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', '4 .');
		$activeSheet->getStyle('A'.$line)->applyFromArray($right);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$line.'', 'Are you related to any employee of the company?');
		$activeSheet->getStyle('I'.$line.':K'.$line)->applyFromArray($border_bottom);
		$objPHPExcel->getActiveSheet()->setCellValue('L'.$line.'', 'If so, to whom?');
		$activeSheet->getStyle('N'.$line.':T'.$line)->applyFromArray($border_bottom);

		$line++;
		$objPHPExcel->getActiveSheet()->getRowDimension($line)->setRowHeight(5);

		$line++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', '5 .');
		$activeSheet->getStyle('A'.$line)->applyFromArray($right);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$line.'', 'Have you been involved in any administrative, civil, or criminal case?');
		$activeSheet->getStyle('M'.$line.':T'.$line)->applyFromArray($border_bottom);

		$line++;
		$objPHPExcel->getActiveSheet()->getRowDimension($line)->setRowHeight(5);

		$line++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', '6 .');
		$activeSheet->getStyle('A'.$line)->applyFromArray($right);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$line.'', 'Do you have any physical defects?');
		$activeSheet->getStyle('H'.$line.':T'.$line)->applyFromArray($border_bottom);

		$line++;
		$objPHPExcel->getActiveSheet()->getRowDimension($line)->setRowHeight(5);

		$line++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', '7 .');
		$activeSheet->getStyle('A'.$line)->applyFromArray($right);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$line.'', 'What serious illness, operations or accidents have you had?');
		$activeSheet->getStyle('L'.$line.':T'.$line)->applyFromArray($border_bottom);

		$line++;
		$objPHPExcel->getActiveSheet()->getRowDimension($line)->setRowHeight(5);

		$line++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', '8 .');
		$activeSheet->getStyle('A'.$line)->applyFromArray($right);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$line.'', 'Do you take liquor?');
		$activeSheet->getStyle('F'.$line.':G'.$line)->applyFromArray($border_bottom);
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$line.'', 'To what extent?');
		$activeSheet->getStyle('J'.$line.':L'.$line)->applyFromArray($border_bottom);
		$objPHPExcel->getActiveSheet()->setCellValue('M'.$line.'', 'Do you take drugs? (Specify)');
		$activeSheet->getStyle('P'.$line.':T'.$line)->applyFromArray($border_bottom);

		$line++;
		$objPHPExcel->getActiveSheet()->getRowDimension($line)->setRowHeight(5);

		$line++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', '9 .');
		$activeSheet->getStyle('A'.$line)->applyFromArray($right);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$line.'', 'Have you ever been dismissed or suspended from any position?');
		$activeSheet->getStyle('L'.$line.':N'.$line)->applyFromArray($border_bottom);
		$objPHPExcel->getActiveSheet()->setCellValue('O'.$line.'', 'Explain');
		$activeSheet->getStyle('P'.$line.':T'.$line)->applyFromArray($border_bottom);

		$line++;
		$objPHPExcel->getActiveSheet()->getRowDimension($line)->setRowHeight(5);

		$line++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', '10 .');
		$activeSheet->getStyle('A'.$line)->applyFromArray($right);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$line.'', 'Are you willing to be assigned in provincial projects?');
		$activeSheet->getStyle('J'.$line.':K'.$line)->applyFromArray($border_bottom);
		$objPHPExcel->getActiveSheet()->setCellValue('L'.$line.'', 'If so, what province in particular');
		$activeSheet->getStyle('P'.$line.':T'.$line)->applyFromArray($border_bottom);

		$activeSheet->getStyle('A'.$begline.':T'.$line)->getFont()->setSize(8);

		$line = $line + 2;
		$activeSheet->mergeCells('A'.$line.':T'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'I certify that the statements made in this application form are true and complete. I understand that any');
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($center);
		$activeSheet->getStyle('A'.$line.'')->getFont()->setSize(10);

		$line++;
		$activeSheet->mergeCells('A'.$line.':T'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'misrepresentation(s) or omission of information will be considered sufficient reason or withdrawal of an');
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($center);
		$activeSheet->getStyle('A'.$line.'')->getFont()->setSize(10);

		$line++;
		$activeSheet->mergeCells('A'.$line.':T'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'offer or subsequent dismissal, if employed.');
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($center);
		$activeSheet->getStyle('A'.$line.'')->getFont()->setSize(10);

		$line = $line + 4;
		$activeSheet->getStyle('C'.$line.':J'.$line)->applyFromArray($border_bottom);
		$activeSheet->getStyle('N'.$line.':S'.$line)->applyFromArray($border_bottom);

		$line++;
		$activeSheet->mergeCells('C'.$line.':J'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$line.'', 'Signature of Applicant');
		$activeSheet->getStyle('C'.$line.'')->applyFromArray($center);

		$activeSheet->mergeCells('N'.$line.':S'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('N'.$line.'', 'Date');
		$activeSheet->getStyle('N'.$line.'')->applyFromArray($center);

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save( $filename );

		return $filename;
	}    

    // excel format
	function employment_agreement( $report, $columns, $result )
	{
		ini_set('memory_limit', '1024M');   
        ini_set('max_execution_time', 1800);

		$this->load->helper('file');
		$path = 'uploads/reports/recruitment/excel/';
		$this->check_path( $path );
		$filename = $path . strtotime(date('Y-m-d H:i:s')) . 'Employment_agreement' . ".xlsx";

		$this->load->library('excel');

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setTitle("Employment Agreement Report")
		            ->setDescription("Employment Agreement Report");
		               
		// Assign cell values
		$objPHPExcel->setActiveSheetIndex(0);
		$activeSheet = $objPHPExcel->getActiveSheet();

		//header
		$alphabet  = range('A','Z');
		$alpha_ctr = 0;
		$sub_ctr   = 0;				

/*	    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);*/

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

		$right = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
			)
		);

		$v_center = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
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

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(3.42);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(1.63);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(4.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(4.42);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(5.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(11.85);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8.14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(1.63);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(1.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(3.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(4.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(5.42);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(3.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(1.54);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(1.85);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(3.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(3.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(8.14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(14);

		if ($result && $result->num_rows() > 0){
			$record = $result->row_array();
		}

		$line = 6;
		$xcoor = $alphabet[$alpha_ctr];

		$objPHPExcel->getActiveSheet()->setCellValue('A6', 'EMPLOYMENT AGREEMENT');	
		$activeSheet->getStyle('A6')->getFont()->setSize(16);

		$line = $line + 2;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'To');
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$line.'', $record['fullname']);
		$activeSheet->getStyle('E'.$line.':O'.$line)->applyFromArray($border_bottom);
		$objPHPExcel->getActiveSheet()->setCellValue('P'.$line.'', 'Date');
		$objPHPExcel->getActiveSheet()->setCellValue('R'.$line.'', $record['recruitment_date']);
		$activeSheet->getStyle('R'.$line.':U'.$line)->applyFromArray($border_bottom);

		$line++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'City Address');
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$line.'', $record['present_ddress']);
		$activeSheet->getStyle('E'.$line.':U'.$line)->applyFromArray($border_bottom);

		$line++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'Provincial Address');
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$line.'', $record['present_province']);
		$activeSheet->getStyle('E'.$line.':U'.$line)->applyFromArray($border_bottom);

		$line++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'Date of Birth');
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$line.'', $record['birthdate']);
		$activeSheet->getStyle('E'.$line.':H'.$line)->applyFromArray($border_bottom);
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$line.'', 'Marital Status');
		$objPHPExcel->getActiveSheet()->setCellValue('M'.$line.'', $record['civil_status']);
		$activeSheet->getStyle('M'.$line.':O'.$line)->applyFromArray($border_bottom);
		$objPHPExcel->getActiveSheet()->setCellValue('P'.$line.'', 'Telephone No.');
		$objPHPExcel->getActiveSheet()->setCellValue('T'.$line.'', $record['phone']);
		$activeSheet->getStyle('T'.$line.':U'.$line)->applyFromArray($border_bottom);

		$line++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'TIN');
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$line.'', $record['tin_number']);
		$activeSheet->getStyle('C'.$line.':H'.$line)->applyFromArray($border_bottom);
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$line.'', 'SSS');
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$line.'', $record['sss_number']);
		$activeSheet->getStyle('K'.$line.':O'.$line)->applyFromArray($border_bottom);
		$objPHPExcel->getActiveSheet()->setCellValue('P'.$line.'', 'Pag-ibig No.');
		$objPHPExcel->getActiveSheet()->setCellValue('T'.$line.'', '');
		$activeSheet->getStyle('T'.$line.':U'.$line)->applyFromArray($border_bottom);

		$line = $line + 2;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'You are hereby notified of the following actions affecting your employment:');
		$activeSheet->getStyle('A'.$line.'')->getFont()->setSize(13);
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($bold);

		$line = $line + 2;
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$line.'', 'Employment');

		$activeSheet->getStyle('H'.$line.':I'.$line)->applyFromArray($border_style);
		$activeSheet->mergeCells('H'.$line.':I'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line.'', 'Change of Employment Status');

		$activeSheet->getStyle('O'.$line.':P'.$line)->applyFromArray($border_style);
		$activeSheet->mergeCells('O'.$line.':P'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('Q'.$line.'', 'Disciplinary Action (See Particulars)');

		$line++;
		$objPHPExcel->getActiveSheet()->getRowDimension($line)->setRowHeight(5);

		$line++;
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$line.'', 'Salary Adjustment');

		$activeSheet->getStyle('H'.$line.':I'.$line)->applyFromArray($border_style);
		$activeSheet->mergeCells('H'.$line.':I'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line.'', 'Voluntary Resignation (Acceptance/Rejection)');
		$activeSheet->getStyle('J'.$line.'')->getAlignment()->setWrapText(true);
		$activeSheet->mergeCells('J'.$line.':N'.($line+1));

		$activeSheet->getStyle('O'.$line.':P'.$line)->applyFromArray($border_style);
		$activeSheet->mergeCells('O'.$line.':P'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('Q'.$line.'', 'Termination of Employment                                      (See Particulars)       ');
		$activeSheet->getStyle('Q'.$line.'')->getAlignment()->setWrapText(true);
		$activeSheet->mergeCells('Q'.$line.':U'.($line+1));

		$line++;
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$line.'', 'Transfer');

		$line = $line + 2;
		$begline = $line;
		$activeSheet->mergeCells('A'.$line.':F'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'Job/Position Title');
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($center);

		$activeSheet->mergeCells('G'.$line.':L'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$line.'', 'Place of Work');
		$activeSheet->getStyle('G'.$line.'')->applyFromArray($center);

		$activeSheet->mergeCells('M'.$line.':Q'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('M'.$line.'', 'Salary Rate');
		$activeSheet->getStyle('M'.$line.'')->applyFromArray($center);

		$activeSheet->mergeCells('R'.$line.':U'.$line);
		$objPHPExcel->getActiveSheet()->setCellValue('R'.$line.'', 'Effective Date of Action');
		$activeSheet->getStyle('R'.$line.'')->applyFromArray($center);

		$line++;
		$this->db->where('recruit_id',$record['recruit_id']);
		$this->db->like('key', 'employment', 'after'); 
		$this->db->order_by('sequence,key_id');
		$employment_result = $this->db->get('recruitment_personal_history');

		if ($employment_result && $employment_result->num_rows() > 0){	
			$sequence = array();
			$ctr = 0;
			foreach ($employment_result->result() as $row) {
				if (!in_array($row->sequence, $sequence)){
					$sequence[] = $row->sequence;

					if ($ctr > 0){
						$line++;	
					}										
				}

				$activeSheet->mergeCells('A'.$line.':F'.$line);	
				$activeSheet->mergeCells('G'.$line.':L'.$line);
				$activeSheet->mergeCells('M'.$line.':Q'.$line);

				switch ($row->key) {
					case 'employment-position-title':
							$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'',  $row->key_value);	
						break;	
					case 'employmemployment-location':
							$objPHPExcel->getActiveSheet()->setCellValue('G'.$line.'',  "ll");	
						break;	
					case 'employment-last-salary':
							$objPHPExcel->getActiveSheet()->setCellValue('M'.$line.'',  $row->key_value);		
						break;														
				}

				$objPHPExcel->getActiveSheet()->setCellValue('R'.$line.'',  '');
				$activeSheet->mergeCells('R'.$line.':U'.$line);				

				$ctr++;
			}			

			$endline = $line;

			$activeSheet->getStyle('A'.$begline.':U'.$endline)->applyFromArray($border_style);			
		}
		else{
			$endline = $line - 1;

			$activeSheet->getStyle('A'.$begline.':U'.$endline)->applyFromArray($border_style);				
		}

		$line = $line + 2;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'Particulars :');

		$line++;
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$line.'', '1. Employment is co-terminus within the completion of the project or phase of work where you are ');

		$line++;
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$line.'', 'specifically assigned.');

		$line++;
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$line.'', '2. Project Duration :');

		$line = $line + 2;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'TERMS AND CONDITIONS :');
		$activeSheet->getStyle('A'.$line.'')->getFont()->setSize(13);
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($bold);

		$line = $line + 2;
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$line.'', 'Casual Employment');

		$activeSheet->getStyle('J'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$line.'', '15 Days VL and 15 Days SL after 12 months of Continous Service');

		$line++;
		$objPHPExcel->getActiveSheet()->getRowDimension($line)->setRowHeight(5);

		$line++;
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$line.'', 'Project Employment');

		$activeSheet->getStyle('J'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$line.'', '5 Days Service Incentive Leave per year');

		$line++;
		$objPHPExcel->getActiveSheet()->getRowDimension($line)->setRowHeight(5);

		$line++;
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$line.'', 'Probationary Employment');

		$activeSheet->getStyle('J'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$line.'', 'Entitled to Overtime with pay');

		$line++;
		$objPHPExcel->getActiveSheet()->getRowDimension($line)->setRowHeight(5);

		$line++;
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$line.'', 'Regular Employment');

		$activeSheet->getStyle('J'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$line.'', 'Duties and Salary Level Exempt yo from Overtime Compensation');

		$line = $line + 3;
		$begline = $line;
		$activeSheet->mergeCells('A'.$line.':F'.$line);	
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'Initiated');
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($center);

		$activeSheet->mergeCells('G'.$line.':M'.$line);	
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$line.'', 'Checked');
		$activeSheet->getStyle('G'.$line.'')->applyFromArray($center);

		$activeSheet->mergeCells('N'.$line.':U'.$line);	
		$objPHPExcel->getActiveSheet()->setCellValue('N'.$line.'', 'Approved');
		$activeSheet->getStyle('N'.$line.'')->applyFromArray($center);

		$activeSheet->getStyle('G'.$line.'')->applyFromArray($v_center);
		$objPHPExcel->getActiveSheet()->getRowDimension($line)->setRowHeight(27.5);

		$line++;
		$activeSheet->mergeCells('A'.$line.':F'.$line);	
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'EVELYN A. BUERA                     Manager - PGAD');
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($center);
		$activeSheet->getStyle('A'.$line.'')->getAlignment()->setWrapText(true);

		$activeSheet->mergeCells('G'.$line.':M'.$line);	
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$line.'', 'Project Manager');
		$activeSheet->getStyle('G'.$line.'')->applyFromArray($center);
		$activeSheet->getStyle('G'.$line.'')->getAlignment()->setWrapText(true);

		$activeSheet->mergeCells('N'.$line.':U'.$line);	
		$objPHPExcel->getActiveSheet()->setCellValue('N'.$line.'', 'EMELITO D. CABUCO                                                                                                                                                     Senior Vice President');
		$activeSheet->getStyle('N'.$line.'')->applyFromArray($center);
		$activeSheet->getStyle('N'.$line.'')->getAlignment()->setWrapText(true);

		$objPHPExcel->getActiveSheet()->getRowDimension($line)->setRowHeight(76.5);

		$endline = $line;

		$activeSheet->getStyle('A'.$begline.':U'.$endline)->applyFromArray($border_style);

		$line = $line + 2;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'Accepted with the terms and conditions stated at the back hereof :');

		$line = $line + 2;
		$activeSheet->getStyle('S'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('T'.$line.'', 'Personnel Copy');

		$line++;
		$objPHPExcel->getActiveSheet()->getRowDimension($line)->setRowHeight(5);

		$line++;
		$activeSheet->getStyle('S'.$line.'')->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('T'.$line.'', 'Employee Copy');

		$line++;
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line.'', 'Employee');
		$activeSheet->getStyle('E'.$line.':I'.$line)->applyFromArray($border_bottom);
		$activeSheet->getStyle('A'.$line.'')->applyFromArray($bold);

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save( $filename );

		return $filename;
	}  	
}