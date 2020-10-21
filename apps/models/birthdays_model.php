<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class birthdays_model extends Record
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
		$this->mod_id = 41;
		$this->mod_code = 'birthdays';
		$this->route = 'birthdays';
		$this->url = site_url('birthdays');
		$this->primary_key = 'user_id';
		$this->table = 'users_profile';
		$this->icon = '';
		$this->short_name = 'Birthdays';
		$this->long_name  = 'Birthdays';
		$this->description = 'Birthdays';
		$this->path = APPPATH . 'modules/birthdays/';

		parent::__construct();
	}


	public function _get_list($start, $limit, $search)
	{
		$data = array();
		
		$qry = "SELECT * FROM dashboard_birthday_list 
					WHERE birth_date LIKE '%-".$search."-%'
					ORDER BY MONTH(birth_date), DAY(birth_date)
					LIMIT $limit OFFSET $start";
		$result = $this->db->query($qry);
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;
	}

	function getBirthdays($bdate){ 
		
		$data = array();

		$qry = "SELECT * FROM dashboard_birthday WHERE birth_date = '".$bdate."'"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			// foreach($result->result_array() as $row){
			// 	$data[] = $row;
			// }			
			$data = $result->row_array();
		}
		
		$result->free_result();
		return $data;	
	}



}