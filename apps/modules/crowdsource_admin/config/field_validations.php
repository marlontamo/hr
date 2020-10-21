<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['performance_appraisal_contributor.contributor'][] = array(
	'field'   => 'performance_appraisal_contributor[contributor]',
	'label'   => 'Crowdsource',
	'rules'   => 'required'
);
$config['field_validations']['performance_appraisal_contributor.template_section_id'][] = array(
	'field'   => 'performance_appraisal_contributor[template_section_id]',
	'label'   => 'Template Section',
	'rules'   => 'required'
);
$config['field_validations']['performance_appraisal_contributor.user_id'][] = array(
	'field'   => 'performance_appraisal_contributor[user_id]',
	'label'   => 'Partner',
	'rules'   => 'required'
);
