<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ytd extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('ytd_model', 'mod');
		parent::__construct();
	}

	public function index()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

        $this->load->helper('form');
        $this->load->helper('file');		
		echo $this->load->blade('pages.dashboard')->with( $this->load->get_cached_vars() );
	}

	public function get_ytd()
	{
		$this->_ajax_only();
		$year = $this->input->post('pay_year');
		$user_id = $this->input->post('user_id');

		$count_ytd = 0;
		if( (!empty($year)) && (!empty($user_id)) ){
			$qry_ytd = "SELECT ptc.transaction_class, pcs.summary_code,
						ROUND(AES_DECRYPT(pcs.`ytd`,`encryption_key`()),2) as ytd,
						ROUND(AES_DECRYPT(pcs.`january`,`encryption_key`()),2) as january,
						ROUND(AES_DECRYPT(pcs.`february`,`encryption_key`()),2) as february,
						ROUND(AES_DECRYPT(pcs.`march`,`encryption_key`()),2) as march,
						ROUND(AES_DECRYPT(pcs.`april`,`encryption_key`()),2) as april,
						ROUND(AES_DECRYPT(pcs.`may`,`encryption_key`()),2) as may,
						ROUND(AES_DECRYPT(pcs.`june`,`encryption_key`()),2) as june,
						ROUND(AES_DECRYPT(pcs.`july`,`encryption_key`()),2) as july,
						ROUND(AES_DECRYPT(pcs.`august`,`encryption_key`()),2) as august,
						ROUND(AES_DECRYPT(pcs.`september`,`encryption_key`()),2) as september,
						ROUND(AES_DECRYPT(pcs.`october`,`encryption_key`()),2) as october,
						ROUND(AES_DECRYPT(pcs.`november`,`encryption_key`()),2) as november,
						ROUND(AES_DECRYPT(pcs.`december`,`encryption_key`()),2) as december
						FROM {$this->db->dbprefix}payroll_closed_summary pcs
						LEFT JOIN {$this->db->dbprefix}payroll_transaction_class ptc
							ON pcs.summary_code = ptc.transaction_class_code
						WHERE `year` = {$year} AND user_id = {$user_id}";
			$sql_ytd = $this->db->query($qry_ytd);
			$count_ytd = $sql_ytd->num_rows();
			if( $count_ytd > 0 ){
				$data['ytd_record'] = $sql_ytd->result_array();
				$this->response->ytd_record = $this->load->view('edit/ytd_record', $data, true);
			}
		}
		$this->response->records = $count_ytd;
		$this->_ajax_return();
	}
}