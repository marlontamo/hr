<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_entry_recurring.transaction_method_id'][] = array(
	'field'   => 'payroll_entry_recurring[transaction_method_id]',
	'label'   => 'Method',
	'rules'   => 'required'
);
$config['field_validations']['payroll_entry_recurring.document_no'][] = array(
	'field'   => 'payroll_entry_recurring[document_no]',
	'label'   => 'Document No.',
	'rules'   => 'required'
);
$config['field_validations']['payroll_entry_recurring.transaction_id'][] = array(
	'field'   => 'payroll_entry_recurring[transaction_id]',
	'label'   => 'Transaction',
	'rules'   => 'required'
);
$config['field_validations']['payroll_entry_recurring.date_from'][] = array(
	'field'   => 'payroll_entry_recurring[date_from]',
	'label'   => 'Date From - To from',
	'rules'   => 'required'
);
$config['field_validations']['payroll_entry_recurring.date_to'][] = array(
	'field'   => 'payroll_entry_recurring[date_to]',
	'label'   => 'Date From - To to',
	'rules'   => 'required'
);
$config['field_validations']['payroll_entry_recurring.account_id'][] = array(
	'field'   => 'payroll_entry_recurring[account_id]',
	'label'   => 'Account Code',
	'rules'   => 'V'
);
$config['field_validations']['payroll_entry_recurring.amount'][] = array(
	'field'   => 'payroll_entry_recurring[amount]',
	'label'   => 'Rate',
	'rules'   => 'required|numeric'
);
