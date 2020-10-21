<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['partners_health_records.health_type_status_id'][] = array(
	'field'   => 'partners_health_records[health_type_status_id]',
	'label'   => 'Status',
	'rules'   => 'required'
);
$config['field_validations']['partners_health_records.health_provider'][] = array(
	'field'   => 'partners_health_records[health_provider]',
	'label'   => 'Health Provider',
	'rules'   => 'required'
);
$config['field_validations']['partners_health_records.health_type_id'][] = array(
	'field'   => 'partners_health_records[health_type_id]',
	'label'   => 'Form Type',
	'rules'   => 'required'
);
$config['field_validations']['partners_health_records.partner_id'][] = array(
	'field'   => 'partners_health_records[partner_id]',
	'label'   => 'Partner',
	'rules'   => 'required'
);
