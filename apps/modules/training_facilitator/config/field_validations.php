<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['training_facilitator.facilitator'][] = array(
	'field'   => 'training_facilitator[facilitator]',
	'label'   => 'Facilitator',
	'rules'   => 'required'
);
