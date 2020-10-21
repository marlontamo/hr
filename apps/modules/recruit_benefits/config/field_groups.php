<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Benefit Packages',
	'description' => 'Benefit Packages',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'recruitment_benefit_package.benefit',
		'recruitment_benefit_package.rank_id',
		'recruitment_benefit_package.description',
		'recruitment_benefit_package.status_id'
	)
);
