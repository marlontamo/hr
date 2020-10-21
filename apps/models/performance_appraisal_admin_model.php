<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class performance_appraisal_admin_model extends Record
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
		$this->mod_id = 114;
		$this->mod_code = 'performance_appraisal_admin';
		$this->route = 'appraisal/performance_appraisal_admin';
		$this->url = site_url('appraisal/performance_appraisal_admin');
		$this->primary_key = 'appraisal_id';
		$this->table = 'performance_appraisal';
		$this->icon = 'fa-folder';
		$this->short_name = 'Performance Appraisal Admin';
		$this->long_name  = 'Performance Appraisal Admin ';
		$this->description = '';
		$this->path = APPPATH . 'modules/performance_appraisal_admin/';

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
		
		// $qry .= " AND {$this->db->dbprefix}{$this->table}.planning_id = {$this->user->user_id}";	
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

}