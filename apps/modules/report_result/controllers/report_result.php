<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report_result extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('report_result_model', 'mod');
		parent::__construct();
	}

	function files()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}
		
		if( !$this->_set_record_id() )
		{
			echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
			die();
		}

		//check for access
		$user = $this->config->item('user');
		$this->db->limit(1);
		$role_check = $this->db->get_where('report_generator_role', array('report_id' => $this->record_id, 'role_id' => $user['role_id']))->num_rows();
		if( empty($role_check) )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$data['record_id'] = $this->record_id;
		$this->load->vars( $data );

		echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
	}
}