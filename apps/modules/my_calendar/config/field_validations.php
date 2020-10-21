<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['time_forms.date_from'][] = array(
	'field'   => 'time_forms[date_from]',
	'label'   => 'From',
	'rules'   => 'required'
);
$config['field_validations']['time_forms.date_to'][] = array(
	'field'   => 'time_forms[date_to]',
	'label'   => 'To',
	'rules'   => 'required'
);
$config['field_validations']['time_forms.reason'][] = array(
	'field'   => 'time_forms[reason]',
	'label'   => 'Reason',
	'rules'   => 'required'
);
$config['field_validations']['time_forms.deleted'][] = array(
	'field'   => 'time_forms[deleted]',
	'label'   => 'File Upload',
	'rules'   => 'V'
);
