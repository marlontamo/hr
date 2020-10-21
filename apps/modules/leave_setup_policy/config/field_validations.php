<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['time_form_balance_setup_policy.starting_credit'][] = array(
	'field'   => 'time_form_balance_setup_policy[starting_credit]',
	'label'   => 'Starting',
	'rules'   => 'required'
);
$config['field_validations']['time_form_balance_setup_policy.form_id'][] = array(
	'field'   => 'time_form_balance_setup_policy[form_id]',
	'label'   => 'Leave Type',
	'rules'   => 'required'
);
$config['field_validations']['time_form_balance_setup_policy.balance_setup_id'][] = array(
	'field'   => 'time_form_balance_setup_policy[balance_setup_id]',
	'label'   => 'Balance Setup',
	'rules'   => 'required'
);
