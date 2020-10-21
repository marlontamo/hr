<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Loan Set Up',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'payroll_loan.loan_code',
		'payroll_loan.loan',
		'payroll_loan.loan_type_id',
		'payroll_loan.loan_mode_id',
		'payroll_loan.principal_transid',
		'payroll_loan.amortization_transid',
		'payroll_loan.amount_limit'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Interest Set Up',
	'description' => '',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(
		'payroll_loan.interest_transid',
		'payroll_loan.interest_type_id',
		'payroll_loan.debit',
		'payroll_loan.credit',
		'payroll_loan.interest'
	)
);
