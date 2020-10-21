<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Basic',
	'description' => 'Basic Information',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'users_profile.lastname',
		'users_profile.firstname',
		'users_profile.middlename',
		'users_profile.middleinitial',
		'users_profile.maidenname',
		'users_profile.nickname'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Company',
	'description' => 'Company Information',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(
		'users_profile.company',
		'users_profile.location_id',
		'users_profile.position_id',
		'users_profile.role_id',
		'partners.id_number',
		'partners.biometric',
		'partners.shift_id'
	)
);
$config['fieldgroups'][3] = array(
	'fg_id' => 3,
	'label' => 'Employment',
	'description' => 'Employment',
	'display_id' => 3,
	'sequence' => 3,
	'active' => 1,
	'fields' => array(	)
);
