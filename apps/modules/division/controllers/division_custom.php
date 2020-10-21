
	function get_immediate_position(){

		$user_details = $this->mod->get_user_details($this->input->post('user_id'));
        echo json_encode($user_details);

	}
