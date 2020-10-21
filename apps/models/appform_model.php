<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class appform_model extends Record
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
		$this->mod_id = 124;
		$this->mod_code = 'appform';
		$this->route = 'recruitment/appform';
		$this->url = site_url('recruitment/appform');
		$this->primary_key = 'recruit_id';
		$this->table = 'recruitment';
		$this->icon = '';
		$this->short_name = 'Application Form';
		$this->long_name  = 'Application Form';
		$this->description = '';
		$this->path = APPPATH . 'modules/appform/';

		parent::__construct();
	}

	function get_active_mrf_by_year()
	{
        $mrf = array();
       
        $qry = "SELECT a.*, b.position, rra.approver_id
			        FROM {$this->db->dbprefix}recruitment_request a
			        LEFT JOIN {$this->db->dbprefix}recruitment_request_approver rra on rra.request_id = a.request_id
			        LEFT JOIN {$this->db->dbprefix}users_position b on b.position_id = a.position_id
			        WHERE a.deleted=0 AND a.status_id IN (3,7) 
			        GROUP BY a.position_id
			        ORDER BY YEAR(a.created_on) DESC, a.created_on ASC";
        $mrfs = $this->db->query( $qry );
        foreach( $mrfs->result() as $_mrf )
        {
            $mrf[date('Y', strtotime($_mrf->created_on))][] = $_mrf;
        }
        
        return $mrf;
	}

	function get_employee(){
		$this->db->where('user_id !=',1);
		$result = $this->db->get('users');
		if ($result && $result->num_rows() > 0){
			return $result->result_array();
		}
		else{
			return array();
		}
	}

	function get_type_license(){
		$result = $this->db->get('recruitment_type_license');
		if ($result && $result->num_rows() > 0){
			return $result->result_array();
		}
		else{
			return array();
		}
	}

	function get_sourcing_tools(){
		$result = $this->db->get('recruitment_sourcing_tools');
		if ($result && $result->num_rows() > 0){
			return $result->result_array();
		}
		else{
			return array();
		}
	}	

}