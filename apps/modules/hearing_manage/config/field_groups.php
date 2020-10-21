<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Incident Report',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'partners_incident.involved_partners',
		'partners_incident.offense_id',
		'partners_incident.complainants',
		'partners_incident.date_time_of_offense',
		'partners_incident.attachments'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Details of Offense',
	'description' => '',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(
		'partners_incident.witnesses',
		'partners_incident.location',
		'partners_incident.violation_details',
		'partners_incident.damages',
		'partners_incident.status',
		'partners_incident.incident_status_id',
		'partners_incident_nte.nte_status_id',
		'partners_incident_nte.explanation',
		'partners_incident_nte.attachments',
		'partners_incident.hearing_partner',
		'partners_incident.hearing_immediate',
		'partners_incident.hearing_witnesses',
		'partners_incident.hearing_others'			
	)
);
