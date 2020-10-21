<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Batch_transaction extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('batch_transaction_model', 'mod');
		parent::__construct();
	}

	function edit()
	{
		parent::edit( '', true );

		$this->_set_employee_lists();

		$this->load->helper('form');
		$this->load->helper('file');
		echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
	}

	function add()
	{
		parent::add( '', true );

		$this->_set_employee_lists();

		$this->load->helper('form');
		$this->load->helper('file');
		echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
	}

	private function _set_employee_lists()
	{
		$data['employee_table'] = "";
		
		if( !empty( $this->record_id ) )
		{
			$qry = "SELECT a.employee_id, AES_DECRYPT(a.quantity, encryption_key()) as quantity, AES_DECRYPT(a.unit_rate, '{$this->config->item('encryption_key')}') as amount, b.full_name, c.id_number
			FROM {$this->db->dbprefix}payroll_entry_batch_employee a
			LEFT JOIN {$this->db->dbprefix}users b on b.user_id = a.employee_id
			LEFT JOIN {$this->db->dbprefix}partners c on c.user_id = a.employee_id
			LEFT JOIN {$this->db->dbprefix}payroll_partners p on p.user_id = a.employee_id
			WHERE a.batch_entry_id = {$this->record_id}";
			$sensID = $this->config->config['user']['sensitivity'];
			if($sensID && !empty($sensID) ){
				$qry .= " AND p.sensitivity IN ( ".$sensID." ) ";
			}
			$qry .= " ORDER BY b.full_name";
			$emps = $this->db->query( $qry );

			foreach( $emps->result() as $emp)
			{
				$emp->amount = trim( $emp->amount );
				$emp->quantity = trim( $emp->quantity );
				$emp->total = $emp->quantity * $emp->amount;
				
				$emp->amount = number_format( $emp->amount, 2, '.', ',');
				$emp->quantity = number_format( $emp->quantity, 2, '.', ',');
				$emp->total = number_format( $emp->total, 2, '.', ',');

				$data['employee_table'] .= $this->load->view('edit/employee-lists', array( 'employee' => $emp), true);
			}
		}

		$this->load->vars( $data );
	}

	function get_add_employee_form()
	{
		$this->_ajax_only();

		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$post['group'] = $this->input->post('group');
		$post['employee_id'] = "";
		if( $this->input->post('employee_id') )
		{
			$post['employee_id'] = $this->input->post('employee_id');
			$post['employee_id'] = implode(',', $post['employee_id']);	
		}
		$post['group_lists'] = $this->mod->_get_group_lists( $post['group'] );

		$data['title'] = 'Batch Transaction';
		$data['content'] = $this->load->view('edit/add_employee_form', $post, true);

		$this->response->add_employee_form = $this->load->view('templates/modal', $data, true);	

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function get_employees()
	{
		$this->_ajax_only();

		$user = $this->config->item('user');

		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$err = 0;

		$this->response->employees = "";

		$group = $this->input->post('group');
		$group_id = $this->input->post('group_id');
		if( empty( $group_id  ) )
		{
			$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

			$this->_ajax_return();	
		}
		$group_id = implode( ',', $group_id );
		$except = $this->input->post('except');

		$qry = "SELECT a.user_id, a.full_name, b.company, c.department, d.id_number
		FROM {$this->db->dbprefix}users a
		INNER JOIN {$this->db->dbprefix}users_profile b on b.user_id = a.user_id
		INNER JOIN {$this->db->dbprefix}users_department c on c.department_id = b.department_id
		INNER JOIN {$this->db->dbprefix}partners d on d.user_id = a.user_id
		LEFT JOIN {$this->db->dbprefix}payroll_partners p on p.user_id = a.user_id
		WHERE a.deleted = 0 AND a.active = 1 ";

		$role_cat = '';
		switch( $group )
		{
			case 'company':
				$this->db->where('role_id',$user['role_id']);
				$this->db->where('category_field','company_id');
				$role_category_result = $this->db->get('roles_category');
				$role_cat_array = array();
				if ($role_category_result && $role_category_result->num_rows() > 0){
					$role_cat = $role_category_result->row()->category_val;
					$role_cat_array = explode(',',$role_cat);
				}
				if ($role_cat != ''){
					foreach (explode(',', $group_id) as $key => $value) {
						if (in_array($value, $role_cat_array)){
							$qry .= "AND b.company_id IN ({$value}) ";
							$err = 0;
							$role_cat_array = array_diff($role_cat_array, array($value));
						}
						else{
							$role_cat_comma = implode(',', $role_cat_array);
							$err = 1;
							if (!empty($role_cat_array)){
								$new_cat = $role_cat_comma .','. $value;
							}
							else{
								$new_cat = $value;
							}
							$qry .= "AND b.company_id NOT IN ({$new_cat}) ";
						}
					}
				}
				else{
					$qry .= "AND b.company_id IN ({$group_id}) ";
				}
				break;
			case 'department':
				$this->db->where('role_id',$user['role_id']);
				$this->db->where('category_field','department_id');
				$role_category_result = $this->db->get('roles_category');
				$role_cat_array = array();
				if ($role_category_result && $role_category_result->num_rows() > 0){
					$role_cat = $role_category_result->row()->category_val;
					$role_cat_array = explode(',',$role_cat);
				}
				if ($role_cat != ''){
					foreach (explode(',', $group_id) as $key => $value) {
						if (in_array($value, $role_cat_array)){
							$qry .= "AND b.department_id IN ({$value}) ";
							$err = 0;
							$role_cat_array = array_diff($role_cat_array, array($value));
						}
						else{
							$role_cat_comma = implode(',', $role_cat_array);
							$err = 1;
							if (!empty($role_cat_array)){
								$new_cat = $role_cat_comma .','. $value;
							}
							else{
								$new_cat = $value;
							}
							$qry .= "AND b.department_id NOT IN ({$new_cat}) ";
						}
					}
				}
				else{
					$qry .= "AND b.department_id IN ({$group_id}) ";
				}				
				break;
			case 'branch':
				$this->db->where('role_id',$user['role_id']);
				$this->db->where('category_field','branch_id');
				$role_category_result = $this->db->get('roles_category');
				$role_cat_array = array();
				if ($role_category_result && $role_category_result->num_rows() > 0){
					$role_cat = $role_category_result->row()->category_val;
					$role_cat_array = explode(',',$role_cat);
				}
				if ($role_cat != ''){
					foreach (explode(',', $group_id) as $key => $value) {
						if (in_array($value, $role_cat_array)){
							$qry .= "AND b.branch_id IN ({$value}) ";
							$err = 0;
							$role_cat_array = array_diff($role_cat_array, array($value));
						}
						else{
							$role_cat_comma = implode(',', $role_cat_array);
							$err = 1;
							if (!empty($role_cat_array)){
								$new_cat = $role_cat_comma .','. $value;
							}
							else{
								$new_cat = $value;
							}
							$qry .= "AND b.branch_id NOT IN ({$new_cat}) ";
						}
					}
				}
				else{
					$qry .= "AND b.branch_id IN ({$group_id}) ";
				}					
				break;				
			case 'position':
				$qry .= "AND b.position_id IN ({$group_id}) ";
				break;
			case 'employee_type':
				$qry .= "AND d.employment_type_id IN ({$group_id}) ";
				break;
			case 'location':
				$qry .= "AND b.location_id IN ({$group_id}) ";
				break;
		}

		if( !empty($except) )
		{
			$qry .= " AND a.user_id NOT IN ({$except}) ";
		}

		$sensID = $this->config->config['user']['sensitivity'];
		if($sensID && !empty($sensID) ){
			$qry .= " AND p.sensitivity IN ( ".$sensID." ) ";
		}

		$qry .= "order by a.full_name asc";

		$result = $this->db->query( $qry );
		foreach( $result->result()  as $employee )
		{
			$this->response->employees .= $this->load->view('edit/add_employee', array('employee' => $employee), true);
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		if ($err == 1){
			$this->response->message[] = array(
				'message' => 'Result is empty because it was not set in role (category)',
				'type' => 'warning'
			);
		}
		
		$this->_ajax_return();
	}

	function add_employees()
	{
		$this->_ajax_only();

		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$this->response->employees = "";
		
		$qry = "select a.user_id as employee_id, a.full_name, 1 as  quantity, 0 as amount, b.id_number
		FROM {$this->db->dbprefix}users a
		LEFT JOIN {$this->db->dbprefix}partners b on b.user_id = a.user_id";

		$employees = $this->input->post('employees');
		$limit = sizeof( $employees );
		$employees = implode(',', $employees);

		$qry .= " WHERE a.user_id in ({$employees}) AND a.deleted = 0 limit {$limit}";
		$emps = $this->db->query( $qry );
		foreach( $emps->result() as $emp)
		{
			$emp->amount = $this->input->post('unit_rate') ? trim( str_replace(",", "", $this->input->post('unit_rate') ) ) : 0;
			$emp->quantity = trim( $emp->quantity );
			$emp->total = $emp->quantity * $emp->amount;
			
			$emp->amount = number_format( $emp->amount, 2, '.', ',');
			$emp->quantity = number_format( $emp->quantity, 2, '.', ',');
			$emp->total = number_format( $emp->total, 2, '.', ',');

			$this->response->employees .= $this->load->view('edit/employee-lists', array( 'employee' => $emp), true);
		}

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function save()
	{
		$this->_ajax_only();

		if( !$this->_set_record_id() )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'error'
			);
			$this->_ajax_return();	
		}
		
		if( (empty( $this->record_id ) && !$this->permission['add']) || ($this->record_id && !$this->permission['edit']) )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$this->db->trans_begin();
		$this->response = $this->mod->_save( true, false );

		if( $this->response->saved ){
			if( $this->input->post('payroll_entry_batch_employee') )
			{
				$batch_employee = $this->input->post('payroll_entry_batch_employee');
				$employee = $batch_employee['employee_id'];
				$quantity = $batch_employee['quantity'];
				$amount = $batch_employee['amount'];

				$qry = "DELETE FROM {$this->db->dbprefix}payroll_entry_batch_employee
						  WHERE batch_entry_id = {$this->response->record_id} ";
				
				$sensID = $this->config->config['user']['sensitivity'];
				if($sensID && !empty($sensID) ){
					$qry .= " AND employee_id IN ( SELECT user_id FROM {$this->db->dbprefix}payroll_partners WHERE sensitivity IN ( ".$sensID." ) )";
				}
				$this->db->query($qry);

				//create system logs
				$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'delete', 'payroll_entry_batch_employee - batch_entry_id', array(), array('batch_entry_id' => $this->response->record_id));
				
				$this->load->library('aes', array('key' => $this->config->item('encryption_key')));

				foreach( $employee as $index => $employee_id )
				{
					if( empty( $quantity[$index] ) || empty( $amount[$index] ) )
					{
						$this->db->trans_rollback();
						$this->response->saved = false;
						$this->response->message[] = array(
							'message' => 'The amount and quantity fields are required, please enter respected values.',
							'type' => 'warning'
						);
						$this->_ajax_return();
					}
					$this->db->select('id_number');
					$this->db->from('partners');
					$this->db->where('user_id', $employee_id);
					$res = $this->db->get()->row();
					
					$id_number = $res->id_number;
					$qty = $this->aes->encrypt( str_replace(',', '', $quantity[$index]) );
					$amt = $this->aes->encrypt( str_replace(',', '', $amount[$index]) );
					$total = number_format( str_replace(',', '', $quantity[$index]) * str_replace(',', '', $amount[$index]) , 2,'.',',' );
					$tot_amt = $this->aes->encrypt( str_replace(',', '', $total ) );
					$insert = array(
						'batch_entry_id' => $this->response->record_id,
						'id_number' => $id_number,
						'employee_id' => $employee_id,
						'unit_rate' => $amt,
						'quantity' => $qty,
						'amount' => $tot_amt
					);
					$this->db->insert('payroll_entry_batch_employee', $insert);
					//create system logs
					$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'insert', 'payroll_entry_batch_employee', array(), $insert);
				}

				$this->db->trans_commit();
			}
			else{
				$this->db->trans_commit();
			}
		}
		else{
			$this->db->trans_rollback();
		}
		
		$this->response->message[] = array(
			'message' => lang('common.save_success'),
			'type' => 'success'
		);

		$this->_ajax_return();
	}
}