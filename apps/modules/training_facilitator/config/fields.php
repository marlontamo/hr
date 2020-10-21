<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][2]['training_facilitator.course_id'] = array(
	'f_id' => 8,
	'fg_id' => 2,
	'label' => 'Course',
	'description' => '',
	'table' => 'training_facilitator',
	'column' => 'course_id',
	'uitype_id' => 10,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'training_course',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'course',
		'value' => 'course_id',
		'textual_value_column' => ''
	)
);
$config['fields'][2]['training_facilitator.is_internal'] = array(
	'f_id' => 7,
	'fg_id' => 2,
	'label' => 'Is Internal?',
	'description' => '',
	'table' => 'training_facilitator',
	'column' => 'is_internal',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['training_facilitator.provider_id'] = array(
	'f_id' => 6,
	'fg_id' => 2,
	'label' => 'Provider',
	'description' => '',
	'table' => 'training_facilitator',
	'column' => 'provider_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'training_provider',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'provider',
		'value' => 'provider_id',
		'textual_value_column' => ''
	)
);
$config['fields'][2]['training_facilitator.facilitator'] = array(
	'f_id' => 5,
	'fg_id' => 2,
	'label' => 'Facilitator',
	'description' => '',
	'table' => 'training_facilitator',
	'column' => 'facilitator',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
