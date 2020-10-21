<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class form_policy_model extends Record
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
		$this->mod_id = 72;
		$this->mod_code = 'form_policy';
		$this->route = 'admin/form_policy';
		$this->url = site_url('admin/form_policy');
		$this->primary_key = 'id';
		$this->table = 'time_form_class_policy';
		$this->icon = '';
		$this->short_name = 'Form Policy';
		$this->long_name  = 'Form Policy';
		$this->description = '';
		$this->path = APPPATH . 'modules/form_policy/';

		parent::__construct();
	}


	public function _get_list($start, $limit, $search, $filter, $trash = false){

		$data = array();				

		$qry = "SELECT 
					`tfcp`.`id` AS `record_id`,
					`tfc`.`class_id`,
					`tfc`.`class_code`,
					tf.`form`,
					`tfcp`.`severity`,
					`tfcp`.`class_value`,
					`tfcp`.`description`,
					`tfcp`.`employment_status_id`, 
					`tfcp`.`employment_type_id`,
					`tfcp`.`role_id`
				FROM  
					ww_time_form_class_policy tfcp 
					
				LEFT JOIN ww_time_form_class tfc ON tfc.`class_id` = tfcp.`class_id`
				LEFT JOIN ww_time_form tf ON tf.`form_id` = tfc.`form_id` 

				WHERE (tfc.`class_code` LIKE '%$search%' 
				OR tf.`form` LIKE '%$search%' 
				OR tfcp.`description` LIKE '%$search%') ";
		
		
		if( $trash )
		{
			$qry .= " AND tf.`deleted` = '1' ";
		}
		else{
			$qry .= " AND tf.`deleted` = '0' ";	
		}

		$qry .= " AND tfcp.`deleted` = '0' ";
		
		$qry .= ' '. $filter;
		$qry .= " ORDER BY tfc.`class_code` ASC ";
		$qry .= " LIMIT $limit OFFSET $start"; // die($qry);

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}

	function _getFormsList(){
		
		$data = array();

		$qry = "SELECT form_id, form_code, form
				FROM ww_time_form 
				WHERE deleted = '0' 
				ORDER BY form ASC";

		$result = $this->db->query( $qry );
		$data = $result->result();

		return $data;
	}
}