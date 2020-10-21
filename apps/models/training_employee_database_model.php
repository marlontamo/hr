<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class training_employee_database_model extends Record
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
		$this->mod_id = 247;
		$this->mod_code = 'training_employee_database';
		$this->route = 'training/training_employee_database';
		$this->url = site_url('training/training_employee_database');
		$this->primary_key = 'employee_database_id';
		$this->table = 'training_employee_database';
		$this->icon = '';
		$this->short_name = 'Training Employee Database';
		$this->long_name  = 'Training Employee Database';
		$this->description = '';
		$this->path = APPPATH . 'modules/training_employee_database/';

		parent::__construct();
	}

	function export_excel()
	{
		ini_set('memory_limit', '1024M');   
        ini_set('max_execution_time', 1800);
        $excelcolumn = '';
        $header = 1; // to bold the header default is BOLD
        $lmr_header = 0; 
        $slvlm_header = 0; 
        $manstatus_header = 0; //manpower status report
        if(isset($_POST['filter']))
            $filter = $_POST['filter'];
        else
            $filter = '';
        

  //       $reports = $this->get_report( $this->input->post( 'record_id' ) );
		// $query = $this->export_query( $reports, $filter );	

		$employee_database = "SELECT 
			`ww_training_employee_database`.`employee_database_id` as record_id, 
			`ww_training_employee_database`.`employee_id` as 'training_employee_database_employee_id',
			`ww_training_employee_database`.`position_id` as 'training_employee_database_position_id',
			`ww_training_employee_database`.`department_id` as 'training_employee_database_department_id',
			`ww_training_employee_database`.`training_balance` as 'training_employee_database_training_balance',
			`ww_training_employee_database`.`daily_training_cost` as 'training_employee_database_daily_training_cost',
			`ww_training_employee_database`.`start_date` as 'training_employee_database_start_date',
			`ww_training_employee_database`.`end_date` as 'training_employee_database_end_date',
			`T1`.`full_name` as 'training_employee_database_employee',
			`T2`.`position` as 'training_employee_database_position',
			`T3`.`department` as 'training_employee_database_department'
			FROM (`ww_training_employee_database`)
			LEFT JOIN `ww_users` T1 ON `T1`.`user_id` = `ww_training_employee_database`.`employee_id`
			LEFT JOIN `ww_users_position` T2 ON `T2`.`position_id` = `ww_training_employee_database`.`position_id`
			LEFT JOIN `ww_users_department` T3 ON `T3`.`department_id` = `ww_training_employee_database`.`department_id`";
        
        $result = $this->db->query($employee_database);
		$excel = $this->load->view("templates/employee_database", array('result' => $result), true);	
		$excelcolumn = 'AZ';

		$this->load->helper('file');
		$path = 'uploads/templates/training_employee_database/';
		$this->check_path( $path );
		$filename = $path . strtotime(date('Y-m-d H:i:s')) . '-TRAINING_EMPLOYEE_DATABASE' . ".xlsx";
		$tmpfile = $path . strtotime(date('Y-m-d H:i:s')) . ".html";
		write_file( $tmpfile, $excel);

		$this->load->library('excel');

		$reader = new PHPExcel_Reader_HTML(); 
		$content = $reader->load($tmpfile); 
		$columns['columns'] = $result->result();

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

			    $border_style = array(
					'borders' => array(
					    'allborders' => array(
					      'style' => PHPExcel_Style_Border::BORDER_THIN
					    )
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
                $new_columns = $this->createColumnsArray($end_column, $column);
                // Merge the new columns which were created with the final columns array.
                $columns = array_merge($columns, $new_columns);
            }
      }

      return $columns;
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