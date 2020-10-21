<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['performance_competency_level.competency_category_id'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Category',
	'description' => 'Category',
	'table' => 'performance_competency_level',
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
$config['fields'][1]['performance_competency_level.competency_values_id'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Value',
	'description' => 'Value',
	'table' => 'performance_competency_level',
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
$config['fields'][1]['performance_competency_level.competency_libraries_id'] = array(
	'f_id' => 5,
	'fg_id' => 1,
	'label' => 'Competency',
	'description' => 'Competency',
	'table' => 'performance_competency_level',
	'column' => 'competency_libraries_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'performance_competency_libraries',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'competency_libraries',
		'value' => 'competency_libraries_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['performance_competency_level.competency_level'] = array(
	'f_id' => 6,
	'fg_id' => 1,
	'label' => 'Level',
	'description' => 'Level',
	'table' => 'performance_competency_level',
	'column' => 'competency_level',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['performance_competency_level.description'] = array(
	'f_id' => 7,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => 'Description',
	'table' => 'performance_competency_level',
	'column' => 'description',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
