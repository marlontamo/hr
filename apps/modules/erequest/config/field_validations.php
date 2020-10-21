<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['resources_request.reason'][] = array(
	'field'   => 'resources_request[reason]',
	'label'   => 'Reason',
	'rules'   => 'required'
);
$config['field_validations']['resources_request.date_needed'][] = array(
	'field'   => 'resources_request[date_needed]',
	'label'   => 'Date Needed',
	'rules'   => 'required'
);
$config['field_validations']['resources_request.request'][] = array(
	'field'   => 'resources_request[request]',
	'label'   => 'Request Item',
	'rules'   => 'required'
);
