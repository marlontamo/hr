<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class erequest_model extends Record
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
		$this->mod_id = 144;
		$this->mod_code = 'erequest';
		$this->route = 'partner/erequest';
		$this->url = site_url('partner/erequest');
		$this->primary_key = 'request_id';
		$this->table = 'resources_request';
		$this->icon = '';
		$this->short_name = 'Online Request';
		$this->long_name  = 'Online Request';
		$this->description = '';
		$this->path = APPPATH . 'modules/erequest/';

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

		if( $this->user->user_id != 1 )
		{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.user_id = {$this->user->user_id}";
		}
		
		$qry .= ' '. $filter;
		$qry .= " GROUP BY {$this->db->dbprefix}{$this->table}.{$this->primary_key} ";
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

	function get_notes( $request_id, $user_id )
	{
		$qry = "select a.*, b.full_name, c.photo, gettimeline(a.created_on) as timeline, d.department
		FROM {$this->db->dbprefix}resources_request_notes a
		LEFT JOIN {$this->db->dbprefix}users b on b.user_id = a.created_by
		LEFT JOIN {$this->db->dbprefix}users_profile c on c.user_id = a.created_by
		LEFT JOIN {$this->db->dbprefix}users_department d on d.department_id = c.department_id
		WHERE a.request_id = {$request_id} AND a.user_id = {$user_id}
		ORDER BY a.created_on DESC";

		// echo "<pre>";print_r($qry);exit();
		return $this->db->query( $qry )->result();
	}

	public function get_erequest_details($record_id=0){		
		$where = array('deleted' => 0, $this->primary_key => $record_id);
		$erequest_details = $this->db->get_where($this->table, $where);
		
		return $erequest_details->row_array();
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

			$form_status = $form['request_status_id'] == 2 ? "Filed" : "Cancelled";
			
			$this->load->model('erequest_admin_model', 'formManage');
			//insert notification
			$insert = array(
				'status' => 'info',
				'message_type' => 'Partners',
				'user_id' => $form['user_id'],
				'display_name' => $this->get_display_name($form['user_id']),
				'feed_content' => $form_status.': online request for '.date('F d, Y', strtotime($form['date_needed'])).'.<br><br>Reason: '.$form['reason'],
				'recipient_id' => $approver->user_id,
				'uri' => str_replace(base_url(), '', $this->formManage->url).'/edit/'.$form[$this->primary_key]
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

			$form_status = $form['request_status_id'] == 2 ? "Filed a new" : "Cancelled an ";

			//insert notification
			$insert = array(
				'status' => 'info',
				'message_type' => 'Partners',
				'user_id' => $form['user_id'],
				'feed_content' => $form_status.' online request',
				'recipient_id' => $form['user_id'],
				'uri' => str_replace(base_url(), '', $this->url).'/detail/'.$form[$this->primary_key]
			);

			$this->db->insert('system_feeds', $insert);
			$id = $this->db->insert_id();
			$this->db->insert('system_feeds_recipient', array('id' => $id, 'user_id' => $form['user_id']));
			$notified[] = $form['user_id'];

		return $notified;
	}

	public function get_display_name($user_id=0){		
		$sql_display_name = $this->db->get_where('users', array('user_id' => $user_id));
		$display_name = $sql_display_name->row_array();
		return $display_name['display_name'];
	}

}