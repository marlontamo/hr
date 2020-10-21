<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][2]['training_cost.description'] = array(
	'f_id' => 6,
	'fg_id' => 2,
	'label' => 'Description',
	'description' => '',
	'table' => 'training_cost',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['training_cost.cost'] = array(
	'f_id' => 5,
	'fg_id' => 2,
	'label' => 'Cost',
	'description' => '',
	'table' => 'training_cost',
	'column' => 'cost',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
