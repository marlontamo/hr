<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_assignment.status_id'][] = array(
	'field'   => 'users_assignment[status_id]',
	'label'   => 'Active',
	'rules'   => 'V'
);
$config['field_validations']['users_assignment.assignment_code'][] = array(
	'field'   => 'users_assignment[assignment_code]',
	'label'   => 'Assignment Code',
	'rules'   => 'required'
);
$config['field_validations']['users_assignment.assignment'][] = array(
	'field'   => 'users_assignment[assignment]',
	'label'   => 'Assignment',
	'rules'   => 'required'
);
