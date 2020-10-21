<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Scheduler extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('scheduler_model', 'mod');
		parent::__construct();
		$this->lang->load('scheduler');
	}

	function _list_options_active( $record, &$rec )
	{
		if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}	

		if( isset($this->permission['process']) && $this->permission['process'] )
		{
			$rec['options'] .= '<li><a href="javascript:process_form('.$record['record_id'].')"><i class="fa fa-gear"></i> Process</a></li>';
		}

		if( isset($this->permission['delete']) && $this->permission['delete'] )
		{
			$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
			$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
				
		}
	}	

	function process_form()
	{
		$this->_ajax_only();
		if( !$this->permission['process'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		
		$record_id = $this->input->post('record_id');
		
		if( !$record_id )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$record = $this->db->get_where('scheduler',array('scheduler_id' => $record_id));

		if ($record && $record->num_rows() > 0){
			$row = $record->row();

			$this->db->query('CALL '.$row->sp_function.'('.$row->arguments.');');
		}


		$this->response->message[] = array(
			'message' => 'Cron successfully processed.',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

}