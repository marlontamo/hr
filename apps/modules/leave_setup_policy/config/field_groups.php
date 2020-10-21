<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Policy Setup',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'time_form_balance_setup_policy.balance_setup_id',
		'time_form_balance_setup_policy.company_id',
		'time_form_balance_setup_policy.form_id',
		'time_form_balance_setup_policy.starting_credit',
		'time_form_balance_setup_policy.max_credit'
	)
);
