<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_specialization.status_id'][] = array(
	'field'   => 'users_specialization[status_id]',
	'label'   => 'Action',
	'rules'   => 'V'
);
$config['field_validations']['users_specialization.specialization_code'][] = array(
	'field'   => 'users_specialization[specialization_code]',
	'label'   => 'Specialization Code',
	'rules'   => 'V'
);
$config['field_validations']['users_specialization.specialization'][] = array(
	'field'   => 'users_specialization[specialization]',
	'label'   => 'Specialization',
	'rules'   => 'V'
);
