<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['report_query.report_title'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Report Title',
	'description' => '',
	'table' => 'report_query',
	'column' => 'report_title',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['report_query.report_query'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Report Query',
	'description' => '',
	'table' => 'report_query',
	'column' => 'report_query',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
