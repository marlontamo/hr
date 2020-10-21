<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class holiday_model extends Record
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
		$this->mod_id = 36;
		$this->mod_code = 'holiday';
		$this->route = 'admin/time/holiday';
		$this->url = site_url('admin/time/holiday');
		$this->primary_key = 'holiday_id';
		$this->table = 'time_holiday';
		$this->icon = '';
		$this->short_name = 'Holiday';
		$this->long_name  = 'Holiday';
		$this->description = '';
		$this->path = APPPATH . 'modules/holiday/';

		parent::__construct();
	}


	function _get_list($start, $limit, $search, $filter, $trash = false){

		$data = array();				
		
		$qry = 'SELECT 
					`ww_time_holiday`.`holiday_id` as record_id, 
					ww_time_holiday.holiday as "time_holiday_holiday", 
					DATE_FORMAT(ww_time_holiday.holiday_date, \'%M %d, %Y\') as "time_holiday_holiday_date", 
					IF(ww_time_holiday.legal = 1, "Yes", "No") as "time_holiday_legal", 
					`ww_time_holiday`.`location_count`,
					`ww_time_holiday`.`locations`,
					`ww_time_holiday`.`created_on` as "time_holiday_created_on", 
					`ww_time_holiday`.`created_by` as "time_holiday_created_by", 
					`ww_time_holiday`.`modified_on` as "time_holiday_modified_on", 
					`ww_time_holiday`.`modified_by` as "time_holiday_modified_by" 
				FROM (`ww_time_holiday`)
				WHERE (
					ww_time_holiday.holiday like "%{$search}%" OR 
					DATE_FORMAT(ww_time_holiday.holiday_date, \'%M %d, %Y\') like "%{$search}%" OR 
					IF(ww_time_holiday.legal = 1, "Yes", "No") like "%{$search}%" 
				)';
		
		
		if( $trash ){
			$qry .= " AND `ww_time_holiday`.`deleted` = '1'";
		}
		else{
			$qry .= " AND `ww_time_holiday`.`deleted` = '0'";	
		}
		
		$qry .= 'ORDER BY ww_time_holiday.holiday_date DESC';

		$qry .= ' '. $filter;
		$qry .= " LIMIT $limit OFFSET $start"; 

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){

				if($row['location_count'] > 0){
					$ids = explode(',', $row['locations']);
					$rows = array();
					//debug( 'ids: ');
					//debug( $ids );
					foreach($ids as $idno){
						$loc = $this->get_location_data($idno);
						//debug( $loc );
						$rows[] = $loc[0]['location_code'];
					}
					$row['locations'] = implode(', ', $rows);

				}
				else{
					$row['locations'] = '-';
				}
				

				//debug( $row );
				$data[] = $row;
			}
		}

		return $data;
	}

	function _save($record_id, $record)
	{
		if( empty($record_id) )
		{
			$this->db->insert('time_holiday', $record);
			$record_id = $this->db->insert_id();
		}
		else{
			$record['modified_by'] = $this->user->user_id;
			$record['modified_on'] = date('Y-m-d');
			$this->db->update('time_holiday', $record, array('holiday_id' => $record_id));
		}

		if( $this->db->_error_message() != "" )
			return $this->db->_error_message();
		else
			return (Integer)$record_id;
	}

	function remove_holiday_locations($location_id){

		$qry = "DELETE FROM ww_time_holiday_location WHERE holiday_id = '".$location_id."'";
		$this->db->query( $qry );
	}


	function get_posted_holiday($holiday_date){

		$data = array();	

		$qry = "SELECT holiday_id, holiday 
				FROM ww_time_holiday 
				WHERE holiday_date = '". date("Y-m-d", strtotime($holiday_date)) ."'";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}


	function get_location_data($location_id){

		$data = array();	

		$qry = "SELECT location_id, location, location_code 
				FROM ww_users_location 
				WHERE location_id = '".$location_id."'";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}


	function get_users_from_location($location_id){

		$data = array();	
		
		$qry = "SELECT up.user_id, up.display_name AS name 
				FROM users_profile up, users u
				WHERE up.user_id = u.user_id AND u.active = 1 AND up.location_id = '".$location_id."'";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}


	function add_to_holiday_location($holiday_id)
	{
		$data = array();

		$qry = "INSERT INTO ww_time_holiday_location
				SELECT th.`holiday_id`, up.`location_id`, ul.`location`, p.`user_id`, up.`display_name`, 0 `deleted`
				FROM `partners` p
				JOIN `users_profile` up ON up.`user_id`=p.`user_id` AND up.`active`=1
				JOIN `ww_time_holiday` th ON th.`holiday_id`={$holiday_id} AND FIND_IN_SET(up.`location_id`,th.`locations`) AND th.`deleted`=0
				LEFT JOIN `ww_users_location` ul ON ul.`location_id`=up.`location_id`
				ORDER BY 2,5";
		$result = $this->db->query( $qry );

		/*
		$qry = "INSERT INTO ww_time_holiday_location (holiday_id, location_id, location, user_id, user) 
				VALUES ('" . $holiday_data['holiday_id'] . "'
					 	, '" . $holiday_data['location_id'] . "'
					 	, '" . $holiday_data['location'] . "'
					 	, '" . $holiday_data['user_id'] . "'
					 	, '" . $holiday_data['user'] . "')";

		$result = $this->db->query( $qry );
		*/
	}


	function update_holiday_user_count($holiday_id, $count){

		$data = array();

		$qry = "UPDATE ww_time_holiday SET user_count = '".$count."' WHERE holiday_id = '".$holiday_id."'";
		$result = $this->db->query( $qry );

		return $result;
	}
}