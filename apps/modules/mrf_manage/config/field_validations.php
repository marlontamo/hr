<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['recruitment_request.user_id'][] = array(
	'field'   => 'recruitment_request[user_id]',
	'label'   => 'Requested By',
	'rules'   => 'required'
);
$config['field_validations']['recruitment_request.created_on'][] = array(
	'field'   => 'recruitment_request[created_on]',
	'label'   => 'Requested on',
	'rules'   => 'required'
);
$config['field_validations']['recruitment_request.date_needed'][] = array(
	'field'   => 'recruitment_request[date_needed]',
	'label'   => 'Date Needed',
	'rules'   => 'required'
);
$config['field_validations']['recruitment_request.department_id'][] = array(
	'field'   => 'recruitment_request[department_id]',
	'label'   => 'Department',
	'rules'   => 'required'
);
$config['field_validations']['recruitment_request.company_id'][] = array(
	'field'   => 'recruitment_request[company_id]',
	'label'   => 'Company',
	'rules'   => 'required'
);
$config['field_validations']['recruitment_request.position_id'][] = array(
	'field'   => 'recruitment_request[position_id]',
	'label'   => 'Position',
	'rules'   => 'required'
);
