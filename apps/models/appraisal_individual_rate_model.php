<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class appraisal_individual_rate_model extends Record
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
		$this->mod_id = 116;
		$this->mod_code = 'appraisal_individual_rate';
		$this->route = 'appraisal/individual_rate';
		$this->url = site_url('appraisal/individual_rate');
		$this->primary_key = 'appraisal_id';
		$this->table = 'performance_appraisal';
		$this->icon = 'fa-folder';
		$this->short_name = 'Individual Performance Appraisals';
		$this->long_name  = 'Individual Performance Appraisals';
		$this->description = '';
		$this->path = APPPATH . 'modules/appraisal_individual_rate/';

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

	function get_observations( $year, $user_id )
	{
		$qry = "SELECT sf.*, sf.display_name AS full_name, up.photo, gettimeline(sf.createdon) as timeline, ud.department
				FROM {$this->db->dbprefix}system_feeds sf 
				LEFT JOIN {$this->db->dbprefix}system_feeds_recipient sfr ON sf.id = sfr.id 
				LEFT JOIN {$this->db->dbprefix}users_profile up ON up.user_id = sf.user_id 
				LEFT JOIN {$this->db->dbprefix}users_department ud on ud.department_id = up.department_id 
				WHERE sf.message_type = 'Feedback' 
				AND sfr.user_id = {$user_id} AND sf.user_id != {$user_id} 
				AND YEAR(sf.createdon) BETWEEN '{$year}' AND '{$year}' 
				ORDER BY sf.createdon DESC";

		// echo "<pre>"; echo $qry;
		return $this->db->query( $qry )->result();
	}

	function get_appraisee( $appraisal_id, $user_id )
	{
		$qry = "select a.*, a.status_id as period_status, j.*, c.effectivity_date, d.company, f.position, i.full_name as immediate, h.position as immediate_position
		FROM {$this->db->dbprefix}performance_appraisal a
		LEFT JOIN {$this->db->dbprefix}performance_appraisal_applicable j ON j.appraisal_id = a.appraisal_id
		LEFT JOIN partners c ON c.user_id = j.user_id
		LEFT JOIN {$this->db->dbprefix}users_profile d ON d.user_id = j.user_id
		LEFT JOIN {$this->db->dbprefix}users_company e ON e.company_id = d.company_id
		LEFT JOIN {$this->db->dbprefix}users_position f ON f.position_id = d.position_id
		LEFT JOIN {$this->db->dbprefix}users_profile g ON g.user_id = d.reports_to_id
		LEFT JOIN {$this->db->dbprefix}users_position h ON h.position_id = g.position_id
		LEFT JOIN {$this->db->dbprefix}users i ON i.user_id = d.reports_to_id
		WHERE a.appraisal_id = {$appraisal_id} AND j.user_id = {$user_id}";

		$appraisee = $this->db->query( $qry );
		return $appraisee->row();
	}

	function get_cs_discussion( $appraisal_id, $section_id, $user_id, $contributor_id )
	{
		if( empty($contributor_id) )
		{
			//get hr
			$contributors = $this->db->get_where('performance_appraisal_contributor', array('user_id' => $user_id));
			$cs_list = array();
			foreach( $contributors->result() as $cs)
			{
				$cs_list[$cs->contributor_id] = $cs->contributor_id;
			}
			$cs_list = implode(',', $cs_list);
			$contributor_id = " not in ({$cs_list})";
		}
		else{
			$contributor_id = " = {$contributor_id}";
		}

		if( !empty($section_id) )
		{
			$section_id = "AND (a.section_id = {$section_id} OR a.section_id IS NULL)";
		}

		$qry = "select a.*, gettimeline(a.created_on) as created_on, b.full_name, c.photo, d.department
		FROM {$this->db->dbprefix}performance_appraisal_contributor_notes a 
		LEFT JOIN {$this->db->dbprefix}users b on b.user_id = a.created_by
		LEFT JOIN {$this->db->dbprefix}users_profile c ON c.user_id = a.created_by
		LEFT JOIN {$this->db->dbprefix}users_department d on d.department_id = c.department_id
		WHERE a.appraisal_id = {$appraisal_id} AND a.user_id = {$user_id} AND
		( 
			(a.note_to = {$user_id} AND a.created_by {$contributor_id} )
			OR
			(a.note_to {$contributor_id} AND a.created_by = {$user_id} )
		)
		{$section_id}
		ORDER BY a.created_on DESC";

		$res = $this->db->query($qry);
		if( $res->num_rows() > 0 )
			return $res->result();
		else
			return false;
	}
}
