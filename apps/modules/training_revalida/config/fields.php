<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['training_revalida_master.course_id'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Training Course',
	'description' => '',
	'table' => 'training_revalida_master',
	'column' => 'course_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'training_course',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'Course',
		'value' => 'course_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['training_revalida_master.revalida_type'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Evaluation Type',
	'description' => 'Evaluation Type',
	'table' => 'training_revalida_master',
	'column' => 'revalida_type',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
