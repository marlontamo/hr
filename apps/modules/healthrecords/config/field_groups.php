<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => ' Health Records',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'partners_health_records.partner_id',
		'partners_health_records.health_type_id',
		'partners_health_records.health_provider',
		'partners_health_records.date_of_completion',
		'partners_health_records.health_type_status_id',
		'partners_health_records.attachments'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => ' Other Information',
	'description' => 'This section contains the finding, diagnosis and recommendation.',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(
		'partners_health_records.findings',
		'partners_health_records.diagnosis',
		'partners_health_records.recommendation'
	)
);
