<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class performance_planning_manage_model extends Record
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
		$this->mod_id = 108;
		$this->mod_code = 'performance_planning_manage';
		$this->route = 'appraisal/planning_manage';
		$this->url = site_url('appraisal/planning_manage');
		$this->primary_key = 'planning_id';
		$this->table = 'performance_planning';
		$this->icon = 'fa-folder';
		$this->short_name = 'Target Management';
		$this->long_name  = 'Target Management';
		$this->description = '';
		$this->path = APPPATH . 'modules/performance_planning_manage/';

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
		
		$qry .= " AND ({$this->db->dbprefix}{$this->table}.created_by = {$this->user->user_id} OR T6.approver_id = {$this->user->user_id})";	

		$qry .= ' '. $filter;
		$qry .= " GROUP BY {$this->db->dbprefix}{$this->table}.{$this->primary_key}";
		$qry .= " ORDER BY {$this->db->dbprefix}{$this->table}.{$this->primary_key} DESC";
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

	public function get_department($user_id=0, $planning_id=0){
		$data = array();	
		
		$qry = " SELECT 
				up.department_id, 
				ud.department 
				FROM {$this->db->dbprefix}performance_planning_approver ppap
				JOIN users_profile up ON ppap.user_id = up.user_id
				JOIN {$this->db->dbprefix}users_department ud ON up.department_id = ud.department_id "
				;

		$qry .= " WHERE approver_id = {$user_id}
					AND ppap.planning_id = {$planning_id} ";
		$qry .= " GROUP BY up.department_id ";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data['department'][$row['department_id']]['name'] = $row['department'];
				$data['department'][$row['department_id']]['users'] = '';
				$data['department'][$row['department_id']]['status_count'] = '';
				$data['users'][$row['department_id']] = $this->get_plan_users($row['department_id'], $planning_id, $user_id);
				$data['status'][$row['department_id']] = $this->get_statuses($row['department_id'], $planning_id, $user_id);
				// $data['department'][$row['department_id']]['users'] = $this->get_plan_users($row['department_id'], $planning_id, $user_id);
			}
		}
		return $data;
	}

	public function get_plan_users($department_id=0, $planning_id=0, $user_id=0){
		$data = array();	
		
		$qry = " SELECT 
				up.user_id, 
				CONCAT(up.firstname, ' ', up.lastname) as fullname,
				ppa.status_id
				FROM {$this->db->dbprefix}performance_planning_approver ppap
				JOIN {$this->db->dbprefix}performance_planning_applicable ppa
				ON ppap.user_id = ppa.user_id AND ppa.planning_id = {$planning_id}
				JOIN users_profile up ON ppap.user_id = up.user_id
				JOIN {$this->db->dbprefix}users_department ud 
				ON up.department_id = ud.department_id "
				;

		$qry .= " WHERE approver_id = {$user_id}
					AND ppap.planning_id = {$planning_id}
					AND up.department_id = {$department_id} ";
		$qry .= " GROUP BY ppap.user_id ";

					// exit();
		$result = $this->db->query( $qry );

		if($result->num_rows() > 0)
		{
			foreach($result->result_array() as $row){
				$data[$row['user_id']]['name'] = $row['fullname'];
				$data[$row['user_id']]['status_id'] = $row['status_id'];
			}
		}
		return $data;
	}

	public function get_statuses($department_id=0, $planning_id=0, $user_id=0){
		$data = array();	
		
		$qry = " SELECT 
				ppa.status_id
				FROM {$this->db->dbprefix}performance_planning_approver ppap
				JOIN {$this->db->dbprefix}performance_planning_applicable ppa
				ON ppap.user_id = ppa.user_id AND ppa.planning_id = {$planning_id}
				JOIN users_profile up ON ppap.user_id = up.user_id
				JOIN {$this->db->dbprefix}users_department ud 
				ON up.department_id = ud.department_id "
				;

		$qry .= " WHERE approver_id = {$user_id}
					AND ppap.planning_id = {$planning_id}
					AND up.department_id = {$department_id} ";
		$qry .= " GROUP BY ppa.status_id ";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data['status'][] = $row['status_id'];
				$data['status_count'][] = $this->get_status_count($department_id, $planning_id, $user_id, $row['status_id']);
			}
		}
		return $data;
	}

	public function get_status_count($department_id=0, $planning_id=0, $user_id=0, $status_id=0){
		$data = array();	
		
		$qry = " SELECT 
				COUNT(*) as status_count
				FROM {$this->db->dbprefix}performance_planning_approver ppap
				JOIN {$this->db->dbprefix}performance_planning_applicable ppa
				ON ppap.user_id = ppa.user_id AND ppa.planning_id = {$planning_id}
				JOIN users_profile up ON ppap.user_id = up.user_id
				JOIN {$this->db->dbprefix}users_department ud 
				ON up.department_id = ud.department_id "
				;

		$qry .= " WHERE approver_id = {$user_id}
					AND ppap.planning_id = {$planning_id}
					AND up.department_id = {$department_id}
					AND ppa.status_id = {$status_id} ";
		// $qry .= " GROUP BY ppa.status_id ";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data = $row['status_count'];
			}
		}
		return $data;
	}

	public function filter_status($department_id=0, $planning_id=0, $user_id=0, $status_id=0){
		$data = array();
		
		$qry = " SELECT 
				up.user_id, 
				CONCAT(up.firstname, ' ', up.lastname) as fullname,
				ppa.status_id
				FROM {$this->db->dbprefix}performance_planning_approver ppap
				JOIN {$this->db->dbprefix}performance_planning_applicable ppa
				ON ppap.user_id = ppa.user_id AND ppa.planning_id = {$planning_id}
				JOIN users_profile up ON ppap.user_id = up.user_id
				JOIN {$this->db->dbprefix}users_department ud 
				ON up.department_id = ud.department_id "
				;

		$qry .= " WHERE approver_id = {$user_id}
					AND ppap.planning_id = {$planning_id}
					AND up.department_id = {$department_id}  ";
		if(is_numeric($status_id)){
			$qry .= " AND ppa.status_id = {$status_id} ";
		}
		$qry .= " GROUP BY ppap.user_id ";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[$row['user_id']]['name'] = $row['fullname'];
				$data[$row['user_id']]['status_id'] = $row['status_id'];
			}
		}
		return $data;
	}
}