<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['performance_competency_libraries.competency_category_id'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Category',
	'description' => 'Category',
	'table' => 'performance_competency_libraries',
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
$config['fields'][1]['performance_competency_libraries.competency_values_id'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Value',
	'description' => 'Value',
	'table' => 'performance_competency_libraries',
	'column' => 'competency_values_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'performance_competency_values',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'competency_values',
		'value' => 'competency_values_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['performance_competency_libraries.competency_libraries'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Library',
	'description' => 'Library',
	'table' => 'performance_competency_libraries',
	'column' => 'competency_libraries',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['performance_competency_libraries.description'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => 'Description',
	'table' => 'performance_competency_libraries',
	'column' => 'description',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
