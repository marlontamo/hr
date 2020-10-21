<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class inbox_model extends Record
{
	public function _get_user_messages( $user_id )
	{
		$response = new stdClass();
		$qry = "SELECT a.from, a.from_name, b.photo, COUNT(a.from) AS unread, a.message, a.time, gettimeline(a.time) AS timeline 
		FROM `{$this->db->dbprefix}system_chat` a
		LEFT JOIN `{$this->db->dbprefix}users_profile` b ON b.user_id = a.from
		WHERE a.seen = 0 AND a.to = {$user_id}
		ORDER BY a.time DESC";
		$messages = $this->db->query( $qry );
		$response->total_messages = 0;
		$response->message = array();
		$response->inbox = array();
		foreach( $messages->result_array() as $message )
		{
			if($message['unread'])
			{
				$response->inbox[] = $this->load->view('templates/inbox_message', $message, true);
			}
		}
		$response->total_messages = sizeof($response->inbox);

		return $response;
	}

	public function _uninbox( $user_id )
	{
		$response = new stdClass();
		$qry = "update `{$this->db->dbprefix}system_chat`
		set seen = 1
		where `to` = {$user_id}";
		$this->db->query( $qry );

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