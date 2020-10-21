<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class holiday_event_model extends Record
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
		$this->mod_code = 'holiday_event';
		$this->route = 'admin/time/holiday_event';
		$this->url = site_url('admin/time/holiday_event');
		$this->primary_key = 'event_id';
		$this->table = 'time_holiday_event';
		$this->icon = '';
		$this->short_name = 'Holiday Event';
		$this->long_name  = 'Holiday Event';
		$this->description = '';
		$this->path = APPPATH . 'modules/holiday_event/';

		parent::__construct();
	}

	function getHolidayEvents(){

		$data = array();
		$holiday_events = $this->db->get_where('time_holiday_event', array('deleted' => 0));

		if($holiday_events->num_rows() > 0){
				
			foreach($holiday_events->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$holiday_events->free_result();
		return $data;		
	}

}