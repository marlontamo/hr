<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Rating Score',
	'description' => 'Rating Score',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'performance_setup_rating_score.rating_group_id',
		'performance_setup_rating_score.rating_score',
		'performance_setup_rating_score.description'
	)
);
