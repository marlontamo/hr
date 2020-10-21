<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['partners_safe_manhour.status_id'][] = array(
	'field'   => 'partners_safe_manhour[status_id]',
	'label'   => 'Status ',
	'rules'   => 'required'
);
$config['field_validations']['partners_safe_manhour.date_return_to_work'][] = array(
	'field'   => 'partners_safe_manhour[date_return_to_work]',
	'label'   => 'Date of Return to Work',
	'rules'   => 'required'
);
$config['field_validations']['partners_safe_manhour.date_incident'][] = array(
	'field'   => 'partners_safe_manhour[date_incident]',
	'label'   => 'Date of Incident',
	'rules'   => 'required'
);
$config['field_validations']['partners_safe_manhour.total_manhour'][] = array(
	'field'   => 'partners_safe_manhour[total_manhour]',
	'label'   => 'Total Manhour',
	'rules'   => 'required'
);
$config['field_validations']['partners_safe_manhour.health_provider'][] = array(
	'field'   => 'partners_safe_manhour[health_provider]',
	'label'   => 'Health Provider',
	'rules'   => 'required'
);
$config['field_validations']['partners_safe_manhour.nature_id'][] = array(
	'field'   => 'partners_safe_manhour[nature_id]',
	'label'   => 'Nature ',
	'rules'   => 'required'
);
$config['field_validations']['partners_safe_manhour.partner_id'][] = array(
	'field'   => 'partners_safe_manhour[partner_id]',
	'label'   => 'Partner',
	'rules'   => 'required'
);
