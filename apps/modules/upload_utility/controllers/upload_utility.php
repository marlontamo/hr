<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Upload_utility extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('upload_utility_model', 'mod');
		parent::__construct();
	}

	public function index()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$vars['templates'] = array();
		$templates = $this->db->get_where( 'system_upload_template', array('deleted' => 0) );
		if( $templates->num_rows() > 0 )
			$vars['templates'] = $templates->result();

		$this->load->vars( $vars );

		echo $this->load->blade('pages.dashboard')->with( $this->load->get_cached_vars() );
	}

	function load_template()
	{
		$this->_ajax_only();

		if( !$this->permission['list'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.no_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		$template_id = $this->input->post('template_id');

		$this->db->limit(1);
		$this->response->template = $this->db->get_where( $this->mod->table, array('deleted' => 0,'template_id' => $template_id) )->row();

		$this->response->message[] = array(
				'message' => '',
				'type' => 'success'
			);

		$this->_ajax_return();
	}

	function upload()
	{
		$this->_ajax_only();
		
		if( !$this->permission['list'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.no_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$template_id = $this->input->post('template_id');
		$file = $this->input->post('template');

		if( !file_exists( urldecode($file) ) )
		{
			$this->response->message[] = array(
				'message' => lang('upload_utility.file_missing'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$ext = pathinfo($file, PATHINFO_EXTENSION);

		$this->db->limit(1);
		$template = $this->db->get_where( 'system_upload_template', array('deleted' => 0,'template_id' => $template_id) )->row();
		$accepted_file_types = explode(',', $template->accepted_file_types);

		if (!in_array($ext, $accepted_file_types)) {
            $this->response->message[] = array(
				'message' => lang('upload_utility.file_type_not_accepted'),
				'type' => 'warning'
			);
			$this->_ajax_return();
        }

        $csv_convert = false;
        if( in_array($ext, array('xls', 'xlsx')) )
        {
        	$csv_convert = time().'.csv';
        	$this->load->library('excel');
        	$inputFileType = PHPExcel_IOFactory::identify(urldecode($file));
        	$reader = PHPExcel_IOFactory::createReader($inputFileType);
			//$reader->setReadDataOnly(true);
			$excel = $reader->load(urldecode($file)); 
			$writer = PHPExcel_IOFactory::createWriter($excel, 'CSV');
			$writer->setDelimiter("\t");
			$writer->save($csv_convert);
        }

        $response = $this->mod->upload( urldecode($file), $template, $csv_convert );
		$this->response =  (object) array_merge((array) $this->response, (array) $response);

		$this->response->message[] = array(
			'message' => 'Upload success!',
			'type' => 'success'
		);
		$this->_ajax_return();
	}
}