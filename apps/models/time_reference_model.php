<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class time_reference_model extends Record
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
		$this->mod_id = 78;
		$this->mod_code = 'time_reference';
		$this->route = 'time/reference';
		$this->url = site_url('time/reference');
		$this->primary_key = '1';
		$this->table = '1';
		$this->icon = '';
		$this->short_name = 'Time Reference';
		$this->long_name  = 'Time Reference';
		$this->description = 'timekeeping management and configuration section.';
		$this->path = APPPATH . 'modules/time_reference/';

		parent::__construct();
	}


	function getTimeReferrenceList(){ 

		$data = array();

		/*!*
		* 36 - holiday
		* 37 - shift
		*/

		$qry = "SELECT  
					mod_id, route, short_name, icon, description
				FROM ww_modules
				WHERE mod_id IN ('36', '37', '39', '72', '83')
				AND deleted = '0'"; 
		
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
			
			$data['count'] = $result->num_rows();

			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

}