<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class signatories_model extends Record
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
		$this->mod_id = 30;
		$this->mod_code = 'signatories';
		$this->route = 'admin/signatories';
		$this->url = site_url('admin/signatories');
		$this->primary_key = 'approver_class_id';
		$this->table = 'approver_class';
		$this->icon = 'fa-cogs';
		$this->short_name = 'Signatories';
		$this->long_name  = 'Signatory Settings';
		$this->description = 'signatory manager and settings';
		$this->path = APPPATH . 'modules/signatories/';

		parent::__construct();
	}

	function get_company_signatories( $class_id, $company_id )
	{
		$signatories = $this->db->get_where('approver_class_company', array('class_id' => $class_id, 'company_id' => $company_id, 'deleted' => 0));
		if( $signatories->num_rows() > 0 )
		{
			return $signatories->result();
		}

		return false;
	}

	function get_department_signatories( $class_id, $department_id, $company_id )
	{
		$where = array('class_id' => $class_id, 'department_id' => $department_id, 'company_id' => $company_id, 'deleted' => 0);
		$signatories = $this->db->get_where('approver_class_department', $where);
		if( $signatories->num_rows() > 0 )
		{
			return $signatories->result();
		}

		return false;
	}

	function get_position_signatories( $class_id, $position_id, $department_id, $company_id )
	{
		$where = array(
			'class_id' => $class_id, 
			'position_id' => $position_id,
			'department_id' => $department_id,
			'company_id' => $company_id, 
			'deleted' => 0
		);
		$signatories = $this->db->get_where('approver_class_position', $where);
		if( $signatories->num_rows() > 0 )
		{
			return $signatories->result();
		}

		return false;
	}

	function get_user_signatories( $class_id, $user_id, $position_id, $department_id, $company_id )
	{
		$where = array(
			'class_id' => $class_id, 
			'user_id' => $user_id,
/*			'position_id' => $position_id,
			'department_id' => $department_id,
			'company_id' => $company_id,*/ 
			'deleted' => 0
		);
		$signatories = $this->db->get_where('approver_class_user', $where);
		if( $signatories->num_rows() > 0 )
		{
			return $signatories->result();
		}

		return false;
	}

	function get_users_signatories( $user_id, $position_id, $department_id, $company_id )
	{
		$where = array(
			'user_id' => $user_id,
			'position_id' => $position_id,
			'department_id' => $department_id,
			'company_id' => $company_id, 
			'deleted' => 0
		);
		$signatories = $this->db->get_where('approver_class_users', $where);
		if( $signatories->num_rows() > 0 )
		{
			return $signatories->result();
		}

		return false;
	}

	function delete_company_signatory( $records )
	{
		$response = new stdClass();

		$data['modified_on'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->user->user_id;
		$data['deleted'] = 1;

		$this->db->where_in('id', $records);
		$this->db->update('approver_class_company', $data);
		
		if( $this->db->_error_message() != "" ){
			$response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}
		else{
			$response->message[] = array(
				'message' => lang('common.delete_record', $this->db->affected_rows()),
				'type' => 'success'
			);
		}

		return $response;
	}

	function delete_department_signatory( $records )
	{
		$response = new stdClass();

		$data['modified_on'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->user->user_id;
		$data['deleted'] = 1;

		$this->db->where_in('id', $records);
		$this->db->update('approver_class_department', $data);
		
		if( $this->db->_error_message() != "" ){
			$response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}
		else{
			$response->message[] = array(
				'message' => lang('common.delete_record', $this->db->affected_rows()),
				'type' => 'success'
			);
		}

		return $response;
	}

	function delete_position_signatory( $records )
	{
		$response = new stdClass();

		$data['modified_on'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->user->user_id;
		$data['deleted'] = 1;

		$this->db->where_in('id', $records);
		$this->db->update('approver_class_position', $data);
		
		if( $this->db->_error_message() != "" ){
			$response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}
		else{
			$response->message[] = array(
				'message' => lang('common.delete_record', $this->db->affected_rows()),
				'type' => 'success'
			);
		}

		return $response;
	}

	function delete_user_signatory( $records )
	{
		$response = new stdClass();

		$data['modified_on'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->user->user_id;
		$data['deleted'] = 1;

		$this->db->where_in('id', $records);
		$this->db->update('approver_class_user', $data);
		
		if( $this->db->_error_message() != "" ){
			$response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}
		else{
			$response->message[] = array(
				'message' => lang('common.delete_record', $this->db->affected_rows()),
				'type' => 'success'
			);
		}

		return $response;
	}

	function get_company_signatory( $id )
	{
		if( !empty($id) )
			return $this->db->get_where('approver_class_company', array('id' => $id))->row();
		else{
			$response = new stdClass();
			$response->id = '';
			$response->class_id = '';
			$response->company_id = '';
			$response->approver_id = '';
			$response->condition = '';
			$response->sequence = '';
			$response->approver = '';
			$response->email = '';
			return $response;
		}
	}

	function get_department_signatory( $id )
	{
		if( !empty($id) )
			return $this->db->get_where('approver_class_department', array('id' => $id))->row();
		else{
			$response = new stdClass();
			$response->id = '';
			$response->class_id = '';
			$response->company_id = '';
			$response->approver_id = '';
			$response->condition = '';
			$response->sequence = '';
			$response->approver = '';
			$response->email = '';
			return $response;
		}
	}

	function get_position_signatory( $id )
	{
		if( !empty($id) )
			return $this->db->get_where('approver_class_position', array('id' => $id))->row();
		else{
			$response = new stdClass();
			$response->id = '';
			$response->class_id = '';
			$response->company_id = '';
			$response->approver_id = '';
			$response->condition = '';
			$response->sequence = '';
			$response->approver = '';
			$response->email = '';
			return $response;
		}
	}

	function get_user_signatory( $id )
	{
		if( !empty($id) )
			return $this->db->get_where('approver_class_user', array('id' => $id))->row();
		else{
			$response = new stdClass();
			$response->id = '';
			$response->class_id = '';
			$response->company_id = '';
			$response->approver_id = '';
			$response->condition = '';
			$response->sequence = '';
			$response->approver = '';
			$response->email = '';
			$response->user_id = '';
			return $response;
		}
	}

	function get_users_signatory( $id )
	{
		if( !empty($id) )
			return $this->db->get_where('approver_class_users', array('id' => $id))->row();
		else{
			$response = new stdClass();
			$response->id = '';
			$response->class_id = '';
			$response->company_id = '';
			$response->approver_id = '';
			$response->condition = '';
			$response->sequence = '';
			$response->approver = '';
			$response->email = '';
			$response->user_id = '';
			return $response;
		}
	}

	function check_if_approver( $approver_id )
	{
		$qry = "select * from (";
		$qry .= "select id from {$this->db->dbprefix}approver_class_company where approver_id = {$approver_id} and approver = 1 and deleted = 0 limit 0, 1";
		$qry .= " UNION ";
		$qry .= "select id from {$this->db->dbprefix}approver_class_department where approver_id = {$approver_id} and approver = 1 and deleted = 0 limit 0, 1";
		$qry .= " UNION ";
		$qry .= "select id from {$this->db->dbprefix}approver_class_position where approver_id = {$approver_id} and approver = 1 and deleted = 0 limit 0, 1";
		$qry .= " UNION ";
		$qry .= "select id from {$this->db->dbprefix}approver_class_user where approver_id = {$approver_id} and approver = 1 and deleted = 0 limit 0, 1";
		$qry .= ") as t1";

		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
			return true;
		else
			return false;
	}

	function update_existing_form_approvers($class_id=0, $user_id=0, $position_id=0, $department_id=0, $company_id=0)
	{
		$update_forms_approver_qry = "CALL `sp_approvers_change_applicable`($class_id, $user_id, $position_id, $department_id, $company_id)";
		// $approver_class = $this->db->get_where('approver_class', array('class_id' => $class_id))->row_array();
		// $update_forms_approver_qry = "CALL `sp_time_forms_change_pending_approvers`($user_id, '{$approver_class['class_code']}')";
		$result_update = $this->db->query( $update_forms_approver_qry );
		mysqli_next_result($this->db->conn_id);

		$response = array();
		$response['type'] = "";
		if( $this->db->_error_message() != "" ){
			$response = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}

		return $response;
	}

	function select_existing_pending_forms($class_id=0, $user_id=0, $position_id=0, $department_id=0, $company_id=0)
	{
		$result_rows = 0;

		$qry = "SELECT up.user_id, tf.form_code, tf.date_from 
				FROM {$this->db->dbprefix}approver_class_user acp
				JOIN {$this->db->dbprefix}approver_class ac ON ac.class_id=acp.class_id
				JOIN users_profile up ON acp.position_id = up.position_id AND acp.department_id = up.department_id AND acp.company_id = up.company_id
				JOIN time_forms tf ON tf.user_id=up.user_id AND tf.form_status_id IN (2,3,4,5) AND tf.form_code=ac.class_code
				WHERE acp.user_id = $user_id AND acp.position_id = {$position_id} AND acp.department_id = {$department_id} AND acp.company_id = {$company_id} AND up.active=1 AND ac.class_id=$class_id
				GROUP BY 1,2,3;
				";
		$result = $this->db->query( $qry );

		if($result->num_rows() > 0) {
			// return affected users
			$result_rows = $result->num_rows();

		} else {
			$qry = "SELECT up.user_id, tf.form_code, tf.date_from 
					FROM {$this->db->dbprefix}approver_class_position acp
					JOIN {$this->db->dbprefix}approver_class ac ON ac.class_id=acp.class_id
					JOIN users_profile up ON acp.position_id = up.position_id AND acp.department_id = up.department_id AND acp.company_id = up.company_id
					JOIN time_forms tf ON tf.user_id=up.user_id AND tf.form_status_id IN (2,3,4,5) AND tf.form_code=ac.class_code
					WHERE acp.position_id = {$position_id} AND acp.department_id = {$department_id} AND acp.company_id = {$company_id} AND up.active=1 AND ac.class_id=$class_id
					GROUP BY 1,2,3;
					";
			$result = $this->db->query( $qry );

			if($result->num_rows() > 0) {
				// return affected positions
				$result_rows = $result->num_rows();
			
			} else {
				$qry = "SELECT up.user_id, tf.form_code, tf.date_from 
						FROM {$this->db->dbprefix}approver_class_department acp
						JOIN {$this->db->dbprefix}approver_class ac ON ac.class_id=acp.class_id
						JOIN users_profile up ON acp.department_id = up.department_id AND acp.company_id = up.company_id
						JOIN time_forms tf ON tf.user_id=up.user_id AND tf.form_status_id IN (2,3,4,5) AND tf.form_code=ac.class_code
						WHERE acp.department_id = {$department_id} AND acp.company_id = {$company_id} AND up.active=1 AND ac.class_id=$class_id
						GROUP BY 1,2,3;
						";
				$result = $this->db->query( $qry );

				if($result->num_rows() > 0) {
					// return affected departments
					$result_rows = $result->num_rows();

				} else {
					$qry = "SELECT up.user_id, tf.form_code, tf.date_from 
							FROM {$this->db->dbprefix}approver_class_department acp
							JOIN {$this->db->dbprefix}approver_class ac ON ac.class_id=acp.class_id
							JOIN users_profile up ON acp.company_id = up.company_id
							JOIN time_forms tf ON tf.user_id=up.user_id AND tf.form_status_id IN (2,3,4,5) AND tf.form_code=ac.class_code
							WHERE acp.company_id = {$company_id} AND up.active=1 AND ac.class_id=$class_id
							GROUP BY 1,2,3;
							";
					$result = $this->db->query( $qry );

					if($result->num_rows() > 0) {
						// return affected company
						$result_rows = $result->num_rows();
					} else {
						$result_rows = 0;
					}
				}
			}
		}
		return $result_rows;
	}
	
	public function get_display_name($user_id=0){		
		$sql_display_name = $this->db->get_where('users', array('user_id' => $user_id));
		$display_name = $sql_display_name->row_array();
		return $display_name['display_name'];
	}
	
	public function get_company_details($company_id=0){		
		$sql_company_details = $this->db->get_where('users_company', array('company_id' => $company_id));
		$company_details = $sql_company_details->row_array();
		return $company_details;
	}
	
	public function get_department_details($department_id=0){		
		$sql_department_details = $this->db->get_where('users_department', array('department_id' => $department_id));
		$department_details = $sql_department_details->row_array();
		return $department_details;
	}
	
	public function get_position_details($position_id=0){		
		$sql_position_details = $this->db->get_where('users_position', array('position_id' => $position_id));
		$position_details = $sql_position_details->row_array();
		return $position_details;
	}

	function select_existing_pending_performance($class_id=0, $user_id=0, $position_id=0, $department_id=0, $company_id=0, $user_id=0){
		
		if($user_id > 0){
			$users_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_user acu 
	           		WHERE acu.user_id = {$user_id} 
	           		AND acu.class_id = {$class_id} 
		           	GROUP BY acu.user_id 
	           		";
			$users_result = $this->db->query( $users_qry );

			if($users_result->num_rows() > 0){
				foreach($users_result->result_array() as $row){
					$user_ids[] = $row['user_id'];
				}
			}else{
				$user_ids[] = 0;
			}
		}elseif($position_id > 0){
			$position_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_position acp
           		INNER JOIN users_profile up ON acp.position_id = up.position_id
           		AND acp.department_id = up.department_id 
           		AND acp.company_id = up.company_id
           		WHERE acp.position_id = {$position_id}
           		AND acp.department_id = {$department_id}
           		AND acp.company_id = {$company_id}
           		GROUP BY up.user_id";
			$position_result = $this->db->query( $position_qry );

			if($position_result->num_rows() > 0){
				foreach($position_result->result_array() as $row){
					$user_ids[] = $row['user_id'];
				}
			}else{
				$user_ids[] = 0;
			}
		}elseif($department_id > 0){
			$department_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_department acd
           		INNER JOIN users_profile up ON acd.department_id = up.department_id 
           		AND acd.company_id = up.company_id
           		WHERE acd.department_id = {$department_id}
           		AND acd.company_id = {$company_id}
           		GROUP BY up.user_id";
			$department_result = $this->db->query( $department_qry );

			if($department_result->num_rows() > 0){
				foreach($department_result->result_array() as $row){
					$user_ids[] = $row['user_id'];
				}	
			}else{
				$user_ids[] = 0;
			}
		}elseif($company_id > 0){
			$company_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_company acc
           		INNER JOIN users_profile up ON acc.company_id = up.company_id
           		WHERE acc.company_id = {$company_id}
           		GROUP BY up.user_id";
			$company_result = $this->db->query( $company_qry );

			if($company_result->num_rows() > 0){
				foreach($company_result->result_array() as $row){
					$user_ids[] = $row['user_id'];
				}	
			}else{
				$user_ids[] = 0;
			}
		} else {
			$user_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_user acu
           		INNER JOIN users_profile up ON acu.user_id = up.user_id
           		WHERE acu.user_id = {$user_id}
           		GROUP BY up.user_id";
			$user_result = $this->db->query( $user_qry );

			if($user_result->num_rows() > 0){
				foreach($user_result->result_array() as $row){
					$user_ids[] = $row['user_id'];
				}	
			} else{
				$user_ids[] = 0;
			}
		}

		$select_pending_appraisal_qry = "SELECT  *
											FROM {$this->db->dbprefix}performance_appraisal_applicable pap 
											LEFT JOIN {$this->db->dbprefix}performance_appraisal_approver paa 
											ON pap.appraisal_id = paa.appraisal_id 
											AND pap.user_id = paa.user_id
       								WHERE FIND_IN_SET(pap.user_id, '".implode(',', $user_ids)."') 
       								AND status_id < 4
       								"; 

		$select_pending_planning_qry = "SELECT  *
											FROM {$this->db->dbprefix}performance_planning_applicable pap 
											LEFT JOIN {$this->db->dbprefix}performance_planning_approver paa 
											ON pap.planning_id = paa.planning_id 
											AND pap.user_id = paa.user_id
       								WHERE FIND_IN_SET(pap.user_id, '".implode(',', $user_ids)."') 
       								AND status_id < 4 
       								"; 
		$appraisal = $this->db->query( $select_pending_appraisal_qry );
		$planning = $this->db->query( $select_pending_planning_qry );
		
		return $appraisal->num_rows() + $planning->num_rows();
	}

	function update_existing_performance_approvers($class_id=0, $user_id=0, $position_id=0, $department_id=0, $company_id=0 ,$user_id=0){

		$update_forms_approver_qry = "CALL `sp_approvers_change_applicable`($class_id, $user_id, $position_id, $department_id, $company_id)";
		// $approver_class = $this->db->get_where('approver_class', array('class_id' => $class_id))->row_array();
		// $update_forms_approver_qry = "CALL `sp_time_forms_change_pending_approvers`($user_id, '{$approver_class['class_code']}')";
		$result_update = $this->db->query( $update_forms_approver_qry );
		mysqli_next_result($this->db->conn_id);

		$response = array();
		$response['type'] = "";
		if( $this->db->_error_message() != "" ){
			$response = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}

		// $select_for_update = "SELECT  pap.`planning_id`, pap.`user_id`, paa.approver_id, pap.fullname
		// 				       FROM {$this->db->dbprefix}performance_planning_applicable pap 
		// 				       INNER JOIN {$this->db->dbprefix}performance_planning_approver paa 
		// 				       ON pap.planning_id = paa.planning_id AND pap.user_id = paa.user_id 
		// 					   WHERE FIND_IN_SET(pap.user_id, '".implode(",", $user_ids)."') AND ( status_id > 1 AND status_id < 4)";
		// $notify_sql = $this->db->query($select_for_update);

		// if($notify_sql->num_rows() > 0){
		// 	$notifies = $notify_sql->result_array();
		// 	foreach($notifies as $notify){
		// 		$insert = array(
		// 			'status' => 'info',
		// 			'message_type' => 'Signatories',
		// 			'user_id' => $this->user->user_id,
		// 			'display_name' => $this->mod->get_display_name( $notify['approver_id'] ),
		// 			'feed_content' => "Performance Planning approvers of {$notify['fullname']} has been changed.",
		// 			'recipient_id' => $notify['approver_id']
		// 		);
		// 		$notified[] = $notify['approver_id'];
		// 		$this->db->insert('system_feeds', $insert);
		// 	}
		// }


		return $response;
	}


	function select_existing_pending_change_requests($class_id=0, $position_id=0, $department_id=0, $company_id=0, $user_id = 0){
		$position_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_position acp
           		INNER JOIN users_profile up ON acp.position_id = up.position_id
           		AND acp.department_id = up.department_id 
           		AND acp.company_id = up.company_id
           		WHERE acp.position_id = {$position_id}
           		AND acp.department_id = {$department_id}
           		AND acp.company_id = {$company_id}
           		GROUP BY up.user_id";
		$position_result = $this->db->query( $position_qry );

		if($position_result->num_rows() > 0){
			foreach($position_result->result_array() as $row){
				$user_ids[] = $row['user_id'];
			}	
		}else{
			$department_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_department acd
           		INNER JOIN users_profile up ON acd.department_id = up.department_id 
           		AND acd.company_id = up.company_id
           		WHERE acd.department_id = {$department_id}
           		AND acd.company_id = {$company_id}
           		GROUP BY up.user_id";
			$department_result = $this->db->query( $department_qry );

			if($department_result->num_rows() > 0){
				foreach($department_result->result_array() as $row){
					$user_ids[] = $row['user_id'];
				}	
			}else{
				$company_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_company acc
	           		INNER JOIN users_profile up ON acc.company_id = up.company_id
	           		WHERE acc.company_id = {$company_id}
	           		GROUP BY up.user_id";
				$company_result = $this->db->query( $company_qry );

				if($company_result->num_rows() > 0){
					foreach($company_result->result_array() as $row){
						$user_ids[] = $row['user_id'];
					}	
				} else {
					$user_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_user acu
		           		INNER JOIN users_profile up ON acu.user_id = up.user_id
		           		WHERE acu.user_id = {$user_id}
		           		GROUP BY up.user_id";
					$user_result = $this->db->query( $user_qry );

					if($user_result->num_rows() > 0){
						foreach($user_result->result_array() as $row){
							$user_ids[] = $row['user_id'];
						}	
					} else {
						$user_ids[] = 0;
					}
				}
			}
		}

		$select_pending_change_request_qry = "SELECT  *
											FROM {$this->db->dbprefix}partners_personal_request ppr 
											LEFT JOIN {$this->db->dbprefix}users_profile up 
											ON ppr.partner_id = up.partner_id 
       								WHERE FIND_IN_SET(user_id, '".implode(',', $user_ids)."') 
       								AND status < 3
       								"; 

		$appraisal = $this->db->query( $select_pending_change_request_qry );
		
		return $appraisal->num_rows();
	}


	function select_existing_pending_mrf($class_id=0, $position_id=0, $department_id=0, $company_id=0, $user_id=0){
		$position_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_position acp
           		INNER JOIN users_profile up ON acp.position_id = up.position_id
           		AND acp.department_id = up.department_id 
           		AND acp.company_id = up.company_id
           		WHERE acp.position_id = {$position_id}
           		AND acp.department_id = {$department_id}
           		AND acp.company_id = {$company_id}
           		GROUP BY up.user_id";
		$position_result = $this->db->query( $position_qry );

		if($position_result->num_rows() > 0){
			foreach($position_result->result_array() as $row){
				$user_ids[] = $row['user_id'];
			}	
		}else{
			$department_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_department acd
           		INNER JOIN users_profile up ON acd.department_id = up.department_id 
           		AND acd.company_id = up.company_id
           		WHERE acd.department_id = {$department_id}
           		AND acd.company_id = {$company_id}
           		GROUP BY up.user_id";
			$department_result = $this->db->query( $department_qry );

			if($department_result->num_rows() > 0){
				foreach($department_result->result_array() as $row){
					$user_ids[] = $row['user_id'];
				}	
			}else{
				$company_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_company acc
	           		INNER JOIN users_profile up ON acc.company_id = up.company_id
	           		WHERE acc.company_id = {$company_id}
	           		GROUP BY up.user_id";
				$company_result = $this->db->query( $company_qry );

				if($company_result->num_rows() > 0){
					foreach($company_result->result_array() as $row){
						$user_ids[] = $row['user_id'];
					}	
				} else {
					$user_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_user acu
		           		INNER JOIN users_profile up ON acu.user_id = up.user_id
		           		WHERE acu.user_id = {$user_id}
		           		GROUP BY up.user_id";
					$user_result = $this->db->query( $user_qry );

					if($user_result->num_rows() > 0){
						foreach($user_result->result_array() as $row){
							$user_ids[] = $row['user_id'];
						}	
					} else {
						$user_ids[] = 0;
					}
				}
			}
		}

		$select_pending_mrf_qry = "SELECT  *
											FROM {$this->db->dbprefix}recruitment_request_approver rra 
       								WHERE FIND_IN_SET(approver_id, '".implode(',', $user_ids)."') 
       								AND status_id < 3
       								"; 

		$mrfs = $this->db->query( $select_pending_mrf_qry );
		
		return $mrfs->num_rows();
	}


	function select_existing_pending_erequest($class_id=0, $position_id=0, $department_id=0, $company_id=0, $user_id=0){
		$position_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_position acp
           		INNER JOIN users_profile up ON acp.position_id = up.position_id
           		AND acp.department_id = up.department_id 
           		AND acp.company_id = up.company_id
           		WHERE acp.position_id = {$position_id}
           		AND acp.department_id = {$department_id}
           		AND acp.company_id = {$company_id}
           		GROUP BY up.user_id";
		$position_result = $this->db->query( $position_qry );

		if($position_result->num_rows() > 0){
			foreach($position_result->result_array() as $row){
				$user_ids[] = $row['user_id'];
			}	
		}else{
			$department_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_department acd
           		INNER JOIN users_profile up ON acd.department_id = up.department_id 
           		AND acd.company_id = up.company_id
           		WHERE acd.department_id = {$department_id}
           		AND acd.company_id = {$company_id}
           		GROUP BY up.user_id";
			$department_result = $this->db->query( $department_qry );

			if($department_result->num_rows() > 0){
				foreach($department_result->result_array() as $row){
					$user_ids[] = $row['user_id'];
				}	
			}else{
				$company_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_company acc
	           		INNER JOIN users_profile up ON acc.company_id = up.company_id
	           		WHERE acc.company_id = {$company_id}
	           		GROUP BY up.user_id";
				$company_result = $this->db->query( $company_qry );

				if($company_result->num_rows() > 0){
					foreach($company_result->result_array() as $row){
						$user_ids[] = $row['user_id'];
					}	
				} else {
					$user_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_user acu
		           		INNER JOIN users_profile up ON acu.user_id = up.user_id
		           		WHERE acu.user_id = {$user_id}
		           		GROUP BY up.user_id";
					$user_result = $this->db->query( $user_qry );

					if($user_result->num_rows() > 0){
						foreach($user_result->result_array() as $row){
							$user_ids[] = $row['user_id'];
						}	
					} else {
						$user_ids[] = 0;
					}
				}
			}
		}

		$select_pending_erequest_qry = "SELECT  *
											FROM {$this->db->dbprefix}resources_request_approver ppr 
											LEFT JOIN {$this->db->dbprefix}users_profile up 
											ON ppr.user_id = up.user_id 
       								WHERE FIND_IN_SET(ppr.user_id, '".implode(',', $user_ids)."') 
       								AND request_status_id IN (2,3,5)
       								"; 
// echo "<pre>";echo $select_pending_erequest_qry;
		$erequest = $this->db->query( $select_pending_erequest_qry );
		
		return $erequest->num_rows();
	}

	function select_existing_pending_ir($class_id=0, $position_id=0, $department_id=0, $company_id=0, $user_id=0){
		$position_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_position acp
           		INNER JOIN users_profile up ON acp.position_id = up.position_id
           		AND acp.department_id = up.department_id 
           		AND acp.company_id = up.company_id
           		WHERE acp.position_id = {$position_id}
           		AND acp.department_id = {$department_id}
           		AND acp.company_id = {$company_id}
           		GROUP BY up.user_id";
		$position_result = $this->db->query( $position_qry );

		if($position_result->num_rows() > 0){
			foreach($position_result->result_array() as $row){
				$user_ids[] = $row['user_id'];
			}	
		}else{
			$department_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_department acd
           		INNER JOIN users_profile up ON acd.department_id = up.department_id 
           		AND acd.company_id = up.company_id
           		WHERE acd.department_id = {$department_id}
           		AND acd.company_id = {$company_id}
           		GROUP BY up.user_id";
			$department_result = $this->db->query( $department_qry );

			if($department_result->num_rows() > 0){
				foreach($department_result->result_array() as $row){
					$user_ids[] = $row['user_id'];
				}	
			}else{
				$company_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_company acc
	           		INNER JOIN users_profile up ON acc.company_id = up.company_id
	           		WHERE acc.company_id = {$company_id}
	           		GROUP BY up.user_id";
				$company_result = $this->db->query( $company_qry );

				if($company_result->num_rows() > 0){
					foreach($company_result->result_array() as $row){
						$user_ids[] = $row['user_id'];
					}	
				} else {
					$user_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_user acu
		           		INNER JOIN users_profile up ON acu.user_id = up.user_id
		           		WHERE acu.user_id = {$user_id}
		           		GROUP BY up.user_id";
					$user_result = $this->db->query( $user_qry );

					if($user_result->num_rows() > 0){
						foreach($user_result->result_array() as $row){
							$user_ids[] = $row['user_id'];
						}	
					} else {
						$user_ids[] = 0;
					}
				}
			}
		}

		$select_pending_erequest_qry = "SELECT  *
											FROM {$this->db->dbprefix}partners_incident_approver ppr 
											LEFT JOIN {$this->db->dbprefix}users_profile up 
											ON ppr.user_id = up.user_id 
       								WHERE FIND_IN_SET(ppr.user_id, '".implode(',', $user_ids)."') 
       								AND incident_status_id IN (2,3,5)
       								"; 
// echo "<pre>";echo $select_pending_erequest_qry;
		$erequest = $this->db->query( $select_pending_erequest_qry );
		
		return $erequest->num_rows();
	}

	function select_existing_pending_amp($class_id=0, $position_id=0, $department_id=0, $company_id=0, $user_id=0){
		$position_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_position acp
           		INNER JOIN users_profile up ON acp.position_id = up.position_id
           		AND acp.department_id = up.department_id 
           		AND acp.company_id = up.company_id
           		WHERE acp.position_id = {$position_id}
           		AND acp.department_id = {$department_id}
           		AND acp.company_id = {$company_id}
           		GROUP BY up.user_id";
		$position_result = $this->db->query( $position_qry );

		if($position_result->num_rows() > 0){
			foreach($position_result->result_array() as $row){
				$user_ids[] = $row['user_id'];
			}	
		}else{
			$department_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_department acd
           		INNER JOIN users_profile up ON acd.department_id = up.department_id 
           		AND acd.company_id = up.company_id
           		WHERE acd.department_id = {$department_id}
           		AND acd.company_id = {$company_id}
           		GROUP BY up.user_id";
			$department_result = $this->db->query( $department_qry );

			if($department_result->num_rows() > 0){
				foreach($department_result->result_array() as $row){
					$user_ids[] = $row['user_id'];
				}	
			}else{
				$company_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_company acc
	           		INNER JOIN users_profile up ON acc.company_id = up.company_id
	           		WHERE acc.company_id = {$company_id}
	           		GROUP BY up.user_id";
				$company_result = $this->db->query( $company_qry );

				if($company_result->num_rows() > 0){
					foreach($company_result->result_array() as $row){
						$user_ids[] = $row['user_id'];
					}	
				} else {
					$user_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_user acu
		           		INNER JOIN users_profile up ON acu.user_id = up.user_id
		           		WHERE acu.user_id = {$user_id}
		           		GROUP BY up.user_id";
					$user_result = $this->db->query( $user_qry );

					if($user_result->num_rows() > 0){
						foreach($user_result->result_array() as $row){
							$user_ids[] = $row['user_id'];
						}	
					} else {
						$user_ids[] = 0;
					}
				}
			}
		}

		$select_pending_erequest_qry = "SELECT  *
											FROM {$this->db->dbprefix}recruitment_manpower_plan_approver amp 
											LEFT JOIN {$this->db->dbprefix}users_profile up 
											ON amp.user_id = up.user_id 
       								WHERE FIND_IN_SET(amp.user_id, '".implode(',', $user_ids)."') 
       								AND amp.plan_status_id IN (2,3,5)
       								"; 
// echo "<pre>";echo $select_pending_erequest_qry;
		$erequest = $this->db->query( $select_pending_erequest_qry );
		
		return $erequest->num_rows();
	}

	function select_existing_pending_mv($class_id=0, $position_id=0, $department_id=0, $company_id=0, $user_id=0){
		$position_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_position acp
           		INNER JOIN users_profile up ON acp.position_id = up.position_id
           		AND acp.department_id = up.department_id 
           		AND acp.company_id = up.company_id
           		WHERE acp.position_id = {$position_id}
           		AND acp.department_id = {$department_id}
           		AND acp.company_id = {$company_id}
           		GROUP BY up.user_id";
		$position_result = $this->db->query( $position_qry );

		if($position_result->num_rows() > 0){
			foreach($position_result->result_array() as $row){
				$user_ids[] = $row['user_id'];
			}	
		}else{
			$department_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_department acd
           		INNER JOIN users_profile up ON acd.department_id = up.department_id 
           		AND acd.company_id = up.company_id
           		WHERE acd.department_id = {$department_id}
           		AND acd.company_id = {$company_id}
           		GROUP BY up.user_id";
			$department_result = $this->db->query( $department_qry );

			if($department_result->num_rows() > 0){
				foreach($department_result->result_array() as $row){
					$user_ids[] = $row['user_id'];
				}	
			}else{
				$company_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_company acc
	           		INNER JOIN users_profile up ON acc.company_id = up.company_id
	           		WHERE acc.company_id = {$company_id}
	           		GROUP BY up.user_id";
				$company_result = $this->db->query( $company_qry );

				if($company_result->num_rows() > 0){
					foreach($company_result->result_array() as $row){
						$user_ids[] = $row['user_id'];
					}	
				} else {
					$user_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_user acu
		           		INNER JOIN users_profile up ON acu.user_id = up.user_id
		           		WHERE acu.user_id = {$user_id}
		           		GROUP BY up.user_id";
					$user_result = $this->db->query( $user_qry );

					if($user_result->num_rows() > 0){
						foreach($user_result->result_array() as $row){
							$user_ids[] = $row['user_id'];
						}	
					} else {
						$user_ids[] = 0;
					}
				}
			}
		}

		$select_pending_erequest_qry = "SELECT  *
											FROM {$this->db->dbprefix}partners_movement_approver ppr 
											LEFT JOIN {$this->db->dbprefix}users_profile up 
											ON ppr.user_id = up.user_id 
       								WHERE FIND_IN_SET(ppr.user_id, '".implode(',', $user_ids)."') 
       								AND movement_status_id IN (2)
       								"; 
// echo "<pre>";echo $select_pending_erequest_qry;
		$erequest = $this->db->query( $select_pending_erequest_qry );
		
		return $erequest->num_rows();
	}

	function update_existing_personal_request_approvers($class_id=0, $position_id=0, $department_id=0, $company_id=0, $user_id=0){
		$position_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_position acp
           		INNER JOIN users_profile up ON acp.position_id = up.position_id
           		AND acp.department_id = up.department_id 
           		AND acp.company_id = up.company_id
           		WHERE acp.position_id = {$position_id}
           		AND acp.department_id = {$department_id}
           		AND acp.company_id = {$company_id}
           		GROUP BY up.user_id";
		$position_result = $this->db->query( $position_qry );

		if($position_result->num_rows() > 0){
			foreach($position_result->result_array() as $row){
				$user_ids[] = $row['partner_id'];
			}	
		}else{
			$department_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_department acd
           		INNER JOIN users_profile up ON acd.department_id = up.department_id 
           		AND acd.company_id = up.company_id
           		WHERE acd.department_id = {$department_id}
           		AND acd.company_id = {$company_id}
           		GROUP BY up.user_id";
			$department_result = $this->db->query( $department_qry );

			if($department_result->num_rows() > 0){
				foreach($department_result->result_array() as $row){
					$user_ids[] = $row['partner_id'];
				}	
			}else{
				$company_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_company acc
	           		INNER JOIN users_profile up ON acc.company_id = up.company_id
	           		WHERE acc.company_id = {$company_id}
	           		GROUP BY up.user_id";
				$company_result = $this->db->query( $company_qry );

				if($company_result->num_rows() > 0){
					foreach($company_result->result_array() as $row){
						$user_ids[] = $row['partner_id'];
					}	
				} else {
					$user_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_user acu
		           		INNER JOIN users_profile up ON acu.user_id = up.user_id
		           		WHERE acu.user_id = {$user_id}
		           		GROUP BY up.user_id";
					$user_result = $this->db->query( $user_qry );

					if($user_result->num_rows() > 0){
						foreach($user_result->result_array() as $row){
							$user_ids[] = $row['user_id'];
						}	
					} else {
						$user_ids[] = 0;
					}
				}
			}
		}

		$update_partners_personal_approver_qry = "CALL sp_partners_personal_change_pending_approvers('". implode(",", $user_ids) ."', {$class_id})";
		$result_update = $this->db->query( $update_partners_personal_approver_qry );
		mysqli_next_result($this->db->conn_id);

		$response = array();
		$response['type'] = "";
		if( $this->db->_error_message() != "" ){
			$response = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}

		return $response;
	}

	function update_existing_amp_approvers($class_id=0, $position_id=0, $department_id=0, $company_id=0, $user_id=0){
		$position_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_position acp
           		INNER JOIN users_profile up ON acp.position_id = up.position_id
           		AND acp.department_id = up.department_id 
           		AND acp.company_id = up.company_id
           		WHERE acp.position_id = {$position_id}
           		AND acp.department_id = {$department_id}
           		AND acp.company_id = {$company_id}
           		GROUP BY up.user_id";
		$position_result = $this->db->query( $position_qry );

		if($position_result->num_rows() > 0){
			foreach($position_result->result_array() as $row){
				$user_ids[] = $row['partner_id'];
			}	
		}else{
			$department_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_department acd
           		INNER JOIN users_profile up ON acd.department_id = up.department_id 
           		AND acd.company_id = up.company_id
           		WHERE acd.department_id = {$department_id}
           		AND acd.company_id = {$company_id}
           		GROUP BY up.user_id";
			$department_result = $this->db->query( $department_qry );

			if($department_result->num_rows() > 0){
				foreach($department_result->result_array() as $row){
					$user_ids[] = $row['partner_id'];
				}	
			}else{
				$company_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_company acc
	           		INNER JOIN users_profile up ON acc.company_id = up.company_id
	           		WHERE acc.company_id = {$company_id}
	           		GROUP BY up.user_id";
				$company_result = $this->db->query( $company_qry );

				if($company_result->num_rows() > 0){
					foreach($company_result->result_array() as $row){
						$user_ids[] = $row['partner_id'];
					}	
				} else {
					$user_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_user acu
		           		INNER JOIN users_profile up ON acu.user_id = up.user_id
		           		WHERE acu.user_id = {$user_id}
		           		GROUP BY up.user_id";
					$user_result = $this->db->query( $user_qry );

					if($user_result->num_rows() > 0){
						foreach($user_result->result_array() as $row){
							$user_ids[] = $row['user_id'];
						}	
					} else {
						$user_ids[] = 0;
					}
				}
			}
		}

		$update_partners_personal_approver_qry = "CALL sp_recruitment_manpower_plan_pending_approvers('". implode(",", $user_ids) ."', {$class_id})";
		$result_update = $this->db->query( $update_partners_personal_approver_qry );
		mysqli_next_result($this->db->conn_id);

		$response = array();
		$response['type'] = "";
		if( $this->db->_error_message() != "" ){
			$response = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}

		return $response;
	}

	function update_existing_mrf_approvers($class_id=0, $position_id=0, $department_id=0, $company_id=0, $user_id=0){
		$position_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_position acp
           		INNER JOIN users_profile up ON acp.position_id = up.position_id
           		AND acp.department_id = up.department_id 
           		AND acp.company_id = up.company_id
           		WHERE acp.position_id = {$position_id}
           		AND acp.department_id = {$department_id}
           		AND acp.company_id = {$company_id}
           		GROUP BY up.user_id";
		$position_result = $this->db->query( $position_qry );

		if($position_result->num_rows() > 0){
			foreach($position_result->result_array() as $row){
				$user_ids[] = $row['partner_id'];
			}	
		}else{
			$department_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_department acd
           		INNER JOIN users_profile up ON acd.department_id = up.department_id 
           		AND acd.company_id = up.company_id
           		WHERE acd.department_id = {$department_id}
           		AND acd.company_id = {$company_id}
           		GROUP BY up.user_id";
			$department_result = $this->db->query( $department_qry );

			if($department_result->num_rows() > 0){
				foreach($department_result->result_array() as $row){
					$user_ids[] = $row['partner_id'];
				}	
			}else{
				$company_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_company acc
	           		INNER JOIN users_profile up ON acc.company_id = up.company_id
	           		WHERE acc.company_id = {$company_id}
	           		GROUP BY up.user_id";
				$company_result = $this->db->query( $company_qry );

				if($company_result->num_rows() > 0){
					foreach($company_result->result_array() as $row){
						$user_ids[] = $row['partner_id'];
					}	
				} else {
					$user_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_user acu
		           		INNER JOIN users_profile up ON acu.user_id = up.user_id
		           		WHERE acu.user_id = {$user_id}
		           		GROUP BY up.user_id";
					$user_result = $this->db->query( $user_qry );

					if($user_result->num_rows() > 0){
						foreach($user_result->result_array() as $row){
							$user_ids[] = $row['user_id'];
						}	
					} else {
						$user_ids[] = 0;
					}
				}
			}
		}

		$update_partners_personal_approver_qry = "CALL sp_recruitment_request_pending_approvers('". implode(",", $user_ids) ."', {$class_id})";
		$result_update = $this->db->query( $update_partners_personal_approver_qry );
		mysqli_next_result($this->db->conn_id);

		$response = array();
		$response['type'] = "";
		if( $this->db->_error_message() != "" ){
			$response = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}

		return $response;
	}

	function update_existing_online_request_approvers($class_id=0, $position_id=0, $department_id=0, $company_id=0, $user_id=0){
		$position_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_position acp
           		INNER JOIN users_profile up ON acp.position_id = up.position_id
           		AND acp.department_id = up.department_id 
           		AND acp.company_id = up.company_id
           		WHERE acp.position_id = {$position_id}
           		AND acp.department_id = {$department_id}
           		AND acp.company_id = {$company_id}
           		GROUP BY up.user_id";
		$position_result = $this->db->query( $position_qry );

		if($position_result->num_rows() > 0){
			foreach($position_result->result_array() as $row){
				$user_ids[] = $row['user_id'];
			}	
		}else{
			$department_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_department acd
           		INNER JOIN users_profile up ON acd.department_id = up.department_id 
           		AND acd.company_id = up.company_id
           		WHERE acd.department_id = {$department_id}
           		AND acd.company_id = {$company_id}
           		GROUP BY up.user_id";
			$department_result = $this->db->query( $department_qry );

			if($department_result->num_rows() > 0){
				foreach($department_result->result_array() as $row){
					$user_ids[] = $row['user_id'];
				}	
			}else{
				$company_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_company acc
	           		INNER JOIN users_profile up ON acc.company_id = up.company_id
	           		WHERE acc.company_id = {$company_id}
	           		GROUP BY up.user_id";
				$company_result = $this->db->query( $company_qry );

				if($company_result->num_rows() > 0){
					foreach($company_result->result_array() as $row){
						$user_ids[] = $row['user_id'];
					}	
				} else {
					$user_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_user acu
		           		INNER JOIN users_profile up ON acu.user_id = up.user_id
		           		WHERE acu.user_id = {$user_id}
		           		GROUP BY up.user_id";
					$user_result = $this->db->query( $user_qry );

					if($user_result->num_rows() > 0){
						foreach($user_result->result_array() as $row){
							$user_ids[] = $row['user_id'];
						}	
					} else {
						$user_ids[] = 0;
					}
				}
			}
		}

		$update_partners_personal_approver_qry = "CALL sp_resources_erequest_change_pending_approvers('". implode(",", $user_ids) ."', {$class_id})";
		$result_update = $this->db->query( $update_partners_personal_approver_qry );
		mysqli_next_result($this->db->conn_id);

		$response = array();
		$response['type'] = "";
		if( $this->db->_error_message() != "" ){
			$response = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}

		return $response;
	}

	function update_existing_ir_approvers($class_id=0, $position_id=0, $department_id=0, $company_id=0, $user_id=0){
		$position_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_position acp
           		INNER JOIN users_profile up ON acp.position_id = up.position_id
           		AND acp.department_id = up.department_id 
           		AND acp.company_id = up.company_id
           		WHERE acp.position_id = {$position_id}
           		AND acp.department_id = {$department_id}
           		AND acp.company_id = {$company_id}
           		GROUP BY up.user_id";
		$position_result = $this->db->query( $position_qry );

		if($position_result->num_rows() > 0){
			foreach($position_result->result_array() as $row){
				$user_ids[] = $row['user_id'];
			}	
		}else{
			$department_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_department acd
           		INNER JOIN users_profile up ON acd.department_id = up.department_id 
           		AND acd.company_id = up.company_id
           		WHERE acd.department_id = {$department_id}
           		AND acd.company_id = {$company_id}
           		GROUP BY up.user_id";
			$department_result = $this->db->query( $department_qry );

			if($department_result->num_rows() > 0){
				foreach($department_result->result_array() as $row){
					$user_ids[] = $row['user_id'];
				}	
			}else{
				$company_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_company acc
	           		INNER JOIN users_profile up ON acc.company_id = up.company_id
	           		WHERE acc.company_id = {$company_id}
	           		GROUP BY up.user_id";
				$company_result = $this->db->query( $company_qry );

				if($company_result->num_rows() > 0){
					foreach($company_result->result_array() as $row){
						$user_ids[] = $row['user_id'];
					}	
				} else {
					$user_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_user acu
		           		INNER JOIN users_profile up ON acu.user_id = up.user_id
		           		WHERE acu.user_id = {$user_id}
		           		GROUP BY up.user_id";
					$user_result = $this->db->query( $user_qry );

					if($user_result->num_rows() > 0){
						foreach($user_result->result_array() as $row){
							$user_ids[] = $row['user_id'];
						}	
					} else {
						$user_ids[] = 0;
					}
				}
			}
		}

		$update_partners_personal_approver_qry = "CALL sp_partners_incident_change_pending_approvers('". implode(",", $user_ids) ."', {$class_id})";
		$result_update = $this->db->query( $update_partners_personal_approver_qry );
		mysqli_next_result($this->db->conn_id);

		$response = array();
		$response['type'] = "";
		if( $this->db->_error_message() != "" ){
			$response = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}

		return $response;
	}

	function update_existing_mv_approvers($class_id=0, $position_id=0, $department_id=0, $company_id=0, $user_id=0){
		$position_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_position acp
           		INNER JOIN users_profile up ON acp.position_id = up.position_id
           		AND acp.department_id = up.department_id 
           		AND acp.company_id = up.company_id
           		WHERE acp.position_id = {$position_id}
           		AND acp.department_id = {$department_id}
           		AND acp.company_id = {$company_id}
           		GROUP BY up.user_id";
		$position_result = $this->db->query( $position_qry );

		if($position_result->num_rows() > 0){
			foreach($position_result->result_array() as $row){
				$user_ids[] = $row['user_id'];
			}	
		}else{
			$department_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_department acd
           		INNER JOIN users_profile up ON acd.department_id = up.department_id 
           		AND acd.company_id = up.company_id
           		WHERE acd.department_id = {$department_id}
           		AND acd.company_id = {$company_id}
           		GROUP BY up.user_id";
			$department_result = $this->db->query( $department_qry );

			if($department_result->num_rows() > 0){
				foreach($department_result->result_array() as $row){
					$user_ids[] = $row['user_id'];
				}	
			}else{
				$company_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_company acc
	           		INNER JOIN users_profile up ON acc.company_id = up.company_id
	           		WHERE acc.company_id = {$company_id}
	           		GROUP BY up.user_id";
				$company_result = $this->db->query( $company_qry );

				if($company_result->num_rows() > 0){
					foreach($company_result->result_array() as $row){
						$user_ids[] = $row['user_id'];
					}	
				} else {
					$user_qry = "SELECT * FROM {$this->db->dbprefix}approver_class_user acu
		           		INNER JOIN users_profile up ON acu.user_id = up.user_id
		           		WHERE acu.user_id = {$user_id}
		           		GROUP BY up.user_id";
					$user_result = $this->db->query( $user_qry );

					if($user_result->num_rows() > 0){
						foreach($user_result->result_array() as $row){
							$user_ids[] = $row['user_id'];
						}	
					} else {
						$user_ids[] = 0;
					}
				}
			}
		}

		$update_partners_personal_approver_qry = "CALL sp_partners_movement_change_pending_approvers('". implode(",", $user_ids) ."', {$class_id})";
		$result_update = $this->db->query( $update_partners_personal_approver_qry );
		mysqli_next_result($this->db->conn_id);

		$response = array();
		$response['type'] = "";
		if( $this->db->_error_message() != "" ){
			$response = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}

		return $response;
	}

	function delete_users_signatory( $records )
	{
		$response = new stdClass();

		$data['modified_on'] = date('Y-m-d H:i:s');
		$data['modified_by'] = $this->user->user_id;
		$data['deleted'] = 1;

		$this->db->where_in('id', $records);
		$this->db->update('approver_class_users', $data);
		
		if( $this->db->_error_message() != "" ){
			$response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}
		else{
			$response->message[] = array(
				'message' => lang('common.delete_record', $this->db->affected_rows()),
				'type' => 'success'
			);
		}

		return $response;
	}

}