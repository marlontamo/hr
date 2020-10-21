<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_competency_level.status_id'][] = array(
	'field'   => 'users_competency_level[status_id]',
	'label'   => 'Action',
	'rules'   => 'V'
);
$config['field_validations']['users_competency_level.competency_level_code'][] = array(
	'field'   => 'users_competency_level[competency_level_code]',
	'label'   => 'Competency Level Code',
	'rules'   => 'required'
);
$config['field_validations']['users_competency_level.competency_level'][] = array(
	'field'   => 'users_competency_level[competency_level]',
	'label'   => 'Competency Level',
	'rules'   => 'required'
);
