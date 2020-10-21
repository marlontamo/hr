<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['report_query.report_title'][] = array(
	'field'   => 'report_query[report_title]',
	'label'   => 'Report Title',
	'rules'   => 'required'
);
$config['field_validations']['report_query.report_query'][] = array(
	'field'   => 'report_query[report_query]',
	'label'   => 'Report Query',
	'rules'   => 'required'
);
