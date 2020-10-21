<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_department.department'][] = array(
	'field'   => 'users_department[department]',
	'label'   => 'Department',
	'rules'   => 'required'
);
$config['field_validations']['users_department.department_code'][] = array(
	'field'   => 'users_department[department_code]',
	'label'   => 'Department Code',
	'rules'   => 'required'
);
$config['field_validations']['users_department.division_id'][] = array(
	'field'   => 'users_department[division_id]',
	'label'   => 'Division',
	'rules'   => 'V'
);
$config['field_validations']['users_department.immediate_id'][] = array(
	'field'   => 'users_department[immediate_id]',
	'label'   => 'Immediate Head',
	'rules'   => 'V'
);
$config['field_validations']['users_department.status_id'][] = array(
	'field'   => 'users_department[status_id]',
	'label'   => 'Active',
	'rules'   => 'V'
);
