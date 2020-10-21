<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class sms_queue_model extends Record
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
		$this->mod_id = 179;
		$this->mod_code = 'sms_queue';
		$this->route = 'admin/sms';
		$this->url = site_url('admin/sms');
		$this->primary_key = 'id';
		$this->table = 'system_sms_queue';
		$this->icon = '';
		$this->short_name = 'SMS Queue';
		$this->long_name  = 'SMS Queue';
		$this->description = '';
		$this->path = APPPATH . 'modules/sms_queue/';

		parent::__construct();
	}

		
	function _get_list($start, $limit, $search, $filter, $trash = false)
	{
		$data = array();				
		
		$qry = $this->_get_list_cached_query();
			
		$qry .= ' '. $filter;
		$qry .= ' ORDER BY timein';
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