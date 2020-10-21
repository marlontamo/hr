<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][2]['scheduler.description'] = array(
	'f_id' => 3,
	'fg_id' => 2,
	'label' => 'Description',
	'description' => '',
	'table' => 'scheduler',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['scheduler.sp_function'] = array(
	'f_id' => 2,
	'fg_id' => 2,
	'label' => 'SP Function',
	'description' => '',
	'table' => 'scheduler',
	'column' => 'sp_function',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['scheduler.arguments'] = array(
	'f_id' => 2,
	'fg_id' => 2,
	'label' => 'Arguments',
	'description' => '',
	'table' => 'scheduler',
	'column' => 'arguments',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['scheduler.title'] = array(
	'f_id' => 1,
	'fg_id' => 2,
	'label' => 'Title',
	'description' => '',
	'table' => 'scheduler',
	'column' => 'title',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
