<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['taxcode.taxcode'][] = array(
	'field'   => 'taxcode[taxcode]',
	'label'   => 'Type',
	'rules'   => 'required'
);
$config['field_validations']['taxcode.amount'][] = array(
	'field'   => 'taxcode[amount]',
	'label'   => 'Excemption',
	'rules'   => 'required|numeric'
);
