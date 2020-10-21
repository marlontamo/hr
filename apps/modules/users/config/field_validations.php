<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_profile.company_id'][] = array(
	'field'   => 'users_profile[company_id]',
	'label'   => 'Company',
	'rules'   => ''
);
$config['field_validations']['users.login'][] = array(
	'field'   => 'users[login]',
	'label'   => 'User Login',
	'rules'   => 'required'
);
$config['field_validations']['users.role_id'][] = array(
	'field'   => 'users[role_id]',
	'label'   => 'Role',
	'rules'   => 'required'
);
$config['field_validations']['users_profile.firstname'][] = array(
	'field'   => 'users_profile[firstname]',
	'label'   => 'Firstname',
	'rules'   => 'required'
);
$config['field_validations']['users_profile.lastname'][] = array(
	'field'   => 'users_profile[lastname]',
	'label'   => 'Lastname',
	'rules'   => 'required'
);
$config['field_validations']['users.email'][] = array(
	'field'   => 'users[email]',
	'label'   => 'Email',
	'rules'   => 'required|valid_email'
);
$config['field_validations']['users.hash'][] = array(
	'field'   => 'users[hash]',
	'label'   => 'Password',
	'rules'   => 'required'
);
$config['field_validations']['users.hash'][] = array(
	'field'   => 'users[hash-confirm]',
	'label'   => 'Confirm Password',
	'rules'   => 'required|matches[users[hash]]'
);