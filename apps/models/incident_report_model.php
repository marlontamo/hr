<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class incident_report_model extends Record
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
		$this->mod_id = 139;
		$this->mod_code = 'incident_report';
		$this->route = 'partner/incident_report';
		$this->url = site_url('partner/incident_report');
		$this->primary_key = 'incident_id';
		$this->table = 'partners_incident';
		$this->icon = 'fa-folder';
		$this->short_name = 'Incident Report';
		$this->long_name  = 'Incident Report';
		$this->description = '';
		$this->path = APPPATH . 'modules/incident_report/';

		parent::__construct();
	}
		
	function _get_list($start, $limit, $search, $filter, $trash = false)
	{
		$data = array();				
		
		$qry = $this->_get_list_cached_query();
		
		if( $trash )
		{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 1";
		}
		else{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 0";	
		}

		//if( $this->user->user_id != 1 )
		//{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.created_by = {$this->user->user_id}";
		//}
		
		$qry .= ' '. $filter;
		// $qry .= " GROUP BY {$this->db->dbprefix}{$this->table}.{$this->primary_key} ";
		$qry .= "ORDER BY {$this->db->dbprefix}{$this->table}.{$this->primary_key} desc";
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );
		// echo "<pre>";print_r($qry);
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	public function get_incident_details($record_id=0){		
		$where = array('deleted' => 0, $this->primary_key => $record_id);
		$incident_details = $this->db->get_where($this->table, $where);
		
		return $incident_details->row_array();
	}

	function notify_hr( $forms_id=0, $form=array())
	{	
		$notified = array();
		$form_status = $form['incident_status_id'] == 6 ? "Closed" : lang('incident_report.forward_im');
		$offenses = $this->db->get_where('partners_offense', array('offense_id' => $form['offense_id']))->row_array();
		$hr_admin = $this->db->get_where('users', array('role_id' => 2, 'active' => 1, 'deleted' => 0))->result_array();

		//insert notification
		$this->load->model('incident_admin_model', 'incident_admin');

		foreach($hr_admin as $hr_admin) {
			$insert = array(
				'status' => 'info',
				'message_type' => 'Code of Conduct',
				'user_id' => $this->user->user_id,
				'display_name' => $this->get_display_name($this->user->user_id),
				'feed_content' => $form_status.': incident report involving '.$this->get_display_name($form['involved_partners']).'.<br><br>Offense: '.$offenses['offense'],
				'recipient_id' => $hr_admin['user_id'],
				'uri' => str_replace(base_url(), '', $this->incident_admin->url).'/detail/'.$form[$this->primary_key]
			);

			$this->db->insert('system_feeds', $insert);
			$id = $this->db->insert_id();
			$this->db->insert('system_feeds_recipient', array('id' => $id, 'user_id' => $hr_admin['user_id']));
			$notified[] = $hr_admin['user_id'];
		}

		return $notified;
	}

	function notify_approvers( $forms_id=0, $form=array())
	{
		$notified = array();

		$this->db->order_by('sequence', 'asc');
		$approvers = $this->db->get_where($this->table.'_approver', array($this->primary_key => $form[$this->primary_key], 'deleted' => 0));

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

			$form_status = $form['incident_status_id'] == 2 ? "Filed" : "Cancelled";
			
			$offenses = $this->db->get_where('partners_offense', array('offense_id' => $form['offense_id']))->row_array();
			
			$this->load->model('incident_manage_model', 'formManage');
			//insert notification
			$insert = array(
				'status' => 'info',
				'message_type' => 'Code of Conduct',
				'user_id' => $form['created_by'],
				'display_name' => $this->get_display_name($form['created_by']),
				'feed_content' => $form_status.': incident report involving '.$this->get_display_name($form['involved_partners']).'.<br><br>Offense: '.$offenses['offense'],
				'recipient_id' => $approver->user_id,
				'uri' => str_replace(base_url(), '', $this->formManage->url).'/detail/'.$form[$this->primary_key]
			);
			$this->db->insert('system_feeds', $insert);
			$id = $this->db->insert_id();
			$this->db->insert('system_feeds_recipient', array('id' => $id, 'user_id' => $approver->user_id));
			$notified[] = $approver->user_id;

			$first = false;

		}

		return $notified;
	}

	function notify_filer( $forms_id=0, $form=array())
	{
		$notified = array();

		$form_status = $form['incident_status_id'] == 2 ? "Filed a new" : "Cancelled an ";

		//insert notification
		$insert = array(
			'status' => 'info',
			'message_type' => 'Code of Conduct',
			'user_id' => $form['created_by'],
			'feed_content' => $form_status.' incident report',
			'recipient_id' => $form['created_by'],
			'uri' => str_replace(base_url(), '', $this->url).'/detail/'.$form[$this->primary_key]
		);

		$this->db->insert('system_feeds', $insert);
		$id = $this->db->insert_id();
		$this->db->insert('system_feeds_recipient', array('id' => $id, 'user_id' => $form['created_by']));
		$notified[] = $form['created_by'];

		return $notified;
	}

	function notify_immediate( $forms_id=0, $form=array())
	{
		$this->load->model('incident_manage_model', 'formManage');

		$notified = array();

		$offenses = $this->db->get_where('partners_offense', array('offense_id' => $form['offense_id']))->row_array();
		
		$form_status = $form['incident_status_id'] == 2 ? "Filed a new" : "Cancelled an ";

        $incident_details = $this->mod->get_incident_details($form[$this->primary_key]);
		
		//insert notification involved partner's immediate
		$users_data = $this->db->get_where( 'users_profile', array( 'user_id' => $incident_details['involved_partners'] ) )->row_array();   
		$insert = array(
			'status' => 'info',
			'message_type' => 'Code of Conduct',
			'user_id' => $users_data['reports_to_id'],
			'feed_content' => $form_status.': incident report involving '.$this->get_display_name($form['involved_partners']).'.<br><br>Offense: '.$offenses['offense'],
			'recipient_id' => $users_data['reports_to_id'],
			'uri' => str_replace(base_url(), '', $this->formManage->url).'/detail/'.$form[$this->primary_key]
		);

		$this->db->insert('system_feeds', $insert);
		$id = $this->db->insert_id();
		$this->db->insert('system_feeds_recipient', array('id' => $id, 'user_id' => $users_data['reports_to_id']));
		$notified[] = $users_data['reports_to_id'];

		return $notified;
	}	

	public function get_display_name($user_id=0){		
		$sql_display_name = $this->db->get_where('users', array('user_id' => $user_id));
		$display_name = $sql_display_name->row_array();
		return $display_name['display_name'];
	}
}