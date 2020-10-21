<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class partners_model extends Record
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
		$this->mod_id = 43;
		$this->mod_code = 'partners';
		$this->route = 'partners/list';
		$this->url = site_url('partners/list');
		$this->primary_key = 'user_id';
		$this->table = 'users';
		$this->icon = 'fa-user';
		$this->short_name = 'Employees';
		$this->long_name  = 'Employees';
		$this->description = 'manage and list application employees. ';
		$this->path = APPPATH . 'modules/partners/';

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

		$qry_category = $this->get_role_category();

		if ($qry_category != ''){
			$qry .= ' AND ' . $qry_category;
		}

		$qry .= " AND {$this->db->dbprefix}users.user_id > 1 ". $filter;
		$qry .= " ORDER BY `{$this->db->dbprefix}users_profile`.`firstname`,`{$this->db->dbprefix}users_profile`.`lastname`";
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

		if(!count($partner_details) > 0){
			$this->db->insert('partners', array('user_id' => $user_id));
			$partner_id = $this->db->insert_id();
		}
		
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
		$partner_details = array();

		$sql_partner = $this->db->get_where('partners', array('user_id' => $user_id));
		$partner_details = $sql_partner->row_array();
		if(!empty($partner_details)){
			return $partner_details['partner_id'];
		}
		return null;
	}


	function get_partners_personal_list_details($user_id=0, $key_class_code='', $sequence=0){

		$partner_id = $this->get_partner_id($user_id);
		$this->db->select('key, sequence, key_value, personal_id')
	    ->from('partners_personal_history')
	    ->join('partners', 'partners_personal_history.partner_id = partners.partner_id', 'left')
	    ->join('partners_key', 'partners_personal_history.key_id = partners_key.key_id', 'left')
	    ->join('partners_key_class', 'partners_key.key_class_id = partners_key_class.key_class_id', 'left')
	    ->where("partners.partner_id = $partner_id")
	    ->where("partners_key_class.key_class_code = '$key_class_code'")
	    ->where("partners_personal_history.sequence = '$sequence'")
	    // ->order_by("sequence", "desc")
	    ;

	    $partners_personal_list_details = $this->db->get('');	
		return $partners_personal_list_details->result_array();
	}

	function get_partners_personal($user_id=0, $partners_personal_table='', $key='', $sequence=0){
		$this->db->select('personal_id, key_value')
	    ->from($partners_personal_table)
	    ->join('partners', $partners_personal_table.'.partner_id = partners.partner_id', 'left')
	    ->where("partners.user_id = $user_id")
	    ->where("partners.deleted = 0")
	    ->where($partners_personal_table.".key = '$key'");
	    if($sequence != 0)
	    	$this->db->where($partners_personal_table.".sequence = '$sequence'");

		if($partners_personal_table == 'partners_personal'){
	    	$this->db->where("partners_personal.deleted = 0");
	    }

	    $partners_personal = $this->db->get('');	
	    
		if( $partners_personal->num_rows() > 0 )
	    	return $partners_personal->result_array();
	    else
	    	return array();
	}

	function create_movement($partner, $movement_type_code)
	{
		$movement_type = $this->db->get_where('partners_movement_type', array('type_code' => $movement_type_code))->row_array();

		// partners_movement
			$movement_record = array( 'status_id'  => 3, 
								 'due_to_id'  => 1, 
								 'remarks' 	  => 'Employee Rehire',
								 'created_by' => $this->user->user_id
								 );

			$this->db->insert('partners_movement', $movement_record); // main movement table
			$movement_id = $this->db->insert_id();

		// partners_movement_action
			$movement_action = array(  'movement_id' 		=> $movement_id, 
								 'status_id'  		=> 6,
								 'user_id' 			=> $partner['user_id'], 
								 'display_name' 	=> $partner['display_name'], 
								 'effectivity_date' => date('Y-m-d'),
								 'type_id' 			=> $movement_type['type_id'],
								 'type' 			=>  $movement_type['type'],
								 'remarks' 			=> 'Employee Rehire',
								 'created_by' 		=> $this->user->user_id
								 );
			$this->db->insert('partners_movement_action', $movement_action); 
			$movement_action_id = $this->db->insert_id();

		if($movement_type_code == 'EMPSTATUS'){
			// partners_movement_action_transfer
				$movement_action_transfer = array( 'action_id' 	=> $movement_action_id, 
											  'movement_id' => $movement_id, 
											  'field_id' 	=> 9, 
											  'field_name' 	=> 'employment_status',
											  'from_id' 	=> $partner['from_id'],
											  'to_id' 		=> $partner['to_id'],
											  'from_name' 	=> $partner['from_name'],
											  'to_name' 	=> $partner['to_name'],
											 );
				$this->db->insert('partners_movement_action_transfer', $movement_action_transfer); 
				$movement_action_transfer_id = $this->db->insert_id();
		}

	}

	function get_signatories($user_id)
	{
		$gender_result = $this->get_partners_personal($user_id,'partners_personal','gender');
		$gender = '';
		if (count($gender_result) > 0){
			$gender = $gender_result[0]['key_value'];
		}

		$this->db->select('TRIM(category)category,approver_class.class,approver_class.class_id,approver_class.class_code,only_male,only_female');
		$this->db->order_by('category, class');
		$this->db->join('time_form','approver_class.class_code = time_form.form_code','left');
		$this->db->where('approver_class.deleted',0);
		
		if ($gender == 'Male'){
			$this->db->where('only_female',0);
			$this->db->or_where('only_female',NULL);
		}
		elseif ($gender == 'Female'){
			$this->db->where('only_male',0);
			$this->db->or_where('only_female',NULL);
		}

		$classes = $this->db->get('approver_class');

		$data['class'] = array();
		foreach( $classes->result() as $class )
		{
			$class_code = $class->class_code.'-GRANT';
			$this->db->join('time_form_class_policy','time_form_class.class_id = time_form_class_policy.class_id');
			$result = $this->db->get_where('time_form_class',array('class_code' => $class_code));
			if ($result && $result->num_rows() > 0){
				$row = $result->row();
				if ($row->class_value == 'YES'){
					$data['class'][$class->category][$class->class_id] = $class->class . ' ('.$class->class_code.')';
				}
			}
		}

		return $data;
	}

	function add_to_holiday_location($user_id,$location_id)
	{
		$data = array();

		$this->db->where('deleted',0);
		$holiday = $this->db->get('time_holiday');
		if ($holiday && $holiday->num_rows() > 0) {
			foreach ($holiday->result() as $row) {
				$this->db->where('holiday_id',$row->holiday_id);
				$this->db->where('user_id',$user_id);
				$this->db->where('location_id',$location_id);
				$user_holiday = $this->db->get('time_holiday_location');
				if (!$user_holiday || $user_holiday->num_rows == 0) {
					$qry = "INSERT INTO ww_time_holiday_location
							SELECT th.`holiday_id`, up.`location_id`, ul.`location`, p.`user_id`, up.`display_name`, 0 `deleted`
							FROM `ww_partners` p
							JOIN `users_profile` up ON up.`user_id`=p.`user_id` AND up.`active`=1
							JOIN `ww_time_holiday` th ON th.`holiday_id`={$row->holiday_id} AND FIND_IN_SET(up.`location_id`,th.`locations`) AND th.`deleted`=0
							LEFT JOIN `ww_users_location` ul ON ul.`location_id`=up.`location_id`
							WHERE p.user_id = {$user_id}
							ORDER BY 2,5";
					$result = $this->db->query( $qry );
				}
			}
		}
	}
}