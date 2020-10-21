<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class partners_immediate_model extends Record
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
		$this->mod_id = 45;
		$this->mod_code = 'partners_immediate';
		$this->route = 'partners/immediate';
		$this->url = site_url('partners/immediate');
		$this->primary_key = 'user_id';
		$this->table = 'users';
		$this->icon = 'fa-user';
		$this->short_name = 'Partners Immediate';
		$this->long_name  = 'Partners Immediate';
		$this->description = 'List of subordinates. ';
		$this->path = APPPATH . 'modules/partners_immediate/';

		parent::__construct();
	}
		
	function _get_list($start='', $limit=0, $search='', $filter, $trash = false)
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
		//filter employees reporting to
		$qry .= " AND {$this->db->dbprefix}users_profile.reports_to_id = {$this->user->user_id}" ;

		$qry .= ' '. $filter;

		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);
		
// echo "here<pre>";
// print_r($qry);
		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

    function get_partners_personal($user_id=0, $key=''){

        $this->db->select('key_value')
        ->from('partners_personal ')
        ->join('partners', 'partners_personal.partner_id = partners.partner_id', 'left')
        ->where("partners.user_id = $user_id")
        ->where("partners_personal.key = '$key'")
        ->where("partners_personal.deleted = 0");


        $partners_personal = $this->db->get('');    
        if( $partners_personal->num_rows() > 0 )
            return $partners_personal->result_array();
        else
            return array();
    }

	public function _get_list_cached_query()
	{
		$this->load->config('list_cached_query_custom');
		return $this->config->item('list_cached_query');	
	}

	public function _get_edit_cached_query_custom( $record_id=0 )
	{
		$this->load->config('edit_cached_query_custom');
		$cached_query = $this->config->item('edit_cached_query_custom');

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($cached_query, array('record_id' => $record_id), TRUE);

		return $this->db->query( $qry )->row_array();
	}

	public function _get_edit_cached_query_personal_custom( $record_id=0 )
	{
		$this->load->config('edit_cached_query_custom');
		$cached_query = $this->config->item('edit_cached_query_personal_custom');

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($cached_query, array('record_id' => $record_id), TRUE);

		return $this->db->query( $qry )->result_array();
	}

	public function insert_partners_personal($user_id=0, $key_code='', $key_value='', $sequence=0, $partner_id=0)
	{
		$sql_partner = $this->db->get_where('partners', array('user_id' => $user_id));
		$partner_details = $sql_partner->row_array();

		$sql_partner_key = $this->db->get_where('partners_key', array('key_code' => $key_code));
		$key_details = $sql_partner_key->row_array();

		$data = array();
		
		$data = array(
			'partner_id' => ($partner_id == 0) ? $partner_details['partner_id'] : $partner_id,
			'key_id' => $key_details['key_id'],		
			'key' => $key_details['key_code'],
			'sequence' => $sequence,
			'key_name' => $key_details['key_label'],
			'key_value' => $key_value,
			'created_on' => date('Y-m-d H:i:s'),
			'created_by' => $this->user->user_id
			);

		return $data;
	}

	public function get_partner_id($user_id=0){
		$sql_partner = $this->db->get_where('partners', array('user_id' => $user_id));
		$partner_details = $sql_partner->row_array();
		return $partner_details['partner_id'];
	}

}