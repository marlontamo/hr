<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['performance_appraisal_applicable.user_id'][] = array(
	'field'   => 'performance_appraisal_applicable[user_id]',
	'label'   => 'Applicable For',
	'rules'   => 'required'
);
$config['field_validations']['performance_appraisal.notes'][] = array(
	'field'   => 'performance_appraisal[notes]',
	'label'   => 'Notes',
	'rules'   => 'required'
);
$config['field_validations']['performance_appraisal.template_id'][] = array(
	'field'   => 'performance_appraisal[template_id]',
	'label'   => 'Template',
	'rules'   => 'required'
);
$config['field_validations']['performance_appraisal.performance_type_id'][] = array(
	'field'   => 'performance_appraisal[performance_type_id]',
	'label'   => 'Performance Type',
	'rules'   => 'required'
);
$config['field_validations']['performance_appraisal.performance_type_id'][] = array(
	'field'   => 'performance_appraisal[performance_type_id]',
	'label'   => 'Performance Type',
	'rules'   => 'required'
);
$config['field_validations']['performance_appraisal.planning_id'][] = array(
	'field'   => 'performance_appraisal[planning_id]',
	'label'   => 'Planning',
	'rules'   => 'required'
);
$config['field_validations']['performance_appraisal.date_to'][] = array(
	'field'   => 'performance_appraisal[date_to]',
	'label'   => 'Date To',
	'rules'   => 'required'
);
$config['field_validations']['performance_appraisal.date_from'][] = array(
	'field'   => 'performance_appraisal[date_from]',
	'label'   => 'Date From',
	'rules'   => 'required'
);
$config['field_validations']['performance_appraisal.appraisal_id'][] = array(
	'field'   => 'performance_appraisal[appraisal_id]',
	'label'   => 'Year',
	'rules'   => 'required'
);
