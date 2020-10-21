<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class my_change_request_model extends Record
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
		$this->mod_id = 75;
		$this->mod_code = 'my_change_request';
		$this->route = 'account/201_update';
		$this->url = site_url('account/201_update');
		$this->primary_key = 'personal_id';
		$this->table = 'partners_personal_request';
		$this->icon = 'fa-folder';
		$this->short_name = 'Change Request';
		$this->long_name  = 'Change Request';
		$this->description = '';
		$this->path = APPPATH . 'modules/my_change_request/';

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
		
		// $qry .= " AND {$this->db->dbprefix}{$this->table}.status != 1";
		$qry .= ' '. $filter;
		$qry .= " ORDER BY {$this->db->dbprefix}{$this->table}.created_on desc";
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	function notify_approvers( $forms_id=0, $form=array())
	{
		$notified = array();

		$personal_request_key = 'personal_request_id';
		$this->db->order_by('sequence', 'asc');
		$approvers = $this->db->get_where('partners_personal_approver', array($personal_request_key => $form[$this->primary_key], 'deleted' => 0));

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

			$form_status = "Filed";
			
			$requests = $this->db->get_where('partners_personal_request', array($this->primary_key => $form[$this->primary_key]))->row_array();
			$keys = $this->db->get_where('partners_key', array('key_id'=> $form['key_id']))->row_array();
			
			$this->load->model('change_request_model', 'update201');
			//insert notification
			$insert = array(
				'status' => 'info',
				'message_type' => 'Partners',
				'user_id' => $form['created_by'],
				'display_name' => $this->get_display_name($form['created_by']),
				'feed_content' => $form_status.': change request for '.$keys['key_label'].": ".$form['key_value'],
				'recipient_id' => $approver->user_id,
				'uri' => str_replace(base_url(), '', $this->update201->url).'/detail/'.strtotime($requests['created_on']).'/'.$requests['partner_id'].'/'.$form['status']
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

			$form_status =  "Filed a new" ;

			//insert notification
			$insert = array(
				'status' => 'info',
				'message_type' => 'Partners',
				'user_id' => $form['created_by'],
				'feed_content' => $form_status.' change request',
				'recipient_id' => $form['created_by'],
				'uri' => str_replace(base_url(), '', $this->url)
			);

			$this->db->insert('system_feeds', $insert);
			$id = $this->db->insert_id();
			$this->db->insert('system_feeds_recipient', array('id' => $id, 'user_id' => $form['created_by']));
			$notified[] = $form['created_by'];

		return $notified;
	}

	public function get_display_name($user_id=0){		
		$sql_display_name = $this->db->get_where('users', array('user_id' => $user_id));
		$display_name = $sql_display_name->row_array();
		return $display_name['display_name'];
	}
}