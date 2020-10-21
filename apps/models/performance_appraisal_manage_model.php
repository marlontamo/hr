<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class performance_appraisal_manage_model extends Record
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
		$this->mod_id = 112;
		$this->mod_code = 'performance_appraisal_manage';
		$this->route = 'performance/appraisal_manage';
		$this->url = site_url('performance/appraisal_manage');
		$this->primary_key = 'appraisal_id';
		$this->table = 'performance_appraisal';
		$this->icon = 'fa-folder';
		$this->short_name = 'Performance Appraisal Management';
		$this->long_name  = 'Performance Appraisal Management';
		$this->description = '';
		$this->path = APPPATH . 'modules/performance_appraisal_manage/';

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
		
		$qry .= " AND ({$this->db->dbprefix}{$this->table}.planning_created_by = {$this->user->user_id} OR T6.approver_id = {$this->user->user_id})";	
		$qry .= ' '. $filter;
		$qry .= " GROUP BY {$this->db->dbprefix}{$this->table}.appraisal_id";
		$qry .= " ORDER BY {$this->db->dbprefix}{$this->table}.{$this->primary_key} DESC ";
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

	public function get_department($user_id=0, $appraisal_id=0){
		$data = array();	
		
		$qry = " SELECT 
				up.department_id, 
				ud.department 
				FROM {$this->db->dbprefix}performance_appraisal_approver ppap
				JOIN users_profile up ON ppap.user_id = up.user_id
				JOIN {$this->db->dbprefix}users_department ud ON up.department_id = ud.department_id "
				;

		$qry .= " WHERE approver_id = {$user_id}
					AND ppap.appraisal_id = {$appraisal_id} ";
		$qry .= " GROUP BY up.department_id ";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data['department'][$row['department_id']]['name'] = $row['department'];
				$data['department'][$row['department_id']]['users'] = '';
				$data['department'][$row['department_id']]['status_count'] = '';
				$data['users'][$row['department_id']] = $this->get_appraise_users($row['department_id'], $appraisal_id, $user_id);
				$data['status'][$row['department_id']] = $this->get_statuses($row['department_id'], $appraisal_id, $user_id);
				// $data['department'][$row['department_id']]['users'] = $this->get_appraise_users($row['department_id'], $appraisal_id, $user_id);
			}
		}
		return $data;
	}

	public function get_appraise_users($department_id=0, $appraisal_id=0, $user_id=0){
		$data = array();	
		
		$qry = " SELECT 
				up.user_id, 
				up.display_name as fullname, up.photo,
				ppa.status_id, ps.performance_status, upos.position
				FROM {$this->db->dbprefix}performance_appraisal_approver ppap
				JOIN {$this->db->dbprefix}performance_appraisal_applicable ppa
				ON ppap.user_id = ppa.user_id AND ppa.appraisal_id = {$appraisal_id}
				JOIN users_profile up ON ppap.user_id = up.user_id
				LEFT JOIN users_position upos ON upos.position_id = up.position_id
				LEFT JOIN {$this->db->dbprefix}performance_status ps ON ps.performance_status_id = ppa.status_id
				JOIN {$this->db->dbprefix}users_department ud 
				ON up.department_id = ud.department_id "
				;

		$qry .= " WHERE approver_id = {$user_id}
					AND ppap.appraisal_id = {$appraisal_id}
					AND up.department_id = {$department_id} ";
		// $qry .= " GROUP BY up.department_id ";

		// echo "<pre>";print_r($qry);exit();
		$result = $this->db->query( $qry );

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[$row['user_id']]['name'] = $row['fullname'];
				$data[$row['user_id']]['status_id'] = $row['status_id'];
				$data[$row['user_id']]['status'] = $row['performance_status'];
				$data[$row['user_id']]['position'] = $row['position'];
				$data[$row['user_id']]['photo'] = $row['photo'];
			}
		}
		return $data;
	}

	public function get_statuses($department_id=0, $appraisal_id=0, $user_id=0){
		$data = array();	
		
		$qry = " SELECT 
				ppa.status_id, ps.performance_status
				FROM {$this->db->dbprefix}performance_appraisal_approver ppap
				JOIN {$this->db->dbprefix}performance_appraisal_applicable ppa ON ppap.user_id = ppa.user_id AND ppa.appraisal_id = {$appraisal_id}
				JOIN {$this->db->dbprefix}performance_status ps on ps.performance_status_id = ppa.status_id 
				JOIN users_profile up ON ppap.user_id = up.user_id
				JOIN {$this->db->dbprefix}users_department ud ON up.department_id = ud.department_id ";

		$qry .= " WHERE approver_id = {$user_id}
					AND ppap.appraisal_id = {$appraisal_id}
					AND up.department_id = {$department_id} ";
		$qry .= " GROUP BY ppa.status_id ";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data['status'][] = $row['status_id'];
				$data['status_label'][] = $row['performance_status'];
				$data['status_count'][] = $this->get_status_count($department_id, $appraisal_id, $user_id, $row['status_id']);
			}
		}
		return $data;
	}

	public function get_status_count($department_id=0, $appraisal_id=0, $user_id=0, $status_id=0){
		$data = array();	
		
		$qry = " SELECT 
				COUNT(*) as status_count
				FROM {$this->db->dbprefix}performance_appraisal_approver ppap
				JOIN {$this->db->dbprefix}performance_appraisal_applicable ppa
				ON ppap.user_id = ppa.user_id AND ppa.appraisal_id = {$appraisal_id}
				JOIN users_profile up ON ppap.user_id = up.user_id
				JOIN {$this->db->dbprefix}users_department ud 
				ON up.department_id = ud.department_id "
				;

		$qry .= " WHERE approver_id = {$user_id}
					AND ppap.appraisal_id = {$appraisal_id}
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

	public function filter_status($department_id=0, $appraisal_id=0, $user_id=0, $status_id=0){
		$data = array();
		
		$qry = " SELECT 
				up.user_id, 
				CONCAT(up.firstname, ' ', up.lastname) as fullname,
				ppa.status_id
				FROM {$this->db->dbprefix}performance_appraisal_approver ppap
				JOIN {$this->db->dbprefix}performance_appraisal_applicable ppa
				ON ppap.user_id = ppa.user_id AND ppa.appraisal_id = {$appraisal_id}
				JOIN users_profile up ON ppap.user_id = up.user_id
				JOIN {$this->db->dbprefix}users_department ud 
				ON up.department_id = ud.department_id "
				;

		$qry .= " WHERE approver_id = {$user_id}
					AND ppap.appraisal_id = {$appraisal_id}
					AND up.department_id = {$department_id}  ";
		if(is_numeric($status_id)){
			$qry .= " AND ppa.status_id = {$status_id} ";
		}
		// $qry .= " GROUP BY up.department_id ";

		// echo "<pre>";print_r($qry);exit();
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

	function get_appraisee( $appraisal_id, $user_id )
	{
		$qry = "select k.selfrate_date, a.*, a.status_id as period_status, b.*, c.effectivity_date, d.company, f.position, i.full_name as immediate, h.position as immediate_position, j.set_crowdsource_by
		FROM {$this->db->dbprefix}performance_appraisal a
		LEFT JOIN {$this->db->dbprefix}performance_appraisal_applicable b ON b.appraisal_id = a.appraisal_id
		LEFT JOIN {$this->db->dbprefix}performance_appraisal_applicable_user k ON k.appraisal_id = a.appraisal_id AND b.user_id = k.user_id
		LEFT JOIN partners c ON c.user_id = b.user_id
		LEFT JOIN {$this->db->dbprefix}users_profile d ON d.user_id = b.user_id
		LEFT JOIN {$this->db->dbprefix}users_company e ON e.company_id = d.company_id
		LEFT JOIN {$this->db->dbprefix}users_position f ON f.position_id = d.position_id
		LEFT JOIN {$this->db->dbprefix}users_profile g ON g.user_id = d.reports_to_id
		LEFT JOIN {$this->db->dbprefix}users_position h ON h.position_id = g.position_id
		LEFT JOIN {$this->db->dbprefix}users i ON i.user_id = d.reports_to_id
		LEFT JOIN {$this->db->dbprefix}performance_template j ON j.template_id = b.template_id
		WHERE b.appraisal_id = {$appraisal_id} AND b.user_id = {$user_id}";

		$appraisee = $this->db->query( $qry );
		return $appraisee->row();
	}

	function get_approver( $appraisal_id, $user_id, $approver_id )
	{
		$where = array(
			'appraisal_id' => $appraisal_id,
			'user_id' => $user_id,
			'approver_id' => $approver_id
		);

		$this->db->limit(1);
		$approver = $this->db->get_where('performance_appraisal_approver', $where);
		if($approver->num_rows() == 1)
			return $approver->row();
		else
			return false;
	}

	function get_self_review( $appraisal_id, $user_id )
	{
		$this->db->limit(1);
		$where = array(
			'appraisal_id' => $appraisal_id,
			'user_id' => $user_id
		);
		$res = $this->db->get_where('performance_appraisal_self_review', $where);
		if( $res->num_rows() == 1 )
			return $res->row();
		else{
			$res = new stdClass();
			$res->accomplishments = "";
			$res->evidences = "";
			$res->areas_to_improve = "";
			$res->items_to_address = "";
			return $res;
		}
	}
}