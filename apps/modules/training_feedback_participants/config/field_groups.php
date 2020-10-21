<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][4] = array(
	'fg_id' => 4,
	'label' => 'Participant Information',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(	)
);
$config['fieldgroups'][5] = array(
	'fg_id' => 5,
	'label' => 'Training Session Details',
	'description' => '',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(	)
);
$config['fieldgroups'][6] = array(
	'fg_id' => 6,
	'label' => 'Feedback Questionnaire',
	'description' => '',
	'display_id' => 3,
	'sequence' => 3,
	'active' => 1,
	'fields' => array(		
		'training_feedback.total_score',
		'training_feedback.average_score'	
	)
);
