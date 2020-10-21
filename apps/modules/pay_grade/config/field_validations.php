<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_job_pay_level.status_id'][] = array(
	'field'   => 'users_job_pay_level[status_id]',
	'label'   => 'Active',
	'rules'   => 'V'
);
$config['field_validations']['users_job_pay_level.pay_level_code'][] = array(
	'field'   => 'users_job_pay_level[pay_level_code]',
	'label'   => 'Pay Grade Code',
	'rules'   => 'required'
);
$config['field_validations']['users_job_pay_level.pay_level'][] = array(
	'field'   => 'users_job_pay_level[pay_level]',
	'label'   => 'Pay Grade',
	'rules'   => 'required'
);
