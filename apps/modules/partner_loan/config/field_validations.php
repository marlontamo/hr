<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_partners_loan.user_id'][] = array(
	'field'   => 'payroll_partners_loan[user_id]',
	'label'   => 'Employee Name',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners_loan.loan_id'][] = array(
	'field'   => 'payroll_partners_loan[loan_id]',
	'label'   => 'Loan Type',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners_loan.loan_status_id'][] = array(
	'field'   => 'payroll_partners_loan[loan_status_id]',
	'label'   => 'Loan Status',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners_loan.entry_date'][] = array(
	'field'   => 'payroll_partners_loan[entry_date]',
	'label'   => 'Entry Date',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners_loan.no_payments'][] = array(
	'field'   => 'payroll_partners_loan[no_payments]',
	'label'   => 'No. of payments',
	'rules'   => 'required|integer'
);
$config['field_validations']['payroll_partners_loan.loan_principal'][] = array(
	'field'   => 'payroll_partners_loan[loan_principal]',
	'label'   => 'Loan Principal',
	'rules'   => 'numeric'
);
$config['field_validations']['payroll_partners_loan.amount'][] = array(
	'field'   => 'payroll_partners_loan[amount]',
	'label'   => 'Amount',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_partners_loan.interest'][] = array(
	'field'   => 'payroll_partners_loan[interest]',
	'label'   => 'Interest',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_partners_loan.beginning_balance'][] = array(
	'field'   => 'payroll_partners_loan[beginning_balance]',
	'label'   => 'Beginning Balance',
	'rules'   => 'numeric'
);
$config['field_validations']['payroll_partners_loan.start_date'][] = array(
	'field'   => 'payroll_partners_loan[start_date]',
	'label'   => 'Start Date',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners_loan.no_payments_remaining'][] = array(
	'field'   => 'payroll_partners_loan[no_payments_remaining]',
	'label'   => 'Payments Remaining',
	'rules'   => 'required|integer'
);
$config['field_validations']['payroll_partners_loan.running_balance'][] = array(
	'field'   => 'payroll_partners_loan[running_balance]',
	'label'   => 'Running Balance',
	'rules'   => 'numeric'
);
$config['field_validations']['payroll_partners_loan.system_amortization'][] = array(
	'field'   => 'payroll_partners_loan[system_amortization]',
	'label'   => 'System Amortization',
	'rules'   => 'numeric'
);
$config['field_validations']['payroll_partners_loan.system_interest'][] = array(
	'field'   => 'payroll_partners_loan[system_interest]',
	'label'   => 'System Interest',
	'rules'   => 'numeric'
);
$config['field_validations']['payroll_partners_loan.user_amortization'][] = array(
	'field'   => 'payroll_partners_loan[user_amortization]',
	'label'   => 'User Amortization',
	'rules'   => 'numeric'
);
$config['field_validations']['payroll_partners_loan.user_interest'][] = array(
	'field'   => 'payroll_partners_loan[user_interest]',
	'label'   => 'User Interest',
	'rules'   => 'numeric'
);
$config['field_validations']['payroll_partners_loan.total_amount_paid'][] = array(
	'field'   => 'payroll_partners_loan[total_amount_paid]',
	'label'   => 'Total Amount Paid',
	'rules'   => 'numeric'
);
$config['field_validations']['payroll_partners_loan.no_payments_paid'][] = array(
	'field'   => 'payroll_partners_loan[no_payments_paid]',
	'label'   => 'Total No. of Payments',
	'rules'   => 'numeric'
);
$config['field_validations']['payroll_partners_loan.total_arrears'][] = array(
	'field'   => 'payroll_partners_loan[total_arrears]',
	'label'   => 'Total Arrears',
	'rules'   => 'numeric'
);
