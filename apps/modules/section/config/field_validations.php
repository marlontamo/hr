<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_section.status_id'][] = array(
	'field'   => 'users_section[status_id]',
	'label'   => 'Active',
	'rules'   => 'V'
);
$config['field_validations']['users_section.section'][] = array(
	'field'   => 'users_section[section]',
	'label'   => 'Section',
	'rules'   => 'required'
);
$config['field_validations']['users_section.section_code'][] = array(
	'field'   => 'users_section[section_code]',
	'label'   => 'Section Code',
	'rules'   => 'required'
);
