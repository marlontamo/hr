<?php //delete me
	public function get_user_details($user_id=0)
	{
		$this->db->join('users_profile','users_profile.user_id = users.user_id','left');
		$this->db->join('users_position','users_position.position_id = users_profile.position_id','left');
		$this->db->where('users.user_id',$user_id);
		$user_details = $this->db->get('users');
	    return $user_details->row();
	}
