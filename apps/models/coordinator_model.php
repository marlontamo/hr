<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class coordinator_model extends Record
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
		$this->mod_id = 253;
		$this->mod_code = 'coordinator';
		$this->route = 'admin/time/coordinator';
		$this->url = site_url('admin/time/coordinator');
		$this->primary_key = 'coordinator_id';
		$this->table = 'users_coordinator';
		$this->icon = '';
		$this->short_name = 'Coordinator';
		$this->long_name  = 'Coordinator';
		$this->description = '';
		$this->path = APPPATH . 'modules/coordinator/';

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
		
		$qry .= ' GROUP BY coordinator_id';
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

	function get_user_list($branch_id = false,$company_id = false){

		$cdate = date('Y-m-d');

		if ($branch_id){
			$this->db->where('users_profile.branch_id',$branch_id);
		}

		if ($company_id){
			$this->db->where('users_profile.company_id',$company_id);
		}

		$this->db->where('users.deleted',0);
		$this->db->where('resigned_date','0000-00-00');
		$this->db->where('resigned_date <=',$cdate);
		$this->db->join('partners','users.user_id = partners.user_id');
		$this->db->join('users_profile','users.user_id = users_profile.user_id');
		$result = $this->db->get('users');

		if ($result && $result->num_rows() > 0){
			return $result;
		}
		else{
			return false;
		}
	}
}