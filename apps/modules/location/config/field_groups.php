<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Location Information',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'users_location.location',
		'users_location.location_code',
		'users_location.min_wage_amt',
		'users_location.ecola_amt',
		'users_location.ecola_amt_month',
		'users_location.status_id'
	)
);
