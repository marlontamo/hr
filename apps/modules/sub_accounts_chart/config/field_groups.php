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
		'payroll_account_sub.account_sub_code',
		'payroll_account_sub.account_sub',
		'payroll_account_sub.account_id',
		'payroll_account_sub.category_id'
	)
);
