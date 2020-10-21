<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['performance_appraisal_contributor.contributor'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Crowdsource',
	'description' => '',
	'table' => 'performance_appraisal_contributor',
	'column' => 'contributor',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'users',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'full_name',
		'value' => 'user_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['performance_appraisal_contributor.template_section_id'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Template Section',
	'description' => '',
	'table' => 'performance_appraisal_contributor',
	'column' => 'template_section_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'performance_template_section',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'template_section',
		'value' => 'template_section_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['performance_appraisal_contributor.user_id'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Partner',
	'description' => '',
	'table' => 'performance_appraisal_contributor',
	'column' => 'user_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'users',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'full_name',
		'value' => 'user_id',
		'textual_value_column' => ''
	)
);
