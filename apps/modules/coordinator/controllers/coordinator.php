<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Coordinator extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('coordinator_model', 'mod');
		parent::__construct();
	}

	function get_add_employee(){
		$this->_ajax_only();

		$data['company_id'] = $this->input->post('company_id');
		$data['branch_id'] = $this->input->post('branch_id');
		$data['record_id'] = $this->input->post('record_id');
		$data['list_coordinator'] = $this->mod->get_user_list($this->input->post('branch_id'),$this->input->post('company_id'));

		$this->response->list_user = $this->load->view('edit/custom_fgs/coordinator_list.blade.php', $data, true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

        $this->_ajax_return();		
	}

	function save( $child_call = false )
	{
		parent::save( true );
		
		$record_id = $this->record_id;

		$post = $this->input->post('users_coordinator');

		$coordinator_user_id = implode(',', $post['coordinator_user_id']);
		$coordinator_user_id_array = $post['coordinator_user_id'];
		$users_id = '';
		if ($this->input->post('user')){
			$users_id  = implode(',',$this->input->post('user'));
		}
		$users_id_array  = $this->input->post('user');

		if( $this->response->saved )
		{
			$this->db->where('coordinator_id',$record_id);
			$this->db->update('users_coordinator',array('user_id' => $users_id));

			if (!empty($users_id_array)){
				foreach ($users_id_array as $key => $value) {
					foreach ($coordinator_user_id_array as $key1 => $value1) {
						$query = "UPDATE `ww_users_profile` SET coordinator_id = CONCAT(coordinator_id,',{$value1}') 
								  WHERE NOT FIND_IN_SET ({$value1}, coordinator_id) 
								  AND user_id = {$value}";

						$this->db->query($query);
					}
				}
			}

			$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
		}

		$this->_ajax_return();
	}	

	function _list_options_active( $record, &$rec )
	{
		//temp remove until view functionality added
		if( $this->permission['detail'] )
		{
			$rec['detail_url'] = $this->mod->url . '/detail/' . $record['record_id'];
			$rec['options'] .= '<li><a href="'.$rec['detail_url'].'"><i class="fa fa-info"></i> View</a></li>';
		}

		if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}	
	}	
}