<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class report_model extends Record
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
		$this->mod_id = 82;
		$this->mod_code = 'report';
		$this->route = 'report';
		$this->url = site_url('report');
		$this->primary_key = 'report_id';
		$this->table = 'report';
		$this->icon = ' fa-book';
		$this->short_name = 'Reports';
		$this->long_name  = 'Reports and Analytics';
		$this->description = '';
		$this->path = APPPATH . 'modules/report/';

		parent::__construct();
	}

	function _get_report_info($id){

		$data = array();

		$qry = "SELECT report_id, report_code, report, description, columns, labels, module, method, export_fields
				FROM ww_reports 
				WHERE report_id = '$id' AND deleted = '0'";

		$result = $this->db->query( $qry );
		$data = $result->result();

		return $data;
	}

	function _get_company_list(){

		$data = array();

		$qry = "SELECT company_id, company FROM ww_users_company WHERE deleted = '0'";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}

	function _get_reports_list(){

		$data = array();

		$qry = "SELECT report_id, report, show_employee_option FROM ww_reports WHERE deleted = '0'";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}

	function _get_total_count($qry){ 

		$data = array();
		$result = $this->db->query( $qry );

		if(is_object($result))
			return $result->num_rows();
		else return 0;
	}

	function _get_incomplete_attendance_list($params){

		$data = array();

		$qry = "SELECT 
					tr.`record_id`,
					tr.`user_id`,
					u.`full_name`,
					uc.`company_id`,
					uc.`company_code`,
					uc.`company`,
					tr.`date`,
					IFNULL(tr.`aux_shift_id`, tr.`shift_id`) shift_id,
					IFNULL(tr.`aux_shift`, tr.`shift`) shift,
					DATE_FORMAT(IFNULL(tr.`aux_time_in`, tr.`time_in`), '%H:%i:%s') time_in,
					DATE_FORMAT(IFNULL(tr.`aux_time_out`, tr.`time_out`), '%H:%i:%s') time_out,
					tfs.`forms_id`,
					tfs.`form_code`,
					tf.`form_id`,
					IFNULL(tf.`form`, 'AWOL') form,
					tf_stat.`form_status_id`,
					tf_stat.`form_status`
					
				FROM ww_time_record tr

				LEFT JOIN ww_users u ON u.`user_id` = tr.`user_id` 
				LEFT JOIN ww_users_profile up ON up.`user_id` = u.`user_id` 
				LEFT JOIN ww_users_company uc ON uc.`company_id` = up.`company_id` 
				LEFT JOIN ww_time_forms tfs ON tfs.`user_id` = u.`user_id`
				LEFT JOIN ww_time_form tf ON tf.`form_id` = tfs.`form_id`
				LEFT JOIN ww_time_form_status  tf_stat ON tf_stat.`form_status_id` = tfs.`form_status_id`

				-- filtering DTR with either or both no login and out
				-- and that shift_id is not 1 which is restday
				WHERE 
					((((IFNULL(tr.`aux_time_in`, tr.`time_in`) IS NULL) 
					OR (IFNULL(tr.`aux_time_out`, tr.`time_out`) IS NULL ))
					AND IFNULL(tr.`aux_shift`, tr.`shift`) <> '1' )
					
					-- as well as filtering through time period
					AND tr.`date` BETWEEN '" . date('Y-m-d', strtotime($params['date_from'])) . "' AND '" . date('Y-m-d', strtotime($params['date_to'])) ."')
					
					-- now, be sure that partner/employee/user has
					-- not filed any form for the disputed date of
					-- absence
					AND tf_stat.`form_status_id` <> '6' 

					-- ADDITIONALS
					-- 1. remove ot, cws, and other forms not related 
					-- 2. can also be or have multiple result: eg, had OBT and DTRP 
					-- 2. and how about late filing ???
					-- FORM ID'S
					-- #9 = OT, #12 = CWS, SHOULD THERE BE ANY OTHER FORMS NEEDS TO BE
					AND (tf.`form_id` <> '9' OR tf.`form_id` <> '12')
					";

		if(isset($params['company']) && $params['company'] !== ''){

			//$company = isset($params['company']) ? isset($params['company']) : isset($params['selected-company']);

			$qry .= "\r\n\r\n
					-- if user has explicity selected company/ies
					AND uc.`company_id` IN (". $params['company'] .") ";
		}

		// echo "<pre>";
		// print_r($qry);
		// echo "</pre>";
		// die();		
					
		$qry .= " \r\n\r\n
				GROUP BY 
					uc.`company_id`, 
					tr.`date`,
					tr.`user_id`
				\r\n	
				ORDER BY uc.`company`, u.`full_name`, tr.date "; 

		// echo "<pre>";
		// print_r($qry);
		// echo "</pre>";
		// die();	
		

		if(!isset($params['action']) || $params['action'] !== 'export'){ //die('???????????????');

			// reserve un-limited query to determine
			// total number of records found for this query
			// and to properly setup paging
			$count_qry = $qry;

			$qry .= "\r\n\r\n
					LIMIT ".$params['limit']." OFFSET ".$params['page']; //echo $qry; die();

			$qry = $params['type'] === 'file' ? $count_qry : $qry;

			// get the total number of records without the
			// limit
			$data['total'] = $this->_get_total_count($count_qry);
		}
		
		//echo $qry; die();
		
		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		

		// echo "<pre>";
		// print_r($qry);
		// echo "</pre>";
		// die();
		//echo json_encode($qry); die();
		return $data;
	}

	function _get_dtr_summary_report($params){

		$data = array();

		$qry = "SELECT 
					tr.`record_id`,
					tr.`user_id`,
					u.`full_name`,
					uc.`company_id`,
					uc.`company_code`,
					uc.`company`,
					tr.`date`,
					tr.`shift_id`,
					tr.`shift`, 
					DATE_FORMAT(tr.`time_in`, '%H:%i:%s') time_in,
					DATE_FORMAT(tr.`time_out`, '%H:%i:%s') time_out,
					trs.`late`,
					trs.`undertime`

				FROM time_record tr 

				JOIN users u ON u.`user_id` = tr.`user_id` 
				LEFT JOIN time_record_summary trs ON trs.`user_id` = u.`user_id` AND trs.date = tr.date
				LEFT JOIN ww_users_profile up ON up.`user_id` = u.`user_id` 
				LEFT JOIN ww_users_company uc ON uc.`company_id` = up.`company_id` 

				-- include submitted forms
				LEFT JOIN ww_time_forms tfs ON tfs.`user_id` = u.`user_id`
				LEFT JOIN ww_time_form tf ON tf.`form_id` = tfs.`form_id`
				LEFT JOIN ww_time_form_status  tf_stat ON tf_stat.`form_status_id` = tfs.`form_status_id`

				-- get lates and undertime based on DTR
				-- having lates and undertimes greater 
				-- than zero, and is not tagged as Restday 
				-- and limit result based on cut-off/period
				WHERE 
					(((((trs.late IS NOT NULL AND trs.`late` > 0) 
					OR (trs.`undertime` IS NOT NULL AND trs.`undertime` > 0))
					AND tr.`shift_id` <> '1')
					
					-- as well as filtering through time period
					AND tr.date BETWEEN '". date("Y-m-d", strtotime($params['date_from'])) ."' AND '". date("Y-m-d", strtotime($params['date_to'])) ."')
					
					-- now, be sure that partner/employee/user has
					-- not filed any form for the disputed date of
					-- absence
					AND tf_stat.`form_status_id` <> '6') ";

		if($params['company']){

			$qry .= "\r\n\r\n
					-- if user has explicity selected company/ies
					AND uc.`company_id` IN (".$params['company'].") ";
		}

					
					
		$qry .= " \r\n\r\n
				GROUP BY 
					uc.`company_id`, 
					tr.`user_id`,
					tr.`date`
					
				\r\n	
				ORDER BY uc.`company`, tr.`date` ASC "; 
		

		if(!isset($params['action']) || $params['action'] !== 'export'){

			// reserve un-limited query to determine
			// total number of records found for this query
			// and to properly setup paging
			$count_qry = $qry;

			$qry .= "\r\n\r\n
					LIMIT ".$params['limit']." OFFSET ".$params['page']; //echo $qry; die();

			$qry = $params['type'] === 'file' ? $count_qry : $qry;

			// get the total number of records without the
			// limit
			$data['total'] = $this->_get_total_count($count_qry);
		}

		// echo "<pre>";
		// print_r($qry);
		// echo "<br><br>";
		// echo "</pre>";
		// die();

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		// get the total number of records without the
		// limit
		// $data['total'] = $this->_get_total_count($count_qry);

		// echo "<pre>";
		// print_r($qry);
		// echo "</pre>";
		// die();
		//echo json_encode($qry); die();
		return $data;
	}

	function _get_tardiness_report_for_memo($params){

		// echo "<pre>";
		// print_r($params);
		// echo "<br><br>";
		// echo "</pre>";
		// die();

		$data = array();

		$qry = "SELECT 
					a.*,
					b.occurence

				FROM (

					SELECT 
						tr.`record_id`,
						tr.`user_id`,
						uc.`company_id`,
						uc.`company_code`,
						uc.`company`,
						ud.`department_id`,
						ud.`department`,
						u.`full_name`,
						tr.date,
						tr.`shift`,
						DATE_FORMAT(tr.`time_in`, '%H:%i:%s') time_in,
						DATE_FORMAT(tr.`time_out`, '%H:%i:%s') time_out,
						trs.`late`,
						trs.`undertime`
						
					FROM time_record tr 

					JOIN ww_users u ON u.`user_id` = tr.`user_id` 
					LEFT JOIN time_record_summary trs ON trs.`user_id` = u.`user_id` AND trs.date = tr.date
					LEFT JOIN ww_users_profile up ON up.`user_id` = u.`user_id` 
					LEFT JOIN ww_users_company uc ON uc.`company_id` = up.`company_id` 
					LEFT JOIN ww_users_department ud ON ud.`division_id` = up.`department_id`
					
					-- include submitted forms
					LEFT JOIN ww_time_forms tfs ON tfs.`user_id` = u.`user_id`
					LEFT JOIN ww_time_form tf ON tf.`form_id` = tfs.`form_id`
					LEFT JOIN ww_time_form_status  tf_stat ON tf_stat.`form_status_id` = tfs.`form_status_id`

					WHERE 
						-- ((trs.late IS NOT NULL AND trs.`late` > 0) 
						-- OR (trs.`undertime` IS NOT NULL AND trs.`undertime` > 0))
						-- AND tr.`shift` <> '1' 
							
						(((((trs.late IS NOT NULL AND trs.`late` > 0) 
						OR (trs.`undertime` IS NOT NULL AND trs.`undertime` > 0))
						AND tr.`shift_id` <> '1')
						AND tr.date BETWEEN '". date("Y-m-d", strtotime($params['date_from'])) ."' AND '". date("Y-m-d", strtotime($params['date_to'])) ."')
						
						-- now, be sure that partner/employee/user has
						-- not filed any form for the disputed date
						AND tf_stat.`form_status_id` <> '6')
						
					GROUP BY 
						uc.`company_id`, 
						tr.`user_id`,
						tr.`date`
						
					ORDER BY uc.`company_code`, MONTH(tr.`date`) ASC 
				) a , (
					
					SELECT 
						tr.`record_id`,
						u.`full_name`,
						COUNT(tr.`user_id`) occurence
						
					FROM time_record tr 

					JOIN ww_users u ON u.`user_id` = tr.`user_id` 
					LEFT JOIN time_record_summary trs ON trs.`user_id` = u.`user_id` AND trs.date = tr.date
					LEFT JOIN ww_users_profile up ON up.`user_id` = u.`user_id` 
					LEFT JOIN ww_users_company uc ON uc.`company_id` = up.`company_id` 
					LEFT JOIN ww_users_department ud ON ud.`division_id` = up.`department_id`
					
					-- include submitted forms
					LEFT JOIN ww_time_forms tfs ON tfs.`user_id` = u.`user_id`
					LEFT JOIN ww_time_form tf ON tf.`form_id` = tfs.`form_id`
					LEFT JOIN ww_time_form_status  tf_stat ON tf_stat.`form_status_id` = tfs.`form_status_id`

					WHERE 
						-- ((trs.late IS NOT NULL AND trs.`late` > 0) 
						-- OR (trs.`undertime` IS NOT NULL AND trs.`undertime` > 0))
						
						(((((trs.late IS NOT NULL AND trs.`late` > 0) 
						OR (trs.`undertime` IS NOT NULL AND trs.`undertime` > 0))
						AND tr.`shift_id` <> '1')
						AND tr.date BETWEEN '". date("Y-m-d", strtotime($params['date_from'])) ."' AND '". date("Y-m-d", strtotime($params['date_to'])) ."')
						
						-- now, be sure that partner/employee/user has
						-- not filed any form for the disputed date
						AND tf_stat.`form_status_id` <> '6')

					GROUP BY 
						uc.`company_id`, 
						tr.`user_id`,
						MONTH(tr.`date`) 
						
					ORDER BY uc.`company`, MONTH(tr.`date`), tr.`user_id` ASC 
				) b 

				-- where b.record_id = a.record_id 
				WHERE b.full_name = a.full_name  ";

		if($params['company']){

			$qry .= "\r\n\r\n
					-- if user has explicity selected company/ies
					AND a.`company_id` IN (".$params['company'].") ";
		}


		$qry .= "
				-- b.occurence is currently set constantly,
				-- this should be change and parameterized.
				HAVING b.occurence > 4 

				ORDER BY a.company_code, a.full_name, a.date ASC ";



		if(!isset($params['action']) || $params['action'] !== 'export'){

			// reserve un-limited query to determine
			// total number of records found for this query
			// and to properly setup paging
			$count_qry = $qry;

			$qry .= "\r\n\r\n
					LIMIT ".$params['limit']." OFFSET ".$params['page']; //echo $qry; die();

			$qry = $params['type'] === 'file' ? $count_qry : $qry;

			// get the total number of records without the
			// limit
			$data['total'] = $this->_get_total_count($count_qry);
		}

		// echo "<pre>";
		// print_r($qry);
		// echo "<br><br>";
		// echo "</pre>";
		// die(); 

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		// echo "<pre>";
		// print_r($qry);
		// echo "</pre>";
		// die();
		//echo json_encode($qry); die();
		return $data;
	}
}