<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Basic Information',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'profiles.profile',
		'profiles.description'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Data Access',
	'description' => '',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(	)
);
$config['fieldgroups'][3] = array(
	'fg_id' => 3,
	'label' => 'Module Permission',
	'description' => '',
	'display_id' => 3,
	'sequence' => 3,
	'active' => 1,
	'fields' => array(	)
);
