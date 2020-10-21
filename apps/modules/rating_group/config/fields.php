<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['performance_setup_rating_group.status_id'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Is Active',
	'description' => 'Is Active',
	'table' => 'performance_setup_rating_group',
	'column' => 'status_id',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['performance_setup_rating_group.description'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => 'Description',
	'table' => 'performance_setup_rating_group',
	'column' => 'description',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['performance_setup_rating_group.rating_group'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Rating Group',
	'description' => 'Rating Group',
	'table' => 'performance_setup_rating_group',
	'column' => 'rating_group',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
