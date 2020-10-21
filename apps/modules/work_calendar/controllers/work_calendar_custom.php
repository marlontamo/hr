<?php //delete me

	public function index(){
		
		if( !$this->permission['list'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		echo $this->load->blade('record_listing_custom')->with( $this->load->get_cached_vars() );
        die();
	}

	public function get_list(){

		$this->_ajax_only();

		// Prepare date filters
		$start_date = \DateTime::createFromFormat('D M d Y H:i:s e+', $this->input->post('start_date')); // Thu Nov 15 2012 00:00:00 GMT-0700 (Mountain Standard Time)
		$start_date = $start_date->format('Y-m-d');

		$end_date = \DateTime::createFromFormat('D M d Y H:i:s e+', $this->input->post('end_date')); // Thu Nov 15 2012 00:00:00 GMT-0700 (Mountain Standard Time)
		$end_date = $end_date->format('Y-m-d');

		$this->response->shift= $this->mod->get_shift(); 
		$this->response->list = $this->mod->get_work_calendar_details($start_date, $end_date, $this->session->userdata('user')->user_id);
		

		$this->_ajax_return();
	}

	function save(){

		$this->_ajax_only();


		// final
		$Partners = isset($_POST['user_id']) ? $_POST['user_id'] : '';
		$shift_id = isset($_POST['shift_id']) ? $_POST['shift_id'] : '';
		$start_date = isset($_POST['date']['start']) ? $_POST['date']['start'] : '';
		$end_date = isset($_POST['date']['end']) ? $_POST['date']['end'] : '';

		//double check if date is set
		$start_date = $start_date == '' ? $_POST['current_date'] : $start_date;

		if( !$Partners ){

			$this->response->message[] = array(
			    'message' => 'Please choose partner(s)!',
			    'type' => 'error'
			);

			$this->_ajax_return();	
			die();				
		}

		if(isset($_POST['update_shift'])){ 

			foreach($Partners as $index => $id){
				$this->mod->update_partner_work_schedule( date("Y-m-d", strtotime($start_date)), $Partners[$index], $shift_id[$index]);	
			}
		}
		else{ 

			while (strtotime($start_date) <= strtotime($end_date)) {

				foreach($Partners as $index => $id){

					// IF SHIFT ID NOT BLANK??? SAVE? IF YES CONTINUE NEXT LOOP!!!
					$this->mod->update_partner_work_schedule( date("Y-m-d", strtotime($start_date)), $Partners[$index], $shift_id[$index]);				
				}

				$start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));
			}
		}

		$this->response->message[] = array(
		    'message' => 'Partner schedule added and or updated successfully!',
		    'type' => 'success'
		);

		$this->_ajax_return();
    }


    public function get_available_schedules(){

    	$this->_ajax_only();

        if( !$this->permission['add'] && !$this->permission['edit'] )
        {
            $this->response->message[] = array(
                'message' => 'You dont have sufficient permission to file forms on this calendar, please notify the System Administrator.',
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        $this->load->helper('form');
        $data = array();  

        $data['shifts'] = $this->mod->get_shift();

        $data['partners']= 
        	$this->mod->get_assigned_partners(
        		$this->session->userdata('user')->user_id
        		, date("Y-m-d", strtotime($this->input->post('date')))
        		, $this->input->post('shift_id'));

        $data['currentday_schedules'] = 
        	$this->mod->get_work_calendar_details(
        		date("Y-m-d", strtotime($this->input->post('date'))), 
        		date("Y-m-d", strtotime($this->input->post('date'))), 
        		$this->session->userdata('user')->user_id);

        //edit_assigned_partners_rows_only
        $this->response->rows = $this->load->view('edit/edit_assigned_partners_rows_only', $data, true);
        $this->response->available_scheds = $this->load->view('edit/edit_assigned_partners_scheds_only', $data, true);

        $this->response->message[] = array(
		    'message' => '',
		    'type' => 'success'
		);

    	$this->_ajax_return();
    }

    public function get_assigned_partners(){

        $this->_ajax_only();

        if( !$this->permission['add'] && !$this->permission['edit'] )
        {
            $this->response->message[] = array(
                'message' => 'You dont have sufficient permission to file forms on this calendar, please notify the System Administrator.',
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        $this->load->helper('form');
        $data = array();

        $data['title'] = 'Manage Partners Work Schedule';
        $data['shifts'] = $this->mod->get_shift();
        $data['date'] = $_POST['date'];

        $data['partners']= 
        	$this->mod->get_assigned_partners(
        		$this->session->userdata('user')->user_id
        		, date("Y-m-d", strtotime($this->input->post('date')))
        		, $this->input->post('shift_id'));

        $data['currentday_schedules'] = 
        	$this->mod->get_work_calendar_details(
        		date("Y-m-d", strtotime($this->input->post('date'))), 
        		date("Y-m-d", strtotime($this->input->post('date'))), 
        		$this->session->userdata('user')->user_id);

        $view['content'] = $this->load->view('edit/edit_assigned_partners', $data, true);
        
        //$this->response->edit_assigned_partners = $this->load->view('templates/modal', $view, true);
        $this->response->edit_assigned_partners = $view['content'];

		$this->response->message[] = array(
		    'message' => '',
		    'type' => 'success'
		);

    	$this->_ajax_return(); 
    }

	public function get_manager_partners($manager_id = '0'){

        $this->_ajax_only();

        if( !$this->permission['add'] && !$this->permission['edit'] )
        {
            $this->response->message[] = array(
                'message' => 'You dont have sufficient permission to file forms on this calendar, please notify the System Administrator.',
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        $this->load->helper('form');
        $data = array();


        // check if some required post data is received.
        if(!empty($_POST)){

        	if($this->input->post('page') == '1'){

        		// process everything
        		// load partners too

        		$data['form_title'] = "Select Date(s)";
        		$view['title'] = 'Manage Partners Work Schedule';

        		$start_date = '';
        		$end_date = '';

        		if(isset($_POST['start_date'])){
	        		$start_date = \DateTime::createFromFormat('D M d Y H:i:s e+', $this->input->post('start_date'));
	        		$start_date = $start_date->format('F d, Y');        			
        		}

				if(isset($_POST['end_date'])){
        			$end_date = \DateTime::createFromFormat('D M d Y H:i:s e+', $this->input->post('end_date'));
        			$end_date = $end_date->format('Y-m-d');
        		}
        		
        		$data['start_date']= $start_date;
        		$data['end_date']= $end_date;
        		$data['shift_id']= $this->input->post('shift_id');
        		$view['content'] = $this->load->view('edit/edit_manage_date_range', $data, true);

        		$this->response->start_date = $start_date;

        		$this->response->edit_manage_form = $view['content'];

        		$this->response->message[] = array(
		            'message' => '',
		            'type' => 'success'
		        );

		        $this->_ajax_return();
        	}

        	else if($this->input->post('page') == '2'){ 

        		if( ( $this->input->post('date_from') !== '') AND ( $this->input->post('date_to') !== '' ) ){

        			// okay proceed to next page

	        		/*if(isset($_POST['start_date'])){
		        		$start_date = \DateTime::createFromFormat('D M d Y H:i:s e+', $this->input->post('start_date'));
		        		$start_date = $start_date->format('F d, Y');        			
	        		}

					if(isset($_POST['end_date'])){
	        			$end_date = \DateTime::createFromFormat('D M d Y H:i:s e+', $this->input->post('end_date'));
	        			$end_date = $end_date->format('Y-m-d');
	        		}*/

	        		$data['shifts'] = $this->mod->get_shift();

			        $data['currentday_schedules'] = 
			        	$this->mod->get_work_calendar_details(
			        		date("Y-m-d", strtotime($this->input->post('date'))), 
			        		date("Y-m-d", strtotime($this->input->post('date'))), 
			        		$this->session->userdata('user')->user_id);

	        		$data['start_date']= $this->input->post('date_from');
	        		$data['end_date']= $this->input->post('date_to');
	        		$data['shift_id']= $this->input->post('shift_id');

        			$data['partners']= $this->mod->get_partners($manager_id);
        			$view['content'] = $this->load->view('edit/edit_manage_partners_list', $data, true);

        			$this->response->proceed = true;

	        		$start_date = '';
	        		$end_date = '';

	        		$this->response->partners_list = $view['content'];
		        	$this->response->start_date = $this->input->post('date_from');		
	        		$this->response->end_date = $this->input->post('date_to');	        		


        			$this->response->message[] = array(
			            'message' => '',
			            'type' => 'success'
			        );
			        $this->_ajax_return();
        		}

        		else{
        			
        			// one/both field's value is missing

        			$this->response->proceed = false;

        			$this->response->message[] = array(
			            'message' => 'Please provide start and end date.',
			            'type' => 'error'
			        );
			        $this->_ajax_return();
        		}
	        }
        }

        else{

        	// nothing is posted, WW don't know what to do.

        	$this->response->message[] = array(
                'message' => 'Start Date is required.',
                'type' => 'error'
            );

            $this->_ajax_return();
        }    
	}