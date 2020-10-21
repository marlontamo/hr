<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Training Application',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'training_application.type_id',
		'training_application.competency_id',
		'training_application.course_id',
		'training_application.source_id',
		'training_application.venue',
		'training_application.estimated_cost'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Other Details',
	'description' => 'This section contains date range, total hours and supporting documents.',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(
		'training_application.date_from',
		'training_application.date_to',
		'training_application.total_hours',
		'training_application.remarks'
	)
);
$config['fieldgroups'][3] = array(
	'fg_id' => 3,
	'label' => 'Objectives',
	'description' => 'This section contains objectives, action plan and knowledge transfer.',
	'display_id' => 3,
	'sequence' => 3,
	'active' => 1,
	'fields' => array(	)
);
