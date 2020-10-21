<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Record extends MY_Model
{
	//load module config
	private $response;
	private $record_id;

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

	//code of conduct
	var $coc_process = 'immediate';

	function __construct()
	{
		$this->db_which();

		$this->user = $this->session->userdata('user');
		$this->response = new stdClass();
	}

	public function get_role_category($table = '',$user_role_id = ''){
		if ($table == ''){
			$table = "{$this->db->dbprefix}users_profile";
		}

		$user = $this->config->item('user');

		if ($user_role_id != ''){
			$user_role_id_f = $user_role_id;
		}
		else{
			$user_role_id_f = $user['role_id'];
		}

		$this->db->where('role_id',$user_role_id_f);
		$role_category_result = $this->db->get('roles_category');
		$qry = '';
		if ($role_category_result && $role_category_result->num_rows() > 0){
			$ctr = 0;
			foreach ($role_category_result->result() as $row) {
				if ($ctr == 0){
					$qry .= "{$table}.".$row->category_field." IN (". $row->category_val .")";
				}
				else{
					$qry .= " AND {$table}.".$row->category_field." IN (". $row->category_val .")";
				}
				$ctr++;
			}
		}

		return $qry;
	}

	public function get_role_permission($permission){
		$qry = "SELECT  *
				FROM {$this->db->dbprefix}roles r 
				WHERE FIND_IN_SET(".$permission.",profile_id)";

		$result = $this->db->query($qry); 

		$arr_result = array();
		if ($result && $result->num_rows() > 0){
			foreach ($result->result() as $row) {
				array_push($arr_result, $row->role_id);
			}
		}

		return $arr_result;
	}

	public function get_company(){
		$this->db->where('deleted',0);
		$company = $this->db->get('users_company');
		return $company;
	}

	function db_which()
	{
		if( $this->session->userdata('current_db') && $this->session->userdata('current_db') != "default" )
		{
			$multidb = $this->load->config('multidb', true, true);
			if( $multidb && isset( $multidb[$this->session->userdata('current_db')] ) )
			{
				$this->db = $this->load->database($multidb[$this->session->userdata('current_db')], TRUE);
				$connected = $this->db->initialize();
				if( !$connected )
				{
					echo "Cant connect to database";
					die();
				}
			}
		}
		else{
			$this->db->initialize(); //use default
		}	
	}

	/**
	 * [_record_exists description]
	 * @param  [type] $record_id
	 * @param  [type] $table
	 * @param  [type] $key
	 * @param  array  $where
	 * @return [type]
	 */
	public function _exists( $record_id )
	{
		$record = $this->db->get_where( $this->table, array( $this->primary_key => $record_id ) );

		switch( $record->num_rows() )
		{
			case 1:
				return true;
			case 0:
				return lang('common.no_record_found');
			default:
				return lang('common.multi_record_found');
		}
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

	public function _get_list_cached_query()
	{
		//check for cached query
		if( !$this->load->config('list_cached_query', false, true) )
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
					switch( $field['uitype_id'] ){
						case 3: //yes or no
							$columns[] = 'IF('.$this->db->dbprefix.$f_name.' = 1, "Yes", "No")' . ' as "'. $field['table'] .'_'. $field['column'] .'"';
							$search_col[] = 'IF('.$this->db->dbprefix.$f_name.' = 1, "Yes", "No")';
							break;
						case 4: //searchable dropdowns
							if( isset( $field['searchable'] )){
								switch( true )
								{
									case !empty($field['searchable']['textual_value_column']):
										$columns[] = $this->db->dbprefix.$field['table'].'.'.$field['searchable']['textual_value_column'] . ' as "'. $field['table'] .'_'. $field['column'] .'"';
										$search_col[] = $this->db->dbprefix.$field['table'].'.'.$field['searchable']['textual_value_column'];	
										break;
									case $field['searchable']['type_id'] == 1:
										$table_alias = "T".$field['f_id'];
										$columns[] = $table_alias.'.'.$field['searchable']['label'] . ' as "'. $field['table'] .'_'. $field['column'] .'"';
										$other_joins[] = array(
											'table' => $field['searchable']['table'] .' '. $table_alias,
											'on' => $table_alias.'.'.$field['searchable']['value'] . ' = ' . $field['table'].'.'.$field['column'],
											'join' => 'left'

										);
										$search_col[] = $table_alias.'.'.$field['searchable']['label'];
										break;
									case $field['searchable']['type_id'] == 2:

										break;
									default:
										$columns[] = $f_name . ' as "'. $field['table'] .'_'. $field['column'] .'"';
										$search_col[] = $this->db->dbprefix.$f_name;
									}
							}
							else{
								$columns[] = '"Undefined Searchable Dropdown" as "'. $field['table'] .'_'. $field['column'] .'"';	
							}
							break;
						case 6: //date picker
							$columns[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . ', \\\'%M %d, %Y\\\') as "'. $field['table'] .'_'. $field['column'] .'"';
							$search_col[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . ', \\\'%M %d, %Y\\\')';
							break;
						case 7: //password never ever include in listing
						case 13: //placeholder
							break;
						case 12: //date from - date to
							$columns[] = 'CONCAT(DATE_FORMAT('.$this->db->dbprefix.$f_name . '_from, \\\'%M %d, %Y\\\'), \\\' to \\\', DATE_FORMAT('.$this->db->dbprefix.$f_name . '_to, \\\'%M %d, %Y\\\')) as "'. $field['table'] .'_'. $field['column'] .'"';
							$search_col[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . '_from, \\\'%M %d, %Y\\\')';
							$search_col[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . '_to, \\\'%M %d, %Y\\\')';
							break;
						case 14: //time from - time to
							$columns[] = 'CONCAT(DATE_FORMAT('.$this->db->dbprefix.$f_name . '_from, \\\'%h:%i %p\\\'), \\\' to \\\', DATE_FORMAT('.$this->db->dbprefix.$f_name . '_to, \\\'%h:%i %p\\\')) as "'. $field['table'] .'_'. $field['column'] .'"';
							$search_col[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . '_from, \\\'%h:%i %p\\\')';
							$search_col[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . '_to, \\\'%h:%i %p\\\')';
							break;
						case 16: //date and time picker
							$columns[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . ', \\\'%M %d, %Y %h:%i %p\\\') as "'. $field['table'] .'_'. $field['column'] .'"';
							$search_col[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . ', \\\'%M %d, %Y %h:%i %p\\\')';
							break;
						case 17: //time picker
							$columns[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . ', \\\'%h:%i %p\\\') as "'. $field['table'] .'_'. $field['column'] .'"';
							$search_col[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . ', \\\'%h:%i %p\\\')';
							break;
						case 18: //month and year picker
							$columns[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . ', \\\'%M %d\\\') as "'. $field['table'] .'_'. $field['column'] .'"';
							$search_col[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . ', \\\'%M %d\\\')';
							break;
						case 19: //number range
							$columns[] = 'CONCAT('.$this->db->dbprefix.$f_name . '_from, \\\' to \\\', '.$this->db->dbprefix.$f_name . '_to) as "'. $field['table'] .'_'. $field['column'] .'"';
							$search_col[] = $this->db->dbprefix.$f_name . '_from';
							$search_col[] = $this->db->dbprefix.$f_name . '_to';
							break;
						case 20: //Time - Minute Second Picker
							$columns[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . ', \\\'%h:%i:%s %p\\\') as "'. $field['table'] .'_'. $field['column'] .'"';
							$search_col[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . ', \\\'%h:%i:%s %p\\\')';
							break;
						case 21: //Date and Time From - Date and Time To Picker
							$columns[] = 'CONCAT(DATE_FORMAT('.$this->db->dbprefix.$f_name . '_from, \\\'%M %d, %Y %h:%i %p\\\'), \\\' to \\\', DATE_FORMAT('.$this->db->dbprefix.$f_name . '_to, \'%M %d, %Y %h:%i %p\')) as "'. $field['table'] .'_'. $field['column'] .'"';
							$search_col[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . '_from, \\\'%M %d, %Y %h:%i %p\\\')';
							$search_col[] = 'DATE_FORMAT('.$this->db->dbprefix.$f_name . '_to, \\\'%M %d, %Y %h:%i %p\\\')';
							break;
						default:
							$columns[] = $f_name . ' as "'. $field['table'] .'_'. $field['column'] .'"';
							$search_col[] = $this->db->dbprefix.$f_name;
					}
					
					if( !in_array( $field['table'], $tables ) && $field['table'] != $this->table ){
						$this->db->join( $field['table'], $field['table'].'.'.$this->primary_key . ' = ' . $this->table.'.'.$this->primary_key, 'left');
						$tables[] = $field['table'];
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
			$this->db->from( $this->table );
			$record = $this->db->get();
			$this->db->db_debug = $db_debug;
			$cached_query = $this->db->last_query();
			if( sizeof($search_col) > 0 ){
				$cached_query .= "\r\nWHERE (\r\n";
				foreach($search_col as $index => $search)
				{
					$cached_query .= "\t" . $search .' like "%{$search}%"';
					if(sizeof($search_col) != $index+1)
					{
						$cached_query .= " OR \r\n";
					}
					else{
						$cached_query .= "\r\n";
					}
				}
				$cached_query .= ")";
			}


			$cached_query = '$config["list_cached_query"] = \''. $cached_query .'\';';
			$cached_query = $this->load->blade('templates/save2file', array( 'string' => $cached_query), true);
			
			$this->load->helper('file');
			$save_to = $this->path . 'config/list_cached_query.php';
			$this->load->helper('file');
			write_file($save_to, $cached_query);
		}

		if( $this->load->config('list_cached_query_custom', false, true) )
		{
			return $this->config->item('list_cached_query_custom');
		}

		$this->load->config('list_cached_query');
		return $this->config->item('list_cached_query');	
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

		foreach( $post as $table => $columns )
		{
			if($columns == "date_sent")
			{
				$save[$this->table]['date_sent'] = date('Y-m-d H:i:s');
			}
			if (is_array($columns)){
				foreach($columns as $column => $value)
				{
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
								if (isset($field['searchable']['multiple']) && $field['searchable']['multiple'] == 1){
									if ($post[$table][$field['column']] && is_array($post[$table][$field['column']])){
										$save[$table][$field['column']] = implode(',', $post[$table][$field['column']]);
									}
									else{
										$save[$table][$field['column']] = $post[$table][$field['column']];
									}
								}
								else{
									$save[$table][$field['column']] = $post[$table][$field['column']];
								}
								if( !empty($field['searchable']['textual_value_column']) )
								{
									$save[$table][$field['searchable']['textual_value_column']] = 'updated by trigger';
								}
								break;
							case 6: //date picker
								if ($value != '') {
									$save[$table][$column] = date('Y-m-d', strtotime($value));
								}
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
		$previous_main_data = array();
		$main_record = $save[$this->table];
		$record = $this->db->get_where( $this->table, array( $this->primary_key => $this->record_id ) );
		switch( true )
		{
			case $record->num_rows() == 0:
				//add mandatory fields
				$main_record['created_by'] = $this->user->user_id;
				$this->db->insert($this->table, $main_record);
				if( $this->db->_error_message() == "" )
				{
					$this->response->record_id = $this->record_id = $this->db->insert_id();
				}
				$this->response->action = 'insert';
				break;
			case $record->num_rows() == 1:
				//get previous data for audit logs
				$previous_main_data = $this->db->get_where($this->table, array($this->primary_key => $this->record_id))->row_array();
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
		
		//create system logs
		$this->audit_logs($this->user->user_id, $this->mod_code, $this->response->action, $this->table, $previous_main_data, $main_record);

		$other_tables = $save;
		unset( $other_tables[$this->table] );
		foreach( $other_tables as $table => $data )
		{
			$previous_other_data = array();
			$record = $this->db->get_where( $table, array( $this->primary_key => $this->record_id ) );
			switch( true )
			{
				case $record->num_rows() == 0:
					$data[$this->primary_key] = $this->record_id;
					$this->db->insert($table, $data);
					$this->record_id = $this->db->insert_id();
					$other_action = 'insert';
					break;
				case $record->num_rows() == 1:
					//get previous data for audit logs
					$previous_other_data = $this->db->get_where($table, array($this->primary_key => $this->record_id))->row_array();
					$this->db->update( $table, $data, array( $this->primary_key => $this->record_id ) );
					$other_action = 'update';
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

			//create system logs
			$this->audit_logs($this->user->user_id, $this->mod_code, $other_action, $table, $previous_other_data, $data);
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

	function _get_total()
	{
		$this->db->where('deleted = 0');
		return $this->db->count_all( $this->table );
	}
		
	function _get_list($start, $limit, $search, $filter, $trash = false)
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
		
		$qry .= ' '. $filter;
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	function _delete( $records )
	{
		$data['modified_on'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->user->user_id;
		$data['deleted'] = 1;

		$this->db->where_in($this->primary_key, $records);
		$result = $this->db->get($this->table);
		$result_data = $result->result();
		if($result->num_rows > 0){
			$count = 0;
			foreach($result_data as $row){
        		if(isset($row->can_delete) && $row->can_delete == '0'){
					$count++;
				}
        	}

        	if($count > 0){
        		$this->response->message[] = array(
                	'message' => lang('common.can_delete', $count),
                	'type' => 'error'
            	);
            	$error = true;            	
            	goto stop;	
        	}
	
		}

		stop:
		// debug($cannot_delete);die();

		$this->db->where_in($this->primary_key, $records);
		//temporary until all tables have can_delete column
		// $this->db->where('can_delete','1');
		$this->db->update($this->table, $data);

		//create system logs
		$this->audit_logs($this->user->user_id, $this->mod_code, 'delete', $this->primary_key, array(), $records);

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

		return $this->response;
	}

	function _restore( $records )
	{
		$data['modified_on'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->user->user_id;
		$data['deleted'] = 0;

		$this->db->where_in($this->primary_key, $records);
		$this->db->update($this->table, $data);
		
		//create system logs
		$this->audit_logs($this->user->user_id, $this->mod_code, 'restore', $this->primary_key, array(), $records);

		if( $this->db->_error_message() != "" ){
			$this->response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}
		else{
			$this->response->message[] = array(
				'message' => lang('common.restore_record', $this->db->affected_rows()),
				'type' => 'success'
			);
		}

		return $this->response;
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

	function audit_logs($user_id, $module, $action, $field="", $previous_val="", $new_val=""){
		//check if new value is array
		if(is_array($new_val)){
			$exclude_fields = array('created_by', 'created_on', 'modified_by', 'modified_on');
			foreach($new_val as $index_field => $new_value){
				if(!count($previous_val) > 0){
					if($action == 'delete' || $action == 'restore'){
						$this->system_logs($user_id, $module, $action, $field, $new_value, '');
						$this->user_logs($user_id, $module, $action, $field, $new_value, '');
					}else{//insert
						if(!in_array($index_field, $exclude_fields) && $new_value != ""){
							$this->system_logs($user_id, $module, $action, $index_field, '', $new_value);
							$this->user_logs($user_id, $module, $action, $index_field, '', $new_value);
						}
					}
				}else{
					if(strtolower($previous_val[$index_field]) != strtolower($new_value) && $new_value != "" && !in_array($index_field, $exclude_fields)){
						$this->system_logs($user_id, $module, $action, $index_field, $previous_val[$index_field], $new_value);
						$this->user_logs($user_id, $module, $action, $index_field, $previous_val[$index_field], $new_value);
					}
				}
			}
		}else{
			$this->system_logs($user_id, $module, $action, $field, $previous_val, $new_val);
			$this->user_logs($user_id, $module, $action, $field, $previous_val, $new_val);
		}
	}

	function system_logs($user_id, $module, $action, $field, $previous_val, $new_val){
		//$this->db_which();

		//
		$this->load->helper('file');
        $path = 'apps/logs/system/';
        $this->check_path( $path );
        $count = 1;
        $file_count = str_pad($count, 3, "0", STR_PAD_LEFT);
        $current_date= date('Y-m-d');
        $filename = $path.$current_date."-".$file_count.".txt";

		$content = "";
		$file_size = 0;

        if (file_exists($filename)) {
		    $file_size = filesize( $filename );
			// if($file_size > 0){
				// $content = "\r\n";
				// if($file_size >= 10000){ //1mb
					$log_files = scandir($path);
					$max_count = '001';
					foreach($log_files as $filelog){
						if(substr($filelog,0,10) == $current_date){
							$logcount = substr($filelog, 11, 3);
							if($logcount > $max_count){
								$max_count = $logcount;
							}
						}
					}
					$filename = $path.$current_date."-".$max_count.".txt";
				    $file_size = filesize( $filename );
					if($file_size > 0){
						$content = "\r\n";
						if($file_size >= 10000){ //1mb
							$content = "";
        					$file_count = ++$max_count;
       						$file_count = str_pad($file_count, 3, "0", STR_PAD_LEFT);
        					$filename = $path.$current_date."-".$file_count.".txt";
				  			$file = fopen($filename,"w");
							fwrite($file, '');
							fclose($file);
						}
					}
			// 	}
			// }
		} else {
  			$file = fopen($filename,"w");
			fwrite($file, '');
			fclose($file);
		}
		$user = $this->db->get_where('users', array('user_id' => $user_id))->row();
		
		$content .= $user->full_name."(".$user->login.")";
		$content .= " --> ".date("Y-m-d H:i:s");
		$content .= " --> ".$module;
		$content .= " --> ".$action;
		$content .= " --> ".$field;
		$content .= " --> ".$previous_val;
		$content .= " --> ".$new_val;

		$file = fopen($filename, 'a');
		fwrite($file, $content);

		return true;
	}

	function user_logs($user_id, $module, $action, $field, $previous_val, $new_val){
		//$this->db_which();

		//
		$this->load->helper('file');
		$user = $this->db->get_where('users', array('user_id' => $user_id))->row();
        $path = 'apps/logs/users/'.$user->login.'/';
        $this->check_path( $path );
        $count = 1;
        $file_count = str_pad($count, 3, "0", STR_PAD_LEFT);
        $current_date= date('Y-m-d');
        $filename = $path.$current_date."-".$file_count.".txt";

		$content = "";
		$file_size = 0;

        if (file_exists($filename)) {
		    $file_size = filesize( $filename );
			// if($file_size > 0){
				// $content = "\r\n";
				// if($file_size >= 10000){ //1mb
					$log_files = scandir($path);
					$max_count = '001';
					foreach($log_files as $filelog){
						if(substr($filelog,0,10) == $current_date){
							$logcount = substr($filelog, 11, 3);
							if($logcount > $max_count){
								$max_count = $logcount;
							}
						}
					}
					$filename = $path.$current_date."-".$max_count.".txt";
				    $file_size = filesize( $filename );
					if($file_size > 0){
						$content = "\r\n";
						if($file_size >= 10000){ //1mb
							$content = "";
        					$file_count = ++$max_count;
       						$file_count = str_pad($file_count, 3, "0", STR_PAD_LEFT);
        					$filename = $path.$current_date."-".$file_count.".txt";
				  			$file = fopen($filename,"w");
							fwrite($file, '');
							fclose($file);
						}
					}
			// 	}
			// }
		} else {
  			$file = fopen($filename,"w");
			fwrite($file, '');
			fclose($file);
		}

		$content .= date("Y-m-d H:i:s");
		$content .= " --> ".$module;
		$content .= " --> ".$action;
		$content .= " --> ".$field;
		$content .= " --> ".$previous_val;
		$content .= " --> ".$new_val;

		$file = fopen($filename, 'a');
		fwrite($file, $content);
		return true;
	}

	function check_within_cutoff($value='', $date_from='', $date_to='', $company_id=''){

    	$current_day = date('Y-m-d');
    	$this->db->where('deleted',0);

    	if ($company_id != ''){
    		$this->db->where("company_id IN ($company_id)", '', false);    		
    	}

        $this->db->where('(\'' . date('Y-m-d',strtotime($current_day)) . '\' BETWEEN date_from AND cutoff)', '', false);
        $result_timekeeping_period = $this->db->get('time_period');  


        if ($result_timekeeping_period && $result_timekeeping_period->num_rows() > 0){
		    $row_period = $result_timekeeping_period->row();
		    //return $row_period->cutoff;
		    $date_from = date('Y-m-d', strtotime($date_from));
		    $date_to = date('Y-m-d', strtotime($date_to));

		    if  ($date_from >= $row_period->date_from)
		    {
		    	return true;
		    }
		    else
		    {
		    	if ($date_from >= $current_day){
		    		return true;
		    	}
		    	else{
		      		return false;  
		      	}
		    }
		}
		else{
			if ($date_to <= $current_day){
				return true;
			}
			else{
				return false;
			}
		}	
    }

    function get_immediate($user_id = false){
    	$reports_to = '';
    	if ($user_id){
			$result = $this->db->get_where( 'users_profile', array( 'user_id' => $user_id ) );   
			if ($result && $result->num_rows() > 0){
				$row = $result->row();
				$reports_to = $row->reports_to_id;
			}
    	}

    	return $reports_to;
    }

    function notify($notify_status = '',$notify_user_id = '',$message_type = '',$url = '',$records_id = 0,$feed_message = ''){
		$notified = array();

		$insert = array(
			'status' => 'info',
			'message_type' => $message_type,
			'user_id' => $notify_user_id,
			'feed_content' => $feed_message,
			'recipient_id' => $notify_user_id,
			'uri' => str_replace(base_url(), '', $url).'/detail/'.$records_id
		);

		$this->db->insert('system_feeds', $insert);
		$id = $this->db->insert_id();
		$this->db->insert('system_feeds_recipient', array('id' => $id, 'user_id' => $notify_user_id));
		$notified[] = $notify_user_id;

		return $notified;    	
    }
}