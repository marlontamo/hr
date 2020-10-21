<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['time_shift.shift'][] = array(
	'field'   => 'time_shift[shift]',
	'label'   => 'Shift',
	'rules'   => 'required'
);
$config['field_validations']['time_shift.time_start'][] = array(
	'field'   => 'time_shift[time_start]',
	'label'   => 'From',
	'rules'   => 'required'
);
$config['field_validations']['time_shift.time_end'][] = array(
	'field'   => 'time_shift[time_end]',
	'label'   => 'To',
	'rules'   => 'required'
);
$config['field_validations']['time_shift.color'][] = array(
	'field'   => 'time_shift[color]',
	'label'   => 'Color',
	'rules'   => 'V'
);
