<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][2]['time_form_balance_setup_policy.max_credit'] = array(
	'f_id' => 4,
	'fg_id' => 2,
	'label' => 'Maximum',
	'description' => '',
	'table' => 'time_form_balance_setup_policy',
	'column' => 'max_credit',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['time_form_balance_setup_policy.starting_credit'] = array(
	'f_id' => 3,
	'fg_id' => 2,
	'label' => 'Starting',
	'description' => '',
	'table' => 'time_form_balance_setup_policy',
	'column' => 'starting_credit',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['time_form_balance_setup_policy.form_id'] = array(
	'f_id' => 2,
	'fg_id' => 2,
	'label' => 'Leave Type',
	'description' => '',
	'table' => 'time_form_balance_setup_policy',
	'column' => 'form_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
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
$config['fields'][2]['time_form_balance_setup_policy.balance_setup_id'] = array(
	'f_id' => 1,
	'fg_id' => 2,
	'label' => 'Balance Setup',
	'description' => '',
	'table' => 'time_form_balance_setup_policy',
	'column' => 'balance_setup_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'time_form_balance_setup',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'employment_type',
		'value' => 'balance_setup_id',
		'textual_value_column' => ''
	)
);
$config['fields'][2]['time_form_balance_setup_policy.company_id'] = array(
	'f_id' => 1,
	'fg_id' => 2,
	'label' => 'Company',
	'description' => '',
	'table' => 'time_form_balance_setup_policy',
	'column' => 'company_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'users_company',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'company',
		'value' => 'company_id',
		'textual_value_column' => ''
	)
);
