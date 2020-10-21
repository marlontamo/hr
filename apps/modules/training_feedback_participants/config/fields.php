<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][4]['training_feedback.average_score'] = array(
	'f_id' => 3,
	'fg_id' => 4,
	'label' => 'Average Score',
	'description' => '',
	'table' => 'training_feedback',
	'column' => 'average_score',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][4]['training_feedback.total_score'] = array(
	'f_id' => 2,
	'fg_id' => 4,
	'label' => 'Total Score',
	'description' => '',
	'table' => 'training_feedback',
	'column' => 'total_score',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
