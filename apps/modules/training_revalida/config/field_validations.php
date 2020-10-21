<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['training_revalida_master.revalida_type'][] = array(
	'field'   => 'training_revalida_master[revalida_type]',
	'label'   => 'Evaluation Type',
	'rules'   => 'required'
);
