<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['training_bond.rls_days'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'RLS in days',
	'description' => 'RLS in days',
	'table' => 'training_bond',
	'column' => 'rls_days',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['training_bond.rls_months'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'RLS in months',
	'description' => 'RLS in months',
	'table' => 'training_bond',
	'column' => 'rls_months',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['training_bond.cost_to'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Cost To',
	'description' => 'Cost To',
	'table' => 'training_bond',
	'column' => 'cost_to',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['training_bond.cost_from'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Cost From',
	'description' => 'Cost From',
	'table' => 'training_bond',
	'column' => 'cost_from',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 0
);
