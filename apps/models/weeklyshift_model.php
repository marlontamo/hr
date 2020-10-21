<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class weeklyshift_model extends Record
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
		$this->mod_id = 39;
		$this->mod_code = 'weeklyshift';
		$this->route = 'admin/time/weeklyshift';
		$this->url = site_url('admin/time/weeklyshift');
		$this->primary_key = 'calendar_id';
		$this->table = 'time_shift_weekly';
		$this->icon = '';
		$this->short_name = 'Weekly Shift';
		$this->long_name  = 'Weekly Shift';
		$this->description = '';
		$this->path = APPPATH . 'modules/weeklyshift/';

		parent::__construct();
	}
public function call_sp_time_shift_insert($calendar_id='', $week_no='', $shift_id=0){		
		$sp_time_shift_insert = $this->db->query("CALL sp_time_shift_insert('".$calendar_id."', '".$week_no."', ".$shift_id.")");
		mysqli_next_result($this->db->conn_id);
		return $sp_time_shift_insert;
	}

public function get_time_shift_weekly_calendar($record_id){		

		$this->db->where('calendar_id',$record_id);
		$get_time_shift_weekly = $this->db->get('time_shift_weekly_calendar');
		return $get_time_shift_weekly->result_array();
	}}