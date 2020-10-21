<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Training Calendar',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
				'training_calendar.course_id',
				'training_calendar.calendar_type_id',
				'training_calendar.training_calendar_id',
				'training_calendar.training_category_id',
				'training_calendar.training_capacity',
				'training_calendar.min_training_capacity',
				'training_calendar.venue',
				'training_calendar.topic',
				'training_calendar.tba',
				'training_calendar.equipment',
				'training_calendar.registration_date',
				'training_calendar.cost_per_pax',
				'training_calendar.last_registration_date',
				'training_category.feedback_category_id',
				'training_calendar.publish_date',
				'training_calendar.training_revalida_master_id',
				'training_calendar.with_certification',
				'training_calendar.revalida_date',
				'training_calendar.planned'
		)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Training Session',
	'description' => '',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(	)
);
$config['fieldgroups'][3] = array(
	'fg_id' => 3,
	'label' => 'Training Cost',
	'description' => '',
	'display_id' => 3,
	'sequence' => 3,
	'active' => 1,
	'fields' => array(	)
);
$config['fieldgroups'][4] = array(
	'fg_id' => 4,
	'label' => 'Training Participants',
	'description' => '',
	'display_id' => 3,
	'sequence' => 4,
	'active' => 1,
	'fields' => array(	)
);
