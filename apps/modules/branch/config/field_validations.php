<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_branch.status_id'][] = array(
	'field'   => 'users_branch[status_id]',
	'label'   => 'Active',
	'rules'   => 'V'
);
$config['field_validations']['users_branch.branch_code'][] = array(
	'field'   => 'users_branch[branch_code]',
	'label'   => 'Branch Code',
	'rules'   => 'V'
);
$config['field_validations']['users_branch.branch'][] = array(
	'field'   => 'users_branch[branch]',
	'label'   => 'Branch',
	'rules'   => 'V'
);
