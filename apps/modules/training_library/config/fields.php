<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['training_library.published_date'] = array(
	'f_id' => 12,
	'fg_id' => 1,
	'label' => 'Published Date',
	'description' => '',
	'table' => 'training_library',
	'column' => 'published_date',
	'uitype_id' => 6,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['training_library.module'] = array(
	'f_id' => 11,
	'fg_id' => 1,
	'label' => 'Training Module',
	'description' => '',
	'table' => 'training_library',
	'column' => 'module',
	'uitype_id' => 8,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['training_library.description'] = array(
	'f_id' => 10,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => '',
	'table' => 'training_library',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['training_library.author'] = array(
	'f_id' => 9,
	'fg_id' => 1,
	'label' => 'Author',
	'description' => '',
	'table' => 'training_library',
	'column' => 'author',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['training_library.library'] = array(
	'f_id' => 7,
	'fg_id' => 1,
	'label' => 'Training Course',
	'description' => '',
	'table' => 'training_library',
	'column' => 'library',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
