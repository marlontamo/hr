<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Performance_appraisal extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('performance_appraisal_model', 'mod');
		$this->load->model('performance_appraisal_manage_model', 'mod_manage');
		parent::__construct();
		$this->lang->load('performance_appraisal');
	}

    public function index()
    {
        if( !$this->permission['list'] )
        {
            echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
            die();
        }
        
        $permission = parent::_check_permission('performance_appraisal_manage');
        $data['allow_manage'] = $permission['list'];
        $permission = parent::_check_permission('appraisal_individual_rate');
        $data['allow_personal'] = $permission['list'];

		$performance_appraisal_year = $this->db->get_where('performance_appraisal', array('deleted' => 0));
		$data['performance_appraisal_year'] = $performance_appraisal_year->result();

        $this->load->vars($data);
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }

	function delete()
	{
		$this->_ajax_only();
		
		if( !$this->permission['delete'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		if( !$this->input->post('records') )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();	
		}

		$records = $this->input->post('records');
		$records = explode(',', $records);

		$this->db->where_in($this->mod->primary_key, $records);
		$this->db->where('status_id', 0);
		$record_check = $this->db->get( $this->mod->table );

		if( $record_check->num_rows() > 0 )
		{
			$this->response->message[] = array(
				'message' => 'Delete is not allowed for closed transaction!',
				'type' => 'warning'
			);
			$this->_ajax_return();	
		}

		$this->db->where_in($this->mod->primary_key, $records);
		$record = $this->db->get( $this->mod->table )->result_array();

		foreach($record as $rec){
			if($rec['can_delete'] == 1){
				$data['modified_on'] = date('Y-m-d H:i:s');
				$data['modified_by'] = $this->user->user_id;
				$data['deleted'] = 1;

				$this->db->where($this->mod->primary_key, $rec[$this->mod->primary_key]);
				$this->db->update($this->mod->table, $data);
				
				if( $this->db->_error_message() != "" ){
					$this->response->message[] = array(
						'message' => $this->db->_error_message(),
						'type' => 'error'
					);
				}
				else{
					$this->response->message[] = array(
						'message' => lang('common.delete_record', $this->db->affected_rows()),
						'type' => 'success'
					);
				}
			}else{
				$this->response->message[] = array(
					'message' => 'Record(s) cannot be deleted.',
					'type' => 'warning'
				);
			}
		}

		$this->_ajax_return();
	}

	public function get_list()
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

		$this->response->show_import_button = false;
		if( $this->input->post('page') == 1 )
		{
			$this->load->model('upload_utility_model', 'import');
			if( $this->import->get_templates( $this->mod->mod_id ) )
				$this->response->show_import_button = true;
		}

		$trash = $this->input->post('trash') == 'true' ? true : false;

		$records = $this->_get_list( $trash );
		$this->_process_lists( $records, $trash );

		$this->_ajax_return();
	}

	private function _process_lists( $records, $trash )
	{
		$this->response->records_retrieve = sizeof($records);
		$this->response->list = '';
		foreach( $records as $record )
		{
			$rec = array(
				'detail_url' => '#',
				'edit_url' => '#',
				'delete_url' => '#',
				'options' => ''
			);

			if(!$trash)
				$this->_list_options_active( $record, $rec );
			else
				$this->_list_options_trash( $record, $rec );

			$record = array_merge($record, $rec);
			$this->response->list .= $this->load->blade('list_template_custom', $record, true)->with( $this->load->get_cached_vars() );
		}
	}

	private function _get_list( $trash )
	{
		$page = $this->input->post('page');
		$search = $this->input->post('search');
		$filter = "";
		
		$filter_by = $this->input->post('filter_by');
		$filter_value = $this->input->post('filter_value');
		
		if( is_array( $filter_by ) )
		{
			foreach( $filter_by as $filter_by_key => $filter_value )
			{
				if ($filter_by_key == 'status_id'){
					$filter_by_key = 'ww_performance_appraisal.status_id';
				}

				if( $filter_value != "" ) $filter = 'AND '. $filter_by_key .' = "'.$filter_value.'"';	
			}
		}
		else{
			if( $filter_by && $filter_by != "" )
			{
				if ($filter_by == 'status_id'){
					$filter_by = 'ww_performance_appraisal.status_id';
				}

				$filter = 'AND '. $filter_by .' = "'.$filter_value.'"';
			}
		}

		if( $page == 1 )
		{
			$searches = $this->session->userdata('search');
			if( $searches ){
				foreach( $searches as $mod_code => $old_search )
				{
					if( $mod_code != $this->mod->mod_code )
					{
						$searches[$this->mod->mod_code] = "";
					}
				}
			}
			$searches[$this->mod->mod_code] = $search;
			$this->session->set_userdata('search', $searches);
		}
		
		$page = ($page-1) * 10;
		$records = $this->mod->_get_list($page, 10, $search, $filter, $trash);
		return $records;
	}

	function add_form() {
		$this->_ajax_only();

		$where = array('deleted'=>0, 'status_id'=>1);
		$data['notifications'] = $this->db->get_where('performance_setup_notification', $where)->result_array();
		$data['form_value'] = $this->input->post('form_value');
		$data['start_date'] = $this->input->post('start_date');

		$this->load->helper('file');
		$this->response->add_form = $this->load->view('edit/forms/'.$this->input->post('add_form'), $data, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();
	}

	public function edit( $record_id, $child_call = false )
	{
		if( !$this->permission['edit'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_edit( $child_call );
	}
	
	public function add( $record_id = '', $child_call = false )
	{
		if( !$this->permission['add'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_edit( $child_call, true );
	}

	private function _edit( $child_call, $new = false )
	{
		$record_check = false;
		$this->record_id = $data['record_id'] = '';
		$data['reminder_ids'] = array();

		if( !$new ){
			if( !$this->_set_record_id() )
			{
				echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
				die();
			}

			$this->record_id = $data['record_id'] = $_POST['record_id'];
		}
		
		$record_check = $this->mod->_exists( $this->record_id );
		if( $new || $record_check === true )
		{
			$result = $this->mod->_get( 'edit', $this->record_id );
			if( $new )
			{
				$field_lists = $result->list_fields();
				foreach( $field_lists as $field )
				{
					$data['record'][$field] = '';
				}
			}
			else{
				$record = $result->row_array();
				foreach( $record as $index => $value )
				{
					$record[$index] = trim( $value );	
				}
				$data['record'] = $record;
			}

			//get rating scores
			$reference_ids = $this->db->get_where('performance_appraisal_applicable', array('appraisal_id' => $this->record_id))->result_array();
			$references= array();
			foreach ($reference_ids as $index => $value){
				$references[] = $value['user_id'];
			}
			$data['record']['performance_appraisal_applicable.user_id'] = implode(',', $references);

			$data['reminder_ids'] = $this->db->get_where('performance_appraisal_reminder', array('appraisal_id' => $this->record_id, 'deleted' => 0))->result_array();

			$this->load->vars( $data );
			if( !$child_call ){
				$this->load->helper('form');
				$this->load->helper('file');
				echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
			}
		}
		else
		{
			$this->load->vars( $data );
			if( !$child_call ){
				echo $this->load->blade('pages.error', array('error' => $record_check))->with( $this->load->get_cached_vars() );
			}
		}
	}

	public function applicable_selection(){
		$this->_ajax_only();
		if($this->input->get('category') > 0){
			$data = array();

			switch($this->input->get('category')){
				case 1: //Employment Type
					$data = $this->mod->getEmpTypeTagList();
				break;
				case 2: //Employment Status
					$data = $this->mod->getEmpStatusTagList();
				break;
				case 3: //Position
					$data = $this->mod->getPositionsTagList();
				break;
				case 4: //Employee
					$data = $this->mod->getUsersTagList();
				break;
				case 5: //Company
					$data = $this->mod->getCompanyTagList();
				break;
			}

			header('Content-type: application/json');
			echo json_encode($data);
			die();
		}else{
			$this->response->message[] = array(
				'message' => 'Please Select Applicable For',
				'type' => 'warning'
				);

			$this->_ajax_return();
		}
	}


	public function save( $child_call = false )
	{
		$this->_ajax_only();
		if( !$this->_set_record_id() )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'error'
			);
			$this->_ajax_return();	
		}
		
		if( (empty( $this->record_id ) && !$this->permission['add']) || ($this->record_id && !$this->permission['edit']) )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		
		$child_table = 'performance_appraisal_reminder';
		$child_primary_id = 'reminder_id';
		$child_table_data = array();
		if(isset($_POST['performance_appraisal_reminder'])){
			$child_table_data = $_POST['performance_appraisal_reminder'];
		}
		if(isset($_POST['performance_appraisal_applicable'])){
			$applicable_for_data['performance_appraisal_applicable'] = $_POST['performance_appraisal_applicable'];
		}

		unset( $_POST['notification_id'] );
		unset( $_POST['performance_appraisal_reminder'] );
		unset( $_POST['performance_appraisal_applicable'] );

		$transactions = true;
		$this->db->trans_begin();
		$this->response = $this->mod->_save( $child_call );
		$error = false;

		if( $this->response->saved )
		{

			$planning_id = $_POST['performance_appraisal']['planning_id'];

			$this->db->where('planning_id',$planning_id);
			$planning_info_result = $this->db->get('performance_planning');
			if ($planning_info_result && $planning_info_result->num_rows() > 0){
				$planning_info = $planning_info_result->row();
				$this->db->where('appraisal_id',$this->response->record_id);
				$this->db->update('performance_appraisal',array('planning_created_by' => $planning_info->created_by));
			}

			if(!empty($child_table_data)){
				$child_record = array();
				foreach($child_table_data[$child_primary_id] as $index => $value){				
					//start saving with performance_appraisal_reminder table
			        $record = $this->db->get_where( $child_table , array( $child_primary_id => $value ) );
			        $child_record['appraisal_id'] = $this->response->record_id;
			        $child_record['notification_id'] = $child_table_data['notification_id'][$index];
			        $child_record['date'] = date('Y-m-d', strtotime($child_table_data['date'][$index]));
			        $child_record['status_id'] = $child_table_data['status_id'][$index];
			        $child_record['file'] = $child_table_data['file'][$index];
			        switch( true )
			        {
			            case $record->num_rows() == 0:
			                //add mandatory fields
			                $child_record['created_on'] = date('Y-m-d H:i:s');
			                $child_record['created_by'] = $this->user->user_id;

			                $this->db->insert($child_table, $child_record);
			                if( $this->db->_error_message() == "" )
			                {
			                    $child_record_id = $this->child_record_id = $this->db->insert_id();
			                }
			                break;
			            case $record->num_rows() == 1:
			                $child_record['modified_by'] = $this->user->user_id;
			                $child_record['modified_on'] = date('Y-m-d H:i:s');

			                $this->db->update( $child_table, $child_record, array( $child_primary_id => $value) );
			                break;
			            default:
			                $this->response->message[] = array(
			                    'message' => lang('common.inconsistent_data'),
			                    'type' => 'error'
			                );
			                $error = true;
			                goto stop;
			        }
			        if( $this->db->_error_message() != "" ){
			            $this->response->message[] = array(
			                'message' => $this->db->_error_message(),
			                'type' => 'error'
			            );
			            $error = true;
			            goto stop;
			        }
			    }
			}

	        // DELETE/INSERT 
	        $applicable_for_insert = array();
	        foreach($applicable_for_data as $field => $value){
	            $applicable_for_insert[$this->mod->primary_key] = $this->response->record_id;
	            $template_id = $_POST['performance_appraisal']['template_id'];
	            $appraisal_status_id = $_POST['performance_appraisal']['status_id'];
	            $performance_type_id = $_POST['performance_appraisal']['performance_type_id'];
	            $planning_year = $_POST['performance_appraisal']['year'];
				$performance_type = $this->db->get_where( 'performance_setup_performance' , array( 'performance_id' => $performance_type_id ) )->row_array();

	            $user_id = $value['user_id'];
	            //delete from applicable if REMOVED
	            $this->db->where_not_in('user_id', $user_id);
	        	$this->db->delete('performance_appraisal_applicable', array( $this->mod->primary_key => $this->response->record_id ) ); 
	            //delete from applicable personal if REMOVED
	            $this->db->where_not_in('user_id', $user_id);
	        	$this->db->delete('performance_appraisal_applicable_user', array( $this->mod->primary_key => $this->response->record_id ) ); 
	            //delete from approver if REMOVED
/*	            $this->db->where_not_in('user_id', $user_id);
	        	$this->db->delete('performance_appraisal_approver', array( $this->mod->primary_key => $this->response->record_id ) ); */
	            foreach ($user_id as $index => $id){
	            	$appraisal_date = '';
					$this->db->where('planning_id',$planning_id);
					$this->db->where('user_id',$id);
					$planning_info_applicable_result = $this->db->get('performance_planning_applicable');
					if ($planning_info_applicable_result && $planning_info_applicable_result->num_rows() > 0){
						$planning_info_applicable_row = $planning_info_applicable_result->row();
						$appraisal_date = $planning_info_applicable_row->approved_date;
					}

	            	$applicable_for_insert['user_id'] = $id;
	            	$applicable_for_insert['status_id'] = 3;
	            	$applicable_for_insert['to_user_id'] = $id;
	            	$applicable_for_insert['approved_date'] = $appraisal_date;

					$full_name = $this->db->order_by('full_name', 'ASC')->get_where( 'users' , array( 'user_id' => $id ) )->row_array();
					$applicable_for_insert['fullname'] = $full_name['full_name'];
					

					$this->db->where_in('template_id', $template_id);
					$applicables = $this->db->get( 'performance_template' )->result_array();

					foreach($applicables as $applicable){
						switch($applicable['applicable_to_id']){
							case 1: //employment type
								$this->db->where_in('employment_type_id', explode(',', $applicable['applicable_to']));
								$this->db->where('user_id', $id);
								$applicable_id = $this->db->get( 'partners' )->num_rows();
								if($applicable_id > 0){
									$applicable_for_insert['template_id'] = $applicable['template_id'];

									$this->db->where('user_id', $applicable_for_insert['user_id']);
									$this->db->where('template_id', $applicable_for_insert['template_id']);
									$this->db->where('appraisal_id', $applicable_for_insert['appraisal_id']);
									$applicable_exist = $this->db->get( 'performance_appraisal_applicable' );
									$send_feeds = 0;
									if($applicable_exist->num_rows() == 0){
			            				$this->db->insert('performance_appraisal_applicable', $applicable_for_insert);
									}

									$this->db->where('user_id', $applicable_for_insert['user_id']);
									$this->db->where('template_id', $applicable_for_insert['template_id']);
									$this->db->where('appraisal_id', $applicable_for_insert['appraisal_id']);
									$applicable_exist = $this->db->get( 'performance_appraisal_applicable_user' );
									if($applicable_exist->num_rows() == 0){
	            						$applicable_for_insert['to_user_id'] = $id;
			            				$this->db->insert('performance_appraisal_applicable_user', $applicable_for_insert);
										$send_feeds = 1;
									}else{
										$applicables = $applicable_exist->row_array();
										if($applicables['status_id'] != 4){//not approved
											$send_feeds = 1;
										}
									}

							        $this->db->where('appraisal_id',$this->response->record_id);
							        $appraisal_info_result = $this->db->get( 'performance_appraisal');
							        $appraisal_info = $appraisal_info_result->row();

									$performance_populate_approvers = $this->db->query("CALL sp_performance_appraisal_populate_approvers({$this->response->record_id}, ".$appraisal_info->planning_created_by.", ".$id.")");
									mysqli_next_result($this->db->conn_id);									
								}
							break;
							case 6: //job class
								$qry = "select c.*
								FROM {$this->db->dbprefix}partners_personal a
								LEFT JOIN {$this->db->dbprefix}partners b on b.partner_id = a.partner_id
								LEFT JOIN {$this->db->dbprefix}users c on c.user_id = b.user_id
								LEFT JOIN {$this->db->dbprefix}users_job_class d on d.job_class = a.key_value
								where a.key = 'job_class' and c.user_id = {$id} and d.job_class_id in ({$applicable['applicable_to']})";
								$applicable_id = $this->db->query( $qry )->num_rows();
								if($applicable_id > 0){
									$applicable_for_insert['template_id'] = $applicable['template_id'];

									$this->db->where('user_id', $applicable_for_insert['user_id']);
									$this->db->where('template_id', $applicable_for_insert['template_id']);
									$this->db->where('appraisal_id', $applicable_for_insert['appraisal_id']);
									$applicable_exist = $this->db->get( 'performance_appraisal_applicable' );
									$send_feeds = 0;
									if($applicable_exist->num_rows() == 0){
			            				$this->db->insert('performance_appraisal_applicable', $applicable_for_insert);
									}

									$this->db->where('user_id', $applicable_for_insert['user_id']);
									$this->db->where('template_id', $applicable_for_insert['template_id']);
									$this->db->where('appraisal_id', $applicable_for_insert['appraisal_id']);
									$applicable_exist = $this->db->get( 'performance_appraisal_applicable_user' );
									if($applicable_exist->num_rows() == 0){
	            						$applicable_for_insert['to_user_id'] = $id;
			            				$this->db->insert('performance_appraisal_applicable_user', $applicable_for_insert);
										$send_feeds = 1;
									}else{
										$applicables = $applicable_exist->row_array();
										if($applicables['status_id'] != 4){//not approved
											$send_feeds = 1;
										}
									}
									$performance_populate_approvers = $this->db->query("CALL sp_performance_appraisal_populate_approvers({$this->response->record_id}, ".$id.")");
									mysqli_next_result($this->db->conn_id);

									//add feeds if within scope
				                    if( $send_feeds == 1 )
				                    {
										$appraisal_status = ($appraisal_status_id == 1) ? 'open' : 'closed';
				                    	if($performance_type['for_probi']){
				                    		$feed_content = "The appraisal period for your {$performance_type['performance']} is now $appraisal_status";
				                    	}else{
				                    		$feed_content = "The {$planning_year} appraisal period for {$performance_type['performance']} is now $appraisal_status";
				                    	}
				                        $this->load->model('system_feed');
				                        $feed = array(
				                            'status' => 'info',
				                            'message_type' => 'Comment',
				                            'user_id' => $this->user->user_id,
				                            'feed_content' => $feed_content,
				                            // 'uri' => $this->mod->route . '/review/'.$_POST['planning_id'].'/'.$_POST['user_id'].'/'.$approver->approver_id,
				                            'recipient_id' => $id
				                        );

				                        $recipients = array($id);
				                        $this->system_feed->add( $feed, $recipients );
				                    
				                        $this->response->notify[] = $id;
				                    }
								}
							break;
						}
					}

		            if( $this->db->_error_message() != "" ){
		                $this->response->message[] = array(
		                    'message' => $this->db->_error_message(),
		                    'type' => 'error'
		                );
		                $error = true;
		                goto stop;
		            }
	            }
	        }

			//add feeds if within scope
            if( $send_feeds == 1 )
            {
                $this->load->model('system_feed');
				$appraisal_status = ($appraisal_status_id == 1) ? 'is now open' : 'was closed';
                $feed = array(
                    'status' => 'info',
                    'message_type' => 'Comment',
                    'user_id' => $this->user->user_id,
                    'feed_content' => "{$planning_year} performance appraisal period for {$performance_type['performance']} $appraisal_status.",
                    'uri' => $this->mod_manage->route,
                    'recipient_id' => $appraisal_info->planning_created_by
                );

                $recipients = array($appraisal_info->planning_created_by);
                $this->system_feed->add( $feed, $recipients );
            
                $this->response->notify[] = $appraisal_info->planning_created_by;
            }

            //send to approvers
/*			$appraisal_get_approvers = $this->db->query("SELECT * 
										FROM {$this->db->dbprefix}performance_appraisal_approver 
										WHERE appraisal_id = {$this->response->record_id} 
										GROUP BY approver_id")->result_array();
			// mysqli_next_result($this->db->conn_id);
	        if(count($appraisal_get_approvers) > 0){
				$appraisal_status = ($appraisal_status_id == 1) ? 'is now open' : 'was closed';
				foreach ($appraisal_get_approvers as $approver){
	                $this->load->model('system_feed');
	                $feed = array(
	                    'status' => 'info',
	                    'message_type' => 'Comment',
	                    'user_id' => $this->user->user_id,
	                    'feed_content' => "{$planning_year} performance appraisal period for {$performance_type['performance']} $appraisal_status.",
	                    // 'uri' => $this->mod->route . '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'].'/'.$approver->approver_id,
	                    'recipient_id' => $approver['approver_id']
	                );

	                $recipients = array($approver['approver_id']);
	                $this->system_feed->add( $feed, $recipients );
	            
	                $this->response->notify[] = $approver['approver_id'];
	        	}
	        }*/

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

		$this->response->message[] = array(
			'message' => 'Successfully Save',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function download_file($reminder_id){	
		$reminder_details = $this->db->get_where( 'performance_appraisal_reminder' , array( 'reminder_id' => $reminder_id ) )->row_array();
		$decoded_url = urldecode($reminder_details['file']);
		$path = base_url() . $reminder_details['file'];

		header('Content-disposition: attachment; filename='.substr( $reminder_details['file'], strrpos( $reminder_details['file'], '/' )+1 ).'');
		header('Content-type: txt/pdf');
		readfile($path);
	}	

	function delete_child()
	{
		$this->_ajax_only();
		
		if( !$this->permission['delete'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		if( !$this->input->post('records') )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();	
		}

		$child_primary_id = 'reminder_id';
		$child_table = 'performance_appraisal_reminder';
		$records = $this->input->post('child_id');
		$records = explode(',', $records);

		$this->db->where_in($child_primary_id, $records);
		$record = $this->db->get( $child_table )->result_array();

		foreach($record as $rec){
			if($rec['can_delete'] == 1){
				$data['modified_on'] = date('Y-m-d H:i:s');
				$data['modified_by'] = $this->user->user_id;
				$data['deleted'] = 1;

				$this->db->where($child_primary_id, $rec[$child_primary_id]);
				$this->db->update($child_table, $data);
				
				if( $this->db->_error_message() != "" ){
					$this->response->message[] = array(
						'message' => $this->db->_error_message(),
						'type' => 'error'
					);
				}
				else{
					$this->response->message[] = array(
						'message' => lang('common.delete_record', $this->db->affected_rows()),
						'type' => 'success'
					);
				$this->response->record_deleted = 1;
				}
			}else{
				$this->response->message[] = array(
					'message' => 'Record(s) cannot be deleted.',
					'type' => 'warning'
				);
				$this->response->record_deleted = 0;
			}
		}

		$this->_ajax_return();
	}

	function get_appplicable_references() {
		$this->_ajax_only();

		$record_id = $this->input->post('record_id');
		$where = array('appraisal_id'=>$record_id);
		$applicable_for = $this->db->get_where('performance_appraisal_applicable', $where)->result_array();
		
		foreach($applicable_for as $index => $value){
			$this->response->applicable_for[] = array(
				'label' => $value['fullname'],
				'value' => $value['user_id']
				);
		}

		$this->_ajax_return();
	}

	public function get_filters(){
		$this->_ajax_only();
		if($this->input->post('record_id') > 0){
			$data = array();

			// $where = array('deleted'=>0);
			switch($this->input->post('record_id')){
				case 1: //company
					$this->db->select('company_id as value,company as label');
					$this->db->order_by('company', '0');
					$this->db->where('deleted', '0');
					$filter_by = $this->db->get('users_company');
				break;
				case 2: //Location
					$this->db->select('location_id as value,location as label');
					$this->db->order_by('location', '0');
					$this->db->where('deleted', '0');
					$filter_by = $this->db->get('users_location');
				break;
				case 3: //Department
					$this->db->select('department_id as value,department as label');
					$this->db->order_by('department', '0');
					$this->db->where('deleted', '0');
					$filter_by = $this->db->get('users_department');
				break;
				case 4: //Division
					$this->db->select('division_id as value,division as label');
					$this->db->order_by('division', '0');
					$this->db->where('deleted', '0');
					$filter_by = $this->db->get('users_division');
				break;
			}
		}else{
			$this->response->message[] = array(
				'message' => 'Please Select Filter By',
				'type' => 'warning'
				);

		}

		$this->response->filter_id = array();
		if($this->input->post('appraisal_id') > 0){
			$where = array('deleted'=>0, 'appraisal_id'=>$this->input->post('appraisal_id'));
			$appraisal_data = $this->db->get_where('performance_appraisal', $where)->row_array();
        	$filter_ids = $appraisal_data['filter_id'];
        	$this->response->filter_id = explode(',', $filter_ids);
		}

        $this->response->count = $filter_by->num_rows();
        $this->response->selected_filter = 0;
        foreach( $filter_by->result() as $filterBy )
        {
        	$selected = '';
        	if(in_array($filterBy->value, $this->response->filter_id) || !($this->input->post('appraisal_id') > 0) ){
        		$selected = 'selected="selected"';
            	$this->response->selected_filter = 1;
        	}
            $this->response->filter_by .= '<option value="'.$filterBy->value.'" '.$selected.'>'.$filterBy->label.'</option>';
        }

		$this->_ajax_return();
	}

    function get_selection_filters()
    {
        $this->_ajax_only();
        $filter_by = $this->input->post('filter_by');
        $filter_id = $this->input->post('filter_id');
        $template_id = implode(",",$this->input->post('template_id'));
        $employment_status_id = $this->input->post('employment_status_id');

		$template_qry = "SELECT * FROM 
						{$this->db->dbprefix}performance_template
						WHERE template_id IN ({$template_id})";
		$applicables = $this->db->query( $template_qry )->result_array();

        $qry = "SELECT partners.alias, partners.partner_id, partners.user_id 
                FROM partners
                INNER JOIN users_profile ON partners.user_id = users_profile.user_id
                INNER JOIN {$this->db->dbprefix}users users ON partners.user_id = users.user_id
                WHERE partners.deleted = 0 AND users.active = 1 
                ";

		if(!empty($filter_id)){
        	$filter_id = implode(',',$this->input->post('filter_id'));
			switch($filter_by){
				case 1: //company
		            $qry .= " AND company_id IN ({$filter_id}) ";
				break;
				case 2: //Location
		            $qry .= " AND location_id IN ({$filter_id}) ";
				break;
				case 3: //Department
	            	$qry .= " AND department_id IN ({$filter_id})  ";
				break;
				case 4: //Division
	            	$qry .= " AND division_id IN ({$filter_id})  ";
				break;
			}
		}

		if(!empty($employment_status_id)){
        	$employment_status_id = implode(",",$this->input->post('employment_status_id'));
			$qry .= " AND status_id IN ({$employment_status_id})  ";
		}

		$applicable_to = array();
		foreach($applicables as $applicable){
			// $template_applicable = $this->db->get_where( 'performance_template_applicable' , array( 'applicable_to_id' => $applicable['applicable_to_id'] ) )->row_array();
			switch($applicable['applicable_to_id']){
				case 1: //employment type
					$applicable_to[] = $applicable['applicable_to'];
				break;
			}
		}

        $applicable_tos = implode(",",$applicable_to);
		$qry .= " AND employment_type_id IN ({$applicable_tos})  ";
        $qry .= " ORDER BY partners.alias ASC";

        $employees = $this->db->query( $qry );

		$this->response->filter_id = array();
		if($this->input->post('appraisal_id') > 0){
			$where = array('appraisal_id'=>$this->input->post('appraisal_id'));
			$appraisal_data = $this->db->get_where('performance_appraisal_applicable', $where)->result_array();
        	
        	$filter_ids = array();
        	foreach($appraisal_data as $index => $value){
        		$filter_ids[] = $value['user_id'];
        	}
        	$this->response->filter_id = $filter_ids;
		}

        $this->response->count = $employees->num_rows();
        $this->response->selected_filter = 0;
        foreach( $employees->result() as $employee )
        {   
        	$selected = '';
        	if(in_array($employee->user_id, $this->response->filter_id) || !($this->input->post('appraisal_id') > 0) ){
        		$selected = 'selected="selected"';
            	$this->response->selected_filter = 1;
        	}
            $data['partner_id_options'][$employee->user_id] = $employee->alias;
            $this->response->employees .= '<option value="'.$employee->user_id.'" '.$selected.'>'.$employee->alias.'</option>';
        }


        // $this->response->filtered_employees = $view['content'];

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();  
    }


	public function get_planning(){
		$this->_ajax_only();

		$planning_id = $this->input->post('planning_id');
		if($planning_id > 0){
			$data = array();
			$sql = "SELECT pp.year, pp.performance_type_id, psp.performance, pp.filter_by as filter_by_id, ppf.filter_by,
					pp.template_id, pp.employment_status_id, pp.filter_id
					FROM {$this->db->dbprefix}performance_planning pp 
					LEFT JOIN {$this->db->dbprefix}performance_setup_performance psp 
						ON pp.performance_type_id = psp.performance_id
					LEFT JOIN {$this->db->dbprefix}performance_planning_filter ppf 
						ON pp.filter_by = ppf.filter_id
					WHERE planning_id = '{$planning_id}'";
			$planning_details = $this->db->query($sql)->row_array();
		}else{
			$this->response->message[] = array(
				'message' => 'Please Select Planning',
				'type' => 'warning'
				);
		}

		if(!empty($planning_details)){
			$this->response->performance_type_id = '';
			$this->response->year = $planning_details['year'];
			if(array_key_exists('performance_type_id', $planning_details)){
            	$this->response->performance_type_id = '<option value="'.$planning_details['performance_type_id'].'" selected="selected">'.$planning_details['performance'].'</option>';
			}
			$this->response->filter_by = '';
			$this->response->filter_id = '';
			if(array_key_exists('filter_by_id', $planning_details)){
            	$this->response->filter_by = '<option value="'.$planning_details['filter_by_id'].'" selected="selected">'.$planning_details['filter_by'].'</option>';

				if(array_key_exists('filter_id', $planning_details)){
					switch($planning_details['filter_by_id']){
						case 1: //company
							$query = "SELECT company_id as value,company as label 
									FROM {$this->db->dbprefix}users_company 
									WHERE deleted = 0 AND 
									company_id IN ({$planning_details['filter_id']}) 
									ORDER BY company";
							$filter_by_id = $this->db->query($query)->result_array();
						break;
						case 2: //Location
							$query = "SELECT location_id as value,location as label
									FROM {$this->db->dbprefix}users_location 
									WHERE deleted = 0 AND 
									location_id IN ({$planning_details['filter_id']}) 
									ORDER BY location";
							$filter_by_id = $this->db->query($query)->result_array();
						break;
						case 3: //Department
							$query = "SELECT department_id as value,department as label
									FROM {$this->db->dbprefix}users_department 
									WHERE deleted = 0 AND 
									department_id IN ({$planning_details['filter_id']}) 
									ORDER BY department";
							$filter_by_id = $this->db->query($query)->result_array();
						break;
						case 4: //Division
							$query = "SELECT division_id as value,division as label
									FROM {$this->db->dbprefix}users_division 
									WHERE deleted = 0 AND 
									division_id IN ({$planning_details['filter_id']}) 
									ORDER BY division";
							$filter_by_id = $this->db->query($query)->result_array();
						break;
					}
					if(!empty($filter_by_id)){
						$this->response->filter_by_count = count($filter_by_id);
				        foreach( $filter_by_id as $filter )
				        {
		            		$this->response->filter_id .= '<option value="'.$filter['value'].'" selected="selected">'.$filter['label'].'</option>';
						}
					}
				}	
			}
			$this->response->template_id = '';
			if(array_key_exists('template_id', $planning_details)){
				$query = "SELECT *
						FROM {$this->db->dbprefix}performance_template 
						WHERE deleted = 0 AND 
						template_id IN ({$planning_details['template_id']}) 
						ORDER BY template";
				$templates = $this->db->query($query)->result_array();

				if(!empty($templates)){
					$this->response->template_id_count = count($templates);
			        foreach( $templates as $template )
			        {
	            		$this->response->template_id .= '<option value="'.$template['template_id'].'" selected="selected">'.$template['template'].'</option>';
					}
				}
			}	
			$this->response->employment_status_id = '';
			if(array_key_exists('employment_status_id', $planning_details)){
				if(!empty($planning_details['employment_status_id'])){
					$query = "SELECT *
							FROM {$this->db->dbprefix}partners_employment_status 
							WHERE deleted = 0 AND 
							employment_status_id IN ({$planning_details['employment_status_id']}) 
							ORDER BY employment_status ";
					$employment_statuses = $this->db->query($query)->result_array();

					if(!empty($employment_statuses)){
						$this->response->employment_status_id_count = count($employment_statuses);
				        foreach( $employment_statuses as $employment_status )
				        {
		            		$this->response->employment_status_id .= '<option value="'.$employment_status['employment_status_id'].'" selected="selected">'.$employment_status['employment_status'].'</option>';
						}
					}
				}
			}	

		// $this->response->filter_id = array();
		$filter_ids = array();
		if($this->input->post('appraisal_id') > 0){
			$where = array('appraisal_id'=>$this->input->post('appraisal_id'));
			$appraisal_data = $this->db->order_by('fullname', 'ASC')->get_where('performance_appraisal_applicable', $where)->result_array();
        	
        	foreach($appraisal_data as $index => $value){
        		$filter_ids[] = $value['user_id'];
        	}
        	// $this->response->filter_id = $filter_ids;
		}
			$this->response->user_id = '';
			$applicable_for = $this->db->order_by('fullname', 'ASC')->get_where('performance_planning_applicable', array('planning_id' => $planning_id,'status_id' => 4))->result_array();
			if(!empty($applicable_for)){
				$this->response->user_id_count = count($applicable_for);
        		$this->response->selected_filter = 0;
		        foreach( $applicable_for as $applicable )
		        {
		        	$selected = '';
		        	if(in_array($applicable['user_id'], $filter_ids) || !($this->input->post('appraisal_id') > 0) ){
		        		$selected = 'selected="selected"';
		            	$this->response->selected_filter = 1;
		        	}
            		$this->response->user_id .= '<option value="'.$applicable['user_id'].'" '.$selected.'>'.$applicable['fullname'].'</option>';
				}
			}
		}else{
			$this->response->message[] = array(
				'message' => 'Planning has no details',
				'type' => 'warning'
				);
		}

		$this->_ajax_return();
	}

	function _list_options_active( $record, &$rec )
	{
		//add options to close appraisal
		if(strtolower($record['performance_appraisal_status_id']) == 'yes'){
			$rec['close_appraisal'] = $this->mod->url . '/close_appraisal/' . $record['record_id'];
			$rec['options'] .= '<li><a href="javascript: close_appraisal('.$record['record_id'].')"><i class="fa fa-lock"></i> '.lang('performance_appraisal.close_appraisal').'</a></li>';
		}else{
			$rec['open_appraisal'] = $this->mod->url . '/open_appraisal/' . $record['record_id'];
			$rec['options'] .= '<li><a href="javascript: open_appraisal('.$record['record_id'].')"><i class="fa fa-unlock"></i> '.lang('performance_appraisal.open_appraisal').'</a></li>';
		}
		//add options to view users selected in appraisal
			$this->load->model('performance_appraisal_admin_model', 'appraise_admin');
			$rec['view_users'] = $this->appraise_admin->url . '/index/' . $record['record_id'];
			$rec['options'] .= '<li><a href="'.$rec['view_users'].'"><i class="fa fa-user"></i> '.lang('performance_appraisal.view_emp').'</a></li>';

		if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}	
		
		if( isset($this->permission['delete']) && $this->permission['delete'] )
		{
			$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
			$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
		}
	}

	function count_unapproved_forms()
	{
		$this->_ajax_only();
		
		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		if( !$this->input->post('appraisal_id') )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$appraisal_id = $this->input->post('appraisal_id');
		$records = explode(',', $appraisal_id);
		
		$this->db->where('status_id <', '4');
		$this->db->where_in($this->mod->primary_key, $records);
		$record = $this->db->get( 'performance_appraisal_applicable' );

		$this->response->unapproved_forms_count = $record->num_rows();
		$this->_ajax_return();
	}

	function save_appraisal_status()
	{
		$this->_ajax_only();
		
		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		if( !$this->input->post('appraisal_id') )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$appraisal_id = $this->input->post('appraisal_id');
		$status_id = $this->input->post('status_id');
		// $records = explode(',', $appraisal_id);
		
		$data['status_id'] = $status_id;
		$this->db->where($this->mod->primary_key, $appraisal_id);
		$this->db->update($this->mod->table, $data);

		$performance_appraisal_data = $this->db->get_where('performance_appraisal', array('appraisal_id' => $appraisal_id))->row_array();
		$performance_type = $this->db->get_where( 'performance_setup_performance' , array( 'performance_id' => $performance_appraisal_data['performance_type_id'] ) )->row_array();

		$appraisal_get_applicable = $this->db->query("SELECT * 
									FROM {$this->db->dbprefix}performance_appraisal_applicable 
									WHERE appraisal_id = {$appraisal_id} 
									AND status_id != 4")->result_array();
        $this->load->model('system_feed');
        if(count($appraisal_get_applicable) > 0){
			foreach ($appraisal_get_applicable as $applicable){
				$appraisal_status = ($status_id == 1) ? 'was re-opened' : 'was closed';
	            $feed = array(
	                'status' => 'info',
	                'message_type' => 'Comment',
	                'user_id' => $this->user->user_id,
	                'feed_content' => "{$performance_appraisal_data['year']} performance appraisal period for {$performance_type['performance']} $appraisal_status.",
	                // 'uri' => $this->mod->route . '/review/'.$_POST['appraisal_id'].'/'.$_POST['user_id'].'/'.$approver->approver_id,
	                'recipient_id' => $applicable['user_id']
	            );

	            $recipients = array($applicable['user_id']);
	            $this->system_feed->add( $feed, $recipients );
	        
	            $this->response->notify[] = $applicable['user_id'];
	        }
        }

        //send to approvers
		$appraisal_get_approvers = $this->db->query("SELECT * 
									FROM {$this->db->dbprefix}performance_appraisal_approver 
									WHERE appraisal_id = {$appraisal_id} 
									GROUP BY approver_id")->result_array();
		// mysqli_next_result($this->db->conn_id);

        if(count($appraisal_get_approvers) > 0){
			$appraisal_status = ($status_id == 1) ? 'was re-opened' : 'was closed';
			foreach ($appraisal_get_approvers as $approver){
	            $feed = array(
	                'status' => 'info',
	                'message_type' => 'Comment',
	                'user_id' => $this->user->user_id,
	                'feed_content' => "{$performance_appraisal_data['year']} performance appraisal period for {$performance_type['performance']} $appraisal_status.",
	                // 'uri' => $this->mod->route . '/review/'.$_POST['planning_id'].'/'.$_POST['user_id'].'/'.$approver->approver_id,
	                'recipient_id' => $approver['approver_id']
	            );

	            $recipients = array($approver['approver_id']);
	            $this->system_feed->add( $feed, $recipients );
	        
	            $this->response->notify[] = $approver['approver_id'];
	    	}
	    }

		if($status_id == 0){
			$status = 'Closed';
		}else{
			$status = 'Opened';
		}

		$this->response->message[] = array(
			'message' => "Appraisal Successfully $status.",
			'type' => 'success'
		);
		$this->_ajax_return();
	}

}