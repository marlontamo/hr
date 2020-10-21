<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class performance_planning_admin_model extends Record
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
		$this->mod_id = 110;
		$this->mod_code = 'performance_planning_admin';
		$this->route = 'appraisal/performance_planning_admin';
		$this->url = site_url('appraisal/performance_planning_admin');
		$this->primary_key = 'planning_id';
		$this->table = 'performance_planning';
		$this->icon = 'fa-folder';
		$this->short_name = 'Performance Planning Admin';
		$this->long_name  = 'Performance Planning Admin';
		$this->description = '';
		$this->path = APPPATH . 'modules/performance_planning_admin/';

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
		
		$qry .= " AND ww_performance_planning_applicable.status_id IS NOT NULL ";

		// $qry .= " AND {$this->db->dbprefix}{$this->table}.planning_id = {$this->user->user_id}";	
		$qry .= ' '. $filter;
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

	function _delete_planning( $record_id, $user_id )
	{
		$this->response = new stdClass();
		
		$where = array(
			'planning_id' => $record_id,
			'user_id' => $user_id
		);
		$delete_from = array(
			'performance_planning_applicable',
			'performance_planning_applicable_fields',
			'performance_planning_applicable_items',
			'performance_planning_approver',
			'performance_planning_crowdsource',
			'performance_planning_logs',
			'performance_planning_notes',
		);

		$this->db->trans_begin();
		$error = false;
		foreach( $delete_from as $table )
		{
			$this->db->delete($table, $where);
			if( $this->db->_error_message() != "" ){
				$this->response->message[] = array(
					'message' => $this->db->_error_message(),
					'type' => 'error'
				);
				$error = true;
			}
		}
		
		if( !$error ){
			$this->db->trans_commit();
			$this->response->message[] = array(
				'message' => lang('common.delete_record', $this->db->affected_rows()),
				'type' => 'success'
			);
		}
		else{
			$this->db->trans_rollback();
		}
		
		return $this->response;
	}
}