<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_group.group'][] = array(
	'field'   => 'users_group[group]',
	'label'   => 'Group',
	'rules'   => 'required'
);
$config['field_validations']['users_group.group_code'][] = array(
	'field'   => 'users_group[group_code]',
	'label'   => 'Group Code',
	'rules'   => 'required'
);
$config['field_validations']['users_group.position'][] = array(
	'field'   => 'users_group[position]',
	'label'   => 'Immediate Position',
	'rules'   => 'V'
);
$config['field_validations']['users_group.status_id'][] = array(
	'field'   => 'users_group[status_id]',
	'label'   => 'Active',
	'rules'   => 'V'
);
