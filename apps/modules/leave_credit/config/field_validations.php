<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['time_form_balance.current'][] = array(
	'field'   => 'time_form_balance[current]',
	'label'   => 'Current Credit',
	'rules'   => 'required'
);
$config['field_validations']['time_form_balance.previous'][] = array(
	'field'   => 'time_form_balance[previous]',
	'label'   => 'Previous Credit',
	'rules'   => 'required'
);
$config['field_validations']['time_form_balance.form_id'][] = array(
	'field'   => 'time_form_balance[form_id]',
	'label'   => 'Leave Type',
	'rules'   => 'required'
);
$config['field_validations']['time_form_balance.user_id'][] = array(
	'field'   => 'time_form_balance[user_id]',
	'label'   => 'Partner',
	'rules'   => 'required'
);
$config['field_validations']['time_form_balance.year'][] = array(
	'field'   => 'time_form_balance[year]',
	'label'   => 'Year',
	'rules'   => 'required'
);
