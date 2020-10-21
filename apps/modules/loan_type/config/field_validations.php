<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_loan.loan'][] = array(
	'field'   => 'payroll_loan[loan]',
	'label'   => 'Loan Type',
	'rules'   => 'required'
);
