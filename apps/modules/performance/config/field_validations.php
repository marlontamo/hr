<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['performance_setup_performance.performance'][] = array(
	'field'   => 'performance_setup_performance[performance]',
	'label'   => 'Performance',
	'rules'   => 'required'
);
