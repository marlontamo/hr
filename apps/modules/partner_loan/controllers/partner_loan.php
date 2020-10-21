<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Partner_loan extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('partner_loan_model', 'mod');
		parent::__construct();
		$this->lang->load('payroll_employee_loan');
	}

	function index()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$payroll_loan = $this->db->get_where('payroll_loan', array('deleted' => 0));
		$data['loan_types'] = $payroll_loan->result();

		$payroll_loan_status = $this->db->get_where('payroll_loan_status', array('deleted' => 0));
		$data['loan_statuses'] = $payroll_loan_status->result();

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
				if( $filter_value != "" ) $filter .= ' AND '. "{$this->db->dbprefix}payroll_partners_loan.".$filter_by_key .' = "'.$filter_value.'"';	
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

	public function add()
    {
		$data['userdata'] = $this->config->config['user']['sensitivity'];
		$this->load->vars($data);   
        parent::add();
    }

	function save()
	{
		parent::save( true );
		$partner_loan = $this->db->get_where('payroll_partners_loan',array('partner_loan_id' => $this->response->record_id) );
		if($partner_loan->num_rows > 0){
			$record = $partner_loan->row();
			$desc = $this->db->get_where('payroll_loan',array('loan_id' => $record->loan_id) )->row();
			$this->db->update( 'payroll_partners_loan', array('description' => $desc->loan), array('partner_loan_id' => $this->response->record_id));
		}

		$this->response->message[] = array(
	        'message' => lang('common.save_success'),
	        'type' => 'success'
	    );
	        

        $this->_ajax_return();
	}
}