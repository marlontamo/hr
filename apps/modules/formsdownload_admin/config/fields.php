<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['resources_downloadable.attachments'] = array(
	'f_id' => 5,
	'fg_id' => 1,
	'label' => 'Attachments',
	'description' => '',
	'table' => 'resources_downloadable',
	'column' => 'attachments',
	'uitype_id' => 8,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['resources_downloadable.description'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => '',
	'table' => 'resources_downloadable',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['resources_downloadable.category'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Category',
	'description' => '',
	'table' => 'resources_downloadable',
	'column' => 'category',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'resources_category',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'category',
		'value' => 'category',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['resources_downloadable.title'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Title',
	'description' => '',
	'table' => 'resources_downloadable',
	'column' => 'title',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
