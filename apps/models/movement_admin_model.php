<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class movement_admin_model extends Record
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
		$this->mod_id = 258;
		$this->mod_code = 'movement_admin';
		$this->route = 'partners/admin/movement_admin';
		$this->url = site_url('partners/admin/movement_admin');
		$this->primary_key = 'movement_id';
		$this->table = 'partners_movement';
		$this->icon = 'fa-user';
		$this->short_name = 'Employee Movement Admin';
		$this->long_name  = 'Employee Movement Admin';
		$this->description = 'Manage Employee Movement';
		$this->path = APPPATH . 'modules/movement_admin/';

		parent::__construct();
	}

	function _get_list($start, $limit, $search, $filter, $trash = false)
	{
		$data = array();	
		$user = $this->config->item('user');			

		$role_permission = $this->get_role_permission(22);		
		
		$qry = $this->_get_list_cached_query();
		
		if( $trash )
		{
			$qry .= " AND ww_partners_movement.deleted = 1";
		}
		else{
			$qry .= " AND ww_partners_movement.deleted = 0";	
		}
		
		//$qry .= " AND (T6.user_id = " . $this->user->user_id . " AND T6.movement_status_id >= 2) OR ww_partners_movement.created_by = " . $this->user->user_id;
		$qry .= " AND ww_partners_movement.status_id > 2";

		if (count($role_permission) > 0 && in_array($user['role_id'], $role_permission)){
			//$qry .= " AND (ww_partners_movement.status_id = 6 OR (ww_partners_movement.status_id > 6 AND ".$this->user->user_id." IN (SELECT user_id FROM ww_partners_movement_approver_hr WHERE movement_id = ww_partners_movement.`movement_id`))) OR (ww_partners_movement.status_id > 6 AND ww_partners_movement.`created_by` = ".$this->user->user_id.")";
			$qry .= " AND ((ww_partners_movement.status_id >= 6 OR (ww_partners_movement.status_id > 6 AND ".$this->user->user_id." IN (SELECT user_id FROM ww_partners_movement_approver_hr WHERE movement_id = ww_partners_movement.`movement_id`))) OR (ww_partners_movement.status_id > 6 AND ww_partners_movement.`created_by` = ".$this->user->user_id."))";

	        $qry_category = $this->mod->get_role_category();

	        if ($qry_category != ''){
	            $qry .= ' AND ' . $qry_category;
	        }			
		}

		$filter .= ' GROUP BY record_id ORDER BY ww_partners_movement.created_on DESC';

		$qry .= ' '. $filter;
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );

		if($result && $result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				// to get hr approval status
				$this->db->where('movement_id',$row['record_id']);
				$this->db->where('movement_status_id',9);
				$this->db->where('user_id',$this->user->user_id);
				$hr_approver = $this->db->get('partners_movement_approver_hr');

				if ($hr_approver && $hr_approver->num_rows() > 0){
					$row['hr_approver_movement_status_id'] = 9;
				}
				else{
					$row['hr_approver_movement_status_id'] = 1;
				}
				// to get hr approval status
				$row['hr_admin_movement'] = 0;
				if (count($role_permission) > 0 && in_array($user['role_id'], $role_permission)){
					$row['hr_admin_movement'] = 1;
				}				

				$data[] = $row;
			}
		}

		return $data;
	}

	function transfer_to_validation($movement_details=array()){
		$data = array( 'status_id' => 6 ); // set status to 'For Validation'
		$this->db->update( 'partners_movement', $data, array('movement_id' => $movement_details['movement_id']) );

        $this->notify_hr_validation($movement_details);
	}

	function notify_hr_validation($movement_details=array()){
		$this->load->model('movement_admin_model', 'mva');

		$hr_movement = $this->get_role_permission(22);

		if (count($hr_movement) > 0){
			$this->db->where_in('role_id',$hr_movement);
			$this->db->where('active',1);
			$this->db->where('deleted',0);  			
			$hr_admin = $this->db->get('users')->result_array();

            $current_user = array();
            $current_user = $this->db->get_where('users',array('user_id' => $this->session->userdata['user']->user_id))->row();

			foreach( $hr_admin as $hr_admin )
			{
				$qry_category = $this->get_role_category('',$hr_admin['role_id']);

				$to_check = false;
		        if ($qry_category != ''){
		            $this->db->where($qry_category, '', false);
		            $to_check = true;
		        }   

		        $this->db->where('email',trim($hr_admin['email']));
		        $this->db->join('users_profile','users.user_id = users_profile.user_id');
				$result = $this->db->get( 'users');

				if ($result && $result->num_rows() > 0){
					$users = $result->row_array();

					if ($to_check){
				        if ($qry_category != ''){
				            $this->db->where($qry_category, '', false);

					        $this->db->where('users.user_id',$movement_details['user_id']);
					        $this->db->join('users_profile','users.user_id = users_profile.user_id');
							$result1 = $this->db->get( 'users');
							if ($result1 && $result1->num_rows() > 0){
					            $data['user_id']        	= $current_user->user_id;
					            $data['display_name']   	= $current_user->full_name;
					            $data['feed_content']  		= 'Movement filed by '.$movement_details['display_name'].
					            							  ' has been disapproved and is now for HR validation';                                                           // THE MAIN FEED BODY
					            $data['recipient_id']   	= $users['user_id'];                                                               // TO WHOM THIS POST IS INTENDED TO
					            $data['status']         	= 'info';                                                                   // DANGER, INFO, SUCCESS & WARNING
					            $data['message_type']       = 'Movement';
					            $data['movement_id'] 		= $movement_details['movement_id'];
					            
					            // ADD NEW DATA FEED ENTRY
					            $latest = $this->newPostData($data,$this->mva->url);
								$sp_time_forms_email_hr_validation = $this->db->query("CALL sp_partners_movement_email_hr_approval({$movement_details['movement_id']}, {$users['user_id']},'disapproved')");
								mysqli_next_result($this->db->conn_id);
							}						            
				        }   				
					}
					else {
			            $data['user_id']        	= $current_user->user_id;
			            $data['display_name']   	= $current_user->full_name;
			            $data['feed_content']  		= 'Movement filed by '.$movement_details['display_name'].
			            							  ' has been disapproved and is now for HR validation';                                                           // THE MAIN FEED BODY
			            $data['recipient_id']   	= $users['user_id'];                                                               // TO WHOM THIS POST IS INTENDED TO
			            $data['status']         	= 'info';                                                                   // DANGER, INFO, SUCCESS & WARNING
			            $data['message_type']       = 'Movement';
			            $data['movement_id'] 		= $movement_details['movement_id'];
			            
			            // ADD NEW DATA FEED ENTRY
			            $latest = $this->newPostData($data,$this->mva->url);
						$sp_time_forms_email_hr_validation = $this->db->query("CALL sp_partners_movement_email_hr_approval({$movement_details['movement_id']}, {$users['user_id']},'disapproved')");
						mysqli_next_result($this->db->conn_id);
					}
				}
			}
		}
	}	

	public function get_movement_header($movement_id){
		$this->db->where('movement_id',$movement_id);
		$this->db->join('users','partners_movement.created_by = users.user_id');
		$hr_approver = $this->db->get('partners_movement');

		if ($hr_approver && $hr_approver->num_rows() > 0){
			return $hr_approver->row_array();
		}
		else{
			return array();
		}
	}

	public function get_hr_approver_status($movement_id){
		$this->db->where('movement_id',$movement_id);
		$this->db->where('movement_status_id',9);
		$this->db->where('user_id',$this->user->user_id);
		$hr_approver = $this->db->get('partners_movement_approver_hr');

		if ($hr_approver && $hr_approver->num_rows() > 0){
			return 9;
		}
		else{
			return 1;
		}
	}

	public function _get_list_cached_query()
	{
		$this->load->config('list_cached_query_custom');
		return $this->config->item('list_cached_query');	
	}

	function getTransferFields(){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_fields WHERE from_to = 1 "; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_employee_details($user_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT *, 
		'' AS rank_id, 
		'' AS rank
		 FROM partner_movement_current WHERE user_id = {$user_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result && $result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}

			$result->free_result();			
		}
			
		return $data;	
	}

	public function get_approver_hr($movement_id=0){ 
		$qry = "SELECT *
			FROM ww_partners_movement_approver_hr WHERE movement_id = {$movement_id} ORDER BY sequence"; // WHERE user_id = '$userID';
		
		$result = $this->db->query($qry);
		
		if ($result && $result->num_rows() > 0){
			return $result->result_array();
		}
		else{
			return array();
		}
	}

	function getPayrollAllowanceTransaction(){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}payroll_transaction WHERE show_in_movement = 1 AND deleted = 0"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_employee_allowance($user_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT *, 
		'' AS rank_id, 
		'' AS rank
		 FROM partner_movement_current WHERE user_id = {$user_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_employee_allowance_details($user_id=0){ 
		$qry = "SELECT *,CAST( AES_DECRYPT( `pere`.`amount`, encryption_key()) AS CHAR) as 'total_amount'
		FROM {$this->db->dbprefix}payroll_entry_recurring per
		LEFT JOIN {$this->db->dbprefix}payroll_entry_recurring_employee pere ON per.recurring_id = pere.recurring_id
		WHERE pere.employee_id = {$user_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result && $result->num_rows() > 0){
			foreach ($result->result() as $row) {
				$data[$row->transaction_id] = trim($row->total_amount);
			}
		}

		return $data;
	}

	public function get_movement_details($movement_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT 
				pmove.movement_id,
				pmove.status_id,
				pmove.due_to_id,
				pmove.remarks AS movement_remarks,
				pmoveact.action_id,
				pmoveact.user_id,
				pmoveact.effectivity_date,
				pmoveact.type_id,
				pmoveact.type,
				pmoveremarks.remarks_print_report AS action_remarks,
				pmoveact.action_id,
				pmoveact.display_name,
				pmoveastat.status,
				pmoveact.status_id as act_status_id,
				pmoveact.photo,
				pmoveactm.further_reason,
				pmoveactr.reason
				FROM {$this->db->dbprefix}partners_movement pmove
				LEFT JOIN {$this->db->dbprefix}partners_movement_action pmoveact 
				ON pmove.movement_id = pmoveact.movement_id 
				LEFT JOIN {$this->db->dbprefix}partners_movement_action_moving pmoveactm
				ON pmoveact.action_id = pmoveactm.action_id 	
				LEFT JOIN {$this->db->dbprefix}partners_movement_reason pmoveactr
				ON pmoveactm.reason_id = pmoveactr.reason_id 	
				LEFT JOIN {$this->db->dbprefix}partners_movement_remarks pmoveremarks
				ON pmoveremarks.remarks_print_report_id = pmoveact.remarks_print_report_id 											
				LEFT JOIN {$this->db->dbprefix}partners_movement_status pmoveastat 
				ON pmove.status_id = pmoveastat.status_id 
				WHERE pmove.movement_id = {$movement_id}
				AND pmoveact.deleted = 0
				ORDER BY pmoveact.effectivity_date DESC"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_action_movement($action_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action pma
				LEFT JOIN {$this->db->dbprefix}users u ON pma.user_id = u.user_id
				LEFT JOIN {$this->db->dbprefix}partners_movement_remarks pmr ON pmr.remarks_print_report_id = pma.remarks_print_report_id
				WHERE pma.action_id = {$action_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_action_movement_attachment($action_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_attachment pmaa
				WHERE pmaa.action_id = {$action_id} AND deleted = 0";
		$result = $this->db->query($qry);
		
		if($result && $result->num_rows() > 0){
			$data = $result->result();		
		}
			
		$result->free_result();
		return $data;	
	}	

	public function get_extension_movement($action_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_extension
				WHERE action_id = {$action_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_moving_movement($action_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_moving pmam
				LEFT JOIN {$this->db->dbprefix}partners_movement_reason pmr ON pmam.reason_id = pmr.reason_id
				WHERE pmam.action_id = {$action_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_compensation_movement($action_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_compensation
				WHERE action_id = {$action_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_transfer_movement($action_id=0, $field_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_transfer
				WHERE action_id = {$action_id} 
				AND field_id = {$field_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	public function get_additional_allowance_movement($action_id=0, $field_id=0){ 
		
		// should this display all employee's birthday? 
		// or should birthday feeds be filtered via company, division, etc?

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_additional_allowance
				WHERE action_id = {$action_id} 
				AND transaction_id = {$field_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result && $result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	function get_partners_personal($user_id=0, $partners_personal_table='', $key='', $sequence=0){
		$this->db->select('personal_id, key_value')
	    ->from($partners_personal_table)
	    ->join('partners', $partners_personal_table.'.partner_id = partners.partner_id', 'left')
	    ->where("partners.user_id = $user_id")
	    ->where($partners_personal_table.".key = '$key'");
	    if($sequence != 0)
	    	$this->db->where($partners_personal_table.".sequence = '$sequence'");

		if($partners_personal_table == 'partners_personal'){
	    	$this->db->where("partners_personal.deleted = 0");
	    }

	    $partners_personal = $this->db->get('');	
	    
		if( $partners_personal->num_rows() > 0 )
	    	return $partners_personal->row_array();
	    else
	    	return array();
	}

    // print movement information
    function export_pdf( $movement_id ){
    	$user = $this->config->item('user');

        $this->load->library('PDFm');

        $mpdf = new PDFm();
        $mpdf->SetTitle( 'Movement Info Sheet' );
		$mpdf->SetFontSize(8,true);
		$mpdf->SetAutoPageBreak(true, 5);
        $mpdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $mpdf->SetDisplayMode('real', 'default');
        $mpdf->AddPage();

		$reason_qry = "SELECT GROUP_CONCAT(`T1`.`remarks_print_report` SEPARATOR ', ') AS remarks_print_report
				FROM (`ww_partners_movement_action`)
				LEFT JOIN `ww_partners_movement_remarks` T1 ON `T1`.`remarks_print_report_id` = `ww_partners_movement_action`.`remarks_print_report_id`
				WHERE ww_partners_movement_action.movement_id = {$movement_id}";

		$result_remarks = $this->db->query($reason_qry);

		$print_remarks = '';
		if ($result_remarks && $result_remarks->num_rows() > 0){
			$movement_info_remarks = $result_remarks->row();
			$print_remarks = $movement_info_remarks->remarks_print_report;
		}

		$query = "SELECT CONCAT(up.lastname,', ',up.firstname,' ',SUBSTRING(up.middlename, 1, 1),'.') as fullname,pm.hrd_remarks,uc.company,uc.company_code,ub.branch,pma.user_id,p.status,upos.position,udep.department,jgl.job_level,pma.display_name,u.full_name as reports_to,pma.effectivity_date,pmr.remarks_print_report,pm.remarks as reason,p.effectivity_date as date_hired,id_number,sss_no,pp.tin FROM {$this->db->dbprefix}partners_movement pm
				  LEFT JOIN {$this->db->dbprefix}partners_movement_action pma ON pm.movement_id = pma.movement_id
				  LEFT JOIN {$this->db->dbprefix}partners_movement_remarks pmr ON pm.remarks_print_report_id = pmr.remarks_print_report_id
				  LEFT JOIN {$this->db->dbprefix}partners p ON p.user_id = pma.user_id
				  LEFT JOIN {$this->db->dbprefix}users_job_grade_level jgl ON p.job_grade_id = jgl.job_grade_id
				  LEFT JOIN {$this->db->dbprefix}payroll_partners pp ON p.user_id = pp.user_id
				  LEFT JOIN {$this->db->dbprefix}users_profile up ON p.user_id = up.user_id
				  LEFT JOIN {$this->db->dbprefix}users_position upos ON upos.position_id = up.position_id
				  LEFT JOIN {$this->db->dbprefix}users_department udep ON udep.department_id = up.department_id
				  LEFT JOIN {$this->db->dbprefix}users_branch ub ON ub.branch_id = up.branch_id
				  LEFT JOIN {$this->db->dbprefix}users_company uc ON uc.company_id = up.company_id
				  LEFT JOIN {$this->db->dbprefix}users u ON up.reports_to_id = u.user_id
				  WHERE pm.movement_id = {$movement_id}
				 ";
		$result = $this->db->query($query);

		if ($result && $result->num_rows() > 0){
			$movement_info = $result->row();
		}

		$this->db->where('movement_id',$movement_id);
		$this->db->join('users','partners_movement_approver_hr.user_id = users.user_id');
		$this->db->order_by('sequence','DESC');
		$this->db->limit(2);
		$signatory_result = $this->db->get('partners_movement_approver_hr');

		$approved_by = '';
		$reviewed_by = '';

		if ($signatory_result && $signatory_result->num_rows() > 0){
			$signatory = $signatory_result->result_array();
			$approved_by = $signatory[0]['full_name'];
			$reviewed_by = $signatory[1]['full_name'];
		}

		$html = '<h4 align="center" style="border-top:1px solid black; border-bottom: 1px solid black;margin:0;font-size:11;">Employee Movement Report</h3>';

		$html .= '<table width="100%">
					<tbody>
						<tr>
							<td width="15%" style="font-size:10;">Name</td>
							<td width="35%" style="text-align:left;font-size:10;">'.$movement_info->fullname.'</td>
							<td width="15%" style="text-align:right;font-size:10;font-size:10;">Effective Date</td>
							<td width="35%" style="text-align:left;font-size:10;padding-left:60px;">'.date('M d, Y',strtotime($movement_info->effectivity_date)).'</td>							
						</tr>
						<tr>
							<td style="font-size:10;">Reason</td>
							<td style="font-size:10;">'.$print_remarks.'</td>
							<td style="font-size:10;text-align:right;">&nbsp;</td>
							<td style="font-size:10;text-align:left;padding-left:60px">&nbsp;</td>							
						</tr>						
					</tbody>
				</table>';

		$html .= '<table width="100%" style="border-top:1px solid black; border-bottom: 1px solid black;">
					<tbody>
						<tr>
							<td width="15%" style="font-size:10;">Date Printed</td>
							<td width="35%" style="text-align:left;font-size:10;">'.date('m/d/Y').'</td>
							<td width="15%" style="font-size:10;text-align:right;">< FROM ></td>
							<td width="35%" style="text-align:right;font-size:10;padding-right:10px">< TO ></td>							
						</tr>					
					</tbody>
				</table>';

		$query = "SELECT *,pmf.field_name AS pmf_field_name FROM {$this->db->dbprefix}partners_movement_fields pmf
				  LEFT JOIN (SELECT * FROM {$this->db->dbprefix}partners_movement_action_transfer WHERE movement_id = {$movement_id}) AS pmat ON pmf.field_id = pmat.field_id
				  WHERE pmf.field_name IN ('company','branch','employment_status','position','job_level','department') GROUP BY pmf.field_id ORDER BY orderby
				 ";
		$result = $this->db->query($query);

		$query2 = "SELECT * FROM {$this->db->dbprefix}partners_movement_action_compensation
				  WHERE movement_id = {$movement_id}
				 ";
		$result2 = $this->db->query($query2);

		$total_pay_from  = 0;
		$total_pay_to  = 0;
		$from_salary = 0;
		$to_salary = 0;
		if ($result2 && $result2->num_rows() > 0){
			$row2 = $result2->row();
			$from_salary = $row2->current_salary;
			$to_salary = $row2->to_salary;	
			$total_pay_from  += $from_salary;
			$total_pay_to += $to_salary;					
		}
		else{
			$salary_qry = "SELECT CAST( AES_DECRYPT( `ww_payroll_partners`.`salary`, encryption_key()) AS CHAR) as salary FROM {$this->db->dbprefix}payroll_partners
					  WHERE user_id = {$movement_info->user_id}
					 ";
			$salary_result = $this->db->query($salary_qry);	
			if ($salary_result && $salary_result->num_rows() > 0){
				$salary_row = $salary_result->row();
				$from_salary = ($salary_row->salary != NULL ? $salary_row->salary : 0);
				$to_salary = ($salary_row->salary != NULL ? $salary_row->salary : 0);

				$total_pay_from  += $from_salary;
				$total_pay_to += $to_salary;					
			}		
		}

		$html .= '<table width="100%" style="border-bottom: 1px solid black;">
					<tbody>';

		if ($result && $result->num_rows() > 0){
			foreach ($result->result() as $row) {
				$from_name = $row->from_name;
				$to_name = $row->to_name;
				if ($row->to_name == '' OR $row->to_name == 'NULL'){
					switch ($row->pmf_field_name) {
						case 'company':
							$from_name = $movement_info->company_code;
							$to_name = $movement_info->company_code;
							break;	
						case 'branch':
							$from_name = $movement_info->branch;
							$to_name = $movement_info->branch;
							break;													
						case 'department':
							$from_name = $movement_info->department;
							$to_name = $movement_info->department;
							break;
						case 'position':
							$from_name = $movement_info->position;
							$to_name = $movement_info->position;
							break;
						case 'employment_status':
							$from_name = $movement_info->status;
							$to_name = $movement_info->status;
							break;
						case 'job_level':
							$from_name = $movement_info->job_level;
							$to_name = $movement_info->job_level;
							break;						
					}
				}

				$html .= '<tr>
							<td width="25%" style="font-size:10;padding-left:20px">'.$row->field_label.'</td>
							<td width="40%" style="font-size:10;font-weight:bold;text-align:right;">'.($from_name != NULL ? $from_name : '').'</td>
							<td width="35%" style="font-size:10;font-weight:bold;text-align:right;padding-right:10px;">'.($to_name != NULL ? $to_name : '').'</td>						
						</tr>';					
			}
		}

		$html .= '<tr>
					<td width="25%" style="font-size:10;padding-left:20px">Basic Pay</td>
					<td width="40%" style="font-size:10;font-weight:bold;text-align:right;">'.number_format($from_salary, 2, '.', ',').'</td>
					<td width="35%" style="font-size:10;font-weight:bold;text-align:right;padding-right:10px;">'.number_format($to_salary, 2, '.', ',').'</td>						
				</tr>';	


		$query1 = "SELECT pt.transaction_label,pmaaa.from_allowance,pmaaa.to_allowance,pt.transaction_id FROM {$this->db->dbprefix}payroll_transaction pt
				  LEFT JOIN (SELECT * FROM {$this->db->dbprefix}partners_movement_action_additional_allowance WHERE movement_id = {$movement_id}) AS pmaaa ON pt.transaction_id = pmaaa.transaction_id
				  WHERE pt.show_in_movement = 1
				 ";
		$result1 = $this->db->query($query1);

		if ($result1 && $result1->num_rows() > 0){
			foreach ($result1->result() as $row1) {
				$total_pay_from  += ($row1->from_allowance != '' ? $row1->from_allowance : 0);
				$total_pay_to += ($row1->to_allowance != '' ? $row1->to_allowance : 0);		
				$from_allowance = ($row1->from_allowance != '' ? $row1->from_allowance : 0);		
				$to_allowance = ($row1->to_allowance != '' ? $row1->to_allowance : 0);

				if ($from_allowance == 0 && $to_allowance == 0){
					$allowance_qry = "SELECT CAST( AES_DECRYPT( `ere`.`amount`, encryption_key()) AS CHAR) as allowance FROM {$this->db->dbprefix}payroll_entry_recurring_employee ere
							  LEFT JOIN {$this->db->dbprefix}payroll_entry_recurring ec ON ere.recurring_id = ec.recurring_id
							  WHERE ec.transaction_id = {$row1->transaction_id} AND ere.employee_id = {$movement_info->user_id}
							 ";
					$allowance_result = $this->db->query($allowance_qry);	
					if ($allowance_result && $allowance_result->num_rows() > 0){
						$allowance_row = $allowance_result->row();

						$from_allowance = $allowance_row->allowance;
						$to_allowance = $allowance_row->allowance;

						$total_pay_from  += $from_allowance;
						$total_pay_to += $to_allowance;						
					}	
				}

				$html .= '<tr>
							<td width="25%" style="font-size:10;padding-left:20px">'.$row1->transaction_label.'</td>
							<td width="40%" style="font-size:10;font-weight:bold;text-align:right;">'.number_format($from_allowance, 2, '.', ',').'</td>
							<td width="35%" style="font-size:10;font-weight:bold;text-align:right;padding-right:10px;">'.number_format($to_allowance, 2, '.', ',').'</td>						
						</tr>';					
			}
		}		

		$html .= '<tr>
					<td width="25%" style="font-size:10;padding-left:20px">Total Pay</td>
					<td width="40%" style="font-size:10;font-weight:bold;text-align:right;border-top: 1px solid black;">'.number_format($total_pay_from, 2, '.', ',').'</td>
					<td width="35%" style="font-size:10;font-weight:bold;text-align:right;padding-right:10px;border-top: 1px solid black;">'.number_format($total_pay_to, 2, '.', ',').'</td>						
				</tr>';		

		$html .= '</tbody>
			</table>';

		$html .= '<table width="100%">
					<tbody>
						<tr>
							<td width="12%" style="font-size:10;">Personnel ID NO:</td>
							<td width="12%" style="text-align:left;font-size:10;">'.$movement_info->id_number.'</td>
							<td width="12%" style="font-size:10;text-align:right;">Date Hired:</td>
							<td width="12%" style="text-align:right;font-size:10;padding-right:10px">'.date('m/d/Y',strtotime($movement_info->date_hired)).'</td>	
							<td width="12%" style="font-size:10;text-align:right;">TIN:</td>
							<td width="12%" style="text-align:right;font-size:10;padding-right:10px">'.$movement_info->tin.'</td>	
							<td width="12%" style="font-size:10;text-align:right;">SSS #:</td>
							<td width="12%" style="text-align:right;font-size:10;">'.$movement_info->sss_no.'</td>																					
						</tr>		
						<tr>
							<td width="15%" style="font-size:10;">Remarks</td>	
							<td width="85%" style="font-size:10;" colspan="7">'.$movement_info->hrd_remarks.'</td>																		
						</tr>										
					</tbody>
				</table><br /><br />';

		$html .= '<table width="100%">
					<tbody>
						<tr>
							<td width="25%" style="text-align:center;font-size:10;">Recommended By</td>
							<td width="25%" style="text-align:center;font-size:10;">Reviewed By</td>
							<td width="25%" style="text-align:center;font-size:10;">Approved By</td>
							<td width="25%" style="text-align:center;font-size:10">Received By</td>																					
						</tr>						
						<tr>
							<td width="25%" style="text-align:center;font-size:10;">&nbsp;</td>
							<td width="25%" style="text-align:center;font-size:10;">'.$reviewed_by.'</td>
							<td width="25%" style="text-align:center;font-size:10;">'.$approved_by.'</td>
							<td width="25%" style="text-align:center;font-size:10">'.$movement_info->fullname.'</td>																					
						</tr>																
					</tbody>
				</table>';

		$html .= '<br /><br /><table width="100%">
					<tbody>
						<tr>
							<td style="text-align:left;font-size:10;">"Honor the Lord with your wealth, with the firstfruits of all your crops" <i>- Proverbs 3:9 (NIV) </i></td>
						</tr>																					
					</tbody>
				</table>';

        $path = 'uploads/templates/movement/pdf/';
        $this->check_path( $path );
        $filename = $path . "movement_info.pdf";

        $mpdf->WriteHTML($html);
        $mpdf->Output($filename, 'F');

        return $filename;
    }

	function export_excel( $movement_id )
	{
		ini_set('memory_limit', '1024M');   
        ini_set('max_execution_time', 1800);

		$this->load->helper('file');
		$path = 'uploads/reports/movement/excel/';
		$this->check_path( $path );
		$filename = $path . strtotime(date('Y-m-d H:i:s')) . 'Movement' . ".xlsx";

		$this->load->library('excel');

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setTitle("Movement Report")
		            ->setDescription("Movement Report");
		               
		// Assign cell values
		$objPHPExcel->setActiveSheetIndex(0);
		$activeSheet = $objPHPExcel->getActiveSheet();

		//header
		$alphabet  = range('A','Z');
		$alpha_ctr = 0;
		$sub_ctr   = 0;				

	    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);

		//Initialize style
		$styleArray = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		);

		$bold = array(
			'font' => array(
				'bold' => true,
			)
		);

		$leftstyleArray = array(
			'font' => array(
				'italic' => true,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		);

		$center = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		);

        $border_bottom = array(
            'borders' => array(
                'bottom' =>array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );

        $border_top = array(
            'borders' => array(
                'top' =>array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );

        $border_right = array(
            'borders' => array(
                'right' =>array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );

        $border_left = array(
            'borders' => array(
                'left' =>array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );

		$border_style = array(
			'borders' => array(
			    'allborders' => array(
			      'style' => PHPExcel_Style_Border::BORDER_THIN
			    )
			  )
			);

		$objPHPExcel->getActiveSheet()->setShowGridlines(false);

		$line = 1;
		$xcoor = $alphabet[$alpha_ctr];

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'NOTICE OF PERSONNEL ACTION - DAILY');
		$activeSheet->getStyle($xcoor.$line)->applyFromArray($bold);	
		$activeSheet->getStyle($xcoor.$line)->getFont()->setSize(16);

		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'RIOFIL CORPORATION');
		$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Units 1704-1706 Hanston Square');
		$objPHPExcel->getActiveSheet()->setCellValue('D3', '17 San Miguel Ave., Ortigas Center');
		$objPHPExcel->getActiveSheet()->setCellValue('D4', 'Pasig City');

		$this->db->where('partners_movement.movement_id',$movement_id);
		$this->db->join('partners_movement_action','partners_movement.movement_id = partners_movement_action.movement_id');
		$movement = $this->db->get('partners_movement');

		$action_id = '';
		if ($movement && $movement->num_rows() > 0){
			$movement_data = $movement->row();
			$action_id = $movement_data->action_id;

			$partners = $this->db->get_where('partners',array('user_id' => $movement_data->user_id));
			if ($partners && $partners->num_rows() > 0){
				$partners_info = $partners->row();
			}

			$objPHPExcel->getActiveSheet()->setCellValue('B8', date('d M Y',strtotime($movement_data->effectivity_date)));
			$objPHPExcel->getActiveSheet()->setCellValue('B9', $movement_data->display_name);
			$objPHPExcel->getActiveSheet()->setCellValue('B10', $movement_data->type);

			switch ($partners_info->status_id) {
				case 1:
					$objPHPExcel->getActiveSheet()->setCellValue('E9', 'X');
					$activeSheet->getStyle('E9')->applyFromArray($center);
					break;
				case 2:
					$objPHPExcel->getActiveSheet()->setCellValue('G9', 'X');
					$activeSheet->getStyle('G9')->applyFromArray($center);
					break;
				case 4:
					$objPHPExcel->getActiveSheet()->setCellValue('I9', 'X');
					$activeSheet->getStyle('I9')->applyFromArray($center);
					break;										
			}
		}

		$line = 8;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'EFFECTIVE DATE        :');
		$activeSheet->getStyle($xcoor.$line)->getFont()->setSize(12);
		$activeSheet->getStyle('B'.$line.':'.'C'.$line)->applyFromArray($border_bottom);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$line, 'EMPLOYMENT STATUS');
		$activeSheet->getStyle('E'.$line)->applyFromArray($bold);

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'EMPLOYEE NAME      :');
		$activeSheet->getStyle($xcoor.$line)->getFont()->setSize(12);
		$activeSheet->getStyle('B'.$line.':'.'C'.$line)->applyFromArray($border_bottom);

		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(3);

		$activeSheet->getStyle('E'.$line)->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(3);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 'R');
		$activeSheet->getStyle('F'.$line)->applyFromArray($bold);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(3);

		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(3);
		$activeSheet->getStyle('G'.$line)->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$line, 'P');
		$activeSheet->getStyle('H'.$line)->applyFromArray($bold);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(3);

		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(3);
		$activeSheet->getStyle('I'.$line)->applyFromArray($border_style);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$line, 'PJ');
		$activeSheet->getStyle('J'.$line)->applyFromArray($bold);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(3);		

		$line++;

		$objPHPExcel->getActiveSheet()->setCellValue($xcoor.$line, 'NATURE OF ACTION  :');
		$activeSheet->getStyle($xcoor.$line)->getFont()->setSize(12);
		$activeSheet->getStyle('B'.$line.':'.'C'.$line)->applyFromArray($border_bottom);

		$line++;

		if ($action_id != ''){
			$this->db->select('field_label,from_name,to_name');
			$this->db->where('action_id',$action_id);
			$this->db->join('partners_movement_fields','partners_movement_action_transfer.field_id = partners_movement_fields.field_id');
			$movement_action = $this->db->get('partners_movement_action_transfer');
			if ($movement_action && $movement_action->num_rows() > 0){
				$header = array('PARTICULARS','FROM','TO');

				$line = 13;
				foreach ($header as $key => $value) {
					if ($alpha_ctr >= count($alphabet)) {
						$alpha_ctr = 0;
						$sub_ctr++;
					}

					if ($sub_ctr > 0) {
						$xcoor = $alphabet[$sub_ctr - 1] . $alphabet[$alpha_ctr];
					} else {
						$xcoor = $alphabet[$alpha_ctr];
					}	

					$activeSheet->setCellValue($xcoor.$line, $value);
					$activeSheet->getStyle($xcoor.$line)->applyFromArray($bold);

					$alpha_ctr++;
				}

				$line++;

				foreach ($movement_action->result() as $row) {
					if ($row->field_label == 'End Date of Temporary Assignment'){
						$row->from_name = '';
					}
					$activeSheet->setCellValue('A'.$line, $row->field_label);
					$activeSheet->setCellValue('B'.$line, $row->from_name);
					$activeSheet->setCellValue('D'.$line, $row->to_name);
					$activeSheet->getStyle('A'.$line.':K'.$line)->applyFromArray($border_style);
					$activeSheet->mergeCells('B'.$line.':C'.$line);
					$activeSheet->mergeCells('D'.$line.':K'.$line);
					$line++;							
				}
			}
		}

		if ($action_id != ''){
			$line++;
			$alpha_ctr = 0;		
					
			$this->db->select('type_name,current_salary,to_salary');
			$this->db->where('action_id',$action_id);
			$movement_action = $this->db->get('partners_movement_action_compensation');
			if ($movement_action && $movement_action->num_rows() > 0){

				$header = array('CHANGES','FROM','TO');
				foreach ($header as $key => $value) {
					if ($alpha_ctr >= count($alphabet)) {
						$alpha_ctr = 0;
						$sub_ctr++;
					}

					if ($sub_ctr > 0) {
						$xcoor = $alphabet[$sub_ctr - 1] . $alphabet[$alpha_ctr];
					} else {
						$xcoor = $alphabet[$alpha_ctr];
					}	

					$activeSheet->setCellValue($xcoor.$line, $value);
					$activeSheet->getStyle($xcoor.$line)->applyFromArray($bold);

					$alpha_ctr++;
				}

				$line++;
				foreach ($movement_action->result() as $row) {
					$activeSheet->setCellValue('A'.$line, 'Salary Rate');
					$activeSheet->setCellValue('B'.$line, $row->current_salary);
					$activeSheet->setCellValue('D'.$line, $row->to_salary);
					$activeSheet->getStyle('A'.$line.':K'.$line)->applyFromArray($border_style);
					$activeSheet->mergeCells('B'.$line.':C'.$line);
					$activeSheet->mergeCells('D'.$line.':K'.$line);					
					$line++;							
				}
			}
		}

		$line++;

		$activeSheet->setCellValue('A'.$line, 'Approved by :');
		$activeSheet->getStyle('A'.$line)->applyFromArray($bold);

		$line++;

		$activeSheet->getStyle('A'.$line.':K'.$line)->applyFromArray($border_top);

		$activeSheet->getStyle('A'.$line.':A'.($line+4))->applyFromArray($border_left);

		$activeSheet->getStyle('K'.$line.':K'.($line+4))->applyFromArray($border_right);

		$activeSheet->getStyle('A'.($line+4).':K'.($line+4))->applyFromArray($border_bottom);

		$activeSheet->setCellValue('A'.($line+2), '     __________________________     ');
		$activeSheet->setCellValue('B'.($line+2), '     __________________________     ');
		$activeSheet->setCellValue('D'.($line+2), '     _________________________  ');

		$line = $line + 6;

		$activeSheet->setCellValue('A'.$line, 'Employee: ____________________________________');
		$activeSheet->getStyle('A'.$line)->applyFromArray($bold);

		$line++;

		$activeSheet->setCellValue('A'.$line, '                        Signature over Printed Name / Date');

		$activeSheet->getStyle('D'.$line)->applyFromArray($border_style);
		$activeSheet->setCellValue('E'.$line, 'Employee');

		$activeSheet->getStyle('I'.$line)->applyFromArray($border_style);
		$activeSheet->setCellValue('J'.$line, 'Personnel');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save( $filename );

		return $filename;
	}

	private function check_path( $path, $create = true )
	{
		$this->load->helper('file');
		if( !is_dir( FCPATH . $path ) ){
			if( $create )
			{
				$folders = explode('/', $path);
				$cur_path = FCPATH;
				foreach( $folders as $folder )
				{
					$cur_path .= $folder;

					if( !is_dir( $cur_path ) )
					{
						mkdir( $cur_path, 0777, TRUE);
						$indexhtml = read_file( APPPATH .'index.html');
		                write_file( $cur_path .'/index.html', $indexhtml);
					}

					$cur_path .= '/';
				}
			}
			return false;
		}
		return true;
	} 

	function newPostData($data = array(),$url = ''){
		if ($url != ''){
			$url = $url;
		}
		else{
			$url = $this->url;
		}
		$qry = "INSERT INTO ww_system_feeds 
				(
					status
					, message_type
					, user_id
					, display_name
					, feed_content
					, recipient_id
					, uri
				) 
				VALUES
				(
					'" . $data['status'] . "',
					'" . $data['message_type'] . "',
					'" . $data['user_id'] . "',
					'" . $data['display_name'] . "',
					'" . $data['feed_content'] . "',
					'" . $data['recipient_id'] . "',
					'" . str_replace(base_url(), '', $url).'/edit/'.$data['movement_id'] . "'					
				)";
		
		$this->db->query($qry);                                  
		
		return $this->db->insert_id();
	}		
}