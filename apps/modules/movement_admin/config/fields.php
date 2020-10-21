<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][5]['partners_movement_action_moving.further_reason'] = array(
	'f_id' => 14,
	'fg_id' => 5,
	'label' => 'Further Reason',
	'description' => 'Further Reason',
	'table' => 'partners_movement_action_moving',
	'column' => 'further_reason',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][5]['partners_movement_action_moving.reason_id'] = array(
	'f_id' => 13,
	'fg_id' => 5,
	'label' => 'Reason',
	'description' => 'Reason',
	'table' => 'partners_movement_action_moving',
	'column' => 'reason_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'partners_movement_reason',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'reason',
		'value' => 'reason_id',
		'textual_value_column' => ''
	)
);
$config['fields'][5]['partners_movement_action_moving.blacklisted'] = array(
	'f_id' => 18,
	'fg_id' => 5,
	'label' => 'Blacklisted',
	'description' => 'Blacklisted',
	'table' => 'partners_movement_action_moving',
	'column' => 'blacklisted',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][5]['partners_movement_action_moving.end_date'] = array(
	'f_id' => 12,
	'fg_id' => 5,
	'label' => 'End Date',
	'description' => 'End Date',
	'table' => 'partners_movement_action_moving',
	'column' => 'end_date',
	'uitype_id' => 6,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][3]['partners_movement_action_extension.end_date'] = array(
	'f_id' => 9,
	'fg_id' => 3,
	'label' => 'End Date',
	'description' => 'End Date To',
	'table' => 'partners_movement_action_extension',
	'column' => 'end_date',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][3]['partners_movement_action_extension.no_of_months'] = array(
	'f_id' => 7,
	'fg_id' => 3,
	'label' => 'Months',
	'description' => 'Months',
	'table' => 'partners_movement_action_extension',
	'column' => 'no_of_months',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['partners_movement_action.effectivity_date'] = array(
	'f_id' => 5,
	'fg_id' => 2,
	'label' => 'Effective',
	'description' => 'Effective',
	'table' => 'partners_movement_action',
	'column' => 'effectivity_date',
	'uitype_id' => 6,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['partners_movement_action.remarks'] = array(
	'f_id' => 6,
	'fg_id' => 2,
	'label' => 'Remarks',
	'description' => 'Remarks',
	'table' => 'partners_movement_action',
	'column' => 'remarks',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['partners_movement_action.grade'] = array(
	'f_id' => 7,
	'fg_id' => 2,
	'label' => 'Grade',
	'description' => 'Grade',
	'table' => 'partners_movement_action',
	'column' => 'grade',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][6]['partners_movement_action_transfer.to_id'] = array(
	'f_id' => 17,
	'fg_id' => 6,
	'label' => 'To id',
	'description' => 'To id',
	'table' => 'partners_movement_action_transfer',
	'column' => 'to_id',
	'uitype_id' => 1,
	'display_id' => 4,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][6]['partners_movement_action_transfer.from_id'] = array(
	'f_id' => 16,
	'fg_id' => 6,
	'label' => 'From id',
	'description' => 'From id',
	'table' => 'partners_movement_action_transfer',
	'column' => 'from_id',
	'uitype_id' => 1,
	'display_id' => 4,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][6]['partners_movement_action_transfer.field_id'] = array(
	'f_id' => 15,
	'fg_id' => 6,
	'label' => 'Field id',
	'description' => 'Field id',
	'table' => 'partners_movement_action_transfer',
	'column' => 'field_id',
	'uitype_id' => 1,
	'display_id' => 4,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['partners_movement.remarks'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Remarks',
	'description' => 'Remarks',
	'table' => 'partners_movement',
	'column' => 'remarks',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['partners_movement_action.type_id'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Type',
	'description' => 'Type',
	'table' => 'partners_movement_action',
	'column' => 'type_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'partners_movement_type',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'type',
		'value' => 'type_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['partners_movement_action.type_category_id'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Type',
	'description' => 'Category',
	'table' => 'partners_movement_action',
	'column' => 'type_category_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'partners_movement_type_category',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'type_category',
		'value' => 'type_category_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['partners_movement.due_to_id'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Due To',
	'description' => 'Due To',
	'table' => 'partners_movement',
	'column' => 'due_to_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'partners_movement_cause',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'cause',
		'value' => 'cause_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['partners_movement.remarks_print_report_id'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Remarks',
	'description' => 'Remarks',
	'table' => 'partners_movement',
	'column' => 'remarks_print_report_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'partners_movement_remarks',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'remarks_print_report',
		'value' => 'remarks_print_report_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['partners_movement_action.user_id'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Partner',
	'description' => 'Partner',
	'table' => 'partners_movement_action',
	'column' => 'user_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'users',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'display_name',
		'value' => 'user_id',
		'textual_value_column' => ''
	)
);
$config['fields'][4]['partners_movement_action_compensation.to_salary'] = array(
	'f_id' => 11,
	'fg_id' => 4,
	'label' => 'New Salary',
	'description' => 'New Salary',
	'table' => 'partners_movement_action_compensation',
	'column' => 'to_salary',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][4]['partners_movement_action_compensation.current_salary'] = array(
	'f_id' => 10,
	'fg_id' => 4,
	'label' => 'Current Salary',
	'description' => 'Current Salary',
	'table' => 'partners_movement_action_compensation',
	'column' => 'current_salary',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);