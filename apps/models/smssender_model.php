<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class smssender_model extends Record
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
		$this->mod_id = 32;
		$this->mod_code = 'smssender';
		$this->route = 'smssender';
		$this->url = site_url('smssender');
		$this->primary_key = 'timein';
		$this->table = 'system_sms_queue';
		$this->icon = 'fa-mail';
		$this->short_name = 'Outgoing SMS';
		$this->long_name  = 'Outgoing SMS';
		$this->description = 'Outgoing SMS';
		$this->path = APPPATH . 'modules/smssender/';

		parent::__construct();
	}

	function get_queued( $start, $limit )
	{	
		$where = array(
			'status' => 'queued',
		);
		$this->db->where( $where );
		$this->db->order_by('timein');
		$mail = $this->db->get($this->table, $limit, $start);
		return $mail;
	}

	function change_status($id, $status) {
		$this->db->where(array('id' => $id));
		$this->db->update($this->table, array('status' => $status));
	}

	function delete_from_queue($id)
	{
		$data = array('id' => $id);
		$this->db->delete($this->table, $data);
	}

	function attempt($id, $attempt)
	{
		$this->db->where(array('id' => $id));
		$this->db->update($this->table, array('attempts' => $attempt));
	}

	function sent( $id )
	{
		$this->db->where(array('id' => $id));
		$this->db->update($this->table, array('status' => 'sent', 'sent_on' => date('Y-m-d H:i:s')));
	}
}