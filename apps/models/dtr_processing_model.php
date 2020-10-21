<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class dtr_processing_model extends Record
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
	
	private $response;

	public function __construct()
	{
		$this->mod_id = 29;
		$this->mod_code = 'dtr_processing';
		$this->route = 'dtr_processing';
		$this->url = site_url('dtr_processing');
		$this->primary_key = 'period_id';
		$this->table = 'time_period';
		$this->icon = 'fa-clock-o';
		$this->short_name = 'Processing';
		$this->long_name  = 'Timesheet Processing';
		$this->description = 'calculation of time records';
		$this->path = APPPATH . 'modules/dtr_processing/';

		$this->response = new stdClass();
		parent::__construct();
	}

	function getUsersTagList(){

		$data = array();

		$qry_category = $this->get_role_category('users_profile');

		$qry = "SELECT u.user_id AS value, u.full_name AS label FROM users u
				JOIN partners p ON u.user_id = p.user_id 
				JOIN users_profile ON p.user_id = users_profile.user_id";

		//$qry .= " WHERE u.active = '1'";

		if ($qry_category != ''){
			$qry .= ' AND ' . $qry_category;
		}

		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$row['label'] = trim($row['label']);
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;			
	}

	function _get_applied_to_options( $record_id, $mark_selected = false, $apply_to = "" )
	{
		if( $mark_selected )
		{
			$selected = array();
			$applied_to = $this->db->get_where('time_period_apply_to_id', array('period_id' => $record_id));
			foreach( $applied_to->result() as $row )
			{
				$selected[] = $row->apply_to_id;
			}
		}
		
		if( !empty($record_id) )
		{
			$result = $this->_get( 'edit', $record_id );
			$record = $result->row_array();
			$apply_to = $record['time_period.apply_to_id'];
		}

		// GET SENSITIVITY
		// BEGIN //
		$qry = '';
		$sensID = $this->config->config['user']['sensitivity'];
		if($sensID && !empty($sensID) ){
			$qry .= " AND p.sensitivity IN ( ".$sensID." )";
		}
		// END //

		$options = array();
		switch( $apply_to )
		{
			case 1: //employee
				$qry = "SELECT u.full_name as label, u.user_id as value
				FROM {$this->db->dbprefix}users u
				INNER JOIN {$this->db->dbprefix}payroll_partners p on p.user_id = u.user_id
				WHERE u.deleted = 0 $qry
				ORDER BY u.full_name asc";
				break;
			case 2: //status
				$qry = "SELECT employment_status as label, employment_status_id as value
				FROM {$this->db->dbprefix}partners_employment_status
				WHERE deleted = 0
				ORDER BY employment_status asc";
				break;
			case 3: //division
				$qry = "SELECT division as label, division_id as value
				FROM {$this->db->dbprefix}users_division
				WHERE deleted = 0
				ORDER BY division asc";
				break;
			case 4: //department
				$qry = "SELECT department as label, department_id as value
				FROM {$this->db->dbprefix}users_department
				WHERE deleted = 0
				ORDER BY department asc";
				break;
		}

		$lists = $this->db->query( $qry );
		if ($lists && $lists->num_rows() > 0){
			foreach( $lists->result() as $row )
			{
				if( $mark_selected && in_array($row->value, $selected) )
				{
					$options[] = '<option value="'. $row->value .'" selected>'.$row->label.'</option>';
				}
				else{
					$options[] = '<option value="'. $row->value .'">'.$row->label.'</option>';
				}	
			}
		}
		return implode('', $options);
	}

	function _get_list($start, $limit, $search, $trash = false)
	{
		$data = array();				
		

		$qry = $this->_get_list_cached_query();
		$qry .= " LIMIT $limit OFFSET $start";

		$trash = $trash ? 'true' : 'false';

		$this->db->query("select set_search('". $search ."')");
		$this->db->query("select set_trash( ".$trash." )");

		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	function _get_list_cached_query()
	{
		parent::_get_list_cached_query();
		return 'SELECT * FROM `time_period_list`';
	}

	function _get_stat_count( $record_id )
	{
		$result = $this->_get( 'edit', $record_id );
		$rec = $result->row_array();
		
		$company_id = $rec['time_period.company_id'];

		$qry = "SELECT a.status, COUNT(a.status) AS stat_count FROM `partners` a
		LEFT JOIN {$this->db->dbprefix}users_profile b ON b.user_id = a.user_id 
		WHERE b.company_id = {$company_id}
		GROUP BY a.status";
		$result = $this->db->query( $qry );
		if( $result->num_rows() > 0 )
			return $result->result();
		else
			return array();
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
							$save[$table][$column] = date('Y-m-d H:i:s', strtotime($value));
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
		$main_record['company_id'] = explode(",", $main_record['company_id']);
			$record = $this->db->get_where( $this->table, array( $this->primary_key => $this->record_id ) );
		foreach($main_record['company_id'] as $company_id){
			$main_record['company_id'] = $company_id;
			
			if($record->num_rows() == 0) {

					//add mandatory fields
					$period_where = array( 'payroll_date'=> $main_record['payroll_date']
										,'date_from'=> $main_record['date_from'] 
										,'date_to'=> $main_record['date_to']
										,'deleted'=> 0
										,'company_id'=> $main_record['company_id'] );
					$record_check = $this->db->get_where( $this->table, $period_where );

					if($record_check->num_rows() == 0){
						$main_record['created_by'] = $this->user->user_id;
						$this->db->insert($this->table, $main_record);
						if( $this->db->_error_message() == "" )
						{
							$this->response->record_id = $this->record_id = $this->db->insert_id();
						}
					}
					$this->response->action = 'insert';
			}elseif($record->num_rows() == 1){
					$main_record['modified_by'] = $this->user->user_id;
					$main_record['modified_on'] = date('Y-m-d H:i:s');
					$this->db->update( $this->table, $main_record, array( $this->primary_key => $this->record_id ) );
					$this->response->action = 'update';
			}else{
					$this->response->message[] = array(
						'message' => lang('common.inconsistent_data'),
						'type' => 'error'
					);
					$error = true;
					goto stop;
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

	public function get_previous_cutoff($company_id = null, $payroll_date = null )
	{
		$this->db->where('deleted', 0);

		if(!is_null($company_id))
		$this->db->where('company_id IN ('.$company_id.')');

		if(!is_null($payroll_date))
			$this->db->where('payroll_date <', $payroll_date);
		
		$this->db->order_by('payroll_date', 'DESC');
		$this->db->limit('1');
		$period = $this->db->get($this->table);

		if($period && $period->num_rows() > 0){
			return $period->row();
		}

		return false;
	}
}