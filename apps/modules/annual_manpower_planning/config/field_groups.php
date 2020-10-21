<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Annual Manpower Planning',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'recruitment_manpower_plan.year',
		'recruitment_manpower_plan.company_id',
		'recruitment_manpower_plan.department_id',
		'recruitment_manpower_plan.departmenthead',
		'recruitment_manpower_plan.created_by',
		'recruitment_manpower_plan.attachment'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Planing Details',
	'description' => 'This section manage to add tables and configure each settings and relationship.',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(	)
);
