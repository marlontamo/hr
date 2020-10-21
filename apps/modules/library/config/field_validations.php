<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['performance_setup_library.library'][] = array(
	'field'   => 'performance_setup_library[library]',
	'label'   => 'Library',
	'rules'   => 'required'
);
