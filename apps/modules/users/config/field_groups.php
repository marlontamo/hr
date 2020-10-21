<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => ' Employee Information',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'users.login',
		'users.hash',
		'users_profile.company_id',
		'users.role_id',
		'users.active',
		'users_profile.business_level_id'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => ' Personal Information',
	'description' => '',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(
		'users_profile.firstname',
		'users_profile.lastname',
		'users_profile.middlename',
		'users_profile.nickname',
		'users_profile.photo',
		'users_profile.birth_date',
		'users_profile.suffix'
	)
);
$config['fieldgroups'][3] = array(
	'fg_id' => 3,
	'label' => ' Contact Information',
	'description' => '',
	'display_id' => 3,
	'sequence' => 3,
	'active' => 1,
	'fields' => array(
		'users.email'
	)
);
