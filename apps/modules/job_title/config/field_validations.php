<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_job_title.job_title'][] = array(
	'field'   => 'users_job_title[job_title]',
	'label'   => 'Job Title',
	'rules'   => 'required'
);
$config['field_validations']['users_job_title.job_title_code'][] = array(
	'field'   => 'users_job_title[job_title_code]',
	'label'   => 'Job Title Code',
	'rules'   => 'required'
);
$config['field_validations']['users_job_title.status_id'][] = array(
	'field'   => 'users_job_title[status_id]',
	'label'   => 'Active',
	'rules'   => 'V'
);
