<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['report_results.filepath'][] = array(
	'field'   => 'report_results[filepath]',
	'label'   => 'Path',
	'rules'   => 'required'
);
$config['field_validations']['report_results.path'][] = array(
	'field'   => 'report_results[path]',
	'label'   => 'Path',
	'rules'   => 'required'
);
$config['field_validations']['report_results.file_type'][] = array(
	'field'   => 'report_results[file_type]',
	'label'   => 'File Type',
	'rules'   => 'required'
);
$config['field_validations']['report_results.report_id'][] = array(
	'field'   => 'report_results[report_id]',
	'label'   => 'Report',
	'rules'   => 'required'
);
