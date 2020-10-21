<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
    require __DIR__ . '/record.php';
}

class system_feed extends Record
{
	var $feed = array();

	function __construct()
	{
		$this->user = $this->session->userdata('user');
		$this->feed = array(
			'status' => 'info',
			'message_type' => 'Comment',
			'user_id' => $this->user->user_id,
			'feed_content' => '',
			'uri' => '',
			'recipient_id' => ''
		);
        parent::__construct();
	}

	function add( $feed = array(), $recipients = array() )
	{
		$this->feed = array_replace( $this->feed, $feed );
		$this->db->insert('system_feeds', $this->feed);
		$id = $this->db->insert_id();

		if( sizeof( $recipients ) > 0 )
		{
			foreach( $recipients as $user_id )
				$this->add_recipient( $id, $user_id );
		}
	}

	function add_recipient( $id, $user_id )
	{
		@$this->db->insert( 'system_feeds_recipient', array('id' => $id, 'user_id' => $user_id) );
	}
}