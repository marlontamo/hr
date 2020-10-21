<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Performance_planning_admin extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('performance_planning_admin_model', 'mod');
		parent::__construct();
	}

	public function index($planning_id=0)
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}
		
		// $this->db->order_by('performance_status', 'asc');
		$performance_status = $this->db->get_where('performance_status', array('deleted' => 0, 'planning' => 1));
		$data['performance_status'] = $performance_status->result();

		$data['planning_id'] = $planning_id;

		$this->load->vars( $data );
		echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
	}

	public function get_list($planning_id=0)
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

		$trash = $this->input->post('trash') == 'true' ? true : false;

		$records = $this->_get_list( $trash,  $planning_id);
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
			$this->response->list .= $this->load->blade('list_template', $record, true)->with( $this->load->get_cached_vars() );
		}
	}

	private function _get_list( $trash, $planning_id=0 )
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
				if($filter_by_key == "status_id"){
					$filter_by_key = "{$this->db->dbprefix}performance_planning_applicable.".$filter_by_key;
				}
				if( $filter_value != "" ) $filter .= ' AND '. $filter_by_key .' = "'.$filter_value.'"';	
			}
		}
		else{
			if( $filter_by && $filter_by != "" )
			{
				$filter = 'AND '. $filter_by .' = "'.$filter_value.'"';
			}
		}

		if($planning_id > 0){
			$filter .= " AND {$this->db->dbprefix}{$this->mod->table}.planning_id = {$planning_id}";
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

	function _list_options_active( $record, &$rec )
	{
		if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}	
		
		if( isset($this->permission['delete']) && $this->permission['delete'] )
		{
			$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
			$rec['options'] .= '<li><a href="javascript: delete_planning('.$record['record_id'].', '.$record['user_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').' </a></li>';
/*			$rec['options'] .= '<li><a href="javascript: view_transaction_logs('.$record['record_id'].', '.$record['user_id'].')"><i class="fa fa-info"></i> View Planning Logs </a></li>';
			$rec['options'] .= '<li><a href="javascript: initialize_planning('.$record['record_id'].', '.$record['user_id'].')"><i class="fa fa-pencil"></i> Initialize Template </a></li>';*/
		}
	}

	function delete_planning()
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

		if( !$this->input->post('record_id') || !$this->input->post('user_id') )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();	
		}

		$record_id = $this->input->post('record_id');
		$user_id = $this->input->post('user_id');
		

		$this->response = $this->mod->_delete_planning( $record_id, $user_id );

		$this->_ajax_return();
	}

	public function initialize_planning( )
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

		$user_id = $this->input->post('user_id');
		$this->db->where('planning_id', $this->record_id);
		$applicables = $this->db->get( 'performance_planning' )->row_array();
		
        $template_ids = $applicables['template_id'];

        $select_templates = " SELECT applicable_to 
        					FROM {$this->db->dbprefix}performance_template 
        					WHERE template_id IN ({$template_ids}) ";

        $applicable_data = $this->db->query($select_templates)->result_array();

        $applicables = array();
        foreach($applicable_data as $data){
        	$data = explode(",", $data['applicable_to']);
        	foreach ($data as $datum){
        		if(in_array($datum, $applicables)){
	                $this->response->message[] = array(
	                    'message' => 'Selected templates have the same applicable to',
	                    'type' => 'warning'
	                );
					$this->_ajax_return();
        		}else{
        			$applicables[] = $datum;
        		}
        	}
        }

		$transactions = true;
		$this->db->trans_begin();
		$error = false;

	        // DELETE/INSERT to applicable
	        $applicable_for_insert = array();
	        // $this->db->delete('performance_planning_applicable', array( $this->mod->primary_key => $this->response->record_id ) ); 

	            $applicable_for_insert['planning_id'] = $this->record_id;
	   //          $template_id = $_POST['performance_planning']['template_id'];
	   //          $appraisal_status_id = $_POST['performance_planning']['status_id'];
	   //          $performance_type_id = $_POST['performance_planning']['performance_type_id'];
	   //          $planning_year = $_POST['performance_planning']['year'];
				// $performance_type = $this->db->get_where( 'performance_setup_performance' , array( 'performance_id' => $performance_type_id ) )->row_array();

	            //delete from applicable if REMOVED
	            $where_array = array( 'planning_id' => $this->record_id, 'user_id' => $user_id );
	        	$this->db->delete('performance_planning_applicable', $where_array ); 
	            //delete from approver if REMOVED
	        	$this->db->delete('performance_planning_approver', $where_array ); 

	            	$applicable_for_insert['user_id'] = $user_id;
	            	$applicable_for_insert['status_id'] = 0;
	            	$applicable_for_insert['to_user_id'] = $user_id;

					$full_name = $this->db->get_where( 'users' , array( 'user_id' => $user_id ) )->row_array();
					$applicable_for_insert['fullname'] = $full_name['full_name'];

					// $this->db->where("template_id IN CAST({$template_ids} AS INT)");
					// $applicables = $this->db->get( 'performance_template' )->result_array();

			        $select_ptemplates = " SELECT * 
			        					FROM {$this->db->dbprefix}performance_template 
			        					WHERE template_id IN ({$template_ids}) ";
					$applicables = $this->db->query( $select_ptemplates )->result_array();
					foreach($applicables as $applicable){
						// $template_applicable = $this->db->get_where( 'performance_template_applicable' , array( 'applicable_to_id' => $applicable['applicable_to_id'] ) )->row_array();
						switch($applicable['applicable_to_id']){
							case 1: //employment type
								$this->db->where_in('employment_type_id', $applicable['applicable_to']);
								$this->db->where('user_id', $user_id);
								$applicable_id = $this->db->get( 'partners' )->num_rows();
								if($applicable_id > 0){
									$applicable_for_insert['template_id'] = $applicable['template_id'];

									$this->db->where('user_id', $applicable_for_insert['user_id']);
									$this->db->where('template_id', $applicable_for_insert['template_id']);
									$this->db->where('planning_id', $applicable_for_insert['planning_id']);
									$applicable_exist = $this->db->get( 'performance_planning_applicable' );
									$send_feeds = 0;		

		            				$performance_populate_approvers = $this->db->query("CALL sp_performance_planning_populate_approvers({$this->record_id}, ".$user_id.")");
									mysqli_next_result($this->db->conn_id);
										
									if($applicable_exist->num_rows() == 0){
			            				$this->db->insert('performance_planning_applicable', $applicable_for_insert);
										$send_feeds = 1;
									}else{
										$applicables = $applicable_exist->row_array();
										if($applicables['status_id'] != 4){//not approved
											$send_feeds = 1;
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
				                            'feed_content' => "{$planning_year} performance planning period for {$performance_type['performance']} $appraisal_status.",
				                            // 'uri' => $this->mod->route . '/review/'.$_POST['planning_id'].'/'.$_POST['user_id'].'/'.$approver->approver_id,
				                            'recipient_id' => $user_id
				                        );

				                        $recipients = array($user_id);
				                        $this->system_feed->add( $feed, $recipients );
				                    
				                        $this->response->notify[] = $user_id;
				                    }

								}
							break;
							case  6: // job class
								$qry = "select c.*
								FROM {$this->db->dbprefix}partners_personal a
								LEFT JOIN {$this->db->dbprefix}partners b on b.partner_id = a.partner_id
								LEFT JOIN {$this->db->dbprefix}users c on c.user_id = b.user_id
								LEFT JOIN {$this->db->dbprefix}users_job_class d on d.job_class = a.key_value
								where a.key = 'job_class' and c.user_id = {$user_id} and d.job_class_id in ({$applicable['applicable_to']})";
								$applicable_id = $this->db->query( $qry )->num_rows();
								if($applicable_id > 0){
									$applicable_for_insert['template_id'] = $applicable['template_id'];

									$this->db->where('user_id', $applicable_for_insert['user_id']);
									$this->db->where('template_id', $applicable_for_insert['template_id']);
									$this->db->where('planning_id', $applicable_for_insert['planning_id']);
									$applicable_exist = $this->db->get( 'performance_planning_applicable' );
									$send_feeds = 0;		

		            				$performance_populate_approvers = $this->db->query("CALL sp_performance_planning_populate_approvers({$this->record_id}, ".$user_id.")");
									mysqli_next_result($this->db->conn_id);
										
									if($applicable_exist->num_rows() == 0){
			            				$this->db->insert('performance_planning_applicable', $applicable_for_insert);
										$send_feeds = 1;
									}else{
										$applicables = $applicable_exist->row_array();
										if($applicables['status_id'] != 4){//not approved
											$send_feeds = 1;
										}
									}

									//add feeds if within scope
				                    if( $send_feeds == 1 )
				                    {
				                        $this->load->model('system_feed');
				                        $feed = array(
				                            'status' => 'info',
				                            'message_type' => 'Comment',
				                            'user_id' => $this->user->user_id,
				                            'feed_content' => "Performance planning template has been changed.",
				                            // 'uri' => $this->mod->route . '/review/'.$_POST['planning_id'].'/'.$_POST['user_id'].'/'.$approver->approver_id,
				                            'recipient_id' => $user_id
				                        );

				                        $recipients = array($user_id);
				                        $this->system_feed->add( $feed, $recipients );
				                    
				                        $this->response->notify[] = $user_id;
				                    }

								}
							break;
						}									
					}
    				$performance_populate_approvers = $this->db->query("CALL sp_performance_planning_initialize_template({$this->record_id}, ".$user_id.")");
					mysqli_next_result($this->db->conn_id);		

		            if( $this->db->_error_message() != "" ){
		                $this->response->message[] = array(
		                    'message' => $this->db->_error_message(),
		                    'type' => 'error'
		                );
		                $error = true;
		                goto stop;
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
            'message' => 'Planning Template successfully initialize.',
            'type' => 'success'
        );

		$this->_ajax_return();
	}

    function view_transaction_logs()
    {
        $this->_ajax_only();

        $approvers_list = array();
        $approvers = "SELECT ppa.display_name, upos.position FROM {$this->db->dbprefix}performance_planning_approver  ppa 
                        INNER JOIN {$this->db->dbprefix}users_profile up 
                        ON ppa.approver_id = up.user_id 
                        INNER JOIN {$this->db->dbprefix}users_position upos 
                        ON up.position_id = upos.position_id 
                        WHERE ppa.planning_id = {$_POST['planning_id']} AND ppa.user_id = {$_POST['user_id']}
                    ";
        $app_sql = $this->db->query($approvers);
        if($app_sql->num_rows() > 0){
            $approvers_list = $app_sql->result_array();
        }

        $logs_list = array();
        $logs = "SELECT CONCAT(up.firstname,' ',up.lastname) as partner_name, upos.position, 
                        ppa.created_on, performance_status, pstat.class 
                        FROM {$this->db->dbprefix}performance_planning_logs  ppa 
                        INNER JOIN {$this->db->dbprefix}users_profile up 
                        ON ppa.to_user_id = up.user_id
                        INNER JOIN {$this->db->dbprefix}users_position upos 
                        ON up.position_id = upos.position_id 
                        INNER JOIN ww_performance_status pstat 
                        ON ppa.status_id = pstat.performance_status_id 
                        WHERE ppa.planning_id = {$_POST['planning_id']} AND ppa.user_id = {$_POST['user_id']}
                    ";
        $log_sql = $this->db->query($logs);
        if($log_sql->num_rows() > 0){
            $logs_list = $log_sql->result_array();
        }

        $vars['approvers_list'] = $approvers_list;
        $vars['logs_list'] = $logs_list;

        // $this->load->vars( $vars );
        $this->load->helper('form');
        $this->load->helper('file');
        // // $data['title'] = 'Add/Edit Column Item';
        // $data['content'] = $this->load->blade('edit.view_logs')->with( $this->load->get_cached_vars() );

        // $this->response->redeem_form = $this->load->view('form/redeem', $data, true);

        $this->response->trans_logs = $this->load->view('edit/view_logs', $vars, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }
}