<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Scorecard',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'performance_setup_scorecard.scorecard',
		'performance_setup_scorecard.description',
		'performance_setup_scorecard.status_id'
	)
);
