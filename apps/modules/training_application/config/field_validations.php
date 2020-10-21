<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['training_application.date_to'][] = array(
	'field'   => 'training_application[date_to]',
	'label'   => 'To',
	'rules'   => 'required'
);
$config['field_validations']['training_application.date_from'][] = array(
	'field'   => 'training_application[date_from]',
	'label'   => 'From',
	'rules'   => 'required'
);
$config['field_validations']['training_application.venue'][] = array(
	'field'   => 'training_application[venue]',
	'label'   => 'Venue',
	'rules'   => 'required'
);
$config['field_validations']['training_application.source_id'][] = array(
	'field'   => 'training_application[source_id]',
	'label'   => 'Provider',
	'rules'   => 'required'
);
$config['field_validations']['training_application.competency_id'][] = array(
	'field'   => 'training_application[competency_id]',
	'label'   => 'Competency',
	'rules'   => 'required'
);
$config['field_validations']['training_application.type_id'][] = array(
	'field'   => 'training_application[type_id]',
	'label'   => 'Type',
	'rules'   => 'required'
);
