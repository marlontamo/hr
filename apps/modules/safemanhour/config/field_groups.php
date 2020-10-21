<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => ' Safe Manhour',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'partners_safe_manhour.partner_id',
		'partners_safe_manhour.nature_id',
		'partners_safe_manhour.health_provider',
		'partners_safe_manhour.total_manhour',
		'partners_safe_manhour.date_incident',
		'partners_safe_manhour.date_return_to_work',
		'partners_safe_manhour.status_id',
		'partners_safe_manhour.medication',
		'partners_safe_manhour.medication_qty',
		'partners_safe_manhour.details',
		'partners_safe_manhour.attachment'
	)
);
