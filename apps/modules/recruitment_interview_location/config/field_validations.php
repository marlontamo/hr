<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['recruitment_interview_location.status_id'][] = array(
	'field'   => 'recruitment_interview_location[status_id]',
	'label'   => 'Active',
	'rules'   => 'V'
);
$config['field_validations']['recruitment_interview_location.interview_location_code'][] = array(
	'field'   => 'recruitment_interview_location[interview_location_code]',
	'label'   => 'Interview Location Code',
	'rules'   => 'V'
);
$config['field_validations']['recruitment_interview_location.interview_location'][] = array(
	'field'   => 'recruitment_interview_location[interview_location]',
	'label'   => 'Interview Location',
	'rules'   => 'V'
);
