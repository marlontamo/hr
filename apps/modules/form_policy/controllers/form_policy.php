<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Form_policy extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('form_policy_model', 'mod');
		parent::__construct();
	}

	public function index(){

		$data = array();

		$data['forms'] = $this->mod->_getFormsList();
		$this->load->vars( $data );

        echo $this->load->blade('record_listing_custom')->with( $this->load->get_cached_vars() );
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

		$trash = $this->input->post('trash') == 'true' ? true : false;

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
		
		$page = ($page-1) * 10; //echo $page;
		$records = $this->mod->_get_list($page, 10, $search, $filter, $trash);
		$this->response->records_retrieve = sizeof($records);
		$this->response->list = '';
        if( count($records) > 0 ){

			foreach( $records as $record )
			{
				$rec = array(
					'detail_url' => '#',
					'edit_url' => '#',
					'delete_url' => '#',
					'options' => ''
					);

				if(!$trash)
					$this->_list_options_active( $record, $rec );
				else
					$this->_list_options_trash( $record, $rec );				
				
				$record = array_merge($record, $rec);

				$permission_list['permission'] = $this->permission;
				$record = array_merge($record, $permission_list);
				
				$this->response->list .= $this->load->blade('list_template', $record, true);
			}
        }
        else{

            $this->response->list = "";

        }

		$this->_ajax_return();
	}

	public function detail($user_id=0){
		
		if( !$this->permission['list'] ){
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
				);
			$this->_ajax_return();
		}

		$data = array();

		$this->load->vars($data);
		echo $this->load->blade('edit.detail_custom')->with( $this->load->get_cached_vars() );
	}

	function _list_options_active( $record, &$rec )
	{
		if( isset($this->permission['detail']) && $this->permission['detail'] )
		{
			$rec['detail_url'] = $this->mod->url . '/detail/' . $record['record_id'];
			$rec['options'] .= '<li><a href="'.$rec['detail_url'].'"><i class="fa fa-search"></i> View</a></li>';
		}

		if( isset($this->permission['edit']) && $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}	
		
		if( isset($this->permission['delete']) && $this->permission['delete'] )
		{
			$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
			$rec['delete_url_javascript'] = "javascript: delete_record(".$record['record_id'].")";
			$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
		}
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

			if(isset($_POST['time_form_class_policy']['company_id'])){

				$company_id = implode(",", $_POST['time_form_class_policy']['company_id']);

				if(isset($_POST['time_form_class_policy']['division_id'])){
					$division_id = implode(",", $_POST['time_form_class_policy']['division_id']);
				}
				else{
					$division_id = 'ALL';
				}

				if(isset($_POST['time_form_class_policy']['department_id'])){
					$department_id = implode(",", $_POST['time_form_class_policy']['department_id']);
				}
				else{
					$department_id = 'ALL';
				}

				if(isset($_POST['time_form_class_policy']['group_id'])){
					$group_id = implode(",", $_POST['time_form_class_policy']['group_id']);
				}
				else{
					$group_id = 'ALL';
				}

				if(isset($_POST['time_form_class_policy']['employment_status_id'])){
					$employment_status_id = implode(",", $_POST['time_form_class_policy']['employment_status_id']);
				}
				else{
					$employment_status_id = 'ALL';
				}

				if(isset($_POST['time_form_class_policy']['employment_type_id'])){
					$employment_type_id = implode(",", $_POST['time_form_class_policy']['employment_type_id']);
				}
				else{
					$employment_type_id = 'ALL';
				}

				$record = array(

					'class_id' => $_POST['time_form_class_policy']['class_id'],
					'class_value' => $_POST['time_form_class_policy']['class_value'],
					'description' => $_POST['time_form_class_policy']['description'],
					'severity' => $_POST['time_form_class_policy']['severity'],
					'company_id' => $company_id,
					'division_id' => $division_id,
					'department_id' => $department_id,
					'group_id' => $group_id,
					'employment_status_id' => $employment_status_id,
					'employment_type_id' => $employment_type_id
				);

				$qry = "SELECT * FROM ww_time_form_class_policy WHERE id = '" .$_POST['record_id']. "'";

				if($this->db->query($qry)->num_rows() > 0){

					$record['modified_on'] = date('Y-m-d H:i:s');
					$record['modified_by'] = $this->user->user_id;
					$this->db->where('id', $_POST['record_id']);
					$this->db->update('time_form_class_policy', $record);
				}
				else{

					$record['created_on'] = date('Y-m-d H:i:s');
					$record['created_by'] = $this->user->user_id;
					$this->db->insert('time_form_class_policy', $record);
				}

				$this->response->message[] = array(
					'message' => lang('common.save_success'),
					'type' => 'success'
				);
			}
			else{

                $this->response->message[] = array(
                    'message' => "The Company field is required",
                    'type' => 'warning'
                );
			}

			$this->db->trans_commit();
		}
		else{
			$this->db->trans_rollback();
		}

		$this->_ajax_return();
	}

}