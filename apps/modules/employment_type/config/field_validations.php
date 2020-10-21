<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['partners_employment_type.employment_type'][] = array(
	'field'   => 'partners_employment_type[employment_type]',
	'label'   => 'Employment Type',
	'rules'   => 'required'
);
$config['field_validations']['partners_employment_type.active'][] = array(
	'field'   => 'partners_employment_type[active]',
	'label'   => 'Active',
	'rules'   => 'V'
);

