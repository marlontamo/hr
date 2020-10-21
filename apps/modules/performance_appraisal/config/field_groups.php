<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Appraisal',
	'description' => 'Appraisal',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'performance_appraisal.year',
		'performance_appraisal.date_from',
		'performance_appraisal.date_to',
		'performance_appraisal.performance_type_id',
		'performance_appraisal.template_id',
		'performance_appraisal.status_id',
		'performance_appraisal.notes',
		'performance_appraisal.filter_by',
		'performance_appraisal.filter_id',
		'performance_appraisal_applicable.user_id',
		'performance_appraisal.employment_status_id',
		'performance_appraisal.planning_id'
	)
);
