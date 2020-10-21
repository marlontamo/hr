<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_position.position'][] = array(
	'field'   => 'users_position[position]',
	'label'   => 'Position',
	'rules'   => 'required'
);
$config['field_validations']['users_position.position_code'][] = array(
	'field'   => 'users_position[position_code]',
	'label'   => 'Position Code',
	'rules'   => 'required'
);
$config['field_validations']['users_position.employee_type_id'][] = array(
	'field'   => 'users_position[employee_type_id]',
	'label'   => 'Employee Type',
	'rules'   => 'required'
);
$config['field_validations']['users_position.immediate_id'][] = array(
	'field'   => 'users_position[immediate_id]',
	'label'   => 'Immediate Head',
	'rules'   => 'V'
);
$config['field_validations']['users_position.immediate_position'][] = array(
	'field'   => 'users_position[immediate_position]',
	'label'   => 'Immediate Position',
	'rules'   => 'V'
);
$config['field_validations']['users_position.status_id'][] = array(
	'field'   => 'users_position[status_id]',
	'label'   => 'Active',
	'rules'   => 'V'
);
