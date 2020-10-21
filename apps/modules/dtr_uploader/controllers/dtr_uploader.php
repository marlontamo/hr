<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dtr_uploader extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('dtr_uploader_model', 'mod');
		parent::__construct();
	}

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

		$this->load->model('upload_utility_model', 'import');
		$mod_id = $this->input->post('mod_id');
		$vars['templates'] = $this->import->get_templates( $mod_id );
		if( $vars['templates'] )
		{
			$this->load->vars( $vars );

			$data['title'] = $this->mod->short_name .' - Import';
			$data['content'] = $this->load->blade('common.import-form')->with( $this->load->get_cached_vars() );

			$this->response->import_form = $this->load->view('templates/modal', $data, true);

			$this->response->message[] = array(
				'message' => '',
				'type' => 'success'
			);
		}
		else{
			$this->response->message[] = array(
				'message' => lang('common.no_import_settings'),
				'type' => 'warning'
			);
		}
		
		$this->_ajax_return();
	}

	public function download_template(){
		
		$template = $this->mod->get_template($_GET['template_id']);
		if( $template && $template->num_rows() > 0 ) {
			$upload_template = $template->row();
			$File = strtolower($upload_template->sample_path . "/" . $upload_template->sample_name . "." . $upload_template->accepted_file_types);
			header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($File));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');

            $Handle = fopen($File, 'r');
            readfile($File);
            exit();
		}
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

		$this->db->limit(1);
		$template = $this->db->get_where( 'system_upload_template', array('deleted' => 0,'template_id' => $template_id) )->row();

		$this->db->order_by('sequence','asc');
		$column = $this->db->get_where('system_upload_template_column',array('template_id' => $template_id));
		if($column && $column->num_rows() > 0){
			$cols = $column->result();
			foreach ($cols as $key => $value) {
				$col[$value->sequence] = $value->column;
			}
		}

		$accepted_file_types = explode(',', $template->accepted_file_types);
		$delimiter = $template->delimiter == "tab" ? "\t" : ",";
		
		if (!in_array($ext, $accepted_file_types)) {
            $this->response->message[] = array(
				'message' => lang('upload_utility.file_type_not_accepted'),
				'type' => 'warning'
			);
			$this->_ajax_return();
        }

        $this->load->model('upload_utility_model', 'import');

        $csv_convert = false;
        if(is_array($col) && count($col) > 0 ) {
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
	        } elseif( $ext == 'dat' ) {
	        	$record = fopen( urldecode($file) ,"r" );
				$cnt = 0;
				$file_record = array();
				//read file and put put in array
				while ($row = fgets($record))
			    {
			    	$cnt++;
			    	if($template->skip_headers == 1 && $cnt == 1){
			    		// $col = explode("$delimiter", $row);
			    		// continue;
			    	}

			    	$row = trim($row);
			    	$process = $this->import->process_row($row,$delimiter);
					foreach ($process as $k => $val) {
			   			$file_record[$col[$k]] = $val;
			   		}
			        $result[] = $file_record ;
			    }
	        } elseif( $ext == 'txt' ) {
	        	$record = fopen( urldecode($file) ,"r" );
				$cnt = 0;
				$file_record = array();
				//read file and put put in array
				while ($row = fgets($record))
			    {
			    	$cnt++;
			    	if($template->skip_headers == 1 && $cnt == 1){
			    		continue;
			    	}

			    	$row = trim($row);
			    	
			    	$process[0] = substr($row, 0, 8);
			    	$process[1] = substr($row, 25, 19);
			    	$process[2] = substr($row, 45, 4);

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
/*		   				if (DateTime::createFromFormat('Y-m-d H:i:s', $_rec) === FALSE){
		   					$error_msg .= "Invalid date and time format  in line " . ($line+2) . ".<br />";
		   					$err = 1;
		   				}*/

	 	   				// if( preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) [0-2][0-3]:[0-5][0-9]:[0-5][0-9]/", date("Y-m-d H:i:s",strtotime($_rec))) ) {
	 	   				// 	$error_msg .= "Invalid date and time in line " . ($line+2) . ".<br />";
	 	   				// 	$err = 1;
	 	   				// }
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
					'message' => 'Validation complete. Ready for upload!',
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
	    } else {
			$response->message[] = array(
				'message' => lang('upload_utility.no_columns'),
				'type' => 'warning'
			);
	    }
		$this->_ajax_return();
	}
}