<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Employee Loans',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'payroll_partners_loan.user_id',
		'payroll_partners_loan.loan_id',
		'payroll_partners_loan.loan_status_id',
		'payroll_partners_loan.entry_date',
		'payroll_partners_loan.no_payments',
		'payroll_partners_loan.releasing_debit_account_id',
		'payroll_partners_loan.releasing_credit_account_id',
		'payroll_partners_loan.loan_principal',
		'payroll_partners_loan.amount',
		'payroll_partners_loan.interest',
		'payroll_partners_loan.beginning_balance',
		'payroll_partners_loan.description',
		'payroll_partners_loan.remarks'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Amortization Setup',
	'description' => '',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(
		'payroll_partners_loan.start_date',
		'payroll_partners_loan.payment_mode_id',
		'payroll_partners_loan.no_payments_remaining',
		'payroll_partners_loan.amortization_credit_account_id',
		'payroll_partners_loan.interest_credit_account_id',
		'payroll_partners_loan.running_balance',
		'payroll_partners_loan.system_amortization',
		'payroll_partners_loan.system_interest',
		'payroll_partners_loan.user_amortization',
		'payroll_partners_loan.user_interest'
	)
);
$config['fieldgroups'][3] = array(
	'fg_id' => 3,
	'label' => 'Payments',
	'description' => '',
	'display_id' => 3,
	'sequence' => 3,
	'active' => 1,
	'fields' => array(
		'payroll_partners_loan.last_payment_date',
		'payroll_partners_loan.total_amount_paid',
		'payroll_partners_loan.no_payments_paid',
		'payroll_partners_loan.total_arrears'
	)
);
