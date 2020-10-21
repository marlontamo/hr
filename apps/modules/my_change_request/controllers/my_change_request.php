<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_change_request extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('my_change_request_model', 'mod');
		parent::__construct();
	}

	public function index()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->load->model('signatories_model', 'signatories');
		$data['approver'] = $this->signatories->check_if_approver( $this->user->user_id );
		
		$this->load->vars( $data );

		echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
	}

	function cr_form()
	{
		$this->_ajax_only();

		$this->load->helper('form');
		$this->load->model('profile_model', 'profile');
		$this->load->model('change_request_model', 'change_request');
		
		$partner_id = get_partner_id( $this->user->user_id );
		if(empty($partner_id)){
			$partner_id = $this->get_partner_id( $this->user->user_id );
		}

		$key_classes = $this->profile->get_user_editable_key_classes();
		$data['key_classes'] = array();
		foreach( $key_classes as $row )
		{
			//check wether key_class has active request
			if( !$this->profile->has_active_request( $row->key_class_id, $partner_id ) )
				$data['key_classes'][$row->key_class_id] = $row->key_class; 
		}

		$drafts = $this->profile->get_user_editable_keys_draft( $partner_id );
		$draft = array();
		foreach( $drafts as $row )
		{
			$draft[$row->key_class_id][$row->key_id] = $row; 
		}

		$data['draft'] = '';
		foreach( $draft as $key_class_id => $keys )
		{
			$temp = array();
			foreach ($keys as $key_id => $key) {
				$temp[] = $this->profile->create_key_draft( $key, $key->key_value );
			}
			$temp = implode('', $temp);

			$data['draft'] .= $this->load->view('draft', array('key_class_id' => $key_class_id,'keys' => $temp), true);
		}

		$this->load->vars($data);

		$data = array();
		$data['title'] = 'Change Request';
		$data['content'] = $this->load->blade('cr_form')->with( $this->load->get_cached_vars() );
		$this->response->cr_form = $this->load->view('templates/modal', $data, true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function add_class_draft()
	{
		$this->_ajax_only();

		$key_class_id = $this->input->post('key_class_id');

		$this->load->model('profile_model', 'profile');

		$keys = $this->profile->get_user_editable_keys( $key_class_id );
		$temp = array();
		foreach( $keys as $key )
		{
			$temp[] = $this->profile->create_key_draft( $key, '' );	
		}
		$temp = implode('', $temp);

		$this->response->class_draft = $this->load->view('draft', array('key_class_id' => $key_class_id, 'keys' => $temp), true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function save_request()
	{
		$this->_ajax_only();

		$status = $this->input->post('status');
		$classes = $this->input->post('key');
		$partner_id = get_partner_id( $this->user->user_id );
		if(empty($partner_id)){
			$partner_id = $this->get_partner_id( $this->user->user_id );
		}
		$this->response->save = false;

		$this->load->model('profile_model', 'profile');


        //SAVING START   
        $error = false;
		$transactions = true;
		$this->partner_id = 0;
		if( $transactions )
		{
			$this->db->trans_begin();
		}

		$no_delete = array();

		if( $this->input->post('key') == "")
		{
			$this->response->message[] = array(
				'message' => 'Please add atleast one item.',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}	
		else
		{
			foreach( $classes as $class_id => $keys )
			{
				$active = $this->profile->has_active_request( $class_id, $partner_id );
				$request_data = $this->profile->get_change_request_data( $class_id, $partner_id );

				$ctr = 1;
				foreach($keys as $key_id => $value)
				{
					$value = trim($value);
					if(!empty($value)){
						$no_delete[] = $key_id;

						$where = $data = array(
							'partner_id' => $partner_id,
							'key_id' => $key_id
						);

						$data['sequence'] = $ctr;
						$data['key_value'] = $value;
						$data['status'] = $status;
						$data['created_by'] = $this->user->user_id;
						
						if(count($request_data) > 0){
							foreach($request_data as $rdata){
								if($rdata['key_id'] == $key_id){
									$request_personal_id = $rdata['personal_id'];
									$where['personal_id'] = $rdata['personal_id'];
								}
							}
						}

						$if_for_approval = $this->db->get_where('partners_key_class', array('deleted' => 0, 'key_class_id' => $class_id))->row_array();

						if($active)
						{
							$this->db->update('partners_personal_request', $data, $where);
							$request_details = $this->db->get_where('partners_personal_request', $where)->row_array();
							$request_personal_id = $request_details['personal_id'];
							$data['personal_id'] = $request_details['personal_id'];
						}
						else{
							$this->db->insert('partners_personal_request', $data);
							$request_personal_id = $data['personal_id'] = $this->db->insert_id();
						}
						$data['key_id'] = $key_id;


						if($status == 2){			
							if($this->db->_error_message() != "")
							{
								$this->response->message[] = array(
									'message' => $this->db->_error_message(),
									'type' => 'error'
								);
								$error = true;
								goto stop;
							}else{
								if($if_for_approval['for_approval'] == 1){
									$populate_personal_qry = "CALL sp_partners_personal_populate_approvers({$request_personal_id}, {$this->user->user_id})";
									$result_insert_update = $this->db->query( $populate_personal_qry );
									mysqli_next_result($this->db->conn_id);
								}else{
									//set to approve
									$this->db->update('partners_personal_request', array('status' => 3), $where);
									$partners_key = $this->db->get_where('partners_key', array('deleted' => 0, 'key_id' => $key_id))->row_array();

									$sequence = 1;
									$this->load->model('partners_model', 'partners_mod');		
									$partners_personal = $this->partners_mod->get_partners_personal($this->user->user_id, 'partners_personal', $partners_key['key_code'], 1);
									$check_on_personal = $this->db->get_where('partners_personal', array('partner_id' => $partner_id, 'key_id' => $key_id))->result_array();
									
									$main_record = array();
									switch( true )
									{
										case count($check_on_personal) == 0:
											$data_personal = $this->partners_mod->insert_partners_personal($this->user->user_id, $partners_key['key_code'], $value, 1, $partner_id);
											$this->db->insert('partners_personal', $data_personal);
											$this->response->action = 'insert';
											break;
										case count($check_on_personal) > 0:
											$partners_personal = $check_on_personal[0];
											$main_record['modified_by'] = $this->user->user_id;
											$main_record['modified_on'] = date('Y-m-d H:i:s');
											$main_record['key_value'] = $value;
											$this->db->update( 'partners_personal', $main_record, array( 'personal_id' => $partners_personal['personal_id'] ) );
											$this->response->action = 'update';
											break;
										default:
											$this->response->message[] = array(
												'message' => lang('common.inconsistent_data'),
												'type' => 'error'
											);
											$error = true;
											goto stop;
									}

									if( $this->db->_error_message() != "" ){
										$this->response->message[] = array(
											'message' => $this->db->_error_message(),
											'type' => 'error'
										);
										$error = true;
										goto stop;
									}
								}
							}
						}

						$ctr++;

			            if(in_array($status, array(2))){
			                // INSERT NOTIFICATIONS FOR APPROVERS
			                $this->response->notified = $this->mod->notify_approvers( $request_personal_id, $data );
			                $this->response->notified = $this->mod->notify_filer( $request_personal_id, $data );
			            }
					}
				}
			}
		}

		$qry = "update {$this->db->dbprefix}partners_personal_request set deleted = 1
		WHERE key_id not in (".implode(',', $no_delete).") AND status = 1 AND partner_id = {$partner_id}";
		$this->db->query( $qry );
		$this->response->q = $this->db->last_query();

		stop:
		if( true )
		{
			if( !$error ){
				$this->db->trans_commit();
			}
			else{
				 $this->db->trans_rollback();
			}
		}

		if( !$error  )
		{
			$this->response->save = true;
			$this->response->message[] = array(
				'message' => 'Request successfully filed.',
				'type' => 'success'
			);
		}
		$this->_ajax_return();
	}

	function get_public_data() {
		$this->_ajax_only();

		$result = array();
		$value = trim(strtolower($_GET['term']));
		$column = $_GET['column'];

		switch($column){
			case 'countries';
			$field = 'short_name';
				$this->db->select($field)
			    ->from('countries')
			    ->where("LOWER({$field}) LIKE '%{$value}%'");
			    $result = $this->db->get('');	
		    break;
			case 'cities';
			$field = 'city';
				$this->db->select($field)
			    ->from('cities')
			    ->where("LOWER({$field}) LIKE '%{$value}%'");
			    $result = $this->db->get('');	
		    break;
		}
		
		$data = array();
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$row['label'] = trim($row[$field]);
				$data[] = $row;
			}			
		}			
		$result->free_result();

		header('Content-type: application/json');
		echo json_encode($data);
		die();
	}

	public function get_partner_id($user_id=0){
		$sql_partner = $this->db->get_where('partners', array('user_id' => $user_id));
		$partner_details = $sql_partner->row_array();
		return $partner_details['partner_id'];
	}
}