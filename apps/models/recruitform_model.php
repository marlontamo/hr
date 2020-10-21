<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class recruitform_model extends Record
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
		$this->mod_id = 129;
		$this->mod_code = 'recruitform';
		$this->route = 'recruitment/form';
		$this->url = site_url('recruitment/form');
		$this->primary_key = 'recruit_id';
		$this->table = 'recruitment';
		$this->icon = '';
		$this->short_name = 'Recruitment Form';
		$this->long_name  = 'Recruitment Form';
		$this->description = '';
		$this->path = APPPATH . 'modules/recruitform/';

		parent::__construct();
	}
	
	function get_recruitment_personal($recruit_id=0, $recruitment_personal_table='', $key='', $sequence=0){
		$this->db->select("{$this->table}.recruit_id, key_value")
	    ->from($recruitment_personal_table)
	    ->join($this->table, $recruitment_personal_table.".recruit_id = {$this->table}.recruit_id", 'left')
	    ->where("{$this->table}.recruit_id = {$recruit_id}")
	    ->where($recruitment_personal_table.".key = '$key'");
	    if($sequence != 0)
	    	$this->db->where($recruitment_personal_table.".sequence = '$sequence'");

		if($recruitment_personal_table == 'recruitment_personal'){
	    	$this->db->where("recruitment_personal.deleted = 0");
	    }

	    $recruitment_personal = $this->db->get('');	
		// echo "<pre>";print_r($this->db->last_query());
	    
		if( $recruitment_personal->num_rows() > 0 )
	    	return $recruitment_personal->result_array();
	    else
	    	return array();
	}

	function get_recruitment_personal_value($recruit_id=0, $key=''){

		$this->db->select('key_value')
	    ->from('recruitment_personal ')
	    ->join('recruitment', 'recruitment_personal.recruit_id = recruitment.recruit_id', 'left')
	    ->where("recruitment.recruit_id = $recruit_id")
	    ->where("recruitment_personal.key = '$key'")
	    ->where("recruitment_personal.deleted = 0");

	    $recruitment_personal = $this->db->get('');	

		if( $recruitment_personal->num_rows() > 0 )
	    	return $recruitment_personal->result_array();
	    else
	    	return array();
	}

	function get_recruitment_personal_value_history($recruit_id=0, $key_class_code=''){

		$this->db->select('key, sequence, key_value, personal_id')
	    ->from('recruitment_personal_history')
	    ->join('recruitment', 'recruitment_personal_history.recruit_id = recruitment.recruit_id', 'left')
	    ->join('recruitment_key', 'recruitment_personal_history.key_id = recruitment_key.key_id', 'left')
	    ->join('recruitment_key_class', 'recruitment_key.key_class_id = recruitment_key_class.key_class_id', 'left')
	    ->where("recruitment.recruit_id = $recruit_id")
	    ->where("recruitment_key_class.key_class_code = '$key_class_code'");

	    $recruitment_personal_history = $this->db->get();

	    if( $recruitment_personal_history->num_rows() > 0 )
	    	return $recruitment_personal_history->result_array();
	    else
	    	return array();
	}

	public function insert_recruitment_personal($user_id=0, $key_code='', $key_value='', $sequence=0, $recruit_id=0)
	{
		// $sql_partner = $this->db->get_where('recruitment', array('user_id' => $user_id));
		// $partner_details = $sql_partner->row_array();

		// if(!count($partner_details) > 0){
		// 	$this->db->insert('recruitment', array('user_id' => $user_id));
		// 	$recruit_id = $this->db->insert_id();
		// }
		
		$sql_partner_key = $this->db->get_where('recruitment_key', array('key_code' => $key_code));
		
		$data = array();
			
		if ($sql_partner_key && $sql_partner_key->num_rows() > 0){
			$key_details = $sql_partner_key->row_array();
			$data = array(
				'recruit_id' => $recruit_id,
				'key_id' => $key_details['key_id'],		
				'key' => $key_details['key_code'],
				'sequence' => $sequence,
				'key_name' => $key_details['key_label'],
				'key_value' => $key_value,
				'created_on' => date('Y-m-d H:i:s'),
				'created_by' => ( !$this->session->userdata('user') ) ? '' : $this->user->user_id
				);

		}

		return $data;
	}
	
	function get_active_mrf_by_year()
	{
        $user_id = $this->config->config['user']['user_id'];
        $permission = $this->config->item('permission');
        $this->load->model('applicant_monitoring_model', 'applicant_monitoring');
        $is_assigned = isset($permission[$this->applicant_monitoring->mod_code]['process']) ? $permission[$this->applicant_monitoring->mod_code]['process'] : 0;

        $mrf = array();
       
        $qry = "SELECT a.*, b.position AS position_sought, rra.approver_id
        FROM {$this->db->dbprefix}recruitment_request a
        LEFT JOIN {$this->db->dbprefix}recruitment_request_approver rra on rra.request_id = a.request_id
        LEFT JOIN {$this->db->dbprefix}users_position b on b.position_id = a.position_id
        WHERE a.deleted=0 AND a.status_id IN (3,5,7) GROUP BY request_id ";
/*        if($is_assigned){
             $qry .= " AND a.hr_assigned={$user_id}";
        }*/
        $qry .= " ORDER BY YEAR(a.created_on) DESC, a.created_on ASC";
        $mrfs = $this->db->query( $qry );
        
        foreach( $mrfs->result() as $_mrf )
        {
            $mrf[date('Y', strtotime($_mrf->created_on))][] = $_mrf;
        }
        
        return $mrf;
	}
}