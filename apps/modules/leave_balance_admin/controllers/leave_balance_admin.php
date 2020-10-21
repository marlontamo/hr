<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Leave_balance_admin extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('leave_balance_admin_model', 'mod');
		parent::__construct();
	}

    public function index()
    {
        $this->load->model('my_calendar_model', 'my_calendar');
        $form_list = $this->my_calendar->get_form_policy_grant($this->user->user_id);

        $data['leave_forms'] = array();
        $form_codes = array('SL', 'VL', 'EL');
        foreach($form_list as $index => $field )
        {
            if($field['is_leave'] == 1 AND in_array($field['form_code'], $form_codes)){
                $data['leave_forms'][$field['form_id']] = $field['form'];
            }
        }
        $data['years'] = $this->mod->getYear();

        $this->load->vars($data);        
		parent::index();
    }

	public function edit( $record_id = "", $child_call = false )
	{
		if( !$this->permission['edit'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_edit( $child_call );
	}

	private function _edit( $child_call, $new = false )
	{
		$record_check = false;
		$this->record_id = $data['record_id'] = '';

		if( !$new ){
			if( !$this->_set_record_id() )
			{
				echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
				die();
			}

			$this->record_id = $data['record_id'] = $_POST['record_id'];
		}
		
		$record_check = $this->mod->_exists( $this->record_id );
		if( $new || $record_check === true )
		{
			$result = $this->mod->_get( 'edit', $this->record_id );
			if( $new )
			{
				$field_lists = $result->list_fields();
				foreach( $field_lists as $field )
				{
					$data['record'][$field] = '';
				}
			}
			else{
				$record = array();
				if ($result && $result->num_rows() > 0){
					$record = $result->row_array();
				}
				foreach( $record as $index => $value )
				{
					$record[$index] = trim( $value );	
				}
				$data['record'] = $record;

				$this->db->where('deleted',0);
				$this->db->where('leave_balance_id',$this->record_id);
				$result = $this->db->get('ww_time_form_balance_accrual');

				$data['leave_accrual'] = $result;
			}

			$this->record = $data['record'];
			$this->load->vars( $data );

			if( !$child_call ){
				$this->load->helper('form');
				$this->load->helper('file');
				echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
			}
		}
		else
		{
			$this->load->vars( $data );
			if( !$child_call ){
				echo $this->load->blade('pages.error', array('error' => $record_check))->with( $this->load->get_cached_vars() );
			}
		}
	}

	function get_leave_accrual(){
		$this->load->helper('form');

		$this->db->where('id',$this->input->post('record_id'));
		$this->db->join('time_form','time_form_balance.form_id = time_form.form_id');
		$result = $this->db->get('time_form_balance');

		$form_info = array();
		if ($result && $result->num_rows() > 0){
			$form_info = $result->row();
		}

		$record = array('year_id' => '','month_id' => '','accrual' => '');
		$year_month = date('Y-m',strtotime($this->input->post('date')));
		$this->db->where('deleted',0);
		$this->db->where('leave_balance_id',$this->input->post('record_id'));
		$this->db->like('date_accrued',$year_month,'after');
		$record_result = $this->db->get('time_form_balance_accrual');
		if ($record_result && $record_result->num_rows() > 0){
			$row = $record_result->row();
			$record['year_id'] = date('Y',strtotime($row->date_accrued));
			$record['month_id'] = date('n',strtotime($row->date_accrued));
			$record['accrual'] = $row->accrual;
		}

		$data['form_info'] = $form_info;
		$data['record_id'] = $this->input->post('record_id');
		$data['record'] = $record;

		$this->response->edit_accrual = $this->load->view('edit/custom_fgs/edit_leave_accrual.blade.php', $data, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();		

	}

	function delete_credit(){
		$record_id = $this->input->post('record_id');
		$year_month = date('Y-m',strtotime($this->input->post('date')));
		$qry = "leave_balance_id = {$record_id} AND date_accrued LIKE '{$year_month}%' AND deleted = 0";

		$this->db->query("INSERT {$this->db->dbprefix}time_form_balance_accrual_deleted (user_id, leave_balance_id, form_id, form_code, date_accrued, accrual, created_on, modified_on)
		                       SELECT user_id, leave_balance_id, form_id, form_code, date_accrued, accrual, created_on, modified_on
	                           FROM {$this->db->dbprefix}time_form_balance_accrual
	                           WHERE leave_balance_id = {$record_id} AND date_accrued LIKE '{$year_month}%' AND deleted = 0");

		if($this->db->affected_rows() > 0){
			$this->db->where($qry);
			$this->db->delete('time_form_balance_accrual');		    
		}


		$this->db->where('id',$record_id);
		$this->db->update('time_form_balance',array('modified_on' => date('Y-m-d H:i:s')));	

		$this->db->where('id',$record_id);
		$bal = $this->db->get('time_form_balance');
		$credit_current = 0;
		if ($bal && $bal->num_rows() > 0){
			$credit_current = $bal->row()->current;
		}

		$this->response->credit_current = $credit_current;

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();		

	}

	function save_credits(){
		$record_id = $this->input->post('record_id');
		$month = $this->input->post('month');
		$month = str_pad($month, 2, "0", STR_PAD_LEFT);
		$year = $this->input->post('year');
		$this->db->where('deleted',0);
		$this->db->where('leave_balance_id',$record_id);
		$this->db->like('date_accrued',$year.'-'.$month,'after');
		$result = $this->db->get('time_form_balance_accrual');
		
		if ($result && $result->num_rows() > 0){
			$year_month = $year.'-'.$month;
			$qry = "leave_balance_id = {$record_id} AND date_accrued LIKE '{$year_month}%' AND deleted = 0";
			$this->db->where($qry);
			$this->db->update('time_form_balance_accrual',array('accrual' => $this->input->post('accrued'),'modified_on' => date('Y-m-d H:i:s')));		
		}
		else{
			$year_month_date = $year.'-'.$month.'-'.date('d');
			$info = array(
					'user_id' => $this->input->post('user_id'),
					'leave_balance_id' => $record_id,
					'form_id' => $this->input->post('form_id'),
					'form_code' => $this->input->post('form_code'),
					'date_accrued' => $year_month_date,
					'accrual' => $this->input->post('accrued'),
					'modified_on' => date('Y-m-d H:i:s')
				);

			$this->db->insert('time_form_balance_accrual',$info);
		}

		$this->db->where('id',$record_id);
		$this->db->update('time_form_balance',array('modified_on' => date('Y-m-d H:i:s')));	

		$this->db->where('deleted',0);
		$this->db->where('leave_balance_id',$record_id);
		$result = $this->db->get('ww_time_form_balance_accrual');

		$data['leave_accrual'] = $result;
		$data['record_id'] = $record_id;
		$this->response->list_accrual = $this->load->view('edit/custom_fgs/list_leave_accrual.blade.php', $data, true);

		$this->db->where('id',$record_id);
		$bal = $this->db->get('time_form_balance');
		$credit_current = 0;
		if ($bal && $bal->num_rows() > 0){
			$credit_current = $bal->row()->current;
		}

		$this->response->credit_current = $credit_current;
		
		$this->response->message[] = array(
			'message' => lang('common.save_success'),
			'type' => 'success'
		);

        $this->_ajax_return();
	}

	function get_credits(){
		$record_id = $this->input->post('record_id');
		$month = $this->input->post('month');
		$month = str_pad($month, 2, "0", STR_PAD_LEFT);
		$year = $this->input->post('year');
		$this->db->where('deleted',0);
		$this->db->where('leave_balance_id',$record_id);
		$this->db->like('date_accrued',$year.'-'.$month,'after');
		$result = $this->db->get('time_form_balance_accrual');
		
		$row_array = array();
		if ($result && $result->num_rows() > 0){
			$row_array = $result->row_array();				
		}

		$this->response->leave_bal_info = $row_array;

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

        $this->_ajax_return();
	}

	function save()
	{
		//validate if duplicate entry (user, form, year)
		$record_id_check = $this->input->post('record_id');
		$time_form_balance = $this->input->post('time_form_balance');

		$is_exist_sql = "SELECT *
							FROM ww_time_form_balance tb WHERE deleted=0
								AND user_id = {$time_form_balance['user_id']}
								AND form_id = {$time_form_balance['form_id']}
								AND year = {$time_form_balance['year']}
								
								";	
		if($this->input->post('record_id') > 0){
			$is_exist_sql .= " AND id != {$record_id_check}";
		}

		$result_exist = $this->db->query( $is_exist_sql );
		
		$is_exist = 0;
		if ($result_exist && $result_exist->num_rows() > 0){
			$is_exist = $result_exist->num_rows();
		}
		
		if($is_exist > 0){
			$this->response->message[] = array(
				'message' => "Duplicate entry! <br>Leave balance for the selected employee already created",
				'type' => 'warning'
			);
		$this->_ajax_return();
		}

    	if((!empty($time_form_balance['period_from']) && $time_form_balance['period_from'] != '') && (!empty($time_form_balance['period_to']) && $time_form_balance['period_to'] != '')){
    		if (strtotime($time_form_balance['period_from']) > strtotime($time_form_balance['period_to'])){
				$this->response->message[] = array(
					'message' => "Date from should be less than with date to",
					'type' => 'error'
				);
				$this->_ajax_return();    			
    		}
		}

		parent::save( true );
		if( $this->response->saved )
        {        	
        	if(empty($time_form_balance['period_from']) || $time_form_balance['period_from'] == ''){
				
				$this->db->where($this->mod->primary_key, $this->record_id);
            	$this->db->update($this->mod->table, array('period_from' => '0000-00-00' ));
			}

        	if(empty($time_form_balance['period_to']) || $time_form_balance['period_to'] == ''){
				
				$this->db->where($this->mod->primary_key, $this->record_id);
            	$this->db->update($this->mod->table, array('period_to' => '0000-00-00' ));
			}

        	if(empty($time_form_balance['period_extension']) && $time_form_balance['period_extension'] == ''){
				$this->db->where($this->mod->primary_key, $this->record_id);
            	$this->db->update($this->mod->table, array('period_extension' => date('Y-m-d',strtotime($time_form_balance['period_to'] ))));
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
		// echo "<pre>"print_r($record);
		//temp remove until view functionality added
		if( $this->permission['detail'] )
		{
			$this->load->model('leave_filed_admin_model', 'leavef');
			$rec['detail_url'] = $this->leavef->url . '/index/' . $record['form_id'].'/'. $record['time_form_balance_year'].'/'. $record['user_id'];
			$rec['options'] .= '<li><a href="'.$rec['detail_url'] .'"><i class="fa fa-info"></i> View</a></li>';
		}

		if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}	
		
		if( isset($this->permission['delete']) && $this->permission['delete'] )
		{
			$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
			$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
		}
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
		$this->response->q = $this->db->last_query();
		$this->_process_lists( $records, $trash );

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

			if(!$trash)
				$this->_list_options_active( $record, $rec );
			else
				$this->_list_options_trash( $record, $rec );

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
				if($filter_by_key == "form_id"){
					$filter_by_key = "T3.".$filter_by_key;
				}
				if( $filter_value != "" ) $filter .= ' AND '. $filter_by_key .' = "'.$filter_value.'"';	
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

}