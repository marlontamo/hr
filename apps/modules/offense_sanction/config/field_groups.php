<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Offense Sanction',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'partners_offense_sanction.sanction_category_id',
		'partners_offense_sanction.offense_level_id',
		'partners_offense_sanction.sanction'
	)
);
