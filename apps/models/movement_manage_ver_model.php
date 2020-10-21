<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

// it was created due to movement_manage_model doesn't read in Abraham in live but ok in uat and local. tirso
class movement_manage_ver_model extends Record
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
		$this->mod_id = 257;
		$this->mod_code = 'movement_manage';
		$this->route = 'partners/admin/movement_manage';
		$this->url = site_url('partners/admin/movement_manage');
		$this->primary_key = 'movement_id';
		$this->table = 'partners_movement';
		$this->icon = 'fa-user';
		$this->short_name = 'Employee Movement Manage';
		$this->long_name  = 'Employee Movement Manage';
		$this->description = 'Manage Employee Movement';
		$this->path = APPPATH . 'modules/movement_manage/';

		parent::__construct();
	}

	function _get_list($start, $limit, $search, $filter, $trash = false)
	{
		$data = array();				
		
		
		$qry = $this->_get_list_cached_query();
		
		if( $trash )
		{
			$qry .= " AND ww_partners_movement.deleted = 1";
		}
		else{
			$qry .= " AND ww_partners_movement.deleted = 0";	
		}
		
		$qry .= " AND (T6.user_id = " . $this->user->user_id . " AND T6.movement_status_id >= 2) OR ww_partners_movement.created_by = " . $this->user->user_id;

		$filter .= ' GROUP BY record_id ORDER BY ww_partners_movement.created_on DESC';

		$qry .= ' '. $filter;
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );

		if($result && $result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	public function _get_list_cached_query()
	{
		$this->load->config('list_cached_query_custom');
		return $this->config->item('list_cached_query');	
	}

	public function _get( $view, $record_id )
	{
		switch( $view )
		{
			case 'detail':
				$cached_query = $this->_get_detail_cached_query();
				break;
			case 'edit':
				$cached_query = $this->_get_edit_cached_query();
				break;
			case 'quick_edit':
		}

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($cached_query, array('record_id' => $record_id), TRUE);
		$qry = $this->parser->parse_string($qry, array('approver_userid' => $this->user->user_id), TRUE);

		return $this->db->query( $qry );
	}

	private function _get_detail_cached_query()
	{
		//check for cached query
		if( !$this->load->config('detail_cached_query', false, true) )
		{
			//mandatory fields
			$this->db->select( $this->table . '.' . $this->primary_key . ' as record_id' );
			$mandatory = array();
			foreach( $this->mfs as $mf )
			{
				$mandatory[] = $this->table . '.'.$mf . ' as "' . $this->table . '_'.$mf . '"';
			}

			//create query for all tables
			$this->load->config('fields');
			$tables = array();
			$columns = array();
			$search_col = array();
			$fields = $this->config->item('fields');
			foreach( $fields as $fg_id => $_fields )
			{
				foreach( $_fields as $f_name => $field )
				{
					if( $field['display_id'] == 2 || $field['display_id'] == 3)
					{
						switch( $field['uitype_id'] ){
							case 3: //yes or no
								$columns[] = 'IF('.$this->db->dbprefix.$f_name.' = 1, "Yes", "No")' . ' as "'. $field['table'] .'_'. $field['column'] .'"';
								break;
							case 4: //searchable dropdowns
								if( isset( $field['searchable'] )){
									switch( true )
									{
										case !empty($field['searchable']['textual_value_column']):
											$columns[] = $this->db->dbprefix.$field['table'].'.'.$field['searchable']['textual_value_column'] . ' as "'. $field['table'] .'_'. $field['column'] .'"';
											break;
										case $field['searchable']['type_id'] == 1:
											
											$columns[] = $this->db->dbprefix.$field['searchable']['table'].'.'.$field['searchable']['label'] . ' as "'. $field['table'] .'_'. $field['column'] .'"';
											$other_joins[] = array(
												'table' => $field['searchable']['table'],
												'on' => $field['searchable']['table'].'.'.$field['searchable']['value'] . ' = ' . $field['table'].'.'.$field['column'],
												'join' => 'left'

											);
											break;
										default:
											$columns[] = $f_name . ' as "'. $field['table'] .'_'. $field['column'] .'"';
										}
								}
								else{
									$columns[] = '"Undefined Searchable Dropdown" as "'. $field['table'] .'_'. $field['column'] .'"';	
								}
								break;
							case 6: //date picker
								$columns[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . ', \\\'%M %d, %Y\\\') as "'. $field['table'] .'_'. $field['column'] .'"';
								break;
							case 7: //password never ever include in listing
							case 13: //placeholder
								break;
							case 12: //date from - date to
								$columns[] = 'CONCAT(DATE_FORMAT('.$this->db->dbprefix.$f_name . '_from, \\\'%M %d, %Y\\\'), \\\' to \\\', DATE_FORMAT('.$this->db->dbprefix.$f_name . '_to, \\\'%M %d, %Y\\\')) as "'. $field['table'] .'_'. $field['column'] .'"';
								break;
							case 14: //time from - time to
								$columns[] = 'CONCAT(DATE_FORMAT('.$this->db->dbprefix.$f_name . '_from, \\\'%h:%i %p\\\'), \\\' to \\\', DATE_FORMAT('.$this->db->dbprefix.$f_name . '_to, \\\'%h:%i %p\\\')) as "'. $field['table'] .'_'. $field['column'] .'"';
								break;
							case 16: //date and time picker
								$columns[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . ', \\\'%M %d, %Y %h:%i %p\\\') as "'. $field['table'] .'_'. $field['column'] .'"';
								break;
							case 17: //time picker
								$columns[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . ', \\\'%h:%i %p\\\') as "'. $field['table'] .'_'. $field['column'] .'"';
								break;
							case 18: //month and year picker
								$columns[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . ', \\\'%M %d\\\') as "'. $field['table'] .'_'. $field['column'] .'"';
								break;
							case 19: //number range
								$columns[] = 'CONCAT('.$this->db->dbprefix.$f_name . '_from, \\\' to \\\', '.$this->db->dbprefix.$f_name . '_to) as "'. $field['table'] .'_'. $field['column'] .'"';
								break;
							case 20: //Time - Minute Second Picker
								$columns[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . ', \\\'%h:%i:%s %p\\\') as "'. $field['table'] .'_'. $field['column'] .'"';
								break;
							case 21: //Date and Time From - Date and Time To Picker
								$columns[] = 'CONCAT(DATE_FORMAT('.$this->db->dbprefix.$f_name . '_from, \\\'%M %d, %Y %h:%i %p\\\'), \\\' to \\\', DATE_FORMAT('.$this->db->dbprefix.$f_name . '_to, \'%M %d, %Y %h:%i %p\')) as "'. $field['table'] .'_'. $field['column'] .'"';
								break;
							default:
								$columns[] = $f_name . ' as "'. $field['table'] .'_'. $field['column'] .'"';
						}
						
						if( !in_array( $field['table'], $tables ) && $field['table'] != $this->table ){
							$this->db->join( $field['table'], $field['table'].'.'.$this->primary_key . ' = ' . $this->table.'.'.$this->primary_key, 'left');
							$tables[] = $field['table'];
						}
					}
				}
			}

			if(isset($other_joins))
			{
				foreach($other_joins as $join)
				{
					$this->db->join( $join['table'], $join['on'], $join['join']);	
				}
			}

			if( sizeof($columns) > 0 ){
				$this->db->select( $columns, false );
			}
			
			$db_debug = $this->db->db_debug;
			$this->db->db_debug = FALSE;

			$this->db->select( $mandatory );
			if( isset( $columns ) ) $this->db->select( $columns, false );
			$this->db->from( $this->table );
			$this->db->where( $this->table.'.'.$this->primary_key. ' = "{$record_id}"' );
			$record = $this->db->get();
			$cached_query = $this->db->last_query();

			$this->db->db_debug = $db_debug;

			$cached_query = '$config["detail_cached_query"] = \''. $cached_query .'\';';
			$cached_query = $this->load->blade('templates/save2file', array( 'string' => $cached_query), true);
			
			$this->load->helper('file');
			$save_to = $this->path . 'config/detail_cached_query.php';
			$this->load->helper('file');
			write_file($save_to, $cached_query);
		}

		$this->load->config('detail_cached_query');
		return $this->config->item('detail_cached_query');
	}

	private function _get_edit_cached_query()
	{
		//check for cached query
		if( !$this->load->config('edit_cached_query', false, true) )
		{
			//mandatory fields
			$this->db->select( $this->table . '.' . $this->primary_key . ' as record_id' );
			$mandatory = array();
			foreach( $this->mfs as $mf )
			{
				$mandatory[] = $this->table . '.'.$mf . ' as "' . $this->table . '.'.$mf . '"';
			}

			//create query for all tables
			$this->load->config('fields');
			$tables = array();
			foreach( $this->config->item('fields') as $fg_id => $fields )
			{
				foreach( $fields as $f_name => $field )
				{
					if( $field['display_id'] == 2 || $field['display_id'] == 3)
					{
						$encrypt_start = "";
						$encrypt_end = "";
						if(  $field['encrypt'] )
						{
							$encrypt_start = "CAST( AES_DECRYPT( ";
							$encrypt_end = ", encryption_key()) AS CHAR)";
						}
						
						switch( $field['uitype_id'] )
						{ 
							case 6:
								$columns[] = $encrypt_start . 'DATE_FORMAT('.$this->db->dbprefix.$f_name . ', \\\'%M %d, %Y\\\') '. $encrypt_end .' as "'. $field['table'] .'.'. $field['column'] .'"';
								break;
							case 12:
								$columns[] = $encrypt_start . 'DATE_FORMAT('.$this->db->dbprefix.$f_name . '_from, \\\'%M %d, %Y\\\') '. $encrypt_end .' as "'. $field['table'] .'.'. $field['column'] .'_from"';
								$columns[] = $encrypt_start . 'DATE_FORMAT('.$this->db->dbprefix.$f_name . '_to,\\\'%M %d, %Y\\\') '. $encrypt_end .' as "'. $field['table'] .'.'. $field['column'] .'_to"';
								break;	
							default:
								$columns[] = $encrypt_start . $this->db->dbprefix.$f_name . $encrypt_end . ' as "'. $field['table'] .'.'. $field['column'] .'"';
						}
					}
					
					if( !in_array( $field['table'], $tables ) && $field['table'] != $this->table ){
						$this->db->join( $field['table'], $field['table'].'.'.$this->primary_key . ' = ' . $this->table.'.'.$this->primary_key, 'left');
						$tables[] = $field['table'];
					}
				}
			}

			$db_debug = $this->db->db_debug;
			$this->db->db_debug = FALSE;

			$this->db->select( $mandatory );
			if( isset( $columns ) ) $this->db->select( $columns, false );
			$this->db->from( $this->table );
			$this->db->where( $this->table.'.'.$this->primary_key. ' = "{$record_id}"' );
			$record = $this->db->get();
			$cached_query = $this->db->last_query();

			$this->db->db_debug = $db_debug;

			$cached_query = '$config["edit_cached_query"] = \''. $cached_query .'\';';
			$cached_query = $this->load->blade('templates/save2file', array( 'string' => $cached_query), true);
			
			$this->load->helper('file');
			$save_to = $this->path . 'config/edit_cached_query.php';
			$this->load->helper('file');
			write_file($save_to, $cached_query);
		}

		$this->load->config('edit_cached_query');
		return $this->config->item('edit_cached_query');
	}
		
	function getTransferFields(){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_fields WHERE from_to = 1 "; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	function getPayrollAllowanceTransaction(){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}payroll_transaction WHERE show_in_movement = 1 AND deleted = 0"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}	

	public function get_employee_details($user_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT *, 
		'' AS rank_id, 
		'' AS rank
		 FROM partner_movement_current WHERE user_id = {$user_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	function setDecission($decission){

		$data = array();

		$qry = "CALL sp_partners_movement_approval('".$decission['movementid']."', '".$decission['userid']."', '".$decission['decission']."', '".$decission['comment']."')";
		$result = $this->db->query( $qry );

		if($result && $result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		mysqli_next_result($this->db->conn_id);
		return $data;	
	}

	public function get_movement_main_details($movement_id=0){ 

		$data = array();

		$qry = "SELECT 
				pmove.movement_id,
				pmove.status_id,
				pmove.due_to_id,
				pmove.remarks AS movement_remarks,
				pmove.created_by,
				pmoveact.action_id,
				pmoveact.user_id,
				ap.user_id AS approver_user_id,
				ap.movement_status_id AS approver_status_id,
				pmoveact.effectivity_date,
				pmoveact.type_id,
				pmoveact.type,
				pmoveact.remarks AS action_remarks,
				pmoveact.action_id,
				pmoveact.display_name,
				pmoveastat.status,
				pmoveact.status_id as act_status_id
				FROM {$this->db->dbprefix}partners_movement pmove
				LEFT JOIN {$this->db->dbprefix}partners_movement_action pmoveact 
				ON pmove.movement_id = pmoveact.movement_id 
				LEFT JOIN {$this->db->dbprefix}partners_movement_approver ap 
				ON pmove.movement_id = ap.movement_id 				
				LEFT JOIN {$this->db->dbprefix}partners_movement_status pmoveastat 
				ON pmove.status_id = pmoveastat.status_id 		
				WHERE pmove.movement_id = {$movement_id}
				AND ap.user_id = {$this->user->user_id}
				AND pmoveact.deleted = 0
				ORDER BY pmoveact.effectivity_date DESC"; // WHERE user_id = '$userID';

		$result = $this->db->query( $qry );
		
		if($result && $result->num_rows() > 0){
			return $result->row_array();		
		}
		else{
			return array();
		}
	}

	function newPostData($data = array(),$url = ''){
		if ($url != ''){
			$url = $url;
		}
		else{
			$url = $this->url;
		}
		$qry = "INSERT INTO ww_system_feeds 
				(
					status
					, message_type
					, user_id
					, display_name
					, feed_content
					, recipient_id
					, uri
				) 
				VALUES
				(
					'" . $data['status'] . "',
					'" . $data['message_type'] . "',
					'" . $data['user_id'] . "',
					'" . $data['display_name'] . "',
					'" . $data['feed_content'] . "',
					'" . $data['recipient_id'] . "',
					'" . str_replace(base_url(), '', $url).'/detail/'.$data['movement_id'] . "'					
				)";
		
		$this->db->query($qry);                                  
		
		return $this->db->insert_id();
	}

	function transfer_to_validation($movement_details=array()){
		$this->load->model('movement_model', 'mv');
		$data = array( 'movement_status_id' => 6 ); // set status to 'For Validation'
		$this->db->update( 'partners_movement', $data, array('movement_id' => $movement_details['movement_id']) );

        $current_user = array();
        $current_user = $this->db->get_where('users',array('user_id' => $this->session->userdata['user']->user_id))->row();

        $data['user_id']        	= $current_user->user_id;
        $data['display_name']   	= $current_user->full_name;
        $data['feed_content']  		= 'Your movement has now been approved and is now for HR approval';                                                           // THE MAIN FEED BODY
        $data['recipient_id']   	= $movement_details['created_by'];                                                               // TO WHOM THIS POST IS INTENDED TO
        $data['status']         	= 'info';                                                                   // DANGER, INFO, SUCCESS & WARNING
        $data['message_type']       = 'Movement';
        $data['movement_id'] 		= $movement_details['movement_id'];
            
        // ADD NEW DATA FEED ENTRY
        $latest = $this->newPostData($data,$this->mv->url);

        $this->notify_hr_validation($movement_details);
	}

	function notify_hr_validation($movement_details=array()){
		$this->load->model('movement_admin_model', 'mva');

		$hr_movement = $this->get_role_permission(22);

		if (count($hr_movement) > 0){
			$this->db->where_in('role_id',$hr_movement);
			$this->db->where('active',1);
			$this->db->where('deleted',0);  			
			$hr_admin_result = $this->db->get('users')->result_array();

            $current_user = array();
            $current_user = $this->db->get_where('users',array('user_id' => $this->session->userdata['user']->user_id))->row();

			foreach( $hr_admin_result as $hr_admin )
			{
				$qry_category = $this->get_role_category('',$hr_admin['role_id']);

				$to_check = false;
		        if ($qry_category != ''){
		            $this->db->where($qry_category, '', false);
		            $to_check = true;
		        }   

		        $this->db->where('email',trim($hr_admin['email']));
		        $this->db->join('users_profile','users.user_id = users_profile.user_id');
				$result = $this->db->get( 'users');

				if ($result && $result->num_rows() > 0){
					$users = $result->row_array();

					if ($to_check){
				        if ($qry_category != ''){
				            $this->db->where($qry_category, '', false);

					        $this->db->where('users.user_id',$movement_details['user_id']);
					        $this->db->join('users_profile','users.user_id = users_profile.user_id');
							$result1 = $this->db->get( 'users');
							if ($result1 && $result1->num_rows() > 0){
					            $data['user_id']        	= $current_user->user_id;
					            $data['display_name']   	= $current_user->full_name;
					            $data['feed_content']  		= 'Movement filed by '.$movement_details['display_name'].
					            							  ' has now been approved and is now for HR validation';                                                           // THE MAIN FEED BODY
					            $data['recipient_id']   	= $users['user_id'];                                                               // TO WHOM THIS POST IS INTENDED TO
					            $data['status']         	= 'info';                                                                   // DANGER, INFO, SUCCESS & WARNING
					            $data['message_type']       = 'Movement';
					            $data['movement_id'] 		= $movement_details['movement_id'];
					            
					            // ADD NEW DATA FEED ENTRY
					            $latest = $this->newPostData($data,$this->mva->url);
								$sp_time_forms_email_hr_validation = $this->db->query("CALL sp_partners_movement_email_hr_approval({$movement_details['movement_id']}, {$users['user_id']},'approved')");
								mysqli_next_result($this->db->conn_id);
							}						            
				        }   				
					}
					else {
			            $data['user_id']        	= $current_user->user_id;
			            $data['display_name']   	= $current_user->full_name;
			            $data['feed_content']  		= 'Movement filed by '.$movement_details['display_name'].
			            							  ' has now been approved and is now for HR validation';                                                           // THE MAIN FEED BODY
			            $data['recipient_id']   	= $users['user_id'];                                                               // TO WHOM THIS POST IS INTENDED TO
			            $data['status']         	= 'info';                                                                   // DANGER, INFO, SUCCESS & WARNING
			            $data['message_type']       = 'Movement';
			            $data['movement_id'] 		= $movement_details['movement_id'];
			            
			            // ADD NEW DATA FEED ENTRY
			            $latest = $this->newPostData($data,$this->mva->url);
						$sp_time_forms_email_hr_validation = $this->db->query("CALL sp_partners_movement_email_hr_approval({$movement_details['movement_id']}, {$users['user_id']},'approved')");
						mysqli_next_result($this->db->conn_id);
					}
				}
			}
		}
	}

	public function get_movement_details($movement_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT 
				pmove.movement_id,
				pmove.status_id,
				pmove.due_to_id,
				pmove.remarks AS movement_remarks,
				pmoveact.action_id,
				pmoveact.user_id,
				pmoveact.effectivity_date,
				pmoveact.type_id,
				pmoveact.type,
				pmoveremarks.remarks_print_report AS action_remarks,
				pmoveact.action_id,
				pmoveact.display_name,
				pmoveastat.status,
				pmoveact.status_id as act_status_id,
				pmoveact.photo,
				pmoveactm.further_reason,
				pmoveactr.reason
				FROM {$this->db->dbprefix}partners_movement pmove
				LEFT JOIN {$this->db->dbprefix}partners_movement_action pmoveact 
				ON pmove.movement_id = pmoveact.movement_id 
				LEFT JOIN {$this->db->dbprefix}partners_movement_action_moving pmoveactm
				ON pmoveact.action_id = pmoveactm.action_id 	
				LEFT JOIN {$this->db->dbprefix}partners_movement_reason pmoveactr
				ON pmoveactm.reason_id = pmoveactr.reason_id 	
				LEFT JOIN {$this->db->dbprefix}partners_movement_remarks pmoveremarks
				ON pmoveremarks.remarks_print_report_id = pmoveact.remarks_print_report_id 													
				LEFT JOIN {$this->db->dbprefix}partners_movement_status pmoveastat 
				ON pmove.status_id = pmoveastat.status_id 
				WHERE pmove.movement_id = {$movement_id}
				AND pmoveact.deleted = 0
				ORDER BY pmoveact.effectivity_date DESC"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function call_sp_approvers($user_id){		
		$sp_time_calendar = $this->db->query("CALL sp_partners_movement_get_approvers('mv', ".$user_id.")");

		mysqli_next_result($this->db->conn_id);
		return $sp_time_calendar->result_array();
	}

	function get_approver_list($movement_id=0){			
		$comments_query = "SELECT CONCAT( lastname , ' ', firstname ) AS display_name, comment, 
							movement_approver.movement_status_id, movement_approver.user_id AS approver_id,
							movement_approver.comment_date,ms.status,position
	    					FROM {$this->db->dbprefix}partners_movement_approver movement_approver 
							LEFT JOIN {$this->db->dbprefix}users_profile users_profile
							ON movement_approver.user_id = users_profile.user_id							
							LEFT JOIN {$this->db->dbprefix}partners_movement_status ms 
							ON movement_approver.movement_status_id = ms.status_id
							LEFT JOIN {$this->db->dbprefix}users_position up 
							ON users_profile.position_id = up.position_id							
					        WHERE movement_approver.movement_id= $movement_id
        					AND movement_approver.deleted = 0
        					ORDER BY movement_approver.sequence,movement_approver.id ";
		$comments = $this->db->query($comments_query);
		if ($comments && $comments->num_rows() > 0){
        	$comments = $comments->result_array();
		}
		else{
			$comments = array();
		}
		return $comments;
	}

	function get_hr_approver_list($movement_id=0){			
		$comments_query = "SELECT CONCAT( lastname , ' ', firstname ) AS display_name, comment, 
							movement_approver_hr.movement_status_id, movement_approver_hr.user_id AS approver_id,
							movement_approver_hr.comment_date,ms.status,position
	    					FROM {$this->db->dbprefix}partners_movement_approver_hr movement_approver_hr 
							LEFT JOIN {$this->db->dbprefix}users_profile users_profile
							ON movement_approver_hr.user_id = users_profile.user_id							
							LEFT JOIN {$this->db->dbprefix}partners_movement_status ms 
							ON movement_approver_hr.movement_status_id = ms.status_id
							LEFT JOIN {$this->db->dbprefix}users_position up 
							ON users_profile.position_id = up.position_id							
					        WHERE movement_approver_hr.movement_id= $movement_id
        					AND movement_approver_hr.deleted = 0
        					ORDER BY movement_approver_hr.sequence";
		$comments = $this->db->query($comments_query);
		if ($comments && $comments->num_rows() > 0){
        	$comments = $comments->result_array();
		}
		else{
			$comments = array();
		}
		return $comments;
	}


	function get_approver_remarks($movement_id=0){			
		$comments_query = "SELECT CONCAT( firstname , ' ', lastname ) AS display_name, comment, 
							movement_status_id, movement_approver.user_id AS approver_id,
							movement_approver.comment_date,movement_status
	    					FROM {$this->db->dbprefix}partners_movement_approver movement_approver 
							LEFT JOIN {$this->db->dbprefix}users_profile users_profile 
							ON movement_approver.user_id = users_profile.user_id
					        WHERE movement_id= $movement_id
        					AND (movement_status_id = 4 OR movement_status_id = 3 OR movement_status_id = 7)
        					AND deleted = 0
        					ORDER BY movement_approver.id ";
		$comments = $this->db->query($comments_query);
        $comments = $comments->result_array();
		return $comments;
	}

	public function get_action_movement($action_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action pma
				LEFT JOIN {$this->db->dbprefix}users u ON pma.user_id = u.user_id
				LEFT JOIN {$this->db->dbprefix}partners_movement_remarks pmr ON pmr.remarks_print_report_id = pma.remarks_print_report_id
				WHERE pma.action_id = {$action_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_action_movement_attachment($action_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_attachment pmaa
				WHERE pmaa.action_id = {$action_id} AND deleted = 0";
		$result = $this->db->query($qry);
		
		if($result && $result->num_rows() > 0){
			$data = $result->result();		
		}
			
		$result->free_result();
		return $data;	
	}
	
	public function get_extension_movement($action_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_extension
				WHERE action_id = {$action_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_moving_movement($action_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_moving pmam
				LEFT JOIN {$this->db->dbprefix}partners_movement_reason pmr ON pmam.reason_id = pmr.reason_id
				WHERE pmam.action_id = {$action_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_compensation_movement($action_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_compensation
				WHERE action_id = {$action_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_transfer_movement($action_id=0, $field_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_transfer
				WHERE action_id = {$action_id} 
				AND field_id = {$field_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_additional_allowance_movement($action_id=0, $field_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_additional_allowance
				WHERE action_id = {$action_id} 
				AND transaction_id = {$field_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result && $result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	function get_partners_personal($user_id=0, $partners_personal_table='', $key='', $sequence=0){
		$this->db->select('personal_id, key_value')
	    ->from($partners_personal_table)
	    ->join('partners', $partners_personal_table.'.partner_id = partners.partner_id', 'left')
	    ->where("partners.user_id = $user_id")
	    ->where($partners_personal_table.".key = '$key'");
	    if($sequence != 0)
	    	$this->db->where($partners_personal_table.".sequence = '$sequence'");

		if($partners_personal_table == 'partners_personal'){
	    	$this->db->where("partners_personal.deleted = 0");
	    }

	    $partners_personal = $this->db->get('');	
	    
		if( $partners_personal->num_rows() > 0 )
	    	return $partners_personal->row_array();
	    else
	    	return array();
	}

    // print movement information
    function export_pdf( $recruit_id ){
    	$user = $this->config->item('user');

        $this->load->library('PDFm');

        $mpdf = new PDFm();
        $mpdf->SetTitle( 'Movement Info Sheet' );
        $mpdf->SetAutoPageBreak(true, 1);
        $mpdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $mpdf->SetDisplayMode('real', 'default');
        $mpdf->AddPage();
		
		$html = '<table><thead><tr><td>dasdf</td></tr></thead><tbody><tr><td>dddd</td></tr></tbody></table>';

        $path = 'uploads/templates/movement/pdf/';
        $this->check_path( $path );
        $filename = $path . "movement_info.pdf";

        $mpdf->WriteHTML($html);
        $mpdf->Output($filename, 'F');

        return $filename;
    }

	function export_excel( $movement_id )
	{
		ini_set('memory_limit', '1024M');   
        ini_set('max_execution_time', 1800);

		$this->load->helper('file');
		$path = 'uploads/reports/movement/excel/';
		$this->check_path( $path );
		$filename = $path . strtotime(date('Y-m-d H:i:s')) . 'Movement' . ".xlsx";

		$this->load->library('excel');

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setTitle("Movement Report")
		            ->setDescription("Movement Report");
		               
		// Assign cell values
		$objPHPExcel->setActiveSheetIndex(0);
		$activeSheet = $objPHPExcel->getActiveSheet();

		//header
		$alphabet  = range('A','Z');
		$alpha_ctr = 0;
		$sub_ctr   = 0;				

	    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);

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

		$line = 1;
		$xcoor = $alphabet[$alpha_ctr];

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'NOTICE OF PERSONNEL ACTION - DAILY');
		$activeSheet->getStyle($xcoor.$line)->applyFromArray($bold);	
		$activeSheet->getStyle($xcoor.$line)->getFont()->setSize(16);

		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'RIOFIL CORPORATION');
		$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Units 1704-1706 Hanston Square');
		$objPHPExcel->getActiveSheet()->setCellValue('D3', '17 San Miguel Ave., Ortigas Center');
		$objPHPExcel->getActiveSheet()->setCellValue('D4', 'Pasig City');

		$this->db->where('partners_movement.movement_id',$movement_id);
		$this->db->join('partners_movement_action','partners_movement.movement_id = partners_movement_action.movement_id');
		$movement = $this->db->get('partners_movement');

		$action_id = '';
		if ($movement && $movement->num_rows() > 0){
			$movement_data = $movement->row();
			$action_id = $movement_data->action_id;

			$partners = $this->db->get_where('partners',array('user_id' => $movement_data->user_id));
			if ($partners && $partners->num_rows() > 0){
				$partners_info = $partners->row();
			}

			$objPHPExcel->getActiveSheet()->setCellValue('B8', date('d M Y',strtotime($movement_data->effectivity_date)));
			$objPHPExcel->getActiveSheet()->setCellValue('B9', $movement_data->display_name);
			$objPHPExcel->getActiveSheet()->setCellValue('B10', $movement_data->type);

			switch ($partners_info->status_id) {
				case 1:
					$objPHPExcel->getActiveSheet()->setCellValue('E9', 'X');
					$activeSheet->getStyle('E9')->applyFromArray($center);
					break;
				case 2:
					$objPHPExcel->getActiveSheet()->setCellValue('G9', 'X');
					$activeSheet->getStyle('G9')->applyFromArray($center);
					break;
				case 4:
					$objPHPExcel->getActiveSheet()->setCellValue('I9', 'X');
					$activeSheet->getStyle('I9')->applyFromArray($center);
					break;										
			}
		}

		$line = 8;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'EFFECTIVE DATE        :');
		$activeSheet->getStyle($xcoor.$line)->getFont()->setSize(12);
		$activeSheet->getStyle('B'.$line.':'.'C'.$line)->applyFromArray($border_bottom);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$line, 'EMPLOYMENT STATUS');
		$activeSheet->getStyle('E'.$line)->applyFromArray($bold);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'EMPLOYEE NAME      :');
		$activeSheet->getStyle($xcoor.$line)->getFont()->setSize(12);
		$activeSheet->getStyle('B'.$line.':'.'C'.$line)->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(3);

		$activeSheet->getStyle('E'.$line)->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(3);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'R');
		$activeSheet->getStyle('F'.$line)->applyFromArray($bold);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(3);

		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(3);
		$activeSheet->getStyle('G'.$line)->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$line, 'P');
		$activeSheet->getStyle('H'.$line)->applyFromArray($bold);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(3);

		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(3);
		$activeSheet->getStyle('I'.$line)->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line, 'PJ');
		$activeSheet->getStyle('J'.$line)->applyFromArray($bold);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(3);		

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'NATURE OF ACTION  :');
		$activeSheet->getStyle($xcoor.$line)->getFont()->setSize(12);
		$activeSheet->getStyle('B'.$line.':'.'C'.$line)->applyFromArray($border_bottom);

		$line++;

		if ($action_id != ''){
			$this->db->select('field_label,from_name,to_name');
			$this->db->where('action_id',$action_id);
			$this->db->join('partners_movement_fields','partners_movement_action_transfer.field_id = partners_movement_fields.field_id');
			$movement_action = $this->db->get('partners_movement_action_transfer');
			if ($movement_action && $movement_action->num_rows() > 0){
				$header = array('PARTICULARS','FROM','TO');

				$line = 13;
				foreach ($header as $key => $value) {
					if ($alpha_ctr >= count($alphabet)) {
						$alpha_ctr = 0;
						$sub_ctr++;
					}

					if ($sub_ctr > 0) {
						$xcoor = $alphabet[$sub_ctr - 1] . $alphabet[$alpha_ctr];
					} else {
						$xcoor = $alphabet[$alpha_ctr];
					}	

					$activeSheet->setCellValue($xcoor.$line, $value);
					$activeSheet->getStyle($xcoor.$line)->applyFromArray($bold);

					$alpha_ctr++;
				}

				$line++;

				foreach ($movement_action->result() as $row) {
					if ($row->field_label == 'End Date of Temporary Assignment'){
						$row->from_name = '';
					}
					$activeSheet->setCellValue('A'.$line, $row->field_label);
					$activeSheet->setCellValue('B'.$line, $row->from_name);
					$activeSheet->setCellValue('D'.$line, $row->to_name);
					$activeSheet->getStyle('A'.$line.':K'.$line)->applyFromArray($border_style);
					$activeSheet->mergeCells('B'.$line.':C'.$line);
					$activeSheet->mergeCells('D'.$line.':K'.$line);
					$line++;							
				}
			}
		}

		if ($action_id != ''){
			$line++;
			$alpha_ctr = 0;		
					
			$this->db->select('type_name,current_salary,to_salary');
			$this->db->where('action_id',$action_id);
			$movement_action = $this->db->get('partners_movement_action_compensation');
			if ($movement_action && $movement_action->num_rows() > 0){

				$header = array('CHANGES','FROM','TO');
				foreach ($header as $key => $value) {
					if ($alpha_ctr >= count($alphabet)) {
						$alpha_ctr = 0;
						$sub_ctr++;
					}

					if ($sub_ctr > 0) {
						$xcoor = $alphabet[$sub_ctr - 1] . $alphabet[$alpha_ctr];
					} else {
						$xcoor = $alphabet[$alpha_ctr];
					}	

					$activeSheet->setCellValue($xcoor.$line, $value);
					$activeSheet->getStyle($xcoor.$line)->applyFromArray($bold);

					$alpha_ctr++;
				}

				$line++;
				foreach ($movement_action->result() as $row) {
					$activeSheet->setCellValue('A'.$line, 'Salary Rate');
					$activeSheet->setCellValue('B'.$line, $row->current_salary);
					$activeSheet->setCellValue('D'.$line, $row->to_salary);
					$activeSheet->getStyle('A'.$line.':K'.$line)->applyFromArray($border_style);
					$activeSheet->mergeCells('B'.$line.':C'.$line);
					$activeSheet->mergeCells('D'.$line.':K'.$line);					
					$line++;							
				}
			}
		}

		$line++;

		$activeSheet->setCellValue('A'.$line, 'Approved by :');
		$activeSheet->getStyle('A'.$line)->applyFromArray($bold);

		$line++;

		$activeSheet->getStyle('A'.$line.':K'.$line)->applyFromArray($border_top);

		$activeSheet->getStyle('A'.$line.':A'.($line+4))->applyFromArray($border_left);

		$activeSheet->getStyle('K'.$line.':K'.($line+4))->applyFromArray($border_right);

		$activeSheet->getStyle('A'.($line+4).':K'.($line+4))->applyFromArray($border_bottom);

		$activeSheet->setCellValue('A'.($line+2), '     __________________________     ');
		$activeSheet->setCellValue('B'.($line+2), '     __________________________     ');
		$activeSheet->setCellValue('D'.($line+2), '     _________________________  ');

		$line = $line + 6;

		$activeSheet->setCellValue('A'.$line, 'Employee: ____________________________________');
		$activeSheet->getStyle('A'.$line)->applyFromArray($bold);

		$line++;

		$activeSheet->setCellValue('A'.$line, '                        Signature over Printed Name / Date');

		$activeSheet->getStyle('D'.$line)->applyFromArray($border_style);
		$activeSheet->setCellValue('E'.$line, 'Employee');

		$activeSheet->getStyle('I'.$line)->applyFromArray($border_style);
		$activeSheet->setCellValue('J'.$line, 'Personnel');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save( $filename );

		return $filename;
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