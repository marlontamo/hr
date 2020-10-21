<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class appraisal_individual_planning_model extends Record
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
		$this->mod_id = 109;
		$this->mod_code = 'appraisal_individual_planning';
		$this->route = 'appraisal/individual_planning';
		$this->url = site_url('appraisal/individual_planning');
		$this->primary_key = 'planning_id';
		$this->table = 'performance_planning';
		$this->icon = 'fa-folder';
		$this->short_name = 'Individual Target Setting';
		$this->long_name  = 'Individual Target Setting';
		$this->description = '';
		$this->path = APPPATH . 'modules/appraisal_individual_planning/';

		parent::__construct();
	}

	function get_appraisee( $planning_id, $user_id )
	{
		$qry = "select a.*, b.*, c.effectivity_date, d.company, f.position, i.full_name as immediate, h.position as immediate_position
		FROM {$this->db->dbprefix}performance_planning a
		LEFT JOIN {$this->db->dbprefix}performance_planning_applicable b ON b.planning_id = a.planning_id
		LEFT JOIN partners c ON c.user_id = b.user_id
		LEFT JOIN {$this->db->dbprefix}users_profile d ON d.user_id = b.user_id
		LEFT JOIN {$this->db->dbprefix}users_company e ON e.company_id = d.company_id
		LEFT JOIN {$this->db->dbprefix}users_position f ON f.position_id = d.position_id
		LEFT JOIN {$this->db->dbprefix}users_profile g ON g.user_id = d.reports_to_id
		LEFT JOIN {$this->db->dbprefix}users_position h ON h.position_id = g.position_id
		LEFT JOIN {$this->db->dbprefix}users i ON i.user_id = d.reports_to_id
		WHERE b.planning_id = {$planning_id} AND b.user_id = {$user_id}";

		$appraisee = $this->db->query( $qry );
		return $appraisee->row();
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
		
		$qry .= " AND {$this->db->dbprefix}{$this->table}_applicable.status_id IN (6,4,11)";	
		$qry .= " AND {$this->db->dbprefix}{$this->table}_applicable.user_id = {$this->user->user_id}";	
		$qry .= ' '. $filter;
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

	function get_notes( $planning_id, $user_id )
	{
		$qry = "select a.*, b.full_name, c.photo, gettimeline(a.created_on) as timeline, d.department
		FROM {$this->db->dbprefix}performance_planning_notes a
		LEFT JOIN {$this->db->dbprefix}users b on b.user_id = a.created_by
		LEFT JOIN {$this->db->dbprefix}users_profile c on c.user_id = a.created_by
		LEFT JOIN {$this->db->dbprefix}users_department d on d.department_id = c.department_id
		WHERE a.planning_id = {$planning_id} AND a.user_id = {$user_id}
		ORDER BY a.created_on DESC";

		return $this->db->query( $qry )->result();
	}

	function get_approver( $planning_id, $user_id, $approver_id )
	{
		$where = array(
			'planning_id' => $planning_id,
			'user_id' => $user_id,
			'approver_id' => $approver_id
		);

		$this->db->limit(1);
		$approver = $this->db->get_where('performance_planning_approver', $where);
		if($approver->num_rows() == 1)
			return $approver->row();
		else
			return false;
	}
}