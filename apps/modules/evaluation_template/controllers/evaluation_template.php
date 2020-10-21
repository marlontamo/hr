<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Evaluation_template extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('evaluation_template_model', 'mod');
		parent::__construct();
	}


	function get_section_form()
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
		
		$section_id = $this->input->post('section_id');
		$evaluation_template_id = $this->input->post('template_id');
		$vars['template_section_id'] = $section_id;
		$vars['evaluation_template_id'] = $evaluation_template_id;
		$vars['template_section'] = '';
		$vars['parent_id'] = '';
		$vars['weight'] = '';
		$vars['section_type_id'] = '';
		$vars['sequence'] = '';
		$vars['header'] = '';
		$vars['footer'] = '';

		if( !empty( $section_id ) )
		{
			$data['title'] = 'Edit Section';
			$vars = $this->db->get_where('training_evaluation_template_section', array('template_section_id' => $section_id))->row_array();
		}else{
			$data['title'] = 'Add Section';
		}
		
		$this->load->vars( $vars );

		$this->load->helper('form');
		$data['title'] = 'Add/Edit Section';
		$data['content'] = $this->load->blade('edit.section_form')->with( $this->load->get_cached_vars() );

		$this->response->section_form = $this->load->view('templates/modal', $data, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();	
	}
}