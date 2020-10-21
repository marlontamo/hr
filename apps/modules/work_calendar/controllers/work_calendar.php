<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Work_calendar extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('work_calendar_model', 'mod');
		parent::__construct();
	}

	public function get_list(){

		$this->_ajax_only();

		// Prepare date filters
		//$start_date = \DateTime::createFromFormat('D M d Y H:i:s e+', $this->input->post('start_date')); // Thu Nov 15 2012 00:00:00 GMT-0700 (Mountain Standard Time)
		//$start_date = $start_date->format('Y-m-d');

        $start_date = date('Y-m-d', strtotime($this->input->post('start_date')));

		//$end_date = \DateTime::createFromFormat('D M d Y H:i:s e+', $this->input->post('end_date')); // Thu Nov 15 2012 00:00:00 GMT-0700 (Mountain Standard Time)
		//$end_date = $end_date->format('Y-m-d');
        $end_date = date('Y-m-d', strtotime($this->input->post('end_date')));

		$this->response->shift= $this->mod->get_shift(); 
        $this->response->shift_weekly= $this->mod->get_shift_weekly(); 
		$this->response->list = $this->mod->get_work_calendar_details($start_date, $end_date, $this->session->userdata('user')->user_id);
		
        

		$this->_ajax_return();
	}

	function save(){

		$this->_ajax_only();


		// final
		$Partners = isset($_POST['user_id']) ? $_POST['user_id'] : '';
		$shift_id = isset($_POST['shift_id']) ? $_POST['shift_id'] : '';
        $calendar_id = isset($_POST['calendar_id']) ? $_POST['calendar_id'] : '';
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

                //saving of history for audit
                $schedule_history = array(
                                        'user_id' => $Partners[$index],
                                        'from_date' => $start_date,
                                        'to_date' => $start_date,
                                        'shift_id' => $shift_id[$index],
                                        'created_by' => $this->user->user_id
                                      );

                $this->db->insert('time_record_schedule_history',$schedule_history);
			}
		}
		else{ 

            $startdate = $start_date;

            foreach($Partners as $index => $id)
            {
                $start_date = $startdate;

                while (strtotime($start_date) <= strtotime($end_date)) 
                {
					// IF SHIFT ID NOT BLANK??? SAVE? IF YES CONTINUE NEXT LOOP!!!
                    if (isset($shift_id[$index])){
                        $data_restDay = array();
                        $qry_restDay = "SELECT ts.shift_id, week_name, tswc.shift_id , tswc.week_no, tswc.calendar_id  
                                            FROM {$this->db->dbprefix}time_shift ts
                                            LEFT JOIN {$this->db->dbprefix}time_shift_weekly_calendar tswc 
                                            ON ts.default_calendar = tswc.calendar_id
                                            WHERE tswc.shift IN ('OFF','RESTDAY')"; //restday shift
                        $qry_restDay .= " AND ts.shift_id = {$shift_id[$index]} ";
                        $qry_restDay .= " AND tswc.week_name = '".date('l', strtotime($start_date))."'";
                        $result_restDay = $this->db->query($qry_restDay); 

                        if(!$result_restDay->num_rows() > 0)
                        {
                            $this->mod->update_partner_work_schedule( date("Y-m-d", strtotime($start_date)), $Partners[$index], $shift_id[$index]);
                        }  
                    }
                    elseif (isset($calendar_id[$index])){
                        $this->mod->update_partner_work_schedule_weekly( date("Y-m-d", strtotime($start_date)), $Partners[$index], $calendar_id[$index]);
                    } 
            
                    $start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));

				} // end while


                $start_date = $startdate;

                if (isset($shift_id[$index]))
                {
                    $schedule_history = array(
                                                'coordinator_id' => $this->user->user_id,
                                                'user_id' => $Partners[$index],
                                                'from_date' => $start_date,
                                                'to_date' => $end_date,
                                                'shift_id' => $shift_id[$index],
                                                'created_by' => $this->user->user_id
                                              );
                }
                elseif (isset($calendar_id[$index]))
                {
                    $schedule_history = array(
                                                'coordinator_id' => $this->user->user_id,
                                                'user_id' => $Partners[$index],
                                                'from_date' => $start_date,
                                                'to_date' => $end_date,
                                                'calendar_id' => $calendar_id[$index],
                                                'created_by' => $this->user->user_id
                                              );
                }
                $this->db->insert('time_record_schedule_history',$schedule_history);

			} //foreach $Partners

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

        $user = $this->config->item('user'); 
        $role_id = $user['role_id'];

        $data['partners']= 
        	$this->mod->get_assigned_partners(
        		$this->session->userdata('user')->user_id
        		, date("Y-m-d", strtotime($this->input->post('date')))
        		, $this->input->post('shift_id')
                , $role_id);

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

        $user = $this->config->item('user'); 
        $role_id = $user['role_id'];

        $data['partners']= 
        	$this->mod->get_assigned_partners(
        		$this->session->userdata('user')->user_id
        		, date("Y-m-d", strtotime($this->input->post('date')))
        		, $this->input->post('shift_id')
                , $role_id);

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

	public function get_manager_partners(){

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

        $manager_id = $this->user->user_id;

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
	        		$start_date = date('F d, Y', strtotime($this->input->post('start_date')));       			
        		}

				if(isset($_POST['end_date'])){
        			$end_date = date('Y-m-d', strtotime($this->input->post('end_date'))); 
        		}
        		
                $data['type']= $this->input->post('type');
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

	        		$data['shifts'] = $this->mod->get_shift();
                    $data['shifts_weekly'] = $this->mod->get_shift_weekly();
                    $user = $this->config->item('user'); 
                    $role_id = $user['role_id'];

                    // if current user is a manager and has full access
                    // to this module's record then don't load any data.
                    // let 'em use search functionality to see it
