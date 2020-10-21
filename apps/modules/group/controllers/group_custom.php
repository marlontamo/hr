
	function get_immediate_position(){

		$this->load->model('division_model', 'div_mod');
		$user_details = $this->div_mod->get_user_details($this->input->post('user_id'));
        echo json_encode($user_details);

	}