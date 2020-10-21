<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class habitual_tardiness_configuration_model extends Record
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
		$this->mod_id = 262;
		$this->mod_code = 'habitual_tardiness_configuration';
		$this->route = 'admin/time/habitual_tardiness_configuration';
		$this->url = site_url('admin/time/habitual_tardiness_configuration');
		$this->primary_key = 'habitual_tardiness_id';
		$this->table = 'time_record_tardiness_settings';
		$this->icon = '';
		$this->short_name = 'Habitual Tardiness Configuration';
		$this->long_name  = 'Habitual Tardiness Configuration';
		$this->description = '';
		$this->path = APPPATH . 'modules/habitual_tardiness_configuration/';

		parent::__construct();
	}

	function get_tardiness_settings(){
		$data = array();

		$this->db->where('deleted',0);
		$result = $this->db->get('time_record_tardiness_settings');

		if ($result && $result->num_rows() > 0){
			$data = $result->row_array();
		}

		return $data;
	}
}