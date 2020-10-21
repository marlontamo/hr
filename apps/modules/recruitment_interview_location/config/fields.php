<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][2]['recruitment_interview_location.status_id'] = array(
	'f_id' => 6,
	'fg_id' => 2,
	'label' => 'Active',
	'description' => '',
	'table' => 'recruitment_interview_location',
	'column' => 'status_id',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['recruitment_interview_location.interview_location_code'] = array(
	'f_id' => 5,
	'fg_id' => 2,
	'label' => 'Interview Location Code',
	'description' => '',
	'table' => 'recruitment_interview_location',
	'column' => 'interview_location_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['recruitment_interview_location.interview_location'] = array(
	'f_id' => 4,
	'fg_id' => 2,
	'label' => 'Interview Location',
	'description' => '',
	'table' => 'recruitment_interview_location',
	'column' => 'interview_location',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
