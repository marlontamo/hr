<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Leave Balance',
	'description' => 'Leave Balance',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'time_form_balance.year',
		'time_form_balance.user_id',
		'time_form_balance.form_id',
		'time_form_balance.previous',
		'time_form_balance.current'
	)
);
