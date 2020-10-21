<?php //delete me
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
	