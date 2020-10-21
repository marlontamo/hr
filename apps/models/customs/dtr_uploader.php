<?php //delete me
	function import_from_file( $device_id )
	{
		$response = new stdClass();
		$response->processed = 0;
		$this->db->limit(1, 0);
		$device = $this->db->get_where('time_device', array('device_id' => $device_id));

		if( $device->num_rows() != 1  )
		{
			$response->message[] = array(
				'message' => "Can not find device configuration!",
				'type' => 'error'
			);
			goto stop;
		}

		$device = $device->row();
		$fields = $this->_get_device_fields( $device->device_id );

		$this->load->helper('file');

		switch( $device->delimeter )
		{
			case 'none':

				break;
			case 'tab':
			case 'comma':
			default;
				if( $device->delimeter == 'tab' ) $delimiter = "\t";
				if( $device->delimeter == 'comma' ) $delimiter = ",";

				$files = get_dir_file_info( $device->folder_location );
				if( $files )
				{
					foreach( $files as $f_name => $file )
					{
						$f_info = pathinfo( $file['server_path'] );
						if( isset( $f_info['extension'] ) && $f_info['extension'] === $device->file_extension )
						{
							$response->processed += $this->_import_delimited_file( $delimiter, $device, $fields, $file['server_path'], $response );
							
							//move file
							if( !is_dir( FCPATH . $device->folder_location . '/processed' ) ){
								mkdir( FCPATH . $device->folder_location . '/processed', 0777, TRUE);
								$indexhtml = read_file( APPPATH .'index.html');
				                write_file( FCPATH . $device->folder_location . '/processed/index.html', $indexhtml);
							}

							$to_write = read_file( $file['server_path'] );
							write_file( FCPATH . $device->folder_location . '/processed/'.strtotime(date('Y-m-d H:i:s')) .'-'. $f_info['basename'], $to_write);
							unlink( $file['server_path'] );
						}
					}
				}
		}

		stop:
		return $response;
	}

	private function _import_delimited_file( $delimiter, $device, $fields, $file )
	{
		$processed = 0;
		
		$fdata = file( $file );
		$skip = false;

		if( $device->with_col_headers )
			$skip = true;
		
		foreach($fdata as $row)
		{
			if( $skip )
			{
				$skip = false;
				continue;
			}

			$columns = explode($delimiter, $row);

			$data = array();
			foreach( $fields as $index => $field )
			{
				$data[ $field->field ] = $columns[$index];
			}

			if( sizeof($data) > 0 )
			{
				$old = $this->db->get_where('time_record_raw', $data);
				if( $old->num_rows() == 0 )
				{
					$this->db->insert('time_record_raw', $data);
					$processed++;
				}
			}
		}

		return $processed;
	}

	function _get_devices()
	{
		$device = $this->db->get_where('time_device', array('deleted' => 0));

		if( $device->num_rows() > 0 )
			return $device->result();
		else
			return array();
	}

	private function _get_device_fields( $device_id )
	{
		$this->db->order_by('sequence');
		$fields = $this->db->get_where('time_device_column', array('device_id' => $device_id));

		if( $fields->num_rows() > 0 )
			return $fields->result();
		else
			return array();
	}
