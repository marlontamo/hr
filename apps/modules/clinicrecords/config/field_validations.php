<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['partners_clinic_records.medication_qty'][] = array(
	'field'   => 'partners_clinic_records[medication_qty]',
	'label'   => 'Medication Quantity ',
	'rules'   => 'required'
);
$config['field_validations']['partners_clinic_records.medication'][] = array(
	'field'   => 'partners_clinic_records[medication]',
	'label'   => 'Medication ',
	'rules'   => 'required'
);
$config['field_validations']['partners_clinic_records.partner_id'][] = array(
	'field'   => 'partners_clinic_records[partner_id]',
	'label'   => 'Partner',
	'rules'   => 'required'
);
