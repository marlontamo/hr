<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_loan.principal_transid'][] = array(
	'field'   => 'payroll_loan[principal_transid]',
	'label'   => 'Principal Transaction',
	'rules'   => 'required'
);
$config['field_validations']['payroll_loan.loan_code'][] = array(
	'field'   => 'payroll_loan[loan_code]',
	'label'   => 'Loan Code',
	'rules'   => 'requires'
);
$config['field_validations']['payroll_loan.loan'][] = array(
	'field'   => 'payroll_loan[loan]',
	'label'   => 'Loan Name',
	'rules'   => 'requires'
);
$config['field_validations']['payroll_loan.loan_type_id'][] = array(
	'field'   => 'payroll_loan[loan_type_id]',
	'label'   => 'Loan Type',
	'rules'   => 'required'
);
$config['field_validations']['payroll_loan.loan_mode_id'][] = array(
	'field'   => 'payroll_loan[loan_mode_id]',
	'label'   => 'Loan Mode',
	'rules'   => 'required'
);
