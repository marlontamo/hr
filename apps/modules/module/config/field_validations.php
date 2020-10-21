<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['modules.short_name'][] = array(
	'field'   => 'modules[short_name]',
	'label'   => 'Module Name',
	'rules'   => 'required'
);
$config['field_validations']['modules.long_name'][] = array(
	'field'   => 'modules[long_name]',
	'label'   => 'Descriptive Name',
	'rules'   => 'required'
);
$config['field_validations']['modules.mod_code'][] = array(
	'field'   => 'modules[mod_code]',
	'label'   => 'Module Code',
	'rules'   => 'required'
);
$config['field_validations']['modules.route'][] = array(
	'field'   => 'modules[route]',
	'label'   => 'Route',
	'rules'   => 'required'
);
$config['field_validations']['modules.table'][] = array(
	'field'   => 'modules[table]',
	'label'   => 'Main Table',
	'rules'   => 'required'
);
$config['field_validations']['modules.primary_key'][] = array(
	'field'   => 'modules[primary_key]',
	'label'   => 'Primary Key',
	'rules'   => 'required'
);
$config['field_validations']['modules.list_template_header'][] = array(
	'field'   => 'modules[list_template_header]',
	'label'   => 'List Template Header',
	'rules'   => 'required'
);
$config['field_validations']['modules.list_template'][] = array(
	'field'   => 'modules[list_template]',
	'label'   => 'List Template',
	'rules'   => 'required'
);