/*                    if($role_id == '2' || $role_id == '6'){
                        $manager_id = '0';
                    }*/

			        $data['currentday_schedules'] = 
			        	$this->mod->get_work_calendar_details(
			        		date("Y-m-d", strtotime($this->input->post('date'))), 
			        		date("Y-m-d", strtotime($this->input->post('date'))), 
			        		$this->session->userdata('user')->user_id);

	        		$data['start_date']= $this->input->post('date_from');
	        		$data['end_date']= $this->input->post('date_to');
	        		$data['shift_id']= $this->input->post('shift_id');
                    $data['type']= $this->input->post('type');
 
        			$data['partners']= $manager_id !== '0' ? $this->mod->get_partners($manager_id, $role_id) : array(); 
                    
                    if ($this->input->post('type') == 'shift'){
                        $view['content'] = $this->load->view('edit/edit_manage_partners_list', $data, true);
                    }
                    else{
                        $view['content'] = $this->load->view('edit/edit_manage_partners_list_weekly', $data, true);
                    }

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

    public function get_search_data(){

        $this->_ajax_only();

        if( !$this->permission['add'] && !$this->permission['edit'] )
        {
            $this->response->message[] = array(
                'message' => 'You dont have sufficient permission to file forms on this calendar, please notify the System Administrator.',
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        $search_keyword = $this->input->post('keyword');
        $manager_id = $this->user->user_id;

        $user = $this->config->item('user'); 
        $role_id = $user['role_id']; 


        if($search_keyword != ''){
            $data = array();
            $data['shifts'] = $this->mod->get_shift();
            $data['shifts_weekly'] = $this->mod->get_shift_weekly();
            $user = $this->config->item('user'); 
            $role_id = $user['role_id'];


            // if current user is a manager and has full access
            // to this module's record then don't load any data.
            // let 'em use search functionality to see it
/*            if($role_id == '2' || $role_id == '6'){
                $manager_id = '0';
            }*/

            $data['currentday_schedules'] = 
                $this->mod->get_work_calendar_details(
                    date("Y-m-d", strtotime($this->input->post('date'))), 
                    date("Y-m-d", strtotime($this->input->post('date'))), 
                    $this->session->userdata('user')->user_id);

            $data['partners']= $manager_id !== '0' ? $this->mod->get_searched_partner($manager_id, $search_keyword, $role_id) : array(); 

            if ($this->input->post('type') == 'shift'){
                $view['content'] = $this->load->view('edit/search_result', $data, true);
            }
            else{
                $view['content'] = $this->load->view('edit/search_result_weekly', $data, true);
            }


            $this->response->partners_list = $view['content'];
        }
        else if($search_keyword == ''){
            $data = array();
            $data['shifts'] = $this->mod->get_shift();
            $data['shifts_weekly'] = $this->mod->get_shift_weekly();
            $user = $this->config->item('user'); 
            $role_id = $user['role_id'];


            // if current user is a manager and has full access
            // to this module's record then don't load any data.
            // let 'em use search functionality to see it
/*            if($role_id == '2' || $role_id == '6'){
                $manager_id = '0';
            }*/

            $data['currentday_schedules'] = 
                $this->mod->get_work_calendar_details(
                    date("Y-m-d", strtotime($this->input->post('date'))), 
                    date("Y-m-d", strtotime($this->input->post('date'))), 
                    $this->session->userdata('user')->user_id);

            $data['partners']= $manager_id !== '0' ? $this->mod->get_searched_partner($manager_id, '', $role_id) : array(); 

            if ($this->input->post('type') == 'shift'){
                $view['content'] = $this->load->view('edit/search_result', $data, true);
            }
            else{
                $view['content'] = $this->load->view('edit/search_result_weekly', $data, true);
            }

            $this->response->partners_list = $view['content'];
        }
        else{

            // just a blank response
            $this->response->partners_list = '';   
        }

        $this->_ajax_return();
    }
}