<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Competency Level',
	'description' => 'Competency Level',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'performance_competency_level.competency_category_id',
		'performance_competency_level.competency_values_id',
		'performance_competency_level.competency_libraries_id',
		'performance_competency_level.competency_level',
		'performance_competency_level.description'
	)
);
