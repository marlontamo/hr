<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['partners_incident.date_time_of_offense'][] = array(
	'field'   => 'partners_incident[date_time_of_offense]',
	'label'   => 'Date and Time of Offense',
	'rules'   => 'required'
);
$config['field_validations']['partners_incident.complainants'][] = array(
	'field'   => 'partners_incident[complainants]',
	'label'   => 'Complainant/s',
	'rules'   => ''
);
$config['field_validations']['partners_incident.offense_id'][] = array(
	'field'   => 'partners_incident[offense_id]',
	'label'   => 'Offense ',
	'rules'   => 'required'
);
$config['field_validations']['partners_incident.involved_partners'][] = array(
	'field'   => 'partners_incident[involved_partners]',
	'label'   => 'Involved Employee/s',
	'rules'   => ''
);
