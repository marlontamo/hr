<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Planning',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'performance_planning.year',
		'performance_planning.date_from',
		'performance_planning.date_to',
		'performance_planning.performance_type_id',
		'performance_planning.template_id',
		'performance_planning.status_id',
		'performance_planning.notes',
		'performance_planning.filter_by',
		'performance_planning.filter_id',
		'performance_planning_applicable.user_id',
		'performance_planning_applicable.employment_status_id'
	)
);
