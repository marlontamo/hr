<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class training_revalida_participants_model extends Record
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
		$this->mod_id = 250;
		$this->mod_code = 'training_revalida_participants';
		$this->route = 'training/training_revalida_participants';
		$this->url = site_url('training/training_revalida_participants');
		$this->primary_key = 'training_revalida_id';
		$this->table = 'training_revalida';
		$this->icon = '';
		$this->short_name = 'Training Revalida Participants';
		$this->long_name  = 'Training Revalida Participants';
		$this->description = '';
		$this->path = APPPATH . 'modules/training_revalida_participants/';

		parent::__construct();
	}

	function _get_list($start, $limit, $search, $filter, $trash = false, $calendar_id)
	{
		$data = array();				
		
		$qry = $this->_get_list_cached_query();

		if( $trash )
		{
			$qry .= " WHERE {$this->db->dbprefix}{$this->table}.deleted = 1";
		}
		else{
			$qry .= " WHERE {$this->db->dbprefix}{$this->table}.deleted = 0";	
		}

		$qry .= " AND {$this->db->dbprefix}{$this->table}.training_calendar_id = {$calendar_id}";	
		
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
}