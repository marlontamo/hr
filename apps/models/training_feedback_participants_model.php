<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class training_feedback_participants_model extends Record
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
		$this->mod_id = 249;
		$this->mod_code = 'training_feedback_participants';
		$this->route = 'training/training_feedback_participants';
		$this->url = site_url('training/training_feedback_participants');
		$this->primary_key = 'feedback_id';
		$this->table = 'training_feedback';
		$this->icon = '';
		$this->short_name = 'Training Feedback Participants';
		$this->long_name  = 'Training Feedback Participants';
		$this->description = '';
		$this->path = APPPATH . 'modules/training_feedback_participants/';

		parent::__construct();
	}

	function _get_list($start, $limit, $search, $filter, $trash = false, $calendar_id)
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

		$qry .= " AND {$this->db->dbprefix}{$this->table}.training_calendar_id = {$calendar_id}";	
		
		$qry .= ' '. $filter;
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);
		// debug($qry); die;
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