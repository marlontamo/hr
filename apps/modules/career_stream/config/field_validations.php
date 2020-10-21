<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_job_class.status_id'][] = array(
	'field'   => 'users_job_class[status_id]',
	'label'   => 'Active',
	'rules'   => 'V'
);
$config['field_validations']['users_job_class.job_class_code'][] = array(
	'field'   => 'users_job_class[job_class_code]',
	'label'   => 'Job Class Code',
	'rules'   => 'required'
);
$config['field_validations']['users_job_class.job_class'][] = array(
	'field'   => 'users_job_class[job_class]',
	'label'   => 'Job Class',
	'rules'   => 'required'
);
