<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['performance_setup_library.status_id'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Is Active',
	'description' => 'Is Active',
	'table' => 'performance_setup_library',
	'column' => 'status_id',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['performance_setup_library.description'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => 'Description',
	'table' => 'performance_setup_library',
	'column' => 'description',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['performance_setup_library.library'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Library',
	'description' => 'Library',
	'table' => 'performance_setup_library',
	'column' => 'library',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
