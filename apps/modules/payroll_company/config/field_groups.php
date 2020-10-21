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
		'users_company.company_code',
		'users_company.company',
		'users_company.bank_id',
		'users_company.sss',
		'users_company.hdmf',
		'users_company.phic',
		'users_company.tin'
	)
);
