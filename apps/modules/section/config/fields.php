<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['users_section.status_id'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Active',
	'description' => '',
	'table' => 'users_section',
	'column' => 'status_id',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_section.section'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Section',
	'description' => '',
	'table' => 'users_section',
	'column' => 'section',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_section.section_code'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Section Code',
	'description' => '',
	'table' => 'users_section',
	'column' => 'section_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
