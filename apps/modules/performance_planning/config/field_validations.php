<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['performance_planning_applicable.user_id'][] = array(
	'field'   => 'performance_planning_applicable[user_id]',
	'label'   => 'Applicable For',
	'rules'   => 'required'
);
$config['field_validations']['performance_planning.notes'][] = array(
	'field'   => 'performance_planning[notes]',
	'label'   => 'Notes',
	'rules'   => 'required'
);
$config['field_validations']['performance_planning.template_id'][] = array(
	'field'   => 'performance_planning[template_id]',
	'label'   => 'Template',
	'rules'   => 'required'
);
$config['field_validations']['performance_planning.performance_type_id'][] = array(
	'field'   => 'performance_planning[performance_type_id]',
	'label'   => 'Performance Type',
	'rules'   => 'required'
);
$config['field_validations']['performance_planning.date_to'][] = array(
	'field'   => 'performance_planning[date_to]',
	'label'   => 'Date To',
	'rules'   => 'required'
);
$config['field_validations']['performance_planning.date_from'][] = array(
	'field'   => 'performance_planning[date_from]',
	'label'   => 'Date From',
	'rules'   => 'required'
);
$config['field_validations']['performance_planning.year'][] = array(
	'field'   => 'performance_planning[year]',
	'label'   => 'Year',
	'rules'   => 'required'
);
