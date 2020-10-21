<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['training_bond.rls_days'][] = array(
	'field'   => 'training_bond[rls_days]',
	'label'   => 'RLS in days',
	'rules'   => 'required'
);
$config['field_validations']['training_bond.rls_months'][] = array(
	'field'   => 'training_bond[rls_months]',
	'label'   => 'RLS in months',
	'rules'   => 'required'
);
$config['field_validations']['training_bond.cost_to'][] = array(
	'field'   => 'training_bond[cost_to]',
	'label'   => 'Cost To',
	'rules'   => 'Required'
);
$config['field_validations']['training_bond.cost_from'][] = array(
	'field'   => 'training_bond[cost_from]',
	'label'   => 'Cost From',
	'rules'   => 'required'
);
