<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class position_model extends Record
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
		$this->mod_id = 33;
		$this->mod_code = 'position';
		$this->route = 'admin/user/position';
		$this->url = site_url('admin/user/position');
		$this->primary_key = 'position_id';
		$this->table = 'users_position';
		$this->icon = '';
		$this->short_name = 'Position';
		$this->long_name  = 'Position';
		$this->description = '';
		$this->path = APPPATH . 'modules/position/';

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
		
		$qry .= ' '. $filter;
		$qry .= " ORDER BY {$this->db->dbprefix}{$this->table}.position_code DESC ";
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

	public function get_user_details($user_id=0)
	{
		$this->db->join('users_profile','users_profile.user_id = users.user_id','left');
		$this->db->join('users_position','users_position.position_id = users_profile.position_id','left');
		$this->db->where('users.user_id',$user_id);
		$user_details = $this->db->get('users');
	    return $user_details->row();
	}
}