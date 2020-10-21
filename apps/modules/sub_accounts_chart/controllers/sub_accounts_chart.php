<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sub_accounts_chart extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('sub_accounts_chart_model', 'mod');
		parent::__construct();
		$this->lang->load('sub_account_charts');
	}

	function index()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$payroll_account = $this->db->get_where('payroll_account', array('deleted' => 0));
		$data['account_types'] = $payroll_account->result();

		$this->load->vars( $data );
		echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
	}

	public function get_list()
	{
		$this->_ajax_only();
		if( !$this->permission['list'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$this->response->show_import_button = false;
		if( $this->input->post('page') == 1 )
		{
			$this->load->model('upload_utility_model', 'import');
			if( $this->import->get_templates( $this->mod->mod_id ) )
				$this->response->show_import_button = true;
		}

		$trash = $this->input->post('trash') == 'true' ? true : false;
		$records = $this->_get_list( $trash );
		$this->_process_lists( $records, $trash );
		
		$this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

		$this->_ajax_return();
	}

	private function _process_lists( $records, $trash )
	{
		$this->response->records_retrieve = sizeof($records);
		$this->response->list = '';
		foreach( $records as $record )
		{
			$rec = array(
				'detail_url' => '#',
				'edit_url' => '#',
				'delete_url' => '#',
				'options' => ''
			);

			if(!$trash){
				$this->_list_options_active( $record, $rec );
			}else{
				$this->_list_options_trash( $record, $rec );
			}

			$record = array_merge($record, $rec);
			$this->response->list .= $this->load->blade('list_template', $record, true)->with( $this->load->get_cached_vars() );
		}
	}

    private function _get_list( $trash )
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
				if( $filter_value != "" ) $filter .= ' AND '. "{$this->db->dbprefix}payroll_account_sub.".$filter_by_key .' = "'.$filter_value.'"';	
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
		$records = $this->mod->_get_list($page, 10, $search, $filter, $trash);
		return $records;
	}

	function get_applied_to_options()
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

		$this->response->options = $this->mod->_get_applied_to_options( '', false, $this->input->post('category_id') );

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
		
		if( empty($_POST['payroll_account_sub']['category_val_id']) )
		{	
			$this->db->trans_rollback();
			$this->response->saved = false;
			$this->response->message[] = array(
				'message' => 'Please choose Category value.',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		if( $this->response->saved ){
			if( empty($_POST['payroll_account_sub']['category_val_id']) )
			{	
				$this->db->trans_rollback();
				$this->response->saved = false;
				$this->response->message[] = array(
					'message' => 'Please choose Category value.',
					'type' => 'warning'
				);
				$this->_ajax_return();
			} 
			else {
				$category_id = $_POST['payroll_account_sub']['category_id'];
				$category_val_id = $_POST['payroll_account_sub']['category_val_id'];
				switch( $category_id )
				{
					case 1: // branch
						$qry = "SELECT branch as value
						FROM {$this->db->dbprefix}users_branch
						WHERE deleted = 0 AND branch_id = ".$category_val_id."
						ORDER BY branch asc";
						break;
					case 2: //department
						$qry = "SELECT department as value
						FROM {$this->db->dbprefix}users_department
						WHERE deleted = 0 AND department_id = ".$category_val_id."
						ORDER BY department asc";
						break;
					case 3: //division
						$qry = "SELECT division as value
						FROM {$this->db->dbprefix}users_division
						WHERE deleted = 0 AND division_id = ".$category_val_id."
						ORDER BY division asc";
						break;
					case 4: // group
						$qry = "SELECT `group` as value
						FROM {$this->db->dbprefix}users_group
						WHERE deleted = 0 AND group_id = ".$category_val_id."
						ORDER BY `group` asc";
						break;
					case 5: // position
						$qry = "SELECT position as value
						FROM {$this->db->dbprefix}users_position
						WHERE deleted = 0 AND position_id = ".$category_val_id."
						ORDER BY position asc";
						break;
					case 6: // section
						$qry = "SELECT section as value
						FROM {$this->db->dbprefix}users_section
						WHERE deleted = 0 AND section_id = ".$category_val_id."
						ORDER BY section asc";
						break;
				}
				$category_value = $this->db->query( $qry )->row();
				$this->db->update('payroll_account_sub',
									array( 'category_val_id' => $category_val_id, 'category_value' => $category_value->value ),
									array( 'account_sub_id' => $this->response->record_id )
								);

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