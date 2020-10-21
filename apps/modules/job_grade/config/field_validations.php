<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_job_grade_level.status_id'][] = array(
	'field'   => 'users_job_grade_level[status_id]',
	'label'   => 'Active',
	'rules'   => 'V'
);
$config['field_validations']['users_job_grade_level.job_grade_code'][] = array(
	'field'   => 'users_job_grade_level[job_grade_code]',
	'label'   => 'Job Grade Code',
	'rules'   => 'required'
);
$config['field_validations']['users_job_grade_level.job_level'][] = array(
	'field'   => 'users_job_grade_level[job_level]',
	'label'   => 'Job Grade',
	'rules'   => 'required'
);
