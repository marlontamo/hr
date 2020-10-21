<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['report_results.filepath'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Path',
	'description' => '',
	'table' => 'report_results',
	'column' => 'filepath',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['report_results.file_type'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'File Type',
	'description' => '',
	'table' => 'report_results',
	'column' => 'file_type',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['report_results.report_id'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Report',
	'description' => '',
	'table' => 'report_results',
	'column' => 'report_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'report_generator',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'report_name',
		'value' => 'report_id',
		'textual_value_column' => ''
	)
);
