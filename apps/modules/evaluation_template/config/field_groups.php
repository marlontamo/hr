<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Template Evaluation',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'training_evaluation_template.title',
		'training_evaluation_template.applicable_for',
		'training_evaluation_template.description'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Template Sections',
	'description' => '',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(	)
);
