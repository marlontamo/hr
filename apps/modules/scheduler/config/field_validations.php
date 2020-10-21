<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['scheduler.description'][] = array(
	'field'   => 'scheduler[description]',
	'label'   => 'Description',
	'rules'   => 'V'
);
$config['field_validations']['scheduler.sp_function'][] = array(
	'field'   => 'scheduler[sp_function]',
	'label'   => 'SP Function',
	'rules'   => 'V'
);
$config['field_validations']['scheduler.arguments'][] = array(
	'field'   => 'scheduler[arguments]',
	'label'   => 'Arguments',
	'rules'   => 'V'
);
$config['field_validations']['scheduler.title'][] = array(
	'field'   => 'scheduler[title]',
	'label'   => 'Title',
	'rules'   => 'V'
);
