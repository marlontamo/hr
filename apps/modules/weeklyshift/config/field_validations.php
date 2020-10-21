<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['time_shift_weekly.calendar'][] = array(
	'field'   => 'time_shift_weekly[calendar]',
	'label'   => 'Shift Name',
	'rules'   => 'V'
);
