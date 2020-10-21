<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Policy Setup',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'time_form_class_policy.class_id',
		'time_form_class_policy.class_value',
		'time_form_class_policy.description',
		'time_form_class_policy.severity',
		'time_form_class_policy.company_id',
		'time_form_class_policy.division_id',
		'time_form_class_policy.department_id',
		'time_form_class_policy.group_id',
		'time_form_class_policy.employment_status_id',
		'time_form_class_policy.employment_type_id',
		'time_form_class_policy.role_id'
	)
);
