<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Competency Libraries',
	'description' => 'Competency Libraries',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'performance_competency_libraries.competency_category_id',
		'performance_competency_libraries.competency_values_id',
		'performance_competency_libraries.competency_libraries',
		'performance_competency_libraries.description'
	)
);
