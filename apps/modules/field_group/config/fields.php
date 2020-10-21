<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields']['fieldgroups.status'] = array(
	'f_id' => 5,
	'fg_id' => 1,
	'label' => 'Status',
	'description' => 'Status',
	'table' => 'fieldgroups',
	'column' => 'status',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields']['fieldgroups.sequence'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Sequence',
	'description' => 'Sequence',
	'table' => 'fieldgroups',
	'column' => 'sequence',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'required|integer',
	'active' => '1',
	'encrypt' => 0
);
$config['fields']['fieldgroups.display_id'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Display',
	'description' => 'Display',
	'table' => 'fieldgroups',
	'column' => 'display_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => 1,
		'table' => 'diplays',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'display',
		'value' => 'display_id',
		'textual_value_column' => ''
	)
);
$config['fields']['fieldgroups.description'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => 'Description',
	'table' => 'fieldgroups',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields']['fieldgroups.label'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Label',
	'description' => 'Label',
	'table' => 'fieldgroups',
	'column' => 'label',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
