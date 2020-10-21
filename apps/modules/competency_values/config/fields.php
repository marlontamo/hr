<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['performance_competency_values.competency_category_id'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Category',
	'description' => 'Category',
	'table' => 'performance_competency_values',
	'column' => 'competency_category_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'performance_competency_category',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'competency_category',
		'value' => 'competency_category_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['performance_competency_values.competency_values'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Competency Value',
	'description' => 'Competency Value',
	'table' => 'performance_competency_values',
	'column' => 'competency_values',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['performance_competency_values.description'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => 'Description',
	'table' => 'performance_competency_values',
	'column' => 'description',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
