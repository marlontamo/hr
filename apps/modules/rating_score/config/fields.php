<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['performance_setup_rating_score.description'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => 'Description',
	'table' => 'performance_setup_rating_score',
	'column' => 'description',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['performance_setup_rating_score.rating_score'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Rating Score',
	'description' => 'Rating Score',
	'table' => 'performance_setup_rating_score',
	'column' => 'rating_score',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['performance_setup_rating_score.rating_group_id'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Rating Group',
	'description' => 'Rating Group',
	'table' => 'performance_setup_rating_score',
	'column' => 'rating_group_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'performance_setup_rating_group',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'rating_group',
		'value' => 'rating_group_id',
		'textual_value_column' => ''
	)
);
