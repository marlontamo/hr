<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Rating Group',
	'description' => 'Rating Group',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'performance_setup_rating_group.rating_group',
		'performance_setup_rating_group.description',
		'performance_setup_rating_group.status_id'
	)
);
