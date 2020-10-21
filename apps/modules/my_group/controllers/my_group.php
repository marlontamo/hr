<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_group extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('my_group_model', 'mod');
		parent::__construct();
		$this->lang->load( 'my_group' );
	}

	function discussion()
	{
		if( !$this->_set_record_id() )
		{
			echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->db->limit(1);
		$vars['current_group'] = $this->db->get_where('groups', array('group_id' => $this->record_id))->row();
		$this->load->vars( $vars );

		if( !$this->mod->is_member( $this->record_id, $this->user->user_id ) )
		{
			echo $this->load->blade('pages.restricted')->with( $this->load->get_cached_vars() );
			die();
		}

		echo $this->load->blade('pages.discussion')->with( $this->load->get_cached_vars() );
	}

	function members()
	{
		if( !$this->_set_record_id() )
		{
			echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->db->limit(1);
		$vars['current_group'] = $this->db->get_where('groups', array('group_id' => $this->record_id))->row();
		$this->load->vars( $vars );

		if( !$this->mod->is_member( $this->record_id, $this->user->user_id ) )
		{
			echo $this->load->blade('pages.restricted')->with( $this->load->get_cached_vars() );
			die();
		}

		echo $this->load->blade('pages.members')->with( $this->load->get_cached_vars() );
	}

	function files()
	{
		if( !$this->_set_record_id() )
		{
			echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->db->limit(1);
		$vars['current_group'] = $this->db->get_where('groups', array('group_id' => $this->record_id))->row();
		$this->load->vars( $vars );

		if( !$this->mod->is_member( $this->record_id, $this->user->user_id ) )
		{
			echo $this->load->blade('pages.restricted')->with( $this->load->get_cached_vars() );
			die();
		}

		echo $this->load->blade('pages.files')->with( $this->load->get_cached_vars() );
	}

	function photos()
	{
		if( !$this->_set_record_id() )
		{
			echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->db->limit(1);
		$vars['current_group'] = $this->db->get_where('groups', array('group_id' => $this->record_id))->row();
		$this->load->vars( $vars );

		if( !$this->mod->is_member( $this->record_id, $this->user->user_id ) )
		{
			echo $this->load->blade('pages.restricted')->with( $this->load->get_cached_vars() );
			die();
		}

		echo $this->load->blade('pages.photos')->with( $this->load->get_cached_vars() );
	}

	function quick_add()
	{
		parent::quick_add( true );

		$this->_after_parent_edit();

		$this->load->helper('form');
		$this->load->helper('file');
		
		$data['title'] = lang('my_group.create_group');
		$data['content'] = $this->load->blade('pages.quick_edit')->with( $this->load->get_cached_vars() );
		$this->response->quick_edit_form = $this->load->view('templates/modal', $data, true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	private function _after_parent_edit()
	{
		$vars['members'] = $this->mod->_get_members( $this->record_id, 'csv' );
		$this->load->vars( $vars );
	}

	function view_post()
	{
		$this->_ajax_only();
		$this->mod->view_post( $this->input->post('post_id') );
		$this->response->feed_id = $this->input->post('post_id');
		//$this->response->like_str = $this->mod->feed_like_str( $this->input->post('post_id'), $this->input->post('mobileapp') );
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();	
	}

	function save()
	{
		parent::save( true );
		
		if( $this->response->saved )
		{
			$record = $this->db->get_where( $this->mod->table, array( $this->mod->primary_key => $this->record_id ) )->row();
			$members = $_POST['groups_members']['user_id'];
			$members = explode(',', $members);
			if( !in_array($record->created_by, $members) )
				$members[] = $record->created_by;
		
			$this->db->limit(1);
			$created_by = $this->db->get_where('users', array('user_id' => $record->created_by))->row();

			foreach( $members as $user_id )
			{
				$this->db->limit(1);
				$user = $this->db->get_where('users', array('user_id' => $user_id))->row();

				$where = array(
					'group_id' => $this->record_id,
					'user_id' => $user_id
				);
				$this->db->limit(1);
				$check = $this->db->get_where('groups_members', $where);
				if( $check->num_rows() == 1 )
				{
					$member = $this->db->get_where('groups_members', $where)->row();
					
					$update = array(
						'group_id' => $this->record_id,
						'user_id' => $user_id,
						'full_name' => $user->full_name
					);

					if( !$member->active && (empty( $member->leave_date ) || $member->leave_date == '0000-00-00' ) )
					{
						$update['active'] = 1;
						$update['date_approved'] = date('Y-m-d');
						$update['approved_by'] = $this->user->user_id;
					}

					$this->db->update('groups_members', $update, $where);
				}
				else{
					$insert = array(
						'group_id' => $this->record_id,
						'user_id' => $user_id,
						'full_name' => $user->full_name
					);

					if( $user_id == $this->user->user_id )
					{
						$insert['admin'] = 1;
					}
					$insert['active'] = 1;
					$insert['approved_by'] = $this->user->user_id;
					$insert['date_approved'] = date('Y-m-d');
					$this->db->insert('groups_members', $insert);

					if( $user_id != $record->created_by )
					{
						$recipients[] = $user_id;
					}
				}
			}

			if( isset($recipients) )
			{
				$this->response->group_notif = $recipients;

				//add to notification
				$this->load->model('group_notification_model', 'gn');
				$notif = array(
					'notif' => lang('my_group.added_to_group')." {$record->group_name} ".lang('my_group.by')." {$created_by->full_name}.",
					'type_id' => 2,
					'url' => $this->mod->route . '/discussion/'.$record->group_id,
					'created_by' => $this->user->user_id
				);
				$this->gn->add( $notif, $recipients );
			}
		}

		$this->response->message[] = array(
			'message' => lang('common.save_success'),
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function join_group()
	{
		$this->_ajax_only();
		
		$pending_request = $this->mod->check_pending_request( $this->input->post('group_id'),  $this->user->user_id);
		if( !$pending_request )
		{
			$user = $this->db->get_where('users', array('user_id' => $this->user->user_id))->row();
			$insert = array(
				'group_id' => $this->input->post('group_id'),
				'user_id' => $this->user->user_id,
				'full_name' => $user->full_name,
				'date_joined' => date('Y-m-d')
			);
			$this->db->insert('groups_members', $insert);

			$this->response->message[] = array(
				'message' => lang('my_group.msg_for_accept'),
				'type' => 'success'
			);

			//notify admins
			$this->db->limit(1);
			$group = $this->db->get_where('groups', array('group_id' => $this->input->post('group_id')))->row();
			$this->db->limit(1);
			$user = $this->db->get_where('users', array('user_id' => $this->user->user_id))->row();
			$this->load->model('group_notification_model', 'gn');
			$notif = array(
				'notif' =>  "{$user->full_name} wants to join {$group->group_name}.",
				'type_id' => 5,
				'url' => $this->mod->route . '/members/'.$group->group_id,
				'created_by' => $this->user->user_id
			);
			$this->response->group_notif = $this->mod->_get_admins($group->group_id);
			$this->gn->add( $notif, $this->response->group_notif );
		}
		else{
			$this->response->message[] = array(
				'message' => lang('my_group.msg_has_pending_request'),
				'type' => 'info'
			);	
		}
		$this->_ajax_return();	
	}

	function get_members_list()
	{
		$this->_ajax_only();
		
		if( !$this->_set_record_id() )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		if( !$this->mod->is_member( $this->record_id, $this->user->user_id ) )
		{
			$this->response->message[] = array(
				'message' => lang('my_group.msg_not_member'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$vars['is_admin'] = $this->mod->is_admin( $this->record_id, $this->user->user_id );
		$this->load->vars( $vars );

		$records = $this->_get_other_list( '_get_members_list' );
		$this->_process_members_lists( $records );
		$this->_ajax_return();
	}

	function get_files_list()
	{
		$this->_ajax_only();
		
		if( !$this->_set_record_id() )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		if( !$this->mod->is_member( $this->record_id, $this->user->user_id ) )
		{
			$this->response->message[] = array(
				'message' => lang('my_group.msg_not_member'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$vars['is_admin'] = $this->mod->is_admin( $this->record_id, $this->user->user_id );
		$this->load->vars( $vars );

		$records = $this->_get_other_list( '_get_files_list' );
		$this->_process_files_lists( $records );
		$this->_ajax_return();
	}

	function get_photos_list()
	{
		$this->_ajax_only();
		
		if( !$this->_set_record_id() )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		if( !$this->mod->is_member( $this->record_id, $this->user->user_id ) )
		{
			$this->response->message[] = array(
				'message' => lang('my_group.msg_not_member'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$vars['is_admin'] = $this->mod->is_admin( $this->record_id, $this->user->user_id );
		$this->load->vars( $vars );

		$records = $this->_get_other_list( '_get_photos_list' );
		$this->_process_photos_lists( $records );
		$this->_ajax_return();
	}

	function get_post_list()
	{
		$this->_ajax_only();
		
		if( !$this->_set_record_id() )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		if( !$this->mod->is_member( $this->record_id, $this->user->user_id ) )
		{
			$this->response->message[] = array(
				'message' => lang('my_group.msg_not_member'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$vars['is_admin'] = $this->mod->is_admin( $this->record_id, $this->user->user_id );
		$this->load->vars( $vars );

		$records = $this->_get_other_list( '_get_post_list' );
		$this->_process_post_lists( $records );
		$this->_ajax_return();
	}

	private function _get_other_list( $list )
	{
		$page = $this->input->post('page');
		$search = $this->input->post('search');
		$filter = "";
		
		$filter_by = $this->input->post('filter_by');
		$filter_value = $this->input->post('filter_value');
		
		if( is_array( $filter_by ) )
		{
			foreach( $filter_by as $filter_by_key => $filter_value )
			{
				if( $filter_value != "" ) $filter = 'AND '. $filter_by_key .' = "'.$filter_value.'"';	
			}
		}
		else{
			if( $filter_by && $filter_by != "" )
			{
				$filter = 'AND '. $filter_by .' = "'.$filter_value.'"';
			}
		}

		if( $page == 1 )
		{
			$searches = $this->session->userdata('search');
			if( $searches ){
				foreach( $searches as $mod_code => $old_search )
				{
					if( $mod_code != $this->mod->mod_code )
					{
						$searches[$this->mod->mod_code] = "";
					}
				}
			}
			$searches[$this->mod->mod_code] = $search;
			$this->session->set_userdata('search', $searches);
		}
		
		$page = ($page-1) * 10;
		$records = $this->mod->$list($page, 10, $search, $filter, $this->record_id );
		return $records;
	}

	private function _process_members_lists( $records )
	{
		$this->response->records_retrieve = sizeof($records);
		$this->response->list = '';
		foreach( $records as $record )
		{
			$this->response->list .= $this->load->blade('members/list_template', $record, true)->with( $this->load->get_cached_vars() );
		}
	}

	private function _process_files_lists( $records )
	{
		$this->response->records_retrieve = sizeof($records);
		$this->response->list = '';
		foreach( $records as $record )
		{
			$this->response->list .= $this->load->blade('files/list_template', $record, true)->with( $this->load->get_cached_vars() );
		}
	}

	private function _process_photos_lists( $records )
	{
		$this->response->records_retrieve = sizeof($records);
		$this->response->list = '';
		foreach( $records as $record )
		{
			$this->response->list .= $this->load->blade('photos/list_template', $record, true)->with( $this->load->get_cached_vars() );
		}
	}

	private function _process_post_lists( $records )
	{
		$this->response->records_retrieve = sizeof($records);
		$this->response->list = '';
		foreach( $records as $record )
		{
			$this->response->list .= $this->load->view('discussion/post', array('post' => $record), true);
		}
	}

	function accept_request()
	{
		$this->_ajax_only();
		$this->response->refresh = true;
		if( !$this->mod->is_admin( $this->input->post('group_id'), $this->user->user_id ))
		{
			$this->response->refresh = false;
			$this->response->message[] = array(
				'message' => lang('my_group.msg_pending_request'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		
		$update = array(
			'date_approved' => date('Y-m-d'),
			'approved_by' => $this->user->user_id,
			'active' => 1
		);
		$where = array(
			'group_id' => $this->input->post('group_id'),
			'user_id' => $this->input->post('user_id')
		);
		$this->db->update('groups_members', $update, $where);

		//notify user
		$this->db->limit(1);
		$group = $this->db->get_where('groups', array('group_id' => $this->input->post('group_id')))->row();
		$this->load->model('group_notification_model', 'gn');
		$notif = array(
			'notif' =>  lang('my_group.msg_accepted')." {$group->group_name}.",
			'type_id' => 6,
			'url' => $this->mod->route . '/discussion/'.$group->group_id,
			'created_by' => $this->user->user_id
		);
		$this->gn->add( $notif, array($this->input->post('user_id')) );
		$this->response->group_notif = array($this->input->post('user_id'));

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();		
	}

	function _list_options_active( $record, &$rec )
	{
		if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}	
		
		if( isset($this->permission['delete']) && $this->permission['delete'] )
		{
			$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
			//$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
		}

		$rec['options'] .= '<li><a href="'.$this->mod->url . '/discussion/' . $record['record_id'].'"><i class="fa fa-info"></i> Discussion</a></li>';
		$rec['options'] .= '<li><a href="javascript:leave_group('.$record['record_id'].')"><i class="fa fa-book"></i> Leave Group</a></li>';
	}

	function leave_group()
	{
		$this->_ajax_only();
		$this->response->refresh = true;
		
		$update = array(
			'leave_date' => date('Y-m-d'),
			'left_group' => 1
		);
		$where = array(
			'group_id' => $this->input->post('group_id'),
			'user_id' => $this->user->user_id
		);
		$this->db->update('groups_members', $update, $where);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();		
	}

	function add_post()
	{
		$this->_ajax_only();
		if( !$this->mod->is_member( $this->input->post('group_id'), $this->user->user_id ) )
		{
			$this->response->message[] = array(
				'message' => lang('my_group.add_post_msg'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		if( !$this->input->post('group_id') )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$post = $this->input->post('post');
		if( empty($post) )
		{
			$this->response->message[] = array(
				'message' => lang('my_group.msg_post_validation'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$insert = array(
			'group_id' => $this->input->post('group_id'),
			'post' => $post,
			'created_by' => $this->user->user_id,
			'modified_by' => $this->user->user_id,
			'modified_on' => date('Y-m-d H:i:s'),
		);

		$this->db->insert('groups_post', $insert);
		$id = $this->db->insert_id();
		$this->response->post_id = $id;

		$uploads = $_POST['discussion_upload'];
			unset($_POST['discussion_upload']);
			//debug($uploads); exit();
			$where = array(
				'post_id' => $id,
			);
			$this->db->delete('groups_post_upload', $where);

			if( count($uploads['upload_id']) > 0 )
			{
				$uploads = explode(',', $uploads['upload_id']);
				foreach( $uploads as $upload_id )
				{
					$insert = array(
						'post_id' => $id,
						'upload_id' => $upload_id
					);
					$this->db->insert('groups_post_upload', $insert);
				}

			}

		//notify members
		$this->db->limit(1);
		$group = $this->db->get_where('groups', array('group_id' => $this->input->post('group_id')))->row();
		$this->db->limit(1);
		$user = $this->db->get_where('users', array('user_id' => $this->user->user_id))->row();
		$this->load->model('group_notification_model', 'gn');
		$notif = array(
			'notif' =>  lang('my_group.added')." {$group->group_name} ".lang('my_group.by')." {$user->full_name} : {$post}",
			'type_id' => 3,
			'post_id' => $id,
			'url' => $this->mod->route . '/discussion/'.$group->group_id,
			'created_by' => $this->user->user_id
		);
		
		$this->response->group_notif = $this->mod->_get_members($group->group_id);
		if(($key = array_search($this->user->user_id, $this->response->group_notif)) !== false) {
		    unset($this->response->group_notif[$key]);
		}
		$this->gn->add( $notif, $this->response->group_notif );

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function get_single_post()
	{
		$this->_ajax_only();
		if( !$this->mod->is_member( $this->input->post('group_id'), $this->user->user_id ) )
		{
			$this->response->message[] = array(
				'message' => lang('my_group.msg_add_post_not_member'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		if( !$this->input->post('post_id') )
		{
			
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$vars['post'] = $post = $this->mod->get_post( $this->input->post('post_id') );
		
		if( $post )
		{
			
			$this->load->vars( $vars );
			$this->response->post = $this->load->view('discussion/post', '', true);
			$this->response->message[] = array(
				'message' => '',
				'type' => 'success'
			);
		}
		else
			$this->response->message[] = array(
				'message' => lang('my_group.cannot_retrieve_post'),
				'type' => 'warning'
			);

		$this->_ajax_return();
	}

	function like_post()
	{
		$this->_ajax_only();
		$this->mod->like_post( $this->input->post('post_id'), $this->input->post('status') );
		
		$this->mod->update_timeline_post($this->input->post('post_id'));

		$this->response->like_str = $this->mod->post_like_str( $this->input->post('post_id') );

		//notify post owner
		$this->db->limit(1);
		$post = $this->db->get_where('groups_post', array('post_id' => $this->input->post('post_id')))->row();
		$this->db->limit(1);
		$group = $this->db->get_where('groups', array('group_id' => $post->group_id))->row();
		$this->db->limit(1);
		$user = $this->db->get_where('users', array('user_id' => $this->user->user_id))->row();
		$this->load->model('group_notification_model', 'gn');
		$notif = array(
			'notif' =>  lang('my_group.your_post_in')." {$group->group_name} ".lang('my_group.liked_by')." {$user->full_name}.",
			'type_id' => 7,
			'url' => $this->mod->route . '/discussion/'.$group->group_id,
			'created_by' => $this->user->user_id
		);
		$this->response->group_notif = array( $post->created_by );
		$this->gn->add( $notif, $this->response->group_notif );

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function add_comment()
	{
		$this->_ajax_only();
		$comment_id = $this->mod->add_comment( $this->input->post('post_id'), $this->input->post('comment'), $this->input->post('comment_id') );
		$vars['comment'] = $comment = $this->mod->get_comment( $comment_id );
		if( $comment )
			$this->response->comment = $this->load->view('discussion/comment', $vars, true);
		else
			$this->response->comment = "";

		if( $this->input->post('comment_id') )
			$this->response->comment_id = $comment_id;

		$this->mod->update_timeline_post($this->input->post('post_id'));

		//notify post owner
		$post = $this->db->get_where('groups_post', array('post_id' => $this->input->post('post_id')))->row();
		$this->db->limit(1);
		$group = $this->db->get_where('groups', array('group_id' => $post->group_id))->row();
		$this->db->limit(1);
		$user = $this->db->get_where('users', array('user_id' => $this->user->user_id))->row();
		$this->load->model('group_notification_model', 'gn');
		$notif = array(
			'notif' =>  lang('my_group.added_by')." {$user->full_name} to your post in {$group->group_name}.",
			'type_id' => 4,
			'url' => $this->mod->route . '/discussion/'.$group->group_id,
			'created_by' => $this->user->user_id
		);
		$this->response->group_notif = array( $post->created_by );
		$this->gn->add( $notif, $this->response->group_notif );

		//notify other commenters
		$commenters = $this->mod->_get_other_commenters($post->post_id, $post->created_by, $this->user->user_id);
		if( $commenters )
		{
			$notif = array(
				'notif' =>  "{$user->full_name} ".lang('my_group.also_commented')." {$group->group_name}.",
				'type_id' => 8,
				'url' => $this->mod->route . '/discussion/'.$group->group_id,
				'created_by' => $this->user->user_id
			);
			$this->response->group_notif = array( $this->response->group_notif, $commenters );
			$this->gn->add( $notif, $commenters );
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();	
	}


	function delete_comment()
	{
		$this->_ajax_only();

		$where = array(
			'comment_id' => $this->input->post('comment_id'),
			'user_id' => $this->user->user_id
		);
		$this->db->update('groups_post_comments', array('deleted' => 1), $where);
		
		$comment = $this->mod->get_comment( $this->input->post('comment_id') );
		$comments = $this->mod->get_comments( $comment->post_id );
		if ( $comments ){
			$this->response->comment = "";
        	foreach ($comments as $comment){
        		$this->response->comment .= $this->load->view('discussion/comment', array('comment' => $comment), true);		
        	}
		}

		$this->mod->update_timeline_post( $comment->post_id );

		$this->response->post_id = $comment->post_id;

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();	
	}

	function comment_form()
	{
		$this->_ajax_only();
		$this->db->limit(1);
		$comment = $this->db->get_where('groups_post_comments', array('comment_id' => $this->input->post('comment_id')))->row_array();
		$this->response->comment_form = $this->load->view('discussion/comment-form', $comment, true);
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();	
	}
}