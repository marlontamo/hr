<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Training Bond Schedule',
	'description' => 'Training Bond Schedule',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'training_bond.cost_from',
		'training_bond.cost_to',
		'training_bond.rls_months',
		'training_bond.rls_days'
	)
);
