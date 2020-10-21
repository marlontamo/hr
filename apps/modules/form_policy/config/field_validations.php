<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['time_form_class_policy.class_value'][] = array(
	'field'   => 'time_form_class_policy[class_value]',
	'label'   => 'Value',
	'rules'   => 'required'
);
$config['field_validations']['time_form_class_policy.class_id'][] = array(
	'field'   => 'time_form_class_policy[class_id]',
	'label'   => 'Class',
	'rules'   => 'required'
);
