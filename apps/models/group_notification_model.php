<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class group_notification_model extends MY_Model
{
	var $notif = array();

	/*function __construct()
	{
		$this->user = $this->session->userdata('user');
		$this->notif = array(
			'notif' => '',
			'url' => '',
			'type_id' => 3,
			'created_by' => $this->user->user_id,
		);
	}*/

	function add( $notif = array(), $recipients = array() )
	{
		$this->notif = array_replace( $this->notif, $notif );
		$this->db->insert('groups_notif', $this->notif);
		$notif_id = $this->db->insert_id();

		if( sizeof( $recipients ) > 0 )
		{
			foreach( $recipients as $user_id )
				$this->add_recipient( $notif_id, $user_id );
		}
	}

	function add_recipient( $notif_id, $user_id )
	{
		$this->db->insert( 'groups_notif_recipient', array('notif_id' => $notif_id, 'user_id' => $user_id) );
	}

	function get_notifications( $user_id )
	{
		$response = new stdClass();
		$response->total_notification = 0;
		$response->total_unread = 0;
		$response->notification = array();
		
		$notifications = $this->db->query( "SELECT * FROM `dashboard_group_notification` WHERE (recipient = ". $user_id ." OR recipient = 0) AND (read_on IS NULL OR read_on = '0000-00-00 00:00:00') AND (`read` IS NULL OR `read` = 0)" );
		$response->total_notification = $notifications->num_rows();
		$response->total_unread = $notifications->num_rows();
		$response->notification = array();
		$limit = 0;
		
		foreach( $notifications->result_array() as $notif )
		{
			//$response->notification[] = $this->load->view('templates/notifications/'.$notification['status'], $notification, true);	
			$response->notification[] = $this->load->view('templates/group_notif', $notif, true);
			$limit++;
			if( $limit > 9 )
			{
				break;
			}	
		}

		$notifications = $this->db->query( "SELECT * FROM `dashboard_group_notification` WHERE (recipient = ". $user_id ." OR recipient = 0) AND NOT (read_on IS NULL OR read_on = '0000-00-00 00:00:00') AND NOT (`read` IS NULL OR `read` = 0)" );
		$response->total_notification += $notifications->num_rows();
		if( sizeof( $response->notification ) < 10 )
		{
			$limit = sizeof( $response->notification ) - 1;
			foreach( $notifications->result_array() as $notif )
			{
				//$this->load->view('templates/group_notif', array('notif' => $notif), true);
				$response->notification[] = $this->load->view('templates/group_notif', $notif, true);
				$limit++;
				if( $limit > 9 )
				{
					break;
				}	
			}	
		}
		

		//debug($response);
		return $response; 

	}

	function _unnotify( $user_id )
	{
		$response = new stdClass();
		$update = array(
			'read' => 1,
			'read_on' => date('Y-m-d H:i:s')
		);
		$where = array('user_id' => $user_id);
		$this->db->update('groups_notif_recipient', $update, $where);
		if( $this->db->_error_message() != "" )
		{
			$response->message[] = array(
				'message' => $this->db->_error_message(),
				'type' => 'error'
			);
		}
		else{
			$response->message[] = array(
				'message' => '',
				'type' => 'success'
			);
		}
		return $response;
	}
}