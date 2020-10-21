<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][6]['users_project.project_code'] = array(
	'f_id' => 3,
	'fg_id' => 6,
	'label' => 'PRN',
	'description' => '',
	'table' => 'users_project',
	'column' => 'project_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][6]['users_project.project'] = array(
	'f_id' => 2,
	'fg_id' => 6,
	'label' => 'Project',
	'description' => '',
	'table' => 'users_project',
	'column' => 'project',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][6]['users_project.status_id'] = array(
	'f_id' => 1,
	'fg_id' => 6,
	'label' => 'Active',
	'description' => '',
	'table' => 'users_project',
	'column' => 'status_id',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
