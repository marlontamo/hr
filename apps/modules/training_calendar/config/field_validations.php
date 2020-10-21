<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['training_calendar.planned'][] = array(
	'field'   => 'training_calendar[planned]',
	'label'   => 'Planned',
	'rules'   => 'required'
);
$config['field_validations']['training_calendar.with_certification'][] = array(
	'field'   => 'training_calendar[with_certification]',
	'label'   => 'Certification',
	'rules'   => 'required'
);
$config['field_validations']['training_calendar.training_revalida_master_id'][] = array(
	'field'   => 'training_calendar[training_revalida_master_id]',
	'label'   => 'Level 2 and 3 Evaluation',
	'rules'   => 'required'
);
$config['field_validations']['training_calendar.feedback_category_id'][] = array(
	'field'   => 'training_calendar[feedback_category_id]',
	'label'   => 'Evaluation Form',
	'rules'   => 'required'
);
$config['field_validations']['training_calendar.topic'][] = array(
	'field'   => 'training_calendar[topic]',
	'label'   => 'Training Course Description',
	'rules'   => 'required'
);
$config['field_validations']['training_calendar.tba'][] = array(
	'field'   => 'training_calendar[tba]',
	'label'   => 'To Be Announce',
	'rules'   => 'required'
);
$config['field_validations']['training_calendar.training_capacity'][] = array(
	'field'   => 'training_calendar[training_capacity]',
	'label'   => 'Minimum Trainee Capacity',
	'rules'   => 'required'
);
$config['field_validations']['training_calendar.min_training_capacity'][] = array(
	'field'   => 'training_calendar[min_training_capacity]',
	'label'   => 'Maximum Trainee Capacity',
	'rules'   => 'required'
);
$config['field_validations']['training_calendar.calendar_type_id'][] = array(
	'field'   => 'training_calendar[calendar_type_id]',
	'label'   => 'Training Type',
	'rules'   => 'required'
);
$config['field_validations']['training_calendar.course_id'][] = array(
	'field'   => 'training_calendar[course_id]',
	'label'   => 'Training Course',
	'rules'   => 'required'
);
