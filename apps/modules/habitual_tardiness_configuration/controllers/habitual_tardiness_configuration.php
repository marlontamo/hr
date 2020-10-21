<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Habitual_tardiness_configuration extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('habitual_tardiness_configuration_model', 'mod');
		parent::__construct();
		$this->lang->load('habitual_tardiness');
	}

	public function index(){
		if( !$this->permission['list'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$data['tardiness_settings'] = $this->mod->get_tardiness_settings();
		
		$this->load->vars($data);
		echo $this->load->blade('record_flat')->with( $this->load->get_cached_vars() );
	}	

	public function save(){

		$this->_ajax_only();

		if( !$this->permission['list'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}		

		$qry_string = "";
		
		$instances = $this->input->post('instances');
		$minutes_tardy = $this->input->post('minutes_tardy');
		$month_within = $this->input->post('month_within');
		$record_id = $this->input->post('record_id');

		$data = array(
						'instances' => $instances,
						'minutes_tardy' => $minutes_tardy,
						'month_within' => $month_within,
				);

		if ($record_id && $record_id != '-1'){
			$this->db->where('habitual_tardiness_id',$record_id);
			$this->db->update('time_record_tardiness_settings',$data);
		}
		else{
			$this->db->insert('time_record_tardiness_settings',$data);
		}

		$this->response->message[] = array(
			'message' => 'Data successfully saved/updated!',
			'type' => 'success'
		);
		$this->_ajax_return();					
	}	
}