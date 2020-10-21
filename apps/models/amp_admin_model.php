<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class amp_admin_model extends Record
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
		$this->mod_id = 127;
		$this->mod_code = 'amp_admin';
		$this->route = 'recruitment/amp_admin';
		$this->url = site_url('recruitment/amp_admin');
		$this->primary_key = 'plan_id';
		$this->table = 'recruitment_manpower_plan';
		$this->icon = 'fa-folder';
		$this->short_name = 'Annual Manpower Planning - Admin';
		$this->long_name  = 'Annual Manpower Planning - Admin';
		$this->description = '';
		$this->path = APPPATH . 'modules/amp_admin/';

		parent::__construct();
	}

	function validate_department( $company_id, $department_id, $year )
	{
		$where = array(
			'company_id' => $company_id,
			'department_id' => $department_id,
			'year' => $year,
			'deleted' => 0
		);
		$this->db->limit(1);
		$check = $this->db->get_where( $this->table, $where );
		if( $check->num_rows() != 0 )
			return false;
		else
			return true;
	}

	function get_saved_incumbents( $plan_id )
	{
		$qry = "select a.*, c.position_id, c.position, e.employment_status
		FROM {$this->db->dbprefix}users a
		LEFT JOIN {$this->db->dbprefix}users_profile b on b.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}users_position c ON c.position_id = b.position_id
		LEFT JOIN {$this->db->dbprefix}partners d ON d.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}partners_employment_status e ON e.employment_status_id = d.status_id
		RIGHT JOIN {$this->db->dbprefix}recruitment_manpower_plan_incumbent f ON f.user_id = a.user_id
		WHERE a.deleted = 0 AND a.active = 1 AND
		f.plan_id = {$plan_id}
		GROUP BY a.user_id
		ORDER BY a.full_name";

		$users = $this->db->query( $qry );
		if( $users->num_rows() > 0 )
			return $users->result();
		else
			return false;
	}

	function get_saved_positions( $plan_id )
	{
		$qry = "select a.*, b.position_id, b.position
		FROM {$this->db->dbprefix}recruitment_manpower_plan_position a
		LEFT JOIN {$this->db->dbprefix}users_position b ON b.position_id = a.position_id
		WHERE a.deleted = 0 AND a.plan_id = {$plan_id}
		GROUP BY b.position_id
		ORDER BY b.position";

		$positions = $this->db->query( $qry );
		if( $positions->num_rows() > 0 )
			return $positions->result();
		else
			return false;
	}

	function get_incumbents( $company_id, $department_id, $position_id = "" )
	{
		$qry = "select a.*, c.position_id, c.position, e.employment_status
		FROM {$this->db->dbprefix}users a
		LEFT JOIN {$this->db->dbprefix}users_profile b on b.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}users_position c ON c.position_id = b.position_id
		LEFT JOIN {$this->db->dbprefix}partners d ON d.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}partners_employment_status e ON e.employment_status_id = d.status_id
		WHERE a.deleted = 0 AND a.active = 1 AND
		b.company_id = {$company_id} AND b.department_id = {$department_id}";
		if( !empty( $position_id ) )
			$qry .= " AND c.position_id = {$position_id}";
		$qry .= " order by a.full_name";

		$users = $this->db->query( $qry );
		if( $users->num_rows() > 0 )
			return $users->result();
		else
			return false;
	}

	function get_positions( $department_id )
	{
		$qry = "SELECT a.*, d.position_id, d.position
		FROM `{$this->db->dbprefix}users_job_family_department` a
		LEFT JOIN `{$this->db->dbprefix}users_job_family` b ON b.job_family_id = a.job_family_id
		LEFT JOIN `{$this->db->dbprefix}users_job_title` c ON c.job_family_id = b.job_family_id
		LEFT JOIN `{$this->db->dbprefix}users_position` d ON d.job_title_id = c.job_title_id
		WHERE a.department_id = {$department_id} and d.deleted = 0
		ORDER BY d.position";

		$positions = $this->db->query( $qry );
		if( $positions->num_rows() > 0 )
			return $positions->result();
		else
			return false;
	}

	function get_incumbent_plans($plan_id, $user_id, $month = false)
	{
		$qry = "select a.*, b.action, b.class
		FROM {$this->db->dbprefix}recruitment_manpower_plan_incumbent a
		LEFT JOIN {$this->db->dbprefix}recruitment_manpower_plan_action b ON B.action_id = a.action_id
		WHERE a.plan_id = {$plan_id} AND a.user_id = {$user_id}";
		if( $month )
			$qry .= " AND a.month = {$month}";
		$qry .= " ORDER BY a.month";

		$plans = $this->db->query( $qry );
		if( $plans->num_rows() > 0 )
			return $plans->result();
		else
			return false;
	}

	function get_position_plans($plan_id, $position_id, $month = false)
	{
		$qry = "select a.*
		FROM {$this->db->dbprefix}recruitment_manpower_plan_position a
		WHERE a.plan_id = {$plan_id} AND a.position_id = {$position_id}";
		if( $month )
			$qry .= " AND a.month = {$month}";
		$qry .= " ORDER BY a.month";

		$plans = $this->db->query( $qry );
		if( $plans->num_rows() > 0 )
			return $plans->result();
		else
			return false;
	}

	function get_new_position_plans($plan_id)
	{
		$qry = "select a.*
		FROM {$this->db->dbprefix}recruitment_manpower_plan_position_new a
		WHERE a.plan_id = {$plan_id}
		ORDER BY a.month";
		$plans = $this->db->query( $qry );
		if( $plans->num_rows() > 0 )
			return $plans->result();
		else
			return false;
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
		$qry .= " ORDER BY {$this->db->dbprefix}{$this->table}.created_on DESC ";
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
}