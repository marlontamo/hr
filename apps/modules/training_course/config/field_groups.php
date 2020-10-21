<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Training Course',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'training_course.course',
		'training_course.category_id',
		'training_course.type_id',
		'training_course.provider_id',
		'training_course.facilitator',
		'training_course.planned',
		'training_course.position_id'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Bond Setup',
	'description' => '',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(
		'training_course.with_bond',
		'training_course.cost',
		'training_course.length_of_service',
		'training_course.remarks'
	)
);
