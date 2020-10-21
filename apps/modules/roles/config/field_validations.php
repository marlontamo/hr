<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['roles.role'][] = array(
	'field'   => 'roles[role]',
	'label'   => 'Role Name',
	'rules'   => 'required'
);
