<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['training_cost.cost'][] = array(
	'field'   => 'training_cost[cost]',
	'label'   => 'Cost',
	'rules'   => 'required'
);
