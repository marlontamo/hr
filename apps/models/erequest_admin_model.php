<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class erequest_admin_model extends Record
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
		$this->mod_id = 145;
		$this->mod_code = 'erequest_admin';
		$this->route = 'partner/erequest_admin';
		$this->url = site_url('partner/erequest_admin');
		$this->primary_key = 'request_id';
		$this->table = 'resources_request';
		$this->icon = '';
		$this->short_name = 'Online Request Admin';
		$this->long_name  = 'Online Request Admin';
		$this->description = '';
		$this->path = APPPATH . 'modules/erequest_admin/';

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

		if( $this->user->user_id != 1 )
		{
			$qry .= " AND appr.user_id = {$this->user->user_id}";
		}
		
		$qry .= ' '. $filter;
		$qry .= " GROUP BY {$this->db->dbprefix}{$this->table}.{$this->primary_key} ";
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );
		// echo "<pre>";print_r($qry);
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	function get_notes( $request_id, $user_id )
	{
		$qry = "select a.*, b.full_name, c.photo, gettimeline(a.created_on) as timeline, d.department
		FROM {$this->db->dbprefix}resources_request_notes a
		LEFT JOIN {$this->db->dbprefix}users b on b.user_id = a.created_by
		LEFT JOIN {$this->db->dbprefix}users_profile c on c.user_id = a.created_by
		LEFT JOIN {$this->db->dbprefix}users_department d on d.department_id = c.department_id
		WHERE a.request_id = {$request_id}
		ORDER BY a.created_on DESC";

		// echo "<pre>";print_r($qry);exit();
		return $this->db->query( $qry )->result();
	}

	function email_erequest($record_id=0){
		$erequest_data = $this->db->get_where( $this->table, array( $this->primary_key => $record_id) )->row_array();	
	 	
	 	$erequest_data['date_needed'] = date('F d, Y', strtotime($erequest_data['date_needed']));
		$erequest_data['system_url'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'URL' LIMIT  1")->row_array();
    	$erequest_data['system_title'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'application_title' LIMIT  1")->row_array();
    	$erequest_data['system_author'] = $this->db->query("SELECT value FROM {$this->db->dbprefix}config WHERE `key` = 'author' LIMIT  1")->row_array();
		
		$ereq_template = $this->db->get_where( 'system_template', array( 'code' => 'EREQ') )->row_array();	
	
		// $users[] = $erequest_data['user_id'];
		$users = array();
		if($erequest_data['notify_immediate'] > 0){
			$users[] =  $erequest_data['notify_immediate']; 
		}
		if($erequest_data['notify_others'] > 0){
			$users =  array_merge($users, explode(',', $erequest_data['notify_others'])); 
		}
		// print_r($users);
		if(count($users) > 0){
			foreach($users as $uid){
				$sql_display_name = $this->db->get_where('users', array('user_id' => $uid))->row_array();
				$erequest_data['employee_name'] = $sql_display_name['display_name'];

				$this->load->library('parser');
				$this->parser->set_delimiters('{{', '}}');
				$msg = $this->parser->parse_string($ereq_template['body'], $erequest_data, TRUE);
				
				$this->db->query("INSERT INTO {$this->db->dbprefix}system_email_queue (`to`, `subject`, body)
				         VALUES('{$sql_display_name['email']}', '{$ereq_template['subject']}', '{$msg}') ");
				
				if( $this->db->_error_message() != "" ){
					return $this->db->_error_message();
				}
			}
		}
		return true;
	}

}