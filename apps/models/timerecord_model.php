<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class timerecord_model extends Record
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
		$this->mod_id = 31;
		$this->mod_code = 'timerecord';
		$this->route = 'time/timerecords';
		$this->url = site_url('time/timerecords');
		$this->primary_key = 'record_id';
		$this->table = 'time_record';
		$this->icon = '';
		$this->short_name = 'Time Records';
		$this->long_name  = 'Time Records';
		$this->description = 'timesheets.';
		$this->path = APPPATH . 'modules/timerecord/';

		parent::__construct();
	}

	public function _get_list($range, $date){

		$from = date("Y-m-1", strtotime($date));
		$to = date("Y-m-t", strtotime($date));

		$data = array();
		
		$qry = "SELECT * FROM time_record_list 
				WHERE user_id = '".$this->user->user_id."' ";
		$qry .= " AND date BETWEEN '" . $from . "' AND '" . $to . "'";
		$qry .= " ORDER BY DATE ASC"; 

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;		
	}

	public function _get_list_by_period($from, $to){

		$from = date("Y-m-d", strtotime($from));
		$to = date("Y-m-d", strtotime($to));

		$data = array();
		
		$qry = "SELECT * FROM time_record_list 
				WHERE user_id = '".$this->user->user_id."' ";
		$qry .= " AND date BETWEEN '" . $from . "' AND '" . $to . "'";
		$qry .= " ORDER BY DATE ASC"; 

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}

	public function get_period_list(){

		$data = array();

		$qry = "SELECT `record_id`,`period_id`,`period_year`,`payroll_date`,`from`,`to` 
				FROM time_period_list  tpl 
				JOIN users_profile up ON up.company_id =  tpl.`company_id`  
				AND up.`user_id` = '".$this->user->user_id."'
				LIMIT 5";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}

	public function time_record_list_forms($date, $user_id){

		$data = array();

		$qry = "SELECT * FROM time_record_list_forms
				WHERE date = '{$date}' 
				AND user_id = '{$user_id}' 
				AND form_code <> 'DTRU'
				GROUP BY forms_id 
				";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}

		return $data;
	}

	public function is_dtr_editable($date, $user_id){

		$data = 'fa ';
		$current_date = date('Y-m-d');
		// $current_date = '2015-03-19';

		$qry = "SELECT * FROM {$this->db->dbprefix}time_period 
				LEFT JOIN users_profile ON 
				{$this->db->dbprefix}time_period.company_id = users_profile.company_id
				WHERE user_id = {$user_id} AND
				'{$date}' BETWEEN `date_from` AND `date_to`
				AND '{$current_date}' < cutoff
				";

		$result = $this->db->query( $qry );

		if($result->num_rows() > 0){						
			$data = 'fa-edit';
		}

		return $data;
	}

	public function time_record_list_forms_details($forms_id=0, $user_id=0, $date){

		$data = array();

		$qry = "SELECT * FROM time_record_list_forms
				WHERE forms_id = '{$forms_id}'
				AND date = '{$date}' 
				GROUP BY forms_id 
				";

		$result = $this->db->query( $qry );
		return $result->row_array();
		
	}


	public function get_timerecord_aux($date, $form_id){

		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}time_forms_date
				WHERE date = '{$date}' 
				AND forms_id = '{$form_id}'";

		$result = $this->db->query( $qry );

		if($result && $result->num_rows() > 0){			
			$data = $result->row_array();
		}

		return $data;
	}

	public function get_display_name($user_id=0){		
		$sql_display_name = $this->db->get_where('users', array('user_id' => $user_id));
		$display_name = $sql_display_name->row_array();
		return $display_name['display_name'];
	}

	function notify_approvers( $user_id, $status, $period, $form=array())
	{
		$notified = array();
		
		$this->db->order_by('sequence', 'asc');
		$approvers = $this->db->get_where('time_forms_approver', array('forms_id' => $form['forms_id'], 'deleted' => 0));
		
		$first = true;

		foreach( $approvers->result() as $approver )
		{
			switch( $approver->condition )
			{
				case 'All':
				case 'Either Of';
					break;
				case 'By Level':
					if( !$first )
						continue;	
					break;
			}

			$aux_status = $status == 2 ? "Filed" : "";
			
			$this->db->where('form_code',$form['form_code']);
			$this->db->where('deleted',0);
			$form_type = $this->db->get('time_form');
			$form_type = $form_type->row_array();

			//insert notification
			$insert = array(
				'status' => 'info',
				'message_type' => 'Time Record',
				'user_id' => $user_id,
				'display_name' => $this->get_display_name($user_id),
				'feed_content' => $aux_status.': '.$form_type['form'].' for Period '.$period.' <br><br> '.date('F d, Y', strtotime($form['date_from'])). '-' .date('F d, Y', strtotime($form['date_to'])),
				'recipient_id' => $approver->user_id,
				'uri' => $this->route.'/updating'
			);
			$this->db->insert('system_feeds', $insert);
			$id = $this->db->insert_id();
			$this->db->insert('system_feeds_recipient', array('id' => $id, 'user_id' => $approver->user_id));
			$notified[] = $approver->user_id;

			$first = false;

		}

		return $notified;
	}

	function notify_filer( $user_id, $period)
	{
		$notified = array();

        $this->lang->load( 'form_application' );
		$aux_status = $this->lang->line('form_application.applied_for');

		//insert notification
		$insert = array(
			'status' => 'info',
			'message_type' => 'Time Record',
			'user_id' => $user_id,
			'feed_content' => $aux_status.' Time Record Updating for Period '. $period,
			'recipient_id' => $user_id,
			'uri' => $this->route.'/updating'
		);

		$this->db->insert('system_feeds', $insert);
		$id = $this->db->insert_id();
		$this->db->insert('system_feeds_recipient', array('id' => $id, 'user_id' => $user_id));
		$notified[] = $user_id;

		return $notified;
	}

	public function is_dtru_applicable()
	{
		$updating = $this->db->get_where('time_form', array('form_code' => 'DTRU', 'deleted' => 0));
		if($updating && $updating->num_rows() > 0){
			$dtru = $updating->row();
			if($dtru->can_view == 1){
				return true;
			}
		}
		return false;
	}

	public function get_ot_info($user_id, $date)
	{
		$this->db->select('payroll_transaction.transaction_label, time_record_process.quantity');
		$this->db->where('time_record_process.date', $date);
		$this->db->where('time_record_process.user_id', $user_id);
		$this->db->where('payroll_transaction.transaction_class_id', 10);
		$this->db->join('payroll_transaction', 'payroll_transaction.transaction_id = time_record_process.transaction_id');
		$this->db->join('payroll_transaction_class', 'payroll_transaction_class.transaction_class_id = payroll_transaction.transaction_class_id');
		$this->db->from('time_record_process');
		$result = $this->db->get();
		
		$data = array();
		if($result && $result->num_rows() > 0){			
			$data = $result->result_array();
		}
		
		return $data;
	}
}