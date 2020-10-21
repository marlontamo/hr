<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['payroll_leave_conversion_period.status'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Status',
	'description' => '',
	'table' => 'payroll_leave_conversion_period',
	'column' => 'status',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '2',
		'table' => 'select period_status_id, period_status
from {$db->dbprefix}payroll_period_status
where period_status_id != 3',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'period_status',
		'value' => 'period_status_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_leave_conversion_period.apply_to_id'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Apply To',
	'description' => '',
	'table' => 'payroll_leave_conversion_period',
	'column' => 'apply_to_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'payroll_leave_conversion_period_apply_to',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'apply_to',
		'value' => 'apply_to_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_leave_conversion_period.year'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Year',
	'description' => '',
	'table' => 'payroll_leave_conversion_period',
	'column' => 'year',
	'uitype_id' => 18,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_leave_conversion_period.payroll_date'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Payroll Date',
	'description' => '',
	'table' => 'payroll_leave_conversion_period',
	'column' => 'payroll_date',
	'uitype_id' => 6,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_leave_conversion_period.remarks'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Remarks',
	'description' => '',
	'table' => 'payroll_leave_conversion_remarks',
	'column' => 'remarks',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);

$config['fields'][1]['payroll_leave_conversion_period.form_id'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Leave',
	'description' => '',
	'table' => 'payroll_leave_conversion_period',
	'column' => 'form_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'time_form',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'form',
		'value' => 'form_id',
		'textual_value_column' => ''
	)
);

$config['fields'][1]['payroll_leave_conversion_period.nontax_leave_id'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Non-Taxable',
	'description' => '',
	'table' => 'payroll_leave_conversion_period',
	'column' => 'nontax_leave_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'payroll_transaction',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'transaction_label',
		'value' => 'transaction_id',
		'textual_value_column' => ''
	)
);

$config['fields'][1]['payroll_leave_conversion_period.taxable_leave_id'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Taxable',
	'description' => '',
	'table' => 'payroll_leave_conversion_period',
	'column' => 'taxable_leave_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'payroll_transaction',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'transaction_label',
		'value' => 'transaction_id',
		'textual_value_column' => ''
	)
);
