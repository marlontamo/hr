<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Basic Information',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'payroll_bank.bank_type',
		'payroll_bank.bank_code_numeric',
		'payroll_bank.bank_code_alpha',
		'payroll_bank.bank',
		'payroll_bank.account_name',
		'payroll_bank.account_no',
		'payroll_bank.batch_no',
		'payroll_bank.ceiling_amount',
		'payroll_bank.branch_code',
		'payroll_bank.description',
		'payroll_bank.address',
		'payroll_bank.branch_officer',
		'payroll_bank.branch_position',
		'payroll_bank.signatory_1',
		'payroll_bank.signatory_2'
	)
);
