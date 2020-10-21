<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'General Information',
	'description' => 'General Information',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'users_profile.lastname',
		'users_profile.firstname',
		'users_profile.middlename',
		'users_profile.maidenname',
		'users_profile.nickname'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Company Information',
	'description' => 'Company Information',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(
		'users_profile.company',
		'users_profile.location_id',
		'users_profile.position_id',
		'users.role_id',
		'partners.id_number',
		'partners.biometric',
		'partners.shift_id'
	)
);
$config['fieldgroups'][3] = array(
	'fg_id' => 3,
	'label' => 'Employment Information',
	'description' => 'Employment Information',
	'display_id' => 3,
	'sequence' => 3,
	'active' => 1,
	'fields' => array(
		'partners.status_id',
		'partners.employment_type_id',
		'partners.effectivity_date'
	)
);
$config['fieldgroups'][4] = array(
	'fg_id' => 4,
	'label' => 'Personal Contact',
	'description' => 'Personal Contact',
	'display_id' => 3,
	'sequence' => 4,
	'active' => 1,
	'fields' => array(
		'users.email'
	)
);
$config['fieldgroups'][5] = array(
	'fg_id' => 5,
	'label' => 'Work Assignment',
	'description' => 'Work Assignment',
	'display_id' => 3,
	'sequence' => 5,
	'active' => 1,
	'fields' => array(
		'users_department.immediate_id',
		'users_profile.division_id',
		'users_profile.group_id',
		'users_profile.department_id'
	)
);
$config['fieldgroups'][7] = array(
	'fg_id' => 7,
	'label' => 'Emergency Contact',
	'description' => 'Emergency Contact',
	'display_id' => 3,
	'sequence' => 6,
	'active' => 1,
	'fields' => array(	)
);
$config['fieldgroups'][8] = array(
	'fg_id' => 8,
	'label' => 'Personal Information',
	'description' => 'Personal Information',
	'display_id' => 3,
	'sequence' => 7,
	'active' => 1,
	'fields' => array(
		'users_profile.birth_date'
	)
);
$config['fieldgroups'][9] = array(
	'fg_id' => 9,
	'label' => 'Other Information',
	'description' => 'Other Information',
	'display_id' => 3,
	'sequence' => 8,
	'active' => 1,
	'fields' => array(	)
);
