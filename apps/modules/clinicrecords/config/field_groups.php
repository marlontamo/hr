<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => ' Clinic Records',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'partners_clinic_records.partner_id',
		'partners_clinic_records.medication',
		'partners_clinic_records.medication_qty',
		'partners_clinic_records.complaint',
		'partners_clinic_records.diagnosis',
		'partners_clinic_records.other_med_cost',
		'partners_clinic_records.attachments',
		'partners_clinic_records.details'
	)
);
