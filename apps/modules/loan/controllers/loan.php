<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Loan extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('loan_model', 'mod');
		parent::__construct();
		$this->lang->load('loans');
	}

	function save()
	{
		$this->_ajax_only();

		if( !$this->_set_record_id() )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'error'
			);
			$this->_ajax_return();	
		}
		
		if( (empty( $this->record_id ) && !$this->permission['add']) || ($this->record_id && !$this->permission['edit']) )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$this->db->trans_begin();
		$this->response = $this->mod->_save( true, false );

		if( $this->response->saved ){
			if( $this->input->post('payroll_loan') )
			{
				$payroll_loan = $this->input->post('payroll_loan');
				$loan = $payroll_loan['loan'];
				$loan_code = $payroll_loan['loan_code'];
				$loan_type_id = $payroll_loan['loan_type_id'];
				$loan_mode_id = $payroll_loan['loan_mode_id'];
				$principal_transid = $payroll_loan['principal_transid'];
				$amortization_transid = $payroll_loan['amortization_transid'];
				$amount_limit = $payroll_loan['amount_limit'];
				$interest_transid = $payroll_loan['interest_transid'];
				$interest_type_id = $payroll_loan['interest_type_id'];
				$debit = $payroll_loan['debit'];
				$credit = $payroll_loan['credit'];
				$interest = $payroll_loan['interest'];

				$this->db->delete('payroll_loan', array('loan_id' => $this->response->record_id));

				$insert = array(
						'loan_id' => $this->response->record_id,
						'loan' => $loan,
						'loan_code' => $loan_code,
						'loan_type_id' => $loan_type_id,
						'loan_mode_id' => $loan_mode_id,
						'principal_transid' => $principal_transid,
						'amortization_transid' => $amortization_transid,
						'amount_limit' => $amount_limit,
						'interest_transid' => $interest_transid,
						'interest_type_id' => $interest_type_id,
						'debit' => $debit,
						'credit' => $credit,
						'interest' => $interest
					);
				$this->db->insert('payroll_loan', $insert);
				
				$this->db->trans_commit();
			}
			else{
				$this->db->trans_commit();
			}

			$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);

		}
		else{
			$this->db->trans_rollback();
		}
		
		
		$this->_ajax_return();
	}
}