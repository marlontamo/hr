<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sbr extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('sbr_model', 'mod');
		parent::__construct();
	}

	function _list_options_active( $record, &$rec )
	{
		if( isset($this->permission['process']) && $this->permission['process'] )
		{
			$rec['process_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
			$rec['export_url'] = 'javascript:export_sbr( '. $record['record_id'] .' )';
		}
	}

	function process_form()
	{
		$this->_ajax_only();
		// echo"<pre>";print_r($_POST);exit;
		if( !$this->permission['process'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
		
		parent::detail( '', true);
		$data['title'] = 'Processing Details';
		$data['content'] = $this->load->view('process_form', '', true);


		$this->response->process_form = $this->load->view('templates/modal', $data, true);

		$this->_ajax_return();
	}

	function quick_edit( $child_call = false )
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

		$this->_quick_edit( $child_call, false );
		$this->_ajax_return();
	}

	public function _quick_edit( $child_call, $new = false )
	{	
		if( !$new ){
			if( !$this->_set_record_id() )
			{
				echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
				die();
			}

			$this->record_id = $data['record_id'] = $_POST['record_id'];
		}
		
		if( !$child_call ){
			$this->load->helper('form');
			$this->load->helper('file');

			$this->record_id = $data['record_id'] = $_POST['record_id'];
			$this->load->vars( $data );
			
			$data['title'] = $this->mod->short_name .' - Quick Edit';
			$data['content'] = $this->load->blade('pages.quick_edit')->with( $this->load->get_cached_vars() );

			$this->response->quick_edit_form = $this->load->view('templates/modal', $data, true);

			$this->response->message[] = array(
				'message' => '',
				'type' => 'success'
			);
		}	
	}

	function get_dropdown_options()
	{
		$this->_ajax_only();
		$year_month = $this->input->post('year_month');
		$statutory_id = $this->input->post('statutory');
		$companies = $this->input->post('company_val');
		switch ($statutory_id) {
			case '1':
				$transaction_id = 49;
				break;
			case '2':
				$transaction_id = 50;
				break;
			case '3':
				$transaction_id = 52;
				break;
			case '4':
				$loan_type_id = 13;
				break;
			case '5':
				$loan_type_id = 14;
				break;
		}
		switch ($this->input->post('type')) {
			case 'employee_id':
				if(!empty($transaction_id)){
					$qry = "SELECT DISTINCT u.user_id AS value, u.full_name AS 'text'
							FROM {$this->db->dbprefix}users u
							INNER JOIN {$this->db->dbprefix}partners e ON u.user_id = e.user_id
							INNER JOIN {$this->db->dbprefix}payroll_closed_transaction pct ON u.user_id = pct.employee_id AND pct.transaction_id = $transaction_id 
							WHERE DATE_FORMAT(pct.payroll_date,'%Y%c')  = $year_month 
							ORDER BY u.full_name";
				}
				else{
					$qry = "SELECT DISTINCT u.user_id  AS value, u.full_name AS 'text'
							FROM {$this->db->dbprefix}users u
							INNER JOIN {$this->db->dbprefix}partners e ON u.user_id = e.user_id
							LEFT JOIN {$this->db->dbprefix}payroll_partners_loan el ON el.user_id = u.user_id
							LEFT JOIN {$this->db->dbprefix}payroll_loan pl ON el.loan_id = pl.loan_id
							LEFT JOIN {$this->db->dbprefix}payroll_loan_type plt ON plt.loan_type_id = pl.loan_type_id
							LEFT JOIN {$this->db->dbprefix}payroll_partners_loan_payment elp ON elp.partner_loan_id = el.partner_loan_id
							WHERE DATE_FORMAT(elp.payroll_date,'%Y%c') = $year_month AND plt.loan_type_id = $loan_type_id 
							ORDER BY u.full_name";
				}
				break;
			// case 'division_id':
			// 	if(!empty($transaction_id)){
			// 		$qry = "SELECT DISTINCT up.division_id AS value, ud.division AS 'text'
			// 				FROM {$this->db->dbprefix}users_division ud
			// 				LEFT JOIN {$this->db->dbprefix}users_profile up ON ud.division_id = up.division_id
			// 				LEFT JOIN  {$this->db->dbprefix}users u ON up.user_id = u.user_id
			// 				LEFT JOIN {$this->db->dbprefix}partners e ON u.user_id = e.user_id
			// 				LEFT JOIN {$this->db->dbprefix}payroll_partners ep ON u.user_id = ep.user_id 
			// 				LEFT JOIN {$this->db->dbprefix}payroll_closed_transaction pct ON ep.user_id = pct.employee_id AND pct.transaction_id = $transaction_id 
			// 				WHERE DATE_FORMAT(pct.payroll_date,'%Y%c')  = $year_month 
			// 				ORDER BY ud.division";
			// 	}
			// 	else{
			// 		$qry = "SELECT s.division_id AS value, s.division AS 'text'
			// 				FROM {$this->db->dbprefix}user u
			// 				INNER JOIN {$this->db->dbprefix}employee e ON u.employee_id = e.employee_id
			// 				INNER JOIN {$this->db->dbprefix}employee_payroll ep ON u.employee_id = ep.employee_id
			// 				LEFT JOIN {$this->db->dbprefix}employee_loan el ON el.employee_id = u.employee_id
			// 				LEFT JOIN {$this->db->dbprefix}payroll_loan pl ON el.loan_id = pl.loan_id
			// 				LEFT JOIN {$this->db->dbprefix}payroll_loan_type plt ON plt.loan_type_id = pl.loan_type_id
			// 				LEFT JOIN {$this->db->dbprefix}employee_loan_payment elp ON elp.partner_loan_id = el.partner_loan_id
			// 				LEFT JOIN {$this->db->dbprefix}payroll_period p ON elp.payroll_date = p.payroll_date
			// 				LEFT JOIN {$this->db->dbprefix}user_company_division s ON s.division_id = u.division_id
			// 				WHERE DATE_FORMAT(pct.payroll_date,'%Y%c') = $year_month AND plt.loan_type_id = $loan_type_id 
			// 				ORDER BY s.division";
			// 	}
			// 	break;
			case 'company_id':
				 	if(!empty($transaction_id)){
						$qry = "SELECT DISTINCT u.user_id AS value, u.full_name AS 'text'
								FROM {$this->db->dbprefix}users u
								INNER JOIN {$this->db->dbprefix}partners e ON u.user_id = e.user_id
								INNER JOIN {$this->db->dbprefix}payroll_closed_transaction pct ON u.user_id = pct.employee_id AND pct.transaction_id = $transaction_id
								-- INNER JOIN {$this->db->dbprefix}payroll_partners_contribution c ON u.employee_id = c.employee_id AND c.transaction_id = $transaction_id 
								WHERE DATE_FORMAT(pct.payroll_date,'%Y%c') = $year_month ";
						
						if(!empty($companies)) { $qry .= " AND u.company_id IN  ($companies)"; }
						
						$qry .=	" ORDER BY u.full_name";
					}
					else
					{
						$qry = "SELECT DISTINCT u.user_id  AS value, u.full_name AS 'text'
								FROM {$this->db->dbprefix}users u
								INNER JOIN {$this->db->dbprefix}partners e ON u.user_id = e.user_id
								LEFT JOIN {$this->db->dbprefix}payroll_partners_loan el ON el.user_id = u.user_id
								LEFT JOIN {$this->db->dbprefix}payroll_loan pl ON el.loan_id = pl.loan_id
								LEFT JOIN {$this->db->dbprefix}payroll_loan_type plt ON plt.loan_type_id = pl.loan_type_id
								LEFT JOIN {$this->db->dbprefix}payroll_partners_loan_payment elp ON elp.partner_loan_id = el.partner_loan_id
								WHERE DATE_FORMAT(elp.payroll_date,'%Y%c') = $year_month AND plt.loan_type_id = $loan_type_id "; 
						
						if(!empty($companies)) { $qry .= " AND u.company_id IN  ($companies)"; }
						
						$qry .=	" ORDER BY u.full_name";
					}
					
				break;
			default:
				break;
		}
		$lists = $this->db->query( $qry );
		$options = array();
		foreach( $lists->result() as $row )
		{
			$options[] = '<option value="'. $row->value .'">'.$row->text.'</option>';
		}
		$this->response->options = is_array($options) && count($options) > 0 ? implode('', $options) : $options;

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function get_company() 
	{
		$this->_ajax_only();
      	$company = $this->db->query("SELECT
	                          d.company_id AS value,
	                          d.company AS 'text'
	                        FROM {$this->db->dbprefix}partners a
	                          LEFT JOIN {$this->db->dbprefix}users b
	                            ON a.user_id = b.user_id
	                          LEFT JOIN {$this->db->dbprefix}users_profile e
	                            ON a.user_id = e.user_id
	                          LEFT JOIN {$this->db->dbprefix}payroll_partners c
	                            ON a.user_id = c.user_id 
	                          LEFT JOIN {$this->db->dbprefix}users_company d
	                            ON b.company_id = d.company_id
	                        WHERE d.deleted = 0
	                        GROUP BY d.company");
	  	if($company->num_rows() > 0 )
		{
			foreach( $company->result() as $row )
			{
				$options[] = '<option value="'. $row->value .'">'.$row->text.'</option>';
			}
			$this->response->options = implode('', $options);
	 	}
	 	$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
 		
      	$this->_ajax_return(); 
    }

    function process(){
		/* Update SBR # */
		if(!IS_AJAX){
			$this->session->set_flashdata('flashdata', 'Operation does not allow direct access.<br/>Please contact the System Administrator.');
			redirect(base_url() . $this->module_link);	
		}

		$tran_date = '';
		$post = $this->input->post();
		$sbr_no = $post['sbr_no'];
		if(!empty($post['tran_date'])){
			$tran_date = date("Y-m-d",strtotime($this->input->post('tran_date')));
		}
		
		if( !$sbr_no )
		{
			$this->response->message[] = array(
				'message' => 'Please enter SBR No.',
				'type' => 'error'
			);
			$this->_ajax_return();	
		}

		if( !$tran_date )
		{
			$this->response->message[] = array(
				'message' => 'Please select SBR Date',
				'type' => 'error'
			);
			$this->_ajax_return();	
		}

		$year_month = $post['year_month'];
		$type = $post['type'];
		$values = isset($post['values']) ? implode(',', $post['values']) : '';
		$company_val = isset($post['company_val']) ? implode(',', $post['company_val']) : '';
		$statutory_id = $post['statutory'];
		$transaction_id = '';
		$add_qry = '';
		switch ($statutory_id) {
			case '1':
				$transaction_id = 49;
				break;
			case '2':
				$transaction_id = 50;
				break;
			case '3':
				$transaction_id = 52;
				break;
			case '4':
				$loan_type_id = 1;
				break;
			case '5':
				$loan_type_id = 11;
				break;
		}
		if(!empty($values)){
			$add_qry .= " AND pct.employee_id IN ($values)";
		}
		if(!empty($company_val)){
			$add_qry .= " AND pct.company_id IN ($company_val)";
		}

		if(!empty($transaction_id) && $transaction_id > 0){
			$update_qry = "UPDATE {$this->db->dbprefix}payroll_closed_transaction pct
				-- LEFT JOIN {$this->db->dbprefix}payroll_partners_contribution c
				LEFT JOIN {$this->db->dbprefix}payroll_period p ON p.payroll_period_id = pct.period_id
				INNER JOIN {$this->db->dbprefix}users u ON u.user_id = pct.employee_id
				SET pct.sbr_no = '{$sbr_no}', pct.sbr_date = '{$tran_date}' 
					-- , c.sbr_no = '{$sbr_no}', c.sbr_date = '{$tran_date}'
				WHERE DATE_FORMAT(pct.payroll_date,'%Y%c') = {$year_month} AND pct.transaction_id = $transaction_id $add_qry";
		}else{
			$update_qry = "UPDATE {$this->db->dbprefix}payroll_partners_loan_payment elp
				INNER JOIN {$this->db->dbprefix}payroll_partners_loan el ON elp.partner_loan_id = el.partner_loan_id
				INNER JOIN {$this->db->dbprefix}users u ON el.user_id = u.user_id
				LEFT JOIN {$this->db->dbprefix}payroll_loan pl ON pl.loan_id = el.loan_id
				LEFT JOIN {$this->db->dbprefix}payroll_loan_type plt ON plt.loan_type_id = pl.loan_type_id
				SET elp.sbr_no = '{$sbr_no}', elp.sbr_date = '{$tran_date}' 
				WHERE DATE_FORMAT(elp.payroll_date,'%Y%c') = {$year_month} AND plt.loan_type_id = $loan_type_id $add_qry";
		}
		
		$this->db->query($update_qry);

		$this->response->message[] = array(
			'message' => 'Successfully Process',
			'type' => 'success'
		);

		$this->_ajax_return();	
	}
}