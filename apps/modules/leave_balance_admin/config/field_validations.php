<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['time_form_balance.period_extension'][] = array(
	'field'   => 'time_form_balance[period_extension]',
	'label'   => 'Period Extension',
	'rules'   => 'v'
);
$config['field_validations']['time_form_balance.period_to'][] = array(
	'field'   => 'time_form_balance[period_to]',
	'label'   => 'Period To',
	'rules'   => 'required'
);
$config['field_validations']['time_form_balance.period_from'][] = array(
	'field'   => 'time_form_balance[period_from]',
	'label'   => 'Period From',
	'rules'   => 'required'
);
$config['field_validations']['time_form_balance.current'][] = array(
	'field'   => 'time_form_balance[current]',
	'label'   => 'Current Credit',
	'rules'   => 'V'
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
