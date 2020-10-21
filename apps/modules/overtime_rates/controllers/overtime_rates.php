<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Overtime_rates extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('overtime_rates_model', 'mod');
		parent::__construct();
		$this->lang->load('overtime_rates');
	}


	public function index()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}
		
		$data = array();

        $this->load->vars( $data );
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
	}

	public function save()
	{
		parent::save( true );

		$overtime_rates = $this->db->get_where('payroll_overtime_rates',array('overtime_rate_id' => $this->response->record_id) );
		if($overtime_rates->num_rows > 0){
			$record = $overtime_rates->row();
			$desc = $this->db->get_where('payroll_overtime',array('overtime_id' => $record->overtime_id) )->row();
			$this->db->update( 'payroll_overtime_rates', array('overtime_code' => $desc->overtime_code,'overtime' => $desc->overtime), array('overtime_rate_id' => $this->response->record_id));
		}

		$this->response->message[] = array(
	        'message' => lang('common.save_success'),
	        'type' => 'success'
	    );
	        

        $this->_ajax_return();
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

		$this->_ajax_return();
	}

	private function _get_list( $trash )
	{
		$page = $this->input->post('page');
		$search = $this->input->post('search');
		$filter = "";
		
		$filter_by = $this->input->post('filter_by');
		$filter_value = $this->input->post('filter_value');
		
		//company, dept, employee filter
		$company_id = $this->input->get('company');
		if($company_id > 0){					
			$filter .= ' AND a.company_id = '.$company_id;
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

			//debug($record); exit();
			$record = array_merge($record, $rec);
			$this->response->list .= $this->load->blade('list_template', $record, true)->with( $this->load->get_cached_vars() );
		}
	}

	function _list_options_active( $record, &$rec )
	{
		//temp remove until view functionality added
		if( $this->permission['detail'] )
		{
			$rec['detail_url'] = $this->mod->url . '/detail/' . $record['overtime_rate_id'];
			$rec['options'] .= '<li><a href="'.$rec['detail_url'].'"><i class="fa fa-info"></i> View</a></li>';
		}

		if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['overtime_rate_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['overtime_rate_id'] .' )';
		}	
		
		if( isset($this->permission['delete']) && $this->permission['delete'] )
		{
			$rec['delete_url'] = $this->mod->url . '/delete/' . $record['overtime_rate_id'];
			$rec['options'] .= '<li><a href="javascript: delete_record('.$record['overtime_rate_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
		}
	}
}