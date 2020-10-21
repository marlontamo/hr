<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Roles extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('roles_model', 'mod');
		parent::__construct();
		$this->lang->load('roles');
	}

	public function save()
	{
		parent::save( true );
		
		if( $this->response->saved )
		{
			if (isset($_POST['roles']['category_selected'])){
				$category_id = implode(',', $_POST['roles']['category_selected']);

				$this->db->where('role_id',$this->record_id);
				$this->db->update('roles',array('category_id' => $category_id));
			}
			else{
				$this->db->where('role_id',$this->record_id);
				$this->db->update('roles',array('category_id' => '(NULL)'));				
			}

			$this->db->delete('roles_category', array('role_id' => $this->record_id));

			if (isset($_POST['roles']['category'])){
				foreach ($_POST['roles']['category'] as $field_name => $value) {
					$category_val_id = implode(',', $value);
					$this->db->insert('roles_category',array('role_id' => $this->record_id, 'category_field' => $field_name, 'category_val' => $category_val_id));
				}
			}

			//update profile distribution
			$this->db->delete('roles_profile', array('role_id' => $this->record_id));
			$profile_ids = $_POST['roles']['profile_id'];
			foreach( $profile_ids as $profile_id )
			{
				$this->db->insert('roles_profile', array('role_id' => $this->record_id, 'profile_id' => $profile_id));
			}

			$this->mod->_create_permission_file( $this->record_id );

			$this->load->model('menu');

			$this->menu->create_role_menu( $this->record_id );	
			

			$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
		}

		$this->_ajax_return();
	}

	public function get_category(){
		$this->_ajax_only();

		$result = $this->db->get_where('category',array('category_id' => $this->input->post('category_id')));

		$data['record'] = $result->row();

		$this->response->html = $this->load->view('edit/category', $data, true);
		$this->response->id = $result->row()->primary_key;
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();		
	}
}