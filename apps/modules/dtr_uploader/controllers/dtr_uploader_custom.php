<?php //delete me
	function index()
	{
		$this->load->library('form_validation');

		$rules = array(
        	array(
                'field'   => 'device_id',
                'label'   => 'Device',
                'rules'   => 'required'
            )
        );

        $this->form_validation->set_rules( $rules ); 

        if( $this->form_validation->run() == false )
		{
			if( validation_errors() != "" )
			{
				foreach( $this->form_validation->get_error_array() as $f => $f_error )
				{
					$this->response->message[] = array(
						'message' => $f_error,
						'type' => 'warning'
					);	
				}
			}
			else{
				$this->response->message[] = array(
					'message' => "No data was submitted!",
					'type' => 'error'
				);	
			}
		}
		else{
			$device_id = $this->input->post('device_id');
			$this->response = $this->mod->import_from_file( $device_id );
		}

		$this->_ajax_return();
	}

	function run()
	{
		$_POST['device_id'] = 1;
		$this->index();
	}

	function runall()
	{
		$devices = $this->mod->_get_devices(); 

		foreach( $devices as $device) 
		{
			$this->response->message[] = $this->mod->import_from_file( $device->device_id );
		}
		
		$this->_ajax_return();

	}