<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_project.project_code'][] = array(
	'field'   => 'users_project[project_code]',
	'label'   => 'Project Code',
	'rules'   => 'required'
);
$config['field_validations']['users_project.project'][] = array(
	'field'   => 'users_project[project]',
	'label'   => 'Project',
	'rules'   => 'required'
);
$config['field_validations']['users_project.status_id'][] = array(
	'field'   => 'users_project[status_id]',
	'label'   => 'Active',
	'rules'   => 'V'
);
