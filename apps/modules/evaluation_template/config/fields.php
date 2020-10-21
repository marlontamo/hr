<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['training_evaluation_template.description'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => '',
	'table' => 'training_evaluation_template',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['training_evaluation_template.applicable_for'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Applicable For',
	'description' => '',
	'table' => 'training_evaluation_template',
	'column' => 'applicable_for',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'training_applicable_for',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'applicable_for',
		'value' => 'applicable_for_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['training_evaluation_template.title'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Evaluation Title',
	'description' => '',
	'table' => 'training_evaluation_template',
	'column' => 'title',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
