<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class performance_appraisal_contributor_model extends Record
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
		$this->mod_id = 115;
		$this->mod_code = 'performance_appraisal_contributor';
		$this->route = 'appraisal/contributor';
		$this->url = site_url('appraisal/contributor');
		$this->primary_key = 'appraisal_id';
		$this->table = 'performance_appraisal';
		$this->icon = 'fa-folder';
		$this->short_name = 'Crowdsourced Feedback Requests';
		$this->long_name  = 'Crowdsourced Feedback Requests';
		$this->description = '';
		$this->path = APPPATH . 'modules/performance_appraisal_contributor/';

		parent::__construct();
	}

	function get_appraisee( $appraisal_id, $user_id, $contributor_id )
	{
		$qry = "select a.*, a.status_id as period_status, b.*, j.template_id, c.alias as fullname, c.effectivity_date, d.company, f.position, i.full_name as immediate, h.position as immediate_position
		FROM {$this->db->dbprefix}performance_appraisal a
		LEFT JOIN {$this->db->dbprefix}performance_appraisal_contributor b ON b.appraisal_id = a.appraisal_id
		LEFT JOIN {$this->db->dbprefix}performance_appraisal_applicable j ON j.appraisal_id = a.appraisal_id and b.user_id = j.user_id
		LEFT JOIN partners c ON c.user_id = b.user_id
		LEFT JOIN {$this->db->dbprefix}users_profile d ON d.user_id = b.user_id
		LEFT JOIN {$this->db->dbprefix}users_company e ON e.company_id = d.company_id
		LEFT JOIN {$this->db->dbprefix}users_position f ON f.position_id = d.position_id
		LEFT JOIN {$this->db->dbprefix}users_profile g ON g.user_id = d.reports_to_id
		LEFT JOIN {$this->db->dbprefix}users_position h ON h.position_id = g.position_id
		LEFT JOIN {$this->db->dbprefix}users i ON i.user_id = d.reports_to_id
		WHERE b.appraisal_id = {$appraisal_id} AND b.user_id = {$user_id} and b.contributor_id = {$contributor_id}";


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
		
		$qry .= " AND {$this->db->dbprefix}performance_appraisal_contributor.finalized = 1";
		$qry .= " AND {$this->db->dbprefix}performance_appraisal_contributor.contributor_id = {$this->user->user_id}";	
		$qry .= " AND {$this->db->dbprefix}performance_appraisal_contributor.contributor_id > 0 ";
		$qry .= " GROUP BY {$this->db->dbprefix}performance_appraisal_contributor.user_id, {$this->db->dbprefix}{$this->table}.{$this->primary_key}";
		$qry .= " ORDER BY {$this->db->dbprefix}{$this->table}.{$this->primary_key} DESC ";
		// $qry .= ' '. $filter;
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);
		// echo "<pre>"; echo $qry;
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