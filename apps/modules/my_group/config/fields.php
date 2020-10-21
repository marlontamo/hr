<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['groups.group_name'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Group Name',
	'description' => 'Group Name',
	'table' => 'groups',
	'column' => 'group_name',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['groups.description'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => 'Description',
	'table' => 'groups',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);