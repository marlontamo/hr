<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class incident_manage_model extends Record
{
	var $mod_id;
	var $mod_code;
	var $route;
	var $url;
	var $primary_key;
	var $table;
	var $table_ir;
	var $icon;
	var $short_name;
	var $long_name;
	var $description;
	var $path;

	public function __construct()
	{
		$this->mod_id = 140;
		$this->mod_code = 'incident_manage';
		$this->route = 'partner/incident_manage';
		$this->url = site_url('partner/incident_manage');
		$this->primary_key = 'incident_id';
		$this->table = 'partners_incident';
		$this->table_ir = 'partners_incident_approver';
		$this->icon = '';
		$this->short_name = 'Incident Report';
		$this->long_name  = 'Incident Report';
		$this->description = '';
		$this->path = APPPATH . 'modules/incident_manage/';

		parent::__construct();
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

		/*if( $this->user->user_id != 1 )
		{
			$qry .= " AND appr.user_id = {$this->user->user_id}";
		} */
		
		switch ($this->coc_process) {
			case 'immediate':
				$qry .= " AND ime.user_id = {$this->user->user_id}";
				break;
			default:
				$qry .= " AND appr.user_id = {$this->user->user_id}";
				break;
		}
		
		$qry .= ' '. $filter;
		// $qry .= " GROUP BY {$this->db->dbprefix}{$this->table}.{$this->primary_key} ";
		$qry .= "ORDER BY {$this->db->dbprefix}{$this->table}.{$this->primary_key} desc";
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		// echo "<pre>";print_r($qry);
		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
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
		$qry = $this->parser->parse_string($qry, array('approverid' => $this->user->user_id), TRUE);

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

	public function get_incident_details($record_id=0){		
		$where = array('deleted' => 0, $this->primary_key => $record_id);
		$incident_details = $this->db->get_where($this->table, $where);
		
		return $incident_details->row_array();
	}

	function notify_approvers( $forms_id=0, $form=array())
	{
		$notified = array();

		$this->db->order_by('sequence', 'asc');
		$approvers = $this->db->get_where($this->table.'_approver', array($this->primary_key => $form[$this->primary_key], 'deleted' => 0));

		$first = true;
		foreach( $approvers->result() as $approver )
		{
			switch( $approver->condition )
			{
				case 'All':
				case 'Either Of';
					break;
				case 'By Level':
					if( !$first )
						continue;
					break;
			}
			if($this->user->user_id != $approver->user_id){
				$form_status = $form['incident_status_id'] == 6 ? "Closed" : lang('incident_manage.forwarded_hr');
				
				$offenses = $this->db->get_where('partners_offense', array('offense_id' => $form['offense_id']))->row_array();
				
				$this->load->model('incident_manage_model', 'formManage');
				//insert notification
				$insert = array(
					'status' => 'info',
					'message_type' => 'Code of Conduct',
					'user_id' => $this->user->user_id,
					'display_name' => $this->get_display_name($this->user->user_id),
					'feed_content' => $form_status.': incident report involving '.$this->get_display_name($form['involved_partners']).'.<br><br>Offense: '.$offenses['offense'],
					'recipient_id' => $approver->user_id,
					'uri' => str_replace(base_url(), '', $this->formManage->url).'/detail/'.$form[$this->primary_key]
				);
				$this->db->insert('system_feeds', $insert);
				$id = $this->db->insert_id();
				$this->db->insert('system_feeds_recipient', array('id' => $id, 'user_id' => $approver->user_id));
				$notified[] = $approver->user_id;

				$first = false;
			}
		}

		return $notified;
	}

	function notify_filer( $forms_id=0, $form=array())
	{
		$notified = array();
		$form_status = $form['incident_status_id'] == 6 ? "Closed" : lang('incident_manage.forwarded_hr');
				
		$offenses = $this->db->get_where('partners_offense', array('offense_id' => $form['offense_id']))->row_array();
		//insert notification
		$this->load->model('incident_report_model', 'incident_report');
		$insert = array(
			'status' => 'info',
			'message_type' => 'Code of Conduct',
			'user_id' => $this->user->user_id,
			'display_name' => $this->get_display_name($this->user->user_id),
			'feed_content' => $form_status.': incident report involving '.$this->get_display_name($form['involved_partners']).'.<br><br>Offense: '.$offenses['offense'],
			'recipient_id' => $form['created_by'],
			'uri' => str_replace(base_url(), '', $this->incident_report->url).'/detail/'.$form[$this->primary_key]
		);

		$this->db->insert('system_feeds', $insert);
		$id = $this->db->insert_id();
		$this->db->insert('system_feeds_recipient', array('id' => $id, 'user_id' => $form['created_by']));
		$notified[] = $form['created_by'];

		return $notified;
	}

	function notify_hr( $forms_id=0, $form=array())
	{	
		$notified = array();
		$form_status = $form['incident_status_id'] == 6 ? "Closed" : lang('incident_manage.forwarded_hr');
		$offenses = $this->db->get_where('partners_offense', array('offense_id' => $form['offense_id']))->row_array();
		$hr_admin = $this->db->get_where('users', array('role_id' => 2, 'active' => 1, 'deleted' => 0))->result_array();
		//insert notification
		$this->load->model('incident_admin_model', 'incident_admin');

		foreach($hr_admin as $hr_admin) {
			$insert = array(
				'status' => 'info',
				'message_type' => 'Code of Conduct',
				'user_id' => $this->user->user_id,
				'display_name' => $this->get_display_name($this->user->user_id),
				'feed_content' => $form_status.': incident report involving '.$this->get_display_name($form['involved_partners']).'.<br><br>Offense: '.$offenses['offense'],
				'recipient_id' => $hr_admin['user_id'],
				'uri' => str_replace(base_url(), '', $this->incident_admin->url).'/detail/'.$form[$this->primary_key]
			);

			$this->db->insert('system_feeds', $insert);
			$id = $this->db->insert_id();
			$this->db->insert('system_feeds_recipient', array('id' => $id, 'user_id' => $hr_admin['user_id']));
			$notified[] = $hr_admin['user_id'];
		}

		return $notified;
	}

	public function get_display_name($user_id=0){		
		$sql_display_name = $this->db->get_where('users', array('user_id' => $user_id));
		$display_name = $sql_display_name->row_array();
		return $display_name['display_name'];
	}

}