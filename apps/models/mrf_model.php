<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class mrf_model extends Record
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

	//load module config
	private $response;
	public $record_id;

	//mandatory fields
	var $mfs = array(
		'created_on',
		'created_by',
		'modified_on',
		'modified_by'
	);

	//new record mandatory fields
	var $nmfs = array(
		'created_on',
		'created_by',
	);

	//update record mandatory fields
	var $emfs = array(
		'modified_on',
		'modified_by',
	);

	public function __construct()
	{
		$this->mod_id = 122;
		$this->mod_code = 'mrf';
		$this->route = 'recruitment/mrf';
		$this->url = site_url('recruitment/mrf');
		$this->primary_key = 'request_id';
		$this->table = 'recruitment_request';
		$this->icon = 'fa-folder';
		$this->short_name = ' Personnel Requisition Form';
		$this->long_name  = ' Personnel Requisition Form';
		$this->description = '';
		$this->path = APPPATH . 'modules/mrf/';

		$this->response = new stdClass();
		parent::__construct();
	}

	function get_key_classes()
	{
		$this->db->order_by('sequence');
		$classes = $this->db->get_where('recruitment_request_key_class', array('deleted' => 0));
		if( $classes->num_rows() > 0 )
			return $classes->result();
		else
			return false;
	}

	function get_keys( $key_class_id, $record_id )
	{
		if( !empty( $record_id ) ){
			$qry = "select a.*, b.key_value
			FROM {$this->db->dbprefix}recruitment_request_key a
			LEFT JOIN {$this->db->dbprefix}recruitment_request_details b ON b.key_id = a.key_id  AND b.request_id = {$record_id}
			WHERE a.deleted = 0 AND a.key_class_id = {$key_class_id}
			ORDER BY a.sequence";
			$classes = $this->db->query( $qry );
		}
		else{
			$this->db->order_by('sequence');
			$classes = $this->db->get_where('recruitment_request_key', array('deleted' => 0, 'key_class_id' => $key_class_id));	
		}

		if( $classes->num_rows() > 0 )
			return $classes->result();
		else
			return false;
	}

	function _get_list($start, $limit, $search, $filter, $dt_filter, $trash = false)
	{
		$data = array();				
		
		$qry = $this->_get_list_cached_query();
		
		if( $trash )
		{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 1";
		}
		else{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 0";	
		}
		
		$qry .= " AND {$this->db->dbprefix}recruitment_request.user_id = {$this->user->user_id}";
		if(is_array($filter)) {
			foreach ($filter as $filter_key => $filter_value) {
				$qry .= ' AND '.$this->db->dbprefix.'recruitment_request.'. $filter_value;
			}
		}	
		
		if($dt_filter != "")
			$qry .= ' AND '.$this->db->dbprefix.'recruitment_request.created_on LIKE "%'. $dt_filter . '%"';
			
		$qry .= " ORDER BY " .$this->db->dbprefix. "recruitment_request.created_on DESC";
		$qry .= " LIMIT $limit OFFSET $start";
		
		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);
		//echo "<pre>";print_r($qry);exit;
		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		
		return $data;
	}

	function get_mrf_by_status()
	{
		$mrf = array();
		$has_mrf = false;
		//get status
		$statuses = $this->db->get_where('recruitment_request_status', array('deleted' => 0));
		foreach( $statuses->result() as $status )
		{
			if( empty($status->css_class) )
				$status->css_class = "default";
			$mrf[$status->recruit_status_id]['status'] = $status;
			$mrf[$status->recruit_status_id]['mrf'] = array();
			//get all mrf with status
			$qry = "SELECT a.*, b.position
			FROM {$this->db->dbprefix}recruitment_request a
			LEFT JOIN {$this->db->dbprefix}users_position b on b.position_id = a.position_id
			WHERE a.deleted=0 AND a.status_id={$status->recruit_status_id}
			ORDER BY a.created_on DESC";
			$mrfs = $this->db->query( $qry );
			foreach( $mrfs->result() as $_mrf )
			{
				$mrf[$status->recruit_status_id]['mrf'][] = $_mrf;
				$has_mrf = true;
			}
		}
		
		if($has_mrf)
			return $mrf;
		return 
			false;
	}

	function get_active_mrf_by_year_interviewer()
	{
		$user = $this->db->get_where('users_profile',array('user_id'=>$this->user->user_id));
		$users = $user->row();
		
		$mrf = array();
		$qry = "SELECT a.*, b.position, c.process_id, d.schedule_id, d.user_id as `interviewer`
		FROM {$this->db->dbprefix}recruitment_request a
		LEFT JOIN {$this->db->dbprefix}users_position b on b.position_id = a.position_id
		LEFT JOIN {$this->db->dbprefix}recruitment_process c on c.request_id = a.request_id
		LEFT JOIN {$this->db->dbprefix}recruitment_process_schedule d on d.process_id = c.process_id
		WHERE a.deleted=0 AND a.status_id in (4,7) AND a.user_id = $users->user_id OR d.user_id = $users->user_id
		GROUP BY c.request_id"; 
		
		$qry .= " ORDER BY YEAR(a.created_on) DESC, a.created_on ASC";
		$mrfs = $this->db->query( $qry );
		
		if($mrfs->num_rows() > 0 )
		{	
			foreach( $mrfs->result() as $_mrf )
			{
				$mrf[date('Y', strtotime($_mrf->created_on))][] = $_mrf;
			}
			
			return $mrf;
		}
		else {
			return false;
		}	
	}

	function get_active_mrf_by_year()
	{
        $user_id = $this->config->config['user']['user_id'];
        $permission = $this->config->item('permission');
        $this->load->model('applicant_monitoring_model', 'applicant_monitoring');
        $is_assigned = isset($permission[$this->applicant_monitoring->mod_code]['process']) ? $permission[$this->applicant_monitoring->mod_code]['process'] : 0;

		$mrf = array();
       
		$qry = "SELECT a.*, b.position, rra.approver_id
		FROM {$this->db->dbprefix}recruitment_request a
        LEFT JOIN {$this->db->dbprefix}recruitment_request_approver rra on rra.request_id = a.request_id
		LEFT JOIN {$this->db->dbprefix}users_position b on b.position_id = a.position_id
		WHERE a.deleted=0 AND a.status_id IN (4,7) ";
        if($is_assigned){
             $qry .= " AND a.hr_assigned={$user_id}";
        }
		$qry .= " ORDER BY YEAR(a.created_on) DESC, a.created_on ASC";
		$mrfs = $this->db->query( $qry );
        
		foreach( $mrfs->result() as $_mrf )
		{
			$mrf[date('Y', strtotime($_mrf->created_on))][] = $_mrf;
		}
		
		return $mrf;
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

	public function _save( $child_call = false, $transactions = true )
	{
		$error = false;
		$post = $_POST;
		$this->response->record_id = $this->record_id = $post['record_id'];
		unset( $post['record_id'] );

		$this->load->config('fields');
		$this->load->config('field_validations');
		$this->load->library('encrypt');
		$this->load->library('form_validation');
		$validation_rules = array();

		$fgs = $this->config->item('fields');	
		foreach( $fgs as $fg_id => $fs )
		{
			foreach( $fs as $f_name => $field )
			{
				$fields[$f_name] = $field;
			}
		}

		if( !isset($fields) )
		{
			$this->response->message[] = array(
				'message' => lang('common.no_field'),
				'type' => 'error'
			);
			$error = true;
			goto stop;
		}

		$save = array();
		//echo "<pre>";print_r($post);exit;
		foreach( $post as $table => $columns )
		{
			if(is_array($columns))
			{
				foreach($columns as $column => $value)
				{
					if($column == "quantity")
					{
						if(!$value > 0){
							$this->response->message[] = array(
								'message' => 'Quantity should be greater than zero.',
								'type' => 'warning'
							);
							$error = true;
							goto stop;
						}
					}

					$field = isset( $fields[$table.'.'.$column] ) ? $fields[$table.'.'.$column] : false;
					
					if( $field ){
						$rules = array();
						if( !empty( $field['datatype'] ) )
						{
							$rules = explode('|', $field['datatype']);
						}

						if( in_array('integer', $rules) || in_array('numeric', $rules) )
						{
							$value = str_replace(',', '', $value);  
							$post[$table][$field['column']] = $value;
							$_POST[$table][$column] = $value;
						}
						
						
						switch( $field['uitype_id'] )
						{
							case 4: //init value of additional column 
								$save[$table][$field['column']] = $post[$table][$field['column']];
								if( !empty($field['searchable']['textual_value_column']) )
								{
									$save[$table][$field['searchable']['textual_value_column']] = 'updated by trigger';
								}
								break;
							case 6: //date picker
								$save[$table][$column] = date('Y-m-d', strtotime($value));
								break;
							case 7: //password
								$this->load->library('phpass');
								$save[$table][$column] = $this->phpass->hash( $value );
								break;	
							case 10: //multiselect checkbox
								$save[$table][$field['column']] = implode(',', $post[$table][$field['column']]);
								break;	
							case 12: //date from date to
								unset( $post[$table][$field['column']] );
								$save[$table][$field['column'].'_from'] = date('Y-m-d', strtotime($post[$table][$field['column'].'_from']));
								$save[$table][$field['column'].'_to'] = date('Y-m-d', strtotime($post[$table][$field['column'].'_to']));
								break;
							case 14: //time from time to
								unset( $post[$table][$field['column']] );
								$fields[$table.'.'.$column.'_from'] = $field;
								$fields[$table.'.'.$column.'_to'] = $field;
								$save[$table][$field['column'].'_from'] = date('H:i:s', strtotime($post[$table][$field['column'].'_from']));
								$save[$table][$field['column'].'_to'] = date('H:i:s', strtotime($post[$table][$field['column'].'_to']));
								break;
							case 16: //date and time picker
								$save[$table][$column] = date('Y-m-d H:i:s', strtotime(str_replace(' - ', ' ', $value)));
								break;
							case 17: //Time Picker
							case 12: //Time - Minute Second Picker
								$save[$table][$column] = date('H:i:s', strtotime($value));
								break;
							case 18: //Month and Year Picker
								$save[$table][$column] = date('Y-m-01', strtotime($value));
								break;
							case 19: //number range
								unset( $post[$table][$field['column']] );
								$save[$table][$field['column'].'_from'] = date('H:i:s', strtotime($post[$table][$field['column'].'_from']));
								$save[$table][$field['column'].'_to'] = date('H:i:s', strtotime($post[$table][$field['column'].'_to']));
								break;
							case 21: //Date and Time From - Date and Ti
								unset( $post[$table][$field['column']] );
								$save[$table][$field['column'].'_from'] = date('Y-m-d H:i:s', strtotime($post[$table][$field['column'].'_from']));
								$save[$table][$field['column'].'_to'] = date('Y-m-d H:i:s', strtotime($post[$table][$field['column'].'_to']));
								break;
							default:
								$save[$table][$field['column']] = $post[$table][$field['column']];	
						}

						if( $field['encrypt'] && $value )
						{
							$this->load->library('aes', array('key' => $this->config->item('encryption_key')));
							switch( $field['uitype_id'] )
							{
								case 12:
								case 14:
								case 19:
								case 21:
									$save[$table][$field['column'].'_from'] = $this->aes->encrypt( $save[$table][$field['column'].'_from'] );
									$$save[$table][$field['column'].'_to'] = $this->aes->encrypt( $save[$table][$field['column'].'_to'] );
									break;
								default:
									$save[$table][$column] = $this->aes->encrypt( $value );
							}
						}

						$validation = $this->config->item($table.'.'.$column, 'field_validations');
						//validation if any
						if( $validation )
						{
							foreach( $validation as $rule )
							{
								$validation_rules[] = $rule;	
							}
						}
					}
				}
			}	
		}

		if( sizeof( $validation_rules ) > 0 )
		{
			$this->form_validation->set_rules( $validation_rules );
			if ($this->form_validation->run() == false)
			{
				foreach( $this->form_validation->get_error_array() as $f => $f_error )
				{
					$this->response->message[] = array(
						'message' => $f_error,
						'type' => 'warning'
					);	
				}
				
				$error = true;
				goto stop;
			}	

		}

		if( $transactions )
		{
			$this->db->trans_begin();
		}
		
		
		//start saving with main table
		$main_record = $save[$this->table];
		$record = $this->db->get_where( $this->table, array( $this->primary_key => $this->record_id ) );
		switch( true )
		{
			case $record->num_rows() == 0:
				//add mandatory fields
				$main_record['created_by'] = $this->user->user_id;
				$main_record['created_on'] = date('Y-m-d H:i:s');
				$this->db->insert($this->table, $main_record);
				if( $this->db->_error_message() == "" )
				{
					$this->response->record_id = $this->record_id = $this->db->insert_id();
				}
				$this->response->action = 'insert';
				break;
			case $record->num_rows() == 1:
				$main_record['modified_by'] = $this->user->user_id;
				$main_record['modified_on'] = date('Y-m-d H:i:s');
				$this->db->update( $this->table, $main_record, array( $this->primary_key => $this->record_id ) );
				$this->response->action = 'update';
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

		$other_tables = $save;
		unset( $other_tables[$this->table] );

		foreach( $other_tables as $table => $data )
		{
			$record = $this->db->get_where( $table, array( $this->primary_key => $this->record_id ) );
			switch( true )
			{
				case $record->num_rows() == 0:
					$data[$this->primary_key] = $this->record_id;
					$this->db->insert($table, $data);
					$this->record_id = $this->db->insert_id();
					break;
				case $record->num_rows() == 1:
					$this->db->update( $table, $data, array( $this->primary_key => $this->record_id ) );
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
			}
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

		if( !$error && !$child_call )
		{
			$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
		}

		$this->response->saved = !$error;
		return $this->response;
	}

	public function get_request_key_id($key_code = null)
	{
		if(!is_null($key_code)){
			$this->db->where('key_code', $key_code);
			$recruitment_request_key = $this->db->get('recruitment_request_key');

			if($recruitment_request_key && $recruitment_request_key->num_rows() > 0){
				$recruitment_request_key = $recruitment_request_key->row();
				return $recruitment_request_key->key_id;
			}
		}

		return false;
	}

    function get_recruitment_config($key)
    {
    	$this->db->where('key', $key);
    	$this->db->limit('1');
    	$config = $this->db->get('config');

    	if($config && $config->num_rows() > 0){
    		$config = $config->row();
    		return $config->value;
    	}
    	
    	return false;
    }
    
}