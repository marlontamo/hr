<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class upload_utility_model extends Record
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
		$this->mod_id = 176;
		$this->mod_code = 'upload_utility';
		$this->route = 'utilities/upload';
		$this->url = site_url('utilities/upload');
		$this->primary_key = 'log_id';
		$this->table = 'system_upload_log';
		$this->icon = 'fa-folder';
		$this->short_name = 'Utility Manager';
		$this->long_name  = 'Utility Manager';
		$this->description = '';
		$this->path = APPPATH . 'modules/upload_utility/';

		parent::__construct();
	}

	function get_templates( $mod_id = 0 )
	{
		$templates = $this->db->get_where('system_upload_template', array('deleted' => 0, 'module_id' => $mod_id));
		if( $templates->num_rows() > 0 )
			return $templates->result();
		else
			return false;
	}

	function upload( $file, $template, $csv_convert = false )
	{
		$response = new stdClass();

		//get template columns
		$this->db->order_by('sequence');
		$columns = $this->db->get_where('system_upload_template_column', array('template_id' => $template->template_id));
		if( $columns->num_rows() > 0 )
		{
			$column = $columns->result();
			if($csv_convert)
				$fdata = file($csv_convert);
			else
				$fdata = file($file);

			$response->rows = 0;
			$response->valid_count = 0;
			$response->error_count = 0;
			$delimiter = $template->delimiter;
			$header = true;
			foreach($fdata as $row)
			{
				if( $template->skip_headers && $header ){
					$header = false;
					continue;
				}
				
				$row = trim($row);
				if( !empty( $row ) )
				{
					$insert = array();
					if(!empty($delimiter))
					{
						$data = $this->process_row( $row, $delimiter );
						if( sizeof($data) < sizeof($column))
						{
							$response->error_count++;
							continue;
						}

						foreach($column as $index => $col)
						{
							if( $csv_convert )
							{
								$data[$index] = substr($data[$index], 1, -1);
							}

							if( $col->required )
							{
								if( !$col->allow_blank && $data[$index] == "" )
								{
									$insert = false;
									$response->error_count++;
									break;
								}

								switch($col->data_type)
								{
									case 'int':
										if(!ctype_digit($data[$index]))
										{
											$insert = false;
											$response->error_count++;
											break 2;
										}
										break;
									case 'timestamp':
										$data[$index] = date('Y-m-d G:i:s', strtotime( $data[$index] ));
										if (DateTime::createFromFormat('Y-m-d G:i:s', $data[$index]) === FALSE)
										{
											$insert = false;
											$response->error_count++;
											break 2;
										}
										break;
									case 'date':
										$data[$index] = date('Y-m-d', strtotime( $data[$index] ));
										if ( $data[$index] != "" && DateTime::createFromFormat('Y-m-d', $data[$index]) === FALSE)
										{
											$insert = false;
											$response->error_count++;
											break 2;
										}
										break;
									case 'switch':
										if( $data[$index] != 0 && $data[$index] != 1 )
										{
											$insert = false;
											$response->error_count++;
											break 2;
										}
										break;
								}
								$insert[$col->table][$col->column] = $data[$index];

								if( $col->encrypt )
								{
									$this->load->library('aes', array('key' => $this->config->item('encryption_key')));
									$insert[$col->table][$col->column] = $this->aes->encrypt( $insert[$col->table][$col->column] );
								}
							}							
						}
					} 
					
					switch( $template->template_code )
					{
						case "BATCH_ENTRY":
							$this->_batch_entry_insert( $insert, $response );
							break;
						case "RECURRING_ENTRY":
							$this->_recurring_entry_insert( $insert, $response );
							break;
						default:
							$this->_default_insert( $insert, $response );
							
					}

					$response->rows++;
				}
			}

			$log = array(
				'template_id' => $template->template_id,
				'file_path' => $file,
				'filesize' => filesize($file),
				'rows' => $response->rows,
				'valid_count' => $response->valid_count,
				'error_count' => $response->error_count,
				'created_by' => $this->user->user_id
			);

			$this->db->insert('system_upload_log', $log);

			if($csv_convert)
				unlink($csv_convert);
		}
		else{
			$response->message[] = array(
				'message' => lang('upload_utility.no_columns'),
				'type' => 'warning'
			);
		}

		return $response; 
	}

	private function _default_insert( $insert, &$response )
	{
		if( $insert && sizeof($insert) > 0 )
		{
			foreach( $insert as $table => $tcolumns )
			{
				// CHECK IF RECORD EXIST
				$this->db->where('id_number',$tcolumns['id_number']);
				$this->db->where('document_no',$tcolumns['document_no']);
				$exist = $this->db->get($table);
				if($exist && $exist->num_rows() > 0 ){
					$this->db->where('id_number',$tcolumns['id_number']);
					$this->db->where('document_no',$tcolumns['document_no']);
					$this->db->delete($table);
				}
				$this->db->insert($table, $tcolumns);
				if( $this->db->_error_message() != "" )
				{
					$response->q[] = $this->db->_error_message();
					$response->error_count++;
				}
				else
					$response->valid_count++;
			}
		}
	}

	private function _batch_entry_insert( $insert, &$response )
	{
		if( $insert && sizeof($insert) > 0 )
		{
			//check parent
			$this->db->limit(1);
			$batch_entry = $this->db->get_where('payroll_entry_batch', array('document_no' => $insert['payroll_entry_batch']['document_no']));

			if( $batch_entry->num_rows() == 0 )
			{
				$this->db->insert('payroll_entry_batch', $insert['payroll_entry_batch']);
			}
			$insert['payroll_entry_batch_employee']['document_no'] = $insert['payroll_entry_batch']['document_no'];
			unset($insert['payroll_entry_batch']);
			$this->_default_insert( $insert, $response );
		}
	}

	private function _recurring_entry_insert( $insert, &$response )
	{
		if( $insert && sizeof($insert) > 0 )
		{
			//check parent
			$this->db->limit(1);
			$recurring_entry = $this->db->get_where('payroll_entry_recurring', array('document_no' => $insert['payroll_entry_recurring']['document_no']));
			if( $recurring_entry->num_rows() == 0 )
			{
				$this->db->insert('payroll_entry_recurring', $insert['payroll_entry_recurring']);
			}
			$insert['payroll_entry_recurring_employee']['document_no'] = $insert['payroll_entry_recurring']['document_no'];
			unset($insert['payroll_entry_recurring']);
			$this->_default_insert( $insert, $response );
		}
	}

	public function process_row( $row, $delimiter )
	{
		return explode( "$delimiter", $row );
	}
}