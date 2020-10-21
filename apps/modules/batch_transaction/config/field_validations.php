<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_entry_batch.unit_rate_main'][] = array(
	'field'   => 'payroll_entry_batch[unit_rate_main]',
	'label'   => 'Unit Rate',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_entry_batch.document_no'][] = array(
	'field'   => 'payroll_entry_batch[document_no]',
	'label'   => 'Document No.',
	'rules'   => 'required'
);
$config['field_validations']['payroll_entry_batch.transaction_id'][] = array(
	'field'   => 'payroll_entry_batch[transaction_id]',
	'label'   => 'Transaction',
	'rules'   => 'required'
);
$config['field_validations']['payroll_entry_batch.payroll_date'][] = array(
	'field'   => 'payroll_entry_batch[payroll_date]',
	'label'   => 'Payroll Date',
	'rules'   => 'required'
);
